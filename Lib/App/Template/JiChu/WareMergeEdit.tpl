<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无限分类</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
var parentId=0;
$(function(){
		   parentId=document.getElementById("default").value;
		   });
function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',parentId,false);
}
</script>
{/literal}
</head>
<body>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SaveMergeNode'}" method="post">
<fieldset>     
<legend>合并物品</legend>
<div align="center">
<input type="hidden" name="wareId" value="{$aWare.wareId}">
<input name="default" type="hidden" id="default" value="{$smarty.get.default}">
<table>
<tr>
<td>当前物品</td>
<td><input name="from" type="text" readonly value="{$aWare.wareName}"></td>
<tr></tr>
<tr>
<td>合并至</td>
<td><input name="to" type="text" onClick="popMenu(this)"></td>
</tr>
<tr><td><input name="submit1" type="submit" value="提交"></td><td><input name="button1" type="button" onClick="history.go(-1)" value="返回"></td></tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>