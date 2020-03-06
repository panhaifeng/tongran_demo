<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css">
{literal}
<style type="text/css">
.mm{font-weight:bold;
	font-size:14px;
	background-color:#cccccc;
	}
div table {
	width:98%;
	border-collapse:collapse;
	border:1px solid #86B5E7;
	background-color:#FFFFFF;
}
div table td {
	border-bottom:1px solid #86B5E7;
	border-right:1px solid #86B5E7;
	font:"新宋体";
	font-size:12px;
	height:30px
}
input{
	border: 1px solid #3c3c3c;
	height:25px;
	background-color: #b5d0ee;
}
</style>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveGuide'}" method="post">
<div align="center">
<table width="100%" border="1">
                <tr class="mm">
                  <td align="center" style="width:30px">客户</td>
                  <td align="center">订单号</td>
                  <td align="center">纱支规格</td>
                  <td align="center" style="width:30px">颜色</td>
                  <td align="center">缸号</td>
                  <td align="center" style="width:30px">色号</td>
                  <td align="center" width="50">计划投料</td>
                  <td align="center" width="50">计划筒数</td>
                  <td align="center">毛重(kg)</td>
                  <td align="center">净重(kg)</td>
                  <td align="center">筒子数(个)</td>
                  <td align="center">件数</td>
                </tr>
				{foreach from=$rows item=item}
                <tr>
                  <td align="center">{$item.clientName}</td>
                  <td align="center">{$item.orderCode}</td>
                  <td align="center">{$item.guige}</td>
                  <td align="center">{$item.color}</td>
                  <td align="center">{$item.vatNum}</td>
                  <td align="center">{$item.OrdWare.colorNum}</td>
                  <td align="center">{$item.cntPlanTouliao}</td>
                  <td align="center">{$item.planTongzi}</td>
                  <td align="center">{if $item.maoKg!=''}{$item.maoKg}{else}<input name="maoKg[]" type="text" id="maoKg[]" size="6" onMouseOver="this.select()" value="{$item.maoKg}">&nbsp;&nbsp;&nbsp;<span style="color:red;">*</span>{/if}</td>
                  <td align="center">{if $item.isShow==''}<input name="gangId[]" type="hidden" id="gangId[]" value="{$item.id}">{/if}
                  {if $item.jingKg!=''}{$item.jingKg}{else}<input name="jingKg[]" type="text" id="jingKg[]" size="6" onMouseOver="this.select()" value="{$item.jingKg}">&nbsp;&nbsp;&nbsp;<span style="color:red;">*</span>{/if}</td>
                  <td align="center">{if $item.cntTongzi!=''}{$item.cntTongzi}{else}<input name="cntTongzi[]" type="text" id="cntTongzi[]" size="6" onMouseOver="this.select()" value="{$item.cntTongzi1}">&nbsp;&nbsp;&nbsp;<span style="color:red;">*</span>{/if}</td>
                  <td align="center">{if $item.cntJian!=''}{$item.cntJian}{else}<input name="cntJian[]" type="text" id="cntJian[]" size="6" onMouseOver="this.select()" value="{$item.cntJian}">&nbsp;&nbsp;&nbsp;<span style="color:red;">*</span>{/if}</td>
                </tr>
                
                {/foreach}
              </table>
							
		<input name="Submit" type="submit" id="Submit" value='提交' onClick="javascript:window.location='?controller={$smarty.get.controller}&action=right'">
		</td>
	
</div>
</form>
</body>
</html>
