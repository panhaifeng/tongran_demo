<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无限分类</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript">
{literal}
function kd(e,obj){
	var keyCode = e.keyCode;	
	if(keyCode==13) {
		var btns = document.getElementsByName('btnSel');
		
		//根据输入的关键字，搜索相匹配的物料，如果物料数量为1，显示，
		//如果为0，提示错误，
		//如果多个，跳出选择
		var url='?controller=jichu_ware&action=GetJsonByKey';
		var param= {key:obj.value};
		$.getJSON(url,param,function(json){
			
			if(!json||json.length==0) {
				
				alert('未发现匹配的物料!');return false;
			}
			
			if(json.length==1) {
				//dump(json[0]);
				obj.value=json[0].wareName + ' ' + json[0].guige;
				$('#parentId').val(json[0].id);
				return false;
			}
			//dump(json);
			selWare(document.getElementById('btnSel'));
			return false;
		});
		return false;
	}
	return true;
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
{/literal}
</script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>
<body>

<form action="{url controller=$smarty.get.controller action='ImportSure'}" method="post" enctype="multipart/form-data" name="form1" id="form1">
<fieldset>     
<legend>物料导入</legend>
<div align="center">
<table>
<tr>
  <td>目标位置：</td>
  <td><input name="parentName" type="text" id="parentName"  size="10" onKeyDown='return kd(event,this)'><input type="button" name="btnSel" id="btnSel" value="..." onClick="selWare(this)" />
  <input name="parentId" type="hidden" id="parentId" value="{$aRow.parentId|default:$smarty.get.parentId}"></td>
</tr>
<tr>
  <td>文件:</td>
  <td><input type="file" name="file1" id="file1"></td>
</tr>

<tr><td colspan="2"><input type="submit" name="Submit" value="提交">
  <input type="button" name="back" value="取消返回" id="back" onClick="window.location.href='{url controller=$smarty.get.controller action='right' parentId=$smarty.get.parentIdFrom}'"></td></tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>