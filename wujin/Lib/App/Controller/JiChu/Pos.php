<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Pos extends Tmis_Controller {
	var $_modelExample;
	var $title = "染缸档案";
	function Controller_JiChu_Pos() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_Jichu_Pos');
	}
	function actionRight() {
		FLEA::loadClass('TMIS_Pager');
		//$arrParam = TMIS_Pager::getParamArray(array('key'=>''));
		//$condition = $arrParam[key]!='' ? "vatCode like '$arrParam[key]%'" : NULL;
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		if($arr['key']!='') $condition[]=array('posName',"%$arr[key]%",'like');
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset =$pager->findAll();
		foreach($rowset as & $v){
		   $v['edit']="<a href='".$this->_url('edit',array('id'=>$v['id'],'posName'=>$v['posName']))."'>修改</a>".' ';
		   $v['edit'].="<a href='".$this->_url('remove',array('id'=>$v['id']))."'>删除</a>".' ';
		}
		$arr_field_info = array(
			"id" =>"系统编号|right",
			"posName" =>"库存位置|left",
			"edit" =>"操作"
		);
		$smarty = & $this->_getView();
		$smarty->assign('title', '库存位置');
		$smarty->assign('arr_field_info',$arr_field_info);

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
		//$this->authCheck(81);
		$smarty = & $this->_getView();
		$smarty->assign("aPos",$Arr);
		$smarty->display('JiChu/PosEdit.tpl');
	}
	function actionRemove(){
		//$this->authCheck(81);
	    $this->_modelExample->removeByPkv($_GET['id']);
	    redirect($this->_url('right'));
	}
	function actionEdit(){
		//$this->authCheck(81);
	    $this->_edit($_GET);
	}
}
?>