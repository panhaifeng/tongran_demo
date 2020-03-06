<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/TmisSuggest.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
<script language="javascript">
{literal}
function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',0,false,function(e) {
		var arr = explode("||",e.text);
		
		$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
		$('#spanDanwei')[0].innerHTML = arr[2]?arr[2]:'kg';
	});
}
{/literal}
</script>
</head>

<body>
<div id="container">
<div id="nav">{include file="_ContentNav2.tpl"}</div>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveWares'}" method="post" onSubmit="return CheckForm(this)">   
<fieldset>
<legend>{$title}</legend>
<table class="tableHaveBorder table100" width="100%">
	<tr class="th">
	  <td align="center">货品编号</td>
	  <td align="center">品名</td>
	  <td align="center">规格</td>
	  <td align="center">单位</td>
	  <td align="center">产地</td>
	  <td align="center">数量</td>
	  <td align="center">件数</td>
	  <td align="center">操作</td>
	</tr>
	<tr>
	  <td align="center"><input name="wareId" type="text" id="wareId" size="10" onClick="popMenu(this)" readonly></td>
	  <td align="center"><span id='spanWareName'>&nbsp;</span></td>
	  <td align="center"><span id='spanGuige'>&nbsp;</span></td>
	  <td align="center"><span id='spanDanwei'>&nbsp;</span></td>
	  <td align="center"><input name="chandi" type="text" id="chandi" size="8"></td>
	  <td align="center"><input name="cnt" type="text" id="cnt" size="8"></td>
	  <td align="center"><input name="cntJian" type="text" id="cntJian" size="8"></td>
	  <td align="center"><input type="submit" name="Submit" id="Submit" value="提交">
	  <input type="hidden" name="rukuId" id="rukuId" value="{$smarty.get.rukuId}"></td>
	</tr>
	{foreach from=$rows item=item}
	<tr>
	  <td align="center">{$item.wareId}</td>
	  <td align="center">{$item.Wares.wareName}</td>
	  <td align="center">{$item.Wares.guige}</td>
	  <td align="center">{$item.Wares.unit}</td>
	  <td align="center">{$item.chandi}</td>
	  <td align="center">{$item.cnt}</td>
	  <td align="center">{$item.cntJian}</td>
	  <td align="center"><a href="?controller={$smarty.get.controller}&action=RemoveWare&id={$item.id}">删除</a></td>
	</tr>
	{/foreach}
  </table>
</fieldset>

<div id="footButton" style="width:300px;">
	<ul>
		<li><input name="Back" type="button" id="Back" value='确定并打印' onClick="javascript:window.location.href='{url controller=$smarty.get.controller action='viewMore' id=$smarty.get.rukuId}'"></li>
	</ul>
</div>

</form>
</div>
</body>
</html>
