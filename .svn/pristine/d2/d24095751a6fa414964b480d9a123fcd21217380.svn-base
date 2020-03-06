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
{literal}
<style type="text/css">

div.c{overflow: hidden;width:100%; border:solid 1px #86b5e7; padding:1px;}
table.t thead tr{position:relative;top:expression(this.offsetParent.scrollTop-2);}

</style>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<script language="javascript">
$(function(){
		var topHeight 		= 0;
		var tailHeight 		= 4;
		var ieHeight		= document.body.clientHeight;
		//alert(ieHeight);
		//alert(ieHeight+'-'+tailHeight+'-'+topHeight);
		var contentHeight 	= parseInt(ieHeight) - parseInt(tailHeight)-parseInt(topHeight);
		document.getElementById('TableContainer').style.height=contentHeight;
		/*try {
			//alert(contentHeight);//alert(tailHeight);alert(topHeight);
			//alert(1);
			//document.getElementById('TableContainer').style.height=contentHeight;
			//document.getElementById('TableContainer').style.height=300;
		} catch(e) {
		}*/
});
</script>
{/literal}
<base target="_self" />
</head>
<body style="margin-left:2px; margin-right:0px; height:100%">
<div id="div_content" class="c">
{*浮宝要求所有数据都nowrap,而且操作区放在最前面，故这个模板不具备通用性*}
{literal}
<style type='text/css'>
.scrollContent {
 height:100px;
 overflow-x:hidden;
 overflow-y:auto;
}
.scrollContent tr {
 height: auto;
 white-space: nowrap;
}
.scrollContent tr td:last-child {
 padding-right: 2px;
}
.nowrap td {
	white-space:nowrap;
}
.fixedHeader tr {
 position: relative;
 height: 20px;
 top: expression( this.parentNode.parentNode.parentNode.scrollTop + 'px' );
}
div.TableContainer {
 border: 1px solid #80BDCB;
 height:500px;
 width:100%;
 overflow-y:scroll;
 overflow-x:auto;
}
.headerFormat {
 background-color: white;
 color: #FFFFFF;
 margin: 0px;
 padding: 0px;
 white-space: nowrap;
 font-family: Helvetica;
 font-size: 15px;
 text-decoration: none;
 font-weight: bold;
}
.headerFormat tr td {
 border: 0px solid #FFFFFF;
 background-color: #BADBE0;
}
.bodyFormat tr td {
	color: #000000;
	margin: 0px;
	padding: 0px;
	border: 0px none;
	font-family: Helvetica;
	font-size: 12px;
}
.alternateRow {
  background-color: #E0F1E0;
}
.point {
 cursor:pointer;
}
.th{
	color:#000000;
}

#fieldValue td{ height:20px;}

.fieldValue td {
	border-top:0px solid #eee!important;
	border-bottom:0px solid #eee!important;
}

.fieldValue1 td{
	border-top:1px dotted blue !important;
	border-bottom:1px dotted blue !important;
}
img{border:0px;}
</style>
{/literal}
<div id="TableContainer" class="TableContainer">
<table width='100%' cellpadding="1" cellspacing="1" class="scrollTable nowrap" id="tb">
    <thead class="fixedHeader headerFormat">
      <tr id="fieldInfo" class='th'>
        {if $arr_field_info._edit}<td align="center"  class="point">{$arr_field_info._edit}</td>{/if}
	    {foreach from=$arr_field_info item=item key=key}
        	{assign var=align value="|"|explode:$item}
        	{if $key!='_edit'}<td align="{if $align[1]==''}center{else}{$align[1]}{/if}"  class="point">{$align[0]}</td>{/if}
        {/foreach}
      </tr>
	  </thead>
      <tbody class="scrollContent bodyFormat" style="height:200px;">
      {foreach from=$arr_field_value item=field_value}
	  {if $field_value.display != 'false'}
  	  <tr id="fieldValue"  bgcolor="{cycle values="#eeeeee,#ffffff"}" onmouseover="this.className='fieldValue1'" onMouseOut="this.className='fieldValue'" style="{if $field_value._bgColor!=''}background: {$field_value._bgColor} {/if}">
         {if $arr_field_info._edit}<td align="center"  class="point">{$field_value._edit}</td>{/if}
		{foreach from=$arr_field_info key=key item=item}
        	{if $key!='_edit'}
        	{assign var=foo value="."|explode:$key}
            {assign var=align value="|"|explode:$item}
		    {assign var=key1 value=$foo.0}
		    {assign var=key2 value=$foo.1}
			{assign var=key3 value=$foo.2}
    	<td align="{if $align[1]==''}center{else}{$align[1]}{/if}" style="border-right:1px solid #ccc">{if $key2==''}{$field_value.$key|default:'&nbsp;'}{elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}{else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}{/if}</td>
        	{/if}
    	{/foreach}

  	  </tr>
	  {/if}
      {/foreach}
      </tbody>
    </table>{$other}
</div>
</div>
</body>
</html>