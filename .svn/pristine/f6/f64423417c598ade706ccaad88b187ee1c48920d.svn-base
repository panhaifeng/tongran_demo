<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_InitMaterial extends TMIS_TableDataGateway {
	var $tableName = 'cangku_init_material';
	var $primaryKey = 'id';
	var $primaryName = 'initDate';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Material',
			'foreignKey' => 'materialId',
			'mappingName' => 'Material'
		)
	);	
	
}
?>