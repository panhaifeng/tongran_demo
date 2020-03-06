<?php  
	$_sysMenu = array(
		#定义目录结构
		'menu'=>array(
			'仓库管理'=>array(
				'染化料仓库管理'=>array(
					'入库登记'=>url('CangKu_Yl_RuKu','right'),
					'退库登记'=>url('CangKu_Yl_RukuTuiku','right'),
					'库位调拨'=>url('CangKu_Yl_Diaobo','add'),
					'库位调拨查询'=>url('CangKu_Yl_Diaobo','right'),
					'按处方领料'=>url('CangKu_Yl_ChuKu','right'),
					'领料查询'=>url('CangKu_Yl_ChuKu','right1'),
					// '其他出库'=>url('CangKu_Yl_ChuKu','right3'),
					'染料耗用分析'=>url('CangKu_Yl_ChuKu','YlAnalyse'),
					'染料用量日报表'=>url('Gongyi_Dye_Chufang','YlCost'),
					'染化料月报表'=>url('CangKu_Yl_Kucun','MonthReport'),
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
	                "<span class='menu_001'>仓库收发存报表</span>"	 =>url('Chengpin_Dye_Cpck','MonthReport'),
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

			'产量报工'=>array(
                '松紧筒打包'=>array(
                    "<span class='menu_001'>产量登记</span>"	 =>url('Chanliang_Input','right'),
                ),
                '装出笼' =>array(
                    "<span class='menu_001'>产量登记</span>"	 =>url('Chanliang_InputZcl','right'),
                ),
                '染色' =>array(
                    "<span class='menu_001'>产量登记</span>"	 =>url('Chanliang_InputRs','right'),
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

				),

				'产量工资'=>array(
				 	// "员工产量审核"	 =>url('CaiWu_Confirm','ListGuozhang'),
      //       		"产量审核记录"	 =>url('CaiWu_Confirm','Right'),
      //       		"染色产量工资"	 =>url('CaiWu_Confirm','ListRsPrice'),
      //       		"染色工资报表"	 =>url('CaiWu_Confirm','ListRsReport'),
      //       		"成本核算"	 	 =>url('CaiWu_CheckCost','Right')

            		"员工产量审核"	 =>url('CaiWu_Confirm','ListGuozhang'),
            		"产量审核记录"	 =>url('CaiWu_Confirm','Right'),
            		"成本核算"	 	 =>url('CaiWu_CheckCost','Right')
				),
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
					"<span class='menu_001'>未发货汇总表</span>"	 =>url('Chengpin_Dye_Cpck','NoFahuoReport'),

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
					"<span class='menu_001'>染色工序档案</span>" =>url('JiChu_VatGxPrice','right'),
					"<span class='menu_001'>产品大类</span>"	 =>url('JiChu_SaleKind','right'),
					"<span class='menu_001'>报工人员档案</span>" =>url('JiChu_GxPerson','right'),
					"<span class='menu_001'>松紧筒装出笼产量工序档案</span>"	 =>url('JiChu_ChanliangGx','right'),
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

	);	

?>