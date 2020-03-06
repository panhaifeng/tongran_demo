{*选择库存项目或者其他与生产有关的信息时使用，一般以thickbox形式显示*}
{*在调用窗口中必须定义onSelect方法，表示在选择后进行的动作*}
{*在调用窗口中需要定义css:.t td {FONT-SIZE:8pt;COLOR:#000000;FONT-FAMILY:"Arial,"}*}
<table id="tb" width="100%" cellpadding="0" cellspacing="0"  style="border: 1px solid #86B5E7;" class='t'>
      {*字段名称*}
	  <thead>
      <tr style="height:22px;background-image:url('Resource/Image/System/tblHeadBg.gif')"> 
	    {foreach from=$arr_field_info item=item}
        <td align="center" style="border-right: 1px solid #86B5E7; border-bottom: 1px solid #86B5E7; padding-top:3px;white-space:nowrap;">{$item}</td>
        {/foreach}		
      </tr>
	  </thead>
	  <tbody>
      {*字段的值*}
      {foreach from=$arr_field_value item=field_value}
  	  <tr style="height:20px;" ondblclick="onSelect(this)">
	  	{foreach from=$arr_field_info key=key item=item}
        	{assign var=foo value="."|explode:$key}
		    {assign var=key1 value=$foo.0}
		    {assign var=key2 value=$foo.1}
			{assign var=key3 value=$foo.2}                   
    	<td align="center" style="border-top: 1px solid #cccccc; border-right:1px solid #cccccc;white-space:nowrap">{if $key2==''}{$field_value.$key|default:'&nbsp;'}{elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}{else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}{/if}</td>
    	{/foreach}    	
  	  </tr>
      {/foreach}
	  </tbody>
    </table>