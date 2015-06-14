<?php
session_start();
if(!isset($_SESSION['username']) || $_SESSION['username']!='admin'){
	$url = $_SERVER['PHP_SELF'];
	header('Location:login.php?from='.$url);
    exit();
}
var_dump($_SESSION);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>效果图上传预览</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="renderer" content="webkit">
<link rel="stylesheet" type="text/css" href="public/basic.css" />
<link rel="stylesheet" type="text/css" href="public/dropzone.css" />
<script language="javascript" type="text/javascript" src="public/jquery-1.8.3.min.js"></script>
<script language="javascript" type="text/javascript" src="public/dropzone.js"></script>
<script>Dropzone.options.autoDiscover = false;</script>
<style type="text/css">
    input,body{font-size:16px; font-family: "Microsoft YaHei", Arial, Helvetica, sans-serif;}
    .dropzone.dz-clickable{border: 2px #999 dashed;}
    .dropzone.dz-clickable:hover{opacity: 0.65}
    .dropzone .dz-preview .dz-image { border-radius: 8px; display: block; width: 240px; height:400px; z-index: 10; }
    .dropzone .dz-preview{width: 240px;}
    .btnSubmit{border-radius: 3px; border: 1px #0266c4 solid; background-color:#017bed ;color:white; font-size: 16px; min-width: 100px; height: 31px;}
    table{border-collapse: collapse;}
    td{border:1px #e0e0e0 solid;}
    input[type="text"].txt{height:20px; line-height: 20px; padding: 3px; width: 320px;}
	#logout{position:fixed; right:5px;bottom:5px; text-align:right;}
</style>
</head>
<body>
<form action="upload.php" class="dropzone" id="my-awesome-dropzone" name="form" enctype='multipart/form-data'>
    <input type="hidden" id="projectName_hidden" name="name" value=""/>
    <input type="hidden" id="type_hidden" name="webtype" value=""/>
	<input type="hidden" id="folder" name="folder" value="" />
</form>
<div style="margin:12px auto 0 auto; width: 320px padding: 10px;">
    <table cellspacing="5" cellpadding="8" width="100%">
        <tr>
            <td align="right">项目名：</td>
            <td> <input id="projectName" type="text" value="" class="txt" placeholder="请输入项目名(写个中文名吧方便理解)" autocomplete="off" ></td>
        </tr>
        <tr>
            <td align="right">类 型：</td>
            <td><input style="margin-left: -2px;" name="type" form="form"  type="radio" value="pc" autocomplete="off" /><label style="margin-right: 25px;">PC端网页效果图</label>
                <input name="type" form="form" type="radio" value="mobile" autocomplete="off" /><label>移动端效果图(APP/微信/WAP)</label></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="btnSubmit" type="submit" value="确认上传"  autocomplete="off" />
            <a href="list.php" target="_blank" >查看已上传项目</a>
            </td>
        </tr>
    </table>
    <br/>
</div>
<a id="newLink" href="" target="_blank" style="visibility: hidden">link to new object</a>
<script>
	/*
	*目录生成函数
	*年月日 + 项目名 + timestamp;
	*
	*/
	function makeFolder(){
		var date = new Date;
		var y = (date.getFullYear() + '').substring(2);
		//y = y < 10 ? '0'+y : y;
		var m = date.getMonth()+1;
		m = m < 10 ? '0'+m : m;
		var d = date.getDate();
		d = d < 10 ? '0'+d : d;
		var h = date.getHours();
		h = h < 10 ? '0'+h : h;
		var min = date.getMinutes();
		min = min < 10 ? '0'+min : min;
		var s = date.getSeconds();
		s = s < 10 ? '0'+s : s;
		var type = $('#type_hidden').val();
		var timestamp = date.getTime();		
		//$('#folder').val(y + m + d + type + '_' + $("#projectName_hidden").val() + '_' + timestamp);
		$('#folder').val(y + m + d + type + '_' + $("#projectName_hidden").val() + '_' + h + min + s);
	}
    $("#projectName").blur(function(){
        $("#projectName_hidden").val($.trim($(this).val()));
    });
    $('input[name="type"]').click(function(){
        if($(this).is(":checked")){
            $("#type_hidden").val($(this).val());
        }
    });
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("#my-awesome-dropzone", {
        // url: "/file/post"
        url:'upload.php',
        parallelUploads:1,
        autoProcessQueue:false,
//        drop:function(){
//            if(is_check){
//                myDropzone.processQueue()
//            }
//            else{
//                console.log("未验证");
//            }
//
//        },
        dictDefaultMessage: "支持多个图片拖拽上传！APP建议:640, PC建议:1920",
        thumbnailWidth:240,
        thumbnailHeight:400,
        success:function(data){
           // console.log('success!');
            //console.log(data);

        },
        complete:function(data){
            console.log('complete!');
            //console.log(data);
            myDropzone.processQueue();
        },
        queuecomplete: function(){
            console.log("queuecomplete!");
            //触发新项目链接
            $('#newLink').click();

        }
    });
    $(".btnSubmit").click(function(){
        var flag = true;
        flag = flag && $.trim($("#projectName").val());
        if(!flag){
            alert('项目名必填！');
            return;
        }
        flag = flag && ($('input[name="type"]').eq(0).is(':checked')||$('input[name="type"]').eq(1).is(':checked'));
        if(!flag){
            alert('项目类型必选！');
            return;
        }
        if (flag){
			$('#projectName,input[name="type"]').attr('disabled','disabled');
            $(this).attr('disabled','disabled');
			makeFolder();
            console.log('ok');
            myDropzone.processQueue();
        }
        //添加新项目链接
        var url = window.location.href;
        url = url.replace(/[^\/]*$/,'');
        url += 'upload/';
        url += $('#folder').val();
        url = encodeURI(url);
        $('#newLink').attr('href',url);
    });
</script>
<?php 
if(isset($_SESSION['username'])){
?>
<div id="logout">
<span><?php echo $_SESSION['username']; ?>,你好! </span>
<a href="login.php?logout=1">注销</a>
</div>

<?php
}
?>
</body>
</html>
