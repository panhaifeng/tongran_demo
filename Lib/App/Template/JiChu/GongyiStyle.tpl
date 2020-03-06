<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript">
function popMenu(obj) {
	tMenu(obj,'Index.php?controller=JiChu_Ware&action=tmismenu',5,false,function(e) {
		var arr = explode("||",e.text);
	});
}
</script>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveindex'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>工艺录入</legend>
<div align="center">
<table width="50%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td height="33">分类：</td>
    <td><select name="kind" id="kind">
      <option value=''>选择分类</option>
      <option value='前处理' {if $aRow.kind=='前处理'}selected{/if}>前处理</option>
      <option value='后处理' {if $aRow.kind=='后处理'}selected{/if}>后处理</option>
      <option value='染色助剂' {if $aRow.kind=='染色助剂'}selected{/if}>染色助剂</option>
      <option value='染色染料' {if $aRow.kind=='染色染料'}selected{/if}>染色染料</option>
    </select></td>
  </tr>
  <tr>
    <td width="13%" height="33">名称：</td>
    <td width="38%">
      <input name="gongyiName" type="text" id="carCode" value="{$aRow.gongyiName}" check="^(\s|\S)+$" warning="名称不能为空!" /></td>
    </tr>  
  <tr>
    <td height="35">备注：</td>
    <td><input name="memo" type="text" id="memo" value="{$aRow.memo}"/></td>
  </tr>
  <tr>
    <td height="45" colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aRow.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
