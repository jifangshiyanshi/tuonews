
<!--footer start-->
<footer class="footer">
    <div class="footer_wrap">
        <div class="footer_left">
            <a href="/">
                <span class="icon icon_footer_logo"></span>
            </a>
        </div>
        <div class="footer_right">
            <div class="friendship">
                <div class="head">友情链接</div>
                <ul class="list">
                    <?php foreach ( $friendLinks as $value ) { ?>
                    <li class="item"><a href="<?php echo $value['url']?>" class="link" target="_blank"><?php echo $value[name]?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <nav class="footer_nav">
                <ul class="list">
                    <?php foreach ( $footNavis as $value ) { ?>
                    <li class="item">
                        <a href="<?php echo url("/article_artone_service/?id=$value[id]") ?>" class="link"><?php echo $value[title]?></a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
            <div class="copyright">
                <?php echo $appConfigs[copy_right]?> <?php echo $appConfigs[ipc_beian]?>
            </div>
        </div>
    </div>
</footer>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?09911ff282f4012ce5a7afd27dd73ecf";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<!--footer end-->
</body>
</html>
