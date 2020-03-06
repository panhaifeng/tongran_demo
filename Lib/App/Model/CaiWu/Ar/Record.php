<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_Ar_Record extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_ar_record';
	var $primaryKey = 'id';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'clientId',
			'mappingName' => 'Client'
		),
		array(
			'tableClass' => 'Model_CaiWu_ArType',
			'foreignKey' => 'arTypeId',
			'mappingName' => 'ArType'

		)
	);	
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