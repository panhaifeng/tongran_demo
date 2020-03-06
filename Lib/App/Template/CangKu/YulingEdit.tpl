<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery1.10.1.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/TmisSuggest.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<!-- <script language="javascript" src="Resource/Script/jquery.autocomplete.js"></script> -->
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="Resource/Script/autocomplete/autocomplete.js"></script>
<link href="Resource/Script/autocomplete/autocomplete.css" type="text/css" rel="stylesheet" />

{literal}
<style type="text/css">
.text {border-width:0;}
</style>
<script language="javascript">
/*
	实时增加table行数
*/
var newRow;
var table;

$(function(){
	table = document.getElementById('table_moreinfo');
	var tr = table.rows[table.rows.length-1];
	newRow = tr.cloneNode(true);
	for(var i=0;table.rows[i];i++){
		autoAfterAdd(table.rows[i]);
	}
});

function addRow() {
	var tr = table.rows[table.rows.length-1];
	for (var i=0;i<5;i++) {
		var newTr = tr.cloneNode(true);
		tr.parentNode.appendChild(newTr,table.rows[table.rows.length-1]);
		// table.childNodes[0].appendChild(newRow.cloneNode(true));
	}
	tab = document.getElementById('table_moreinfo');
	for(var i=0;tab.rows[i];i++){
	    autoAfterAdd(tab.rows[i]);
	}
}
//增加一行
function addOneRow(){
	table.childNodes[0].appendChild(newRow.cloneNode(true));
	tab = document.getElementById('table_moreinfo');
	for(var i=0;tab.rows[i];i++){
	    autoAfterAdd(tab.rows[i]);
	}
}
// function delRow(obj){
// 	var arrButton = document.getElementsByName('btnDel');
// 	var rev = document.getElementsByName('ifRemove[]');
// 	for(var i=0; i<arrButton.length; i++){
// 		if (arrButton[i] == obj){
// 			//table.deleteRow(i+1);
// 			table.rows[i+1].style.display='none';
// 			rev[i].value=1;
// 			break;
// 		}
// 	}
// }
function delRow(obj){
	var arrButton = document.getElementsByName('btnDel');
	///var rev = document.getElementsByName('ifRemove[]');
	var pos = -1;
	for(var i=0;arrButton[i];i++) {
		if(obj==arrButton[i]) {
			pos=i;break;
		}
	}
	if(pos<0) return false;

	var ids = document.getElementsByName('id2[]');
	//如果只有一个新增行，禁止删除(移除 只保留最后一条)
	// if(ids.length==1 || (pos+1==ids.length && ids[pos].value=='' && (ids[pos-1].value)>0)) return false;
	if(ids.length==1) {
		if (ids[pos].value!='') {
			alert('至少保留一条有效明细数据'); 
			return false;
		}
		return false;
	}
	//alert(ids.length);return false;
	if(ids[pos].value>0) {//如果当前id>0,需要用ajax从数据库中删除
		if(!confirm("警告：该操作将删除数据,您确认吗?")) return false;
		var url = "?controller=cangku_chuku&action=RemoveAjax";
		var param = {id:ids[pos].value};
		$.getJSON(url,param,function(json){
			if(!json.success) {
				alert(json.msg);
				return false;
			}
			alert('删除成功！');
			table.deleteRow(pos+1);
		});
	} else {
		//这边+1 因为还有表头 tr
		table.deleteRow(pos+1);
	}
}
function popMenu(e) {
	return false;
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',2,false,function(json) {
		var arr = explode("||",json.text);
		//取得位置
		var pos=0;
		var id = "wareId[]";
		var arr1 = document.getElementsByName(id);
		for (var i=0;i<arr1.length;i++) {
			if (arr1[i]==e) {
				pos =i;
				break;
			}
		}
		//debugger;
		//alert(pos);
		//alert(document.getElementsByName('spanWareName[]')[pos].value);
		document.getElementsByName('spanWareName[]')[pos].value = arr[0]?arr[0]:'';
		document.getElementsByName('spanGuige[]')[pos].value = arr[1]?arr[1]:'';
		document.getElementsByName('spanDanwei[]')[pos].value = arr[2]?arr[2]:'';


	});
}
function CheckForm(){
	//return false;
	if(document.getElementById('clientId').value=='') {
		alert('必须选择客户!');
		return false;
	}
	var chandi=document.getElementsByName('chandi[]');
	var j=0;
	for(var i=0;chandi[i];i++){
		if(chandi[i].value==''){
			j++;
		}
	}
	//alert(j);return false;
	if(j==parseFloat(chandi.length)){
		alert('请填写产地!');
		return false;
	}
	var pihao=document.getElementsByName('pihao[]');
	var p=0;
	for(var i=0;pihao[i];i++){
		if(pihao[i].value==''){
			p++;
		}
	}
	//alert(j);return false;
	if(p==parseFloat(pihao.length)){
		alert('请填写批号!');
		return false;
	}	
	//在进行判断批号是否重复 是否要保存重复的操作
	// for(var i=0;pihao[i];i++){
	// 	if(pihao[i].value!=''){
	// 		var url="?controller=CangKu_Ruku&action=GetIsCheck";
	// 		var param={pihao:pihao[i].value};
	// 		var check;
	// 		//dump(param);return false;
	// 		$.ajaxSetup({
	// 		  async: false
	// 		});
	// 		$.getJSON(url,param,function(json){
	// 			//dump(json);return false;	
	// 			check = json.isCheck;
	// 		});
	// 		if (check==1) {
	// 			return confirm('是否要保存重复的批号！');
	// 		}
	// 	}
	// }
	// return true;
}

