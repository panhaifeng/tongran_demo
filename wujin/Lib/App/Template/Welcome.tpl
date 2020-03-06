<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/thickbox/thickbox.js"></script>
<link href="Resource/Css/thickbox.css" rel="stylesheet" type="text/css" />
{literal}
<style>
td{font-family:"宋体"; font-size:12px;}
img{vertical-align:middle;}
body{background-color:#dae6f3}
a{}
a:link{color:#000;text-decoration:none;}
a:visited{color:#993300;text-decoration: none;}
a:hover{color:#006699;text-decoration:underline;}
	
.mainTable{width:100%; height:100%; border:1px solid #278296; background-color:#FFF}

.childTable{border:1px solid #278296; width:100%; height:100%;}
.childTable .header td{padding-left:10px;}

.header{
	line-height: 16px;
	height: 25px;
	font-weight: bold;
	color: #FFFFFF;
	border-bottom: 1px solid #525C3D;
	padding: 0px 8px;
	background-color:#278296;
}

#table_gg{width:100%; height:100%}
#table_gg td{font-size:12px;}

#table_xztz{width:80%; height:100%}
#table_xztz td{font-size:12px;}

#table_adr{width:80%; height:100%}
#table_adr span{color:#CC9900;}
#table_adr td{width:50%; height:25%;}

.table_001, .table_002{width:100%; height:100%}
.table_001 td, .table_002 td{padding-left:10px;}
.table_001{border:1px dashed #999900;}
.table_001 .th{background-color:#CCCCCC; font-weight:bold; }
.table_002{border:1px dashed #cccccc;}
.table_002 .th{background-color:#80BDCB; font-weight:bold; }

</style>
{/literal}
</head>
<body style="text-align:center; margin:10px;">
{*<table class="mainTable">
	<tr><td class="header" align="left" colspan="3"><img src="Resource/Image/Index/ictip.gif">&nbsp;欢迎来到{webcontrol type='GetAppInf' varName='compName'}仓库管理系统！</td></tr>
	<tr>
		<td width="30%" height="30%" rowspan="2" valign="top">
			<table class="childTable">
				<tr class="header">
				  <td align="left"><img src="Resource/Image/Index/b_tipp.png">&nbsp;行政通知</td></tr>
				<tr><td valign="top">					
						{foreach from=$arr_field_value1 item=field_value}
                        <br>
						<img src="Resource/Image/Index/index.gif" border="0">&nbsp;<a href="Index.php?controller=Index&action=View&id={$field_value.id}&width=700&height=500&TB_iframe=1" title='新闻详细' class="thickbox">							
							{$field_value.title|default:'&nbsp;'}							
							{$field_value.buildDate}
							<img src="Resource/Image/Index/new.gif" style="margin-bottom:0px;" border="0" />
							
						</a>
                        <br>
						{/foreach}
                        	
			</td></tr>
			</table>
		</td>
		<td width="30%" rowspan="2" valign="top">
			<table class="childTable">
				<tr class="header">
				  <td align="left"><img src="Resource/Image/Index/b_search.png">&nbsp;库存警告</td></tr>
				<tr><td valign="top">
					<table id="table_xztz">                    
                    {foreach from=$arr_field_value2 item=field_value}
						<tr><td valign="top"><img src="Resource/Image/Index/filetype_document.gif">&nbsp;<a href="Index.php?controller=Index&action=View&id={$field_value.id}&width=700&height=500&TB_iframe=1" title='新闻详细' class="thickbox">	{$field_value.title|default:'&nbsp;'}	{$field_value.buildDate}</a><img src="Resource/Image/Index/new.gif" style="margin-bottom:0px;" border="0" /></td></tr>
                    {/foreach}                   
                    
					</table>
                    
				</td></tr>
			</table>
	  </td>
		<td width="30%">
		  <table class="childTable">
				<tr class="header"><td align="left"><img src="Resource/Image/Index/w26.gif">&nbsp;当天出库</td></tr>
				<tr><td align="center"></td></tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td width="30%" height="30%">
			<table class="childTable">
				<tr class="header">
				  <td align="left"><img src="Resource/Image/Index/b_browse.png">&nbsp;申请过期提醒</td></tr>
				<tr><td valign="top" align="center">
					<table id="table_adr">
						{foreach from=$arr_field_value3 item=field_value}
						<tr><td><img src="Resource/Image/Index/filetype_document.gif">&nbsp;<a href="Index.php?controller=Index&action=View&id={$field_value.id}&width=700&height=500&TB_iframe=1" title='新闻详细' class="thickbox">	{$field_value.title|default:'&nbsp;'}	{$field_value.buildDate}</a><img src="Resource/Image/Index/new.gif" style="margin-bottom:0px;" border="0" />
                        </td></tr>
                    {/foreach}
					</table>
				</td></tr>
			</table>
		</td>
	</tr>
	
	
	<tr>
		<td colspan="3"  height="40%">
			<table class="childTable">
				<tr class="header"><td align="left" colspan="6"><img src="Resource/Image/Index/b_bookmark.png">&nbsp;快速通道</td></tr>
				<tr>
					<td><table class="table_002">
						<tr>
						  <td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;领料申请</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Shenqing&action=add" target="_blank">申请登记</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Shenqing&action=right1" target="_blank">申请查询</a></td></tr>
						<!--<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Shenqing&action=right1" target="_blank">申请明细查询</a></td></tr>-->
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Shenqing&action=right2" target="_blank">未领申请</a></td></tr>
                        <tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Shenqing&action=right3" target="_blank">已过期申请</a></td></tr>
					</table></td>
					<td><table class="table_001">
						<tr>
						  <td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;仓库现场</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Ruku&action=add" target="_blank">入库登记</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Chuku&action=add" target="_blank">出库登记</a></td></tr>
						<!--<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Pandian&action=right" target="_blank">盘点登记</a></td></tr>-->
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=JiChu_Employkind&action=right" target="_blank">人员设置</a></td></tr>
					</table></td>
					<td><table class="table_002">
						<tr>
						  <td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;财务管理</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Chuku&action=listForDanjia" target="_blank">出库单价设置</a></td></tr>
						<!--<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Chuku&action=listForDanjia" target="_blank">结帐审核</a></td></tr>-->
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Chuku&action=DanjiaBrowse" target="_blank">出库单价查询</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="#" target="_blank">&nbsp;</a></td></tr>
					</table></td>
					<td><table class="table_001">
						<tr>
						  <td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;报表中心</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Kucun&action=MonthReport" target="_blank">收发存汇总</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Kucun&action=lingyongReport" target="_blank">部门领用汇总</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Cangku_Kucun&action=CarReport" target="_blank">单车领用汇总</a></td></tr>
						<!--<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="#" target="_blank">收发存汇总</a></td></tr>
                        <tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="#" target="_blank">年发存汇总</a></td></tr>-->
					</table></td>
					<td><table class="table_002">
						<tr>
						  <td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;基础资料</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=JiChu_Ware&action=right" target="_blank">物料档案</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=JiChu_Supplier&action=right" target="_blank">供应商档案</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=JiChu_Department&action=right" target="_blank">部门档案</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=JiChu_Employ&action=right" target="_blank">员工档案</a></td></tr>
                        <!--<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="#" target="_blank">车辆档案</a></td></tr>-->
					</table></td>
					<td><table class="table_001">
						<!--<tr>
						  <td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;公告信息</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="#" target="_blank">公告/系统升级日志</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="#" target="_blank">行政通知</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="#" target="_blank">公司制度</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="#" target="_blank">行业新闻</a></td></tr>-->
					</table></td>
				</tr>
			</table>
		</td>
	</tr>
</table>*}
</body>
</html>
