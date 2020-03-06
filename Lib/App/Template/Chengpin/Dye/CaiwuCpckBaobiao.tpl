<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{literal}
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript">
function prnbutt_onclick() { 
	window.print(); 
	return true; 
} 

function window_onbeforeprint() { 
	document.getElementById('ttt').style.visibility ="hidden"; 
	return true; 
} 

function window_onafterprint() { 
	document.getElementById('ttt').style.visibility = "visible"; 
	return true; 
} 
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 14pt;
	font-weight: bold;
}

td {FONT-FAMILY:"宋体,Arial";FONT-SIZE:14px;COLOR:#000;}
.title {FONT-SIZE: 12pt}

#button{width:50}
-->
</style>
{/literal}
</head>

{* 	table_with:表宽		
	hr_height:标题行高度		
	tr_height:其它行高度 	
*}	
<body style="text-align:center"  onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<h1>{$title}</h1>
{*主表信息,每行显示3个字段*}
<table align="center" cellpadding="2" cellspacing="0" id='ttt'>
  <form name="form1" method="post" action="{url controller=$smarty.get.controller action='CaiwuCpckBaobiao'}">
  <tr id="tr">   
    <td align="left">日期:
      <input type="text" style="width:80" name="dateFrom" id="dateFrom" onClick="calendar()" value="{$arr_condition.dateFrom}"/>
到:
<input type="text" style="width:80" name="dateTo" id="dateTo" onClick="calendar()" value="{$arr_condition.dateTo}"/>
客户:{webcontrol type='ClientSelect' id='clientId' selected=$arr_condition.clientId}&nbsp;
            纱支:
            <input name="guige" type="text" id="guige" value="{$arr_condition.guige}" size="10"/>
      <input type="submit" name="button" id="button" value="搜索"></td>    
    <td align="right"><input type="button" name="prn" id="prn" value="打 印" onClick="return prnbutt_onclick()" class="ptnClass100"/></td>
    </tr></form>
</table>
{*明细列表*}
<table id="dataList" width="98%" style="BORDER-COLLAPSE: collapse;" bordercolor="#000000" border="2" align="center" cellpadding="2" cellspacing="0">
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
</body>
</html>
