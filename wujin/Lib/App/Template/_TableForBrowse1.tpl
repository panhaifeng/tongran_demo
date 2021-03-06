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
        	{if $key!='_edit'}<td align="{if $align[1]==''}center{else}{$align[1]}{/if}">{$align[0]}</td>{/if}
        {/foreach}
      </tr>
	  </thead>
      <tbody class="scrollContent bodyFormat" style="height:200px;">
      {foreach from=$arr_field_value item=field_value}
	  {if $field_value.display != 'false'}	
  	  <tr id="fieldValue"  bgcolor="{cycle values="#eeeeee,#ffffff"}" onmouseover="this.className='fieldValue1'" onmouseout="this.className='fieldValue'" style="{if $field_value._bgColor!=''}background: {$field_value._bgColor} {/if}">      
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
    </table>
</div>
{literal}
<script language="javascript">
	  	var topHeight 		= 70;
		var tailHeight 		= 29;
		var ieHeight		= document.body.clientHeight;
		var contentHeight 	= ieHeight - tailHeight-topHeight;
		try {
			document.getElementById('TableContainer').style.height=contentHeight;
		} catch(e) {
		}
</script>
{/literal}