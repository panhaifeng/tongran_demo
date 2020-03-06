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
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<script language="javascript">
{literal}
var _emptyRow = null;
$(function(){
	$('#form1').validate({
		rules:{
			supplierId:'required',
			jingshouRenId:'required',
			zhidanRenId:'required',
			yanshouRenId:'required',
			shenheRenId:'required'
		}				 
	});
	var rows = document.getElementById('tbl').rows;
	_emptyRow = rows[rows.length-1].cloneNode(true);
	
	//增加9行待录入项目
	var tbl = document.getElementById('tbl');
	/*for (var i=0;i<9;i++) {
		tbl.rows[0].parentNode.appendChild(_emptyRow.cloneNode(true));
		//var newRow = ;
	}
	
	$('#btnAdd').click(function(){
		var tbl = document.getElementById('tbl');
		var row = tbl.rows[tbl.rows.length-1];
		for (var i=0;i<5;i++) row.parentNode.insertBefore(row.cloneNode(true),row);
	});*/
});
function addRow(){
	var tbl = document.getElementById('tbl');
	var row = tbl.rows[tbl.rows.length-2];
	for(var i=0;i<5;i++){
		row.parentNode.insertBefore(row.cloneNode(true),row);
	}
}
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

function applyWare(ret,pos) {
	if(!ret || ret=='close') return false;			
	if(pos==-1) return false;
	//dump(ret);
	var wareId = document.getElementsByName('wareId[]');
	var texts = document.getElementsByName('wareName[]');
	var kucun = document.getElementsByName('tdKucun');
		var wn = document.getElementsByName('tdWareName');
		var gg = document.getElementsByName('tdGuige');
		var u = document.getElementsByName('tdUnit');
		var cnt = document.getElementsByName('cnt[]');
	if(ret.guige!='') texts[pos].value= ret.wareCode;
	else texts[pos].value= ret.wareCode;
	wareId[pos].value= ret.id;
	kucun[pos].innerHTML= ret.cntKucun;	
	wn[pos].innerHTML = ret.wareName;
	gg[pos].innerHTML = ret.guige;
	u[pos].innerHTML = ret.unit;
	cnt[pos].focus();
}

function delRow(obj) {
	var o = document.getElementsByName('btnDel');
	var pos = -1;
	for(var i=0;o[i];i++) {
		if(o[i]==obj) {
			pos=i;break;
		}
	}
	if(pos==-1) return false;
	
	var tbl = document.getElementById('tbl');
	//如果只有一行，禁止删除
	if(tbl.rows.length==2) {
		return false;
	}
	tbl.deleteRow(pos+1);
}
function selSupplier(){
	var url="?controller=jichu_supplier&action=Popup";
	ymPrompt.win({message:url,handler:callBack,width:700,height:500,title:'选择供应商',iframe:true});
	return false;        
	function callBack(ret){
			//alert(ret);
			if(!ret || ret=='close') return false;			
			
			$('#supplierName').val(ret.compName);
			$('#supplierId').val(ret.id);
	}	
}
function calMoney(obj) {
	var id = obj.id;
	var objs = document.getElementsByName(id);
	var pos = -1;
	for (var i=0;objs[i];i++) {
		if(objs[i]==obj) {
			pos = i;break;
		}
	}
	if(pos==-1) return false;
	
	var moneys = document.getElementsByName('money[]');
	var cnts = document.getElementsByName('cnt[]');
	var danjias = document.getElementsByName('danjia[]');
	if(cnts[pos].value!=''&&danjias[pos].value!='') moneys[pos].value=(parseFloat(cnts[pos].value) * parseFloat(danjias[pos].value)).toFixed(2);
	
	//计算合计
	var tCnt = tMoney = 0;
	//var taxRate = 0.17;
	for (var i=0;cnts[i];i++) {
		//if(cnts[i].value!='') tCnt += parseFloat(cnts[i].value);
		if(cnts[i].value!=''&&danjias[i].value!='') tMoney += parseFloat(cnts[i].value)*parseFloat(danjias[i].value);
	}
	//$('#spanTotalCnt').text(tCnt.toFixed(2));
	$('#spanMoney').text(tMoney.toFixed(2));
	//$('#spanTax').text((tMoney*taxRate).toFixed(2));
	//$('#spanTotalmoney').text((tMoney*(1+taxRate)).toFixed(2));	
	
}

