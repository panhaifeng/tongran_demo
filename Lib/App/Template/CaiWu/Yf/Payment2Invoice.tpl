<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>付款抵冲凭证</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript">
{literal}
function getSelectedMoney(o){
	var chks = document.getElementsByName('invoiceId[]');
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
	var invoiceNum = $('#invoiceNum')[0].value;
	var tbl = document.getElementById('tbl');
	//执行ajax
	$.getJSON('Index.php?controller=CaiWu_Yf_Invoice&action=GetInvoiceJson',
		{invoiceNum:invoiceNum},function(json){	
			//将json形成行进行插入
			for (var j=0;j<json.length;j++) {
				var newRow = tbl.insertRow(-1);	
				var cells = new Array();
				for (var i=0;i<5;i++) {
					cells[i] = newRow.insertCell(-1);
				}
				cells[0].innerHTML = '<input name="invoiceId[]" type="checkbox" id="invoiceId[]" value="' + json[j].id + '" onclick="setTotalMoney(this)">';
				cells[1].innerHTML = json[j].invoiceNum;
				cells[2].innerHTML = json[j].dateInput;
				cells[3].innerHTML = json[j].Supplier.compName;			
				cells[4].innerHTML = '<span id="spanMoney" name="spanMoney">'+json[j].money+'</span>';
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

付款信息
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td>付款编号：{$aPayment.payNum}</td>
      <td>类型：{$aPayment.type}</td>
      <td>日期：{$aPayment.datePay}</td>
    </tr>
    <tr>
      <td colspan="2">供应商：{$aPayment.supplierName}</td>
      <td>付款金额：{$aPayment.moneyPay}</td>
    </tr>
    <tr>
      <td colspan="3">备注：{$aPayment.memo}</td>
    </tr>
  </table>
  
抵冲信息 (付款金额为
:{$aPayment.moneyPay}&nbsp;&nbsp;, 凭证金额为: <span style="color:#FF0000" id='totalMoney'>{$total_money}</span>
&nbsp;&nbsp;)
  <form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveLink'}" method="post">

<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
  <tr>
    <td valign="top" bgcolor="#CCCCCC">凭证号：
      <input type="text" name="invoiceNum" id="invoiceNum">
      <input type="button" name="search" id="search" value="搜索" onClick="add()"></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#CCCCCC"><table width="100%" border="1" cellspacing="0" cellpadding="0" id='tbl'>
      
      <tr bgcolor="#999999">
        <td valign="top" bgcolor="#CCCCCC">选择</td>
        <td valign="top" bgcolor="#CCCCCC">凭证编号</td>
        <td valign="top" bgcolor="#CCCCCC">凭证日期</td>
        <td valign="top" bgcolor="#CCCCCC">供应商</td>
        <td valign="top" bgcolor="#CCCCCC">凭证金额 </td>
      </tr>
      {foreach from=$arr_invoices item=value}
      <tr bgcolor="#999999">
        <td valign="top" bgcolor="#CCCCCC"><a href="{url controller=$smarty.get.controller action='cancelLink' paymentId=$smarty.get.id invoiceId=$value.id}" onClick="return confirm('您确认要取消嘛?')">删除</a></td>
        <td valign="top" bgcolor="#CCCCCC">{$value.invoiceNum}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.dateInput}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.Supplier.compName}</td>
        <td valign="top" bgcolor="#CCCCCC">{$value.money}</td>
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
