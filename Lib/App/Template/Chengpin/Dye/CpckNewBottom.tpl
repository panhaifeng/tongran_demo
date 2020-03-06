<html>
<head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
{literal}

$(function(){
	document.getElementById('form2').onsubmit = function(){
		var cntChuku=document.getElementsByName('cntChuku[]');
		var cntJian=document.getElementsByName('cntJian[]');
		var cntTongzi=document.getElementsByName('cntTongzi[]');
		var jingKg=document.getElementsByName('jingKg[]');	
		if(cntJian.length>0)
		{
			for(var i=0;i<cntJian.length;i++){
			   if(/*cntChuku[i].value=='' || */cntJian[i].value==''/* ||  cntTongzi[i].value==''||jingKg[i]==''*/){
				   //alert('请填写完整或删除多余!');
				   alert('请填写完整或删除多余，且件数不能为空!');
				   return false;
			   }
			}
		}
 }
});

function addNewRow(gangId){
	//alert(gangId);return false;
	var tbl = document.getElementById('tblEdit');
	var cntCol = tbl.rows[0].cells.length;
	var url = 'Index.php?controller=Chengpin_Dye_Cpck&action=getJsonByGangId';
	var params={gangId:gangId};	
	var mapCount = 7;//是显示json还是显示文字
	//var pos=0;
	//表格列与json的隐射表
	var mapArray = [
		'compName',
		'orderCode',
		'guige',
		'color',
		'vatNum',
		'cntPlanTouliao',
		'planTongzi',
		'<input name="cntChuku[]" type="text" id="cntChuku[]" size="5">',
		'<input name="maoKg[]" type="text" id="maoKg[]" size="5">',
		'<input name="gangId[]" type="hidden" id="gangId[]" value='+gangId+'><input name="jingKg[]" type="text" id="jingKg[]" size="5" onChange="changeJk(this)">',
		'<input name="jingKgZ[]" type="text" id="jingKgZ[]" size="5" readonly>',
		'<input name="cntTongzi[]" type="text" id="cntTongzi[]" size="5">',
		'<input name="cntJian[]" type="text" id="cntJian[]" size="5">&nbsp;&nbsp;&nbsp;<span style="color:red;">*</span>',
		"<select name='memo[]'><option value=''></option><option value='未完'>未完</option><option value='不结账'>不结账</option><option value='退回回修'>退回回修</option><option value='退回回倒'>退回回倒</option><option value='退回检纱'>退回检纱</option><option value='未完经纱'>未完经纱</option></select><input type='text' name='memo2[]' id='memo2[]' size='3'>",
		'<input name="memo1[]" type="text" id="memo1[]" size="5"><input name="paymentWay[]" type="hidden" id="paymentWay[]"><input name="zhelv[]" type="hidden" id="zhelv[]">',		
		'<input name="btnDel" type=button value="删除" onClick="removeRow(this)">'
	];
	$.getJSON(url, params, function(json){
		debugger;
		//dump(json['Cprk']);return false;
		var newRow = tbl.insertRow(-1);
		var  jingKg=document.getElementsByName('jingKg[]');
		var  cntTongzi=document.getElementsByName('cntTongzi[]');
		var  cntJian=document.getElementsByName('cntJian[]');
		var  cntChuku=document.getElementsByName('cntChuku[]');

		var  paymentWay=document.getElementsByName('paymentWay[]');
		var  zhelv=document.getElementsByName('zhelv[]');
		var  jingKgZ=document.getElementsByName('jingKgZ[]');
		var  maoKg=document.getElementsByName('maoKg[]');
		for (var i=0;i<cntCol;i++) {
			var newCell=newRow.insertCell(-1);
			if (i<mapCount) newCell.innerHTML = json[mapArray[i]];
			else newCell.innerHTML = mapArray[i];			
		}
		var pos=jingKg.length-1;
		cntChuku[pos].value=json.cntChuku;
		jingKg[pos].value=json.jingKg;
		cntTongzi[pos].value=json.cntTongzi;
		cntJian[pos].value=json.cntJian;
		zhelv[pos].value=json.zhelvOrder;
		paymentWay[pos].value=json.paymentWay;
		if (json.jingKg>0) {
			if (json.paymentWay==2) {
				jingKgZ[pos].value=(json.jingKg/(1-parseFloat(json.zhelvOrder))).toFixed(2);
			}else{
				// jingKgZ[pos].value=json.jingKg;//客户需求所有结算方式都 进行算法 by zcc
				jingKgZ[pos].value=(json.jingKg/(1-parseFloat(json.zhelvOrder))).toFixed(2);
			}
			
		}
		maoKg[pos].value=json.maoKg;//by zcc 2017年10月27日 15:20:31 新增毛重字段
		//pos++;
	});
}
function changeJk(obj){
	var btns = document.getElementsByName('jingKg[]');
	var paymentWay = document.getElementsByName('paymentWay[]');
	var zhelv = document.getElementsByName('zhelv[]');
	var jingKgZ = document.getElementsByName('jingKgZ[]');
	for (var i=0;i<btns.length;i++) {
		if (btns[i]==obj) {
			var index = i;
			break;
		}
	}
	if (paymentWay[index].value==2) {//当为结算类型为折率时 进行带入折率运算 jingzhong/（1-zhelv）
		jingKgZ[index].value = (obj.value/(1- parseFloat(zhelv[index].value))).toFixed(2);
	}else{
		// jingKgZ[index].value = obj.value;
		jingKgZ[index].value = (obj.value/(1- parseFloat(zhelv[index].value))).toFixed(2);
	}

	
}
function removeRow(btn) {
	//获得btn的位置
	var btns = document.getElementsByName('btnDel');
	for (var i=0;i<btns.length;i++) {
		if (btns[i]==btn) {
			var index = i;
			break;
		}
	}
	//删除btn所在的行
	document.getElementById('tblEdit').deleteRow(i+1);
}
{/literal}
</script>
<style type="text/css">
{literal}
.tableHaveBorder {border-collapse:collapse; border:1px solid #999999;}
.tableHaveBorder td {border-bottom:1px solid #999999; border-right:1px solid #999999;}
.table100{width:100%;}
.table100 td{height:25px;}
.th{background-color:#cccccc; text-align:center}
.th td{font-size:12px;}
{/literal}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="height:350"><iframe frameborder="0" id="GangList" name="GangList" src="Index.php?controller=Chengpin_Dye_Cpck&action=AddGuide3" scrolling="auto" style="height: 100%; width: 100%; z-index: 1;"></iframe></td>
  </tr>
  <tr>
  	<td style="text-align:center">
		<fieldset style="margin:10px; background-color:#F4FBFA">
			<legend>出库数据编辑</legend>
			<form name="form2" id="form2" action="{url controller=$smarty.get.controller action='saveGuide'}" method="post" >
			<table id="tblEdit" class="tableHaveBorder table100">
			  <tr class="th">
				<td align="center">客户</td>
				<td align="center">订单号</td>
				<td align="center">纱支规格</td>
				<td align="center">颜色</td>
				<td align="center">缸号</td>
				<td align="center">投料</td>
				<td align="center">筒数</td>
				<td align="center">本次出库(kg)</td>
				<td align="center">毛重(kg)</td>
				<td align="center">净重(kg)</td>
				<td align="center">计价重量(kg)</td>
				<td align="center">筒子数(个)</td>
				<td align="center">件数</td>
				<td align="center">备注/余件</td>
				<td align="center">胶筒</td>
				<td align="center">操作</td>
			  </tr>
			  {foreach from=$rows item=item}
				  <tr>
					<td align="center">{$item.clientName}</td>
					<td align="center">{$item.orderCode}</td>
					<td align="center">{$item.guige}</td>
					<td align="center">{$item.color}</td>
					<td align="center">{$item.vatNum}</td>
					<td align="center">{$item.cntPlanTouliao}</td>
					<td align="center">{$item.planTongzi}</td>
					<td align="center"><input name="cntChuku[]" type="text" id="cntChuku[]" size="5"></td>
					<td align="center"><input name="maoKg[]" type="text" id="maoKg[]" size="5">
					<td align="center"><input name="gangId[]" type="hidden" id="gangId[]" value="{$item.id}">
						<input name="jingKg[]" type="text" id="jingKg[]" size="5"  onMouseOver="this.select()" onChange="changeJk(this)"></td>
					<td align="center"><input name="jingKgZ[]" type="text" id="jingKgZ[]" size="5" readonly></td>	
					<td align="center"><input name="cntTongzi[]" type="text" id="cntTongzi[]" size="5"></td>
					<td align="center"><input name="cntJian[]" type="text" id="cntJian[]" size="5">
					   </td>
					<td align="center"><select name='memo[]'>
						  <option value='未完'>未完</option>
                          <option value='不结账'>不结账</option>
						  <option value='退回回修'>退回回修</option>
						  <option value='退回回倒'>退回回倒</option>
						  <option value='退回检纱'>退回检纱</option> 
                          <option value='未完经纱'>未完经纱</option> 
						</select>
						<input type="text" name="memo2[]" id="memo2[]" size="3"></td>
					<td><input name="memo1[]" type="text" id="memo1[]" size="5"></td>
				  </tr>
			  {/foreach}
	    </table>
    		出库日期：
			<input type=text name='dateCpck' id='dateCpck' onClick='calendar()' value='{$dateCpck}' style="width:80px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="Submit" type="submit" id="Submit" value="确定并打印">
			<input name="Submit" type="submit" id="Submit" value="保存并打印">
			</form>
		</fieldset>
	</td>
  </tr>
</table>
{include file="_Footer.tpl"}
</body>
</html>