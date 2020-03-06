<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Yf_Other extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 10;
	function Controller_CaiWu_Yf_Other() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton("Model_CaiWu_Yf_Other");
	}
	
	function actionRight() {
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'supplierId'=>0
		));
		$condition = array(
			array('dateRecord',$arr['dateFrom'],'>='),
			array('dateRecord',$arr['dateTo'],'<=')
		);
		if($arr['supplierId']>0) $condition[] = array('supplierId',$arr['supplierId']);
		$pager = & new TMIS_Pager($this->_modelExample, $condition);
		$rowset = $pager->findAll();
		if($rowset) foreach($rowset as & $v) {
			$v['_edit'] = $this->getEditHtml($v['id']) . " | " . $this->getRemoveHtml($v['id']);
		}
		//dump($rowset);
		$arrFieldInfo = array (
			"dateRecord" => "发生日期",
			"Supplier.compName" => "供应商",
			'money'=>'发生金额',
			'memo'=>'备注',
			'_edit'=>'操作'
		);
		$smarty = & $this->_getView();			
		$smarty->assign("title","其他应付往来");
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign("arr_field_value",$rowset);
		$smarty->assign('arr_condition',$arr);	
		$smarty->assign('arr_js_css',$this->makeArrayJsCss('calendar'));
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display("TableList.tpl");
	}
	
	function _edit($aDep) {
		$this->authCheck($this->funcId);
		$smarty = $this->_getView();
		$smarty->assign('aRow',$aDep);
		$smarty->display('CaiWu/Yf/OtherEdit.tpl');
	}
}
?>