<?php
return array(
	'systemName' => '易奇信息管理系统',
	'versionNum' => 'V3.0',
	'compName'=> '南通苏彩坊纺织科技有限公司',
	'pageSize' => 20,
	'webControlsExtendsDir' => APP_DIR . '/TMIS/WebControlsExt',
	'day'=>27,//每月的结账日期
    'dbDSN' => array(
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'login'     => 'root',
        'password'  => 'eqinfo',
        'database'  => 'tongran_dongyang_wujin'
    ),

	#定义目录结构
	'menu'=>array(
		'仓库管理'=>array(
			'五金仓库'=>array(
				'库存初始化'=>url('Cangku_kucun','init'),
				'入库登记'=>url('Cangku_Ruku','add'),
				'入库查询'=>url('Cangku_Ruku','right'),
				'出库登记'=>url('Cangku_Chuku','add'),
				'出库查询'=>url('Cangku_Chuku','right'),
				'库存查询'=>url('Cangku_Kucun','right'),
				'收发存月报表'=>url('Cangku_Kucun','month')
			)
		),
		'基础资料'=>array(
			'基础资料'=>array(
				'五金档案'=>url('JiChu_Ware','right'),
				'领料部门设置'=>url('JiChu_Department','right'),
				'供应商档案'=>url('JiChu_Supplier','right'),
				'员工档案'=>url('JiChu_Employ','right'),
				'人员设置'=>url('JiChu_Employkind','right')
			)
		),
		/*'系统设置'=>array(
			'权限管理'=>array(
				'用户管理'=>url('Acm_User','right'),
				'组管理'=>url('Acm_Role','right'),
				//'模块管理'=>url('Acm_Func','right'),
				'权限设置'=>url('Acm_Func','SetQx')
			),
			'密码修改'=>array(
				'修改密码'=>url('Acm_User','ChangePwd')
			)
		)*/
	),

	'view' => 'FLEA_View_Smarty',
    'viewConfig' => array(
        'smartyDir'         => APP_DIR . '/../Smarty',
        'template_dir'      => APP_DIR . '/Template',
        'compile_dir'       => APP_DIR . '/../../_Cache/Smarty',
        'left_delimiter'    => '{',
        'right_delimiter'   => '}',
    ),


	/**
     * 应用程序标题
     */
    'appTitle' => 'FleaPHP EqDeport',

    /**
     * 指定默认控制器
     */
    'defaultController' => 'Index',


    /**
     * 指示默认语言
     */
    'defaultLanguage' => 'chinese-utf8',

    /**
     * 上传目录和 URL 访问路径
     */
    //'uploadDir' => UPLOAD_DIR,
    //'uploadRoot' => UPLOAD_ROOT,

    /**
     * 缩略图的大小、可用扩展名
     */
    'thumbWidth' => 166,
    'thumbHeight' => 166,
    'thumbFileExts' => 'gif,png,jpg,jpeg',

    /**
     * 商品大图片的最大文件尺寸和可用扩展名
     */
    'photoMaxFilesize' => 1000 * 1024,
    'photoFileExts' => 'gif,png,jpg,jpeg',

    /**
     * 使用默认的控制器 ACT 文件
     *
     * 这样可以避免为每一个控制器都编写 ACT 文件
     */
    //'defaultControllerACTFile' => dirname(__FILE__) . '/Lib/App/Controller/Login.act.php',

    /**
     * 必须设置该选项为 true，才能启用默认的控制器 ACT 文件
     */
    //'autoQueryDefaultACTFile' => true,


	'internalCacheDir' => APP_DIR . '/../../_Cache/Fleaphp',
);
?>