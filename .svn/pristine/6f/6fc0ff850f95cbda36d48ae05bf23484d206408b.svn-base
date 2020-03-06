<?php
/*********************************************************************\
*  Copyright (c) 2007-2019, TH. All Rights Reserved.
*  Author :Shen
*  FName  :Api_Lib_Rsp_UniApp_genSign.php
*  Time   :2019年9月30日
*  Remark :UniApp需要用的签名算法，简化
\*********************************************************************/
class Api_Lib_Rsp_UniApp_genSign {

    //加密算法
    public function gen_sign($params=array() ,$token = '' ,& $service)
    {

        $tmpStr = $params['timestamp'] . '&' . $params['method'] . '&' . $params['version'] . '&' . $token;
        if($params['sid']){
            $tmpStr .= "&".$params['sid'];
        }
        if($params['openid']){
            $tmpStr .= "&".$params['openid'];
        }
        if($params['userId']){
            $tmpStr .= "&".$params['userId'];
        }

        return md5($tmpStr);
    }


}
?>