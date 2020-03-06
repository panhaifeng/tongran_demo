<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/TmisPopup.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript">
/*
	实时增加table行数
*/
var newRow;
var table;

$(function(){
  // 初始化给助剂选择框绑定事件
  renderWare();
});


function addRow() {
	var tr = table.rows[table.rows.length-1];
	//var newTr = tr.cloneNode(true);
	for (var i=0;i<5;i++) {
		/*table.childNodes[0].appendChild(newRow.cloneNode(true));
		newTr.cells[0].firstChild.targetMenu = null;*/
		var newTr = tr.cloneNode(true);
    // 清空原来的信息
    // newTr.cells[0].innerHTML='<input name="wareId[]" type="text" id="wareId[]" size="10" /><span id="spanWare" name="spanWare"></span><input id="gongyiId[]" name="gongyiId[]" type="hidden" /><span style="text-align:left"><input id="id[]" name="id[]" type="hidden" /></span>';
    $('[name="wareId[]"]',newTr).val("");
    $('[name="wareId[]"]',newTr).removeAttr("isPopup");
    // $('[name="gongyiId[]"]',newTr).val("");
    $('[name="spanWare"]', newTr).text("");
    $('[name="id[]"]',newTr).val("");
    $('[name="unitKg[]"]',newTr).val('');
    $('[name="unit[]"]',newTr).val($('[name="unit[]"]',$(tr)).val());
    $('[name="tmp[]"]',newTr).val("");
    $('[name="tmpRs[]"]',newTr).val("");
    $('[name="_btnWare[]"]',newTr).remove();
		tr.parentNode.appendChild(newTr,table.rows[table.rows.length-1]);
		//debugger;
	}
  renderWare();// 给新加的行绑定选择助剂事件
	//debugger;
}

function delRow(obj,id){
	//alert(id);return false;
	var arrButton = document.getElementsByName(id);
	var rev = document.getElementsByName('ifRemove[]');
	for(var i=0; i<arrButton.length; i++){
		if (arrButton[i] == obj&&i!=(arrButton.length-1)){
			//table.deleteRow(i+1);
			table.rows[i+1].style.display='none';
			rev[i].value=1;
			break;
		}
	}
}

function getTableQcl(){
	// debugger;
	if(table==document.getElementById('table_moreinfo')){
		return false;
	}
	table = document.getElementById('table_moreinfo');
	var tr = table.rows[table.rows.length-1];
	newRow = tr.cloneNode(true);
}

function getTableRs(){
	if(table==document.getElementById('table_moreinfo2')){
		return false;
	}
	table = document.getElementById('table_moreinfo2');
	var tr = table.rows[table.rows.length-1];
	newRow = tr.cloneNode(true);
}
function setTableHcl(){
	if(table==document.getElementById('table_moreinfo3')){
		return false;
	}
	table = document.getElementById('table_moreinfo3');
	var tr = table.rows[table.rows.length-1];
	newRow = tr.cloneNode(true);
}

// 给现有的助剂染料框加选择按钮
function renderWare() {
  new TmisPopup({
      obj:document.getElementsByName('wareId[]'),//进行渲染的目标元素,可以是document.getElementsByName('')得到的数组
      fieldInText:'id',//选择后对text控件进行赋值的字段
      fieldInHidden:'id',//选择后对hidden控件进行赋值的字段,默认是id
      width : 120,//渲染后的宽度
      urlPop:'?controller=JiChu_Ware&action=PopupByTree',//弹出框的地址
      titlePop:'选择染料助剂',//弹出框的标题
      widthPop:400,
      heightPop:400,
      // idHidden:'guigeId',//创建的hidden元素的id和name
      idBtn:'_btnWare',//创建的按钮的id
      isArray:true,//if true,创建的元素以[]结尾
      onSelect: function(json,pos){
        // 给对应行的span赋值，显示助剂信息
        $('span[name="spanWare"]').eq(pos).text(json.text);
        //debugger;
        // dump(json);return false;
      }//选择某个记录后的触发动作
    });
}

function setTemp(Obj){
	$('input[@name="'+Obj.name+'"]').each(function(){
		if(this.value=="" && this){
			this.value=Obj.value;
		 }
	});
}
function setRs(Obj){
	$('input[@name="'+Obj.name+'"]').each(function(){
		if(this.value=="" && this){
			this.value=Obj.value;
		 }
	});
}

</script>

<style>
.addButton{margin-top:10px;}
.addButton li{float:right;}
.tableHaveBorder td{font:12px Arial, Helvetica, sans-serif;}
</style>
{/literal}
</head>

