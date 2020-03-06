<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发货明细</title>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
function getOrdpro(e) {
	var url='Index.php?controller=Chengpin_Denim_Report&action=getJsonByManuCode';
	var arr = document.getElementsByName(e.name);
	for (var i=0;i<arr.length;i++) {
		if (arr[i]==e) {
			var pos = i;
			break;
		}
	}
	var params = {manuCode:e.value};
	$.getJSON(url,params,function(json){
		document.getElementsByName('spanProCode')[pos].innerHTML=json.proCode;
		//document.getElementsByName('spanProName')[pos].innerHTML=json.proName;
		//document.getElementsByName('spanGuige')[pos].innerHTML=json.guige;
		document.getElementsByName('spanCntKg')[pos].innerHTML=json.Kucun.cntKg;
		document.getElementsByName('spanCntKgC')[pos].innerHTML=json.Kucun.cntKgC;
		document.getElementsByName('spanCntKgF')[pos].innerHTML=json.Kucun.cntKgF;
		document.getElementsByName('order2ProductId1[]')[pos].value=json.order2ProductId1;
		//document.getElementsByName('cprkId')[pos].innerHTML=json.id;
	});
}
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveOrdpro'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>     
<legend>发货明细</legend>
<table width="100%">

	<!----基本信息start----------------------------->
	<tr>
		<td>
		</td>
	</tr>
	<!----基本信息end----------------------------->
	

	<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
                <tr>
                  <td colspan="5" align="center" bgcolor="#CCCCCC">要货信息</td>
                  <td colspan="8" align="center" bgcolor="#7477A5">待发库存信息</td>
                </tr>
                <tr>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">生产编号</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">产品代码</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">品名</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">规格</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">要货数</td>
                  <td rowspan="2" align="center" bgcolor="#7477A5">生产编号</td>
                  <td rowspan="2" align="center" bgcolor="#7477A5">产品编号</td>
                  <td colspan="3" align="center" bgcolor="#7477A5">当前库存</td>
                  <td colspan="3" align="center" bgcolor="#7477A5">本次发货数</td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#7477A5">一等</td>
                  <td align="center" bgcolor="#7477A5">次等</td>
                  <td align="center" bgcolor="#7477A5">废布</td>
                  <td align="center" bgcolor="#7477A5">一等</td>
                  <td align="center" bgcolor="#7477A5">次等</td>
                  <td align="center" bgcolor="#7477A5">废布</td>
                </tr>
                {foreach from=$pros item=item}
                <tr>
                  <td align="center" bgcolor="efefef"><input name="order2ProductId[]" type="hidden" id="order2ProductId[]" value="{$item.order2ProductId}">
                    <input name="id[]" type="hidden" id="id[]" value="{$item.cpckId}">
                    <input name="order2ProductId1[]" type="hidden" id="order2ProductId1[]" value="{$item.order2ProductId1}">
                  {$item.manuCode}</td>
                  <td align="center" bgcolor="efefef">{$item.Product.proCode}</td>
                  <td align="center" bgcolor="efefef">{$item.Product.proName}</td>
                  <td align="center" bgcolor="efefef">{$item.Product.guige}</td>
                  <td align="center" bgcolor="efefef">{$item.cntKgYh}</td>
                  <td align="center" bgcolor="efefef"><input name="manuCode[]" type="text" id="manuCode[]" onBlur="getOrdpro(this)" value="{$item.manuCode1}" size="10"></td>
                  <td align="center" bgcolor="efefef"><span id='spanProCode' name='spanProCode'>{$item.Product1.proCode}</span></td>
                  <td align="center" bgcolor="efefef"><span id='spanCntKg' name='spanCntKg'>{$item.Kucun.cntKg}</span></td>
                  <td align="center" bgcolor="efefef"><span id='spanCntKgC' name='spanCntKgC'>{$item.Kucun.cntKgC}</span></td>
                  <td align="center" bgcolor="efefef"><span id='spanCntKgF' name='spanCntKgF'>{$item.Kucun.cntKgF}</span></td>
                  <td align="center" bgcolor="efefef"><input name="cntKg[]" type="text" id="cntKg[]" value="{$item.cntKg}" size="5"></td>
                  <td align="center" bgcolor="efefef"><input name="cntKgC[]" type="text" id="cntKgC[]" value="{$item.cntKgC}" size="5"></td>
                  <td align="center" bgcolor="efefef"><input name="cntKgF[]" type="text" id="cntKgF[]" value="{$item.cntKgF}" size="5"></td>
                </tr>
                {/foreach}
                
              </table>
	            <input type="hidden" name="orderId" id="orderId" value="{$smarty.get.orderId}">
	            <input type="hidden" name="cpckId" id="cpckId" value="{$smarty.get.cpckId}">
      <input name="Back" type="submit" id="Back" value='确定返回'></td>
	</tr>
</table>
</fieldset>
</form>
</body>
</html>
