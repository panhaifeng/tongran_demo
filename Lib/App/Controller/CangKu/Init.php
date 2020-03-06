<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Init extends Tmis_Controller {
	var $_modelExample;
	var $title = "库存初始化";
	var $funcId = 10;
	function Controller_CangKu_Init() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_Init');
	}
	
	function actionRight()	{
		$this->authCheck($this->funcId);
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();		
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][wareName] = $rowset[$i][Ware][wareName]." ".$rowset[$i][Ware][guige];
			$rowset[$i][unit] = $rowset[$i][Ware][unit];
		}
		
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"initDate" =>"初始化日期",
			"wareName" =>"品名规格",			
			"cntInit" =>"初始数量",
			"unit" => "单位",
			"moneyInit" =>"初始金额",
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
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty-> display('TableList.tpl');
	}
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$smarty->display('CangKu/InitEdit.tpl');
	}

		
}
?>