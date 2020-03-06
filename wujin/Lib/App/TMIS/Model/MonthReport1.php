<?php
/**
***********说明文档*********************
*与MonthReport相比，该报表允许设置多个数量(金额)字段，用逗号分割开，
*适用范围：成品中有一等，次等，零布的区别，需要返回多个数量(金额)字段。
**/
FLEA::loadClass('FLEA_Db_TableDataGateway');
class TMIS_Model_MonthReport1 extends FLEA_Db_TableDataGateway {
	//关键字段的配置表
	var $tableName = 'jichu_product';
	var $primaryKey = 'id';
	var $keyField = 'productId';
	
	var $initTable = 'chengpin_denim_init';
	var $initCntField = 'cntKg,cntKgC,cntKgF';
	
	var $rukuTable = 'view_chengpin_denim_cprk';
	var $rukuDateField = 'dateCprk';
	var $rukuCntField = 'cntKg,cntKgC,cntKgF';
	
	var $chukuTable = 'view_chengpin_denim_cpck';
	var $chukuDateField = 'dateCpck';
	var $chukuCntField = 'cntKg,cntKgC,cntKgF';	
	
	//某些时候可能会以几个字段集中显示库存信息，比如库存中的一等品，次品等。field以","分割
	//返回 sum(key1) as key1,sum(key2) as key2
	function _explode($fields){
		$ret = "";
		$arr = explode(",",$fields);
		if(count($arr)>0) foreach($arr as $v) {
			$ret .= "sum($v) as $v,";
		}
		return substr($ret,0,-1);
	}
	
	//得到当月的初始信息，包括入库总数和金额
	function getInitInfo($keyValue,$dateFrom) {
		$str = "select ". $this->_explode($this->initCntField) . " from {$this->initTable} where {$this->keyField} = '$keyValue'";
		//echo $str;exit;
		$re=mysql_fetch_array(mysql_query($str));

		$str = "select ". $this->_explode($this->rukuCntField) . " from {$this->rukuTable} where {$this->keyField} = '$keyValue' and {$this->rukuDateField} < '$dateFrom'";
		$re1=mysql_fetch_array(mysql_query($str));

		$str = "select " . $this->_explode($this->chukuCntField) . " from {$this->chukuTable} where {$this->keyField} = '$keyValue' and {$this->chukuDateField} < '$dateFrom'";
		$re2=mysql_fetch_array(mysql_query($str));
		
		$ret = array();
		$arr = explode(",",$this->initCntField);
		foreach($arr as $key) {
			$ret[$key] = $re[$key]+$re1[$key]-$re2[$key];
		}		
		return $ret;
	}
	
	//得到当月的入库信息，包括入库总数和金额
	function getRukuInfo($keyValue,$dateFrom,$dateTo) {
		$str = "select ". $this->_explode($this->rukuCntField) . " from {$this->rukuTable} where {$this->keyField} = '$keyValue' and {$this->rukuDateField} >= '$dateFrom' and {$this->rukuDateField} <= '$dateTo'";
		$re=mysql_fetch_array(mysql_query($str));
		$ret = array();
		$arr = explode(",",$this->initCntField);
		foreach($arr as $key) {
			$ret[$key] = $re[$key];
		}		
		return $ret;
	}
	
	//得到当月的出库信息，包括入库总数和金额
	function getChukuInfo($keyValue,$dateFrom,$dateTo) {
		$str = "select " . $this->_explode($this->chukuCntField) . " from {$this->chukuTable} where {$this->keyField} = '$keyValue' and {$this->chukuDateField} >= '$dateFrom' and {$this->chukuDateField} <= '$dateTo'";
		$re=mysql_fetch_array(mysql_query($str));
		$ret = array();
		$arr = explode(",",$this->initCntField);
		foreach($arr as $key) {
			$ret[$key] = $re[$key];
		}		
		return $ret;
	}
		
}
?>