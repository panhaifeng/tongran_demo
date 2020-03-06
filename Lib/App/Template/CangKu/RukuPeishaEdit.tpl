<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="container">
<div id="nav">{include file="_ContentNav2.tpl"}</div>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<input name="tag" type="hidden" id=tag value="1">
<input type="hidden" name="id" id="id" value="{$arr_field_value.$pk}">

<fieldset>
<legend>入库基本信息( * 为必填项)</legend>
<table class="tableHaveBorder table100" style="width:300px;">
  <tr>
	<td class="tdTitle">单号：</td>
	<td align="left"><input name="ruKuNum" type="text" id="ruKuNum" value="{$arr_field_value.ruKuNum}" size="15" warning="请输入单号!" check="^\w+$" > <span class="fillRequired">*</span></td></tr>
  <tr>
	<td  class="tdTitle">入库日期：</td>
	<td align="left"><input name="ruKuDate" type="text" id="ruKuDate"  value="{$arr_field_value.ruKuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"> <span class="fillRequired">*</span></td>
  </tr>
  
  <tr>
	<td class="tdTitle">客户：</td>
	<td align="left">{webcontrol type='ClientSelect' id='supplierId' selected=$arr_field_value.Supplier} <span class="fillRequired">*</span></td>
  </tr>
  
  <tr>
	<td class="tdTitle">备注：</td>
	<td align="left"><input name="memo" type="text" id="memo" value="{$arr_field_value.memo}"></td>
  </tr>
</table>
</fieldset>	
		
<div id="footButton" style="width:300px;">
	<ul>
		<li><input type="submit" id="submit" name="submit" value='确定并编辑货品信息'></li>
		<li><input type="button" id="Back" name="Back" value='返  回' onClick="javascript:window.history.go(-1);"></li>
	</ul>
</div>

</form>
</div>
</body>
</html>
