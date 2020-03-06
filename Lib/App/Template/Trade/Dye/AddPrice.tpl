<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>{$title}</title>
{literal}
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
var currentLine=-1;
var currentCol=-1;
$(function(){
	aa();
	/*$('input[@name="danJia[]"]').each(function(){
		this.onchange=aa;
	});
	$('input[@name="money[]"]').each(function(){
		this.onchange=aa;
	});*/

});
function keygo(cols){
  var cols=cols//列数,手动设置
  var elobj=myform.elements.length;
  key=window.event.keyCode;
  if (key==38){//↑
      CurTabIndex=event.srcElement.tabIndex-cols
      for (n=0;n<myform.elements.length;n++){
      if (myform.elements[n].tabIndex==CurTabIndex){
        myform.elements[n].select();
        return true;
            }
        }
    }
  if (key==40){//↓
      CurTabIndex=event.srcElement.tabIndex+cols
    for (n=0;n<myform.elements.length;n++){
      if (myform.elements[n].tabIndex==CurTabIndex){
        myform.elements[n].select();
        return true;
      }
    }
    }
  if (key==37){//←
      CurTabIndex=event.srcElement.tabIndex-1
      for (n=0;n<myform.elements.length;n++){
      if (myform.elements[n].tabIndex==CurTabIndex){
        myform.elements[n].select();
        return true;
            }
        }
    }
  if (key==39){//→
      CurTabIndex=event.srcElement.tabIndex+1
    for (n=0;n<myform.elements.length;n++){
      if (myform.elements[n].tabIndex==CurTabIndex){
        //myform.elements[n].focus();
        myform.elements[n].select();
        return true;
      }
    }
    }
}
function aa() {
	var d =document.getElementsByName('danJia[]');
	var c =document.getElementsByName('cntKg[]');
	var m =document.getElementsByName('money[]');
	var tm = 0;
	for (var i=0;i<d.length;i++) {
		if(d[i].value>0) tm += parseInt(c[i].value)*parseFloat(d[i].value);
		else tm += parseFloat(m[i].value|0);
	}
	document.getElementById('tm').innerHTML = tm.toFixed(2);
}
function getMoney(obj){
	var money1=document.getElementsByName('money1[]');
	var danjia=document.getElementsByName('danjia[]');
	var cntKg=document.getElementsByName('cntKg[]');
	var money=document.getElementsByName('money[]');
	var pos=-1;
	for(var i=0;danjia[i];i++){
		if(danjia[i]==obj||money[i]==obj){
			pos=i;
		}
	}
	if(pos==-1)return false;
	//alert(danjia[pos].value);alert(money[pos].value);return false;
	if(danjia[pos].value!=0&&money[pos].value!=0){
		alert('单价和总价只能填写一个,请确认后重新填写！');
		if(money1[pos].value!=0){
			money[pos].value=0;
		}else{
			danjia[pos].value=0
		}
	}
	var d=danjia[pos].value==''?0:parseFloat(danjia[pos].value);
	var c=cntKg[pos].value==''?0:parseFloat(cntKg[pos].value);
	money1[pos].value=d*c;
	aa();
}
</script>
{/literal}
</head>
<body style="text-align:center">
<div>
<form name="myform" id="myform" action="{url controller=$smarty.get.controller action='SavePrice'}" method="post" onKeyUp="return keygo(5)">
<input type="hidden" name="orderId" value="{$aRow.id}">
<table>
	<tr><td>定单号:{$aRow.orderCode}</td><td>定单日期:{$aRow.dateOrder}</td><td>客户:{$aRow.Client.compName}</td></tr>
</table>
<br>
<table id="tab">
	<tr>
		<td align="center">货品编号</td>                  
		<td align="center">纱支</td>
		<td align="center">颜色</td>
		<td align="center">色号</td>
		<td align="center">重量</td>
		<td align="center">单价</td>
		<td align="center">金额</td>
		<td align="center">总价(不计单价)</td>
	</tr>
	{foreach from=$aRow.Ware item=item}
	<tr>
		<td align="center">{$item.wareId}</td>
		<td align="center">{$item.shazhi}</td>
		<td align="center">{$item.color}</td>
		<td align="center" name='tdCnt' id='tdCnt'>{$item.colorNum}</td>
		<td align="center" name='tdCnt' id='tdCnt'>{$item.cntKg}
	    <input name="cntKg[]" type="hidden" id="cntKg[]" value="{$item.cntKg}"><input type="hidden" name="id[]" value="{$item.id}"></td>
	  	<td align="center">
		  	{if $item.isShenhe!=1}
		  	<input name="danJia[]" type="text" value="{$item.danjia}" size="10" tabindex="{$tabindex++}" onClick="this.select()" onMouseOver="this.select()" onChange="getMoney(this)"  >
		  	{else}
		  	<input name="danJia[]" type="text" value="{$item.danjia}" size="10" id="danJia[]" readonly>
			{/if}
		</td>
		<td align="center">
			{if $item.isShenhe!=1}
		  	<input name="money1[]" type="text" id="money1[]" tabindex="{$tabindex++}" onClick="this.select()" onMouseOver="this.select()" value="{$item.money1}" size="10">
		  	{else}
		  	<input name="money1[]" type="text" value="{$item.money1}" size="10" id="money1[]" readonly>
			{/if}
		</td>
		<td align="center">
		  	{if $item.isShenhe!=1}
			<input name="money[]" type="text" value="{$item.money}" size="10" tabindex="{$tabindex++}" onClick="this.select()" onMouseOver="this.select()" onChange="getMoney(this)">
		  	{else}
		  	<input name="money[]" type="text" value="{$item.money}" size="10" id="money[]" readonly>
			{/if}
		</td>
	</td>
	  
	</tr>
	
	{/foreach}
    <tr>
	  <td colspan="8">金额合计： <span id='tm' style=" color:#F00">0</span>元</td>
	  </tr>
	<!--
	<tr>
	  <td align="center"><strong>合计</strong></td>
	  <td align="center"></td>
	  <td align="center"></td>
	  <td align="center">{$aRow.Total.tCntKg}</td>
	  <td align="center"></td>
	  <td align="center">{$aRow.Total.tMoney}</td>
	</tr>-->
</table>

<br />
<input name="submit" type="submit" value='保存并返回' style="width:80px; height:30px;">
</form>
</div>
{literal}
<script type="text/javascript">
  //myform.textfield1.focus();
  for (n=0;n<myform.elements.length;n++){
    myform.elements[n].tabIndex=n;
  }
</script>

{/literal}
</body>
</html>
