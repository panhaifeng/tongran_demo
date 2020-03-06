{*被包含模板,成品入库出库，车间产量录入等需要选择计划后进行录入的地方用到*}
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
</head>

<body leftmargin="10" topmargin="10">
<div id="append_parent"></div>
<table width="100%" border="0" cellpadding="2" cellspacing="6"><tr><td>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="guide" style="display:none"><tr><td><a href="#" onClick="parent.menu.location='admincp.php?action=menu'; parent.main.location='admincp.php?action=home';return false;">系统设置首页</a>&nbsp;&raquo;&nbsp;后台首页</td></tr></table>
<br />

<table width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #1598CB">
      <tr class="altbg1" style="padding-left:20px;">
        <form method="post" action="" name="FormSearch">
			<td colspan="2">起始日期：
<input name="dateFrom" type="text" id="dateFrom" value="{$smarty.post.dateFrom|default:$smarty.now|date_format:'%Y-%m-01'}" size="10" onClick="calendar()">
                      截至日期：
                      <input name="dateTo" type="text" id="dateTo" value="{$smarty.post.dateTo|default:$smarty.now|date_format:'%Y-%m-%d'}" size="10" onClick="calendar()"/>
                      客户：{webcontrol type='ClientSelect' id='clientId' selected=$arr_field_value.Client}
<input type="submit" name="Submit" value="搜索" /></td>
		</form>
	  </tr>	
</table>

<br />


{include file="_TableForBrowse.tpl"}




</td></tr></table>

<br />
{include file="_Footer.tpl"}
</body>
</html>


