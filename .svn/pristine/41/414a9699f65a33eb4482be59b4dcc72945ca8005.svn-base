<?php
load_class('TMIS_TableDataGateway');
class Model_Cangku_Wujin_Chuku extends TMIS_TableDataGateway {
	var $tableName = 'cangku_wujin_chuku';
	var $primaryKey = 'id';
	//var $primaryName = 'orderCode';


	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_WareWujin',
			'foreignKey' => 'wareId',
			'mappingName' => 'Ware'
		)
	);
	/*var $hasMany = array(
		array(
			'tableClass' => 'Model_Cs_Order2tihuo',
			'foreignKey' => 'orderId',
			'mappingName' => 'Tihuo'
		)
	);	*/


}

?>