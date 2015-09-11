$(function(){
	/*表单验证*/
	var $input = $("div.hone_kj div.oform div.oinput");
	$("input.name",$input).blur(function(){input_yz($(this))});
	$("input.tel",$input).blur(function(){tel($(this))});
	var $tanchuang = $("div.ok_tishi");
	/*获取焦点的*/
	var $val = "";
	$("input",$input).focus(function(){
		$val = $(this).val();
		$(this).val("");
	});
	function input_yz(othis){
		if(othis.val() == ""){
			othis.val($val);
		};
		if(othis.val() == ""){
			othis.siblings("span.tishi").remove();
			othis.parent("div.oinput_kj").append("<span class=\"tishi\">"+"请输入联系人"+"</span>");
		}else{
			othis.siblings("span.tishi").remove();
		}
	};
	function tel(othis){
		if(othis.val() == ""){
			othis.val($val);
		};
		if(/^1[3578][0-9]{9}$/.test(othis.val())){
			othis.siblings("span.tishi").remove();
		}else{
			othis.siblings("span.tishi").remove();
			othis.parent("div.oinput_kj").append("<span class=\"tishi\">"+"请输入手机号码"+"</span>");
		}
	};
	$("div.hone_kj div.oform div.oinput div.hone_btn").click(function(){
		$("input",$input).trigger("blur");
		if($("div.oinput_kj span.tishi",$input).length){

		}else{
			var name = $("#name").val();
			var mobile = $("#mobile").val();
			$.post('/common_index_financeApply/',{"name":name,"mobile":mobile},function(data,status){
				data = JSON.parse(data);
				console.log(data);
				if( data.state !== '0' ){
                    $tanchuang.find("p").html(data.data.msg);
                    $tanchuang.fadeIn(300);
				}else{
                    $tanchuang.find("p").html(data.data.msg);
                    $tanchuang.fadeIn(300);
				}

			});
		}
	});
	//$tanchuang.fadeIn(300);
	$("div.ok_tishi div.tishikj div.tj_btn").click(function(){
		$tanchuang.fadeOut(300);
	});
})