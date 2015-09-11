<!--article_detail start-->
<div class="article_detail">
	<div style="width=500px; height="200px""></div>
    <div class="head_wrap">
        <div class="info">
            <div class="tag">
                <?php foreach ( $item[tags] as $value ) { ?>
                <a href="<?php echo url("/article_tags_detail/?id=$value[id]") ?>" target="_blank"><?php echo $value[name]?></a>
                <?php } ?>
            </div>
            <?php if ( $item[media_id] > 0 ) { ?>
            <a href="<?php echo url("/article_media_detail/?id=$item[media_id]") ?>" target="_blank"><?php echo $item[media]?></a>
            <?php } ?>
            <?php if ( $item[media_id] == 0 ) { ?>
            <a href="javascript:void(0);"><?php echo $item[media]?></a>
            <?php } ?>

            <span class="date"><?php echo $this->getDate($item[add_time], " Y-m-d H:i") ?></span>
            <a id="articles_chanel" href="<?php echo url("/article_article_index/?id=$item[chanel_id]") ?>" target="_blank"><?php echo $item[chanel]?></a>
        </div>
    </div>
    <div class="des"><?php echo $item[bcontent]?></div>
    <div class="text"><?php echo $item[content]?></div>
    <div class="operation">
        <div class="share">
            <div class="bdsharebuttonbox" data-tag="share_1">
                <span class="fl">分享到:</span>
                <a class="bds_tsina share_icon" data-cmd="tsina"></a>
                <a class="bds_qzone share_icon" data-cmd="qzone" href="#"></a>
                <a class="bds_tqq share_icon" data-cmd="baidu"></a>
                <a class="bds_weixin share_icon" data-cmd="weixin"></a>
                <a class="bds_more share_icon" data-cmd="more"></a>
            </div>
        </div>
        <div class="operation_right">
            <!--赞 zan_on zan_off-->
            <span class="zan <?php if ( $item[zan] ) { ?>zan_on<?php } else { ?>zan_off<?php } ?>" <?php if ( !$item[zan] ) { ?>id="zan"<?php } ?> data-ajax-data='{"id":<?php echo $item[id]?>}' data-ajax-url="<?php echo url("/article_article_zan") ?>">
                <span class="icon icon_zan"></span><span class="num"><?php if ( $item[zan_times] != 0 ) { ?><?php echo $item[zan_times]?><?php } ?></span>
            </span>
            <!--收藏 collection_on collection_off-->
            <span class="collection <?php if ( $item[collection] ) { ?>collection_on<?php } else { ?>collection_off<?php } ?>" <?php if ( !$item[collection] ) { ?>id="collection"<?php } ?>
                  data-ajax-data='{"id":<?php echo $item[id]?>}'
                  data-ajax-url="<?php if ( !$item[collection] ) { ?><?php echo url("/article_article_collection") ?><?php } ?>">
                <span class="icon icon_collection"></span>收藏
            </span>
        </div>
    </div>
</div>
<!--article_detail end-->
<!--article_ad start-->
<div class="article_ad">
    <!-- maxwidth621-->
    <!--<a href=""><img class="lazy" src="<?php echo $appConfigs['res_url']?>/res/global/images/reception/block.gif" data-original="<?php echo $appConfigs['res_url']?>/res/app/tuonews/reception/default/skin/default/images/temp/ad610x98.jpg" alt="广告"/></a>-->
    <script type="text/javascript">
        /*610*100 创建于 2015-06-15*/
        var cpro_id = "u2157148";
    </script>
    <!--<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>-->
</div>
<!--article_ad end-->
<!--article_recommend start-->
<div class="article_recommend">
    <div class="head">您可能感兴趣的文章002<div class="border"></div></div>
    <div class="list_wrap">
        <div class="list">
            <!--max 4-->
            <?php foreach ( $alikeArticles as $value ) { ?>
            <dl class="item">
                <!-- 142x118 -->
                <dd class="img">
                    <a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>"><img class="lazy" src="<?php echo $appConfigs[image_block]?>"
                         data-original="<?php echo getImageThumb($value[thumb], '142x118') ?>" alt="<?php echo $value[title]?>"/></a></dd>
                <dt class="title"><a href="<?php echo url("/article_article_detail/?id=$value[id]") ?>"><?php echo $value[title]?></a></dt>
            </dl>
            <?php } ?>
        </div>
    </div>
