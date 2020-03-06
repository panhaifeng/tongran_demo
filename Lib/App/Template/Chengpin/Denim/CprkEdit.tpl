<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">

<table width="100%" border="0" cellspacing="1" cellpadding="0">

	<!----基本信息start----------------------------->
	<tr>
		<td>
		<fieldset>
        <legend>{$title}</legend>
        <table width="100%" border="0">
          <tr>
            <td width="45%" height="25">入库单号：
		      <input type="hidden" name="id" id="id" value="{$arr_field_value.id}">
              	<input name="cprkCode" type="text" id="cprkCode" value="{$arr_field_value.cprkCode}" size="15" warning="请输入单号!" check="^\w+$"></td>	
            <td width="55%">入库日期：
   	        <input name="dateCprk" type="text" id="dateCprk"  value="{$arr_field_value.dateCprk|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
		  </tr>
          
          <tr>
            <td colspan="2">备注：
            <input name="memo" type="text" id="memo" value="{$arr_field_value.memo}" size="50"></td>
          </tr>
        </table>
      	</fieldset>		</td>
	</tr>
	<!----基本信息end----------------------------->
	

	<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><input name="Submit" type="submit" id="Submit" value='确定并输入入库明细'>
	  <input name="Back" type="button" id="Back" value='返回' onClick="javascript:window.history.go(-1)"></td>
	</tr>
</table>

</form>
</body>
</html>
