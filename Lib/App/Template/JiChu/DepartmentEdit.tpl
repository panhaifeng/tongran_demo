<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>部门信息编辑</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>部门信息编辑</legend>
<div align="center">
<table>
  <tr>
    <td>部门：</td>
    <td><input name="depName" type="text" id="depName" value="{$aDep.depName}" check="^\S+$" warning="部门名称不能为空！"/></td>
    </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="{$pk}" type="hidden" id="{$pk}" value="{$aDep.$pk}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
