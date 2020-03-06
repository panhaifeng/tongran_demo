<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/calendar.js"></script>
<title>{$title}</title>
{literal}
<style type="text/css">
table { border-collapse: collapse;}
td {white-space: nowrap;}
.table{text-align:center; font:13px Arial; width:100%; border-bottom:solid 1px black; border-right: solid 1px black; margin-top:8px;}
.table td {border-top:solid 1px black; border-left:solid 1px black;}
.width{ width:20%}
body{ padding:0 10px;}
</style>
{/literal}
</head>

<body>
{include file="_SearchItem.tpl"}
<table cellspacing="0" cellpadding="2" bordercolor="black"  class="table">
  <tr>
    <td rowspan="2"><b>名&nbsp;&nbsp;称(染料)</b></td>
    <td rowspan="2">规格</td>
    <td rowspan="2"><b>单位</b></td>
    <td colspan="3" class="width"><b>上月累计</b></td>
    <td colspan="3" class="width"><b>本月入库</b></td>
    <td colspan="3" class="width"><b>本月出库</b></td>
    <td colspan="3" class="width"><b>本月调库</b></td>
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
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
  </tr>
  {foreach from=$arr_field_value item=item}
  <tr>
    <td>{$item.wareName}{$item.Ware.guige}&nbsp;</td>
    <td>{$item.guige}</td>
    <td>{$item.unit|default:'克'}&nbsp;</td>
    <td>{$item.cntInit}&nbsp;</td>
    <td>{$item.danjiaInit}&nbsp;</td>
    <td>{$item.moneyInit}&nbsp;</td>
    <td>{$item.cntRuku}&nbsp;</td>
    <td>{$item.danjiaRuku}&nbsp;</td>
    <td>{$item.moneyRuku}&nbsp;</td>
    <td>{$item.cntChuku}&nbsp;</td>
    <td>{$item.danjiaChuku}&nbsp;</td>
    <td>{$item.moneyChuku}&nbsp;</td>
    <td>{$item.cntTiao}</td>
    <td>{$item.danjiaTiao}</td>
    <td>{$item.moneyTiao}</td>
    <td>{$item.cntKucun}&nbsp;</td>
    <td>{$item.danjiaKucun}&nbsp;</td>
    <td>{$item.moneyKucun}&nbsp;</td>
  </tr>
  {/foreach} 
  
</table>
{$page_info}
</body>
</html>
