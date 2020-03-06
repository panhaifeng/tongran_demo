<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>染色产量登记</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.query.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Script/CheckForm.js"></script>
{literal}
<script language="javascript">
var newRow;
var table;

$(function(){
  table = document.getElementById('table_moreinfo1');
  var tr = table.rows[table.rows.length-1];
  newRow = tr.cloneNode(true);

  setNum();
});

function addRow() { 
  for (var i=0;i<5;i++) {
    // document.getElementById("table_moreinfo1").appendChild(newRow.cloneNode(true));
    table.childNodes[0].appendChild(newRow.cloneNode(true));
  } 
  setNum();
}

// 设置序号
function setNum(){
  var num = $('span[name="num[]"]');
  for (var i = 0; i < num.length; i++) {
        var xh = parseFloat(i)+1;
        num[i].innerText = xh;
  };
}

function getTongzi(){
	var biaoji=document.getElementById("biaoji").checked;
	if(biaoji){//如标记完成，则将计划筒子数赋给筒子数
		var planTongzi=document.getElementById("planTongzi").value;
		var cntK=document.getElementById("cntPlanTouliao").value;
		document.getElementById("cntTongzi").value=planTongzi;
		document.getElementById("cntK").value=cntK;
	}
}
function getCnt(obj){
	var cntPlanTouliao=document.getElementById('cntPlanTouliao').value;
	var id=document.getElementById('id').value;
	var gangId=document.getElementById('gangId').value;
	var url="?controller=Chejian_Ranse&action=GetCntByGangId";
	var param={gangId:gangId,id:id};
	$.getJSON(url,param,function(json){
		if(!json)return false;
		if(parseFloat(json.markTwice)==1&&parseFloat(json.fensanOver)<2)var cnt=parseFloat(cntPlanTouliao)*2;
		else var cnt=parseFloat(cntPlanTouliao)*2;
		if(parseFloat(obj.value)+parseFloat(json.cntK)>cnt){
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
	}
  $("#Submit").attr('disabled',true);
	return true;
}
</script>
{/literal}
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChanliang'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
  <legend>染色车间染出产量登记</legend>
  <div align="center">
    <table width="80%">
      <tr>
        <td width="90">逻辑缸号：</td>
        <td>{$aRow.Gang.vatNum}</td>
        <td>客户：</td>
        <td>{$aRow.Client.compName}</td>
      </tr>
      <tr>
        <td>纱支规格：</td>
        <td>{$aRow.Ware.wareName} {$aRow.Ware.guige}</td>
        <td>颜色：</td>
        <td>{$aRow.Gang.OrdWare.color}</td>
      </tr>
      <tr>
        <td>计划投料：</td>
        <td>{$aRow.Gang.cntPlanTouliao}
          <input name="cntPlanTouliao" type="hidden" id="cntPlanTouliao" value="{$aRow.Gang.cntPlanTouliao}"></td>
        <td>计划筒子数：</td>
        <td>{$aRow.Gang.planTongzi}<input type="hidden" id="planTongzi" name="planTongzi" value="{$aRow.Gang.planTongzi}"></td>
      </tr>
      <tr>
        <td>定重：</td>
        <td>{$aRow.Gang.unitKg}</td>
        <td>产量类别：</td>
        <td><select name="chanliangKind" id="chanliangKind">
          <option value="0">正常</option>
          <option value="1" {if $aRow.chanliangKind==1}selected{/if}>回修</option>
          <option value="2" {if $aRow.chanliangKind==2}selected{/if}>加料</option>
        </select>    </td>
      </tr>
      <tr>
        <td>班次：</td>
        <td><select name="banci" id="banci">
          <option value="">选择</option>
          <option value="甲" {if $aRow.banci=='甲'}selected{/if}>甲</option>
          <option value="乙" {if $aRow.banci=='乙'}selected{/if}>乙</option>
        </select>    
        </td>
        <td>染色工号：</td>
        <td><input name="workerCode" type="text" id="workerCode" value="{$aRow.workerCode}"></td>
      </tr>
      <tr>
        <td>实际筒子产量：</td>
        <td><input name="cntTongzi" type="text" id="cntTongzi" value="{$aRow.cntTongzi}">
          个</td>
        <td>公斤数：</td>
        <td><input name="cntK" type="text" id="cntK" value="{$aRow.cntK}" ></td> <!--onChange="getCnt(this)"-->
      </tr>

      <tr>
        

      </tr>
      <tr>
        <td>标记完成：</td>
        <td><input type="checkbox" name="biaoji" id="biaoji" value='1' {if $aRow.Vat.rsOver}checked{/if} onClick="getTongzi()"></td>
        <td></td>
        <td></td>
      </tr>
    
    </table>
  </div>
</fieldset>

{if $showRsGx}
 <fieldset>
  <legend>染色工序产量(*为必填)</legend>
  <div align="center">
    <table class="tableHaveBorder" width="80%"  id="table_moreinfo1">
      <tr class="th">
        <td align="center" width="20%">序号</td> 
        <td align="center">类型<span>*</span></td>
        <td align="center">单价<span>*</span></td>
      </tr>

      {foreach from=$aRow.rsGxCl item=item}
      <tr>
        <td align="center" width="20%">
          <input name="rs2gxId[]" type="hidden" id="rs2gxId[]" value="{$item.id}">
          <!-- <input name="danjia[]" type="hidden" id="danjia[]" value="{$item.danjia}" /> -->
          <input name="money[]" type="hidden" id="money[]" value="{$item.money}" />

          <span name="num[]" style="width="></span>
        </td>
       <td align="center">
          <select name="gxId[]" id="gxId[]" warning='请选择'>
                {webcontrol type='TmisOptions' model='JiChu_RsPrice' selected=$item.gxId}
          </select>
        </td>
        <td align="center">
          <!-- <input name="cnt[]" type="text" id='cnt[]' value="{$item.cntK}" size="15"> -->
          <input name="danjia[]" type="text" id="danjia[]" value="{$item.danjia}" />
        </td>
       
      </tr>
     
      {/foreach}
      
      </table>
    </div>
    <div style="text-align:right;margin-right:10%;">
      <input type="button" name="button" id="button" value="+5行" onClick="addRow()">
    </div>
  </fieldset>
  {/if}
  <div id="footButton1">
        <div colspan="2" align="center">
          <input name="gangId" type="hidden" id="gangId" value="{$aRow.Gang.id}" />
          <input name="id" type="hidden" id="id" value="{$smarty.get.id}" />
          <input type="submit" name="Submit" id="Submit" value="提交">
        </div>
  </div>
</form>
</body>
</html>
