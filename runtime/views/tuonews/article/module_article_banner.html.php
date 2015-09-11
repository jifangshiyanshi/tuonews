<!--banner start-->
<section class="banner">
    <div class="sliderBox">
        <!--4个-->
        <!--620x348-->
        <ul class="slider">
            <?php foreach ( $indexRecommend as $value ) { ?>
            <li>
                <a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>">
                    <img class="lazy" src="<?php echo $value[thumb]?>"/>
                    <p><?php echo $value[title]?></p>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
    <ul class="control">
        <?php foreach ( $indexRecommend as $value ) { ?>
        <li>
            <img class="lazy" src="<?php echo $appConfigs['res_url']?>/res/global/images/reception/block.gif"  data-original="<?php echo $value[thumb]?>"/>
            <p><?php echo $value[title]?></p>
        </li>
        <?php } ?>
    </ul>
</section>
<!--banner end-->
