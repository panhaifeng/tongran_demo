<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
<script language="javascript">
{literal}
//ύťdisable״̬
function aa(o) {
	var arrTongzi = document.getElementsByName('cntTongzi');
	var arrJingKg = document.getElementsByName('jingKg');
	var arrCntJian = document.getElementsByName('cntJian');
	var arrBtn = document.getElementsByName('btnCk');
	for (var i=0;i<arrTongzi.length;i++) {
		if (arrTongzi[i]==o||arrJingKg[i]==o||arrCntJian[i]==o) {
			//жǷ񶼲Ϊ
			
			if (arrTongzi[i].value!=''&&arrJingKg[i].value!=''&&arrCntJian[i].value!='') {
				//alert(i);break;
				arrBtn[i].disabled=false;
			}
			return;
		}
	}
}
//ύť
function subm(gangId,o) {
	var arrTongzi = document.getElementsByName('cntTongzi');
	var arrJingKg = document.getElementsByName('jingKg');
	var arrCntJian = document.getElementsByName('cntJian');
	var arrBtn = document.getElementsByName('btnCk');	
	for (var i=0;i<arrBtn.length;i++) {
		if (arrBtn[i]==o) {
			//жǷ񶼲Ϊ
			var url='Index.php?controller=Chengpin_Dye_Cprk&action=actionAjaxCprk';
			var params = {
				gangId:gangId,
				jingKg:arrJingKg[i],
				cntJian:arrCntJian[i],
				cntTongzi:arrTongzi[i]
			};
			$.getJSON(url,params,function(json){
				alert('asdf');
			});
			break;
		}
	}
	
}
{/literal}
</script>
</head>
<body leftmargin="10" topmargin="0">
<table width="100%" border="0" cellpadding="2" cellspacing="6"><tr><td>
<table id="guide" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>
<div id=search style="display:">
<form method="post" action="" name="FormSearch">
	<ul>
		<li id="keyData"><span>ڣ</span>
	<input name="dateFrom" type="text" id="dateFrom" value="{$arr_condition.dateFrom}" size="10" onclick="calendar()">
	<span></span>
	<input name="dateTo" type="text" id="dateTo" value="{$arr_condition.dateTo}" size="10" onclick="calendar()"/>
			<span style="width:10px"></span>		</li>
		
		<li id="keyComp">
			{if ($supplier_name != 'Ӧ')}					  
			<span>ͻ</span>{webcontrol type='ClientSelect' id='clientId' selected=$arr_condition.clientId}
			{else}
			<span>Ӧ̣</span>{webcontrol type='SupplierSelect' selected=$arr_condition.supplierId}
			{/if}
			<span style="width:10px"></span>		</li>
		<li id="keyData"><span></span>
	<input name="orderCode" type="text" id="orderCode" value="{$arr_condition.orderCode}" size="10">
	<span>׺ţ</span>
	<input name="vatNum" type="text" id="vatNum" value="{$arr_condition.vatNum}" size="10"/>
			<span style="width:10px"></span>		</li>		
		<li><input type="submit" name="Submit" value="" /></li>
	</ul>
</form>
</div>

<div id=add style="display:{$add_display}">
	<ul>
		<li><a href="Index.php?controller={$smarty.get.controller}&Action=Add&parentId={$smarty.get.parentId}" accesskey="A"></a>
		</li>
	</ul>
</div></td></tr></table>
{include file="_TableForBrowse.tpl"}
{$page_info}
</td></tr></table>
<br />
{include file="_Footer.tpl"}
</body>
</html>