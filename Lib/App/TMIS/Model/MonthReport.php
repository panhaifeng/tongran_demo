<?php
/**
***********说明文档*********************
*仓库管理中都涉及到一个月报表功能，考虑到很多通用的功能，所以产生了TMIS_MonthReport
*条件：必须具备3个表
*	初始化表：仓库初始化时的数量金额
*	入库表:需包括数量，单价信息
*	出库表:需包括数量,单价信息
*根据以上三个表得到期初信息，入库信息，出库信息，从而演算出库存信息
*适用范围：仓库月报表，财务应付月报表，财务应收月报表等等。
*个别仓库可能不需要金额信息。可将单价设置为1
*某些仓库需要2个以上的关键字段，比如对外加工的原料库存信息,就包含了wareId和加工客户id两个关键字段。需要用到TMIS_Model_MonthReport2
**/
FLEA::loadClass('FLEA_Db_TableDataGateway');
class TMIS_Model_MonthReport extends FLEA_Db_TableDataGateway {
	//关键字段的配置表
	var $tableName = 'jichu_client';
	var $primaryKey = 'id';

	var $initTable = '';
	var $rukuTable = '';
	//var $rukuTable = 'caiwu_ar_record';
	var $chukuTable = 'caiwu_income';
	var $keyField = 'clientId';
	var $rukuDateField = 'dateCpck';
	//var $rukuDateField = 'dateRecord';
	var $chukuDateField = 'dateIncome';
	var $rukuCntField = 'cnt*danJia';
	//var $rukuCntField = 'cnt*danjia';
	var $chukuCntField = 'moneyIncome';
	var $initCntField = 'initMoney';
	var $rukuDanjiaField = 1;
	var $chukuDanjiaField = 1;

	var $initDate = '2009-01-01'; //初始化日期

	//得到需要显示的keyField集合,如果期初，入库，出库都为0，不需要显示
	//目前没考虑initTable
	function getKucunSql($dateFrom,$dateTo,$condition='') {
		//取得有期初的
		$sql1="select {$this->keyField},sum({$this->rukuCntField}) as cntRuku from {$this->rukuTable} where {$this->rukuDateField}<'{$dateFrom}' group by {$this->keyField}";
		$sql2="select {$this->keyField},sum({$this->chukuCntField}) as cntChuku from {$this->chukuTable} where {$this->chukuDateField}<'{$dateFrom}' group by {$this->keyField}";

		$sql3="select {$this->keyField} from {$this->rukuTable} where {$this->rukuDateField}>='{$dateFrom}' and {$this->rukuDateField}<='{$dateTo}' group by {$this->keyField}";
		$sql4 = "select {$this->keyField} from {$this->chukuTable} where {$this->chukuDateField}>='{$dateFrom}' and {$this->chukuDateField}<='{$dateTo}' group by {$this->keyField}";

		$sql = "select x.{$this->keyField}
			from ($sql1) x
			left join ($sql2) y on x.{$this->keyField}=y.{$this->keyField}
			where x.cntRuku<>ifnull(y.cntChuku,0)
			union {$sql3}
			union {$sql4}";
		//echo $sql;exit;
		return $sql;
	}

	//得到当月的初始信息，包括入库总数和金额
	function getInitInfo($keyValue,$dateFrom) {
		if($this->initTable) {
			$str = "select sum({$this->initCntField}) as cnt,sum({$this->initMoneyField}) as money from {$this->initTable} where {$this->keyField} = '$keyValue'";
			 // echo $str;exit;
			$re=mysql_fetch_assoc(mysql_query($str));
		}
		////////////////////////////////////
		$str1 = "select sum({$this->rukuCntField}) cnt,sum({$this->rukuCntField}*{$this->rukuDanjiaField}) money from {$this->rukuTable} where {$this->keyField} = '$keyValue' and {$this->rukuDateField} < '{$dateFrom}' and {$this->rukuDateField} > '{$this->initDate}'";
		// dump(1);exit;
		$re1=mysql_fetch_array(mysql_query($str1));

		$str2 = "select sum({$this->chukuCntField}) cnt,sum({$this->chukuCntField}*{$this->chukuDanjiaField}) money from {$this->chukuTable} where {$this->keyField} = '$keyValue' and {$this->chukuDateField} < '{$dateFrom}' and {$this->chukuDateField} > '{$this->initDate}'";
		$re2=mysql_fetch_array(mysql_query($str2));
		//echo $str ."<br>".$str1."<br>".$str2;
		$arr = array();
		$arr[cnt] = $re[cnt] + $re1[cnt] - $re2[cnt];
		$arr[money] = $re[money] + $re1[money] - $re2[money];

		return $arr;
	}

	//得到当月的入库信息，包括入库总数和金额
	function getRukuInfo($keyValue,$dateFrom,$dateTo) {
		////////////////////////////////
		$str = "select sum({$this->rukuCntField}) cnt , sum({$this->rukuCntField}*{$this->rukuDanjiaField}) money from {$this->rukuTable} where {$this->keyField} = '$keyValue' and {$this->rukuDateField} >= '$dateFrom' and {$this->rukuDateField} <= '$dateTo'";
		$re=mysql_fetch_array(mysql_query($str));
		return $re;
	}

	//得到当月的出库信息，包括入库总数和金额
	function getChukuInfo($keyValue,$dateFrom,$dateTo) {
		$str = "select sum({$this->chukuCntField}) cnt,sum({$this->chukuCntField}*{$this->chukuDanjiaField}) money from {$this->chukuTable} where {$this->keyField} = '$keyValue' and {$this->chukuDateField} >= '$dateFrom' and {$this->chukuDateField} <= '$dateTo'";
		$re=mysql_fetch_array(mysql_query($str));
		return $re;
	}

	//得到入库金额,财务报表中常用
	function getMoneyRuku($keyValue,$dateFrom,$dateTo) {
		$temp=$this->getRukuInfo($keyValue,$dateFrom,$dateTo);
		return $temp[money];
	}
	//得到出库金额,财务报表中常用
	function getMoneyChuku($keyValue,$dateFrom,$dateTo) {
		$temp=$this->getChukuInfo($keyValue,$dateFrom,$dateTo);
		return $temp[money];
	}
	//至$dateFrom为止余额。一般作为期初值。
	function getMoneyInit($keyValue,$dateFrom) {
		$temp=$this->getInitInfo($keyValue,$dateFrom);
		return $temp[money];
	}

	//得到入库数量
	function getCntRuku($keyValue,$dateFrom,$dateTo) {
		$temp=$this->getRukuInfo($keyValue,$dateFrom,$dateTo);
		return $temp[cnt];
	}
	//得到出库数量
	function getCntChuku($keyValue,$dateFrom,$dateTo) {
		$temp=$this->getChukuInfo($keyValue,$dateFrom,$dateTo);
		return $temp[cnt];
	}
	//至$dateFrom为止数量
	function getCntInit($keyValue,$dateFrom) {
		$temp=$this->getInitInfo($keyValue,$dateFrom);
		return $temp[cnt];
	}
}
?>