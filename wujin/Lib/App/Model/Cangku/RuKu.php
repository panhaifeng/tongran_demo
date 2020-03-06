<?php
load_class('TMIS_TableDataGateway');
class Model_Cangku_Ruku extends TMIS_TableDataGateway {
	var $tableName = 'cangku_ruku';
	var $primaryKey = 'id';
	var $primaryName = 'rukuCode';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Supplier',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier'
		)
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Cangku_Ruku2Ware',
			'foreignKey' => 'rukuId',
			'mappingName' => 'Ware'
		)
	);

	function getNewCode() {
		$model = & $this;
		$arr=$model->find(null,'rukuCode desc');
		$max = substr($arr['rukuCode'],2);
		//fdump($max);exit;
		$temp = date("ym-")."0001";
		if ($temp>$max) return "RK".$temp;
		$a = substr($max,-4)+10001;
		return "RK".substr($max,0,-4).substr($a,1);
	}
}
?>