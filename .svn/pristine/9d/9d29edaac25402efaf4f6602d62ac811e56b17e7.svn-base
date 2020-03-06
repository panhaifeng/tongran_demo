<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="Resource/Css/Edit.css"/>
<title>无标题文档</title>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" >
<fieldset>     
<legend>数据库维护</legend>
<div align="center">
<table>
  <tr>
    <td>SQL语句：</td>
    <td style="text-align:left;"><textarea name="sql" cols="80" rows="10" style="height:auto"></textarea></td>
  </tr>
  <tr>
    <td height="25">备注：</td>
    <td style="text-align:left"><input name="memo" type="text" />
      (多条SQL语句，分号隔开“;”)</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<input type="submit" name="Submit" value="确认执行" onclick="return confirm('确认执行吗？')">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{url controller=$smarty.get.controller action='right1'}">历史记录</a></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
