<?php
load_class('TMIS_TableDataGateway');
class Model_JiChu_Employ extends TMIS_TableDataGateway {
	var $tableName = 'jichu_employ';
	var $primaryKey = 'id';
	var $primaryName = 'employName';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Department',
			'foreignKey' => 'depId',
			'mappingName' => 'departments'
		)
	);
}
?>