<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/IndexList.css" type="text/css" rel="stylesheet">
{literal}
<script type="text/javascript">var IMGDIR = 'images/PinkDresser';var attackevasive = '0';</script>
{/literal}
<script src="Resource/Script/common_main.js" type="text/javascript"></script>
<script src="Resource/Script/menu.js" type="text/javascript"></script>
<script src="Resource/Script/calendar.js" type="text/javascript"></script>
<script src="Resource/Script/jquery.js" type="text/javascript"></script>
<script src="Resource/Script/ajax.js" type="text/javascript"></script>
<script language="javascript" src="Resource/Script/TmisGrid.js"></script>
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
//将id为tabs0的宽带设置为当前页面宽减50
$(function(){
		   //document.getElementById("tabs0").style.width=document.body.clientWidth-50;//tb
		   });
/*第一种形式 第二种形式 更换显示样式*/
function setTab(m,n){
 var tli=document.getElementById("menu"+m).getElementsByTagName("li");
 var mli=document.getElementById("main"+m).getElementsByTagName("ul");
 for(i=0;i<tli.length;i++){
  tli[i].className=i==n?"hover":"";
  mli[i].style.display=i==n?"block":"none";
 }
 document.getElementById('indexNum').value=n;
}
/*第三种形式 利用一个背景层定位*/
var m3={0:"",1:"评论内容",2:"技术内容",3:"点评内容"}
function nowtab(m,n){
 if(n!=0&&m3[0]=="")m3[0]=document.getElementById("main2").innerHTML;
 document.getElementById("tip"+m).style.left=n*100+'px';
 document.getElementById("main2").innerHTML=m3[n];
}

</script>
{/literal}
</head>
<body leftmargin="10" topmargin="0">
<a name="top" id="top"></a>
<div style=" clear:both; font-size:14px; border-bottom:1px solid #000;" id="mm" align='left'>
	<b>● 染色排班登记</b>&nbsp;&nbsp;&nbsp;总投料数: <strong>{$total_count}</strong>&nbsp;&nbsp;&nbsp;总缸数:<strong>{$total_vat}</strong><font color="red">(显示条件：下单日期在120天之内，没有染色产量.)</font>
</div>
{include file="_SearchItem.tpl"}
<form id="form1" action="{url controller=$smarty.get.controller action=saveJihua}" method="post">
  
<!--原table形式显示---------------------->
<div align="center" style="display:none">
{section name=loop loop=$count}

{if $vat_code != ''}
<a href="#{$vat_code[$smarty.section.loop.index]}">{$vat_code[$smarty.section.loop.index]}号缸</a>&nbsp;|&nbsp;
{else}
	{if $comp_name[$smarty.section.loop.index] != ''}
	<a href="#{$comp_name[$smarty.section.loop.index]}">{$comp_name[$smarty.section.loop.index]}</a>&nbsp;|&nbsp;
	{/if}
{/if}

{/section}
</div>



<table width="100%" border="0" cellpadding="2" cellspacing="6">
{section name=loop loop=$count}


{if $vat_code != ''}
<tr><td align="left" style="width:90%"><a name="{$vat_code[$smarty.section.loop.index]}" id="{$vat_code[$smarty.section.loop.index]}"><span style="font-size:14px; font-weight:bold; color:#660000;">缸号:&nbsp;{$vat_code[$smarty.section.loop.index]}</span></a></td>
<td align="right" width="100px" style="display:none"><a href="#top"><span style="font-size:12px; font-weight:normal; color:#FF0000">点击回顶部</span></a></td></tr>
{else}

{if $comp_name[$smarty.section.loop.index] != ''}
<tr><td align="center" style="width:90%"><a name="{$comp_name[$smarty.section.loop.index]}" id="{$comp_name[$smarty.section.loop.index]}"><span style="font-size:14px; font-weight:bold; color:#660000;">客户:&nbsp;{$comp_name[$smarty.section.loop.index]}</span></a></td>
<td align="right" width="100px" style="display:none"><a href="#top"><span style="font-size:12px; font-weight:normal; color:#FF0000">点击回顶部</span></a></td></tr>
{/if}
{/if}


