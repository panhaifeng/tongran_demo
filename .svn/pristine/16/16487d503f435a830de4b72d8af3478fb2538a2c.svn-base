<html>
<head>
<title>{webcontrol type='GetAppInf' varName='systemName'}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="Resource/Script/keyboard.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
{literal}
<style>
body,table,form{margin:0px; padding:0px;}
td{ font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666666; font-weight:bold}
a:link{color:#666666;text-decoration:none;}
a:visited{color:#666666;text-decoration: none;}
a:hover{color:#006699;text-decoration:underline;}
</style>
<script type="text/javascript">
function checkss(){
	var inst=$('#banciId').val();
	if(inst==''){
		alert('请选择:班次!');
		return false;
	}
	return true;
}
var curEditName;
$(function(){
	curEditName="login.username";

});
function setKey(Obj){
	curEditName="login."+Obj.name;
}
</script>
{/literal}
</head>
<body bgcolor="#33689e" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align:center">
<!-- ImageReady Slices (01.jpg - Slices: 01, 02, 03, 04, 05) -->
<br><br><br><br><br>
<table width="667" height="404" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<img src="Resource/Image/Login/Login_03_01.jpg" width="11" height="11" alt=""></td>
		<td colspan="3">
			<img src="Resource/Image/Login/Login_03_02.jpg" width="646" height="11" alt=""></td>
		<td>
			<img src="Resource/Image/Login/Login_03_03.jpg" width="10" height="11" alt=""></td>
	</tr>
	<tr>
		<td colspan="5">
			<img src="Resource/Image/Login/Login_03_04.jpg" width="667" height="53" alt=""></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="7">
			<img src="Resource/Image/Login/Login_03_05.jpg" width="134" height="266" alt=""></td>
		<td>
			<table width="428" height="27" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<img src="Resource/Image/Login/Login_03_06_01.jpg" width="134" height="27" alt=""></td>
					<td valign="bottom" style="background-image:url(Resource/Image/Login/systemName_bg.gif); width:294px; height:27px; color:#33689e; font-size:20px;">
						{webcontrol type='GetAppInf' varName='systemName'}<span style="font-size:12px;">{webcontrol type='GetAppInf' varName='versionNum'}</span>
					</td>
				</tr>
			</table>
		</td>
		<td colspan="2" rowspan="7">
			<img src="Resource/Image/Login/Login_03_07.jpg" width="105" height="266" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="Resource/Image/Login/Login_03_08.jpg" width="428" height="16" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="Resource/Image/Login/Login_03_09.jpg" width="428" height="7" alt=""></td>
	</tr>
	<tr>
		<td>
			<table width="428" height="173" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td rowspan="2">
						<img src="Resource/Image/Login/Login_03_10_01.jpg" width="33" height="173" alt=""></td>
					<td>
						<img src="Resource/Image/Login/Login_03_10_02.jpg" width="185" height="23" alt=""></td>
					<td rowspan="2">
						<img src="Resource/Image/Login/Login_03_10_03.jpg" width="30" height="173" alt=""></td>
					<td rowspan="2">
						<img src="Resource/Image/Login/Login_03_10_04.jpg" width="180" height="173" alt=""></td>
				</tr>
				<tr>
					<td style="background-image:url(Resource/Image/Login/Login_03_10_05.gif); width:185px; height:150px;" valign="top">					
					<form action="?controller=Login&action=Login2" method="post" enctype="multipart/form-data" name="login" id="login" onSubmit="return checkss()">
						<table>
							<tr>
								<td width="80">用户名<span style="font-weight:bold">:</span></td><td align="left"><input type="text" name="username" id="username" value="" style="width:100px;" onClick="setKey(this)" tabindex="1"/></td>
								<td rowspan="3" align="left" style="border-left: solid blue 1px;"><a href="#" onClick="showkeyboard(curEditName)">使用小键盘</a></td>
							</tr>
							
							<tr>
								<td>密&nbsp;&nbsp;&nbsp;码<span style="font-weight:bold">:</span></td>
								<td align="left"><input type="password" name="password" id="password" value="" style="width:100px;" tabindex="2" onClick="setKey(this)"/></td>
							</tr>
							
							<tr >
							  <td>班&nbsp;&nbsp;&nbsp;次:</td>
							  <td  align="left" nowrap >
                              		<select name="banciId" id="banciId"> 
                                    	<option value="">请选择</option>     
                                        <option value="1">早班</option>
                                        <option value="2">晚班</option>
                                    </select>
                           		<input type="hidden" name="gongxuId" id="gongxuId" value="{$smarty.get.gongxuId}"></td>
                            </tr>
                            <tr style="height:30px;">
								<td colspan="3"><input name="login" type="submit" class="button" value=" 登 陆 " tabindex="3"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="button" type="button" class="button" onClick="window.location.href='{url controller=$smarty.get.controller action=Login}'" value=" 返 回 " tabindex="4"/></td>
							</tr>
						</table>
					</form>
					</td>
				</tr>
			</table>
		
		</td>
	</tr>
	<tr>
		<td background="Resource/Image/Login/Login_03_11.jpg" width="428" height="23"></td>
	</tr>
	<tr>
		<td background="Resource/Image/Login/Login_03_12.jpg" width="428" height="5"></td>
	</tr>
	<tr>
		<td background="Resource/Image/Login/Login_03_13.jpg" width="428" height="15" style="font-size:11px; font-weight:normal;" align="right">技术支持：<a href="#">常州易奇信息科技</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">
			<img src="Resource/Image/Login/Login_03_14.jpg" width="667" height="64" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="Resource/Image/Login/Login_03_15.jpg" width="11" height="9" alt=""></td>
		<td colspan="3">
			<img src="Resource/Image/Login/Login_03_16.jpg" width="646" height="9" alt=""></td>
		<td>
			<img src="Resource/Image/Login/Login_03_17.jpg" width="10" height="9" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="Resource/Image/Login/分隔符.gif" width="11" height="1" alt=""></td>
		<td>
			<img src="Resource/Image/Login/分隔符.gif" width="123" height="1" alt=""></td>
		<td>
			<img src="Resource/Image/Login/分隔符.gif" width="428" height="1" alt=""></td>
		<td>
			<img src="Resource/Image/Login/分隔符.gif" width="95" height="1" alt=""></td>
		<td>
			<img src="Resource/Image/Login/分隔符.gif" width="10" height="1" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
</body>
</html>
<script language="JavaScript">document.login.username.focus();</script>
