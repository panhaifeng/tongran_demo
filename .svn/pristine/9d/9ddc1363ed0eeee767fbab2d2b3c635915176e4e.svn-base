<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_SaleKind extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 26;
	function Controller_JiChu_SaleKind() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_SaleKind');
	}
	
	
	function actionRight() {
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		//$arrParam = TMIS_Pager::getParamArray(array('key'=>''));
		//$condition = $arrParam[key]!='' ? "carCode like '$arrParam[key]%'" : NULL;      
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');
        $rowset =$pager->findAll();

		$smarty = & $this->_getView();
		$smarty->assign('title', '产品大类');
		$arr_field_info = array(
			"kindName" =>"类别名称",			
			"memo" =>"备注"
		);

		$smarty->assign('arr_field_info',$arr_field_info);
	
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		
		#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);	
		
		#分页信息		
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));		
		
		#开始显示
		$smarty->display('TableList.tpl');
	}
	
		
	/**
	 * 修改,增加综合处理函数
	 */
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aVat",$Arr);
		
		#通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
		#在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
		$pk=$this->_modelExample->primaryKey;
		$smarty->display('JiChu/SaleKindEdit.tpl');
	}

	
}
?>