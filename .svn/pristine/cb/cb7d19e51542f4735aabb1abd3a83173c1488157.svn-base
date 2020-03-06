{*此模板用来进行先输入筒子数，再计算定重的情况*}
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title|default:"排缸第二步"}</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit100.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
var _json //用于存放染缸选项返回的json
var _vatId = 0; // 染缸选项返回后的最佳染缸选中项
var _vat2shuirongId = new Array();// 层数选项的最佳水容量选中项


//复制某行
function copyTr(obj) {
	var tbl = document.getElementById('tblVat');
	var btn = document.getElementsByName('btnCopy');
	var rows = tbl.rows;
	var pos = -1;
	for (var i=0;i<btn.length;i++) {
		if (btn[i]==obj) {
			var pos = i;
			break;
		}
	}
	if(pos==-1) return false;
	
	var newRow = rows[pos+1].cloneNode(true);
	rows[pos+1].parentNode.insertBefore(newRow,rows[pos+1]);	
}
//复制某行
function removeTr(obj) {
	var tbl = document.getElementById('tblVat');
	var btn = document.getElementsByName('btnDel');
	var pos =-1;
	var rows = tbl.rows;
	for (var i=0;i<btn.length;i++) {
		if (btn[i]==obj) {
			pos = i;
			break;
		}
	}
	if(pos==-1) return false;
	
	tbl.deleteRow(pos+1);
	//rows[pos+1].parentNode.insertBefore(newRow,rows[pos+1]);	
}
function getGang(e) {
	var url='Index.php?controller=Plan_Dye&action=GetJsonByVatNum';
	var params = {vatId:e.value};
	$.getJSON(url,params,function(json){
		document.getElementById('vatNum').value=json;
	});
}

//设置定重span的innerHTML
// function setUnitKg(o) {
// 	var arrTongzi = document.getElementsByName('planTongzi[]');
// 	var arrSpan = document.getElementsByName('spanUnitKg');
// 	var arrTouliao = document.getElementsByName('cntPlanTouliao[]');
// 	for (var i=0;i<arrSpan.length;i++) {
// 		if (arrTongzi[i]==o) {
// 			arrSpan[i].innerText=parseInt(arrTouliao[i].value)/parseInt(o.value);
// 			return;
// 		}
// 	}
// }

//根据输入的定重设置筒子数
function setCntTongzi(o) {
	//alert(o.value);
	if (o.value=='' || parseFloat(o.value)==0) return false;
	//alert(typeof(o.value));
	var arrTongzi = document.getElementsByName('planTongzi[]');
	//var arrSpan = document.getElementsByName('spanUnitKg');
	var arrTouliao = document.getElementsByName('cntPlanTouliao[]');
	var arrZhelv = document.getElementsByName('zhelv[]');
	var arrUnitKg = document.getElementsByName('unitKg[]');
	for (var i=0;i<arrUnitKg.length;i++) {
		if (arrUnitKg[i]==o) {
			var pos = i;break;
		}
	}
	arrTongzi[pos].value=Math.round((arrTouliao[pos].value * arrZhelv[pos].value / o.value) || 0)
}

//根据输入的筒子数设置定重
function setUnitKg(o) {

	if (o.value=='' || parseFloat(o.value)==0) return false;
	//alert(typeof(o.value));
	var arrTongzi = document.getElementsByName('planTongzi[]');
	//var arrSpan = document.getElementsByName('spanUnitKg');
	var arrTouliao = document.getElementsByName('cntPlanTouliao[]');
	var arrZhelv = document.getElementsByName('zhelv[]');
	var arrUnitKg = document.getElementsByName('unitKg[]');
	var pos=-1;
	for (var i=0;i<arrTongzi.length;i++) {
		if (arrTongzi[i]==o) {
			var pos = i;break;
		}
	}
	if(pos==-1) return false;
	if(!o.value) return false;
	arrUnitKg[pos].value=(arrTouliao[pos].value * arrZhelv[pos].value / o.value).toFixed(2);
}

