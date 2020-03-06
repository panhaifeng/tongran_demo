<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script language="javascript" src="Resource/Script/LodopFuncs.js"></script>
<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
<param name="Caption" value="我是打印控件lodop">
<param name="Color" value="#C0C0C0">
<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript"> 
{literal}
var obj = {/literal}{$aRow|@json_encode}{literal};
var LODOP; //声明为全局变量  
function prn_Preview() {		
	CreatePrintPage();
  	LODOP.PREVIEW();
  	// LODOP.PRINT_DESIGN();		
};
function CreatePrintPage() {
	LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));
	LODOP.PRINT_INIT("条码打印功能");
	var len = 2;//每一行相差2mm
	// LODOP.SET_PRINT_PAGESIZE(3,980,220,"");
	// LODOP.PRINT_INIT(0,0,370,83,"打印任务名");
	var cishu = Math.ceil(parseInt(document.getElementById('printCnt').value)/3);
	LODOP.SET_PRINT_PAGESIZE(3,980,220,"");
	for (var i = 0; i < cishu; i++) {
		// LODOP.ADD_PRINT_RECT((i*22)+1.91+"mm","0.9mm","30mm","20mm",0,1);
		// LODOP.ADD_PRINT_RECT((i*22)+1.91+"mm","33.44mm","30mm","2cm",0,1);
		// LODOP.ADD_PRINT_RECT((i*22)+1.91+"mm","65.99mm","30mm","20mm",0,1);
		LODOP.ADD_PRINT_TEXT((i*(20+len))+2.38+"mm","1.91mm","31.75mm","6.61mm","纱支:"+obj.wareName);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT((i*22)+8.2+"mm","1.91mm","31.75mm","6.61mm","色号:"+obj.colorNum);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT((i*22)+14.02+"mm","1.91mm","31.75mm","6.61mm","缸号:"+obj.vatNum);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT((i*22)+2.38+"mm","34.4mm","31.75mm","6.61mm","纱支:"+obj.wareName);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT((i*22)+8.2+"mm","34.4mm","31.75mm","6.61mm","色号:"+obj.colorNum);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT((i*22)+14.02+"mm","34.4mm","31.75mm","6.61mm","缸号:"+obj.vatNum);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT((i*22)+2.38+"mm","66.99mm","31.75mm","6.61mm","纱支:"+obj.wareName);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT((i*22)+8.2+"mm","66.99mm","31.75mm","6.61mm","色号:"+obj.colorNum);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT((i*22)+14.02+"mm","66.99mm","31.75mm","6.61mm","缸号:"+obj.vatNum);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	}
}
{/literal}
</script>
</head>
<body>
<fieldset>     
<legend>打印条码个数设定</legend>
<div align="center">
<table width="90%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td align="right">输入打印的个数：</td>
    <td><input name="printCnt" type="text" id="printCnt" value="{$aRow.printCnt}"/></td>
  </tr>
  <tr>
    <td colspan='2'>注意：打印个数请设置为3个倍数。不符合则取最大的倍数进行打印。例: 打印个数为4时则打印2行为6个,因为单行为3个条码！</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="button" value="打印预览" name="B3"  onclick="prn_Preview()"> </td>
  </tr>
</table>
</div>
</fieldset>
</body>
</html>
