<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>产量登记</title>
<script language="javascript" src="Resource/Script/jquery.1.9.1.js"></script>
<script language="javascript" src="Resource/Script/jquery.query.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/multiple-select.js"></script>
<script language="javascript" src="Resource/Script/select2/select2.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<script language="javascript" src="Resource/Script/layer/layer.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/multiple-select.css" rel="stylesheet" type="text/css" />
<script language="javascript">
var controller = '{$smarty.get.controller}';
{literal}
var table;
var newRow;

$(function(){
    table = document.getElementById('table_moreinfo1');
    var tr = table.rows[table.rows.length-1];
    newRow = tr.cloneNode(true);
    setNum();
    
    //$('.select2').select2();
    $('[name="gxPersonId[]"]').change(function() {
        console.log($(this).val());
    }).multipleSelect({
        width: '50%'
    });


});

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
  setNum();
}

// 设置序号
function setNum(){
  var num = $('span[name="num[]"]');
  for (var i = 0; i < num.length; i++) {
        var xh = parseFloat(i)+1;
        num[i].innerText = xh;
  };
}


function myCheck(){
	var gxPersonId=document.getElementById('gxPersonId[]').value;
	//alert(gxPersonId);return false;
	if(gxPersonId==''||parseFloat(gxPersonId)==0){
		alert('请选择操作人员！');
		return false;
	}
  $("#Submit").attr('disabled',true);
	return true;
}

function popMenu(e) {
  // debugger;
  tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',2,false,function(json) {
    //alert(1);
    var arr = explode("||",json.text);
    //取得位置
    var pos=0;
    var id = "vatId[]";
    var arr1 = document.getElementsByName(id);
    for (var i=0;i<arr1.length;i++) {
      if (arr1[i]==e) {
        pos =i;
        break;
      }
    }

    document.getElementsByName('spanWareName')[pos].innerHTML = arr[0]?arr[0]:'&nbsp;';
    document.getElementsByName('spanGuige')[pos].innerHTML = arr[1]?arr[1]:'&nbsp;';

    //取得产地列表
    //清空o.option
    var o = document.getElementsByName('chandi[]')[pos];
    getChandi(o,e);

    coloneShazhi(e);
  });
}
function selWare(obj) {
  var url="?controller=Chanliang_InputRs&action=PopupGanghao1";
  ymPrompt.win({message:url,handler:callBack,width:950,height:400,title:'选择缸号',iframe:true});
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

      var texts = document.getElementsByName('vatNum[]');
      var wareName = document.getElementsByName('wareName[]');
      var gangId = document.getElementsByName('gangId[]');
      var gxTypeId = document.getElementsByName('gxTypeId[]');
      var leixing = document.getElementsByName('leixing[]');
      var cntTouliao = document.getElementsByName('cntTouliao[]');
      var color = document.getElementsByName('color[]');
      
      //处理返回的结果
      for (var i = 0; i <ret.length; i++) {
        var index = parseFloat(pos)+parseFloat(i);
        texts[index].value  = ret[i].vatNum;
        wareName[index].value = ret[i].wareName;
        gangId[index].value = ret[i].id;
        gxTypeId[index].value = ret[i].gxTypeId;
        cntTouliao[index].value = ret[i].cntPlanTouliao;
        color[index].value = ret[i].color;

        // spanWareName[index].innerHTML= ret[i].wareName;
        // spanGuige[index].innerHTML= ret[i].guige;
        //刷新产地信息
        // getChandi(document.getElementsByName('chandi[]')[index],texts[index])
        // coloneShazhi(obj);
      }
  }
}


//增加一行
function addOneRow(){
  var rows = $('.trRow','#table_moreinfo1');
  var len = rows.length;
  var nt = rows.eq(len-1).clone(true);
  $('input,select',nt).val('');
  rows.eq(len-1).after(nt);
  setNum();
  // getColor();//使新增行的颜色在输入时有提示
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

  //如果只有一个新增行，禁止删除
  if(ids.length==1 || (pos+1==ids.length && ids[pos].value=='' && (ids[pos-1].value)>0)) return false;

  table.deleteRow(pos+2);
}
function tb_remove(){
  layer.close(choose_layer); //执行关闭
}

