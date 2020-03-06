{literal}
<style type="text/css">
.navPanel {
	margin-top:5px;
	height:30px;
	clear:both;
	border:1px solid #BBDDE5; 
	background-color: #F4FAFB;
	padding-left: 10px;
}
.navPanel input, select, img{vertical-align:middle; margin: 5px 0px;}
</style>
{/literal}
{if $arr_condition != ''} 
<div id=searchGuide class="navPanel">
<form name="FormSearch" method="post" action="">
{*<img src="Resource/Image/System/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />*}
{foreach from=$arr_condition item=item key=key}
        {if $key=='dateFrom'}
        	日期：<input name="dateFrom" type="text" id="dateFrom" value="{$arr_condition.dateFrom}" size="10" onclick="calendar()">
			到<input name="dateTo" type="text" id="dateTo" value="{$arr_condition.dateTo}" size="10" onclick="calendar()"/>&nbsp;
        {/if}
       
        {if $key=='date'}
			日期：	
			<input name="date" type="text" id="date" value="{$arr_condition.date}" size="10" onclick="calendar()"/>&nbsp;
        {/if}
        
        {if $key=='clientId'}
        	客户：{webcontrol type='ClientSelect' id='clientId' selected=$arr_condition.clientId}&nbsp;
        {/if}
        
        {if $key=='saleKind'}
			产品大类:<select name="saleKind" id="saleKind" warning='请选择'>
              {webcontrol type='TmisOptions' model='JiChu_SaleKind' selected=$arr_condition.saleKind}
				</select>&nbsp;
		{/if}
        
         {if $key=='month'}
        月查询：
          <select name="month" id="month" onchange="document.getElementById('FormSearch').submit()">
          <option value="0">选择</option>
          <option value="1" {if $arr_condition.month==1}selected{/if}>一月份</option>
          <option value="2" {if $arr_condition.month==2}selected{/if}>二月份</option>  
          <option value="3" {if $arr_condition.month==3}selected{/if}>三月份</option>
          <option value="4" {if $arr_condition.month==4}selected{/if}>四月份</option>  
          <option value="5" {if $arr_condition.month==5}selected{/if}>五月份</option>  
          <option value="6" {if $arr_condition.month==6}selected{/if}>六月份</option>  
          <option value="7" {if $arr_condition.month==7}selected{/if}>七月份</option>  
          <option value="8" {if $arr_condition.month==8}selected{/if}>八月份</option>  
          <option value="9" {if $arr_condition.month==9}selected{/if}>九月份</option>
          <option value="10" {if $arr_condition.month==10}selected{/if}>十月份</option>
          <option value="11" {if $arr_condition.month==11}selected{/if}>十一月</option>
          <option value="12" {if $arr_condition.month==12}selected{/if}>十二月</option>        
          </select>
          &nbsp;          
        {/if}
        {if $key=='week'}
          <select name="week" id="week" onchange="docment.getElementById('FromSearch').submit()">
          <option value="0" {if $arr_condition.week==0}selected{/if}>选择</option>
          <option value="1" {if $arr_condition.week==1}selected{/if}>前一天</option>
          <option value="2" {if $arr_condition.week==2}selected{/if}>前二天</option>
          <option value="3" {if $arr_condition.week==3}selected{/if}>前三天</option>
          <option value="4" {if $arr_condition.week==4}selected{/if}>前四天</option>
          <option value="5" {if $arr_condition.week==5}selected{/if}>前五天</option>
          <option value="6" {if $arr_condition.week==6}selected{/if}>前六天</option>
          <option value="7" {if $arr_condition.week==7}selected{/if}>前七天</option>
          </select>
        {/if}
        {if $key=='supplierId'}
        	供应商：{webcontrol type='SupplierSelect' selected=$arr_condition.supplierId}&nbsp;			
        {/if}
        
        {if $key=='orderCode'}
        	订单号：<input name="orderCode" type="text" id="orderCode" value="{$arr_condition.orderCode}" size="10">&nbsp;			
        {/if}
         {if $key=='rukuDanhao'}
          单号：<input name="rukuDanhao" type="text" id="rukuDanhao" value="{$arr_condition.rukuDanhao}" size="10">&nbsp;      
        {/if}
        
        {if $key=='vatNum'}
        	缸号：<input name="vatNum" type="text" id="vatNum" value="{$arr_condition.vatNum}" size="10"/>&nbsp;
        {/if}
          {if $key=='isPrint'}
          是否打印：
        <select name="isPrint" id="isPrint">
        <option value="" >是否打印</option>
        <option value='0' {if $arr_condition.isPrint=='0'}selected{/if}>未打印</option>        
        <option value='1' {if $arr_condition.isPrint=='1'}selected{/if}>已打印</option>        
        </select>
          &nbsp;
        {/if}

		{if $key=='wareId'}
        	支别：<input name="wareId" type="text" id="wareId" size="10" onclick="popMenu(this)" readonly>
            <input name="guige" type="text" id="guige" value="{$arr_condition.guige}" size="10" style="display:none"/>&nbsp;		
        {/if}
    {if $key=='wareName'}
          支别：
      <input name="wareName" type="text" id="wareName" value="{$arr_condition.wareName}" size="10"/>&nbsp; 
    {/if}   
    {if $key=='rhlName'}
          染化料：
      <input name="rhlName" type="text" id="rhlName" value="{$arr_condition.rhlName}" size="10"/>&nbsp; 
    {/if}    
        
		{if $key=='ylId'}
        	染化料：<input name="ylId" type="text" id="ylId" size="10" onclick="popYlMenu(this)" value="{$arr_condition.ylId}">&nbsp;
        {/if}

		{if $key=='zhishu'}
        	支数：<input name="zhishu" type="text" id="zhishu" value="{$arr_condition.zhishu}" size="10"/>&nbsp;	
        {/if}

		{if $key=='color'}
        	颜色：<input name="color" type="text" id="color" value="{$arr_condition.color}" size="10"/>&nbsp;
        {/if}
		{if $key=='workerCode'}
        	工号：<input name="workerCode" type="text" id="workerCode" value="{$arr_condition.workerCode}" size="10"/>&nbsp;
        {/if}
		{if $key=='colorNum'}
        	色号：<input name="colorNum" type="text" id="colorNum" value="{$arr_condition.colorNum}" size="10"/>&nbsp;
        {/if}
        
		{if $key=='cntPlanTouliao'}
        	总公斤数：<input name="cntPlanTouliao" type="text" id="cntPlanTouliao" value="{$arr_condition.cntPlanTouliao}" size="10"/>&nbsp;
        {/if}
		
		{if $key=='chufangrenId'}
			处方人:<select name="chufangrenId" id="chufangrenId" warning='请选择'>
              {webcontrol type='TmisOptions' model='JiChu_Employ' selected=$arr.chufangrenId condition='depId=13'}
				</select>&nbsp;
		{/if}
    {if $key=='rlzj'}
      <select name="rlzj" id="rlzj" warning='染料/助剂'>
        <option value='染料类'>染料</option>        
        <option value='助剂类' {if $arr_condition.rlzj=='助剂类'}selected{/if}>助剂</option>        
      </select>
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
    {webcontrol type='TmisOptions' model='CaiWu_AccountItem' selected=$smarty.post.accountItemId}
            </select>&nbsp;
		{/if}
		
		{if $key=='key'}
			关键字:<input name="key" type="text" id="key" value="{$arr_condition.key}" size="10"/>&nbsp;
		{/if}

		{if $key=='payType'}
			付款类型：
            <select name="payType" id="payType" onchange="FormSearch.action=this.value;FormSearch.submit();"> 
				<option value=''>选择</option>
				<option value='{url controller='CaiWu_Yf_Payment' action='right'}'>采购付款</option>
				<option value='{url controller='CaiWu_Expense' action='right'}'>非采购付款</option>
            </select>&nbsp;
		{/if}
		{if $key=='guige'}
         规格：<input name="guige" type="text" id="guige" value="{$arr_condition.guige}" size="10"/>&nbsp;
        {/if}
		{if $key == 'isHuixiu'}
			<select name="isHuixiu" id="isHuixiu">
      <option value="" >是否回修</option>
      <option value="0" {if ($arr_condition.isHuixiu ==='0')} selected="selected" {/if}>否</option>
      <option value="1" {if ($arr_condition.isHuixiu === '1')} selected="selected" {/if}>是</option>
     </select>
		{/if}
		
		{if $key == 'dateAssignFrom'}
		排染日期：<input name="dateAssignFrom" type="text" id="dateAssignFrom" value="{$arr_condition.dateAssignFrom}" size="10" onclick="calendar()">
			到<input name="dateAssignTo" type="text" id="dateAssignTo" value="{$arr_condition.dateAssignTo}" size="10" onclick="calendar()"/>&nbsp;
		{/if}
		{if $key == 'banci'}
    <select name="banci" id="banci">
      <option value="" >班次</option>
      <option value="甲" {if ($arr_condition.banci =='甲')} selected="selected" {/if}>甲</option>
      <option value="乙" {if ($arr_condition.banci == '乙')} selected="selected" {/if}>乙</option>
    </select>
    {/if}
		{if $key == 'ranseBanci'}
			班次：<select name="ranseBanci" id="ranseBanci">
		<option value="0" >选择</option>
	  	<option value="1" {if ($arr_condition.ranseBanci == 1)} selected="selected" {/if}>早班1</option>
		<option value="3" {if ($arr_condition.ranseBanci == 3)} selected="selected" {/if}>早班2</option>
		<option value="2" {if ($arr_condition.ranseBanci == 2)} selected="selected" {/if}>晚班1</option>
		<option value="4" {if ($arr_condition.ranseBanci == 4)} selected="selected" {/if}>晚班2</option>
	  </select>
		{/if}
    {if $key == 'chanliangKind'}
    <select name="chanliangKind" id="chanliangKind">
      <option value="">产量类别</option>
      <option value="0" {if $arr_condition.chanliangKind==='0'}selected{/if}>正常</option>
      <option value="1" {if $arr_condition.chanliangKind==='1'}selected{/if}>回修</option>
      <option value="2" {if $arr_condition.chanliangKind==='2'}selected{/if}>加料</option>
    </select>
    {/if}
    {if $key=='guoqi'}
    过期天数天内<input name="guoqi" type="text" size="5" />&nbsp;&nbsp;
    {/if}
    {if $key=='isChulong'}
    装笼/出笼：
    <select name='isChulong' id='isChulong' >
      <option value='' style='color:#bbbbbb'>全部</option>
      <option value='0' {if $arr_condition.isChulong==='0'}selected{/if} >装笼</option>
      <option value='1' {if $arr_condition.isChulong==1}selected{/if} >出笼</option>
    <select>
    {/if}
    {if $key=='chandi'}
        产地：<input name="chandi" type="text" id="chandi" value="{$arr_condition.chandi}" size="10"/>&nbsp;
    {/if}
    {if $key=='supplierIdPs'}
        坯纱供应商： 
        <select name='supplierIdPs' id='supplierIdPs' >
          {webcontrol type='TmisOptions' model='JiChu_Supplier' selected=$arr_condition.supplierIdPs condition="compCode like '04%'"}   
        </select>&nbsp;
        {/if}
    {if $key == 'isPlan'}
      是否排计划：
      <select name='isPlan' id='isPlan' >
        <option value='' style='color:#bbbbbb'>全部</option>
        <option value='0' {if $arr_condition.isPlan==='0'}selected{/if} >未排</option>
        <option value='1' {if $arr_condition.isPlan==='1'}selected{/if} >已排</option>
      <select>
    {/if}
    {if $key == 'isKucun'}
      库存：
      <select name='isKucun' id='isKucun' >
        <option value='-1' {if $arr_condition.isKucun==='-1'}selected{/if} >全部</option>
        <option value='0' {if $arr_condition.isKucun==='0'}selected{/if} >有效库存</option>
        <option value='1' {if $arr_condition.isKucun==='1'}selected{/if} >零库存</option>
      <select>
    {/if}
    {if $key=='pihao'}
        批号：<input name="pihao" type="text" id="pihao" value="{$arr_condition.pihao}" size="8"/>&nbsp;
    {/if}
    {if $key=='kuanhao'}
        款号：<input name="kuanhao" type="text" id="kuanhao" value="{$arr_condition.kuanhao}" size="8"/>&nbsp;
    {/if}
    {if $key=='orderKind'}
        订单类型：
        <select name='orderKind' id='orderKind' >
          <option value='' style='color:#bbbbbb'>全部</option>
          <option value='0' {if $arr_condition.orderKind==='0'}selected{/if} >加工</option>
          <option value='1' {if $arr_condition.orderKind==='1'}selected{/if} >经销</option>
        <select>&nbsp;
    {/if}
    {if $key == 'isOverRk'}
      是否完成入库：
      <select name='isOverRk' id='isOverRk' >
        <option value='0' {if $arr_condition.isOverRk==='0'}selected{/if} >未完成</option>
        <option value='1' {if $arr_condition.isOverRk==='1'}selected{/if} >已完成</option>
      <select>
    {/if}    
    {/foreach}
		<input type="submit" name="Submit" value="搜索"/>
		<input name="isReport" type="hidden" id="isReport" value="{$smarty.post.isReport|default:$smarty.get.isReport}" />
    <div id="edit" align="right" style="padding: 5px 10px 0 0;float: right;">
        {if $other_url!=''}{$other_url}{/if}
    </div>
    
</form></div>
{*显示常规搜索项目以外的项目，比如把客户排列出来供点击*}
{$other_search_item}
{/if}