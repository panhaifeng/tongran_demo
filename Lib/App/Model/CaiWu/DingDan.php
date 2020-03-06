<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_DingDan extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_dingdan';
	var $primaryKey = 'id';
	var $primaryName = 'dingDanNum';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'clientId',
			'mappingName' => 'Client'
		),
		array(
			'tableClass' => 'Model_Acm_User',
			'foreignKey' => 'userId',
			'mappingName' => 'User'
		),
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'employId',
			'mappingName' => 'Employ'
		)
	);	
	var $hasMany = array(	
		array(
			'tableClass' => 'Model_CaiWu_DingDan2Product',
			'foreignKey' => 'baseTableId',
			'mappingName' => 'DingDan2Product'
		)
		
		
	);
}
?>