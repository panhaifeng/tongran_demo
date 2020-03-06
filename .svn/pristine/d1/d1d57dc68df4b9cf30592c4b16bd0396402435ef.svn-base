<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<link href="Resource/Css/Print.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/Lodop/CheckActivX.js"></script>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
  <param name="CompanyName" value="常州易奇信息科技有限公司">
  <param name="License" value="664717080837475919278901905623">
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/PrintRuku.js"></script>
{literal}
<script language=javascript id=clientEventHandlersJS> 
<!-- 
function prnbutt_onclick() { 
	window.print(); 
	return true; 
} 

function window_onbeforeprint() { 
	document.getElementById('prn').style.visibility ="hidden"; 
	return true; 
} 

function window_onafterprint() { 
	document.getElementById('prn').style.visibility = "visible"; 
	return true; 
} 
function mm(){
	var id={/literal}{$smarty.get.id}{literal};
	var url='?controller=Cangku_Ruku&action=PrintLodop';
	var param={id:id};
	$.getJSON(url,param,function(json){
			//dump(json);return false;
			for(var i=0;json[i];i++) {
				//alert('gggggg');
				CreatePrintPage(json[i],i+1,json.length);
				//LODOP.PRINT_DESIGN();return false;
				LODOP.PRINT();
			}							 
	});
}
function prn_preview(){
	var id={/literal}{$smarty.get.id}{literal};
	var url='?controller=Cangku_Ruku&action=PrintLodop';
	var param={id:id};
	$.getJSON(url,param,function(json){
			//dump(json);return false;
			for(var i=0;json[i];i++) {
				//alert('gggggg');
				CreatePrintPage(json[i],i+1,json.length);
				//LODOP.PRINT_DESIGN();return false;
				LODOP.PREVIEW();
			}							 
	});
}
//-->
</script>
<style type="text/css">
 #divTotal {margin-left:40px}
 #divTotal { float:right; width:100%; text-align:right;}
 body {background-color:#FFFFFF}
 #tbl,#tbl1 { width:100%; border-left:1px solid #000; border-top:1px solid #000;border-collapse:collapse;}
 #tbl td,#tbl1 td { border-color:#000000;border-right:1px solid #000; border-bottom:1px solid #000;border-collapse:collapse;}
 #footButton { clear:both;} 
 
 #noBorder {width:100%}
 #noBorder td{border:0px;}
  .mm{width:19cm; margin-top:20px;}
</style>
{/literal}
</head>

<body style="margin:0px; text-align:center"  onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
{foreach from=$row item=item1 key=key}
<div align="center" {if ($key+1)!=$cnt}style="page-break-after:always;"{/if}  class="mm">
<table id='noBorder'>
<tr>
  <td align="center" style="font-size:18px"><strong>{webcontrol type='GetAppInf' varName='compName'}入库单<br></strong>
    
  </td>
</tr>
</table>
<table id='noBorder'>
  <tr>
    <td height="25"><span style="font-size:14px;">日期：{$arr_field_value.rukuDate}</span></td>
    <td align="right" >第{$key+1}页/共{$cnt}页</td>
    <td align="right" ><span style="font-size:14px;">单号：{$arr_field_value.rukuCode}</span></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" id='tbl'>
<tr class="th" style="height:25px;">
  <td colspan="2">供应商：{$arr_field_value.Supplier.compName}</td>
  <td colspan="3">经手人：{$arr_field_value.jingshouRenName} </td>
  <td colspan="2">票号:{$arr_field_value.songhuoCode}</td>
  </tr>
<tr class="th" style="height:25px;">
  <td align="center">材料编码</td>
  <td align="center">材料名称</td>
  <td align="center">材料规格</td>
  <td align="center">单位</td>
  <td align="center">本次入库</td>
  <td align="center">单价</td>
  <td align="center">金额</td>
  </tr>

{foreach from=$item1 item=item}
<tr  style="height:25px;">
  <td align="center">{$item.Wares.wareCode}</td>
  <td align="center">{$item.Wares.wareName|default:'&nbsp;'}</td>
  <td align="center">{$item.Wares.guige|default:'&nbsp;'}</td>
  <td align="center">{$item.Wares.unit|default:'&nbsp;'}</td>
  <td align="center">{$item.cnt}</td>
  <td align="center">{$item.danjia}</td>
  <td align="center">{$item.money}</td>
  </tr>
{/foreach}
{if $key+1==$cnt}
<tr style="height:25px;">
 	<td colspan="3" align="left" style="border-right:0px solid #000;">金额合计(大写):<span style=" width:200px; text-align:center;">{$tRmb}</span></td>
  <td colspan="4" align="right">小写:<span style=" width:100px; text-align:center;">{$arr_field_value.tCnt}</span>元</td>
  </tr>
{/if}
</table>

<table border="0" cellpadding="0" cellspacing="0" id="noBorder">
  <tr>
    <td height="25">制单：{$arr_field_value.zhidanRenName}
    </td>
    <td>验收：{$arr_field_value.yanshouRenName}</td>
    <td align="right" >审核：{$arr_field_value.shenheRenName}
    </td>
  </tr>
</table>

</div>
{/foreach}
<div id='prn' align="center" {if $smarty.get.kind==1}style="display:none"{/if}>
<input type="button" name="button2" id="button2" value="打印预览" onClick="return prn_preview()">
<input id='prnbutt' onClick="return prnbutt_onclick()" type='button' value="打印">
	<input type="button" name="button" id="button" value="直接打印" onClick="mm()">
</div>

</body>
</html>
