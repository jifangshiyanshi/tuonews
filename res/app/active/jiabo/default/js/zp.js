
$(function() {
	// 延迟加载
	$("img").imglazyload();

	// 分享到朋友圈
	$(".share-to-moments").on('click',function() {
		$(this).hide();
	});
});

 var mySwiper = new Swiper('.swiper-container',{
	    mode: 'vertical',
	    onInit:function(swiper, direction) {
	      var index = swiper.activeIndex;
	      var height = $(window).innerHeight();
	      var obj = $(".swiper-slide");
	      var images = obj.find(".swiper-slide-visible img");
	      obj.not(".swiper-slide-visible").find(".mengda").addClass('hide');
	      obj.eq(index).find(".mengda").removeClass("hide");
	      obj.find(".swiper-slide-visible img")
	  },
	    onSlideChangeEnd:function(swiper, direction) {
	      var index = swiper.activeIndex;
	      var obj = $(".swiper-slide");
	      obj.eq(index).siblings().find(".mengda").addClass('hide');
	      obj.eq(index).find(".mengda").removeClass("hide");
	  }
 });

function shareTimeline(){
	WeixinJSBridge.invoke('shareTimeline', {
		"img_url" : window.shareData.img,
		"img_width" : window.shareData.img_width,
		"img_height" : window.shareData.img_height,
		"link" : window.shareData.url,
		"desc" : window.shareData.content,
		"title" : window.shareData.title
	}, function(res) {
		validateShare(res);
	});
}
function sendAppMessage(){
	WeixinJSBridge.invoke('sendAppMessage', {
		"img_url" : window.shareData.img,
		"img_width" : window.shareData.img_width,
		"img_height" : window.shareData.img_height,
		"link" : window.shareData.url,
		"desc" : window.shareData.content,
		"title" : window.shareData.title
	}, function(res) {
	});
}

function validateShare(res) {
    if(res.err_msg != 'send_app_msg:cancel' && res.err_msg != 'share_timeline:cancel') {
    	//分享成功
    	var companyId = '30962';
    	if(''){
    		var username = '';
    		jQuery.ajax({
    			url:ctx+'/cr/regist.json',
    			type:'POST',
    			data:{
    				companyId:companyId,
    				username:username
    			},
    			dataType:'json'
    		}).done(function(result){
    			window.location.href="http://c.mengda.com/apply/success.html";
    		});
    	}else{
    		//计数
	    	jQuery.ajax({
				type:'post',
				data:{companyId:companyId},
				url:ctx+'/cs/joinCompany.json?type=2&companyId='+companyId,
				dataType:'json'
			}).done(function(result){

			});
    	}
    }
}

//微信分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	window.shareData = {
		"url" : "http://active.tuonews.myZ",
		"img" : "/images/fight.jpg",
		"img_width" : "200",
		"img_height" : "200",
		"title" : "企业互联网化，成为风口中的那只猪",
		"content" : "看完，就获高额一对一服务补贴"
	};
	// 发送给好友
	WeixinJSBridge.on('menu:share:appmessage', function(argv) {
		sendAppMessage();
	});
	// 分享到朋友圈
	WeixinJSBridge.on('menu:share:timeline', function(argv) {
		shareTimeline();
	});

}, false);
