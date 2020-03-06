<?php
load_class('TMIS_TableDataGateway');
class Model_JiChu_Client extends TMIS_TableDataGateway {
	var $tableName = 'jichu_client';
	var $primaryKey = 'id';
	var $primaryName = 'compName';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader'
		)
	);
	var $manyToMany = array(		
		array (
			'tableClass' => 'Model_CaiWu_ArType' ,			
			'mappingName' => 'ArType',
			'joinTable' => 'jichu_client2artype',
			'foreignKey' => 'clientId',
			'assocForeignKey' => 'arTypeId'
		)
	);
	
	//如果已经有订单记录，则不允许删除
	function removeByPkv($id) {
		//判断收款记录
		//$m=&FLEA::getSingleton('Model_CaiWu_Ar_Income');
		//判断是否有订单
		$m=&FLEA::getSingleton('Model_Trade_Dye_Order');
		if ($m->find(array(
			'clientId'=>$id
		))) return false;
		return parent::removeByPkv($id);
	}
}
?>