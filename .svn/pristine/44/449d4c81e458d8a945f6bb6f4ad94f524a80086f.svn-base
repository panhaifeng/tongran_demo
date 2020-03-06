<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>应收款初始化</title>
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
<legend>染色应收款登记</legend>
<div align="center">  
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="33">日期：
      <input name="dateRecord" type="text" id="dateRecord" value="{$aRow.dateRecord|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"/></td>
    <td>客户：{webcontrol type='ClientSelect' selected=$aRow.Client arType=1}</td>
    </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="2">
      <tr>
        <td align="center">纱支</td>
        <td align="center">计划单号</td>
        <td align="center">色号</td>
        <td align="center">色别</td>
        <td align="center">数量</td>
        <td align="center">单价</td>
        <td align="center">金额</td>
        <td align="center">备注</td>
        </tr>
      <tr>
        <td align="center"><input name="standby1[]" type="text" id="standby1[]" value="{$aRow.standby1}" size="6"></td>
        <td align="center"><input name="standby2[]" type="text" id="standby2[]" value="{$aRow.standby2}" size="6"></td>
        <td align="center"><input name="standby3[]" type="text" id="standby3[]" value="{$aRow.standby3}" size="6"></td>
        <td align="center"><input name="standby4[]" type="text" id="standby4[]" value="{$aRow.standby4}" size="6"></td>
        <td align="center"><input name="cnt[]" type="text" id="cnt[]" value="{$aRow.cnt}" size="6"></td>
        <td align="center"><input name="danjia[]" type="text" id="danjia[]" value="{$aRow.danjia}" size="6"></td>
        <td align="center"><span id="spanMoney">{$aRow.money}</span></td>
        <td align="center"><input name="memo[]" type="text" id="memo[]" value="{$aRow.memo}"></td>
      </tr>
      <tr>
        <td align="center"><input name="standby1[]" type="text" id="standby1[]" size="6"></td>
        <td align="center"><input name="standby2[]" type="text" id="standby2[]" size="6"></td>
        <td align="center"><input name="standby3[]" type="text" id="standby3[]" size="6"></td>
        <td align="center"><input name="standby4[]" type="text" id="standby4[]" size="6"></td>
        <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="6"></td>
        <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="6"></td>
        <td align="center"><span id="spanMoney"></span></td>
        <td align="center"><input type="text" name="memo[]" id="memo[]"></td>
      </tr>
      <tr>
        <td align="center"><input name="standby1[]" type="text" id="standby1[]" size="6"></td>
        <td align="center"><input name="standby2[]" type="text" id="standby2[]" size="6"></td>
        <td align="center"><input name="standby3[]" type="text" id="standby3[]" size="6"></td>
        <td align="center"><input name="standby4[]" type="text" id="standby4[]" size="6"></td>
        <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="6"></td>
        <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="6"></td>
        <td align="center"><span id="spanMoney"></span></td>
        <td align="center"><input type="text" name="memo[]" id="memo[]"></td>
      </tr>
      <tr>
        <td align="center"><input name="standby1[]" type="text" id="standby1[]" size="6"></td>
        <td align="center"><input name="standby2[]" type="text" id="standby2[]" size="6"></td>
        <td align="center"><input name="standby3[]" type="text" id="standby3[]" size="6"></td>
        <td align="center"><input name="standby4[]" type="text" id="standby4[]" size="6"></td>
        <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="6"></td>
        <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="6"></td>
        <td align="center"><span id="spanMoney"></span></td>
        <td align="center"><input type="text" name="memo[]" id="memo[]"></td>
      </tr>
      <tr>
        <td align="center"><input name="standby1[]" type="text" id="standby1[]" size="6"></td>
        <td align="center"><input name="standby2[]" type="text" id="standby2[]" size="6"></td>
        <td align="center"><input name="standby3[]" type="text" id="standby3[]" size="6"></td>
        <td align="center"><input name="standby4[]" type="text" id="standby4[]" size="6"></td>
        <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="6"></td>
        <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="6"></td>
        <td align="center"><span id="spanMoney"></span></td>
        <td align="center"><input type="text" name="memo[]" id="memo[]"></td>
        </tr>
      <tr>
        <td align="center"><input name="standby1[]" type="text" id="standby1[]" size="6"></td>
        <td align="center"><input name="standby2[]" type="text" id="standby2[]" size="6"></td>
        <td align="center"><input name="standby3[]" type="text" id="standby3[]" size="6"></td>
        <td align="center"><input name="standby4[]" type="text" id="standby4[]" size="6"></td>
        <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="6"></td>
        <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="6"></td>
        <td align="center"><span id="spanMoney"></span></td>
        <td align="center"><input type="text" name="memo[]" id="memo[]"></td>
      </tr>
      <tr>
        <td align="center"><input name="standby1[]" type="text" id="standby1[]" size="6"></td>
        <td align="center"><input name="standby2[]" type="text" id="standby2[]" size="6"></td>
        <td align="center"><input name="standby3[]" type="text" id="standby3[]" size="6"></td>
        <td align="center"><input name="standby4[]" type="text" id="standby4[]" size="6"></td>
        <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="6"></td>
        <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="6"></td>
        <td align="center"><span id="spanMoney"></span></td>
        <td align="center"><input type="text" name="memo[]" id="memo[]"></td>
      </tr>
      <tr>
        <td align="center"><input name="standby1[]" type="text" id="standby1[]" size="6"></td>
        <td align="center"><input name="standby2[]" type="text" id="standby2[]" size="6"></td>
        <td align="center"><input name="standby3[]" type="text" id="standby3[]" size="6"></td>
        <td align="center"><input name="standby4[]" type="text" id="standby4[]" size="6"></td>
        <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="6"></td>
        <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="6"></td>
        <td align="center"><span id="spanMoney"></span></td>
        <td align="center"><input type="text" name="memo[]" id="memo[]"></td>
      </tr>
      
    </table></td>
    </tr>
  <tr>
    <td height="45" colspan="2" align="center">
	<input name="arTypeId" type="hidden" id="arTypeId" value="1" />
	<input name="id" type="hidden" id="id" value="{$aRow.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
