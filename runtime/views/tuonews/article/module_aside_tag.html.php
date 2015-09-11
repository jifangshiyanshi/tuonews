<!--aside_tag start-->
<div class="aside_tag aside_module">
    <div class="module_head">热门标签</div>
    <div class="list">
        <?php foreach ( $hotTags as $value ) { ?>
        <a class="item" href="<?php echo url("/article_tags_detail/?id=$value[id]") ?>"><?php echo $value[name]?></a>
        <?php } ?>
    </div>
</div>
<!--aside_tag end-->
