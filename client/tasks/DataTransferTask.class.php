<?php
namespace tasks;

use herosphp\bean\Beans;
use herosphp\db\DBFactory;
use herosphp\utils\ArrayUtils;
use tasks\interfaces\ITask;
use herosphp\core\Loader;

// 定义当前访问的应用
define('APP_NAME', 'tuonews');

//定义应用根目录
define('APP_PATH', APP_ROOT."app/");

//定义Beans配置目录，如果为false则默认使用configs/beans,注意目录分割符号用.而不是用/
define('BEANS_PATH', 'beans.tuonews');

//定义数据模型配置目录，如果为false则默认使用configs/models,注意目录分割符号用.而不是用/
define('MODELS_PATH', 'configs.models.tuonews');

//定义数据库配置目录，如果为false则默认使用configs/db,注意目录分割符号用.而不是用/
define('DB_CFG_PATH', 'db.tuonews');

Loader::import('tasks.interfaces.ITask', IMPORT_CLIENT);
Loader::import('extend.word.WordSplit', IMPORT_CUSTOM);
/**
 * 转移老版本驼牛的数据
 * @author yangjian102621@163.com
 */
class DataTransferTask implements ITask {

    /**
     * 源数据库配置信息
     * @var array
     */
    private static $_DB_CONFIG = array(
        'src' => array(
            'db_type'      => 'mysql',
            'db_host'      => 'localhost',
            'db_user'      => 'root',
            'db_pass'      => '123456',
            'db_name'      => 'tuonews',
            'db_port'      => 3306,
            'flag'         => 'tuonews',    //唯一标志，每个数据配置都不能相同，用来缓存数据库连接
            'db_charset'   => 'utf8',
        ),

        'temp' => array(
            'db_type'      => 'mysql',
            'db_host'      => 'localhost',
            'db_user'      => 'root',
            'db_pass'      => '123456',
            'db_name'      => 'temp.tuonews.com',
            'db_port'      => 3306,
            'flag'         => 'temp.tuonews.com',    //唯一标志，每个数据配置都不能相同，用来缓存数据库连接
            'db_charset'   => 'utf8',
        ),
    );

    /**
     * 文章分类到文章频道的映射
     * @var array
     */
    private static $_CAT_TO_CHANEL = array(
        '1' => '19',
        '2' => '18',
        '3' => '11',
        '4' => '5',
        '21' => '18',
        '23' => '9',
    );

    /**
     * 源数据库连接资源
     * @var resource
     */
    private static $_SRC_DB = null;

    /**
     * 临时数据库配置
     * @var resource
     */
    private static $_TEMP_DB = null;

    /**
     * 日志文件
     * @var string
     */
    private static $logFile = '';

    /**
     * 初始化构造方法
     */
    public function __construct() {

        self::$_SRC_DB = DBFactory::createDB(DB_ACCESS, self::$_DB_CONFIG['src']);
        self::$_TEMP_DB = DBFactory::createDB(DB_ACCESS, self::$_DB_CONFIG['temp']);
        self::$logFile = APP_ROOT.'client/tasks/logs/data_transfer.log';

    }

    public function run() {

        //1. 更新临时表中的文章标签，将标签的ID转换成name
        //$this->updateTags();

        //2. 转移源驼牛文章到目标驼牛数据库
        //$this->transferArticle();

        //3. 恢复目标驼牛数据库之前的数据
        //$this->transferTempArticle();

        //更新文章摘要和关键字
        $this->updateKeywords();

    }

