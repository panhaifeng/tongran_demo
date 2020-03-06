<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>供应商资料编辑</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
$(function(){
	$('#form1').validate({
		rules:{
			compCode:'required',
			compName:'required'
		},
		debug:false
	});
});	
</script>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post">
<fieldset>     
<legend>供应商资料编辑</legend>
<div align="center">
<table width="50%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td width="13%" height="33">编码：</td>
    <td width="38%">
      <input name="compCode" type="text" id="compCode" value="{$aSupplier.compCode}"/></td>
    </tr>
  <tr>
    <td>名称：</td>
    <td><input name="compName" type="text" id="compName" value="{$aSupplier.compName}"/></td>
    </tr>
  <tr>
    <td height="35">联系人:</td>
    <td><input name="people" type="text" id="people" value="{$aSupplier.people}" /></td>
    </tr>
  <tr>
    <td>电话：</td>
    <td><input name="tel" type="text" id="tel" value="{$aSupplier.tel}" /></td>
    </tr>
  <tr>
    <td height="34">传真：</td>
    <td><input name="fax" type="text" id="fax" value="{$aSupplier.fax}" /></td>
    </tr>
  <tr>
    <td>手机：</td>
    <td><input name="mobile" type="text" id="mobile" value="{$aSupplier.mobile}" /></td>
    </tr>
  <tr>
    <td height="35">帐号：</td>
    <td><input name="accountId" type="text" id="accountId" value="{$aSupplier.accountId}" /></td>
    </tr>
  <tr>
    <td height="35">税号：</td>
    <td><input name="taxId" type="text" id="taxId" value="{$aSupplier.taxId}"/></td>
  </tr>
  <tr>
    <td height="35">地址：</td>
    <td><input name="address" type="text" id="address" value="{$aSupplier.address}"/></td>
  </tr>
  <tr>
    <td height="35">备注：</td>
    <td><input name="memo" type="text" id="memo" value="{$aSupplier.memo}"/></td>
    
  </tr>
  <tr>
    <td height="45" colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aSupplier.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
