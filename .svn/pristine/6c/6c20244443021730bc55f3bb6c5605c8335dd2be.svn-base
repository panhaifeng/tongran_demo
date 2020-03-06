<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Employ extends TMIS_TableDataGateway {
	var $tableName = 'jichu_employ';
	var $primaryKey = 'id';
	var $primaryName = 'employName';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Department',
			'foreignKey' => 'depId',
			'mappingName' => 'departments'
		)
	);
}
?>