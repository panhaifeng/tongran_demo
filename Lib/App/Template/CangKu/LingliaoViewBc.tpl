<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
<title>坯纱领料</title>
{literal}
<script language="javascript">
$(function(){
	//库存信息
	$('input[@id="cnt[]"]').each(function(){
		getMsg(this);
	});
	$('#form1').submit(function(){
		var chandi=document.getElementsByName('chandi[]');
		var j=0;
		for(var i=0;chandi[i];i++){
			if(chandi[i].value!=''){
				j++;
			}
		}
		//alert(j);return false;
		if(j!=parseFloat(chandi.length)){
			alert('请选择产地!');
			return false;
		}
		return true;							
	});
});

function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',0,false,function(json) {
		var arr = explode("||",json.text);
		//dump(json); return false;
		var id=e.id;
		var left=id.indexOf(']');
		var right=id.indexOf('[');
		var length=left-right;
		id=id.substr(right+1,length-1);//得到键值
		var tableId='tbl_'+id;
		$('#'+tableId+' input[@id="wareId[]"]').each(function(){
			this.value=json.value;
		});
		//库存信息
		$('input[@id="cnt[]"]').each(function(){
		getMsg(this);
		});
	});	
}
function getMsg(e){
	var wareId='';	
	var tableId='';
	var msgId='';
	var cnt=0;
	for(var i=0;i<$('input[@id="cnt[]"]').length;i++){
	    var	obj=document.getElementsByName('cnt[]');
		var ps=document.getElementsByName('key[]');
		var pt=document.getElementsByName('wareId[]');
		if(obj[i]==e){
			wareId=pt[i].value;
			tableId='tbl_'+ps[i].value;
			msgId='msg_'+ps[i].value;
			break;
		}
	}
	
	$('#'+tableId+' input[@id="cnt[]"]').each(function(){
			if(this.value==''){
				cnt=parseFloat(cnt);
			}
			else{
				cnt=parseFloat(cnt)+parseFloat(this.value);
			}
	});
	//alert(wareId+'___'+cnt);return false;
	/*var url='Index.php?controller=CangKu_Kucun&action=getCntKucun&wareId='+wareId;
	$.getJSON(url,null,function(json){
		//dump(json);	
		if(json.cnt<cnt){
			//debugger;
			$('#'+msgId).html(json.wareName+' 库存不足: '+(parseFloat(json.cnt)-parseFloat(cnt)));
		}
		else{
			$('#'+msgId).html('');
		}
		//alert('correct');return false;
	});*/
	//重新统计总计
	var heji=0;
	$('input[@id="cnt[]"]').each(function(){
		heji=parseFloat(heji)+parseFloat(this.value);
	});
	$('#heji').html(heji);
}
function getKucun(obj){
	var chandi=document.getElementsByName('chandi[]');
	var supplierId=document.getElementsByName('supplierId[]');
	var wareId=document.getElementsByName('wareId[]');
	var pihao=document.getElementsByName('pihao[]');
	var spanKucun=document.getElementsByName('spanKucun');
	var pos=-1;
	for(var i=0;chandi[i];i++){
		if(chandi[i]==obj){
			pos=i;
		}
	}
	if(pos==-1)return false;
	var url="?controller=CangKu_ChuKuBc&action=GetKucunByJson";
	var param={wareId:wareId[pos].value,chandi:chandi[pos].value,supplierId:supplierId[pos].value,pihao:pihao[pos].value};
	//dump(param);return false;
	$.getJSON(url,param,function(json){
		//dump(json);return false;	
		if(!json) return false;
		spanKucun[pos].innerHTML=json.cntKucun;
	});
}

function addOne(_this){
	var tr = $(_this).parents('tr');
	var newTr = tr.clone(true);
	tr.after(newTr);
}
</script>
{/literal}
</head>

<body >
<div id="container">
<form id="form1" action="{url controller=$smarty.get.controller action=SaveRecords}" method="post">
<fieldset>
<legend>本厂坯纱库存-领料出库</legend>
{foreach from=$aRow item=item key=key}
<div style="width:500px; margin-top:10px;">
	<div align="left" style="font-size:14px;">计划单纱支规格：<span style="font-weight:bold; color:#0066CC">{$item.0.wareName}</span><span style="margin-left:20px;">修改纱支：<input name="wareId2[{$key}]" type="text" id="wareId2[{$key}]" size="10" onClick="popMenu(this)"  readonly ></span></div>
</div>
<table id='tbl_{$key}' class="tableHaveBorder table100" style=" width:500px; margin:0 auto;">
<tr class="th">
<td>产地</td>
<td>批号</td>
<td>库存数</td>
<td>数量</td>
<td>缸号</td>
<td>计划产地</td>
<td>供应商</td>
<td>操作</td>
</tr>
{foreach from=$aRow.$key item=items}
    <tr align="center">
      <td ><select name="chandi[]" id="chandi[]" onChange="getKucun(this)">
      	<option value="">请选择</option>
      	{foreach from=$chandi[$key] item=cdi}
      	<option value="{$cdi}">{$cdi}</option>
        {/foreach}
      </select></td>
      <td>{$items.pihao}<input name="pihao[]" type="hidden" id="pihao[]" value="{$items.pihao}" /></td>
      <td ><span id="spanKucun" name="spanKucun">&nbsp;</span></td>
        <td ><input name="wareId[]" type="hidden" id="wareId[]" value="{$key}" />          
        <input type="hidden" id="key[]" name="key[]" value="{$key}"><input type="text" name="cnt[]" id="cnt[]" value="{$items.cnt}" onBlur="getMsg(this)" size="8" />
        </td>
        <td><input name="gangId[]" type="hidden" id="gangId[]" value="{$items.gangId}" />
          {$items.gangName}</td>
        <td>{$items.chandi}</td>
        <td>
        <input name="supplierId[]" id="supplierId[]" type="hidden" value="{$items.supplierId}" />          {$items.supplierName}
        </td>
        <td><a href="javascript:;" onClick="addOne(this)">+1</a></td>
{/foreach}
</table>
<span id="msg_{$key}" style="color:red;"></span>
{/foreach}
<table style=" width:500px; margin:0 auto;"><tr>
  <td><b>合计:</b><span id="heji" style="font-weight:bold; color:#0066CC">{$heji}</span></td><td>&nbsp;</td><td></td></tr></table>
<div style="margin-top:20px;">
	<input name="submit" type="submit" value="提 交" />&nbsp;&nbsp;
    <input name="submit" type="submit" value="确定并打印" />&nbsp;&nbsp;
	<input name="Back" type="button" value="返 回" onClick="javascript:window.history.go(-1)"/>
</div>
</fieldset>

</form>
</div>
</body>
</html>
