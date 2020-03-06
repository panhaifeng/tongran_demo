<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{webcontrol type='GetAppInf' varName='compName'}</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0" align="center">
    <tr>
        <td colspan="5" align="center" class="font1">{webcontrol type='GetAppInf' varName='compName'}加工染色定产单</td>
    </tr>
    <tr>
        <td width="52">合同编号:</td>
        <td width="262">{$arr_field_value.orderCode}</td>
        <td width="45">&nbsp;</td>
        <td width="77">客户编号:</td>
        <td width="100">{$arr_field_value.clientId}</td>
    </tr>
    <tr>
        <td>生产编号:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>下单日期:</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp; 年&nbsp;&nbsp;&nbsp;&nbsp; 月&nbsp;&nbsp;&nbsp;&nbsp; 日 </td>
    </tr>
    <tr>
        <td colspan="5">
			<table id="dingdan" class="haveBorder">
				<tr><td width="92">品种:</td> 
				<td width="210"></td> 
				<td colspan="2" align="center">品质样:</td> 
				</tr>
				<tr><td>规格:</td> <td></td> 
				    <td colspan="2" rowspan="6" align="center">贴样处</td> 
				</tr>
				<tr><td>门幅:</td> 
				    <td>&nbsp;&nbsp;&nbsp;&nbsp; CM&plusmn;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CM </td> 
				</tr>
				<tr><td>克重:</td> 
				    <td>&nbsp;&nbsp;&nbsp;&nbsp;G/M2&plusmn;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G/M2</td> 
				</tr>
				<tr><td>定单数量:</td> 
				    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; KG&nbsp; (&nbsp;&nbsp;&nbsp; M) </td> 
				</tr>
				<tr><td>短溢范围:</td> 
				    <td>&nbsp;&nbsp;&nbsp;&nbsp; &plusmn;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; % </td> 
				</tr>
				<tr><td>交货期限:</td> 
				    <td>&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;&nbsp; 月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 日 </td> 
				</tr>
				<tr><td>经营方面 <br>
				    <br>
				    备注要求:</td> 
				<td colspan="3"></td> </tr>
				<tr><td>成品匹长:</td> 
				    <td>&nbsp;第匹&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; M以上 </td> 
			    <td width="86">理论数量:</td> 
			    <td width="157">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; KG(&nbsp;&nbsp;&nbsp; M) </td>
				</tr>
				<tr><td>包装要求:</td> 
				    <td><input type="radio" name="cq">厂签 <input type="radio" name="kq">客签 <input type="radio" name="zx">中性 </td> 
				    <td>经向缩率:</td> 
				    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; % </td>
				</tr>
				<tr><td>检验要求:</td> 
				    <td><input type="radio" name="sj">商检 <input type="radio" name="kj2">客检 <input type="radio" name="zj">自检 </td> 
				    <td>纬向缩率:</td> 
				    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; % </td>
				</tr>
				<tr><td><p>生产方面<br>
				    <br>
				        注意事项:</p>
				    </td> 
				<td colspan="3"></td> </tr>
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
