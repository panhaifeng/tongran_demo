<html>
<head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>
<body style="margin-left:8px; margin-right:8px;">
	<form name="form1" method="post" action="{url controller=$smarty.get.controller action='saveImport'}">    
	<style type="text/css">
{literal}
	#tb {
		width:100%;
		border: 1px solid #bbdde5; 
		margin-top:5px; 
		background-color:FFFFFF
	}
	#fieldInfo{		
		position: relative; 
        top: expression(this.offsetParent.scrollTop); 
        z-index: 10;
        background-color: #E6ECF0;
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
{/literal}
</style>
<table id="tb" cellspacing='1' cellpadding='1'>
      {*字段名称*}
      <tr id="fieldInfo"> 
        	<td align="center">物料编码</td>
        	<td align="center">品名</td>
        	<td align="center">规格</td>
        	<td align="center">单位</td>
        	<td align="center">初始数量</td>
        	<td align="center">初始金额</td>
      </tr>
	  
      {*字段的值*}
      {foreach from=$rowset item=field_value}
  	  <tr id="fieldValue">
    	<td align="center" style="border-right:1px solid #ccc">        
        <input name='wareCode[]' id='wareCode[]' value='{$field_value[0]}' size=8>
        </td>
    	<td align="center" style="border-right:1px solid #ccc"><input name='wareName[]' id='wareName[]' value='{$field_value[1]}' size=8></td>
    	<td align="center" style="border-right:1px solid #ccc"><input name='guige[]' id='guige[]' value='{$field_value[2]}' size=8></td>
    	<td align="center" style="border-right:1px solid #ccc"><input name='unit[]' id='unit[]' value='{$field_value[3]}' size=8></td>
    	<td align="center" style="border-right:1px solid #ccc"><input name="initCnt[]" type="text" id="initCnt[]" value="{$field_value[4]}" size="8"></td>
    	<td align="center" style="border-right:1px solid #ccc"><input name='initMoney[]' id='initMoney[]' value='{$field_value[6]}' size=8></td>
  	  </tr>
      {/foreach}
    </table>
	
<div align="center"><input name="Submit" type="submit" value="提交">
  <input name="parentId" type="hidden" id="parentId" value="{$smarty.post.parentId}">
</div>
    </form>
</body>
</html>

