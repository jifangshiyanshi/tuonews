
/*$(function($){
	//发布按钮
	var $text = $("div.pinlun_kj div.input_text textarea");
	var $oul = $("div.pinlun_kj div.pl_kj ul");
	var $btn_pl = $("div.pinlun_kj div.input_text div.btn_kj .pl_btn");
	//文字数量判断
	$text.keydown(function(){
		var $str = $(this).val().length;
		if($str>=300){
			alert("不可以在输入了");
		}
		$("div.pinlun_kj div.input_text div.btn_kj .biaoqin em").html(300-$str);
	});
	$btn_pl.click(function(){
		if($text.val() == false){
			return;
		}else{
			$oul.prepend(
				"<li>"+
					"<div class=\"img\">"+
						"<img class=\"lazy\" src=\"{$appConfigs['res_url']}/res/global/images/reception/tx_img.jpg\" data-original=\"{$appConfigs['res_url']}/res/app/tuonews/reception/default/skin/default/images/temp/tx_img.jpg\" />"+
					"</div>"+
					"<div class=\"pl_text\">"+
						"<div class=\"pl_top\">"+
							"<span class=\"name\">千纸鹤</span>"+
							"<span class=\"date\">2015-9-7</span>"+
							"<div class=\"oflow\"></div>"+
						"</div>"+
						"<p>"+$text.val()+"</p>"+
					"</div>"+
					"<div class=\"huifu\">"+
						"<span class=\"hf_btn\">回复</span>"+
						"<div class=\"hf2_kj\">"+
							"<input type=\"text\" name=\"huifu\" class=\"hf_input\"/>"+
							"<div class=\"fb_btn\">发布</div>"+
							"<div class=\"oflow\"></div>"+
						"</div>"+
						"<div class=\"oflow\"></div>"+
					"</div>"+
					"<div class=\"oflow\"></div>"+
				"</li>"
			);
			$text.val("");
		};
		$("div.pinlun_kj div.pl_kj ul li div.huifu span.hf_btn").on("click",function (){
			if($(this).siblings("div.hf2_kj").is(":hidden")){
				$(this).siblings("div.hf2_kj").fadeIn(200);
			}else{
				$(this).siblings("div.hf2_kj").fadeOut(200);
			};
		});
		var $ejhf = $("div.pinlun_kj div.pl_kj ul li div.huifu div.hf2_kj div.fb_btn");
		$ejhf.click(function(){
			var $plval = $(this).siblings("input.hf_input").val();
			$($(this).parents("li").find("div.img , div.pl_top")).hide();
			$($(this).parents("li")).prepend(
				"<li class=\"opl_li\">"+
					"<div class=\"img\">"+
						"<img class=\"lazy\" src=\"{$appConfigs['res_url']}/res/global/images/reception/tx_img.jpg\" data-original=\"{$appConfigs['res_url']}/res/app/tuonews/reception/default/skin/default/images/temp/tx_img.jpg\" />"+
					"</div>"+
					"<div class=\"pl_text\">"+
						"<div class=\"pl_top\">"+
							"<span class=\"name\">千纸鹤</span>"+
							"<span class=\"date\">2015-9-7</span>"+
							"<div class=\"oflow\"></div>"+
						"</div>"+
						"<div class=\"hfmr\">回复小缘</div>"+
						"<p>"+$plval+"</p>"+
					"</div>"+
					"<div class=\"huifu\">"+
						"<span class=\"hf_btn\">回复</span>"+
						"<div class=\"hf2_kj\">"+
							"<input type=\"text\" name=\"huifu\" class=\"hf_input\"/>"+
							"<div class=\"fb_btn\">发布</div>"+
							"<div class=\"oflow\"></div>"+
						"</div>"+
						"<div class=\"oflow\"></div>"+
					"</div>"+
					"<div class=\"oflow\"></div>"+
				"</li>"
			);
		})
	});
});*/
