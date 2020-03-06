<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>染缸档案编辑</title>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
{literal}
<style>
#table_baseinfo1{width:80%; height:100%}
#footButton1{width:300px; margin-top:10px;}
#footButton1 li{ float:left;}
#footButton1 input{width:70px; height:30px; padding-top:3px;}
</style>
<script language="javascript">
/*
  实时增加table行数
*/
var newRow;
var table;
var newRowT;
var tableT;

$(function(){
  table = document.getElementById('table_moreinfo1');
  var tr = table.rows[table.rows.length-1];
  newRow = tr.cloneNode(true);

  tableT = document.getElementById('table_moreinfo2');
  var trT = tableT.rows[tableT.rows.length-1];
  newRowT = trT.cloneNode(true);

  setNum();
  setNumT();
});

function addRow() { 
  // for (var i=0;i<5;i++) {
  //   document.getElementById("table_moreinfo1").appendChild(newRow.cloneNode(true));
  //   // table.childNodes[0].appendChild(newRow.cloneNode(true));
  // } 
  for (var i=0;i<5;i++) {
      var rows = $('.trRow','#table_moreinfo1');
      var len = rows.length;
      var nt = rows.eq(len-1).clone(true);
      $('input,select',nt).val('');
      rows.eq(len-1).after(nt);

    // document.getElementById("table_moreinfo1").appendChild(newRow.cloneNode(true));
    // table.childNodes[0].appendChild(newRow.cloneNode(true));
  } 
  setNum();
  setNumT();
}

function addRowT() { 
  // for (var i=0;i<5;i++) {
  //   document.getElementById("table_moreinfo2").appendChild(newRowT.cloneNode(true));
  //   // tableT.childNodes[0].appendChild(newRowT.cloneNode(true));
  // } 
for (var i=0;i<5;i++) {
      var rows = $('.trRow','#table_moreinfo2');
      var len = rows.length;
      var nt = rows.eq(len-1).clone(true);
      $('input,select',nt).val('');
      rows.eq(len-1).after(nt);

    // document.getElementById("table_moreinfo2").appendChild(newRowT.cloneNode(true));
    // tableT.childNodes[0].appendChild(newRowT.cloneNode(true));
  } 
  setNum();
  setNumT();
}

//此删除方法仅仅隐藏，没有删除作用 若需要删除需要完善  2015-11-04 by wuyou
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

//表单验证
function myCheck(o){
  var c = document.getElementsByName('cengCnt[]');
  var s = document.getElementsByName('shuirong[]');
  for (var i = 0; i < c.length; i++) {
      if((c[i].value!='' && s[i].value=='') || (c[i].value=='' && s[i].value!='')){
          alert('同一行内，层数或水溶量都必填！');
          return false;
      }
  };
  return CheckForm(o);
}

// 设置序号
function setNum(){
  var num = $('span[name="num[]"]');
  for (var i = 0; i < num.length; i++) {
        var xh = parseFloat(i)+1;
        num[i].innerText = xh;
  };
}

// 设置序号
function setNumT(){
  var num = $('span[name="numT[]"]');
  for (var i = 0; i < num.length; i++) {
        var xh = parseFloat(i)+1;
        num[i].innerText = xh;
  };
}
</script>
<style type="text/css">
.text{ border-width:0;}
</style>
{/literal}
</head>
<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return myCheck(this)">

