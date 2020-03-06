<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>销售合同</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="761" border="0" align="center">
    <tr>
        <td colspan="6" class="font1" align="center">销售合同</td>
    </tr>
    <tr>
        <td width="37">甲方:</td>
        <td colspan="2">{webcontrol type='GetAppInf' varName='compName'}</td>
        <td width="140">&nbsp;</td>
        <td width="61">合同号:</td>
        <td width="90">{$aRow.orderCode}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td width="122">&nbsp;</td>
        <td width="285">&nbsp;</td>
        <td>&nbsp;</td>
        <td>签订地点:</td>
        <td>{webcontrol type='GetAppInf' varName='compName'}</td>
    </tr>
    <tr>
        <td>乙方:</td>
        <td colspan="2">{$aRow.Client.compName}</td>
        <td>&nbsp;</td>
        <td>签订时间:</td>
        <td>{$aRow.dateOrder}</td>
    </tr>
    <tr>
        <td colspan="6">经甲乙双方友好协商,就乙方向甲方订购下列货物达成如下协议:</td>
    </tr>
    <tr>
        <td colspan="6">第一条 货物品名 规格 数量 价款及交货时间: </td>
    </tr>
    <tr>
        <td colspan="6">
		
			<table id="sellPact" class="haveBorder" width="100%">
				<tr>
					<td>编号</td>
					<td>货物品名</td>
					<td>规格</td>
					<td>有效门幅</td>
					<td>克重</td>
					<td>数量</td>
					<td>单价</td>
					<td>金额(元)</td>
					<td>交货日期</td>
				</tr>
                {foreach from=$aRow.Products item=aPro}
				<tr>
					<td>{$aPro.Product.proCode}</td>
					<td>{$aPro.Product.proName}</td>
				  <td>{$aPro.Product.guige}</td>
					<td>{$aPro.Product.menfu}</td>
					<td>{$aPro.Product.kezhong}</td>
					<td>{$aPro.cntKg}</td>
					<td>{$aPro.danjia}</td>
					<td>{$aPro.cntKg*$aPro.danjia}</td>
					<td>{$aRow.dateJiaohuo}</td>
				</tr>
                {/foreach}
				<tr>
					<td>合&nbsp;&nbsp;&nbsp; 计：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				    <td colspan="2"><u>{$total_money}</u></td>
				    <td colspan="6">&nbsp;人民币(大写):<u>{$total_rmb}</u> </td>
			    </tr>
			</table>		</td>
    </tr>
    <tr>
        <td>第一条</td>
        <td>质量标准</td>
        <td colspan="4">按乙方确认样生产。</td>
    </tr>
    <tr>
        <td>第二条</td>
        <td>包装标准</td>
        <td colspan="4">塑料包装,短溢量为 3% </td>
    </tr>
    <tr>
        <td>第三条</td>
        <td>交付方式</td>
        <td colspan="4">由甲方送货到乙方所在地， 费用由甲方承担。</td>
    </tr>
    <tr>
        <td>第四条</td>
        <td>验收标准：</td>
        <td colspan="4">按乙方提供确认样验收，符合FZ/T72008-2006标准。</td>
    </tr>
    <tr>
        <td>第五条</td>
        <td>结算方式：</td>
        <td colspan="4">预付30%定金，余款提货时结清，定金到账后开始生产。</td>
    </tr>
    <tr>
        <td>第六条</td>
        <td>违约责任：</td>
        <td colspan="4">如果乙方对甲方的产品质量有异议， 请在15个工作日内提出。 </td>
    </tr>
    <tr>
        <td>第七条</td>
        <td>争议解决方式：</td>
        <td colspan="4">本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决。</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">（1）提交签约地仲裁委员会仲裁；（2）依法向人民法院起诉；</td>
    </tr>
    <tr>
        <td>第八条</td>
        <td colspan="5">本协议一式二份，签字盖章后生效。</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">甲方</td>
        <td>&nbsp;</td>
        <td>乙方</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">单位名称（章）：</td>
        <td>&nbsp;</td>
        <td>单位名称（章）：</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">法人、委托代理人</td>
        <td>&nbsp;</td>
        <td>法人、委托代理人：</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">电话：</td>
        <td>&nbsp;</td>
        <td>电话：</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">传真：</td>
        <td>&nbsp;</td>
        <td>传真：</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="6">&nbsp;</td>
    </tr>
</table>
</body>
</html>
