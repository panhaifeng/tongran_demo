<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
{literal}
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
});

function addRow() {	
//alert('111111');
	// var tr = table.rows[table.rows.length-1];
	// for (var i=0;i<5;i++) {
	// 	var newTr = tr.cloneNode(true);
	// 	tr.parentNode.appendChild(newTr,table.rows[table.rows.length-1]);
	// 	// table.childNodes[0].appendChild(newRow.cloneNode(true));
	// }
	// for (var i=0;i<5;i++) {
	// 	table.childNodes[0].appendChild(newRow.cloneNode(true));
	// }	
	for (var i=0;i<5;i++) {
		table.childNodes[0].appendChild(newRow.cloneNode(true));
	}
}

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
	var ids = document.getElementsByName('id[]');
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
		var url = "?controller=Cangku_Yl_Diaobo&action=RemoveAjax";
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
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',5,false,function(json) {
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
		document.getElementsByName('spanWareName[]')[pos].value = arr[0]?arr[0]:'&nbsp;';
		document.getElementsByName('spanGuige[]')[pos].value = arr[1]?arr[1]:'&nbsp;';
		document.getElementsByName('spanDanwei[]')[pos].value = 'kg';
			
	});
}
//提交前检验
function CheckForm(){
	if(document.getElementById('rukuDate').value=='') {
		alert('必须选择日期!');
		return false;
	}
	var kind = document.getElementsByName('rukuKuwei');
	var flag = 0;
 	for (var i=0;i<kind.length;i++){
 		if (kind.item(i).checked == true){
  			flag = 1;
  			break;
		}
 	}
	if(flag==0) {
		alert('必须选择类型!');
		return false;
	}
	return true;
}
function selWare(obj) {
	// var url="?controller=jichu_ware&action=PopupPishaOfften";
	var clientId = $('#clientId').val();
	// if (!clientId) {
	// 	alert('客户未选择！请选择客户后在进行操作！');
	// 	return false;
	// }
	var kind = $('#kind').val();
	if (kind==0) {
		var url="?controller=Trade_Dye_Order&action=Popup&clientId="+clientId;
	}else{
		var url="?controller=Trade_Dye_Order&action=PopupBc";
	}
	ymPrompt.win({message:url,handler:callBack,width:550,height:400,title:'选择纱支',iframe:true});
	return false;
	function callBack(ret){
			if(!ret || ret=='close') return false;

			var btns = document.getElementsByName('btnSel');
			var pos = -1;
			for (var i=0;btns[i];i++) {
				if(btns[i]==obj) {
					pos=i;break;
				}
			}
			if(pos==-1) return false;
			// 判断行数是否足够，不够，则增加相应行
			var needRow = ret.length - (btns.length - pos);
			for (var i = 0; i < needRow; i++) {
				addOneRow();
			};
			var texts = document.getElementsByName('wareId[]');
			var spanWareName = document.getElementsByName('spanWareName');
			var spanGuige = document.getElementsByName('spanGuige');
			var wareNameBc = document.getElementsByName('wareNameBc[]');
			var pihao = document.getElementsByName('pihao[]');
			var chandi = document.getElementsByName('chandi[]');
			//处理返回的结果
			for (var i = 0; i <ret.length; i++) {
				var index = parseFloat(pos)+parseFloat(i);
				texts[index].value= ret[i].id;
				spanWareName[index].innerHTML= ret[i].wareName;
				spanGuige[index].innerHTML= ret[i].guige;
				wareNameBc[index].value = ret[i].wareNameBc;
				pihao[index].value = ret[i].pihao;
				chandi[index].value = ret[i].chandi;
				//把得到的库存 保存到缓存中
				_cacheKucun[ret[i].id+","+ret[i].pihao+","+ret[i].chandi] = ret[i].kuCun;
				//刷新产地信息
				// getChandi(document.getElementsByName('chandi[]')[index],texts[index],ret[i].chandi)
				// getPihao(document.getElementsByName('pihao[]')[index],texts[index],ret[i].pihao)
				document.getElementsByName('kuCun[]')[index].value = ret[i].kuCun;
				coloneShazhi(obj);

			}
	}
}
</script>
<style type="text/css">
.text{ border-width:0;}
</style>
{/literal}
</head>
<body>
<div id='container'>
<div style="text-align:left;">{include file="_ContentNav.tpl"}</div>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<input type="hidden" name="rukuId" id="rukuId" value="{$arr_field_value.id}">
<fieldset>
<legend>调拨基础资料</legend>
<table width="100%">
<tr>
<td height="25">调拨单号：
  <input name="rukuNum" type="text" id="rukuNum" value="{$arr_field_value.rukuNum}" size="15" warning="请输入单号!" check="^\w+$" readonly></td>	
