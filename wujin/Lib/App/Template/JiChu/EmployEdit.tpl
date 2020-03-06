<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>员工信息编辑</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisPopup.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript">
{literal}
$(function(){
	new TmisPopup({
		obj:document.getElementById('depName'),//进行渲染的目标元素,可以是document.getElementsByName('')得到的数组
		fieldInText:'depName',//选择后对text控件进行赋值的字段
		fieldInHidden:'id',//选择后对hidden控件进行赋值的字段,默认是id
		width : 120,//渲染后的宽度
		urlPop:'?controller=Jichu_Department&action=Popup',//弹出框的地址
		titlePop:'选择申请部门',//弹出框的标题
		widthPop:700,
		heightPop:500,
		urlSearch:'?controller=Jichu_Department&action=GetJsonByKey',//根据输入进行检索的地址
		idHidden:'depId',//创建的hidden元素的id和name
		idBtn:'_depBtn',//创建的按钮的id
		isArray:false,//if true,创建的元素以[]结尾
		onSelect: function(json,pos){
			//dump(json);
			//将焦点给下一个
			//document.getElementById("traderCode").focus();
		}//选择某个记录后的触发动作
	});
});
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

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
    <td><!--<input type="radio" name="sex" value="0" {if $aEmploy.sex==0} checked {/if}>
      男
        <input type="radio" name="sex" value="1" {if $aEmploy.sex==1} checked {/if}>
      女--><select id="sex" name="sex">
      <option value="0" {if $aEmploy.sex==0}selected{/if}>男</option>
      <option value="1" {if $aEmploy.sex==1}selected{/if}>女</option>
      </select></td>
    <td>部门：</td>
    <td>
	<!--<select name='DepId'>		
	{webcontrol type='TmisOptions' model='JiChu_Department' selected=$aEmploy.depId}
	</select>-->
  <input name="depName" type="text" id="depName" value="{$aEmploy.departments.depName}" size="8">
  <input name="depId" type="hidden" id="depId" value="{$aEmploy.depId}">
    </td>
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
    <td colspan="4" align="center">
	<input name="{$pk}" type="hidden" id="{$pk}" value="{$aEmploy.$pk}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
