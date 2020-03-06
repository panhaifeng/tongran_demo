{*此模板用来进行先输入筒子数，再计算定重的情况*}
<html>
<head>
<title>修改排缸信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=">
<link href="Resource/Css/Edit200.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript">
var vatId = {$arr_field_value.vatId};
var vat2shuirongId = {$arr_field_value.vat2shuirongId};
var _json ;//用于存放染缸选项返回的json
var a ='';
var b = new Array();;
{literal}
function getGang(e) {
	var url='Index.php?controller=Plan_Dye&action=GetJsonByVatNum';
	var params = {vatId:e.value};
	$.getJSON(url,params,function(json){
		document.getElementById('vatNum').value=json;
	});
}


//根据输入的定重设置筒子数
function setCntTongzi(o) {//setCntTongzi is not defined
	if (o.value=='' || parseFloat(o.value)==0) return false;
	var arrTongzi = document.getElementsByName('planTongzi[]');
	var arrTouliao = document.getElementsByName('cntPlanTouliao[]');
	var arrZhelv = document.getElementsByName('zhelv[]');
	var arrUnitKg = document.getElementsByName('unitKg[]');
	var pos=-1;
	for (var i=0;i<arrUnitKg.length;i++) {
		if (arrUnitKg[i]==o) {
			var pos = i;break;
		}
	}
	if(pos==-1) return false;
	if(!o.value) return false;
	try {
		arrTongzi[pos].value=Math.ceil(arrTouliao[pos].value * arrZhelv[pos].value / o.value);
	} catch(e) {
	}
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
	if (o.value=='' || o.value==0) return false;
	var arrOpt = document.getElementsByName('vatId[]');
	var arrTongzi = document.getElementsByName('planTongzi[]');
	//var arrZhelv = document.getElementsByName('zhelv[]');
	var arrUnitKg = document.getElementsByName('unitKg[]');
	var obj;
	if(o.id=='planTongzi[]') obj=arrTongzi;
	else obj=arrUnitKg;
	
	var pos = -1;
	for (var i=0;i<obj.length;i++) {
		if (obj[i]==o) {
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
		for (var j=0;j<json.length;j++){
			var opt=new Option(json[j].vatCode+"(可装:"+json[j].cntTongzi+")",json[j].id);   
			arrOpt[i].options.add(opt);
			// if (vatId=='') {
				b[json[j].id]=json[j].vat2shuirongId;
			// };
		}
		//设置提交按钮状态
		// checkSelect();
		if(vatId!=''){ //判断是否是刚修改进来时
			arrOpt[i].value = vatId;
			vatId = '';
		}else{ 
			arrOpt[i].value = json[0].id;
		}
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
			if(vat2shuirongId!=''){
				cengOpt[pos].value = vat2shuirongId;
				vat2shuirongId = '';
			}else{
				cengOpt[pos].value = b[obj[pos].value];
			}
		}
	});

	var hasCengOpt = len>0?true:false; 
	if(hasCengOpt){
		//设置提交按钮状态
		checkSelect(false);
	}else{
		var vatId = obj[pos].value;
		for (var j=0;j<_json.length;j++){
			if(vatId==_json[j].id){
				var vatCode = _json[j].vatCode;
			}
		}
		alert('缸号'+vatCode+'未设置层数，请在染缸档案中设置后再操作此环节！');
		checkSelect(true);
	}
	return; 
}
</script>
{/literal}
</head>


<body onload="setOption(document.getElementsByName('planTongzi[]')[0])">

<div id='container'>
	<div style="text-align:left">{include file="_ContentNav2.tpl"}	</div>

<form name="form1" action="{url controller=$smarty.get.controller action=SaveGang}" method=post>
      <fieldset>
        <legend class="style1">修改排缸信息</legend>
		

<table id='table_moreinfo' class="tableHaveBorder" width="100%">
<tr class="th"> 
	<td>逻辑缸号</td>
	<td>计划投料</td>
	<td>折率</td>
	<td>计划筒子数</td>
	<td>定重(kg)</td>
	<td>物理缸号</td>
	<td>层数</td>
	</tr>
		<tr> 
			<td>
			<input type="hidden" name="order2wareId" value="{$arr_field_value.order2wareId}"> 
			<input name="vatNum" type="text" id="vatNum" value="{$arr_field_value.vatNum}" size="15"></td>
			<td><input type="text" name="cntPlanTouliao[]" size="8" value="{$arr_field_value.cntPlanTouliao}" onmouseover="this.select()" onkeyup="setUnitKg(this)"/></td>
			<td class="tableHaveBorder table100"><select name="zhelv[]" id="zhelv[]">
			  <option value="1">100%</option>
			  <option value="0.99" {if $arr_field_value.zhelv==0.99}selected{/if}>99%</option>
			  <option value="0.98"{if $arr_field_value.zhelv==0.98}selected{/if}>98%</option>
			  <option value="0.97"{if $arr_field_value.zhelv==0.97}selected{/if}>97%</option>
			  <option value="0.96"{if $arr_field_value.zhelv==0.96}selected{/if}>96%</option>
			  <option value="0.95"{if $arr_field_value.zhelv==0.95}selected{/if}>95%</option>
			  <option value="0.94"{if $arr_field_value.zhelv==0.94}selected{/if}>94%</option>
			  <option value="0.93"{if $arr_field_value.zhelv==0.93}selected{/if}>93%</option>
			  <option value="0.92"{if $arr_field_value.zhelv==0.92}selected{/if}>92%</option>
			  <option value="0.91"{if $arr_field_value.zhelv==0.91}selected{/if}>91%</option>
			  <option value="0.90"{if $arr_field_value.zhelv==0.90}selected{/if}>90%</option>
			  <option value="0.89"{if $arr_field_value.zhelv==0.89}selected{/if}>89%</option>
			  <option value="0.88"{if $arr_field_value.zhelv==0.88}selected{/if}>88%</option>
			  <option value="0.88"{if $arr_field_value.zhelv==0.87}selected{/if}>87%</option>
			  <option value="0.88"{if $arr_field_value.zhelv==0.86}selected{/if}>86%</option>
			  <option value="0.88"{if $arr_field_value.zhelv==0.85}selected{/if}>85%</option>
			  </select></td>
			<td align="center"><input name="planTongzi[]" type="text" id="planTongzi[]" onfocus="document.getElementById('Submit').disabled=true" onblur="setOption(this)" onkeyup="setUnitKg(this)" value="{$arr_field_value.planTongzi}" size="6"/></td>
		  <td><input name="unitKg[]" type="text" id="unitKg[]" value="{$arr_field_value.unitKg}" size="5"  {*onclick="this.select()" onfocus="document.getElementById('Submit').disabled=true" onblur="setOption(this)" onkeyup="setCntTongzi(this)"*}/></td>
		  <td><select name="vatId[]"  style="width:120px">
		    
		    {*取出装筒数大于或等于计划筒子数的最小两个染缸*}
		    
		    </select></td>
		    <td><select name="vat2shuirongId[]" value="{$arr_field_value.vat2shuirongId}">{*取出选中染缸的层数*}</select></td>
	    </tr>
 
	</table>
</fieldset>
<div id="footButton">
	<ul>
		<li><input name="from" type="hidden" id="from" value="{$smarty.get.from}" /></li>
		<li><input type="hidden" name="{$pk_disabled|default:'id'}" value="{$arr_field_value.id}"/></li>
		<li><input type="submit" name="Submit" id='Submit' value="完 成" disabled="disabled"></li>
	</ul>
</div>
</form>
</div>
</body>
</html>