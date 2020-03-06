<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>复制打印所要信息</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css">
{literal}

<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
var obj = {/literal}{$row|@json_encode}{literal};
$(function(){

});
function copyUrl2()  
{  
  var Url2=document.getElementById("biao1");  
  Url2.select(); // 选择对象  
  document.execCommand("Copy"); // 执行浏览器复制命令  
  alert("已复制好，可贴粘。");  
}  
</script>
{/literal}
</head>
<body>
<div style="text-align: center;">
	<textarea cols="20" rows="10" id="biao1" style="width: 65%;">{$arr_field_value.text}</textarea>
	<br>
	<input type="button" onClick="copyUrl2()" value="点击复制内容" />  
</div>


</body></html>
