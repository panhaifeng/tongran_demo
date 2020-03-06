<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>入库单详细信息</title>
</head>
<body>
<fieldset>     
<legend><span class="legendFront">详细信息</span></legend>
<div align="center">
	<table>
			<tr> 
				<td class="tdItem">单号：</td>
				<td>{$arr_field_value.rukuNum}</td>
				<td class="tdItem">供应商：</td>
				<td>{$arr_field_value.Supplier.compName}</td>
			</tr>
			<tr> 
				<td class="tdItem">日期：</td>
				<td>{$arr_field_value.rukuDate}</td>
				<td class="tdItem">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
									 
			<tr> 
				<td class="tdItem">详细信息：</td>
				<td colspan="3">{$arr_field_value.memo}</td>
			</tr>
	</table>
	<br />
<table>
				<tr class="tdItem"> 
					<td>序号</td>
					<td>名称</td>
					<td>规格</td>
					<td>单位</td>
					<td>数量(kg)</td>
					<td>单价</td>
				</tr>
				{foreach from=$arr_field_value.Wares item=item} 
					<tr align="center"> 
						<td>{$item.id}</td>
						<td>{$item.WareName}</td>
						<td>{$item.Guige}</td>
						<td>{$item.Unit}</td>
						<td>{$item.cnt}</td>
						<td>{$item.danjia}</td>
					</tr>
				{/foreach}
	</table>
	<div style="clear:both;">
		<a href="#" onclick="javascript:window.history.back()">返回</a>
	</div>
</div>
</fieldset>
</form>
</body>
</html>