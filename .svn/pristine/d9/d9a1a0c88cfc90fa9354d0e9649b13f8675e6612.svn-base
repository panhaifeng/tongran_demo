<html>
<head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="Resource/Css/Thickbox.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/ajax.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/thickbox/thickbox.js"></script>
{$other_script}
{literal}
<script language="javascript">


function popMenu(e) {
	tMenu(e,'Index.php?controller=Jichu_Ware&action=tmismenu',0,false,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
		$('#spanDanwei')[0].innerHTML = arr[2]?arr[2]:'kg';
	});
}

function popYlMenu(e) {
	tMenu(e,'Index.php?controller=Jichu_Ware&action=tmismenu',5,false,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
		$('#spanDanwei')[0].innerHTML = arr[2]?arr[2]:'kg';
	});
}
</script>


<style type="text/css">
td{font-family:Arial, Helvetica, sans-serif; font-size:14px;}
.tableHaveBorder {border-collapse:collapse; border:1px solid #000; background-color:#FFFFFF;}
.tableHaveBorder td {border-bottom:1px solid #000; border-right:1px solid #000; padding:2px;}
.th{background-color:#cccccc}
.tdTitle{background-color:#cccccc;}
.spanColor{width:10px; background-color:#C96; font-size:12px; font-family:Arial, Helvetica, sans-serif}
</style>

{/literal}

</head>
<body style="margin-left:8px; margin-right:8px;">
<div id='divPanel' style="margin:0px; padding:0px;">
<table align="center">
<tr>
  <td align="center"><b style="font-size:18px">订单跟踪信息</b></td></tr>

<tr>
	<td align="center">
   <table width="800" cellpadding="0" cellspacing="0"class="tableHaveBorder">
  {foreach from=$arr_field_value1 item=field_value}
    <tr>
      <td class="tdTitle">客户：</td>
      <td>{$field_value.Client.compName}</td>
      <td class="tdTitle">合同编码：</td>
	  <td>{$field_value.orderCode}</td>
      
	  <td class="tdTitle">签约日期：</td>
      <td>{$field_value.dateOrder}</td>
      <td class="tdTitle">业务员：</td>
      <td>{$field_value.Trader.employName}</td>
      </tr>
  {/foreach}
  </table></td></tr>

<tr>
  <td>
 <table width="800" cellpadding="0" cellspacing="0"class="tableHaveBorder">
    <tr bgcolor="#cccccc">
      <td colspan="4" rowspan="2" align="center">缸号信息</td>
      <td colspan="6" align="center">生产信息</td>
      </tr>
    <tr bgcolor="#cccccc" align="center">
      <td>项目</td>
      <td>数量</td>
      <td>时间</td>
      <td>项目</td>
      <td>数量</td>
      <td>时间</td>
      </tr>
    {foreach from=$arr_field_value item=item key=key}  
    <tr bgcolor="#6699CC">
      <td colspan="10">{$key}&nbsp;计划投料总数：{$item[0].Sum.cntPlanTouliao}&nbsp;计划筒子总数：{$item[0].Sum.planTongzi}&nbsp;坯纱领料总数：{$item[0].Sum.ll}&nbsp;</td>
    </tr>
    {foreach from=$item item=item1}
    
    <tr>
      <td colspan="2" class="tdTitle">缸号：{$item1.vatNum}</td>
      <td width="80">排缸日期</td>
      <td>{$item1.planDate}</td>
      <td width="80" class="tdTitle"><span class="spanColor">1</span>松筒数量</td>
      <td>{$item1.st}</td>
      <td>{$item1.stTimeInput}</td>
      <td width="80" class="tdTitle"><span class="spanColor">2</span>装出笼</td>
      <td>{$item1.zcl}</td>
      <td>{$item1.zclTimeInput}</td>
    </tr>
    <tr>
      <td width="80">计划投料</td>
      <td>{$item1.cntPlanTouliao}</td>
      <td width="80">物理缸</td>
      <td>{$item1.vatCode}</td>
      <td width="80" class="tdTitle"><span class="spanColor">3</span>高台染色</td>
      <td>{$item1.rs}</td>
      <td>{$item1.rsTimeInput}</td>
      <td width="80" class="tdTitle"><span class="spanColor">4</span>烘纱</td>
      <td>{$item1.hs}</td>
      <td>{$item1.hsTimeInput}</td>
    </tr>
    <tr>
      <td width="80">计划筒数</td>
      <td>{$item1.planTongzi}</td>
      <td width="80">工艺</td>
      <td>{$item1.chufang}</td>
      <td width="80" class="tdTitle"><span class="spanColor">5</span>回倒</td>
      <td>{$item1.hd}</td>
      <td>{$item1.hdTimeInput}</td>
      <td width="80" class="tdTitle"><span class="spanColor">6</span>打包</td>
      <td>{$item1.db}</td>
      <td>{$item1.dbTimeInput}</td>
    </tr>
    <tr>
      <td>计划定重</td>
      <td>{$item1.unitKg}</td>
      <td>制成率</td>
      <td>{$item1.sunhao}</td>
      <td class="tdTitle"><span class="spanColor">7</span>入库</td>
      <td>{$item1.rk}</td>
      <td>&nbsp;</td>
      <td class="tdTitle"><span class="spanColor">8</span>出库</td>
      <td>{$item1.ck}</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="10"  style="height:3px"></td>
    </tr>
    
     {/foreach}
  {/foreach}
  </table></td></tr>
  
</table>
</div>
</body>
</html>
