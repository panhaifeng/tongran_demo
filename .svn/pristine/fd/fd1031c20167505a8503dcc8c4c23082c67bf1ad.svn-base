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
<div align="center">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<fieldset style="width:90%">
<legend>增加染化料入库单</legend>
<table border="0">
<tr>
<td width="45%" height="25">单号：
<input type="hidden" name="id" id="id" value="{$arr_field_value.$pk}">
<input name="ruKuNum" type="text" id="ruKuNum" value="{$arr_field_value.ruKuNum}" size="15" warning="请输入单号!" check="^\w+$" ></td>	
<td width="55%">入库日期：
<input name="ruKuDate" type="text" id="ruKuDate"  value="{$arr_field_value.ruKuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
</tr>

<tr>
<td>供应商：{webcontrol type='SupplierSelect' selected=$arr_field_value.supplierId}</td>
<td>备注：<input name="memo" type="text" id="memo" value="{$arr_field_value.memo}" size="40"></td>
</tr>
</table>
</fieldset>
<div>	
<input name=tag type=hidden id=tag value={$ruku_tag}>
<input name="Submit" type="submit" id="Submit" value='确定并编辑货品信息'>			    
<input name="Back" type="button" id="Back" value='返回' onClick="javascript:window.history.go(-1)">
</div>
</form></div>
</body>
</html>