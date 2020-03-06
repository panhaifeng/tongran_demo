<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>选择缸号</title>
</head>
<body>
<div align="center">
	<table>
			<tr> 
				<td class="tdItem">订单号：</td>
				<td>{$arr_field_value.Order.orderCode}</td>
				<td class="tdItem">客户：</td>
				<td>{$arr_field_value.clientName}</td>
			</tr>
			<tr> 
				<td class="tdItem">订单日期：</td>
				<td>{$arr_field_value.Order.dateOrder}</td>
				<td class="tdItem">交货日期：</td>
				<td>{$arr_field_value.Order.dateJiaohuo}</td>
			</tr>
									 
			<tr> 
				<td class="tdItem">质量要求等级：</td>
				<td>{$arr_field_value.Order.zhiliang}</td>
				<td class="tdItem">烘干要求：</td>
				<td>{$arr_field_value.Order.honggan}</td>
			</tr>
			<tr> 
				<td class="tdItem">色牢度要求：</td>
				<td colspan="3">1, 干磨{$arr_field_value.Order.fastness_gan}级；2，湿磨{$arr_field_value.Order.fastness_shi}级； 3.白沾{$arr_field_value.Order.fastness_baizhan}级；4.褪色{$arr_field_value.Order.fastness_tuise}级</td>
			</tr>
			<tr> 
				<td class="tdItem">成品要求：</td>
				<td colspan="3">1.纸管:{$arr_field_value.Order.packing_zhiguan} 
					2.塑料袋:{$arr_field_value.Order.packing_suliao} 3.外包装:{$arr_field_value.Order.packing_out} 
				</td>
			</tr>
			
			<tr> 
				<td class="tdItem">其他要求:</td>
				<td colspan="3">{$arr_field_value.Order.memo}</td>
			</tr>
	</table>
	<br />
	<table>
				<tr class="tdItem"> 
					<td>序号</td>
					<td>缸号</td>
					<td>批号</td>
					<td>颜色</td>
					<td>色号</td>
					<td>数量(kg)</td>
					<td>计划投料</td>
					<td>物理缸号</td>
					<td>定重</td>
				</tr>
				{foreach from=$arr_field_value item=item} 
					{foreach from=$item.Pdg item=value}
					<tr align="center"> 
						<td>{$item.id}</td>
						<td>{$value.vatNum}</td>
						<td>{$value.pihao}</td>
						<td>{$item.color}</td>
						<td>{$item.colorNum}</td>
						<td>{$item.cntKg}</td>
						<td>{$value.cntPlanTouliao}</td>
						<td>{$value.vatId}</td>
						<td>{$value.unitKg}</td>
					</tr>
					{/foreach}	
				{/foreach}
		</table>
	<div style="clear:both;">
		<a href="Index.php?controller={$smarty.get.controller}&action=right">完成</a>
		<!--
		<form name="form1" action="{url controller=$smarty.get.controller action='PrintPlan'}" method="post" style="display:none;">
				<input type="hidden" name="{$pk_name}" value="{$arr_field_value.$pk_name}" />
				<input type="submit" name="print" value="打印"/>
		</form>-->
	</div>
</div>
</form>
</body>
</html>