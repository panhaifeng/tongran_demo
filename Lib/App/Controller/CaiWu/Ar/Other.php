<?php
/**
 * 注释参考Client.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Ar_Other extends Tmis_Controller {
	var $_modelExample;
	var $title = "其他应收款";
	var $funcId = 43;
	function Controller_CaiWu_Ar_Other() {
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Ar_Other');
	}
	function actionRight()	{
		$this->authCheck($this->funcId);
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();		
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][clientName] = $rowset[$i][Client][compName];
		}
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"recordDate" =>"发生日期",
			"clientName" =>"客户",
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
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=CaiWu_Ar_Other&action=Right'));
		$smarty-> display('TableList.tpl');
	}
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$smarty->display('CaiWu/Ar/OtherEdit.tpl');
	}

	function actionAdd() {		
		$this->_edit(array());
	}

	function actionSave() {
       	$this->_modelExample->save($_POST);
		redirect(url("CaiWu_Ar_Other","Right"));
	}

	function actionEdit() {
		$aRow=$this->_modelExample->find($_GET[id]);		
		$this->_edit($aRow);
	}
}
?>