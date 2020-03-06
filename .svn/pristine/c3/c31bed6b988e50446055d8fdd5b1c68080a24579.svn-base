<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_ChuKu2Ware extends TMIS_TableDataGateway {
	var $tableName = 'cangku_chuku2ware';
	var $primaryKey = 'id';
	//var $primaryName = 'chukuId';	
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Wares'
		),
		array(
			'tableClass' => 'Model_CangKu_ChuKu',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Chuku'
		),
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier'
		)
	);
	
	//得到特定wareId的出库单价，以最后一次入库单价为准。
	function getDanjia($wareId) {
		$model = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$a=$model->find("wareId='$wareId'",'id desc');		
		$danjia = $a[danJia];		
		if ($danjia>0) return $danjia;
		//初始单价
		$model = FLEA::getSingleton('Model_CangKu_Init');
		$a = $model->find("wareId = '$wareId'");		
		if ($a[cntInit]==0) return false;
		$danjia = $a[moneyInit]/$a[cntInit];
		return number_format($danjia,2,".","");
	}
}
?>