<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>密码修改</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript">
{literal}
function myCheck(objForm) {
	if (objForm.passwd.value!=objForm.PasswdConfirm.value) {
		alert("密码不匹配!");
		return false;
	}
	return CheckForm(objForm);
}
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
<legend>密码修改</legend>
<div align="center">
<table>
  <tr>
    <td>用户名：</td>
    <td><input name="userName" type="text" id="userName" value="{$aUser.userName}" disabled="disabled"/></td>
    </tr>
  <tr>
    <td>密码：</td>
    <td><input name="passwd" type="password" id="passwd" value="{$aUser.passwd}" check="^\S+$" warning="密码不能为空！"/></td>
  </tr>
  <tr>
    <td>密码确认：</td>
    <td><input name="PasswdConfirm" type="password" id="PasswdConfirm" value="{$aUser.passwd}" check="^\S+$" warning="重复密码不能为空！"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aUser.id}" />
	<input type="submit" name="Submit" value="确认修改"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
