<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统基本设置</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit100.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/lodop/LodopFuncs.js"></script>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
	<param name="CompanyName" value="常州易奇信息科技有限公司">
	<param name="License" value="664717080837475919278901905623"> 
	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="install_lodop.exe"></embed>
</object> 
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/Print.css" type="text/css" rel="stylesheet" />

{literal}
<script language="javascript">
function print_onclick(){
	CreatePage();	
	//LODOP.PRINT_DESIGN();return false;//打印设计
	LODOP.PREVIEW();//打印预览
}
var LODOP;
function CreatePage(){	
		LODOP=getLodop(document.getElementById('LODOP'),document.getElementById('LODOP_EM')); 
		
		LODOP.PRINT_INITA(0,5,522,333,"");
		//LODOP.SET_PRINT_PAGESIZE(1,700,750,"测试打印");
		LODOP.ADD_PRINT_LINE(158,8,159,508,0,1);
}
$(function(){			
	$('#form1').submit(function(){
	  //判断是否至少一个checkbox被选中	  
	  var chk = $('[name="isPrint[]"]');
	  for(var i=0;chk[i];i++) {
		  if(chk[i].checked) return true;
	  }
	  alert('至少选择一个打印项目');
	  return false;
	});    
});
</script>
<style>
.table100 td{height:30px;}
body{
	font-size:14px;
	}
</style>
{/literal}
</head>

<body>
<div id="container">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SavePrint2'}" method="post">	
<div id="nav" style="font-size:20px">流转卡打印配置工具<font color='red'>(此工具会影响系统的报表功能，非系统管理人员慎用)</font></div>

 <fieldset>
  <legend>流转卡偏移量设置</legend>
<table class="tableHaveBorder table100" style="width:700px">
          <tr>
           <input name="setName[]" type="hidden" id="setName[]" value="offsetXY">
         <input name="id[]" type="hidden" id="id[]" value="{$row.offsetXY.id}">
            <td width="86" colspan="1" class="tdTitle" >偏移量设置：
            <td width="70" align="center" >左/右偏移量</td>
            <td width="200" align="center" ><input name="cntLeft[]" type="text" id="left" value="{$row.py.left|default:0}"></td>
			<td width="84" nowrap>上/下偏移：</td>
			<td width="168" nowrap>
			  <input name="cntTop[]" type="text" id="top" value="{$row.py.top}">
			</td>
			<td width="64" nowrap>&nbsp;</td>
          </tr>
      </table>
</fieldset>	

