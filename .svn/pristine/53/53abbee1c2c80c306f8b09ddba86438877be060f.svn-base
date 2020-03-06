<?php
load_class('TMIS_TableDataGateway');
class Model_Chengpin_Denim_Cpck extends TMIS_TableDataGateway {
	var $tableName = 'chengpin_denim_cpck';
	var $primaryKey = 'id';
		
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Chengpin_Denim_Cpck2OrdPro',
			'foreignKey' => 'cpckId',
			'mappingName' => 'Cpck'
		)		
	);
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Trade_Denim_Order',
			'foreignKey' => 'orderId',
			'mappingName' => 'Order'
		)
	);
}
?>