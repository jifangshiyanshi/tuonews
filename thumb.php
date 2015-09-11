<?php
/**
* 动态输出并创建缩略图
* @author yangjian<yangjian102621@gmail.com>
*/
// 定义系统根目录
define('APP_ROOT', __DIR__.'/');

//定义框架根目录
define('APP_FRAME_PATH', APP_ROOT.'framework/herosphp/');

//引入系统常量文件
require APP_FRAME_PATH.'Heros.const.php';

//包含系统框架的统一入口文件
require APP_FRAME_PATH.'Herosphp.class.php';

//包含公共函数页面
require APP_ROOT.'functions.php';

\herosphp\core\Loader::import('utils.ImageThumb', IMPORT_FRAME);

$url = $_SERVER['REQUEST_URI'];
$urlInfo = parse_url($url);
$info = pathinfo($urlInfo['path']);
$filename = explode(".", $info['filename']);
$size = explode('x', $filename[count($filename)-1]);    //最后一个缩略图尺寸生效
$imgSrc = __DIR__.$info['dirname']."/".$filename[0].".".$info['extension'];

if ( !file_exists($imgSrc) ) {

	$logosize = '80x80';
	if ( $size[0] < 180 && $size[1] < 125 ) {
		$logosize  = '180x125';
	} else if ( $size[0] >= 647 && $size[1] < 338 ) {
		$logosize = '647x338';
	} else if ( $size[0] >= 648 && $size[1] < 366 ) {
        $logosize = '648x366';
    } else if ( $size[0] >= 650 ) {
		$logosize = '650x304';
	}
    $img = imagecreatefromjpeg(__DIR__."/res/global/images/default-{$logosize}.jpg");
//	$img = imagecreatefromjpeg(__DIR__."/res/global/images/default8.jpg");
	header("Content-Type:image/jpeg");
	imagejpeg($img);
	die();
}

$thumbInstance = \herosphp\utils\ImageThumb::getInstance();
$thumbInstance->setFlag(2); //固定高度(宽度)，等比缩放
//获取原图的尺寸
$srcInfo = getimagesize($imgSrc);
$rat_src = $srcInfo[0]/$srcInfo[1];
$rat_thumb = $size[0]/$size[1];
if ( $rat_thumb > $rat_src ) {
    $thumb = $thumbInstance->makeThumb(array($size[0], 0), $imgSrc, __DIR__.$urlInfo['path']);
} else {
    $thumb = $thumbInstance->makeThumb(array(0, $size[1]), $imgSrc, __DIR__.$urlInfo['path']);
}
//计算缩放后图片的尺寸
$thumbSize = getimagesize($thumb);
//计算裁剪的坐标
$position = array();
$position[0] = ($thumbSize[0] - $size[0])/2;
$position[1] = ($thumbSize[1] - $size[1])/2;
//__print($position);die();
//自动裁剪图片
$thumbInstance->setFlag(0);
$thumbInstance->crop($position, $size, $thumb, null, true);
$thumbInstance->showImage();