function checkSelect() {
	var arrOpt = document.getElementsByName('vatId[]');
	for (var i=0;i<arrOpt.length;i++) {		
		if (arrOpt[i].options.length==0) return false;		
	}
	document.getElementById('Submit').disabled=false;
}
function setOption(o) {	
	if (o.value=='') return false;
	var arrOpt = document.getElementsByName('vatId[]');
	var arrTongzi = document.getElementsByName('planTongzi[]');
	//var arrZhelv = document.getElementsByName('zhelv[]');
	var arrUnitKg = document.getElementsByName('unitKg[]');
	var arrCntJ=document.getElementsByName('cntJ[]');
	var arrCntW=document.getElementsByName('cntW[]');
	var obj;
	if(o.id=='planTongzi[]') obj=arrTongzi;
	else obj=arrUnitKg;
	
	var pos = -1;
	for (var i=0;i<obj.length;i++) {
		if (obj[i]==o||arrCntJ[i]==o||arrCntW[i]==o) {
			var pos = i;break;
		}
	}
	if(pos==-1) return false;
	
	var url='?controller=Plan_Dye&action=GetVatOption';
	var params={cntTongzi:arrTongzi[pos].value};
	while (arrOpt[i].options.length>0) {arrOpt[i].remove(0);}; 
	$.getJSON(url, params, function(json){
		// console.log(json);
		//设置o的option
		_json = json;
		_vatId = json[0].id;//默认选择第一条

		for (var j=0;j<json.length;j++){
			var opt=new Option(json[j].vatCode+"(可装:"+json[j].cntTongzi+")",json[j].id);   
			arrOpt[i].options.add(opt);
			_vat2shuirongId[json[j].id]=json[j].vat2shuirongId;
		}
		//设置提交按钮状态
		checkSelect();
		arrOpt[i].value=_vatId;
		setOptionCeng(arrOpt[i]);	
	});					
	return; 	
}
function changePos(obj){//
	var k =window.event.keyCode;
	var objs = document.getElementsByName('planTongzi[]');
	var dingzhong=document.getElementsByName('unitKg[]');
	var pos =-1;
	for (var i=0;objs[i];i++) {
		if(objs[i]==obj||dingzhong[i]==obj) {
			pos=i;break;
		}
	}
	if(pos==-1) return false;
	if(k==38) {//上
		if(pos==0) return false;
		if(objs[pos]==obj){
			objs[pos-1].focus();
		}else{
			dingzhong[pos-1].focus();
		}
	}
	if(k==40) {//下
		if(pos==objs.length-1) return false;
		if(objs[pos]==obj){
			objs[pos+1].focus();
		}else{
			dingzhong[pos+1].focus();
		}
	}
}
//设置层数选项
function setOptionCeng(o){
	if (o.value=='') return false;
	var obj = document.getElementsByName('vatId[]');
	var cengOpt = document.getElementsByName('vat2shuirongId[]');
	for (var i=0;i<obj.length;i++) {
		if (obj[i]==o) {
			var pos = i;break;
		}
	}
	var url='?controller=Jichu_Vat&action=GetCengOption';
	var params={vatId:obj[pos].value};
	var len = 0;
	while (cengOpt[pos].options.length>0) {cengOpt[pos].remove(0);}; 
	$.ajaxSettings.async = false;//同步执行，即getJSON按顺序执行，否则异步取得的数据不对 2015-11-05 by wuyou
	$.getJSON(url, params, function(json){
		len = json.length;
		if(json.length>0){
			//设置o的option
			for (var j=0;j<json.length;j++){
				var opt=new Option(json[j].kind+''+json[j].cengCnt+'层|筒子范围:'+json[j].minCntTongzi+'~'+json[j].maxCntTongzi+'|水溶量:'+json[j].shuirong,json[j].id);
				cengOpt[pos].options.add(opt);
			}
		}
	});
	var hasCengOpt = len>0?true:false; 
	if(hasCengOpt){
		// 设置最佳水容量选项
		var vatId = obj[pos].value;
		cengOpt[pos].value=_vat2shuirongId[vatId];
		//设置提交按钮状态
		checkSelect(false);
	}else{
		var vatId = obj[pos].value;
		for (var j=0;j<_json.length;j++){
			if(vatId ==_json[j].id){
				var vatCode = _json[j].vatCode;
			}
		}
		alert('缸号'+vatCode+'未设置层数，请在染缸档案中设置后再操作此环节！');
		checkSelect(true);
	}
	return; 
}
</script>
<style>
.table100{ text-align:center}
</style>
{/literal}
</head>

