<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>效果图上传预览</title>
<link rel="stylesheet" type="text/css" href="public/basic.css" />
<link rel="stylesheet" type="text/css" href="public/dropzone.css" />
<script language="javascript" type="text/javascript" src="public/jquery-1.8.3.min.js"></script>
<script language="javascript" type="text/javascript" src="public/dropzone.js"></script>
<script>Dropzone.options.autoDiscover = false;</script>
<style type="text/css">
    input,body{font-size:16px; font-family: "Microsoft YaHei", Arial, Helvetica, sans-serif;}
    .dropzone.dz-clickable{border: 2px #999 dashed;}
    .dropzone.dz-clickable:hover{opacity: 0.65}
    .dropzone .dz-preview .dz-image { border-radius: 8px; display: block; width: 320px; height:480px; z-index: 10; }
    .dropzone .dz-preview{width: 320px;}
    .btnSubmit{border-radius: 3px; border: 1px #0266c4 solid; background-color:#017bed ;color:white; font-size: 16px; min-width: 100px; height: 31px;}
    table{border-collapse: collapse;}
    td{border:1px #e0e0e0 solid;}
    input[type="text"].txt{height:20px; line-height: 20px; padding: 3px; width: 240px;}
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
            <td> <input id="projectName" type="text" value="" class="txt" placeholder="请输入项目名，可输入中文" autocomplete="off" ></td>
        </tr>
        <tr>
            <td align="right">类 型：</td>
            <td><input style="margin-left: -2px;" name="type" form="form"  type="radio" value="pc" autocomplete="off" /><label style="margin-right: 25px;">PC端网页效果图</label>
                <input name="type" form="form" type="radio" value="mobile" autocomplete="off" /><label>移动端效果图(APP/微信/WAP)</label></td>
        </tr>
        <tr>
            <td></td>
            <td><input class="btnSubmit" type="submit" value="确认上传" /></td>
        </tr>
    </table>
    <br/>

</div>
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
		var timestamp = date.getTime();
		var type = $('#type_hidden').val();
		$('#folder').val(y + m + d + type + '_' + $("#projectName_hidden").val() + '_' + timestamp);
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
        dictDefaultMessage: "支持拖拽上传！",
        thumbnailWidth:320,
        thumbnailHeight:480,
        success:function(data){
            console.log('success!');
            console.log(data);
        },
        complete:function(data){
            console.log('complete!');
            console.log(data);
        }

    });
    $(".btnSubmit").click(function(){
        var flag = true;
        flag = flag && $.trim($("#projectName").val());
        flag = flag && ($('input[name="type"]').eq(0).is(':checked')||$('input[name="type"]').eq(1).is(':checked'));
        if (flag){
			$('#projectName,input[name="type"]').attr('disabled','disabled');
			makeFolder();
            console.log('ok');
            myDropzone.processQueue();
        }
    });
</script>

</body>
</html>
