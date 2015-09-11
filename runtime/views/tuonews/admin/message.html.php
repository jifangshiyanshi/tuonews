<?php include $this->getIncludePath('admin.top')?>

<div class="container-fluid">
    <div class="row">
        <?php include $this->getIncludePath('admin.sider')?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <h1 class="pull-left" style="font-size: 30px;">O(∩_∩)O~</h1>
            <div class="alert alert-<?php echo $type?> pull-left" style="margin-top: 20px; margin-left: 20px; font-size: 14px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>提示：</strong>
                    <span class="alert-one"><?php echo $message?></span>
            </div>

            <div class="pull-left" style="margin-top: 24px; margin-left: 20px;">
                <?php if ( $url ) { ?>
                <a href="<?php echo $url?>" class="btn btn-primary btn-lg">返回</a>
                <?php } else { ?>
                <a href="javascript:window.history.go(-1);" class="btn btn-primary btn-lg">返回</a>
                <?php } ?>
            </div>

            <script>
                <?php if ( $url ) { ?>
                    setTimeout(function() {
                        window.location.replace('<?php echo $url?>');
                    }, 3000);
                <?php } ?>
            </script>
        </div>
    </div>
</div>

<?php include $this->getIncludePath('admin.script')?>

<?php include $this->getIncludePath('admin.footer')?>