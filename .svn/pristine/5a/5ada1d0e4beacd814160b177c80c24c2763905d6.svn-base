<?php
load_class('TMIS_TableDataGateway');
class Model_Chengpin_Dye_Cpck extends TMIS_TableDataGateway {
	var $tableName = 'chengpin_dye_cpck';
	var $primaryKey = 'id';
		
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Plan_Dye_Gang',
			'foreignKey' => 'planId',
			'mappingName' => 'Plan'
		)
	);
}
?>