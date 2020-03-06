<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>计划进度一览表</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />

{literal}
<style type="text/css">
#fieldInfo td {
		height:24px;
		background-image:url('Resource/Image/System/th_bg.gif');		
		/*border-right: 1px solid #525C3D; 
		border-bottom: 1px solid #525C3D; */
		border-right:1px solid #ccc;
		color:#192E32; font-weight:bold;
	}
#tb {
		width:100%;
		border: 1px solid #bbdde5; 
		margin-top:5px;
		background-color:#FFFFFF
	}
.mm{
	border-right:1px solid #ccc;
	border-bottom:1px solid #ccc;
}
</style>
{/literal}
</head>

<body>
{if $nav_display != 'none'}{include file="_ContentNav.tpl"}{/if}
{include file="_SearchItem.tpl"} 
<table width="100%" border="0" cellpadding="1" cellspacing="1" id="tb">  
  {foreach from=$orders item='aOrder'}
  {if $aOrder.isShow==true}
  {assign var="tCnt" value=0}
  {assign var="tTongzi" value=0} 
  <tr>
    <td colspan="20" style="background-image:url('Resource/Image/System/th_bg.gif')">
    <span style="font-size:16px"><b>
    {$aOrder.dateOrder},{$aOrder.Client.compName},订单号:{$aOrder.orderCode},产品类别:{$aOrder.SaleKind.kindName}
    {if !$aOrder.isShow},未计划, [ <a href='{url controller="Plan_Dye" action="makeGang1" id=$aOrder.id}'>开始计划</a> ]
    {/if}
    &nbsp;,交货日期：{$aOrder.dateJiaohuo}
    </b>
    </span>
    </td>
  </tr>
   <tr id="fieldInfo">
    <td bgcolor="#6699cc" width="180px">纱支规格</td>
    <td bgcolor="#6699cc">款号</td>
    <td bgcolor="#6699cc" width="200px">颜色</td>
    <td bgcolor="#6699cc">色号</td>
    <td bgcolor="#6699cc">缸号</td>
    <td colspan="2" bgcolor="#6699cc"><div align="center">经</div></td>
    <td bgcolor="#6699cc"><div align="center">纬</div></td>
    <td bgcolor="#6699cc"><div align="center">合计</div></td>
    <td bgcolor="#6699cc">筒子数</td>
    <td bgcolor="#6699cc">松筒</td>
    <td bgcolor="#6699cc">高台染色</td>
    <td bgcolor="#6699cc">烘纱</td>
    <td bgcolor="#6699cc">回倒</td>
    <td bgcolor="#6699cc" width="65px">入库筒子数</td>
    <td bgcolor="#6699cc">入库</td>
    <td bgcolor="#6699cc">计价重量</td>
    <td bgcolor="#6699cc">差值(计价重量-投料数)</td>
    <td bgcolor="#6699cc">发货</td>
    <td bgcolor="#6699cc">已发货数量</td>
	  <!-- <td bgcolor="#6699cc">打样人</td> -->
  </tr>
 {foreach from=$aOrder.Ware item='aOrdPro' key=key}
  {foreach from=$aOrdPro item=item key=key1}
  	{if $item.isShow}
  	{if $item.Gang}
  	{foreach from=$item.Gang item='aGang' key=key2}
    {if $aGang.isShow}
    {math equation="x + y" x=$aGang.cntPlanTouliao2 y=$tCnt assign='tCnt'}
    {math equation="x + y" x=$aGang.planTongzi y=$tTongzi assign='tTongzi'}
  <tr>
    <td class="mm">{*{if $key1 == 0 && $key2 == 0}{$key}{else}&nbsp;{/if}*}{$key}</td>
    <td class="mm">{$item.kuanhao|default:'&nbsp;'}</td>
    <td class="mm">{$item.color|default:'&nbsp;'}</td>
    <td class="mm">{$item.colorNum|default:'&nbsp;'}</td>
    <td class="mm">{$aGang.vatNum|default:'&nbsp;'}</td>
    <td colspan="2" class="mm">{$aGang.cntJ|default:'&nbsp;'}</A></td>
    <td class="mm">{$aGang.cntW}</td>
    <td class="mm">{$aGang.cntPlanTouliao}</td>
    <td class="mm">{$aGang.planTongzi}</td>
    <td style="border-right:1px solid #ccc; border-bottom:1px solid #ccc;">{if $aGang.haveSt==true}√{else}&nbsp;{/if}</td>
    <td class="mm">{if $aGang.haveRs==true}{if $aGang.haveRs==3}√√{else}√{/if}{else}&nbsp;{/if}</td>
    <td class="mm">{if $aGang.haveHs==true}√{else}&nbsp;{/if}</td>
    <td class="mm">{if $aGang.haveHd==true}√{else}&nbsp;{/if}</td>
    <td class="mm">{$aGang.RkTongziCnt|default:'&nbsp;'}</td>
    <td class="mm">{if $aGang.haveRk==true}√{else}&nbsp;{/if}</td>
    <td class="mm">{$aGang.Cpck.0.jingKgZ}</td>
    <td class="mm">{$aGang.Cpck.0.jingKgZ-$aGang.cntPlanTouliao}</td>
    <td class="mm">{if $aGang.haveFh==true}√{else}&nbsp;{/if}</td>
    <td class="mm">{$aGang.CkCnt|default:'&nbsp;'}</td>
	  <!-- <td class="mm">{$item.personDayangName}</td> -->
  </tr>
  	{/if}
    {/foreach}
    {else}    
    {math equation="x+y " x=$item.cntKg y=$tCnt assign='tCnt'}
  <tr>
    <td class="mm">{$key}</td>
    <td class="mm">&nbsp;</t
    <td class="mm">{$item.color}</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">未计划</td>
    <td colspan="4" class="mm" style="background-color:lightyellow">{$item.cntKg}</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
	<!-- <td class="mm">{$item.personDayangName}</td> -->
  </tr>
  
      
    {/if}
    {/if}
    {/foreach}
  {/foreach}
  <tr>
    <td class="mm"><strong>合计</strong></td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td colspan="4" class="mm"><strong>{$tCnt}</strong></td>
    <td class="mm"><strong>{$tTongzi}</strong></td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
    <td class="mm">&nbsp;</td>
	<!-- <td class="mm">&nbsp;</td> -->
  </tr> 
  {/if}
  {/foreach}
</table>
</body>
{literal} 
<script type="text/javascript">
 var obj=document.getElementById('tb');
 for(var i=1;i<obj.rows.length;i++){  //循环表格行设置鼠标事件：丁学 http://www.cnblogs.com/dxef
   obj.rows[i].onmouseover=function(){    
    //this.style.backgroundImage='Resource/Image/System/row-over.gif';
      //this.style.background="#b4d1f0";
    this.style.background="#cccccc";
  }
   
   obj.rows[i].onmouseout=function(){this.style.background="";}
 }
</script>
{/literal} 
</html>
