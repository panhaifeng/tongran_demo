<?php
load_class('TMIS_TableDataGateway');
class Model_SongTong_Chanliang extends TMIS_TableDataGateway {
	var $tableName = 'dye_st_chanliang';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_SongTong_Gang2StCar',
			'foreignKey' => 'gang2stcarId',
			'mappingName' => 'Plan'
		)
	);	
}
?>