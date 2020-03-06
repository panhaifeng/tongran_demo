
function CreatePrintPage(obj,offsetX,offsetY,page,len) {
	//dump(obj.Dye[0]);
	var title = "工艺处方单";
	LODOP.PRINT_INIT(title);
	//设置纸张大小
    LODOP.SET_PRINT_STYLE("FontSize",14);
	LODOP.SET_PRINT_STYLE("Alignment",2);
	LODOP.SET_PRINT_PAPER(0,0,755,obj.Height.px,"工艺处方单");
	//alert(obj.Height.mm);
	//LODOP.SET_PRINT_PAGESIZE(0,2000,960,"0");
	// LODOP.SET_PRINT_PAGESIZE(0,2000,obj.Height.mm,"0");
	LODOP. SET_PRINT_PAGESIZE (2, 0, 0,"A5");
	LODOP.SET_PRINT_STYLE("FontSize",11);
	LODOP.ADD_PRINT_TEXT(0,234,233,34,"工艺处方单");
	LODOP.SET_PRINT_STYLEA(1,"FontSize",14);
	LODOP.SET_PRINT_STYLEA(1,"Alignment",2);
	//LODOP.ADD_PRINT_TEXT(2,416,150,20,"(第undefined页,共undefined页)");
	LODOP.ADD_PRINT_TEXT(24,15,170,20,"日期："+obj.datePrint);
	LODOP.ADD_PRINT_TEXT(24,197,170,20,"客户名："+obj.compName);
	LODOP.ADD_PRINT_TEXT(24,377,170,20,"颜色："+obj.color);
	LODOP.ADD_PRINT_TEXT(24,560,170,20,"色号："+obj.colorNum);
	LODOP.ADD_PRINT_TEXT(42,15,170,20,"工艺类别："+obj.dyeKind);
	LODOP.ADD_PRINT_TEXT(42,197,170,20,"物理缸："+obj.vatCode);
	LODOP.ADD_PRINT_TEXT(42,377,170,20,"水容量："+obj.shuirong+'L');
	LODOP.ADD_PRINT_TEXT(42,560,170,20,"染化料折率："+obj.rhlZhelv);
	LODOP.ADD_PRINT_TEXT(5,559,170,20,"处方人："+obj.chufangren);

	//定义缸表头
	LODOP.ADD_PRINT_TEXT(69,17,50,20,"缸号");
	LODOP.ADD_PRINT_TEXT(69,113,100,20,"纱支");
	LODOP.ADD_PRINT_TEXT(69,253,64,20,"定重");
	LODOP.ADD_PRINT_TEXT(69,360,77,20,"筒子数");
	LODOP.ADD_PRINT_TEXT(69,497,100,20,"总公斤数");
	LODOP.ADD_PRINT_TEXT(69,620,100,20,"包数");
	//动态缸的信息
		for(var i=0;obj.Gang[i];i++) {
			LODOP.ADD_PRINT_TEXT(93+16*i,17,100,20,obj.Gang[i].vatNum);
			LODOP.ADD_PRINT_TEXT(93+16*i,113,140,20,obj.Gang[i].guige);
			LODOP.ADD_PRINT_TEXT(93+16*i,253,64,20,obj.Gang[i].unitKg);
			LODOP.ADD_PRINT_TEXT(93+16*i,360,77,20,obj.Gang[i].planTongzi);
			LODOP.ADD_PRINT_TEXT(93+16*i,497,100,20,obj.Gang[i].cntPlanTouliao);
			LODOP.ADD_PRINT_TEXT(93+16*i,620,100,20,''+(obj.Gang[i].cntBao||''));
		}
	//缸的合计信息
	LODOP.ADD_PRINT_TEXT(96+16*i,14,100,20,"合计");
	LODOP.ADD_PRINT_TEXT(96+16*i,360,100,20,obj.cntTongzi);
	LODOP.ADD_PRINT_TEXT(96+16*i,497,100,20,obj.cntKg);
	LODOP.ADD_PRINT_TEXT(96+16*i,620,100,20,obj.cntKg/5);
	//LODOP.ADD_PRINT_TEXT(198,14,100,20,"染色");
	//LODOP.ADD_PRINT_TEXT(253,14,100,20,"后处理");

	//线
	LODOP.ADD_PRINT_LINE(90,17,89,722,0,1);
	LODOP.ADD_PRINT_LINE(93+16*i,17,93+16*i,722,0,1);
	LODOP.ADD_PRINT_LINE(190,17,189,722,0,1);

	//定义主表头
	LODOP.ADD_PRINT_TEXT(170,17,150,20,"工序方案");
	LODOP.ADD_PRINT_TEXT(170,134,148,20,"染化料/助剂");
	LODOP.ADD_PRINT_TEXT(170,259,111,20,"单位用量");
	LODOP.ADD_PRINT_TEXT(170,362,80,20,"缸用量(g)");
	LODOP.ADD_PRINT_TEXT(170,454,60,20,"温度");
	LODOP.ADD_PRINT_TEXT(170,518,70,20,"时间");
	LODOP.ADD_PRINT_TEXT(170,640,100,20,"备注");
	LODOP.SET_PRINT_STYLE("FontSize",10);
	LODOP.SET_PRINT_STYLE("Bold",1);
	var space=0;
	//循环主体
	for(var i=0;obj.Arr[i];i++) {
		var marginTop = 6;
		// if(i!=0 && obj.Arr[i].gongxu!=''){
		// 	marginTop += 3;
		// }
		//染色工序的字体加大一些
		if(obj.Arr[i].gongxuId==2){
			LODOP.SET_PRINT_STYLE("FontSize",12);
		}else{
			LODOP.SET_PRINT_STYLE("FontSize",10);
		}
		if(obj.Arr[i].gongxu){
			space = space + 10;
		}
		LODOP.ADD_PRINT_TEXT(192+22*i+marginTop + space,17,150,20,obj.Arr[i].gongxu||'');
		LODOP.ADD_PRINT_TEXT(192+22*i+marginTop + space,134,148,20,obj.Arr[i].guige);
		LODOP.ADD_PRINT_TEXT(192+22*i+marginTop + space,259,120,20,obj.Arr[i].unitKg);
		LODOP.ADD_PRINT_TEXT(192+22*i+marginTop + space,362,80,20,''+(obj.Arr[i].cntKg||''));
		LODOP.ADD_PRINT_TEXT(192+22*i+marginTop + space,454,60,20,obj.Arr[i].tmp);
		LODOP.ADD_PRINT_TEXT(192+22*i+marginTop + space,518,70,20,obj.Arr[i].timeRs);
		LODOP.ADD_PRINT_TEXT(192+22*i+marginTop + space,640,100,20,obj.Arr[i].memo);
		//每一行增加一个分割线
		if(obj.Arr[i].gongxuId==2){
			LODOP.ADD_PRINT_LINE(192+(22*i+marginTop)+20+space,150,192+(22*i+marginTop)+20-1+space,722,2,1);
			//LODOP.ADD_PRINT_LINE(261,108,262,737,0,1);
		}else{
			LODOP.ADD_PRINT_LINE(192+(22*i+marginTop)+18+space,150,192+(22*i+marginTop)+18-1+space,722,2,1);
		}
	}
	//广告上的线
	LODOP.ADD_PRINT_LINE((parseFloat(obj.Height.page)*parseFloat(obj.Height.pageCnt)-40),18,(parseFloat(obj.Height.page)*parseFloat(obj.Height.pageCnt)-39),718,0,1);

	LODOP.SET_PRINT_STYLE("Alignment",2);
	LODOP.SET_PRINT_STYLE("FontSize",10);
	LODOP.SET_PRINT_STYLE("Alignment",3);
	LODOP.SET_PRINT_STYLE("Bold",0);
	LODOP.ADD_PRINT_TEXT((parseFloat(obj.Height.page)*parseFloat(obj.Height.pageCnt)-37),256,466,20,"软件开发：常州易奇科技，联系方式：{webcontrol type='Servtel'}");
        /*LODOP.ADD_PRINT_LINE(158,13,159,718,0,1);
        LODOP.ADD_PRINT_LINE(132,13,133,718,0,1);*/
}