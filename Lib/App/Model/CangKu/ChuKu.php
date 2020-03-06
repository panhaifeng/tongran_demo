<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_ChuKu extends TMIS_TableDataGateway {
	var $tableName = 'cangku_chuku';
	var $primaryKey = 'id';
	var $primaryName = 'chukuNum';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Department',
			'foreignKey' => 'depId',
			'mappingName' => 'Department'
		)
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_CangKu_ChuKu2Ware',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Wares'
		)
	);

}
?>