<div id="container">
<div id="nav">{include file="_ContentNav2.tpl"}</div>
<fieldset>
<legend>订单基本信息</legend>
	<table class="tableHaveBorder table100">
			<tr> 
				<td class="tdTitle">订单号：</td>
				<td align="left">{$arr_field_value.orderCode}</td>
				<td class="tdTitle">客户：</td>
				<td align="left">{$arr_field_value.Client.compName}</td>
				<td class="tdTitle">订单日期：</td>
				<td align="left">{$arr_field_value.dateOrder}</td>
				<td class="tdTitle">交货日期：</td>
				<td align="left">{$arr_field_value.dateJiaohuo}</td>
			</tr>
			<tr> 
				<td class="tdTitle">色牢度要求：</td>
				<td align="left" colspan="3">1, 干磨{$arr_field_value.fastness_gan}级；2，湿磨{$arr_field_value.fastness_shi}级； 3.白沾{$arr_field_value.fastness_baizhan}级；4.褪色{$arr_field_value.fastness_tuise}级</td>
				<td class="tdTitle">质量要求等级：</td>
				<td align="left">{$arr_field_value.zhiliang}</td>
				<td class="tdTitle">烘干要求：</td>
				<td align="left">{$arr_field_value.honggan}</td>
			</tr>
			<tr> 
				<td class="tdTitle">成品要求：</td>
				<td align="left" colspan="3">1.纸管:{$arr_field_value.packing_zhiguan} 
					2.塑料袋:{$arr_field_value.packing_suliao} 3.外包装:{$arr_field_value.packing_out} 
				</td>
				<td class="tdTitle">其他要求：</td>
				<td align="left" colspan="3">{$arr_field_value.memo}</td>
			</tr>
	</table>
</fieldset>