<div align="center">
  <fieldset>     
  <legend>染缸档案编辑</legend>
  <table width="50%" border="1" cellspacing="1" cellpadding="0">
    <tr>
      <td width="13%" height="33">染缸编号：</td>
      <td width="38%">
        <input name="{$pk}" type="hidden" id="{$pk}" value="{$aVat.$pk}" />
        <input name="vatCode" type="text" id="vatCode" value="{$aVat.vatCode}" check="^(\s|\S)+$" warning="染缸编号不能为空!"/>
      </td>
      <td height="35">装筒数：</td>
      <td>
        <input name="cntTongzi" type="text" id="cntTongzi" value="{$aVat.cntTongzi}"  check="^\d+$" warning="筒子数量必须为数字!"/>
      </td>
      </tr>
    <tr>
      <td height="35">最小染纱量：</td>
      <td><input name="minKg" type="text" id="minKg" value="{$aVat.minKg}" /></td>
      <td height="34">最大染纱量：</td>
      <td><input name="maxKg" type="text" id="maxKg" value="{$aVat.maxKg}" /></td>
      </tr>
    <tr>
      <td height="35">最小浴比：</td>
      <td><input name="minYubi" type="text" id="minYubi" value="{$aVat.minYubi}" /></td>
      <td height="34">最大浴比：</td>
      <td><input name="maxYubi" type="text" id="maxYubi" value="{$aVat.maxYubi}" /></td>
    </tr>
    <tr>
      <td height="35">水溶量：</td>
      <td><input name="shuiRong" type="text" id="shuiRong" value="{$aVat.shuiRong}"/></td>
      <td height="35">水溶量1：</td>
      <td><input name="shuiRong1" type="text" id="shuiRong1" value="{$aVat.shuiRong1}"/></td>
    </tr>
    <tr>
      <td height="35">排列顺序：</td>
      <td><input name="orderLine" type="text" id="orderLine" value="{$aVat.orderLine}" </td>
      <td height="35" colspan="2"></td>
    </tr>
    <tr>
      <td height="35">备注：</td>
      <td colspan="3"><input name="memo" type="text" id="memo" value="{$aVat.memo}" style="width:85%;"/></td>
    </tr>
  </table>
  </fieldset>
  <fieldset>
  <legend>染缸水溶量编辑(*为必填)</legend>
  <table class="tableHaveBorder" width="100%" id="table_moreinfo1">
    <tr class="th">
      <td align="center" width="20%">序号</td> 
      <td align="center">类型<span>*</span></td>
      <td align="center">层数<span>*</span></td>
      <td align="center">最小筒子数<span>*</span></td>
      <td align="center">最大筒子数<span>*</span></td>
      <td align="center">水溶量<span>*</span></td>
      <!-- <td align="center">操作</td> -->
    </tr>

    {foreach from=$aVat.Shuirongs item=item}
    <tr class="trRow">
      <td align="center" width="20%">
        <input name="shuirongId[]" type="hidden" id="shuirongId[]" value="{$item.id}">
        <span name="num[]" style="width="></span>
      </td>
      <td align="center">
        <select name="kind[]" id='kind[]'} >
          <option value=''>请选择</option> 
          <option value='平' {if $item.kind=='平'}selected{/if}>平</option>      
          <option value='锥' {if $item.kind=='锥'}selected{/if}>锥</option> 
        </select>
      </td>
      <td align="center">
        <input name="cengCnt[]" type="text" id='cengCnt[]' value="{$item.cengCnt}" size="15">
      </td>
      <td align="center">
        <input name="minCntTongzi[]" type="text" id='minCntTongzi[]' value="{$item.minCntTongzi}" size="15">
      </td>
      <td align="center">
        <input name="maxCntTongzi[]" type="text" id='maxCntTongzi[]' value="{$item.maxCntTongzi}" size="15">
      </td>
      <td align="center"><input name="shuirong[]" type="text" id='shuirong[]' value="{$item.shuirong}" size="15"></td>
      <!-- <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this);setNum();"></td> -->
    </tr>
    {/foreach}
      <tr>
        <td align="center" width="20%"><span name="num[]"></span></td>
        <td align="center">
          <select name="kind[]" id='kind[]' >
            <option value='' selected>请选择</option>  
            <option value='平' >平</option>      
            <option value='锥'>锥</option> 
          </select>
        </td>
        <td align="center"><input id="cengCnt[]" type="text" name="cengCnt[]" size="15" ></td>
        <td align="center"><input id="minCntTongzi[]" type="text" name="minCntTongzi[]" size="15" ></td>
        <td align="center"><input id="maxCntTongzi[]" type="text" name="maxCntTongzi[]" size="15" ></td>
        <td align="center"><input id="shuirong[]" type="text" name="shuirong[]" size="15" ></td>
        <!-- <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this);setNum();"></td> -->
    </tr>
    </table>
    <div style="text-align:right;margin-right:10%;">
      <input type="button" name="button" id="button" value="+5行" onClick="addRow()">
    </div>
  </fieldset>

  <fieldset>
  <legend>染缸工序单价(*为必填)</legend>
  <table class="tableHaveBorder" width="100%" id="table_moreinfo2">
    <tr class="th">
      <td align="center" width="20%">序号</td> 
      <td align="center">工序<span>*</span></td>
      <td align="center">价格<span>*</span></td>
    </tr>

    {foreach from=$aVat.RsgxPrice item=item}
    <tr class="trRow">
      <td align="center" width="20%">
        <input name="rsgxId[]" type="hidden" id="rsgxId[]" value="{$item.id}">
        <span name="numT[]" style="width="></span>
      </td>
      <td align="center">
        <select name="gxName[]" id="gxName[]" warning='请选择'>
              {webcontrol type='TmisOptions' model='JiChu_RsPrice' selected=$item.gxId}
        </select>
      </td>
      <td align="center">
        <input name="price[]" type="text" id='price[]' value="{$item.price}" size="15">
      </td>
     
      <!-- <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this);setNum();"></td> -->
    </tr>
    {/foreach}
      <tr>
        <td align="center" width="20%"><span name="numT[]"></span></td>
        <td align="center">
        <select name="gxName[]" id="gxName[]" warning='请选择'>
              {webcontrol type='TmisOptions' model='JiChu_RsPrice' selected=''}
        </select>
        </td>
        <td align="center"><input id="price[]" type="text" name="price[]" size="15" ></td>
        <!-- <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this);setNum();"></td> -->
    </tr>
    </table>
    <div style="text-align:right;margin-right:10%;">
      <input type="button" name="button" id="button" value="+5行" onClick="addRowT()">
    </div>
  </fieldset>

  <div id="footButton1" style="width:300px;">
  <ul>
    <li><input type="submit" id="submit1" value="保 存" ></li>
    <li><input name="Back" type="button" id="Back" value='返 回' onClick="javascript:history.go(-1)"></li>
  </ul>
  </div>
</div>
</form>
</body>
</html>
