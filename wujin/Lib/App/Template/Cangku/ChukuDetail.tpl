<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<title>{$title}</title>
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
</head>

<body>
<table id="tb" cellpadding="1" cellspacing="1">
      {*字段名称*}
      <tr id="fieldInfo"> 
	    {foreach from=$arr_field_info item=item}
        	<td align="center">{$item}</td>
        {/foreach}
		{if $arr_edit_info != ""}		{/if}
      </tr>
	  
      {*字段的值*}
      {foreach from=$arr_field_value item=field_value}
	  {if $field_value.display != 'false'}	{*显示条件行*}                              
  	  <tr id="fieldValue">
	  	{foreach from=$arr_field_info key=key item=item}
				{assign var=foo value="."|explode:$key}
				{assign var=key1 value=$foo.0}
				{assign var=key2 value=$foo.1}
				{assign var=key3 value=$foo.2}                  
				<td align="center" style="border-right:1px solid #ccc">{if $key2==''}{$field_value.$key|default:'&nbsp;'}{elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}{else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}{/if}</td>
    	{/foreach}
		{if $arr_edit_info != ""}		{/if}    	
  	  </tr>
	  {/if}
      {/foreach}
    </table>

</body>
</html>
