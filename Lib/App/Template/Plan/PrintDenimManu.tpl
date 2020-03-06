<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{webcontrol type='GetAppInf' varName='compName'}针织牛仔定产单</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0" align="center">
    <tr>
        <td colspan="5" align="center" class="font1">{webcontrol type='GetAppInf' varName='compName'}针织牛仔定产单</td>
    </tr>
    <tr>
        <td width="52">合同编号:</td>
        <td width="262">{$arr_field_value.Order.orderCode}</td>
        <td width="45">&nbsp;</td>
        <td width="77">客户编号:</td>
        <td width="100">{$arr_field_value.clientCode}</td>
    </tr>
    <tr>
        <td>生产编号:</td>
        <td>{$arr_field_value.manuCode}</td>
        <td>&nbsp;</td>
        <td>下单日期:</td>
        <td>{$arr_field_value.Order.dateOrder}</td>
    </tr>
    <tr>
      <td>产品编号:</td>
      <td>{$arr_field_value.Product.proCode}</td>
      <td>&nbsp;</td>
      <td>交货日期:</td>
      <td>{$arr_field_value.Order.dateJiaohuo}</td>
    </tr>
    <tr>
        <td colspan="5">
			<table id="dingdan" class="haveBorder">
				<tr>
				  <td width="92">品名:</td> 
				<td width="210">{$arr_field_value.Product.proName}</td> 
				<td colspan="2" align="center">品质样:</td> 
				</tr>
				<tr><td>规格:</td> 
				  <td>{$arr_field_value.Product.guige}</td> 
				    <td colspan="2" rowspan="6" align="center">贴样处</td> 
				</tr>
				<tr><td>门幅:</td> 
				    <td>{$arr_field_value.Product.menfu}CM&plusmn;{$arr_field_value.menfuDiff}CM </td> 
				</tr>
				<tr><td>克重:</td> 
				    <td>{$arr_field_value.Product.kezhong}G/M2&plusmn;{$arr_field_value.kezhongDiff}G/M2</td> 
				</tr>
				<tr><td>定单数量:</td> 
				    <td>{$arr_field_value.cntKg}KG</td> 
				</tr>
				<tr><td>短溢范围:</td> 
				    <td>&plusmn;{$arr_field_value.Order.overflow} % </td> 
				</tr>
				<tr><td>交货期限:</td> 
				    <td>{$arr_field_value.Order.dateJiaohuo}</td> 
				</tr>
				<tr><td>经营方面 <br>
				    <br>
				    备注要求:</td> 
				<td colspan="3">{$arr_field_value.Order.memoTrade}</td> 
				</tr>
				<tr><td>成品匹长:</td> 
				    <td>&nbsp;每匹{$arr_field_value.Order.pichang}M以上 </td> 
			        <td width="86">理论数量:</td> 
			    <td width="157">{$arr_field_value.Order.kgTheory} KG({$arr_field_value.Order.mTheory}M) </td>
				</tr>
				<tr><td>包装要求:</td> 
				    <td>{$arr_field_value.Order.packing}</td> 
				    <td>经向缩率:</td> 
				    <td>{$arr_field_value.Order.warpShrink} % </td>
				</tr>
				<tr><td>检验要求:</td> 
				    <td>{$arr_field_value.Order.checking}</td> 
				    <td>纬向缩率:</td> 
				    <td>{$arr_field_value.Order.weftShrink}% </td>
				</tr>
				<tr><td><p>生产方面<br>
				    <br>
				        注意事项:</p>
				    </td> 
				<td colspan="3">{$arr_field_value.Order.memoManu}</td> 
				</tr>
				<tr><td>色纱情况:</td> 
				    <td><input type="radio" name="kc">有库存 <input type="radio" name="kc">无库存 </td> 
				    <td>定型主任:</td> <td></td></tr>
				<tr><td>业务跟单:</td> <td></td> 
				    <td>成品主任:</td> <td></td></tr>
				<tr><td>业务经理:</td> <td></td> 
				    <td>织造主任:</td> <td></td></tr>
				<tr><td>销售负责:</td> <td></td> 
				    <td>生产负责:</td> <td></td></tr>
			</table>		</td>
    </tr>
</table>
</body>
</html>
