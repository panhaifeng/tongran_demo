<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{literal}
<style type="text/css">
td {FONT-FAMILY:"宋体,Arial";FONT-SIZE:14px;COLOR:#000;}
</style> 
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=CangKu_ChuKu action='PrintLingliao'}" method="post" onsubmit="CheckForm()">
<table width="100%" style="BORDER-COLLAPSE: collapse" bordercolor="#000000" border="2" align="center" cellpadding="2" cellspacing="0">
	<tr><td colspan="10" align="center" style="font-size:22px"><b>新增缸打印</b></td></tr>
  <tr><td colspan="10"><b>计划已排完，发现如下新产生的缸，请打印！</b></td></tr>
  <tr>
    <td>领纱</td>
    <td>缸号</td>
    <td>客户</td>
    <td>单号</td>
    <td>颜色</td>
    <td>纱支</td>
    <td>投料</td>
    <td>定重</td>
    <td>筒子数</td>
    <td>打印</td>
  </tr>
  {foreach from=$arr_field_value item=item} 
  <tr>
    <td><input type="checkbox" name="lingliao[]" id="lingliao[]" value="{$item.id}" /></td>
    <td>{$item.vatNum}</td>
    <td>{$item.compName}</td>
    <td>{$item.orderCode}</td>
    <td>{$item.OrdWare.color}</td>
    <td>{$item.guige}</td>
    <td>{$item.cntPlanTouliao}</td>
    <td>{$item.unitKg}</td>
    <td>{$item.planTongzi}</td>
    <td>{$item.print}</td>
  </tr>
  {/foreach} 
  <tr>
  <td colspan="10" align="center">
  <input type="submit" id="buttom" name="buttom" value="打印坯纱请领单" />
    <input type="button" id="Back" name="Back" value='返回订单编辑界面' onClick="window.location='Index.php?controller=Trade_Dye_Order&action=Edit&id={$arr_field_value[0].OrdWare.orderId}&page={$page}'">
  <input type="button" id="Back" name="Back" value='返回生产计划' onClick="window.location='Index.php?controller=Trade_Dye_Order&action=right'">
  </td>
  </tr>
</table>
</form>
</body>
</html>
