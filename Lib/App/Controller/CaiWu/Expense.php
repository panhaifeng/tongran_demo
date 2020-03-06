<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Expense extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 32;
	function Controller_CaiWu_Expense() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->arrLeftHref = array(
			"CaiWu_Expense" => "付款登记",
			"CaiWu_Ar_Income" => "收款登记",
			"CaiWu_ExpenseItem" =>"支出项目管理",
			"CaiWu_AccountItem" =>"帐户管理",
			"CaiWu_Report_Cash" =>"日记帐"
		);
		$this->leftCaption = '收支管理';		
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Expense');
	}	
	
	function actionRight(){
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			payType=>'',
			dateFrom=>date("Y-m-01"),
			dateTo=>date("Y-m-d")
		));
		$condition = array(
			array('dateExpense',$arr[dateFrom],'>='),
			array('dateExpense',$arr[dateTo],'<=')
		);
		$pager =& new TMIS_Pager($this->_modelExample,$condition,null,200);
        $rowset =$pager->findAll();
		
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][expenseItemType] = $rowset[$i][ExpenseItem][itemType];
			$rowset[$i][expenseItemName] = $rowset[$i][ExpenseItem][itemName];
			$rowset[$i][accountItemName] = $rowset[$i][AccountItem][itemName];
			//$rowset[$i][rukuMoney] = $this->_modelExample->getMoneyRuku($rowset[$i][id]);
			$totalMoney += $rowset[$i][money];
		}

		$i = count($rowset);
		$rowset[$i][payNum] = '<strong>合计</strong>';
		$rowset[$i][money] = '<strong>'.$totalMoney.'</strong>';

		$smarty = & $this->_getView();
		$smarty->assign('search_item',"<select onchange=\"window.location.href='Index.php?controller=CaiWu_Yf_Payment&action=right'\"><option>非采购付款记录</option><option>采购付款记录</option></select>");
		$smarty->assign('title', '付款登记');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"payNum" =>"付款记录编号",
			"dateExpense" =>"支出日期",
			"accountItemName" => "银行帐户",
			//"expenseItemType" =>"支出类别",
			"expenseItemName" =>"支出项目",
			"money" =>"金额",
			"memo" =>"备注"			
		);
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('search_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar("Index.php?controller={$this->_controllerName}&action=Right"));
		$smarty->assign('controller',$this->_controllerName);
		$smarty->assign('arr_condition',$arr);
		//$smarty->assign('other_search_item','asdf');
		$smarty-> display('TableList.tpl');
	}
	
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$smarty->display('CaiWu/ExpenseEdit.tpl');
	}

	function actionAdd() {		
		$this->_edit(array('payNum'=>$this->getNextPayNum()));
	}

	function actionSave() {
       	$id = $this->_modelExample->save($_POST);
		redirect($this->_url("Right"));
	}

	function actionEdit() {
		//$this->_editable($_GET[id]);
		$aRow=$this->_modelExample->find($_GET[id]);
		//dump($aRow);
		$this->_edit($aRow);
	}	

	function actionRemove() {
		$this->_editable($_GET[id]);
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[id]);		
		redirect($this->_url("Right"));
	}
	
	//判断是否允许修改,有下列情况之一不允许修改或者删除
	//1,操作日期超过24小时。
	function _editable($pkv) {
		/*
		$p = $this->_modelExample->find($pkv);
		if (date("Y-m-d H:i:s",mktime(date("H")-24,0,0,date("m"),date("d"),date("Y")))>$p[dt]) 
			js_alert('录入时间已经超过24小时，不允许修改!','',$_SERVER['HTTP_REFERER']);
		*/
	}

	//取得最大的凭证编号
	function getMaxPayNum() {
		$arr=$this->_modelExample->find(null,'payNum desc');		
		$model = FLEA::getSingleton("Model_CaiWu_Yf_Payment");
		$arr2 = $model->find(null,'payNum desc');
		return $arr[payNum]>$arr2[payNum]?$arr[payNum]:$arr2[payNum];		
	}
	function getNextPayNum(){
		$maxPayNum = $this->getMaxPayNum();
		$temp = date("ym")."001";
		if ($temp>$maxPayNum) return $temp;
		$a = substr($maxPayNum,-3)+1001;
		return substr($maxPayNum,0,-3).substr($a,1);
	}
}
?>