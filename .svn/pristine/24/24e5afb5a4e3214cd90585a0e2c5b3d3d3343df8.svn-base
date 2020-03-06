<?php
load_class('TMIS_TableDataGateway');
class Model_Gongyi_Dye_Chufang extends TMIS_TableDataGateway {
	var $tableName = 'gongyi_dye_chufang';
	var $primaryKey = 'id';
		
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Trade_Dye_Order2Ware',
			'foreignKey' => 'order2wareId',
			'mappingName' => 'OrdWare'
		),
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'chufangrenId',
			'mappingName' => 'Chufangren'
		),
		array(
			'tableClass' => 'Model_Plan_Dye_Gang',
			'foreignKey' => 'gangId',
			'mappingName' => 'Gang',
			'enabled' => false
		),
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Gongyi_Dye_Chufang2Ware',
			'foreignKey' => 'chufangId',
			'mappingName' => 'Ware'
		)
	);
	
	//某个订单明细已经开过的处方数
	function getCntOfChufang($order2wareId) {
		return $this->findCount(array(
			order2wareId => $order2wareId
		));
	}
}
?>