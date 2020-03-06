<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_EmployKind extends TMIS_TableDataGateway {
	var $tableName = 'jichu_employ_kind';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Employ',
			'foreignKey' => 'employId',
			'mappingName' => 'employs'
		)
	);
}
?>