function calMoney1(obj) {
	var id = obj.id;
	var objs = document.getElementsByName(id);
	var pos = -1;
	for (var i=0;objs[i];i++) {
		if(objs[i]==obj) {
			pos = i;break;
		}
	}
	if(pos==-1) return false;
	
	var moneys = document.getElementsByName('money[]');
	var cnts = document.getElementsByName('cnt[]');
	var danjias = document.getElementsByName('danjia[]');
	if(cnts[pos].value!=''&&moneys[pos].value!='') {
		//按+号截取
		var temp=moneys[pos].value.split('+');
		var tMoney=0;
		for(var i=0;temp[i];i++) {
			tMoney+=parseFloat(temp[i]||0);
		}
		danjias[pos].value=(tMoney/parseFloat(cnts[pos].value)).toFixed(6);
	}
	
	//计算合计
	var tCnt = tMoney = 0;
	//var taxRate = 0.17;
	for (var i=0;cnts[i];i++) {
		//if(cnts[i].value!='') tCnt += parseFloat(cnts[i].value);
		if(cnts[i].value!=''&&danjias[i].value!='') tMoney += parseFloat(cnts[i].value)*parseFloat(danjias[i].value);
	}
	//$('#spanTotalCnt').text(tCnt.toFixed(2));
	$('#spanMoney').text(tMoney.toFixed(2));
	//$('#spanTax').text((tMoney*taxRate).toFixed(2));
	//$('#spanTotalmoney').text((tMoney*(1+taxRate)).toFixed(2));	
	
}
function kd(e,obj){
	var keyCode = e.keyCode;	
	if(keyCode==13) {
		var btns = document.getElementsByName('btnSel');
		var ws = document.getElementsByName('wareName[]');	
		var pos = -1;
		for (var i=0;ws[i];i++) {
			if(ws[i]==obj) {
				pos=i;break;
			}
		}
		if(pos==-1) return false;
		//根据输入的关键字，搜索相匹配的物料，如果物料数量为1，显示，
		//如果为0，提示错误，
		//如果多个，跳出选择
		var url='?controller=jichu_ware&action=GetJsonByKey';
		var param= {key:obj.value};
		$.getJSON(url,param,function(json){
			if(!json||json.length==0) {
				alert('未发现匹配的物料!');return false;
			}
			if(json.length==1) {
				applyWare(json[0],pos);
				return false;
			}
			selWare(btns[pos]);
			return false;
		});	
		return false;
	}
	return true;
}
//数量回车后焦点移动到下一个
function next(e,obj){
	if(e.keyCode==13) {
		e.keyCode=9;
	}
	return true;
}
//单价回车后进入下一行
function nextRow(e,obj){
	if(e.keyCode==13) {
		//如果有+号，进行计算
		var temp=obj.value.split('+');
		var tMoney=0;
		for(var i=0;temp[i];i++) {
			tMoney+=parseFloat(temp[i]||0);
		}
		obj.value=tMoney;
		
		//如果是最后一行增加，否则跳到下一行
		var pos=-1;
		var dj=document.getElementsByName('money[]');
		//alert(dj[0]==obj);
		for (var i=0;dj[i];i++) {
			if(dj[i]==obj) {
				pos=i;break;
			}
		}
		//alert(pos);
		if(pos==-1) return false;
		var tbl = document.getElementById('tbl');		
		
		//如果是最后一行，新增一行	
		if(tbl.rows.length-2==pos)	{			
			var row = tbl.rows[tbl.rows.length-1];
			var newRow=row.parentNode.appendChild(_emptyRow.cloneNode(true));
		} 
		//下一个wareName[]获得焦点
		//debugger;
		var wn = document.getElementsByName('wareName[]');
		wn[pos+1].focus();
		return false;
	}
	return true;
}
//控制使其不会多次提交
function mm(obj){
	var supplierId=document.getElementById('supplierId').value;
	if(supplierId==''){
		alert('请选择供应商!');
		return false;
	}
	var jingshouRenId=document.getElementById('jingshouRenId').value;
	if(jingshouRenId==''){
		alert('请选择经手人!');
		return false;
	}
	var yanshouRenId=document.getElementById('yanshouRenId').value;
	if(yanshouRenId==''){
		alert('请选择验收人!');
		return false;
	}
	var o = document.getElementsByName(obj.name);
	document.getElementById("kind").value=obj.value;
	for(var i=0;o[i];i++) o[i].disabled=true;
	//obj.disabled=true;
	form1.submit();
}
</script>
<style type="text/css">
 #divTotal {margin-left:40px}
 #divTotal div { float:left; width:18%;}
 body {background-color:#FFFFFF}
 .text{ background-color:#ffffff; border-bottom:1px dotted; border-top:0px; border-left:0px; border-right:0px}
 #tbl,#tbl1 { width:95%; border-left:1px solid #000; border-top:1px solid #000;}
 #tbl td,#tbl1 td { border-color:#000000;border-right:1px solid #000; border-bottom:1px solid #000;}
 #footButton { clear:both;}
</style>
{/literal}
</head>

<body>
<div align="center">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post">
<table width="100%" border="0">
<tr>
  <td height="25" align="center" style="font-size:15px"><strong>{webcontrol type='GetAppInf' varName='compName'}入库单<br>
    <input name="rukuDate" type="text" class="text" id="rukuDate" onClick="calendar()"  value="{$arr_field_value.rukuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15">
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="hidden" name="id" id="id" value="{$arr_field_value.id}">
  <input name="rukuCode" type="text" class="text" id="rukuCode" value="{$arr_field_value.rukuCode}" size="15">
  </strong></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" id="tbl1">
  <tr>
    <td height="25">供应商：
      <input name="supplierName" type="text" class="text" id="supplierName" readonly="readonly" value="{$arr_field_value.Supplier.compName}">
        <input type="button" name="btnSelSupplier" id="btnSelSupplier" value="..." onClick="selSupplier()">
        <input name="supplierId" type="hidden" id="supplierId" value="{$arr_field_value.supplierId}"></td>
    <td>经手人：
      <!--{*<input name="supplierName2" type="text" class="text" id="supplierName2" size="10" readonly="readonly">
        <input type="button" name="btnSelSupplier2" id="btnSelSupplier2" value="..." onClick="selSupplier()">*}-->
        <select id="jingshouRenId" name="jingshouRenId"> 
        <option value="">请选择</option>       
        {foreach from=$kind item=item}
        {if $item.kind=='经手'}
        <option value='{$item.employId}' {if $arr_field_value.jingshouRenId==$item.employId}selected{/if}>{$item.employs.employName}</option>
        {/if}
        {/foreach}
        </select>
        </td>
    <td align="right" >送货单号:
      <input name="songhuoCode" type="text" class="text" id="songhuoCode" value="{$arr_field_value.songhuoCode}" size="15"></td>
  </tr>
</table>
<table border="0" cellpadding="1" cellspacing="1" id='tbl'>
<tr class="th">
  <td height="30" align="center">材料编码</td>
  <td align="center">材料名称</td>
  <td align="center">材料规格</td>
  <td align="center">单位</td>
  <td align="center">当前库存</td>

  <td align="center">本次入库</td>
  <td align="center">单价</td>
  <td align="center">金额</td>
  <td align="center">操作</td>
</tr>

{foreach from=$arr_field_value.Ware item=item}
<tr>
  <td align="center"><input type="hidden" name="ruku2wareId[]" id="ruku2wareId[]" value="{$item.id}">
    <input name="wareName[]" type="text" class="text" id="wareName[]" title='可输入助记码、编码或品名关键字回车进行查找' onKeyDown='return kd(event,this)' size="15" value="{$item.Wares.wareCode}"/>
    <input type="button" name="btnSel" id="btnSel" value="..." onClick="selWare(this)" />
    <input name="wareId[]" type="hidden" id="wareId[]"  value="{$item.wareId}"/>    </td>
  <td align="center" id="tdWareName" name='tdWareName'>{$item.Wares.wareName|default:'&nbsp;'}</td>
  <td align="center" id="tdGuige" name='tdGuige'>{$item.Wares.guige|default:'&nbsp;'}</td>
  <td align="center" id="tdUnit" name='tdUnit'>{$item.Wares.unit|default:'&nbsp;'}</td>
  <td align="center" id="tdKucun" name='tdKucun'>{$item.cntKucun|default:'&nbsp;'}</td>
  <td align="center"><input name="cnt[]" type="text" class="text" id="cnt[]" onKeyDown="return next(event,this)" onKeyUp="calMoney(this)" size="8" value="{$item.cnt}"></td>
  <td align="center"><input name="danjia[]" type="text" class="text" id="danjia[]" size="8" value="{$item.danjia}"  onKeyUp="calMoney(this)" onKeyDown="return next(event,this)"></td>
  <td align="center"><input name="money[]" type="text" class="text" id="money[]" size="8" value="{$item.money}"  onKeyDown="return nextRow(event,this)" onKeyUp="calMoney1(this)"></td>
  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" onClick="delRow(this)"></td>
</tr>
{/foreach}
<tr>
  <td align="center"><input name="wareName[]" type="text" class="text" id="wareName[]" title='可输入助记码、编码或品名关键字回车进行查找' onKeyDown='return kd(event,this)' size="15"/>
    <input type="button" name="btnSel" id="btnSel" value="..." onClick="selWare(this)" />
    <input name="wareId[]" type="hidden" id="wareId[]" />    </td>
  <td align="center" id='tdWareName' name='tdWareName'>&nbsp;</td>
  <td align="center" id='tdGuige' name='tdGuige'>&nbsp;</td>
  <td align="center" id='tdUnit' name='tdUnit'>&nbsp;</td>
  <td align="center" id='tdKucun' name='tdKucun'>&nbsp;</td>
  <td align="center"><input name="cnt[]" type="text" class="text" id="cnt[]" onKeyDown="return next(event,this)" onKeyUp="calMoney(this)" size="8"></td>
  <td align="center"><input name="danjia[]" type="text" class="text" id="danjia[]" onKeyUp="calMoney(this)" onKeyDown="return next(event,this)" size="8"></td>
  <td align="center"><input name="money[]" type="text" class="text" id="money[]" size="8"  onKeyDown="return nextRow(event,this)" onKeyUp="calMoney1(this)"></td>
  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" onClick="delRow(this)"></td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" id="tbl1">
  <tr>
    <td height="25"><div id='divTotal' style="text-align:left">	
    <div>
    	金额合计:<span id='spanMoney' >{$arr_field_value.tCnt}</span>
    </div>
    
</div></td>
    </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" id="tbl1">
  <tr>
    <td height="25">制单：<!--{*高凤华*}-->
    <select id="zhidanRenId" name="zhidanRenId"> 
    <option value="">请选择</option>  
    {foreach from=$kind item=item}
    {if $item.kind=='制单'}
    <option value='{$item.employId}' {if $arr_field_value.zhidanRenId==$item.employId}selected{/if}>{$item.employs.employName}</option>
    {/if}
    {/foreach}
    </select>
    </td>
    <td>验收：<!--{*徐小艳*}-->
    <select id="yanshouRenId" name="yanshouRenId">
    <option value="">请选择</option>
    {foreach from=$kind item=item}
    {if $item.kind=='验收'}
    <option value='{$item.employId}' {if $arr_field_value.yanshouRenId==$item.employId}selected{/if}>{$item.employs.employName}</option>
    {/if}
    {/foreach}
    </select></td>
    <td align="right" >审核：<!--{*江国良*}-->
    <select id="shenheRenId" name="shenheRenId">
    <option value="">请选择</option>
    {foreach from=$kind item=item}
    {if $item.kind=='审核'}
    <option value='{$item.employId}' {if $arr_field_value.shenheRenId==$item.employId}selected{/if}>{$item.employs.employName}</option>
    {/if}
    {/foreach}
    </select>
    </td>
  </tr>
</table>


<div id="footButton">
	<input name="Next" type="button" id="Next" value='确定并输入下一个' style="display:none">		    
    <input name="Submit" type="button" id="Submit" value='确定并录入下一个' onClick="mm(this)">	
    <input type="button" name="Submit" id="button" value="确定并打印" onClick="mm(this)">
    <input name="Submit" type="button" id="Submit" value='确定并返回' onClick="mm(this)">
    <input name="Back" type="button" id="Back" value='返回' onClick="javascript:window.history.go(-1)" style="display:none">
    {if $smarty.get.id!=''}
    <input type="button" name="button1" id="button1" value="打印" onClick="window.open('Index.php?controller={$smarty.get.controller}&action=print&id={$smarty.get.id}')">
    {/if}
    <input type="hidden" name="kind" id="kind">
    
</div>
</form></div>
</body>
</html>
