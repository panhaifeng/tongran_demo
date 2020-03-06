<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_Yf_Other extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_yf_other';
	var $primaryKey = 'id';
	var $belongsTo = array(array(
		'tableClass' => 'Model_JiChu_Supplier',
		'foreignKey' => 'supplierId',
		'mappingName' => 'Supplier'
	));	
	//var $primaryName = 'compName';
	/*var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'userId',
			'mappingName' => 'User'
		)
	);*/
}
?>