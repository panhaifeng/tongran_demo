<?php
load_class('TMIS_TableDataGateway');
class Model_OA_SM extends TMIS_TableDataGateway {
	var $tableName = 'oa_sm';
	var $primaryKey = 'id';
	var $primaryName = 'title';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Acm_User',
			'foreignKey' => 'sendUserId',
			'mappingName' => 'UserSend'
		),
		array(
			'tableClass' => 'Model_Acm_User',
			'foreignKey' => 'reUserId',
			'mappingName' => 'UserRe'
		)
	);
}
?>