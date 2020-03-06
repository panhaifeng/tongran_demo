<html>
<head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">
	var IMGDIR = 'images/PinkDresser';var attackevasive = '0';</script>
{/literal}
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/common_main.js"></script>
<script language="javascript" src="Resource/Script/menu.js"></script>
<script language="javascript" src="Resource/Script/ajax.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>

<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',0,false,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
		//alert(arr[2]);
		$('#spanDanwei')[0].innerHTML = arr[2]?arr[2]:'kg';
	});
}
{/literal}
</script>
{literal}
<script type="text/javascript">
function checkalloption(form, value) {
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.value == value && e.type == 'radio' && e.disabled != true) {
			e.checked = true;
		}
	}
}

function checkallvalue(form, value, checkall) {
	var checkall = checkall ? checkall : 'chkall';
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.type == 'checkbox' && e.value == value) {
			e.checked = form.elements[checkall].checked;
		}
	}
}

function zoomtextarea(objname, zoom) {
	zoomsize = zoom ? 10 : -10;
	obj = $(objname);
	if(obj.rows + zoomsize > 0 && obj.cols + zoomsize * 3 > 0) {
		obj.rows += zoomsize;
		obj.cols += zoomsize * 3;
	}
}

function redirect(url) {
	window.location.replace(url);
}

var collapsed = getcookie('qq4_collapse');
function collapse_change(menucount) {
	if($('menu_' + menucount).style.display == 'none') {
		$('menu_' + menucount).style.display = '';collapsed = collapsed.replace('[' + menucount + ']' , '');
		$('menuimg_' + menucount).src = 'Resource/Image/menu_reduce.gif';
	} else {
		$('menu_' + menucount).style.display = 'none';collapsed += '[' + menucount + ']';
		$('menuimg_' + menucount).src = 'Resource/Image/menu_add.gif';
	}
	setcookie('qq4_collapse', collapsed, 2592000);
}
</script>

<style>
#searchGuid input {
	vertical-align:middle;
}
</style>
{/literal}
</head>
<body style="margin:0 8px">
<div id=searchGuid style="padding:2px; padding-left:10px;">
<form name="FormSearch" method="post" action="">
<input type='hidden' name=clientId  value="{$arr_condition.clientId}">
订单号：<input name="orderCode" type="text" id="orderCode" value="{$arr_condition.orderCode}" size="15">			
</form>
</div>

{include file="_TableForBrowse.tpl"}

{$page_info}

<br />

{include file="_Footer.tpl"}

</body>
</html>

