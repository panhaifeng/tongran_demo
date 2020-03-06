<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :Jeff
*  FName  :Response.php
*  Time   :2014/05/13 18:31:40
*  Remark :api接口的请求类
\*********************************************************************/
class Controller_Point_Rpc{

    public $_timeout = 30;
    public $taskname = '';  // 请求任务名称

    function __construct() {
        $this->certConf = 'Config/config.point.php';
        $this->base = 'http://sev1.eqinfo.com.cn/point_server/';
        // $this->base = 'http://192.168.1.65/point_server/';
        $this->api_url = $this->base.'api.php';
        $this->token   = 'br172bA2hMmJn09d0r7frG4fo4o7zgb0c6U21ca4gQ35gb5zf6';
        $this->getCompCode();
    }

    //获取公司编号
    function getCompCode(){
        if(file_exists($this->certConf)){
            require($this->certConf);
        }else{
            $code = md5(FLEA::getAppInf('compName').time());
            $data = <<<controller
<?php
    \$compCode = '{$code}';
controller;
            if (safe_file_put_contents($this->certConf, $data)) {
                require($this->certConf);
            } else {
               return false;
            }
        }

        $this->compCode = $compCode;
        $this->compName= FLEA::getAppInf('compName');
    }

    /**
     * @desc ：调用门店宝api
     * @author li 2015/09/29 16:11:38
     * @param params
     * @return 返回值类型
    */
    function api_caller($params = array()) {
        $array = array(
            'compCode'  =>$this->compCode,
            'compName'  =>$this->compName,
            'version'   =>'v1',
            'timestamp' =>time(),
        );
        $params = array_merge($params , $array);

        //签名
        $params['sign'] = self::gen_sign($params ,$this->token);

        $res = self::_post($params ,$this->api_url);
        return $res;
    }

    //post
    public function _post($data, $url ,&$errorCode)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上, 0为直接输出屏幕，非0则不输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
        //为了支持cookie
        //curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //curl_excc会输出内容，而$result只是状态标记
        $response = curl_exec($ch);
        $errorCode = curl_errno($ch);
        //释放curl句柄
        curl_close($ch);

        if(0 !== $errorCode) {
            return false;
        }

        return $response;
    }

    /**
     * 签名处理
     * Time：2017/04/26 09:02:38
     * @author li
    */
    private function gen_sign($params){
        $str_key_value = $this->assemble($params);
        return strtoupper(md5(strtoupper(md5($str_key_value)).$this->token));
    }

    /**
     * 字符串处理
     * Time：2017/04/26 09:02:38
     * @author li
    */
    private function assemble($params)
    {
        if(!is_array($params))  return null;
        ksort($params, SORT_STRING);
        $sign = '';
        foreach($params AS $key=>$val){
            if(is_null($val))   continue;
            if(is_bool($val))   $val = ($val) ? 'true' : 'false';
            $sign .= $key . (is_array($val) ? $this->assemble($val) : $val);
        }
        return $sign;
    }

    /**
     * 获取请求接口的id
     * Time：2016/10/11 16:05:34
     * @author li
    */
    private function gen_uniq_process_id(){
        $_rand = rand(100000,999999);
        $rpc_id = uniqid().$_rand;
        return $rpc_id;
    }

    /**
     * 超时时间设置
     */
    public function set_timeout($timeout) {
        $this->_timeout = $timeout;
    }

    /**
     * 设置请求任务的名字
     */
    public function set_taskname($taskname) {
        $this->taskname = $taskname;
    }
}