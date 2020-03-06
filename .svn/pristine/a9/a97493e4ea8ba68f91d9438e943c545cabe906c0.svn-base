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
#TblMainInfo{border-collapse:collapse; border:solid 2px black; width:98%}
#TblMainInfo td {FONT-FAMILY:"宋体,Arial";FONT-SIZE:14px;COLOR:#000; border-bottom:solid 1px black; border-right:solid 1px black;}
#foot{ width:98%}
.title {FONT-SIZE: 12pt}
.tr {height:30px;}
.textbox{ width:80px;}
#hr{ text-align:center}
</style>
{/literal}
</head>

<body onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<table  border="0" cellspacing="0" cellpadding="0" id="TblMainInfo">
  <tr  id="hr" >
    <td colspan="7"><b>{webcontrol type='GetAppInf' varName='compName'}坯纱领料出库单</b></td>
  </tr>
  <tr class="tr">
    <td colspan="2">日期：{$aRow.chukuDate}</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" style="width:5%">领料部门：{$aRow.Department.depName}</td>
  </tr>
  <tr class="tr">
    <td>缸号</td>
    <td>客户</td>
    <td>纱支规格</td>
    <td>颜色</td>
    <td>色号</td>
    <td>公斤数</td>
    <td width="10%">&nbsp;</td>
  </tr>
  {foreach from=$aRow.Wares item=item}
<tr class="tr">
        <td>{$item.Gang.vatNum}</td>
        <td>{$item.Client.compName}</td>
        <td>{$item.Ware.wareName}[{$item.Ware.guige}]</td>
        <td>{$item.Gang.OrdWare.color}</td>
        <td>{$item.Gang.OrdWare.colorNum}</td>
        <td>{$item.cnt}</td>
        <td>&nbsp;</td>
      </tr>
  {/foreach}
</table>
<table id="foot">
<tr>
<td style="width:80%">经手人：{$smarty.session.REALNAME}</td>
<td>经手人签字：</td>
</tr>
</table>
<div  style="width:98%; text-align:center;">
<input name="print" type="button"  onclick="return prnbutt_onclick()" value="打&nbsp;&nbsp;印"/>
<input name="print2" id="print2" type="button" onclick="window.location.href='Index.php?controller=CangKu_ChuKu&action=PrintRecords2&id={$aRow.id}'" value="汇总打印" />
</div>
</body>
</html>
