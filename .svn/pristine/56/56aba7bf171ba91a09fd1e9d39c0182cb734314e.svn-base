<?php
load_class('TMIS_TableDataGateway');
class Model_Cangku_Chuku2Ware extends TMIS_TableDataGateway {
	var $tableName = 'cangku_chuku2ware';
	var $primaryKey = 'id';
	//var $primaryName = 'chukuId';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Ware'
		),
		array(
			'tableClass' => 'Model_Cangku_Chuku',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Chuku'
		)
	);

	//得到特定wareId的出库单价，以最后一次入库单价为准。
	function getDanjia($wareId) {
		return 0;
		/*return 100;
		$model = FLEA::getSingleton('Model_Cangku_RuKu2Ware');
		$a=$model->find("wareId='$wareId'",'id desc');
		$danjia = $a[danJia];
		if ($danjia>0) return $danjia;
		//初始单价
		$model = FLEA::getSingleton('Model_Cangku_Init');
		$a = $model->find("wareId = '$wareId'");
		if ($a[cntInit]==0) return false;
		$danjia = $a[moneyInit]/$a[cntInit];
		return number_format($danjia,2,".","");*/
	}

	function _afterCreateDb(&$row) {
		//dump($row);exit;
		//$this->changeKucun($row);
	}

	function _afterRemoveDb(&$row) {
		//$this->changeKucun($row);
	}
	function _afterUpdateDb(&$row) {
		//$this->changeKucun($row);
	}
}
?>