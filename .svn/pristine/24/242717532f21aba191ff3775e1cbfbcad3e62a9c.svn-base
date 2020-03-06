{*此模板用来进行先输入定重，再计算筒子数的情况*}
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title|default:"排缸第二步"}</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit100.css" type="text/css" rel="stylesheet">

<script language="javascript">
//每个颜色的计划数存入缓存中
var arrOrd2ware = {$arrOrd2ware|@json_encode};
var _json //用于存放染缸选项返回的json
var _vatId = 0; // 染缸选项返回后的最佳染缸选中项
var _vat2shuirongId = new Array();// 层数选项的最佳水容量选中项
{literal}
$(function(){
	$(".cntW").each(function(){
		// alert($(this)[0]);
		if($(this).val()=="")
		$(this).val(0);
              setCntTongzi($(this)[0]);//现计算出筒子数
              setOption($(this)[0]);//然后根据筒子 进行匹配所对应的缸
	});
	$('.cntJ').change(function(){	
		var pos =-1;
		var o = this;
		$('.cntJ').each(function(i){
			if(this==o) pos=i;
		});		
		if(pos==-1) return false;
		
		$('.cntKg')[pos].value=parseFloat($('.cntW')[pos].value||0)+parseFloat($('.cntJ')[pos].value||0);
		$('.cntKg').eq(pos).change();
		$('.cntW')[pos].value=parseFloat($('.cntKg')[pos].value||0)-parseFloat($('.cntJ')[pos].value||0);

		changeRemain(this);		
	});
	$('.cntW').change(function(){	
		var pos =-1;
		var o = this;
		$('.cntW').each(function(i){
			if(this==o) pos=i;
		});
		//alert(pos);
		if(pos==-1) return false;
		//var pos = $('.cntJ').index($(this));
		//alert(pos);
		$('.cntKg')[pos].value=parseFloat($('.cntW')[pos].value||0)+parseFloat($('.cntJ')[pos].value||0);
		$('.cntKg').eq(pos).change();
		changeRemain(this);	
	});
	$(".cntKg").change(function(){
		var tr = $(this).parents('tr')
		$('[name="sunJz[]"]',tr).val(parseFloat($('[name="zhelv[]"]',tr).val()||0)*parseFloat($(this).val()||0));
	});
	function changeRemain(obj) {
		//var objs = $()
		var pos = $("[name='"+obj.name+"']").index(obj);
		var order2wareId = $('[name="order2wareId[]"]',$(obj).parents('tr')).val();
		var cntTotal = arrOrd2ware[order2wareId].cntKg;
		var cntUsed = 0;//已使用
		var cntR = 0;
		var obj4change = [];

		//取得余量总和
		var ids = $('[name="order2wareId[]"]');
		for(var i=0;ids[i];i++) {
			if(ids[i].value!=order2wareId) continue;
			//取得本行的投料数
			_cntKg = $('[name="cntKg[]"]',$(ids[i]).parents('tr'));
			if(i<=pos) {
				cntUsed += parseFloat(_cntKg.val()||0);
			} else {
				obj4change.push(_cntKg)
				cntR ++;
			}
		}
		if(cntR==0) return;
		var cntPer = (cntTotal - cntUsed)/cntR;

		for(var i=0;obj4change[i];i++) {
			obj4change[i].val(cntPer);
			obj4change[i].change();
		}
	}
});
//复制某行
$(function(){	
	document.onkeydown = function(e){		
		document.getElementById('form1').onsubmit = function(){document.getElementById('submit').disabled=true;};

		//可以用上下键移动的控件序列，用来标志移动的顺序
		var cellNames = ['pihao[]','cntJ[]','cntW[]','unitKg[]'];
		var ev = document.all ? window.event : e;
		//debugger;
		//假如不是回车和方向键，则返回
		if(ev.keyCode!=13&&ev.keyCode!=37&&ev.keyCode!=38&&ev.keyCode!=39&&ev.keyCode!=40) return true;				
		var target = document.all ? ev.srcElement : ev.target;
		//找到和target的name相同的所有元素
		var ts = document.getElementsByName(target.name);
		//找到位置
		for (var i=0;i<ts.length;i++) {
			if (target==ts[i]) {
				var pos =i;
				break;
			}
		}		
		
		//如果回车,cab
		if(ev.keyCode==13 && target.type!='button' && 

target.type!='submit' && target.type!='reset' && target.type!='textarea' && target.type!='')  {			
			if (document.all) ev.keyCode=9;
			else return false;
		}
		if(ev.keyCode==39||ev.keyCode==37) {

//如果是左37或右39,平移
			if (ev.keyCode==37){//左移
				//如果是最左返回
				if (target.name==cellNames[0]) return 

false;
				//否则往左移动
				for(var i=0;i<cellNames.length;i++){
					if(cellNames[i]==target.name) 

{									

	
						

//document.getElementsByName(cellNames[i-1])[pos].focus();
						

document.getElementsByName(cellNames[i-1])[pos].select();
						return false;
					}
				}
			} else if (ev.keyCode==39){//右移
				//如果是最右返回
				if (target.name==cellNames

[cellNames.length]) return false;
				//否则往右移动
				for(var i=0;i<cellNames.length;i++){
					if(cellNames[i]==target.name) 

{
						

document.getElementsByName(cellNames[i+1])[pos].select();
						return false;
					}
				}
			}
		} else if(ev.keyCode==38||ev.keyCode==40) {

//如果是上38下40,竖直移动
			if(ev.keyCode==40&&pos<ts.length-1) ts

[pos+1].focus();
			if(ev.keyCode==38&&pos>0) ts[pos-1].select();
		}
	}
});
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


