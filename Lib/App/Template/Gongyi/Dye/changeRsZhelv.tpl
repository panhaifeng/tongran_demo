<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>筒染工艺处方单</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
</head>
<body><br>

<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveRsZhelv'}" method="post" AUTOCOMPLETE="OFF">
<div align="center">
<table cellpadding="5" cellspacing="0" id='tbl'>
	<tr>
	  <td align="center">染色折率： </td>
	  <td align="center"><input name="rsZhelv" type="text" id="rsZhelv" value="{$aRow.rsZhelv}"></td>
	  <td align="center">&nbsp;</td>
	</tr>
	<tr>
	  <td align="center">物理缸：</td>
	  <td align="center">{$aRow.Vat.vatCode}</td>
	  <td align="center">&nbsp;</td>
	  </tr>
	<tr>
	  <td align="center">水容量：</td>
	  <td align="center"><select name="shuirong" id="shuirong">
        <option value="{$aRow.Vat.shuiRong}">{$aRow.Vat.shuiRong}</option>
        {if $aRow.Vat.shuiRong1>0}<option value="{$aRow.Vat.shuiRong1}" {if $aRow.shuirong==$aRow.Vat.shuiRong1}selected{/if}>{$aRow.Vat.shuiRong1}</option>{/if}
        </select>
	    L</td>
	  <td align="left"><font color='red'>注:水容量需在基础档案中的染缸档案中进行定义</font></td>
	  </tr>
	<tr>
	  <td align="center">&nbsp;</td>
	  <td align="center"><input name="submit" type="submit" value='确定'>
	    <input name="id" type="hidden" id="id" value="{$smarty.get.gangId}">
        <input name="ordwareId" type="hidden" id="ordwareId" value="{$smarty.get.ordwareId}">
        <input name="chufangId" type="hidden" id="chufangId" value="{$smarty.get.chufangId}"></td>
	  <td align="center">&nbsp;</td>
	  </tr>

</table>							
</div>
</form>
</body>
</html>
