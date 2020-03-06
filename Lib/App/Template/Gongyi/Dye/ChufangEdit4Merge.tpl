<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工艺处方单</title>
<link href="Resource/Css/Edit100.css" type="text/css" rel="stylesheet">
{literal}
<style>
.input100{width:35px;}
</style>
{/literal}
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery1.10.1.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/TmisSuggest.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/TmisPopup.js"></script>
<script language="javascript" src="Resource/Script/autocomplete/autocomplete.js"></script>
<link href="Resource/Script/autocomplete/autocomplete.css" type="text/css" rel="stylesheet" />
<script language="javascript">
{literal}
$(function(){
    renderWare();
    document.onkeydown = function(e){
        document.getElementById('form1').onsubmit = function(){document.getElementById('submit').disabled=true;};

        //可以用上下键移动的控件序列，用来标志移动的顺序
        var cellNames = ['mnemocode[]','unitKg[]','tmp[]','timeRs[]','memo[]'];
        var ev = document.all ? window.event : e;
        //debugger;
        //假如不是回车和方向键，则返回
        if(ev.keyCode!=13&&ev.keyCode!=37&&ev.keyCode!=38&&ev.keyCode!=39&&ev.keyCode!=40) return true;

        var target = document.all ? ev.srcElement : ev.target;
        //找到和target的name相同的所有元素
        var ts = document.getElementsByName(target.name);
        //找到位置
        for (var i=0;i<ts.length;i++) {
            if (target==ts[i]) {
                var pos =i;
                break;
            }
        }

        //如果回车,cab
        if(ev.keyCode==13 && target.type!='button' && target.type!='submit' && target.type!='reset' && target.type!='textarea' && target.type!='')  {
            if (document.all) ev.keyCode=9;
            else return false;
        }
        if(ev.keyCode==39||ev.keyCode==37) {//如果是左37或右39,平移
            if (ev.keyCode==37){//左移
                //如果是最左返回
                if (target.name==cellNames[0]) return false;
                //否则往左移动
                for(var i=0;i<cellNames.length;i++){
                    if(cellNames[i]==target.name) {
                        //document.getElementsByName(cellNames[i-1])[pos].focus();
                        document.getElementsByName(cellNames[i-1])[pos].select();
                        return false;
                    }
                }
            } else if (ev.keyCode==39){//右移
                //如果是最右返回
                if (target.name==cellNames[cellNames.length]) return false;
                //否则往右移动
                for(var i=0;i<cellNames.length;i++){
                    if(cellNames[i]==target.name) {
                        document.getElementsByName(cellNames[i+1])[pos].select();
                        return false;
                    }
                }
            }
        } else if(ev.keyCode==38||ev.keyCode==40) {//如果是上38下40,竖直移动
            if(ev.keyCode==40&&pos<ts.length-1) ts[pos+1].focus();
            if(ev.keyCode==38&&pos>0) ts[pos-1].select();
        }
    }
    $('#selRscfName').autocomplete('?controller=Jichu_Gongyi&action=GetGongYiByAjax', {
        minChars: 1,
        remoteDataType:'json',
        useCache:false,
        onItemSelect:function(v){
            $('#selRscf').val(v.data[0].id);
            $('#selRscf').change();
        }
    });
    // $('#selQclName').autocomplete('?controller=Jichu_Gongyi&action=GetGongYiByAjax&kind=前处理', {
    //     minChars: 1,
    //     remoteDataType:'json',
    //     useCache:false,
    //     onItemSelect:function(v){
    //         $('#selQcl').val(v.data[0].id);
    //         $('#selQcl').change();
    //     }
    // });
    // $('#selRanseName').autocomplete('?controller=Jichu_Gongyi&action=GetGongYiByAjax&kind=染色', {
    //     minChars: 1,
    //     remoteDataType:'json',
    //     useCache:false,
    //     onItemSelect:function(v){
    //         $('#selRanse').val(v.data[0].id);
    //         $('#selRanse').change();
    //     }
    // });
    // $('#selHclName').autocomplete('?controller=Jichu_Gongyi&action=GetGongYiByAjax&kind=后处理', {
    //     minChars: 1,
    //     remoteDataType:'json',
    //     useCache:false,
    //     onItemSelect:function(v){
    //         $('#selHcl').val(v.data[0].id);
    //         $('#selHcl').change();
    //     }
    // });
});
// 给现有的助剂染料框加选择按钮
function renderWare() {
    new TmisPopup({
            obj:document.getElementsByName('mnemocode[]'),//进行渲染的目标元素,可以是document.getElementsByName('')得到的数组
            fieldInText:'wareName',//选择后对text控件进行赋值的字段
            fieldInHidden:'id',//选择后对hidden控件进行赋值的字段,默认是id
            width : 120,//渲染后的宽度
            urlPop:'?controller=JiChu_Ware&action=PopupByTree',//弹出框的地址
            titlePop:'选择染料助剂',//弹出框的标题
            widthPop:400,
            heightPop:400,
            // idHidden:'guigeId',//创建的hidden元素的id和name
            idBtn:'_btnWare',//创建的按钮的id
            isArray:true,//if true,创建的元素以[]结尾
            onSelect: function(json){
                //debugger;
                //alert('取得联系人');
                //dump(json);return false;
            }//选择某个记录后的触发动作
        });
}
//如果没有处方人,提示在基础档案中增加
function showMsg(obj){
    if (obj.options.length==1) {
        alert('开工艺单前请确认工艺科的员工资料齐全,基础档案中的员工档案新增时部门选择为"工艺科",保存后即可!');
    };
}

