
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>打印出库单</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
{literal}
<style type="text/css">
td {FONT-SIZE:14px;}
.haveBorder{border-top:1px solid #000000; border-left:1px solid #000}
.haveBorder td { border-bottom:1px solid #000; border-right:1px solid #000}
.th td{font-weight:bold}
</style>
{/literal}

{literal}
<script language=javascript id=clientEventHandlersJS> 
<!-- 
function prnbutt_onclick() { 
	window.print(); 
	return true; 
} 

function window_onbeforeprint() { 
	prn.style.visibility ="hidden"; 
	return true; 
} 

function window_onafterprint() { 
	prn.style.visibility = "visible"; 
	return true; 
} 
//--> 
</script>
{/literal}
</head>
<body style="margin-top:0px" onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<table align="center" width="750px">
<tr align="center">
  <td colspan="3" style="font-size:18px; font-weight:bold">{webcontrol type='GetAppInf' varName='compName'}送货单</td>
</tr>
<tr>
    <td width="200px" align="left">客户: {$arr_field_value.0.clientName}</td>
    <td align="center">出库日期: {$arr_field_value.0.dateCpck}</td>
    <td align="right" width="200px" style="color:#06F">单号：{$cpckcode}</td>
</tr>

<tr><td colspan="3">
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="haveBorder">
	{*字段名称*}
      <tr class="th">
	    {foreach from=$arr_field_info item=item}
        <td align="center">{$item}</td>
        {/foreach}
      </tr>
      {*字段的值*}
      {foreach from=$arr_field_value item=field_value}
  	  <tr style="height:17px;">
	  	{foreach from=$arr_field_info key=key item=item}
    	<td align="center" style="border-top: 1px solid #cccccc;">{$field_value.$key|default:'&nbsp;'}</td>
    	{/foreach}
  	  </tr>
      {/foreach}
</table></td></tr>
<tr><td colspan="3" align="left">发货人(录入时间):{$fahuoren}({$arr_field_value.0.dt})&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;收货单位确认货、数量后签字:</td></tr>
<tr><td colspan="3" align="left">*注 1.请收货单位收货时认真核对收货数量，金额和累积账款，并由收货方财务签字确认后回传苏彩坊财务（或由驾驶员带回）<br>
2.请认真核对色光、色号无误后入库。如有质量异议需在五天内以书面形式通知染厂。织造成品后如出现质量问题由此而造成的赔款或退货，染厂概不负责。</td></tr>
<tr><td colspan="3" height="30px" align="center" style="border-top:1px solid #000; font-style:italic; font-size:12px;">常州易奇科技（专业开发筒染、色织系统） 联系方式：{webcontrol type='Servtel'}</td></tr>
</table><form action="{url controller=$smarty.get.controller action='PrintLodop'}" method="post" name="form1">
<div id=prn align="center">
	<input id=prnbutt type='submit' value="打印">
</div>
<input type='hidden' name='cpckcode' value='{$cpckcode}'/>
{foreach from=$smarty.post.printId item='item'}<input type='hidden' name='printId[]' value='{$item}'/>{/foreach}
{foreach from=$smarty.get.printId item='item'}<input type='hidden' name='printId[]' value='{$item}'/>{/foreach}
</form>
</body>
</html>
