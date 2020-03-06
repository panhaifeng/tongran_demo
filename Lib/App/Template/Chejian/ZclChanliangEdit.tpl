<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>装出笼产量登记</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.query.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
function getCnt(obj){
	var cntPlanTouliao=document.getElementById('cntPlanTouliao').value;
	var id=document.getElementById('id').value;
	var gangId=document.getElementById('gangId').value;
	var url="?controller=Chejian_Zhuangchulong&action=GetCntByGangId";
	var param={gangId:gangId,id:id};
	$.getJSON(url,param,function(json){
		if(!json)return false;
		if(parseFloat(obj.value)+parseFloat(json.cntK)>parseFloat(cntPlanTouliao)){
			alert('公斤数大于计划投料数，请确认后重新输入!');
			if(json.id==''){
				document.getElementById('cntK').value='';
			}else{
				window.location.reload();
			}
		}
	});
}
function myCheck(){
	var cntK=document.getElementById('cntK').value;
	//alert(cntK);return false;
	if(cntK==''||parseFloat(cntK)==0){
		alert('请录入公斤数！');
		return false;
	}else if($('#banci').val()==''){
    alert('请选择班次');
    return false;
  }
  $("#Submit").attr('disabled',true);
	return true;
}

function isComplete(obj){   //是否完成选择框点击后自动填充实际筒子产量和公斤数
  if($(obj).attr('checked')){
    $('#cntK').val($('#cntPlanTouliao').val());
  }
  // else{
    // $('#cntK').val('');
  // }
}

</script>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChanliang'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
<legend>装出笼产量登记</legend>
<div align="center">
<table width="80%">
  <tr>
    <td width="90">逻辑缸号：</td>
    <td>{$aRow.Gang.vatNum}</td>
    </tr>
  <tr>
    <td>客户：</td>
    <td>{$aRow.Client.compName}</td>
  </tr>
  <tr>
    <td>纱支规格：</td>
    <td>{$aRow.Ware.wareName} {$aRow.Ware.guige}</td>
  </tr>
  <tr>
    <td>颜色：</td>
    <td>{$aRow.Gang.OrdWare.color}</td>
  </tr>
  <tr>
    <td>计划投料：</td>
    <td>{$aRow.Gang.cntPlanTouliao}
      <input name="cntPlanTouliao" type="hidden" id="cntPlanTouliao" value="{$aRow.Gang.cntPlanTouliao}"></td>
  </tr>
  <tr>
    <td>计划筒子数：</td>
    <td>{$aRow.Gang.planTongzi}</td>
  </tr>
  <tr>
    <td>定重：</td>
    <td>{$aRow.Gang.unitKg}</td>
  </tr>
<!--**********************by liu 2013.7.4*****************************-->
  <tr>
    <td>班次：</td>
    <td>
      <select name='banci' id='banci'>
      <option value=''>请选择</option>
      <option value='0' {if $aRow.banci=='0'}selected{/if}>甲</option>
      <option value='1' {if $aRow.banci=='1'}selected{/if}>乙</option>
      </select>
    </td>
  </tr>

  <tr>
    <td>是否回修：</td>
    <td>
      <select name='isHuixiu'>
      <option value='0' {if $aRow.isHuixiu=='0'}selected{/if}>否</option>
      <option value='1' {if $aRow.isHuixiu=='1'}selected{/if}>是</option>
      </select>
    </td>
  </tr>

<!--**********************by liu 2013.7.4*****************************-->
  <tr>
    <td>装/出笼</td>
    <td>
      <select name='isChulong'>
        <option value='0' {if $aRow.isChulong==='0'}selectec{/if}>装笼</option>
        <option value='1' {if $aRow.isChulong==1}selected{/if}>出笼</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>工号：</td>
    <td><input name="workerCode" type="text" id="workerCode" value="{$aRow.workerCode}"></td>
  </tr>
  <tr>
    <td>实际筒子产量：</td>
    <td><input name="cntTongzi" type="text" id="cntTongzi" value="{if $smarty.get.id==''}{$aRow.Gang.planTongzi}{/if}{$aRow.cntTongzi}">      
      个</td>
  </tr>
  <tr>
    <td>公斤数：</td>
    <td><input name="cntK" type="text" id="cntK" value="{$aRow.cntK}" ></td>
  </tr>
  <!--**********************by liu 2013.7.4*****************************-->
  <tr>
  <td>标记完成：</td>
  <td><input type='checkbox' name="isCom" id='isCom' value='1' onclick='isComplete(this)' {if $aRow.Vat.zclOver}checked{/if} /></td>
  </tr>
  <!--**********************by liu 2013.7.4*****************************-->
  <tr>
    <td colspan="2" align="center"><input name="gangId" type="hidden" id="gangId" value="{$aRow.Gang.id}" />
      <input name="id" type="hidden" id="id" value="{$smarty.get.id}" />
      <input name="danjia" type="hidden" id="danjia" value="{$aRow.danjia}" />
	<input type="submit" name="Submit" id="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
