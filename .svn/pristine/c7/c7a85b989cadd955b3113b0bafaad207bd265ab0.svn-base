<!--
    使用ymPrompt数据选择器,弹出对话框形式,
-->
<html>
<head>
<base target="_self" />
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{foreach from=$arr_js_css.cssFile item=css}
<link href="Resource/Css/{$css}" rel="stylesheet" type="text/css" />
{/foreach}
{foreach from=$arr_js_css.jsFile item=js}
<script language="javascript" src="Resource/Script/{$js}"></script>
{/foreach}
<script language="javascript" src="Resource/Script/calendar/WdatePicker.js"></script>
{literal}
<style type="text/css">

body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
}
form{margin:0px; padding:0px;}
div.c{overflow:auto;width:100%; border:solid 1px #86b5e7; padding:1px; background-color:#C9daf4}
table.t thead tr{position:relative;top:expression(this.offsetParent.scrollTop-2);}

/* Scrollable Content Height */
.scrollContent {
 height:auto;
 overflow-x:hidden;
 overflow-y:auto;
}

.scrollContent tr {
 height: auto;
 white-space: nowrap;
}

/* Prevent Mozilla scrollbar from hiding right-most cell content */
.scrollContent tr td:last-child {
 padding-right: 2px;
}

/* Fixed Header Height */
.fixedHeader tr {
 position: relative;
 height: auto;
 /* this fixes IE header jumping bug when mousing over rows in the tbody */
 top: expression( this.parentNode.parentNode.parentNode.scrollTop + 'px' );
}

/* Put border around entire table */
div.TableContainer {
 border: 1px solid #80BDCB;
 overflow-y:auto;
}

/* Table Header formatting */
.headerFormat {
 background-color: white;
 color: #FFFFFF;
 margin: 3px;
 padding: 1px;
 white-space: nowrap;
 font-family: Helvetica;
 font-size: 15px;
 text-decoration: none;
 font-weight: bold;
}
.headerFormat tr td {
 border: 0px solid #FFFFFF;
 background-color: #80BDCB;
}

/* Table Body (Scrollable Content) formatting */
.bodyFormat tr td {
    color: #000000;
    margin: 3px;
    padding: 1px;
    border: 0px none;
    font-family: Helvetica;
    font-size: 12px;
}

/* Use to set different color for alternating rows */
.alternateRow {
  background-color: #E0F1E0;
}

/* Styles used for SORTING */
.point {
 cursor:pointer;
}

.fieldValue td {
    border-top:1px solid #eee!important;
    border-bottom:1px solid #eee!important;
}

.fieldValue1 td{
    border-top:1px dotted blue !important;
    border-bottom:1px dotted blue !important;
}

</style>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
var _cache = new Array();
$(function(){
    var topHeight       = 24;
    var ieHeight        = document.body.clientHeight;
    var obj1        = document.getElementById('div_content');
    //debugger;
    var contentHeight   = ieHeight - obj1.offsetTop-topHeight;
    //alert(ieHeight);

    obj1.style.height   =   contentHeight;
    document.getElementById('TableContainer').style.height=contentHeight-4;

    $('#key').focus();
    $('#checkAll').click(function(){
        $("input[name='sel[]']").each(function(i){
            $(this).click();
        });
    });

    //标记完成

    var size=$('.over').size();
    //alert(size);
    $('.over').click(function(){
        var _this=this;
        var id=$(this).attr('values');
        $.ajax({
            type:'POST',
            data:{id:id},
            dataType:'json',
            url:'?controller=Chanliang_Input&action=SetVatOver',
            success:function(ret){
                if(ret.succ=='wei'){
                    $(_this).html(ret.msg);
                }else if(ret.succ=='yi'){
                    $(_this).html(ret.msg);
                }
            }
        });
    });
});
function changeCache(obj,json) {
    if(obj.checked) {
        _cache[obj.value] = json;
    } else delete _cache[obj.value];
    //alert(_cache.length);
}
function ret() {
    //window.parent.callBack('adf');return false;
    var arr = new Array();
    for (key in _cache) {
        arr.push(_cache[key])
    }
    window.parent.ymPrompt.doHandler(arr,true);//return false;
    //window.returnValue=arr;
    //window.close();

    //如果是iframe,改变opener中的变量,并执行callback(arr);
}
function trClick(th){
    var that = th.cells[0];
    that.click();
}
</script>{/literal}
</head>
<body >

<div style="float:left;">
    <form name="FormSearch" method="post" action="">
    <div style="float:left;">
    关键字:<input name="key" type="text" id="key" onclick='this.select()' value="{$arr_condition.key}" size="10"/>
    客户：{webcontrol type='ClientSelect' id='clientId' selected=$arr_condition.clientId}
    计划投料数：<input name="cntRs" type="text" id="cntRs" value="{$arr_condition.cntRs}" size="5"/>&nbsp;
    颜色：<input type="text" name="color" id="color" value="{$arr_condition.color}" size="5">&nbsp;
    日期：<input name="dateFrom" type="text" id="dateFrom" value="{$arr_condition.dateFrom}" size="10" onclick="calendar()">
            到<input name="dateTo" type="text" id="dateTo" value="{$arr_condition.dateTo}" size="10" onclick="calendar()"/>
<!--     是否完成:
    <select name="selGangHao" id="selGangHao">
    <option value="0" {if $arr_condition.selGangHao==0}selected{/if}>未完成</option>
    <option value="1" {if $arr_condition.selGangHao==1}selected{/if}>已完成</option>
    </select> -->&nbsp;
    <input type="submit" name="Submit" value="搜索"/>
    </div>
    </form>
</div>
<div id="div_content" class="c" style="clear:both">
<div id="TableContainer" class="TableContainer">
<table width='100%' cellpadding="1" cellspacing="1" class="scrollTable" id="tb">
      {*字段名称*}
    <thead class="fixedHeader headerFormat">
      <tr id="fieldInfo" class='title'>
        <td align="center"><span id="checkAll">选择[ 全选 ]</span></td>
        {foreach from=$arr_field_info item=item}
            <td align="center"  class="point">{$item}</td>
        {/foreach}
      </tr>
      </thead>
      {*字段的值*}
      <tbody class="scrollContent bodyFormat" style="height:auto;">
      {foreach from=$arr_field_value item=field_value}
      {if $field_value.display != 'false'}  {*显示条件行*}
      <tr class="fieldValue"  bgcolor="{cycle values="#eeeeee,#ffffff"}" onmouseover="this.className='fieldValue1'" onMouseOut="this.className='fieldValue'" onClick="trClick(this);" onDblClick='_cache=new Array();this.cells[0].firstChild.checked=false;trClick(this);ret();'>
        <td align="center">
            <INPUT TYPE="checkbox" NAME="sel[]" onChange="changeCache(this,{$field_value|@json_encode|escape:'html'})" value='{$field_value[$unique_field]|default:$field_value.id}'>
        </td>
        {foreach from=$arr_field_info key=key item=item}
            {assign var=foo value="."|explode:$key}
            {assign var=key1 value=$foo[0]}
            {assign var=key2 value=$foo[1]}
            {assign var=key3 value=$foo[2]}
        <td align="center" {if $field_value._bgColor!=''}bgcolor="{$field_value._bgColor}"{/if}>
            {if $key2==''}{$field_value.$key|default:'&nbsp;'}
            {elseif $key3==''}{$field_value.$key1.$key2|default:'&nbsp;'}
            {else}{$field_value.$key1.$key2.$key3|default:'&nbsp;'}
            {/if}</td>
        {/foreach}
      </tr>
      {/if}
      {/foreach}
      </tbody>
    </table>
</div>
</div>
<div style="float:left">{$page_info}</div>
<div  style="float:right;"><input type="button" name="button" id="button" value="选择" onClick="ret()"></div>
</body>
</html>