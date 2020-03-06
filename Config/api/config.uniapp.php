<?php
    //签名加密+yan
    $CERTI_KEY = 'Qpa72bVihMge9d0j1frG4fL4o7gbrc6N21ca4pQ35gbuzd4';
    $GEN_SIGN = "Api_Lib_Rsp_UniApp_genSign"; //定义一个类,里面需要实现gen_sign方法作为签名方法
    //方法映射
    $api_array = array(
        // 测试
        'uni.test'=>array('class'=>'Api_Lib_Rsp_Uni','method'=>'runTest','title'=>'test'),
        'uni.login'=>array('class'=>'Api_Lib_Rsp_Uni','method'=>'loginInfo','title'=>'登录验证'),
        'uni.getSwiperImages'=>array('class'=>'Api_Lib_Rsp_UniApp_Home','method'=>'getSwiperImages','title'=>'轮播图'),
        'uni.getClientList'=>array('class'=>'Api_Lib_Rsp_Uni','method'=>'getClientList','title'=>'客户列表数据'),
        'uni.page.build'=>array('class'=>'Api_Lib_Rsp_UniApp_Page','method'=>'pageBuild','title'=>'测试表单配置'),
        'uni.image.upload'=>array('class'=>'Api_Lib_Rsp_Image','method'=>'uploadImg','title'=>'图片上传通用'),
        'uni.image.upload.scan'=>array('class'=>'Api_Lib_Rsp_Image','method'=>'scanCard','title'=>'上传名片并识别'),
        'image.file.upload'=>array('class'=>'Api_Lib_Rsp_Image','method'=>'uploadImg','title'=>'图片上传通用'),
        'uni.autocomplete.get.data.list'=>array('class'=>'Api_Lib_Rsp_UniApp_Autocomplete','method'=>'getData','title'=>'获取demoform中autocomplete数据的接口，通用'),
        'uni.pop.get.list'=>array('class'=>'Api_Lib_Rsp_UniApp_Pop','method'=>'getData','title'=>'获取demoform中autocomplete数据的接口，通用'),
        'login.user.mp' =>array(
            'class'  =>'Api_Lib_Rsp_Login',
            'method' =>'loginMp',
            'title'  =>'小程序专用接口,获取对应个新信息',
            'params' =>array(
                'userinfo' => array('title'=>'用户信息','type'=>'json'),
                'provider' => '平台名称',
            ),
        ),
        'login.bind.mp' =>array(
            'class'  =>'Api_Lib_Rsp_Login',
            'method' =>'bindMpCode',
            'title'  =>'小程序专用接口,绑定二维码',
            'params' =>array(
                'code' => array('title'=>'条码信息','type'=>'json'),
            ),
        ),
        'login.logout' =>array(
            'class'  =>'Api_Lib_Rsp_Login',
            'method' =>'loginout',
            'title'  =>'退出'
        ),
        'menu.list.get' =>array(
            'class'  =>'Api_Lib_Rsp_Login',
            'method' =>'getMenu',
            'title'  =>'获取首页的菜单项目',
        ),
        'userinfo.openid.check' =>array(
            'class'  =>'Api_Lib_Rsp_Login',
            'method' =>'checkUser',
            'title'  =>'检查小程序的openid是否解绑',
        ),
        'uni.gx.list' =>array(
            'class'  =>'Api_Lib_MiniPro',
            'method' =>'getGxList',
            'title'  =>'获取工序列表',
        ),
        
        'uni.output.people' =>array(
            'class'  =>'Api_Lib_MiniPro',
            'method' =>'getOutPeople',
            'title'  =>'获取报工人员',
        ),
        'barcode.detail.get' =>array(
            'class'  =>'Api_Lib_MiniPro',
            'method' =>'barcodeDetail',
            'title'  =>'条码信息',
        ),
        'uni.output.save' =>array(
            'class'  =>'Api_Lib_MiniPro',
            'method' =>'outputSave',
            'title'  =>'条码信息',
        ),
        'uni.order.process' =>array(
            'class'  =>'Api_Lib_MiniPro',
            'method' =>'getOrderProcess',
            'title'  =>'条码信息',
        ),
        'get.data.order'   =>array(
            'class'  =>'Api_Lib_MiniPro',
            'method' =>'getOrderData',
            'title'  =>'获取订单数据信息',
        ),
    );

?>