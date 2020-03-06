<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_ExpenseItem extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_expenseitem';
	var $primaryKey = 'id';
	var $primaryName = 'itemName';
	/*var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader'
		)
	);*/
}
?>