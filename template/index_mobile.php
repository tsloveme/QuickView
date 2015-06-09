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
			if(preg_match('/(jpg)|(jpeg)|(png)|(gif)/i',get_file_type($v)) && !preg_match('/quick_mark_address/i',$v)){
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
<!--<meta name="full-screen" content="yes"/>
<meta name="browsermode" content="application"/>-->
<!-- QQ强制竖屏 QQ强制全屏 -->
<meta name="x5-orientation" content="portrait"/>
<meta name="x5-fullscreen" content="true"/>
<meta name="x5-page-mode" content="app"/>
<script src="../../public/jquery-1.8.3.min.js"></script>
<script src="../../public/jquery.event.drag-1.5.min.js"></script>
<script src="../../public/jquery.touchSlider.js"></script>
<script>
/*判断是否手机浏览器*/
function isMobile() {
	var sUserAgent = navigator.userAgent.toLowerCase();
	var noneUA =!(navigator.userAgent.toLowerCase());
	var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
	var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
	var bIsMidp = sUserAgent.match(/midp/i) == "midp";
	var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
	var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
	var bIsAndroid = sUserAgent.match(/android/i) == "android";
	var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
	var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
	if (noneUA || bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM ){
		return true;
	}
	else{
		return false;
	}
}
$(function(){
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
	
	/*timer = setInterval(function(){
		$("#btn_next").click();
	}, 5000);
	
	$(".main_visual").hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(function(){
			$("#btn_next").click();
		},5000);
	});*/
	
	/*$(".main_image").bind("touchstart",function(){
		clearInterval(timer);
	}).bind("touchend", function(){
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
						//img加载完成，适配调度
						adaptHeight();
					}
				}
			}(i);
		}
	})();
	//自适应高度
	function adaptHeight(){
		$(".main_image img").each(function(){
			 var h = $(this).height();
			 maxImgHeight = maxImgHeight > h ? maxImgHeight:h;
		});
		$(".main_image").css("height",maxImgHeight+'px');
	}
	//pc端预览模式
	if(!isMobile()){
		$("html").addClass("pc_page");
		$("body").append('<div class="pc_pannel">\
							<div class="inner">\
								<h2>页面导航</h2>\
								<div class="a_wrap">\
								</div>\
								<div class="clear"></div>\
								<h2>手机扫描二维码全屏访问</h2>\
								<div><img src="quick_mark_address.png" /></div>\
							</div>\
						</div>');
		<?php
			if (isset($imgArr)&&!empty($imgArr)){
				$linkBtn ='';
				foreach($imgArr as $key => $value){
					$linkBtn.='<a href="javascript:;" title="'.$value.'">'.$value.'</a>';
				}
				echo 'var linkBtns =\''.$linkBtn.'\';';	
			}
		?>
		$(".a_wrap").append(linkBtns);
		$(".a_wrap a").click(function(){
			var n = $(".a_wrap a").index($(this));
			$(".flicking_con a").eq(n).click();
			
		});
		$(".main_image").bind("dragend",function(){
			var n = $(".flicking_con a").index($(".flicking_con .on"));
			$(".a_wrap a").removeClass("selected").eq(n).addClass("selected");
		});
		$(".flicking_con a").click(function(){
			var n = $(".flicking_con a").index($(".flicking_con .on"));
			$(".a_wrap a").removeClass("selected").eq(n).addClass("selected");
		});
	
	}
	//
	//var pc_pannel = $('<div class="pc_pannel"><div class="inner"><h2>页面导航</h2></div></div>');
	//var pc_pannel = $('<div class="pc_pannel"><div class="inner"><h2>页面导航</h2></div></div>');
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
body{max-width:480px; margin:0 auto; height:100%; background-color:#000;}
/* main_image */
.main_visual{overflow:hidden;position:relative;}
.main_image{height:422px;overflow:hidden;position:relative;}
.main_image ul{width:9999px;overflow:hidden;position:absolute;top:0;left:0}
.main_image li{float:left;width:100%;}
.main_image li a{display:block;width:100%;height:422px}
.main_image li span{display:block;width:100%;background-position:center top; background-size:100% auto; background-repeat:no-repeat}
.main_image li img{width:100%;}
div.flicking_con{position:fixed; width:100%; max-width:480px;bottom:.5em;left:auto;z-index:999; text-align:center;}
div.flicking_con a{width:1em;height:1em;margin:0;padding:0;background:url('../public/btn_main_img.png') 0 0 no-repeat;display:inline-block;text-indent:-999em; background-size:100% auto; overflow:hidden;}
div.flicking_con a.on{background-position:0 -1em}
#btn_prev,#btn_next{z-index:11111;position:absolute;display:block;top:50%;margin-top:-37px;display:none;}
#btn_prev{left:100px;}
#btn_next{right:100px;}
.pc_page{padding-left:55%;}
.pc_pannel{width:55%; height:100%; overflow-y:scroll; position:fixed; left:0; top:0; background-color:#fff}
.pc_pannel .inner{margin:0 5px; padding:5px 0;}
.pc_pannel h2{font-size:18px; color:#333; line-height:1.75; padding-top:15px;}
.pc_pannel table{border-collapse:collapse;}
.pc_pannel .a_wrap{ padding:2px;}
.pc_pannel .a_wrap a{display:block; line-height:1.5; padding:5px; color:#666;border:1px #ccc dotted; border-radius:3px; text-decoration:none; background-color:#fff;white-space:nowrap; text-overflow:ellipsis;overflow:hidden;}
.pc_pannel .a_wrap a:link{color:#666; float:left; width:21%; margin:0 2% 8px  0; }
.pc_pannel .a_wrap a:hover{color:#fff; background-color:orange; text-decoration:none}
.pc_pannel .a_wrap a.selected{background-color:orange;border:1px #ff6000 solid; color:white}
div.flicking_con{background-color:rgba(255, 255, 255, 0.25); padding-top:.5em;}


</style>
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
<!--<div class="pc_pannel">
	<div class="inner">
		<h2>页面导航</h2>
		<div class="a_wrap">
			<a href="javascript:;" title="welcome_1080_1920_1">welcome_1080_1920_1</a>
			<a href="javascript:;" title="welcome_1080_1920_2">welcome_1080_1920_2222222</a>
			<a href="javascript:;" title="welcome_1080_1920_3">welcome_1080_1920_333333</a>
			<a href="javascript:;" title="welcome_1080_1920_4">welcome_1080_1920_444444444444</a>
			
			<a href="javascript:;" title="welcome_1080_1920_1">welcome_1080_1920_1</a>
			<a href="javascript:;" title="welcome_1080_1920_2">welcome_1080_1920_2222222</a>
			<a href="javascript:;" title="welcome_1080_1920_3">welcome_1080_1920_333333</a>
			<a href="javascript:;" title="welcome_1080_1920_4">welcome_1080_1920_444444444444</a>

			</div
	></div>
</div>-->

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
