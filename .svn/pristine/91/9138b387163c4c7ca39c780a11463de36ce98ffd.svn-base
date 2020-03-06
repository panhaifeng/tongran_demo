<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>客户资料编辑</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>     
<legend>首页信息发布</legend>
<div align="center">
<table>
  <tr>
    <td width="13%" align="right">类别：</td>
    <td width="38%">
				<select name="classId">
				{webcontrol type='TmisOptions' model='OA_MessageClass' selected = $aRow.classId}
			  </select></td>
    <td width="11%" align="right">标题：</td>
    <td width="38%"><input name="title" type="text" id="title" value="{$aRow.title}"/></td>
  </tr>
  <tr>
    <td align="right" colspan="4">内容:</td>
  </tr>
  <tr>
    <td align="right" colspan="4" style="height:300px"><textarea name="content" style="display:none">{$aRow.content}</textarea>
		<iframe id='eWebEditor1' src='lib/eweb/ewebeditor.htm?id=content'  frameborder='0' scrolling='no' width='100%' height='100%'></iframe>		</td>
  </tr>
  <tr>
    <td align="right">建立日期：</td>
    <td><input name="buildDate" type="text" id="buildDate" value="{if $aRow.buildDate==null} {$default_date}{else} {$aRow.buildDate} {/if}" /></td>
    <td align="right">建立人：</td>
    <td> <select name="userId">
				{webcontrol type='TmisOptions' model='Acm_User' selected = $aRow.userId}
			  </select>	</td>
  </tr>
  
  <tr>
    <td colspan="4" align="center">
	<input name="{$pk}" type="hidden" id="{$pk}" value="{$aRow.$pk}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
