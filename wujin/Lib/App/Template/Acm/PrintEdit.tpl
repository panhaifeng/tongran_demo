<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
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
<fieldset>     
<legend>{$title}</legend>
<div align="center">
<p>1.打印前<a href="install_lodop.exe">点击此处</a>,下载安装控件 </p><p>2.下载完，双击控件进行安装。</p><p>3.安装完毕后即可进行正常的打印。</p>
</div>
</fieldset>
</body>
</html>
