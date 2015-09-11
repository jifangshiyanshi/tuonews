<?php

namespace tasks;

use herosphp\utils\FileUtils;
use tasks\interfaces\ITask;
use herosphp\core\Loader;

Loader::import('tasks.interfaces.ITask', IMPORT_CLIENT);
/**
 * 将文件中的CRLF换行替换成LF换行
 * @author yangjian102621@163.com
 */
class LFTask implements ITask {


    /**
     * 要操作的目录
     * @var string
     */
    private static $dir = '/php/tuonews.com';

    /**
     * 需要替换的文件的后缀
     * @var array
     */
    private static $extensions = array('css', 'php', 'js', 'less', 'txt', 'md', 'html', 'htm');

    /**
     * 日志文件
     * @var string
     */
    private static $logFile = './logs/lf.log';

    /**
     * 总共替换的文件个数
     * @var int
     */
    private static $fileNum = 0;

    public function run() {

        self::walkDir(self::$dir);
        tprintWarning("共成功替换".self::$fileNum."个文件");

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
                        self::replaceCR($filename);
                    } else {
                        self::walkDir($filename);
                    }
                }
            }
            closedir($handle);
        }

    }

    /**
     * 替换 CR换行符号
     * @param $filename
     */
    private static function replaceCR($filename) {

        $ext = FileUtils::getFileExt($filename);
        if ( !in_array($ext, self::$extensions) ) {
            return;
        }
        $content = file_get_contents($filename);
        $content = str_replace("\r", "\n", $content);
        if ( file_put_contents($filename, $content) ) {
            tprintOk("成功替换文件{$filename}");
            self::$fileNum++;
        } else {
            tprintError("替换文件失败{$filename}");
            //记录错误日志
            file_put_contents(self::$logFile, "替换文件失败{$filename}", FILE_APPEND);
        }

    }

} 
