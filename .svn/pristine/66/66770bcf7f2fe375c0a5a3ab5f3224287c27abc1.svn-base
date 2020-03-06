<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>

<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript">
var _emptyRow=null;
$(function(){
	var rows = document.getElementById('tbl').rows;
	_emptyRow = rows[rows.length-1].cloneNode(true);		   
});
function selWare(obj) {
	var url="?controller=jichu_ware&action=Popup";
	
	var btns = document.getElementsByName('btnSel');
	var pos = -1;
	for (var i=0;btns[i];i++) {
		if(btns[i]==obj) {
			pos=i;break;
		}
	}
	if(pos==-1) return false;
	var objs = document.getElementsByName('wareName[]');
	//alert(objs[pos].value);
	if(objs[pos].value!='') url += '&key=' + encodeURI(objs[pos].value);
			
	ymPrompt.win({message:url,handler:callBack,width:700,height:500,title:'选择物料',iframe:true});
	return false;        
	function callBack(ret){
		applyWare(ret,pos);
	}   
}
function applyWare(ret,pos){
	if(!ret || ret=='close') return false;			
	if(pos==-1) return false;
	//alert(pos);return false;
	//dump(ret);return false;
	var wareCode=document.getElementsByName('wareCode[]');
	var wareId=document.getElementsByName('wareId[]');
	var wareName=document.getElementsByName('wareName[]');
	var guige=document.getElementsByName('guige[]');
	var units=document.getElementsByName('unit[]');
	var cntKucun=document.getElementsByName('cntKucun[]');
	var danjia=document.getElementsByName('danjia[]');
	wareCode[pos].value=ret.wareCode;
	wareId[pos].value=ret.id;
	wareName[pos].value=ret.wareName;
	guige[pos].value=ret.guige;
	units[pos].value=ret.unit;
	cntKucun[pos].value=ret.cntKucun;
	danjia[pos].value=ret.danjia;
}
function nextRow(e,obj){
	if(e.keyCode==13) {
		//alert(e.keyCode);
		var tbl = document.getElementById('tbl');		
		var row = tbl.rows[tbl.rows.length-1];
		var newRow=row.parentNode.appendChild(_emptyRow.cloneNode(true));
		return false;
	}
	return true;
}
function checkForm(){
	if(document.getElementById('faliaoren').value=='') {
		alert('请选择发料人(可在系统设置中进行设置)');
		return false;
	}
	
	//判断是否申请大于库存
	var kucun = document.getElementsByName('cntKucun[]');
	var cnt = document.getElementsByName('cnt[]');
	
	for (var i=0;kucun[i];i++) {
		//alert(kucun[i].innerHTML+','+cnt[i].value);
		if(parseFloat(kucun[i].value||0)<parseFloat(cnt[i].value)) {
			alert('系统检测到您的申领数量大于库存数,请重新输入申请数量!');return false;
		}
	}
	
	
	document.getElementById('Submit').disabled=true;
	return true;
}

