<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h3 align="center">{$title}</h3>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='search'}" method="post" onSubmit="return CheckForm(this)">
  <tr>
    <td>
	<fieldset><legend>查询条件</legend>
	  <table width="100%" border="0" cellspacing="1" cellpadding="1">

        <tr>
          <td height="25" align="center" style="display:none">
		  客户：
			  <select name="clientId">
				{webcontrol type='TmisOptions' model='JiChu_Client' selected=$client_id}
			  </select>
		  </td>
          <td height="25" align="center"  style="display:none">
		  起始日期：<input name="date_from" type="text" size=10  onclick='calendar()' value="{if $date_from ==null}{$default_date}{else}{$date_from}{/if}">
		  &nbsp;&nbsp;截至日期：<input name="date_to" type="text" size=10  onclick='calendar()' value="{if $date_to ==null}{$default_date}{else}{$date_to}{/if}">
		  
		  </td>
          <td height="25" align="right" >产品名称：<input name="key" type="text" value="{$key}" /></td>
		  </td>
        </tr>
        
        <tr>
          <td height="25" colspan="3" align="center" >
            <input name="Submit" type="submit" id="Submit" value="查询"></td>
          </tr>
      </table>
      </fieldset>
	</td>
  </tr>  
  </form>
  
  
  <tr>
    <td>
	
	
	<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#999999">
      {*字段名称*}
      <tr bgcolor="#CCCCCC"> 
	    {foreach from=$arr_field_info item=item}
        <td>{$item}</td>
        {/foreach}
        
      </tr>
      {*字段的值*}
      {foreach from=$arr_field_value item=field_value}
  	  <tr bgcolor="{cycle values="#D4D0C8,#EEEEEE"}">
	  	{foreach from=$arr_field_info key=key item=item}
    	<td>{$field_value.$key}</td>
    	{/foreach}
    	
  </tr>
      {/foreach}
    </table>
	</td>
  </tr>
	
	
	
</table>
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
{$page_info}
<p align="center">[ <a href="Index.php?controller=Main&action=index">返回</a> ]</p>
</body>
</html>
