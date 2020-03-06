<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>筒染工艺处方单合并</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript">
{literal}
$(function(){
	document.getElementById('form1').onsubmit = function(){
		//alert(document.getElementById('shuirong').value);
		if(document.getElementsByName('gangId[]').length<2) {
			alert('请选择至少2缸进行合并');return false;
		}
		if(!document.getElementById('vatId').value) {
			alert('请选择缸!');return false;
		}
		if(!document.getElementById('shuirong').value) {
			alert('请选择水溶!');return false;
		}
	}
	$('#vatId').change(function(){
		var url= '?controller=jichu_vat&action=getJsonShuirong';
		var param = {vatId:this.value};
		$.getJSON(url,param,function(json){
			//dump(json);
			if(!json) return false;
			var sel = document.getElementById('shuirong');
			while(sel.options.length>0) {
				sel.remove(0);
			}
			//var i=0;
			var op = new Option(json.shuiRong+' L',json.shuiRong);
			sel.options.add(op);
			if(parseFloat(json.shuiRong1)==0) return false;
			var op = new Option(json.shuiRong1+' L',json.shuiRong1);
			sel.options.add(op);			
		});		
	});
});
function selGang(obj) {
	var pos =-1;
	var btns = document.getElementsByName('btnSel');
	for(var i=0;btns[i];i++) {
		if(btns[i]==obj) {
			pos = i;break;
		}
	}
	if(pos==-1) return false;
	
	var rows = document.getElementById('tbl').rows;
	var url='';	
	var gang = window.showModalDialog(url);
	if(!gang) return false;
	alert('asdf');
}
function addRow(json){
	//dump(json);return false;
	var tbl = document.getElementById('tbl'); 
	var row = tbl.insertRow(-1);
	var cell = row.insertCell(-1);
	cell.innerHTML = '<input type="hidden" name="gangId[]" id="gangId[]" value="'+json.realGangId+'"><input type="hidden" name="chufangId[]" id="chufangId[]" value="'+json.id+'">'+json.vatNum;
	var cell = row.insertCell(-1);
	cell.innerHTML = json.wareName + ' ' + json.guige;
	var cell = row.insertCell(-1);
	cell.innerHTML = json.color;
	var cell = row.insertCell(-1);
	cell.innerHTML = json.cntPlanTouliao;
	var cell = row.insertCell(-1);
	cell.innerHTML = '<input type="button" name="btnDel" id="btnDel" value="删除" onClick="delRow(this)">';
	//alert(json.length);return false;
}
function delRow(obj){
	var table=document.getElementById("tbl");
	var arrButton=document.getElementsByName("btnDel");
	var pos=-1;
	for(var i=0;arrButton[i];i++){
		if(arrButton[i]==obj){
			pos=i;
		}
	}
	if(pos==-1) return false;
	table.deleteRow(pos+1);
}
{/literal}
</script>

</head>
<body>
<table width="100%" border="0" cellspacing="5" cellpadding="5" style="height:300px">
    <tr>
      <td><iframe  frameborder="0" style="width:100%;height:100%;" src="{url controller=$smarty.get.controller action='listformerge'}"></iframe></td>
    </tr>
  </table>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveMerge'}" method="post">
<div align="center">
  物理缸：
<select name="vatId" id="vatId">
{webcontrol type='TmisOptions' model='Jichu_Vat'}
  </select>
  合并后水容量：
  <select name="shuirong" id="shuirong">    
  </select>
  折率：
  <input name="rsZhelv" type="text" id="rsZhelv" value="1" size="5">
<table width="100%" cellpadding="5" cellspacing="0" id='tbl'>
  <tr align="center" bgcolor="#cccccc">
	  <td>缸号</td>
	  <td>纱支</td>
	  <td>颜色</td>
	  <td>投料数</td>
      <td>操作</td>
    </tr>				
</table>							

<br>
<div align="center">
  <input name="Submit" type="submit" value='确定并返回' id="Submit">
  <input name="Submit" type="submit" value='确定并打印' id="Submit">
</div>
</form>
</body>
</html>
