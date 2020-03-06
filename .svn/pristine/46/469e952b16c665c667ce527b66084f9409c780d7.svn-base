<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>打印出库单</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/Lodop/CheckActivX.js"></script>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
  <param name="CompanyName" value="常州易奇信息科技有限公司">
  <param name="License" value="664717080837475919278901905623">
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>

<!-- <script language="javascript" src="Resource/Script/{webcontrol type='GetAppInf' varName='PrintCpck'}"></script> -->

{literal}
<script language="javascript">
var tel = {/literal}{$tel}{literal};
$(function(){
	var obj = {/literal}{$obj|@json_encode}{literal};
	for(var i=0;obj[i];i++) {
		CreatePrintPage(obj[i],i+1,obj.length);
		LODOP.PREVIEW();
		// LODOP.PRINT_DESIGN();
		// return false;
		// LODOP.PRINT();
	}
	if(window.opener){
		window.close();
	}else{
		// window.location.href=document.referrer;
		window.location.href="Index.php?controller=Chengpin_Dye_Cpck&action=right";
	}
});
function CreatePrintPage(obj,cp,tp){
	var perPage=10;//每页行数
	var title = "成品发货单";
	LODOP.PRINT_INIT(title);
	// LODOP.PRINT_INITA(0,0,869,529,"成品发货单");
	LODOP.SET_PRINT_PAGESIZE(0,2300,1400,"");
	// LODOP.SET_PRINT_STYLE("FontSize",8);
	// LODOP.SET_PRINT_STYLE("Alignment",2);
	// LODOP.SET_PRINT_STYLE("Italic",1);
	LODOP.ADD_PRINT_TEXT(2,188,399,34,obj.title+'送货单');
	LODOP.SET_PRINT_STYLEA(0,"FontSize",17);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
	LODOP.SET_PRINT_STYLEA(0,"Bold",1);

	LODOP.ADD_PRINT_TEXT(34,249,290,20,"筒纱发货结算单(第"+cp+"页/共"+tp+"页)");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",14);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.ADD_PRINT_TEXT(12,651,165,20,"出库单号："+obj.cpckcode);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",12);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",1);



	//横线
	for(var i=0;i<perPage+2;i++) {
		LODOP.ADD_PRINT_LINE(60+26*i,14,59+26*i,839,0,1);
	}	

	// LODOP.ADD_PRINT_LINE(60,14,59,839,0,1);
	// LODOP.ADD_PRINT_LINE(87,14,86,839,0,1);
	// LODOP.ADD_PRINT_LINE(113,14,112,839,0,1);
	// LODOP.ADD_PRINT_LINE(139,14,138,839,0,1);
	// LODOP.ADD_PRINT_LINE(165,14,164,839,0,1);
	// LODOP.ADD_PRINT_LINE(191,14,190,839,0,1);
	// LODOP.ADD_PRINT_LINE(217,14,216,839,0,1);
	// LODOP.ADD_PRINT_LINE(243,14,242,839,0,1);
	// LODOP.ADD_PRINT_LINE(269,14,268,839,0,1);

	// LODOP.ADD_PRINT_LINE(267,14,58,15,0,1);
	// LODOP.ADD_PRINT_LINE(267,101,58,102,0,1);
	// LODOP.ADD_PRINT_LINE(267,215,58,216,0,1);
	// LODOP.ADD_PRINT_LINE(267,334,58,335,0,1);
	// LODOP.ADD_PRINT_LINE(267,423,58,424,0,1);
	// LODOP.ADD_PRINT_LINE(267,461,58,462,0,1);
	// LODOP.ADD_PRINT_LINE(267,528,58,529,0,1);
	// LODOP.ADD_PRINT_LINE(267,720,58,721,0,1);
	// LODOP.ADD_PRINT_LINE(267,592,58,593,0,1);
	// LODOP.ADD_PRINT_LINE(267,654,58,655,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,14,58,15,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,101,58,102,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,215,58,216,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,334,58,335,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,423,58,424,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,461,58,462,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,528,58,529,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,720,58,721,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,592,58,593,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,654,58,655,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,759,59,760,0,1);
	LODOP.ADD_PRINT_LINE((perPage+1)*26+58,838,58,839,0,1);

	// LODOP.ADD_PRINT_LINE(267,838,58,839,0,1);

	// LODOP.ADD_PRINT_TEXT(65+(perPage+1)*26,9,384,20,"发货人(录入时间):"+obj.senderName+"("+obj.timeInput+")");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.SET_PRINT_STYLEA(0,"Alignment",1);

	// LODOP.ADD_PRINT_TEXT(65+(perPage+1)*26,440,362,20,"收货单位确认货、数量后签字:");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.SET_PRINT_STYLEA(0,"Alignment",1);

	// LODOP.ADD_PRINT_TEXT(60+(perPage+2)*25.5,12,760,20,"*注:如染色数量有差异,请当天提出,否则以此单为准!收货后如有质量问题,请在10天内书面提出,否则概不负责。");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.SET_PRINT_STYLEA(0,"Alignment",1);



	//基础信息
	LODOP.ADD_PRINT_TEXT(30,17,240,20,"客户："+obj.clientName);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",1);

	LODOP.ADD_PRINT_TEXT(34,650,161,20,"出库日期:"+obj.dateCpck);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",1);

	//字段

	LODOP.ADD_PRINT_TEXT(66,15,80,20,"缸号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.ADD_PRINT_TEXT(66,105,106,20,"纱支规格");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.ADD_PRINT_TEXT(66,219,99,20,"色号/色别");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.ADD_PRINT_TEXT(66,330,87,20,"款号");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.ADD_PRINT_TEXT(66,418,50,20,"件数");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.ADD_PRINT_TEXT(59,469,58,25,"投料数(kg)");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-4);
	LODOP.ADD_PRINT_TEXT(59,530,58,25,"毛重(kg)");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-4);
	LODOP.ADD_PRINT_TEXT(59,595,58,25,"净重(kg)");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-4);
	LODOP.ADD_PRINT_TEXT(59,654,68,25,"染色单价\n元/kg");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-4);
	LODOP.ADD_PRINT_TEXT(66,718,43,20,"类别");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

	LODOP.ADD_PRINT_TEXT(66,761,73,20,"小计金额");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",2);


	// LODOP.ADD_PRINT_TEXT(66,15,80,20,"订单号");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.ADD_PRINT_TEXT(66,105,106,20,"纱支规格");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.ADD_PRINT_TEXT(66,219,99,20,"色号/色别");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.ADD_PRINT_TEXT(66,330,87,20,"缸号");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.ADD_PRINT_TEXT(66,418,50,20,"件数");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);

	// LODOP.ADD_PRINT_LINE(313,14,312,839,0,1);
	// LODOP.ADD_PRINT_TEXT(315,13,825,15,"常州易奇科技(专业开发筒染、色织系统) 联系方式:0519-...(省略)");

	// LODOP.ADD_PRINT_TEXT(59,469,58,25,"投料数(kg)");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-4);
	// LODOP.ADD_PRINT_TEXT(59,530,58,25,"毛重(kg)");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-4);
	// LODOP.ADD_PRINT_TEXT(59,595,58,25,"净重(kg)");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-4);
	// LODOP.ADD_PRINT_TEXT(59,654,68,25,"染色单价\n元/kg");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-4);
	// LODOP.ADD_PRINT_LINE(268,759,59,760,0,1);
	// LODOP.ADD_PRINT_TEXT(66,718,43,20,"类别");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);
	// LODOP.ADD_PRINT_LINE(267,838,58,839,0,1);
	// LODOP.ADD_PRINT_TEXT(66,761,73,20,"小计金额");
	// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	// LODOP.SET_PRINT_STYLEA(0,"Italic",0);

	LODOP.SET_PRINT_STYLE("FontSize",10);

	//字段赋值
	for(var i=0;obj.Gang[i];i++) {

		LODOP.ADD_PRINT_TEXT(93+26*i,6,100,20,obj.Gang[i].vatNum);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,98,116,20,obj.Gang[i].wareName);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,212,126,20,obj.Gang[i].colorSeCode);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,331,95,20,obj.Gang[i].kuanhao);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,419,46,20,obj.Gang[i].cntJian);//件数
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,462,67,20,obj.Gang[i].cntPlanTouliao);//投料数
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,528,67,20,obj.Gang[i].maoKg);//毛重
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,591,67,20,obj.Gang[i].jingKg);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,655,67,20,' ');
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,716,47,20,obj.Gang[i].kindName);
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		LODOP.ADD_PRINT_TEXT(93+26*i,755,88,20,' ');
		LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
		// LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
		// LODOP.SET_PRINT_STYLEA(0,"Italic",0);

	}
	// LODOP.ADD_PRINT_LINE(58+(perPage+3)*25.5,14,58+(perPage+3)*25.5-1,825,0,1);
	// LODOP.SET_PRINT_STYLE("FontSize",8);
	// LODOP.SET_PRINT_STYLE("Italic",1);
	// LODOP.ADD_PRINT_TEXT(60+(perPage+3)*25.5,13,825,15,"常州易奇科技(专业开发筒染、色织系统) 联系方式:0519-86339029");
	LODOP.ADD_PRINT_LINE(138+(perPage+1)*26,14,139+(perPage+1)*26,835,0,1);
	LODOP.ADD_PRINT_TEXT(138+(perPage+1)*26,13,825,15,"常州易奇科技(专业开发筒染、色织系统) 联系方式:"+tel);
	LODOP.SET_PRINT_STYLEA(0,"Alignment",3);
	LODOP.ADD_PRINT_TEXT(65+(perPage+1)*26,49,793,42,obj.memo);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	LODOP.ADD_PRINT_TEXT(65+(perPage+1)*26,18,37,42,"注：");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
	LODOP.SET_PRINT_STYLEA(0,"Bold",1);
	LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-2);
	LODOP.ADD_PRINT_TEXT(120+(perPage+1)*26,17,65,20,"仓管员:");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(120+(perPage+1)*26,71,80,20,obj.senderName);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.SET_PRINT_STYLEA(0,"TextFrame",2);
	LODOP.ADD_PRINT_TEXT(120+(perPage+1)*26,231,65,20,"业务员:");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(120+(perPage+1)*26,284,80,20,obj.Client.Trader.employName);
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.SET_PRINT_STYLEA(0,"TextFrame",2);
	LODOP.ADD_PRINT_TEXT(120+(perPage+1)*26,446,65,20,"送货人:");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(120+(perPage+1)*26,495,80,20,"");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.SET_PRINT_STYLEA(0,"TextFrame",2);
	LODOP.ADD_PRINT_TEXT(120+(perPage+1)*26,662,65,20,"收货人:");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	LODOP.ADD_PRINT_TEXT(120+(perPage+1)*26,709,80,20,"");
	LODOP.SET_PRINT_STYLEA(0,"FontSize",11);
	// LODOP.SET_PRINT_STYLEA(0,"TextFrame",2);
	
	
	return false;

}
</script>
{/literal}
</head>
<body style="margin-top:0px">
<script language="javascript">CheckLodop();</script>
</body>
</html>
