<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript">
function popMenu(obj) {
	tMenu(obj,'Index.php?controller=JiChu_Ware&action=tmismenu',5,false,function(e) {
		var arr = explode("||",e.text);
	});
}
</script>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveindex'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>染缸工序价格录入</legend>
<div align="center">
<table width="50%" border="1" cellspacing="1" cellpadding="0">
  
  <tr>
    <td width="13%" height="33">名称：</td>
    <td width="38%">
      <input name="gxName" type="text" id="carCode" value="{$aRow.gxName}" check="^(\s|\S)+$" warning="名称不能为空!" /></td>
  </tr>  
  <tr>
    <td height="33">类型：</td>
    <td>
      <input name="kind" type="text" id="carCode" value="{$aRow.kind}"  />
    </td>
  </tr>
 <!--  <tr>
    <td height="35">价格：</td>
    <td><input name="price" type="text" id="price" value="{$aRow.price}"/></td>
  </tr> -->
  <tr>
    <td height="45" colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aRow.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
