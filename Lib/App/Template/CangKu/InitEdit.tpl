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
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>{$title}</legend>
<div align="center">  
<table width="100%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td width="24%" height="33">初始化日期：</td>
    <td width="76%"><input name="initDate" type="text" id="initDate" value="{$aRow.initDate|default:'2007-11-01'}" onClick="calendar()"/></td>
    </tr>
  <tr>
    <td height="35">选择货品：</td>
    <td><input name="wareId" type="text" id="wareId" onClick="popMenu(this)" value="{$aRow.wareId}" size="10" readonly>
      <span id='spanWareName'>品名：{$aRow.Ware.wareName}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="spanGuige">品名：{$aRow.Ware.guige}</span></td>
    </tr>
  <tr>
    <td height="34">初始数量：</td>
    <td><input name="cntInit" type="text" id="cntInit" value="{$aRow.cntInit}" /></td>
  </tr>
  <tr>
    <td height="34">初始金额：</td>
    <td><input name="moneyInit" type="text" id="moneyInit" value="{$aRow.moneyInit}" /></td>
    </tr>
  <tr>
    <td height="35">备注：</td>
    <td><input name="memo" type="text" id="memo" value="{$aRow.memo}" /></td>
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
