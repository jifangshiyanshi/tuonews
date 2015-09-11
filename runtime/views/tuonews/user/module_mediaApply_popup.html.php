<!--mediaApply-popup-->
<script id="mediaApply_popup" type="text/html">
    <div class="mediaApply_popup">
        <dl class="item">
            <dd><span class="icon icon_media"></span></dd>
            <dt><a class="gray_radius_btn" href="<?php echo url("/user_ucenter_mediaApply/?id=1") ?>">申请媒体</a></dt>
        </dl>
        <dl class="item">
            <dd><span class="icon icon_mymedia"></span></dd>
            <dt><a class="gray_radius_btn" href="<?php echo url("/user_ucenter_mediaApply/?id=2") ?>">申请自媒体</a></dt>
        </dl>
        <dl class="item">
            <dd><span class="icon icon_company"></span></dd>
            <dt><a class="gray_radius_btn" href="<?php echo url("/user_ucenter_mediaApply/?id=3") ?>">申请企业</a></dt>
        </dl>
    </div>
</script>
<?php echo $this->importResource('gres', 'js', 'artTemplate.js')?>
<script>
    $(function(){
        $('.mediaApply_popup_btn').click(function(e){
            e.preventDefault();
            var data = {};
            var html = template('mediaApply_popup', data);
            JDialog.lock.work({opacity:0.5});
            JDialog.win.work({
                title : '',
                skin : 'mediaApply_popup',
                borderWidth: 0,
                content : html,
                width: 660
            });
        });
    });
</script>
