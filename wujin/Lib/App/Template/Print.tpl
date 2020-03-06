<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{literal}
<style type="text/css">
<!--
.style1 {
	font-size: 14pt;
	font-weight: bold;
}
body {
	margin-left: 0px;
	margin-top: 0px;
}
td {FONT-FAMILY:"宋体,Arial";FONT-SIZE:14px;COLOR:#000;}
.title {FONT-SIZE: 12pt}

#tr {height:30px;}
-->
</style>
{/literal}
</head>

{* 	table_with:表宽		
	hr_height:标题行高度		
	tr_height:其它行高度 	
*}	
<body style="text-align:center">
<h1>{$title}</h1>
{*主表信息,每行显示3个字段*}
<table id="TblMainInfo" width="98%" style="BORDER-COLLAPSE: collapse" bordercolor="#000000" border="2" align="center" cellpadding="2" cellspacing="0">
  <tr id="tr">  
  	{assign var=i value=0}
    {assign var=index value=0}
    {assign var=countMain value=$arr_main_value|@count}
    {foreach from=$arr_main_value item=item key=key} 
    <td align="left">{$key}：{$item}</td>
    {math equation="(x+1)%3" x=$i assign=i}
    {math equation="x+1" x=$index assign=index}
    {if $i==0 && $index>0 && $index<$countMain}
    </tr>
    <tr id="tr"> 
    {/if}
    {/foreach}
  </tr>  
  
</table>
<br>
{*明细列表*}
<table id="dataList" width="98%" style="BORDER-COLLAPSE: collapse" bordercolor="#000000" border="2" align="center" cellpadding="2" cellspacing="0">
  {*字段名称*}
	<tr id="hr" style="height:{$hr_height|default:'30px'};"> 	   
		{foreach from=$arr_field_info item=item}
		<td class="ptd">{$item}</td>
		{/foreach}        
	</tr>
  {*字段的值*}
  
 {foreach from=$arr_field_value item=field_value}    
  <tr id="tr">	  	
	{foreach from=$arr_field_info key=key item=item}    		
	{assign var=foo value="."|explode:$key}
				{assign var=key1 value=$foo.0}
                {assign var=key2 value=$foo.1}
                {assign var=key3 value=$foo.2}	                 
				<td>
					{if $key2==''}{$field_value.$key|default:'&nbsp;'}
                    {elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}
                    {else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}{/if}
				</td>	
	{/foreach}    	
  </tr>
  {/foreach}
</table>	
	
</body>
</html>
