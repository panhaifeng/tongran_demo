<script language="javascript" src="Resource/Script/CheckForm.js"></script>
<script language="javascript" src="Resource/Script/prototype.js"></script>
<script language="javascript" src="Resource/Script/Fun.js"></script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" onsubmit="return CheckForm(this)">

    	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">        
			<tr align="center" bgcolor="#FFFFFF">
			  <td height="25" align="left">■ {$title}</td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><table width="100%"  border="0" cellpadding="1" cellspacing="1" bgcolor="#999999">
				  <!-----字段名------------->
				  <tr align="center" bgcolor="#FFFFFF">
					<td>品名</td>
					<td height="20">规格</td>
					<td>材料</td>
					<td>标准条码</td>
					<td height="20">数量</td>
					<td height="20">操作</td>
				  </tr>
				  
				  <!-----字段值输入框------->
				  <tr align="center" bgcolor="#FFFFFF">				   
				   <td height="20">
				   	<input id="baseTableId" name="baseTableId" type="hidden" value="{$base_table_id}" />
					
					<input id="productId" name="productId" type="hidden">
					<input id="name" name="name" type="text" size="10" ondblclick="return PopUpPro('Index.php?controller=CangKu_ProductListPop')" ></td> 
				   <td>
					<input id="guige" name="guige" type="text"></td>
					
					<td><input id="material" name="material" type="text" readonly></td>
					<td><input id="standardCode" name="standardCode" type="text" readonly></td>
					<td><input id="cnt" name="cnt" type="text" warning="数量格式不对"  onkeyup="calValue()"></td>
					
					
					<td height="20"><input type="submit" name="Submit" id="Submit" value="增加"></td>
				  </tr>
				  

				{include file="CangKu/_List.tpl"}	
				  		  
			  </table></td>
			</tr>
			<tr align="center" bgcolor="#FFFFFF">
			  <td height="25"><input name="Back" type="button" id="Back" value='完成' onclick="javascript:window.location.href='{url controller=$back_controller action='edit' id=$base_table_id}'"></td>
			</tr>
	  	</table> 
</form>   
