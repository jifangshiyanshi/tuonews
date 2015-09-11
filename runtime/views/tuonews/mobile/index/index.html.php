<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title>驼牛网-产业文化与媒体影响力传播交流平台</title>
<meta name="description" content="">
<meta name="renderer" content="webkit">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<?php echo $this->importResource('res', 'css', 'reset.css')?>
<?php echo $this->importResource('res', 'css', 'index.css')?>

<style>
.gmu-media-detect{-webkit-transition: width 0.001ms; width: 0; position: absolute; clip: rect(1px, 1px, 1px, 1px);}
</style>
<?php echo $this->importResource('gres', 'js', 'jquery-1.11.2.min.js')?>
</head>
<body >
	<header class='clearfix'>
		<div class='top-title'><span class='logo'>驼牛网</span><span class='detail'>媒体第一开放平台</span></div>
		<nav>
			<ul id='menu'>
                <li class='on'><a href="#">首页</a></li>
                <?php foreach ( $chanels as $item ) { ?>
                <li><a href="<?php echo $item[url]?>"><?php echo $item[name]?></a></li>
                <?php } ?>
			</ul>
		</nav>
	</header>
    <div class='focus-img-wraper'>
		<div class='focus-img'>
            <a href='<?php echo $indexPosition[url]?>'>
				<img src="<?php echo $indexPosition[thumb]?>">
				<span class='bg'></span>
				<span class='text'><?php echo $indexPosition[title]?></span>
			</a>
		</div>
	</div>
	<div id="indicator">
		<div id="dotty"></div>
	</div>
	<div class='content'>
		<div class='today-news'>
            <?php foreach ( $items as $item ) { ?>
                <a href='<?php echo $item[url]?>'>
                    <div class='msg'>
                        <p class='type'><?php echo $item[chanel]?></p>
                        <p class='focus-detail'><span class='time'>BY<span class='name'><?php echo $item[media]?></span></span><span class='author'><?php echo $item[time]?></span></p>
                    </div>
                    <?php if ( empty($item[thumb]) ) { ?>
                        <img src="/res/global/images/reception/loading.gif">
                    <?php } else { ?>
                        <img src="<?php echo $item[thumb]?>">
                    <?php } ?>
                    <div class='right-side'>
                        <p class='text'><?php echo $item[title]?></p>
                    </div>
                </a>
            <?php } ?>
		</div>
	</div>
	<div class='loading-more-wraper'>
		<p class='loading-more'>加载更多</p>
	</div>
    <?php include $this->getIncludePath('mobile.module_index_up')?>
    <?php include $this->getIncludePath('mobile.module_index_footer')?>
</body>
<?php echo $this->importResource('res', 'js', 'template.js')?>
<script id="test" type="text/html">
{{each data as value}}
    <a href='{{value.url}}'>
        <div class='msg'>
            <p class='type'>{{value.chanel}}</p>
            <p class='focus-detail'>
                <span class='time'>BY<span class='name'>{{value.media}}</span></span><span class='author'>{{value.time}}</span></p>
        </div>
        <img src="{{value.thumb}}">
        <div class='right-side'>
            <p class='text'>{{value.title}}</p>
        </div>
    </a>
{{/each}}
</script>
<script type="text/javascript">
    var pn = 2;
    $('.loading-more').on('touchend',function (e) {
        e.preventDefault();
        $.ajax({url:"<?php echo url("/mobile_index_indexJson") ?>",type:"get",dataType:"json",data:{page:pn},success:function(data){
            if (data.state == 1) {
                pn++;
                var html = template('test', data);
                $('.today-news').append(html);
            } else {
                $('.loading-more').hide();
            }
        }});
    })
</script>
</html>
