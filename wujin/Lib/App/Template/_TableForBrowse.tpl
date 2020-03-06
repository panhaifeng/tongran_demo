{literal}
<style type="text/css">
	#tb {
		width:100%;
		border: 1px solid #bbdde5; 
		margin-top:5px;
		background-color:FFFFFF
	}
	#fieldInfo td {
		height:24px;
		background-image:url('Resource/Image/System/th_bg.gif');		
		/*border-right: 1px solid #525C3D; 
		border-bottom: 1px solid #525C3D; */
		border-right:1px solid #ccc;
		color:#192E32; font-weight:bold;
	}
	#fieldValue {height:17px;}
	#fieldvalue td {border-top: 1px solid #cccccc;}
	a:visited{color:#993300;text-decoration:none;}
</style>
{/literal}
<table id="tb" cellpadding="1" cellspacing="1">
      {*字段名称*}
      <tr id="fieldInfo"> 
	    {foreach from=$arr_field_info item=item}
        	{assign var=align value="|"|explode:$item}
        	<td align="{if $align[1]==''}center{else}{$align[1]}{/if}">{$align[0]}</td>
        {/foreach}
		{if $arr_edit_info != ""}
        	<td align="center">操作2</td>
		{/if}
      </tr>
	  
      {*字段的值*}
      {foreach from=$arr_field_value item=field_value}
	  {if $field_value.display != 'false'}	{*显示条件行*}                              
  	  <tr id="fieldValue">
	  	{foreach from=$arr_field_info key=key item=item}
				{assign var=foo value="."|explode:$key}
                {assign var=align value="|"|explode:$item}
				{assign var=key1 value=$foo.0}
				{assign var=key2 value=$foo.1}
				{assign var=key3 value=$foo.2}   
				<td align="{if $align[1]==''}center{else}{$align[1]}{/if}" style="border-right:1px solid #ccc">{if $key2==''}{$field_value.$key|default:'&nbsp;'}{elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}{else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}{/if}</td>
    	{/foreach}
		{if $arr_edit_info != ""}
		<td align="center">&nbsp;
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
	  {/if}
      {/foreach}
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
