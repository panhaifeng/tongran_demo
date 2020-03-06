<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>员工信息编辑</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveFanxiu'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>返修信息编辑</legend>
<div align="center">
<table width="90%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td align="right">登记日期：</td>
    <td><input name="dateFanxiu" type="text" id="dateFanxiu" value="{$aRow.dateFanxiu|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"></td>
  </tr>
  <tr>
    <td align="right">生产总数量：</td>
    <td><input name="cntTotal" type="text" id="cntTotal" value="{$aRow.cntTotal}"/>
      kg</td>
  </tr>
  <tr>
    <td align="right">工艺原因返修数：</td>
    <td><input name="cntByGongyi" type="text" id="cntByGongyi3" value="{$aRow.cntByGongyi}"/>
      kg</td>
  </tr>
  <tr>
    <td align="right">染色原因返修数：</td>
    <td><input name="cntByRanse" type="text" id="cntByRanse" value="{$aRow.cntByRanse}"/>
    kg</td>
  </tr>
  <tr>
    <td align="right" valign="top">反修说明：</td>
    <td><textarea name="memo" id="memo" cols="45" rows="5">{$aRow.memo}</textarea></td>
    </tr>
  <tr>
    <td colspan="2" align="center">
      <input name="id" type="hidden" id="id" value="{$smarty.get.id}" />
      <input type="submit" name="Submit" value="提交"></td>
  </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
