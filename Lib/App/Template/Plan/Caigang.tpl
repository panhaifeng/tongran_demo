<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>修改排缸信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
{literal}
var cntTouliao=0;
var cntTongzi = 0;
var _json //用于存放染缸选项返回的json
var _vatId = 0; // 染缸选项返回后的最佳染缸选中项
var _vat2shuirongId = new Array();// 层数选项的最佳水容量选中项
$(function(){	
	cntTouliao = parseFloat(document.getElementById('cntJ[]').value||0)+parseFloat(document.getElementById('cntW[]').value||0);
	cntJ = parseFloat(document.getElementById('cntJ[]').value||0);
	cntW = parseFloat(document.getElementById('cntW[]').value||0);
	//alert(cntTouliao);
	cntTongzi = parseInt(document.getElementById('planTongzi[]').value);
	$('#btnCaifen').click(function(){
		this.disabled=true;
		var cntGang = $('#cntGang').val();
		if(cntGang>3) {
			alert('缸数不能大于3');
			return false;
		}		
		
		var row = document.getElementById('tbl').rows[3];
		//alert(cntGang-1);
		//var evg = cntTouliao/parseInt(cntGang);
		for(var i=0;i<cntGang-1;i++) {
			var newRow = row.cloneNode(true);
			row.parentNode.insertBefore(newRow,row);
		}
		
		//设置每缸投料
		$('input[@id="cntJ[]"]').each(function(){
			this.value=(cntJ/parseInt(cntGang)).toFixed(2);
		});
		$('input[@id="cntW[]"]').each(function(){
			this.value=(cntW/parseInt(cntGang)).toFixed(2);
		});
		$('input[@id="planTongzi[]"]').each(function(i){
			//alert(i);
			this.value=(cntTongzi/parseInt(cntGang)).toFixed(0);
			setUnitKg(this);
			// debugger;
			setOption(this);
		});
		
	});

});
function getGang(e) {
	var url='Index.php?controller=Plan_Dye&action=GetJsonByVatNum';
	var params = {vatId:e.value};
	$.getJSON(url,params,function(json){
		document.getElementById('vatNum').value=json;
	});
}

