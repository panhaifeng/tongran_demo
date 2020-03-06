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
$(function(){	
	cntTouliao = parseFloat(document.getElementById('cntPlanTouliao[]').value);
	cntTongzi = parseInt(document.getElementById('planTongzi[]').value);
	setOption(document.getElementsByName('planTongzi[]')[0]);
	setUnitKg(document.getElementsByName('planTongzi[]')[0]);
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
	var arrOpt = document.getElementsByName('vatId[]');
	var arrTongzi = document.getElementsByName('planTongzi[]');
	var url='?controller=Plan_Dye&action=GetVatOption';
	var params={cntTongzi:o.value};
	for (var i=0;i<arrTongzi.length;i++) {
		if (arrTongzi[i]==o) {
			while (arrOpt[i].options.length>0) {arrOpt[i].remove(0);}; 
			$.getJSON(url, params, function(json){
				//设置o的option
				for (var j=0;j<json.length;j++){
					var opt=new Option(json[j].vatCode+"(可装:"+json[j].cntTongzi+")",json[j].id);   
					arrOpt[i].options.add(opt);
				}
				//设置提交按钮状态
				checkSelect();	
			});					
			return;
		}
	}
 	
}
{/literal}
</script>
</head>
<body>
<form name="form1" action="{url controller=$smarty.get.controller action=SaveMerge}" method=post>
	<br />
<div align="center">
	<p><table width="760" id="tbl">
<tr class="tdItem">
  <td colspan="5" align="left" bgcolor="#CCCCCC">要合并的缸</td>
  </tr>
<tr class="tdItem">
  <td width="120" align="center">逻辑缸号</td> 
		<td width="120" align="center">计划投料</td>
		<td width="120" align="center">计划筒子数</td>
		<td width="120" align="center">定重(kg)</td>
		<td width="120" align="center">物理缸号</td>
	  </tr>
      {foreach from=$gangs item=item}
		<tr>
		  <td align="center"><input name="gangId[]" type="hidden" id="gangId[]" value="{$item.id}" />
	      {$item.vatNum}</td> 
			<td align="center">{$item.cntPlanTouliao}</td>
			<td align="center">{$item.planTongzi}</td>
			<td align="center">{$item.unitKg}</td>
		  <td align="center">{$item.vatId}
		  </td>
	  </tr>
       {/foreach}
	</table></p>
	<table width="760" id="tbl">
<tr class="tdItem">
  <td colspan="5" align="left" bgcolor="#CCCCCC">要产生的新缸</td>
  </tr>
<tr class="tdItem"> 
		<td width="120">计划投料</td>
		<td width="120" align="center">折率</td>
		<td width="120" align="center">计划筒子数</td>
		<td width="120" align="center">定重(kg)</td>
		<td width="120" align="center">物理缸号</td>
	  </tr>
		<tr> 
			<td><input type="text" name="cntPlanTouliao[]" id="cntPlanTouliao[]" size="8" value="{$item.cntPlanTouliao}" onmouseover="this.select()" onkeyup="setUnitKg(this)"/></td>
			<td align="center"><select name="zhelv[]" id="zhelv[]">
			  <option value="1">100%</option>
			  <option value="0.99">99%</option>
			  <option value="0.98">98%</option>
			  <option value="0.97" selected="selected">97%</option>
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
		    </select></td>
			<td align="center"><input name="planTongzi[]" type="text" id="planTongzi[]" onfocus="document.getElementById('Submit').disabled=true" onblur="setOption(this)" onkeyup="setUnitKg(this)" value="{$item.planTongzi}" size="6"/></td>
			<td align="center"><input name="unitKg[]" type="text" id="unitKg[]" value="{$item.unitKg}" size="6"/></td>
		  <td align="center"><select name="vatId[]" >
		    {*取出装筒数大于或等于计划筒子数的最小两个染缸*}
		    </select>
		  </td>
	  </tr>
         
	</table>
<div style="clear:both;">
	  <input name="order2wareId" type="hidden" id="order2wareId" value="{$gangs[0].order2wareId}"/>
		<input type="submit" name="Submit" id='Submit' value="确定提交" disabled="disabled">
	</div>

</div>
</form>
</body>
</html>