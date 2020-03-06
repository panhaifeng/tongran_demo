<html>
<head>
<title>生产流转卡打印</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
<script language=javascript id=clientEventHandlersJS> 
{literal}
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
{/literal}
</script> 

{literal}
<style>
.ptable td {font-size:18px;}
.jianju{width:85px;}
.leftW{width:145px;}
</style>
{/literal}

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onafterprint="return window_onafterprint()" 
onbeforeprint="return window_onbeforeprint()">

<div>
   <table  border="0" cellpadding="0" cellspacing="0">
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
           <td align=left class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td align=center class="ptd jianju" >&nbsp;</td>
           <td class="ptd" align="right">{$smarty.now|date_format:"%Y &nbsp;&nbsp;&nbsp;%m &nbsp;&nbsp;&nbsp;%d"}</td>
         </tr>
       </table></td>
     </tr>
     <tr align="center" bgcolor="#FFFFFF">
       <td height="25" colspan="2">
       <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="ptable">
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">{$row.Order.Client.compName}</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd" >{$row.vatNum}</td>
          </tr>
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">{$row.Order.orderCode}</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd">&nbsp;</td>
          </tr>
         
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">&nbsp;</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd">{$row.Order.SaleKind.kindName}</td>
          </tr>
         
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">{if $row.Ware.mnemocode}{$row.Ware.mnemocode}{else}{$row.Ware.wareName},{$row.Ware.guige}{/if}</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd">&nbsp;</td>
          </tr>
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">{$row.OrdWare.colorNum}</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd">&nbsp;</td>
         </tr>
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">{$row.OrdWare.color}</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd">&nbsp;</td>
         </tr>
         <tr>
           <td class="ptd leftW" height="{$lineHeight|default:20}">{$row.cntPlanTouliao}kg</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd">&nbsp;</td>
         </tr>
         <tr>
           <td class="ptd leftW" align="right" height="{$lineHeight|default:20}">{$row.planTongzi}</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd">&nbsp;</td>
         </tr>
         <tr>
           <td class="ptd leftW" align="right" height="{$lineHeight|default:20}">{$row.unitKg}</td>
           <td align=center class="ptd jianju">&nbsp;</td>
           <td class="ptd">&nbsp;</td>
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