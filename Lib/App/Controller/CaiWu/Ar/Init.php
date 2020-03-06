<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Ar_Init extends Tmis_Controller {
	var $_modelExample;
	var $title = "应收款初始化";
	var $funcId = 43;
	function Controller_CaiWu_Ar_Init() {
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Ar_Init');
	}
	function actionRight()	{
		$this->authCheck($this->funcId);
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();		
		if (count($rowset)>0) {
			foreach($rowset as & $v) {
				$v['clientName'] = $v['Client']['compName'];
				$v['_edit']="<a href='".$this->_url('edit',array('id'=>$v['id']))."'>修改</a>&nbsp;<a href='".$this->_url('remove',array('id'=>$v['id']))."'>删除</a>";
			}
			$heji = $this->getHeji($rowset,array('initMoney'),'initDate');
		}
		$rowset[] = $heji;

		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"initDate" =>"初始化日期",
			"clientName" =>"客户",
			"initMoney" =>"金额",
			"memo" =>"备注",
			'_edit' => '操作'
		);

		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=CaiWu_Ar_Init&action=Right'));
		$smarty-> display('TableList.tpl');
	}
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$smarty->display('CaiWu/Ar/InitEdit.tpl');
	}

	function actionAdd() {		
		$this->_edit(array());
	}

	function actionSave() {
       	$this->_modelExample->save($_POST);
		redirect(url("CaiWu_Ar_Init","Right"));
	}

	function actionEdit() {
		$aRow=$this->_modelExample->find($_GET[id]);		
		$this->_edit($aRow);
	}
}
?>