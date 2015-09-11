<?php

namespace tasks;

use herosphp\utils\FileUtils;
use tasks\interfaces\ITask;
use herosphp\core\Loader;

Loader::import('tasks.interfaces.ITask', IMPORT_CLIENT);
/**
 * 处理图片文件夹
 * 1. 将媒体logo, 文章裁剪的缩略图替换原图
 * 2. 删除缩略图缓存
 * @author yangjian102621@163.com
 */
class ImageTask implements ITask {


    /**
     * 要操作的目录
     * @var string
     */
    private static $dir = null;

    /**
     * 日志文件
     * @var string
     */
    private static $logFile = './logs/image.log';

    /**
     * 总共删除缩略图缓存的文件个数
     * @var int
     */
    private static $delNum = 0;

    /**
     * 替换文件个数
     * @var int
     */
    private static $repNum = 0;

    public function run() {
        self::$dir = RES_PATH.'upload';
        self::walkDir(self::$dir);
        tprintWarning("共成功替换".self::$repNum."个文件");
        tprintWarning("共成功删除".self::$delNum."个文件");

    }

    /**
     * 便利目录
     * @param $dir
     */
    private static function walkDir($dir) {

        $handle = opendir($dir);
        if ( $handle != false ) {
            while ( $file=readdir($handle) ) {
                if( $file != "." && $file != ".." ) {
                    $filename = $dir."/".$file;
                    if( !is_dir($filename) ) {
                        self::replaceImage($filename);
                    } else {
                        self::walkDir($filename);
                    }
                }
            }
            closedir($handle);
        }

    }

    /**
     * 1. 重命名裁剪的缩略图，覆盖缩略图的原图
     * 2. 删除其他缩略图缓存
     * @param $filename
     */
    private static function replaceImage($filename) {

        //1. 如果是裁剪图片，则将其覆盖原图
        if ( ($pos = strpos($filename, '__crop__')) !== false ) {

            $srcImage = substr($filename, 0, $pos-1);
            //重命名
            $message = "覆盖文件 {$filename} => {$srcImage}";
            if ( rename($filename, $srcImage) ) {
                tprintOk($message."成功！");
                self::$repNum++;
            } else {
                self::addLog($message."失败！");
                tprintError($message);
            }

        } else {

            $pattern = '/\.\d+x\d+\./';
            if ( preg_match($pattern, $filename) ) {
                $message = "删除文件 {$filename}";
                if ( unlink($filename) ) {
                    tprintOk($message."成功！");
                    self::$delNum++;
                } else {
                    tprintError($message."失败！");
                }
            }

        }

    }

    /**
     * 添加日志
     * @param $message
     */
    public static function addLog($message) {
        file_put_contents(self::$logFile, $message."\n");
    }

}
