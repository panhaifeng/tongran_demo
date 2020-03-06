<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/LodopFuncs.js"></script>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="install_lodop.exe"></embed>
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/Print.css" type="text/css" rel="stylesheet" />
{literal}
<script language="javascript">
	function prnbutt_onclick() {
		window.print();
		return true;
	}

	//传递的参数处理
	var obj ={/literal}{$aRow|@json_encode}{literal};
	var codewidth ={/literal}{$codewidth|@json_encode}{literal};
	//var codetitle='{/literal}{$codetitle}{literal}';
	function prn1_preview() {
		CreateOneFormPage(obj.id,obj.barCode);
		//LODOP.PRINT_DESIGN();return false;
		LODOP.PREVIEW();
		if(window.opener) window.close();else window.location.href=document.referrer;
	};
	function prn1_setup() {
		CreateOneFormPage(obj.id,obj.barCode);
		LODOP.PRINT_setup();
	};
	function prn1_design() {
		CreateOneFormPage(obj.id,obj.barCode);
		LODOP.PRINT_design();
	};
	var LODOP;
	function CreateOneFormPage(strPartNumber,strCodeValue){

		LODOP=getLodop(document.getElementById('LODOP'),document.getElementById('LODOP_EM'));
		var num = 0;
		//新版本的
		LODOP.PRINT_INIT("排缸卡打印");
		LODOP.SET_PRINT_PAGESIZE(0,710,1000,"");

		LODOP.PRINT_INITA(0,0,268,378,"排缸卡打印");
		LODOP.SET_PRINT_PAGESIZE(0,710,1000,"");
		LODOP.ADD_PRINT_BARCODE("10.1mm",18,237,"18mm","",obj.vatNum);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
		LODOP.ADD_PRINT_TEXT("28.3mm",10,252,25,"南通苏彩坊纺织有限公司");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.SET_PRINT_STYLEA(0,"Horient",2);
		LODOP.ADD_PRINT_TEXT("33.1mm",56,157,23,"排缸卡");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.SET_PRINT_STYLEA(0,"Horient",2);
		LODOP.ADD_PRINT_TEXT("37.6mm",9,209,20,"客户："+obj.compName);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_LINE("42.1mm",0,158,"70.1mm",0,1);
		LODOP.ADD_PRINT_LINE("51.1mm",1,192,266,0,1);
		LODOP.ADD_PRINT_LINE("59.5mm",1,224,266,0,1);
		LODOP.ADD_PRINT_LINE("67.7mm",1,255,266,0,1);
		LODOP.ADD_PRINT_LINE("76.7mm",2,289,267,0,1);
		LODOP.ADD_PRINT_LINE("82.4mm",1,310,266,0,1);
		LODOP.ADD_PRINT_LINE("42.1mm","13.5mm","82.3mm",52,0,1);
		LODOP.ADD_PRINT_LINE("82mm",138,158,139,0,1);
		LODOP.ADD_PRINT_LINE("41.8mm",180,290,181,0,1);
		LODOP.ADD_PRINT_TEXT("44.7mm",9,43,20,"机号");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("52.9mm",9,43,20,"纱批");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("61.4mm",8,43,20,"纱支");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("70.1mm",8,43,20,"重量");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("44.4mm",52,86,20,obj.vatCode);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
		LODOP.ADD_PRINT_TEXT("52.9mm",48,97,20,obj.pihao);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.ADD_PRINT_TEXT("61.4mm",47,101,20,obj.wareName);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.ADD_PRINT_TEXT("70.1mm",49,86,20,obj.cntPlanTouliao);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.ADD_PRINT_TEXT("44.7mm",144,47,20,"颜色");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("44.7mm",182,88,20,obj.color);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.ADD_PRINT_TEXT("53.2mm",144,41,20,"色号");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("61.4mm",144,42,20,"只数");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("70.1mm",144,42,20,"损重");
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("53.2mm",182,88,20,obj.colorNum);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		LODOP.ADD_PRINT_TEXT("61.4mm",182,88,20,obj.planTongzi);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
		LODOP.SET_PRINT_STYLEA(0,"Bold",1);
		LODOP.ADD_PRINT_TEXT("70.1mm",182,88,20,obj.sunJkg);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
		LODOP.ADD_PRINT_TEXT("84.1mm",5,256,55,"备注："+obj.memo);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
        LODOP.ADD_PRINT_TEXT(292,8,42,21,"层高");
        LODOP.ADD_PRINT_TEXT(292,50,79,21," "+obj.fenceng);
	};


</script>

<style type="text/css">
table tr{height:40px;}
.title{font-weight:bold; text-align:right;}
</style>
{/literal}
</head>

<body onLoad="prn1_preview();"
onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="0">
     <tr align="center">
       <td height="25" style="font-size:24px; font-weight:bold;">
  {webcontrol type='GetAppInf' varName='compName'}-排缸卡打印</td>
     </tr>
      <tr>
       <td height="100" valign="middle" align="center"><font size="+1"><b>{$aRow.vatNum|default:'&nbsp;'}</b> </font></td>
     </tr>
     <tr align="center" bgcolor="#FFFFFF">
       <td height="25">&nbsp;</td>
     </tr>
  </table>
<div id="prn" align="center">
 <input type="button" value="打印预览" onClick="prn1_preview()">
</div>
</body>
</html>