function checkSelect() {
    if (document.getElementById('chufangrenId').value == 0) {
        alert('请选择处方人!');
        return false;
    }
    else return true;
}

function init() {
    document.onkeydown=keyDown
}

function addrow(id){
        //alert(id); return false;
        var tbl = document.getElementById(id);
        var rows = tbl.rows;
        var gongxuId = $('[name="gongxuId[]"]',rows[1]).val();
        var lastRow = rows[rows.length-1];
        for (var i=0;i<5;i++) {
            var newRow = lastRow.cloneNode(true);
            //lastRow.parentNode.insertBefore(newRow,lastRow);
            lastRow.parentNode.appendChild(newRow);
            // newRow.style.display = 'block';

            //清空text
            newRow.cells[0].innerHTML='<input style="width:80px;" name="mnemocode[]" type="text"id="mnemocode[]" value=""> <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value=""><input name="gongxuId[]" type="hidden" id="gongxuId[]" value="'+gongxuId+'">';
            var t = newRow.cells[0];

            new TmisSuggest.AutoSuggest($(t).find('input[name="mnemocode[]"]')[0],null,[{
                RequestUrl: "?controller=JiChu_Ware&action=GetSuggestJson",
                OverWidth: 0
            }]);
        }
        renderWare();
}
function keyDown(e) {
    if(event.keyCode==13) {
        event.keyCode=9
    }
}
$(function(){
    var test = $("#form1");
    var arr = document.getElementsByName('mnemocode[]');
    for (var i=0;i<arr.length;i++) {
        new TmisSuggest.AutoSuggest(arr[i],null,[{
            RequestUrl: "?controller=JiChu_Ware&action=GetSuggestJson",
            OverWidth: 0
        }]);
    }

});

function getRese2ware(){
    var rs = document.getElementById('selRanse');
    var kind=2;
    if(rs=='') return false;

    $.getJSON('Index.php?controller=Gongyi_Dye_Chufang&action=Popgongyi&id='+rs.value,null,function(json){
        //行数不够动态添加
        // debugger;
        if(json['GongyiWares']!=null){
            json[1]=json['GongyiWares'];
            var a=json[1].length;
            var b=$('#tbl input[name="mnemocode[]"]').length;
            var tbl = document.getElementById('tbl');
            var rows = tbl.rows;
            var lastRow = rows[rows.length-1];
            if(a>b){
                for(var i=0; i<a-b; i++){
                    var newRow = lastRow.cloneNode(true);
                    lastRow.parentNode.appendChild(newRow,lastRow);
                    newRow.cells[0].innerHTML='<input style="width:80px;" name="mnemocode[]" type="text"id="mnemocode[]" value=""> <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value=""><input name="gongxuId[]" type="hidden" id="gongxuId[]" value="2">';
                    var t = newRow.cells[0];
                    new TmisSuggest.AutoSuggest($(t).children()[0],null,[{
                        RequestUrl: "?controller=JiChu_Ware&action=GetSuggestJson",
                        OverWidth: 0
                    }]);
                }
            }
            renderWare();
        }
        var unitKg1=$('#tbl input[name="unitKg[]"]');
        var un1=$('#tbl select[name="unit[]"]');
        var tmp1=$('#tbl input[name="tmp[]"]');
        var timeRs1=$('#tbl input[name="timeRs[]"]');
        var chufang2WareId=$('#tbl input[name="chufang2WareId[]"]');
        //清空所有内容

        var j=0;
        $('#tbl input[name="mnemocode[]"]').each(function(){
            this.value='';
            unitKg1[j].value='';
            tmp1[j].value='';
            timeRs1[j].value='';
            j++;
        });
        //var tt=document.getElementsByName('mnemocode[]');
        //var ss=$('#tbl2 input[name="mnemocode[]"]');
        //alert(un.length); return false;
        //赋值

        if(json['GongyiWares']!=null){
            json[1]=json['GongyiWares'];
              var i=0;
             $('#tbl input[name="mnemocode[]"]').each(function(){
                if(json[1][i]==null){return false;}
                if(!json[1][i].Ware.id){
                    this.value='';
                }
                else{
                    this.value=json[1][i].Ware.mnemocode+':'+json[1][i].Ware.wareName+' '+json[1][i].Ware.guige+'         /'+json[1][i].Ware.id;
                }
                for(var j=0; j<un1[i].length;j++){
                    var op=un1[i].options[j];
                    if(op.value==json[1][i]['unit']){
                        op.selected=true;
                    }
                }
                //chufang2WareId[i].value=json[1][i].Ware.id;
                unitKg1[i].value=json[1][i].unitKg;
                tmp1[i].value=json[1][i].tmp;
                timeRs1[i].value=json[1][i].timeRs;
                i++;
             });
        }

    });

}


