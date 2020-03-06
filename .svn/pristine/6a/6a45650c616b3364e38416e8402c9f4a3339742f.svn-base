{literal}
<style type="text/css">
.navPanel {
	margin-top:0px;
	height:30px;
	clear:both;
	border:1px solid #BBDDE5;
	background-color: #F4FAFB;
	padding-left: 10px;
}
.navPanel input, select, img{vertical-align:middle; margin: 5px 0px;}
</style>
<script language="javascript">
function onkd(e,obj){
	var keyCode=e.keyCode;
	if(keyCode==13){
		var url="?controller=JiChu_Employ&action=GetJsonByKey";
		param={key:obj.value};
		$.getJSON(url,param,function(json){
				if(!json||json.length==0){
					alert('该员工不存在！');
					return false;
				}
				if(json.length==1){
					obj.value=json[0].id+":"+json[0].employName;
					return false;
				}
				selName(json);
				return false;

		});
		return false;
	}

}
//选择员工
function selName(obj){
	var url="?controller=JiChu_Employ&action=Popup";
	var objs = document.getElementById('employName');
	if(objs.value!='') url += '&key=' + encodeURI(objs.value);

	ymPrompt.win({message:url,handler:callBack,width:700,height:500,title:'选择员工',iframe:true});
	return false;
	function callBack(ret){
		//dump(ret);return false;
		if(!ret || ret=='close') return false;

		document.getElementById('employId').value=ret.id;
		document.getElementById('employName').value=ret.employName;
	}
}
</script>
{/literal}
{if $arr_condition != ''}
<div id=searchGuide class="navPanel">
<form name="FormSearch" method="post" action="">
<img src="Resource/Image/System/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
{foreach from=$arr_condition item=item key=key}
        {if $key=='dateFrom'}
        	日期：<input name="dateFrom" type="text" id="dateFrom" value="{$arr_condition.dateFrom}" size="8" onclick="calendar()">
			到<input name="dateTo" type="text" id="dateTo" value="{$arr_condition.dateTo}" size="8" onclick="calendar()"/>&nbsp;
        {/if}

        {if $key=='date'}
			日期：
			<input name="date" type="text" id="date" value="{$arr_condition.date}" size="8" onclick="calendar()"/>&nbsp;
        {/if}
        {if $key=='ym'}
			年月：
			<input name="ym" type="text" id="ym" value="{$arr_condition.ym}" size="8" />&nbsp;
        {/if}
        {if $key=='traderId'}
	业务员：<select name="traderId" id="traderId">
    {webcontrol type='TmisOptions' model='Jichu_Employ' selected=$arr_condition.traderId condition='depId=1'}
            </select>&nbsp;
		{/if}

        {if $key=='clientId'}
        	客户：{webcontrol type='ClientSelect' id='clientId' selected=$arr_condition.clientId}&nbsp;
        {/if}
        {if $key=='jingshouren'}
			经手人：
			<input name="jingshouren" type="text" id="jingshouren" value="{$arr_condition.jingshouren}" size="8" />&nbsp;
        {/if}
        {if $key=='supplierId'}
        	供应商：{webcontrol type='SupplierSelect' selected=$arr_condition.supplierId}&nbsp;
        {/if}

        {if $key=='orderCode'}
        	订单号：<input name="orderCode" type="text" id="orderCode" value="{$arr_condition.orderCode}" size="8">&nbsp;
        {/if}

        {if $key=='vatNum'}
        	缸号：<input name="vatNum" type="text" id="vatNum" value="{$arr_condition.vatNum}" size="8"/>&nbsp;
        {/if}
        {if $key=='pinGui'}
        	 品规：<input name="pinGui" type="text" id="pinGui" value="{$arr_condition.pinGui}" size="8"/>&nbsp;
        {/if}
		{if $key=='deepth'}
        	级别：
