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
var newRow;
var table;

$(function(){
	table = document.getElementById('table_moreinfo');
	var tr = table.rows[table.rows.length-1];
	newRow = tr.cloneNode(true);
});

function addRow() {	
//alert('111111');
	for (var i=0;i<5;i++) {
		table.childNodes[0].appendChild(newRow.cloneNode(true));
	}	
}

function delRow(obj){
	var arrButton = document.getElementsByName('btnDel');	
	var rev = document.getElementsByName('ifRemove[]');
	for(var i=0; i<arrButton.length; i++){
		if (arrButton[i] == obj){
			//table.deleteRow(i+1); 
			table.rows[i+1].style.display='none';
			rev[i].value=1;
			break;
		}
	}
}


function popMenu(obj) {
	tMenu(obj,'Index.php?controller=JiChu_Ware&action=tmismenu',5,false,function(e) {
		var arr = explode("||",e.text);
		var arrId=document.getElementsByName('wareId[]');
		var arrName=document.getElementsByName('spanWareName[]');
		var arrGuige=document.getElementsByName('spanGuige[]');
		var arrDanwei=document.getElementsByName('spanDanwei[]');
		var pos = -1;
		
		for(var i=0;i<arrId.length;i++)
		{
			if (arrId[i] == obj) {
				pos=i;
				break;
			}
		}
		//alert(arrId[2]==e);
		if(pos==-1) return false;
		 arrName[pos].value= arr[0]?arr[0]:'';
		 arrGuige[pos].value= arr[1]?arr[1]:'';
		 arrDanwei[pos].value = arr[2]?arr[2]:'kg';
	});
}

function popDanjia(e) {
	var wareId = document.getElementById('wareId').value;
	var con = {wareId:wareId};
	var ruku = popRuku(con);
	if (ruku) {
		e.value=ruku.danjia;
	}
}
</script>
{/literal}
</head>

<body>
<div id="container">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<fieldset>
<legend>染化料基础资料</legend>
<table width="100%">
  <tr>
	<td width="45%" height="25">单号：
<input type="hidden" name="id" id="id" value="{$arr_field_value.id}">
	  <input name="chukuNum" type="text" id="chukuNum" value="{$arr_field_value.chukuNum}" size="15" warning="请输入单号!" check="^\w+$" ></td>	
	<td width="55%">退库日期：
	  <input name="chukuDate" type="text" id="chukuDate"  value="{$arr_field_value.chukuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
  </tr>
  
  <tr>
	<td>部门：
	  <select name="depId" id="depId">
	  {webcontrol type='Tmisoptions' model='JiChu_Department' selected=$arr_field_value.depId}
	  </select></td>
	<td>备注：
	<input name="memo" type="text" id="memo" value="{$arr_field_value.memo}" size="40"></td>
  </tr>
</table>
  </fieldset>
  <fieldset>
    <legend>详细信息</legend>
<table class="tableHaveBorder table100" width="100%" id="table_moreinfo">
                <tr class="th">
                  <td align="center" bgcolor="#CCCCCC">货品编号</td>
                  <td align="center" bgcolor="#CCCCCC">品名</td>
                  <td align="center" bgcolor="#CCCCCC">规格</td>
                  <td align="center" bgcolor="#CCCCCC">单位</td>
				  <td align="center" bgcolor="#CCCCCC">退库数量</td>
                  <td align="center" bgcolor="#CCCCCC">操作</td>
                </tr>
                {foreach from=$arr_field_value.Wares item=item}
                <tr>
                  <td align="center"><input name="wareId[]" type="text" id="wareId[]" onClick="popMenu(this)" value="{$item.wareId}" size="10" readonly></td>
                  <td align="center"><input name="spanWareName[]" type="text" class="text" id='spanWareName[]' value="{$item.Ware.wareName}" size="10" readonly></td>
                  <td align="center"><input name="spanGuige[]" type="text" class="text" id='spanGuige[]' value="{$item.Ware.guige}" size="10" readonly></td>
                  <td align="center"><input name="spanDanwei[]" type="text" class="text" id='spanDanwei[]2' value="{$item.Ware.unit}" size="10" readonly></td>
				  <td align="center"><input name="cnt[]" type="text" id="cnt[]" value="{$item.cnt}" size="8" warning='请输入数量！' check=''></td>
                  <td align="center"><a href="?controller={$smarty.get.controller}&action=RemoveWare&id={$item.id}">删除
                    <input type="hidden" name="chuku2WareId[]" id="chuku2WareId[]" value="{$item.id}">
                  </a></td>
                </tr>
                {/foreach}
                <tr>
                  <td align="center"><input name="wareId[]" type="text" id="wareId[]" size="10" onClick="popMenu(this)" readonly></td>
                  <td align="center"><input id='spanWareName[]' type="text" name="spanWareName[]" readonly size="10" class="text"></td>
                  <td align="center"><input id='spanGuige[]' type="text" name="spanGuige[]" readonly class="text" size="10"></td>
                  <td align="center"><input id='spanDanwei[]' type="text" name="spanDanwei[]" readonly class="text" size="10"></td>
				  <td align="center"><input name="cnt[]" type="text" id="cnt[]" size="8" warning='请输入数量！' check=''></td>
                  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)"></td>
                </tr>
              </table>
        
         <div style="text-align:right; padding-right:4%;">
           <input type="button" name="button" id="button" value="+5行" onClick="addRow()">
         </div>
 </fieldset>
    <table style="width:100%; margin: 0 auto;">
    <tr>
    <td style=" text-align:center"><input name="submit1" type="submit" value="提&nbsp;&nbsp;&nbsp;&nbsp;交"  style="width:80px;" ></td>
    <td style="padding-left::5px;"><input name="button1" type="button" onClick="history.go(-1)" value="返回"></td>
    </tr>
    </table>

</form>
</div></body></html>
