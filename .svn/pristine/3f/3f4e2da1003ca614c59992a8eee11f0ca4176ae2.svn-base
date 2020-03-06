<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Point_Point extends TMIS_Controller {

    // /构造函数
    function __construct() {
        $this->rpc = FLEA::getSingleton('Controller_Point_Rpc');
    }

    //免登陆跳转积分地址查看明细
    function actionLocation(){
        $userInfo = $this->userInfo();
        $keyTel = 'tel';
        $url = $this->rpc->base . 'index.php?controller=Home_Login&action=LoginAuto';
        if($userInfo[$keyTel]){
            //生成地址
            $time = time();
            $string = $userInfo[$keyTel].$time;
            $token = $this->signLogin($string);
            $url .= "&tel=".$userInfo[$keyTel];
            $url .= "&time=".$time;
            $url .= "&token=".$token;

            //是否需要先签到
            if($_GET['sign'] == 'true'){
                $this->uploadPoint('LOGIN_SIGN');
            }
            header('location:'.$url);
        }else{
            $url2 = url('Acm_User','InfoPerfect',array('from'=>$this->_url('Location',array('sign'=>'true'))));
            js_alert('','if(confirm("您还没有完善手机号，现在完善？")){window.location.href="'.$url2.'"}else{window.location.href="'.$url.'"}');exit;
        }
    }

    function signLogin($string){
        return md5($string.'易奇云积分');
    }

    //登录积分的入口
    function actionRunSign(){
        if(!$_SESSION['USERID'] || !$_SESSION['USERNAME']){
            echo json_encode(array('succ'=>false,'msg'=>'需要登录'));
            exit;
        }
        $result = $this->uploadPoint('LOGIN_SIGN');
        // echo $result;exit;

        //获取最新的积分
        $html = '请完善个人信息';
        $user = $this->userInfo();
        // if($user['tel']){
            $newPoint = $this->getPoint($user['tel'],$user['realName']);
            $result = json_decode($newPoint ,1);
            // dump($result);exit;
            $html = $result['data']['html'] ? $result['data']['html'] : '个人经验('.$result['data']['experience'].")&nbsp;&nbsp;企业经验(".$result['data']['comp_experience'].')';
        // }

        echo json_encode(array('html'=>$html));
        exit;
    }

    //登录积分的入口
    function actionRunInit(){
        if(!$_SESSION['USERID'] || !$_SESSION['USERNAME']){
            echo json_encode(array('succ'=>false,'msg'=>'需要登录'));
            exit;
        }
        $sql = "SHOW TABLES LIKE 'jifen_user'";
        //判断是否存在老的积分表
        $model = FLEA::getSingleton('Model_Acm_User');
        $res = $model->findBySql($sql);
        if(count($res) > 0){
            $sql = "select jifen,id from jifen_user where userCode='{$_SESSION['USERNAME']}' order by remoteUserId desc limit 0,1";
            $res = $model->findBySql($sql);
            $row = $res[0];
            $point = $row['jifen']+0;
            // echo $point;
            if($point){
                //查找该用户是否有初始积分
                $result = $this->uploadPoint('INIT' ,$point);
                $result = json_decode($result ,1);
                //初始化完成的则不需要初始化了
                if($result['data']['succ'] == 'true'){
                    $sql = "update jifen_user set jifen=jifen-{$point} where id='{$row['id']}'";
                    $model->execute($sql);
                }
                echo json_encode($result['data']);
                exit;
            }
        }else{
            echo json_encode(array('succ'=>false,'msg'=>'没有需要初始化的数据'));
            exit;
        }

    }

    /**
     * 上传积分
     * Time：2018/08/07 14:57:26
     * @author li
     * type LOGIN_SIGN登录签到|INIT初始化
    */
    function uploadPoint($type = '' ,$point){
        if(!$type)return false;
        $day = date('Y-m-d');
        $method = 'point.upload';
        $userInfo = $this->userInfo();
        if($userInfo){
            $model = FLEA::getSingleton('Model_Acm_User');
            //查找对应的角色信息
            $sql = "select y.roleName from acm_user2role x
            inner join acm_roledb y on x.roleId=y.id
            where x.userId='{$userInfo['id']}'";
            $role = $model->findBySql($sql);
            foreach ($role as $key => &$v) {
                $roleName[$v['roleName']] = $v['roleName'];
            }

            $userInfo['roleName'] = join(',',$roleName);
        }

        $tel = $userInfo['tel'] ? $userInfo['tel'] : $userInfo['mobile'];
        $fromUrl = 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/')+1);
        if(!$tel){
            return false;
        }
        $data = array(
            'name'    => $userInfo['realName'],
            'role'    => $userInfo['roleName'],
            'day'     => $day,
            'method'  => $method,
            'type'    => $type,
            'tel'     => $tel,
            'fromUrl' => $fromUrl,
        );

        if($point)$data['point'] = $point;
        // dump($data);exit;

        return $this->rpc->api_caller($data);
    }

    //获取用户信息
    function userInfo(){
        $uid = $_SESSION['USERID'];
        if(!$uid){
            return false;
        }
        $model = FLEA::getSingleton('Model_Acm_User');
        $row = $model->find($uid);
        return $row;
    }


    /**
     * 获取个人和所属企业的积分
     * Time：2018/08/08 09:50:47
     * @author li
    */
    function getPoint($tel='' ,$name){
        // if(!$tel)return false;

        $data = array(
            'method' => 'point.info.get',
            'tel'    => $tel,
            'name'   => $name,
            'type'   => 3,
        );
        return $this->rpc->api_caller($data);
    }
}

?>