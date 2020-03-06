<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :Jeff
*  FName  :
*  Time   :2014/05/13 18:31:40
*  Remark :用curl模拟http请求,用来访问api,一般在api的调用方被包含
\*********************************************************************/
class Api_Httprequest{
    
    //post方式提交数据,注意post_data不能有嵌套的数组
    public function post($post_data,$url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        //设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上, 0为直接输出屏幕，非0则不输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //为了支持cookie
        //curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        /*
        // POST数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        */
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        //curl_excc会输出内容，而$result只是状态标记
        $result = curl_exec($ch);
        $errorCode = curl_errno($ch);
        //释放curl句柄
        curl_close($ch);
        if(0 !== $errorCode) {
            return false;
        }
        // $result = ob_get_contents();
        // ob_end_clean();
        return $result;
        return json_decode($result,true);
    }
    
    function get($query,$url)
    {
        $info = parse_url($url);#print_r($info);exit;
        $fp = fsockopen($info["host"], 80, $errno, $errstr, 3);
        $head = "GET ".$info['path']."?".$info["query"]." HTTP/1.0\r\n";
        $head .= "Host: ".$info['host']."\r\n";
        $head .= "\r\n";
        $write = fputs($fp, $head);
        while (!feof($fp))
        {
            $line = fread($fp,4096);
            echo $line;
        }
    }
}
?>