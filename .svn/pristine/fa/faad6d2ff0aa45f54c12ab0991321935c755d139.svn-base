<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_Yf_Pisha extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_yf_pisha';
	var $primaryKey = 'id';
	var $belongsTo = array(array(
		'tableClass' => 'Model_JiChu_Supplier',
		'foreignKey' => 'supplierId',
		'mappingName' => 'Supplier'
	));
	var $hasMany = array(
		array(
			'tableClass' => 'Model_CangKu_Ruku2Ware',
			'foreignKey' => 'invoiceId',
			'mappingName' => 'Ruku2ware',
			'linkRemove'=>false,
			'linkRemoveFillValue'=>0
		),

	);

}
?>