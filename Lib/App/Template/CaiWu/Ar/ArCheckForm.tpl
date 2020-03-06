<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{webcontrol type='GetAppInf' varName='compName'}对帐单</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
{literal}
<style type="text/css">
td {FONT-SIZE:16px;}
.haveBorder{border-top:2px solid #000000; border-bottom:2px solid #000}
.haveBorder td { border-bottom:0px solid #000; border-right:0px solid #000; text-align:left;}
.th td{font-weight:bold; border-bottom:1px solid #000; height:26px;FONT-SIZE:14px;}
.tC td{font-weight:bold; border-bottom:1px dotted #000; height:26px;FONT-SIZE:14px;}
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
<table align="center" width="800px">
<tr align="center">
  <td colspan="3" style="font-size:24px; font-family:'隶书'">{webcontrol type='GetAppInf' varName='compName'}对帐单</td>
</tr>
<tr>
    <td width="250px" align="left">客户: {$client_name}</td>
    <td align="center">结算方式：{$paymentWayName}</td>
    <td align="right" width="300">时间：{$smarty.get.dateFrom} 到 {$smarty.get.dateTo}</td>
</tr>

<tr><td colspan="3">
	<table width="100%" align="left" cellpadding="2" cellspacing="0" class="haveBorder">
		{*字段名称*}
		<tr class="th"> 	   
		{foreach from=$arr_field_info item=item}
		<td>{$item}</td>
		{/foreach}        
		</tr>
		{*字段的值*}
	
		{foreach from=$arr_field_value item=field_value}    
		<tr class="tC">	  	
		{foreach from=$arr_field_info key=key item=item}
		<td>{$field_value.$key|default:'&nbsp;'}</td>    		
		{/foreach}    	
		</tr>
		{/foreach}
	</table>	
</td></tr>

<!-- 用纱明细	<br />
<tr><td colspan="3">
<table width="100%" align="left" cellpadding="2" cellspacing="0" class="haveBorder">
	{*字段名称*}
	<tr class="th"> 	   
	{foreach from=$arr_field_info200 item=item}
	<td>{$item}</td>
	{/foreach}        
	</tr>
	{*字段的值*}
	
	{foreach from=$arr_field_value200 item=field_value}    
	<tr class="tC">	  	
	{foreach from=$arr_field_info200 key=key item=item}    		
	<td>{$field_value.$key|default:'&nbsp;'}</td>    		
	{/foreach}    	
	</tr>
	{/foreach}
</table></td></tr>-->
<tr><td colspan="3" height="30px" align="center" style="border-top:0px solid #000; font-style:italic; font-size:12px;">常州易奇科技（专业开发筒染、色织系统） 联系方式：{webcontrol type='Servtel'}</td></tr>
</table>

<div id=prn align="center"> 
  <input id=outbutt type=button value=" 导 出 " onClick="window.location.href=window.location.href+'&export=1'">
  <input id=prnbutt onClick="return prnbutt_onclick()" type=button value=" 打 印 ">
</div>
</body>
</html>
