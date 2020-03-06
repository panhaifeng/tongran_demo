<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Department extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 28;
	function Controller_JiChu_Department() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton("Model_JiChu_Department");
	}
	

/*
	function actionIndex() {
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$smarty->assign('caption', "部门资料");
		$smarty->assign('controller', 'JiChu_Department');
		$smarty->assign('action', 'right');		
		$smarty->display('MainContent.tpl');
	}*/
	
	function actionRight() {
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		if (isset($_POST[key])&&$_POST[key]!="") $condition = "depName like '%$_POST[key]%'";
		$pager = & new TMIS_Pager($this->_modelExample, $condition);
		$rowset = $pager->findAll();
		
		$arrFieldInfo = array ("id" => "编号","depName" => "部门");
		$pk = $this->_modelExample->primaryKey;
		$smarty = & $this->_getView();
		
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		
		$smarty->assign("title","部门管理");
		$smarty->assign('controller', 'JiChu_Department');
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign("arr_field_value",$rowset);
		$smarty->assign('arr_condition',$arr);	
		$smarty->assign('pk', $pk);	
		$smarty->assign("page_info",$pager->getNavBar($this->_url()));
		$smarty->display("TableList.tpl");
	}
	
	function _edit($aDep) {
		$this->authCheck($this->funcId);
		$smarty = $this->_getView();
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('aDep',$aDep);
		$smarty->assign('pk', $pk);
		$smarty->display('JiChu/DepartmentEdit.tpl');
	}
	function actionAdd() {
		$this->_edit(array());
	}
	function actionEdit() {
		$aDep = $this->_modelExample->find($_GET[id]);
		$this->_edit($aDep);
	}
	
	function actionSave() {
		$this->_modelExample->save($_POST);
		redirect(url("JiChu_Department","Right"));
	}
	function actionRemove() {
		$this->_modelExample->removeByPkv($_GET[id]);
		redirect(url("JiChu_Department","Right"));
	}
}
?>