function selWare(obj) {
	if ($('#clientId').val()=='') {
		alert('请先选择客户！');
		return false;
	}
	var url="?controller=cangku_yuling&action=YulingList"+"&clientId="+$('#clientId').val();
	ymPrompt.win({message:url,handler:callBack,width:800,height:550,title:'选择松筒数据',iframe:true});
	return false;
	function callBack(ret){
			// console.log(ret);
			if(!ret) return false;
			if(ret=='close') return false;
			var btns = document.getElementsByName('btnSel');
			var pos = -1;
			for (var i=0;btns[i];i++) {
				if(btns[i]==obj) {
					pos=i;break;
				}
			}
			if(pos==-1) return false;
			var wareId = document.getElementsByName('wareId[]');
			var spanWareName = document.getElementsByName('spanWareName[]');
			var spanGuige = document.getElementsByName('spanGuige[]');
			var pihao = document.getElementsByName('pihao[]');
			var chandi = document.getElementsByName('chandi[]');
			wareId[pos].value= ret.wareId;
			spanWareName[pos].value= ret.wareName;
			spanGuige[pos].value= ret.guige;
			pihao[pos].value= ret.pihao;
			chandi[pos].value= ret.chandi;
			// 判断行数是否足够，不够，则增加相应行
			// var needRow = ret.length - (btns.length - pos);
			// for (var i = 0; i < needRow; i++) {
			// 	addOneRow();
			// };
			// var texts = document.getElementsByName('wareId[]');
			// var spanWareName = document.getElementsByName('spanWareName[]');
			// var spanGuige = document.getElementsByName('spanGuige[]');
			// //处理返回的结果
			// for (var i = 0; i <ret.length; i++) {
			// 	var index = parseFloat(pos)+parseFloat(i);
			// 	texts[index].value= ret[i].id;
			// 	spanWareName[index].value= ret[i].wareName;
			// 	spanGuige[index].value= ret[i].guige;
			// }
	}
}
//自动搜到批号
function autoAfterAdd(o){
  $('input[name="pihao[]"]',o).autocomplete('?controller=CangKu_Ruku&action=GetpihaoByAjax', {
      minChars: 1,
      remoteDataType:'json',
      useCache:false,
      onItemSelect:function(v){
        // $('[name="pihao[]"]',o).val(v.data[0].pihao);
      }
  });
}
</script>
{/literal}
</head>

<body>
<div id='container'>
<div style="text-align:left;">{include file="_ContentNav.tpl"}</div>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='Save'}" method="post" onSubmit="return CheckForm(this)">
<input type="hidden" name="rukuId" id="rukuId" value="{$aRow.id}">
<!-- <input type="hidden" name="id" id="id" value="{$aRow.id}"> -->
<fieldset>
<legend>预领纱基础资料</legend>
<table class="tableHaveBorder table100" width="100%">
<tr>
	<td height="25" class="tdTitle">单号：</td>
	<td><input name="ruKuNum" type="text" id="ruKuNum" value="{$aRow.ruKuNum}" size="15" warning="请输入单号!" check="^\w+$"  readonly>
	&nbsp;&nbsp;</td>
	<td class="tdTitle">客户： </td>
	<td>{webcontrol type='ClientSelect' id='clientId' selected=$aRow.Client.id}</td>
	
</tr>
<tr>
	<td class="tdTitle">预领日期：</td>
  	<td><input name="ruKuDate" type="text" id="ruKuDate"  value="{$aRow.ruKuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
  	<td class="tdTitle" >备注：</td>
  	<td >
  		<input type="text" name="memo" id="memo" value="{$aRow.memo}" style="width: 50%">
  	</td>
