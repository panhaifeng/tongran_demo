<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script language="javascript" src="Resource/Script/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=100 height=200> 
<param name="Caption" value="我是打印控件lodop">
<param name="Color" value="#C0C0C0">
<embed id="LODOP_EM" type="application/x-print-lodop" width=130 height=200></embed>
</object>
<script language="javascript"> 
var aRow={$aRow|@json_encode};
//var LR={$xyIndex|@json_encode};
var offsetTop={$top};
var offsetLeft={$left};
//var lineHeight={$lineHeight}+'mm';

{literal}
var LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));
LODOP.PRINT_INIT('print');
// LODOP.SET_PRINT_PAGESIZE(1,'77mm','154mm','A4');
LODOP.SET_PRINT_STYLE("FontName",'微软雅黑');
LODOP.SET_PRINT_STYLE("FontSize",'12');
for(var i=0;aRow[i];i++){
LODOP.ADD_PRINT_TEXT(parseInt(aRow[i].top)+offsetTop+'mm',parseInt(aRow[i].left)+offsetLeft+'mm','50mm','10mm',aRow[i].Printname);
}
LODOP.PREVIEW();
//window.close();
window.location.href="Index.php?controller=Trade_Dye_Order&action=PlanManage";
{/literal}
</script>
</head>
<body>
如果不能正常打印请下载打印控件 地址：<a href="Resource/Script/lodop6.1/install_lodop32.exe">点击下载</a>   &nbsp; &nbsp;<a href="{url controller=$smarty.get.controller action='ShowPrintEdit'}">设置</a>
<!--http://localhost/tongran_dongnan/Resource/Script/lodop6.1/install_lodop32.exe-->
</body>
</html>