<form name="form1" action="{url controller=$smarty.get.controller action='savePlan'}" method=post>
<input type="hidden" name="{$pk_name}" value="{$arr_field_value.$pk_name}" />
<input type="hidden" name="gangTotal" value="{$gang_total}" />
<input type="hidden" name="page" value="{$page}" />
<fieldset>
<legend>排缸第二步</legend>
	<table class="tableHaveBorder table100" id="tblVat">
	  <tr class="th"> 
		<td>序号</td>
		<td>批号</td>
		<td>纱支规格</td>
		<td>颜色</td>
		<td>色号</td>
		<td>数量(kg)</td>
		<td colspan="2">计划投料</td>
		<td>折率</td>
		<td>计划筒数</td>
		<td>计划定重</td>
		<td>物理缸号</td>
		<td>层数</td>									
		<td>操作</td>
	  </tr>
	  {foreach from=$arr_field_value_ware item=item} 
	  <tr onMouseOver="this.style.background='#ccc'" onMouseOut="this.style.background=''"> 
		  <td rowspan="2">{$item.id}</td>
		  <td rowspan="2"><input type="text" name="pihao[]" size="5" value=""></td>
		  <td rowspan="2">{$item.Ware.wareName} {$item.Ware.guige}</td>
		  <td rowspan="2">{$item.color}</td>
		  <td rowspan="2">{$item.colorNum}</td>
		  <td rowspan="2">{$item.cntKg}</td>
		  <td><div align="center">经</div></td>
		  <td><div align="center">纬</div></td>
		  <td rowspan="2"><select name="zhelv[]" id="zhelv[]">                       
		    <option value="1">100%</option>
		    <option value="0.99">99%</option>
		    <option value="0.98">98%</option>
		    <option value="0.97">97%</option>
		    <option value="0.96" selected="selected">96%</option>
		    <option value="0.95">95%</option>
		    <option value="0.94">94%</option>
		    <option value="0.93">93%</option>
		    <option value="0.92">92%</option>
		    <option value="0.91">91%</option>
		    <option value="0.90">90%</option>
		    <option value="0.89">89%</option>
		    <option value="0.88">88%</option>
		    <option value="0.88">87%</option>
		    <option value="0.88">86%</option>
		    <option value="0.88">85%</option>
	      </select></td>
		  <td rowspan="2"><input name="planTongzi[]" type="text" id="planTongzi[]" size="5"  onclick="this.select()" onFocus="document.getElementById('Submit').disabled=true"  onblur="setOption(this)" onKeyUp="setUnitKg(this)" onkeydown="changePos(this)"/>
			<input type="hidden" name="order2wareId[]" size="12" value="{$item.id}"/></td>
		  <td rowspan="2"><input name="unitKg[]" type="text" id="unitKg[]" value="{$item.unitKg}" size="5"  {*onclick="this.select()" onFocus="document.getElementById('Submit').disabled=true" onBlur="setOption(this)" onKeyUp="setCntTongzi(this)"*} onkeydown="changePos(this)"/></td>
		  <td rowspan="2"><select name="vatId[]"  style="width:120px">{*取出装筒数大于或等于计划筒子数的最小两个染缸*}</select></td>
		  <td rowspan="2"><select name="vat2shuirongId[]" >{*取出选中染缸的层数*}</select></td>
		  <td rowspan="2"><input type="button" name="btnCopy" id="btnCopy" value="复制" onClick="copyTr(this)"/>
	      <input type="button" name="btnDel" id="btnDel" value="删除" onClick="removeTr(this)"/></td>
	  </tr>
	  <tr onMouseOver="this.style.background='#ccc'" onMouseOut="this.style.background=''">
	    <td>{$item.cntKgJ}</td>
	    <td>{$item.cntKgW}</td>
	    </tr>
		{/foreach}
	</table>
	
	<div id="footButton" style="width:300px;">
<ul>
			<li><input type="submit" name="Submit" value=" 下一步 " disabled='true'></li>
			<li><input type="button" id="Back" name="Back" value='返  回' onClick="javascript:window.history.go(-1);"></li>
		</ul>
	</div>
</fieldset></form>

<fieldset>
<legend>已排缸列表</legend>
	<table class="tableHaveBorder table100">
      <tr class="th">
        <td>缸号</td>
        <td>纱支规格</td>
        <td>颜色</td>
        <td>色号</td>
        <td>要货数量(kg)</td>
        <td>计划投料</td>
        <td>折率</td>
        <td>计划筒数</td>
        <td>计划定重</td>
        <td style=" width:140px">物理缸号</td>
        </tr>
      {foreach from=$arr_gang item=item}
	  <tr>
		<td>{$item.vatNum}</td>
		<td>{$item.wareName} {$item.guige}</td>
		<td>{$item.color}</td>
		<td>{$item.colorNum}</td>
		<td>{$item.cntKg}</td>
		<td>{$item.cntPlanTouliao}</td>
		<td>{$item.zhelv}</td>
		<td>{$item.planTongzi}</td>
		<td>{$item.unitKg}</td>
		<td>{$item.vatCode}</td>
		</tr>
      {/foreach}
    </table>
</fieldset>

</div>
<p style="color:#F00; font-size:12px">注：目前排缸习惯是由筒子数计算定重，如要改为由定重计算筒子数请联系管理员。</p>
</body></html>