<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Edit2.css" type="text/css" rel="stylesheet">
</head>

<body style="text-align:center">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<input name="{$pk}" type="hidden" id="{$pk}" value="{$aRow.$pk}" />
<table>
  <tr>
    <td width="13%" align="right">收信人：</td>
    <td width="38%">
				<select name="reUserId">
				{webcontrol type='TmisOptions' model='Acm_User'}
			  </select></td>
    <td width="11%" align="right">标题：</td>
    <td width="38%"><input name="title" type="text" id="title" value=""/></td>
  </tr>

<!--
  <tr>
  	<td align="right" colspan="4" style="height:300px"><input id="content" name="content" style="display:none">
	<iframe id='content_frame' name="content_frame" src='Lib/DZeditor/editor.html'  frameborder='0' scrolling='no' width='100%' height='100%'></iframe></td></tr>
-->
  <tr>
    <td align="right" colspan="4" style="height:300px"><textarea name="content" style="display:none">{$aRow.content}</textarea>
		<iframe id='eWebEditor1' src='lib/eweb/ewebeditor.htm?id=content'  frameborder='0' scrolling='no' width='100%' height='100%'></iframe>		</td>
  </tr>
  <tr>
    <td align="right">发送日期：</td>
    <td><input name="sendDate" type="text" id="sendDate" value="{$default_date}" /></td>
    <td colspan="2"><input name="sendUserId" type="hidden" value="{$send_userId}"></td>
  </tr>
</table>
	<input type="submit" name="Submit" value="提交"></td>
</form>
</body>
</html>
