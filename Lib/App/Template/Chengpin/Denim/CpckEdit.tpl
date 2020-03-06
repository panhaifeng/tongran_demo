<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>针织牛仔出库单基本信息</title>
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
        <legend>针织牛仔发货单基本信息</legend>
        <table width="100%" border="0">
          <tr>
            <td width="45%" height="25">出库单号：
		      <input type="hidden" name="id" id="id" value="{$arr_field_value.id}">
              	<input name="cpckCode" type="text" id="cpckCode" value="{$arr_field_value.cpckCode}" size="15" warning="请输入单号!" check="^\w+$"></td>	
            <td width="55%">发货日期：
   	        <input name="dateCpck" type="text" id="dateCpck"  value="{$arr_field_value.dateCpck|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
		  </tr>
          
          <tr>
            <td colspan="2">备注：
            <input name="memo" type="text" id="memo" value="{$arr_field_value.memo}" size="50"></td>
          </tr>
          <tr>
            <td colspan="2">配货合同号：
              <input name="orderCode" type="text" id="orderCode" value="{$arr_field_value.Order.orderCode}"></td>
          </tr>
        </table>
      	</fieldset>		</td>
	</tr>
	<!----基本信息end----------------------------->
	

	<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><input name="Submit" type="submit" id="Submit" value='确定并输入发货明细'>
	  <input name="Back" type="button" id="Back" value='返回' onClick="javascript:window.history.go(-1)"></td>
	</tr>
</table>

</form>
</body>
</html>