<td>调拨日期：<input name="rukuDate" type="text" id="rukuDate"  value="{$arr_field_value.rukuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
<!-- <td>供应商：{webcontrol type='SupplierSelect' selected=$arr_field_value.supplierId}</td>
<td>送货单号：<input name="songhuoCode" type="text" id="songhuoCode" value="{$arr_field_value.songhuoCode}" size="15"></td> -->
<td>
	<span>类型：</span>
	<input name="rukuKuwei" id ='rukuKuwei' type="radio" value="1" {if $arr_field_value.rukuKuwei=='1'}checked{/if}/>仓库→车间
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="rukuKuwei" id ='rukuKuwei' type="radio" value="0" {if $arr_field_value.rukuKuwei=='0'}checked{/if}/>车间→仓库
</td>
<td>备注：<input name="memo" type="text" id="memo" value="{$arr_field_value.memo}" size="40"></td>
</tr>
</table>
</fieldset>

<fieldset>
<legend>调拨明细资料</legend>
<table class="tableHaveBorder table100" width="100%" id="table_moreinfo">
	<tr class="th">
	  <td align="center">货品编号</td>
	  <td align="center">品名</td>
	  <td align="center">规格</td>
	  <td align="center">单位</td>
	  <td align="center">数量</td>
	  <!-- <td align="center">单价</td> -->
	  <td align="center">操作</td>
	</tr>

	{foreach from=$arr_field_value.Wares item=item}
	<tr>
	  <td align="center"><input name="id[]" type="hidden" id="id[]" value="{$item.id}">
	  <input name="wareId[]" type="text" id="wareId[]"  value="{$item.wareId}" size="10" onclick="popMenu(this)">
	  <!-- <input type="button" name="btnSel" id="btnSel" value=".." onClick="selWare(this)"> -->
	  </td>
	  <td align="center"><input name="spanWareName[]" type="text" class="text" id='spanWareName[]' value="{$item.wareName}" size="10" readonly></td>
	  <td align="center"><input name="spanGuige[]" type="text" class="text" id='spanGuige[]' value="{$item.guige}" size="10" readonly></td>
	  <td align="center"><input name="spanDanwei[]" type="text" class="text" id='spanDanwei[]' value="{$item.unit}" size="10" readonly></td>
	  <td align="center"><input name="cnt[]" type="text" id="cnt[]" value="{$item.cnt}" size="8"></td>
	  <!-- <td align="center"><input name="danjia[]" type="text" id="danjia[]" value="{$item.danjia}" size="8"></td> -->
	  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)"></td>
	</tr>
	{/foreach}
    <tr>
      <input name="id[]" type="hidden" id="id[]" value="">	
	  <td align="center"><input name="wareId[]" type="text" id="wareId[]" size="10"  readonly onclick="popMenu(this)">
	  <!-- <input type="button" name="btnSel" id="btnSel" value=".." onClick="selWare(this)"> -->
	  </td>
	  <td align="center"><input id="spanWareName[]" type="text" name="spanWareName[]" readonly class="text" size="10"></td>
	  <td align="center"><input id="spanGuige[]" type="text" name="spanGuige[]" readonly class="text" size="10"></td>
	  <td align="center"><input id="spanDanwei[]" type="text" name="spanDanwei[]" readonly class="text" size="10"></td>
	  <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="8"></td>
	  <!-- <td align="center"><input name="danjia[]" type="text" id="danjia[]" size="8"></td> -->
	  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)"></td>
	</tr>
	
  </table>
  <div style="text-align:right;">
  	<input type="button" name="button" id="button" value="+5行" onClick="addRow()">
  </div>
</fieldset>

<div id="footButton" style="width:300px;">
	<ul>
		<li><input type="submit" id="submit1" value="保 存" style="width:100px;"></li>
		<li><input name="Back" type="button" id="Back" value='返 回' onClick="javascript:history.go(-1)"></li>
	</ul>
</div>
</form>
</div>
</body>
</html>