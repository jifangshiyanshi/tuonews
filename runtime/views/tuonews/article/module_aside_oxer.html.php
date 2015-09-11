<!-- aside_oxer(牛栏) start-->
<div class="aside_oxer aside_module">
    <div class="module_head"><a href="<?php echo url("/article_media_index/?tkey=qiye") ?>" class="module_more">更多</a>牛企</div>
    <div class="justify_wrap">
        <!-- 4个 偶数 -->
        <!--oxer124x112-->
        <?php foreach ( $niulanMedia as $value ) { ?>
        <a href="<?php echo url("/article_media_detail/?id=$value[id]") ?>" class="item">
            <img class="lazy" src="<?php echo $appConfigs[image_block]?>"  data-original="<?php echo getImageThumb($value[logo], '124x124') ?>"
                 alt="<?php echo $value[name]?>"/>
        </a>
        <?php } ?>
        <span class="justify_span"></span>
    </div>
</div>
<!-- aside_oxer end-->
