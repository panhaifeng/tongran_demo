//建立染厂打印工艺处方的js函数
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
function CreatePrintPage(obj,offsetX,offsetY) {	
	//dump(obj.Dye[0]);
	//alert('fffff');return false;
	var title = "工艺处方单";
	LODOP.PRINT_INIT(title);
	//设置纸张大小
	//LODOP.ADD_PRINT_LINE(287,18,288,718,2,1);return false;
	LODOP.SET_PRINT_PAGESIZE(0,2000,2800,"0");

	//LODOP.ADD_PRINT_LINE(110,18,111,718,0,1);
	
        
        LODOP.SET_PRINT_STYLE("FontSize",16);
	LODOP.SET_PRINT_STYLE("Alignment",2);
	LODOP.ADD_PRINT_TEXT(0,234,233,34,"工艺处方单");
	

	//设置以下所有的打印风格
	LODOP.SET_PRINT_STYLE("Alignment",2);
	LODOP.SET_PRINT_STYLE("FontSize",14); 
	LODOP.SET_PRINT_STYLE("Alignment",1);
	LODOP.ADD_PRINT_TEXT(34,15,170,20,"日期："+obj.datePrint);
	LODOP.ADD_PRINT_TEXT(34,197,170,20,"客户名："+obj.compName);
	LODOP.ADD_PRINT_TEXT(34,377,170,20,"颜色："+obj.color);
	LODOP.ADD_PRINT_TEXT(34,560,170,20,"色号："+obj.colorNum);
	LODOP.ADD_PRINT_TEXT(62,15,170,20,"染坯要求："+obj.dyeKind);
	LODOP.ADD_PRINT_TEXT(62,197,170,20,"锅型："+obj.vatCode);
	LODOP.ADD_PRINT_TEXT(62,377,170,20,"折率："+obj.rsZhelv);
	LODOP.ADD_PRINT_TEXT(62,560,170,20,"水容量："+obj.shuirong);
	LODOP.ADD_PRINT_TEXT(5,559,170,20,"处方人："+obj.chufangren);
	//return false;

        LODOP.SET_PRINT_STYLE("Italic",1);
	LODOP.ADD_PRINT_TEXT(363,15,74,20,"缸号");
	LODOP.ADD_PRINT_TEXT(363,120,53,20,"纱支");
	LODOP.ADD_PRINT_TEXT(363,300,60,20,"定重");
	LODOP.ADD_PRINT_TEXT(363,402,94,20,"筒子数量");	
	LODOP.ADD_PRINT_TEXT(363,521,90,20,"总公斤数");	
	LODOP.ADD_PRINT_TEXT(363,650,54,20,"包数");

	//LODOP.ADD_PRINT_TEXT(89,13,59,20,"工序");
	LODOP.ADD_PRINT_TEXT(89,15,121,20,"染化料/助剂");
	LODOP.ADD_PRINT_TEXT(89,139,150,20,"单位用量");
	LODOP.ADD_PRINT_TEXT(89,289,70,20,"缸用量");
	LODOP.ADD_PRINT_TEXT(89,361,59,20,"温度");
	LODOP.ADD_PRINT_TEXT(89,427,59,20,"时间");
	LODOP.ADD_PRINT_TEXT(89,488,59,20,"备注");


	LODOP.ADD_PRINT_TEXT(480,15,100,20,"合计");
	LODOP.ADD_PRINT_TEXT(480,402,100,20,obj.cntTongzi);
	LODOP.ADD_PRINT_TEXT(480,519,100,20,obj.cntKg);
	LODOP.ADD_PRINT_TEXT(480,650,62,20,obj.cntKg/5);

        LODOP.SET_PRINT_STYLE("Italic",0);

	//动态内容
	for(var i=0;obj.Gang[i];i++) {
		LODOP.ADD_PRINT_TEXT(386+24*i,15,100,20,obj.Gang[i].vatNum);
		LODOP.ADD_PRINT_TEXT(386+24*i,120,174,20,obj.Gang[i].guige);	
		LODOP.ADD_PRINT_TEXT(386+24*i,300,100,20,obj.Gang[i].unitKg);	
		LODOP.ADD_PRINT_TEXT(386+24*i,402,100,20,obj.Gang[i].planTongzi);	
		LODOP.ADD_PRINT_TEXT(386+24*i,519,100,20,obj.Gang[i].cntPlanTouliao);	
		LODOP.ADD_PRINT_TEXT(386+24*i,650,100,20,''+(obj.Gang[i].cntBao||''));	
	}
	for(var i=0;obj.Dye[i];i++) {
		//LODOP.ADD_PRINT_TEXT(112+24*i,13,59,20,'');
		LODOP.ADD_PRINT_TEXT(112+24*i,15,121,20,obj.Dye[i].guige);
		LODOP.ADD_PRINT_TEXT(112+24*i,139,150,20,obj.Dye[i].unitKg);
		LODOP.ADD_PRINT_TEXT(112+24*i,289,70,20,''+(obj.Dye[i].cntKg||''));
		LODOP.ADD_PRINT_TEXT(112+24*i,361,59,20,obj.Dye[i].tmp);
		LODOP.ADD_PRINT_TEXT(112+24*i,427,59,20,obj.Dye[i].timeRs);
		LODOP.ADD_PRINT_TEXT(112+24*i,488,59,20,obj.Dye[i].memo);
	}
        
        //增加竖线
		LODOP.ADD_PRINT_LINE(350,134,85,135,0,1);
		LODOP.ADD_PRINT_LINE(350,485,85,486,0,1);
		LODOP.ADD_PRINT_LINE(350,286,85,287,0,1);
		LODOP.ADD_PRINT_LINE(350,610,85,611,0,1);
		LODOP.ADD_PRINT_LINE(350,358,85,359,0,1);
		LODOP.ADD_PRINT_LINE(350,550,85,551,0,1);
		LODOP.ADD_PRINT_LINE(350,423,85,424,0,1);
		LODOP.ADD_PRINT_LINE(350,667,85,668,0,1);
		LODOP.ADD_PRINT_LINE(350,12,85,13,0,1);
		LODOP.ADD_PRINT_LINE(350,717,85,718,0,1);

        //增加横线,行高lh
        var lh = 24;
        for(var i=0;i<12;i++){
            LODOP.ADD_PRINT_LINE(86+i*lh,13,87+i*lh,718,0,1);
        }

        LODOP.ADD_PRINT_LINE(384,18,385,718,0,1);
	LODOP.ADD_PRINT_LINE(476,18,477,718,2,1);
        /*LODOP.ADD_PRINT_LINE(158,13,159,718,0,1);
        LODOP.ADD_PRINT_LINE(132,13,133,718,0,1);*/
}