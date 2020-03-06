<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>松筒产量登记</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.query.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<!-- <script language="javascript" src="Script/CheckForm.js"></script> -->
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
function getCnt(obj){
	var cntPlanTouliao=document.getElementById('cntPlanTouliao').value;
	var id=document.getElementById('id').value;
	var gangId=document.getElementById('gangId').value;
	var url="?controller=Chejian_Songtong&action=GetCntByGangId";
	var param={gangId:gangId,id:id};
	$.getJSON(url,param,function(json){
		//dump(json);return false;
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
function myCheck(){
	var cntK=document.getElementById('cntK').value;
	//alert(cntK);return false;
	if(cntK==''||parseFloat(cntK)==0){
		alert('请录入公斤数！');
		return false;
	}
  if($('#banci').val()=='') {
    alert('请选择班次');
    return false;
  }
  $("#Submit").attr("disabled",true);
	return true;
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
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChanliang'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
<legend>松筒车间产量登记</legend>
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
      <input name="cntPlanTouliao" type="hidden" id="cntPlanTouliao" value="{$aRow.Gang.cntPlanTouliao}">
      <input name="cntPlanTouliao1" type="hidden" id="cntPlanTouliao1" value="{$smarty.get.cntk}">
    </td>
  </tr>
  <tr>
    <td>计划筒子数：</td>
    <td>{$aRow.Gang.planTongzi}
    <input name="planTongzi" type="hidden" id="planTongzi" value="{$aRow.Gang.planTongzi}">
    <input name="planTongzi1" type="hidden" id="planTongzi1" value="{$smarty.get.cntTongzi}">
  </td>
  </tr>
  <tr>
    <td>定重：</td>
    <td>{$aRow.Gang.unitKg}</td>
  </tr>
  <tr>
    <td>净重：</td>
    <td><input name="netWeight" type="text" id="netWeight" value="{$aRow.netWeight}"></td>
  </tr>
  <tr>
    <td>班次：</td>
    <td><select name="banci" id="banci">
      <option value="">选择</option>
      <option value="甲" {if $aRow.banci=='甲'}selected{/if}>甲</option>
      <option value="乙" {if $aRow.banci=='乙'}selected{/if}>乙</option>
    </select>    </td>
  </tr>
  <tr>
    <td>是否回修：</td>
    <td><select name="isHuixiu" id="isHuixiu">      
      <option value="0" {if $aRow.isHuixiu=='0'}selected{/if}>否</option>
      <option value="1" {if $aRow.isHuixiu=='1'}selected{/if}>是</option>
    </select>    </td>
  </tr>
  <tr>
    <td>工号：</td>
    <td><input name="workerCode" type="text" id="workerCode" value="{$aRow.workerCode}"></td>
  </tr>
  <tr>
    <td>实际筒子产量：</td>
    <td><input name="cntTongzi" type="text" id="cntTongzi" value="{$aRow.cntTongzi}">
      个</td>
  </tr>
    <tr>
    <td>公斤数：</td>
    <td><input name="cntK" type="text" id="cntK" value="{$aRow.cntK}" onChange="getCnt(this)"></td>
  </tr>
  <tr>
    <td>车编号和司机：</td>
    <td>
      <select  name ="carId" id="carId" style="width: 150px" onchange="ChangeCarId(this)">
      {webcontrol type='TmisOptions' model='jichu_vehicle' selected=$aRow.carId }
      </select>
      <select name ="people" id="people" style="width: 150px">
        <option value=''>请选择</option>
        {if $people}
          {foreach from=$people item=item}
            <option value='{$item}' {if $item==$aRow.people}selected{/if}>{$item}</option>
          {/foreach}
        {/if}
      </select>
    </td>
  </tr>
  <tr>
    <td>标记完成：</td>
    <td><input type="checkbox" name="biaoji" id="biaoji" value='1' {if $aRow.Vat.stOver}checked{/if} onClick="getTongzi()"></td>
  </tr>
   {if $smarty.get.id==0} {/if}

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
