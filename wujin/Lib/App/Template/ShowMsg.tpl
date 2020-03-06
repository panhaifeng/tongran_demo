<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{literal}
<style type="text/css">
.line{border-bottom: solid 1px #996600;}
td{font-size:12px;}
</style>
{/literal}
</head>

<body style="text-align:center">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" >
<input name="{$pk}" type="hidden" id="{$pk}" value="{$aRow.$pk}" />
<table width="600px" border="0">
  <tr>
    <td align="center" class="line" >
      <span style="font-size:15pt; font:bold">{$aRow.title}</span><br/>
      发布日期：{if $aRow.buildDate==null} {$default_date}{else} {$aRow.buildDate} {/if}
    </td>
    </tr>

  <tr>
    <td align="center" style="height:300px" class="line"><div style="height:300px; width:100%; text-align:left;word-wrap:break-word;word-break:break-all;">{$aRow.content}</div></td>
  </tr>
  <tr>
    <td align="right"><input type="hidden" name="hiddenField" id="hiddenField" value="{$smarty.session.USERNAME}"></td>
    </tr>

</table>
<input name="btton1" type="button" value="关闭窗口"  onClick="var ss= window.parent.tb_remove();">
</td>

</form>
</body>
</html>
