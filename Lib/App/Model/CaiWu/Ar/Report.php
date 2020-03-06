<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Model_MonthReport');
class Model_CaiWu_Ar_Report extends TMIS_Model_MonthReport {
	var $tableName = 'jichu_client';
	var $primaryKey = 'id';
	var $keyField = 'clientId';

	var $rukuTable = 'view_dye_cpck_ar';
	//var $rukuCntField = 'cntPlanTouliao';
	//海鲨需要分批出库，这里改为每次出库数,且view_dye_cpck_ar重新搭建
	var $rukuCntField = 'cntChuku';

	var $rukuDanjiaField = 'danjia';
	var $rukuDateField = 'dateCpck';

	var $chukuTable = 'caiwu_income';
	var $chukuDateField = 'dateIncome';
	var $chukuCntField = 'moneyIncome';
	var $chukuDanjiaField = 1;

	var $initTable = 'caiwu_ar_init';
	var $initCntField = 'initMoney';
	var $initMoneyField ='initMoney';

	var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader'
		)
	);

	//得到出库金额，因为需要加入条件type<9(去掉调整金额)
	function getMoneyChuku($keyValue,$dateFrom,$dateTo) {
		$str = "select sum(moneyIncome) money from {$this->chukuTable} where {$this->keyField} = '$keyValue' and {$this->chukuDateField} >= '$dateFrom' and {$this->chukuDateField} <= '$dateTo' and type<9";
		$re=mysql_fetch_array(mysql_query($str));
		return $re[money];
	}

	//得到某段日期内的调整金额
	function getAdjustMoney($clientId,$dateFrom,$dateTo) {
		$model = FLEA::getSingleton('Model_CaiWu_Ar_Income');
		$r = $model->find(array(
			type=>9,
			clientId => $clientId,
			array('dateIncome',$dateFrom,'>='),
			array('dateIncome',$dateTo,'<=')
		));
		return $r[moneyIncome];
	}

	//得到其他应收项目的金额
	function getOtherMoney($clientId,$dateFrom,$dateTo) {
		$str = "select sum(money) as money from caiwu_ar_other where clientId = '$clientId' and recordDate >= '$dateFrom' and recordDate <= '$dateTo'";
		$re=mysql_fetch_array(mysql_query($str));
		return $re[money];
	}

	//重载 金额 = 单价*投料+金额
	function getInitInfo($keyValue,$dateFrom) {
		$str = "select sum({$this->initCntField}) as cnt,sum({$this->initMoneyField}) as money from {$this->initTable} where {$this->keyField} = '$keyValue'";
		$re=mysql_fetch_assoc(mysql_query($str));
		// dump($str);

		////////////////////////////////////
		//$str = "select sum({$this->rukuCntField}) cnt,sum({$this->rukuCntField}*{$this->rukuDanjiaField}+money) money from {$this->rukuTable} where {$this->keyField} = '$keyValue' and {$this->rukuDateField} < '{$dateFrom}' and {$this->rukuDateField} > '{$this->initDate}'";
		//修改为按照投料数来计算
		$str1 = "select
			sum(x.cntPlanTouliao) cnt,
			sum(x.cntPlanTouliao*y.danjia+y.money) money
			from plan_dye_gang x
			join trade_dye_order2ware y on x.order2wareId=y.id
			join trade_dye_order z on y.orderId=z.id
			where x.parentGangId=0 and z.clientId = '$keyValue'
			and x.dateDuizhang < '{$dateFrom}' and x.dateDuizhang > '{$this->initDate}'";
		//echo $str1;exit;
		$re1=mysql_fetch_assoc(mysql_query($str1));
		// dump($str1);

		$str2 = "select sum({$this->chukuCntField}) cnt,sum({$this->chukuCntField}*{$this->chukuDanjiaField}) money from {$this->chukuTable} where {$this->keyField} = '$keyValue' and {$this->chukuDateField} < '{$dateFrom}' and {$this->chukuDateField} > '{$this->initDate}'";
		$re2=mysql_fetch_assoc(mysql_query($str2));
		// dump($str2);

		$str3 = "select sum(money) as money from caiwu_ar_other where clientId = '$keyValue' and recordDate < '$dateFrom'";
		// dump($str3);
		$re3 = mysql_fetch_assoc(mysql_query($str3));
		$arr = array();
		$arr[cnt] = $re[cnt] + $re1[cnt] - $re2[cnt];
		$arr[money] = $re['money'] + $re1['money'] - $re2['money'] + $re3['money'];
		// dump($re);dump($re1);dump($re2);dump($re3);dump($arr);exit;
		return $arr;
	}

	//重载 金额 = 单价*投料+金额
	//不计算回修的缸，parentGangId>0
	function getRukuInfo($keyValue,$dateFrom,$dateTo) {
		////////////////////////////////
		$str = "select sum({$this->rukuCntField}) cnt , sum({$this->rukuCntField}*{$this->rukuDanjiaField}+money) money from {$this->rukuTable} where {$this->keyField} = '$keyValue' and {$this->rukuDateField} >= '$dateFrom' and {$this->rukuDateField} <= '$dateTo' and parentGangId=0";
		$str = "select
			sum(x.cntPlanTouliao) cnt,
			sum(x.cntPlanTouliao*y.danjia+y.money) money
			from plan_dye_gang x
			join trade_dye_order2ware y on x.order2wareId=y.id
			join trade_dye_order z on y.orderId=z.id
			where x.parentGangId=0 and z.clientId = '$keyValue'
			and x.dateDuizhang >= '{$dateFrom}' and x.dateDuizhang<='{$dateTo}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		//如果有未出库整缸回修数据 取得这个回修数据最后一个回修缸号的数据 加到本月出库上
		$sql = "SELECT
			x.cntPlanTouliao as cnt,
			(x.cntPlanTouliao*y.danjia+y.money)as money
			from plan_dye_gang x
			join trade_dye_order2ware y on x.order2wareId=y.id
			join trade_dye_order z on y.orderId=z.id
			where x.parentGangId>0 
			AND x.isHuixiuCk = 1
			AND z.clientId = '$keyValue'
			AND x.dateDuizhang >= '{$dateFrom}' and x.dateDuizhang<='{$dateTo}'
			ORDER by x.id DESC LIMIT 0,1";	
		$re2=mysql_fetch_assoc(mysql_query($sql));

		$reNew = array(
			'cnt' => $re['cnt']+$re2['cnt'],
			'money' => $re['money']+$re2['money']
		);
		return $reNew;
	}
}
?>