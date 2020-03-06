<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_Init extends TMIS_TableDataGateway {
	var $tableName = 'cangku_init';
	var $primaryKey = 'id';
	var $belongsTo = array(array(
		'tableClass' => 'Model_JiChu_Ware',
		'foreignKey' => 'wareId',
		'mappingName' => 'Ware'
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