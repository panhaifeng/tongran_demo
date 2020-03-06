<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_RuKu2Ware extends TMIS_TableDataGateway {
	var $tableName = 'cangku_ruku2ware';
	var $primaryKey = 'id';
	//var $primaryName = 'ruKuId';	
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Wares'
		),
		array(
			'tableClass' => 'Model_CangKu_RuKu',
			'foreignKey' => 'ruKuId',
			'mappingName' => 'Ruku'
		)
	);
}
?>