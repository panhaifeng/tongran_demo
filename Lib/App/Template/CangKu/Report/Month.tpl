<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>物料月报表</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',0,true,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = '品名:'+(arr[0]?arr[0]:'&nbsp;');
		$('#spanGuige')[0].innerHTML = '规格:'+(arr[1]?arr[1]:'&nbsp;');
	});
}
{/literal}
</script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td valign="bottom" width="100%" height="40" align="right">
			<table width="100%" height="24" border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #B2D0F7" >
				<tr style="border-collapse:collapse">
					<td background="Resource/Image/System/right_01_01.gif" width="25" height="24" style="border:0px solid #B2D0F7">&nbsp;</td>
					<td background="Resource/Image/System/bg_title.gif" width="85" height="24" style="color:#ffffff; font-weight:bold; padding-top:3px">{$title}</td>
					<td align="right" valign="bottom"><a href="Index.php?controller={$smarty.get.controller}&Action=Add&parentId={$smarty.get.parentId}" accesskey="A">新增</a></div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="5px;"></td></tr>
  <tr>
    <td background="Resource/Image/System/bg_search.gif" width="100%" height="25">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
	  	<form method="post" action="" name="FormSearch">
			<td colspan="2">起始日期：
<input name="dateFrom" type="text" id="dateFrom" value="{$smarty.post.dateFrom|default:$smarty.now|date_format:'%Y-%m-01'}" size="10" onClick="calendar()">
                      截至日期：
                      <input name="dateTo" type="text" id="dateTo" value="{$smarty.post.dateTo|default:$smarty.now|date_format:'%Y-%m-%d'}" size="10" onClick="calendar()"/>
                      货品：
                      <input name="wareId" type="text" id="wareId" onClick="popMenu(this)" value="{$aRow.wareId}" size="10" readonly>
<input type="submit" name="Submit" value="搜索" /></td>
		</form>
	  </tr>	
    </table></td>
  </tr>  
	<tr>
		<td>{include file="_TableForBrowse.tpl"}</td>
	</tr>
	<tr height=""><td>{$page_info}</td></tr>
</table>
</body>
</html>
