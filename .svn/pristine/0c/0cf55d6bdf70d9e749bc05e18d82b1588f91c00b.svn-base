<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Sys_CompInfo extends Tmis_Controller {
	var $_modelExample;
	var $title = "帐套信息";
	var $funcId = 25;
	function Controller_Sys_CompInfo() {
		$this->_modelExample = & FLEA::getSingleton('Model_Sys_CompInfo');
	}

	private function _editJichuClient($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign("rowset",$Arr);
		$smarty->display('Sys/CompInfoEdit.tpl');
	}

	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$rowset=$this->_modelExample->findAll();
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign("row",$rowset[0]);
		$smarty->display('Sys/CompInfoEdit.tpl');
	}		


	function actionSave(){
		__TRY();
		$this->_modelExample->save($_POST);
		$ex = __CATCH();
		if (__IS_EXCEPTION($ex)) {
			js_alert('保存出错!', '', $this->_url('edit'));
		} else {
			js_alert('保存成功!', '', $this->_url('edit'));
		}
	}
}
?>