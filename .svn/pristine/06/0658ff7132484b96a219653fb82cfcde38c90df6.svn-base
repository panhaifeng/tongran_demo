<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript">
/*
	实时增加table行数
*/
var newRow;
var table;

$(function(){
	table = document.getElementById('table_moreinfo');
	var tr = table.rows[table.rows.length-1];
	newRow = tr.cloneNode(true);
});

function addRow() {	
//alert('111111');
	for (var i=0;i<5;i++) {
		table.childNodes[0].appendChild(newRow.cloneNode(true));
	}	
}

function delRow(obj){
	var arrButton = document.getElementsByName('btnDel');	
	var rev = document.getElementsByName('ifRemove[]');
	for(var i=0; i<arrButton.length; i++){
		if (arrButton[i] == obj){
			//table.deleteRow(i+1); 
			table.rows[i+1].style.display='none';
			rev[i].value=1;
			break;
		}
	}
}

function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',5,false,function(json) {
		var arr = explode("||",json.text);
		//取得位置
		var pos=0;
		var id = "wareId[]";
		var arr1 = document.getElementsByName(id);
		for (var i=0;i<arr1.length;i++) {
			if (arr1[i]==e) {
				pos =i;
				break;
			}
		}
		//debugger;
		//alert(pos); 
		//alert(document.getElementsByName('spanWareName[]')[pos].value); 
		document.getElementsByName('spanWareName[]')[pos].value = arr[0]?arr[0]:'&nbsp;';
		document.getElementsByName('spanGuige[]')[pos].value = arr[1]?arr[1]:'&nbsp;';
		
			
	});
}

</script>
<style type="text/css">
.text{ border-width:0;}
</style>
{/literal}
</head>

<body >

<div id='container'>
<div style="text-align:left;">{include file="_ContentNav.tpl"}</div>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<input type="hidden" name="rukuId" id="rukuId" value="{$arr_field_value.id}">
<fieldset>
<legend>染化料基础资料</legend>
<table width="100%">
<tr>
<td height="25">退库单号：
  <input name="rukuNum" type="text" id="rukuNum" value="{$arr_field_value.rukuNum}" size="15" warning="请输入单号!" check="^\w+$" ></td>	
<td>退库日期：
  <input name="rukuDate" type="text" id="rukuDate"  value="{$arr_field_value.rukuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
<td>供应商：{webcontrol type='SupplierSelect' selected=$arr_field_value.supplierId}</td>
<td>备注：<input name="memo" type="text" id="memo" value="{$arr_field_value.memo}" size="40"></td>
</tr>
</table>
</fieldset>

<fieldset>
<legend>染化料详细资料</legend>
<table class="tableHaveBorder table100" width="100%" id="table_moreinfo">
	<tr class="th">
	  <td align="center">货品编号</td>
	  <td align="center">品名</td>
	  <td align="center">规格</td>
	  <td align="center">单位</td>
	  <td align="center">数量</td>
	  <td align="center">单价</td>
	  <td align="center">操作</td>
	</tr>

	{foreach from=$arr_field_value.Wares item=item}
	<tr>
	  <td align="center"><input name="id[]" type="hidden" id="id[]" value="{$item.id}"><input name="wareId[]" type="text" id="wareId[]" onClick="popMenu(this)" value="{$item.wareId}" size="10" ></td>
	  <td align="center"><input name="spanWareName[]" type="text" class="text" id='spanWareName[]' value="{$item.wareName}" size="10" readonly></td>
	  <td align="center"><input name="spanGuige[]" type="text" class="text" id='spanGuige[]' value="{$item.guige}" size="10" readonly></td>
	  <td align="center"><input name="spanDanwei[]" type="text" class="text" id='spanDanwei[]' value="{$item.unit}" size="10" readonly></td>
	  <td align="center"><input name="cnt[]" type="text" id="cnt[]" value="{$item.cnt}" size="8"></td>
	  <td align="center"><input name="danjia[]" type="text" id="danjia[]" value="{$item.danjia}" size="8"></td>
	  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)"></td>
	</tr>
	{/foreach}
    <tr>
	  <td align="center"><input name="wareId[]" type="text" id="wareId[]" size="10" onClick="popMenu(this)" readonly></td>
	  <td align="center"><input id="spanWareName[]" type="text" name="spanWareName[]" readonly class="text" size="10"></td>
	  <td align="center"><input id="spanGuige[]" type="text" name="spanGuige[]" readonly class="text" size="10"></td>
	  <td align="center"><input id="spanDanwei[]" type="text" name="spanDanwei[]" readonly class="text" size="10"></td>
	  <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="8"></td>
	  <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="8"></td>
	  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)"></td>
	</tr>
	
  </table>
  <div style="text-align:right;">
  	<input type="button" name="button" id="button" value="+5行" onClick="addRow()">
  </div>
</fieldset>

<div id="footButton" style="width:300px;">
	<ul>
		<li><input type="submit" id="submit1" value="保 存" style="width:100px;"></li>
		<li><input name="Back" type="button" id="Back" value='返 回' onClick="javascript:history.go(-1)"></li>
	</ul>
</div>
</form>
</div>
</body>
</html>