<?php
FLEA::loadClass('TMIS_Controller');
class Controller_OA_Message extends Tmis_Controller {
	var $_modelExample;
	//var $title = "通知管理";
	var $funcId = '';

	//var $funcId = 9;
	function Controller_OA_Message() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_OA_Message');
		//$this->_log=& FLEA::getSingleton('Model_OA_ControlLog');
		$this->_modelClass= & FLEA::getSingleton('Model_OA_MessageClass');
		switch($_GET['id']) {
			case '1':
				$this->funcId=266;
				break;
			case'2':
				$this->funcId=267;
				break;
			case'3':
				$this->funcId=268;
				break;
			case'4':
				$this->funcId=268;
				break;
			case'5':
				$this->funcId=268;
				break;
			default:
				$this->funcId=172;
		}
	}


	/*function actionRight() {
		$condition=array('classId'=>$_GET['id']);
		$limit=isset($_GET['limit']) ? $_GET['limit']:null;
		$rowset=$this->_modelExample->findAll($condition,'buildDate desc',$limit);
		//dump($rowset);exit;
		$smarty= & $this->_getView();
		$smarty->assign('classId',$_GET['id']);
		$smarty->assign('title','通知管理»'.$rowset[0]['MessageClass']['className']);
		$smarty->assign('aRow',$rowset);
		if($this->authCheck(172,true)===true)	$smarty->assign('show_add',1);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss('calendar'));
		$smarty->assign('controller', 'OA_message');
		$smarty->assign('class', $this->_modelClass->find(array('id'=>$_GET['id'])));
		$smarty-> display('OA/IndexMsg/MsgList.tpl');
	}*/
	#全部详细
	function actionRight() {
		//$this->authCheck(172);
		//dump($_GET);
		if(isset($_GET['id'])) $condition=array('classId'=>$_GET['id']);
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset =$pager->findAll();
		foreach ($rowset as & $value) {
			$value['userName'] = $value['User']['realName'];
			$value['className'] = $value['MessageClass']['className'];
			$value['_edit'] = "<a href='".$this->_url('look',array('id'=>$value['id'],'width'=>'700','height'=>'500','TB_iframe'=>'1'))."' class='thickbox' title='点击查看明细'>查看</a>";
			//echo($this->funcId);exit;
			if($this->authCheck($this->funcId,true)&& $this->funcId!=172) {
				$value['_edit'].=' |'.$this->getEditHtml($value['id'])." | ".$this->getRemoveHtml($value['id']);
			}
		}
		//dump($rowset);exit;
		$title=$rowset[0]['className'];
		//dump($value);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			//"className" =>"类别ID",
			"title" =>"标题",
			"buildDate" =>"日期",
			"userName" =>"操作人员",
			'_edit'=>"操作"
		);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);

		$smarty->assign('add_url',$this->_url('add',array('id'=>$_GET['id'])));

		//$smarty->assign('add_url','add&'$this->_url('add',array('id'=>$rowset[0]['classId'])));
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],array('id'=>$_GET['id']))));
		$smarty->assign('controller', 'OA_message');
		$smarty->display('TableList2.tpl');
	}
	#登陆通知界面
	function actionRight2() {
		$idList=$this->_modelClass->findAll();
		$arr=array();
		foreach($idList as $key=> & $v) {
			$condition=array('classId'=>$v['id']);
			$limit='8';
			$rowset=$this->_modelExample->findAll($condition,'id desc',$limit);
			$arr[$key]=$rowset;
		}
		$class=$this->_modelClass->findAll();
		//dump($class);exit;
		//dump($arr[1]);exit;
		//dump($arr); exit;
		$smarty= & $this->_getView();
		$smarty->assign('classId',$_GET['id']);
		$smarty->assign('title','最近通知');
		$smarty->assign('class',$class);
		$smarty->assign('aRow',$arr);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss('calendar'));
		$smarty->assign('controller', 'OA_message');
		$smarty->display('OA/IndexMsg/MsgListIndex2.tpl');

	}
	function actionLook() {
		$arr=array(
			'ip'=>$_SERVER['REMOTE_ADDR'],
			'messageId'=>$_GET['id'],
			'caozuoren'=>$_SESSION['USERID']
		);
		//dump($arr);exit;
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);
		//$this->_log->save($arr);
		$this->_look($aRow);
	}
	function _look($Arr) {
		//dump($_POST);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		//die($primary_key);
		$smarty->assign("pk",$primary_key);
		$smarty->assign('default_date',date("Y-m-d"));
		$smarty->display('ShowMsg.tpl');
	}
	function _edit($Arr) {

		//die();
		//if(isset($_SESSION['classId'])) $Arr['classId']=6;
		//$this->authCheck(54);
		//dump($Arr);exit;
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		//die($primary_key);
		$smarty->assign("pk",$primary_key);
		$smarty->assign('default_date',date("Y-m-d"));
		$smarty->display('OA/MsgEdit.tpl');
	}

	function actionAdd($ARR=array()) {
		$this->authCheck(54);
		if(isset($_GET['id']))$ARR['classId']=$_GET['id'];
		$this->_edit($ARR);
	}

	function actionSave() {
		$arr=$_POST;
		$arr['userId']=$_SESSION['USERID'];
		$this->_modelExample->save($arr);
		js_alert('','',$this->_url('right',array('id'=>$arr['classId'])));
	}

	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);
		$this->_edit($aRow);
	}

	function actionRemove() {
		$arr = $this->_modelExample->find(array('id'=>$_GET['id']));
		$classId = $arr['classId'];
		$this->_modelExample->removeByPkv($_GET['id']);
		redirect($this->_url("right1",array('id'=>$classId)));
	}
}
?>