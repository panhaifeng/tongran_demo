<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统基本设置</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit100.css" type="text/css" rel="stylesheet">
{literal}
<style>
.table100 td{height:30px; width:100px;}
</style>
{/literal}
</head>

<body>
<div id="container">
<div id="nav" style="font-size:20px">系统配置工具<font color='red'>(此工具会影响系统的报表功能，非系统管理人员慎用)</font></div>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveSet'}" method="post" onSubmit="return CheckForm(this)">
  <fieldset>
  <legend>生产日期设置</legend>
<table class="tableHaveBorder table100" style="width:700px">
          <tr>
            <td colspan="1" class="tdTitle">染色起始日期：
            <input name="setName[]" type="hidden" id="setName[]" value="DyeStartDate"></td>
			<td style="width:120px"><input name="setValue[]" type="text" id="setValue[]" onClick="calendar()" value="{$row.DyeStartDate}"></td>
			<td>未染色列表和排缸表的起始日期</td>
          </tr>
          <tr>
            <td colspan="1" class="tdTitle">坯纱仓库生效日期：
            <input name="setName[]" type="hidden" id="setName[]" value="PishaStartDate"></td>
            <td><input name="setValue[]" type="text" id="setValue[]" onClick="calendar()" value="{$row.PishaStartDate}"></td>
            <td>坯纱仓库库存计算的起始日期</td>
          </tr>
          <tr>
            <td colspan="1" class="tdTitle">染料仓库生效日期：
            <input name="setName[]" type="hidden" id="setName[]" value="RanliaoStartDate"></td>
            <td><input name="setValue[]" type="text" id="setValue[]" onClick="calendar()" value="{$row.RanliaoStartDate}"></td>
            <td>染料仓库库存计算的起始日期</td>
          </tr>
      </table>
</fieldset>	

<fieldset>
  <legend>使用习惯设置</legend>
  <table class="tableHaveBorder table100" style="width:700px">
          <tr>
            <td colspan="1" class="tdTitle">排缸习惯：
              <input name="setName[]" type="hidden" id="setName[]" value="PaigangXiguan"></td>
			<td><select name="setValue[]" id="setValue[]">
			  <option value="0">由筒子数计算出定重</option>
			  <option value="1" {if $row.PaigangXiguan==1}selected{/if}>由定重计算出筒子数</option>
		    </select></td>
			<td>&nbsp;</td>
        </tr>
      </table>
</fieldset>	
<fieldset>
  <legend>处方单纸张高度设置
  </legend>
  <table class="tableHaveBorder table100" style="width:700px">
          <tr>
            <td colspan="1" class="tdTitle">纸张高度：
              <input name="setName[]" type="hidden" id="setName[]" value="PageSize"></td>
			<td><input type="text" name="setValue[]" id="setValue[]" value="{$row.PageSize}"></td>
			<td>单位为厘米</td>
        </tr>
      </table>
</fieldset>	
<div id="footButton" style="width:300px;">
	<ul>
		<li><input type="submit" id="submit" name="submit" value='保存'></li>
	</ul>
</div>

</form>
<!--
<form name="form2" action="{url controller=$smarty.get.controller action='edit'}" method="post">
<div style="width:80%">
<fieldset>
<legend>入库基本信息( * 为必填项)</legend>
<input name="newOrderCode" type="hidden" id="newOrderCode" value="{$arr_field_value.orderCode}" readonly>
翻单号：<input name="orderCode" type="text" value=""><input name="submit" type="submit" value="调入">
</div></form>-->

</div></body></html>