<select name="deepth" id="deepth">
   				 <option value=1 {if $arr_condition.deepth==1}selected{/if}>1</option>
                 <option value=2 {if $arr_condition.deepth==2}selected{/if}>2</option>
                 <option value=3 {if $arr_condition.deepth==3}selected{/if}>3</option>
                 <option value=4 {if $arr_condition.deepth==4}selected{/if}>4</option>
                 <option value=5 {if $arr_condition.deepth==5}selected{/if}>5</option>
                 <option value=6 {if $arr_condition.deepth==6}selected{/if}>6</option>
                 <option value=7 {if $arr_condition.deepth==7}selected{/if}>7</option>
                 <option value=8 {if $arr_condition.deepth==8}selected{/if}>8</option>
            </select>&nbsp;
        {/if}

        {if $key=='gongxuId'}
        	工序 <select name="gongxuId" id="gongxuId">
    				{webcontrol type='TmisOptions' model='Jichu_Gongxu' selected=$arr_condition.gongxuId }
            	</select>&nbsp;
        {/if}
		
          {if $key=='kind'}
                库存类别：
                <select name="kind" id="kind"> 
                    <option value='0' {if $arr_condition.kind==0}selected{/if}>正常</option>
                    <option value='1' {if $arr_condition.kind==1}selected{/if}>溢出</option>
                    <option value='2' {if $arr_condition.kind==2}selected{/if}>不足</option>
                </select>&nbsp;
            {/if}
        
		{if $key=='proId'}
        	品名：
        <select name="proId" id="proId">
                   {webcontrol type='TmisOptions' model='jichu_product' selected=$arr_condition.proId}
        </select>
        {/if}
        {if $key=='employName'}
        	申请人：
      <input name="employName" type="text" id="employName" value="{$arr_condition.employName}" size="8">
        {/if}
        {if $key=='code'}
        	编码：
      <input name="code" type="text" id="code" value="{$arr_condition.code}" size="6">
        {/if}
        {if $key=='rukuCode'}
        	入库单号：
      <input name="rukuCode" type="text" id="rukuCode" value="{$arr_condition.rukuCode}" size="6">
        {/if}
        {if $key=='chukuCode'}
        	出库单号：
      <input name="chukuCode" type="text" id="chukuCode" value="{$arr_condition.chukuCode}" size="8">
        {/if}
         {if $key=='method'}
        	方式：
      <!--<input name="method" type="text" id="method" value="{$arr_condition.method}" size="8">-->
        <select name="method" id="method"> 
        	<option value='2' {if $arr_condition.method==2}selected{/if}>全部</option>
            <option value='0' {if $arr_condition.method==0}selected{/if}>正常</option>
            <option value='1' {if $arr_condition.method==1}selected{/if}>以旧换新</option>
        </select>
        {/if}
		{if $key=='ylId'}
        	染化料：<input name="ylId" type="text" id="ylId" size="8" onclick="popYlMenu(this)" value="{$arr_condition.ylId}">&nbsp;
        {/if}

		{if $key=='zhishu'}
        	支数：<input name="zhishu" type="text" id="zhishu" value="{$arr_condition.zhishu}" size="8"/>&nbsp;
        {/if}

		{if $key=='color'}
        	颜色：<input name="color" type="text" id="color" value="{$arr_condition.color}" size="8"/>&nbsp;
        {/if}

		{if $key=='colorNum'}
        	色号：<input name="colorNum" type="text" id="colorNum" value="{$arr_condition.colorNum}" size="8"/>&nbsp;
        {/if}

		{if $key=='cntPlanTouliao'}
        	总公斤数：<input name="cntPlanTouliao" type="text" id="cntPlanTouliao" value="{$arr_condition.cntPlanTouliao}" size="8"/>&nbsp;
        {/if}

		{if $key=='chufangrenId'}
			处方人:<select name="chufangrenId" id="chufangrenId" warning='请选择'>
              {webcontrol type='TmisOptions' model='JiChu_Employ' selected=$chufang.chufangrenId condition='depId=13'}
				</select>&nbsp;
		{/if}

        {if $key=='overMark'}
			是否完成:
			<select name="overMark" id="overMark">
			  <option value="0" {if $arr_condition.overMark==0}selected{/if}>未完成</option>
			  <option value="1" {if $arr_condition.overMark==1}selected{/if}>已完成</option>
			  <option value="2" {if $arr_condition.overMark==2}selected{/if}>全部</option>
			</select>&nbsp;
		{/if}

		{if $key=='accountItemId'}
			帐户：<select name="accountItemId" id="accountItemId" onchange="FormSearch.submit();">
    {webcontrol type='TmisOptions' model='Caiwu_AccountItem' selected=$smarty.post.accountItemId}
            </select>&nbsp;
		{/if}

		{if $key=='key'}
			关键字：<input name="key" type="text" id="key" value="{$arr_condition.key}" size="8" onclick="this.select()"/>&nbsp;
		{/if}

		{if $key=='payType'}
			付款类型：
            <select name="payType" id="payType" onchange="FormSearch.action=this.value;FormSearch.submit();">
				<option value=''>选择</option>
				<option value='{url controller='Caiwu_Yf_Payment' action='right'}'>采购付款</option>
				<option value='{url controller='Caiwu_Expense' action='right'}'>非采购付款</option>
            </select>&nbsp;
		{/if}

		{if $key == 'isHuixiu'}
			是否回修：<input type="checkbox" name="isHuixiu" value=1 {if $arr_condition.isHuixiu==1} checked="checked" {/if}>&nbsp;
		{/if}


		{if $key == 'ranseBanci'}
			班次：<select name="ranseBanci" id="ranseBanci">
		<option value="0" >选择</option>
	  	<option value="1" {if ($arr_condition.ranseBanci == 1)}"selected" {/if}>早班1</option>
		<option value="3" {if ($arr_condition.ranseBanci == 3)}"selected" {/if}>早班2</option>
		<option value="2" {if ($arr_condition.ranseBanci == 2)}"selected" {/if}>晚班1</option>
		<option value="4" {if ($arr_condition.ranseBanci == 4)}"selected" {/if}>晚班2</option>
	  </select>
		{/if}
        {if $key == 'depId'}
            申请部门：
              <select name="depId" id="depId">
              {webcontrol type='TmisOptions' model='Jichu_Department' selected=$arr_condition.depId}
              </select>
        {/if}
      {/foreach}
		<input type="submit" name="Submit" value="搜索"/>
		<input name="isReport" type="hidden" id="isReport" value="{$smarty.post.isReport|default:$smarty.get.isReport}" />
</form></div>
{*显示常规搜索项目以外的项目，比如把客户排列出来供点击*}
{$other_search_item}
{/if}