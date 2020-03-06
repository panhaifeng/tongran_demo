<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>凭据录入</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>付款凭据录入</legend>
<div align="center">  
<table width="100%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td height="33">凭据类型：</td>
    <td><select name="type">  
    {webcontrol type='TmisOptions' inf='invoiceTypes' selected=$aRow.type}
    </select>
    </td>
  </tr>
  <tr>
    <td height="35">凭据编号：</td>
    <td><input name="invoiceNum" type="text" id="invoiceNum" value="{$aRow.invoiceNum}" warning='请输入单号,只能为数字!' check='^\d+$'/></td>
  </tr>
  <tr>
    <td width="16%" height="33">日期：</td>
    <td width="84%"><input name="dateInput" type="text" id="dateInput" value="{$aRow.dateInput|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"/></td>
    </tr>
  <tr>
    <td height="35">供应商：</td>
    <td>
    {webcontrol type='supplierSelect' selected=$aRow.supplierId}
   </td>
    </tr>
  <tr>
    <td height="34">金额：</td>
    <td><input name="money" type="text" id="money" value="{$aRow.money}" /></td>
    </tr>
  <tr>
    <td height="35">备注：</td>
    <td><input name="memo" type="text" id="memo" value="{$aRow.memo}" /></td>
    </tr>
  <tr>
    <td height="45" colspan="2" align="center">
	<input name="{$pk}" type="hidden" id="{$pk}" value="{$aRow.$pk}" />
	<input type="submit" name="Submit" value="确定">
	<!--<input type="submit" name="Submit" value="确定并抵冲入库单" id="Submit">-->
	<input type="button" name="button" id="button" value="取消" onClick="window.history.go(-1)"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
