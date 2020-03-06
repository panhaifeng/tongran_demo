<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/calendar.js"></script>
<title>{$title}</title>
{literal}
<style type="text/css">
.table{text-align:center; font:13px Arial; width:100%; border-bottom:solid 1px black; border-right: solid 1px black; margin-top:8px;}
.table td {border-top:solid 1px black; border-left:solid 1px black;}
.width{ width:20%}
body{ padding:0 10px;}
</style>
{/literal}
</head>

<body>
{if $nav_display != 'none'}{include file="_ContentNav.tpl"}{/if}
{include file="_SearchItem.tpl"}
<table cellspacing="0" cellpadding="2" bordercolor="black"  class="table">
  <tr>
    <td rowspan="2"><b>名&nbsp;&nbsp;称(染料)</b></td>
    <td rowspan="2"><b>单位</b></td>
    <td colspan="3" class="width"><b>上月累计</b></td>
    <td colspan="3" class="width"><b>本月入库</b></td>
    <td colspan="3" class="width"><b>本月出库</b></td>
    <td colspan="3" class="width"><b>本月结存</b></td>
  </tr>
  <tr>
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
  </tr>
  {foreach from=$arr_field_value item=item}
  <tr>
    <td>{$item.Ware.wareName}{$item.Ware.guige}&nbsp;</td>
    <td>{$item.Ware.unit|default:'公斤'}&nbsp;</td>
    <td>{$item.cntInit}&nbsp;</td>
    <td>{$item.danjiaInit}&nbsp;</td>
    <td>{$item.moneyInit}&nbsp;</td>
    <td>{$item.cntRuku}&nbsp;</td>
    <td>{$item.danjiaRuku}&nbsp;</td>
    <td>{$item.moneyRuku}&nbsp;</td>
    <td>{$item.cntChuku}&nbsp;</td>
    <td>{$item.danjiaChuku}&nbsp;</td>
    <td>{$item.moneyChuku}&nbsp;</td>
    <td>{$item.cntKucun}&nbsp;</td>
    <td>{$item.danjiaKucun}&nbsp;</td>
    <td>{$item.moneyKucun}&nbsp;</td>
  </tr>
  {/foreach}
  <tr>
    <td>{$from}~~{$to}</td>
    <td><b>合计</b></td>
    <td>{$heji.cntInit}&nbsp;</td>
    <td>&nbsp;</td>
    <td>{$heji.moneyInit}&nbsp;</td>
    <td>{$heji.cntRuku}&nbsp;</td>
    <td>&nbsp;</td>
    <td>{$heji.moneyRuku}&nbsp;</td>
    <td>{$heji.cntChuku}&nbsp;</td>
    <td>&nbsp;</td>
    <td>{$heji.moneyChuku}&nbsp;</td>
    <td>{$heji.cntKucun}&nbsp;</td>
    <td>&nbsp;</td>
    <td>{$heji.moneyKucun}&nbsp;</td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2"><b>名&nbsp;&nbsp;称(助剂)</b></td>
    <td rowspan="2"><b>单位</b></td>
    <td colspan="3" class="width"><b>上月累计</b></td>
    <td colspan="3" class="width"><b>本月入库</b></td>
    <td colspan="3" class="width"><b>本月出库</b></td>
    <td colspan="3" class="width"><b>本月结存</b></td>
  </tr>
  <tr>
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
  </tr>
  {foreach from=$arr_field_value2 item=item}
  <tr>
    <td>{$item.Ware.wareName}{$item.Ware.guige}&nbsp;</td>
    <td>{$item.Ware.unit|default:'吨'}&nbsp;</td>
    <td>{$item.cntInit}&nbsp;</td>
    <td>{$item.danjiaInit}&nbsp;</td>
    <td>{$item.moneyInit}&nbsp;</td>
    <td>{$item.cntRuku}&nbsp;</td>
    <td>{$item.danjiaRuku}&nbsp;</td>
    <td>{$item.moneyRuku}&nbsp;</td>
    <td>{$item.cntChuku}&nbsp;</td>
    <td>{$item.danjiaChuku}&nbsp;</td>
    <td>{$item.moneyChuku}&nbsp;</td>
    <td>{$item.cntKucun}&nbsp;</td>
    <td>{$item.danjiaKucun}&nbsp;</td>
    <td>{$item.moneyKucun}&nbsp;</td>
  </tr>
  {/foreach}
  <tr>
    <td>{$from}~~{$to}</td>
    <td><b>合计</b></td>
    <td>{$heji2.cntInit}&nbsp;</td>
    <td>&nbsp;</td>
    <td>{$heji2.moneyInit}&nbsp;</td>
    <td>{$heji2.cntRuku}&nbsp;</td>
    <td>&nbsp;</td>
    <td>{$heji2.moneyRuku}&nbsp;</td>
    <td>{$heji2.cntChuku}&nbsp;</td>
    <td>&nbsp;</td>
    <td>{$heji2.moneyChuku}&nbsp;</td>
    <td>{$heji2.cntKucun}&nbsp;</td>
    <td>&nbsp;</td>
    <td>{$heji2.moneyKucun}&nbsp;</td>
  </tr>
</table>
</body>
</html>
