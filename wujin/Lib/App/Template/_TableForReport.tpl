<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#999999">
      {*字段名称*}
      <tr bgcolor="#CCCCCC"> 
	    {foreach item=item from=$arr_field_title}
        <td>{$item}</td>
        {/foreach}        
      </tr>
      {*字段的值*}
      {foreach from=$arr_field_value item=field_value}
  	  <tr bgcolor="{cycle values="#D4D0C8,#EEEEEE"}">
	  	{foreach from=$field_value item=item key=key}
    		{if $key != $field_primary_key}
    	<td>{$item}</td>
    		{/if}
    	{/foreach}    	
  </tr>
      {/foreach}
    </table>