<?php
return array(
	'systemName' => '易奇信息管理系统',
    'systemV' =>'E7筒染行业版 v3.7',
	'versionNum' => 'V3.7',
	'compName'=> '南通苏彩坊纺织科技有限公司',
	'pageSize' => 20,
    //流转卡打印模板,
	'LiuzhuankaMoBan'=>'DongnanPrintVatCard.tpl',
	//成品发货单打印时使用lodop控件需要使用到的js文件
	'PrintCpck'=>'Cpck/JianliPrintCpck.js',
        //处方单打印时使用模板文件，如设置为JianliPrintVatCard.tpl则为建立的打印模板，PrintVatCard.tpl为原来的模板,DongnanPrintDirectly.tpl为东南的模板
        'PrintChufang'=>'DongnanPrintDirectly.tpl',
	'webControlsExtendsDir' => APP_DIR . '/TMIS/WebControlsExt',

    'dbDSN' => array(
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'login'     => 'root',
        'password'  => 'root',
        'database'  => 'tongran_mini_demo',
       // 'database'  => 'niuzai_kailan',
    ),
    'menu'=>'Config/menu.php',//使用的菜单目录
    //by zcc 定义的目录转移到  Config/menu.php (仿照色织其他版本系统)
	#定义目录结构
	'menuOld'=>array(
		'仓库管理'=>array(
			'染化料仓库管理'=>array(
				'入库登记'=>url('CangKu_Yl_RuKu','right'),
				'退库登记'=>url('CangKu_Yl_RukuTuiku','right'),
				// '库位调拨'=>url('CangKu_Yl_Diaobo','add'),
				// '库位调拨查询'=>url('CangKu_Yl_Diaobo','right'),
				'按处方领料'=>url('CangKu_Yl_ChuKu','right'),
				'领料查询'=>url('CangKu_Yl_ChuKu','right1'),
				'其他出库'=>url('CangKu_Yl_ChuKu','right3'),
				'染料耗用分析'=>url('CangKu_Yl_ChuKu','YlAnalyse'),
				'染料用量日报表'=>url('Gongyi_Dye_Chufang','YlCost'),
				'染化料月报表'=>url('CangKu_Yl_Kucun','Right'),
				'库存调整'=>url('CangKu_Yl_Kucun','ChangeKucun'),
				'库存调整查询'=>url('CangKu_Yl_Kucun','Search'),
				//'助剂月报表'=>url('CangKu_Report_MonthDye','right',array('parentId'=>7)),
				//'染料月报表'=>url('CangKu_Report_MonthDye','right',array('parentId'=>6)),
			),
			'坯纱仓库'=>array(
				"<span class='menu_001'>入库登记</span>"	 =>url('CangKu_RuKu','right',array('rukuTag'=>1)),

				"<span class='menu_001'>退库登记</span>"	 =>url('CangKu_Tuiku','right',array('rukuTag'=>1)),

				"<span class='menu_001'>领料登记</span>"	 =>url('CangKu_ChuKu','ChanliangInput1'),
				"<span class='menu_001'>领料查询</span>"	 =>url('CangKu_ChuKu','right'),
                "<span class='menu_001'>领料统计</span>"	 =>url('CangKu_ChuKu','Tongji'),

                "<span class='menu_001'>预领纱登记</span>"	 =>url('CangKu_Yuling','Add'),
                "<span class='menu_001'>预领纱查询</span>"	 =>url('CangKu_Yuling','Right'),

				"<span class='menu_001'>坯纱日报表</span>"	 =>url('CangKu_Report_Month','reportday'),
				"<span class='menu_001'>坯纱库存报表</span>"	 =>url('CangKu_Report_Month','right1'),
			),
			'本厂坯纱仓库'=>array(
				"<span class='menu_001'>采购登记</span>"	 =>url('CangKu_RuKuBc','right',array('rukuTag'=>1)),
				"<span class='menu_001'>退库登记</span>"	 =>url('CangKu_TuikuBc','right',array('rukuTag'=>1)),
				"<span class='menu_001'>领料登记</span>"	 =>url('CangKu_ChuKuBc','ListforAdd'),
				"<span class='menu_001'>领料查询</span>"	 =>url('CangKu_ChuKuBc','right'),
                "<span class='menu_001'>领料统计</span>"	 =>url('CangKu_ChuKuBc','Tongji'),
				"<span class='menu_001'>坯纱日报表</span>"	 =>url('CangKu_Report_Month','reportdayBc'),
				"<span class='menu_001'>坯纱库存报表</span>" =>url('CangKu_Report_Month','right2'),
			),

			'成品仓库' =>array(
				"<span class='menu_001'>计划查询</span>"	 =>url('Chengpin_Dye_Cpck','OrderSearch'),
				"<span class='menu_001'>成品入库登记</span>"	 =>url('Chengpin_Dye_Cprk','AddGuide'),
				"<span class='menu_001'>成品入库查询</span>"	 =>url('Chengpin_Dye_Cprk','right'),
				"<span class='menu_001'>成品出库（整单）</span>"	 =>url('Chengpin_Dye_Cpck','AddGuide'),
				"<span class='menu_001'>成品出库（自由）</span>"	 =>url('Chengpin_Dye_Cpck','AddGuide2'),
				"<span class='menu_001'>成品出库查询</span>"	 =>url('Chengpin_Dye_Cpck','right'),

				// "<span class='menu_001'>成品退库</span>"	 =>url('Chengpin_Dye_Cpck','TuikuList'),
				// "<span class='menu_001'>成品退库查询</span>"	 =>url('Chengpin_Dye_Cpck','Tuiku'),

                "<span class='menu_001'>成品出库报表</span>"	 =>url('Chengpin_Dye_Cpck','DayReport'),
				"<span class='menu_002'>打印日志</span>"	 =>url('Chengpin_Dye_Cpck','PrintLog'),
			),
			'五金仓库' =>array(
				"<span class='menu_001'>库存初始化</span>"	 =>url('Cangku_Wujin','init'),
				"<span class='menu_001'>入库登记</span>"	 =>url('Cangku_Wujin','Ruku'),
				"<span class='menu_001'>入库查询</span>"	 =>url('Cangku_Wujin','RukuSearch'),
				"<span class='menu_002'>出库登记</span>"	 =>url('Cangku_Wujin','Chuku'),
				"<span class='menu_002'>出库查询</span>"	 =>url('Cangku_Wujin','ChukuSearch'),
				"<span class='menu_002'>库存查询</span>"	 =>url('Cangku_Wujin','Kucun'),
				"<span class='menu_002'>收发存月报表</span>"	 =>url('Cangku_Wujin','Month'),
			),
		),

		'销售管理'=>array(
			'销售管理'=>array(
				"<span class='menu_001'>订单登记</span>"	 =>url('Trade_Dye_Order','right'),
				"<span class='menu_001'>订单查询</span>"	 =>url('Trade_Dye_Order','orderSearch')
			),
			'进度查询'=>array(
				"<span class='menu_001'>计划进度一览表</span>"	 =>url('Public_Search','PlanTrace')
			)
		),

		'生产管理'=>array(
			'公共查询区' =>array(
				"<span class='menu_001'>生产跟踪列表</span>"	 =>url('Public_Search','right0'),
				"<span class='menu_001'>计划进度列表</span>"	 =>url('Public_Search','PlanTrace'),
				"<span class='menu_001'>已排缸查询</span>"	     =>url('Trade_Dye_Order','PlanManage2'),
			),

			'生产计划管理' =>array(
				"<span class='menu_001'>生产计划</span>"		=>url('Trade_Dye_Order','right'),
                                "<span class='menu_001'>排缸任务清单</span>"	 =>url('Trade_Dye_Order','right1',array('display'=>false)),
				"<span class='menu_001'>已排缸查询</span>"	 =>url('Trade_Dye_Order','PlanManage'),
                                "<span class='menu_001'>打印领纱申请</span>"	 =>url('CangKu_ChuKu','Lingliao'),
				"<span class='menu_001'>未染色列表</span>"	 =>url('plan_dye','paigangSchedule1'),
				"<span class='menu_001'>染色排班登记</span>"	 =>url('plan_dye','paigangSchedule'),
				"<span class='menu_001'>染色排班查询</span>"	 =>url('plan_dye','JihuaList'),
				"<span class='menu_001'>并缸查询</span>"	 =>url('plan_dye','SearchBinggang'),
				//"<span class='menu_001'>返修登记</span>"	 =>url('plan_dye','fanxiu'),
				"<span class='menu_001'>回修统计报表</span>"	 =>url('Trade_Dye_Order','HuixiuList')
			),

			'大样处方管理' =>array(
				"<span class='menu_001'>处方登记</span>"	 =>url('Gongyi_Dye_Chufang','right'),
				"<span class='menu_001'>处方查询</span>"	 =>url('Gongyi_Dye_Chufang','list'),
				"<span class='menu_001'>已并缸处方登记</span>"	 =>url('Gongyi_Dye_Chufang','ListBinggang'),
				"<span class='menu_001'>合并处方</span>"	 =>url('Gongyi_Dye_Chufang','merge'),
				"<span class='menu_001'>合并处方查询</span>"	 =>url('Gongyi_Dye_Chufang','listMerge'),
			),


			'产量管理' =>array(
				"<span class='menu_001'>松筒产量登记</span>"	 =>url('Chejian_Songtong','chanliangInput1'),
				"<span class='menu_001'>松筒产量查询</span>"	 =>url('Chejian_Songtong','chanliangList'),
				"<span class='menu_001'>松筒未完成查询</span>" =>url('Chejian_Songtong','Notwanchen'),
				"<span class='menu_001'>松筒产量日报表</span>"	 =>url('Chejian_Songtong','chanliangDayReport'),

				"<span class='menu_001'>装出笼产量登记</span>"	 =>url('Chejian_Zhuangchulong','chanliangInput1'),
				"<span class='menu_001'>装出笼产量查询</span>"	 =>url('Chejian_Zhuangchulong','chanliangList'),
				"<span class='menu_001'>装出笼未完成查询</span>"	 =>url('Chejian_Zhuangchulong','Notwanchen'),
				"<span class='menu_001'>装出笼产量日报表</span>"	 =>url('Chejian_Zhuangchulong','chanliangDayReport'),

				"<span class='menu_001'>染色产量登记</span>"	 =>url('Chejian_Ranse','chanliangInput1'),
				"<span class='menu_001'>染色产量查询</span>"	 =>url('Chejian_Ranse','chanliangList'),
				"<span class='menu_001'>染色未完成查询</span>"	 =>url('Chejian_Ranse','Notwanchen'),
				"<span class='menu_001'>染色产量统计表</span>"	 =>url('Chejian_Ranse','chanliangDayReport'),

				"<span class='menu_001'>烘纱产量登记</span>"	 =>url('Chejian_Hongsha','chanliangInput1'),
				"<span class='menu_001'>烘纱产量查询</span>"	 =>url('Chejian_Hongsha','chanliangList'),
				"<span class='menu_001'>烘纱未完成查询</span>"	 =>url('Chejian_Hongsha','Notwanchen'),
				"<span class='menu_001'>烘纱产量日报表</span>"	 =>url('Chejian_Hongsha','chanliangDayReport'),

				"<span class='menu_001'>回倒产量登记</span>"	 =>url('Chejian_Huidao','chanliangInput1'),
				"<span class='menu_001'>回倒产量查询</span>"	 =>url('Chejian_Huidao','chanliangList'),
				"<span class='menu_001'>回倒未完成查询</span>"	 =>url('Chejian_Huidao','Notwanchen'),
				"<span class='menu_001'>回倒产量日报表</span>"	 =>url('Chejian_Huidao','chanliangDayReport'),

				"<span class='menu_001'>打包产量登记</span>"	 =>url('Chejian_Dabao','chanliangInput1'),
				"<span class='menu_001'>打包产量查询</span>"	 =>url('Chejian_Dabao','chanliangList'),
				"<span class='menu_001'>打包未完成查询</span>"	 =>url('Chejian_Dabao','Notwanchen'),
				"<span class='menu_001'>打包产量日报表</span>"	 =>url('Chejian_Dabao','chanliangDayReport'),

			),


		),

		'财务管理'=>array(
			'应收管理' => array(
				'应收款初始化'	=>url('CaiWu_Ar_Init','right'),
				'订单添加单价'	=>url('Trade_Dye_Order','RightHavePrice'),
				'订单单价修改'	=>url('Trade_Dye_Order','RightHavePrice1'),
				'发票管理'	=>url('CaiWu_Ar_Invoice', 'right'),
				'其他应收登记'	=>url('CaiWu_Ar_Other','right'),
				//'付款凭证审核'	=>url('CaiWu_Af_Invoice', 'checkInvoice'),
				'应收款报表'	=>url('CaiWu_Ar_Report','right')
			),

			'应付管理'=>array(
				'应付款初始化'		=>url('CaiWu_Yf_Init', 'right'),
				//'染化料添加单价'	=>url('CangKu_RuKu', 'RightHavePrice',array('rukuTag'=>2)),
				//'坯纱添加单价'	=>url('CangKu_RuKu', 'RightHavePrice',array('rukuTag'=>1)),
				'坯纱采购入账'		=>url('CaiWu_Yf_Pisha', 'ListforAdd'),
				'坯纱采购入账查询'		=>url('CaiWu_Yf_Pisha', 'Right'),
				'其他往来'	=>url('CaiWu_Yf_Other','right'),
				'发票管理'	=>url('CaiWu_Yf_Invoice', 'right'),
				//'付款凭证审核'	=>url('CaiWu_Yf_Invoice', 'checkInvoice'),
				'应付款报表'	=>url('CaiWu_Yf_Report', 'right'),
			),

			'收支管理'=>array(
				'付款登记'		=>url('CaiWu_Expense', 'right'),
				'收款登记'		=>url('CaiWu_Ar_Income', 'right'),
				'支出项目管理'	=>url('CaiWu_ExpenseItem', 'right'),
				'帐户管理'		=>url('CaiWu_AccountItem', 'right'),
				'日记帐'		=>url('CaiWu_Report_Cash', 'right'),
			),

			'报表中心'=>array(
				'现金日记账'	=>url('CaiWu_Report_Cash', 'right'),
				'应收款报表'	=>url('CaiWu_Ar_Report', 'right'),
				'应付款报表'	=>url('CaiWu_Yf_Report', 'right')
			)
		),

        '财务对账'=>array(
			'财务对账'=>array(
				"<span class='menu_001'>添加订单价格</span>"	 =>url('Trade_Dye_Order','RightHavePrice'),
				"<span class='menu_001'>订单单价修改</span>"	 =>url('Trade_Dye_Order','RightHavePrice1'),
				"<span class='menu_001'>订单小缸价修改</span>"	 =>url('Trade_Dye_Order','RightHavePrice2'),
				//"<span class='menu_001'>订单折率修改</span>"	 =>url('Trade_Dye_Order','RightHaveZhelv'),
                "<span class='menu_001'>对账单</span>"	 =>url('CaiWu_Ar_Report','Duizhang'),
                "<span class='menu_001'>计划进度一览表</span>"	 =>url('Public_Search','PlanTrace2'),
                "<span class='menu_001'>订单明细审核</span>"	 =>url('Trade_Dye_Order','OrderShenhe'),

			)
		),
		'人事办公'=>array(
			'信息发布'=>array(
				"<span class='menu_001'>首页信息发布</span>"	 =>url('OA_Message','right')
			),
			'邮件管理'=>array(
			    "<span class='menu_001'>邮件管理</span>"	 =>url('OA_SM','right')
			),
			'个人设置'=>array(
				"<span class='menu_001'>密码修改</span>"	 =>url('Acm_User','ChangePwd')
			),
			'通讯录'=>array(
				"<span class='menu_001'>通讯录</span>"	 =>url('Jichu_Tongxun','Right')
			)

		),

		'报表中心'=>array(
			'仓库报表'=>array(
				//"<span class='menu_001'>坯纱入库日报表</span>"	 => url('CangKu_RuKu', 'Report',array('rukuTag'=>1)),
				"<span class='menu_001'>坯纱日报表</span>"	 =>url('CangKu_Report_Month','reportday'),
				"<span class='menu_001'>坯纱库存报表</span>"	 =>url('CangKu_Report_Month','right1'),
                "<span class='menu_001'>坯纱库存不足报表</span>" =>url('CangKu_Chuku','right1'),
				"<span class='menu_001'>成品入库日报表</span>"	 =>url('Chengpin_Dye_Cprk','DayReport'),
				"<span class='menu_001'>成品出库日报表</span>"	 =>url('Chengpin_Dye_Cpck','DayReport'),

			),

			'生产报表'=>array(
				"<span class='menu_001'>计划进度一览表</span>"	 =>url('Public_Search','PlanTrace'),
				"<span class='menu_001'>松筒产量日报表</span>"	 =>url('Chejian_Songtong','chanliangDayReport'),
				"<span class='menu_001'>装出笼产量日报表</span>"	 =>url('Chejian_Zhuangchulong','chanliangDayReport'),
				"<span class='menu_001'>染色产量日报表</span>"	 =>url('Chejian_Ranse','chanliangDayReport'),
				"<span class='menu_001'>烘纱产量日报表</span>"	 =>url('Chejian_Hongsha','chanliangDayReport'),
				"<span class='menu_001'>回倒产量日报表</span>"	 =>url('Chejian_Huidao','chanliangDayReport'),
				"<span class='menu_001'>打包产量日报表</span>"	 =>url('Chejian_Dabao','chanliangDayReport'),
				"<span class='menu_001'>筒染车间生产日报表</span>"	 =>url('Chejian_Dabao','ChejianChanliangDayReport'),
			),



		),

		'基础资料'=>array(
			'基础资料'=>array(
				"<span class='menu_001'>纱支档案</span>"	 =>url('JiChu_Ware','right',array('parentId'=>'2','default'=>'2')),
				"<span class='menu_001'>染料档案</span>"	 =>url('JiChu_Ware','right',array('parentId'=>'5','default'=>'5')),
				//"<span class='menu_001'>五金规格档案</span>"	 =>url('JiChu_WareWujin','right'),
				"<span class='menu_001'>客户档案</span>"	 =>url('JiChu_Client','right'),
				"<span class='menu_001'>已停止客户</span>"	 =>url('JiChu_Client','right1'),
				"<span class='menu_001'>供应商档案</span>"	 =>url('JiChu_Supplier','right'),
				"<span class='menu_001'>员工档案</span>"	 =>url('JiChu_Employ','right'),
				"<span class='menu_001'>部门资料</span>"	 =>url('JiChu_Department','right'),
				"<span class='menu_001'>染缸档案</span>"	 =>url('JiChu_Vat','right'),
				"<span class='menu_001'>产品大类</span>"	 =>url('JiChu_SaleKind','right'),
				"<span class='menu_003'>方案分配</span>"	 =>url('JiChu_Gongyi','right'),
				"<span class='menu_001'>车辆档案</span>"	 =>url('JiChu_Vehicle','right'),
			),
			'五金基础资料'=>array(
				"<span class='menu_001'>五金档案</span>"	 =>url('Cangku_Wujin','Jichu'),
				"<span class='menu_001'>库存位置</span>"	 =>url('Cangku_Wujin','Pos'),
				"<span class='menu_001'>领料部门设置</span>"	 =>url('Cangku_Wujin','Department'),
				"<span class='menu_001'>供应商档案</span>"	 =>url('Cangku_Wujin','Supplier'),
				"<span class='menu_002'>员工档案</span>"	 =>url('Cangku_Wujin','Employ'),
				"<span class='menu_002'>人员设置</span>"	 =>url('Cangku_Wujin','SetEmploy'),
			),
		),

		'系统设置'=>array(
			'系统设置'=>array(
				"<span class='menu_001'>物料档案维护</span>"=>url('JiChu_Ware','right1'),
				"<span class='menu_001'>基本设置</span>"	 =>url('Sys_Sys','set'),
				"<span class='menu_001'>数据更新</span>"	 =>url('Sys_Sys','right'),
				"<span class='menu_001'>基础资料日志</span>"	 =>url('Sys_Sys','right2'),
				"<span class='menu_001'>打印控件下载</span>" => "Resource/Script/lodop6.1/install_lodop32.exe",
				"<span class='menu_001'>流转单打印设置</span>" => url('Plan_Dye', 'ShowPrintEdit'),
			),
			'权限管理'=>array(
				"<span class='menu_001'>用户管理</span>"	 =>url('Acm_User','right'),
				"<span class='menu_001'>组管理</span>"	 =>url('Acm_Role','right'),
				"<span class='menu_001'>模块管理</span>"	 =>url('Acm_Func','right'),
			),

			'帐套设置'=>array(
				'帐套信息设置'=>url('Sys_CompInfo', 'Edit'),
			),

			'密码管理'=>array(
				'修改密码'=>url('Acm_User','ChangePwd')
			)
		),
		//'缸号：'
	),

	//支出项目总类
	'expenseType'=>array(
		'筒染车间'=>'筒染车间',
		'白纱车间'=>'白纱车间',
		'回倒车间'=>'回倒车间'
	),
	//应收款类别
	'arType'=>array(
		'00:筒染'=>0, //4
		'01:绞染'=>1
	),
	//付款类型
	'paymentTypes' => array(
		'现金'=>0,
		'支票'=>1,
		'电汇'=>2,
		'其他'=>3,
		'承兑'=>4,
		'汇票'=>5
	),
	//应付款凭据类型
	'invoiceTypes' => array(
		'采购发票'=>0,
		'采购对账单'=>1
	),
	//应收款凭据类型
	'arInvoiceTypes' => array(
		'销售发票'=>2,
		'销售对账单'=>3
	),
	//产品类别
	'proKind' => array(
		'筒染'=>1,
		'绞染'=>2
	),
	//产品颜色
	'proColor' => array(
		'靛蓝'=>'A',
		'黑色'=>'B',
		'兰加黑'=>'C',
		'活性'=>'H',
		'涂层'=>'T'
	),
	//包装要求
	'packing' => array(
		'厂签'=>'厂签',
		'客签'=>'客签',
		'中性'=>'中性'
	),
	//检验要求
	'checking' => array(
		'商检'=>'商检',
		'客检'=>'客检',
		'自检'=>'自检'
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