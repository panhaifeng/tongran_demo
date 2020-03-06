<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/prototype.js"></script>
<script language="javascript" src="Resource/Script/Fun.js"></script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onSubmit="return CheckForm(this)">
<legend><h5 align="center">{$title}</h5></legend>
<table width="100%" border="0" cellspacing="1" cellpadding="0">

	<!----基本信息start----------------------------->
	<tr>
		<td>
		<fieldset><legend>基本信息</legend>
        <table width="100%" border="0">
          <tr>
            <td height="25">单号：
				<input type="hidden" name="id" id="id" value="{$arr_field_value.$pk}">
              	<input name="dingDanNum" type="text" id="dingDanNum" value="{$arr_field_value.dingDanNum}" size="15" warning="请输入单号!" check="^\w+$" ></td>	
            <td>订单日期：
              	<input name="dingDanDate" type="text" id="dingDanDate"  value="{if $arr_field_value.dingDanDate==null} {$default_date}{else} {$arr_field_value.dingDanDate} {/if}" size="15" onClick="calendar()"></td>
            <td>交货日期：
              	<input name="jiaoHuoDate" type="text" id="jiaoHuoDate"  value="{if $arr_field_value.jiaoHuoDate==null} {$default_date}{else} {$arr_field_value.jiaoHuoDate} {/if}" size="15" onClick="calendar()"></td>
			<td></td>
          </tr>
          <tr>
            <td height="25">客户：
			  <select name="clientId">
				{webcontrol type='TmisOptions' model='JiChu_Client' selected = $arr_field_value.clientId}
			  </select>			</td>
			<td height="25">业务员：			
			  <select name="employId">
				{webcontrol type='TmisOptions' model='JiChu_Employ' selected = $arr_field_value.employId}
			  </select>			</td>
			<td height="25">操作人：{if $arr_field_value.userId==null} {$real_name}{else} {$arr_field_value.User.realName} {/if}
				<input id="userId" name="userId" value="{$user_id}" type="hidden"></td>
			<td></td>
          </tr>
          <tr>
            <td colspan="4" align="left">备注：<input name="memo" type="text" id="memo" value="{$arr_field_value.memo}" size="83"></td>
          </tr>
        </table>
      	</fieldset>
		</td>
	</tr>
	<!----基本信息end----------------------------->
	
	<tr>
		<td><input id="addProduct" name="addProduct" type="button" value="增加产品" onClick="javascript:window.location.href='Index.php?controller={$queen_controller}&action=index&baseTableId={$arr_field_value.$pk}'"></td>
	</tr>
	
	<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><input name="Submit" type="submit" id="Submit" value='确定'><input name="Back" type="button" id="Back" value='返回' onClick="javascript:window.location.href='{url controller=$smarty.get.controller}'"></td>
	</tr>
</table>

</form>
</body>
</html>
