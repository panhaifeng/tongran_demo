<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :zcc
*  FName  :Vehicle.php
*  Time   :2014/08/30 09:18:48
*  Remark :
\*********************************************************************/
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Vehicle extends Tmis_Controller {
	var $_modelExample;
	var $title = "车辆档案";
	var $funcId = 25;
	function Controller_JiChu_Vehicle() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Vehicle');
	}
	function actionAdd(){
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("rows",$Arr);
		$smarty->display('JiChu/VehicleEdit.tpl');
	}
	function actionRight()	{
		$this->authCheck($this->funcId);
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		//echo $condition;
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(
			array(
				'key'=>''
			));

		if ($arr[key]!="") $condition[]="carCode like '$arr[key]%' or people like '%$arr[key]%'";
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();
		if(count($rowset)>0) foreach($rowset as & $v){
			$v['_edit'] = $this->getEditHtml($v['id']) . " <a href='".$this->_url('Remove',array(
				'id'=>$v['id']
			))."'>删除</a>";
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"carCode" =>"车编号",
			"people" =>"联系人",
			"tel" =>"电话",
			"memo" =>"备注",
			'_edit'=>'操作'
		);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->assign('controller', 'JiChu_Vehicle');
		$smarty-> display('TableList.tpl');
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

	function actionEdit() {
		$Arr=$this->_modelExample->find($_GET['id']);
		$smarty = & $this->_getView();
		$smarty->assign("rows",$Arr);
		$smarty->display('JiChu/VehicleEdit.tpl');
	}
	//ajax 获取车辆中的司机（联系人）
	function actionGetPeopleName(){
		$sql = "SELECT people FROM jichu_vehicle where id = {$_GET['id']} ";
		$people = $this->_modelExample->findBySql($sql);
		$string = $people[0]['people'];
		$arr = explode(';', $string);
		echo json_encode($arr);
		exit;
	}
}
?>