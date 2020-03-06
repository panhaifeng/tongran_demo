<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />

<script language="javascript">
{literal}
$(function(){


});
function ChangeJk(o){
	var jingKg = document.getElementsByName('jingKg[]');
	var jingKgZ = document.getElementsByName('jingKgZ[]');
	var zhelv = document.getElementsByName('zhelvMx[]');
	var paymentWay = document.getElementsByName('paymentWayMx[]');
	var pos = -1;
	for(var i=0;jingKg[i];i++) {
		if(o==jingKg[i]) {
			pos=i;break;
		}
	}
	if(pos<0) return false;
	var tr = $(o).parents('tr');
	if (paymentWay[pos].value==2) {//当为结算类型为折率时 进行带入折率运算 jingzhong/（1-zhelv）
		var value = (o.value/(1-zhelv[pos].value)).toFixed(2)*1;
		$('[name="jingKgZ[]"]',tr).val(value);
	}else{
		// $('[name="jingKgZ[]"]',tr).val(o.value); // 因客户需求 所有结算方式都进行算法 by zcc 2017年11月10日 14:13:07
		var value = (o.value/(1-zhelv[pos].value)).toFixed(2)*1;
		$('[name="jingKgZ[]"]',tr).val(value);
	}
}
{/literal}
</script>
</head>

<body>
<div id='container'>
<div style="text-align:left;">{include file="_ContentNav.tpl"}</div>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveGuide'}" method="post">
<fieldset>
<legend> 成品出库基础资料</legend>
<table class="tableHaveBorder table100" width="100%" >
	<tr>
		<td class="tdTitle">日期：</td>
		<td colspan="12">
			<input type=text name='dateCpck' id='dateCpck' onclick='calendar()' value='{$dateCpck}'>
		</td>

    <tr class="th">
	  <td align="center">客户</td>
	  <td align="center">订单号</td>
	  <td align="center">纱支规格</td>
	  <td align="center">颜色</td>
	  <td align="center">缸号</td>                  
	  <td align="center">计划投料</td>
	  <td align="center">计划筒数</td>
	  <td align="center">毛重(kg)</td>
	  <td align="center">净重(kg)</td>
	  <td align="center">计价重量(kg)</td>
	  <td align="center">筒子数(个)</td>
	  <td align="center">件数(个)</td>
	  <td align="center">备注</td>
	  <td align="center">胶筒</td>
	</tr>
	{foreach from=$rows item=item}
	<tr>
	  <td align="center">{$item.clientName}</td>
	  <td align="center">{$item.orderCode}</td>
	  <td align="center">{$item.guige}</td>
	  <td align="center">{$item.color}</td>
	  <td align="center">{$item.vatNum}</td>
	  
	  <td align="center">{$item.cntPlanTouliao}</td>
	  <td align="center">{$item.planTongzi}</td>
	  <td align="center"><input name="maoKg[]" type="text" id="maoKg[]" size="5" ></td>
	  <td align="center"><input name="gangId[]" type="hidden" id="gangId[]" value="{$item.id}">
	  <input name="jingKg[]" type="text" id="jingKg[]" size="5" onchange="ChangeJk(this)">
	  <input name="cntChuku[]" type="hidden" id="cntChuku[]" value="{$item.cntPlanTouliao}"></td>
	  <td align="center"><input name="jingKgZ[]" type="text" id="jingKgZ[]" size="5" readonly></td>
	  <td align="center"><input name="cntTongzi[]" type="text" id="cntTongzi[]" size="5"></td>
	  <td align="center"><input name="cntJian[]" type="text" id="cntJian[]" size="5">&nbsp;&nbsp;&nbsp;<span style="color:red;">*</span></td>
	  <td align="center"><select name='memo[]'>
		<option value=''></option>
        <option value='不结账'>不结账</option>
        <option value='未发完'>未发完</option>
        <option value='已发完'>已发完</option>
		<option value='退回回修'>退回回修</option>
		<option value='退回回倒'>退回回倒</option>
		<option value='退回检纱'>退回检纱</option>
        <option value='未完经纱'>未完经纱</option>
		</select></td>
	  <td align="center"><input name="memo1[]" type="text" id="memo1[]" size="5">
	  	<input type="hidden" name="zhelvMx[]" id = 'zhelvMx[]' value="{$item.OrdWare.zhelvMx}">
		<input type="hidden" name="paymentWayMx[]" id = 'paymentWayMx[]' value="{$paymentWay}">
	  </td>
	
	</tr>	
	{/foreach}
				
	{*显示已经出库的产量*}
	{foreach from=$rows1 item=item}
	<tr>
	  <td align="center">{$item.clientName}</td>
	  <td align="center">{$item.orderCode}</td>
	  <td align="center">{$item.guige}</td>
	  <td align="center">{$item.color}</td>
	  <td align="center">{$item.vatNum}</td>                  
	  <td align="center">{$item.cntPlanTouliao}</td>
	  <td align="center">{$item.planTongzi}</td>
	  <td align="center">{$item.maoKg}</td>
	  <td align="center">{$item.chanliang}</td>
	  <td align="center">{$item.jingKgZ}</td>
	  <td align="center"></td>
	  <td align="center"></td>
	<td align="center"></td>
	<td align="center"></td>
	</tr>
    {/foreach}
</table>							
<input name="Submit" type="submit" id="Submit" value='确定'>&nbsp;&nbsp;&nbsp;
<input name="Submit" type="submit" id="Submit" value='确定并打印'>
</fieldset>	
</form></div></body></html>
