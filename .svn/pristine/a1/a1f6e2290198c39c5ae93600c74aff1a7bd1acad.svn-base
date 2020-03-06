<html>
<head>
<title>{webcontrol type='GetAppInf' varName='systemV'}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="favicon" rel="shortcut icon" href="favicon.ico" />
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<script language="javascript">
{literal}
window.onbeforeunload = function(){
	  var   n   =   window.event.screenX   -   window.screenLeft;
      var   b   =   n   >   document.documentElement.scrollWidth-20;
      if(b   &&   window.event.clientY   <   0   ||   window.event.altKey)
      {
          //alert("是关闭而非刷新");
          window.event.returnValue   =   "您是否确认要离开系统并关闭窗口？";
      }else{
             //alert("是刷新而非关闭");
     }
}
{/literal}
</script>
{literal}
<script language="javascript">
var cntJiaji=0;
$(function(){
	//得到加急的缸的数量,并进行链接
	// getJiaji();
	// setInterval('getJiaji()',10000);
	maintenancePop();
});
function getJiaji(){
	var url='?controller=plan_dye&action=GetJiajiJson';
	var param={};
	$.getJSON(url,param,function(json){
		//如果加急的缸数有变化，弹出窗口进行提醒
		document.getElementById('spanJiaji').innerHTML = json.cntJiaji || 0;
		/*if(cntJiaji<json.cntJiaji && cntJiaji>0) {//如果原来的加急数>0且当前加急数>原来加急数,弹出窗口
			//alert($.query.get.length);return false;
			var url = window.parent.main.location.href;
			if(url.indexOf('OA_Message')>-1 && url.indexOf('listJiaji')>-1) {
				window.parent.main.location.href='?controller=OA_Message&action=listJiaji';
			} else if(confirm('系统发现新的加急缸,您希望马上打开加急列表吗？')) {
				window.parent.main.location.href='?controller=OA_Message&action=listJiaji';
			};
		} */
		cntJiaji=json.cntJiaji;
	});
}

// 维护到期状态获取 提醒
function maintenancePop(){
    var url='?controller=Main&action=GetMaintenanceInfo';
    var param = null;
    $.post(url,param,function(json){
        if(!json) {
            alert('异常');
            return false;
        }
        if(json.showRemind){
            ymPrompt.win(
                json.msg,
                950,
                420,
                '维护到期提醒',
            　  function() {}, //回调事件
            　  '#000', //遮罩透明色
            　  0.3, //遮罩透明度
            　  false //iframe模式
            );
        }
    },'json');
}

</script>
{/literal}
</head>
<body style="margin:0px" scroll="no">
<script src="Resource/Script/iframe.js" type="text/javascript"></script>
<div style="position: absolute;top: 0px;left: 0px; z-index: 2;height: 60px;width: 100%">
<iframe frameborder="0" id="header" name="header" src="Index.php?controller=main&action=top" scrolling="no" style="height: 60px; visibility: inherit; width: 100%; z-index: 1;"></iframe>
</div>
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="table-layout: fixed;">
<tr><td width="165" height="60"></td><td></td></tr>
<tr>
<td><iframe frameborder="0" id="menu" name="menu" src="Index.php?controller=main&action=leftMenu" scrolling="yes" style="height: 100%; visibility: inherit; width: 100%; z-index: 1;overflow: auto;"></iframe></td>
<td><iframe frameborder="0" id="main" name="main" src="Index.php?controller=main&action=Content" scrolling="yes" style="height: 100%; visibility: inherit; width: 100%; z-index: 1;overflow: auto;"></iframe></td>
</tr>
<tr>
	<td height="25px" colspan="2">
		<table cellpadding="0" cellspacing="0" style="width:100%;border:1px solid #000;background-color:#278296;color:#FFF; font-family:'宋体'">
			<tr>
				<td style="color:#FFF; font-size:12px; height:25px; padding-left:10px;"><img src="Resource/Image/Index/b_comment.png" style="vertical-align:middle">&nbsp;技术支持：易奇科技({webcontrol type='Servtel'})
                &nbsp;&nbsp;
                <font style="font-size:12px;">定单号:</font><input type="text" name="orderCode" id="orderCode" style="height:18px" size="10" />
                <font style="font-size:12px;">缸号:</font>
                <input type="text" name="vatNum" id="vatNum" style="height:18px" size="10" />
                <input type="submit" style="font-size:12px; height:18px" name="button" id="button" value="进度跟踪" onClick="var id=document.getElementById('vatNum').value;var orderCode=document.getElementById('orderCode').value; if(id==''&&orderCode=='') return false;window.open('Index.php?controller=Public_Search&action=right0&vatNum='+id+'&orderCode='+orderCode,'main')"/>
                </td>
				<td align="right"><a href="{url controller='OA_Message' action='listJiaji'}" target="_blank" style="color:#FFF; text-decoration:none; font-size:12px; font-weight:bold">本周 <span style="color:red" id='spanJiaji'>0</span> 缸加急&nbsp;</a></td>
			</tr>
		</table>
	</td>
</tr>
</table>
</body>
</html>