function getHcl2ware(){
    var hcl=document.getElementById('selHcl');
    if(hcl.value=='') return false;
    $.getJSON('Index.php?controller=Gongyi_Dye_Chufang&action=Popgongyi&id='+hcl.value,null,function(json){
        json[0]=json['GongyiWares'];
        if(json[0]!=null){
            var a=json[0].length;
            var b=$('#tbl2 input[name="mnemocode[]"]').length;
            var tbl = document.getElementById('tbl2');
            var rows = tbl.rows;
            var lastRow = rows[rows.length-1];
            //alert(a+'sssssssss'+b); return false;
            if(a>b){
                for(var i=0; i<a-b; i++){
                    var newRow = lastRow.cloneNode(true);
                    // debugger;
                    lastRow.parentNode.appendChild(newRow,lastRow);
                    newRow.cells[0].innerHTML='<input style="width:80px;" name="mnemocode[]" type="text"id="mnemocode[]" value=""> <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value=""><input name="gongxuId[]" type="hidden" id="gongxuId[]" value="3">';
                    var t = newRow.cells[0];
                    new TmisSuggest.AutoSuggest($(t).children()[0],null,[{
                        RequestUrl: "?controller=JiChu_Ware&action=GetSuggestJson",
                        OverWidth: 0
                    }]);
                }
            }
            renderWare();

        }

        //var zl=document.getElementsByName('zhengli');
        var unitKg=$('#tbl2 input[name="unitKg[]"]');
        var un=$('#tbl2 select[name="unit[]"]');
        var tmp=$('#tbl2 input[name="tmp[]"]');
        var timeRs=$('#tbl2 input[name="timeRs[]"]');
        var memo=$('#tbl2 input[name="memo[]"]');
        //清空所有内容
        var j=0;
        $('#tbl2 input[name="mnemocode[]"]').each(function(){
            this.value='';
            //zl[j].innerHTML='';
            unitKg[j].value='';
            tmp[j].value='';
            timeRs[j].value='';
            j++;

        });

        //赋值
        if(json[0]!=null){
             var i=0;
             $('#tbl2 input[name="mnemocode[]"]').each(function(){
                if(json[0][i]==null){return false;}
                if(!json[0][i].Ware.id){
                    this.value='';
                }
                else{
                    this.value=json[0][i].Ware.mnemocode+':'+json[0][i].Ware.wareName+' '+json[0][i].Ware.guige+'        /'+json[0][i].Ware.id;
                }
                //zl[i].innerHTML=json[0][i].Class;
                //下拉框选项处理
                for(var j=0; j<un[i].length;j++){
                    var op=un[i].options[j];
                    if(op.value==json[0][i]['unit']){
                        op.selected=true;
                    }
                }

                unitKg[i].value=json[0][i].unitKg;
                tmp[i].value=json[0][i].tmp;
                timeRs[i].value=json[0][i].timeRs;
                i++;
             });
        }

    });

}

