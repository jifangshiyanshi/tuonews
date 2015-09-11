/**
 * Created by zhao on 2015-5-16.
 */
var seaUrl=location.protocol+'//'+location.host;
seajs.config({
    // Sea.js 的基础路径
    base: seaUrl+"/res/global/js/sea",
    // 路径配置
    paths: {
        'tuonews_reception': seaUrl+'/res/app/tuonews/reception/default/js',
        'tuonews_user': seaUrl+'/res/app/tuonews/user/default/js',
        'jq':'jquery',
        'jq_plugins': 'jquery/plugins',
        'plugins':'plugins'
    },
    // 别名配置
    alias: {
        'jquery': 'jq/jquery',
        '$': 'jq/jquery'
    },
    // 调试模式
    debug: true,
    // 文件编码
    charset: 'utf-8'
});