<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Employkind extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 27;
	function Controller_JiChu_Employkind() {
		$this->_modelExample = & FLEA::getSingleton('Model_Jichu_EmployKind');
	}

	function actionRight() {
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		$rowset =$pager->findAll();
		//dump($rowset);
		$smarty = & $this->_getView();
		$smarty->assign('title','人员设置');
		$smarty->assign('arr_field_value',$rowset);
		#开始显示
		$smarty->display('JiChu/SetEmployKind.tpl');
	}
	//保存已经设置的员工类别
	function actionSave() {
	  //dump($_POST);exit;
	  $arr=array(
		    'employId'=>$_POST['employId'],
		    'kind'=>$_POST['kind']
		    );
	  $this->_modelExample->save($arr);
	  redirect($this->_url("Right"));
	}
	//删除信息
	function actionDelete() {
	    //dump($_GET);exit;
	    $this->_modelExample->removeByPkv($_GET['id']);
	    redirect($this->_url("Right"));
	}
}
?>