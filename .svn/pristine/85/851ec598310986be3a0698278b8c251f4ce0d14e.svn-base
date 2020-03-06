<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>颜色自动完成</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>颜色自动完成设置</legend>
<div align="center">
<table>
  <tr>
    <td align="center">颜色：</td>
    <td align="center"><input name="color" type="text" id="color" value="{$aRow.color}"/></td>
    </tr>
  <tr>
    <td align="center">助记码：</td>
    <td align="center"><input name="memoCode" type="text" id="memoCode" value="{$aRow.memoCode}"/></td>
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
