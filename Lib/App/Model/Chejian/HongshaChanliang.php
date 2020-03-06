<?php
load_class('TMIS_TableDataGateway');
class Model_Chejian_HongshaChanliang extends TMIS_TableDataGateway {
	var $tableName = 'dye_hs_chanliang';
	var $primaryKey = 'id';
	//var $primaryName = 'employName';
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
}
?>