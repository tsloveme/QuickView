<?php
	//获取文件扩展名
	function get_file_type($filename){ 
		$type = pathinfo($filename); 
		$type = strtolower($type["extension"]); 
		return $type; 
	}  
	$dir = getcwd();
	$list = scandir($dir);
	$imgArr = array();
	foreach($list as $k => $v){
		if(is_file($dir.'\\'.$v)){
			if(preg_match('/(jpg)|(jpeg)|(png)|(gif)/i',get_file_type($v))){
				array_push($imgArr,iconv('GBK', 'utf-8', $v));	
			}
		}
	}
	if (isset($imgArr)&&!empty($imgArr)){
		$pageTitle = "效果图预览-".$imgArr[0];
	}
	else{
		$pageTitle = "没有文件，请先添加";	
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection" />
<!-- UC默认竖屏 ，UC强制全屏 -->
<meta name="full-screen" content="yes"/>
<meta name="browsermode" content="application"/>
<!-- QQ强制竖屏 QQ强制全屏 -->
<meta name="x5-orientation" content="portrait"/>
<meta name="x5-fullscreen" content="true"/>
<meta name="x5-page-mode" content="app"/>
<script src="../public/jquery-1.8.3.min.js"></script><!--
<script src="../public/jquery.event.move.js"></script>
<script src="../public/jquery.event.swipe.js"></script>-->
<script src="../public/jquery.event.drag-1.5.min.js"></script>
<script src="../public/jquery.touchSlider.js"></script>
<script>
$(function(){
	/*$("body").on("swiperight", function(){
		alert('right!');
	})*/;
	
	$dragBln = false;
	maxImgHeight = 0;
	$(".main_image").touchSlider({
		flexible : true,
		speed : 200,
		btn_prev : $("#btn_prev"),
		btn_next : $("#btn_next"),
		paging : $(".flicking_con a"),
		counter : function (e){
			$(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
		}
	});
	
	$(".main_image").bind("mousedown", function() {
		$dragBln = false;
	});
	
	$(".main_image").bind("dragstart", function() {
		$dragBln = true;
	});
	
	$(".main_image a").click(function(){
		if($dragBln) {
			return false;
		}
	});
	
	timer = setInterval(function(){
		$("#btn_next").click();
	}, 5000);
	
	$(".main_visual").hover(function(){
		clearInterval(timer);
	},function(){
		/*timer = setInterval(function(){
			$("#btn_next").click();
		},5000);*/
	});
	
	$(".main_image").bind("touchstart",function(){
		clearInterval(timer);
	})/*.bind("touchend", function(){
		timer = setInterval(function(){
			$("#btn_next").click();
		}, 5000);
	});*/

	var loadedNum = 0;
	(function(){
		var imgWrap = document.getElementsByClassName("main_image")[0];
		var imgs = imgWrap.getElementsByTagName("img");
		var imgLength = imgs.length;
		for(var i=0;i<imgLength;i++){
			!function(i){
				imgs[i].onload =function(){
					loadedNum++;
					if	(loadedNum==imgLength){
						adaptHeight();
					}
				}
			}(i);
		}
	})();
	function adaptHeight(){
		$(".main_image img").each(function(){
			 var h = $(this).height();
			 maxImgHeight = maxImgHeight > h ? maxImgHeight:h;
		});
		$(".main_image").css("height",maxImgHeight+'px');
	}
})
</script>
<title><?php echo $pageTitle ?></title>
<style type="text/css">
/*初始化*/
.clearfix:after{content:"."; display:block; clear:both; line-height:0; font-size:0; height:0; overflow:hidden; visibility:hidden;}
.clearfix{*zoom:1;}
.clear{display:block; height:0; font-size:0; line-height:0; visibility:hidden; overflow:hidden; clear:both;}
p,ul,ol,li,body,h1,h2,h3,h4,h5,h6,dl,dd,form,input,li,dd{margin:0; padding:0;}
body{font-size:1em; color:#666; font-family:Arial, Helvetica, sans-serif;}
h1,h2,h3,h4,h5,h6{font-size:12pt;}
img{border:none}
ul li{list-style-type:none;}
ol{}
/*初始化*/
header,footer,.main{margin:0 auto; max-width:480px;}
header{display:block;width:100%; vertical-align:top;}
body{max-width:480px; margin:0 auto; height:100%;}
/* main_image */
.main_visual{overflow:hidden;position:relative;}
.main_image{height:422px;overflow:hidden;position:relative;}
.main_image ul{width:9999px;overflow:hidden;position:absolute;top:0;left:0}
.main_image li{float:left;width:100%;}
.main_image li a{display:block;width:100%;height:422px}
.main_image li span{display:block;width:100%;background-position:center top; background-size:100% auto; background-repeat:no-repeat}
.main_image li img{width:100%;}
div.flicking_con{position:fixed; width:100%; max-width:480px;bottom:.5em;left:auto;z-index:999; text-align:center;}
div.flicking_con a{width:1em;height:1em;margin:0;padding:0;background:url('../public/btn_main_img.png') 0 0 no-repeat;display:inline-block;text-indent:-999em; background-size:100% auto;}
div.flicking_con a.on{background-position:0 -1em}
#btn_prev,#btn_next{z-index:11111;position:absolute;display:block;top:50%;margin-top:-37px;display:none;}
#btn_prev{left:100px;}
#btn_next{right:100px;}</style>
</head>
<body>
<?php 
	if (isset($imgArr)&&!empty($imgArr)){
		echo '<div class="main_visual"><div class="flicking_con">';
		foreach($imgArr as $key => $value){
			/*if (count($imgArr)==1){
				echo '<a href="#">'.($key+1).'</a>';
			}*/
			echo '<a href="#">'.($key+1).'</a>';
		}
		echo '</div><div class="main_image"><ul>';
		foreach($imgArr as $key => $value){
			echo '<li><span><img src="'.$value.'" /></span></li>';
		}
		echo '</ul><a href="#" id="btn_prev"></a><a href="#" id="btn_next"></a></div></div>';
	}
	else{
		echo '<strong style="font-size:1.5em;display:block;padding:5em 1em; text-align:center;">没有图片，请先添加！</strong>';
	}

?>

<!--<div class="main_visual">
	<div class="flicking_con">
		<a href="#">1</a>
		<a href="#">2</a>
		<a href="#">3</a>
		<a href="#">4</a>
		<a href="#">5</a>
		<a href="#">6</a>
		<a href="#">7</a>
	</div>
	<div class="main_image">
		<ul>
			<li><span><img src="welcome_1080_1920_1.jpg" /></span></li>
			<li><span><img src="welcome_1080_1920_2.jpg" /></span></li>
			<li><span><img src="welcome_1080_1920_3.jpg" /></span></li>
			<li><span><img src="welcome_1080_1920_4.jpg" /></span></li>
			<li><span><img src="welcome_1080_1920_5.jpg" /></span></li>
			<li><span><img src="welcome_1080_1920_最后.jpg" /></span></li>
			<li><span><img src="APP移动端（ 邂逅英伦爱情520）.jpg" /></span></li>
		</ul>
		<a href="#" id="btn_prev"></a>
		<a href="#" id="btn_next"></a>
	</div>
</div>-->
</body>
</html>
