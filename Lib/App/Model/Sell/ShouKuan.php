<?php
load_class('TMIS_TableDataGateway');
class Model_Sell_ShouKuan extends TMIS_TableDataGateway {
	var $tableName = 'sell_shoukuan';
	var $primaryKey = 'id';
	var $primaryName = 'chuKuId';
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
		)
	);
}
?>