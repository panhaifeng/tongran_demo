<?php
class Api_Lib_Rsp_UniApp_Pop {

    function __construct() {
        $this->_config = array(
            'clientList'  =>'clientList',
        );
    }

    /**
     * 页面获取数据的入口方法
     * Time：2019/11/13 08:48:31
     * @author li
     * @param 参数类型
     * @return 返回值类型
    */
    function getData($params = array(),& $service){
        if(!$params['dataKey']){
            $service->send_user_error('dataKey not found');
        }

        //判断当前的对应方法
        if(!isset($this->_config[$params['dataKey']])){
            $service->send_user_error('dataKey not in config');
        }

        //判断是否配置再其他class中，如果是需要调用其他类
        $pos = strpos($this->_config[$params['dataKey']], '@');
        if($pos > 0){
            list($ctl ,$action) = explode('@', $this->_config[$params['dataKey']]);
            $class = FLEA::getSingleton($ctl);
            $data = $class->$action($params);
        }else{
            $action = $this->_config[$params['dataKey']] ? $this->_config[$params['dataKey']] : $params['dataKey'];
            $data = $this->$action($params);
        }
        //获取页面的配置

        return $data;
    }

    //测试数据
    function clientList($params){
        $search = json_decode($params['searchParams'] ,true);
        if(!$search)$search = array();
        $params = array_merge($params ,$search);

        $class = FLEA::getSingleton('Api_Lib_Rsp_Uni');
        $list = $class->getCList($params);

        //处理其他配置
        //展示的主要内容
        $params = array(
            'value' =>'cid',
            'text'  =>'compName',
            'title' =>'客户列表',
            'show'  =>array(
                // 'compName' =>'客户名称',
                // 'compCode' =>'客户编号',
                // 'people'   =>'联系人',
                // 'mobile'   =>'手机',
                // 'email'    =>'邮箱',
            ),
        );
        $list['params'] = $params;

        return $list;
    }
}
?>