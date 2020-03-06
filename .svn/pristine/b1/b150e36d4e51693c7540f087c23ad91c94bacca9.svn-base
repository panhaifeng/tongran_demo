<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',0,false,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = '品名:'+(arr[0]?arr[0]:'&nbsp;');
		$('#spanGuige')[0].innerHTML = '规格:'+(arr[1]?arr[1]:'&nbsp;');
	});
}
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='savePandian'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>{$title}</legend>
<div align="center">  
<table width="100%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td width="24%" height="33">盘点日期：</td>
    <td width="76%"><input name="datePandian" type="text" id="datePandian" value="{$aRow.datePandian|default:$smarty.get.datePandian}" readonly="readonly"/></td>
    </tr>
  <tr>
    <td height="35">品名：</td>
    <td>{$aRow.Ware.wareName}
      <input name="wareId" type="hidden" id="wareId" value="{$aRow.wareId|default:$smarty.get.wareId}"></td>
    </tr>
  <tr>
    <td height="34">盘点数量：</td>
    <td><input name="cnt" type="text" id="cnt" value="{$aRow.cnt}" /></td>
  </tr>
  <tr>
    <td height="34">盘点金额：</td>
    <td><input name="money" type="text" id="money" value="{$aRow.money}" /></td>
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
