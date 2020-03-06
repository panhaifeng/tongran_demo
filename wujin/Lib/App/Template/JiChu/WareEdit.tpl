<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无限分类</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/Edit200.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript" for="document" event="onkeydown">
　　<!--
　　 if(event.keyCode==13 && event.srcElement.type!='button' && event.srcElement.type!='submit' && event.srcElement.type!='reset' && event.srcElement.type!='textarea' && event.srcElement.type!='')
　　 event.keyCode=9;
　　-->
　　</script>
<script language="javascript" type="text/javascript">
var parentId=0;
//默认父节点
$(function(){
	parentId=document.getElementById('default').value;
	
	$('#form1').submit(function(){
		//parentId,wareCode,wareName,
		
		if($('#wareCode').val()=='') {
			alert('请输入物料编码');return false;
		}
		if($('#wareName').val()=='') {
			alert('请输入品名');return false;
		}
		return true;
	});

	
	$('#parentName').keydown(function(e){
		if(e.keyCode!=13) return true;
		selWare(document.getElementById('btnSel'));
	});

	$('#parentName').click(function(e){
		this.select();
	});
	
	$('#wareCode').blur(function(e){		
		var code = $('#wareCode').val();
		var url='?controller=jichu_ware&action=getJsonByCode';
		var param={code:this.value};
		//alert('begin');
		var info='';
		$.getJSON(url,param,function(json){
			//dump(json);
			if(!json) {
				document.getElementById('spanInfo').style.color='red';
				info = '未发现匹配的物料';				
			} else {
				document.getElementById('spanInfo').style.color='green';
				info = json.wareName + ' ' + json.guige +',位置:' + json.pathInfo;
			}
			$('#spanInfo').html(info);
		});
	});
})



function warning(){
	var wareName=document.getElementById('wareName').value;
	var guige=document.getElementById('guige').value;
	if(wareName==''){
		document.getElementById('warning').innerHTML='品名不能为空!'; return false;
	}
	else{
		var url='index.php?Controller=JiChu_Ware&action=getflag&wareName='+wareName+'&guige='+guige;
		url=encodeURI(url);
		//alert(url);return false;
		$.getJSON(url,null,function(json){
				//dump(json);
				//alert(json.flag); return false;
				if(json.flag=='true'){
					document.getElementById('warning').innerHTML='允许录入!'; return false;
				}
				else{
					document.getElementById('warning').innerHTML='纱支已存在!'; return false;
				}
			}
		);
	}
}
function selWare(obj) {
	var url="?controller=jichu_ware&action=selParent";
	if(document.getElementById('parentName').value!='') url+= '&key='+encodeURI(document.getElementById('parentName').value);
	//alert(url);return false;
	
	var btns = document.getElementsByName('btnSel');
	var pos = -1;
	for (var i=0;btns[i];i++) {
		if(btns[i]==obj) {
			pos=i;break;
		}
	}
	if(pos==-1) return false;
	//var objs = document.getElementsByName('wareName[]');
	//alert(objs[pos].value);
	//if(objs[pos].value!='') url += '&key=' + encodeURI(objs[pos].value);
			
	ymPrompt.win({message:url,handler:callBack,width:700,height:500,title:'选择父类',iframe:true});
	return false;        
	function callBack(ret){
		//dump(ret);return false;
		if(ret=='close') return false;
		$('#parentName').val(ret.wareName+' '+ret.guige);
		$('#parentId').val(ret.id);
	}   
}

//显示某类下的所有子节点的信息
function showChildren(){
	var url="?controller=jichu_ware&action=showChildren";
	if(document.getElementById('parentId').value!='') url+= '&parentId='+encodeURI(document.getElementById('parentId').value);
	ymPrompt.win({message:url,width:700,height:500,title:'显示子项',iframe:true});
	return false; 
}
</script>
{/literal}
</head>
<body>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post">
<fieldset>     
<legend>货品资料编辑</legend>
<div align="center">
<table>
<tr><td colspan="1">所属父类：</td>
  <td colspan="1"><input type="text" name="parentName" id="parentName" value="{$aRow.parentName}">
    <input name="parentId" type="hidden" id="parentId" value="{$aRow.parentId|default:$smarty.get.parentId}"></td>
  <td colspan="2">{if $aRow.id==0}<input type="button" name="btnSel" id="btnSel" value="..." onClick="selWare(this)" />{/if}<input type="button" name="btnView" id="btnView" value="查看所有子项" onClick="showChildren()" /></td>
</tr>
<tr>
  <td colspan="1">物料编码：</td>
  <td colspan="3"><input name="wareCode" type="text"  id="wareCode" value="{$aRow.wareCode}"><span id='spanInfo' style=" font-size:12px"></span></td>
  </tr>
<tr>
  <td>库存位置：</td>
  <td>
  <select name="pos" id="pos">
  {foreach from=$aPos item=item}
  <option {if $aRow.pos==$item.posName}selected{/if}>{$item.posName}</option>
  {/foreach}
  </select></td>
  <td colspan="2"><input type="checkbox" name="son" id="son" value="1">
复制到子节点</td>
</tr>
<tr><td>品名：</td>
<td><input name="wareName" type="text"  id="wareName" value="{$aRow.wareName}"></td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td>规格：</td>
  <td><input name="guige" type="text" id="guige" value="{$aRow.guige}"></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr><td>单位：</td>
<td><input name="unit" type="text" id="unit" value="{$aRow.unit}"></td>
<td>&nbsp;</td>
<td>&nbsp;</td></tr>
<tr>
  <td>助记码：</td>
  <td><input name="mnemocode" type="text" id="mnemocode" value="{$aRow.mnemocode}"></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>最小库存：</td>
  <td><input name="cntMin" type="text" id="cntMin" value="{$aRow.cntMin}"></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>最大库存：</td>
  <td><input name="cntMax" type="text" id="cntMax" value="{$aRow.cntMax}"></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>

<tr>
<td colspan="4" align="center"><input type="submit" name="Submit" value="确认并输入下一个">
  <input type="submit" name="Submit" value="确认并返回" id="Submit">
  <input name="id" type="hidden" id="id" value="{$aRow.id}">
  <input name="default" type="hidden" id="default" value="{$smarty.get.default}"></td>
</tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>