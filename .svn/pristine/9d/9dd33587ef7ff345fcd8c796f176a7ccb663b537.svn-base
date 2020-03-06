<?php
load_class('TMIS_TableDataGateway');
class Model_Trade_Denim_Order extends TMIS_TableDataGateway {
	var $tableName = 'trade_denim_order';
	var $primaryKey = 'id';
	//var $primaryName = 'ruKuNum';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'clientId',
			'mappingName' => 'Client'
		),
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader'
		)
	);	
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Trade_Denim_Order2Product',
			'foreignKey' => 'orderId',
			'mappingName' => 'Products'
		)		
	);
}
?>