<fieldset>
  <legend>流转卡位置设置</legend>
  <table class="tableHaveBorder table100" style="width:700px">
          <tr align="center">
            <td width="145" colspan="1" class="tdTitle" style="text-align:center;">名称            </td>
			<td width="197" class="tdTitle" style="text-align:center;">上边距</td>
			<td width="219" class="tdTitle" style="text-align:center;"><span class="tdTitle" style="text-align:center;">左边距</span></td>
			<td width="119" class="tdTitle" style="text-align:center;">是否打印</td>
        </tr>
        <tr align="center">
            <td>日期
              <input name="setName[]" type="hidden" id="setName[]" value="printDate">
            <input name="id[]" type="hidden" id="id[]" value="{$row.printDate.id}"></td>
            <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.printDate.cntTop}"></td>
            <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.printDate.cntLeft}"></td>
            <td><input name='isPrint[]' type='checkbox' value="printDate" {if $row.printDate.isPrint} checked {/if}/></td>
        </tr>
        <tr align="center">
          <td>缸号
            <input name="setName[]" type="hidden" id="setName[]" value="vatNum">
          <input name="id[]" type="hidden" id="id[]" value="{$row.vatNum.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.vatNum.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.vatNum.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="vatNum"{if $row.vatNum.isPrint} checked {/if} /></td>
        </tr>
        <tr align="center">
          <td>加工单位
            <input name="setName[]" type="hidden" id="setName[]" value="compName">
          <input name="id[]" type="hidden" id="id[]" value="{$row.compName.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.compName.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.compName.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="compName" {if $row.compName.isPrint} checked {/if} /></td>
        </tr>
        <tr align="center">
          <td>数量
            <input name="setName[]" type="hidden" id="setName[]" value="cntPlanTouliao">
          <input name="id[]" type="hidden" id="id[]" value="{$row.cntPlanTouliao.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.cntPlanTouliao.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.cntPlanTouliao.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="cntPlanTouliao" {if $row.cntPlanTouliao.isPrint} checked {/if} /></td>
        </tr>
        <tr align="center">
          <td>产地
            <input name="setName[]" type="hidden" id="setName[]" value="chandi">
          <input name="id[]" type="hidden" id="id[]" value="{$row.chandi.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.chandi.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.chandi.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="chandi" {if $row.chandi.isPrint} checked {/if} /></td>
        </tr>
        <tr align="center">
          <td>纱支规格
            <input name="setName[]" type="hidden" id="setName[]" value="guige">
          <input name="id[]" type="hidden" id="id[]" value="{$row.guige.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.guige.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.guige.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="guige" {if $row.guige.isPrint} checked {/if} /></td>
        </tr>
        <tr align="center">
          <td>计划筒子数
            <input name="setName[]" type="hidden" id="setName[]" value="planTongzi">
          <input name="id[]" type="hidden" id="id[]" value="{$row.planTongzi.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.planTongzi.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.planTongzi.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="planTongzi" {if $row.planTongzi.isPrint} checked {/if} /></td>
        </tr>
        <tr align="center">
            <td>颜色
              <input name="setName[]" type="hidden" id="setName[]" value="color">
            <input name="id[]" type="hidden" id="id[]" value="{$row.color.id}"></td>
            <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.color.cntTop}"></td>
            <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.color.cntLeft}"></td>
            <td><input name='isPrint[]' type='checkbox' value="color" {if $row.color.isPrint} checked {/if}  /></td>
        </tr>
        <tr align="center">
          <td>色号
            <input name="setName[]" type="hidden" id="setName[]" value="colorNum">
          <input name="id[]" type="hidden" id="id[]" value="{$row.colorNum.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.colorNum.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.colorNum.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="colorNum" {if $row.colorNum.isPrint} checked {/if} /></td>
        </tr>
        <tr align="center">
          <td>物理缸号
            <input name="setName[]" type="hidden" id="setName[]" value="vatCode">
          <input name="id[]" type="hidden" id="id[]" value="{$row.vatCode.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.vatCode.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.vatCode.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="vatCode" {if $row.vatCode.isPrint} checked {/if}  /></td>
        </tr>
        <tr align="center">
          <td>净重
            <input name="setName[]" type="hidden" id="setName[]" value="unitKg">
          <input name="id[]" type="hidden" id="id[]" value="{$row.unitKg.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.unitKg.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.unitKg.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="unitKg" {if $row.unitKg.isPrint} checked {/if}  /></td>
        </tr>
        <tr align="center">
          <td>回倒要求
            <input name="setName[]" type="hidden" id="setName[]" value="huidao">
          <input name="id[]" type="hidden" id="id[]" value="{$row.huidao.id}"></td>
          <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.huidao.cntTop}"></td>
          <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.huidao.cntLeft}"></td>
          <td><input name='isPrint[]' type='checkbox' value="huidao" {if $row.huidao.isPrint} checked {/if}  /></td>
        </tr>
        <tr align="center">
            <td>烘干要求
              <input name="setName[]" type="hidden" id="setName[]" value="honggan">
            <input name="id[]" type="hidden" id="id[]" value="{$row.honggan.id}"></td>
            <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.honggan.cntTop}"></td>
            <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.honggan.cntLeft}"></td>
            <td><input name='isPrint[]' type='checkbox' value="honggan" {if $row.honggan.isPrint} checked {/if} /></td>
        </tr>
        <tr align="center">
            <td>订单号
              <input name="setName[]" type="hidden" id="setName[]" value="orderCode">
            <input name="id[]" type="hidden" id="id[]" value="{$row.orderCode.id}"></td>
            <td><input name="cntTop[]" type="text" id="cntTop[]" value="{$row.orderCode.cntTop}"></td>
            <td><input name="cntLeft[]" type="text" id="cntLeft[]" value="{$row.orderCode.cntLeft}"></td>
            <td><input name='isPrint[]' type='checkbox' value="orderCode" {if $row.orderCode.isPrint} checked {/if} /></td>
        </tr>
      </table>
  <p>&nbsp;</p>
</fieldset>	
<div id="footButton" style="width:300px;">
	<ul>
		<li><input type="submit" id="submit" name="submit" value='保存'></li>
	</ul>
</div>

</form>
</div>
</body></html>
