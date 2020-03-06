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
<legend>报工人员信息录入</legend>
<div align="center">
<table width="50%" border="1" cellspacing="1" cellpadding="0">
  
  <tr>
    <td width="13%" height="33">名称：</td>
    <td width="38%">
      <input name="perName" type="text" id="perName" value="{$aRow.perName}" check="^(\s|\S)+$" warning="名称不能为空!" /></td>
  </tr>
  <tr>
    <td width="13%" height="33">工号：</td>
    <td width="38%">
      <input name="workerCode" type="text" id="workerCode" value="{$aRow.workerCode}" check="^(\s|\S)+$" warning="名称不能为空!" /></td>
  </tr>    
  <tr>
    <td height="33">类型：</td>
    <td>
        <select name="type" id="type">
          <option value="st" {if $aRow.type=='st'}selected{/if}>松筒</option>
          <option value="zcl" {if $aRow.type=='zcl'}selected{/if}>装出笼</option>
          <option value="hs" {if $aRow.type=='hs'}selected{/if}>烘纱</option>
          <option value="rs" {if $aRow.type=='rs'}selected{/if}>染色</option>
          <option value="hd" {if $aRow.type=='hd'}selected{/if}>紧筒</option>
          <option value="db" {if $aRow.type=='db'}selected{/if}>打包</option>
          <option value="ts" {if $aRow.type=='ts'}selected{/if}>脱水</option>
        </select>&nbsp;
    </td>
  </tr>
  <tr>
    <td height="33">班次：</td>
    <td>
        <select name="banci" id="banci">
          <option value="0" {if $aRow.banci=='0'}selected{/if}>请选择</option>
          <option value="1" {if $aRow.banci=='1'}selected{/if}>早班</option>
          <option value="2" {if $aRow.banci=='2'}selected{/if}>晚班</option>
        </select>&nbsp;
    </td>
  </tr>

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