function getQcl2ware(){
    var qcl=document.getElementById('selQcl');
    if(qcl.value=='') return false;
    $.getJSON('Index.php?controller=Gongyi_Dye_Chufang&action=Popgongyi&id='+qcl.value,null,function(json){
        json[0]=json['GongyiWares'];
        if(json[0]!=null){
            var a=json[0].length;
            var b=$('#tbl3 input[name="mnemocode[]"]').length;
            var tbl = document.getElementById('tbl3');
            var rows = tbl.rows;
            var lastRow = rows[rows.length-1];
            //alert(a+'sssssssss'+b); return false;
            if(a>b){
                for(var i=0; i<a-b; i++){
                    var newRow = lastRow.cloneNode(true);
                    lastRow.parentNode.appendChild(newRow,lastRow);
                    newRow.cells[0].innerHTML='<input style="width:80px;" name="mnemocode[]" type="text"id="mnemocode[]" value=""> <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value=""><input name="gongxuId[]" type="hidden" id="gongxuId[]" value="1">';
                    var t = newRow.cells[0];
                    new TmisSuggest.AutoSuggest($(t).children()[0],null,[{
                        RequestUrl: "?controller=JiChu_Ware&action=GetSuggestJson",
                        OverWidth: 0
                    }]);
                }
            }
            renderWare();

        }

        //var zl=document.getElementsByName('zhengli');
        var unitKg=$('#tbl3 input[name="unitKg[]"]');
        var un=$('#tbl3 select[name="unit[]"]');
        var tmp=$('#tbl3 input[name="tmp[]"]');
        var timeRs=$('#tbl3 input[name="timeRs[]"]');
        var memo=$('#tbl3 input[name="memo[]"]');
        //清空所有内容
        var j=0;
        $('#tbl3 input[name="mnemocode[]"]').each(function(){
            this.value='';
            //zl[j].innerHTML='';
            unitKg[j].value='';
            tmp[j].value='';
            timeRs[j].value='';
            j++;

        });

        //赋值
        if(json[0]!=null){
             var i=0;
             $('#tbl3 input[name="mnemocode[]"]').each(function(){
                if(json[0][i]==null){return false;}
                if(!json[0][i].Ware.id){
                    this.value='';
                }
                else{
                    this.value=json[0][i].Ware.mnemocode+':'+json[0][i].Ware.wareName+' '+json[0][i].Ware.guige+'        /'+json[0][i].Ware.id;
                }
                //zl[i].innerHTML=json[0][i].Class;
                //下拉框选项处理
                for(var j=0; j<un[i].length;j++){
                    var op=un[i].options[j];
                    if(op.value==json[0][i]['unit']){
                        op.selected=true;
                    }
                }

                unitKg[i].value=json[0][i].unitKg;
                tmp[i].value=json[0][i].tmp;
                timeRs[i].value=json[0][i].timeRs;
                i++;
             });
        }

    });

}
function getChufang2ware(){
    var selRscf = document.getElementById('selRscf');
    if(selRscf.value=='') return false;
    $.getJSON('Index.php?controller=Gongyi_Dye_Chufang&action=Popgongyi&id='+selRscf.value,null,function(json){
        json[0]=json['GongyiWares'];
        if(json[0]!=null){
            var a=json[0].length;
            var b=$('#tbl4 input[name="mnemocode[]"]').length;
            var tbl = document.getElementById('tbl4');
            var rows = tbl.rows;
            var lastRow = rows[rows.length-1];
            //alert(a+'sssssssss'+b); return false;
            if(a>b){
                for(var i=0; i<a-b; i++){
                    var newRow = lastRow.cloneNode(true);
                    lastRow.parentNode.appendChild(newRow,lastRow);
                    newRow.cells[0].innerHTML='<input style="width:80px;" name="mnemocode[]" type="text"id="mnemocode[]" value=""> <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value=""><input name="gongxuId[]" type="hidden" id="gongxuId[]" value="4">';
                    var t = newRow.cells[0];
                    new TmisSuggest.AutoSuggest($(t).children()[0],null,[{
                        RequestUrl: "?controller=JiChu_Ware&action=GetSuggestJson",
                        OverWidth: 0
                    }]);
                }
            }
            renderWare();

        }

        //var zl=document.getElementsByName('zhengli');
        var unitKg=$('#tbl4 input[name="unitKg[]"]');
        var un=$('#tbl4 select[name="unit[]"]');
        var tmp=$('#tbl4 input[name="tmp[]"]');
        var timeRs=$('#tbl4 input[name="timeRs[]"]');
        var memo=$('#tbl4 input[name="memo[]"]');
        //清空所有内容
        var j=0;
        $('#tbl4 input[name="mnemocode[]"]').each(function(){
            this.value='';
            //zl[j].innerHTML='';
            unitKg[j].value='';
            tmp[j].value='';
            timeRs[j].value='';
            j++;

        });

        //赋值
        if(json[0]!=null){
             var i=0;
             $('#tbl4 input[name="mnemocode[]"]').each(function(){
                if(json[0][i]==null){return false;}
                if(!json[0][i].Ware.id){
                    this.value='';
                }
                else{
                    this.value=json[0][i].Ware.mnemocode+':'+json[0][i].Ware.wareName+' '+json[0][i].Ware.guige+'        /'+json[0][i].Ware.id;
                }
                //zl[i].innerHTML=json[0][i].Class;
                //下拉框选项处理
                for(var j=0; j<un[i].length;j++){
                    var op=un[i].options[j];
                    if(op.value==json[0][i]['unit']){
                        op.selected=true;
                    }
                }

                unitKg[i].value=json[0][i].unitKg;
                tmp[i].value=json[0][i].tmp;
                timeRs[i].value=json[0][i].timeRs;
                i++;
             });
        }

    });
}
//单击用量时，设置文本为select（）状态
function getSel(obj){
    obj.select();
}
function select1(obj){
    var url="?controller=Jichu_Gongyi&action=Popup&kind=前处理";
    ymPrompt.win({message:url,handler:callBack,width:550,height:500,title:'选择方案',iframe:true});
    return false;
    function callBack(ret){
        $('#selQclName').val(ret.gongyiName);
        $('#selQcl').val(ret.id);
        $('#selQcl').change();
    }
}
function select2(obj){
    var url="?controller=Jichu_Gongyi&action=Popup&kind=染色助剂";
    ymPrompt.win({message:url,handler:callBack,width:550,height:500,title:'选择方案',iframe:true});
    return false;
    function callBack(ret){
        $('#selRanseName').val(ret.gongyiName);
        $('#selRanse').val(ret.id);
        $('#selRanse').change();
    }
}
function select3(obj){
    var url="?controller=Jichu_Gongyi&action=Popup&kind=后处理";
    ymPrompt.win({message:url,handler:callBack,width:550,height:500,title:'选择方案',iframe:true});
    return false;
    function callBack(ret){
        $('#selHclName').val(ret.gongyiName);
        $('#selHcl').val(ret.id);
        $('#selHcl').change();
    }
}
function select4(obj){
    var url="?controller=Jichu_Gongyi&action=Popup&kind=染色染料";
    ymPrompt.win({message:url,handler:callBack,width:550,height:500,title:'选择方案',iframe:true});
    return false;
    function callBack(ret){
        $('#selRscfName').val(ret.gongyiName);
        $('#selRscf').val(ret.id);
        $('#selRscf').change();
    }
}   
//删除
/*function delRow(obj,id,tbl) {
    debugger;
    var _tbl=document.getElementById(tbl);
    if(!confirm('确认删除吗?')) return false;
    var pos =-1;
    var objs = document.getElementsByName(obj.name);
    for(var i=0;objs[i];i++) {
        if(objs[i]==obj) {
            pos=i;break;
        }
    }
    //alert(id);
    if(pos==-1) return false;

    if(!id) _tbl.deleteRow(pos+1);
    else {
        //alert(1);
        var url='?controller=Gongyi_Dye_Chufang&action=removeByAjax';
        var param={id:id}
        $.getJSON(url,param,function(json){
            if(!json.success) {
                alert(json.msg);
                return false;
            }
            _tbl.deleteRow(pos+1);
        });
    }
}*/

</script>
{/literal}
</head>
<body>
<div id='container'>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChufang4Merge'}" method="post" onSubmit="return checkSelect();" AUTOCOMPLETE="OFF">
  <fieldset>
  <legend>处方管理</legend>
