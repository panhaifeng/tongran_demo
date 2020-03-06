<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工艺处方单</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css">
{literal}
<style type="text/css">
body,form,table{margin:0px; padding:0px;}
td{font-size:18px;}
td span{font-weight:bold;}
.haveBorder{border:1px solid #000;}
.th td {font-weight:bold;}
.haveBorder td {border-bottom:1px solid #000; border-right:1px solid #000; border-collapse:collapse; height:15px;}
.caption{font-size:18px; font-weight:bold;}
</style>
{/literal}
</head>
<body>
<div class="caption" align="center">工艺处方单</div>
<form name="form1" method="post" action="{url controller=$smarty.get.controller action='SaveForLl'}" id='form1'>
	  <input name="gangId" type="hidden" id="gangId" value="{$chufang.Gang.id}">
      <input name="chufangId" type="hidden" id="chufangId" value="{$chufang.id}">
<table width="700" align="center">
	<tr><td colspan="3">
		<table width="100%">
		<tr align="left">
		<td><span>客户名：</span>{$chufang.clientName}</td>
		<td><span>颜色：</span>{$chufang.OrdWare.color}</td>
		<td><span>色号：</span>{$chufang.OrdWare.colorNum}</td>
		<td><span>纱支：</span>{$chufang.guige}</td>
		</tr>
		<tr align="left">
		<td height=15px><span>缸号：</span>{$chufang.Gang.vatNum}		    </td>
		<td><span>总公斤数：</span>{$chufang.Gang.cntPlanTouliao}</td>
		<td><span>折率：</span>{$chufang.Gang.rsZhelv}</td>
		<td><span>筒子数量：</span>{$chufang.Gang.planTongzi}</td>
		</tr>
		<tr align="left">
		<td height=15px><span>包数：</span>{$chufang.Gang.cntPlanTouliao/5} </td>
		<td><span>染坯要求：</span>{$chufang.dyeKind} </td>
		<td><span>锅型：</span>{$chufang.Gang.Vat.vatCode}</td>
		<td><span>水容量：</span>{$chufang.Gang.shuirong}升</td>
		</tr>
		<tr><td></td><tr>
		</table>
	</td></tr>
	
	<tr>
	<td colspan="3">
	<table width="100%" border="0" cellpadding="2px" cellspacing="0" class="haveBorder" >
	<tr class=th>
	<td height="15px" align="center">染化料/助剂</td>
	<td align="center">用量(单位)</td>
	<td align="center">缸用量kg</td>
	<td align="center">温度</td>
	<td align="center">时间</td>
	<td align="center">备注</td>
	</tr>
	{foreach from=$ranliao item=item}
	<tr>
	<td align="center" style="height:15px">{$item.wareName|default:'&nbsp;'}
	<input type="hidden" name="wareId[]" id="wareId[]" value="{$item.wareId}"></td>	  
	<td align="center">{$item.unitKg}{$item.unit}&nbsp;</td>
	<td align="center">{$item.vatCnt|default:'&nbsp;'}
	<input type="hidden" name="cnt[]" id="cnt[]" value="{$item.vatCnt}"></td>
	<td align="center">{$item.tmp|default:'&nbsp;'}</td>
	<td align="center">{$item.timeRs|default:'&nbsp;'}</td>
	<td align="center">{$item.memo|default:'&nbsp;'}</td>
	</tr>				
	{/foreach}
	
	  
		</table>
	</td>
	</tr>
	
	<tr>
	<td height='30px'>处方人: {$chufang.chufangren}</td>
	<td height='30px' align="right">&nbsp;</td>
	<td height='30px' align="right">打印日期:{$smarty.now|date_format:"%Y-%m-%d"}</td>
	</tr>
</table>
<div id=prn align="center">
	{if $smarty.get.for=='ll'}
<input type='button' value="确定出库" onClick="document.getElementById('form1').submit()">
    <input onClick="window.location.href='{url controller=$smarty.get.controller action='right'}'" type=button value="取消">
  	{/if}
</div>


</form></body></html>
