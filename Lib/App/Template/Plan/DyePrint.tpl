<html>
<head>
<title>打印坯纱请领单</title>
{literal}
	<style type="text/css">
		td {font:Arial, Helvetica, sans-serif}
		.haveBorder {border:1px solid #000}
		.haveBorder td {border-right:1px solid #000; border-bottom:1px solid #000; text-align:center}
		.tdItem {width:200px;}
	</style>
{/literal}
</head>
<body>
<div align="center" style="text-align:center">
	<div style="font-size:22px; font-weight:bold; height:30px;">坯纱请领单</div>
	<table  width="600px" cellpadding="0" cellspacing="0">
			<tr> 
				<td class="tdItem">客户：{$arr_field_value.Client.compName}</td>
				<td class="tdItem">订单号：{$arr_field_value.orderCode}</td>
				<td class="tdItem">订单日期：{$arr_field_value.dateOrder}</td>
				<td></td>
			</tr>
			
									 
			
	</table>
	<br>
	<table class="haveBorder" width="600px" cellpadding="0" cellspacing="0">
				<tr class="tdItem" height="30px"> 
					<td>序号</td>
					<td>缸号</td>
					<td>纱支</td>					
					<td>颜色</td>
					<td>计划投料</td>
				</tr>
				{foreach from=$arr_pdg item=item} 
					{foreach from=$item.Pdg item=value}
					<tr align="center"> 
						<td>{$item.id|default:'&nbsp;'}</td>
						<td>{$value.vatNum|default:'&nbsp;'}</td>
						<td>{$item.wareName|default:'&nbsp;'}</td>
						<td>{$item.color|default:'&nbsp;'}</td>
						<td>{$value.cntPlanTouliao|default:'&nbsp;'}</td>
					</tr>
					{/foreach}	
				{/foreach}
	</table>
</div>

</body>
</html>