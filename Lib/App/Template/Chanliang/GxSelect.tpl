<!DOCTYPE html>
<html>
<head>
<title>选择码单</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="Resource/Script/jquery.1.9.1.js"></script>
<script language="javascript" src="Resource/Script/layer/layer.js"></script>
<link href="Resource/bootstrap/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<script type="text/javascript">
var controller = '{$smarty.get.controller}';
var index = '{$smarty.get.index}';
var gxIds=parent.$('[name="gxIds[]"]').eq(index).val();
{literal}
$(function(){
    //初始化显示的数据
    if(gxIds){
        var gxId = gxIds.split(',');

        if (!Array.prototype.indexOf){ Array.prototype.indexOf = function(elt /*, from*/){ var len = this.length >>> 0; var from = Number(arguments[1]) || 0; from = (from < 0) ? Math.ceil(from) : Math.floor(from); if (from < 0) from += len; for (; from < len; from++) { if (from in this && this[from] === elt) return from; } return -1; }; }

        //选中之前选择的数据，
        $('[name="docheck[]"]').each(function(){
            if(gxId.indexOf(this.value)>=0){
                $(this).prop('checked',true);
            }
        });
    }
   
    //全选/反选
    $('[name="sel"]').click(function(){
        $('[name="docheck[]"]').prop('checked',this.checked);
       
    });
    $(".form-control p").mouseover(function(){
        $(this).attr('title',$(this).attr('titles'));
    });

    //ok
    $('#ok').click(function(){
        var che_data = getSelData();
        if(!che_data.gongxuIds){
            layer.alert("先选择要标记的布卷信息");
        }

        //返回已选择的数据
        var obj = {'gongxuIds':che_data.gongxuIds,'gxName':che_data.gxName,'danjia':che_data.danjia};
        parent.layer.callback(index,obj);
        parent.tb_remove();
    });

    //back
    $('#back').click(function(){
        parent.tb_remove();
    });
});
function getHeji(){
    var cnt = 0;
    var i=0;
    $('[name="docheck[]"]:checked').each(function(){
        if(!this.disabled){
            var t_cnt = parseFloat($(this).attr('cnt'))||0;
            cnt+=t_cnt;
            i++;
        }
    });

    return {'cnt':cnt.toFixed(2),'cntJuan':i};
}
function getSelData(){
    var data = [];
    var gxName = [];
    var danjia = [];
    $('[name="docheck[]"]:checked').each(function(){
        if(!this.disabled){
            data.push(this.value);
            gxName.push($(this).attr('cnt'));
            danjia.push($(this).attr('danjia'));
        }
    });

    return {'gongxuIds':data.join(','),'gxName':gxName.join(','),'danjia':danjia.join(',')};
}
</script>
<style type="text/css">
    .bottom-5{margin-bottom: 5px;}
    .heji{float: right;margin-right: 20px;}
    .hejiText{border: none;}
</style>
{/literal}
<body>
<div class='container-fluid'>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='Peihuo'}" method="post">
    <input type="hidden" name="id" id="id" value="{$Peihuo.id}">
    <!-- 校验码单 -->
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <pre>
                
                </pre>
            </div>
        </div>
    </div>

    <div class="form-contrl"><input type="checkbox" name='sel' value="">全选/反选

        <div class="row" style="margin-top:5px;">
            {foreach from=$rowset item = item key = k}
            <div class="col-xs-3">
                <div class="form-control bottom-5">
                    <b>{$item.gxName}</b>
                    <input type="checkbox" name='docheck[]' cnt='{$item.gxName}' value='{$item.gxId}' danjia='{$item.price}' style="width:15px;height:15px;" {if $item.checked}checked{/if} {if $item.disabled}disabled{/if} />
                </div>
            </div>
            {/foreach}
        </div>

        <!-- 按钮区 -->
        <div class="form-group col-xs-12">
            <div class="text-center">
                <input class="btn btn-default" type="button" id="ok" name="ok" value=" 确定 ">
                <input class="btn btn-warning" type="button" id="back" name="back" value=" 返 回 ">
            </div>
        </div>
    </div>
</form>
</div>
</body>
</html>