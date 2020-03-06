<?php
load_class('TMIS_TableDataGateway');
class Model_JiChu_Supplier extends TMIS_TableDataGateway {
	var $tableName = 'jichu_supplier';
	var $primaryKey = 'id';
	var $primaryName = 'compName';

	function removeByPkv($pkv){	
		$_model = FLEA::getSingleton('Model_CangKu_RuKu');
		$arr = $_model->find(array(
			supplierId=>$pkv,
			tag=>2 //染料入库标志

		));
		//$dbo=FLEA::getDBO(false);
		//dump($dbo->log);exit;
		//dump($arr);exit;
		if($arr) return false;
		return parent::removeByPkv($pkv);
	}	
}
?>