<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_Yf_Payment extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_payment';
	var $primaryKey = 'id';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Supplier',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier'
		),
		array(
			'tableClass' => 'Model_CaiWu_AccountItem',
			'foreignKey' => 'accountItemId',
			'mappingName' => 'AccountItem'
		)
	);	
	//ȡƾ֤Ľ
	function getMoneyInvoice($pkv){
		$_model = FLEA::getSingleton('Model_CaiWu_Yf_Invoice');
		$arr=$_model->findAll("paymentId='$pkv'");		
		//dump($arr);exit;
		for ($i=0;$i<count($arr);$i++) {
			$ret += $arr[$i][money];
		}
		return number_format($ret,2,".","");
	}
	//removeByPkv,ɾʱӦýinvoicepaymentIdֶΪ0
	function removeByPkv($pkv){
		$_model = FLEA::getSingleton('Model_CaiWu_Yf_Invoice');
		$_model->updateField("paymentId='$pkv'",'paymentId',0);
		parent::removeByPkv($pkv);
	}
	
}
?>