<?php
load_class('TMIS_TableDataGateway');
class Model_Chejian_DabaoChanliang extends TMIS_TableDataGateway {
	var $tableName = 'dye_db_chanliang';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Plan_Dye_Gang',
			'foreignKey' => 'gangId',
			'mappingName' => 'Vat'
		),
        array(
			'tableClass' => 'Model_Plan_Dye_ViewGang',
			'foreignKey' => 'gangId',
			'mappingName' => 'VatView',
			'enabled'=>false
		)
	);
	var $hasMany = array (
		array(
			'tableClass' => 'Model_Chejian_DabaoChanliangMx',
			'foreignKey' => 'chanliangId',
			'mappingName' => 'Mingxi',
			'sort'=>'xianghao'
		)
	);
}
?>