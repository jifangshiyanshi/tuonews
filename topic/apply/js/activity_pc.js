$(function(){
	var $kj = $("div.no_tishi");
	var $text = $("div.no_tishi p");
	var $tj_btn = $("div.web_kj div.kj_text div.banli_lc div.oinput ul div.form_btn");
	var $oinput = $("div.web_kj div.kj_text div.banli_lc div.oinput .oform input");
	var $btn_if = $("div.ok_tishi");
	function top_animate(){
		$("div.web_kj div.header_img img").animate({"bottom":"0px"},200,function(){
			$(this).fadeIn(1000);
		});
	}
	top_animate();
	//动画-验证失败弹出
	function $date(){
		var $date = setInterval(function(){
			$kj.fadeOut(300);
			clearTimeout($date);
		},2000);
	}
	/*鼠标一开验证*/
	$oinput.blur(function(){
		if($(this).val().length <=0){
			$kj.fadeIn(300);
			$text.html($(this).attr("tishi"));
			$date();
		};
	});
	/*点击提交按钮验证*/
	$tj_btn.click(function(){
		var index = 0;
		$oinput.each(function(){
			//console.log($(this).val());
			if($(this).val().length > 0){
				index += 1;
			}else{
				index -= index;
				$kj.fadeIn(300);
				$text.html($(this).attr("tishi"));
				$date();
				return;
			};
			if(index >= 2){
				var name = $("#name").val();
				var mobile = $("#mobile").val();

				$.post('/common_index_financeApply/',{"name":name,"mobile":mobile},function(data,status){
					data = JSON.parse(data);
					console.log(data);

					if( data.state !== '0' ){
						$btn_if.find("p").html(data.data.msg);
						$btn_if.fadeIn(300);
					}else{
						$btn_if.find("p").html(data.data.msg);
						$btn_if.fadeIn(300);
					}

				});

			};
		});
	});
	/*成功后点击关闭*/
	$("div.ok_tishi div.tishikj div.ok_btn").click(function(){
		$btn_if.fadeOut(300);
	});


})