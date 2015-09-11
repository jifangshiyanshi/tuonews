<?php include $this->getIncludePath('site.header')?>
<!-- 新闻内容区 -->
<div class="content">

<div class="maxWidth">

<div class="clearfix">
<!-- 新闻左栏 -->
<div class="l-con fl">
    <!-- 新闻内容 -->
    <div class="n-con-box">
        <div class="nc-head">
            <h3 class="nc-title"><?php echo $item['title']?></h3>
            <div class="nc-relate clearfix">
                <div class="nc-relate-l fl">
                    作者：<span><a href="javascript:;"><?php echo $item[author]?></a></span>
                    来源：<span><a href="<?php echo url("/site_index_index/?media_id=$loginMedia[id]") ?>"><?php echo $loginMedia[name]?></a></span>
                    发布时间：<span><?php echo $this->getDate($item[add_time], " Y-m-d H:i") ?></span>
                </div>
            </div>
        </div>
        <div class="nc-content" style="width:600px;">
            <div class="nc-brief">
                <p>摘要 : <?php echo $item['bcontent']?></p>
            </div>

            <div class="nc-text" style="overflow: hidden;">
                <?php echo $item['content']?>
            </div>
        </div>
        <div class="sec-con-f" style="background:none; border:none;">
            <ul class="pagination">
                <?php echo $pages?>
            </ul>
        </div>
        <div style="clear:both;"></div>
        <br/>
        <div class="nc-relate clearfix">
            <div class="nc-relate-l fl">
                标签:
                <span class="nc-tags">
                    <?php foreach ( $item[tags] as $val ) { ?>
                    <a href="javascript:void(0);"><?php echo $val[name]?></a>
                    <?php } ?>
                </span>
            </div>
        </div>
        <style>
            .nc-relate-r .special{
                color:#D854D7;
                font-weight:bold;
                cursor:pointer;
            }
            .n-con-box .nc-footer{
                margin-top:0px;
            }
            .n-con-box .nc-footer .nc-link{
                float:left;
            }
            .nc-footer .nc-link p{
                float:left;
            }
            #spr{
                float:right;margin-left:10px;
            }
        </style>
        <div class="nc-footer clearfix">
            <div class="nc-link">
                <?php if ( $prev_article[0]['title'] ) { ?>
                <p>上一篇：<a href="/newsdetail-<?php echo $prev_article[0]['id']?>/"><?php echo $prev_article[0]['title']?></a></p>
                <?php } ?>
                <?php if ( $next_article[0]['title'] ) { ?>
                <p id="spr">下一篇：<a href="/newsdetail-<?php echo $next_article[0]['id']?>/"><?php echo $next_article[0]['title']?></a></p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- 新闻评论 -->
    <!--<div class="nc-comment-box">-->
        <!--<div class="box-title">-->
            <!--<h3>精彩评论</h3>-->
        <!--</div>-->
        <!--<div class="comment-box">-->
            <!--<div id="SOHUCS" sid="<?php echo $item['mid']?>|<?php echo $item['id']?>"></div>-->
            <!--<script>-->
                <!--(function(){-->
                    <!--var appid = 'cyrjjRUet',-->
                        <!--conf = 'prod_f84baba4e169b7bf6f772865df79220b';-->
                    <!--var doc = document,-->
                        <!--s = doc.createElement('script'),-->
                        <!--h = doc.getElementsByTagName('head')[0] || doc.head || doc.documentElement;-->
                    <!--s.type = 'text/javascript';-->
                    <!--s.charset = 'utf-8';-->
                    <!--s.src =  'http://assets.changyan.sohu.com/upload/changyan.js?conf='+ conf +'&appid=' + appid;-->
                    <!--h.insertBefore(s,h.firstChild);-->
                <!--})()-->
            <!--</script>-->
        <!--</div>-->
    <!--</div>-->

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

</div>

</div>
<?php include $this->getIncludePath('site.footer')?>