</tr>
</table>
</fieldset>
<br/>
<fieldset>
<legend>预领纱明细</legend>
<table class="tableHaveBorder table100" width="100%" id="table_moreinfo">

	<tr class="th">
	  <td align="center">货品编号</td>
	  <td align="center">品名</td>
	  <td align="center">规格</td>
	  <td align="center">单位</td>
	  <td align="center">批号</td>
	  <td align="center">产地</td>
	  <td align="center">数量</td>
	  <td align="center">件数</td>
	  <td align="center">操作</td>
	</tr>
    {foreach from=$aRow.Wares item=item}
	<tr>
	  <td align="center"><input name="wareId[]" type="text" id="wareId[]" onClick="popMenu(this)" value="{$item.wareId}" size="10" readonly>
		  <input type="button" name="btnSel" id="btnSel" value=".." onClick="selWare(this)"></td>
	  <td align="center">	    <input name="spanWareName[]" type="text" class="text" id='spanWareName[]' value="{$item.wareName}" size="10" readonly></td>
	  <td align="center"><input name="spanGuige[]" type="text" class="text" id='spanGuige[]' value="{$item.guige}" size="10" readonly></td>
	  <td align="center"><input name="spanDanwei[]" type="text" class="text" id='spanDanwei[]' value="{$item.unit}" size="10" readonly></td>
	  <td align="center"><input name="pihao[]" type="text" id="pihao[]" class="text" value="{$item.pihao}" size="8" readonly></td>
	  <td align="center"><input name="chandi[]" type="text" id="chandi[]" class="text" value="{$item.chandi}" size="8" readonly></td>
	  <td align="center"><input name="cnt[]" type="text" id="cnt[]" value="{$item.cnt}" size="8"></td>
	  <td align="center"><input name="cntJian[]" type="text" id="cntJian[]" value="{$item.cntJian}" size="8"></td>
	  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)">
	  <input type="hidden" name="id[]" id="id[]" value="{$item.id}">
	  </a></td>
	</tr>
	{/foreach}
	<tr>
	  <td align="center"><input name="wareId[]" type="text" id="wareId[]" size="10" onClick="popMenu(this)" readonly>
		  <input type="button" name="btnSel" id="btnSel" value=".." onClick="selWare(this)"></td>
	  <td align="center"><input name="spanWareName[]" type="text" class="text" id='spanWareName[]' size="10" readonly></td>
	  <td align="center"><input name="spanGuige[]" type="text" class="text" id='spanGuige[]' size="10" readonly></td>
	  <td align="center"><input name="spanDanwei[]" type="text" class="text" id='spanDanwei[]' size="10" readonly></td>
	  <td align="center"><input name="pihao[]" type="text" id="pihao[]" class="text" value="" size="8" readonly></td>
	  <td align="center"><input name="chandi[]" type="text" id="chandi[]" class="text" size="8" readonly></td>
	  <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="8"></td>
	  <td align="center"><input name="cntJian[]" type="text" id="cntJian[]" size="8"></td>
	  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)">
        <input type="hidden" name="id[]" id="id[]">
        </td>
	</tr>
    <tr>
	  <td align="center"><input name="wareId[]" type="text" id="wareId[]" size="10" onClick="popMenu(this)" readonly>
		  <input type="button" name="btnSel" id="btnSel" value=".." onClick="selWare(this)"></td>
	  <td align="center"><span id='spanWareName'>&nbsp;
	    <input name="spanWareName[]" type="text" class="text" id='spanWareName[]' size="10" readonly>
	  </span></td>
	  <td align="center"><span id='spanGuige'>&nbsp;
	    <input name="spanGuige[]" type="text" class="text" id='spanGuige[]' size="10" readonly>
	  </span></td>
	  <td align="center"><span id='spanDanwei'>
	    <input name="spanDanwei[]" type="text" class="text" id='spanDanwei[]' size="10" readonly>
	    &nbsp;</span></td>
	  <td align="center"><input name="pihao[]" type="text" id="pihao[]" class="text" value="" size="8" readonly></td>  
	  <td align="center"><input name="chandi[]" type="text" id="chandi[]" class="text" size="8"  readonly></td>
	  <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="8"></td>
	  <td align="center"><input name="cntJian[]" type="text" id="cntJian[]" size="8"></td>
	  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)">
        <input type="hidden" name="id[]" id="id[]">
    </td>
	</tr>

  </table>
</fieldset>
<div style="text-align:right;">
	<div style="color:#F00; float:left" align="left"></div>
	<div><input type="button" name="button" id="button" value="+5行" onClick="addRow()"></div>
</div>
<div>
  <input name="Submit" type="submit" id="Submit" value=' 提 交 '>
	<input name="Back" type="button" id="Back" value=' 返 回 ' onClick="javascript:window.history.go(-1)">
</div>
</form></div></body></html>