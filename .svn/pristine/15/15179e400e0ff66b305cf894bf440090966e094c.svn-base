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
	var title = "入库打印单";
	LODOP.PRINT_INIT(title);
	LODOP.SET_PRINT_PAPER(0,0,831,557,title);
	//设置纸张大小
	//LODOP.ADD_PRINT_LINE(287,18,288,718,2,1);return false;
	LODOP.SET_PRINT_PAGESIZE(0,2200,920,"0");
	//标题
	LODOP.SET_PRINT_STYLE("Bold",0);
	LODOP.SET_PRINT_STYLE("FontSize",16);
	LODOP.ADD_PRINT_TEXT(31,226,416,35,obj.title+'入库单');
	
	LODOP.SET_PRINT_STYLE("FontSize",11);
	LODOP.ADD_PRINT_TEXT(69,11,192,20,"日期："+obj.rukuDate);
	LODOP.ADD_PRINT_TEXT(69,311,237,20,"第"+cp+"页/共"+tp+"页");
	LODOP.ADD_PRINT_TEXT(69,587,148,20,"单号："+obj.rukuCode);
	LODOP.ADD_PRINT_TEXT(92,16,233,20,"供应商："+obj.compName);
	LODOP.ADD_PRINT_TEXT(92,340,206,20,"经手人："+obj.jingshouRenName);
	LODOP.ADD_PRINT_TEXT(92,621,114,20,"票号："+obj.songhuoCode);
	if(cp==tp){
		LODOP.ADD_PRINT_TEXT(274,16,265,20,"金额合计(大写)："+obj.tRmb);
		LODOP.ADD_PRINT_TEXT(272,582,149,20,"小写："+obj.tCnt+"元");
	}
	if(cp==tp){
		LODOP.ADD_PRINT_TEXT(301,10,148,20,"制单："+obj.zhidanRenName);
		LODOP.ADD_PRINT_TEXT(303,317,158,20,"验收："+obj.yanshouRenName);
		//LODOP.SET_PRINT_STYLEA("Alignment",3);
		LODOP.ADD_PRINT_TEXT(302,607,130,20,"审核："+obj.shenheRenName);
	}else{
		LODOP.ADD_PRINT_TEXT(275,10,148,20,"制单："+obj.zhidanRenName);
		LODOP.ADD_PRINT_TEXT(277,317,158,20,"验收："+obj.yanshouRenName);
		LODOP.ADD_PRINT_TEXT(276,607,141,20,"审核："+obj.shenheRenName);
	}
	
	
	//设计表头
	LODOP.ADD_PRINT_TEXT(119,33,80,20,"材料编码");
	LODOP.ADD_PRINT_TEXT(119,216,85,20,"材料名称");
	LODOP.ADD_PRINT_TEXT(119,393,80,20,"材料规格");
	LODOP.ADD_PRINT_TEXT(119,514,46,20,"单位");
	LODOP.ADD_PRINT_TEXT(119,559,69,20,"本次入库");
	LODOP.ADD_PRINT_TEXT(119,626,45,20,"单价");
	LODOP.ADD_PRINT_TEXT(119,681,50,20,"金额");
	
	
	//横线
	var mm=cp==tp?9:8;
	for(var i=0;i<mm;i++) {
		LODOP.ADD_PRINT_LINE(90+26*i,14,89+26*i,730,0,1);
	}
	
	//竖线
	LODOP.ADD_PRINT_LINE(cp==tp?298:271,14,89,15,0,1);
	LODOP.ADD_PRINT_LINE(271,174,115,175,0,1);
	LODOP.ADD_PRINT_LINE(271,339,89,340,0,1);
	LODOP.ADD_PRINT_LINE(271,513,115,514,0,1);
	LODOP.ADD_PRINT_LINE(271,558,115,559,0,1);
	LODOP.ADD_PRINT_LINE(271,621,89,622,0,1);
	LODOP.ADD_PRINT_LINE(271,675,115,676,0,1);
	LODOP.ADD_PRINT_LINE(cp==tp?298:271,730,89,731,0,1);

	for(var i=0;obj[i];i++) {
		//alert(obj.Gang);
		LODOP.ADD_PRINT_TEXT(146+26*i,18,161,20,obj[i].Wares.wareCode);
		LODOP.ADD_PRINT_TEXT(146+26*i,177,162,26,obj[i].Wares.wareName);
		LODOP.ADD_PRINT_TEXT(146+26*i,340,174,26,obj[i].Wares.guige);
		LODOP.ADD_PRINT_TEXT(146+26*i,516,44,26,obj[i].Wares.unit);
		LODOP.ADD_PRINT_TEXT(146+26*i,562,70,26,obj[i].cnt);
		LODOP.ADD_PRINT_TEXT(146+26*i,623,53,26,obj[i].danjia);
		LODOP.ADD_PRINT_TEXT(146+26*i,676,70,26,obj[i].danjia*obj[i].cnt);
	}
	return false;

}