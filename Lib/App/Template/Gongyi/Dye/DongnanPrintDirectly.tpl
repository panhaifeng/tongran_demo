<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工艺处方单打印</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css">
{literal}
<style type="text/css">
td{font-size:20px;}
td span{font-weight:bold;}
.haveBorder{border:1px solid #000;}
.th td {font-weight:bold;}
.haveBorder td {border-bottom:1px solid #000; border-right:1px solid #000; border-collapse:collapse;}
.caption{font-size:24px; font-weight:bold;}
#topTable td{font-size:18px;}
</style>
{/literal}

<script language=javascript id=clientEventHandlersJS> 
{literal}
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
{/literal}
</script>
</head>
<body style="margin-top:0px" onafterprint="return window_onafterprint()" 
onbeforeprint="return window_onbeforeprint()">
<table width="700" align="center" style="margin-top:0px">
		<tr><td colspan="3" align="center" class="caption">工艺处方单</td></tr>
		<tr><td colspan="3">
		<table width="100%" id="topTable">
		<tr align="left">
		  <td><span>日期：</span>{$row.datePrint}</td>
		  <td><span>客户名：</span>{$row.compName}</td>
		  <td><span>纱支：</span>{$row.Gang[0].guige}</td>
		  <td><span>颜色：</span>{$row.color}</td>
		  <td><span>折率：</span>{$row.rsZhelv}</td>
		</tr>
		<tr align="left">
		  <td><span>缸号：</span>{$row.Gang[0].vatNum}</td>
		  <td><span>总公斤数：</span>{$row.cntKg}</td>
		  <!--<td><span>定重：</span>{$row.Gang[0].unitKg}</td>
		  <td><span>筒子数量：</span>{$row.cntTongzi}</td>-->
		  <td><span>锅型：</span>{$row.vatCode}</td>
		  <td><span>水容量：</span>{$row.shuirong}</td>
		  <td><span>前处理：</span>{$row.pisha_qcl}</td>
		  <!--<td><span>包数：</span>{$row.cntKg/5} </td>
		  <td><span>染坯要求：</span>{$row.dyeKind} </td>-->
		  <!--<span>色号：</span>{$row.colorNum}</td>-->
		</tr>
		
		</table>
  </td></tr>
		<tr>
			<td colspan="3">
				<table width="100%" class="haveBorder" cellpadding="2px" cellspacing="0" >
		<tr class=th>
		  <td align="center">染化料/助剂</td>
		  <td align="center">单位用量</td>
		  <td align="center">缸用量(g)</td>
		  <td align="center">温度</td>
		  <td align="center">时间</td>
		  <td align="center">备注</td>
		</tr>
		{foreach from=$row.Dye item=item}
		<tr>
			<td align="center" >{$item.guige|default:'&nbsp;'}</td>	  
		  	<td align="center">{$item.unitKg|default:'&nbsp;'}{if $item.unit}({$item.unit|default:'&nbsp;'}){/if}</td>
			<td align="center">{$item.cntKg|default:'&nbsp;'}</td>
			<td align="center">{$item.tmp|default:'&nbsp;'}</td>
		  <td align="center">{$item.timeRs|default:'&nbsp;'}</td>
		  <td align="center">{$item.memo|default:'&nbsp;'}</td>
		</tr>				
		{/foreach}
				</table>
			</td>
		</tr>
		<tr>
		    <td style="width:75%">&nbsp;</td>
		    <td colspan="2" style="font-size:14px">处方人: {$row.chufangren}</td>
		</tr>
</table>
<div id=prn align="center">
<input language=javascript id=prnbutt onClick="return prnbutt_onclick()" type=button value="打印"></div>
</body>
</body>
</html>