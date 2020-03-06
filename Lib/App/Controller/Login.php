<?php
class Controller_Login extends FLEA_Controller_Action
{
    /**
     * 构造函数
     *
     * @return Controller_Default
     */
    function Controller_Login() {
		//echo("languageFilesDir");
		//die(dirname(__FILE__));
		//load_language('ui');
    }

    /**
     * 显示登录界面
     */
    function actionIndex() {
        require_once('Config/NewLogin_config.php');
        // dump($_login_config);die;
        $login = $_login_config;
        $_login = $_login_config['Login'];
        $_login_Ip = $_login_config['Login_Ip'];
        $_outTime = $_login_config['timeOut'];

        //如果设置了远程地址,获取远程数据，
        if($_login_Ip!=''){
            $_Url = str_replace(PHP_EOL, '',$_login_Ip);
            //设置超时时间
            $context['http'] = array(
                'timeout'=>$_outTime > 0 ? $_outTime : 3,
                'method' => 'POST'
            );
            $json = file_get_contents($_Url, false, stream_context_create($context));
            $_l = json_decode($json,true);
            if($_l['success']){
                $login = $_l['config'];
            }
        }
        $smarty = & $this->_getView();
        $login['btnColor']=substr($login['btnColor'],-7);
        FLEA::writeCache('Service.Tel',$login['servTel']);
        $smarty->assign('login',$login);
		$smarty = & $this->_getView();
		$smarty->display('LoginNew.tpl');
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
        //$ui =& FLEA::initWebControls();
        header("Location:Index.php");
    }

    /**
     * 登录
     */
    function actionLogin() {
        //$imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
        /* @var $imgcode FLEA_Helper_ImgCode */
        do {
            $p=$_POST?$_POST:$_GET;
            $_ajax = $p['is_ajax'];
            if(!isset($p['username'])) break;
            /*if (!$imgcode->check($_POST['imgcode'])) {
				$msg = "验证码不对";
                break;
            }
            $imgcode->clear();
			*/
            /*验证用户名和密码是否正确*/
            $eqLogin =& FLEA::getSingleton('Model_Login');
            $user = $eqLogin->findByUsername($_POST['username']);
            if (!$user) {
                $msg = "无效用户名";
                if($_ajax){
                    echo json_encode(array('success'=>false,'msg'=>$msg));
                }
                else{
                    js_alert($msg,null,$this->_url('index'));
                }
                exit;
            }
			$userId = $user[id];
			$realName = $user[realName];

            if (!$eqLogin->checkPassword($_POST['password'], $user[$eqLogin->passwordField])) {
                $msg = "无效密码";
                if($_ajax){
                    echo json_encode(array('success'=>false,'msg'=>$msg));
                }
                else{
                    js_alert($msg,null,$this->_url('index'));
                }
                exit;
            }

            //判断是否需要验证扫码认证身份
            //如果是开发者，则不需要验证：：
            $isVerify = $user['qrCodeVerify'];//是否需要验证的判断依据
            $ipWhilte = array('localhost' ,'127.0.0.1');
            // if(in_array($_SERVER['SERVER_NAME'], $ipWhilte)){
            //     $isVerify = 0;
            // }

            //如果需要验证，则跳转到身份验证区域，session放临时区域
            if($isVerify == 1){
                $_SESSION['LOGIN_VERIFY_TEMP']['USERID']   = $userId;
                $_SESSION['LOGIN_VERIFY_TEMP']['REALNAME'] = $realName;
                $_SESSION['LOGIN_VERIFY_TEMP']['USERNAME'] = $p['username'];
                $_SESSION['LOGIN_VERIFY_TEMP']['PHP_SELF'] = $_SERVER['PHP_SELF'];
                if($_ajax){
                    echo json_encode(array('success'=>true,'href'=>$this->_url('QrCodeVerify')));exit;
                }
                else{
                    redirect($this->_url('QrCodeVerify'));
                }
            }

            //验证结束


            /*登录成功，通过 RBAC 保存用户信息和角色*/
            $_SESSION['LANG'] = $_POST['language'];
			$_SESSION['USERID'] = $userId;
			$_SESSION['REALNAME'] = $realName;
			$_SESSION['USERNAME'] = $_POST['username'];

			//echo('----------------'.$_POST['username']); exit();
			if ($_POST['username'] == 'wgh') {
				include(APP_DIR . '/Template/MainWgh.tpl'); exit;
				//redirect(url('Main', 'mainSimple'));
			}
			else {
                if($_ajax){
                    echo json_encode(array('success'=>true,'href'=>url('Main')));exit;
                }
                else{
                    redirect(url('Main'));
                }
            }
        }
        while (false);
        // 登录发生错误，再次显示登录界面
		//$ui =& FLEA::initWebControls();
		redirect($this->_url('index'));
        //include(APP_DIR . '/Template/Login.tpl');
    }