function changeCheckd(o){
  var tr = $(o).parents('.trRow');
  if (o.checked===true) {
    $("[name='isOverRsV[]']",tr).val('1');
  }else{
    $("[name='isOverRsV[]']",tr).val('');
  }
}

   /**
    * 选择按钮单机事件
    * 打开选择界面
    */
 function  chooseGx(obj){
  //debugger;
        var tr = $(obj).parents('.trRow');
        var index=$('[name="btnSelGx"]').index(obj);
        var gxType=$('#gxType').val();
        var leixing = $('[name="leixing[]"]',tr).val();
        var gangId=$('[name="gangId[]"]',tr).val();
        if(!gangId){alert('请先选择缸号');return;}
        var url="?controller="+controller+"&action=ViewChoose&index="+index+"&type="+gxType+"&gangId="+gangId+"&leixing="+leixing;
        choose_layer = $.layer({
              type: 2,
              shade: [1],
              fix: false,
              title: '选择',
              maxmin: true,
              iframe: {src : url},
              // border:false,
              area: ['1024px' , '640px'],
              close: function(index){//关闭时触发
                  
              },
              //回调函数定义
              callback:function(index,ret) {
                //alert(555);
               // console.log(ret);
                $('[name="gxIds[]"]',tr).val(ret.gongxuIds);
                $('[name="gongxu[]"]',tr).val(ret.gxName);
                $('[name="danjia[]"]',tr).val(ret.danjia);
            }
        });
}

</script>
{/literal}
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Script/select2/select2.css" type="text/css" rel="stylesheet">
{literal}
<style type="text/css">
  .select2{width: 500px;}
</style>
{/literal}
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return myCheck(this)">
<fieldset>     
  <legend>产量登记</legend>
  <div align="center">
    <table width="80%">
      <tr>
        <td width="90">日期：</td>
        <td><input name="dateInput" type="text" id="dateInput" value="{$aRow.dateInput|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"/></td>
      </tr>
      
      <tr>
        <td width="90">操作人员：</td>
        <td width="490">
          {webcontrol type='PersonSelect' selected=$aRow.workerId multiple=true action='rs'}
        </td>
      </tr>

    
    </table>
  </div>
