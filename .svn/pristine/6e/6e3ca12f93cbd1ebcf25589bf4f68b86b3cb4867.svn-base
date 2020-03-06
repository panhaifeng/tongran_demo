<?php
load_class('TMIS_TableDataGateway');
class Model_Gongyi_Dye_Chufang2Ware extends TMIS_TableDataGateway {
	var $tableName = 'gongyi_dye_chufang2ware';
	var $primaryKey = 'id';
		
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Gongyi_Dye_Chufang',
			'foreignKey' => 'chufangId',
			'mappingName' => 'Chufang'
		),
		array(
			'tableClass' => 'Model_JiChu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Ware'
		) 
	);	
}
?>