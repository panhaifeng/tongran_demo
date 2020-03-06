<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChanliang'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
<legend>松筒产量登记</legend>
<div align="center">
<table width="80%">
  <tr>
    <td width="90">松筒车台：</td>
    <td>{$aRow.Car.carCode}</td>
  </tr>
  <tr>
    <td>缸号：</td>
    <td>{$aRow.Gang.vatNum}</td>
    </tr>
  <tr>
    <td>客户：</td>
    <td>{$aRow.Client.compName}</td>
  </tr>
  <tr>
    <td>纱支规格：</td>
    <td>{$aRow.Ware.wareName} {$aRow.Ware.guige}</td>
  </tr>
  <tr>
    <td>计划投料：</td>
    <td>{$aRow.Gang.cntPlanTouliao}</td>
  </tr>
  <tr>
    <td>定重：</td>
    <td>{$aRow.Gang.unitKg}</td>
  </tr>
  <tr>
    <td>计划筒子数：</td>
    <td>{$aRow.Gang.cntPlanTouliao/$aRow.Gang.unitKg}</td>
  </tr>
  <tr>
    <td>班组号：</td>
    <td><select name="className" id="className">
      <option value="甲1">甲1</option>
      <option value="乙1"{if $aRow.className=='甲1'} selected{/if}>乙1</option>
      <option value="甲2"{if $aRow.className=='甲2'} selected{/if}>甲2</option>
      <option value="乙2"{if $aRow.className=='乙2'} selected{/if}>乙2</option>
      <option value="甲3"{if $aRow.className=='甲3'} selected{/if}>甲3</option>
      <option value="乙3"{if $aRow.className=='乙3'} selected{/if}>乙3</option>
    </select>    </td>
  </tr>
  <tr>
    <td>实际筒子产量：</td>
    <td>      <input name="cntTongzhi" type="text" id="cntTongzhi" value="{$aRow.cntTongzhi}">
      个</td>
  </tr>
  <tr>
    <td>实际公斤数：</td>
    <td><input name="cntKg" type="text" id="cntKg" value="{$aRow.cntKg}">
      公斤</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="gang2stcarId" type="hidden" id="gang2stcarId" value="{$aRow.gang2stcarId|default:$smarty.get.planId}" />
	<input name="id" type="hidden" id="id" value="{$smarty.get.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
