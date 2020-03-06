<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
{literal}
<script type="text/javascript">var IMGDIR = 'images/PinkDresser';var attackevasive = '0';</script>
{/literal}
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script src="Resource/Script/common_main.js" type="text/javascript"></script>
<script src="Resource/Script/menu.js" type="text/javascript"></script>
<script src="Resource/Script/ajax.js" type="text/javascript"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
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


function checkallbox(form) {
	var chks = document.getElementsByName('printId[]');
	var cnt=0;
	var chks = $('input[@name="printId[]"]').each(function(){
		if(this.checked==true) cnt++;
	});
	if(cnt==0) {
		alert('请选择要打印的记录');
		return false;
	}
	if (true) {}
	
}
var clientId='';
function sss(obj,id){
    if(clientId==''){
        clientId=id;
    }
    else{
        if(clientId==id){
        //同一个客户
            var i=0;
            $('input[@name="printId[]"]').each(function(){
                if(this.checked==true){
                        i++;
                }
            });
            if(i==0){
                clientId='';
            }
        }
        else{
            obj.checked=false;
            var i=0;
           	$('input[@name="printId[]"]').each(function(){
                if(this.checked==true){
                        i++;
                }
            });
            if(i==0){
                clientId='';
                obj.checked=true;
            }
            else{
                alert('不是同一个客户！');
            }
            //return false;
        }
    }
}	
</script>
{/literal}
</head>

<body  style="margin:0 8px">
{if $arr_condition != ''} {include file="_SearchItem.tpl"} {/if}

<table id="tb" width="100%" cellpadding="0" cellspacing="1"  style="border: 1px solid #525C3D;">
      {*字段名称*}
      <tr style="height:30px;background-image:url('Resource/Image/System/bg_list.gif')">
	  	<td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-right: 1px solid #525C3D; border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold;">选择</td> 
	    {foreach from=$arr_field_info item=item}
        <td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-right: 1px solid #525C3D; border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold;">{$item}</td>
        {/foreach}
		{if $arr_edit_info != ""}
        <td align="center" style="height:20px;background-image:url('Resource/Image/System/bg_list.gif'); border-bottom: 1px solid #525C3D; color:#FFFFFF; font-weight:bold">操作</td>
		{/if}
      </tr>
      {*字段的值*}
	  <form name="formList" action="Index.php?controller={$smarty.get.controller}&Action=Print" method="post" onSubmit="return checkallbox('formList')" target="_blank">
    	<input type="submit" name="print" value="打印预览">	<input type="submit" name="print" value="直接打印">	  
      {foreach from=$arr_field_value item=field_value}
	  {if $field_value.display != 'false'}	{*显示条件行*}
  	  <tr style="height:17px;" >
		<td align="center" {if $field_value._bgColor!=''}bgcolor="{$field_value._bgColor}"{/if}>
		<input type="checkbox" name="printId[]" value="{$field_value.id}" style="padding:0; margin:0px;" {if $isClient==1}onclick="sss(this,{$field_value.clientId})" {/if} /></td>
	  	{foreach from=$arr_field_info key=key item=item}
    	<td align="center" style="border-top: 1px solid #cccccc;" {if $field_value._bgColor!=''}bgcolor="{$field_value._bgColor}"{/if}>{$field_value.$key|default:'&nbsp;'}</td>
    	{/foreach}
		{if $arr_edit_info != ""}
		<td align="center" style="border-top: 1px solid #cccccc;" {if $field_value._bgColor!=''}bgcolor="{$field_value._bgColor}"{/if}>&nbsp;
		{foreach from=$arr_edit_info key=key item=item}
		{if $item == "删除" && $field_value.id!=""}
			<a href="{url controller=$smarty.get.controller action=$key id=$field_value.id parentId=$smarty.get.parentId}" onClick="return confirm('确认删除吗?')">{$item}</a>
		{else}
			<a href="{url controller=$smarty.get.controller action=$key id=$field_value.id}">{$item}</a>
		{/if}
    	{/foreach}
		</td>
		{/if}
  	  </tr>
	  {/if}
      {/foreach}
	  </form>
    </table>
	
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

{$page_info}
<font color="DarkTurquoise">蓝色表示已经打印过</font>

{include file="_Footer.tpl"}
</body>
</html>

