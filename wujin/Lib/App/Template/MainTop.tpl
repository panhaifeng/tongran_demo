<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>main-top</title>
{literal}

<style type="text/css">
	/* 主菜单标签 */
body {margin:0px; padding:0px;}
a {text-decoration: none;color: #555555}
a:hover {text-decoration: underline;/*color: #FFFFFF;*/}

.topmenubg {
	background: url(Resource/Image/System/bg_header.gif) repeat-x;
	/*background-color:#ffffff;*/
}
.topmenu {
	height: 38px;
	float: left;
	min-width: 600px;
	width: 100%;
	font-size: 14px;
	font-weight: bold;
	color: #555555;
	/*color:#ffffff;*/
	margin-top: 24px;
}
.topmenu ul {
	margin: 0px;
	padding: 0px;
}

.topmenu li {
	float: left;
	border: solid 1px #43809C;
	border-bottom: none;
	list-style-type: none;
	margin-right: 1px;
	margin-top: 2px;
}

.topmenu span {
	display: block;
	float: left;
	padding: 0 10px;
	background: url(Resource/Image/System/bg_menu2.gif);
	height: 25px;
	line-height: 25px;
	border: solid 1px #FFFFFF;
	border-bottom: none;
	color: #555555;
}

/* 当前链接标签 */

#menuon {
	margin-top: 0px;
	height: 30px;
	line-height: 30px;
	border: solid 1px #525C3D;
	border-bottom: none;
	background: url(bg_menu.gif);
}

#menuon span {
	padding-top: 1px;
	background: url(Resource/Image/System/bg_menu.gif);
	border: solid 1px #FFFFFF;
	height: 27px;
	border-bottom: none;
}
#menuon span a {
	color: #003366;
}
</style>

<script src="Resource/Script/menu.js" type="text/javascript"></script>
<script>

//var menus = new Array('Base', 'Manu','Report', 'Other');
function togglemenu(obj) {
	if(parent.menu) {//left的ifram存在
		var divs = parent.menu.document.getElementsByName('leftMenu');	
		var lis = document.getElementsByTagName('li');
		var k = 0;//需要显示的leftMenu的序号
		for (var i=0;i<lis.length;i++){			
			if(lis[i]==obj){
				k=i;
			}
		}
		for (var i=0;i<divs.length;i++){
			divs[i].style.display = i == k ? '' : 'none';
		}
	}
}

function sethighlight(o) {
	var lis = document.getElementsByTagName('li');
	for(var i = 0; i < lis.length; i++) {
		lis[i].id = '';
	}
	o.parentNode.parentNode.id='menuon';
}

</script>
{/literal}

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="topmenubg">
<tr>
	<td rowspan="2" width="250px">
		<div style="padding-left:0px; text-align:center; font-size:14px; color:#FFFFFF;">
			<strong>{webcontrol type='GetAppInf' varName='systemName'}</strong><br />
			<span style="color:#99CCCC; font-size:12px;">用户:&nbsp;<font color="#FFA505">{$real_name}</font></span>
			<span id='czClock' style="color:#99CCCC; font-size:12px;"></span>
		</div>
	</td>
	<td>
		<div class="topmenu">
		<ul>
		{foreach from=$menu item=item key=key}
		<li>
			<span>
				<a href="#" id="Base" name="Base" onclick="sethighlight(this); togglemenu(this.parentNode.parentNode);return false;">{$key}</a>
			</span>
		</li>
		{/foreach}
		</ul>
		</div>
	</td>
   
</tr>
</table>
<INPUT TYPE="hidden" NAME="instId" id='instId' value=0>
</body></html>
<script language="javascript" src="Resource/Script/DateTime.js"></script>