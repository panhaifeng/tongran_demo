<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>应收款初始化</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>应收款初始化</legend>
<div align="center">  
<table width="100%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td width="24%" height="33">初始化日期：</td>
    <td width="76%"><input name="initDate" type="text" id="initDate" value="{$aRow.initDate|default:'2007-11-01'}" onClick="calendar()"/></td>
    </tr>
  <tr>
    <td height="35">客户：</td>
    <td>{webcontrol type='ClientSelect' selected=$aRow.Client}</td>
    
    </tr>
  <tr>
    <td height="34">金额：</td>
    <td><input name="initMoney" type="text" id="initMoney" value="{$aRow.initMoney}" /></td>
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
