<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>供应商资料编辑</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
{literal}
function setMaxCompCode(o) {
  if (o.value.length==2) {
	$.getJSON('Index.php?controller=JiChu_Supplier&action=GetMaxcompCode',{compCode:o.value},function(json){
    var maxCode = json.compCode;
		if (maxCode){
      var num=parseInt(maxCode.slice(2),10)+1001;
      var newNum = o.value+num.toString(10).slice(1);   
      o.value=newNum; 
    }else{//则为第一条数据
      var num=1001;
      var newNum = o.value+num.toString(10).slice(1);   
      o.value=newNum; 
    }
	});
	return false;
  }  
}
function getName(obj){
	var id=document.getElementById('id').value;
	var url="?controller=JiChu_Supplier&action=GetJsonByName";
	var param={id:id,compName:obj.value};
	$.getJSON(url,param,function(json){
		if(!json)return false;
		//dump(json);return false;
		var c=parseFloat(json.cnt);
		if(c>0){
			alert('名称重复,请重新输入！');
			if(json.id!=''){
				window.location.reload();
			}else{
				document.getElementById('compName').value='';
			}
			return false;
		}
	});
}
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>供应商资料编辑</legend>
<div align="center">
<table width="100%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td width="13%" height="33">编码(双击自动编号)：</td>
    <td width="38%">
      <input name="compCode" type="text" id="compCode" value="{$aSupplier.compCode}" check="^\d+$" warning="编码必须为字母数字或者下划线!" onDblClick="setMaxCompCode(this)" autocomplete="off" />
      <a href="Documents/CaiWu/SupplierCode.txt" target="_blank">编码说明</a></td>
    <td width="11%">名称：</td>
    <td width="38%"><input name="compName" type="text" id="compName" value="{$aSupplier.compName}" check="^\S+$" warning="公司名称不能为空" onChange="getName(this)"/></td>
  </tr>
  <tr>
    <td height="35">联系人:</td>
    <td><input name="people" type="text" id="people" value="{$aSupplier.people}" /></td>
    <td>电话：</td>
    <td><input name="tel" type="text" id="tel" value="{$aSupplier.tel}" /></td>
  </tr>
  <tr>
    <td height="34">传真：</td>
    <td><input name="fax" type="text" id="fax" value="{$aSupplier.fax}" /></td>
    <td>手机：</td>
    <td><input name="mobile" type="text" id="mobile" value="{$aSupplier.mobile}" /></td>
  </tr>
  <tr>
    <td height="35">帐号：</td>
    <td><input name="accountId" type="text" id="accountId" value="{$aSupplier.accountId}" /></td>
    <td>税号：</td>
    <td><input name="taxId" type="text" id="taxId" value="{$aSupplier.taxId}"/></td>
  </tr>
  <tr>
    <td height="35">地址：</td>
    <td colspan="3"><input name="address" type="text" id="address" value="{$aSupplier.address}"/></td>
  </tr>
  <tr>
    <td height="35">备注：</td>
    <td colspan="3"><input name="memo" type="text" id="memo" value="{$aSupplier.memo}"/></td>
    
  </tr>
  <tr>
    <td height="45" colspan="4" align="center"><input name="id" type="hidden" id="id" value="{$aSupplier.id}" />      <input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
