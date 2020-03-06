<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<style type="text/css">
.tdTitle1 {text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;}

</style>
<script language="javascript">
$(function(){	
	document.getElementById('form1').onsubmit=function(){
		//alert('asdf');return false;
		//alert($('#clientId').val());return false;
		if($('#cnt').val()==0) {
			alert('请输入数量!');return false;
		}
		return true;
	};
});

function popMenu(e) {
	tMenu(e,'?controller=JiChu_WareWujin&action=tmismenu',0,false,function(e) {
		var arr = explode("||",e.text);		
		document.getElementById('spanWareName').innerHTML = arr[0]?arr[0]:'&nbsp;';
		//$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
		//$('#spanDanwei')[0].innerHTML = arr[2]?arr[2]:'kg';
	});
}
</script>
{/literal}
<base target="_self">
</head>
<body>
<div id='container'>
	<div style="text-align:left">{include file="_ContentNav2.tpl"}</div>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" AutoComplete='off'>
  <fieldset style="border:0px;">     
    <legend class="style1"></legend>
    <table cellpadding="4" class="tableHaveBorder"  id='table_moreinfo' style="width:400px">
  <tr>
    <td align="right" class="tdTitle1">出库日期</td>
    <td align="left"><input name="dateChuku" type="text" id="dateChuku" onClick="calendar()" value="{$aRow.dateChuku|default:$smarty.now|date_format:'%Y-%m-%d'}"></td>
  </tr>
  <tr>
    <td align="right" class="tdTitle1">品名</td>
    <td align="left"><input name="wareId" type="text" id="wareId" value="{$aRow.wareId}" onClick="popMenu(this)" readonly/>
      <span id='spanWareName'>{$aRow.Ware.wareName}</span></td>
  </tr>
  <tr>
    <td align="right" class="tdTitle1">数量</td>
    <td align="left"><input name="cnt" type="text" id="cnt" value="{$aRow.cnt}" /></td>
  </tr>
<tr>
  <td align="right" class="tdTitle1">备注</td>
  <td align="left"><textarea name="memo" cols="30" rows="10" id="memo">{$aRow.memo}</textarea></td>
</tr>
</table>
</fieldset>

<!--底部两操作按钮-->
<div id="footButton">
	<ul>
		<li>
		  <input type="submit" id="Submit" name="Submit" value='保  存'>
		</li>
		<li><input type="button" id="Back" name="Back" value='取  消' onClick="javascript:window.location.href='{url controller=$smarty.get.controller action='right'}';">
          <input name="id" type="hidden" id="id" value="{$aRow.id}" />
          <input name="type" type="hidden" id="type" value="1" />
		</li>
	</ul>
</div>

</form>
</div>
</body>
</html>
