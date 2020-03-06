<!--
	.在tablelist的基础上进行了美化
	.动态载入js与cs文件.
	.内容区域采用div形式,实现frame效果
-->
<html>
<head>
<base target="_self" />
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{foreach from=$arr_js_css.cssFile item=css}
<link href="Resource/Css/{$css}" rel="stylesheet" type="text/css" />
{/foreach}
{foreach from=$arr_js_css.jsFile item=js}
<script language="javascript" src="Resource/Script/{$js}"></script>
{/foreach}{literal}
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
form{margin:0px; padding:0px;}
div.c{overflow:auto;width:100%; border:solid 1px #86b5e7; padding:1px; background-color:#C9daf4}
table.t thead tr{position:relative;top:expression(this.offsetParent.scrollTop-2);} 

</style>
<script language="javascript">
function ret(){
	var sel = document.getElementsByName('sel[]');
	var r = new Array();
	for(var i=0;sel[i];i++) {
		if(sel[i].checked) {
			r.push(eval("("+sel[i].value+")"));			
		}
	}
	window.returnValue = r;
	window.close();
}
</script>{/literal}
</head>
<body >
{include file="_SearchItem.tpl"}
<div id="div_content" class="c">{include file="_TableForBrowse1.tpl"}</div>
{$page_info}
<input type="button" name="button" id="button" value="选择" onClick="ret()">
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

