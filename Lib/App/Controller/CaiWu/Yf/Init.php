<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Yf_Init extends Tmis_Controller {
	var $_modelExample;
	var $title = "应付款初始化";
	var $funcId = 10;
	function Controller_CaiWu_Yf_Init() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Yf_Init');
	}
	
	function actionRight()	{
		$this->authCheck($this->funcId);
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);

		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();
		
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][supplierName] = $rowset[$i][Supplier][compName];
		}
		$heji = $this->getHeji($rowset,array('initMoney'),'initDate');
		$rowset[] = $heji;
		
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"initDate" =>"初始化日期",
			"supplierName" =>"供应商",
			"initMoney" =>"金额",
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
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=CaiWu_Yf_Init&action=Right'));
		$smarty-> display('TableList.tpl');
	}
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");		
		$smarty->assign("pk",$primary_key);		
		$smarty->display('CaiWu/Yf/InitEdit.tpl');
	}

	function actionAdd() {		
		$this->_edit(array());
	}

	function actionSave() {
       	$this->_modelExample->save($_POST);
		redirect(url("CaiWu_Yf_Init","Right"));
	}

	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);		
		$this->_edit($aRow);
	}	

	function actionRemove() {
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[$pk]);
		redirect(url("CaiWu_Yf_Init","Right"));
	}
}
?>