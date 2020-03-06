<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveStCar'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
<legend>分配松筒车台</legend>
<div align="center">
<table>
  <tr>
    <td>缸号：</td>
    <td>{$aRow.vatNum}</td>
    </tr>
  <tr>
    <td>分配车台：</td>
    <td><select name="Car[]" size="10" id="Car[]" multiple="multiple">
		{webcontrol type='TmisOptions' model='JiChu_StCar' selected=$aRow.Car}
    </select>    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aRow.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
