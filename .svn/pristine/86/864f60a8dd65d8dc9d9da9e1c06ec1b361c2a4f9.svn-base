<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{foreach from=$arr_js_css.cssFile item=css}
<link href="Resource/Css/{$css}" rel="stylesheet" type="text/css" />
{/foreach}
{foreach from=$arr_js_css.jsFile item=js}
<script language="javascript" src="Resource/Script/{$js}"></script>
{/foreach}
</head>

<body>
<div style="margin:0 10%; text-align:center; width:80%">
<form action="{url controller=$smarty.get.controller action=save}" method="post">
<fieldset>
<legend>通讯录</legend>
<input name="id" type="hidden" id="id" value="{$aRow.id}">
<table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>名称：</td>
    <td>
      <input name="proName" type="text" id="proName" value="{$aRow.proName}" />
    </td>
  </tr>
  <tr>
    <td>号码：</td>
    <td>
      <input name="tel" type="text" id="tel" value="{$aRow.tel}" />
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" text-align:center;">
      <input type="submit" name="submit" id="submit" value="提交" />&nbsp;&nbsp;
      <input type="button" name="cancal" id="cancal" value="取消" />
    </td>
    </tr>
</table>
</fieldset>
</form>
</div>
</body>
</html>
