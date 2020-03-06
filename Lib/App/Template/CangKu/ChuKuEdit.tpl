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
<legend><h5 align="center">领料出库</h5></legend>
<table width="100%" border="0" cellspacing="1" cellpadding="0">

	<!----基本信息start----------------------------->
	<tr>
		<td>
		<fieldset>
        <legend>领料基本信息</legend>
        <table width="100%" border="0">
          <tr>
            <td width="45%" height="25">领料单号：
		      <input type="hidden" name="id" id="id" value="{$arr_field_value.$pk}">
              	<input name="chukuNum" type="text" id="chukuNum" value="{$arr_field_value.chukuNum}" size="15" warning="请输入单号!" check="^\w+$" ></td>	
            <td width="55%">出库日期：
       	    <input name="chukuDate" type="text" id="chukuDate"  value="{$arr_field_value.chukuDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
		  </tr>
          
          <tr>
            <td>部门：
              <label>
              <select name="depId" id="depId">
              {webcontrol type='Tmisoptions' model='JiChu_Department' selected=$arr_field_value.depId}
              </select>
            </label></td>
            <td>备注：
            <input name="memo" type="text" id="memo" value="{$arr_field_value.memo}" size="40"></td>
          </tr>
        </table>
      	</fieldset>		</td>
	</tr>
	<!----基本信息end----------------------------->
	

	<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><input name="Submit" type="submit" id="Submit" value='确定并编辑货品信息'><input name="Back" type="button" id="Back" value='返回' onClick="javascript:window.history.go(-1)"></td>
	</tr>
</table>

</form>
</body>
</html>
