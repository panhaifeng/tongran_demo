<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>客户资料编辑</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
{literal}
<script language="javascript">
function setMaxCompCode(o) {
  if (o.value.length==2) {
	$.getJSON('Index.php?controller=JiChu_Client&action=GetMaxcompCode',{compCode:o.value},function(json){
		var maxCode = json?json.compCode:'000';
		var num=parseInt(maxCode.slice(-3),10)+1001;
		var newNum = o.value+num.toString(10).slice(1);		
		o.value=newNum;		
	});
	return false;
  }  
}

function setCompCode(o) {
	var arType = document.getElementById('ArType[]').value;
	var userId = o.value;
	if (arType==4&&userId>0) $.getJSON('Index.php?controller=JiChu_Client&action=GetMaxcompCode',{userId:userId},function(json){
		var t = document.getElementById('compCode');
		var maxCode = json?json.compCode:'000';
		var userCode = json.Trader.employCode;		
		var num=parseInt(maxCode.slice(-3),10)+1001;
		var newNum = '04'+userCode+num.toString(10).slice(1);		
		t.value=newNum;		
	});	
}
</script>
{/literal}

<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<base target="_self">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>     
<legend>客户资料编辑</legend>
<div align="center">
<table width="100%">
  <tr>
    <td width="80" align="right" valign="top" colspan="4">
	<input type='hidden' id='ArType[]' name='ArType[]' value="1">
	<!--
	业务类别：<br>      <font color="#FF0000">按住Ctrl多选</font></td>
    <td rowspan="3" valign="top"><select name="ArType[]" size="5" multiple id="ArType[]" warning='请选择该客户的业务范围' check='^0$'>      
    {webcontrol type='TmisOptions' model='CaiWu_ArType' selected=$aClient.ArType}
    </select>
	-->
	</td>
 </tr>
 <tr>
     <td align="right">编码：</td>
    <td><input name="compCode" type="text" id="compCode" value="{$aClient.compCode}" size="15" check="^[a-zA-Z0-9_]+$" warning="编码必须为字母数字或者下划线!"  ondblclick="setMaxCompCode(this)"/>
      <a href="Documents/CaiWu/ClientCode.txt" target="_blank">编码说明</a></td>
   <td align="right">本厂负责：</td>
    <td><select name="traderId" id="traderId" onChange="setCompCode(this)">
     {webcontrol type='TmisOptions' model='JiChu_Employ' selected=$aClient.traderId condition='depId=11'}
    </select>    </td>
  
  </tr>
  <tr>
    <td align="right">名称：</td>
    <td><input name="compName" type="text" id="compName" value="{$aClient.compName}" /></td>
    
    <td align="right">来源：</td>
    <td><select name="comeFrom" id="comeFrom">
      <option value="网络">网络</option>
      <option value="展会" {if $aclient.comefrom=='展会'}selected{/if}>展会</option>
      <option value="来电" {if $aclient.comefrom=='来电'}selected{/if}>来电</option>
      <option value="介绍" {if $aclient.comefrom=='介绍'}selected{/if}>介绍</option>
      <option value="开发" {if $aclient.comefrom=='开发'}selected{/if}>开发</option>
      <option value="其他" {if $aclient.comefrom=='其他'}selected{/if}>其他</option>
    </select>
    </td>    
  </tr>
  <tr>
    <td align="right">传真：</td>
    <td><input name="fax" type="text" id="fax" value="{$aClient.fax}" /></td>
    <td align="right">联系人:</td>
    <td><input name="people" type="text" id="people" value="{$aClient.people}" /></td>
  </tr>
  <tr>
    <td align="right">帐号：</td>
    <td><input name="accountId" type="text" id="accountId" value="{$aClient.accountId}" /></td>
    <td align="right">电话：</td>
    <td><input name="tel" type="text" id="tel" value="{$aClient.tel}" /></td>
  </tr>
  <tr>
    <td align="right">地址：</td>
    <td><input name="address" type="text" id="address" value="{$aClient.address}"/></td>
    <td align="right">手机：</td>
    <td><input name="mobile" type="text" id="mobile" value="{$aClient.mobile}" /></td>
  </tr>
  <tr>
    <td align="right">备注：</td>
    <td><input name="memo" type="text" id="memo" value="{$aClient.memo}"/></td>
    <td align="right">税号：</td>
    <td><input name="taxId" type="text" id="taxId" value="{$aClient.taxId}"/></td>
  </tr>
  <tr style="background:red">
    <td align="right">用户名：</td>
    <td><input name="loginName" type="text" id="loginName" value="{$aClient.loginName}"/></td>
    <td align="right">密码：</td>
    <td><input name="loginPsw" type="password" id="loginPsw" value="{$aClient.loginPsw}"/></td>
  </tr>
  <tr>
    <td align="right">结算方式：</td>
    <td>
    <select name='paymentWay' id='paymentWay' >
      <option value='0' {if $aClient.paymentWay=='0'}selected{/if}>投坯</option>
      <option value='1' {if $aClient.paymentWay=='1'}selected{/if}>净重</option>
      <option value='2' {if $aClient.paymentWay=='2'}selected{/if}>折率净重</option>
    </select></td>
    <td align="right">客户全称：</td>
    <td><input name="fullName" type="text" id="fullName" value="{$aClient.fullName}"/></td>
  </tr>
  <tr>
    <td align="right">接口地址：</td>
    <td colspan="3" ><input name="iURL" type="text" id="iURL" size="80" value="{$aClient.iURL}"/><br/>
      <font color="#FF0000">
      * 此接口地址用于染纱计划的导入，可留空。<br/>
      * 输入时需要把完整地址输入(包括http://)。</font>
    </td>
  </tr>
  <tr>
    <td colspan="4" align="center">
	<input name="{$pk}" type="hidden" id="{$pk}" value="{$aClient.$pk}" />
	<input type="submit" name="Submit" value="提交">
	<input type="reset" name="button" id="button" value="重置"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
