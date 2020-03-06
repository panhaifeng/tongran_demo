{*为popup定制的通用的模板，在showModaldialog时使用*}
<html>
<head>
<title>选择对话框</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{foreach from=$arr_js_css.cssFile item=css}
<link href="Resource/Css/{$css}" rel="stylesheet" type="text/css" />
{/foreach}
{foreach from=$arr_js_css.jsFile item=js}
<script language="javascript" src="Resource/Script/{$js}"></script>
{/foreach}

{literal}
<style type="text/css">
form{margin:0px; padding:0px;}
div.c{overflow:auto;width:490; height:500; border:solid 1px #86b5e7; padding:3px; background-color:#C9daf4}
table.t thead tr{position:relative;top:expression(this.offsetParent.scrollTop-2);} 
</style>
<script language="javascript">
function onSelect(trObj){
	var ret = new Array();
	var arrMap = new Array();	
	
{/literal}

	{foreach from=$arr_field_info key=key item=item}
		arrMap.push('{$key}');
	{/foreach}

{literal}

	for (var i=0;i<trObj.cells.length;i++){
		ret[arrMap[i]] = (trObj.cells[i].innerText||trObj.cells[i].textContent);
	}
	//alert(ret["clientPihao"]);
	window.returnValue=ret;
	window.close();
}
$(function(){
	var topHeight 		= 95;
	var ieHeight		= document.body.clientHeight;
	var contentHeight 	= ieHeight - topHeight;
	var obj1 		= document.getElementById('div_content');
	obj1.style.height	=	contentHeight;
});
</script>
{/literal}
<base target="_self">
</head>
<body style="margin-left:2px; margin-right:8px; height:100%">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td colspan="2">{include file="_SearchItem.tpl"}</tr>
<tr><td style="height:5px;" colspan="2"></td></tr>
<tr><td colspan="2"><div id="div_content" class="c">{include file="_TableForSelect.tpl"}</div></td></tr>
<tr><td colspan="2">{$page_info}</td></tr>
</table>
</body>
</html>