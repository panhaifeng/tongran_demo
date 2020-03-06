<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {webcontrol type='LoadJsCss' src="Resource/Script/jquery/1.9.1/jquery.js"}
    {webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.2.0/css/bootstrap.css"}
    {webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.2.0/js/bootstrap.min.js"}
    {webcontrol type='LoadJsCss' src="Resource/BtGrid/btGrid.2.0.js"}
    {webcontrol type='LoadJsCss' src="Resource/BtGrid/btGrid.css"}
    {webcontrol type='LoadJsCss' src="Resource/Script/layer/layer.js"}
{literal}
<style>
td{font-family:"宋体"; font-size:12px;}
img{vertical-align:middle;}
a{}
a:link{color:#000;text-decoration:none;}
a:visited{color:#993300;text-decoration: none;}
a:hover{color:#006699;text-decoration:underline;}


.mainTable{width:100%; height:100%; border:1px solid #278296}

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

#table_scgz{width:80%; height:100%}
#table_scgz td{font-size:14px;}

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
{literal}
<script type="text/javascript">
/*查看小程序绑定的二维码*/
function viewDetails(){
    var url='?controller=Main&action=VerifyQrcodeBuild'; //旧版本ViewMiniCode
    $.layer({
        type: 2,
        shade: [1],
        fix: false,
        title: '小程序二维码',
        maxmin: false,
        iframe: {src : url},
        // border:false,
        area: ['700px' , '600px']
    });
}
</script>
{/literal}
</head>
<body style="text-align:left; margin:10px;">
<table class="mainTable">
	<tr><td class="header" align="left" colspan="3"><img src="Resource/Image/Index/ictip.gif">&nbsp;欢迎来到{webcontrol type='GetAppInf' varName='compName'}信息管理系统！</td></tr>
	<tr>
		<td width="30%" height="30%" rowspan="2">
			<table class="childTable">
				<tr class="header"><td align="left"><img src="Resource/Image/Index/b_tipp.png">&nbsp;公告/开发升级日志</td></tr>
				<tr><td valign="top">
					<table id="table_gg">
						{foreach from=$arr_field_value1 item=field_value}
						<tr><td valign="top"><img src="Resource/Image/Index/index.gif" border="0">&nbsp;<a href="Index.php?controller=Index&action=View&id={$field_value.id}" target="_blank">
							{foreach from=$arr_field_info key=key item=item}
							{$field_value.$key|default:'&nbsp;'}
							{/foreach}
							{if $field_value.buildDate==$smarty.now|date_format:"%Y-%m-%d"}
							<img src="Resource/Image/Index/new.gif" style="margin-bottom:0px;" border="0" />
							{/if}
						</a></td></tr>
						{/foreach}
					</table>
			</td></tr>
			</table>
		</td>
		<td width="30%">
			<table class="childTable">
				<tr class="header"><td align="left"><img src="Resource/Image/Index/b_search.png">&nbsp;公共查询区</td></tr>
				<tr><td>
					<table id="table_scgz">
						<tr><td><img src="Resource/Image/Index/filetype_document.gif">&nbsp;<a href="Index.php?controller=Public_Search&action=right0" target="_blank">生产跟踪列表</a></td>
						<td><img src="Resource/Image/Index/filetype_document.gif">&nbsp;<a href="Index.php?controller=Public_Search&action=PlanTrace" target="_blank">计划进度列表</a></td></tr>
						<tr><td><img src="Resource/Image/Index/filetype_document.gif">&nbsp;<a href="Index.php?controller=Public_Search&action=right0" target="_blank"></a></td>
						<td><img src="Resource/Image/Index/filetype_document.gif">&nbsp;<a href="Index.php?controller=Public_Search&action=PlanTrace" target="_blank"></a></td></tr>
						<tr><td><img src="Resource/Image/Index/filetype_document.gif">&nbsp;<a href="Index.php?controller=Public_Search&action=right0" target="_blank"></a></td>
						<td><img src="Resource/Image/Index/filetype_document.gif">&nbsp;<a href="Index.php?controller=Public_Search&action=PlanTrace" target="_blank"></a></td></tr>
					</table>
				</td></tr>
			</table>
		</td>
		<td width="30%">
			<table class="childTable">
				<tr class="header"><td align="left"><img src="Resource/Image/Index/w26.gif">&nbsp;天气预报</td></tr>
				<tr><td align="center"><iframe src="http://i.tianqi.com/index.php?c=code&id=1" width="200" height="50" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" name="265"></iframe></td></tr>
			</table>
		</td>
	</tr>
    
	<tr>
	   {if $isShowBoss}  
		<td width="30%" height="30%"> 
			<table class="childTable">
				<tr class="header"><td align="left"><img src="Resource/Image/Index/b_bookmark.png">&nbsp;老板驾驶舱</td></tr>
				<tr><td>
					<table id="table_gg">
					<tr>
						<td>
							<span class="sr-only"></span>
            老板驾驶舱有小程序版本了，快来体验吧~&nbsp;
            <button type="button" class="btn" onclick="viewDetails()" >点击查看</button>
						</td>
					</tr>
					</table>
			</td></tr>
			</table>
		</td>
		{else}
     	<td width="30%" height="30%">
			<table class="childTable">
				<tr class="header"><td align="left"><img src="Resource/Image/Index/b_bookmark.png">&nbsp;公司制度</td></tr>
				<tr><td>
					<table id="table_gg">
						{foreach from=$arr_field_value5 item=field_value}
						<tr><td valign="top"><img src="Resource/Image/Index/icon3.gif" border="0">&nbsp;<a href="Index.php?controller=Index&action=View&id={$field_value.id}" target="_blank">
							{foreach from=$arr_field_info key=key item=item}
							{$field_value.$key|default:'&nbsp;'}
							{/foreach}
							{if $field_value.buildDate==$smarty.now|date_format:"%Y-%m-%d"}
							<img src="Resource/Image/Index/new.gif" style="margin-bottom:0px;" border="0" />
							{/if}
						</a></td></tr>
						{/foreach}
					</table>
			</td></tr>
			</table>
		</td>
		{/if}
		<td width="30%">
			<table class="childTable">
				<tr class="header"><td align="left"><img src="Resource/Image/Index/b_browse.png">&nbsp;通迅录</td></tr>
				<tr><td valign="top" align="center">

					<table id="table_adr">
                    {foreach from=$arr_field_value6 item=item key=key}
                      	<tr>
                        {foreach from=$item item=item2}
                        <td nowrap>
                            <img src="Resource/Image/Index/icon_arrow01.gif">&nbsp;{$item2.proName}:
                            <span>{$item2.tel}</span>
                        </td>
                        {/foreach}
                       </tr>
                    {/foreach}
					</table>
			</td></tr>
			</table>
		</td>
	</tr>


	<tr>
		<td colspan="3"  height="40%">
			<table class="childTable">
				<tr class="header"><td align="left" colspan="5"><img src="Resource/Image/Index/b_bookmark.png">&nbsp;快速通道</td></tr>
				<tr>
					<td><table class="table_001">
						<tr><td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;染化料仓库</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=CangKu_Yl_Ruku&action=right" target="_blank">入库登记</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=CangKu_Yl_Chuku&action=right" target="_blank">领料登记</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=CangKu_Yl_Kucun&action=Right" target="_blank">染化料月报表</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Chejian_Ranse&action=chanliangInput1" target="_blank">&nbsp;</a></td></tr>
					</table></td>
					<td><table class="table_002">
						<tr><td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;坯纱仓库</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=CangKu_RuKu&action=right" target="_blank">入库登记</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=CangKu_ChuKu&action=ChanliangInput1" target="_blank">领料登记</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=CangKu_Report_Month&action=reportday" target="_blank">坯纱日报表</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=CangKu_Report_Month&action=right1" target="_blank">坯纱库存报表</a></td></tr>
					</table></td>
					<td><table class="table_001">
						<tr><td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;成品仓库</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Chengpin_Dye_Cprk&action=AddGuide" target="_blank">入库登记</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Chengpin_Dye_Cpck&action=AddGuide" target="_blank">成品出库（整单）</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Chengpin_Dye_Cpck&action=AddGuide3" target="_blank">成品出库（自由）</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Chengpin_Dye_Cpck&action=right" target="_blank">成品出库查询</a></td></tr>
					</table></td>
					<td><table class="table_002">
						<tr><td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;化验室</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Gongyi_Dye_Chufang&action=right" target="_blank">处方登记</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Gongyi_Dye_Chufang&action=list" target="_blank">处方查询</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Gongyi_Dye_Chufang&action=listformerge" target="_blank">合并处方</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Gongyi_Dye_Chufang&action=listMerge" target="_blank">合并处方查询</a></td></tr>
					</table></td>
					<td><table class="table_001">
						<tr><td class="th"><img src="Resource/Image/Index/open.gif">&nbsp;生产部</td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Trade_Dye_Order&action=right2 " target="_blank">当日排缸任务</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=Trade_Dye_Order&action=PlanManage" target="_blank">生产计划查询</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=plan_dye&action=paigangSchedule1" target="_blank">未染色列表</a></td></tr>
						<tr><td><img src="Resource/Image/Index/outlink.gif">&nbsp;<a href="Index.php?controller=plan_dye&action=paigangSchedule" target="_blank">已排缸列表</a></td></tr>
					</table></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
