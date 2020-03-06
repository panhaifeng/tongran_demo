<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">var IMGDIR = 'images/PinkDresser';var attackevasive = '0';</script>
{/literal}
<script language="javascript" src="Resource/Script/Calendar/WdatePicker.js"></script>
<script src="Resource/Script/common_main.js" type="text/javascript"></script>
<script src="Resource/Script/menu.js" type="text/javascript"></script>
<script src="Resource/Script/ajax.js" type="text/javascript"></script>

<script src="Resource/Script/jquery.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">

$('#form1').submit(function(){
	//如果sel没有选中的，提示
	var sels = $('[name="sel"]');
	var f = false;
	for(var i=0;sels[i];i++) {
		if(sels.eq(i).attr('checked')) {
			return true;
		}
	}
	alert('必须选择缸');
	return false;
});
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
{/literal}
</head>
<body leftmargin="10" topmargin="0">
<a name="top" id="top"></a>
<div align="center" style=" width:100%;">
<div align="center" style=" clear:both; font-size:14px;">
	<ul style="list-style:none">
		<li style="float:left; color:#006699; white-space:nowrap;"><b>● 未染色列表</b>&nbsp;&nbsp;&nbsp;总投料数: <strong>{$total_count}</strong>&nbsp;&nbsp;&nbsp;总缸数:<strong>{$total_vat}</strong>  <font color="red">注：本报表显示的是120天之内未排班且没有染色产量的缸.</font></li>	
        
	</ul>
</div>
</div>


<hr />



{include file="_SearchItem.tpl"}
<form action='{url controller=$smarty.get.controller action="saveJihua"}' name='form1' id='form1' method="post">

<table width="100%" border="0" cellpadding="2" cellspacing="6">
<tr><td colspan="2">

<table id="tb" width="100%" cellpadding="0" cellspacing="1"  style="border: 1px solid #525C3D;">
      {*字段名称*}
      <tr style="height:30px;background-image:url('Resource/Image/System/bg_list.gif')"> 
	    {foreach from=$arr_field_info item=item}
        <td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-right: 1px solid #525C3D; border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold;">{$item}</td>
        {/foreach}
		{if $arr_edit_info != ""}
        <td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold">操作</td>
		{/if}
      </tr>
      {*字段的值*}
      {foreach from=$arr_field_value item=field_value}
  	  <tr style="height:17px;display:{$field_value.display}">
	  	{foreach from=$arr_field_info key=key item=item}
    	<td align="center" style="border-top: 1px solid #cccccc; border-right:1px solid #ccc">{$field_value.$key|default:'&nbsp;'}</td>
    	{/foreach}
		{if $arr_edit_info != ""}
		<td align="center" style="border-top: 1px solid #cccccc;">&nbsp;
		{foreach from=$arr_edit_info key=key item=item}
		{if $item == "删除" && $field_value.id!=""}
			<a href="{url controller=$smarty.get.controller action=$key id=$field_value.id parentId=$smarty.get.parentId}" onclick="return confirm('确认删除吗?')">{$item}</a>
		{else}
			<a href="{url controller=$smarty.get.controller action=$key id=$field_value.id}">{$item}</a>
		{/if}
    	{/foreach}
		</td>
		{/if}
    	
  	  </tr>
      {/foreach}
    </table>

</td></tr>


	
{literal}	
<script type="text/javascript">
 var obj=document.getElementById("tb"); 
 for(var i=1;i<obj.rows.length;i++){  //循环表格行设置鼠标事件：丁学 http://www.cnblogs.com/dxef
   obj.rows[i].onmouseover=function(){   	
	  //this.style.backgroundImage='Resource/Image/System/row-over.gif';
   	  //this.style.background="#b4d1f0";
	  this.style.background="#efefef";
	}
   
   obj.rows[i].onmouseout=function(){this.style.background="";}
 }
</script>
{/literal}

</td></tr></table>

<div style="width:100%" align="center" >
	日期：<input name="dateAssign" id="dateAssign" type="text" size="15" onClick="calendar()" value="{$smarty.now|date_format:'%Y-%m-%d'}" />
	班次：
	<select name="ranseBanci" id="ranseBanci">
		<option value="1">早班</option>
		<option value="2">晚班</option>
	</select>

	<input name="submit1" id="submit1" type="submit" value="保存并返回" />
	<input name="submit1" id="submit1" type="submit" value="保存并打印" />
	<input name="fromCtroller" id="fromCtroller" type="hidden" value="{$smarty.get.controller}" />
	<input name="fromAction" id="fromAction" type="hidden" value="{$smarty.get.action}" />
</div>
</form>
</body>
</html>

