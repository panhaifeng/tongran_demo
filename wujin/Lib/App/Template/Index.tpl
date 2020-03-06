<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>{webcontrol type='GetAppInf' varName='systemName'}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="Resource/Css/Index.css" type="text/css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico" />
	<style type="text/css">
	{literal}
	body{ margin:0px; padding:0px; font: 12px Arial, Helvetica, sans-serif}

	a{}
	a:link{color:#0099CC;text-decoration: underline;}
	a:visited{color:#0099CC;text-decoration: underline;}
	a:hover{color:#0099CC;text-decoration: underline;}

	input{border: 1px solid #3c3c3c; height:19px;	background-color: #F3F3F3;}

	DIV#top{width:780px; height:60px; clear:both; margin:0 auto; padding-top:30px /*border:1px solid #000;*/}
	DIV#top ul{margin-left:0px;list-style:none; /*border:1px solid #000;*/}
	DIV#top ul li{float:left;}
	DIV#top ul li h3{font:16px; margin-left:20px; margin-top:18px;width:480px; color:#003366}
	.czClock{margin-left:55px; margin-top:22px; width:150px; color:#fe7600; font-weight:bold;/*border:1px solid #000;*/}

	DIV#nav {clear:both;	width:800px; height:31px; margin:0 auto; background-image:url(Resource/Image/Index/bg_nav.gif); border:1px solid #CAD9E2; }
	DIV#nav ul{list-style:none; text-align:left; margin-left:5px; margin-top:8px;}
	DIV#nav ul li{float:left;}
	DIV#nav ul li strong {
			background:transparent url(../Image/Index/ictip.gif) no-repeat scroll 10px 5px;
			padding-top:4px; padding-left:30px; padding-right:10px; font-weight:bold; color:#0066CC;}

	DIV#content{width:800px;clear:both;	margin:0 auto; /*border:1px solid #000;*/}
	.content_ul {list-style:none; margin:0px; padding:0px;}
	.content_li {float:left;}
	DIV#contentLeft{margin-left:12px;}
	DIV#contentMiddle{margin-left:10px;}
	DIV#contentRight{margin-left:10px;}


	DIV#weather, #phone, #message{width:200px; border:1px solid #CCC; margin-top:10px;}
	DIV#developLog, #news, #companyPloy, #companyFile, #companySystem{width:400px; border:1px solid #CCC; margin-top:10px;}
	DIV#quickNav{width:150px; border:1px solid #CCC; margin-top:10px;}


	.caption {background:url(Resource/Image/Index/bg_lm.gif);	height:29px; font-weight:bold; color:#006699;padding:0px;}
	.caption ul{list-style:none; margin:0px;padding:0px;height:29px;}
	.caption ul li {margin-left:5px;margin-top:5px;}
	.caption ul li img{padding-right:5px;}


	.phoneList{}
	.phoneList ul{margin-left:20px; font-size:12px;}
	.phoneList li{padding-top:10px; list-style: none; border-bottom: 1px solid #EBEAEA; height:25px;}
	.phoneList li h5{font-size:12px; font-weight:normal; width:70px; float:left;}
	.phoneList li span{color:#CC9900;}

	.messageContent {}
	.messageContent ul{list-style:none;width:80%; margin:0 auto;}
	#messageButton {width:60px; margin:0 auto; padding-top:10px; height:30px;}


	.contentMiddleList{margin-left:20; padding-top:10px;}
	.contentMiddleList ul {margin:0px; padding:0px; list-style:none; }
	.contentMiddleList ul li {margin-left:10px; height:20px;}
	.contentMiddleList ul li a:link{color:#223355;text-decoration: none;}
	.contentMiddleList ul li a:visited{color:#223355;text-decoration: none;}
	.contentMiddleList ul li a:hover{color:#223355;text-decoration: underline;}

	.quickNavList ul{padding:0px; margin:0px; list-style:none; font-size:14px; color:#999999;}
	.quickNavList ul li{height:20px; padding-top:20px; padding-left:20px; padding-bottom:20px; list-style: none; border-bottom: 1px dashed #EBEAEA; }
	.quickNavList ul li img{margin-right:10px;}
	.quickNavList ul li a:link{color:#CC9900;text-decoration: none;}
	.quickNavList ul li a:visited{color:#CC9900;text-decoration: none;}
	.quickNavList ul li a:hover{color:black;text-decoration: underline;}


	DIV#publicSearch {clear:both; width:775px; margin:0 auto; border:1px solid #CCC;}
	.publicSearchList{margin-left:20; padding-top:10px;}
	.publicSearchList ul{margin:0px; padding:0px; list-style:none; clear:both; height:30px;}
	.publicSearchList ul li{float:left; margin-left:0px; width:150px;}
	{/literal}
	</style>
</head>
<body style='text-align:center'>
<div style='text-align:left; width:780px;'>
<div id="top">
	<ul>
		<li ><h3 style="color:#0B55C4; font-size:20px; font-weight:bold">{webcontrol type='GetAppInf' varName='systemName'}{webcontrol type='GetAppInf' varName='versionNum'}</h3></li>
	  <li class="czClock"><span id=czClock></span></li>
		<li class="clockTime"><span id=clockTime></span></li>
	</ul>
</div>

<div id=nav>
	<ul><li></li></ul>
</div>

<div id=content>
<ul class="content_ul"><li class="content_li">
<div id=contentLeft>

<div id=weather>
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">天气预报</li></ul>
		</div>
		<div style="margin-left:20px; margin-top:20px; margin-bottom:20px;">
			<iframe src="http://weather.265.com/weather.htm" width="180" height="50" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" name="265"></iframe>
		</div>
</div>

<div id=phone>
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">常用电话</li></ul>
		</div>
		<div class=phoneList>
			<ul>
				<li><h5>总经理</h5><span>818</span></li>
				<li><h5>财务科</h5><span>812</span></li>
				<li><h5>业务部</h5><span>811</span></li>
				<li><h5>化验室</h5><span>815</span></li>
				<li><h5>坯纱仓库</h5><span>813</span></li>
				<li><h5>色纱仓库</h5><span>804</span></li>
				<li><h5>软件故障</h5><span>13775052508</span></li>
				<li><h5>硬件故障</h5><span>13357892158</span></li>
			</ul>
		</div>
</div>

<div id=message style="display:none">
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">意见箱</li></ul>
		</div>
		<div class="messageContent">
			<ul>
				<li><textarea name="content" cols="16" rows="8" id="content"></textarea></li>
			</ul>
			<ul id=messageButton>
				<li id=submit><input type="submit" name="Submit" value="提交" style="width:40px"></li>
			</ul>
		</div>
</div>

</div><!-----content left end----------->
</li>
<li class="content_li">
<div id=contentMiddle>
<div id=developLog><!------公共查询区--------------->
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">公共查询区</li></ul>
		</div>
		<div class=publicSearchList>
			<ul style="font-weight:bold; font-size:14px;">
				<li><a href="Index.php?controller=Public_Search&action=Right" target="_blank">生产跟踪</a><img src="Resource/Image/Index/new.gif" /></li>
				<li><a href="#" target="_blank"></a></li>
				<li><a href="#" target="_blank"></a></li>
				<li><a href="#" target="_blank"></a></li>

			</ul>
			<ul>
				<li><a href="#" target="_blank"></a></li>
				<li><a href="#" target="_blank"></a></li>
				<li><a href="#" target="_blank"></a></li>
				<li><a href="#" target="_blank"></a></li>
			</ul>
		</div>
</div><!--publicSearch end-->


<!--
<div id=developLog>
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">系统开发日志</li></ul>
		</div>
		<div class=contentMiddleList>
			<ul>
			{foreach from=$arr_field_value1 item=field_value}
				<li><a href="Index.php?controller=Index&action=View&{$pk}={$field_value.$pk}" target="_blank"><img src="Resource/Image/Index/Icon_jsts.gif" border="0">
					{foreach from=$arr_field_info key=key item=item}
					{$field_value.$key|default:'&nbsp;'}
					{/foreach}
				</a>
				</li>
			{/foreach}
			</ul>
		</div>
</div>-->

<div id=news>
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">新闻活动</li></ul>
		</div>
		<div class=contentMiddleList>
			<ul>
			{foreach from=$arr_field_value2 item=field_value}
				<li><a href="Index.php?controller=Index&action=View&id={$field_value.id}" target="_blank"><img src="Resource/Image/Index/Icon_jsts.gif" border="0">
					{foreach from=$arr_field_info key=key item=item}
					{$field_value.$key|default:'&nbsp;'}
					{/foreach}
                    {if $field_value.buildDate==$smarty.now|date_format:"%Y-%m-%d"}
                    <img src="Resource/Image/Index/new.gif" style="margin-bottom:0px;" border="0" />
                    {/if}
				</a></li>
				{/foreach}
			</ul>
		</div>
</div>

<!--
<div id=companyPloy style="display:none">
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">公司活动</li></ul>
		</div>
		<div class=contentMiddleList>
			<ul>
			{foreach from=$arr_field_value3 item=field_value}
				<li><a href="#" target="_blank"><img src="Resource/Image/Index/Icon_jsts.gif" border="0">
					{foreach from=$arr_field_info key=key item=item}
					{$field_value.$key|default:'&nbsp;'}
					{/foreach}
				</a></li>
				{/foreach}
			</ul>
		</div>
</div>-->

<div id=companyFile>
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">公司文件</li></ul>
		</div>
		<div class=contentMiddleList>
			<ul>
			{foreach from=$arr_field_value4 item=field_value}
				<li><a href="Index.php?controller=Index&action=View&id={$field_value.id}" target="_blank"><img src="Resource/Image/Index/icon3.gif" border="0">
					{foreach from=$arr_field_info key=key item=item}
					{$field_value.$key|default:'&nbsp;'}
					{/foreach}
                    {if $field_value.buildDate==$smarty.now|date_format:"%Y-%m-%d"}
                    <img src="Resource/Image/Index/new.gif" style="margin-bottom:0px;" border="0" />
                    {/if}
				</a></li>
				{/foreach}
			</ul>
		</div>
</div>

<!--
<div id=companySystem>
		<div class="caption">
			<ul><li><img src="Resource/Image/Index/icon.gif">公司制度</li></ul>
		</div>
		<div class=contentMiddleList>
			<ul>
			{foreach from=$arr_field_value5 item=field_value}
				<li><a href="#" target="_blank"><img src="Resource/Image/Index/icon3.gif" border="0">
					{foreach from=$arr_field_info key=key item=item}
					{$field_value.$key|default:'&nbsp;'}
					{/foreach}
				</a></li>
				{/foreach}
				</ul>
		</div>
</div>-->

</div><!-----content middle end----------->
</li>
<li class="content_li">
<div id=contentRight style="display:none">
	<div id=quickNav>
	<div class="caption">
		<ul><li><img src="Resource/Image/Index/icon.gif">客户查询区</li></ul>
	</div>
	<div align="center" style="padding-top:5px; padding-bottom:5px">
		<form name="clientLogin" action="Index.php?controller=Login&action=ClientLogin" method="post" style="padding:0px; margin:0px;">
		用户名:<input name="clientName" type="text" style="width:80px; height:15px;" />
		<br /><br />
		密&nbsp;&nbsp;&nbsp;&nbsp;码:<input name="clientPassword" type="password" style="width:80px; height:15px;" />
		<br /><br />
		<input name="submit" type="submit" value="登 陆">
		</form>
	</div>
	</div>
</div><!-----content right end----------->
<div id=contentRight>
	<div id=quickNav>
	<div class="caption">
		<ul><li><img src="Resource/Image/Index/icon.gif">快速导航</li></ul>
	</div>
	<div class=quickNavList style="">
		<ul>
		<li><img src="Resource/Image/Index/arrow.gif" style="margin-bottom:-3px;"><a href="Index.php?controller=main&action=index&menuName=Cangku" class="link_04">仓库管理</a></li>
		<li><img src="Resource/Image/Index/arrow.gif" style="margin-bottom:-2px;"><a href="Index.php?controller=main&action=index&menuName=Sell" class="link_04">销售管理</a></li>
		<li><img src="Resource/Image/Index/arrow.gif" style="margin-bottom:-3px;"><a href="Index.php?controller=main&action=index&menuName=Produce" class="link_04">生产管理</a></li>
		<li><img src="Resource/Image/Index/arrow.gif" style="margin-bottom:-3px;"><a href="Index.php?controller=main&action=index&menuName=Caiwu" class="link_04">财务管理</a></li>
		<li><img src="Resource/Image/Index/arrow.gif" style="margin-bottom:-3px;"><a href="Index.php?controller=main&action=index&menuName=OA" class="link_04">人事办公</a></li>
		</ul>
	</div>
	</div>
</div><!-----content right end----------->
</li>
</ul>
</div><!------content end---------->

<br />


<div style=" clear:both; width:800px; text-align:center">
	<ul style="list-style:none; margin:0; padding:0px;">
		<li style="border-bottom:1px solid #ccc"></li>
		<li style="margin:0 auto; width:480px;padding-top:10px;padding-bottom:10px; font:12px Arial, Helvetica, sans-serif;">&copy;2009 - 2010 {webcontrol type='GetAppInf' varName='compName'}     ( 技术支持 易奇科技 )</li>
  </ul>
</div><!-----bottom end----------->
</div>
</body>
</html>

<script language="javascript" src="Resource/Script/DateTime.js"></script>
<script language="javascript" src="Resource/Script/swfobject.js"></script>