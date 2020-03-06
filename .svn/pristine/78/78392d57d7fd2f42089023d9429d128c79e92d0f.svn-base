<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Dye_Chanliang extends TMIS_TableDataGateway {
	var $tableName = 'dye_chanliang';
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


}
?>