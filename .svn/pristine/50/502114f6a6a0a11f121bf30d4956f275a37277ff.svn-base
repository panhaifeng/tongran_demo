<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>{$title}</legend>
<div align="center">
<table width="50%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td width="13%" height="33">类别名称：</td>
    <td width="38%">
      <input name="kindName" type="text" id="carCode" value="{$aVat.kindName}" check="^(\s|\S)+$" warning="类别名称不能为空!"/></td>
    </tr>  
  <tr>
    <td height="35">备注：</td>
    <td><input name="memo" type="text" id="memo" value="{$aVat.memo}"/></td>
  </tr>
  <tr>
    <td height="45" colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aVat.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
