<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_Yl_Ruku extends TMIS_TableDataGateway {
	var $tableName = 'cangku_yl_ruku';
	var $primaryKey = 'id';
	var $primaryName = 'rukuNum';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Supplier',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier'
		)
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_CangKu_Yl_Ruku2Ware',
			'foreignKey' => 'rukuId',
			'mappingName' => 'Wares'
		)
	);
        
	function getNewRukuNum() {
		$ym=date("ym");
		$arr=$this->find("rukuNum like '%$ym%'", 'rukuNum desc', 'rukuNum');
		$max = $arr['rukuNum'];
		$temp = date("ym")."001";
		if ($temp>$max) return $temp;
		$a = substr($max,-3)+1001;
		return substr($max,0,-3).substr($a,1);
	}
	// by zcc 2017Äê12ÔÂ15ÈÕ 16:40:52
	function getRukuNum($Name) {
		$ym=$Name.date("ym");
		$condition = array(
			array('rukuNum',$ym.'___','like')
		);
		$arr=$this->find($condition, 'rukuNum desc', 'rukuNum');
		//dump($arr);exit;
		$max = $arr['rukuNum'];
		$temp = $Name.date("ym")."001";
		if ($temp>$max) return $temp;
		$a = substr($max,-3)+1001;
		return substr($max,0,-3).substr($a,1);
	}
}
?>