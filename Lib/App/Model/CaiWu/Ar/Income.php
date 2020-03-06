<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_Ar_Income extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_income';
	var $primaryKey = 'id';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'clientId',
			'mappingName' => 'Client'
		),
		array(
			'tableClass' => 'Model_CaiWu_AccountItem',
			'foreignKey' => 'accountItemId',
			'mappingName' => 'AccountItem'
		),
		array(
			'tableClass' => 'Model_CaiWu_ExpenseItem',
			'foreignKey' => 'expenseItemId',
			'mappingName' => 'ExpenseItem'
		)
	);	
	//ȡƾ֤Ľ
	function getMoneyInvoice($pkv){
		$_model = FLEA::getSingleton('Model_CaiWu_Ar_Invoice');
		$arr=$_model->findAll("incomeId='$pkv'");		
		//dump($arr);exit;
		for ($i=0;$i<count($arr);$i++) {
			$ret += $arr[$i][money];
		}
		return number_format($ret,2,".","");
	}	
}
?>