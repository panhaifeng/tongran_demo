{foreach from=$arr_field_value item=field_value}
  	  <tr bgcolor="{cycle values="#D4D0C8,#EEEEEE"}">
	  	{foreach from=$arr_field_info key=key item=item}
    	<td>{$field_value.$key}</td>
    	{/foreach}
		<td align="center">
		<a href="#" onclick="javascript:if (confirm('确认删除吗?')) window.location.href='{url controller=$smarty.get.controller action='remove' id=$field_value.$pk ruKuId=$ruku_id chuKuId=$chuku_id}'">删除</a>
		</td>   	
  	  </tr>
{/foreach}