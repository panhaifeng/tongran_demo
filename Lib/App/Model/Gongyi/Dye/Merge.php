<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Gongyi_Dye_Merge extends TMIS_TableDataGateway {
	var $tableName = 'gongyi_dye_merge';
	var $primaryKey = 'id';
	//var $primaryName = '';

	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Jichu_Vat',
			'foreignKey' => 'vatId',
			'mappingName' => 'Vat'
		)
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Plan_Dye_Gang',
			'foreignKey' => 'mergeId',
			'mappingName' => 'Gang',
			'linkRemove'=>false,
			'linkRemoveFillValue'=>0
		)
	);
	/*var $manyToMany = array(
		array (
			'tableClass' => 'Model_' ,
			'mappingName' => '',
			'joinTable' => '',
			'foreignKey' => '',
			'assocForeignKey' => ''
		)
	);*/
}
?>