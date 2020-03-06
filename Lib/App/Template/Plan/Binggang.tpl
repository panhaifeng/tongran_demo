<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/common.js"></script>
<script language="javascript" src="Resource/Script/TmisPopup.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" type="text/css" rel="stylesheet" />
{literal}
<script language="javascript">
var table;
var _cache=[];
$(function(){
	renderVatNum();		
});
function renderVatNum() {
	new TmisPopup({
			obj:document.getElementsByName('vatNum'),//进行渲染的目标元素,可以是document.getElementsByName('')得到的数组
			fieldInText:'vatNum',//选择后对text控件进行赋值的字段
			fieldInHidden:'id',//选择后对hidden控件进行赋值的字段,默认是id
			width : 120,//渲染后的宽度
			urlPop:'?controller=Plan_Dye&action=popup',//弹出框的地址
			titlePop:'选择排缸记录',//弹出框的标题
			widthPop:700,
			heightPop:500,
			urlSearch:'?controller=Plan_Dye&action=GetByCode',//根据输入进行检索的地址
			//idHidden:'orderId',//创建的hidden元素的id和name
			idBtn:'_btnPlan',//创建的按钮的id
			isArray:false,//if true,创建的元素以[]结尾
			onSelect: function(json,pos){
				//dump(json);return false;
				//dump(_cache);
				if(!json)return false;
				table=document.getElementById('tab');
				while(tab.rows.length>1) tab.deleteRow(1);
				for(var i=0;json[i];i++){
					var tr = table.insertRow(-1);
					tr.insertCell(-1).innerHTML=json[i].vatNum;
					tr.insertCell(-1).innerHTML=json[i].compName+"<input type='hidden' id='gangId[]' name='gangId[]' value='"+json[i].id+"'>";
					tr.insertCell(-1).innerHTML=json[i].orderCode;
					tr.insertCell(-1).innerHTML=json[i].guige;
					tr.insertCell(-1).innerHTML=json[i].color;
					tr.insertCell(-1).innerHTML=json[i].cntPlanTouliao;
					tr.insertCell(-1).innerHTML=json[i].zhishu|'';
					tr.insertCell(-1).innerHTML=json[i].vatCode;
					//tr.insertCell(-1).innerHTML=json[i].orderCode;
					tr.insertCell(-1).innerHTML="<input type='button' id='btnDel' name='btnDel' value='删除' onClick='delRow(this)'>";
				}
				
			}//选择某个记录后的触发动作
		});
}
function delRow(obj){
	var table=document.getElementById("tab");
	var arrButton=document.getElementsByName("btnDel");
	var pos=-1;
	for(var i=0;arrButton[i];i++){
		if(arrButton[i]==obj){
			pos=i;
		}
	}
	if(pos==-1) return false;
	table.deleteRow(pos+1);
}
function checkForm(){
	//alert(1);return false;
	var vatId=document.getElementById('vatId').value;
	if(vatId==''){
		alert('请选择新染缸！');
		return false;
	}
	return true;
}
</script>
<style type="text/css">
.tableHaveBorder {border-collapse:collapse; border:1px solid #999999;}
.tableHaveBorder td {border-bottom:1px solid #999999; border-right:1px solid #999999;}
</style>
{/literal}
</head>

<body>
<form id="form1" name="form1" action="{url controller=$smarty.get.controller action='saveBinggang'}" method="post" onSubmit="return checkForm()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="5">选择缸号：    
    <input type="text" name="vatNum" id="vatNum" /></td>
  </tr>
  <tr>
    <td colspan="5"><table id="tab" width="100%" class="tableHaveBorder" border="0" cellspacing="0" cellpadding="0">
      <tr class="th">
        <td>缸号</td>
        <td>客户</td>
        <td>订单号</td>
        <td>纱支</td>
        <td>颜色</td>
        <td>计划投料数</td>
        <td>支数</td>
        <td>并前染缸</td>
        <td>操作</td>
      </tr>
      <tr style="display:none;">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
    <td>新染缸：
      <select name="vatId" id="vatId">
      {webcontrol type='TmisOptions' model='Jichu_Vat'}
      </select></td>
    <td>班次：
    	<select name="ranseBanci" id="ranseBanci">
        <option value="1">早班</option>
        <option value="3">早班1</option>
        <option value="4">早班2</option>
        <option value="5">早班3</option>
        <option value="2">晚班</option>
        <option value="6">晚班1</option>
        <option value="7">晚班2</option>
        <option value="8">晚班3</option>
        </select>
    </td>
    <td>日期：
      <input name="dateAssign" type="text" id="dateAssign" value="{$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
    <td>是否加急：<input name="isJiaji" type="checkbox" id="isJiaji" value="1"/></td>
  </tr>
  <tr align="center">
    <td colspan="5"><input type="submit" name="button" id="button" value="保存" />
      <input type="button" name="button2" id="button2" value="返回" onClick="window.location.href='?controller={$smarty.get.controller}&action=paigangSchedule'"></td>
  </tr>
</table>
</form>
</body>
</html>
