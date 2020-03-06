<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_RuKu extends TMIS_TableDataGateway {
	var $tableName = 'cangku_ruku';
	var $primaryKey = 'id';
	var $primaryName = 'ruKuNum';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Client'
		)
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_CangKu_RuKu2Ware',
			'foreignKey' => 'ruKuId',
			'mappingName' => 'Wares'
		)
	);
	function getNewRukuNum() {
		$ym=date("ym");
		$condition = array(
			array('rukuNum',$ym.'___','like')
		);
		$arr=$this->find($condition, 'rukuNum desc', 'rukuNum');
		//dump($arr);exit;
		$max = $arr['rukuNum'];
		$temp = date("ym")."001";
		if ($temp>$max) return $temp;
		$a = substr($max,-3)+1001;
		return substr($max,0,-3).substr($a,1);
	}
}
/*
class Model_CangKu_Ruku_Dye extends Model_CangKu_RuKu {
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Supplier',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier'
		)
	);
}

class Model_CangKu_RuKu_Peisha extends Model_CangKu_RuKu {
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Client'
		)
	);
}*/

?>