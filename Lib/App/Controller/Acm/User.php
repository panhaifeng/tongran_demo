<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Acm_User extends Tmis_Controller {
	var $_modelUser;
	var $funcId = 22;
	function Controller_Acm_User() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelUser = FLEA::getSingleton('Model_Acm_User');
	}

	function actionChangePwd() {
		$realName = $_SESSION[REALNAME];
		$userName = $_SESSION[USERNAME];
		$userId = $_SESSION['USERID'];
		$aUser = $this->_modelUser->find($userId);
		$smarty = $this->_getView();
		$smarty->assign('aUser',$aUser);
		$smarty->assign('title',"密码修改");
		$smarty->display('Acm/ChangePwd.tpl');
	}
	function actionRight() {
		$this->authCheck($this->funcId);
		if (isset($_POST[key])&&$_POST[key]!="") $condition = "realName like '%$_POST[key]%'";
		FLEA::loadClass('TMIS_Pager');
		$pager = new TMIS_Pager($this->_modelUser,$condition);
		$rowSet = $pager->findAll();
		if($rowSet) foreach($rowSet as & $v) {
			$v['_edit'] = $this->getEditHtml($v['id']) . ' ' .$this->getRemoveHtml($v['id']);
			$v['_edit'] .= " "."<a href='".$this->_url('ResetPwd',array(
				'id'=>$v['id']
			))."' onclick='return confirm(\"密码将重置为6个a,您确认吗?\")'>重置密码</a>";

			$text1 = $v['qrCodeVerify']>0?'已开启':'未开启';
			$text2 = $v['qrCodeVerify']>0?'[关闭]':'[开启]';
			$v['_edit2'] = "{$text1}&nbsp;<a href='".$this->_url('SetQrVerify',array('id'=>$v['id'],'qrCodeVerify'=>1-$v['qrCodeVerify']))."'>{$text2}</a>";
		}
		//dump($rowSet);exit;
		$arrFieldInfo = array(
			"id"=>"编号",
			"userName"=>"用户名",
			"realName"=>"真实姓名",
			"_edit"=>'操作',
			'_edit2'=>'二维码验证功能'
		);
		#对操作栏进行赋值
		/*$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除",
		    "reset"=>"重置密码"
		);*/
		$pk = $this->_modelJiChuDepartment->primaryKey;
		$smarty = & $this->_getView();
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign("title","用户管理");
		$smarty->assign("arr_field_value",$rowSet);
		//$smarty->assign('search_display', 'none');
		$smarty->assign('pk','id');
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display("TableList.tpl");
	}
	/*
	function actionIndex() {
		$arrLeftList = array(
			"Acm_User" =>"用户管理",
			"Acm_Role" =>"角色管理",
			"Acm_Func" =>"模块定义"
		);

		$smarty = & $this->_getView();
		$smarty->assign('arr_left_list', $arrLeftList);
		$smarty->assign('title', '用户管理');
		$smarty->assign('caption', '权限管理');
		//$smarty->assign('child_caption', "应付款凭据录入");
		$smarty->assign('controller', 'Acm_User');
		$smarty->assign('action', 'right');
		$smarty->display('MainContent.tpl');
	}*/
	function actionAdd() {
		$this->_edit(array());
	}
	function actionEdit() {
		$aUser = $this->_modelUser->find($_GET[id]);
		//$dbo = FLEA::getDbo(false);
		//dump($dbo->log);exit;
		$this->_edit($aUser);
	}
	function actionSave() {
		$this->_modelUser->save($_POST);
		if ($_POST[Submit]=='确认修改') js_alert('修改密码成功!','window.close()');
		redirect($this->_url('right'));
	}
	function actionRemove() {
		$this->_modelUser->removeByPkv($_GET[id]);
		redirect($this->_url('right'));
	}

	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = $this->_getView();
		$smarty->assign('aUser',$Arr);
		$smarty->assign('title',"用户信息编辑");
		$smarty->display('Acm/UserEdit.tpl');
	}

	//重置密码
	function actionResetPwd(){
		$arr = array(
			'id'=>$_GET['id'],
			'passwd'=>'aaaaaa'
		);
		//dump($arr);exit;
		if($this->_modelUser->update($arr)) js_alert('密码重置成功!','',$this->_url('right'));
	}

	/**
	 * 完善个人信息
	 * Time：2018/08/09 14:43:44
	 * @author li
	*/
	function actionInfoPerfect(){
		if($_SESSION['USERNAME']=='admin'){
			echo "管理员不需要完善个人信息";exit;
		}
		$aUser = $this->_modelUser->find($_SESSION['USERID']);
		$smarty = $this->_getView();
		$smarty->assign('aUser',$aUser);
		$smarty->assign('title',"用户管理编辑");
		$smarty->display('Acm/InfoPerfect.tpl');
	}

	function actionInfoPerfectSave(){
		$sql = "SELECT count(*) as cnt FROM `acm_userdb` where id <>'".$_POST['id']."' and tel='{$_POST['tel']}'";
		$rr = $this->_modelUser->findBySql($sql);
		if($rr[0]['cnt']>0) {
			js_alert('手机号重复!',null,$this->_url('InfoPerfect',$_POST));
		}

		$this->_modelUser->save($_POST);
		js_alert('保存成功！','',$_POST['from'] ? $_POST['from'] : $this->_url('InfoPerfect',$_POST));
	}
	
	/**
	 * @desc ：关闭/开启二维码验证功能
	 * Time：2019/07/19 12:51:26
	 * @author Wuyou
	*/
	function actionSetQrVerify(){
		$sql = "UPDATE acm_userdb SET qrCodeVerify={$_GET['qrCodeVerify']} WHERE id='{$_GET['id']}'";
		$this->_modelUser->execute($sql);
		$text = $_GET['qrCodeVerify']>0?'开启':'关闭';
		js_alert($text.'成功！','',$this->_url('Right'));
	}
}
?>