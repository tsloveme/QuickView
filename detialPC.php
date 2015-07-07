<?php
if(!isset($_REQUEST['projectName']) || empty($_REQUEST['projectName'])){
    echo '无效参数';
    exit;
}
$projectNameOrigin = $_REQUEST['projectName'];
preg_match ('/\d{6}[a-z]*_(.*)_\d{6}/',$projectNameOrigin,$shortName);
$shortName = $shortName[1];
$confirm = $_REQUEST['confirm'];
$dirType = $confirm == '1' ? 'confirm' : 'test';
$absDirUtf8 = 'upload/'.$dirType.'/'.$projectNameOrigin.'/';
$projectName = iconv('utf-8','gbk', $projectNameOrigin);
$absDir = 'upload/'.$dirType.'/'.$projectName.'/';
if(!is_dir($absDir)){
    echo '无效参数';
    exit;
}
	//获取文件扩展名
	function get_file_type($filename){ 
		$type = pathinfo($filename); 
		$type = strtolower($type["extension"]); 
		return $type; 
	}	
	$dir = getcwd();
    $dir = $dir.'\\upload\\'.$dirType.'\\'.$projectName;
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
        $pageTitle = $shortName."-效果图预览";
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
body{padding-top:40px;}
/*初始化*/
.banner{width:100%; overflow:hidden; position:relative; padding-bottom:25px;cursor: url(http://webmap0.map.bdstatic.com/image/api/openhand.cur) 8 8, default;}
.banner .im{width:1px; position:relative; margin:0 auto;}
.banner .disable{visibility:hidden; position:absolute; left:0; top:0;}
.banner .im img{position:absolute; top:auto; left:-960px; display:block; vertical-align:top;}
.main{width:1000px; margin:0 auto;}
.fixedHeader{width:100%;position:fixed; left:0; top:0; background-color:black; background-color:rgba(0,0,0,0.8); text-align:center; z-index:100;}
.fixedHeader .inner{padding:1px;}
.fixedHeader a{display:inline-block; font-weight:bold; margin:3px; padding:6px 4px; line-height:1; border:1px dotted #e0e0e0;border-radius:3px;font-size:12px; color:#e0e0e0; text-decoration:none}
.fixedHeader a:link{color:#e0e0e0;}
.fixedHeader a:hover{border-style:dotted; text-decoration:none;}
.fixedHeader a.selected{border:1px solid #e0e0e0; background-color:#e0e0e0; color:#333;}
.fixedHeader a.selected:hover{border-style:solid;}
.btnWrap{width:120px; position:fixed; height:100%; z-index:99;left:0; top:0;}
.WR{left:auto; right:0;}
.btnWrap:hover{background-color:rgba(255,255,255,0.15);-webkit-background-color:rgba(255,255,255,0.15);}
.btn_prev,.btn_next{position:absolute; display:none; z-index:99; right:25px; top:45%;width:72px; height:72px; background:url(public/btn_prev.png) no-repeat; cursor:pointer; opacity:0.45;filter:alpha(opacity=45);}
.btn_prev:hover,.btn_next:hover{opacity:0.85; filter:alpha(opacity=85);}
.btn_next{right:auto; left:25px; background:url(public/btn_next.png) no-repeat;}
.btnWrap:hover .btn_prev,.btnWrap:hover .btn_next{display:block;}
.btnWrap a:focus{outline:0;}
.drag{width:100%; height:100%; position:fixed; left:0; top:0; cursor: url(http://webmap0.map.bdstatic.com/image/api/openhand.cur) 8 8, default;}
</style>
<script>
function adaptHeight(obj){
	obj.parentNode.style.height=obj.clientHeight+"px";
	obj.style.left=-(obj.width)/2 +"px";
}
</script>
</head>
<body>
<div class="banner">
<?php
	if (isset($imgArr)&&!empty($imgArr)){
		foreach($imgArr as $key => $value){
			if($key == 0){
				echo '<div class="im"><img src="'.$absDirUtf8.$value.'" onload="adaptHeight(this)" /></div>';
			}
			else{
				echo '<div class="im disable"><img src="'.$absDirUtf8.$value.'" onload="adaptHeight(this)" /></div>';
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
<!--<div class="fixedHeader">
	<div class="inner">
    	<a href="#" class="selected">（维也纳智好酒店）网页设计图</a>
    	<a href="#">1（维纳斯皇家酒店）网页设计图</a>
    	<a href="#">1b网页图（集团介绍）</a>
    </div>
</div>-->
<script language="javascript" type="text/javascript" src="public/jquery-1.8.3.min.js"></script>
<script language="javascript" type="text/javascript" src="public/jquery.event.drag-2.2.js"></script>

<script language="javascript" type="text/javascript">
$(function(){
	//拖动滚屏
	$('.banner').live('drag', function( ev, dd ){
		$(document).scrollTop($(document).scrollTop() - (dd.offsetY));
	});
	//图片标题收集，过长图片名简称提取;
	var banner = document.getElementsByClassName("banner")[0];
	var imgs = banner.getElementsByTagName("img");
	var imgLength = imgs.length;
	var arr = new Array();
	for(var i=0;i<imgLength;i++){
        var imgName = imgs[i].getAttribute("src").match(/([^\/]+$)/)[1];
		arr.push(imgName);
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
	//导航按钮生成
	if($(".banner img").length >= 2){
		!function(){
			var btnStr = '<div class="btnWrap"><a href="#" class="btn_prev"></a></div><div class="btnWrap WR"><a href="#" class="btn_next"></a></div>'
            $('body').append('<div class="fixedHeader">\
                                <div class="inner">\
                                </div>\
                             </div>');
            $('body').append(btnStr);
			var str ="";
			for (var i in shortArr){
				str += '<a href="#" title="'+arr[i]+'">'+shortArr[i]+'</a>';	
			}

			$(".fixedHeader .inner").append(str);
			$(".fixedHeader .inner a:first").addClass("selected");
			$(".fixedHeader .inner a").on("click", function(){
				if($(this).hasClass("selected")) return;
				$(this).siblings().removeClass("selected");
				$(this).addClass("selected");
				var n = $(".fixedHeader .inner a").index($(this));
				$(".banner .im").hide().eq(n).removeClass("disable").fadeIn();
			});
			//下一页按钮
			$('.btnWrap .btn_next').on('click', function(){
				var next = $('.fixedHeader .selected').next();
				next = next.length ? next : $('.fixedHeader a').eq(0);
				next.click();
			});
			//上一页按钮
			$('.btnWrap .btn_prev').on('click', function(){
				var prev = $('.fixedHeader .selected').prev();
				prev = prev.length ? prev :  $('.fixedHeader a').eq(-1);
				prev.click();
			});
		}()
	}
});
</script>
</body>
</html>