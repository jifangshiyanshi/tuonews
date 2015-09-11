<?php include $this->getIncludePath('common.header')?>
<!--content start-->
<section class="content">
    <div class="about_article_box">
        <aside class="about_aside">
            <ul class="list">
                <?php foreach ( $footNavis as $value ) { ?>
                    <?php echo $value[id]==$item[id] ? '<li class="current">' : '<li>'; ?><a href="<?php echo url("/article_artone_service/?id=$value[id]") ?>"><?php echo $value['title']?></a></li>
                <?php } ?>
            </ul>
        </aside>
        <article class="about_article">
            <h1 class="head">
                <span class="text"><?php echo $item['title']?></span>
            </h1>
            <div class="main">
                <?php echo $item['content']?>
            </div>
        </article>
    </div>
</section>
<!--content end-->
<?php include $this->getIncludePath('common.footer')?>
