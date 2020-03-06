<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',0,false,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
	});
}
function popDanjia(e) {
	var wareId = document.getElementById('wareId').value;
	var con = {wareId:wareId};
	var ruku = popRuku(con);
	if (ruku) {
		e.value=ruku.danjia;
	}
}
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveWares'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>     
<legend>{$title}</legend>
<div align="center">
<table>

	<!----基本信息start----------------------------->
	<tr>
		<td>
		</td>
	</tr>
	<!----基本信息end----------------------------->
	

	<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><table width="100%" border="1">
                <tr>
                  <td align="center">货品编号</td>
                  <td align="center">品名</td>
                  <td align="center">规格</td>
                  <td align="center">单位</td>
				  <td align="center">客户</td>
                  <td align="center">数量</td>
                  <td align="center">单价<br>
                    <span style="font-size:9px">默认为最末单价</span></td>
                  <td align="center">金额</td>
                  <td align="center">操作</td>
                </tr>
                <tr>
                  <td align="center"><input name="wareId" type="text" id="wareId" size="10" onClick="popMenu(this)" readonly check='^[1-9]\d*$' warning='请选择货品!'></td>
                  <td align="center"><span id='spanWareName'>&nbsp;</span></td>
                  <td align="center"><span id='spanGuige'>&nbsp;</span></td>
                  <td align="center"><span id='spanDanwei'>&nbsp;</span></td>
				  <td align="center">{webcontrol type='ClientSelect' id='supplierId' selected=$arr_field_value.Supplier}</td>
                  <td align="center"><input name="cnt" type="text" id="cnt" size="8" warning='请输入数量！' check=''></td>
                  <td align="center"><input name="danjia" type="text" id="danjia" size="8" readonly><input type="button" name="button" id="button" value=".." onClick="popDanjia(document.getElementById('danjia'))"></td>
                  <td align="center">&nbsp;</td>
                  <td align="center"><input type="submit" name="Submit" id="Submit" value="提交">
                  <input type="hidden" name="chukuId" id="chukuId" value="{$smarty.get.chukuId}"></td>
                </tr>
                {foreach from=$rows item=item}
                <tr>
                  <td align="center">{$item.wareId}</td>
                  <td align="center">{$item.Wares.wareName}</td>
                  <td align="center">{$item.Wares.guige}</td>
                  <td align="center">{$item.Wares.unit}</td>
				  <td align="center">{$item.Supplier.compName}</td>
                  <td align="center">{$item.cnt}</td>
                  <td align="center">{$item.danjia}</td>
                  <td align="center">{$item.cnt*$item.danjia}</td>
                  <td align="center"><a href="?controller={$smarty.get.controller}&action=RemoveWare&id={$item.id}">删除</a></td>
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
