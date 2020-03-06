<!-- <html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无限分类</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript" type="text/javascript">
var parentId=0;
//默认父节点
$(function(){
    parentId=document.getElementById('default').value;
})

function popMenu(e) {
    tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',parentId,true,function(json) {
        var arr = explode("||",json.text);
        document.getElementById('parentName').innerHTML=arr[0]?arr[0]:'';           
    });
}

function warning(){
    var wareName=document.getElementById('wareName').value;
    var guige=document.getElementById('guige').value;
    if(wareName==''){
        document.getElementById('warning').innerHTML='品名不能为空!'; return false;
    }
    else{
        var url='index.php?Controller=JiChu_Ware&action=getflag&wareName='+wareName+'&guige='+guige;
        url=encodeURI(url);
        //alert(url);return false;
        $.getJSON(url,null,function(json){
                //dump(json);
                //alert(json.flag); return false;
                if(json.flag=='true'){
                    document.getElementById('warning').innerHTML='允许录入!'; return false;
                }
                else{
                    document.getElementById('warning').innerHTML='纱支已存在!'; return false;
                }
            }
        );
    }
}
</script>
{/literal}
</head>
<body>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SaveDanjia'}" method="post">
<fieldset>     
<legend>纱支产量单价编辑</legend>
<div align="center">
<table>
<tr>
  <td>品名：</td>
  <td>{$aRow.wareName}</td>
  <td>规格：</td>
  <td>{$aRow.guige}</td></tr>
<tr>
  <td>松筒单价：</td>
  <td><input name="danjiaSt" type="text" id="danjiaSt" value="{$aRow.danjiaSt}"></td>
  <td>装出笼单价：</td>
  <td><input name="danjiaZcl" type="text" id="danjiaZcl" value="{$aRow.danjiaZcl}"></td>
</tr>
<tr>
  <td>烘纱单价：</td>
  <td><input name="danjiaHs" type="text" id="danjiaHs" value="{$aRow.danjiaHs}"></td>
  <td>回倒单价：</td>
  <td><input name="danjiaHd" type="text" id="danjiaHd" value="{$aRow.danjiaHd}"></td>
</tr>
<tr>
  <td>打包单价：</td>
  <td><input name="danjiaDb" type="text" id="danjiaDb" value="{$aRow.danjiaDb}"></td> -->
 <!--  <td>染色单价：</td>
  <td><input name="danjiaRs" type="text" id="danjiaRs" value="{$aRow.danjiaRs}"></td> -->
<!-- </tr>
<tr>
<td colspan="4" align="center"><input type="submit" name="Submit" value="提交">
  <input name="id" type="hidden" id="id" value="{$aRow.id}">
  <input name="wareId" type="hidden" id="id" value="{$aRow.wareId}">
  <input name="default" type="hidden" id="default" value="{$smarty.get.default}"></td>
</tr>
</table>
</div>
</fieldset>
</form>
</body>
</html> -->


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无限分类</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript" type="text/javascript">
var parentId=0;
//默认父节点
$(function(){
    parentId=document.getElementById('default').value;
})

function popMenu(e) {
    tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',parentId,true,function(json) {
        var arr = explode("||",json.text);
        document.getElementById('parentName').innerHTML=arr[0]?arr[0]:'';           
    });
}

function warning(){
    var wareName=document.getElementById('wareName').value;
    var guige=document.getElementById('guige').value;
    if(wareName==''){
        document.getElementById('warning').innerHTML='品名不能为空!'; return false;
    }
    else{
        var url='index.php?Controller=JiChu_Ware&action=getflag&wareName='+wareName+'&guige='+guige;
        url=encodeURI(url);
        //alert(url);return false;
        $.getJSON(url,null,function(json){
                //dump(json);
                //alert(json.flag); return false;
                if(json.flag=='true'){
                    document.getElementById('warning').innerHTML='允许录入!'; return false;
                }
                else{
                    document.getElementById('warning').innerHTML='纱支已存在!'; return false;
                }
            }
        );
    }
}

function addRow() { 
  for (var i=0;i<5;i++) {
      // document.getElementById("table_moreinfo1").appendChild(newRow.cloneNode(true));
      // table.childNodes[0].appendChild(newRow.cloneNode(true));
      var rows = $('.trRow','#table_moreinfo1');
      var len = rows.length;
      var nt = rows.eq(len-1).clone(true);
      $('input,select',nt).val('');
      rows.eq(len-1).after(nt);
  } 
}

</script>
{/literal}
</head>
<body>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SaveDanjia'}" method="post">
<fieldset>     
<legend>纱支产量单价编辑  &nbsp;&nbsp;&nbsp;(纱支规格： {$res.wareName}{$res.guige})</legend>
<div align="center">
<div align="center">
    <table class="tableHaveBorder" width="80%"  id="table_moreinfo1">
      <thead>
        <tr class="th">
          <td align="center">选择工序<span>*</span></td>
          <td align="center">价格</td>
        </tr>
      </thead>
      <tbody>
      {if $aRow}
        {foreach from=$aRow item=item}
        <tr class="trRow">
           <td align="center">
              <select name="gongxuId[]" id="gongxuId[]" warning='请选择'>
                    {webcontrol type='TmisOptions' model='JiChu_Chanliang_Gongxu' selected=$item.gongxuId condition='type=1 or type=2'}
              </select>
            </td>
             <td align="center">
              <input name="danjia[]" type="text" id="danjia[]" value="{$item.danjia}" />
              <input type="hidden" name="ids[]" value="{$item.id}">
            </td>
        </tr>
        {/foreach}
      {else}
        <tr class="trRow">
         <td align="center">
            <select name="gongxuId[]" id="gongxuId[]" warning='请选择'>
                  {webcontrol type='TmisOptions' model='JiChu_Chanliang_Gongxu' selected=$aRow.wareId condition=''}
            </select>
          </td>
           <td align="center">
            <input name="danjia[]" type="text" id="danjia[]" value="{$item.danjia}" />
          </td>
        </tr>
      {/if}
      </tbody>

      </table>
    </div>
    <div style="text-align:right;margin-right:10%;">
      <input type="button" name="button" id="button" value="+5行" onClick="addRow()">
    </div>

    <div align="center">
      <td colspan="4" align="center"><input type="submit" name="Submit" value="提交">
        <input name="id" type="hidden" id="id" value="{$res.id}">
        <input name="wareId" type="hidden" id="id" value="{$res.wareId}">
        <input name="default" type="hidden" id="default" value="{$smarty.get.default}"></td>
    </div>
</div>
</fieldset>
</form>
</body>
</html>