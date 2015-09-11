<?php include $this->getIncludePath('site.header')?>
<!--content start-->

<!-- 新闻内容区 -->
<div class="content">

    <div class="maxWidth">

        <div class="clearfix">
            <!-- 新闻左栏 -->
            <div class="l-con fl">

                <!-- 新闻列表 -->
                <div class="n-list-box">
                    <ul class="n-list">
                        <?php foreach ( $items as $value ) { ?>
                        <li>
                            <div class="nl-pic">
                                <a title="<?php echo $value['title']?>" href="<?php echo url("/site_index_detail/?id=$value[id]&media_id=$loginMedia[id]") ?>">
                                    <img src="<?php echo $value['thumb']?>" alt="<?php echo $value['title']?>" /></a>
                            </div>
                            <div class="nl-text">
                                <div class="nl-title">
                                    <h3><a title="<?php echo $value['title']?>" href="<?php echo url("/site_index_detail/?id=$value[id]&media_id=$loginMedia[id]") ?>"><font color="<?php echo $value['title_color']?>"><?php echo $value['title']?></font></a></h3>
                                    <span class="nl-time"><?php if ( $value['add_time'] ) { ?><?php echo $this->getDate($value['add_time'], " m-d H:i") ?><?php } ?></span>
                                </div>
                                <div class="nl-brief">
                                    <p><?php echo $this->cutString($value['bcontent'], " 75 '...'") ?><a href="<?php echo url("/site_article_detail/?id=$value[id]&media_id=$loginMedia[id]") ?>">[详细]</a></p>
                                </div>
                                <div class="nl-relate">
                                    <div class="nl-relate-l">
                                        <span><?php echo $value['author']?></span>
                                        <span>阅读（<i class="nl-num"><?php echo $value['hits']?></i>）</span>
                                        <!-- 鼠标划上 分享图标出现 -->
                                    </div>
                                    <div class="nl-relate-r">
                                        <?php foreach ( $value[tags] as $vTags ) { ?>
                                        <a href="<?php echo url("/article_tags_detail/?id=$vTags") ?>"><?php echo $tags[$vTags]?></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="sec-con-f">
                    <ul class="pagination">
                        <?php echo $pagemenu?>
                    </ul>
                </div>
            </div>

            <!-- 新闻右栏 -->
            <div class="r-con fr">
                <div class="r-box">
                    <div class="box-title">
                        <h3>热门推荐</h3>
                    </div>
                    <div class="r-hot-box">
                        <ul class="r-hot-con">
                            <?php foreach ( $hotArticles as $v ) { ?>
                            <li>
                                <div class="h-photo">
                                    <a href="<?php echo url("/site_index_detail/?id=$v[id]&media_id=$loginMedia[id]") ?>">
                                        <img alt="<?php echo $v['title']?>" src="<?php echo $v['thumb']?>" /></a>
                                </div>
                                <div class="h-text">
                                    <h3><a href="<?php echo url("/site_index_detail/?id=$v[id]&media_id=$loginMedia[id]") ?>"><?php echo $this->cutString($v['title'], " 18 '...'") ?></a></h3>
                                    <div class="h-relate">
                                        <span class="h-read">阅读(<i><?php echo $v['hits']?></i>)</span>
                                        <span class="h-author"><?php echo $v[author]?></span>
                                    </div>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- 合作媒体 -->
        <?php if ( $link_Arr ) { ?>
        <div class="f-media">
            <h3 class="f-title">合作媒体</h3>
            <div class="media-friends">
                <ul class="media-list">
                    <?php foreach ( $link_Arr as $v ) { ?>
                    <li><a href="<?php echo $v['url']?>" title="<?php echo $v['name']?>" target="_blank"><img alt="<?php echo $v['name']?>" src="<?php echo $v['pic']?>" /></a></li>
                    <?php } ?>
                    <span class="justify_fix">&nbsp;</span>
                </ul>
            </div>
        </div>
        <?php } ?>

        <?php if ( $link_text_Arr ) { ?>
        <!-- 友情链接 -->
        <div class="f-link">
            <h3 class="f-title">友情链接1234</h3>
            <div class="f-link-list">
                <ul class="link-list">+
                    <?php foreach ( $link_text_Arr as $k => $v ) { ?>
                    <?php if ( $k >30 ) { ?>
                    <a href="/link/link/index/" target="_blank">更多>></a>
                    {php}
                    break;
                    {/php}
                    <?php } else { ?>
                    <li><a href="<?php echo $v['url']?>" title="<?php echo $v['name']?>" <?php if ( $v['transfer']==1 ) { ?> rel="nofollow" <?php } ?> target="_blank"><?php echo $v['name']?></a></li>
                    <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php } ?>
    </div>

</div>
<!--content end-->
<?php include $this->getIncludePath('site.footer')?>
