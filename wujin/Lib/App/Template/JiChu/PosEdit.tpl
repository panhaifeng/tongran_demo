<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>库存位置编辑</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post">

<fieldset>     
<legend>库存位置编辑</legend>
<div align="center">
<table>
  <tr>
    <td>库存位置：</td>
    <td><input name="posName" type="text" id="posName" value="{$aPos.posName}" check="^\S+$" warning="部门名称不能为空！"/></td>
    </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aPos.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
