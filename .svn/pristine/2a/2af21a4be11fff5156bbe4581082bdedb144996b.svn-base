<?php
//染缸的水溶量档案
load_class('TMIS_TableDataGateway');
class Model_JiChu_Vat2shuirong extends TMIS_TableDataGateway {
	var $tableName = 'jichu_vat2shuirong';
	var $primaryKey = 'id';

	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Vat',
			'foreignKey' => 'vatId',
			'mappingName' => 'Vat'
		)
	);

}
?>