</fieldset>

 <fieldset>
  <legend>缸产量(*为必填)</legend>
  <div align="center">
    <table class="tableHaveBorder" width="80%"  id="table_moreinfo1">
      <thead>
        <tr class="th">
          <td align="center">编号</td> 
          <td align="center">选择缸号<span>*</span></td>
          <td align="center">染色类型<span>*</span></td>
          <td align="center">纱织规格</td>
          <td align="center">颜色</td>
          <td align="center">选择工序<span>*</span></td>
          <td align="center">投料数</td>
          <td align="center">单价</td>
          <!-- <td align="center">产量</td> -->
          <td align="center">备注</td>
          <td align="center">完成状态</td>
        </tr>
      </thead>

      <tbody>
      {if $aRow}
          <tr class="trRow">
            <td align="center">
              <input name="money[]" type="hidden" id="money[]" value="{$aRow.money}" />
              <span name="num[]" style="width="></span>
            </td>
            <td>
                <input name="vatNum[]" id="vatNum[]" type="text" value="{$aRow.Vat.vatNum}" style="width: 120px;" readonly="true">
                <input type="button" name="btnSel" id="btnSel" value=".." onClick="selWare(this)">
                <input name="id[]" type="hidden" id="id[]" value="{$aRow.id}">
                <input name="gangId[]" type="hidden" id="gangId[]" value="{$aRow.gangId}" />
                <input name="vatId[]" type="hidden" id="vatId[]" value="{$aRow.vatId}" />
            </td>
           <td align="center">
              <select name="gxTypeId[]" id="gxTypeId[]" warning='请选择'>
                    {webcontrol type='TmisOptions' model='JiChu_Ware' selected=$aRow.gxTypeId condition='parentId=2 and isDel=0'}
              </select>
        <!--       <select name="leixing[]" id="leixing[]">
                <option>
                  <option value="1" {if $aRow.leixing==1}selected{/if}>全棉</option>
                  <option value="2" {if $aRow.leixing==2}selected{/if}>人棉</option>
                  <option value="3" {if $aRow.leixing==3}selected{/if}>氨纶</option>
                </option>

              </select> -->
            </td>
            <td align="center">
              <input name="wareName[]" type="text" id="wareName[]" style="width: 80px;" value="{$aRow.wareName}" />
            </td>
            <td align="center">
              <input name="color[]" type="text" id="color[]" style="width: 80px;" value="{$aRow.Gang.OrdWare.color}" />
            </td>
            <td align="center">
                <input name="gongxu[]" type="text" id="gongxu[]" value="{$aRow.gxName}" readonly="true" />
                <input name="gxIds[]" type="hidden" id="gxIds[]" value="{$aRow.gxIds}" />
                <input type="button" name="btnSelGx" id="btnSelGx" value=".." onClick="chooseGx(this)">
            </td>
             <td align="center">
              <input name="cntTouliao[]" type="text" id="cntTouliao[]" style="width: 80px;" value="{$aRow.Vat.cntPlanTouliao}" readonly="true" />
            </td>
            <td align="center">
              <input name="danjia[]" type="text" id="danjia[]" style="width: 80px;" value="{$aRow.danjia}" readonly="true"/>
            </td>
             <td align="center">
              <input name="memo[]" type="text" id="memo[]" value="{$aRow.memo}" />
            </td>
             <td align="center" width="10%">
               <input name="isOverRs[]" type="checkbox" id="isOverRs[]" value="1" {if $aRow.Gang.rsWc} checked="checked" {/if} onchange="changeCheckd(this)">
              <input type="hidden" name="isOverRsV[]" id="isOverRsV[]" value="{$aRow.isOverRsV} ">
             </td>
          </tr>
        <!-- {foreach from=$aRow.rsGxCl item=item}
        {/foreach} -->
      {else}
        <tr class="trRow">
          <td align="center">
              <input name="money[]" type="hidden" id="money[]" value="{$item.money}" />
            <span name="num[]" style="width="></span>
          </td>
          <td>
              <input name="vatId[]" id="vatId[]" type="text" value="{$item.vatId}" style="width: 20px;"  readonly="true">
              <input type="button" name="btnSel" id="btnSel" value=".." onClick="selWare(this)">
              <input name="id[]" type="hidden" id="id[]" value="{$item.id}">
              <input name="gangId[]" type="hidden" id="gangId[]" value="" />
          </td>
         <td align="center">
            <select name="gxTypeId[]" id="gxTypeId[]" warning='请选择'>
                  {webcontrol type='TmisOptions' model='JiChu_Ware' selected=$aRow.gxTypeId condition='parentId=2 and isDel=0'}
            </select>
         <!--    <select name="leixing[]" id="leixing[]">
                <option value="1" {if $item.leixing==1}selected{/if}>全棉</option>
                <option value="2" {if $item.leixing==2}selected{/if}>人棉</option>
                <option value="3" {if $item.leixing==3}selected{/if}>氨纶</option>
            </select> -->
          </td>
          <td align="center">
            <input name="wareName[]" type="text" id="wareName[]" value="{$item.wareName}" />
          </td>
          <td align="center">
              <input name="color[]" type="text" id="color[]" value="{$aRow.Gang.OrdWare.color}" />
          </td>
          <td align="center">
              <input name="gongxu[]" type="text" id="gongxu[]" value="{$item.gongxu}" readonly="true" />
              <input name="gxIds[]" type="hidden" id="gxIds[]" value="" />
              <input type="button" name="btnSelGx" id="btnSelGx" value=".." onClick="chooseGx(this)">
          </td>
           <td align="center">
            <input name="cntTouliao[]" type="text" id="cntTouliao[]" value="{$item.cntTouliao}" readonly="true"/>
          </td>
           <td align="center">
              <input name="danjia[]" type="text" id="danjia[]" style="width: 80px;" value="{$aRow.danjia}" />
          </td>
          <td align="center">
            <input name="memo[]" type="text" id="memo[]" value="{$item.memo}" />
          </td>
           <td align="center" width="10%">
               <input name="isOverRs[]" type="checkbox" id="isOverRs[]" value="1" {if $aRow.Gang.rsWc} checked="checked" {/if} onchange="changeCheckd(this)">
              <input type="hidden" name="isOverRsV[]" id="isOverRsV[]" value="{$aRow.isOverRsV} ">
             </td>
        </tr>
      {/if}
      </tbody>

      </table>
    </div>
    <div style="text-align:right;margin-right:10%;">
      <input type="button" name="button" id="button" value="+5行" onClick="addRow()">
    </div>
  </fieldset>
  <div id="footButton1">
        <div colspan="2" align="center">
          <input name="id" type="hidden" id="id" value="{$aRow.id}" />
          <input name="gxType" type="hidden" id="gxType" value="{$gxType}" />
          <input type="submit" name="Submit" id="Submit" value="提交">
        </div>
  </div>
</form>
</body>
</html>
