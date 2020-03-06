<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Main extends TMIS_Controller
{
	function Controller_Main() {
		$this->_modelExample = & FLEA::getSingleton('Model_Index');
	}

    function actionIndex() {
		//$ui =& FLEA::initWebControls();
		if ($_GET['menuName']) $_SESSION['MENUNAME'] = $_GET['menuName'];
		if (!$_SESSION['REALNAME']) {
			redirect(url("Login"));	exit;
		}
		$smarty =& $this->_getView();
		$smarty->display('Main.tpl');
    }

	function actionTop() {
		//$ui =& FLEA::initWebControls();
		$f = & FLEA::getAppInf('menu');
        include $f;
		$smarty =& $this->_getView();
		if ($_SESSION['REALNAME'] != "") $realName = $_SESSION['REALNAME'];
		else $realName = "未登陆";
		$smarty->assign('real_name', $realName);
		$smarty->assign('menu', $_sysMenu['menu']);
		$smarty->display('MainTop.tpl');
    }

	function actionLeftMenu() {
		$f = & FLEA::getAppInf('menu');
        include $f;
		$smarty = & $this->_getView();
		$smarty->assign('menu', $_sysMenu['menu']);
        $smarty->display('MainLeft.tpl');
    }

	function actionContent() {
		$_modelExample = & FLEA::getSingleton('Model_Index');
		$rowset1 =$_modelExample->findAll("classId=6","dt desc","10");
		$rowset2 =$_modelExample->findAll("classId=2","dt desc","5");
		$rowset3 =$_modelExample->findAll("classId=3","dt desc","5");
		$rowset4 =$_modelExample->findAll("classId=4","dt desc","5");
		$rowset5 =$_modelExample->findAll("classId=5","dt desc","5");

		//通讯录
		$tongxun= & FLEA::getSingleton('Model_Jichu_Tongxun');
		$temp=$tongxun->findAll(null,null,9);
		$temp[]=array(
			'proName'=>'点击查看',
			'tel'=>'<a href="'.url("Jichu_Tongxun","Right").'">更多</a>'
		);
		$i=0;
		foreach($temp as $key=>$v){
			if($key % 2==0 && $key!=0){
				$i++;
			}
			$rowset6[$i][]=$v;
		}
		// 取得老板驾驶舱的配置信息
		$canShowBoss = $this->getBossReportParam();
		//dump($temp);exit;
		$smarty = & $this->_getView();
		$pk = $_modelExample->primaryKey;

		$arr_field_info = array(
			"title" =>"标题",
			"buildDate" =>"日期"
		);

		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('pk', $pk);
		$smarty->assign('arr_field_value1',$rowset1);
		$smarty->assign('arr_field_value2',$rowset2);
		$smarty->assign('arr_field_value3',$rowset3);
		$smarty->assign('arr_field_value4',$rowset4);
		$smarty->assign('arr_field_value5',$rowset5);
		$smarty->assign('arr_field_value6',$rowset6);
		$smarty->assign('isShowBoss',$canShowBoss['isShow']?1:0);
        $smarty->display('Welcome.tpl');
    }

	function actionCalculator() {
		$smarty = & $this->_getView();
    	$smarty->display('Calculator.tpl');
	}


	function actionGetMaintenanceInfo(){
	 	// 易客宝中的客户名称
	    $ykbName = & FLEA::getAppInf('ykbName');
	    $obj_api = FLEA::getSingleton('Api_RequestYkb');
	    if($ykbName){
	    	$r = $obj_api->callApi(array(
	        	'params'=>json_encode(array('compName'=>$ykbName)),
	        	// 'isDebug'=>1
	    	));
	    }
	    $ret = json_decode($r,true);
	    $maintenance['success'] = true;
	    $maintenance['showRemind'] = $ret['data'][0]['expire'];
	    $maintenance['msg'] = $ret['data'][0]['msg'];
	    echo json_encode($maintenance);exit;
	}

		/**
	 * @desc ：查看绑定小程序的二维码
	 * Time：2019年9月2日 10:53:00
	 * @author ShenHao
	*/
	function actionViewMiniCode(){
		//获取小程序二维码
		$miniPro = $this->getMiniUrl();

		$smarty = & $this->_getView();
		$smarty->assign('miniUrl',$miniPro['miniUrl']);
		$smarty->assign('currPro',$miniPro['currPro']);
		$smarty->display('miniCode.tpl');
	}
	/**
	 * @desc ：生成二维码的token
	 * Time：2019年9月2日 10:53:00
	 * @author ShenHao
	*/
	function QrcodeToken($userName,$projectAdd,$time){
        $token = sha1($projectAdd.'+'.$userName.'+'.$time);
        return $token;
	}

	/**
	 * ps ：获取小程序二维码
	 * Time：2019-09-03 08:57:53
	 * @author ShenHao
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function getMiniUrl(){
		//获取小程序二维码
		require_once('Config/miniPro_config.php');
		$_service_Ip = $miniPro_config['url_base'];
		$miniUrl = $_service_Ip.'/index.php?controller=Apply_Qrcode&action=MiniQrcode';

        $projectAdd = 'https://'.$_SERVER['SERVER_NAME'].substr($_SERVER['PHP_SELF'], 0, strripos($_SERVER['PHP_SELF'], '/'));
		$compName = FLEA::getAppInf('compName');
		$time = time();
		$token = $this->QrcodeToken($_SESSION['USERNAME'],$projectAdd,$time);
		$currPro = $_service_Ip.'/index.php?controller=Apply_Qrcode&action=Build&platfrom='.$projectAdd.'&userName='.$_SESSION['USERNAME'].'&token='.$token.'&compName='.$compName.'&timestamp='.$time;

		$result = array(
			'miniUrl'=>$miniUrl,
			'currPro'=>$currPro,
		);
		// dump($result);die;
		return $result;
	}

	function actionVerifyQrcodeBuild(){
		require_once('Config/miniPro_config.php');
		$_service_Ip = $miniPro_config['url_base'];
		$miniUrl = $_service_Ip.'/index.php?controller=Apply_Qrcode&action=MiniQrcode';

        $baseurl = detect_uri_base();
        $url = substr($baseurl, 0,strrpos($baseurl, '/') + 1).'apiMini.php';
        $content = array(
            'uid'       =>$_SESSION['USERID'],
            'uname'     =>$_SESSION['USERNAME'],
            'timestamp' =>time(),
            'serverUrl' =>$url,
        );
        $content['token'] = $this->tokenFormat($content);

        // 生成二维码图片
        $qrcodestr = "http://www.eqinfo.com.cn?c=".json_encode($content);

        FLEA::org('phpqrcode/phpqrcode.php');
        $errorCorrectionLevel = 'L';//容错级别
        $matrixPointSize = 4;//生成图片大小
        $qrcode = QRcode::png($qrcodestr,'base64',$errorCorrectionLevel,$matrixPointSize,2);

        //查找当前绑定状态
        $user = $this->_modelExample->find($_SESSION['USERID']);
        $smarty = & $this->_getView();
        // $smarty->assign('qrcodestr',$qrcodestr);
        $smarty->assign('qrcode',$qrcode);
        $smarty->assign('user',$user);
        $smarty->assign('miniUrl',$miniUrl);
        $smarty->assign('title','登录手机端二维码');
        $smarty->display('VerfyQrcode.tpl');
    }

    //验证和生成二维码的token
    function tokenFormat($param = array()){
        $str = $param['timestamp'].'*'.$param['serverUrl'].'*'.$param['uid'].'*'.$param['uname'];
        return md5($str);
    }

    //解除绑定
    function actionBindCannel(){
        $data = array(
            'id'       =>$_SESSION['USERID'],
            'openid'   =>'',
            'unionid'  =>'',
            'nickname' =>'',
        );
        $res = $this->_modelExample->update($data);
        echo json_encode(array('success'=>$res ,'msg'=>'操作完成'));
    }

		// 获得老板驾驶舱显示参数
	function getBossReportParam(){
		$_modelExample = & FLEA::getSingleton('Model_Index');
		// 获得当前角色是否为老板的信息
		$isBoss = 1;
		if($_SESSION['USERNAME']!='admin'){
			$sql = "SELECT * FROM acm_userdb WHERE id = {$_SESSION['USERID']}";
			$user = $_modelExample->findBySql($sql);
			$isBoss = $user[0]['isBoss'];
		}
		// 判断是否可以显示老板驾驶舱
		$days = 0;
		if($isBoss){
			/*2019年9月18日 09:52:59 关闭老板驾驶舱配置信息 by shen
			$bossReport = & FLEA::getAppInf('bossReport');
			if(!$bossReport['isShow']){//判断是否为试用版
				$isShow = false;
			}else{//未使用版则计算剩余使用天数，为0了则不显示
				if($bossReport['isTrialVer']){
					$days = (strtotime($bossReport['tryExpDate']) - strtotime(date('Y-m-d')))/24/3600;
					if($days<=0){
						$isShow = false;
					}else{
						$isShow = true;
					}
				}else{
					$isShow = true;
				}
			}*/
			$isShow = true;
		}else{
			$isShow = false;
		}
		return array('isShow'=>$isShow,'isTrialVer'=>$bossReport['isTrialVer'],'days'=>$days);
	}
}


?>