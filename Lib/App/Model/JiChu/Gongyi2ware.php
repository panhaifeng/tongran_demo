<?php
/*生产流转卡的打印*/
load_class('TMIS_TableDataGateway');
class Model_JiChu_Gongyi2ware extends TMIS_TableDataGateway {
	var $tableName = 'jichu_gongyi2ware';
	var $primaryKey = 'id';
	var $belongsTo=array(
		array(
		'tableClass'=>'Model_JiChu_Ware',
		'foreignKey'=>'wareId',
		'mappingName'=>'Ware'
		)
		);
}
?>