//根据输入的定重设置筒子数
function setCntTongzi(o) {//setCntTongzi is not defined
	// if (o.value=='' || parseFloat(o.value)==0) return false;
	if (o.value=='' ) return false;
	var arrTongzi = document.getElementsByName('planTongzi[]');
	//debugger;
	var cntJ = document.getElementsByName('cntJ[]');
	var cntW = document.getElementsByName('cntW[]');
	var arrZhelv = document.getElementsByName('zhelv[]');
	var arrUnitKg = document.getElementsByName('unitKg[]');
	var pos=-1;
	for (var i=0;i<arrUnitKg.length;i++) {
		if (arrUnitKg[i]==o||cntJ[i]==o||cntW[i]==o) {
			var pos = i;break;
		}
	}
	//alert(pos);
	if(pos==-1) return false;
	if(!o.value) return false;
	// if (arrZhelv2[pos].value!='') {
	// 	arrTongzi[pos].value=((parseFloat(cntJ[pos].value||0)+parseFloat(cntW[pos].value||0))*parseFloat(arrZhelv2[pos].value||0)/parseFloat(arrUnitKg[pos].value)).toFixed(0);
	// }else{
		arrTongzi[pos].value=((parseFloat(cntJ[pos].value||0)+parseFloat(cntW[pos].value||0))*parseFloat(arrZhelv[pos].value||0)/parseFloat(arrUnitKg[pos].value)).toFixed(0);
	// }
	

	/*try {
		arrTongzi[pos].value=Math.round(arrTouliao[pos].value * arrZhelv[pos].value / o.value);
	} catch(e) {
	}*/
}

