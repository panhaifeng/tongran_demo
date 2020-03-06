<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Script/CheckForm.js"></script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>
  <legend>
  <h3>角色信息编辑</h3>
  </legend>
<table width="100%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td>角色：</td>
    <td><input name="roleName" type="text" id="roleName" value="{$aRole.roleName}" check="^\S+$" warning="部门名称不能为空！"/></td>
    </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aRole.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</fieldset>
</form>
</body>
</html>
