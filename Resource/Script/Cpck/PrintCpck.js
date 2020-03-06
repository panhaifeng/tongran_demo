//打印工艺处方的js函数
//函数头需要加入
/*
<script language="javascript" src="Resource/Script/Lodop/CheckActivX.js"></script>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
  <param name="CompanyName" value="常州易奇信息科技有限公司">
  <param name="License" value="664717080837475919278901905623">
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
$(function(){
		var obj = {/literal}{$row|@json_encode}{literal};
		//dump(obj);
		CreatePrintPage(obj,0,0);
		LODOP.PRINT_DESIGN();
		//LODOP.PRINT();
		if(window.opener) window.close();
});
</script>
*/
//cp:当前页,tp:总页
function CreatePrintPage(obj,cp,tp) {
	//dump(obj.Dye[0]);
	//alert(obj.title);return false;
	var title = "成品发货单";
	LODOP.PRINT_INIT(title);
	//设置纸张大小
	//LODOP.ADD_PRINT_LINE(287,18,288,718,2,1);return false;
	LODOP.SET_PRINT_PAGESIZE(0,2200,930,"0");

	LODOP.SET_PRINT_STYLE("FontSize",11);
	LODOP.SET_PRINT_STYLE("FontSize",19);
	LODOP.SET_PRINT_STYLE("Alignment",2);
	LODOP.SET_PRINT_STYLE("Bold",1);
	LODOP.ADD_PRINT_TEXT(7,246,380,34,obj.title);
	LODOP.SET_PRINT_STYLE("Bold",0);
	LODOP.SET_PRINT_STYLE("FontSize",12);
	LODOP.ADD_PRINT_TEXT(35,290,265,20,"筒纱发货结算单(第"+cp+"页/共"+tp+"页)");
	LODOP.SET_PRINT_STYLE("FontSize",14);
	LODOP.SET_PRINT_STYLE("Alignment",2);

  	/*LODOP.SET_PRINT_STYLEA(2,"Alignment",2);
    LODOP.SET_PRINT_STYLEA(1,"FontSize",16);
	LODOP.SET_PRINT_STYLEA(1,"Alignment",2);
	LODOP.ADD_PRINT_TEXT(10,234,333,34,obj.title);
	LODOP.SET_PRINT_STYLEA(1,"Bold",1);
	LODOP.SET_PRINT_STYLEA(1,"FontSize",14);
	LODOP.ADD_PRINT_TEXT(34,266,265,20,"筒纱发货结算单")*/;

//横线
LODOP.ADD_PRINT_LINE(60,14,59,760,0,1);
LODOP.ADD_PRINT_LINE(92,14,91,760,0,1);
LODOP.ADD_PRINT_LINE(124,14,123,760,0,1);
LODOP.ADD_PRINT_LINE(156,14,155,760,0,1);
LODOP.ADD_PRINT_LINE(188,14,187,760,0,1);
LODOP.ADD_PRINT_LINE(220,14,219,760,0,1);
LODOP.ADD_PRINT_LINE(252,14,251,760,0,1);
LODOP.ADD_PRINT_LINE(284,14,283,760,0,1);
//LODOP.ADD_PRINT_LINE(314,14,313,810,0,1);

//加斜线
LODOP.ADD_PRINT_LINE(91,701,60,760,0,1);

//竖线
LODOP.ADD_PRINT_LINE(283,14,58,15,0,1);
LODOP.ADD_PRINT_LINE(283,87,58,88,0,1);
LODOP.ADD_PRINT_LINE(283,221,58,222,0,1);
LODOP.ADD_PRINT_LINE(283,260,58,261,0,1);
LODOP.ADD_PRINT_LINE(283,350,58,351,0,1);
LODOP.ADD_PRINT_LINE(283,460,58,461,0,1);
LODOP.ADD_PRINT_LINE(283,517,58,518,0,1);
LODOP.ADD_PRINT_LINE(283,574,58,575,0,1);
LODOP.ADD_PRINT_LINE(283,622,58,623,0,1);
LODOP.ADD_PRINT_LINE(283,760,58,761,0,1);
LODOP.ADD_PRINT_LINE(283,656,58,657,0,1);
LODOP.ADD_PRINT_LINE(283,701,58,702,0,1);


LODOP.SET_PRINT_STYLE("FontSize",10);
LODOP.SET_PRINT_STYLE("Alignment",1);
LODOP.ADD_PRINT_TEXT(287,9,384,20,"发货人(录入时间):"+obj.senderName+"("+obj.timeInput+")");
LODOP.ADD_PRINT_TEXT(287,440,362,20,"收货单位确认货、数量后签字:");
LODOP.ADD_PRINT_TEXT(318,12,639,20,"*注:如染色数量有差异, 请当天提出, 否则以此单为准! 联系电话:0519-83445883");

//设计表头
LODOP.ADD_PRINT_TEXT(30,17,100,20,"客户："+obj.Client.compName);
//alert(obj.dateCpck);
LODOP.ADD_PRINT_TEXT(34,623,161,20,"出库日期:"+obj.dateCpck);
LODOP.SET_PRINT_STYLE("Alignment",2);
//LODOP.ADD_PRINT_TEXT(70,27,58,20,"订单号");
LODOP.ADD_PRINT_TEXT(70,31,40,20,"缸号");
LODOP.ADD_PRINT_TEXT(70,132,43,20,"纱支");
LODOP.ADD_PRINT_TEXT(70,218,43,20,"厂地");
LODOP.ADD_PRINT_TEXT(70,284,45,24,"色号");
LODOP.ADD_PRINT_TEXT(70,392,42,20,"颜色");
LODOP.ADD_PRINT_TEXT(70,456,70,20,"计划投料");
LODOP.ADD_PRINT_TEXT(70,509,72,20,"本次发货");
LODOP.ADD_PRINT_TEXT(70,578,39,20,"净重");
LODOP.ADD_PRINT_TEXT(70,617,43,20,"件数");
LODOP.ADD_PRINT_TEXT(70,653,54,20,"筒子数");
LODOP.ADD_PRINT_TEXT(62,691,46,20,"备注");
LODOP.ADD_PRINT_TEXT(74,725,46,20,"余件");

//动态内容
for(var i=0;obj.Gang[i];i++) {
	//alert(obj.Gang);
	//LODOP.ADD_PRINT_TEXT(98+32*i,10,90,26,obj.Gang[i].orderCode);
	LODOP.ADD_PRINT_TEXT(98+32*i,10,80,26,obj.Gang[i].vatNum);
	LODOP.ADD_PRINT_TEXT(98+32*i,88,140,26,obj.Gang[i].wareName);
	LODOP.ADD_PRINT_TEXT(98+32*i,220,40,26,obj.Gang[i].chandi);
	LODOP.ADD_PRINT_TEXT(98+32*i,258,91,26,obj.Gang[i].colorNum);
	LODOP.ADD_PRINT_TEXT(98+32*i,348,111,26,obj.Gang[i].color);
	LODOP.ADD_PRINT_TEXT(98+32*i,455,70,26,obj.Gang[i].cntPlanTouliao);
	LODOP.ADD_PRINT_TEXT(98+32*i,511,60,26,obj.Gang[i].cntChuku);
	LODOP.ADD_PRINT_TEXT(98+32*i,567,60,26,obj.Gang[i].jingKg);
	LODOP.ADD_PRINT_TEXT(98+32*i,619,40,26,obj.Gang[i].cntJian);
	LODOP.ADD_PRINT_TEXT(98+32*i,656,50,26,obj.Gang[i].cntTongzi);
	LODOP.ADD_PRINT_TEXT(98+32*i,700,60,26,obj.Gang[i].memo);
}

	return false;

}