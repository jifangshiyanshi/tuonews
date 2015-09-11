<?php include $this->getIncludePath('common.header')?>
    <!--content start-->
    <section class="content">
        <div class="layoutmr">
            <!--layout-left start--->
            <article class="layout-main">
                <?php include $this->getIncludePath('article.module_article_detail')?>
            </article>
            <!--layout-left end--->
            <!--layout-right start--->
            <aside class="layout-right">
                <?php include $this->getIncludePath('article.module_aside_publish_detail')?>
                <?php include $this->getIncludePath('common.module_aside_ad')?>
                <?php include $this->getIncludePath('article.module_aside_ranking')?>
                <?php include $this->getIncludePath('article.module_aside_oxer')?>
                <?php include $this->getIncludePath('common.module_aside_ad1')?>
                <?php include $this->getIncludePath('article.module_aside_recommend')?>
                <?php include $this->getIncludePath('common.module_aside_ad2')?>
                <?php include $this->getIncludePath('article.module_aside_tag')?>
            </aside>
            <!--layout-right start--->
        </div>
    </section>
    <!--content end-->
<?php include $this->getIncludePath('common.footer')?>
