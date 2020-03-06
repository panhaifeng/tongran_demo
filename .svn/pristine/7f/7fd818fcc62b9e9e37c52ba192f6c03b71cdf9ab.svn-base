<html>
<head>
<title>生产流转卡打印</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
{literal}
<script language=javascript id=clientEventHandlersJS> 

<!-- 
function prnbutt_onclick() 
{ 
window.print(); 
if(window.opener) window.close();
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

</script> 
{/literal}
{literal}
<style>
.ptable td {font-size:18px; font-weight:bold}
.jianju{width:145px;}
.jianju1{width:5px;}
.leftW{width:30px;}
.ptd1{width:130px;}
.ptdjianju{width:80px;}
.ptdjianju1{ white-space:nowrap}
</style>
{/literal} 

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onafterprint="return window_onafterprint()" 
onbeforeprint="return window_onbeforeprint()">

<div>
   <table  border="0" width="470" cellpadding="1" cellspacing="0">
     <tr align="center">
       <td height="{$top}" width="{$left}"></td>
       <td></td>
       <td ></td>
     </tr>
     <tr>
       <td rowspan="2"></td>
       <td height="30" colspan="2" align="right">
       <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="ptable">
         <tr>
           <td width="1" height="{$lineHeight|default:20}" align=left style="width:100px">{$smarty.now|date_format:'%Y-%m-%d'}</td>
           <td width="1" width="150px"><nobr>{$row.Order.SaleKind.kindName}</nobr></td>
            <td width="1" height="{$lineHeight|default:20}" align="right" style="width:150px">缸号：{$row.vatNum}</td>
          </tr>
       </table></tr>
     </tr>
     <tr align="center" bgcolor="#FFFFFF">
       <td height="25" colspan="2">
       <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="ptable">
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td align=left class="ptdjianju">
           <nobr>
           {$row.Order.Client.compName}
           </nobr>
           </td>
           <td class="jianju" >&nbsp;</td>
           <td class="ptd1" align="center" >{$row.OrdWare.colorNum}</td>
           <td class="ptd1" >&nbsp;           </td>
          </tr>
           <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td align=left class="ptdjianju1" style="font-size:14px;">{$row.pinggui}</td>
           <td class="jianju">&nbsp;</td>
           <td class="ptd1" align="left"><div style="margin-left:10px;">{$row.OrdWare.color}</div></td>
           <td class="ptd1">&nbsp;</td>
          </tr>
          
          
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td align=left class="ptdjianju">{$row.cntPlanTouliao}</td>
           <td class="jianju">&nbsp;</td>
           <td class="ptd1" align="left"><div style="margin-left:10px;">{$row.planTongzi}</div></td>
           <td class="ptd1"><div style="margin-left:20px;">{$row.unitKg}</div></td>
          </tr>
         
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td align=left class="ptdjianju">&nbsp;</td>
           <td class="jianju">&nbsp;</td>
           <td class="ptd1">&nbsp;</td>
           <td class="ptd1"><div style="margin-left:20px;">{$row.Vat.vatCode}</div></td>
          </tr>
         	<tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td colspan="4" class="ptd">&nbsp;</td>
          </tr>
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td colspan="4" class="ptd">{$row.Order.honggan}</td>
          </tr>
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td colspan="4" class="ptd">&nbsp;</td>
          </tr>
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td colspan="4" class="ptd">&nbsp;</td>
          </tr>
       </table></td>
     </tr>
  </table>
<span id=prn>
<br><br>
<center>
  <p>
    <input language=javascript id=prnbutt onClick="return prnbutt_onclick()" type=button value="打印"> 
  </p>
  <form name="form1" method="post" action="{url controller=$smarty.get.controller action='savePrint'}">
    行高：
    <input name="rowHeight" type="text" id="rowHeight" value="{$print.rowHeight}" size="10">
左偏移量：
<input name="offsetLeft" type="text" id="offsetLeft" value="{$print.offsetLeft}" size="10">
顶部偏移量：
<input name="offsetTop" type="text" id="offsetTop" value="{$print.offsetTop}" size="10">
<input type="submit" name="button" id="button" value="保存">
  <input name="dyeId" type="hidden" id="dyeId" value="{$smarty.get.id}">
  </form>
</center></span>

</div>
</body>
</html>