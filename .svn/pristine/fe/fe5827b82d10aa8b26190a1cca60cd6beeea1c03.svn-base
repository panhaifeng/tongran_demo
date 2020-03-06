<?php
load_class('Model_CaiWu_Yf_Invoice');
class Model_CaiWu_Ar_Invoice extends Model_CaiWu_Yf_Invoice {
	var $belongsTo = array(array(
		'tableClass' => 'Model_JiChu_Client',
		'foreignKey' => 'clientId',
		'mappingName' => 'Client'
	));

	function getInvoiceSum($dateFrom, $dateTo, $clientId) {
		$sql = "select sum(money) as money from caiwu_invoice where dateInput >= '{$dateFrom}' and dateInput <= '{$dateTo}' and clientId = {$clientId} and type > 1";
		$row = $this->findBySql($sql); 
		return $row[0]['money'];
	}
	/*
	
	//õֳĳ
	function getMoneyChuku($pkv){
		$_model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
		$arr=$_model->findAll("invoiceId='$pkv'");
		//dump($arr);exit;
		for ($i=0;$i<count($arr);$i++) {
			$ret += $arr[$i][Ordpro][danjia]*$arr[$i][cntKg];
		}
		return number_format($ret,2,".","");
	}

	//removeByPkv,ɾʱӦýruku2wareinvoiceIdֶΪ0
	function removeByPkv($pkv){
		$_model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
		$_model->updateField("invoiceId='$pkv'",'invoiceId',0);
		parent::removeByPkv($pkv);
	}*/

}
?>