<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
function popMenu(e) {
	tMenu(e,'Index.php?controller=Acm_Func&action=tmismenu',0,true);
}
{/literal}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <th scope="col">为角色"{$aRole.id}:{$aRole.roleName}"分配权限</th>
  </tr>
  <tr>
    <td align="center">
	<form method="post" action="{url controller=$smarty.get.controller action=saveassign}">
	<fieldset><legend>分配权限</legend>
	选择权限：
	<input name="funcId" type="text" id="funcId" onClick="popMenu(this)"/>
	<input type="submit" name="Submit" value="提交" />
      <input name="roleId" type="hidden" id="roleId" value="{$aRole.id}" />
	</fieldset>
	</form>	
	<table width="100%" border="1" align="center" cellpadding="1" cellspacing="1">
      <tr>
        <th scope="col">已分配权限编号</th>
        <th scope="col">已分配权限</th>
        <th scope="col">操作</th>
      </tr>
	  {foreach from=$aRole.funcs item=aFunc}
      <tr>
        <td align="center">{$aFunc.id}</td>
        <td align="center">{$aFunc.funcName}</td>
        <td align="center"><a href="{url controller=$smarty.get.controller action=removeAssign roleId=$smarty.get.id funcId=$aFunc.id}" onClick="return confirm('您确认要删除吗?')">删除</a></td>
      </tr>
	  {/foreach}
    </table>
	
	</td>
  </tr>
  <tr>
    <td align="center">[ <a href="{url controller=$smarty.get.controller action='right'}">返回</a> ]</td>
  </tr>
</table>
</body>
</html>
