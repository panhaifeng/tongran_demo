<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>修改排缸信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=">
<link href="Resource/Css/Edit200.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
{literal}
<script language="javascript">
var cntTouliao=0;
var cntTongzi = 0;
var b = new Array();
$(function(){	
	cntTouliao = parseFloat(document.getElementById('cntPlanTouliao[]').value);
	cntTongzi = parseInt(document.getElementById('planTongzi[]').value);
	$('#btnCaifen').click(function(){
		this.disabled=true;
		var cntGang = $('#cntGang').val();
		if(cntGang>3) {
			alert('缸数不能大于3');
			return false;
		}		
		
		var row = document.getElementById('tbl').rows[2];
		//alert(cntGang-1);
		//var evg = cntTouliao/parseInt(cntGang);
		for(var i=0;i<cntGang-1;i++) {
			var newRow = row.cloneNode(true);
			row.parentNode.insertBefore(newRow,row);
		}
		
		//设置每缸投料
		$('input[@id="cntPlanTouliao[]"]').each(function(){
			this.value=(cntTouliao/parseInt(cntGang)).toFixed(2);
		});
		$('input[@id="planTongzi[]"]').each(function(){
			this.value=(cntTongzi/parseInt(cntGang)).toFixed(0);
			setUnitKg(this);
			setOption(this);
		});
		
	});
	$('[name="cntPlanTouliao[]"]').change(function(){	
		var pos =-1;
		var o = this;
		$('[name="cntPlanTouliao[]"]').each(function(i){
			if(this==o) pos=i;
		});
		//alert(pos);
		if(pos==-1) return false;
		//var pos = $('.cntJ').index($(this));
		//alert(pos);
		$('[name="planTongzi[]"]')[pos].value=(parseFloat($(this)[pos].value||0)*parseFloat($('[name="zhelv[]"]')[pos].value||0)/$('[name="unitKg[]"]')[pos].value).toFixed(0);
		$('[name="planTongzi[]"]')[pos].onchange();
	});
});
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
	arrTongzi[pos].value=(parseFloat(arrTouliao[pos].value||0)*parseFloat(arrZhelv[pos].value||0)/parseFloat(o.value)).toFixed(0);
	arrTongzi[pos].onchange() ;
}

//设置定重span的innerHTML
function setUnitKg(o) {
	var arrTongzi = document.getElementsByName('planTongzi[]');
	var arrSpan = document.getElementsByName('unitKg[]');
	var arrTouliao = document.getElementsByName('cntPlanTouliao[]');
	for (var i=0;i<arrSpan.length;i++) {
		if (arrTongzi[i]==o||arrTouliao[i]==o) {
			arrSpan[i].value=(parseInt(arrTouliao[i].value)/parseInt(arrTongzi[i].value)).toFixed(2);
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

		arrOpt[i].value = json[0].id;

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

			cengOpt[pos].value = b[obj[pos].value];

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

<form name="form1" action="{url controller=$smarty.get.controller action=SaveAdd}" method=post>
      <fieldset>
        <legend class="style1">修改排缸信息</legend>
<table id="tbl"  class="tableHaveBorder" width="100%">
	<tr class="th"> 
		<td width="120" align="center">计划投料</td>
		<td width="120" align="center">折率</td>
		<td width="120" align="center">定重(kg)</td>
		<td width="120" align="center">计划筒子数</td>
		<td width="120" align="center">物理缸号</td>
		<td width="120" align="center">层数</td>
	  </tr>
		<tr> 
			<td align="center"><input type="text" name="cntPlanTouliao[]" id="cntPlanTouliao[]" size="8" value="" onmouseover="this.select()" /></td>
			<td align="center">
				<input name="zhelv[]" id="zhelv[]" style="width: 50px;" value="0.965" onchange="ChangeZhelv(this)">
			</td>
			
			<td align="center"><input name="unitKg[]" type="text" id="unitKg[]" value="0.92" size="6" onchange="setCntTongzi(this)" /></td>
			<td align="center">
				<input name="planTongzi[]" type="text" id="planTongzi[]" onfocus="document.getElementById('Submit').disabled=true" onblur="setOption(this)"  onChange="setOption(this)" value="" size="6"/>
			</td>
		  <td align="center">
		  	<select name="vatId[]" >
		    	{*取出装筒数大于或等于计划筒子数的最小两个染缸*}
		    </select>
		  </td>
		  <td>
		  	<select name="vat2shuirongId[]" >
		  		{*取出选中染缸的层数*}
		  	</select>
		  </td>
	  </tr>
         
	</table>

</fieldset>
<div id="footButton">
	<ul>
		<li><input name="order2wareId" type="hidden" id="order2wareId" value="{$smarty.get.order2wareId}"/></li>
		<li><input type="submit" name="Submit" id='Submit' value="完 成" disabled="disabled"></li>
	</ul>
</div>
</form>
</div>
</body>
</html>
