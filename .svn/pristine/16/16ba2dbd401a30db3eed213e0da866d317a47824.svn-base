<?php
load_class('TMIS_TableDataGateway');
class Model_Cangku_Kucun extends TMIS_TableDataGateway {
	var $tableName = 'cangku_kucun';
	var $primaryKey = 'id';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Jichu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Ware'
		)
	);

}
?>