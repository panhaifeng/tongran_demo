<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>针织牛仔</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" for="document" event="onkeydown">
<!--
  if(event.srcElement.type!='textarea'&&event.keyCode==13 && event.srcElement.type!='button' && event.srcElement.type!='submit' && event.srcElement.type!='reset' && event.srcElement.type!='') event.keyCode=9;
-->
</script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>针织牛仔应收款登记</legend>
<div align="center">  
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" height="33">日期：
      <input name="dateRecord" type="text" id="dateRecord" value="{$aRow.dateRecord|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"/></td>
    <td>业务员：
      <select name="standby1" id="standby1">
      {webcontrol type='Tmisoptions' model='JiChu_Employ' condition='depId=11' selected=$aRow.standby1}
      </select>      </td>
    </tr>
  <tr>
    <td height="33">客户：{webcontrol type='ClientSelect' selected=$aRow.Client}</td>
    <td>类型：
      <select name="arTypeId" id="arTypeId">        
    {webcontrol type='Tmisoptions' model='CaiWu_ArType' condition='id in(4,5,6,7,8)' selected=4}
      </select>      </td>
  </tr>
  <tr>
    <td height="33">金额：
      <input name="cnt" type="text" id="cnt" warning='金额格式错误!' check='^\d+(\.\d+)?$' value={$aRow.cnt} ></td>
    <td>公斤数：
      <input name="standby2" type="text" id="standby2" value="{$aRow.standby2}" size="10">
      &nbsp;&nbsp;米数：
      <input name="standby3" type="text" id="standby3" value="{$aRow.standby3}" size="10"></td>
  </tr>
  <tr>
    <td height="33" colspan="2">备注：
      <label>
      <input name="memo" type="text" id="memo" value="{$aRow.memo}" size="30">
      </label></td>
    </tr>
  
  <tr>
    <td height="45" colspan="2" align="center"><input name="id" type="hidden" id="id" value="{$aRow.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
