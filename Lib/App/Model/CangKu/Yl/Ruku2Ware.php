<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_Yl_Ruku2Ware extends TMIS_TableDataGateway {
	var $tableName = 'cangku_yl_ruku2ware';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Wares'
		),
		array(
			'tableClass' => 'Model_CangKu_Yl_Ruku',
			'foreignKey' => 'rukuId',
			'mappingName' => 'Ruku'
		)
	);
}
?>