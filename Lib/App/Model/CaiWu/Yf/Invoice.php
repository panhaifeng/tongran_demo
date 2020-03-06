<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_Yf_Invoice extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_invoice';
	var $primaryKey = 'id';
	var $belongsTo = array(array(
		'tableClass' => 'Model_JiChu_Supplier',
		'foreignKey' => 'supplierId',
		'mappingName' => 'Supplier'
	));	
	//var $primaryName = 'compName';
	/*var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'userId',
			'mappingName' => 'User'
		)
	);*/

	//出库金额
	function getMoneyRuku($pkv){
		$_model = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$arr=$_model->findAll("invoiceId='$pkv'");
		//dump($arr);exit;
		for ($i=0;$i<count($arr);$i++) {
			$ret += $arr[$i][danJia]*$arr[$i][cnt];
		}
		return number_format($ret,2,".","");
	}

	//取得已付金额
	function getMoneyPayed(){
	}

	//removeByPkv,删时应将ruku2wareinvoiceId值设为0
	function removeByPkv($pkv){
		$_model = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$_model->updateField("invoiceId='$pkv'",'invoiceId',0);
		parent::removeByPkv($pkv);
	}

	//是否被财务审核过
	function isChecked($pkv) {
		if (!empty($pkv)) $arr = $this->find($pkv);
		if ($arr[isChecked]==1) return true;
		return false;
	}

	//取得已开票合计
	function getInvoiceSum($dateFrom, $dateTo, $supplierId) {
		$sql = "select sum(money) as money from caiwu_invoice where dateInput >= '{$dateFrom}' and dateInput <= '{$dateTo}' and supplierId = {$supplierId} and type < 2";
		$row = $this->findBySql($sql); 
		return $row[0]['money'];
	}
}
?>