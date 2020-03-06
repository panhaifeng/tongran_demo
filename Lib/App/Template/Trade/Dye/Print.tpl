<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>生产计划打印单</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css">
<!-- <script language="javascript" src="Resource/Script/Gongyi/PrintChufang1.js"></script> -->
{literal}
<script language="javascript" src="Resource/Script/Lodop/CheckActivX.js"></script>

<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
  <param name="CompanyName" value="常州易奇信息科技有限公司">
  <param name="License" value="664717080837475919278901905623">
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
var obj = {/literal}{$row|@json_encode}{literal};
$(function(){
	setTimeout(print(),1000);
	window.close();
});
function print(){
		LODOP.PRINT_INITA("0mm","0mm","195mm","270mm","套打模板");
		LODOP.SET_PRINT_PAGESIZE(0,"195mm","270mm",'生产计划打印');
		// LODOP.SET_PRINT_STYLE("FontSize",14);
		// LODOP.SET_PRINT_STYLE("Alignment",2);
		LODOP.SET_PRINT_STYLE("FontName","黑体");
		LODOP.ADD_PRINT_TEXT("45mm","30mm",100,"5mm",obj[0].compName);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",13);
		LODOP.ADD_PRINT_TEXT("45mm","80mm",100,"5mm",obj[0].date);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",13);
		LODOP.ADD_PRINT_TEXT("45mm","142mm",100,"5mm",obj[0].Code);
		LODOP.SET_PRINT_STYLEA(0,"FontSize",13);
		for(var i=0;obj[i];i++) {
			LODOP.ADD_PRINT_TEXT((73+12.5*i)+"mm","15.1mm","22mm","6.1mm",obj[i].kuanhao);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((73+12.5*i)+"mm","35.2mm","24.9mm","6.1mm",obj[i].name);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((73+12.5*i)+"mm","58.7mm","26.2mm","5mm",obj[i].str2);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((73+12.5*i)+"mm","83.6mm","16.9mm","6.1mm",obj[i].cntKgJ);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((73+12.5*i)+"mm","100mm","16.9mm","6.1mm",obj[i].cntKgW);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((73+12.5*i)+"mm","116.9mm","16.9mm","6.1mm",obj[i].cntKg);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((73+12.5*i)+"mm","133.9mm","20.1mm","6.1mm",'');
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((73+12.5*i)+"mm","147mm","27.1mm","6.1mm",obj[i].dateJiaoqi);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((77+12.5*i)+"mm","116.7mm","61.2mm","5mm","备注:"+obj[i].memo);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
			LODOP.ADD_PRINT_TEXT((77+12.5*i)+"mm","58.7mm",217,19,obj[i].colorNum);
			LODOP.SET_PRINT_STYLEA(0,"FontSize",11);

		}
		// LODOP.PRINT_DESIGN();return false;//设计模式
		{/literal}
		{if $smarty.get.preview==1}
		LODOP.PREVIEW();
		{else}
		LODOP.PREVIEW();return false;
		LODOP.PRINT();
		{/if}
		{literal}if(window.opener) window.close();else window.location.href=document.referrer;
		//LODOP.PRINT();if(window.opener) window.close();else window.location.href=document.referrer;
};
</script>
{/literal}
</head>
<body>
<script language="javascript">CheckLodop();</script>
</body></html>
