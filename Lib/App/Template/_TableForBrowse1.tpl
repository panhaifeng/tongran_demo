{literal}
<style type='text/css'>

/* Scrollable Content Height */
.scrollContent {
 height:auto;
 overflow-x:hidden;
 overflow-y:auto;
}

.scrollContent tr {
 height: auto;
 white-space: nowrap;
}

/* Prevent Mozilla scrollbar from hiding right-most cell content */
.scrollContent tr td:last-child {
 padding-right: 2px;
}

/* Fixed Header Height */
.fixedHeader tr {
 position: relative;
 height: auto;
 /* this fixes IE header jumping bug when mousing over rows in the tbody */
 top: expression( this.parentNode.parentNode.parentNode.scrollTop + 'px' );
}

/* Put border around entire table */
div.TableContainer {
 border: 1px solid #80BDCB;
 overflow-y:auto;
}

/* Table Header formatting */
.headerFormat {
 background-color: white;
 color: #FFFFFF;
 margin: 3px;
 padding: 1px;
 white-space: nowrap;
 font-family: Helvetica;
 font-size: 15px;
 text-decoration: none;
 font-weight: bold;
}
.headerFormat tr td {
 border: 0px solid #FFFFFF;
 background-color: #80BDCB;
}

/* Table Body (Scrollable Content) formatting */
.bodyFormat tr td {
	color: #000000;
	margin: 3px;
	padding: 1px;
	border: 0px none;
	font-family: Helvetica;
	font-size: 12px;
}

/* Use to set different color for alternating rows */
.alternateRow {
  background-color: #E0F1E0;
}

/* Styles used for SORTING */
.point {
 cursor:pointer;
}

</style>
{/literal}
<div id="TableContainer" class="TableContainer">
<table width='100%' cellpadding="1" cellspacing="1" class="scrollTable" id="tb">		
      {*字段名称*}
    <thead class="fixedHeader headerFormat">
      <tr id="fieldInfo" class='title'> 
	    {foreach from=$arr_field_info item=item}
        	<td align="center"  class="point">{$item}</td>
        {/foreach}
		{if $arr_edit_info != ""}
        	<td align="center"  class="point">操作</td>
		{/if}
      </tr>
	  </thead>
      {*字段的值*}
      <tbody class="scrollContent bodyFormat" style="height:auto;">
      {foreach from=$arr_field_value item=field_value}
	  {if $field_value.display != 'false'}	{*显示条件行*}
  	  <tr id="fieldValue"  bgcolor="{cycle values="#eeeeee,#ffffff"}">
		{foreach from=$arr_field_info key=key item=item}
        	{assign var=foo value="."|explode:$key}
		    {assign var=key1 value=$foo.0}
		    {assign var=key2 value=$foo.1}
			{assign var=key3 value=$foo.2}			
    	<td align="center" style="border-right:1px solid #ccc" {if $field_value._bgColor!=''}bgcolor="{$field_value._bgColor}"{/if}>{if $key2==''}{$field_value.$key|default:'&nbsp;'}{elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}{else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}{/if}</td>
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
      </tbody>
    </table>
</div>