<fieldset style="width:1000px;">
<legend>基本信息</legend>
<table width="100%">
    <tr>
      <td nowrap>日期：<input name="dateChufang" type="text" id="dateChufang" value="{$chufang.dateChufang|default:$smarty.now|date_format:'%Y-%m-%d'}" ></td><!-- onClick="calendar()" -->
      <td nowrap>工艺类别：
        <select name="dyeKind" id="dyeKind">
        <option value="一般" {if $chufang.dyeKind=='一般'}selected{/if}>一般</option>
        <option value="活性" {if $chufang.dyeKind=='活性'}selected{/if}>活性</option>
        <option value="分散" {if $chufang.dyeKind=='分散'}selected{/if}>分散</option>
          </select></td>
      <td nowrap><!--处方类型：
          <select name="dyeKind" id="dyeKind" onChange="getGongyi()">
                <option value="">请选择</option>
                {foreach from=$gongyi item=item}
                    <option value="{$item.id}" {if $chufang.dyeKind==$item.id}selected{/if}>{$item.gongyiName}</option>
                {/foreach}
            </select>-->
            染化料折率：<input name="rhlZhelv" type="text" id="rhlZhelv" value="{$chufang.rhlZhelv|default:'1'}" size="5">
            </td>
      <td nowrap>处方人：
          <select name="chufangrenId" id="chufangrenId" onFocus="showMsg(this)">
                {if $chufangren!=''}
                    <option value="">请选择</option>
                    <option value="{$chufangren.id}" {if $chufang.chufangrenId==$chufangren.id}selected{/if}>{$chufangren.employName}</option>
                {else}
                  {webcontrol type='TmisOptions' model='JiChu_Employ' selected=$chufang.chufangrenId condition='depId=13'}
                {/if}
          </select></td>
      <td nowrap>染色类别：
        <select name="ranseKind" id="ranseKind">
            <option value="漂染" {if $chufang.ranseKind=='漂染'}selected{/if}>漂染</option>
            <option value="煮染" {if $chufang.ranseKind=='煮染'}selected{/if}>煮染</option>
            <option value="分漂" {if $chufang.ranseKind=='分漂'}selected{/if}>分漂</option>
            <option value="分清" {if $chufang.ranseKind=='分清'}selected{/if}>分清</option>
            <option value="套棉" {if $chufang.ranseKind=='套棉'}selected{/if}>套棉</option>
        </select>
      </td>
      <td>物流缸号：{$binggang.Vat.vatCode}</td>
      <td>标记完成：<input type='checkbox' value='1' name='isComplete' id='isComplete' /></td></tr>

        {foreach from=$gangs item=aGang}
      <tr bgcolor="#CCCCCC">
          <td colspan="7">缸号:{$aGang.vatNum}
            <input type="hidden" name="gangId[]" id="gangId[]" value="{$aGang.id}">
            <input type="hidden" name="order2wareId[]" id="order2wareId[]" value="{$aGang.order2wareId}">
            <input type="hidden" name="chufangId[]" id="chufangId[]" value="">
            &nbsp;&nbsp;颜色:{$aGang.OrdWare.color}
            &nbsp;&nbsp;投料数:{$aGang.cntPlanTouliao}
            &nbsp;&nbsp;折率:<input name="zhelv[]" type="text" id="zhelv[]" value="{$aGang.zhelv}" size="5">
            &nbsp;&nbsp;水容量：
            <select name="shuirong[]" id="shuirong[]">
              <option value="{$aGang.Vat.shuiRong}">{$aGang.Vat.shuiRong}</option>
                    {if $aGang.Vat.shuiRong1>0}
              <option value="{$aGang.Vat.shuiRong1}" {if $aGang.shuirong==$aGang.Vat.shuiRong1}selected{/if}>{$aGang.Vat.shuiRong1}</option>
                    {/if}
              </select>
            <input id='shuirong2[]' name='shuirong2[]' type="text" value="{$aGang.shuirong}" size="5">
            &nbsp;&nbsp;浴比：<span id="yubi" name="yubi" style="font-size: 13">{$aGang.Vat.shuiRong/$aGang.cntPlanTouliao|string_format:"%.2f"}</span>
           </td>
          </tr>
        {/foreach}
</table>
</fieldset>
<table align="left" width="100%">
<!-- 染色染料 -->
<tr>
<td align="center" valign="top">
<div>
<fieldset style="width:700px;">
<legend> 染色染料方案:  
<!--     <select name="selRscf" id="selRscf" style="width:auto;" onChange="getChufang2ware()">
      <option value="">请选择</option>
      {foreach from=$rscfRow item=item}
      <option value="{$item.id}" {if $item.id==$chufang.rscfId}selected{/if}>{$item.gongyiName}</option>
      {/foreach}
    </select> -->
    <span><input type="text" name="selRscfName" id="selRscfName" value="{$selRscfName}"  style="width:80px;" readonly><input type="button" name="btnSel" id="btnSel" value=".." onClick="select4(this)"></span>
    <input type="hidden" name="selRscf" id="selRscf" value="{$chufang.rscfId}" onChange="getChufang2ware()">
    别名:<input type="input" name="memoCf" id="memoCf" value="{$chufang.memoCf}" style="width:70px;" title='别名' emptytext="别名" placeholder="别名">
