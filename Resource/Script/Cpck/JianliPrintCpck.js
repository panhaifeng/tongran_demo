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
	var perPage=7;//每页行数
	var title = "成品发货单";
	LODOP.PRINT_INIT(title);
	//LODOP.SET_PRINT_PAPER(0,0,831,557,title);
	//设置纸张大小
	//LODOP.ADD_PRINT_LINE(287,18,288,718,2,1);return false;
	LODOP.SET_PRINT_PAGESIZE(0,0,0,"A4");

	LODOP.SET_PRINT_STYLE("FontSize",17);
	LODOP.SET_PRINT_STYLE("Alignment",2);
	LODOP.SET_PRINT_STYLE("Bold",1);
	LODOP.ADD_PRINT_TEXT(2,188,399,34,obj.title+'送货单');
	LODOP.SET_PRINT_STYLE("Bold",0);
	LODOP.SET_PRINT_STYLE("FontSize",14);
	LODOP.ADD_PRINT_TEXT(34,249,290,20,"筒纱发货结算单(第"+cp+"页/共"+tp+"页)");
	LODOP.SET_PRINT_STYLE("FontSize",12);
	LODOP.ADD_PRINT_TEXT(12,573,200,20,"出库单号："+obj.cpckcode);
	//LODOP.SET_PRINT_STYLE("FontSize",14);
	//LODOP.SET_PRINT_STYLE("Alignment",2);

  	/*LODOP.SET_PRINT_STYLEA(2,"Alignment",2);
    LODOP.SET_PRINT_STYLEA(1,"FontSize",16);
	LODOP.SET_PRINT_STYLEA(1,"Alignment",2);
	LODOP.ADD_PRINT_TEXT(10,234,333,34,obj.title);
	LODOP.SET_PRINT_STYLEA(1,"Bold",1);
	LODOP.SET_PRINT_STYLEA(1,"FontSize",14);
	LODOP.ADD_PRINT_TEXT(34,266,265,20,"筒纱发货结算单")*/

//横线
for(var i=0;i<perPage+2;i++) {
	LODOP.ADD_PRINT_LINE(60+26*i,14,59+26*i,760,0,1);
}


//竖线
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,14,58,15,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,101,58,102,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,187,58,188,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,301,58,302,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,423,58,424,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,514,58,515,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,587,58,588,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,760,58,761,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,636,58,637,0,1);
LODOP.ADD_PRINT_LINE(59+(perPage+1)*26,701,58,702,0,1);


LODOP.SET_PRINT_STYLE("FontSize",11);
LODOP.SET_PRINT_STYLE("Alignment",1);
LODOP.ADD_PRINT_TEXT(65+(perPage+1)*26,9,384,20,"发货人(录入时间):"+obj.senderName+"("+obj.timeInput+")");
LODOP.ADD_PRINT_TEXT(65+(perPage+1)*26,440,362,20,"收货单位确认货、数量后签字:");
LODOP.ADD_PRINT_TEXT(60+(perPage+2)*25.5,12,760,20,"*注:如染色数量有差异,请当天提出,否则以此单为准!收货后如有质量问题,请在10天内书面提出,否则概不负责。");

//设计表头
LODOP.SET_PRINT_STYLE("Alignment",1);
LODOP.ADD_PRINT_TEXT(30,17,216,20,"客户："+obj.Client.compName);
LODOP.ADD_PRINT_TEXT(34,605,161,20,"出库日期:"+obj.dateCpck);
LODOP.SET_PRINT_STYLE("Alignment",2);
LODOP.ADD_PRINT_TEXT(66,15,80,20,"订单号");
LODOP.ADD_PRINT_TEXT(67,126,49,20,"缸号");
LODOP.ADD_PRINT_TEXT(67,232,43,20,"纱支");
LODOP.ADD_PRINT_TEXT(67,325,42,20,"颜色");
LODOP.ADD_PRINT_TEXT(67,430,80,20,"投料");
LODOP.ADD_PRINT_TEXT(67,528,49,20,"净重");
LODOP.ADD_PRINT_TEXT(67,587,43,20,"件数");
LODOP.ADD_PRINT_TEXT(67,636,54,20,"筒子数");
LODOP.ADD_PRINT_TEXT(67,711,46,20,"备注");

LODOP.SET_PRINT_STYLE("FontSize",12);
//动态内容
for(var i=0;obj.Gang[i];i++) {
	//alert(obj.Gang);
	LODOP.ADD_PRINT_TEXT(90+26*i,10,95,20,obj.Gang[i].orderCode);
	LODOP.ADD_PRINT_TEXT(90+26*i,105,80,26,obj.Gang[i].vatNum);
	LODOP.ADD_PRINT_TEXT(90+26*i,188,120,26,obj.Gang[i].wareName);
	//LODOP.ADD_PRINT_TEXT(98+32*i,220,40,26,obj.Gang[i].chandi);//LODOP.ADD_PRINT_TEXT(98+32*i,308,91,26,obj.Gang[i].colorNum);
	LODOP.ADD_PRINT_TEXT(90+26*i,301,131,26,obj.Gang[i].color?(obj.Gang[i].color+obj.Gang[i].colorNum):'');
	LODOP.ADD_PRINT_TEXT(90+26*i,429,80,26,obj.Gang[i].cntPlanTouliao);
	//LODOP.ADD_PRINT_TEXT(90+26*i,429,80,26,obj.Gang[i].cntChuku);
	//LODOP.ADD_PRINT_TEXT(98+32*i,511,60,26,obj.Gang[i].cntChuku);
	LODOP.ADD_PRINT_TEXT(90+26*i,517,70,26,obj.Gang[i].jingKg);
	LODOP.ADD_PRINT_TEXT(90+26*i,589,40,26,obj.Gang[i].cntJian);
	LODOP.ADD_PRINT_TEXT(90+26*i,639,61,26,obj.Gang[i].cntTongzi);
	LODOP.ADD_PRINT_TEXT(90+26*i,700,60,26,obj.Gang[i].memo);
}
//广告分界线
LODOP.ADD_PRINT_LINE(58+(perPage+3)*25.5,14,58+(perPage+3)*25.5-1,760,0,1);
LODOP.SET_PRINT_STYLE("FontSize",8);
LODOP.SET_PRINT_STYLE("Italic",1);
LODOP.ADD_PRINT_TEXT(60+(perPage+3)*25.5,13,740,15,"常州易奇科技(专业开发筒染、色织系统) 联系方式:{webcontrol type='Servtel'}");
return false;

}