<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>详细信息</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<fieldset>     
<legend>详细信息</legend>
<div align="center">
<table>
  <tr>
    <td colspan="4" align="center" style="font-size:18px; font-weight:bold">{$aRow.title}</td>
  </tr>
  
  <tr>
    <td colspan="4" align="center">发布者：{$aRow.sendRealName}      发布时间: {$aRow.sendDate}</td>
  </tr>
  
  
  <tr>
    <td colspan="4" align="center">{$aRow.content}</td>
  </tr>
  
</table>
</div>
<div align="center" style="clear:both; width:100%"><input type="button" onClick="javascript:history.back(1);" value="返回"></div>
</fieldset>
</form>
</body>
</html>
