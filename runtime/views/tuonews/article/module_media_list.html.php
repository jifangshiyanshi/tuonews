<!---media_list-->
<!---
	无图 class="media_list media_user_list"
	有图 class="media_list media_company_list"
-->
<div class="media_list <?php if ( $showLogo ) { ?>media_company_list<?php } else { ?>media_user_list<?php } ?>">
    <div class="media_list_wrap">
        <?php foreach ( $medias[items] as $value ) { ?>
        <div class="item">
            <div class="item_btn subscribe_ajax_btn <?php if ( $value[order] ) { ?> subscribe_remove <?php } else { ?> subscribe_add <?php } ?>"
                 data-ajax-data='{"id":<?php echo $value[id]?>}'
                 data-ajax-url="<?php if ( $value[order] ) { ?><?php echo url("/article_media_unorder") ?><?php } else { ?><?php echo url("/article_media_order") ?><?php } ?>">
                <div class="item_btn_box">
                    <div class="btn_bg"></div>
                    <div class="operation">
                        <div class="icon icon_wminus_big"></div>
                    </div>
                </div>
            </div>
            <?php if ( $showLogo ) { ?>
            <div class="face_box">
                <img class="face lazy" src="<?php echo $appConfigs[image_block]?>"  data-original="<?php echo getImageThumb($value[logo], '218x128') ?>" alt="<?php echo $value[name]?>"/>
            </div>
            <?php } ?>
            <div class="text">
                <div class="name"><a href="<?php echo $value[url]?>"><?php echo $value[name]?></a></div>
                <div class="des"><?php echo $value[intro]?></div>
                <div class="info">驼牛网收录文章 <?php echo $value[total]?></div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
