<!--aside_publish_detail start-->
<?php if ( $mediaInfo ) { ?>
<div class="aside_module <?php echo $circleClass?> aside_publish">

    <div class="<?php echo $imageClass?>">
        <!--215x126-->
        <img class="lazy" src="<?php echo $appConfigs[image_block]?>" data-original="<?php echo getImageThumb($mediaInfo[logo], '126x126') ?>" alt="<?php echo $mediaInfo[name]?>"/>
    </div>
    <div class="title"><?php echo $mediaInfo[name]?></div>
    <div class="info">
        <?php echo $mediaInfo[intro]?>
    </div>
    <div class="about">
        <div class="head"><div class="more"><a href="<?php echo url("/article_media_detail/?id=$mediaInfo[id]") ?>">更多</a></div><div class="head_text">相关报道</div></div>
        <ul class="list">
            <?php foreach ( $mediaArticles as $value ) { ?>
            <li class="item"><a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>"><?php echo $value[title]?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php } ?>
<!--aside_publish_detail end-->
