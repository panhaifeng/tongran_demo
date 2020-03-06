<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>{webcontrol type='GetAppInf' varName='systemName'}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
{literal}
<style type="text/css">
html, body {
	background: #BFD6F6;
	color: #FFFFFF;
	font: 12px Arial, Helvetica, sans-serif;
}

td{font: 12px Arial, Helvetica, sans-serif;}

.logintable {
	width:600px;
	border: 1px solid #296C89;
	background:#159bd0;
	margin:0 auto;
}
.loginheader td {
	height: 40px;
	background: url(../Image/Login/login_header.gif) repeat-x;
}

input {
	border: 1px solid #FFFFFF;
	background: #FFFFFF;
}

td.line1 {border-bottom: 1px solid #BFD6F6;}

td.line2 {border-top: 1px solid #296C89;}

a {color: #FFFF66;	}

form {margin: 0px;}

a:hover {color: #FFFF66;}

.button {
	font: 12px Arial, Helvetica, sans-serif;
	padding: 0 6px;
	color: #000000;
	background: #bedeff url(bg_button.gif) repeat-x;

	/*for Mozilla*/
 	outline: 1px solid #296c89 ;
	border: 1px solid #FFFFFF !important;
	height: 24px !important;
	line-height: 22px !important;

	/*for IE7*/
	> border: 1px solid #296C89 !important;
	> height: 26px !important;
	> line-height: 20px !important;

	/*for IE*/
	border: 1px solid #296C89 ;
	height: 26px;
	line-height: 20px;
}


</style>
{/literal}
</head>
<br /><br /><br /><br />
<table width="100%">
	<tr><td align="center">
<table border="0" cellpadding="8" cellspacing="0" class="logintable">
<tr class="loginheader"><td width="80"></td><td width="100"></td><td></td><td width="120"></td><td width="80"></td></tr>
<tr style="height:40px"><td>&nbsp;</td>
<td class="line1"><span style="color:#ffff66;font-size:14px;font-weight: bold;">用户登陆</span></td>
<td class="line1">&nbsp;</td>
<td class="line1">&nbsp;</td>
<td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td class="line2">&nbsp;</td><td>&nbsp;</td></tr>


<form name="login" id="login" method="post" action="?controller=Login&action=Login">
<tr>
<td>&nbsp;</td>
<td align="right">用户名</td><td><input type="text" name="username" id="username" value="" style="width:150px;" tabindex="1"/></td>
<td><a href="?controller=Login&action=LogoutToIndex" tabindex="4">返回首页</a></td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp;</td>
<td align="right">密&nbsp;&nbsp;&nbsp;&nbsp;码</td>
<td><input type="password" name="password" id="password" value="" style="width:150px;" tabindex="2"/></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp;</td>
<td class="line1">&nbsp;</td>
<td class="line1" align="center">
	<input name="login" type="submit" class="button" value=" 登 陆 " tabindex="3"/>
</td>
<td class="line1">&nbsp;</td>
<td>&nbsp;</td>
</tr>
</form>
<tr>
<td>&nbsp;</td>
<td class="line2">&nbsp;</td>
<td class="line2">&nbsp;</td>
<td class="line2">&nbsp;</td>
<td>&nbsp;</td>
</tr>


<tr><td colspan="5" align="center">&nbsp; &copy; 2007-2009 技术支持 <b><a href="http://www.eqinfo.com.cn">常州市易奇信息科技有限公司</a></b></td></tr>
<tr><td colspan="5" style="height:30px"></td></tr>
</table>
</td></tr></table>
</html>
<script language="JavaScript">document.login.username.focus();</script>