</div>
<!----评论模块-->
<div class="pinlun_kj" id="pinlun">
			<h3 class="pl_title">有<em><?php echo count($commentList); ?></em>条评论</h3>
			<div class="input_text">
				<div class="text">
					<textarea id="pinlun_content"></textarea>
				</div>
				<div class="btn_kj">
					<div class="biaoqin">
						<a href="#"><img class="lazy" src="<?php echo $appConfigs['res_url']?>/res/global/images/reception/block.gif" data-original="<?php echo $appConfigs['res_url']?>/res/app/tuonews/reception/default/skin/default/images/temp/expression.jpg" alt="ads_300x67"/></a>
						<span class="otxt">您还可以输入<em id="last_num">300</em>个字</span>
					</div>
					<div class="pl_btn" onclick="textAreaComment();">发布</div>
				</div>
			</div>
			<!---评论--->
			<div class="huifu_kj">
				<h3>最新评论</h3>
			</div>
			<div class="pl_kj" >
				<ul id="pinlun_lb">
                    <?php $index = 0 ?>
                    <?php foreach ( $commentList as $val ) { ?>
                    <?php if ( $index < 10 ) { ?>
                    <?php if ( $val['pid'] ) { ?>
					<li>
						<div class="img">
							<img class="laz" src="<?php echo $appConfigs['res_url']?>/res/global/images/reception/tx_img.jpg" data-original="<?php echo $appConfigs['res_url']?>/res/app/tuonews/reception/default/skin/default/images/temp/tx_img.jpg" alt="ads_300x67" />
						</div>
						<div class="pl_text">
							<div class="pl_top">
								<span class="name"><?php echo $users[$val['uid']]['nickname']?></span>
								<span class="date"><?php echo date('Y-m-d h:i',$val['createtime']); ?></span>
								<div class="oflow"></div>
							</div>

                            <!-- 上一级用户 -->
                            <div class="pre_comment">
                                <div class="pre_name"><?php echo $users[$commentList[$val['pid']]['uid']]['nickname']?></div>
                                <div><?php echo $commentList[$val['pid']]['comment']?></div>
                                <div class="pre_reply" onclick="reply(this);" ><span style="float:right;"  class="msg_switch">回复</span></div>

                                <div class="hf2_kj" style="display:none;">
                                    <input type="text" name="huifu" class="hf_input" style="width:100%;"/>
                                    <div class="fb_btn" onclick="subListComment(this,<?php echo $commentList[$val['pid']]['id']?>)" style="float:right;">发布</div>
                                </div>
                            </div>


							<p><?php echo $val['comment']?></p>
						</div>
						<div class="huifu">
							<span class="hf_btn msg_switch" onclick="reply(this);"  >回复</span>
							<div class="hf2_kj">
								<input type="text" name="huifu" class="hf_input"/>
								<div class="fb_btn" onclick="subListComment(this,<?php echo $val['id']?>)">发布</div>
								<div class="oflow"></div>
							</div>
							<div class="oflow"></div>
						</div>
						<div class="oflow"></div>
					</li>


                    <?php } else { ?>


                    <li>
                        <div class="img">
                            <img class="laz" src="<?php echo $appConfigs['res_url']?><?php echo $users[$val['uid']]['head']?>" data-original="<?php echo $appConfigs['res_url']?>/res/app/tuonews/reception/default/skin/default/images/temp/tx_img.jpg" alt="ads_300x67" width="40px"/>
                        </div>
                        <div class="pl_text">
                            <div class="pl_top">
                                <span class="name"><?php echo $users[$val['uid']]['nickname']?></span>
                                <span class="date"><?php echo  date('Y-m-d h:i',$val['createtime']); ?></span>
                                <div class="oflow"></div>
                            </div>

                            <p><?php echo $val['comment']?></p>
                        </div>

                        <div class="huifu">
                            <span class="hf_btn msg_switch" onclick="reply(this);">回复</span>
                            <div class="hf2_kj">
                                <input type="text" name="huifu" class="hf_input"/>
                                <div class="fb_btn" onclick="subListComment(this,<?php echo $val['id']?>)">发布</div>
                                <div class="oflow"></div>
                            </div>
                            <div class="oflow"></div>
                        </div>
                        <div class="oflow"></div>

                    </li>
                    <?php } ?>
                    <?php } ?>
                    <?php $i++ ?>
                    <?php } ?>



				</ul>
			</div>

			<div class="btn_jz" onclick="addMore();">加载更多</div>
            <script type="text/javascript">

                var curpage = 1;
                function addMore(){
                    $.post('/article_article_ajaxCommentMore/',{"curpage":curpage,"aid":"<?php echo $aid?>"},function(data,status){
                        data = JSON.parse( data );
                        if(data.state !== '0'){
                            curpage++;
                            var secondLevel = data.data.secondLevel;
                            var users = data.data.users;
                            $.each(data.data.firstLevel,function(index,element) {
                                if (element.pid !== '0') {
                                    $("#pinlun_lb").append(getTextHasReply(element,secondLevel[element.pid],users));
                                }else{
                                    $("#pinlun_lb").append(getText(element,users))
                                }
                            });

                        }else{
                            alert("已经没有了");
                        }

                    });
                }

                function sendComment( pid, data ){
                    $.post('/article_article_ajaxComment/',{"aid":"<?php echo $aid?>","pid":pid,"data":data},function(data,status){
                        data = JSON.parse(data);
                        console.log(data);

                        if(data.state !== '0'){
                            prePend(data.data);
                            alert('评论成功');
                        }else{
                            if(data.data.msgcode == 2) $('#login_popup_btn').click();
                        }
                        $("#pinlun_content").val('');
                    });
                }

                /**
                 * 有上一级的评论的html
                 */
                function getTextHasReply(cur,pre,users){
                    var text = '<li>'+
                            '<div class="img">'+
                            '           <img class="laz" src=\'<?php echo $appConfigs["res_url"]?>'+users[cur['uid']]['head']+'\' data-original=\'<?php echo $appConfigs["res_url"]?>/res/app/tuonews/reception/default/skin/default/images/temp/tx_img.jpg\' alt="ads_300x67" width="40px" />  '+
                            '           </div>'+
                            '       <div class="pl_text">'+
                            '       <div class="pl_top">'+
                            '       <span class="name">'+users[cur['uid']]['nickname']+'</span>'+
                            '       <span class="date">'+cur['createtime']+'</span>'+
                            '<div class="oflow"></div>'+
                            '   </div>'+

                                <!-- 上一级用户 -->
                            '   <div class="pre_comment">'+
                            '   <div  class="pre_name" >'+users[pre['uid']]['nickname']+'</div>'+
                            '   <div>'+pre['comment']+'</div>'+
                            '   <div class="pre_reply" onclick="reply(this);" ><span style="float:right;" class="msg_switch" >回复</span></div>'+

                            '   <div class="hf2_kj" style="display:none;"> '+
                            '   <input type="text" name="huifu" class="hf_input" style="width:100%;"/>'+
                            '   <div class="fb_btn" onclick="subListComment(this,'+pre['id']+')" style="float:right;">发布</div>'+
                            '   </div>'+
                            '   </div>'+



                            '                            <p>'+cur['comment']+'</p>'+
                            '   </div>'+
                            '   <div class="huifu">'+
                            '   <span class="hf_btn msg_switch" onclick="reply(this);" >回复</span>'+
                            '   <div class="hf2_kj">'+
                            '   <input type="text" name="huifu" class="hf_input"/>'+
                            '   <div class="fb_btn" onclick="subListComment(this,'+cur['id']+')">发布</div>'+
                            '   <div class="oflow"></div>'+
                            '   </div>'+
                            '   <div class="oflow"></div>'+
                            '   </div>'+
                            '<div class="oflow"></div>'+
                            '</li>';
                    return text;
                }

                /**
                 * 没有上一级评论的html
                 */
                function getText(cur,users){
                    //console.log(users);
                    //console.log(cur);
                    var text = '<li>'+
                    '<div class="img"> '+
                    '           <img class="laz" src=\'<?php echo $appConfigs["res_url"]?>'+users[cur['uid']]['head']+'\' data-original=\'<?php echo $appConfigs["res_url"]?>/res/app/tuonews/reception/default/skin/default/images/temp/tx_img.jpg\' alt="ads_300x67"  width="40px"/>  '+
                    '           </div>'+
                    '       <div class="pl_text">'+
                    '       <div class="pl_top">'+
                    '       <span class="name">'+users[cur['uid']]['nickname']+'</span>'+
                    '       <span class="date">'+cur['createtime']+'</span>'+
                    '<div class="oflow"></div>'+
                    '   </div>'+

                    '    <p>'+cur['comment']+'</p>'+
                    '   </div>'+

                    '   <div class="huifu">'+
                    '   <span class="hf_btn msg_switch" onclick="reply(this);">回复</span>'+
                    '   <div class="hf2_kj">'+
                    '   <input type="text" name="huifu" class="hf_input"/> '+
                    '   <div class="fb_btn" onclick="subListComment(this,'+cur['id']+')">发布</div>'+
                    '   <div class="oflow"></div>'+
                    '   </div>'+
                    '   <div class="oflow"></div>'+
                    '   </div>'+
                    '   <div class="oflow"></div>'+

                    '    </li>';
                    return text;
                }

                function prePend(data){

                    if(typeof data.commentList.pre == 'number' ){
                        $("#pinlun_lb").prepend(getText(data.commentList.cur[0],data.users));

                    }else{
                        $("#pinlun_lb").prepend(getTextHasReply(data.commentList.cur[0],data.commentList.pre[0],data.users));
                    };

                }

                function textAreaComment(){
                    var text = $("#pinlun_content").val();
                    if( !(text.length >2 && text.length < 300 ) ){
                        alert("字数在2 到300 之间");
                        return;
                    }
                    sendComment(0,text);
                }

                function subListComment(obj,pid){
                    var text = $(obj).siblings('.hf_input').val();
                    sendComment( pid, text );
                    $(obj).siblings('input').val('');
                    $('.hf2_kj').hide();
                    $(".msg_switch").html("回复");
                }


                $("#pinlun_content").bind('keyup',function(){
                    var text = $("#pinlun_content").val();
                    var lastNum = 300 - text.length;
                    if(lastNum <= 0){
                        alert("不能再输入了");
                        $("#pinlun_content").val(text.substr(0,300))
                        ;
                        lastNum = 0;
                    }
                    $("#last_num").html(lastNum);


                });

                function reply(obj){
                    $('.hf2_kj').fadeOut(200);
                    $(".msg_switch").html("回复");

                    if($(obj).siblings('.hf2_kj').css('display') == "none") {
                        $(obj).siblings('.hf2_kj').fadeIn(200);
                        if (obj.nodeName == 'SPAN') {
                            $(obj).html("收起");
                        } else {
                            $(obj).find("span").html("收起");
                        }
                    }else{
                        $(obj).siblings('.hf2_kj').fadeOut(200);
                        if (obj.nodeName == 'SPAN') {
                            $(obj).html("回复");
                        } else {
                            $(obj).find("span").html("回复");
                        }
                    }
                }


            </script>
		</div>
