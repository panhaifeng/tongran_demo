<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>成品入库登记</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.query.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
function getCnt(obj){
	var cntPlanTouliao=document.getElementById('cntPlanTouliao').value;
	var id=document.getElementById('id').value;
	var gangId=document.getElementById('gangId').value;
	var url="?controller=Chejian_Huidao&action=GetCntByGangId";
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
//标记完成后，取得公斤数
function getTongzi(){
  var biaoji=document.getElementById("biaoji").checked;
  if(biaoji){//如标记完成，则将计划筒子数赋给筒子数 
    var planTongzi=document.getElementById("planTongzi").value;
    var planTongzi1=document.getElementById("planTongzi1").value;
    var cntK=document.getElementById("cntPlanTouliao").value;
    var cntK1=document.getElementById("cntPlanTouliao1").value;
    document.getElementById("cntTongzi").value=parseInt(planTongzi||0)-parseInt(planTongzi1||0);
    document.getElementById("cntK").value=(parseFloat(cntK||0)-parseFloat(cntK1||0)).toFixed(2);
  }
}
function ChangeCarId(obj){
  var id  = document.getElementById('carId').value;
  var people = document.getElementById('people');
  var url="?controller=JiChu_Vehicle&action=GetPeopleName";
  var param={id:id};
  $.getJSON(url,param,function(json){
    if(!json)return false;
    $("#people").empty();
    $("#people").prepend("<option value=''>请选择</option>");
    for(var i=0;i<json.length;i++){
      vals="<option value="+json[i]+">"+json[i]+"</option>";
      $(vals).appendTo("#people");
    }
  });
}
</script>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SaveAdd'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
<legend>成品入库登记</legend>
<div align="center">
<table width="80%">
  <tr>
    <td>客户：</td>
    <td>{$aRow.clientName}</td>
  </tr>
  <tr>
    <td>订单号：</td>
    <td>{$aRow.orderCode}</td>
  </tr>
  <tr>
    <td>纱支规格：</td>
    <td>{$aRow.wareName} {$aRow.guige}</td>
  </tr>
  <tr>
    <td>颜色：</td>
    <td>{$aRow.OrdWare.color}</td>
  </tr>
  <tr>
    <td width="90">逻辑缸号：</td>
    <td>{$aRow.vatNum}</td>
  </tr>
  <tr>
    <td>色号：</td>
    <td>{$aRow.OrdWare.colorNum}</td>
  </tr>
  <tr>
    <td>计划投料：</td>
    <td>
      {$aRow.cntPlanTouliao}
    </td>
  </tr>
  <tr>
    <td>计划筒子数：</td>
      <td>{$aRow.planTongzi}
    </td>
  </tr>
  <tr>
    <td>毛重(Kg)：</td>
    <td><input name="maoKg" type="text" id="maoKg" value="{$aRow.maoKg}" ><span style="color:red;">*</span></td>
  </tr>  
  <tr>
    <td>净重：</td>
    <td><input name="jingKg" type="text" id="jingKg" value="{$aRow.jingKg}" ><span style="color:red;">*</span></td>
  </tr>
  <tr>
    <td>筒子数(个)：</td>
    <td><input name="cntTongzi" type="text" id="cntTongzi" value="{$aRow.cntTongzi}"><span style="color:red;">*</span></td>
  </tr>
  <tr>
    <td>件数：</td>
    <td><input name="cntJian" type="text" id="cntJian" value="{$aRow.cntJian}" ><span style="color:red;">*</span></td>
  </tr>     
  <tr>
    <td>标记完成：</td>
    <td><input type="checkbox" name="isCpRuku" id="isCpRuku" value='1' {if $aRow.Vat.hdOver}checked{/if} onClick="getTongzi()"></td>
  </tr>
  {if $smarty.get.id==0}{/if}
  <tr>
    <td colspan="2" align="center"><input name="gangId" type="hidden" id="gangId" value="{$aRow.id}" />
      <input name="id" type="hidden" id="id" value="{$smarty.get.id}" />
	<input type="submit" name="Submit" id='Submit' value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
