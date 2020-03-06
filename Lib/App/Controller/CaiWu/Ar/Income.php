<?php
/**
 * 注释参考Client.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Ar_Income extends Tmis_Controller {
	var $_modelExample;
	var $title = "收款登记";
	var $funcId = 33;
	function Controller_CaiWu_Ar_Income() {
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Ar_Income');
	}

	function actionRight()	{
		$this->authCheck($this->funcId);
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);

		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' => date("Y-m-01"),
			'dateTo' =>date("Y-m-d")
		));
		$condition[] = array(dateIncome,$arr[dateFrom], '>=');
		$condition[] = array(dateIncome, $arr[dateTo], '<=');
		$pager =& new TMIS_Pager($this->_modelExample,$condition,null,200);
        $rowset =$pager->findAll();
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][c_i] = $rowset[$i][Client] ? $rowset[$i][Client][compName]
												   : $rowset[$i][ExpenseItem][itemName];
			$rowset[$i][accountItemName] = $rowset[$i][AccountItem][itemName];
			$totalMoney += $rowset[$i][moneyIncome];
		}
		$i = count($rowset);
		$rowset[$i][incomeNum] = '<strong>合计</strong>';
		$rowset[$i][moneyIncome] = '<strong>'.$totalMoney.'</strong>';

		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"dateIncome" =>"收款日期",
			"incomeNum" =>"收款记录编号",
			"type" =>"入账方式",
			"c_i" =>"客户/项目",
			'accountItemName' => "银行帐户",
			"moneyIncome" => "金额",
			"memo" => "备注"
		);

		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);

		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign("add_url",$this->_url('add'));
		//$smarty->assign('search_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=CaiWu_Ar_Income&action=Right'));
		$smarty->assign('arr_condition',$arr);
		//$smarty->assign('page_info',$this->_url('Right',$arr));
		$smarty->assign('controller', 'CaiWu_Ar_Income');
		$smarty-> display('TableList.tpl');
	}

	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign("aRow",$Arr);
		$smarty->display('CaiWu/Ar/Income.tpl');
	}

	function actionEdit() {
		$this->_editable($_GET[id]);
		$aRow=$this->_modelExample->find($_GET[id]);
		$this->_edit($aRow);
	}

	function actionRemove(){
		$this->_editable($_GET[id]);
		parent::actionRemove();
	}

	//处理客户和项目的冲突
	function actionSave() {
		//dump($_POST);exit;
		if ($_POST[clientId]>0) $_POST[expenseItemId]=0;
		if ($_POST[expenseItemId]>0) $_POST[clientId]=0;
		if($_POST['from']=='add') {
			parent::actionSave();
			exit;
		}
		//$this->_modelExample->save($_POST);
		if($this->_modelExample->save($_POST)) {
			js_alert('保存成功!','window.parent.location.href="'.url('CaiWu_Ar_Report','right').'"');
			//redirect($this->_url('add'));
		}
	}

	function actionAdd() {
		$arr = array('incomeNum'=>$this->getNextNum());
		$this->_edit($arr);
	}

	//从财务应收款报表中直接增加，会传入clientId,和dateIncome
	function actionAdd1(){
		$arr = array(
			'clientId'=>$_GET['clientId'],
			'dateIncome'=>$_GET['dateIncome']
		);
		$this->_edit($arr);
	}
	//判断是否允许修改,有下列情况之一不允许修改或者删除
	//1,操作日期超过24小时。
	function _editable($pkv) {
		/*
		return true;
		$p = $this->_modelExample->find($pkv);
		if (date("Y-m-d H:i:s",mktime(date("H")-24,0,0,date("m"),date("d"),date("Y")))>$p[dt])
			js_alert('录入时间已经超过24小时，不允许修改!','',$_SERVER['HTTP_REFERER']);
		*/
	}

	//取得最大的凭证编号
	function getMaxNum() {
		$arr=$this->_modelExample->find(null,'incomeNum desc');
		return $arr[incomeNum];
	}

	function getNextNum(){
		$maxNum = $this->getMaxNum();
		$temp = date("ym")."001";
		if ($temp>$maxNum) return $temp;
		$a = substr($maxNum,-3)+1001;
		return substr($maxNum,0,-3).substr($a,1);
	}
}
?>