//根据输入的筒子数设置定重
function setUnitKg(o) {
	//alert(o.value);
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
	// if (arrZhelv2[pos].value!='') {
	// 	arrUnitKg[pos].value=(arrTouliao[pos].value * arrZhelv2[pos].value / o.value).toFixed(2);
	// }else{
		arrUnitKg[pos].value=(arrTouliao[pos].value * arrZhelv[pos].value / o.value).toFixed(2);
	// }
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
function ChangeZhelv(o){
	var tr = $(o).parents('tr');
	$('[name="unitKg[]"]',tr).keyup();
	$('[name="unitKg[]"]',tr).change();
	//修改折率 改变 净损重 公式：投料数*折率
	$('[name="sunJz[]"]',tr).val(parseFloat($('.cntKg',tr).val()||0)*parseFloat(o.value||0));
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

<form name="form1"  id='form1' action="{url controller=$smarty.get.controller action='savePlan'}" method=post>
<input type="hidden" name="{$pk_name}" value="{$arr_field_value.$pk_name}" />
<input type="hidden" name="gangTotal" value="{$gang_total}" />
<fieldset>
<legend>排缸第二步</legend>
	<table class="tableHaveBorder table100" id="tblVat">
	  <tr class="th"> 
		<td rowspan="2">序号</td>
		<td rowspan="2">批号</td>
		<td rowspan="2">纱支规格</td>
		<td rowspan="2">颜色</td>
		<td rowspan="2">色号</td>
		<td rowspan="2">数量(kg)</td>
		<td colspan="2">计划投料</td>
		<td rowspan="2">折率</td>
		<td rowspan="2">净损重</td>
		<td rowspan="2">计划定重</td>
		<td rowspan="2">计划筒数</td>
		<td rowspan="2">物理缸号</td>	
		<td rowspan="2">层数</td>										
		<td rowspan="2">操作</td>
	  </tr>
	  <tr class="th">
	    <td>经</td>
	    <td>纬</td>
	    </tr>
	  {foreach from=$arr_field_value_ware item=item} 
	  <tr onMouseOver="this.style.background='#ccc'" onMouseOut="this.style.background=''">
	    <td>{$item.id}</td>
	    <td><input type="text" name="pihao[]" size="5" value=""></td>
	    <td>{$item.Ware.wareName} {$item.Ware.guige}</td>
	    <td>{$item.color}</td>
	    <td>{$item.colorNum}</td>
	    <td>{*{$item.cntPlanTouliao}*}
	      <input name="cntKg[]" type="text" class="cntKg" id="cntKg[]" style="border:0px;" value="{$item.cntPlanTouliao}" size="5" readonly="readonly"/></td>
	    <td ><input name="cntJ[]" type="text" id="cntJ[]" size="5" class='cntJ' value="{$item.cntPlanTouliao}" onChange="setOption(this)" onKeyUp="setCntTongzi(this)"/></td>
	    <td><input name="cntW[]" type="text"  class='cntW' id="cntW[]" size="5" onChange="setOption(this)" onKeyUp="setCntTongzi(this)"/></td>
	    <td>
<!-- 	    	<select name="zhelv[]" id="zhelv[]">                       
				<option value="1">100%</option>
				<option value="0.99">99%</option>
				<option value="0.98">98%</option>
				<option value="0.97">97%</option>
				<option value="0.963" selected="selected">96.3%</option>
				<option value="0.96">96%</option>
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
	      	</select> -->
	      	<input name="zhelv[]" id="zhelv[]" style="width: 55px;" onchange="ChangeZhelv(this)" value="{$item.zhelv|default:0.963}">
	    </td>
	    <td><input name="sunJz[]" type="text" class="sunJz" id="sunJz[]" style="border:0px;" value="{$item.sunJz}" size="5" readonly="readonly"></td>
	    <td><input name="unitKg[]" type="text" id="unitKg[]" value="{$item.unitKg|default:0.92}" size="5"  onclick="this.select()" onFocus="document.getElementById('Submit').disabled=true" onChange="setOption(this)" onKeyUp="setCntTongzi(this)"/></td>
	    <td><input name="planTongzi[]" type="text" id="planTongzi[]" size="5"  readonly="readonly" {*onclick="this.select()" onFocus="document.getElementById('Submit').disabled=true"  onblur="setOption(this)" onKeyUp="setUnitKg(this)"*}/>
	      <input type="hidden" name="order2wareId[]" size="12" value="{$item.id}"/></td>
	    <td><select name="vatId[]" style="width:120px" onchange="setOptionCeng(this)">{*取出装筒数大于或等于计划筒子数的最小两个染缸*}</select></td>
	    <td><select name="vat2shuirongId[]" >{*取出选中染缸的层数*}</select></td>
	    <td><input type="button" name="btnCopy" id="btnCopy" value="复制" onClick="copyTr(this)"/>
	      <input type="button" name="btnDel" id="btnDel" value="删除" onClick="removeTr(this)"/></td>
	    </tr>
		{/foreach}
	</table>
	
	<div id="footButton" style="width:300px;">
<ul>
			<li><input type="submit" name="Submit" id='Submit' value=" 下一步 " disabled='true'></li>
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
        <td>净损重</td>
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
		<td>{$item.sunJz}</td>
		<td>{$item.planTongzi}</td>
		<td>{$item.unitKg}</td>
		<td>{$item.vatCode}</td>
		</tr>
      {/foreach}
    </table>
</fieldset>

</div>
<p style="color:#F00; font-size:12px">注：目前排缸习惯是由定重计算筒子数，如要改为由筒子数计算定重请联系管理员。</p>
</body></html>