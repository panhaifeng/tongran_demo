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
function popMenu(obj) {
  tMenu(obj,'Index.php?controller=JiChu_Ware&action=tmismenu',5,false,function(e) {
    var arr = explode("||",e.text);
  });
}
function changeCheckd1(o){
  var tr = $(o).parents('.trRow');
  if (o.checked===true) {
    $("[name='quanbu']",tr).val('1');
 
  }else{
    $("[name='quanbu']",tr).val('0');
  }
}
function changeCheckd2(o){
  var tr = $(o).parents('.trRow');
  if (o.checked===true) {
    $("[name='fensan']",tr).val('1');
 
  }else{
    $("[name='fensan']",tr).val('0');
  }
}
function changeCheckd3(o){
  var tr = $(o).parents('.trRow');
  if (o.checked===true) {
    $("[name='taomian']",tr).val('1');
 
  }else{
    $("[name='taomian']",tr).val('0');
  }
}
function changeCheckd4(o){
  var tr = $(o).parents('.trRow');
  if (o.checked===true) {
    $("[name='huixiu']",tr).val('1');
 
  }else{
    $("[name='huixiu']",tr).val('0');
  }
}

function changeCheckd5(){
  var tr = $(o).parents('.trRow');
  if (o.checked===true) {
    $("[name='mamianps']",tr).val('1');
 
  }else{
    $("[name='mamianps']",tr).val('0');
  }
}
</script>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveindex'}" method="post" onSubmit="return CheckForm(this)">

<fieldset>     
<legend>{$title}</legend>
<div align="center">
<table width="50%" border="1" cellspacing="1" cellpadding="0">
  
  <tr>
    <td width="13%" height="33">工序名称：</td>
    <td width="38%">
      <input name="gongxuName" type="text" id="gongxuName" value="{$aRow.gongxuName}" check="^(\s|\S)+$" warning="名称不能为空!" /></td>
  </tr>
  <tr>
    <td width="13%" height="33">工序编号：</td>
    <td width="38%">
      <input name="gongxuCode" type="text" id="gongxuCode" value="{$aRow.gongxuCode}" check="^(\s|\S)+$" warning="名称不能为空!" /></td>
  </tr>    
  <tr>
    <td height="33">类型：</td>
    <td>
        <select name="type" id="type">
          <option value=""> 请选择</option>
          <option value="1" {if $aRow.type=='1'}selected{/if}>松紧筒打包</option>
          <option value="2" {if $aRow.type=='2'}selected{/if}>装出笼</option>
          <option value="3" {if $aRow.type=='3'}selected{/if}>染色</option>
        </select>&nbsp;
    </td>
      <!-- <td><input name="type" type="text" id="type" value="{$aRow.type}" /></td> -->
  </tr>
  <tr>
    <td colspan="2">
      (此选项只能在染色类型工序时选择)
      单染:<input type="checkbox" name="quanbu" id="quanbu" value="1" {if $aRow.quanbu}checked{/if} onchange="changeCheckd1(this)"/>
      麻棉漂纱:<input type="checkbox" name="mamianps" id="mamianps" value="1" {if $aRow.mamianps}checked{/if} onchange="changeCheckd5(this)"/>
      分散:<input type="checkbox" name="fensan" id="fensan" value="1" {if $aRow.fensan}checked{/if} onchange="changeCheckd2(this)"/>
      套棉:<input type="checkbox" name="taomian" id="taomian" value="1" {if $aRow.taomian}checked{/if} onchange="changeCheckd3(this)"/>
      回修:<input type="checkbox" name="huixiu" id="huixiu" value="1" {if $aRow.huixiu}checked{/if} onchange="changeCheckd4(this)"/>
    </td>
  </tr>
 <!--  <tr>
    <td height="33">标识：</td>
    <td>
        <select name="biaoshi" id="biaoshi">
          <option value="">请选择</option>
          <option value="danjiaSt"  {if $aRow.type=='danjiaSt'}selected{/if}>松筒</option>
          <option value="danjiaJt"  {if $aRow.type=='danjiaJt'}selected{/if}>紧筒</option>
          <option value="danjiaZcl" {if $aRow.type=='danjiaZcl'}selected{/if}>装出笼</option>
          <option value="danjiaHs"  {if $aRow.type=='danjiaHs'}selected{/if}>烘纱</option>
          <option value="danjiaHd"  {if $aRow.type=='danjiaHd'}selected{/if}>回倒</option>
          <option value="danjiaDb"  {if $aRow.type=='danjiaDb'}selected{/if}>打包</option>
        </select>&nbsp;
    </td>
  </tr> -->

  <tr>
    <td height="45" colspan="2" align="center">
  <input name="id" type="hidden" id="id" value="{$aRow.id}" />
  <input type="submit" name="Submit" value="提交"></td>
    </tr>
    <tr>
      <td colspan="2">
        注：选择单染，此工序会在单染的缸号显示。 选择分散时，此工序会在缸号做分散的时候显示。 选择套棉时，此工序会在缸号做套棉的时候显示。
            如果都不选择，那么报工页面不会显示该工序
      </td>

    </tr>
</table>
</div>
</fieldset>
</form>
</body>
</html>
