<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Tongxun extends Tmis_Controller {
	var $_modelExample;
	function Controller_Jichu_Tongxun() {
		$this->_modelExample = & FLEA::getSingleton('Model_Jichu_Tongxun');
	}
	#计划列表
	function actionRight(){
		FLEA::loadClass('TMIS_Pager');
		
		$arrG=TMIS_Pager::getParamArray(array(
			'key'=>'',
		));
		if($arrG['key']!=''){$condition=array(array('proName',"%{$arrG['key']}%",'like'));}
		$pager = & new TMIS_Pager($this->_modelExample,$condition);
		$rowset=$pager->findAll();
		if($rowset)foreach($rowset as & $v){
			$v['_edit'] = $this->getEditHtml($v['id']) . ' | ' . $this->getRemoveHtml($v['id']);
		}
		$arr_field_info=array(
			'proName'=>'名称',
			'tel'=>'号码',
			'_edit'=>'操作'
		);
		/***********输出模板界面***************/
		$smarty=& $this->_getView();
		$smarty->assign('title','通讯录');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arrG);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])),$arrG);
		//动态加载js,css文件
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		//$smarty->assign('add_display','none');
		$smarty->display('tableList2.tpl');
	}
	
	/*****编辑界面******/
	function _edit($arr){
		//dump($arr);exit;
		$smarty=& $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->display('Jichu/TongxunEdit.tpl');
	}
	//添加
	function actionAdd(){
		$this->_edit();
	}
	//修改
	function actionEdit(){
		$arr=$this->_modelExample->find($_GET['id']);
		$this->_edit($arr);
	}
	function actionsave(){
		//dump($_POST);exit;
		$this->_modelExample->save($_POST);
		js_alert('','',$this->_url('Right'));
	}
	//删除
	function actionRemove(){
		$this->_modelExample->removeByPkv($_GET['id']);
		js_alert('','',$this->_url('Right'));
	}
}
?>