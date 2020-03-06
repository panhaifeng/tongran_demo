<?php
load_class('TMIS_TableDataGateway');
class Model_Plan_Dye_Gangmerge extends TMIS_TableDataGateway {
	var $tableName = 'plan_dye_gang_merge';
	var $primaryKey = 'id';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Vat',
			'foreignKey' => 'vatId',
			'mappingName' => 'Vat'

		)
	);
}
?>