<body>
<div id='container'>
	<div style="text-align:left">{include file="_ContentNav2.tpl"}	</div>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
 <table width="0" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
  <tr>
    <td>
      <fieldset>
        <legend class="style1">染料/助剂详细信息</legend>
        <table width="100%">
          <tr>
            <td colspan=3 style="padding-left:10px" align="left">
              <table id='table_moreinfo' class="tableHaveBorder" width="100%">
                <tr class="th">
                  <td colspan="3">助剂 | 规格 | 单位</td>
                  <td>单位用量</td>
                  <td>温度*时间</td>
                  <td>操作</td>
                  </tr>
                {*{foreach from=$aRow.1 item=item}*}
                {foreach from=$aRow item=item1}
                {foreach from=$item1 item=item}
                <tr>
                  <td colspan=3 style="padding-left:10px" align="left"><input name="wareId[]" type="text" id="wareId[]" size="10" value="{$item.Ware.id}" />
                    <span id="spanWare" name="spanWare">{$item.Ware.wareName} {$item.Ware.guige} {$item.Ware.unit}</span>
                    <input id="gongyiId[]" name="gongyiId[]" type="hidden" value="{$gongyiId}" />
                    <span style="text-align:left">
                      <input id="id[]" name="id[]" type="hidden" value="{$item.id}" />
                      </span></td>
                  <td style="padding-left:10px" align="left">
                    <input type="text" name="unitKg[]" id="unitKg[]" size="5" value="{$item.unitKg}">
                    <select name="unit[]" id="unit[]">
                      <option value="g/升" {if $item.unit=='g/升'} selected{/if}>g/升</option>
                      <option value="g/包" {if $item.unit=='g/包'} selected{/if}>g/包</option>
                      <option value="%" {if $item.unit=='%'} selected{/if}>%</option>
                      </select></td>
                  <td style="padding-left:10px" align="left">
                  	<input name="tmp[]" type="text" id="tmp[]" onBlur="setTemp(this)"  value="{$item.tmp}" size="5">
                    *
                    <input name="tmpRs[]" type="text" id="tmpRs[]" onBlur="setRs(this)" value="{$item.timeRs}" size="5"></td>
                  <td><a href="{url controller=JiChu_Gongyi action=Remove2Ware id=$item.id}">删除</a> <span style=" display:none;">
                    <input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)">
                    </span>
                    <input name="ifRemove[]" type="hidden" id="ifRemove[]" value="0"></td>
                  </tr>
                {/foreach}
                {/foreach}
                <tr>
                  <td colspan=3 style="padding-left:10px" align="left"><input name="wareId[]" type="text" id="wareId[]" size="10" />
                    <input id="gongyiId[]" name="gongyiId[]" type="hidden" value="{$gongyiId}" /><span id="spanWare" name="spanWare"></span></td>
                  <td style="padding-left:10px" align="left"><input type="text" name="unitKg[]" id="unitKg[]" size="5">
                    <select name="unit[]" id="unit[]">
                      <option value="g/升" >g/升</option>
                      <option value="g/包" >g/包</option>
                      <option value="%" {if $defaultUnit=='%'} selected{/if}>%</option>
                      </select></td>
                  <td style="padding-left:10px" align="left">
                  <input name="tmp[]" type="text" id="tmp[]" size="5" onBlur="setTemp(this)">
                    *
                    <input name="tmpRs[]" type="text" id="tmpRs[]" size="5" onBlur="setRs(this)"></td>
                  <td><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="getTableQcl();delRow(this,'btnDel')">
                    <input name="ifRemove[]" type="hidden" id="ifRemove[]" value="0"></td>
                  </tr>
                <tr>
                  <td colspan=3 style="padding-left:10px" align="left"><input name="wareId[]" type="text" id="wareId[]" size="10" />
                    <input id="gongyiId[]" name="gongyiId[]" type="hidden" value="{$gongyiId}" /><span id="spanWare" name="spanWare"></span></td>
                  <td style="padding-left:10px" align="left"><input type="text" name="unitKg[]" id="unitKg[]" size="5">
                    <select name="unit[]" id="unit[]">
                      <option value="g/升" >g/升</option>
                      <option value="g/包" >g/包</option>
                      <option value="%" {if $defaultUnit=='%'} selected{/if}>%</option>
                      </select></td>
                  <td style="padding-left:10px" align="left"><input name="tmp[]" type="text" id="tmp[]" onBlur="setTemp(this)" size="5">
                    *
                    <input name="tmpRs[]" type="text" id="tmpRs[]" size="5" onBlur="setRs(this)"></td>
                  <td><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="getTableQcl();delRow(this,'btnDel')">
                    <input name="ifRemove[]" type="hidden" id="ifRemove[]" value="0"></td>
                  </tr>
                <tr>
                  <td colspan=3 style="padding-left:10px" align="left"><input name="wareId[]" type="text" id="wareId[]" size="10" />
                    <input id="gongyiId[]" name="gongyiId[]" type="hidden" value="{$gongyiId}" /><span id="spanWare" name="spanWare"></span></td>
                  <td style="padding-left:10px" align="left"><input type="text" name="unitKg[]" id="unitKg[]" size="5">
                    <select name="unit[]" id="unit[]">
                      <option value="g/升" >g/升</option>
                      <option value="g/包" >g/包</option>
                      <option value="%" {if $defaultUnit=='%'} selected{/if}>%</option>
                      </select></td>
                  <td style="padding-left:10px" align="left"><input name="tmp[]" type="text" id="tmp[]" onBlur="setTemp(this)" size="5">
                    *
                    <input name="tmpRs[]" type="text" id="tmpRs[]" size="5" onBlur="setRs(this)"></td>
                  <td><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="getTableQcl();delRow(this,'btnDel')">
                    <input name="ifRemove[]" type="hidden" id="ifRemove[]" value="0"></td>
                  </tr>
                </table></td>
            </tr>
          </table>
        <div class="addButton">
          <ul>
            <li>
              <input type="button" name="button" id="button" value="增加5行" onClick="getTableQcl();addRow()">
              </li>
            </ul>
          </div>
        </fieldset>
      </td>
  </tr>
  </table>


<!--底部两操作按钮-->
<div id="footButton">
	<ul>
		<li><input type="submit" id="Submit" name="Submit" value='保  存'></li>
		<li><input type="button" id="Back" name="Back" value='取  消' onClick="javascript:window.history.go(-1);"></li>
	</ul>
</div>

</form>
</div>
</body>
</html>