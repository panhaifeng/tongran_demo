<?php
load_class('TMIS_TableDataGateway');
class Model_Chengpin_Denim_Cprk2OrdPro extends TMIS_TableDataGateway {
	var $tableName = 'chengpin_denim_cprk2ordpro';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Chengpin_Denim_Cprk',
			'foreignKey' => 'cprkId',
			'mappingName' => 'Cprk'
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
	