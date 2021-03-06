<?php include $this->getIncludePath('user.header')?>
<!--content start-->
<section class="content">
    <?php include $this->getIncludePath('user.module_info_top')?>
    <div class="layoutlm">
        <div class="layout-main">
            <!-- 爆料-->
            <div class="user_right_layout function_tab">
                <ul class="user_right_menu">
                    <li class="current"><a href="<?php echo url("/user_tipoff_index") ?>">爆料</a></li>
                    <li><a href="<?php echo url("/user_tipoff_lists") ?>">我的爆料</a></li>
                </ul>
                <div class="user_right_content">
                    <!-- 爆料 start-->
                    <!--module-form -->
                    <div class="module_form">
                        <div class="tipoff">
                            <form action="" id="tipoff_add_form">
                                <div class="tipoff_des">
                                    驼牛网主要报道产经行业新闻，因此有关于此的一切线索都有可能是我们感兴趣的报道信息源。我们接受实名或匿名的爆料，我们在确定信息可能有效的情况下会在线下与你取得联系，所以务必留下有效的联系方式。届时我们需要核实你的身份，并判断是否会形成利益相关的风险，但同时我们会确保在法律层面对你个人隐私的保护。一旦线索被我们的报道所采纳，我们会支付相应的稿酬。
                                </div>
                                <div class="input_title">内容</div>
                                <textarea class="textarea w_textarea" name="data[content]" tip-text="内容" required></textarea>
                                <div class="input_title">联系方式(请填写手机号码)</div>
                                <input type="text" class="input w_input" name="data[contact]" dtype="mobile" tip-text="联系方式" required/>
                                <button class="red_btn submit_btn ajaxproxy"
                                        href="<?php echo url("/user_tipoff_insert") ?>"
                                        proxy='{"formId":"tipoff_add_form", "method":"post", "location":"<?php echo url("/user_tipoff_lists") ?>"}'>提交
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- 爆料 end-->
                </div>
            </div>
            <!-- function_tab end-->
        </div>
        <div class="layout-left">
            <?php include $this->getIncludePath('user.module_aside')?>
        </div>
    </div>
</section>
<script>
    function  checkBack(data){
        if(data.state == "ok"){
            JDialog.tip.work({type:"ok",width:"200", content:"爆料成功", timer:2000});
        } else {
            JDialog.tip.work({type:"error",width:"200", content:data.message, timer:2000});
        }
    }
</script>
<!--content end-->
<?php include $this->getIncludePath('user.footer')?>