</legend>
<table class="tableHaveBorder table100" width="100%" id='tbl4'>
    <tr class="th">
      <td>助剂</td>
      <td>用量g/升</td>
      <td>温度℃</td>
      <td>时间(分钟)</td>
      <td>备注</td>
      <!--<td>删除</td>-->
      </tr>
    {section name=loop4 loop=$loop4}
    <tr>
      <td align="center">
        <input style="width:80px;" name="mnemocode[]" type="text" id="mnemocode[]" value="{if $rscf[loop4].id>0}{$rscf[loop4].Ware.mnemocode}:{$rscf[loop4].Ware.wareName} {$rscf[loop4].Ware.guige}             /{$rscf[loop4].Ware.id}{/if}">

        <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value="{if $smarty.get.editModel!='copy'}{$rscf[loop4].id}{/if}"><input name="gongxuId[]" type="hidden" id="gongxuId[]" value="4"></td>
      <td align="center">
        <input name="unitKg[]" type="text" id="unitKg[]" value="{$rscf[loop4].unitKg}"  class="input100" onClick="getSel(this)">
        <select name="unit[]" id="unit[]">
            <option value="%" {if $rscf[loop4].unit=='%'}} selected {/if} >%</option>
            <option value="g/升" {if $rscf[loop4].unit=='g/升'}} selected {/if} >g/升</option>
            <option value="g/包" {if $rscf[loop4].unit=='g/包'}} selected {/if} >g/包</option>
        </select></td>
      <td align="center"><strong>
        <input name="tmp[]" type="text" id="tmp[]" value="{$rscf[loop4].tmp}"  class="input100">
      </strong></td>
      <td align="center"><strong>
        <input name="timeRs[]" type="text" id="timeRs[]" value="{$rscf[loop4].timeRs}"  class="input100">
      </strong></td>
      <td align="center"><input name="memo[]" type="text" id="memo[]" value="{$rscf[loop4].memo}"  class="input100"></td>
    <!--  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this,{if $smarty.get.editModel!='copy'}{$rscf[loop4].id}{else}0{/if},tbl2)"></td>-->
      </tr>
    {/section}

    <tr>
      <td align="center">
        <input style="width:80px;" name="mnemocode[]" type="text" id="mnemocode[]" value="">

        <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value="">
        <input name="gongxuId[]" type="hidden" id="gongxuId[]" value="4">
      </td>
      <td align="center">
        <input name="unitKg[]" type="text" id="unitKg[]" value="" class="input100" onClick="getSel(this)">
        <select name="unit[]" id="unit[]">
            <option value="%">%</option>
            <option value="g/升">g/升</option>
            <option value="g/包">g/包</option>
        </select></td>
      <td align="center">
        <input name="tmp[]" type="text" id="tmp[]" value="" class="input100">
      </td>
      <td align="center">
        <input name="timeRs[]" type="text" id="timeRs[]" class="input100">
      </td>
      <td align="center"><input name="memo[]" type="text" id="memo[]"  class="input100"></td>
      <!--<td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this,0,tbl2)"></td>-->
      </tr>
</table>
<div align="right">
  <input type="button" name="addRow" id="addRow" onClick="addrow('tbl4')" value=" +5行 ">
</div>
</fieldset>
</div>
</td>
</tr>
<!-- 前处理方案 -->  
<tr>
<td align="center" valign="top">
<fieldset style="width:700px;">
<legend> 前处理方案:  
<!--     <select name="selQcl" id="selQcl" style="width:auto;" onChange="getQcl2ware()">
    <option value="">请选择</option>
    {foreach from=$qclRow item=item}
    <option value="{$item.id}" {if $item.id==$chufang.qclId}selected{/if}>{$item.gongyiName}</option>
    {/foreach}
    </select> -->
    <span><input type="text" name="selQclName" id="selQclName" value="{$selQclName}"  style="width:80px;" readonly><input type="button" name="btnSel" id="btnSel" value=".." onClick="select1(this)"></span>
    <input type="hidden" name="selQcl" id="selQcl" value="{$chufang.qclId}" onChange="getQcl2ware()">  
    别名:<input type="input" name="memoQcl" id="memoQcl" value="{$chufang.memoQcl}"  style="width:70px;" title='别名' emptytext="别名" placeholder="别名">
  </legend>
<table class="tableHaveBorder table100" width="100%" id='tbl3'>
    <tr class="th">
      <td height="55">助剂</td>
      <td>用量g/升</td>
      <td>温度℃</td>
      <td>时间(分钟)</td>
      <td>备注</td>
      <!--<td>删除</td>-->
      </tr>
    {section name=loop3 loop=$loop3}
    <tr>
      <td align="center">
        <input style="width:80px;" name="mnemocode[]" type="text" id="mnemocode[]" value="{if $qcl[loop3].id>0}{$qcl[loop3].Ware.mnemocode}:{$qcl[loop3].Ware.wareName} {$qcl[loop3].Ware.guige}           /{$qcl[loop3].Ware.id}{/if}">

        <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value="{if $smarty.get.editModel!='copy'}{$qcl[loop3].id}{/if}"><input name="gongxuId[]" type="hidden" id="gongxuId[]" value="1"></td>
      <td align="center">
        <input name="unitKg[]" type="text" id="unitKg[]" value="{$qcl[loop3].unitKg}"  class="input100" onClick="getSel(this)">
        <select name="unit[]" id="unit[]">
          <option value="g/升" {if $qcl[loop3].unit=='g/升'}} selected {/if} >g/升</option>
          <option value="g/包" {if $qcl[loop3].unit=='g/包'}} selected {/if} >g/包</option>
          <option value="%" {if $qcl[loop3].unit=='%'}} selected {/if} >%</option>
          </select></td>
      <td align="center"><strong>
        <input name="tmp[]" type="text" id="tmp[]" value="{$qcl[loop3].tmp}"  class="input100">
      </strong></td>
      <td align="center"><strong>
        <input name="timeRs[]" type="text" id="timeRs[]" value="{$qcl[loop3].timeRs}"  class="input100">
      </strong></td>
      <td align="center"><input name="memo[]" type="text" id="memo[]" value="{$qcl[loop3].memo}"  class="input100"></td>
    <!--  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this,{if $smarty.get.editModel!='copy'}{$zhuji[loop2].id}{else}0{/if},tbl2)"></td>-->
      </tr>
    {/section}

    <tr>
      <td align="center">
        <input style="width:80px;" name="mnemocode[]" type="text" id="mnemocode[]" value="">

        <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value="">
        <input name="gongxuId[]" type="hidden" id="gongxuId[]" value="1">
      </td>
      <td align="center">
        <input name="unitKg[]" type="text" id="unitKg[]" value="" class="input100" onClick="getSel(this)">
        <select name="unit[]" id="unit[]">
          <option value="g/升" >g/升</option>
          <option value="g/包">g/包</option>
          <option value="%">%</option>
          </select></td>
      <td align="center">
        <input name="tmp[]" type="text" id="tmp[]" value="" class="input100">
      </td>
      <td align="center">
        <input name="timeRs[]" type="text" id="timeRs[]" class="input100">
      </td>
      <td align="center"><input name="memo[]" type="text" id="memo[]"  class="input100"></td>
      <!--<td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this,0,tbl2)"></td>-->
      </tr>
