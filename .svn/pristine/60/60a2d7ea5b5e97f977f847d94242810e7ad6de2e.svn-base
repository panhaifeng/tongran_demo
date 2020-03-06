<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>应收款报表</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
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
			<td align="right" colspan="2">起始日期：
<input name="dateFrom" type="text" id="dateFrom" value="{$smarty.post.dateFrom|default:$smarty.now|date_format:'%Y-%m-01'}" size="10" onClick="calendar()">
                      起始日期：
                      <input name="dateTo" type="text" id="dateTo" value="{$smarty.post.dateTo|default:$smarty.now|date_format:'%Y-%m-%d'}" size="10" onClick="calendar()"/>
客户：

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