<!--article_recommend end-->

<!-- 新闻评论 -->
<!--<div class="nc-comment-box">-->
    <!--<div class="box-title">-->
        <!--<h3>精彩评论</h3>-->
    <!--</div>-->
    <!--<div class="comment-box">-->
        <!--<div id="SOHUCS" sid="<?php echo $item[id]?>"></div>-->
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
<script>
    //百度分享
    window.onload = function(){
        var url= "http://"+location.host;
        window._bd_share_config = {
            common : {
                bdText : "<?php echo $item[title]?>",
                bdDesc : "<?php echo $item[bcontent]?>",
                bdUrl : location.href,
                bdPic : url+"<?php echo $item[thumb]?>"
            },
            share : [{
                "bdSize" : 16
            }],
            image : [{
                viewType : 'list',
                viewPos : 'top',
                viewColor : 'black',
                viewSize : '16',
                viewList : ['tsina','qzone','tqq','weixin']
            }],
            selectShare : [{
                "bdselectMiniList" : ['tsina','qzone','tqq','weixin']
            }]
        };
        with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
    };
</script>
<style>
    .share .fl {
        height: 35px;
        line-height: 35px;
        font-size: 14px;
        color: #8b8b8b;
    }
    .share .share_icon {
        background: url("/res/app/tuonews/reception/default/skin/default/images/icon.png") no-repeat;
        width: 23px;
        height: 23px;
        padding: 0;
    }
    .share .bds_tsina { background-position: 0 -228px; }
    .share .bds_qzone { background-position: -30px -228px; }
    .share .bds_tqq { background-position: -60px -228px; }
    .share .bds_weixin { background-position: -90px -228px; }
    .share .bds_more { background-position: -120px -228px; }
</style>
