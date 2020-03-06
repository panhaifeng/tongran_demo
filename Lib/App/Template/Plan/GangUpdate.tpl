<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/thickbox.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/thickbox/thickbox.js"></script>
<title>{$title}</title>
{literal}
<script language="javascript">
$(function(){
	
	$('#btnMerge').click(function(){
		//确认有2个以上的缸被选中
		var i=0;
		var arrId = new Array();
		$("input[@id='sel[]']").each(function(){											 
			if(this.checked) {
				arrId.splice(0,0,this.value);
				i++;
			}
		});
		if(i<2) return false;
		
		if(confirm('该操作将删除选中的缸，并新增一个合并缸，您确认吗？')){
			var url='?controller=Trade_Dye_Order&action=mergeGang';
			for(var i=0;i<arrId.length;i++) {
				url += '&gangId[]='+arrId[i];
			}
			//alert(url);return false;
			window.open(url);
		}
	});
});
</script>
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
.table100{text-align:center;}
.th td{height:15px;}
</style>
{/literal}
</head>

{* 	table_with:表宽		
	hr_height:标题行高度		
	tr_height:其它行高度 	
*}	
<body style="text-align:center">
<div id="container">
<div id="nav">{include file="_ContentNav2.tpl"}</div>
{*主表信息,每行显示3个字段*}
<fieldset>
<legend>订单信息</legend>
<table class="tableHaveBorder table100" width="98%" style="BORDER-COLLAPSE: collapse" bordercolor="#000000" border="2" align="center" cellpadding="2" cellspacing="0">
  <tr id="tr">  
  	{assign var=i value=0}
    {assign var=index value=0}
    {assign var=countMain value=$arr_main_value|@count}
    {foreach from=$arr_main_value item=item key=key} 
    <td class="th" align="left">{$key}：</td>
    <td align="left">{$item}</td>
    {math equation="(x+1)%3" x=$i assign=i}
    {math equation="x+1" x=$index assign=index}
    {if $i==0 && $index>0 && $index<$countMain}
    </tr>
    <tr id="tr"> 
    {/if}
    {/foreach}
  </tr>  
  
</table>
</fieldset>
<br>
{*明细列表*}
<fieldset>
<legend>排缸计划修改
</legend>
<table class="tableHaveBorder table100" width="98%" style="BORDER-COLLAPSE: collapse" bordercolor="#000000" border="2" align="center" cellpadding="2" cellspacing="0">
  {*字段名称*}
	<tr id="hr" style="height:{$hr_height|default:'30px'};"> 	   
		{foreach from=$arr_field_info item=item}
		<td class="th">{$item}</td>
		{/foreach}        
	</tr>
  {*字段的值*}
  
 {foreach from=$arr_field_value item=field_value}    
  <tr id="tr" {if $field_value._bgColor} bgcolor="{$field_value._bgColor}"{/if}>	  	
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
</fieldset>

	<div align="center"><br />
	  <input type="button" name="btnAdd" id="btnAdd" value="增加缸" onclick="window.open('{url controller=$smarty.get.controller action='Addgang' order2wareId=$smarty.get.order2wareId}')"/>
     <input type="button" name="btnCancel" id="btnCancel" value="返回计划编辑界面" onclick="window.location='Index.php?controller=Trade_Dye_Order&action=Edit&id={$arr_field_value[0].orderId}&page=EnterOrder'"/>
       <input type="button" name="btnCancel" id="btnCancel" value="返回计划浏览界面" onclick="window.location='Index.php?controller=Trade_Dye_Order&action=right'"/>
	  <label>
	    <a href="{url controller=Plan_Dye action='totaljiaji' order2wareId=$smarty.get.order2wareId page=jiaji}">整单加急</a>&nbsp;&nbsp;<a href="{url controller=Plan_Dye action='CancelTotalJiaji' order2wareId=$smarty.get.order2wareId page=jiaji}">取消整单加急</a>
      </label>
	</div>
    </div>
</body>
</html>