<tr><td colspan="2">
{if ($comp_name[$smarty.section.loop.index] != '') || ($vat_code != '')}
<table id="tb" width="100%" cellpadding="0" cellspacing="1"  style="border: 1px solid #525C3D;">
      {*字段名称*}
      <tr style="height:30px;background-image:url('Resource/Image/System/bg_list.gif')"> 
	    {foreach from=$arr_field_info item=item}
        <td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-right: 1px solid #525C3D; border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold;">{$item}</td>
        {/foreach}
        <td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold">打印</td>
         <td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold">加急</td>
         {if $arr_edit_info != ""}
        <td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold">取消</td>
		{/if}
      </tr>
      {*字段的值*}
      {foreach from=$arr_field_value[$smarty.section.loop.index] item=field_value}
  	  <tr style="height:17px;display:{$field_value.display}" bgcolor="{$field_value.bgColor}" >
	  	{foreach from=$arr_field_info key=key item=item}
    	<td align="center" style="border-top: 1px solid #cccccc; border-right:1px solid #ccc">{$field_value.$key|default:'&nbsp;'}</td>
    	{/foreach}
    	
    	{if $field_value.planarr }
    	<td align="center" style="border-top: 1px solid #cccccc;border-right:1px solid #ccc">
        <input name="isJihua1[{$field_value.planarr}]" id="isJihua1[{$field_value.planarr}]" type="checkbox"/>
        </td>
    	{/if}
        {if $field_value.id }
    	<td align="center" style="border-top: 1px solid #cccccc;border-right:1px solid #ccc">
        <input name="isJihua[{$field_value.id}]" id="isJihua[{$field_value.id}]" type="checkbox"/>
        </td>
        {else}
        <td align="center" style="border-top: 1px solid #cccccc;border-right:1px solid #ccc">&nbsp;
        
        </td>
        {/if}
        <td align="center" style="border-top: 1px solid #cccccc;border-right:1px solid #ccc">
        {if $field_value.id}<input name="isJiaji[{$field_value.id}]" id="isJiaji[{$field_value.id}]" type="checkbox"/>
        {else}&nbsp;
        {/if}
        </td>
        {if $arr_edit_info != ""}
		<td align="center" style="border-top: 1px solid #cccccc;border-right:1px solid #ccc">&nbsp;
		<!--{foreach from=$arr_edit_info key=key2 item=item}
			{if $item == "取消" && $field_value.id!=""}
            	<a href="{url controller=$smarty.get.controller action=CanelJihua id=$field_value.id}">{$item}</a>
            {/if}
    	{/foreach}-->
         {if $field_value.id}
        <input name="isCancel[{$field_value.id}]" id="isCancel[{$field_value.id}]" type="checkbox"/>
        {/if}
		</td>
		{/if}
  	  </tr>
      {/foreach}
    </table>
{/if}
</td></tr>
{/section}
</td></tr></table>
{literal}	
<!--<script type="text/javascript">
 var obj=document.getElementById("tb"); 
 for(var i=1;i<obj.rows.length;i++){  //循环表格行设置鼠标事件：丁学 http://www.cnblogs.com/dxef
   obj.rows[i].onmouseover=function(){   	
	  //this.style.backgroundImage='Resource/Image/System/row-over.gif';
   	  //this.style.background="#b4d1f0";
	  this.style.background="#efefef";
	}
   
   obj.rows[i].onmouseout=function(){this.style.background="";}
 }
</script>-->
{/literal}

<div style="width:100%" align="center" >
日期：<input name="dateAssign" id="dateAssign" type="text" size="15" onClick="calendar()" value="{$smarty.now|date_format:'%Y-%m-%d'}" />
班次：
<select name="ranseBanci" id="ranseBanci">
<option value="1">早班</option>
<option value="3">早班1</option>
<option value="4">早班2</option>
<option value="5">早班3</option>
<option value="2">晚班</option>
<option value="6">晚班1</option>
<option value="7">晚班2</option>
<option value="8">晚班3</option>
</select>

<input name="submit1" id="submit1" type="submit" value="保存并返回" />
<input name="submit1" id="submit1" type="submit" value="保存并打印" />
<input name="submit1" id="submit1" type="submit" value="取消排班" />
<input type="button" name="button" id="button" value="并缸" onClick="window.location.href='?controller=Plan_Dye&action=Binggang'">
<!-- <input name="submit1" id="submit1" type="submit" value="并缸双染" /> -->
</div>
</form>
<br />
{include file="_Footer.tpl"}
</body>
</html>

