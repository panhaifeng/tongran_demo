<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>入库明细</title>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
function getOrdpro(e) {
	var url='Index.php?controller=Trade_Denim_Order2Product&action=getJsonByManuCode';
	var params = {manuCode:e.value};
	$.getJSON(url,params,function(json){
		document.getElementById('span1').innerHTML=json.Product.proCode;
		document.getElementById('span2').innerHTML=json.Product.proName;
		document.getElementById('span3').innerHTML=json.Product.guige;
		document.getElementById('span4').innerHTML=json.Product.menfu;
		document.getElementById('span5').innerHTML=json.Product.kezhong;
		document.getElementById('span6').innerHTML=json.cntKg;
		document.getElementById('order2ProductId').value=json.id;
	});
}
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveOrdpro'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>     
<legend>入库明细</legend>
<div align="center">
<table>

	<!----基本信息start----------------------------->
	<tr>
		<td>
		</td>
	</tr>
	<!----基本信息end----------------------------->
	

	<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                <tr>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">生产编号</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">产品代码</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">品名</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">规格</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">门幅cm</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">克重<br>
                  g/m2</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">要货数</td>
                  <td colspan="3" align="center" bgcolor="#CCCCCC">入库数(kg)</td>
                  <td rowspan="2" align="center" bgcolor="#CCCCCC">操作</td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#CCCCCC">一等</td>
                  <td align="center" bgcolor="#CCCCCC">次等</td>
                  <td align="center" bgcolor="#CCCCCC">废布</td>
                </tr>
                <tr>
                  <td align="center" bgcolor="efefef"><input type="hidden" name="order2ProductId" id="order2ProductId">
                  <input name="manuCode" type="text" id="manuCode" size="10" onBlur="getOrdpro(this)"></td>
                  <td align="center" bgcolor="efefef"><span id='span1'>&nbsp;</span></td>
                  <td align="center" bgcolor="efefef"><span id='span2'>&nbsp;</span></td>
                  <td align="center" bgcolor="efefef"><span id='span3'>&nbsp;</span></td>
                  <td align="center" bgcolor="efefef"><span id='span4'>&nbsp;</span></td>
                  <td align="center" bgcolor="efefef"><span id='span5'>&nbsp;</span></td>
                  <td align="center" bgcolor="efefef"><span id='span6'>&nbsp;</span></td>
                  <td align="center" bgcolor="efefef"><input name="cntKg" type="text" id="cntKg" size="8"></td>
                  <td align="center" bgcolor="efefef"><input name="cntKgC" type="text" id="cntKgC" size="8"></td>
                  <td align="center" bgcolor="efefef"><input name="cntKgF" type="text" id="cntKgF" size="8"></td>
                  <td align="center" bgcolor="efefef"><input type="submit" name="Submit" id="Submit" value="提交">
                  <input type="hidden" name="cprkId" id="cprkId" value="{$smarty.get.cprkId}"></td>
                </tr>
                {foreach from=$rows item=item}
                <tr>
                  <td align="center" bgcolor="efefef">{$item.Ordpro.manuCode}</td>
                  <td align="center" bgcolor="efefef">{$item.Product.proCode}</td>
                  <td align="center" bgcolor="efefef">{$item.Product.proName}</td>
                  <td align="center" bgcolor="efefef">{$item.Product.guige}</td>
                  <td align="center" bgcolor="efefef">{$item.Product.menfu}</td>
                  <td align="center" bgcolor="efefef">{$item.Product.kezhong}</td>
                  <td align="center" bgcolor="efefef">{$item.Ordpro.cntKg}</td>
                  <td align="center" bgcolor="efefef">{$item.cntKg}</td>
                  <td align="center" bgcolor="efefef">{$item.cntKgC}</td>
                  <td align="center" bgcolor="efefef">{$item.cntKgF}</td>
                  <td align="center" bgcolor="efefef"><a href="?controller={$smarty.get.controller}&action=RemoveOrdpro&id={$item.id}">删除</a></td>
                </tr>
                {/foreach}
              </table>
		<input name="Back" type="button" id="Back" value='确定返回' onClick="javascript:window.location='?controller={$smarty.get.controller}&action=right'"></td>
	</tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
