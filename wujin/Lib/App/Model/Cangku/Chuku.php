<?php
load_class('TMIS_TableDataGateway');
class Model_Cangku_Chuku extends TMIS_TableDataGateway {
	var $tableName = 'cangku_chuku';
	var $primaryKey = 'id';
	var $primaryName = 'chukuCode';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Department',
			'foreignKey' => 'depId',
			'mappingName' => 'Department'
		)
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Cangku_Chuku2Ware',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Ware'
		)
	);

	function getNewCode() {
		$model = & $this;
		$arr=$model->find(null,'chukuCode desc');
		$max = substr($arr['chukuCode'],2);
		//fdump($max);exit;
		$temp = date("ym-")."0001";
		if ($temp>$max) return "CK".$temp;
		$a = substr($max,-4)+10001;
		return "CK".substr($max,0,-4).substr($a,1);
	}
}
?>