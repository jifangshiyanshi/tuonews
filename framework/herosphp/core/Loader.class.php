<?php
/*---------------------------------------------------------------------
 * HerosPHP 资源加载器类
 * ---------------------------------------------------------------------
 * Copyright (c) 2013-now http://blog518.com All rights reserved.
 * ---------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ---------------------------------------------------------------------
 * Author: <yangjian102621@163.com>
 *-----------------------------------------------------------------------*/

namespace herosphp\core;

class Loader {

    /**
     * 已经导入的class文件
     * @var array
     */
    private static $IMPORTED_FILES = array();

    /**
     * 已经导入的配置文档
     * @var array
     */
    private static $CONFIGS = array();

    /**
     * 加载一个类或者加载一个包
     * 如果加载的包中有子文件夹不进行循环加载
     * 参数格式：'article.model.articleModel'
     * article.model.articleModel 相对的路径信息
     * 如果不填写应用名称 ，例如‘article.model.articleModel’，那么加载路径则相对于默认的应用路径
     *
     * 加载一个类的参数方式：'article.model.articleModel'
     * 加载一个包的参数方式：'article.service.*'
     * @param $classPath
     * @param int $type 导入了类包的类别，详情见Herosphp.const.php
     * @param $extension
     * @return boolean
     */
    public static function import( $classPath, $type = IMPORT_APP, $extension=EXT_PHP ) {

        if ( !$classPath ) return false;
        //如果该文件已经导入了，就不再导入
        $classKey = $classPath.'_'.$type.'_'.$extension;
        if ( isset(self::$IMPORTED_FILES[$classKey]) )  return false;

        //组合文件路径
        switch ( $type ) {
            case IMPORT_CLIENT :
                $path = APP_ROOT.'client'.'/';
                break;

            case IMPORT_APP :
                $path = APP_PATH.APP_NAME.'/';
                break;

            case IMPORT_FRAME :
                $path = APP_FRAME_PATH;
                break;

            case IMPORT_CUSTOM :
                $path = APP_ROOT;
                break;

            default:
                return false;
        }

        $classPathInfo = explode('.', $classPath);
        $classPath = str_replace('.', '/', $classPath);
        if ( $classPathInfo[count($classPathInfo)-1] == '*' ) {     //加载包

            $dir = $path.$classPath;
            chdir($dir);
            $classFiles = glob('*'.$extension);
            foreach ($classFiles as $file ) {
                include $dir.'/'.$file;
            }

        } else {    //包含文件
            include $path.$classPath.$extension;
        }

        self::$IMPORTED_FILES[$classKey] = 1;
        return true;
    }

    /**
     * 包含一个文件,并返回该文件的内容
     *
     * 包含一个文件的参数方式：'article.model.articleModel'
     * @param $classPath
     * @param int $type 导入了类包的类别，详情见Herosphp.const.php
     * @param $extension
     * @return boolean
     */
    public static function __include( $classPath, $type = IMPORT_APP, $extension=EXT_PHP ) {

        //组合文件路径
        switch ( $type ) {
            case IMPORT_CLIENT :
                $path = APP_ROOT.'client'.'/';
                break;

            case IMPORT_APP :
                $path = APP_PATH.APP_NAME.'/';
                break;

            case IMPORT_FRAME :
                $path = APP_FRAME_PATH;
                break;

            case IMPORT_CUSTOM :
                $path = APP_ROOT;
                break;

            default:
                return false;
        }

        $classPath = str_replace('.', '/', $classPath);
        return include $path.$classPath.$extension;
    }

    /**
     * 加载配置信息
     * @param string $key 配置文件名称key， 如果没有指定则加载所有配置文档
     * @param string $section 配置文档所属片区|模块，如果没有指定则加载配置文档根目录的所有文件
     * @return array
     */
    public static function config( $key='*', $section='root' ) {

        if ( isset(self::$CONFIGS[$section][$key]) ) {
            return self::$CONFIGS[$section][$key];
        }
        $configDir = APP_CONFIG_PATH;
        //默认加载配置根目录的配置文档
        if ( $section != 'root' ) {
            $configDir .= str_replace('.', '/', $section).'/';
        }
        if ( $key != '*' ) {
            $configFile = $configDir.$key.'.config.php';
            if ( file_exists($configFile) ) {
                self::$CONFIGS[$section][$key] = include $configFile;
            }
        } else if ( file_exists($configDir) ) {
            chdir($configDir);
            $configFiles = glob("*.config.php");
            $configs = array();
            foreach ( $configFiles as $file ) {
                $tempConfig = include $configDir.$file;
                $configs = array_merge($configs, $tempConfig);
            }
            self::$CONFIGS[$section][$key] = &$configs;
        }

        if ( self::$CONFIGS[$section][$key] ) {
            return self::$CONFIGS[$section][$key];
        } else {
            return array();
        }
    }

    /**
     * 加载modelDao
     * @param string $modelName
     * @return \herosphp\model\IModel
     */
    public static function model( $modelName ) {

        $modelName = ucfirst($modelName);
        $modelPath = 'configs.models';
        //如果定义了models路径，则优先使用定义的models路径
        if ( MODELS_PATH != false ) {
            $modelPath = MODELS_PATH;
        }
        Loader::import($modelPath.'.'.$modelName, IMPORT_CUSTOM, EXT_MODEL);
        $className = 'models\\'.$modelName.'Model';
        return new $className();

    }
}
