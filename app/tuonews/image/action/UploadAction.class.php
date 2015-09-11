<?php
namespace image\action;

use common\action\CommonAction;
use herosphp\bean\Beans;
use herosphp\http\HttpRequest;
use herosphp\session\Session;
use herosphp\utils\AjaxResult;
use herosphp\utils\FileUpload;
use herosphp\utils\ImageThumb;

/**
 * 图片上传处理Action
 * @author          yangjian<yangjian102621@163.com>
 */
class UploadAction extends CommonAction {

    /**
     * 初始化方法
     */
    public function C_start() {

        parent::C_start();
        //设置错误等级
        error_reporting(E_ERROR);
    }

    /**
     * 上传文件,返回上传文件的地址
     * @param HttpRequest $request
     */
    public function index( HttpRequest $request ) {

        $userid = $request->getParameter('userid', 'intval');
        $mediaId = $request->getParameter('media_id', 'intval');
        $type = $request->getParameter('type', 'trim');
        //图片的最大尺寸，大于这个尺寸就等比例裁剪
        $width = $request->getParameter('width', 'intval');
        if ( $width <= 0 ) {
            $width = 800;
        }

        if ( !$type ) {
            $type = 'image';
        }

        $__uploadDir = $type.'/'.date('Y').'/'.date('m').'/'.date('d');
        $uploadDir = getConfig('upload_dir').$__uploadDir;

        //上传图片
        $config = array(
            "upload_dir" => $uploadDir,
            'max_size' =>  2048000,
        );
        $upload = new FileUpload($config);
        $result = $upload->upload('Filedata');
        if ( $result && $result['is_image'] == 1 ) {

            //缩放图片
            if ( $width < $result['image_width'] ) {
                $src = $result['file_path'];
                $thumb = ImageThumb::getInstance();
                $thumb->setFlag(2); //规定宽度，等比缩放
                $filename = $thumb->makeThumb(array($width, 0), $src, null, true);

                //重新获取图片的尺寸和大小
                $info = getimagesize($filename);
                $result['image_width'] = $info[0];
                $result['image_height'] = $info[1];
                $result['file_size'] = filesize($filename);
            }

            //添加图片图片信息到数据库
            $service = Beans::get('image.image.service');
            $url = '/res/upload/'.$__uploadDir.'/'.$result['file_name'];
            $data = array(
                'userid' => $userid,
                'media_id' => $mediaId,
                'url' => $url,
                'filename' => $result['local_name'],
                'type' => $type,
                'filesize' => formatFileSize($result['file_size']),
                'width' => intval($result['image_width']),
                'height' => intval($result['image_height']),
                'add_time' => time(),
                'grabed' => 1,
            );

            //保存到数据库失败
            if ( !$service->add($data) ) {
                //删除图片
                @unlink($result['file_path']);

            }
            AjaxResult::ajaxResult(1, $url);

        } else {
            @unlink($result['file_path']);
            AjaxResult::ajaxResult(0, '图片上传失败,'.$upload->getUploadMessage());
        }

    }

    /**
     * 裁剪图片
     * @param HttpRequest $request
     */
    public function crop(HttpRequest $request) {

        $x = $request->getParameter('x', 'intval');
        $y = $request->getParameter('y', 'intval');
        $w = $request->getParameter('w', 'intval');
        $h = $request->getParameter('h', 'intval');
        $_w = $request->getParameter('_w', 'intval');
        $_h = $request->getParameter('_h', 'intval');
        $src = $request->getParameter('src', 'trim');
        //$overwrite = $request->getParameter('overwrite', 'intval');
        $overwrite = 1;

        //裁剪图片
        $imgSrc = rtrim(APP_ROOT, '/').$src;
        $position = array($x, $y);
        $size = array($w, $h);
        $thumb = ImageThumb::getInstance();
        $thumb->setFlag(0);
        $result = $thumb->crop($position, $size, $imgSrc, null, $overwrite);
        if ( $result != false ) {
            //如果传入了固定大小，则强制将图片缩放成指定大小
            if ( $_w > 0 && $_h > 0 ) {
                $sizeNew = array($_w, $_h);
                $outfile = str_replace(implode('x', $size), implode('x', $sizeNew), $result);
                $thumb->makeThumb($sizeNew, $result, $outfile);
                //@unlink($result);
            }
            AjaxResult::ajaxResult(1, '裁剪成功！');
        } else {
            AjaxResult::ajaxResult(0, '裁剪失败！');
        }

    }


}
?>
