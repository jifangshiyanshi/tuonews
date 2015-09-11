<!--aside_recommend start-->
<div class="aside_recommend aside_module">
    <div class="module_head">
        <!--<a href="" class="module_more">更多</a>-->
        编辑推荐
    </div>
    <div class="list">
        <?php foreach ( $editorRec as $value ) { ?>
        <dl class="item">
            <!-- 66x58-->
            <dd class="img">
                <a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>">
                    <img class="lazy" src="<?php echo $appConfigs[image_block]?>"  data-original="<?php echo getImageThumb($value[thumb], '66x58') ?>" alt="<?php echo $value[title]?>"/>
                </a>
            </dd>
            <dt class="head">
                <a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>"><?php echo $value[title]?></a>
            </dt>
        </dl>
        <?php } ?>
    </div>
</div>
<!--aside_recommend end-->