</table>
<div align="right">
  <input type="button" name="addRow" id="addRow" onClick="addrow('tbl3')" value=" +5行 ">
</div>
</fieldset></td>

</tr>
<tr><td align="center" valign="top" style="width:45%">
<fieldset style="width:700px;">
<legend> 染色助剂:  
<!--     <select name="selRanse" id="selRanse" style="width:auto;" onChange="getRese2ware()">
    <option value="">请选择</option>
    {foreach from=$rsRow item=item}
    <option value="{$item.id}" {if $item.id==$chufang.rsgyId}selected{/if}>{$item.gongyiName}</option>
    {/foreach}
    </select> -->
    <span><input type="text" name="selRanseName" id="selRanseName" value="{$selRanseName}"  style="width:80px;" readonly><input type="button" name="btnSel" id="btnSel" value=".." onClick="select2(this)"></span>
    <input type="hidden" name="selRanse" id="selRanse" value="{$chufang.rsgyId}" onChange="getRese2ware()"> 
    别名:<input type="input" name="memoRs" id="memoRs" value="{$chufang.memoRs}" style="width:70px;" title='别名' emptytext="别名" placeholder="别名">
  </legend>
<table class="tableHaveBorder table100" width="100%" id='tbl'>
  <tr class="th">
    <td>染料</td>
    <td>用量g/包</td>
    <td >温度℃</td>
    <td>时间(分)</td>
    <td>备注</td>
<!--    <td>操作</td>-->
  </tr>
  {section name=loop loop=$loop}
  <tr>
    <td align="center"><input style="width:80px;" name="mnemocode[]" type="text" id="mnemocode[]" value="{if $ranliao[loop].id>0}{$ranliao[loop].Ware.mnemocode}:{$ranliao[loop].Ware.wareName} {$ranliao[loop].Ware.guige}         /{$ranliao[loop].Ware.id}{/if}">
      <!-- <input name="DD2" type="button" id="DD" value="∨"> -->
      <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value="{if $smarty.get.editModel!='copy'}{$ranliao[loop].id}{/if}">
      <input name="gongxuId[]" type="hidden" id="gongxuId[]" value="2"></td>
    <td align="center"><input name="unitKg[]" type="text" id="unitKg[]" value="{$ranliao[loop].unitKg}"  class="input100" onClick="getSel(this)">
      <select name="unit[]" id="unit[]">
        <option value="g/升" {if $ranliao[loop].unit=='g/升'}} selected {/if} >g/升</option>
        <option value="g/包" {if $ranliao[loop].unit=='g/包'}} selected {/if} >g/包</option>
        <option value="%" {if $ranliao[loop].unit=='%'}} selected {/if} >%</option>
      </select>


      </td>
    <td align="center"><input name="tmp[]" type="text" id="tmp[]" value="{$ranliao[loop].tmp}"  class="input100"></td>
    <td align="center"><input name="timeRs[]" type="text" id="timeRs[]" value="{$ranliao[loop].timeRs}"  class="input100"></td>
    <td align="center"><input name="memo[]" type="text" id="memo[]" value="{$ranliao[loop].memo}"  class="input100"></td>
   <!-- <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this,{if $smarty.get.editModel!='copy'}{$ranliao[loop].id}{/if},tbl)"></td>-->
  </tr>
  {/section}
  <tr>
    <td align="center"><input style="width:80px;" name="mnemocode[]" type="text" id="mnemocode[]">
      <!-- <input name="DD2" type="button" id="DD" value="∨"> -->
      <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value="">
      <input name="gongxuId[]" type="hidden" id="gongxuId[]" value="2"></td>
    <td align="center"><input name="unitKg[]" type="text" id="unitKg[]"  class="input100" onClick="getSel(this)">
      <select name="unit[]" id="unit[]">
        <option value="g/升" >g/升</option>    
        <option value="g/包">g/包</option>
        <option value="%">%</option>
      </select></td>
    <td align="center"><input name="tmp[]" type="text" id="tmp[]"  class="input100"></td>
    <td align="center"><input name="timeRs[]" type="text" id="timeRs[]"  class="input100"></td>
    <td align="center"><input name="memo[]" type="text" id="memo[]"  class="input100"></td>
    <!--<td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this,0,tbl)"></td>-->
  </tr>
