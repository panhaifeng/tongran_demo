<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出库明细</title>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript">
{literal}
function getPlan(e) {
	var url='Index.php?controller=Chengpin_Dye_Cpck&action=getJsonByVatNum';
	var params = {vatNum:e.value};
	$.getJSON(url,params,function(json){
		document.getElementById('spanTl').innerHTML=json.cntPlanTouliao;
		document.getElementById('spanUnit').innerHTML=json.unitKg;
		document.getElementById('spanTz').innerHTML=1;
		document.getElementById('spanVat').innerHTML=json.vatId;		
	});
}
function changeJk(obj){
  var paymentWay = document.getElementById('paymentWay');
  var zhelv = document.getElementById('zhelv');
  var jingKgZ = document.getElementById('jingKgZ');
  if (paymentWay.value==2) {//当为结算类型为折率时 进行带入折率运算 jingzhong/（1-zhelv）
    jingKgZ.value = (obj.value/(1-zhelv.value)).toFixed(2)*1;
  }else{
    // 因客户需求 所有结算方式都进行算法 by zcc 2017年11月10日 14:13:07
    jingKgZ.value = (obj.value/(1-zhelv.value)).toFixed(2)*1;
  }
  
}
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>     
<legend>出库明细</legend>
<table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000">
  <tr>
    <th width="29%" height="30" bgcolor="#FFFFFF" scope="row">日期：</th>
    <td width="71%" height="30" bgcolor="#FFFFFF"><input name="dateCpck" type="text" id="dateCpck"  value="{$arr_field_value.dateCpck|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">缸号：</th>
    <td height="30" bgcolor="#FFFFFF">
      <input name="vatNum" type="text" id="vatNum" value="{$arr_field_value.Plan.vatNum}" onBlur="getPlan(this)">
    </td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">投料：</th>
    <td height="30" bgcolor="#FFFFFF"><span id='spanTl'>{$arr_field_value.Plan.cntPlanTouliao
      }</span></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">计划定重：</th>
    <td height="30" bgcolor="#FFFFFF"><span id='spanUnit'>{$arr_field_value.Plan.unitKg}</span></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">筒子数：</th>
    <td height="30" bgcolor="#FFFFFF"><span id='spanTz'>{if  $arr_field_value.Plan.unitKg>0}{$arr_field_value.Plan.cntPlanTouliao/$arr_field_value.Plan.unitKg|string_format:"%.0f"}{/if}</span></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">物理缸号：</th>
    <td height="30" bgcolor="#FFFFFF"><span id='spanVat'>{$arr_field_value.Plan.vatId}</span></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">本次发货：</th>
    <td height="30" bgcolor="#FFFFFF"><input name="cntChuku" type="text" id="cntChuku" value="{$arr_field_value.cntChuku}"></td>
  </tr>
    <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">毛重：</th>
    <td height="30" bgcolor="#FFFFFF"><input name="maoKg" type="text" id="maoKg" value="{$arr_field_value.maoKg}"></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">净重：</th>
    <td height="30" bgcolor="#FFFFFF"><input name="jingKg" type="text" id="jingKg" value="{$arr_field_value.jingKg}" onchange="changeJk(this)"></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">计价重量：</th>
    <td height="30" bgcolor="#FFFFFF"><input name="jingKgZ" type="text" id="jingKgZ" value="{$arr_field_value.jingKgZ}"></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">件数：</th>
    <td height="30" bgcolor="#FFFFFF"><input name="cntJian" type="text" id="cntJian" value="{$arr_field_value.cntJian}"></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">筒子数：</th>
    <td height="30" bgcolor="#FFFFFF"><input name="cntTongzi" type="text" id="cntTongzi" value="{$arr_field_value.cntTongzi}"></td>
  </tr>
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">备注：</th>
    <td height="30" bgcolor="#FFFFFF"><input name="memo" type="text" id="memo" value="{$arr_field_value.memo}"></td>
  </tr>
  
  <tr>
    <th height="30" bgcolor="#FFFFFF" scope="row">&nbsp;</th>
    <td height="30" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="提交">
      <input type="reset" name="Submit2" value="重置">
      <input name="id" type="hidden" id="id" value="{$arr_field_value.id}">
      <input name="zhelv" type="hidden" id="zhelv" value="{$zhelv}">
      <input name="paymentWay" type="hidden" id="paymentWay" value="{$paymentWay}">
    </td>
  </tr>
</table>

</fieldset>
</form>
</body>
</html>
