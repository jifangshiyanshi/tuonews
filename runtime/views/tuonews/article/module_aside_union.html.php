<!--aside_union(驼牛联盟) start-->
<div class="aside_union aside_module">
    <div class="module_head"><a href="<?php echo url("/article_media_index/?tkey=qunmei") ?>" class="module_more">更多</a>驼牛联盟</div>
    <div class="justify_wrap">
        <!-- 8个 偶数 -->
        <!--union133x59--->
        <?php foreach ( $tnlm as $value ) { ?>
        <a href="<?php echo url("/article_media_detail/?id=$value[id]") ?>" class="item">
            <img class="lazy" src="<?php echo $appConfigs[image_block]?>"  data-original="<?php echo getImageThumb($value[logo], '133x78') ?>" alt="<?php echo $value[name]?>"/>
        </a>
        <?php } ?>
        <span class="justify_span"></span>
    </div>
</div>
<!--aside_union end-->