//设置定重span的innerHTML
function setUnitKg(o) {
	var arrTongzi = document.getElementsByName('planTongzi[]');
	var arrSpan = document.getElementsByName('unitKg[]');
	//var arrTouliao = document.getElementsByName('cntPlanTouliao[]');
	var cntJ = document.getElementsByName('cntJ[]');
	var cntW = document.getElementsByName('cntW[]');
	var zhelv = document.getElementsByName('zhelv[]');
	for (var i=0;i<arrSpan.length;i++) {
		if (arrTongzi[i]==o||cntJ[i]==o||cntW[i]==o) {
			arrSpan[i].value=((parseFloat(cntJ[i].value)+parseFloat(cntW[i].value))*parseFloat(zhelv[i].value)/parseInt(arrTongzi[i].value)).toFixed(2);
			return;
		}
	}
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
function getCnt(obj){
	var cntJ=document.getElementsByName('cntJ[]');
	var planTongzi=document.getElementsByName('planTongzi[]');
	var unitKg=document.getElementsByName('unitKg[]');
	var cntW=document.getElementsByName('cntW[]');
	var cntPlanTouliao=document.getElementById('cntPlanTouliao').value;
	var zhelv = document.getElementsByName('zhelv[]');
	var pos=-1;
	for(var i=0;cntJ[i];i++){
		if(cntJ[i]==obj||unitKg[i]==obj){
			pos=i;
		}
	}
	if(pos==-1)return false;
	planTongzi[pos].value=((parseFloat(cntJ[pos].value)+parseFloat(cntW[pos].value))*parseFloat(zhelv[pos].value)/parseFloat(unitKg[pos].value)).toFixed(0);
	var k=(parseFloat(cntPlanTouliao)-parseFloat(cntJ[pos].value))/(parseFloat(cntJ.length)-1);
	for(var i=0;cntJ[i];i++){
		if(pos!=i){
			cntJ[i].value=k;
			planTongzi[i].value=((parseFloat(cntJ[i].value)+parseFloat(cntW[i].value))*parseFloat(zhelv[i].value)/parseFloat(unitKg[i].value)).toFixed(0);
			setOption(planTongzi[i]);
		}
	}
	setOption(planTongzi[pos]);
}
function ChangeZhelv(obj) {
	var cntJ=document.getElementsByName('cntJ[]');
	var planTongzi=document.getElementsByName('planTongzi[]');
	var unitKg=document.getElementsByName('unitKg[]');
	var cntW=document.getElementsByName('cntW[]');
	var cntPlanTouliao=document.getElementById('cntPlanTouliao').value;
	var zhelv = document.getElementsByName('zhelv[]');
	var pos=-1;
	for(var i=0;cntJ[i];i++){
		if(zhelv[i]==obj){
			pos=i;
		}
	}
	if(pos==-1)return false;
	planTongzi[pos].value=((parseFloat(cntJ[pos].value)+parseFloat(cntW[pos].value))*parseFloat(zhelv[pos].value)/parseFloat(unitKg[pos].value)).toFixed(0);
	setOption(planTongzi[pos]);	
}
function getCntW(obj){
	var cntJ=document.getElementsByName('cntJ[]');
	var planTongzi=document.getElementsByName('planTongzi[]');
	var unitKg=document.getElementsByName('unitKg[]');
	var cntW=document.getElementsByName('cntW[]');
	var cntPlanTouliao1=document.getElementById('cntPlanTouliao1').value;
	var zhelv = document.getElementsByName('zhelv[]');
	var pos=-1;
	for(var i=0;cntJ[i];i++){
		if(cntW[i]==obj){
			pos=i;
		}
	}
	if(pos==-1)return false;
	planTongzi[pos].value=((parseFloat(cntJ[pos].value)+parseFloat(cntW[pos].value))*parseFloat(zhelv[pos].value)/parseFloat(unitKg[pos].value)).toFixed(0);
	var k=(parseFloat(cntPlanTouliao1)-parseFloat(cntW[pos].value))/(parseFloat(cntW.length)-1);
	for(var i=0;cntJ[i];i++){
		if(pos!=i){
			cntW[i].value=k;
			planTongzi[i].value=((parseFloat(cntJ[i].value)+parseFloat(cntW[i].value))*parseFloat(zhelv[i].value)/parseFloat(unitKg[i].value)).toFixed(0);
			setOption(planTongzi[i]);
		}
	}
	setOption(planTongzi[pos]);
}
{/literal}
</script>
</head>
<body onload="setOption(document.getElementsByName('planTongzi[]')[0])">
<form name="form1" action="{url controller=$smarty.get.controller action=SaveCai}" method=post>
	<br />
<div align="center">
	<table width="100%" id="tbl">
<tr class="tdItem">
  <td colspan="8">本缸原投料：{$arr_field_value.cntPlanTouliao}
    <input name="cntPlanTouliao" type="hidden" id="cntPlanTouliao" value="{$arr_field_value.cntJ}" />
    <input name="cntPlanTouliao1" type="hidden" id="cntPlanTouliao1" value="{$arr_field_value.cntW}" />
    KG,筒子数: {$arr_field_value.planTongzi}，您希望拆分成几缸：
<input name="cntGang" type="text" id="cntGang" onclick="this.select()" value="1" size="8"/>
    <input type="button" name="btnCaifen" id="btnCaifen" value="拆分" /></td>
  </tr>
<tr class="tdItem"> 
			<td width="120" rowspan="2" align="center">逻辑缸号</td>
		<td colspan="2" align="center">计划投料</td>
		<td width="100" rowspan="2" align="center">折率</td>	
		<td width="100" rowspan="2" align="center">计划筒子数</td>
		<td width="120" rowspan="2" align="center">物理缸号</td>
		<td width="120" rowspan="2" align="center">水溶</td>
		<td width="120" rowspan="2" align="center">定重(kg)</td>
	  </tr>
<tr class="tdItem">
  <td width="120" align="center">经纱</td>
  <td width="120" align="center">纬纱</td>
</tr>
		<tr> 
			<td align="center"><input name="vatNum" type="text" id="vatNum" value="{$arr_field_value.vatNum}" size="12"></td>
			
			<td align="center"><input type="text" name="cntJ[]" id="cntJ[]" size="8" value="{$arr_field_value.cntJ}" onmouseover="this.select()" onchange="getCnt(this);" /></td>
			<td align="center"><input type="text" name="cntW[]" id="cntW[]" size="8" value="{$arr_field_value.cntW}" onmouseover="this.select()" onchange="getCntW(this)" /></td>
			<td align="center"><input type="text" name="zhelv[]" id="zhelv[]" size="8" value="{$arr_field_value.zhelv}" onchange="ChangeZhelv(this)"/></td>
			<td align="center"><input name="planTongzi[]" type="text" id="planTongzi[]" onfocus="document.getElementById('Submit').disabled=true" onblur="setOption(this)" onkeyup="setUnitKg(this)" value="{$arr_field_value.planTongzi}" size="6"/></td>
		  <td align="center"><select name="vatId[]" >
		    {*取出装筒数大于或等于计划筒子数的最小两个染缸*}
		    </select>
		  </td>
<!-- 		  <td align="center">
		  	<select name="shuirong[]" id="shuirong[]">
	      	</select>
	      </td> -->
	      <td><select name="vat2shuirongId[]" >{*取出选中染缸的层数*}</select></td>
			<td align="center"><input name="unitKg[]" type="text" id="unitKg[]" value="{$arr_field_value.unitKg}" size="6" onchange="getCnt(this)" /></td>
	  </tr>
         
	</table>
<div style="clear:both;">
<input name="id" type="hidden" id="id" value="{$smarty.get.id}"/>
		<input type="submit" name="Submit" id='Submit' value="确定提交" disabled="disabled">
	</div>

</div>
</form>
</body>
</html>