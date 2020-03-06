<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_DyePandian extends TMIS_TableDataGateway {
	var $tableName = 'cangku_dye_pandian';
	var $primaryKey = 'id';
	var $belongsTo = array(array(
		'tableClass' => 'Model_JiChu_Ware',
		'foreignKey' => 'wareId',
		'mappingName' => 'Ware'
	));	
	//var $primaryName = 'compName';
	/*var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'userId',
			'mappingName' => 'User'
		)
	);*/
}
?>