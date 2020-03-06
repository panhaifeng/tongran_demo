<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>凭据录入</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit100.css" type="text/css" rel="stylesheet">
</head>

<body>
<div id="container">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<input name="from" type="hidden" id="from" value="{$smarty.get.action}" />
<input name="id" type="hidden" id="id" value="{$aRow.id}" />
<fieldset>     
<legend>{$title}</legend>
<table class="tableHaveBorder table100" width="300px">
  <tr>
    <td class="tdTitle">收款类型</td>
    <td><input name="radio" type="radio" id="radio" value="0" onClick="document.getElementById('clientId').disabled=false;document.getElementById('expenseItemId').disabled=true" {if ($aRow.clientId>0)}checked{/if}>
销售收入
  <input type="radio" name="radio" id="radio" value="1" onClick="document.getElementById('expenseItemId').disabled=false;document.getElementById('clientId').disabled=true;" {if ($aRow.expenseItemId>0)}checked{/if}>
  其他收入</td>
  </tr>
  <tr>
    <td class="tdTitle">入帐方式</td>
    <td><select name="type">   
    {webcontrol type='TmisOptions' inf='paymentTypes' selected=$aRow.type}
    </select></td>
  </tr>
  <tr>
    <td class="tdTitle">客户/项目</td>
    <td>
    {if ($aRow.clientId>0)}{webcontrol type='ClientSelect' selected=$aRow.clientId}
    {else}{webcontrol type='ClientSelect' selected=$aRow.clientId disabled=true}{/if}
      <select name="expenseItemId" id="expenseItemId"  {if ($aRow.expenseItemId==0)}disabled{/if}>
      {webcontrol type='TmisOptions' model='caiwu_expenseItem' selected=$aRow.expenseItemId}
      </select>      </td>
  </tr>
  <tr>
    <td class="tdTitle">凭据编号</td>
    <td><input name="incomeNum" type="text" id="incomeNum" value="{$aRow.incomeNum}" readonly/></td>
  </tr>
  <tr>
    <td class="tdTitle">日期</td>
    <td width="84%"><input name="dateIncome" type="text" id="dateIncome" value="{$aRow.dateIncome|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"/></td>
    </tr>
  <tr>
    <td class="tdTitle">银行帐户</td>
    <td><select name="accountItemId" id="accountItemId" check='^0$' warning='请选择银行帐户!'>
      
               
    {webcontrol type='TmisOptions' model='CaiWu_AccountItem' selected=$aRow.accountItemId}    
    
    
    </select>    </td>
  </tr>
  <tr>
    <td class="tdTitle">金额</td>
    <td><input name="moneyIncome" type="text" id="moneyIncome" value="{$aRow.moneyIncome}" /></td>
    </tr>
  <tr>
    <td class="tdTitle">备注</td>
    <td><input name="memo" type="text" id="memo" value="{$aRow.memo}" /></td>
    </tr>
</table>
</fieldset>

<div id="footButton" style="width:300px;">
	<ul>
		<li><input type="submit" name="Submit" value="确  定"></li>
		<li><input type="button" name="button" id="button" value="返  回" onClick="javascript:window.parent.tb_remove()"></li>
	</ul>
</div>
 
</form>
</div>
</body>
</html>
