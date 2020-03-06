<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_Ar_Init extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_ar_init';
	var $primaryKey = 'id';
	var $belongsTo = array(array(
		'tableClass' => 'Model_JiChu_Client',
		'foreignKey' => 'clientId',
		'mappingName' => 'Client'
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