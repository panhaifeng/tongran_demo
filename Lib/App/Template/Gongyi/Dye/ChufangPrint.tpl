<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工艺处方单打印</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css">
{literal}
<style type="text/css">
body,form,table{margin:0px; padding:0px;}
td{font-size:18px;}
td span{font-weight:bold;}
.haveBorder{border:1px solid #000;}
.th td {font-weight:bold;}
.haveBorder td {border-bottom:1px solid #000; border-right:1px solid #000; border-collapse:collapse; height:15px;}
.caption{font-size:18px; font-weight:bold;}
</style>
<script language="javascript" src="Resource/Script/Lodop/CheckActivX.js"></script>

<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
  <param name="CompanyName" value="常州易奇信息科技有限公司">
  <param name="License" value="664717080837475919278901905623">
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript">
function CreatePrintPage(obj,offsetX,offsetY) {	
	//if(!obj.Detect && !obj.AssocDetect) return false;
	//LODOP.PRINT_INIT();
	//obj = {};
	var title = "工艺处方单";
	LODOP.PRINT_INIT(title);
	//设置纸张大小
	//SET_PRINT_PAGESIZE(intOrient, intPageWidth,intPageHeight,strPageName);
//LODOP.SET_PRINT_PAPER(8,2,755,529,"工艺处方单");
LODOP.SET_PRINT_PAGESIZE(0,2000,1400,"0");
LODOP.ADD_PRINT_SHAPE(1,150,18,706,1,0,1,128);
LODOP.ADD_PRINT_SHAPE(1,287,19,705,1,0,1,128);
LODOP.ADD_PRINT_LINE(230,18,231,718,2,1);
LODOP.ADD_PRINT_TEXT(6,234,233,34,"工艺处方单");
LODOP.SET_PRINT_STYLEA(3,"FontSize",16);
LODOP.SET_PRINT_STYLEA(3,"Alignment",2);
LODOP.ADD_PRINT_TEXT(54,15,170,20,"日期：");
LODOP.ADD_PRINT_TEXT(54,197,170,20,"客户名：");
LODOP.ADD_PRINT_TEXT(54,377,170,20,"颜色：");
LODOP.ADD_PRINT_TEXT(54,560,170,20,"色号：");
LODOP.ADD_PRINT_TEXT(82,15,170,20,"染坯要求：");
LODOP.ADD_PRINT_TEXT(82,197,170,20,"锅型：");
LODOP.ADD_PRINT_TEXT(82,377,170,20,"折率：");
LODOP.ADD_PRINT_TEXT(82,560,170,20,"水容量：");
LODOP.ADD_PRINT_TEXT(107,15,170,20,"处方人：");
LODOP.ADD_PRINT_TEXT(133,15,74,20,"缸号");
LODOP.SET_PRINT_STYLEA(13,"Italic",1);
LODOP.ADD_PRINT_TEXT(133,147,53,20,"纱支");
LODOP.SET_PRINT_STYLEA(14,"Italic",1);
LODOP.ADD_PRINT_TEXT(133,269,43,20,"定重");
LODOP.SET_PRINT_STYLEA(15,"Italic",1);
LODOP.ADD_PRINT_TEXT(133,385,80,20,"筒子数量");
LODOP.SET_PRINT_STYLEA(16,"Italic",1);
LODOP.ADD_PRINT_TEXT(133,521,70,20,"总公斤数");
LODOP.SET_PRINT_STYLEA(17,"Italic",1);
LODOP.ADD_PRINT_TEXT(133,670,54,20,"包数");
LODOP.SET_PRINT_STYLEA(18,"Italic",1);
LODOP.ADD_PRINT_TEXT(269,13,50,20,"工序");
LODOP.SET_PRINT_STYLEA(19,"Italic",1);
LODOP.ADD_PRINT_TEXT(269,94,85,20,"染化料/助剂");
LODOP.SET_PRINT_STYLEA(20,"Italic",1);
LODOP.ADD_PRINT_TEXT(269,207,80,20,"单位用量");
LODOP.SET_PRINT_STYLEA(21,"Italic",1);
LODOP.ADD_PRINT_TEXT(269,311,50,20,"缸用量");
LODOP.SET_PRINT_STYLEA(22,"Italic",1);
LODOP.ADD_PRINT_TEXT(269,395,50,20,"温度");
LODOP.SET_PRINT_STYLEA(23,"Italic",1);
LODOP.ADD_PRINT_TEXT(269,482,100,20,"时间");
LODOP.SET_PRINT_STYLEA(24,"Italic",1);
LODOP.ADD_PRINT_TEXT(269,622,100,20,"备注");
LODOP.SET_PRINT_STYLEA(25,"Italic",1);
LODOP.ADD_PRINT_TEXT(233,15,100,20,"合计");
LODOP.ADD_PRINT_TEXT(233,380,100,20,"合计筒子数");
LODOP.ADD_PRINT_TEXT(233,519,100,20,"合计公斤数");
LODOP.ADD_PRINT_TEXT(233,669,62,20,"合计包数");

//动态内容
LODOP.ADD_PRINT_TEXT(293,13,100,20,"工序1");
LODOP.ADD_PRINT_TEXT(315,13,100,20,"工序2");
LODOP.ADD_PRINT_TEXT(156,17,100,20,"缸号1");
LODOP.ADD_PRINT_TEXT(175,17,100,20,"缸号2");
}

$(function(){
	//alert('asdf');
	document.getElementById('btnPrint').onclick = function(){
		//alert('asdf');
		CreatePrintPage(null,0,0);
		LODOP.PRINT_DESIGN();
		//LODOP.PRINT();
	}
});
</script>

<script language=javascript id=clientEventHandlersJS> 
<!-- 

function prnbutt_onclick() { 
	window.print(); 
	return true; 
} 

function window_onbeforeprint() { 
	prn.style.visibility ="hidden"; 
	return true; 
} 

function window_onafterprint() { 
	prn.style.visibility = "visible"; 
	return true; 
} 
//根据传入的样本数据进行打印输出

//--> 

</script>{/literal}
</head>
<body onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<div class="caption" align="center">筒染车间染色工艺处方单</div>
<form name="form1" method="post" action="{url controller=$smarty.get.controller action='SaveForLl'}" id='form1'>
	  <input name="gangId" type="hidden" id="gangId" value="{$chufang.Gang.id}">
      <input name="chufangId" type="hidden" id="chufangId" value="{$chufang.id}">
<table width="700" align="center">
	<tr><td colspan="3">
		<table width="100%">
		<tr align="left">
		<td><span>客户名：</span>{$chufang.clientName}</td>
		<td><span>颜色：</span>{$chufang.OrdWare.color}</td>
		<td><span>色号：</span>{$chufang.OrdWare.colorNum}</td>
		<td><span>纱支：</span>{$chufang.guige}</td>
		</tr>
		<tr align="left">
		<td height=15px><span>缸号：</span>{$chufang.Gang.vatNum}		    </td>
		<td><span>总公斤数：</span>{$chufang.Gang.cntPlanTouliao}</td>
		<td><span>折率：</span>{$chufang.Gang.rsZhelv}</td>
		<td><span>筒子数量：</span>{$chufang.Gang.planTongzi}</td>
		</tr>
		<tr align="left">
		<td height=15px><span>包数：</span>{$chufang.Gang.cntPlanTouliao/5} </td>
		<td><span>染坯要求：</span>{$chufang.dyeKind} </td>
		<td><span>锅型：</span>{$chufang.Gang.Vat.vatCode}</td>
		<td><span>水容量：</span>{$chufang.Gang.shuirong}升</td>
		</tr>
		<tr><td colspan=4></td><tr>
		</table>
	</td></tr>
	
	<tr>
	<td colspan="3">
	<table width="100%" border="0" cellpadding="2px" cellspacing="0" class="haveBorder" >
	<tr class=th>
	<td align="center">工序</td>
	<td height="15px" align="center">染化料/助剂</td>
	<td align="center">用量(单位)</td>
	<td align="center">缸用量</td>
	<td align="center">温度</td>
	<td align="center">时间</td>
	<td align="center">备注</td>
	<td align="center" width="8%">&nbsp;</td>
	<td align="center" width="8%">&nbsp;</td>
	<td align="center" width="8%">&nbsp;</td>
	</tr>
	{foreach from=$ranliao item=item}
	<tr>
	<td align="center" style="height:15px">{$item.Gongxu.gongxuName|default:'&nbsp;'}</td>
	<td align="center" style="height:15px">{$item.wareName|default:'&nbsp;'}
	<input type="hidden" name="wareId[]" id="wareId[]" value="{$item.wareId}"></td>	  
	<td align="center">{$item.unitKg}{$item.unit}&nbsp;</td>
	<td align="center">{$item.vatCnt|default:'&nbsp;'}
	<input type="hidden" name="cnt[]" id="cnt[]" value="{$item.vatCnt}"></td>
	<td align="center">{$item.tmp|default:'&nbsp;'}</td>
	<td align="center">{$item.timeRs|default:'&nbsp;'}</td>
	<td align="center">{$item.memo|default:'&nbsp;'}</td>
	<td align="center">&nbsp;</td>
	<td align="center">&nbsp;</td>
	<td align="center">&nbsp;</td>
	</tr>				
	{/foreach}
	
	  
		</table>
	</td>
	</tr>
	
	<tr>
	<td height='30px'>处方人: {$chufang.chufangren}</td>
	<td height='30px' align="right">&nbsp;</td>
	<td height='30px' align="right">打印日期:{$smarty.now|date_format:"%Y-%m-%d"}</td>
	</tr>
</table>

<div id=prn align="center">
	{if $smarty.get.for=='ll'}
<input type='button' value="确定出库" onClick="document.getElementById('form1').submit()">
    <input onClick="window.location.href='{url controller=$smarty.get.controller action='listForLl'}'" type=button value="取消">
    {else}
	<input language=javascript id=prnbutt onClick="return prnbutt_onclick()" type=button value="打印">
    <input name="btnPrint" id="btnPrint"  type=button value="打印1">
    <input language=javascript id=prnbutt2 onClick="window.location.href='{url controller=$smarty.get.controller action='changeRsZhelv' gangId=$smarty.get.gangId chufangId=$smarty.get.chufangId ordwareId=$smarty.get.id}'" type=button value="修改折率和水容量">
  	{/if}
</div>

</form></body></html>
