<?php
/**
*松筒车档案
*/
load_class('TMIS_TableDataGateway');
class Model_JiChu_StCar extends TMIS_TableDataGateway {
	var $tableName = 'jichu_stcar';
	var $primaryKey = 'id';
	var $primaryName = 'carCode';

	/*var $manyToMany = array(		
		array (
			'tableClass' => 'Model_Plan_Dye_Gang' ,			
			'mappingName' => 'Gang',
			'joinTable' => 'dye_gang2stcar',
			'foreignKey' => 'stcarId',
			'assocForeignKey' => 'gangId',
			'enabled' =>false
		)
	);
	*/
}
?>