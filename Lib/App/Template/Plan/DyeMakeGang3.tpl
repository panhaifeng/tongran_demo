<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title|default:"排缸第三步"}</title>
<link href="Resource/Css/Edit100.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery1.10.1.js"></script>
<script language="javascript">
{literal}
$(function(){
	$('[name="vatNum[]"]').change(function(){
		var tr=$(this).parents('tr');
		var url='?controller=Plan_Dye&action=SetVatNumBc';
	    var param={
	      id:$('[name="mainId[]"]',tr).val(),
	      value:$(this).val(),
	      valueOld:$('[name="SpanTxt[]"]',tr).html()
	    };
	    var me = this;
	    $.post(url,param,function(json){
	      if(json.sucess==true){
	      	alert('修改保存成功！');
	      }
	      else{
	      	alert('修改保存失败！');
	      }
	    },'json');

	});

});
function ChangeVatNum(obj){
	var tr=$(obj).parents('tr');
	$('[name="SpanTxt[]"]',tr).hide();
	// $('[name="vatNum[]"]',tr).prop('type','text');
	$('[name="vatNum[]"]',tr).show();

}
</script>
{/literal}
</head>

<div id="container">
<div id="nav">{include file="_ContentNav2.tpl"}</div>
<fieldset>
<legend>订单基本信息</legend>
	<table class="tableHaveBorder table100">
			<tr> 
				<td class="tdTitle">订单号：</td>
				<td align="left">{$arr_field_value.orderCode}</td>
				<td class="tdTitle">客户：</td>
				<td align="left">{$arr_field_value.Client.compName}</td>
				<td class="tdTitle">订单日期：</td>
				<td align="left">{$arr_field_value.dateOrder}</td>
				<td class="tdTitle">交货日期：</td>
				<td align="left">{$arr_field_value.dateJiaohuo}</td>
			</tr>
			<tr> 
				<td class="tdTitle">色牢度要求：</td>
				<td align="left" colspan="3">1, 干磨{$arr_field_value.fastness_gan}级；2，湿磨{$arr_field_value.fastness_shi}级； 3.白沾{$arr_field_value.fastness_baizhan}级；4.褪色{$arr_field_value.fastness_tuise}级</td>
				<td class="tdTitle">质量要求等级：</td>
				<td align="left">{$arr_field_value.zhiliang}</td>
				<td class="tdTitle">烘干要求：</td>
				<td align="left">{$arr_field_value.honggan}</td>
			</tr>
			<tr> 
				<td class="tdTitle">成品要求：</td>
				<td align="left" colspan="3">1.纸管:{$arr_field_value.packing_zhiguan} 
					2.塑料袋:{$arr_field_value.packing_suliao} 3.外包装:{$arr_field_value.packing_out} 
				</td>
				<td class="tdTitle">其他要求：</td>
				<td align="left" colspan="3">{$arr_field_value.memo}</td>
			</tr>
	</table>
</fieldset>

<fieldset>
<legend>排缸第三步</legend>
<table class="tableHaveBorder table200">
	<tr class="th"> 
		<td>序号</td>
		<td>缸号</td>
		<td>批号</td>
		<td>颜色</td>
		<td>色号</td>
		<td>数量(kg)</td>
		<td>计划投料</td>
		<td>计划筒子数</td>
		<td>定重</td>
		<td>物理缸号</td>
	</tr>
	{foreach from=$arr_pdg item=item} 
		{foreach from=$item.Pdg item=value}
		<tr align="center"> 
			<td>{$item.id}</td>
			<td><span id="SpanTxt[]" name="SpanTxt[]">{$value.vatNum}</span>
			<input type="text" name="vatNum[]" id="vatNum[]" value="{$value.vatNum}" style="width: 80px;display:none;">
			<input type="hidden" name="mainId[]" id="mainId[]" value="{$value.id}">[<a onclick="ChangeVatNum(this)" href="javascript:void(0)">修改</a>]</td>
			<td>{$value.pihao}</td>
			<td>{$item.color}</td>
			<td>{$item.colorNum}</td>
			<td>{$item.cntKg}</td>
			<td>{$value.cntPlanTouliao}</td>
			<td>{$value.planTongzi}</td>
			<td>{$value.unitKg}</td>
			<td>{$value.vatId}</td>
		</tr>
		{/foreach}	
	{/foreach}
</table></fieldset>

<div id="footButton" style="width:300px;">
	<ul>
		<li><input type="button" name="button1" value="完成返回" onClick={if $page=='EnterOrder'}"javascript:window.location.href='Index.php?controller=Trade_Dye_Order&action=Edit&id={$arr_field_value.id}&page=EnterOrder'"{elseif $page=='paigang'}"javascript:window.location.href='Index.php?controller=Trade_Dye_Order&action=Edit&id={$arr_field_value.id}&page=paigang'"{else}"javascript:window.location.href='Index.php?controller={$smarty.get.controller}&action=right'"{/if}></li>
		<li><input type="button" name="button3" value="完成并打印" onClick="javascript:window.location.href='{$print_url}&page={$page}'"></li>
	</ul>
</div>
<br>
<div style="width:100%; text-align:left; font-size:14px;">    
<a href="Index.php?controller={$smarty.get.controller}&action=printPlan&id={$arr_field_value.id}" target="_blank">打印坯纱请领单</a></div>
<br><br>

</div></body></html>