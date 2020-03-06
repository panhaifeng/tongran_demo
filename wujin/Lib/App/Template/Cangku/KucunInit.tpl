<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
function selWare(){
	var url="?controller=jichu_ware&action=Popup";
	ymPrompt.win({message:url,handler:callBack,width:700,height:500,title:'选择物料',iframe:true});
	return false;        
	function callBack(ret){
			//alert(ret);
			if(!ret || ret=='close') return false;			
			
			$('#wareName').val(ret.wareName);
			$('#wareId').val(ret.id);
	}	
}
</script>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>库存初始化</legend>
<div align="center">
<table>
  <tr>
    <td>物料：</td>
    <td><input name="wareName" type="text" id="wareName" value="{$aRow.Ware.wareName}" size="15">
      <input type="button" name="btnSelWare" id="btnSelWare" value="..." onClick="selWare()">
      <input name="wareId" type="hidden" id="wareId" value="{$aRow.wareId}"></td>
  </tr>
  <tr>
    <td>初始库存：</td>
    <td><input name="initCnt" type="text" id="initCnt" value="{$aRow.initCnt}" check="^\S+$" warning="部门名称不能为空！"/></td>
    </tr>
  <tr>
    <td colspan="2" align="center">
	<input name="id" type="hidden" id="id" value="{$aRow.id}" />
	<input type="submit" name="Submit" value="提交"></td>
    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