</script>
<style type="text/css">
 #divTotal {margin-left:40px}
 #divTotal div { float:left; width:18%;}
 td {font-size:15px}
 body {background-color:#FFFFFF}
 .text{ background-color:#ffffff; border-bottom:1px dotted; border-top:0px; border-left:0px; border-right:0px}
 #tbl,#tbl1 { width:95%; border-left:1px solid #000; border-top:1px solid #000;border-collapse:collapse;}
 #tbl td,#tbl1 td { border-color:#000000;border-right:1px solid #000; border-bottom:1px solid #000;}
 #footButton { clear:both;}
 #title {clear:both; text-align:center; width:100%; height:30px; font-size:20px}
</style>{/literal}
</head>

<body>
<div id='title'><strong>出库登记</strong></div>

<div align="center">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return checkForm()">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>出库单号：
      <input name="chukuCode" type="text" class="text" id="chukuCode" value="{$aRow.chukuCode}" size="10">
    </td>
    <td>部门：
      <select id="depId" name="depId"> 
      {webcontrol type='TmisOptions' model='Jichu_Department' selected=$aRow.depId condition='parentId>=0'}
    </select></td>
  </tr>
</table>
<fieldset>
<legend>出库登记货品信息</legend>
<table border="0" cellpadding="1" cellspacing="1" id='tbl'>
<tr class="th">
  <td align="center"><strong>物料编码</strong></td>
  <td align="center"><strong>品名</strong></td>
  <td align="center"><strong>规格</strong></td>
  <td height="25" align="center"><strong>单位</strong></td>
  <td align="center"><strong>当前库存</strong></td>

  <td align="center"><strong>实际领用</strong></td>
  <td align="center"><strong>单价</strong></td>
  </tr>
  {foreach from=$aRow.Ware item=item}
<tr>
  <td align="center"><input name="wareCode[]" type="text" class="text" id="wareCode[]" title='可输入助记码、编码或品名关键字回车进行查找' onKeyDown='return kd(event,this)' value="{$item.Ware.wareCode}" size="15"/>
    <input type="button" name="btnSel" id="btnSel" value="..." onClick="selWare(this)" />
    <input name="wareId[]" type="hidden" id="wareId[]"  value="{$item.wareId}"/></td>
  <td align="center"><input name="wareName[]" type="text" class="text" id="wareName[]" value="{$item.Ware.wareName}" size="10"></td>
  <td align="center"><input name="guige[]" type="text" class="text" id="guige[]" value="{$item.Ware.guige}" size="10"></td>
  <td align="center"><input name="unit[]" type="text" class="text" id="unit[]" value="{$item.Ware.unit}" size="10"></td>
  <td align="center"><input name="cntKucun[]" type="text" class="text" id="cntKucun[]" value="{$item.cntKucun}" size="10"></td>
  <td align="center"><input name="cnt[]" type="text" class="text" id="cnt[]"onKeyDown="return nextRow(event,this)" value="{$item.cnt}" size="10"><input type="hidden" name="chuku2wareId[]" id="chuku2wareId[]" value="{$item.id}"></td>
  <td align="center"><input name="danjia[]" type="text" class="text" id="danjia[]" value="{$item.danjia}" size="10"></td>
</tr>
{/foreach}
<tr>
  <td align="center"><input name="wareCode[]" type="text" class="text" id="wareCode[]" title='可输入助记码、编码或品名关键字回车进行查找' onKeyDown='return kd(event,this)' size="15"/>
    <input type="button" name="btnSel" id="btnSel" value="..." onClick="selWare(this)" />
    <input name="wareId[]" type="hidden" id="wareId[]"  value="{$item.wareId}"/></td>
  <td align="center"><input name="wareName[]" type="text" class="text" id="wareName[]" size="10"></td>
  <td align="center"><input name="guige[]" type="text" class="text" id="guige[]" size="10"></td>
  <td align="center"><input name="unit[]" type="text" class="text" id="unit[]" size="10"></td>
  <td align="center"><input name="cntKucun[]" type="text" class="text" id="cntKucun[]" size="10"></td>
  <td align="center"><input name="cnt[]" type="text" class="text" id="cnt[]" size="10"onKeyDown="return nextRow(event,this)"><input type="hidden" name="chuku2wareId[]" id="chuku2wareId[]" value=""></td>
  <td align="center"><input name="danjia[]" type="text" class="text" id="danjia[]" size="10"></td>
  </tr>

</table>
</fieldset>	
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>出库日期：
<input name="chukuDate" type="text" class="text" id="chukuDate" onClick="calendar()" value="{$aRow.chukuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="10">
    </td>
    <td>发料人：
      <select id="faliaoren" name="faliaoren"> 
        {foreach from=$faliao item=item}
        <option value='{$item.employs.employName}' {if $arr_field_value.faliaoren==$item.employs.employName}selected{/if}>{$item.employs.employName}</option>
        {/foreach}
    </select></td>
    <td align="right">当前用户：{$smarty.session.REALNAME}</td>
  </tr>
</table>
<div id="footButton">
  <input name="Next" type="button" id="Next" value='确定并输入下一个' style="display:none">		    
<input name="Submit" type="submit" id="Submit" value='确定领用'>	
<input name="Back" type="button" id="Back" value='返回' onClick="javascript:window.history.go(-1)" style="display:none">
<input name="id" type="hidden" id="id" value="{$aRow.id}">
</div>
</form></div>
</body>
</html>
