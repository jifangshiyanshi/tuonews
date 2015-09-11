/**
 * Created by monda on 2015/6/11.
 */
$(function(){
    //header
    $('.header .user_item').hover(function(){
        $(this).find('.sublist').slideDown();
    },function(){
        $(this).find('.sublist:animated').stop();
        $(this).find('.sublist').slideUp();
    });
    //slider
    $('.banner').slider({
        event: 'mouseenter',
        effects: "slideX",
        interval: 3000,
        fullScreen: false,
        createControl: true,
        hasSideControl: true,
        fadeSideControl: false
    });
});