    /**
     * 转移文章主任务线程，转移老驼牛的文章
     */
    private function transferArticle() {

        //获取文章
        $query = 'SELECT id,catid,title,kwords,bcontent,hits,author,tags,add_time,update_time,share_times,thumb_pic,trash,ischeck '.
                 'FROM fiidee_article';
        $items = self::$_SRC_DB->getItems($query);

        //获取文章内容
        $ids = array();
        foreach ( $items as $__val ) {
            $ids[] = $__val['id'];
        }

        $articleData = self::$_SRC_DB->getItems('SELECT itemid,content FROM fiidee_articleData WHERE itemid IN ('.implode(',', $ids).')');
        $articleData = ArrayUtils::changeArrayKey($articleData, 'itemid');

        //转移文章
        $articleService = Beans::get('article.article.service');
        $articleTagsService = Beans::get('article.tags.service');
        $imageService = Beans::get('image.image.service');
        //userid,chanel_id,media_id,thumb,title,kwords,bcontent,author,tags,add_time,update_time,publish_time,share_times,hits,trash,ischeck
        foreach ( $items as $value ) {

            $data = array();
            $data['id'] = $value['id'];
            $data['userid'] = 0;
            $data['chanel_id'] = intval(self::$_CAT_TO_CHANEL[$value['catid']]);
            if ( $data['chanel_id'] <= 0 ) {
                $data['chanel_id'] = 5;
            }
            if ( mb_strlen($value['title'], 'UTF-8') < 4 ) {
                $message = "添加文章失败，源ID : {$value['id']}, 文章标题 ： ‘{$value['title']}’ 长度太短";
                tprintError($message);
                $this->addErrorLog($message);
                continue;
            }
            $data['media_id'] = 0;
            $data['title'] = $value['title'];
            $data['kwords'] = $value['kwords'];
            $data['bcontent'] = $value['bcontent'];
            $data['author'] = $value['author'];
            $data['add_time'] = $value['add_time'];
            $data['update_time'] = $value['update_time'];
            $data['publish_time'] = $value['update_time'];
            $data['share_times'] = $value['share_times'];
            $data['hits'] = $value['hits'];
            $data['trash'] = $value['trash'];
            $data['ischeck'] = $value['ischeck'];

            //转移缩略图
            $data['thumb'] = str_replace('/res/attachs/', '/res/upload/', $value['thumb_pic']);

            //转移内容
            $content = $articleData[$value['id']]['content'];
            //过滤掉正文汉字长度小于100的文章
            $__content = '';
            $__length = strlen($content);
            for ( $i = 0; $i < $__length; $i++ ) {
                if ( ord($content[$i]) > 127 ) {
                    $__content .= $content[$i];
                }
            }

            if ( mb_strlen($__content, 'UTF-8') < 100 ) {
                $message = "添加文章失败，源ID : {$value['id']}, 文章标题 ： ‘{$value['title']}’ 文章内容正文小于100";
                tprintError($message);
                $this->addErrorLog($message);
                continue;
            }

            $articleService->beginTransaction();
            $data['content'] = str_replace('/res/attachs/', '/res/upload/', $content);

            $this->getContentImage($value['id'], 0, $data['content']);

            //保存缩略图到图片空间
            $pathinfo = pathinfo($data['thumb']);
            $imgData = array(
                'userid' => 0,
                'media_id' => 0,
                'aid' => $value['id'],
                'url' => $data['thumb'],
                'type' => 'image',
                'filename' => $pathinfo['basename'],
                'add_time' => time(),
                'grabed' => 1,
            );
            $imageService->add($imgData);

            //如果标签为空则自动生成标签
            if ( trim($value['tags']) != '' ) {
                $tags = \WordSplit::split($value['title']);
            } else {
                $tags = explode(' ', $value['tags']);
            }
            //如果标签的数量超过5个，则删除多余的标签
            if ( count($tags) > 5 ) {
                $tags = array_slice($tags, 0, 5);
            }
            $tagIds = array();
            foreach ( $tags as $_value ) {

                if ( trim($_value) == '' ) {
                    continue;
                }

                $tagIds[] = $articleTagsService->add(array('name' => $_value));

            }


            //添加文章
            $data['tags'] = implode(',', $tagIds);
            //var_dump($data);die();
            $result = $articleService->add($data);
            if ( $result ) {
                //提交
                $articleService->commit();
                tprintOk("添加文章成功！ 源ID : {$value['id']}, 新ID ： {$result}");

            } else {
                //回滚
                $articleService->rollback();
                $message = "添加文章失败，源ID : {$value['id']}";
                tprintError($message);
                $this->addErrorLog($message);

            }
        }

    }

    /**
     * 更新简介和关键字
     */
    private function updateKeywords() {

        //获取文章
        $query = 'select id,kwords,bcontent FROM fiidee_article';
        $items = self::$_SRC_DB->getItems($query);

        $service = Beans::get('article.article.service');
        foreach ( $items as $value ) {
            $data = array(
                'kwords' => $value['kwords'],
                'bcontent' => $value['bcontent'],
            );
            if ( $service->update($data, $value['id']) ) {
                $data = null;
                tprintOk("更新文章成功！！ 文章ID ： {$value['id']}");
            } else {
                $message = "更新文章成功，文章ID : {$value['id']}";
                tprintError($message);
                $this->addErrorLog($message);
            }
        }

    }

