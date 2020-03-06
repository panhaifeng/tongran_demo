<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
#divJingyan{display: inline;}
.box {
    width: 100px;
    overflow: hidden;
    float: right;
    z-index: 2;
    right: 0;
}
.col1{
    padding-top:10px;
    width: 500px;
    z-index: 999;
    position: absolute;
    float: right;
    right: 0;
    font-size: 12px;
    color: red;
}
.hide{
	display: none;
}
</style>

<script src="Resource/Script/common_main.js" type="text/javascript"></script>
<script src="Resource/Script/menu.js" type="text/javascript"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
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
$(function(){
	$('body').keydown(function(e){
		var currKey=e.keyCode||e.which||e.charCode;
		//alert(currKey);
		//如果ctrl+alt+shift+A弹出db_change输入框,此功能只开发给开发人员形成db_change文档时用
		if(e.altKey&&e.ctrlKey&&e.shiftKey&&currKey==65) {
			var url = '?controller=Dbchange&action=Add';
			window.open(url);
		}
		//如果ctrl+alt+shift+z弹出执行窗口,此功能只给实施人员用
		if(e.altKey&&e.ctrlKey&&e.shiftKey&&currKey==90) {
			var url = '?controller=Dbchange&action=AutoUpdate';
			window.open(url);
		}
	});

});
</script>
{/literal}

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="topmenubg">
<tr>
	<td rowspan="2" width="250px">
		<div style="padding-left:0px; text-align:center; font-size:14px; color:#FFFFFF;">
			<strong>{webcontrol type='GetAppInf' varName='systemV'}</strong><br />
			<span style="color:#99CCCC; font-size:12px;">用户:&nbsp;<font color="#FFA505">{$real_name}</font></span>
			<span id='czClock' style="color:#99CCCC; font-size:12px;"></span>
			<a id="divJingyan" href="?controller=Point_Point&action=Location" target="_blank"></a>
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
<div class="box hide" id="box" >
    <div class="col1" id="col1">
             尊敬的客户，贵司系统云空间于2018年11月24日即将到期，请及时续费。如未能及时续费将导致系统不能访问，由此给大家带来的不便敬请谅解。
    </div>
</div>
</table>
<INPUT TYPE="hidden" NAME="instId" id='instId' value=0>
<script type="text/javascript">
{literal}
$(function(){
	setTimeout('getJifen()',3000);

})

function getJifen(){
	//上传本地经验积分，取得最新的排名和最新的经验积分
	//url('Jifen_Comp','upJifenByUser',$_SESSION));
	var upUrl = "?controller=Point_Point&action=RunSign";
	$.getJSON(upUrl,null,function(json){
		var div = $('#divJingyan');
		if(json.html)div.html(json.html);

	});
}
var LEN = 220;      // 一个完整滚动条的长度
var x = 0;
var t;
window.onload = roll;
function roll() {
     var $col1 = document.getElementById("col1");

     var fun = function(){
         $col1.style.right = x + 'px';
         x++;
         if( (x - LEN) == 0 ){
             x = 0;
         }

     };
     t = setInterval(fun,100);
}
{/literal}
</script>
</body></html>
<!-- <script language="javascript" src="Resource/Script/DateTime.js"></script> -->