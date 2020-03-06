<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无限分类</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript" type="text/javascript">
var parentId=0;
//默认父节点
$(function(){
	parentId=document.getElementById('default').value;
})

function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',parentId,true,function(json) {
		var arr = explode("||",json.text);
		document.getElementById('parentName').innerHTML=arr[0]?arr[0]:'';			
	});
}

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
  <td colspan="1"><input type="text" name="parentId" id="parentId" onClick="popMenu(this)" value="{$aRow.parentId}">
  </td>
  <td colspan="2">
  <span id="parentName" style=" font:bold; color:blue;">{*$path_info*}</span>
  </td>
</tr>
<tr><td>品名：</td>
<td><input name="wareName" type="text"  id="wareName" value="{$aRow.wareName}"></td>
<td>规格：</td>
<td><input name="guige" type="text" id="guige" value="{$aRow.guige}" onBlur="warning()"></td></tr>
<tr><td>单位：</td>
<td><input name="unit" type="text" id="unit" value="{$aRow.unit}"></td>
<td>助记码：</td>
<td><input name="mnemocode" type="text" id="mnemocode" value="{$aRow.mnemocode}"></td></tr>

<tr>
<tr>
  <td>单价：</td>
<td><input name="danjia" type="text" id="danjia" value="{$aRow.danjia}"></td>
<td>&nbsp;</td>
<td>&nbsp;</td></tr>

<tr>
<td colspan="2" align="center"><input type="submit" name="Submit" value="提交">
  <input name="id" type="hidden" id="id" value="{$aRow.id}">
  <input name="default" type="hidden" id="default" value="{$smarty.get.default}"></td>
<td colspan="2">
<span style=" font:bold; color:red;" id="warning"></span>
</td>
</tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>