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
<meta http-equiv="X-UA-Compatible" content="IE=10" />
<meta name="renderer" content="webkit">
<title><?php echo $pageTitle ?></title>
<style type="text/css">
/*初始化*/
.clearfix:after{content:"."; display:block; clear:both; line-height:0; font-size:0; height:0; overflow:hidden; visibility:hidden;}
.clearfix{*zoom:1;}
.clear{display:block; height:0; font-size:0; line-height:0; visibility:hidden; overflow:hidden; clear:both;}
p,ul,ol,li,body,h1,h2,h3,h4,h5,h6,dl,dd,form,input,li,dd{margin:0; padding:0;}
body{font-size:12px; color:#333; font-family:"微软雅黑"; }
h1,h2,h3,h4,h5,h6{font-size:14px;}
img{border:none}
li{list-style:none;}
a,a:link{color:#535353; text-decoration:none;}
a:hover{color:#CCB08A; text-decoration:underline;}
body{padding-bottom:40px;}
/*初始化*/
.banner{width:100%; overflow:hidden; position:relative; padding-bottom:25px;} 
.banner .im{width:1px; position:relative; margin:0 auto;}
.banner .disable{visibility:hidden; position:absolute; left:0; top:0;}
.banner .im img{position:absolute; top:auto; left:-960px; display:block; vertical-align:top;}
.main{width:1000px; margin:0 auto;}
.fixedFoot{width:100%;position:fixed; left:0; bottom:0; background-color:rgba(0,0,0,0.65);text-align:center;}
.FootOverFlow{overflow-x:scroll; overflow-y:hidden;}
.fixedFoot .inner{padding:1px;}
.fixedFoot a{display:inline-block; margin:3px; padding:6px 4px; line-height:1; border:1px dashed #e0e0e0;border-radius:3px;font-size:12px; color:#e0e0e0; text-decoration:none}
.fixedFoot a:link{color:#e0e0e0;}
.fixedFoot a:hover{border-style:dotted; text-decoration:none;}
.fixedFoot a.selected{border:1px solid #e0e0e0; background-color:#e0e0e0; color:#333;}
.fixedFoot a.selected:hover{border-style:solid;}

</style>
<script>
function adaptHeight(obj){
	obj.parentNode.style.height=obj.clientHeight+"px";
}
</script>
</head>
<body>
<div class="banner">
<?php
	if (isset($imgArr)&&!empty($imgArr)){
		foreach($imgArr as $key => $value){
			if($key == 0){
				echo '<div class="im"><img src="'.$value.'" onload="adaptHeight(this)" /></div>';
			}
			else{
				echo '<div class="im disable"><img src="'.$value.'" onload="adaptHeight(this)" /></div>';
			}
		}
	}
	else{
		echo '<strong style="font-size:25px;display:block;padding:250px; text-align:center;">没有图片，请先添加！</strong>';
	}
 ?>
<!--	<div class="im">
    	<img src="（维也纳智好酒店）网页设计图.jpg" height="1900" onload="adaptHeight(this)" />
    </div>
    
	<div class="im disable" style="height:1900px;">
    	<img src="1（维纳斯皇家酒店）网页设计图.jpg" height="1900" onload="adaptHeight(this)" />
    </div>
    
	<div class="im disable" style="height:1080px;">
    	<img src="1b网页图（集团介绍）.jpg" height="1080" onload="adaptHeight(this)" />
    </div>
-->    
</div>
<div class="fixedFoot">
	<div class="inner">
    	<!--<a href="#" class="selected">（维也纳智好酒店）网页设计图</a>
    	<a href="#">1（维纳斯皇家酒店）网页设计图</a>
    	<a href="#">1b网页图（集团介绍）</a>-->
    </div>
</div>
<script language="javascript" type="text/javascript" src="../../public/jquery-1.8.3.min.js"></script>
<script language="javascript" type="text/javascript">
$(function(){

	var banner = document.getElementsByClassName("banner")[0];
	var imgs = banner.getElementsByTagName("img");
	var imgLength = imgs.length;
	var arr = new Array();
	for(var i=0;i<imgLength;i++){
		arr.push(imgs[i].getAttribute("src"));
	}	
	var shortArr =arr;
	function stringLengthCn(str){
		var str=str.replace(/[^\x00-\xff]/g, 'xx');
		return str.length;
	}
	for (var key in shortArr){
		shortArr[key]=shortArr[key].replace(/(\.jpg)|(\.jpeg)|(\.png)/ig,"");
		shortArr[key] = stringLengthCn(shortArr[key]) >24 ? shortArr[key].substr(0,24)+"...":shortArr[key];
	}
	if($(".banner img").length >= 2){
		!function(){
			var str ="";
			for (var i in shortArr){
				str += '<a href="#" title="'+arr[i]+'">'+shortArr[i]+'</a>';	
			}
			$(".fixedFoot .inner").append(str);
			$(".fixedFoot .inner a:first").addClass("selected");
			$(".fixedFoot .inner a").on("click", function(){
				if($(this).hasClass("selected")) return;
				$(this).siblings().removeClass("selected");
				$(this).addClass("selected");
				var n = $(".fixedFoot .inner a").index($(this));
				$(".banner .im").hide().eq(n).removeClass("disable").fadeIn();
			})
		}()
	}
});
</script>
</body>
</html>