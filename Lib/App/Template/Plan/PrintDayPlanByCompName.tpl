<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{webcontrol type='GetAppInf' varName='compName'}坯纱领料日计划</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language=javascript id=clientEventHandlersJS> 
{literal}
<!-- 
function prnbutt_onclick() 
{ 
window.print(); 
return true; 
} 

function window_onbeforeprint() 
{ 
prn.style.visibility ="hidden"; 
prn1.style.visibility ="hidden"; 
return true; 
} 

function window_onafterprint() 
{ 
prn.style.visibility = "visible"; 
return true; 
} 
$(function(){
	document.getElementById('btnSearch').onclick=function(){
		var url='?controller=plan_dye&action=PrintDayPlanByCompName&dateLingsha='+document.getElementById('dateLingsha').value+'&lingshaBanci='+document.getElementById('lingshaBanci').value;
		//alert(url);return;
		window.location.href = url;
	};
});
//--> 
{/literal}
</script> 
<style type="text/css">
{literal}
td {FONT-SIZE:16px;}
.caption {font-size:22px; font-weight:bold;}
.th td{font-weight:bold; text-align:center}
{/literal}
</style>
</head>

<body onafterprint="return window_onafterprint()" 
onbeforeprint="return window_onbeforeprint()">

<table border="0" align="center">
    <tr>
        <td align="center" class="caption">{webcontrol type='GetAppInf' varName='compName'}坯纱领料日计划</td>
    </tr>
    <tr>
        <td align="right"><div id='prn1' align='center' style="float:left">日期:
            <input name="dateLingsha" type="text" id="dateLingsha" size="10" onClick="calendar()" value="{$smarty.get.dateLingsha}">
            班次:
            <select name="lingshaBanci" id="lingshaBanci">
              <option value="1" {if ($smarty.get.lingshaBanci == 1)} selected="selected" {/if}>早班1</option>
              <option value="3" {if ($smarty.get.lingshaBanci == 3)} selected="selected" {/if}>早班2</option>
              <option value="2" {if ($smarty.get.lingshaBanci == 2)} selected="selected" {/if}>晚班</option>
              <option value="4" {if ($smarty.get.lingshaBanci == 4)} selected="selected" {/if}>晚班2</option>
          </select>
            <input type="submit" name="btnSearch" id="btnSearch" value="查询">
        </div>
        {$date_lingsha}&nbsp;&nbsp;{$lingshaBanci}</td>
    </tr>
    <tr>
        <td>
		<table class="tableHaveBorder" cellpadding="3px">
		  <tr align="center" class="th">
		  	<td>加工单位</td>
			<td>缸号</td>
			<td>逻辑缸号</td>
			<td>纱支</td>
			<td>色别</td>
			<td>投染数kg</td>
			<td>筒子个数</td>
			<td>色号</td>
			<td>备注</td>
		  </tr>
		  {foreach from=$arr_field_value item=field_value}
		  <tr>
			{foreach from=$arr_field_info key=key item=item}
			<td align="center">{$field_value.$key|default:'&nbsp;'}</td>
			{/foreach}
			{if $arr_edit_info != ""}
			
			{/if}
			<td></td>   	
		  </tr>
		  {/foreach}
		</table>
		</td>
    </tr>
	
</table><div id='prn' align='center'><input language=javascript id=prnbutt onClick="return prnbutt_onclick()" type=button value="打印"></div>
</body>
</html>
