<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>{$title}</title>
</head>
<body>
<div align="center">
	<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SavePrice'}" method="post">
	<input type="hidden" name="rukuId" id="rukuId" value="{$aRow.$pk}">
<table>
	<tr><td>定单号:{$aRow.ruKuNum}</td><td>定单日期:{$aRow.ruKuDate}</td><td>客户:{$aRow.Supplier.compName}</td></tr>
</table>
<br>
<table>
	<tr>
	  <td align="center">货品编号</td>                  
	  <td align="center">数量</td>
	  <td align="center">单价</td>
	</tr>
	{foreach from=$aRow.Wares item=item}
	<tr>
	  <td align="center">{$item.wareId}</td>
	  <td align="center">{$item.cnt}</td>
	  <td align="center">
	  	<input name="danJia[]" type="text" value="{$item.danJia}" size="10" tabindex="{$tabindex++}">
		<input type="hidden" name="id[]" value="{$item.id}">
	  </td>	  
	</tr>
	{/foreach}
	
	
</table>
<br>
<input name="submit" type="submit" value='保存并返回'>
</form>
</div>
</body>
</html>
