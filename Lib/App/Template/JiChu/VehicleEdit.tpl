<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>车辆信息编辑</title>
<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>
<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onsubmit="return CheckForm(this)">
	<fieldset>
		<legend>信息编辑</legend>
		<div align="center">
			<table>
			<tr>
				<td>
					车编号：
				</td>
				<td>
					<input name="carCode" type="text" id="carCode" value="{$rows.carCode}" check="^\S+$" warning="车编号不能为空！"/>
				</td>
			</tr>
			<tr>
				<td>
					联系人:
				</td>
				<td>
					<input name="people" type="text" id="people" value="{$rows.people}"/>
					<font color='red'>(多位时请用 ; 隔开.例张三;李四;王五)</font>
				</td>
			</tr>
			<tr>
				<td>
					联系电话：
				</td>
				<td>
					<input name="tel" type="text" id="tel" value="{$rows.tel}"/>
				</td>
			</tr>
			<tr>
				<td>
					备注：
				</td>
				<td>
					<input name="memo" type="text" id="memo" value="{$rows.memo}"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input name="{$pk}" type="hidden" id="{$pk}" value="{$rows.$pk}"/>
					<input name="id" type="hidden" id="id" value="{$rows.id}"/>
					<input type="submit" name="Submit" value="提交">
				</td>
			</tr>
			</table>
		</div>
	</fieldset>
</form>
</body>
</html>