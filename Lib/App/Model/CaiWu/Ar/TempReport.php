<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Model_MonthReport');
class Model_CaiWu_Ar_TempReport extends TMIS_Model_MonthReport {
	var $tableName = 'jichu_client';
	var $primaryKey = 'id';

	var $initTable = 'caiwu_ar_init';
	//var $rukuTable = 'view_chengpin_denim_cpck_for_ar';
	var $rukuTable = 'caiwu_ar_record';
	var $chukuTable = 'caiwu_income';
	var $keyField = 'clientId';
	//var $rukuDateField = 'dateCpck';
	var $rukuDateField = 'dateRecord';
	var $chukuDateField = 'dateIncome';
	//var $rukuCntField = 'cnt*danJia';
	var $rukuCntField = 'cnt';
	var $chukuCntField = 'moneyIncome';
	var $initCntField = 'initMoney';
	var $initMoneyField ='initMoney';
	
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader'
		)
	);
}
?>