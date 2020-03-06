/*
 * 函数说明：选择搜索类型
 * 参数：	actionUrl:搜索目标页面　　tracelog:跟踪参数
 * 返回值：	无
 * 时间：2005-5-12
 */
var activedItem=1;
var tracelogStr="";
var otherParamStr="";
function searchInit(num,tracelog,otherParam){
	tracelogStr = tracelog;
	otherParamStr = otherParam;
	doclick(document.getElementById("node"+num),num);
}
function doclick(srcObj,searchID){
	//alert(searchID);
	var tabList = srcObj.parentNode.getElementsByTagName("li");
	if(srcObj.className=="activedTab")return;
	for(var i=0;i<tabList.length;i++){
		if(tabList[i].className=="activedTab")tabList[i].className="nTab";
	}
	activedItem = searchID;
	srcObj.className = "activedTab";//TAB切换
	
	if(document.getElementById("linkKwords"))
			document.getElementById("linkKwords").innerHTML = linkKeywords[searchID-1].surl
}


/*热门关键字*/
var linkKeywords = [
	{id:1,name:"销售",surl:"<a href=\"Index.php?controller=Main&action=ContentBuilding\" target=LeftMenu>报表中心</a>"},


	{id:2,name:"生产",surl:"<a href=\"Index.php?controller=Plan_Dye\" target=LeftMenu>生产计划管理</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+	
	"<a href=\"Index.php?controller=Main&action=ContentBuilding\" target=LeftMenu>大样处方管理</a>"+"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=Chengpin_Denim_Cprk\" target=LeftMenu>松筒车间</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=Main&action=ContentBuilding\" target=LeftMenu>染色车间</a>"+
		"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=Chengpin_Denim_Cprk\" target=LeftMenu>烘干车间</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=Main&action=ContentBuilding\" target=LeftMenu>回倒车间</a>"+
		"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=Chengpin_Dye_Cprk\" target=LeftMenu>成品车间</a>"},
	

	{id:3,name:"财务",surl:"<a href=\"Index.php?controller=Main&action=ContentBuilding\" target=LeftMenu>科目管理</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=CaiWu_Ar_Report\" target=LeftMenu>应收管理</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=CaiWu_Yf_Invoice\" target=LeftMenu>应付管理</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=CaiWu_Expense\" target=LeftMenu>收支管理</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=CaiWu_Report_Cash\" target=LeftMenu>报表中心</a>"},


	{id:4,name:"采购",surl:"<a href=\"Index.php?controller=CangKu_RuKu\" target=LeftMenu>染化料仓库管理</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=CangKu_Ruku&action=Peisharuku\" target=LeftMenu>坯纱仓库管理</a>"},


	{id:6,name:"系统",surl:"<a href=\"Index.php?controller=Acm_User\" target=LeftMenu>权限管理</a>"},


	{id:7,name:"基础",surl:"<a href=\"Index.php?controller=JiChu_Ware\" target=LeftMenu>货品档案</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=JiChu_Client\" target=LeftMenu>客户档案</a> "+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=JiChu_Supplier\" target=LeftMenu>供应商档案</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+	
	"<a href=\"Index.php?controller=JiChu_Employ\" target=LeftMenu>员工档案</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=JiChu_Department\" target=LeftMenu>部门资料</a>"+
	"<font style='color:#666'>&nbsp;&nbsp;|&nbsp;&nbsp;</font>"+
	"<a href=\"Index.php?controller=JiChu_Vat\" target=LeftMenu>染缸档案</a>"},
	
	{id:8,name:"权限管理",surl:"<a href=\"Index.php?controller=Acm_User\" target=LeftMenu>权限管理</a>"},
	{id:9,name:"OA",surl:"<a href=\"Index.php?controller=OA_Message\" target=LeftMenu>首页信息管理</a>"}
]
