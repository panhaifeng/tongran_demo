<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{webcontrol type='GetAppInf' varName='compName'}染色计划日报表</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
<script language=javascript id=clientEventHandlersJS> 
{literal}
<!-- 
function prnbutt_onclick() 
{ 
window.print(); 
return true; 
} 

function window_onbeforeprint() 
{ 
prn.style.visibility ="hidden"; 
return true; 
} 

function window_onafterprint() 
{ 
prn.style.visibility = "visible"; 
return true; 
} 

//--> 
{/literal}
</script> 
<style type="text/css">
{literal}
td {FONT-SIZE:16px;}
.caption {font-size:22px; font-weight:bold;}
.th td{font-weight:bold; text-align:center}
{/literal}
</style>
</head>

<body onafterprint="return window_onafterprint()" 
onbeforeprint="return window_onbeforeprint()">
<table border="0" align="center">
    <tr>
        <td align="center" class="caption">{webcontrol type='GetAppInf' varName='compName'}染色计划日报表</td>
    </tr>
    <tr>
        <td align="right">{$date_assign}&nbsp;&nbsp;{$ranseBanci}</td>
    </tr>
    <tr>
        <td>
		<table class="tableHaveBorder" cellpadding="3px">
		  <tr align="center" class="th">
           {foreach from=$arr_field_info item=item}
			<td>{$item}</td>			
            {/foreach}
			<td style="width:50px;">备注</td>
		  </tr>
		  {foreach from=$arr_field_value item=field_value}
		  <tr>
			{foreach from=$arr_field_info key=key item=item}
			<td align="center">{$field_value.$key|default:'&nbsp;'}</td>
			{/foreach}
			<td align="center"></td>		  	
		  </tr>
		  {/foreach}
		</table>
		</td>
    </tr>
	<tr><td align="center">
	<span id=prn><input language=javascript id=prnbutt onClick="return prnbutt_onclick()" type=button value="打印"></span></td></tr>
</table>
</body>
</html>