    /**
     * 转移临时数据表中的文章, 这次转移不需要转移图片
     */
    private function transferTempArticle() {

        //获取文章
        $query = 'SELECT id,userid,chanel_id,media_id,thumb,title,kwords,bcontent,author,tags,add_time,update_time,publish_time,share_times,hits,trash,ischeck '.
            'FROM fiidee_article';
        $items = self::$_TEMP_DB->getItems($query);

        //获取文章内容
        $ids = array();
        foreach ( $items as $__val ) {
            $ids[] = $__val['id'];
        }

        $articleData = self::$_TEMP_DB->getItems('SELECT aid,content FROM fiidee_article_data_0 WHERE aid IN ('.implode(',', $ids).')');
        $articleData = ArrayUtils::changeArrayKey($articleData, 'aid');

        //转移文章
        $articleService = Beans::get('article.article.service');
        $articleTagsService = Beans::get('article.tags.service');
        foreach ( $items as $value ) {
            //开启事务
            $articleService->beginTransaction();

            $data = array();
            $data['userid'] = $value['userid'];
            $data['chanel_id'] = $value['chanel_id'];
            $data['media_id'] = $value['media_id'];
            $data['thumb'] = $value['thumb'];
            $data['title'] = $value['title'];
            $data['kwords'] = $value['kwords'];
            $data['bcontent'] = $value['bcontent'];
            $data['author'] = $value['author'];
            $data['add_time'] = $value['add_time'];
            $data['update_time'] = $value['update_time'];
            $data['publish_time'] = $value['publish_time'];
            $data['share_times'] = $value['share_times'];
            $data['hits'] = $value['hits'];
            $data['trash'] = $value['trash'];
            $data['ischeck'] = $value['ischeck'];

            //转移内容
            $data['content'] = $articleData[$value['id']]['content'];

            //保存标签
            $tags = explode(' ', $value['tags']);
            $tagIds = array();
            foreach ( $tags as $_value ) {
                $tagIds[] = $articleTagsService->add(array('name' => $_value));
            }

            //添加文章
            $data['tags'] = implode(',', $tagIds);
            $result = $articleService->add($data);
            if ( $result ) {
                //提交
                $articleService->commit();
                tprintOk("添加文章成功！ 新ID ： {$result}");
            } else {

                //回滚
                $articleService->rollback();
                $message = "添加文章失败，源ID : {$value['id']}";
                tprintError($message);
                $this->addErrorLog($message);
            }
        }

    }

    /**
     * 更新临时表的文章tags
     */
    private function updateTags() {

        $items = self::$_TEMP_DB->getItems("select id,tags from fiidee_article");
        foreach ( $items as $value ) {
            if ( trim($value['tags']) == '' ) {
                continue;
            }
            $tags = self::$_TEMP_DB->getItems("select name from fiidee_article_tags WHERE id IN ({$value['tags']})");
            if ( $tags ) {
                $__tags = array();
                foreach ( $tags as $__value ) {
                    $__tags[] = $__value['name'];
                }

                $__tags = implode(' ', $__tags);
                $__data = array('tags' => $__tags);
                $result = self::$_TEMP_DB->update('fiidee_article', $__data, "id =".$value['id']);
                if ( $result ) {
                    tprintOk("更新标签成功， ID : {$value['id']}, 标签 : {$__tags}");
                } else {
                    $message = "更新标签失败， ID : {$value['id']}";
                    tprintError($message);
                    $this->addErrorLog($message);
                }
            }
        }

    }

    /**
     * 将文章中的图片存储到图片空间数据库
     * @param $aid
     * @param $userid
     * @param $content
     */
    private function getContentImage($aid, $userid, $content) {

        //提取图片链接
        $imagePattern = '/<img.*?src="(.*?)".*?\/>/is';
        $result = preg_match_all($imagePattern, $content, $matches);
        if ( $result ) {
            $imageService = Beans::get('image.image.service');
            //获取用户ID
            foreach ( $matches[1] as $values ) {
                $pathinfo = pathinfo($values);
                //添加图片到图片空间
                $data = array(
                    'userid' => $userid,
                    'media_id' => 0,
                    'aid' => $aid,
                    'url' => $values,
                    'type' => 'image',
                    'filename' => $pathinfo['basename'],
                    'add_time' => time(),
                    'grabed' => 1,
                );
                $imageService->add($data);
            }
        }
    }

    /**
     * 添加错误日志
     * @param $message
     */
    private function addErrorLog($message) {

        file_put_contents(self::$logFile, $message."\n", FILE_APPEND);

    }

}
