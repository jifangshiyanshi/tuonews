<!--list start-->
<section class="article_list">
    <!--注意和首页的图片大小不一样
    牛眼 牛头 牛推 620x203  class="article_list"
    首页 其他列表 180x126 class="article_list small_img_list"
     -->
    <ul class="list">
        <?php foreach ( $items as $value ) { ?>
        <li class="item">
            <div class="img_box">
                <a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>">
                    <img class="lazy" src="<?php echo $appConfigs[image_block]?>"
                         data-original="<?php echo $value[thumb]?>" alt="<?php echo $value[title]?>"/>
                </a>
            </div>
            <div class="text_box">
                <h1 class="head"><a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>"><?php echo $value[title]?></a></h1>
                <div class="info">
                    <div class="tag">
                        <?php foreach ( $value[__tags] as $val ) { ?>
                        <a href="<?php echo $val[tag_url]?>"><?php echo $val[name]?></a>
                        <?php } ?>
                    </div>
                    <a href="<?php echo $value[media_url]?>"><?php echo $value[media_name]?></a>
                    <span class="date"><?php echo $this->getDate($value[add_time], " Y-m-d H:i") ?></span>
                    <a href="<?php echo $value[chanel_url]?>"><?php echo $value[chanel_name]?></a>
                </div>
                <div class="dec"><?php echo $value[bcontent]?></div>
            </div>
        </li>
        <?php } ?>
    </ul>
</section>
<!--list end-->
