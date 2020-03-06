<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无限分类</title>

<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
var parentId=0;
$(function(){
		   parentId=document.getElementById("default").value;
		   });
function popMenu(e) {
	//tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',0,true,function(e) {
	var url=document.getElementById('Controller').value;
	tMenu(e,url,parentId,true,function(e) {
		//var arr = explode("||",e.text);
		//$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		//$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
	});
}
{/literal}
</script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>
<body>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='MoveNodeSave'}" method="post">
<input name="Controller" id="Controller" type="hidden" value="{url controller=$smarty.get.controller action='tmismenu'}">
<fieldset>     
<legend>节点移动</legend>
<div align="center">
<table>
<tr>
  <td colspan="4">当前信息：{$aRow.wareName} {$aRow.guige}</td>
</tr>
<tr>
  <td colspan="4">当前位置：{$path_info}</td></tr>
<tr>
  <td>目标位置：</td>
  <td colspan="3"><input name="targetId" type="text" id="targetId"  onClick="popMenu(this)"></td>
  </tr>

<tr><td colspan="4"><input type="submit" name="Submit" value="提交">
  <input name="sourceId" type="hidden" id="sourceId" value="{$aRow.id}">
  <input name="default" type="hidden" id="default" value="{$smarty.get.default}">
  </td></tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>