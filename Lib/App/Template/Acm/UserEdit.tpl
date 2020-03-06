<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
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
<legend>用户信息编辑</legend>
<div align="center">
<table>
  <tr>
    <td>用户名：</td>
    <td><input name="userName" type="text" id="userName" value="{$aUser.userName}" check="^\S+$" warning="用户名不能为空！"/></td>
    </tr>
  <tr>
    <td>真实姓名：</td>
    <td><input name="realName" type="text" id="realName" value="{$aUser.realName}" check="^\S+$" warning="真实姓名不能为空！"/></td>
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
    <td>属于角色：</td>
    <td><select name="roles[]" size="5" id="roles[]" multiple="multiple">
		{webcontrol type='TmisOptions' model='Acm_Role' selected=$aUser.roles}
    </select>
    </td>
  </tr>
  <tr>
    <td>是否老板角色</td>
    <td>
      <select name="isBoss" id="isBoss">
          <option value="0" {if $aUser.isBoss==0}selected{/if}>否</option>
          <option value="1" {if $aUser.isBoss==1}selected{/if}>是</option>
      </select><font style="color: red;">（开启后首页会显示老板驾驶舱）</font>
    </td>
  </tr>
  <tr>
    <td>对应处方人：</td>
    <td><select name="employId" id="employId">
				  {webcontrol type='TmisOptions' model='JiChu_Employ' selected=$aUser.employId condition='depId=13'}
		  </select></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aUser.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
