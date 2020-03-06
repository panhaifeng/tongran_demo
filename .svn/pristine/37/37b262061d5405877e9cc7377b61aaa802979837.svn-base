<!--
	.在tablelist的基础上进行了美化
	.动态载入js与cs文件.
	.内容区域采用div形式,实现frame效果
-->
<html><head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{foreach from=$arr_js_css.cssFile item=css}
<link href="Resource/Css/{$css}" rel="stylesheet" type="text/css" />
{/foreach}
{foreach from=$arr_js_css.jsFile item=js}
<script language="javascript" src="Resource/Script/{$js}"></script>
{/foreach}
<style type="text/css">
{literal}
div.c{overflow:auto;width:100%; border:solid 1px #86b5e7; padding:1px;}
table.t thead tr{position:relative;top:expression(this.offsetParent.scrollTop-2);} 
{/literal}
</style>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<base target="_self" />
</head>
<body style="margin-left:2px; margin-right:8px; height:100%">
{include file="_ContentNav.tpl"}
{include file="_SearchItem.tpl"}
<div id="div_content" class="c">{include file="_TableForBrowse1.tpl"}</div>
{$page_info}

</body>
</html>

{literal}
<script language="javascript">
/*根据客户端浏览器的高度自动设定*/

	//var previousOnload = window.onload;
	//window.onload = function () { 
	  //if(previousOnload) previousOnload(); 
	  	var topHeight 		= 24;
		var ieHeight		= document.body.clientHeight;
		var obj1 		= document.getElementById('div_content');
		//debugger;
		var contentHeight 	= ieHeight - obj1.offsetTop-topHeight;
		//alert(ieHeight);
		
		obj1.style.height	=	contentHeight;
		document.getElementById('TableContainer').style.height=contentHeight-4;
	//} 
</script>
{/literal}

