<?php
/**
 * 财务报表的基础类，从此类中衍生了应收报表。适应只需要显示金额的报表
 */ 
 FLEA::loadClass('TMIS_Model_MonthReport');
class Model_CaiWu_Yf_Report extends TMIS_Model_MonthReport {
	var $tableName = 'jichu_supplier';
	var $primaryKey = 'id';

	var $initTable = 'caiwu_yf_init';
	//var $rukuTable = 'view_cangku_ruku';
	var $rukuTable = 'view_yl_ruku';
	var $chukuTable = 'caiwu_payment';
	var $keyField = 'supplierId';
	var $rukuDateField = 'rukuDate';
	var $chukuDateField = 'datePay';
	var $rukuCntField = 'cnt*danJia';
	var $chukuCntField = 'moneyPay';
	var $initCntField = 'initMoney';	
	
	var $rukuDanjiaField = 1;	
	var $chukuDanjiaField = 1;	
	var $initMoneyField = 'initMoney';
	
	
	//本期发生
	function getMoneyRuku($keyValue,$dateFrom,$dateTo) {
		$str = "select sum({$this->rukuCntField}) cnt from {$this->rukuTable} where {$this->keyField} = '{$keyValue}' and {$this->rukuDateField} >= '{$dateFrom}' and {$this->rukuDateField} <= '{$dateTo}'";
		//echo $str;exit;
		$re=mysql_fetch_array(mysql_query($str));
		return $re[cnt];
	}

	function getMoneyChuku($keyValue,$dateFrom,$dateTo) {
		return $this->getCntChuku($keyValue,$dateFrom,$dateTo);
	}

	/**/
	//得到目前为止未开票和对账单的入库金额,应付款中私有。
	function getMoneyNoInvoice($keyValue,$dateFrom='',$dateTo='') {		
		$str = "select sum({$this->rukuCntField}) cnt from {$this->rukuTable} where {$this->keyField} = '$keyValue' and invoiceId=0";
		if ($dateFrom !='') $str .= " and {$this->rukuDateField}>='$dateFrom'";
		if ($dateTo !='') $str .= " and {$this->rukuDateField}<='$dateTo'";
		$re=mysql_fetch_array(mysql_query($str));
		return $re[cnt];
	}

	function getCntKucun($keyValue) {
		return $this->getCntInit($keyValue) + $this->getCntRuku($keyValue) - $this->getCntChuku($keyValue);
	}
	
	#得到其他应付往来的金额
	function getOtherMoney($keyValue,$dateFrom='',$dateTo=''){
		$str = "select sum(money) money from caiwu_yf_other where supplierId = '$keyValue'";
		if ($dateFrom !='') $str .= " and dateRecord>='$dateFrom'";
		if ($dateTo !='') $str .= " and dateRecord<='$dateTo'";
		$re=mysql_fetch_array(mysql_query($str));
		return $re['money'];
	}
	
	#得到截止某天的应付余额
	function getMoneyInit($keyValue,$dateFrom) {
		//得到其他应付往来的数据
		$str = "select sum(money) as money from caiwu_yf_other where supplierId='{$keyValue}' and dateRecord<'{$dateFrom}'";
		$re = mysql_fetch_assoc(mysql_query($str));
		// 得到 坯纱采购的入账数据
		$str2 = "select sum(money) as money from caiwu_yf_pisha where supplierId='{$keyValue}' and dateRecord<'{$dateFrom}'";
		$re2 = mysql_fetch_assoc(mysql_query($str2));

		return parent::getMoneyInit($keyValue,$dateFrom) + $re['money'] + $re2['money'];
		
	}
	/**
	 * ps ：本期应付金额（入库产生的金额） = 染化料采购进入+坯纱采购金额
	 * Time：2017/09/05 13:07:59
	 * @author zcc
	*/
	function getMoneyRukuNew($keyValue,$dateFrom,$dateTo) {
		//染化料采购入库金额
		$str = "SELECT sum(cnt*danJia) as money 
			from view_yl_ruku 
			where supplierId = '{$keyValue}' and rukuDate >= '{$dateFrom}' and rukuDate <= '{$dateTo}'";
		//echo $str;exit;
		$re=mysql_fetch_array(mysql_query($str));
		//坯纱采购入账金额
		$str2 = "SELECT sum(money) as money 
			from caiwu_yf_pisha 
			where supplierId='{$keyValue}' and dateRecord>='{$dateFrom}' and dateRecord<='{$dateTo}'";
		$re2 = mysql_fetch_assoc(mysql_query($str2));
		return $re['money']+$re2['money'];
	}
}
?>