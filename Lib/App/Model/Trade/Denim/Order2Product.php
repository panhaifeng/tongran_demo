<?php
load_class('TMIS_TableDataGateway');
class Model_Trade_Denim_Order2Product extends TMIS_TableDataGateway {
	var $tableName = 'trade_denim_order2product';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Trade_Denim_Order',
			'foreignKey' => 'orderId',
			'mappingName' => 'Order'
		),
		array(
			'tableClass' => 'Model_JiChu_Product',
			'foreignKey' => 'productId',
			'mappingName' => 'Product'
		)
	);
	var $hasMany = array(
		//成品出库
		array(
			'tableClass' => 'Model_Chengpin_Denim_Cpck2OrdPro',
			'foreignKey' => 'order2ProductId',
			'mappingName' => 'Cpck',
			'enabled' => false
		),
		//成品入库关联
		array(
			'tableClass' => 'Model_Chengpin_Denim_Cprk2OrdPro',
			'foreignKey' => 'order2ProductId',
			'mappingName' => 'Cprk',
			'enabled' => false
		)		
	);
}
?>