<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
<div id="nav">{include file="_ContentNav2.tpl"}</div>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveWare'}" method="post" onSubmit="return myCheck(this)">
<input name="id" type="hidden" id="id" value="{$arr_field_value.id}" />
<fieldset>
<legend>修改领料数量( * 为必填项)</legend>
<table class="tableHaveBorder table100" style="width:300px;">
  <tr>
    <td align="right" class="tdTitle">客户：</td>
    <td align="left">{$arr_field_value.Supplier.compName}</td>
  </tr>

  <tr>
    <td align="right" class="tdTitle">纱支规格：</td>
    <td align="left">{$arr_field_value.Wares.wareName} {$arr_field_value.Wares.guige}</td>
  </tr>
  
  <tr>
    <td align="right" class="tdTitle">产地：</td>
    <td align="left"><select name="chandi" id="chandi">
      	<option value="">请选择</option>
      	{foreach from=$chandi item=item}
      	<option value="{$item}" {if $arr_field_value.chandi==$item}selected{/if}>{$item}</option>
        {/foreach}
      </select></td>
  </tr>
  <tr>
    <td align="right" class="tdTitle">批号：</td>
    <td align="left">{$arr_field_value.pihao}</td>
  </tr>
  <tr>
    <td align="right" class="tdTitle">领出数量：</td>
    <td align="left"><input name="cnt" type="text" id="cnt" value="{$arr_field_value.cnt}"></td>
  </tr>
</table>

<div id="footButton" style="width:300px;">
	<ul>
		<li><input type="submit" name="Submit" value="确  定"></li>
		<li><input type="button" id="Back" name="Back" value='返  回' onClick="javascript:window.history.go(-1);"></li>
	</ul>
</div>
</fieldset>
</form>
</div>
</body>
</html>
