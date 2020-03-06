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
	var title = "出库打印单";
	LODOP.PRINT_INIT(title);
	LODOP.SET_PRINT_PAPER(0,0,831,557,title);
	//设置纸张大小
	//LODOP.ADD_PRINT_LINE(287,18,288,718,2,1);return false;
	LODOP.SET_PRINT_PAGESIZE(0,2200,920,"0");
	//标题
	LODOP.SET_PRINT_STYLE("Bold",0);
	LODOP.SET_PRINT_STYLE("FontSize",16);
	LODOP.ADD_PRINT_TEXT(31,226,416,35,obj.title+'领料单');
	
	LODOP.SET_PRINT_STYLE("FontSize",11);
	LODOP.ADD_PRINT_TEXT(69,11,192,20,"日期："+obj.shenqingDate);
	LODOP.ADD_PRINT_TEXT(69,311,237,20,"第"+cp+"页/共"+tp+"页");
	LODOP.ADD_PRINT_TEXT(69,587,148,20,"单号："+obj.shenqingCode);
	LODOP.ADD_PRINT_TEXT(92,16,233,20,"申请部门："+obj.depName);
	LODOP.ADD_PRINT_TEXT(94,589,136,20,"领料人："+obj.shenqingren);

	LODOP.ADD_PRINT_TEXT(301,10,148,20,"核准人："+obj.hezhunren);
	LODOP.ADD_PRINT_TEXT(303,214,103,20,"发料人签字：");
	LODOP.ADD_PRINT_TEXT(302,504,99,20,"领料人签字：");
	//发料和领料的横线
	LODOP.ADD_PRINT_LINE(320,297,321,393,0,1);
	LODOP.ADD_PRINT_LINE(316,585,317,681,0,1);
	
	//设计表头
	LODOP.ADD_PRINT_TEXT(119,33,80,20,"材料编码");
	LODOP.ADD_PRINT_TEXT(119,180,85,20,"材料名称");
	LODOP.ADD_PRINT_TEXT(119,341,80,20,"材料规格");
	LODOP.ADD_PRINT_TEXT(119,432,46,20,"单位");
	LODOP.ADD_PRINT_TEXT(119,485,69,20,"申领数量");
	LODOP.ADD_PRINT_TEXT(119,616,50,20,"备注");
	
	
	//横线
	for(var i=0;i<8;i++) {
		LODOP.ADD_PRINT_LINE(90+26*i,14,89+26*i,730,0,1);
	}

	//竖线
	LODOP.ADD_PRINT_LINE(271,14,89,15,0,1);
	LODOP.ADD_PRINT_LINE(271,140,115,141,0,1);
	LODOP.ADD_PRINT_LINE(271,288,89,289,0,1);
	LODOP.ADD_PRINT_LINE(271,432,115,433,0,1);
	LODOP.ADD_PRINT_LINE(271,478,115,479,0,1);
	LODOP.ADD_PRINT_LINE(271,551,115,552,0,1);
	LODOP.ADD_PRINT_LINE(271,730,89,731,0,1);

	for(var i=0;obj[i];i++) {
		//alert(obj.Gang);
		LODOP.ADD_PRINT_TEXT(146+26*i,18,121,20,obj[i].wareCode);
		LODOP.ADD_PRINT_TEXT(146+26*i,141,147,26,obj[i].wareName);
		LODOP.ADD_PRINT_TEXT(146+26*i,288,144,26,obj[i].guige);
		LODOP.ADD_PRINT_TEXT(146+26*i,434,44,26,obj[i].unit);
		LODOP.ADD_PRINT_TEXT(146+26*i,478,70,26,obj[i].cnt);
		LODOP.ADD_PRINT_TEXT(146+26*i,553,176,26,obj[i].memo);
	}
	return false;

}