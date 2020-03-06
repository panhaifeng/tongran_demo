<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_AccountItem extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 21;
	function Controller_CaiWu_AccountItem() {
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_AccountItem');
	}

	function actionRight(){
		$this->authCheck(35);
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample);
		//dump($this->_modelExample);exit;
		$rowset =$pager->findAll();

		$smarty = & $this->_getView();
		$smarty->assign('title', '银行帐户管理');
		$arr_field_info = array(
			"itemName" =>"项目名"
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
		$smarty->assign('controller', $this->_controllerName);
		$smarty-> display('TableList.tpl');
	}

	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$smarty->display('CaiWu/AccountItemEdit.tpl');
	}

	function actionAdd() {
		$this->_edit(array());
	}

	function actionSave() {
       	$id = $this->_modelExample->save($_POST);
		redirect($this->_url("Right"));
	}

	function actionEdit() {
		$aRow=$this->_modelExample->find($_GET[id]);
		$this->_edit($aRow);
	}

}
?>