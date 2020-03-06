<?php
load_class('TMIS_TableDataGateway');
class Model_Cangku_Wujin_Ruku extends TMIS_TableDataGateway {
	var $tableName = 'cangku_wujin_ruku';
	var $primaryKey = 'id';
	//var $primaryName = 'orderCode';


	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_WareWujin',
			'foreignKey' => 'wareId',
			'mappingName' => 'Ware'
		)
	);
	/*var $hasMany = array(
		array(
			'tableClass' => 'Model_Cs_Order2tihuo',
			'foreignKey' => 'orderId',
			'mappingName' => 'Tihuo'
		)
	);	*/

	//取得新单号
	function getNewRukuCode($head="") {
		$length = strlen($head);
		$condition = array(array('rukuCode',$head.'%','like'));
		$arr=$this->find($condition,'rukuCode desc','rukuCode');
		$max = $arr['rukuCode'];

		$temp = $head . date("ym")."001";
		//dump($temp>$max);dump($temp);
		if ($temp>$max) return $temp;
		$a = substr($max,-3)+1001;
		return substr($max,0,-3).substr($a,1);
	}

	function formatRet(& $row) {
		if(!$row['Supplier'] && $row['supplierId']>0) {
			$m = & FLEA::getSingleton('Model_Jichu_Supplier');
			$row['Supplier'] = $m->find(array('id'=>$row['supplierId']));
		}

		if(!$row['Trader'] && $row['traderId']>0) {
			$m = & FLEA::getSingleton('Model_Jichu_Employ');
			$row['Trader'] = $m->find(array('id'=>$row['traderId']));
		}

		if(!$row['User'] && $row['userId']>0) {
			$m = & FLEA::getSingleton('Model_Acm_User');
			$row['User'] = $m->find(array('id'=>$row['userId']));
		}
		return $row;
	}
}

?>