<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>{$title|default:"排缸第一步"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
</head>

<body>
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

<form name="form1" action="Index.php?controller=Plan_Dye&action=MakeGang2&page={$smarty.get.page}" method=post>
<input type="hidden" name="{$pk_name}" value="{$arr_field_value.$pk_name}">
<fieldset>
<legend>排缸第一步</legend>
	<table class="tableHaveBorder table100">
		<tr class="th"> 
			<td>序号</td>
			<td>纱支规格</td>
			<td>颜色</td>
			<td>色号</td>
			<td>数量（kg)</td>
			<td>已排缸数</td>
			<td>计划用缸数量</td>
		</tr>
		{foreach from=$arr_field_value.Ware item=item}
		<tr> 
			<td>{$item.id}</td>
			<td>{$item.Ware.wareName} {$item.Ware.guige}</td>
			<td>{$item.color}</td>
			<td>{$item.colorNum}</td>
			<td>{$item.cntKg}</td>
			<td>{$item.cntGang}</td>
			{if $item.cntGang>0}{/if}
			<td>
			{if $item.cntGang>0}
				{$item.cntGang}
			{else}
				<input name="gangCount[]" type="text" id="gangCount[]" value="1" size="2"> 缸
		   		<input name="ord2WareId[]" type="hidden" id="ord2WareId[]" value="{$item.id}" />
			{/if}
			</td>
		</tr>
		{/foreach}             
	</table>
	
	<div id="footButton" style="width:300px;">
		<ul>
			<li><input type="submit" name="Submit" value=" 下一步 "></li>
			<li><input type="button" id="Back" name="Back" value='返  回' onClick="javascript:window.history.go(-1);"></li>
		</ul>
	</div>
</fieldset></form>
</div></body>
</html>