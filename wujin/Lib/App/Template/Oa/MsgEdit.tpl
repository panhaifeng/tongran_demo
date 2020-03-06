<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit2.css" type="text/css" rel="stylesheet">
{literal}
<style>   
  select.readonly{meizz:expression(selectedIndex=0)}   
</style> 
{/literal}
</head>

<body style="text-align:center">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" >
<input name="{$pk}" type="hidden" id="{$pk}" value="{$aRow.$pk}" />
<table width="650">
  <tr>
    <td align="right">类别：</td>
    <td>
			<select name="classId" onChange="selectedIndex={$aRow.classId}">
				{webcontrol type='TmisOptions' model='OA_MessageClass' selected = $aRow.classId}
			 </select></td>
    <td align="right">标题：</td>
    <td><input name="title" type="text" id="title" onClick="dd(this.value)" value="{$aRow.title}" maxlength="100" /></td>
  </tr>

  <tr>
    <td align="right" colspan="4" style="height:300px"><textarea name="content" style="display:none">{$aRow.content}</textarea>
      <iframe id='eWebEditor1' src='lib/eweb/ewebeditor.htm?id=content'  frameborder='0' scrolling='no' width='100%' height='100%'></iframe></td>
  </tr>
  <tr>
    <td align="right">建立日期：</td>
    <td><input name="buildDate" type="text" id="buildDate" value="{if $aRow.buildDate==null} {$default_date}{else} {$aRow.buildDate} {/if}" /></td>
    <td align="right">建立人：</td>
    <td>{$smarty.session.REALNAME}
      <input type="hidden" name="hiddenField" id="hiddenField" value="{$smarty.session.USERNAME}"></td>
  </tr>

</table>
	
	<input type="submit" name="Submit" value="提交"></td>
</form>
</body>
</html>
