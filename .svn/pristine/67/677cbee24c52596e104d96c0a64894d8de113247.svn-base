<html>
<head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/Thickbox.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/ajax.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.1.9.1.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/thickbox/thickbox.js"></script>
<script language="javascript" src="Resource/Css/Thickbox.css"></script>
<script language="javascript" src="Resource/Script/json2.js"></script>
{$other_script}
<script language="javascript">
{literal}

function popMenu(e) {
	tMenu(e,'Index.php?controller=Jichu_Ware&action=tmismenu',0,false,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
		$('#spanDanwei')[0].innerHTML = arr[2]?arr[2]:'kg';
	});
}

function popYlMenu(e) {
	tMenu(e,'Index.php?controller=Jichu_Ware&action=tmismenu',5,false,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
		$('#spanDanwei')[0].innerHTML = arr[2]?arr[2]:'kg';
	});
}
{/literal}
</script>
{if $sonTpl}{include file=$sonTpl}{/if}
</head>
<body style="margin-left:8px; margin-right:8px;">
<div id='divPanel' style="margin:0px; padding:0px;">
	{if $nav_display != 'none'}{include file="_ContentNav.tpl"}{/if}
	
	{include file="_SearchItem.tpl"}

	{include file="_TableForBrowse.tpl"}
	{$page_info}
</div>
</body>
</html>
