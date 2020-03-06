<?php
load_class('TMIS_TableDataGateway');
class Model_Chengpin_Denim_Cprk extends TMIS_TableDataGateway {
	var $tableName = 'chengpin_denim_cprk';
	var $primaryKey = 'id';
		
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Chengpin_Denim_Cprk2OrdPro',
			'foreignKey' => 'cprkId',
			'mappingName' => 'Cprk'
		)		
	);
}
?>