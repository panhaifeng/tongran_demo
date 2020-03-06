<?php
load_class('TMIS_TableDataGateway');
class Model_CaiWu_Expense extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_expense';
	var $primaryKey = 'id';
	var $primaryName = 'itemName';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_CaiWu_ExpenseItem',
			'foreignKey' => 'expenseItemId',
			'mappingName' => 'ExpenseItem'
		),
		array(
			'tableClass' => 'Model_CaiWu_AccountItem',
			'foreignKey' => 'accountItemId',
			'mappingName' => 'AccountItem'
		)
	);
}
?>