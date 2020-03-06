<?php
load_class('TMIS_TableDataGateway');
class Model_Chengpin_Denim_Cpck2OrdPro extends TMIS_TableDataGateway {
	var $tableName = 'chengpin_denim_cpck2ordpro';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Chengpin_Denim_Cpck',
			'foreignKey' => 'cpckId',
			'mappingName' => 'Cpck'
		),
		array(
			'tableClass' => 'Model_Trade_Denim_Order2Product',
			'foreignKey' => 'order2ProductId',
			'mappingName' => 'Ordpro'
		)
	);
//是否被财务审核过
	function isAuditted($pkv) {
		if (!empty($pkv)) $arr = $this->find($pkv);
		if ($arr[isAuditted]==1) return true;
		return false;
	}
}
?>