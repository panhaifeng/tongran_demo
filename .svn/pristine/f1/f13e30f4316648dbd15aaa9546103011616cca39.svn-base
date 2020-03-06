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
**/
FLEA::loadClass('TMIS_Model_MonthReport1');
class Model_Chengpin_Denim_Report extends TMIS_Model_MonthReport1 {
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
	
	/*
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader'
		)
	);
	*/
	//得到某个生产编号下的库存量
	function getKucunOfManuCode($manuCode){
		$_model = FLEA::getSingleton('Model_Trade_Denim_Order2Product');
		$temp = $_model->find("manuCode='$manuCode'");
		return $this->getKucunOfOrdpro($temp[id]);		
	}
	
	//得到某个ordproId下的库存量
	function getKucunOfOrdpro($order2ProductId){
		$str = "select 
			sum(cntKg) cntKg,
			sum(cntKgC) cntKgC,
			sum(cntKgF) cntKgF
			from view_chengpin_denim_cprk where order2ProductId='$order2ProductId'";
		$re = mysql_fetch_assoc(mysql_query($str));
		
		$str = "select 
			sum(cntKg) cntKg,
			sum(cntKgC) cntKgC,
			sum(cntKgF) cntKgF
			from view_chengpin_denim_cpck where order2ProductId1='$order2ProductId'";
			//echo $str;
		$re1 = mysql_fetch_assoc(mysql_query($str));
		//dump($re);exit;
		return array(
			'cntKg' => ($re[cntKg] - $re1[cntKg]),
			'cntKgC' => ($re[cntKgC] - $re1[cntKgC]),
			'cntKgF' => ($re[cntKgF] - $re1[cntKgF])
		);
		//$str = "";
	}
}
?>