<!--aside_ranking start-->
<!-- 在媒体 文章列表中,文章详情页面的热门排行和周排行-->
<div class="aside_module aside_ranking aside_ranking_tab">
    <ul class="tab_menu">
        <li>
            热门排行
            <div class="border_top"></div>
            <div class="border_bottom"></div>
        </li>

        <li>
            周排行
            <div class="border_top"></div>
            <div class="border_bottom"></div>
        </li>

    </ul>
    <div class="tab_content">
        <ul class="tab_con">
            <li class="tab_conItem">
                <?php foreach ( $hotRanks as $key => $value ) { ?>
                <div class="item">
                    <span class="index"><?php echo ++$key ?></span>
                    <a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>"><?php echo $value[title]?></a>
                </div>
                <?php } ?>
            </li>

            <li class="tab_conItem">
                <?php foreach ( $weekRanks as $key => $value ) { ?>
                <div class="item">
                    <span class="index"><?php echo ++$key ?></span>
                    <a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>"><?php echo $value[title]?></a>
                </div>
                <?php } ?>
            </li>

        </ul>
    </div>
</div>
<!--aside_ranking end-->
