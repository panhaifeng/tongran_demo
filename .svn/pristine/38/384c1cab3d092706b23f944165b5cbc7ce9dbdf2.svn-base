<?php
class Controller_Login extends FLEA_Controller_Action {
    function Controller_Login() {
    //echo("languageFilesDir");
    //die(dirname(__FILE__));
    //load_language('ui');
    }

    /**
     * 显示登录界面
     */
    function actionIndex() {
	$ui =& FLEA::initWebControls();
	$smarty = & $this->_getView();
	$smarty->display('Login.tpl');
    //include(APP_DIR . '/Template/Login.tpl');
    }
    //员工登陆界面
    function actionIndex2() {
	$ui =& FLEA::initWebControls();
	$smarty = & $this->_getView();
	$smarty->display('eLogin.tpl');
    }

    function actionIndex1() {
	$m= FLEA::getSingleton('Model_Jichu_Gongxu');
	$arr=$m->findAll();
	//dump($arr);exit;
	if($arr)foreach($arr as $v) {
		$rowset[]='<a href="'.$this->_url('Index2',array('gongxuId'=>$v['id'])).'">'.$v['gongxuName'].'</a>';
	    }
	$smarty = & $this->_getView();
	$smarty->assign('aRow',$rowset);
	$smarty-> display('eLogin1.tpl');
    }
    /**
     * 注销
     */
    function actionLogout() {
	session_destroy();
	//$msg = "注销";
	redirect($this->_url("login"));
    }

    function actionLogoutToIndex() {
	session_destroy();
	//$msg = "注销";
	$ui =& FLEA::initWebControls();
	header("Location:Index.php");
    }

    /**
     * 员工登录
     */
    function actionLogin2() {
	do {
	    $eqLogin =& FLEA::getSingleton('Model_Login');
	    $user = $eqLogin->findByUsername($_POST['username']);
	    if (!$user) {
		$msg = "无效用户名";
		break;
	    }
	    $userId = $user[id];
	    $realName = $user[realName];

	    if (!$eqLogin->checkPassword($_POST['password'], $user[$eqLogin->passwordField])) {
		$msg = "无效密码";
		break;
	    }

            /*登录成功，通过 RBAC 保存用户信息和角色*/
	    $_SESSION['LANG'] = $_POST['language'];
	    $_SESSION['USERID'] = $userId;
	    $_SESSION['REALNAME'] = $realName;
	    $_SESSION['USERNAME'] = $_POST['username'];

	    $_SESSION['BANCI'] = $_POST['banciId'];
	    $_SESSION['GONGXU'] = $_POST['gongxuName'];


	    //echo('----------------'.$_POST['username']); exit();
	    if ($_POST['username'] == 'wgh') {
		include(APP_DIR . '/Template/MainWgh.tpl'); exit;
	    //redirect(url('Main', 'mainSimple'));
	    }
	    else {
		if(isset($_POST['banciId'])) {//员工界面
                     /****员工登陆判断权限,指向,指定页面****/
		    FLEA::loadClass('TMIS_Controller');
		    $m=FLEA::getSingleton('Model_Jichu_Gongxu');
		    $mfunc= FLEA::getSingleton('Model_Acm_Func');
		    if(isset($_POST['gongxuId'])) {
			$arr=$m->find(array('id'=>$_POST['gongxuId']));
			//工序名
			$_POST['gongxuName']=$arr['gongxuName'];
			$func=$mfunc->find(array(array('funcName',"%{$arr['gongxuName']}登记%",'like')));
			//dump($func);exit;
			//判断权限
			if(TMIS_Controller::authCheck($func['id'],true)) {
			    if($func['id']==112) {
				$controller='Plan_Dye4Tuijuan';
			    }
			    else if($func['id']==117) {
				    $controller='Plan_DyeOfRs';
				}
				else if($func['id']==114) {
					$controller='Plan_DyeOfQcl';
				    }
				    else {
					$controller='Plan_Dye';
				    }
			    $url=url($controller,'DoTask',array('gongxuName'=>$_POST['gongxuName'],'kind'=>'1'));
			}
			else {
			    js_alert('您没有此权限!!','',$this->_url('index2'));break;
			}

		    }
		    include redirect($url);
		}

	    }
	}
	while (false);
	// 登录发生错误，再次显示登录界面

	$ui =& FLEA::initWebControls();
	redirect($this->_url('index2'));

    //include(APP_DIR . '/Template/Login.tpl');
    }

    #登陆
    function actionLogin() {
		do {
			$eqLogin =& FLEA::getSingleton('Model_Login');
			$user = $eqLogin->findByUsername($_POST['username']);
			if (!$user) {
				$msg = "无效用户名";
				break;
			}
			$userId = $user[id];
			$realName = $user[realName];

			//判断密码是否正确，如果该用户拥有动态密码口令的则会追加验证。
			$result = false;
			if ($user['sn']){
				$_POST['password'] = $_POST['password'].$_POST['sn'];	
				$result = $eqLogin->checkPasswordSn($_POST['password'], $user[$eqLogin->passwordField], $_POST['username']);
			}else{
				$result = $eqLogin->checkPassword($_POST['password'], $user[$eqLogin->passwordField]);
			}
			if (!$result){
				$msg = "无效密码";
				break;
			}

			$_SESSION['LANG'] = $_POST['language'];
			$_SESSION['USERID'] = $userId;
			$_SESSION['REALNAME'] = $realName;
			$_SESSION['USERNAME'] = $_POST['username'];

			redirect(url('Main'));
		}
		while (false);

		// 登录发生错误，再次显示登录界面
		$ui =& FLEA::initWebControls();
		redirect($this->_url('index'));
	}

	/**显示验证码*/
	function actionImgCode() {
		$imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
		$imgcode->image();
	}

	#客户登陆
	function actionClientLogin() {
		$clientName = $_POST[clientName];
		$clientPassword = $_POST[clientPassword];
		$mClient = &FLEA::getSingleton('Model_Jichu_Client');
		$rowClient = $mClient->findByField('loginName', $clientName);
		if ($rowClient) {
			if ($clientPassword == $rowClient[loginPsw]) {
				redirect(url('Public_Search','ClientSearch', array(clientId=>$rowClient[id]))); exit;
			}else{
				$msg = "无效密码";
			}
		}else{
			$msg = "无效用户名";
		}
		js_alert($msg,'', 'Index.php');
	}
}


?>