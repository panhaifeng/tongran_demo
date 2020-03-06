<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>颜色自动完成</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChange'}" method="post" onSubmit="return CheckForm(this)">
<div align="center">
<table>
  <tr>
    <td align="center">品名：</td>
    <td align="center">{$aRow.wareName}</td>
  </tr>
  <tr>
    <td align="center">规格：</td>
    <td align="center">{$aRow.guige}</td>
  </tr>
  <tr>
    <td align="center">库存数：</td>
    <td align="center">{$aRow.cntKucun}
      <input name="cntKucun" type="hidden" id="cntKucun" value="{$aRow.cntKucun}"></td>
    </tr>
  <tr>
    <td align="center">库存金额：</td>
    <td align="center">{$aRow.kucunMoney}
      <input name="kucunMoney" type="hidden" id="kucunMoney" value="{$aRow.kucunMoney}"></td>
  </tr>
  <tr>
    <td align="center">库存调整到：</td>
    <td align="center"><input name="cnt" type="text" id="cnt"/></td>
  </tr>
  <tr>
    <td align="center">金额调整到：</td>
    <td align="center"><input name="money" type="text" id="money"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="wareId" type="hidden" id="wareId" value="{$aRow.wareId}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</form>
</body>
</html>
