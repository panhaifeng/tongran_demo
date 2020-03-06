<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>{$title}</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>

<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css">
{literal}
<script language="javascript">
function getCnt(obj){
	var cntK=document.getElementsByName('cntK[]');
	var cntPlanTouliao=document.getElementsByName('cntPlanTouliao[]');
	var pos=-1;
	for(var i=0;cntK[i];i++){
		if(cntK[i]==obj){
			pos=i;
		}
	}
	if(pos==-1)return false;
	var gangId=document.getElementsByName('gangId[]');
	var url="?controller=Chejian_Hongsha&action=GetCntByGangId";
	var param={gangId:gangId[pos].value};
	$.getJSON(url,param,function(json){
		//dump(json);return false;
		if(!json)return false;
		if(parseFloat(cntK[pos].value)+parseFloat(json.cntK)>parseFloat(cntPlanTouliao[pos].value)){
			alert('公斤数大于计划投料数，请确认后再输入！');
			cntK[pos].value='';
		}
	});
}
</script>
{/literal}
</head>


<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChanliangList'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
<legend>烘纱车间烘出产量登记

</legend>
<div align="center">
<table width="100%" border="1">
                <tr class="th">
                  <td align="center">逻辑缸号：</td>
                  <td align="center">客户：</td>
                  <td align="center">纱支规格</td>
                  <td align="center">颜色</td>
                  <td align="center">缸号</td>
                  <td align="center">计划投料：</td>
                  <td align="center">计划筒子数：</td>
                  <td align="center">定重：</td>
                  <td align="center">染色工号：</td>
                  <td align="center">实际筒子产量：(个)</td>
                  <td align="center">公斤数</td>
                  <td align="center">保存</td>
                </tr>
				{foreach name=outer key=key item=item from=$aRow}
                <tr>
                  <td align="center">{$item.Gang.vatNum}<input name="gangId[]" type="hidden" id="gangId[]" value="{$item.Gang.id}" /></td>
                  <td align="center">{$item.Client.compName}</td>
                  <td align="center">{$item.Ware.wareName} {$item.Ware.guige}</td>
                  <td align="center">{$item.Gang.OrdWare.color}</td>
                  <td align="center">{$item.vatNum}</td>
                  <td align="center">{$item.Gang.cntPlanTouliao}</td>
                  <td align="center">{$item.Gang.planTongzi}</td>
                  <td align="center">{$item.Gang.unitKg}</td>
                  <td align="center"><input name="workerCode[]" type="text" id="workerCode[]" value="{$item.workerCode}" size="10"></td>
                  <td align="center"><input name="cntTongzi[]" type="text" id="cntTongzi[]" value="{$item.Gang.planTongzi}" size="10"></td>
                  <td align="center"><input name="cntK[]" type="text" id="cntK[]" value="{$item.Gang.cntPlanTouliao}" size="10" onChange="getCnt(this)">
                  <input name="cntPlanTouliao[]" type="hidden" id="cntPlanTouliao[]" value="{$item.Gang.cntPlanTouliao}"></td>
                  <td align="center"><input name="check[{$key}]" type="checkbox" id="check[{$key}]" value="{$key}" checked ></td>
                </tr>
                {/foreach}
              </table>
      <input name="id" type="hidden" id="id" value="{$smarty.get.id}" />
	<input type="submit" name="Submit" value="提交"></td>
</div>
</fieldset>
</form>
</body>
</html>
