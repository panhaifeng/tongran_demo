<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>员工信息编辑</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='BinggangSave'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>并缸信息编辑</legend>
<div align="center">
<table width="90%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td align="right">染色计划日期：</td>
    <td><input name="dateAssign" type="text" id="dateAssign" value="{$aRow.dateAssign|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"></td>
  </tr>
  <tr>
    <td align="right">物理缸号：</td>
    <td><select name="vatId" id="vatId">
      {webcontrol type='TmisOptions' model='Jichu_Vat' selected=$aRow.vatId}
      </select></td>
  </tr>
  <tr>
    <td align="right">班次：</td>
    <td><select name="ranseBanci" id="ranseBanci">
        <option value="1" {if $aRow.ranseBanci==1}selected{/if}>早班</option>
        <option value="3" {if $aRow.ranseBanci==3}selected{/if}>早班1</option>
        <option value="4" {if $aRow.ranseBanci==4}selected{/if}>早班2</option>
        <option value="5" {if $aRow.ranseBanci==5}selected{/if}>早班3</option>
        <option value="2" {if $aRow.ranseBanci==2}selected{/if}>晚班</option>
        <option value="6" {if $aRow.ranseBanci==6}selected{/if}>晚班1</option>
        <option value="7" {if $aRow.ranseBanci==7}selected{/if}>晚班2</option>
        <option value="8" {if $aRow.ranseBanci==8}selected{/if}>晚班3</option>
        </select></td>
  </tr>
  <tr>
    <td align="right">是否加急：</td>
    <td><input name="isJiaji" type="checkbox" id="isJiaji" value="1" {if $aRow.isJiaji==1}checked{/if} style="border:0px;"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input name="id" type="hidden" id="id" value="{$aRow.id}" />
      <input type="submit" name="Submit" value="提交"></td>
  </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
