<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工艺处方单打印</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css">
{literal}
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />

<object  id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
<param name="Caption" value="我是打印控件lodop">
<param name="Color" value="#C0C0C0">
<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
<script language="javascript" src="Resource/Script/jquery1.10.1.js"></script>
<script language="javascript" src="Resource/Script/jquery-barcode.js"></script>
<script language="javascript" src="Resource/Script/LodopFuncs.js"></script>
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
	LODOP.ADD_PRINT_TEXT(0,268,243,27,"工艺处方单");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",13);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
	LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",10);
	LODOP.ADD_PRINT_TEXT("6.4mm",16,73,25,"日期：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(46,13,93,20,"工艺类别：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(28,603,58,20,"色号：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT("6.6mm",90,99,25,obj.dateChufang);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(47,105,84,20,obj.chufangKind);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);

	LODOP.ADD_PRINT_TEXT("6.9mm","54mm",82,20,"客户名：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(46,422,77,25,"水容量：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT("6.6mm",285,152,24,obj.compName);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);

	LODOP.ADD_PRINT_TEXT("7.4mm",436,55,20,"颜色：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(5,595,72,20,"处方人：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT("0.8mm",669,105,20,obj.chufangren);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(47,"53.2mm",83,25,"物理缸：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(47,287,73,20,obj.vatCode);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(28,661,94,20,obj.colorNum);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(27,497,95,20,obj.color);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);

	LODOP.ADD_PRINT_TEXT(48,496,69,20,obj.shuirong);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(49,565,106,20,"染化料折率：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(48,664,91,20,obj.rsZhelv);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);


	//缸号信息
	LODOP.ADD_PRINT_TEXT(67,16,70,20,"缸号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(67,145,59,25,"纱支");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(69,285,70,20,"定重");
	LODOP.ADD_PRINT_TEXT(71,370,100,20,"筒子数");
	LODOP.ADD_PRINT_TEXT(71,440,100,20,"净损重");
	LODOP.ADD_PRINT_TEXT(70,515,100,20,"总公斤数");
	LODOP.ADD_PRINT_TEXT(69,650,100,20,"包数");
	//动态缸的信息
	for(var i=0;obj.Gang[i];i++) {
		LODOP.ADD_PRINT_TEXT(93+16*i,17,100,20,obj.Gang[i].vatNum);
		LODOP.ADD_PRINT_TEXT(93+16*i,121,145,20,obj.Gang[i].guige);
		LODOP.ADD_PRINT_TEXT(93+16*i,285,100,20,obj.Gang[i].unitKg);
		LODOP.ADD_PRINT_TEXT(93+16*i,375,100,20,obj.Gang[i].planTongzi);
		LODOP.ADD_PRINT_TEXT(93+16*i,440,100,20,obj.Gang[i].jingzhong);
		LODOP.ADD_PRINT_TEXT(93+16*i,515,100,20,obj.Gang[i].cntPlanTouliao);
		LODOP.ADD_PRINT_TEXT(93+16*i,651,100,20,''+(obj.Gang[i].cntBao||''));
	}
	//缸的合计信息
	LODOP.ADD_PRINT_TEXT(96+16*i,16,100,20,"合计");
	LODOP.ADD_PRINT_TEXT(96+16*i,375,100,20,obj.cntTongziAll);
	LODOP.ADD_PRINT_TEXT(96+16*i,440,100,20,obj.cntJingzhongAll);
	LODOP.ADD_PRINT_TEXT(96+16*i,515,100,20,obj.cntPlanTouliao);
	LODOP.ADD_PRINT_TEXT(96+16*i,650,100,20,obj.cntPlanTouliao/5);
	//线
	LODOP.ADD_PRINT_LINE(90,17,89,722,0,1);
	LODOP.ADD_PRINT_LINE(93+16*i,17,93+16*i,722,0,1);

	LODOP.ADD_PRINT_SHAPE(1,"41.8mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"47.9mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"52.9mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"57.9mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"63mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"68mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"73mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"77.8mm",18,463,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"82.8mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"41.8mm",18,1,"94.7mm",0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"41.8mm",207,1,155,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"41.8mm",332,1,155,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,158,481,1,155,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"87.3mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"91.8mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"96.3mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"100.8mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"105.3mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"109.8mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"114.3mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"118.8mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"123.3mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"127.5mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"132mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(1,"136.5mm",18,714,1,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"82.8mm",245,1,"53.4mm",0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"82.8mm",480,1,202,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,157,732,1,360,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"91.8mm",127,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"91.8mm",180,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"91.8mm",362,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"91.8mm",416,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"91.8mm",604,1,169,0,1,"#C0C0C0");
	LODOP.ADD_PRINT_SHAPE(0,"91.8mm",663,1,169,0,1,"#C0C0C0");

	// LODOP.ADD_PRINT_TEXT("31.8mm",19,100,20,"染料方案");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.ADD_PRINT_TEXT(120,215,100,20,"配方");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.ADD_PRINT_TEXT(120,336,100,20,"实际重g");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.ADD_PRINT_TEXT(120,498,221,20,"备注");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
	LODOP.ADD_PRINT_TEXT("43.7mm",19,100,20,"染料方案");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(165,215,100,20,"配方");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(165,336,100,20,"实际重g");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(165,498,221,20,"备注");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
	//染料数据
	var j = 0;
	var text = '';
	for(var i=0;obj.Arr[i];i++) {
		if (obj.Arr[i].gongxuId==4) {//当为染色的数据
			if (text) {
				if (text != obj.Arr[i].isZhuji) {
					j=j+1;
				}
			}
			LODOP.ADD_PRINT_TEXT(180+(j*19),19,192,20,obj.Arr[i].guige);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT(180+(j*19),215,116,20,obj.Arr[i].peifang);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.ADD_PRINT_TEXT(180+(j*19),335,202,20,obj.Arr[i].cntKg||'');
			LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			j++;
			text = obj.Arr[i].isZhuji;
		}
	}
	// LODOP.ADD_PRINT_TEXT(139,19,192,20,"安诺苏3BE红");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.ADD_PRINT_TEXT(139,215,116,20,"0.6");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	// LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	// LODOP.ADD_PRINT_TEXT(139,335,202,20,"11558.4");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	// LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	LODOP.ADD_PRINT_TEXT(315,19,100,20,"染色工艺代号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(315,118,100,20,gy.Rsgy);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(315,245,114,20,"前处理工艺代号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(315,367,109,20,gy.Qclgy);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(315,488,114,20,"后处理工艺代号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(315,612,109,20,gy.Hclgy);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(332,19,74,20,"染色助剂");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(331,245,100,20,"前处理助剂");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(332,512,100,20,"后处理助剂");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,18,72,20,"助剂名称");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,128,51,20,"配方");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,182,71,20,"实际重KG");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,246,72,20,"助剂名称");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,362,82,20,"配方");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,441,71,20,"实际重KG");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,520,72,20,"助剂名称");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,605,71,20,"配方");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(349,665,73,20,"实际重KG");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(181,482,250,136,gy.memo||'');
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.ADD_PRINT_TEXT(518,18,180,20,"制单人："+obj.chufangren);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.ADD_PRINT_TEXT(518,168,100,20,"审核人：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	//染色助剂
	
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
			LODOP.ADD_PRINT_TEXT((98+(x*4.48))+'mm',19,118,16,obj.Arr[i].guige);
			// LODOP.ADD_PRINT_TEXT(322,128,57,20,obj.Arr[i].peifang);
			LODOP.ADD_PRINT_TEXT((98+(x*4.4))+'mm',128,57,20,obj.Arr[i].peifang);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",8);
			LODOP.ADD_PRINT_TEXT((98+(x*4.4))+'mm',182,71,20,obj.Arr[i].cntK||'');
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
			LODOP.ADD_PRINT_TEXT((98+(x*4.48))+'mm',246,126,16,obj.Arr[i].guige);
			LODOP.ADD_PRINT_TEXT((98+(x*4.4))+'mm',363,82,20,obj.Arr[i].peifang);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
			LODOP.ADD_PRINT_TEXT((98+(x*4.4))+'mm',446,71,20,obj.Arr[i].cntK||'');
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
			LODOP.ADD_PRINT_TEXT((98+(x*4.48))+'mm',506,103,16,obj.Arr[i].guige);
			LODOP.ADD_PRINT_TEXT((98+(x*4.4))+'mm',605,57,20,obj.Arr[i].peifang);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",9);
			LODOP.ADD_PRINT_TEXT((98+(x*4.4))+'mm',665,74,20,obj.Arr[i].cntK||'');
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
