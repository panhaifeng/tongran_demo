<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>产品资料编辑</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>     
<legend>产品资料编辑</legend>
<div align="center">
<table width="100%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td width="13%" height="33">产品类别：</td>
    <td width="38%"><select name='proKind' id='proKind'>
    {webcontrol type='TmisOptions' inf='proKind' selected=$aProduct.proKind}
    </select></td>
    <td width="11%">颜色：</td>
    <td width="38%"><select name='proColor' id='proColor'> {webcontrol type='TmisOptions' inf='proColor' selected=$aProduct.proColor}</select></td>
  </tr>
  <tr>
    <td width="13%" height="33">产品编码：</td>
    <td width="38%"><input name="proCode" type="text" id="proCode" value="{$aProduct.proCode}" check="^[a-zA-Z0-9\-]+$" warning="必须为字母数字或者减号!"/><a href="Documents/Product/产品编码说明.txt" target="_blank">编码说明</a></td>
    <td width="11%">&nbsp;</td>
    <td width="38%">&nbsp;</td>
  </tr>
  <tr>
    <td width="13%" height="33">品名：</td>
    <td width="38%"><input name="proName" type="text" id="name" value="{$aProduct.proName}"/></td>
    <td width="11%">规格：</td>
    <td width="38%"><input name="guige" type="text" id="guige" value="{$aProduct.guige}" /></td>
  </tr>
  <tr>
    <td width="13%" height="33">门幅(cm)：</td>
    <td width="38%"><input name="menfu" type="text" id="menfu" value="{$aProduct.menfu}" check="^\d+$" warning="门幅必须为数字!"/></td>
    <td width="11%">克重(g/m2)：</td>
    <td width="38%"><input name="kezhong" type="text" id="kezhong" value="{$aProduct.kezhong}" /></td>
  </tr>
  <tr>
    <td width="13%" height="33">直向：</td>
    <td width="38%"><input name="y" type="text" id="y" value="{$aProduct.y}"/></td>
    <td width="11%">横向：</td>
    <td width="38%"><input name="x" type="text" id="x" value="{$aProduct.x}" /></td>
  </tr>
  <tr>
    <td height="45" colspan="4" align="center">
	<input name="{$pk}" type="hidden" id="{$pk}" value="{$aProduct.$pk}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
