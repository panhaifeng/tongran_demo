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
.width{ width:12%}
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
    <td colspan="3" class="width"><b>转拨车间</b></td>
    <td colspan="3" class="width"><b>转回仓库</b></td>
    <td colspan="3" class="width"><b>本月领料</b></td>
    <td colspan="3" class="width"><b>本月调库</b></td>
    <td colspan="3" class="width"><b>实际结存</b></td>
    <td colspan="3" class="width"><b>理论结存</b></td>
  </tr>
  <tr>
    <!-- 上月累计 -->
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <!-- 本月入库 -->
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <!-- 转拨车间 -->
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <!-- 转回仓库 -->
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <!-- 本月领料 -->
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <!-- 本月调库 -->
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <!-- 实际结存 -->
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
    <!-- 理论结存 -->
    <td>数量</td>
    <td>单价</td>
    <td>金额</td>
  </tr>
  {foreach from=$arr_field_value item=item}
  <tr>
    <td>{$item.wareName}{$item.Ware.guige}&nbsp;</td>
    <td>{$item.guige}</td>
    <td>{$item.unit|default:'克'}&nbsp;</td>

    <td>{$item.kucunQc}&nbsp;</td>
    <td>{$item.danjiaInit}&nbsp;</td>
    <td>{$item.moneyInit}&nbsp;</td>

    <td>{$item.cntRuku}&nbsp;</td>
    <td>{$item.danjiaRuku}&nbsp;</td>
    <td>{$item.moneyRuku}&nbsp;</td>

    <td>{$item.chejianCnt}&nbsp;</td>
    <td>{$item.danjiaChuku}&nbsp;</td>
    <td>{$item.moneyChuku}&nbsp;</td>

    <td>{$item.fankuCnt}&nbsp;</td>
    <td>{$item.danjiaChuku}&nbsp;</td>
    <td>{$item.moneyChuku}&nbsp;</td>
    
    <td>{$item.chukuCnt}&nbsp;</td>
    <td>{$item.danjiaChuku}&nbsp;</td>
    <td>{$item.moneyChuku}&nbsp;</td>

    <td>{$item.tiaoCnt}</td>
    <td>{$item.danjiaTiao}</td>
    <td>{$item.moneyTiao}</td>

    <td>{$item.kucunSj}&nbsp;</td>
    <td>{$item.danjiaKucun}&nbsp;</td>
    <td>{$item.moneyKucun}&nbsp;</td>

    <td>{$item.kucunL}&nbsp;</td>
    <td>{$item.danjiaKucun}&nbsp;</td>
    <td>{$item.moneyKucun}&nbsp;</td>
  </tr>
  {/foreach} 
  
</table>
{$page_info}
</body>
</html>
