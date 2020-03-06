<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body onLoad="document.getElementById('itemName').focus()">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>支出项目编辑</legend>
<div align="center">
<table>
  
  <tr>
    <td>项目名称：</td>
    <td><input name="itemName" type="text" id="itemName" value="{$aRow.itemName}" check="^\S+$" warning="部门名称不能为空！"/></td>
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
