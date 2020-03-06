<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_OA_SM extends Tmis_Controller {
	var $_modelSM;
	var $title = "短消息";
	//var $funcId = 20;
	//var $funcId = 9;
	function Controller_OA_SM() {
		/*if(!$this->authCheck()) die("禁止访问!");*/

		$this->_modelSM = & FLEA::getSingleton('Model_OA_SM');
	}

	function actionRight()
	{
		$this->authCheck(6);
		$condition = ("reUserId like '%$_SESSION[USERID]%'");
		//echo $condition; die();
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelSM,$condition);
    	$rowset =$pager->findAll();
		//dump($rowset);
		foreach ($rowset as & $value) {
			//$value[reUserName] = $value[User][realName];
			$value[sendRealName] = $value[UserSend][realName];
		}

		//dump($rowset);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$pk = $this->_modelSM->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"sendDate" =>"发送日期",
			"title" =>"标题",
			"sendRealName" =>"发件人",
			"state"=>"状态"
		);

		if (count($rowset)>0) {
			foreach ($rowset as & $aRow) {
				if ($aRow[state]==0) {$aRow[state]='<font color=red>未读</font>';}
				if ($aRow[state]==1) {$aRow[state]='已读';}
			}
		}

		#对操作栏进行赋值
		$arr_edit_info = array(
			"view" =>"查看",
			"remove" =>"删除"
		);

		//dump($rowset);eixt;
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=OA_SM&action=Right'));
		$smarty-> display('TableList2.tpl');
	}

	function actionNotes() {
		$count = $this->_modelSM->findCount("reUserId like '%$_SESSION[USERID]%' and state = 0");
		//die($count);
		$smarty = & $this->_getView();
		$smarty->assign('count',$count);
		$smarty->display('OA/SM/Notes.tpl');
	}

	function actionAdd() {
		$smarty = & $this->_getView();
		$smarty->assign('default_date',date("Y-m-d"));
		$smarty->assign('send_userId', $_SESSION['USERID']);
		$smarty->display('OA/SM/Edit.tpl');
	}

	function actionView() {
		$pk=$this->_modelSM->primaryKey;
		$aRow=$this->_modelSM->find($_GET[$pk]);
		$this->_modelSM->updateField("id='$_GET[$pk]'",'state',1);

		//dump($aRow);
		if (count($aRow)>0) {
					$aRow[sendRealName] = $aRow[User][realName];
		}

		$smarty = & $this->_getView();
		$smarty->assign("aRow",$aRow);
		$pk=$this->_modelSM->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		//die($primary_key);
		$smarty->assign("pk",$primary_key);
		$smarty->assign('default_date',date("Y-m-d"));
		$smarty->display('OA/SM/View.tpl');
	}

	function actionSave() {
		//dump($_POST);exit;
		$this->_modelSM->save($_POST);
		redirect(url("OA_SM","Right"));
	}


	function actionRemove() {
		$pk=$this->_modelSM->primaryKey;
		$this->_modelSM->removeByPkv($_GET[$pk]);
		redirect(url("OA_SM","Right"));
	}
}
?>