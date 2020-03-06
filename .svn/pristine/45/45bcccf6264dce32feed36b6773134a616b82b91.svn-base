<!-- <script language='javascript'>
var controller = '{$smarty.get.controller}';
{literal}
$(function(){
    //全选
    $("#checkedAll").click(function(){
        $("input[name='chk[]']").each(function(i){
            $(this).click();
        });
    });
    

    $('#save2').click(function(){
        //2016-12-5 by jeff,3秒内disabled
        var _this = this;
        $(_this).text('保存中').attr('disabled',true);
        setTimeout(function(){
            $(_this).text('保存').attr('disabled',false);
        },3000);
        // return false;
        var ck = $('[name="chk[]"]:checked');   //选择器
        //将所有的选中的id用,连接后传递
        var id=[];
        var danjia=[];
        var money=[];
        var _money=[];
        ck.each(function(){
            id.push($(this).val());
            var trs = $(this).parents('tr');
            danjia.push($('[name="danjia[]"]',trs).val());        
            money.push($('[name="money[]"]',trs).val());
        });
        if(id.length==0) {
            alert('请选择过账信息!');
            return false;
        }
        //只能点击一次保存按钮
        $('#save2').attr("disabled","disabled");
        var url="?controller="+controller+"&action=Save";
        var str = JSON.stringify(id);
        var param={ids:str,danjia:danjia,money:money};

        $.getJSON(url,param,function(json){
             if(json==true){
                alert('保存成功');
             }
            window.location.reload();
         });
    });
});
{/literal}
</script>
 -->

 <script language='javascript'>
var controller = '{$smarty.get.controller}';
{literal}
$(function(){
    //全选
    $("#checkedAll").click(function(){
        $("input[name='chk[]']").each(function(i){
            $(this).click();
        });
    });
    
    //折扣金额变化 入账金额变化
    $('[name="zhekouMoney[]"]').change(function(){
         var trs = $(this).parents('tr');
        var money=Number($('[name="_money[]"]',trs).val());
        var zhekouMoney=Number($(this).val());
        if (isNaN(Number(zhekouMoney))) {
            zhekouMoney = 0;
            $(this).val(zhekouMoney);
        }
        var money2=money+zhekouMoney;
        money2 = Number(money2.toFixed(2));

        var oldMoney = Number($('[name="oldMoney[]"]',trs).val());
        var heji = Number($('#heji').html());
        var newHeji = (heji+money2-oldMoney).toFixed(2);
        $('[name="money[]"]',trs).val(money2);
        $('[name="oldMoney[]"]',trs).val(money2);
        $('#heji').html(newHeji);
        $('[name="oldZhekou[]"]',trs).val(zhekouMoney);

    })
        

    //入账金额变化 总计金额也随着变化
    $('[name="money[]"]').change(function(){
        var trs = $(this).parents('tr');
        var money = Number($('[name="money[]"]',trs).val());
        var _money=$('[name="_money[]"]',trs).val();
        if (isNaN(Number(money))) {
            money = 0;
            $(this).val(money);
        }
        var oldMoney = Number($('[name="oldMoney[]"]',trs).val());
        var heji = Number($('#heji').html());
        var newHeji = heji - oldMoney + money;
        var zhekouMoney=_money+money; 
        zhekouMoney = Number(zhekouMoney.toFixed(2));

        $('[name="zhekouMoney[]"]',trs).val(zhekouMoney);
        $('[name="oldZhekou[]"]',trs).val(zhekouMoney);
        $('#heji').html(newHeji);
        $('[name="oldMoney[]"]',trs).val(money);
    })
        
 

    $('#save2').click(function(){
        //2016-12-5 by jeff,3秒内disabled
        var _this = this;
        $(_this).text('保存中').attr('disabled',true);
        setTimeout(function(){
            $(_this).text('保存').attr('disabled',false);
        },3000);
        // return false;
        var ck = $('[name="chk[]"]:checked');   //选择器
        //将所有的选中的id用,连接后传递
        var id=[];
        var danjia=[];
        var moneys=[];
        var _money=[];
        var memos=[];
        ck.each(function(){
            id.push($(this).val());
            var trs = $(this).parents('tr');
            danjia.push($('[name="danjia[]"]',trs).val());        
            moneys.push($('[name="money[]"]',trs).val());
            memos.push($('[name="memo[]"]',trs).val());
        });
        if(id.length==0) {
            alert('请选择过账信息!');
            return false;
        }
        //只能点击一次保存按钮
        $('#save2').attr("disabled","disabled");
        var url="?controller="+controller+"&action=Save";
        var str = JSON.stringify(id);
        var param={ids:str,danjia:danjia,money:moneys,memo:memos};

        $.getJSON(url,param,function(json){
             if(json==true){
                alert('保存成功');
             }
            var url='?controller=CaiWu_Confirm&action=ListGuozhang';
            window.location.href = url;
         });
    });
});
{/literal}
</script>
