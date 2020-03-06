<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>坯纱入库单打印</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
{literal}
<style type="text/css">
td {FONT-SIZE:14px;}
.haveBorder{border-top:1px solid #000000; border-left:1px solid #000}
.haveBorder td { border-bottom:1px solid #000; border-right:1px solid #000}
.caption {font-size:22px; font-weight:bold;}
.caption span{font-size:12px; font-weight:normal}
.th td{font-weight:bold}
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
<body style="margin-top:0px" onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<table align="center" width="700">
<tr width="700"><td align="center" class="caption" colspan="3">{webcontrol type='GetAppInf' varName='compName'}坯纱入库单</td></tr>
<tr>
<td >客户名称: {$arr_field_value.Client.compName}</td>
<td align="center">入库单号: {$arr_field_value.ruKuNum} &nbsp;&nbsp;送货单号: {$arr_field_value.songhuoCode}</td>
<td align="right">入库日期: {$arr_field_value.ruKuDate}</td>
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
      {foreach from=$arr_field_value.Wares item=item} 
  	  <tr style="height:17px;">
	  	{foreach from=$arr_field_info key=key item=item1}
    	<td align="center" style="border-top: 1px solid #cccccc;">{$item.$key|default:'&nbsp;'}</td>
    	{/foreach}
  	  </tr>
      {/foreach}
</table></td></tr>
<tr><td colspan="3">
<table width="100%" class="haveBorder" cellpadding="2" cellspacing="0">
<tr>
  <td width="350" height="31">送货方签字确认:</td>
  <td colspan="2">收货操作人:{$smarty.session.REALNAME}</td></tr>
</table>
</td></tr>
<tr>
  <td colspan="3">*注:如数量有差异, 请当天提出, 否则以此单为准! </td></tr>
</table>
<div id=prn align="center">
	<input id=prnbutt onClick="return prnbutt_onclick()" type=button value=" 打 印 ">
	<input name="Back" type="button" id="Back" value=' 返 回 ' onClick="javascript:window.location.href='Index.php?controller=CangKu_RuKu&action=right'"></div>
</body>
</html>
