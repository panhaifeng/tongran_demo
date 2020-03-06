<html>
<head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{foreach from=$arr_js_css.cssFile item=css}
<link href="Resource/Css/{$css}" rel="stylesheet" type="text/css" />
{/foreach}
{foreach from=$arr_js_css.jsFile item=js}
<script language="javascript" src="Resource/Script/{$js}"></script>
{/foreach}
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