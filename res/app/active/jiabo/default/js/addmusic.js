window.onload=function(){
	var mp3Url ="/res/app/active/jiabo/default/skin/default/images/smileEye.mp3",
		oggUrl ="/res/app/active/jiabo/default/skin/default/images/smileEye.ogg",
 		audio = document.createElement('audio'),
		mp3source = document.createElement('source'),
		oggsource = document.createElement('source');
	// audio
 	audio.name = "audio";
 	// mp3
 	mp3source.type = "audio/mpeg";
 	mp3source.src = mp3Url;
 	mp3source.autoplay = "autoplay";
 	// ogg
 	oggsource.type = "audio/mpeg";
 	oggsource.src = oggUrl;
 	oggsource.autoplay = "autoplay";

 	audio.loop = "loop";
 	audio.addEventListener('ended',function(){
 		setTimeout(function(){audio.play();},500);
 	},false);
 	audio.appendChild(mp3source);
 	audio.appendChild(oggsource);
 	audio.play();
    var fristTouch = false;
	$(".music").on("touchstart",function(){
		if(audio.paused){
			audio.play();
			$(".music").removeClass('stop');
		}
		else{
			audio.pause();
			$(".music").addClass('stop');
		}
	});

 	$(".music").append(audio);
}
