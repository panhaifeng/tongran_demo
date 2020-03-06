
function CreatePrintPage(obj,offsetX,offsetY,page,len) {
	//dump(obj.Dye[0]);
	var title = "工艺处方单";
	LODOP.PRINT_INIT(title);
	//设置纸张大小
    LODOP.SET_PRINT_STYLE("FontSize",14);
	LODOP.SET_PRINT_STYLE("Alignment",2);
	LODOP.PRINT_INITA(1,-3,"150mm","210mm",'工艺处方单');
	LODOP. SET_PRINT_PAGESIZE (0, 0, 0,"A5");
	LODOP.SET_PRINT_STYLE("FontSize",9);
	LODOP.ADD_PRINT_TEXT(0,142,233,34,"工艺处方单");
	LODOP.SET_PRINT_STYLEA(1,"FontSize",14);
	LODOP.SET_PRINT_STYLEA(1,"Alignment",2);
	//LODOP.ADD_PRINT_TEXT(2,416,150,20,"(第undefined页,共undefined页)");
	LODOP.ADD_PRINT_TEXT(24,15,112,20,"日期："+obj.datePrint);
	LODOP.ADD_PRINT_TEXT(24,128,127,20,"客户名："+obj.compName);
	LODOP.ADD_PRINT_TEXT(24,253,145,20,"颜色："+obj.color);
	LODOP.ADD_PRINT_TEXT(24,398,128,20,"色号："+obj.colorNum);

	LODOP.ADD_PRINT_TEXT(39,15,112,20,"工艺类别："+obj.dyeKind);
	LODOP.ADD_PRINT_TEXT(39,128,127,20,"物理缸："+obj.vatCode);
	LODOP.ADD_PRINT_TEXT(39,253,145,20,"水容量："+obj.shuirong+'L');
	LODOP.ADD_PRINT_TEXT(39,398,128,20,"染化料折率："+obj.rhlZhelv);

	LODOP.ADD_PRINT_TEXT(5,398,128,20,"处方人："+obj.chufangren);

	//定义缸表头
	LODOP.ADD_PRINT_TEXT(59,15,80,20,"缸号");
	LODOP.ADD_PRINT_TEXT(59,102,100,20,"纱支");
	LODOP.ADD_PRINT_TEXT(59,200,64,20,"定重");
	LODOP.ADD_PRINT_TEXT(59,270,56,20,"筒子数");
	LODOP.ADD_PRINT_TEXT(59,334,100,20,"总公斤数");
	LODOP.ADD_PRINT_TEXT(59,443,100,20,"包数");
	//动态缸的信息
		for(var i=0;obj.Gang[i];i++) {
			LODOP.ADD_PRINT_TEXT(72+13*i,17,85,20,obj.Gang[i].vatNum);
			LODOP.ADD_PRINT_TEXT(72+13*i,102,100,20,obj.Gang[i].guige);
			LODOP.ADD_PRINT_TEXT(72+13*i,200,64,20,obj.Gang[i].unitKg);
			LODOP.ADD_PRINT_TEXT(72+13*i,270,56,20,obj.Gang[i].planTongzi);
			LODOP.ADD_PRINT_TEXT(72+13*i,334,100,20,obj.Gang[i].cntPlanTouliao);
			LODOP.ADD_PRINT_TEXT(72+13*i,443,100,20,''+(obj.Gang[i].cntBao||''));
		}
	//缸的合计信息
	LODOP.ADD_PRINT_TEXT(72+13*i,14,85,20,"合计");
	LODOP.ADD_PRINT_TEXT(72+13*i,270,56,20,obj.cntTongzi);
	LODOP.ADD_PRINT_TEXT(72+13*i,334,100,20,obj.cntKg);
	LODOP.ADD_PRINT_TEXT(72+13*i,443,100,20,obj.cntKg/5);
	//LODOP.ADD_PRINT_TEXT(198,14,100,20,"染色");
	//LODOP.ADD_PRINT_TEXT(253,14,100,20,"后处理");

	//线
	LODOP.ADD_PRINT_LINE(73,17,72,528,0,1);
	LODOP.ADD_PRINT_LINE(72+13*i,17,72+13*i,528,0,1);//LODOP.ADD_PRINT_LINE(89,17,89,528,0,1);
	LODOP.ADD_PRINT_LINE(163,17,162,528,0,1);


	
	

	//定义主表头
	LODOP.ADD_PRINT_TEXT(150,15,93,20,"工序方案");
	LODOP.ADD_PRINT_TEXT(150,77,200,20,"染化料/助剂");
	LODOP.ADD_PRINT_TEXT(150,275,63,20,"单位用量");
	LODOP.ADD_PRINT_TEXT(150,331,71,20,"缸用量(g)");
	LODOP.ADD_PRINT_TEXT(150,387,40,20,"温度");
	LODOP.ADD_PRINT_TEXT(150,422,40,20,"时间");
	LODOP.ADD_PRINT_TEXT(150,448,100,20,"备注");
	LODOP.SET_PRINT_STYLE("FontSize",10);
	// LODOP.SET_PRINT_STYLE("Bold",1);
	var space=0;
	//循环主体
	for(var i=0;obj.Arr[i];i++) {
		var marginTop = 6;
		// if(i!=0 && obj.Arr[i].gongxu!=''){
		// 	marginTop += 3;
		// }
		//染色工序的字体加大一些
		if(obj.Arr[i].gongxuId==4){
			LODOP.SET_PRINT_STYLE("FontSize",10);
			LODOP.SET_PRINT_STYLE("Bold",1);
		}else{
			LODOP.SET_PRINT_STYLE("FontSize",9);
			LODOP.SET_PRINT_STYLE("Bold",1);
		}
		if(obj.Arr[i].gongxu){
			space = space + 10;
		}
		if (i>0) {
			if (obj.Arr[i].gongxu!='') {
				LODOP.ADD_PRINT_LINE(164+19*i,25,164+19*i,528,2,1);
			}
			 
		}
		LODOP.ADD_PRINT_TEXT(166+19*i,15,65,19,obj.Arr[i].gongxu||'');
		LODOP.ADD_PRINT_TEXT(166+19*i,77,200,19,obj.Arr[i].guige);
		LODOP.ADD_PRINT_TEXT(166+19*i,274,76,19,obj.Arr[i].unitKg);
		LODOP.ADD_PRINT_TEXT(166+19*i,331,71,19,''+(obj.Arr[i].cntKg||''));
		LODOP.ADD_PRINT_TEXT(166+19*i,387,50,19,obj.Arr[i].tmp);
		LODOP.ADD_PRINT_TEXT(166+19*i,423,50,19,obj.Arr[i].timeRs);
		LODOP.ADD_PRINT_TEXT(166+19*i,448,100,19,obj.Arr[i].memo);
		//每一行增加一个分割线
		if(obj.Arr[i].gongxuId==2){
			// LODOP.ADD_PRINT_LINE(166+(16*i)+16+1,25,166+(16*i)+16-1+1,528,2,1);
			// LODOP.ADD_PRINT_LINE(181,25,180,528,2,0);
			//LODOP.ADD_PRINT_LINE(261,108,262,737,0,1);
		}else{
			// LODOP.ADD_PRINT_LINE(166+(16*i)+16+1,25,166+(16*i)+16-1+1,528,2,1);
			// LODOP.ADD_PRINT_LINE(181,25,180,528,2,0);
		}
	}
	//LODOP.SET_SHOW_MODE("LANDSCAPE_DEFROTATED",1);
	//广告上的线
	//LODOP.ADD_PRINT_LINE(710,15,(parseFloat(obj.Height.page)*parseFloat(obj.Height.pageCnt)-39),503,0,1);
	LODOP.ADD_PRINT_LINE(754,15,755,515,0,1);
	LODOP.SET_PRINT_STYLE("Alignment",2);
	LODOP.SET_PRINT_STYLE("FontSize",10);
	LODOP.SET_PRINT_STYLE("Alignment",3);
	LODOP.SET_PRINT_STYLE("Bold",0);
	LODOP.ADD_PRINT_TEXT(753,50,466,20,"软件开发：常州易奇科技，联系方式：{webcontrol type='Servtel'}");
        /*LODOP.ADD_PRINT_LINE(158,13,159,718,0,1);
        LODOP.ADD_PRINT_LINE(132,13,133,718,0,1);*/
}