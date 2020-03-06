<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_Yl_Chuku2Ware extends TMIS_TableDataGateway {
	var $tableName = 'cangku_yl_chuku2ware';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Wares'
		),
		array(
			'tableClass' => 'Model_CangKu_Yl_Chuku',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Chuku'
		)
	);

	//得到特定wareId的出库单价，以最后一次入库单价为准。
	/*
	function getDanjia($wareId) {
		$model = FLEA::getSingleton('Model_CangKu_Ruku2Ware');
		$a=$model->find("wareId='$wareId'",'id desc');
		$danjia = $a[danJia];
		if ($danjia>0) return $danjia;
		//ʼ
		$model = FLEA::getSingleton('Model_CangKu_Init');
		$a = $model->find("wareId = '$wareId'");
		if ($a[cntInit]==0) return false;
		$danjia = $a[moneyInit]/$a[cntInit];
		return number_format($danjia,2,".","");
	}*/
}
?>