</table>
<div align="right">
  <input type="button" name="addRow1" id="addRow1" onClick="addrow('tbl')" value=" +5行 ">
</div>
</fieldset>
</td>
</tr><tr>
<td align="center" valign="top">
<fieldset style="width:700px;">
<legend> 后处理方案:  
<!--     <select name="selHcl" id="selHcl" style="width:auto;" onChange="getHcl2ware()">
    <option value="">请选择</option>
    {foreach from=$hclRow item=item}
    <option value="{$item.id}" {if $item.id==$chufang.hclId}selected{/if}>{$item.gongyiName}</option>
    {/foreach}
    </select> -->
    <span><input type="text" name="selHclName" id="selHclName" value="{$selHclName}"  style="width:80px;" readonly><input type="button" name="btnSel" id="btnSel" value=".." onClick="select3(this)"></span>
    <input type="hidden" name="selHcl" id="selHcl" value="{$chufang.hclId}" onChange="getHcl2ware()">
    别名:<input type="input" name="memoHcl" id="memoHcl" value="{$chufang.memoHcl}" style="width:70px;" title='别名' emptytext="别名" placeholder="别名">
  </legend>
<table class="tableHaveBorder table100" width="100%" id='tbl2'>
    <tr class="th">
      <td>助剂</td>
      <td>用量g/升</td>
      <td>温度℃</td>
      <td>时间(分钟)</td>
      <td>备注</td>
      <!--<td>删除</td>-->
      </tr>
    {section name=loop2 loop=$loop2}
    <tr>
      <td align="center">
        <input style="width:80px;" name="mnemocode[]" type="text" id="mnemocode[]" value="{if $zhuji[loop2].id>0}{$zhuji[loop2].Ware.mnemocode}:{$zhuji[loop2].Ware.wareName} {$zhuji[loop2].Ware.guige}             /{$zhuji[loop2].Ware.id}{/if}">

        <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value="{if $smarty.get.editModel!='copy'}{$zhuji[loop2].id}{/if}"><input name="gongxuId[]" type="hidden" id="gongxuId[]" value="3"></td>
      <td align="center">
        <input name="unitKg[]" type="text" id="unitKg[]" value="{$zhuji[loop2].unitKg}"  class="input100" onClick="getSel(this)">
        <select name="unit[]" id="unit[]">
          <option value="g/升" {if $zhuji[loop2].unit=='g/升'}} selected {/if} >g/升</option>
          <option value="g/包" {if $zhuji[loop2].unit=='g/包'}} selected {/if} >g/包</option>
          <option value="%" {if $zhuji[loop2].unit=='%'}} selected {/if} >%</option>
          </select></td>
      <td align="center"><strong>
        <input name="tmp[]" type="text" id="tmp[]" value="{$zhuji[loop2].tmp}"  class="input100">
      </strong></td>
      <td align="center"><strong>
        <input name="timeRs[]" type="text" id="timeRs[]" value="{$zhuji[loop2].timeRs}"  class="input100">
      </strong></td>
      <td align="center"><input name="memo[]" type="text" id="memo[]" value="{$zhuji[loop2].memo}"  class="input100"></td>
    <!--  <td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this,{if $smarty.get.editModel!='copy'}{$zhuji[loop2].id}{else}0{/if},tbl2)"></td>-->
      </tr>
    {/section}

    <tr>
      <td align="center">
        <input style="width:80px;" name="mnemocode[]" type="text" id="mnemocode[]" value="">

        <input name="chufang2WareId[]" type="hidden" id="chufang2WareId[]" value="">
        <input name="gongxuId[]" type="hidden" id="gongxuId[]" value="3">
      </td>
      <td align="center">
        <input name="unitKg[]" type="text" id="unitKg[]" value="" class="input100" onClick="getSel(this)">
        <select name="unit[]" id="unit[]">
          <option value="g/升">g/升</option>
          <option value="g/包">g/包</option>
          <option value="%">%</option>
          </select></td>
      <td align="center">
        <input name="tmp[]" type="text" id="tmp[]" value="" class="input100">
      </td>
      <td align="center">
        <input name="timeRs[]" type="text" id="timeRs[]" class="input100">
      </td>
      <td align="center"><input name="memo[]" type="text" id="memo[]"  class="input100"></td>
      <!--<td align="center"><input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this,0,tbl2)"></td>-->
      </tr>
</table>
<div align="right">
  <input type="button" name="addRow" id="addRow" onClick="addrow('tbl2')" value=" +5行 ">
</div>
</fieldset></td></tr>
 
</table>
<br><br>
<div style="clear:both; color:red;">注：如果在修改时想删除某个染化料助剂，将欲删除的染化料助剂的数量设为0,保存后系统会自动将该染化料助剂删除。</div>
<div align="center">
    <input name="Submit" type="submit" value='确定并返回' id="Submit">
    <input name="Submit" type="submit" value='确定并打印' id="Submit">
  <input name="return" type="hidden" id="return" value="{$smarty.get.return}">
  <input name="bgVatId" type="hidden" id="bgVatId" value="{$binggang.vatId}">
  <input name="bgShuirong" type="hidden" id="bgShuirong" value="{$binggang.Vat.shuiRong}">
</div>
<br>
</fieldset></form></div></body></html>
