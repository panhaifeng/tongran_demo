<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工艺处方单打印</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css">
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />

<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
<param name="Caption" value="我是打印控件lodop">
<param name="Color" value="#C0C0C0">
<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
<script language="javascript" src="Resource/Script/jquery1.10.1.js"></script>
<script language="javascript" src="Resource/Script/jquery-barcode.js"></script>
<!-- {webcontrol type='LoadJsCss' src="Resource/Script/lodop/last/LodopFuncs.js"} -->
<script language="javascript" src="Resource/Script/LodopFuncs.js"></script>
{literal}
<script language="javascript">
var LODOP; //声明为全局变量 
$(function(){
	var obj = {/literal}{$row|@json_encode}{literal};
	var gy = {/literal}{$gy|@json_encode}{literal};

	CreateOneFormPage(obj,gy);
	{/literal}
		{if $smarty.get.preview==1}
		LODOP.PREVIEW();
		{else}
		LODOP.PREVIEW();
		// LODOP.PRINT_DESIGN();
		// return false;
		// LODOP.PRINT();
		{/if}
		{literal}if(window.opener) window.close();else window.location.href=document.referrer;

});
 function CreateOneFormPage(obj,gy){
    LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));    
	LODOP.PRINT_INIT("东阳-处方单打印");
	LODOP.SET_PRINT_PAGESIZE(1,0,0,"A4");
	LODOP.ADD_PRINT_BARCODE(17,"55mm",182,40,"",obj.Gang[0].vatNum);
	LODOP.ADD_PRINT_TEXT(27,436,243,30,"染色工艺单");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",20);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
	LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",10);
	LODOP.ADD_PRINT_TEXT("15.9mm",18,73,20,"逻辑缸号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(79,18,73,20,"客户");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(96,18,73,20,"规格");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT("15.9mm",89,120,20,obj.Gang[0].vatNum);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(79,89,120,20,obj.compName);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(96,89,120,20,obj.Gang[0].guige);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT("15.9mm","55mm",54,20,"色号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(96,207,77,20,"投染数kg");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT("15.9mm",262,110,20,obj.colorNum);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(96,284,100,20,obj.touliaoCnt);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT("15.9mm",370,44,20,"颜色");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(60,410,132,20,obj.color);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT("15.9mm",544,89,20,obj.dateChufang);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(79,"55mm",58,20,"机台号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(79,262,73,20,obj.vatCode);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(79,402,54,20,"计划数");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(79,456,115,20,obj.Gang[0].cntPlanTouliao);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(96,380,54,20,"水量");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(96,428,69,20,obj.shuirong);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(96,500,49,20,"浴比");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(96,550,91,20,obj.yubi);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);

	LODOP.ADD_PRINT_SHAPE(1,"29.9mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"36mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"41mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"46mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"51.1mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"56.1mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"61.1mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"65.9mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"70.9mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"29.9mm",18,1,"94.7mm",0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"29.9mm",207,1,155,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"29.9mm",332,1,155,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,113,481,1,155,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"75.4mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"79.9mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"84.4mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"88.9mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"93.4mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"97.9mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"102.4mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"106.9mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"111.4mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"115.6mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"120.1mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"124.6mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"70.9mm",245,1,"53.4mm",0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"70.9mm",480,1,202,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,112,732,1,360,0,1,"#C0C0C0");
	
	LODOP.ADD_PRINT_SHAPE(0,"79.9mm",127,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"79.9mm",180,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"79.9mm",362,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"79.9mm",416,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"79.9mm",604,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"79.9mm",663,1,169,0,1,"#C0C0C0");

	// LODOP.ADD_PRINT_LINE("29.9mm",18,114,732,0,1);
	// LODOP.ADD_PRINT_LINE("36mm",18,137,732,0,1);
	// LODOP.ADD_PRINT_LINE("41mm",18,156,481,0,1);
	// LODOP.ADD_PRINT_LINE("46mm",18,175,481,0,1);
	// LODOP.ADD_PRINT_LINE("51.1mm",18,194,481,0,1);
	// LODOP.ADD_PRINT_LINE("56.1mm",18,213,481,0,1);
	// LODOP.ADD_PRINT_LINE("61.1mm",18,232,481,0,1);
	// LODOP.ADD_PRINT_LINE("65.9mm",18,250,481,0,1);
	// LODOP.ADD_PRINT_LINE("70.9mm",18,269,732,0,1);
	// LODOP.ADD_PRINT_LINE("124.6mm",18,"29.9mm",19,0,1);
	
	// LODOP.ADD_PRINT_LINE("70.9mm",207,113,208,0,1);
	// LODOP.ADD_PRINT_LINE("70.9mm",332,113,333,0,1);
	// LODOP.ADD_PRINT_LINE(268,481,113,482,0,1);
	// LODOP.ADD_PRINT_LINE("75.4mm",18,286,732,0,1);
	// LODOP.ADD_PRINT_LINE("79.9mm",18,303,732,0,1);
	// LODOP.ADD_PRINT_LINE("84.4mm",18,320,732,0,1);
	// LODOP.ADD_PRINT_LINE("88.9mm",18,337,732,0,1);
	// LODOP.ADD_PRINT_LINE("93.4mm",18,354,732,0,1);
	// LODOP.ADD_PRINT_LINE("97.9mm",18,371,732,0,1);
	// LODOP.ADD_PRINT_LINE("102.4mm",18,388,732,0,1);
	// LODOP.ADD_PRINT_LINE("106.9mm",18,405,732,0,1);
	// LODOP.ADD_PRINT_LINE("111.4mm",18,422,732,0,1);
	// LODOP.ADD_PRINT_LINE("115.6mm",18,438,732,0,1);
	// LODOP.ADD_PRINT_LINE("120.1mm",18,455,732,0,1);
	// LODOP.ADD_PRINT_LINE("124.6mm",18,472,732,0,1);
	// LODOP.ADD_PRINT_LINE("124.4mm",245,"70.9mm",246,0,1);
	// LODOP.ADD_PRINT_LINE("124.4mm",480,268,481,0,1);
	// LODOP.ADD_PRINT_LINE(472,732,112,733,0,1);
	LODOP.ADD_PRINT_TEXT("31.8mm",19,100,20,"染料方案");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(120,215,100,20,"配方");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(120,336,100,20,"实际重g");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(120,498,221,20,"备注");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
	//染料数据
	var j = 0;
	var text = '';
	for(var a=0;a<obj.rlzj.length;a++) {
		for (var i = 0;i<obj.rlzj[a].length; i++) {
			LODOP.ADD_PRINT_TEXT(139+(j*19),19,192,20,obj.rlzj[a][i].guige);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT(139+(j*19),215,116,20,obj.rlzj[a][i].peifang);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.ADD_PRINT_TEXT(139+(j*19),335,202,20,obj.rlzj[a][i].cntKg||'');
			LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			j++;
			text = obj.rlzj[a][i].isZhuji;
		}
		j++;
		
	}
	// LODOP.ADD_PRINT_TEXT(139,19,192,20,"安诺苏3BE红");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.ADD_PRINT_TEXT(139,215,116,20,"0.6");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	// LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	// LODOP.ADD_PRINT_TEXT(139,335,202,20,"11558.4");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	// LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	//染色助剂
	LODOP.ADD_PRINT_TEXT(270,19,100,20,"染色工艺代号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(270,118,100,20,gy.Rsgy);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(270,245,114,20,"前处理工艺代号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(270,367,109,20,gy.Qclgy);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(270,488,114,20,"后处理工艺代号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(270,612,109,20,gy.Hclgy);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(287,19,74,20,"染色助剂");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(286,245,100,20,"前处理助剂");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(287,487,100,20,"后处理助剂");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.ADD_PRINT_LINE("124.6mm",127,302,128,0,1);
	// LODOP.ADD_PRINT_LINE("124.6mm",180,302,181,0,1);
	// LODOP.ADD_PRINT_LINE("124.6mm",362,302,363,0,1);
	// LODOP.ADD_PRINT_LINE("124.6mm",416,302,417,0,1);
	// LODOP.ADD_PRINT_LINE("124.6mm",604,302,605,0,1);
	// LODOP.ADD_PRINT_LINE("124.6mm",663,302,664,0,1);
	LODOP.ADD_PRINT_TEXT(304,18,72,20,"助剂名称");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(304,128,51,20,"配方");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(304,182,71,20,"实际重KG");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(304,246,72,20,"助剂名称");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(304,362,51,20,"配方");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(304,417,71,20,"实际重KG");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(304,482,72,20,"助剂名称");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(304,605,46,20,"配方");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(304,665,73,20,"实际重KG");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(473,18,180,20,"制单人："+obj.chufangren);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(473,168,100,20,"审核人：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(473,347,312,20,"第一缸染料总数 单位：克  "+gy.cntKg);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(136,482,250,136,gy.memo||'');
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	//染色工艺
	var x = 0;
	var text = '';
	for(var i=0;obj.Arr[i];i++) {
		if (obj.Arr[i].gongxuId==2) {
			if (text) {
				if (text != obj.Arr[i].isZhuji) {
					x=x+1;
				}
			}
			// LODOP.ADD_PRINT_TEXT(323+(x*18),19,110,20,obj.Arr[i].guige);
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.48))+'mm',19,118,16,obj.Arr[i].guige);
			// LODOP.ADD_PRINT_TEXT(322,128,57,20,obj.Arr[i].peifang);
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.4))+'mm',128,57,20,obj.Arr[i].peifang);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.4))+'mm',182,71,20,obj.Arr[i].cntK||'');
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			x++;
			text = obj.Arr[i].isZhuji;
		}
	}
	
	//前处理
	var x = 0;
	var text = '';
	for(var i=0;obj.Arr[i];i++) {
		if (obj.Arr[i].gongxuId==1) {
			if (text) {
				if (text != obj.Arr[i].isZhuji) {
					x=x+1;
				}
			}
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.48))+'mm',246,126,16,obj.Arr[i].guige);
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.4))+'mm',363,57,20,obj.Arr[i].peifang);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.4))+'mm',419,71,20,obj.Arr[i].cntK||'');
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			x++;
			text = obj.Arr[i].isZhuji;
		}
	}
	//后处理
	var x = 0;
	var text = '';
	for(var i=0;obj.Arr[i];i++) {
		if (obj.Arr[i].gongxuId==3) {
			if (text) {
				if (text != obj.Arr[i].isZhuji) {
					x=x+1;
				}
			}
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.48))+'mm',482,127,16,obj.Arr[i].guige);
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.4))+'mm',605,57,20,obj.Arr[i].peifang);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((85.5+(x*4.4))+'mm',665,74,20,obj.Arr[i].cntK||'');
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			x++;
			text = obj.Arr[i].isZhuji;
		}
	}
	// LODOP.PREVIEW();
    // LODOP.PRINT_DESIGN(); 
}; 
</script>
{/literal}
</head>
<body>
<script language="javascript">CheckLodop();</script>
</body></html>
