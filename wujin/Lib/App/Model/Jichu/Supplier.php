<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Supplier extends TMIS_TableDataGateway {
	var $tableName = 'jichu_supplier';
	var $primaryKey = 'id';
	var $primaryName = 'compName';

	function removeByPkv($pkv){
		$_model = FLEA::getSingleton('Model_Cangku_RuKu');
		$arr = $_model->find(array(
			supplierId=>$pkv
		));
		//$dbo=FLEA::getDBO(false);
		//dump($dbo->log);exit;
		//dump($arr);exit;
		if($arr) return false;
		return parent::removeByPkv($pkv);
	}
}
?>