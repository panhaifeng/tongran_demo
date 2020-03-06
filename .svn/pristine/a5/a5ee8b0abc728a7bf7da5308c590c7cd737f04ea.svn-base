<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_InitProduct extends TMIS_TableDataGateway {
	var $tableName = 'cangku_init_product';
	var $primaryKey = 'id';
	var $primaryName = 'initDate';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Product',
			'foreignKey' => 'productId',
			'mappingName' => 'Product'
		)
	);	
	
}
?>