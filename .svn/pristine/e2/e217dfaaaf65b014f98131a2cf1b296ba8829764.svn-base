<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>员工信息编辑</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/common.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
function getCode(obj){
	var id=document.getElementById('id').value;
	var url='?controller=Jichu_Employ&action=GetJsonByCode';
	var param={workerCode:obj.value,id:id};
	$.getJSON(url,param,function(json){
			//dump(json); return false;
			if(parseFloat(json.cnt)>0){
				alert('工号重复，请确认后再输入！');
				if(json.id!=''){
					window.location.reload();
				}else{
					document.getElementById('workerCode').value='';
				}
			}
	});
}
</script>
{/literal}
</head>

<body>
<form action="{url controller=$smarty.get.controller action='save'}" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>员工信息编辑</legend>
<div align="center">
<table width="100%" border="1" cellspacing="1" cellpadding="0">
  <tr>
    <td>员工代码：</td>
    <td><input name="employCode" type="text" id="employCode" value="{$aEmploy.employCode}" check="^[a-zA-Z0-9_]+$" warning="员工代码必须为字母数字或者下划线!"/></td>
    <td>员工姓名：</td>
    <td><input name="employName" type="text" id="employName" value="{$aEmploy.employName}" /></td>
  </tr>
  <tr>
    <td>性别:</td>
    <td><!--<input type="radio" name="sex" value="0" {if $aemploy.sex==0} checked {/if}>
      男
        <input type="radio" name="sex" value="1" {if $aemploy.sex==1} checked {/if}>
      女--><select id="sex" name="sex">
      <option value="0" {if $aEmploy.sex==0}selected{/if}>男</option>
      <option value="1" {if $aEmploy.sex==1}selected{/if}>女</option>
      </select></td>
    <td>部门：</td>
    <td>
	<select name='DepId'>		
	{webcontrol type='TmisOptions' model='JiChu_Department' selected=$aEmploy.depId}
	</select></td>
  </tr>
  <tr>
    <td>电话：</td>
    <td><input name="mobile" type="text" id="mobile" value="{$aEmploy.mobile}" /></td>
    <td>地址：</td>
    <td><input name="address" type="text" id="address" value="{$aEmploy.address}" /></td>
  </tr>
  <tr>
    <td>上岗日期：</td>
    <td><input name="dateEnter" type="text" id="dateEnter" value="{$aEmploy.dateEnter}" onClick="calendar()" /></td>
    <td>离职日期：</td>
    <td><input name="dateLeave" type="text" id="dateLeave" value="{$aEmploy.dateLeave}" onClick="calendar()"/></td>
  </tr>
  <tr>
    <td>身份证号码：</td>
    <td><input name="IDCard" type="text" value="{$aEmploy.IDCard}"></td>
    <td>工号：</td>
    <td><input name="workerCode" type="text" id="workerCode" value="{$aEmploy.workerCode}" onChange="getCode(this)"></td>
  </tr>
  <tr>
  <tr>
    <td>上传</td>
    <td><input name="imageUrl" type="file">
    <span style="color:red">(jpg,gif,png)</span></td>
    <td>照片</td>
    <td><input name="lookimage" type="image" style="width:80; height:80;" src="{$imgPath}{$aEmploy.imageUrl} ">
      <span style="color:red">无预览请上传</span></td>
  </tr>
    <td colspan="4" align="center">
	<input name="id" type="hidden" id="id" value="{$aEmploy.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
