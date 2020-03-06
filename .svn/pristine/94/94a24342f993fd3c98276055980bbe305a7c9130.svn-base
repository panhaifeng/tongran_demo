<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>供应商资料编辑</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>供应商资料编辑</legend>
<div align="center">
<table width="50%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td width="13%" height="33">染缸编号：</td>
    <td width="38%">
      <input name="vatCode" type="text" id="vatCode" value="{$aVat.vatCode}" check="^(\s|\S)+$" warning="染缸编号不能为空!"/></td>
    </tr>
    <tr>
    <td height="35">排列顺序：</td>
    <td><input name="orderLine" type="text" id="orderLine" value="{$aVat.orderLine}" /></td>
    </tr>
  <tr>
    <td height="35">装筒数：</td>
    <td><input name="cntTongzi" type="text" id="cntTongzi" value="{$aVat.cntTongzi}"  check="^\d+$" warning="筒子数量必须为数字!"/></td>
  </tr>
  <tr>
    <td height="35">最小染纱量：</td>
    <td><input name="minKg" type="text" id="minKg" value="{$aVat.minKg}" /></td>
    </tr>
  <tr>
    <td height="34">最大染纱量：</td>
    <td><input name="maxKg" type="text" id="maxKg" value="{$aVat.maxKg}" /></td>
    </tr>
  <tr>
    <td height="35">最小浴比：</td>
    <td><input name="minYubi" type="text" id="minYubi" value="{$aVat.minYubi}" /></td>
  </tr>
  <tr>
    <td height="34">最大浴比：</td>
    <td><input name="maxYubi" type="text" id="maxYubi" value="{$aVat.maxYubi}" /></td>
  </tr>
  
  <tr>
    <td height="35">水溶量：</td>
    <td><input name="shuiRong" type="text" id="shuiRong" value="{$aVat.shuiRong}"/></td>
  </tr>
  <tr>
    <td height="35">水溶量1：</td>
    <td><input name="shuiRong1" type="text" id="shuiRong1" value="{$aVat.shuiRong1}"/></td>
  </tr>
  <tr>
    <td height="35">备注：</td>
    <td><input name="memo" type="text" id="memo" value="{$aVat.memo}"/></td>
  </tr>
  <tr>
    <td height="45" colspan="2" align="center">
	<input name="{$pk}" type="hidden" id="{$pk}" value="{$aVat.$pk}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
