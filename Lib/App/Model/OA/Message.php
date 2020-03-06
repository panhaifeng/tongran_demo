<?php
load_class('TMIS_TableDataGateway');
class Model_OA_Message extends TMIS_TableDataGateway {
	var $tableName = 'oa_message';
	var $primaryKey = 'id';
	var $primaryName = 'classId';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Acm_User',
			'foreignKey' => 'userId',
			'mappingName' => 'User'
		),		
		array(
			'tableClass' => 'Model_OA_MessageClass',
			'foreignKey' => 'classId',
			'mappingName' => 'MessageClass'
		)
	);
}
?>