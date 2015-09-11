<!--media_list_top start-->
<div class="media_list_top">
    <div class="item_box">
        <?php foreach ( $medias[recommends] as $value ) { ?>
        <dl class="item">
            <dd class="face">
                <a href="<?php echo url("/article_media_detail/?id=$value[id]") ?>">
                    <img class="lazy" src="<?php echo $appConfigs[image_block]?>" data-original="<?php echo getImageThumb($value[logo], '137x137') ?>" alt="<?php echo $value[name]?>"/>
                </a>
            </dd>
            <dt class="name"><a href="<?php echo url("/article_media_detail/?id=$value[id]") ?>"><?php echo $value[name]?></a></dt>
            <dd class="des"><?php echo $value[intro]?></dd>
            <dd class="operation">
                <button class="subscribe_btn subscribe_ajax_btn <?php if ( $value[order] ) { ?> subscribe_remove <?php } else { ?> subscribe_add <?php } ?>"
                        data-ajax-data='{"id":<?php echo $value[id]?>}'
                        data-ajax-url="<?php if ( $value[order] ) { ?><?php echo url("/article_media_unorder") ?><?php } else { ?><?php echo url("/article_media_order") ?><?php } ?>">
                    <span class="on">
                        <span class="icon icon_wadd"></span>订阅
                    </span>
                    <span class="off">
                        <span class="icon icon_gminus"></span>取消订阅
                    </span>
                    </button>
            </dd>
        </dl>
        <?php } ?>
    </div>
</div>
<!--media_list_top end-->
