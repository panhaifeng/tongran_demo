<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_DingDan2Product extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_dingdan2product';
	var $primaryKey = 'id';
	var $primaryName = 'baseTableId';	
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Product',
			'foreignKey' => 'productId',
			'mappingName' => 'Product'
		)
	);
}
?>