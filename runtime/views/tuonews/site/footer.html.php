
<!--footer start-->
<footer class="footer">
    <div class="footer_wrap">
        <div class="footer_left">
            <a href="<?php echo url("/site_index_index/?media_id=$loginMedia[id]") ?>">
                <span class="icon icon_footer_logo"><img width="120px" src="<?php if ( $loginMedia[logo] ) { ?><?php echo $loginMedia[logo]?><?php } else { ?>/res/global/images/default8.png<?php } ?>"/></span>
            </a>
        </div>
        <div class="footer_right">
            <div class="friendship">
                <div class="head">友情链接</div>
                <ul class="list">
                    <?php foreach ( $friendLinks as $value ) { ?>
                    <li class="item"><a href="<?php echo $value['url']?>" class="link" target="_blank"><?php echo $value['name']?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <nav class="footer_nav">
                <ul class="list">
                    <?php foreach ( $artoneMenu as $key => $value ) { ?>
                    <li  class="item" <?php if ( $mid == $value['id'] ) { ?>class="current"<?php } ?> ><a class="link" href="<?php echo url("/site_service_index/?id=$value[id]&media_id=$loginMedia[id]") ?>"><?php echo $value[title]?></a></li>
                    <?php } ?>
                </ul>
            </nav>
            <div class="copyright">
                <?php if ( $mediaConfigs[sitecopy] ) { ?> 版权信息:<?php echo $mediaConfigs[sitecopy]?><?php } ?>&nbsp;&nbsp;&nbsp;  <?php if ( $mediaConfigs[siteicp] ) { ?>备案号:<?php echo $mediaConfigs[siteicp]?><?php } ?>
            </div>
        </div>
    </div>
</footer>
<!--footer end-->
</body>
</html>
