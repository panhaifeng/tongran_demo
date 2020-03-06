<?php
/*生产流转卡的打印*/
load_class('TMIS_TableDataGateway');
class Model_JiChu_Gongyi extends TMIS_TableDataGateway {
	var $tableName = 'jichu_gongyi';
	var $primaryKey = 'id';
	var $primaryName = 'gongyiName';
	var $hasMany=array(
		array(
			'tableClass'=>'Model_JiChu_Gongyi2ware',
			'mappingName'=>'GongyiWares',
			'foreignKey'=>'gongyiId',
			'sort' =>'id',
			)
		);
}
?>