<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>{$title}</title>
{literal}
<script language="javascript">
</script>
{/literal}
</head>
<body style="text-align:center">
<div>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SavePriceAll'}" method="post">
<input type="hidden" name="orderId" value="{$aRow.id}"></td>
<table>
	<tr><td>定单号:{$aRow.orderCode}</td><td>定单日期:{$aRow.dateOrder}</td><td>客户:{$aRow.Client.compName}</td></tr>
</table>
<br>
<table>
	<tr>
		<td align="center">整单价格</td>
		<td align="center"><input name="wholePrice" value=""></td>
	</tr>
</table>

<br />
<input name="submit" type="submit" value='保存并返回'>
</form>
</div>
</body>
</html>
