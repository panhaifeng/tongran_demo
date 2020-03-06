<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Discuz! Administrator's Control Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{literal}
<style type="text/css">
/* 左侧菜单 */
html, body {
	scrollbar-face-color: #80bdcb;
	scrollbar-track-color: #80bdcb;
	scrollbar-highlight-color: #555555;
	scrollbar-3dlight-color: #555555;
	scrollbar-darkshadow-color: #60B7DE;
	scrollbar-shadow-color: #555555;
	scrollbar-arrow-color: #FFFFFF;
	background: #DDEEF2;
}

body {
	margin:0px; padding:0px;
	font: 12px Arial, Helvetica, sans-serif;
}
	
td{
	font: 12px Arial, Helvetica, sans-serif;
	/*text-align: left;*/
}

.leftmenulist {
	margin: 2px;
	border: 1px solid #525C3D;
	width: 134px;
}

.leftmenutext td {
	background: url(Resource/Image/System/bg_list.gif) repeat-x;
	line-height: 16px;
	height: 31px !important;
	> height: 30px !important;
	height: 30px;
	font-weight: bold;
	color: #FFFFFF;
	padding-left: 4px;
	border-bottom: 1px solid #BBDCF1;
}

.leftmenutext a {
	font-size: 13px;
	font-weight: bold;
	color: #FFFFFF;
}

.leftmenutd td {
	background: #FFFFFF;
}

.leftmenuinfo {
	margin-left: 8px;
	margin-bottom: 10px;
	width: 116px;
}

.leftmenuinfo td{
	height: 1.8em;
	line-height: 1.6em;/**/
	border-bottom: solid 1px #A3CEEB;
	text-indent: 8px;
}
a {
	text-decoration: none;
	color: #555555
}
a:hover {
	text-decoration: underline;
}

.menu_001{color:#006699}
.menu_002{color:#993300}
.menu_003{color:#FF0000; font-weight:bold}
</style>
{/literal}
<script src="Resource/Script/common_main.js" type="text/javascript"></script>
<script src="Resource/Script/menu.js" type="text/javascript"></script>
{literal}
<script>
var currentMenu = null;
var collapsed = getcookie('e7_collapse');
function collapse_change(menucount) {
	if($('menu_' + menucount).style.display == 'none') {
		$('menu_' + menucount).style.display = '';collapsed = collapsed.replace('[' + menucount + ']' , '');
		$('menuimg_' + menucount).src = 'Resource/Image/System/menu_reduce.gif';
	} else {
		$('menu_' + menucount).style.display = 'none';collapsed += '[' + menucount + ']';
		$('menuimg_' + menucount).src = 'Resource/Image/System/menu_add.gif';
	}
	setcookie('e7_collapse', collapsed, 2592000);
}

function aboutUs() {

}
function changeBg(obj){
	//dump(obj.parentNode.className);
	if(currentMenu) currentMenu.parentNode.style.background='';	
	//var a = document.getElementsByName('tdMenu');
	//for (var i=0;a[i];i++) a[i]
	obj.parentNode.style.background='#ccc';
	currentMenu = obj;
}
</script>
{/literal}
</head>

<body style="margin:5px!important;margin:3px;">

<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;"><tr class="leftmenutext"><td><div align="center"><a href="Index.php?controller=Main&action=Content" target="main">首页</a>&nbsp;&nbsp;&nbsp;<a href="Index.php?controller=Login&action=logout" target="_top" onclick="return confirm('确认注销吗?')">注销</a>&nbsp;&nbsp;&nbsp;<a href="Help/Index.html" target="_blank">帮助</a></div></td></tr></table>
{assign var="img_id" value=0}
{foreach from=$menu key=key item=item}
	<div id="leftMenu" name="leftMenu" style="display:none">
		{foreach from=$item key=child_key item=child_item}
			<table width="146" border="0" cellspacing="0" align="center" cellpadding="0" class="leftmenulist" style="margin-bottom: 5px;"><tr class="leftmenutext"><td><a href="###" onclick="collapse_change({$img_id})"><img id="menuimg_{$img_id}" src="Resource/Image/System/menu_reduce.gif" border="0"/></a>&nbsp;<a href="###" onclick="collapse_change({$img_id})">{$child_key}</a></td></tr>
			
				<tbody id="menu_{$img_id}" style="">
				<tr class="leftmenutd"><td>
				<table border="0" cellspacing="0" cellpadding="0" class="leftmenuinfo">
					{foreach from=$child_item key=mis_key item=mis_item}
					<tr><td><a href="{$mis_item}" target="main" onclick="changeBg(this)">{$mis_key}</a></td></tr>
					{/foreach}
				</table>
				</td></tr>
				</tbody>
			</table>
			{assign var="img_id" value=$img_id+1}
		{/foreach}
	</div>
{/foreach}

<!--前台登记指定模块
<input id=menuName name=menuName type=hidden value="{$menu_name}">
{literal}	
	<script language="javascript">
	var elementId = document.getElementById("menuName").value;
	//alert(elementId);
	//alert("as;kdfjafsj");
	//alert(parent.header.document.getElementById("Cangku").innerHTML);
	parent.header.document.getElementById(elementId).onclick();
	//togglemenu(document.getElementById("menuName").value); </script>
{/literal}-->
</body>
</html>