<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title|default:"密码修改"}</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/TableEdit.css" type="text/css" rel="stylesheet">
<script language="javascript">
{literal}
function myCheck(objForm) {
	var p=document.getElementById('passwd').value;
	var u = document.getElementById('userName').value;
	if (document.getElementById('passwd').value!=document.getElementById('PasswdConfirm').value) {
		alert("密码不匹配!");
		return false;
	}
	if (document.getElementById('passwd').value.length<7 || document.getElementById('passwd').value.length>40) {
		alert("密码长度必须7位以上，40位以下!");
		return false;
	}
	if (document.getElementById('passwd').value.indexOf(document.getElementById('userName').value)>-1) {
		alert("密码中不能包含用户名!");
		return false;
	}
	for (var i=0;i<u.length-1;i++) {
		if(p.indexOf(u.substr(i,2))>-1) {
			alert("密码不能包含用户名中超过两个连续字符的部分!");
			return false;
		}
	}
	var reg1 = new RegExp('\\d+','i');
	var reg2 = new RegExp('[a-z]+');
	var reg3 = new RegExp('[A-Z]+');
	var reg4 = new RegExp('[!@#$%^&*()_]+','i');
	var t=0;
	//alert(reg.toString());
	//alert(reg.test(p));return false;
	if(reg1.test(p)) t++;
	if(reg2.test(p)) t++;
	if(reg3.test(p)) t++;
	if(reg4.test(p)) t++;	
	if(t<3) {
		alert('密码必须包含以下四类中至少三类字符：英文大写字母（A到Z）、英文小写字母（a到z）、10个基本数字（0到9）、非字母字符（例如 !、$、#、%）');
		return false;
	}
	return true;
}
{/literal}
</script>
</head>

<body>
{include file="_ContentNav.tpl"}
<div align="center">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChangePwd'}" method="post" onSubmit="return myCheck(this)">
<div align="center">
<input name="id" type="hidden" id="id" value="{$aUser.id}" />
<fieldset style="border:0px;">     
<legend class="style1"></legend>
<table id='table_moreinfo' class="tableHaveBorder" style="width:300px;">
  <tr>
    <td align="right" class="tdTitle">用户名：</td>
    <td><input name="userName" type="text" id="userName" value="{$aUser.userName}" disabled="disabled" style="width:150px"/></td>
    </tr>
  <tr>
    <td align="right" class="tdTitle">登记密码：</td>
    <td><input name="passwd" type="password" id="passwd" value="{$aUser.passwd}" check="^\S+$" warning="密码不能为空！" style="width:150px"/></td>
  </tr>
  <tr>
    <td align="right" class="tdTitle">密码确认：</td>
    <td><input name="PasswdConfirm" type="password" id="PasswdConfirm" value="{$aUser.passwd}" check="^\S+$" warning="重复密码不能为空！" style="width:150px"/></td>
  </tr>
  
</table>
</fieldset>
</div>

<div id="footButton">
	<input type="submit" id="Submit" name="Submit" value='保  存'>
</div>

</form></div>
</body>
</html>