    /**显示验证码*/
    function actionImgCode() {
        $imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
        $imgcode->image();
    }

	#客户登陆
	function actionClientLogin() {
		//dump($_POST);
		$clientName = $_POST[clientName];
		$clientPassword = $_POST[clientPassword];
		$mClient = &FLEA::getSingleton('Model_JiChu_Client');
		$rowClient = $mClient->findByField('loginName', $clientName);
		if ($rowClient) {
			if ($clientPassword == $rowClient[loginPsw]) {
				redirect(url('Public_Search','ClientSearch', array(clientId=>$rowClient[id]))); exit;
			}
			else $msg = "无效密码";
		}
		else $msg = "无效用户名";
		//echo($msg); exit;
		js_alert($msg,'', 'Index.php');

	}

    /**
     * @desc ：创建桌面快捷方式
     * Time：2016/09/01 15:59:33
     * @author Wuyou
    */
    function actionCreateshortcuts(){
        // dump($_POST);exit;
        $Shortcut = "[InternetShortcut]
        URL={$_POST['furl']}
        IDList=
        [{000214A0-0000-0000-C000-000000000046}]
        Prop3=19,2";
        $filename = urlencode($_POST['fname']);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$filename}.url");
        echo $Shortcut;
    }
    #打包系统登陆的处理接口
    //注意，输出的json都是带bom头的，必须要在前台进行处理去掉bom头
    function actionDabaoLogin() {
        $m = & FLEA::getSingleton('Model_Jichu_Client');
        $sql = "select * from acm_userdb where userName='{$_POST['userName']}'";
        $rows = $m->findBySql($sql);

        if(count($rows)==0) {
            echo json_encode(array('success'=>false,'msg'=>'用户名不存在'));
            exit;
        }

        $user = $rows[0];
        if($_POST['passwd']!=$user['passwd']) {
            echo json_encode(array('success'=>false,'msg'=>'密码错误'));
            exit;
        }
        echo json_encode(array(
            'success'=>true,
            'msg'=>'',
            'userName'=>$user['userName'],
            'realName'=>$user['realName']
        ));
        exit;

        //成功返回1
        //$arr = array('success'=>true,'msg'=>'','user'=>array('userName'=>'admin','realName'=>'管理员'));
        //echo json_encode($arr);exit;
        //echo json_encode(array('success'=>false,'msg'=>'登陆失败1'));

    }

    /**
     * @desc ：二维码验证页面
     * Time：2019/07/15 16:42:40
     * @author Wuyou
    */
    function actionQrCodeVerify(){
        // 生成token信息记录
        $m = FLEA::getSingleton('Model_Acm_Qrcodeverify');
        $token = $m->createRecord($_SESSION['LOGIN_VERIFY_TEMP']['USERNAME']);
        // 删除今天之前的token记录：这些数据属于过期未删除数据，清理后方便系统维护和提高性能
        $timeToday = strtotime(date('Y-m-d'));
        $m->removeByConditions("timestamp < '{$timeToday}'");

        // 二维码图片地址获取
        $qrCodePath = $this->_createQrcode($token);
        // dump($qrCodePath);

        // $login['bg64'] = 'Resource/Image/LoginNew/qrCode_bg.jpg';
        $smarty = & $this->_getView();
        $smarty->assign('login',$login);
        $smarty->assign('token',$token);
        $smarty->assign('mainUrl',url('Main'));
        $smarty->assign('qrCodePath',$qrCodePath);
        $smarty->display('QrcodeVerify.tpl');
    }

    /**
     * @desc ：获取扫码状态
     * Time：2019/07/17 10:20:42
     * @author Wuyou
    */
    function actionGetStatusByAjax(){
        $m = FLEA::getSingleton('Model_Acm_Qrcodeverify');
        $break = false;
        $i = 0;
        while (($break == false && $i <= 6)) {
            $i++;
            $arr = $m->find(array('token'=>$_GET['token']));
            // 如果为创建和已扫码状态的二维码，且时长超过60s，则状态为超时
            if($arr['status']=='CREATED' || $arr['status']=='SCANED'){
                $time = time() - $arr['timestamp'];
                if($time > 60){
                    $arr['status'] = 'OVERTIME';
                    $break = true;
                }else{
                    //暂停500毫秒
                    usleep(500000);
                }
            }elseif($arr['status']=='SUCCESS'){
                $_SESSION['USERID']   = $_SESSION['LOGIN_VERIFY_TEMP']['USERID'];
                $_SESSION['REALNAME'] = $_SESSION['LOGIN_VERIFY_TEMP']['REALNAME'];
                $_SESSION['USERNAME'] = $_SESSION['LOGIN_VERIFY_TEMP']['USERNAME'];
                $_SESSION['PHP_SELF'] = $_SESSION['LOGIN_VERIFY_TEMP']['PHP_SELF'];
                unset($_SESSION['LOGIN_VERIFY_TEMP']);

                //更改登录时间
                $eqLogin = FLEA::getSingleton('Model_Login');
                $re = $eqLogin->changeLoginTime($_SESSION['USERID']);
                $break = true;
            }
        }
        echo json_encode(array('success'=>true,'verifyInfo'=>$arr));exit;
    }

    /**
     * @desc ：重新获取二维码
     * Time：2019/07/18 14:47:14
     * @author Wuyou
    */
    function actionRefreshQrcode(){
        if(!$_GET['token']){
            echo json_encode(array('success'=>false));exit;
        }
        $ret = array();
        // 生成token信息记录
        $m = FLEA::getSingleton('Model_Acm_Qrcodeverify');
        $ret['token'] = $m->createRecord($_SESSION['LOGIN_VERIFY_TEMP']['USERNAME']);
        // 删除老的token记录
        $m->removeByConditions(array('token'=>$_GET['token']));
        // 获取二维码图片地址
        $ret['qrCodePath'] = $this->_createQrcode($ret['token']);

        echo json_encode(array('success'=>true,'data'=>$ret));exit;
    }

    /**
     * @desc ：服务端生成二维码
     * Time：2019/07/22 15:50:37
     * @author Wuyou
     * @param   1.compCode 项目编号，参考demo代码或者积分使用的代码
                2.compName compInfo中配置的公司名称
                3.userName 需要绑定的帐号
                4.token 当前处理的token，对应到某次请求的唯一码
                5.fromUrl 当前项目的url地址 如 http://sev7.eqinfo.com.cn/demo_project  后面的/及index.php都不需要
     * @return 二维码图片url
    */
    function _createQrcode($token){
        $url = 'http://changzhouhaige.cn/login-verify-wechat/index.php?controller=Apply_Index&action=Qrcode';

        $m = FLEA::getSingleton('Model_Acm_Qrcodeverify');
        $arr = $m->find(array('token'=>$token));

        $params = array(
            'fromUrl'  =>$arr['projectAdd'],
            'userName' =>$arr['userName'],
            'compCode' =>$arr['compCode'],
            'compName' =>FLEA::getAppInf('compName'),
            'token'    =>$arr['token'],
        );
        $query = http_build_query($params);
        $url .= "&".$query;
        return $url;
    }
}


?>