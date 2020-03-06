
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />

<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
<param name="Caption" value="我是打印控件lodop">
<param name="Color" value="#C0C0C0">
<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
<script language="javascript" src="Resource/Script/jquery1.10.1.js"></script>
<script language="javascript" src="Resource/Script/jquery-barcode.js"></script>
<script language="javascript" src="Resource/Script/LodopFuncs.js"></script>
{literal}
<style type="text/css">
/*body {margin: 0;}*/
td {FONT-SIZE:14px;}
.haveBorder{border-top:1px solid #000000; border-left:1px solid #000}
.haveBorder td { border-bottom:1px solid #000; border-right:1px solid #000}
.th td{font-weight:bold}
table {border-collapse:collapse;}
/*table table{ border-style:hidden; border-width:0px;}*/
.a td{border: 1px solid #000000;}
/*.text {letter-spacing:-1px;} 只在lodop引用 打印会在原理的字间距上面加1 所以这边-1 和页面0 一样效果*/
</style>
{/literal}
<script language="javascript">
{literal}
var LODOP; //声明为全局变量 
$(function(){
	var value = $("#imgcode").attr('value');
	$("#bcTarget").barcode($("#imgcode").attr('value'), "code93",{barWidth:2, barHeight:50,fontSize:20,letterSpacing:5,fontWeight:'bold',addQuietZone:false});
});
function prn_Preview() {        
    CreateOneFormPage();
    LODOP.PREVIEW();
    // LODOP.PRINT_DESIGN(); 
    // window.location.href="Index.php?controller=Trade_Dye_Order&action=PlanManage"; 
    if(window.opener) window.close();else window.location.href=document.referrer;
};
function CreateOneFormPage(){
    LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));
    LODOP.PRINT_INIT("条码打印功能");
    // LODOP. SET_PRINT_PAGESIZE(1,1800,2560,"");
    LODOP. SET_PRINT_PAGESIZE(1,0,0,"B5 (JIS)");
    // LODOP. SET_PRINT_PAGESIZE(2,2560,1830,"");

    LODOP.SET_PRINT_STYLE("FontSize",15);
    LODOP.SET_PRINT_STYLE("Bold",1);
    var strBodyStyle="<style>td {FONT-SIZE:15px;}.haveBorder{border-top:1px solid #000000; border-left:1px solid #000}.haveBorder td { border-bottom:1px solid #000; border-right:1px solid #000}.th td{font-weight:bold}table {border-collapse:collapse;}.a td{border: 1px solid #000000;}.text {letter-spacing:-1px;}</style>";
    var strFormHtml=strBodyStyle+"<body>"+document.getElementById("mian").innerHTML+"</body>";
    LODOP.ADD_PRINT_HTM(0,0,'50%','100%',strFormHtml);
}; 
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
{/literal}
</script>
</head>
<body onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<div id='mian'>
    <table align="center" width="645px" cellpadding="0" cellspacing="0"  style="margin-bottom: 5px;">
    	<tr>
    		<td colspan="2">&nbsp;</td>
    		<td colspan="2" rowspan="2"><!-- <img id="imgcode" value='{$aRow.vatNum}' /> --><input type="hidden" id="imgcode" value='{$aRow.vatNum}'><div id="bcTarget" class="barcodeImg"></div>  </td>
    	</tr>
    	<tr>
    		<td colspan="2" style="font-size: 36;font-weight: bold;">苏彩坊流程卡</td>
    	</tr>
    	<tr>
    		<td width="50%" colspan="2">客户名称：{$aRow.compName}</td>
            <!-- <td width="25%" align="right"></td> -->
            <td width="25%">交货日期：{$aRow.dateJiaohuo}</td>
            <td width="25%">机号：{$aRow.vatCode}</td>
    	</tr>
    </table>
    <table width="645px" align="center" class="a">
        <tr align="center" height="36" class="th"> 
            <td width="7%" >纱支<br>品种</td>
            <td width="22%">{$aRow.guigeNew}</td>
            <td width="7%">款号</td>
            <td width="20%">{$aRow.kuanhao}</td>
            <td width="7%">层高</td>
            <td width="17%">{$aRow.cengCnt}</td>
            <td width="8%">公斤数</td>
            <td width="12%">{$aRow.cntPlanTouliao}</td>
        </tr>
        <tr align="center" height="36" class="th"> 
            <td width="7%" >客户<br>缸号</td>
            <td width="22%">{$aRow.ganghaoKf}</td>
            <td width="7%">色号</td>
            <td width="20%">{$aRow.colorNum}</td>
            <td width="7%">是否加急</td>
            <td width="17%">{$aRow.isJiaji}</td>
            <td width="8%">损净重</td>
            <td width="12%">{$aRow.sunJkg}</td>
        </tr>
        <tr class="th" align="center" height="36">
            <td >纱批</td>
            <td>{$aRow.pihao}</td>
            <td>颜色</td>
            <td>{$aRow.color}</td>
            <td>单筒重</td>
            <td>{$aRow.unitKg}</td>
            <td>筒子<br>支数</td>
            <td>{$aRow.planTongzi}</td>
        </tr>
        <tr>
            <td height="33" colspan="8"><SPAN style="font-weight:bold;font-size: 15px">领纱仓库：  批号：{$aRow.pihao}</SPAN></td>
        </tr>
<!--         <tr>
            <td colspan="8" >
                
            </td>
        </tr> -->
    </table>
    <table width="645px" height="70px" align="center" cellspacing="0" cellpadding="0" style="border-left:1px solid #000;border-right:1px solid #000;" >
        <tr valign="top">
            <td width="75px" >质量要求：</td>
            <td class="text">1、白布沾色牢度{$aRow.fastness_baizhan}级.2、原样变化{$aRow.fastness_yuanyang}级。3、干摩牢度{$aRow.fastness_gan}级。4、湿摩牢度{$aRow.fastness_shi}级<br>
            5、日晒牢度{$aRow.fastness_rishai}级。6、汗渍牢度{$aRow.fastness_hanzi}级。{$aRow.yaoqiu}</td>
        </tr>

    </table>
    <table width="645px" height="70px" align="center" class="a" cellpadding="0" cellspacing="0" >
        <tr valign="top">
            <td width="50%" class="text">14.包装要求：{$aRow.packing_memo}</td>
            <td width="50%" class="text">15.其他：{$aRow.order2memo}</td>
        </tr>
    </table>
    <table width="645px" align="center" style="height: 60px;border-top: 0;"  cellpadding="0" cellspacing="0" class="haveBorder">
        <tr height="50%" align="center">
            <td style="width: 14%;">配纱重量</td>
            <td style="width: 14%;">配纱只数</td>
            <td style="width: 14%;">装纱</td>
            <td style="width: 14%;">染色</td>
            <td style="width: 14%;">后处理</td>
            <td style="width: 14%;">烘干</td>
            <td style="width: 14%;">检验</td>
        </tr>
        <tr height="50%">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<table align="center" style=" margin-top: 10px " id=prn>
    <tr>
        <td>
            <input type="button" value="网页打印" name="B2"  onclick="prnbutt_onclick()">
            <input type="button" value="控件打印" name="B3"  onclick="prn_Preview()"> 
        </td>
    </tr>
</table>
     



<!-- 
<br>
<br>
<br>
<table width="750px" align="center" width="750px" cellpadding="0" cellspacing="0" class="haveBorder" style="border-collapse: collapse;">
  <tr class="th" align="center"> 
    <td width="7%" height="36" align="center">纱支<br>品种</td>
    <td width="22%" align="center">{$aRow.guige}</td>
    <td width="7%" align="center">款号</td>
    <td width="20%" align="center"></td>
    <td width="7%" align="center">层高</td>
    <td width="17%" align="center">{$aRow.cengCnt}</td>
    <td width="8%" align="center">公斤数</td>
    <td width="12%" align="center">{$aRow.cntPlanTouliao}</td>
  </tr>
  <tr class="th" align="center"> 
    <td width="7%" height="36" align="center">客户<br>缸号</td>
    <td width="22%" align="center">&nbsp;</td>
    <td width="7%" align="center">色号</td>
    <td width="20%" align="center">{$aRow.colorNum}</td>
    <td width="7%" align="center"></td>
    <td width="17%" align="center">&nbsp;</td>
    <td width="8%" align="center">损净重</td>
    <td width="12%" align="center">{$aRow.sunJkg}</td>
  </tr>
  <tr class="th" align="center">
    <td height="33">纱批</td>
    <td>{$aRow.pihao}</td>
    <td>颜色</td>
    <td>{$aRow.color}</td>
    <td>单筒重</td>
    <td>{$aRow.unitKg}</td>
    <td>筒子<br>支数</td>
    <td>{$aRow.planTongzi}</td>
  </tr>
  <tr>
    <td height="33" colspan="8"><SPAN style="font-weight:bold;font-size: 15px">领纱仓库：  批号：{$aRow.pihao}</SPAN></td>
  </tr>
  <tr>
    <td height="70px" colspan="8" >
    	<table width="100%" style="height: 100%;"  cellspacing="0" cellpadding="0" style="border-collapse: collapse;border-width:0px; border-style:hidden;" >
    		<tr valign="top">
    			<td width="75px" >质量要求：</td>
    			<td>1、白布沾色牢度{$aRow.fastness_baizhan}级.2、原样变化{$aRow.fastness_yuanyang}级。3、干摩牢度{$aRow.fastness_gan}级。4、湿摩牢度{$aRow.fastness_shi}级<br>
				5、日晒牢度{$aRow.fastness_rishai}级。6、汗渍牢度{$aRow.fastness_hanzi}级。{$aRow.yaoqiu}</td>
    		</tr>

    	</table>

    </td>
  </tr>
  <tr>
    <td height="60" colspan="8" style="border-collapse: collapse;">
    	<table width="100%" style="height: 100%;" cellpadding="0" cellspacing="0"  style="border-collapse: collapse;border-style:hidden;">
    		<tr valign="top">
    			<td width="50%" >14.包装要求：1.纸管 {$aRow.packing_zhiguan}2.塑料袋 {$aRow.packing_suliao}3.外包装 {$aRow.packing_out}</td>
    			<td width="50%" >15.其他：</td>
    		</tr>
    	</table>
    </td>
  </tr>
  <tr>
    <td height="50" colspan="8" style="border-collapse: collapse;" class="haveBorder">
    	<table width="100%" style="height: 100%;"  cellpadding="0" cellspacing="0" style="border-collapse: collapse;border-style:hidden;">
    		<tr height="50%" align="center">
    			<td style="width: 14%;">配纱重量</td>
    			<td style="width: 14%;">配纱只数</td>
    			<td style="width: 14%;">装纱</td>
    			<td style="width: 14%;">染色</td>
    			<td style="width: 14%;">后处理</td>
    			<td style="width: 14%;">烘干</td>
    			<td style="width: 14%;">检验</td>
    		</tr>
    		<tr height="50%">
    			<td></td>
    			<td></td>
    			<td></td>
    			<td></td>
    			<td></td>
    			<td></td>
    			<td></td>
    		</tr>
    	</table>
    </td>
  </tr>

</table> -->
</body>
</html>
