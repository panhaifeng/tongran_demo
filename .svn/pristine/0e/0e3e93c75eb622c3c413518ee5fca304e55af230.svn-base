<table width="760" style="BORDER-COLLAPSE: collapse" borderColor=#000000 border="2" align="center" cellpadding="2" cellspacing="0">
      <tr align="center" bgcolor="#FFFFFF">
       {foreach item=item from=$arr_field_title}
        <td>{$item}</td>
        {/foreach} 
      </tr>
      <tr align="center" bgcolor="#FFFFFF">
       {foreach from=$arr_field_value item=field_value}
    		{foreach from=$arr_field_info key=key item=item}
        	{assign var=foo value="."|explode:$key}
		    {assign var=key1 value=$foo.0}
		    {assign var=key2 value=$foo.1}
			{assign var=key3 value=$foo.2}			
    	<td align="center" style="border-right:1px solid #ccc" {if $field_value._bgColor!=''}bgcolor="{$field_value._bgColor}"{/if}>{if $key2==''}{$field_value.$key|default:'&nbsp;'}{elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}{else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}{/if}</td>
    	{/foreach}
      </tr>
    </table>