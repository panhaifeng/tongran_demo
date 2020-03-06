<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
<title>{$title}</title>
{literal}
<script language="javascript">
function prnbutt_onclick() { 
	window.print(); 
	return true; 
} 

function window_onbeforeprint() { 
	prn.style.visibility ="hidden"; 
	return true; 
} 

function window_onafterprint() { 
	prn.style.visibility = "visible"; 
	return true; 
} 
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 18pt;
	font-weight: bold;
}

td {FONT-FAMILY:"宋体,Arial";FONT-SIZE:18px;COLOR:#000;}
.title {FONT-SIZE: 18pt}
#tr {height:30px;}
.dataList{ font-size:18px;}
-->
</style>
{/literal}
</head>

{* 	table_with:表宽		
	hr_height:标题行高度		
	tr_height:其它行高度 	
*}	
<body style="text-align:center" onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<div style="width:650px;">
	<span style="font-size:22px; font-weight:bold">{$title}<span style="font-size:14px;">({$arr_main_value.date})</span>
</div>
<br />

{*明细列表*}
<table id="dataList" class="dataList" width="650px" style="BORDER-COLLAPSE: collapse" bordercolor="#000000" border="2" align="center" cellpadding="2" cellspacing="0">
  {*字段名称*}
	<tr id="hr" style="height:{$hr_height|default:'30px'};"> 	   
		{foreach from=$arr_field_info key=key item=item}
        {if $key!='_edit'}  	
		<td class="ptd">{$item}</td>
        {/if}
		{/foreach}        
	</tr>
  {*字段的值*}
  
 {foreach from=$arr_field_value item=field_value}    
  <tr id="tr">	  	
	{foreach from=$arr_field_info key=key item=item}  
    	{if $key!='_edit'}  		
			{assign var=foo value="."|explode:$key}
            {assign var=key1 value=$foo.0}
            {assign var=key2 value=$foo.1}
            {assign var=key3 value=$foo.2}	                 
            <td>
                {if $key2==''}{$field_value.$key|default:'&nbsp;'}
                {elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}
                {else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}{/if}
            </td>	
         {/if}
	{/foreach}    	
  </tr>
  {/foreach}
</table>
<br />
<input type="button" name="prn" id="prn" value="打 印" onclick="return prnbutt_onclick()" class="ptnClass100"/>
{$other_button}
</body>
</html>
