<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />

<title>入账</title>
</head>
{literal}
<style type="text/css">
.table{text-align:center; font:13px Arial; width:98%; border-bottom:solid 2px black; border-right: solid 2px black }
.table td {border-top:solid 1px black; border-left:solid 1px black;}
.title{ font:bold;}
ul{ list-style:none; margin:0; float:left;}
li{ display:inline;}
li span{padding-left:20px;}
</style>
<script language="javascript">
function CheckForm(){
	//判断单价是否为0，有为0的则提示
	var danjia=document.getElementsByName("danjia[]");
	for(var i=0;i<danjia.length;i++){
		if(danjia[i].value==0){
			alert('单价不能为0！');
			return false;
		}
	}
}
</script>
{/literal}
<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SaveRuzhang'}" method="post" onSubmit="return CheckForm()">
<div style="margin:0 1%;" align="center">
      入库明细<br/>
     <div style="width:100%">
      <ul>
      <li>入库日期：</li>
      <li>{$arr_field_value.ruKuDate|default:'&nbsp;'}</li>
      <li><span>入库单号：</span></li>
      <li>{$arr_field_value.ruKuNum|default:'&amp;nbsp;'}</li>
      <li style=" width:50%;"></li>
      <li><span>供应商：</span></li>
      <li>{$arr_field_value.compName|default:'&amp;nbsp;'}</li>
      <li><span>入账日期：</span></li>
      <li><input type="text" name="inDate" id="inDate" value="{$arr_field_value.inDate|default:$smarty.now|date_format:'%Y-%m-%d'}" onclick="calendar()"></li>
      </ul>
  </div>

      
  <table border="0" cellspacing="0" cellpadding="0" class="table" >
    <tr class="title">
      <td>品名规格</td>
      <td>数量</td>
      <td>单价</td>
      <!-- <td>入账日期</td> -->
      </tr>
    {foreach from=$arr_field_value.Wares item=item}
    <tr>
      <td>{$item.guige|default:'&nbsp;'}</td>
      <td>{$item.cnt|default:'&nbsp;'}
        <input name="cnt[]" type="hidden" id="cnt[]" value="{$item.cnt}" /></td>
      <td>
        <input name="danjia[]" type="text" id="danjia[]" value="{$item.danjia}" size="10" />
        <input name="id[]" type="hidden" id="id[]" value="{$item.id}" /></td>
<!--         <td><input type="text" name="inDate[]" id="inDate[]" value="{$item.inDate|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"></td>  -->
      </tr>
    {/foreach}

  </table>
   <input name="button1" type="submit" value="确定入账" /></td>
   <input name="supplierId" type="hidden" id="supplierId" value="{$arr_field_value.supplierId}" />
   <input name="invoiceId" type="hidden" id="invoiceId" value="{$arr_field_value.invoiceId}" />
</div>
</form>
</body>
</html>
