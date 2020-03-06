<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>车辆信息编辑</title>
{literal}
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript">
function selEmploy(obj) {
	var url="?controller=jichu_employ&action=Popup";	
	var btns = document.getElementsByName('btnSel');
	var pos = -1;
	for (var i=0;btns[i];i++) {
		if(btns[i]==obj) {
			pos=i;break;
		}
	}
	if(pos==-1) return false;
	var objs = document.getElementsByName('employName');
	//alert(objs[pos].value);
	if(objs[pos].value!='') url += '&key=' + encodeURI(objs[pos].value);
			
	ymPrompt.win({message:url,handler:callBack,width:700,height:500,title:'选择员工',iframe:true});
	return false;        
	function callBack(ret){
		if(!ret) return false;
		objs[pos].value=ret.employName;
		var os = document.getElementsByName('employId');
		os[pos].value=ret.id;
		//alert(os[pos].value);
	}   
}

</script>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>人员设置
</legend>
<div align="center">
<table style="width:300px;" class="tab">
  <tr align="center">
    <td>员工</td>
    <td>工种</td>
    <td>操作</td>
    </tr>
  {foreach from=$arr_field_value item=item}
  <tr align="center">
    <td>{$item.employs.employName}</td>
    <td>{$item.kind}</td>
    <td><input type="button" name="button" id="button" value="删除" onClick="window.location.href='?controller={$smarty.get.controller}&action=delete&id={$item.id}'"></td>
  </tr>
  {/foreach}
  <tr align="center">
    <td><input name="employName" type="text" id="employName" size="10" readonly><input type="button" name="btnSel" id="btnSel" value="..." onClick="selEmploy(this)">
      
      <input type="hidden" name="employId" id="employId"></td>
    <td><select name="kind" id="kind">
      <option value="制单">制单</option>
      <option value="验收">验收</option>
      <option value="审核">审核</option>
      <option value="经手">经手</option>
      <option value="发料">发料</option>
    </select></td>
    <td><input type="submit" name="button2" id="button2" value="提交"></td>
  </tr>
  
</table>
</div>
</fieldset>
</form>
</body>
</html>
