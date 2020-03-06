<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>坯纱领料出库单</title>
{literal}
<script language="javascript">
function prnbutt_onclick() { 
	window.print(); 
	document.getElementsById('print2').style.display='none';
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
</script>
<style type="text/css">
.style1 {
	font-size: 14pt;
	font-weight: bold;
}
body {
	margin:0 auto;
}
#bodyDiv{ margin:0 auto; text-align:center;}
#TblMainInfo{border-collapse:collapse; border:solid 2px black; width:600px;}
#TblMainInfo td {FONT-FAMILY:"宋体,Arial";FONT-SIZE:14px;COLOR:#000; border-bottom:solid 1px black; border-right:solid 1px black;}
.foot{ width:600px}
.title {FONT-SIZE: 12pt}
.tr {height:30px;}
#hr{ text-align:center}
</style>
{/literal}
</head>

<body onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<div id="bodyDiv">
<div><b>{webcontrol type='GetAppInf' varName='compName'}坯纱领料出库单</b></div>
<table class="foot" align="center">
   <tr>
    <td align="left" >日期：{$aRow.0.chukuDate}</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table  border="0" cellspacing="0" cellpadding="0" id="TblMainInfo" align="center">
 
  <tr class="tr">
    <td style="width:auto;">客户</td>
    <td style="width:auto;">批号</td>
    <td style="width: auto;">缸号</td>
    <td style="width:auto;">纱支规格</td>
    <td style="width: auto;">颜色</td>
    <td >公斤数</td>
  </tr>
  {foreach from=$aRow item=item}
    <tr class="tr">
      <td >{$item.proName}</td>
      <td >{$item.pihao}</td>
      <td>{$item.vatNum}</td>
      <td >{$item.guige}</td>
      <td>{$item.color}</td>
      <td >{$item.cnt}</td>
    </tr>
  {/foreach}
  <tr>
    <td>合计</td>
    <td colspan="4"></td>
    <td>{$heji}</td>
  </tr>
</table>
<table class="foot" align="center">
<tr>
<td align="left">经手人：{$smarty.session.REALNAME}</td>
<td align="left">经手人签字：</td>
</tr>
</table>
<div  style="width:98%; text-align:center;">
<input name="print" type="button"  onclick="return prnbutt_onclick()" value="打&nbsp;&nbsp;印"/>
</div>
</div>
</body>
</html>
