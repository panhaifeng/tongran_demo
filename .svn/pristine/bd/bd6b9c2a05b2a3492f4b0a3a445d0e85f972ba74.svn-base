<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>抵冲出库单</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript">
{literal}
function getSelectedMoney(o){
	var chks = document.getElementsByName('cpck2OrdproId[]');
	var moneys = document.getElementsByName('spanMoney');
	//debugger;
	for (var i=0;i<chks.length;i++) {
		if (o==chks[i]) {
			var money = parseInt(moneys[i].innerHTML);
			if (!o.checked) return 0-money;
			return money;
		}
	}
	return 0;
}
function setTotalMoney(o) {
	var inner = $('#totalMoney')[0];	
	var cMoney = parseFloat(inner.innerHTML);
	inner.innerHTML = cMoney+getSelectedMoney(o);	
}
function add(){
	var url='Index.php?controller=Chengpin_Denim_Cpck&action=GetWaresJson';
	var cpckCode = $('#cpckCode')[0].value;
	var tbl = document.getElementById('tbl');
	//执行ajax
	$.getJSON(url,{cpckCode:cpckCode},function(json){
			debugger;
			//将json形成行进行插入
			for (var j=0;j<json.length;j++) {
				var newRow = tbl.insertRow(-1);	
				var cells = new Array();
				for (var i=0;i<8;i++) {
					cells[i] = newRow.insertCell(-1);
				}
				cells[0].innerHTML = '<input name="cpck2OrdproId[]" type="checkbox" id="cpck2OrdproId[]" value="' + json[j].id + '" onclick="setTotalMoney(this)">';
				cells[1].innerHTML = json[j].Cpck.cpckCode;
				cells[2].innerHTML = json[j].Product.proCode;
				cells[3].innerHTML = json[j].Product.proName;
				cells[4].innerHTML = json[j].Product.guige;
				cells[5].innerHTML = json[j].Ordpro.danjia;
				cells[6].innerHTML = json[j].cntKg;
				cells[7].innerHTML = '<span id="spanMoney" name="spanMoney">'+json[j].Ordpro.danjia*json[j].cntKg+'</span>';
				//alert('asdf');
			}
		}
		
	);
	//将ajax对象添加倒表格中
}
{/literal}
</script>
</head>

<body>

凭证信息
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>凭证编号：{$aInvoice.invoiceNum}</td>
      <td>类型：{$aInvoice.type}</td>
      <td>日期：{$aInvoice.dateInput}</td>
    </tr>
    <tr>
      <td colspan="2">客户：{$aInvoice.Client.compName}</td>
      <td>凭证金额：{$aInvoice.money}</td>
    </tr>
    <tr>
      <td colspan="3">备注：{$aInvoice.memo}</td>
    </tr>
  </table>
  
抵冲信息 (凭证金额为
:{$aInvoice.money}&nbsp;&nbsp;, 出库金额为: <span style="color:#FF0000" id='totalMoney'>{$total_money}</span>
&nbsp;&nbsp;)
  <form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChuku'}" method="post">

<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#999999">
  <tr>
    <td valign="top" bgcolor="#CCCCCC">出库单号：
      <input type="text" name="cpckCode" id="cpckCode">
      <input type="button" name="search" id="search" value="搜索" onClick="add()"></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#CCCCCC"><table width="100%" border="1" cellspacing="0" cellpadding="0" id='tbl'>
      
      <tr bgcolor="#999999">
        <td valign="top" bgcolor="#CCCCCC">选择</td>
        <td valign="top" bgcolor="#CCCCCC">出库单号</td>
        <td valign="top" bgcolor="#CCCCCC">产品编号</td>
        <td valign="top" bgcolor="#CCCCCC">品名</td>
        <td valign="top" bgcolor="#CCCCCC">规格 </td>
        <td valign="top" bgcolor="#CCCCCC">单价 </td>
        <td valign="top" bgcolor="#CCCCCC">发货数量</td>
        <td valign="top" bgcolor="#CCCCCC">金额 </td>
      </tr>
      {foreach from=$arr_wares item=value}
      <tr bgcolor="#999999">
        <td valign="top" bgcolor="#CCCCCC"><a href="{url controller=$smarty.get.controller action='cancelChuku' invoiceId=$smarty.get.id cpck2OrdproId=$value.id}" onClick="return confirm('您确认要取消嘛?')">删除</a></td>
        <td valign="top" bgcolor="#CCCCCC">{$value.Cpck.cpckCode}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.Product.proCode}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.Product.proName}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.Product.guige}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.Ordpro.danjia}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.cntKg}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.Ordpro.danjia*$value.cntKg}</td>
      </tr>
       {/foreach}
    </table></td>
  </tr>
    
  <tr>
    <td align="center" bgcolor="#CCCCCC"><input type="submit" name="Submit" id="Submit" value="确定">
      <input type="hidden" name="id" id="id" value="{$smarty.get.id}"></td>
    </tr>
      
</table>
</form> 
</body>
</html>
