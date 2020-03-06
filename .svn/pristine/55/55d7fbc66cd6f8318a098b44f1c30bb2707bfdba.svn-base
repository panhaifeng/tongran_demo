<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>打折</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit100.css" type="text/css" rel="stylesheet">
</head>

<body>
<div id="container">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveAdjust'}" method="post" onSubmit="return CheckForm(this)">
<input name="type" type="hidden" id="type" value="9">
<input name="id" type="hidden" id="id" value="{$row.id}">
<fieldset>     
<legend>打折</legend>
<table class="tableHaveBorder table100">
    <tr>
      <td class="tdTitle">日期：</td>
      <td><input name="dateIncome" type="text" id="dateIncome" value="{$row.dateIncome}" onClick="calendar()"></td>
    </tr>
    <tr>
      <td class="tdTitle">客户：</td>
      <td><input name="clientId" type="hidden" id="clientId" value="{$row.clientId|default:$smarty.get.clientId}">
        {$row.Client.compName}</td>
    </tr>
    <tr>
      <td class="tdTitle">打折金额：</td>
      <td><input name="moneyIncome" type="text" id="moneyIncome" value="{$row.moneyIncome}"></td>
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