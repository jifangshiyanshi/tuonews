<?php
namespace image\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\session\Session;
use herosphp\utils\FileUpload;

/**
 * 编辑器图片处理Action
 * @author          yangjian<yangjian102621@163.com>
 */
class UeditorAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();
        //设置错误等级
        error_reporting(E_ERROR);
    }

    /**
     * 编辑器图片处理
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        //获取配置文件上传配置信息
        $configs = file_get_contents(__DIR__.'/config.json');
        //去掉注释
        $configs = json_decode(preg_replace('/\/\*[\s\S]+?\*\//', "", $configs), true);

        $action = $request->getParameter('action', 'trim');
        switch ( $action ) {
            //获取配置信息
            case 'config':
                $result =  json_encode($configs);
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传文件 */
            case 'uploadfile':
                $configs['action'] = $action;
                $result = $this->ueUpload($configs);
                break;

            /* 列出图片 */
            case 'listimage':
                $result = $this->getImageList($request, $configs);
                break;

            /* 列出文件 */
            case 'listfile':
                $result = $this->getFileList($request, $configs);
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = $this->grabRemoteImage($configs);
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        $callback = $request->getParameter('callback', 'trim');
        if ( $callback ) {
            if ( preg_match('/^[\w_]+$/', $callback) ) {
                echo htmlspecialchars($callback) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }

        die();
    }

    /**
     * 编辑器的上传文件，图片，涂鸦
     * @param $configs
     * @return mixed
     */
    public function ueUpload($configs) {

        //文件上传配置
        $uploadConfigs = array();
        //上传文件的目录
        $dir = 'image';
        //上传表单name
        $fieldName = $configs['imageFieldName'];
        $base64 = false;
        if ( $configs['action'] == 'uploadimage' ) {

            $uploadConfigs['allow_ext'] = $configs['imageAllowFiles'];
            $uploadConfigs['max_size'] = $configs['imageMaxSize'];
            $uploadConfigs['max_width'] = $configs['imageMaxWidth'];
            $dir =  $configs['imagePathFormat'];

        } elseif ( $configs['action'] == 'uploadscrawl' ) {

            //$uploadConfigs['allow_ext'] = $configs['scrawlAllowFiles'];
            $uploadConfigs['max_size'] = $configs['scrawlMaxSize'];
            $fieldName = $configs['scrawlFieldName'];
            $dir =  $configs['scrawlPathFormat'];
            $base64 = true;

        } elseif ( $configs['action'] == 'uploadfile' ) {

            $uploadConfigs['allow_ext'] = $configs['fileAllowFiles'];
            $uploadConfigs['max_width'] = $configs['fileMaxWidth'];
            $uploadConfigs['max_size'] = $configs['fileMaxSize'];
            $dir =  $configs['filePathFormat'];
            $fieldName = $configs['fileFieldName'];

        }

        $_dir = $dir.'/'.date('Y').'/'.date('m').'/'.date('d');
        $uploadDir = getConfig('upload_dir').$_dir;
        $uploadConfigs['upload_dir'] = $uploadDir;
        //将允许文件类型处理成FileUpload类所接受的形式
        foreach ( $uploadConfigs['allow_ext'] as $key => $values ) {
            $uploadConfigs['allow_ext'][$key] = ltrim($values, '.');
        }
        $uploadConfigs['allow_ext'] = implode('|', $uploadConfigs['allow_ext']);
        $uploadConfigs['max_size'] = 2048000;
        $fileUpload = new FileUpload($uploadConfigs);
        $fileInfo = $fileUpload->upload($fieldName, $base64);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        $result = array();
        //上传失败
        if ( $fileInfo == false ) {

            $result['state']  = $fileUpload->getUploadMessage();

            //上传成功
        } else {

            $url = '/res/upload/'.$_dir.'/'.$fileInfo['file_name'];
            $result['state'] = 'SUCCESS';
            $result['url'] = $url;
            $result['title'] = $fileInfo['raw_name'];
            $result['original'] = $fileInfo['local_name'];
            $result['original'] = $fileInfo['local_name'];
            $result['type'] = '.'.$fileInfo['file_ext'];
            $result['size'] = $fileInfo['file_size'];

            //插入数据
            $service = Beans::get('image.image.service');
            $mediaService = Beans::get('media.media.service');
            $loginMedia = $mediaService->getLoginMedia();
            $type = $dir;
            //涂鸦也是图片
            if ( $type == 'scraw' ) {
                $type = 'image';
            }
            $userid = intval($this->loginUser['id']);
            $mediaId = intval($loginMedia['id']);
            //如果是通过后台修改用户的数据，则将注前台册用户的id
            if ( !$userid ) {
                Session::start();
                $userid = intval($_SESSION['front_userid']);
            }
            if ( !$mediaId ) {
                Session::start();
                $mediaId = intval($_SESSION['front_mediaId']);
            }
            $data = array(
                'userid' => $userid,
                'media_id' => $mediaId,
                'url' => $url,
                'filename' => $fileInfo['local_name'],
                'type' => $type,
                'filesize' => formatFileSize($fileInfo['file_size']),
                'width' => $fileInfo['image_width'],
                'height' => $fileInfo['image_height'],
                'add_time' => time(),
                'grabed' => 1,
            );

            //保存到数据库失败
            if ( !$service->add($data) ) {
                //删除图片
                @unlink($fileInfo['file_path']);
                $result['state'] = '保存数据失败！';

            }
        }

        /* 返回数据 */
        return json_encode($result);

    }

    /**
     * 获取图片列表
     * @param HttpRequest $request
     * @param array $configs
     * @return array
     */
    public function getImageList(HttpRequest $request, array $configs) {

        //参数处理
        $pagesize = $request->getParameter('size', 'intval');
        if ( $pagesize <= 0 ) {
            $pagesize = isset($configs['fileManagerListSize']) ? $configs['fileManagerListSize'] : 20;
        }
        $start = $request->getParameter('start', 'intval');
        if ( $start <= 0 ) {
            $page = 1;
        } else {
            $page = ceil($start/$pagesize)+1;
        }

        //获取数据
        $service = Beans::get('image.image.service');
        $userid = intval($this->loginUser['id']);
        //如果是通过后台修改用户的数据，则将注前台册用户的id
        if ( !$userid ) {
            Session::start();
            $userid = intval($_SESSION['front_userid']);
        }
        $conditions = "userid={$userid} AND type='image'";
        $items = $service->getItems($conditions, "url", "id desc", $page, $pagesize);
        $total = $service->count($conditions);

        if ( !$items ) {
            return json_encode(array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => $total
            ));
        }
        //填充缩略图
        foreach ( $items as $key => $value ) {
            $items[$key]['thumb'] = getImageThumb($value['url'], '113x113');
        }

        //返回数据
        return json_encode(array(
            "state" => "SUCCESS",
            "list" => $items,
            "start" => $start,
            "total" => $total
        ));

    }

    /**
     * 获取文件列表
     * @param $request
     * @param $configs
     * @return string
     */
    public function getFileList($request, $configs) {

        //参数处理
        $pagesize = $request->getParameter('size', 'intval');
        if ( $pagesize <= 0 ) {
            $pagesize = isset($configs['fileManagerListSize']) ? $configs['fileManagerListSize'] : 20;
        }
        $start = $request->getParameter('start', 'intval');
        if ( $start <= 0 ) {
            $page = 1;
        } else {
            $page = ceil($start/$pagesize)+1;
        }

        //获取数据
        $service = Beans::get('image.image.service');
        $userid = intval($this->loginUser['id']);
        //如果是通过后台修改用户的数据，则将注前台册用户的id
        if ( !$userid ) {
            Session::start();
            $userid = intval($_SESSION['front_userid']);
        }
        $conditions = "userid={$userid} AND type='file'";
        $items = $service->getItems($conditions, "url", "id desc", $page, $pagesize);
        $total = $service->count($conditions);

        if ( !$items ) {
            return json_encode(array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => $total
            ));
        }

        //返回数据
        return json_encode(array(
            "state" => "SUCCESS",
            "list" => $items,
            "start" => $start,
            "total" => $total
        ));

    }

}
?>
