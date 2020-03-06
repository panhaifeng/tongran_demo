-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-09-06 16:39:15
-- 服务器版本： 5.6.10-log
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tongran_dongyang1`
--

-- --------------------------------------------------------

--
-- 表的结构 `acm_func2role`
--

CREATE TABLE IF NOT EXISTS `acm_func2role` (
`id` int(10) NOT NULL,
  `funcId` int(10) NOT NULL,
  `roleId` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `acm_func2role`
--

INSERT INTO `acm_func2role` (`id`, `funcId`, `roleId`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 6, 1),
(4, 8, 1),
(5, 111, 1),
(6, 4, 5),
(7, 52, 3),
(8, 38, 4),
(9, 60, 2),
(10, 137, 5),
(11, 2, 6),
(12, 3, 6),
(14, 60, 7),
(15, 24, 7);

-- --------------------------------------------------------

--
-- 表的结构 `acm_funcdb`
--

CREATE TABLE IF NOT EXISTS `acm_funcdb` (
`id` int(11) NOT NULL,
  `parentId` int(10) NOT NULL,
  `funcName` varchar(20) COLLATE utf8_bin NOT NULL,
  `leftId` int(10) NOT NULL,
  `rightId` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `acm_funcdb`
--

INSERT INTO `acm_funcdb` (`id`, `parentId`, `funcName`, `leftId`, `rightId`) VALUES
(1, -1, '_#_ROOT_NODE_#_', 1, 238),
(2, 0, '销售管理', 2, 9),
(3, 0, '生产管理', 10, 63),
(4, 0, '财务管理', 64, 109),
(5, 0, '采购管理', 110, 121),
(6, 0, ' 人事办公', 122, 127),
(7, 0, '系统设置', 128, 131),
(8, 0, '基础资料', 132, 159),
(9, 4, '应付管理', 65, 74),
(10, 9, '应付款初始化', 66, 67),
(11, 9, '付款凭证审核', 68, 69),
(13, 9, '应付款报表', 70, 71),
(14, 4, '应收管理', 75, 84),
(15, 4, '订单审核', 85, 86),
(16, 4, '发货审核', 87, 88),
(17, 5, '采购申请', 111, 112),
(18, 5, '采购订单管理', 113, 114),
(19, 5, '仓库管理', 115, 120),
(20, 19, '采购入库登记', 116, 117),
(21, 19, '付款凭证登记', 118, 119),
(22, 7, '权限管理', 129, 130),
(23, 8, '产品档案', 133, 134),
(24, 8, '货品档案', 135, 136),
(25, 8, '客户档案', 137, 138),
(26, 8, '供应商档案', 139, 140),
(27, 8, '员工档案', 141, 142),
(28, 8, '部门资料', 143, 144),
(30, 2, '订单录入', 3, 8),
(31, 4, '收支管理', 89, 102),
(32, 31, '付款登记', 90, 91),
(33, 31, '收款登记', 92, 93),
(34, 31, '支出项目管理', 94, 95),
(35, 31, '帐户管理', 96, 97),
(36, 31, '现金日记账', 98, 99),
(37, 31, '银行日记帐', 100, 101),
(38, 3, '成品车间', 11, 24),
(39, 38, '筒染成品入库', 12, 17),
(40, 38, '筒染成品出库', 18, 23),
(41, 14, '针织发货审核', 76, 77),
(42, 14, '销售发票登记', 78, 79),
(43, 14, '应收款初始化', 80, 81),
(45, 14, '应收款报表', 82, 83),
(46, 4, '报表中心', 103, 108),
(47, 46, '牛仔业务考核报表', 104, 105),
(48, 46, '牛仔生产考核报表', 106, 107),
(49, 3, '生产计划管理', 25, 42),
(50, 0, '仓库管理', 160, 223),
(51, 50, '染化料仓库管理', 161, 190),
(52, 50, '坯纱仓库管理', 191, 206),
(53, 3, '松筒车间', 43, 44),
(54, 3, '回倒车间', 45, 46),
(55, 51, '入库登记', 162, 167),
(56, 51, '退库登记', 168, 173),
(57, 52, '入库登记', 192, 197),
(58, 52, '领料登记', 198, 203),
(59, 3, '染色车间', 47, 48),
(60, 3, '大样处方管理', 49, 62),
(61, 55, '染化料-入库登记-查询', 163, 164),
(62, 55, '染化料-入库登记-修改', 165, 166),
(65, 56, '付款凭证登记-查询', 169, 170),
(67, 56, '付款凭证登记-修改', 171, 172),
(69, 6, '信息发布', 123, 124),
(70, 6, '个人设置', 125, 126),
(71, 39, '成品-入库-查询', 13, 14),
(73, 39, '成品-入库-修改', 15, 16),
(75, 40, '成品-出库-查询', 19, 20),
(77, 40, '成品-出库-修改', 21, 22),
(79, 60, '新开处方', 50, 55),
(80, 60, '大样处方管理', 56, 61),
(81, 79, '大样-新开处方-查询', 51, 52),
(83, 79, '大样-新开处方-修改', 53, 54),
(85, 80, '大样-处方管理-查询', 57, 58),
(87, 80, '大样-处方管理-修改', 59, 60),
(89, 49, '筒染订单', 26, 31),
(90, 49, '计划单管理', 32, 37),
(91, 89, '生产计划-筒染订单-查询', 27, 28),
(93, 89, '生产计划-筒染订单-修改', 29, 30),
(96, 57, '坏纱入库-查询', 193, 194),
(98, 57, '坏纱入库-修改', 195, 196),
(100, 58, '坯纱领料-查询', 199, 200),
(102, 58, '坯纱领料-修改', 201, 202),
(104, 90, '计划单-查询', 33, 34),
(105, 90, '计划单-修改', 35, 36),
(106, 52, '库存报表', 204, 205),
(107, 30, '销售-订单-查询', 4, 5),
(108, 30, '销售-订单-修改', 6, 7),
(109, 49, '染色日计划安排', 38, 39),
(110, 49, '领纱日计划安排', 40, 41),
(111, 0, '特殊权限', 224, 227),
(112, 111, '加急单编辑', 225, 226),
(113, 51, '按处方领料', 174, 175),
(114, 51, '领料查询', 176, 177),
(115, 51, '其他出库', 178, 179),
(116, 51, '染料耗用分析', 180, 181),
(117, 51, '染料用量日报表', 182, 183),
(118, 51, '染化料月报表', 184, 185),
(119, 51, '库存调整', 186, 187),
(120, 51, '库存调整查询', 188, 189),
(121, 50, '五金仓库', 207, 222),
(122, 121, '库存初始化', 208, 209),
(123, 121, '入库登记', 210, 211),
(124, 121, '入库查询', 212, 213),
(125, 121, '出库登记', 214, 215),
(126, 121, '出库查询', 216, 217),
(127, 121, '库存查询', 218, 219),
(128, 121, '收发存月报表', 220, 221),
(129, 8, '五金基础资料', 145, 158),
(130, 129, '五金档案', 146, 147),
(131, 129, '库存位置', 148, 149),
(132, 129, '领料部门设置', 150, 151),
(133, 129, '供应商档案', 152, 153),
(134, 129, '员工档案', 154, 155),
(135, 129, '人员设置', 156, 157),
(136, 9, '发票管理', 72, 73),
(137, 0, '财务对账单', 228, 237),
(138, 137, '财务对账', 229, 236),
(139, 138, '添加订单价格', 230, 231),
(140, 138, '订单单价修改', 232, 233),
(141, 138, '对账单', 234, 235);

-- --------------------------------------------------------

--
-- 表的结构 `acm_roledb`
--

CREATE TABLE IF NOT EXISTS `acm_roledb` (
`id` int(10) NOT NULL,
  `roleName` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `acm_roledb`
--

INSERT INTO `acm_roledb` (`id`, `roleName`) VALUES
(1, '厂长'),
(2, '打样员'),
(3, '坯纱仓库'),
(4, '成品仓库'),
(5, '财务'),
(6, '管理员'),
(7, '化验室主管');

-- --------------------------------------------------------

--
-- 表的结构 `acm_user2role`
--

CREATE TABLE IF NOT EXISTS `acm_user2role` (
`id` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `roleId` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `acm_userdb`
--

CREATE TABLE IF NOT EXISTS `acm_userdb` (
`id` int(10) NOT NULL,
  `userName` varchar(10) COLLATE utf8_bin NOT NULL,
  `realName` varchar(10) COLLATE utf8_bin NOT NULL,
  `passwd` varchar(20) COLLATE utf8_bin NOT NULL,
  `employId` int(11) NOT NULL COMMENT '处方人id'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `acm_userdb`
--

INSERT INTO `acm_userdb` (`id`, `userName`, `realName`, `passwd`, `employId`) VALUES
(1, 'admin', '管理员', 'admin', 0);

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_accountitem`
--

CREATE TABLE IF NOT EXISTS `caiwu_accountitem` (
`id` int(10) NOT NULL,
  `itemName` varchar(40) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='支出项目表';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_artype`
--

CREATE TABLE IF NOT EXISTS `caiwu_artype` (
`id` int(10) NOT NULL,
  `typeName` char(10) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='每个客户涉及的业务范围,与应收款挂钩';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_ar_init`
--

CREATE TABLE IF NOT EXISTS `caiwu_ar_init` (
`id` int(10) NOT NULL,
  `initDate` date NOT NULL,
  `clientId` int(10) NOT NULL,
  `initMoney` decimal(10,2) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='应收款初始化';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_ar_other`
--

CREATE TABLE IF NOT EXISTS `caiwu_ar_other` (
`id` int(10) NOT NULL,
  `recordDate` date NOT NULL COMMENT '发生日期',
  `clientId` int(10) NOT NULL COMMENT '客户',
  `money` decimal(10,2) NOT NULL COMMENT '发生金额',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='其他应收款(非主营业务)';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_expense`
--

CREATE TABLE IF NOT EXISTS `caiwu_expense` (
`id` int(10) NOT NULL,
  `payNum` varchar(20) COLLATE utf8_bin NOT NULL,
  `accountItemId` int(10) NOT NULL,
  `expenseItemId` int(10) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `dateExpense` date NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='非采购付款登记';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_expenseitem`
--

CREATE TABLE IF NOT EXISTS `caiwu_expenseitem` (
`id` int(10) NOT NULL,
  `itemName` varchar(40) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='支出项目表';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_income`
--

CREATE TABLE IF NOT EXISTS `caiwu_income` (
`id` int(10) NOT NULL,
  `type` smallint(1) NOT NULL COMMENT '从0递增,分别代表现金,支票,电汇',
  `incomeNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '凭证编号',
  `accountItemId` int(10) NOT NULL,
  `dateIncome` date NOT NULL,
  `clientId` int(10) NOT NULL COMMENT '和expenseItemId两个中只能有一个>0',
  `expenseItemId` int(10) NOT NULL COMMENT '非销售收入的科目代码,使用管理费用科目',
  `moneyIncome` double(15,2) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='收款登记表';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_invoice`
--

CREATE TABLE IF NOT EXISTS `caiwu_invoice` (
`id` int(10) NOT NULL,
  `isChecked` smallint(1) NOT NULL COMMENT '是否被财务审核过',
  `invoiceNum` varchar(20) COLLATE utf8_bin NOT NULL,
  `type` smallint(2) NOT NULL COMMENT '凭证的类型,从0开始递增，分别代表采购发票,采购对账明细单,销售发票,销售对账明细单等',
  `dateInput` date NOT NULL,
  `supplierId` int(10) NOT NULL,
  `clientId` int(10) NOT NULL,
  `money` double(15,2) NOT NULL,
  `paymentId` int(10) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='财务凭证登记表';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_payment`
--

CREATE TABLE IF NOT EXISTS `caiwu_payment` (
`id` int(10) NOT NULL,
  `type` smallint(1) NOT NULL COMMENT '从0递增,分别代表现金,支票,电汇',
  `accountItemId` int(10) NOT NULL,
  `payNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '凭证编号',
  `datePay` date NOT NULL,
  `supplierId` int(10) NOT NULL,
  `moneyPay` double(15,2) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='财务付款登记表';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_init`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_init` (
`id` int(10) NOT NULL,
  `initDate` date NOT NULL,
  `supplierId` int(10) NOT NULL,
  `initMoney` decimal(10,2) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='应付款初始化';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_other`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_other` (
`id` int(10) NOT NULL,
  `dateRecord` date NOT NULL,
  `supplierId` int(10) NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `memo` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='其他应付往来';

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_pisha`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_pisha` (
`id` int(10) NOT NULL,
  `kind` smallint(1) NOT NULL COMMENT '0正常应付1其他应付9其他',
  `dateRecord` date NOT NULL,
  `supplierId` int(10) NOT NULL,
  `danjia` decimal(15,2) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL,
  `memo` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='坯纱应付款记录';

-- --------------------------------------------------------

--
-- 表的结构 `cangku_chuku`
--

CREATE TABLE IF NOT EXISTS `cangku_chuku` (
`id` int(10) NOT NULL,
  `chukuDate` date NOT NULL COMMENT '领料日期',
  `chukuNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '领料单号',
  `depId` int(10) NOT NULL COMMENT '部门',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `cangku_chuku2ware`
--

CREATE TABLE IF NOT EXISTS `cangku_chuku2ware` (
`id` int(10) NOT NULL,
  `chukuId` int(10) NOT NULL,
  `gangId` int(10) NOT NULL COMMENT '逻辑缸号id,需要按计划领料',
  `supplierId` int(10) NOT NULL DEFAULT '0' COMMENT '客户或供应商名称',
  `wareId` int(10) NOT NULL,
  `danjia` decimal(10,3) NOT NULL,
  `cnt` decimal(10,3) NOT NULL,
  `chandi` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '产地',
  `kind` int(1) NOT NULL COMMENT '区分不同的出库 0为正常出库，1为本厂出库'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `cangku_chuku_log`
--

CREATE TABLE IF NOT EXISTS `cangku_chuku_log` (
`id` int(10) NOT NULL,
  `wareId` int(10) NOT NULL,
  `cnt` double NOT NULL,
  `user` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '领料人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '领料时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='坯纱领料不足日志';

-- --------------------------------------------------------

--
-- 表的结构 `cangku_dye_pandian`
--

CREATE TABLE IF NOT EXISTS `cangku_dye_pandian` (
`id` int(10) NOT NULL,
  `datePandian` date NOT NULL COMMENT '盘点日期',
  `wareId` int(10) NOT NULL COMMENT '货品id',
  `cnt` decimal(10,1) NOT NULL COMMENT '数量',
  `money` decimal(10,2) NOT NULL COMMENT '金额'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='染料助剂每月盘存表';

-- --------------------------------------------------------

--
-- 表的结构 `cangku_init`
--

CREATE TABLE IF NOT EXISTS `cangku_init` (
`id` int(10) NOT NULL,
  `initDate` date NOT NULL,
  `wareId` int(10) NOT NULL,
  `cntInit` decimal(15,3) NOT NULL,
  `moneyInit` decimal(15,3) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='应付款初始化';

-- --------------------------------------------------------

--
-- 表的结构 `cangku_ruku`
--

CREATE TABLE IF NOT EXISTS `cangku_ruku` (
`id` int(10) NOT NULL,
  `ruKuNum` varchar(20) COLLATE utf8_bin NOT NULL,
  `songhuoCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '送货单号',
  `ruKuDate` date NOT NULL,
  `supplierId` int(10) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL,
  `tag` tinyint(4) NOT NULL DEFAULT '0',
  `isTuiku` int(1) NOT NULL DEFAULT '0' COMMENT '1表示退库',
  `supplierId2` int(10) NOT NULL COMMENT '采购入库填写的坯纱供应商',
  `kind` int(1) NOT NULL COMMENT '区分不同的入库 0为正常入库，1为本厂采购入库'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `cangku_ruku2ware`
--

CREATE TABLE IF NOT EXISTS `cangku_ruku2ware` (
`id` int(10) NOT NULL,
  `purchase2wareId` int(10) NOT NULL COMMENT '采购订单从表id,预留字段，为以后采购系统做准备',
  `ruKuId` int(10) NOT NULL,
  `wareId` int(10) NOT NULL,
  `chandi` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '产地',
  `danJia` decimal(10,3) NOT NULL,
  `cnt` decimal(10,3) NOT NULL,
  `cntJian` smallint(3) NOT NULL COMMENT '件数',
  `invoiceId` int(10) NOT NULL COMMENT '凭证号码',
  `danjiaGz` decimal(10,3) NOT NULL COMMENT '过账的单价'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `cangku_wujin_chuku`
--

CREATE TABLE IF NOT EXISTS `cangku_wujin_chuku` (
`id` int(10) NOT NULL,
  `dateChuku` date NOT NULL,
  `wareId` int(10) NOT NULL,
  `cnt` decimal(10,1) NOT NULL,
  `danjia` decimal(10,2) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='五金出库表';

-- --------------------------------------------------------

--
-- 表的结构 `cangku_wujin_ruku`
--

CREATE TABLE IF NOT EXISTS `cangku_wujin_ruku` (
`id` int(10) NOT NULL,
  `dateRuku` date NOT NULL,
  `wareId` int(10) NOT NULL,
  `cnt` decimal(10,1) NOT NULL,
  `danjia` decimal(10,2) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='五金入库表';

-- --------------------------------------------------------

--
-- 表的结构 `cangku_yl_chuku`
--

CREATE TABLE IF NOT EXISTS `cangku_yl_chuku` (
`id` int(10) NOT NULL,
  `kind` int(11) NOT NULL COMMENT '类别',
  `gangId` int(10) NOT NULL COMMENT '缸号id',
  `chufangRen` int(11) NOT NULL,
  `chufangId` int(10) NOT NULL COMMENT '处方id',
  `employId` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `chukuDate` date NOT NULL COMMENT '领料日期',
  `chukuNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '领料单号',
  `depId` int(10) NOT NULL COMMENT '部门',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isTuiku` int(1) NOT NULL DEFAULT '0' COMMENT '1表示退库'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `cangku_yl_chuku2ware`
--

CREATE TABLE IF NOT EXISTS `cangku_yl_chuku2ware` (
`id` int(10) NOT NULL,
  `chukuId` int(10) NOT NULL,
  `wareId` int(10) NOT NULL,
  `danjia` decimal(10,4) NOT NULL,
  `cnt` decimal(10,4) NOT NULL,
  `money` decimal(15,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `cangku_yl_ruku`
--

CREATE TABLE IF NOT EXISTS `cangku_yl_ruku` (
`id` int(10) NOT NULL,
  `rukuNum` varchar(20) COLLATE utf8_bin NOT NULL,
  `rukuDate` date NOT NULL,
  `supplierId` int(10) NOT NULL COMMENT '供应商id',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL,
  `songhuoCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '送货单号',
  `isTuiku` int(1) NOT NULL DEFAULT '0' COMMENT '1表示退库'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `cangku_yl_ruku2ware`
--

CREATE TABLE IF NOT EXISTS `cangku_yl_ruku2ware` (
`id` int(10) NOT NULL,
  `rukuId` int(10) NOT NULL,
  `wareId` int(10) NOT NULL,
  `chandi` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '产地',
  `danjia` decimal(10,4) NOT NULL,
  `cnt` decimal(10,3) NOT NULL,
  `invoiceId` int(10) NOT NULL COMMENT '凭证号码'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `chengpin_blog2cpck`
--

CREATE TABLE IF NOT EXISTS `chengpin_blog2cpck` (
`id` int(10) NOT NULL,
  `cpckId` int(10) NOT NULL COMMENT '成品出库id',
  `blogId` int(10) NOT NULL COMMENT '打印日志id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品出库与打印日志的中间表';

-- --------------------------------------------------------

--
-- 表的结构 `chengpin_dye_cpck`
--

CREATE TABLE IF NOT EXISTS `chengpin_dye_cpck` (
`id` int(10) NOT NULL,
  `dateCpck` date NOT NULL COMMENT '出库日期',
  `planId` int(10) NOT NULL COMMENT '计划表Id,决定缸号',
  `cntChuku` decimal(10,2) NOT NULL,
  `jingKg` decimal(10,2) NOT NULL COMMENT '净重',
  `cntJian` int(5) NOT NULL COMMENT '件数',
  `cntTongzi` int(5) NOT NULL COMMENT '支数',
  `cntSecond` decimal(10,1) NOT NULL COMMENT '次等品',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='出库明细,每一缸是统一出库';

-- --------------------------------------------------------

--
-- 表的结构 `chengpin_dye_cprk`
--

CREATE TABLE IF NOT EXISTS `chengpin_dye_cprk` (
`id` int(10) NOT NULL,
  `dabaoId` int(11) NOT NULL COMMENT '打包产量主表的id',
  `dateCprk` date NOT NULL COMMENT '入库日期',
  `planId` int(10) NOT NULL COMMENT '计划表Id,决定缸号',
  `jingKg` decimal(10,1) NOT NULL COMMENT '净重',
  `cntJian` int(5) NOT NULL COMMENT '件数',
  `cntTongzi` int(5) NOT NULL COMMENT '支数',
  `cntSecond` decimal(10,1) NOT NULL COMMENT '次等品',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='入库明细,每一 缸是统一入库';

-- --------------------------------------------------------

--
-- 表的结构 `chengpin_printblog`
--

CREATE TABLE IF NOT EXISTS `chengpin_printblog` (
`id` int(10) NOT NULL,
  `datePrint` date NOT NULL COMMENT '打印日期',
  `user` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '操作人',
  `cpckCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '成品出库单号'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品出库的打印日志';

-- --------------------------------------------------------

--
-- 表的结构 `color_tishi`
--

CREATE TABLE IF NOT EXISTS `color_tishi` (
`id` int(10) NOT NULL,
  `memoCode` char(10) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `color` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '颜色'
) ENGINE=MyISAM AUTO_INCREMENT=130 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='颜色输入提示表';

--
-- 转存表中的数据 `color_tishi`
--

INSERT INTO `color_tishi` (`id`, `memoCode`, `color`) VALUES
(1, 'pb', '漂白'),
(2, 'y', '元'),
(3, 'bp', '半漂'),
(4, 'h', '红'),
(5, 'h', '灰'),
(6, 'l', '兰'),
(7, 'q', '青'),
(8, 'qh', '浅灰'),
(9, 'kq', '卡其'),
(10, 'l', '绿'),
(11, 'sq', '上青'),
(12, 'z', '紫'),
(13, 'qp', '全漂'),
(14, 'tb', '特白'),
(15, 'ql', '浅兰'),
(16, 'fh', '粉红'),
(17, 'mb', '米白'),
(18, 'bl', '宝兰'),
(19, 'dh', '大红'),
(20, 'sh', '深灰'),
(21, 'z', '棕'),
(22, 'sl', '深兰'),
(23, 'qz', '浅紫'),
(24, 'hs', '黑色'),
(25, 'zh', '紫红'),
(26, 'ys', '元色'),
(27, 'ms', '米色'),
(28, 'h', '黄'),
(29, 'zq', '芷青'),
(30, 'zs', '紫色'),
(31, 'b', '白'),
(32, 'mw', '米王'),
(34, 'zl', '中兰'),
(35, 'jl', '军绿'),
(36, 'hl', '湖兰'),
(37, 'sq', '深青'),
(39, 'w', '王'),
(41, 'lh', '绿灰'),
(42, 'hl', '灰兰'),
(44, 'ql', '浅绿'),
(45, 'sh', '深红'),
(46, 'jh', '桔红'),
(49, 'c', '茶'),
(51, 'mh', '米灰'),
(52, 'sl', '深绿'),
(53, 'sz', '深紫'),
(54, 'qk', '浅卡'),
(55, 'lh', '兰灰'),
(56, 'zq', '丈青'),
(57, 'm', '米'),
(60, 'kf', '咖啡'),
(61, 'll', '兰绿'),
(65, 'hl', '湖绿'),
(66, 'k', '卡'),
(68, 'yq', '元青'),
(69, 'qq', '浅青'),
(70, 'jh', '玫红'),
(71, 'jb', '加白'),
(73, 'yh', '元灰'),
(74, 'zh', '中灰'),
(75, 'qw', '浅王'),
(80, 'h', '黑'),
(85, 'ls', '绿色'),
(86, 'qf', '浅粉'),
(88, 'mh', '梅红'),
(89, 'ml', '木绿'),
(90, 'j', '桔'),
(91, 'mh', '米黄'),
(93, 'ls', '兰色'),
(97, 'fs', '粉色'),
(98, 'jh', '酱红'),
(104, 'qz', '浅棕'),
(109, 'sk', '深卡'),
(111, 'hz', '红棕'),
(124, 'hs', '灰色'),
(125, 'gl', '果绿'),
(126, 'hh', '红灰'),
(129, 'jw', '桔王');

-- --------------------------------------------------------

--
-- 表的结构 `dye_db_chanliang`
--

CREATE TABLE IF NOT EXISTS `dye_db_chanliang` (
`id` int(10) NOT NULL,
  `gangId` int(10) NOT NULL COMMENT 'plan_dye_gang主键',
  `cntTongzi` smallint(4) NOT NULL COMMENT '筒子数',
  `cntK` decimal(10,2) NOT NULL COMMENT '公斤数',
  `workerCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工号',
  `dateInput` date NOT NULL COMMENT '日期',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `banci` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '班次',
  `dabaoCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '打包单号',
  `maozhong` decimal(10,2) NOT NULL COMMENT '毛重',
  `jingzhong` decimal(10,2) NOT NULL COMMENT '净重',
  `cntXiang` smallint(3) NOT NULL COMMENT '箱数'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='打包产量表';

-- --------------------------------------------------------

--
-- 表的结构 `dye_db_chanliang_mx`
--

CREATE TABLE IF NOT EXISTS `dye_db_chanliang_mx` (
`id` int(11) NOT NULL,
  `chanliangId` int(11) NOT NULL,
  `gangId` int(11) NOT NULL,
  `xianghao` smallint(4) NOT NULL COMMENT '箱号',
  `maozhong` decimal(10,2) NOT NULL COMMENT '毛重',
  `cntTongzi` int(3) NOT NULL COMMENT '筒管只数',
  `danzhongZhiguan` decimal(10,2) NOT NULL COMMENT '筒管单重',
  `danzhongBaozhuang` decimal(10,2) NOT NULL COMMENT '包装单单重',
  `jingzhong` decimal(10,2) NOT NULL COMMENT '净重',
  `memo` varchar(100) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='打包产量明细';

-- --------------------------------------------------------

--
-- 表的结构 `dye_fanxiu_record`
--

CREATE TABLE IF NOT EXISTS `dye_fanxiu_record` (
`id` int(11) NOT NULL,
  `dateFanxiu` date NOT NULL COMMENT '登记日期',
  `cntByGongyi` decimal(10,2) NOT NULL,
  `cntByRanse` decimal(10,2) NOT NULL,
  `cntTotal` decimal(10,2) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='反修记录表';

-- --------------------------------------------------------

--
-- 表的结构 `dye_gang2stcar`
--

CREATE TABLE IF NOT EXISTS `dye_gang2stcar` (
`id` int(10) NOT NULL,
  `gangId` int(10) NOT NULL COMMENT '逻辑缸号',
  `stcarId` int(10) NOT NULL COMMENT '松筒车号',
  `isOver` tinyint(1) NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='缸号与松筒车的对应关系表，在安排松筒计划';

-- --------------------------------------------------------

--
-- 表的结构 `dye_hd_chanliang`
--

CREATE TABLE IF NOT EXISTS `dye_hd_chanliang` (
`id` int(10) NOT NULL,
  `gangId` int(10) NOT NULL COMMENT 'plan_dye_gang主键',
  `cntTongzi` smallint(4) NOT NULL COMMENT '筒子数',
  `cntK` decimal(10,2) NOT NULL COMMENT '公斤数',
  `isHuixiu` tinyint(4) NOT NULL COMMENT '是否回修',
  `banci` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '班次',
  `workerCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工号',
  `dateInput` date NOT NULL COMMENT '日期',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `carId` int(10) NOT NULL COMMENT '车辆id',
  `people` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '车辆联系人或者司机'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='回倒产量表';

-- --------------------------------------------------------

--
-- 表的结构 `dye_hs_chanliang`
--

CREATE TABLE IF NOT EXISTS `dye_hs_chanliang` (
`id` int(10) NOT NULL,
  `gangId` int(10) NOT NULL COMMENT 'plan_dye_gang主键',
  `cntTongzi` smallint(4) NOT NULL COMMENT '筒子数',
  `cntK` decimal(10,2) NOT NULL COMMENT '公斤数',
  `workerCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工号',
  `dateInput` date NOT NULL COMMENT '日期',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `banci` tinyint(4) NOT NULL COMMENT '班次',
  `isHuixiu` tinyint(4) NOT NULL COMMENT '是否回修'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='烘纱产量表';

-- --------------------------------------------------------

--
-- 表的结构 `dye_rs_chanliang`
--

CREATE TABLE IF NOT EXISTS `dye_rs_chanliang` (
`id` int(10) NOT NULL,
  `type` char(10) COLLATE utf8_bin NOT NULL COMMENT '染色产量类别',
  `gangId` int(10) NOT NULL COMMENT 'plan_dye_gang主键',
  `cntTongzi` smallint(4) NOT NULL COMMENT '筒子数',
  `cntK` decimal(10,2) NOT NULL COMMENT '公斤数',
  `workerCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工号',
  `dateInput` date NOT NULL COMMENT '日期',
  `chanliangKind` smallint(1) NOT NULL COMMENT '0:正常,1:回修,2:加料',
  `chanliangDate` date NOT NULL COMMENT '日期',
  `banci` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '班次',
  `caozuoren` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '操作人',
  `mJianzhu` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '碱煮',
  `mPiaosha` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '漂纱',
  `mFensan` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '分散',
  `mQingxi` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '清洗',
  `mPiaobai` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '漂白',
  `mRuran` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '入染',
  `mJiajian` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '加碱',
  `mDuiyang` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '对样',
  `mSuanxi` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '酸洗',
  `mZaoxi` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '皂洗',
  `mShangyou` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '上油',
  `mLase` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '拉色',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='染色产量表';

-- --------------------------------------------------------

--
-- 表的结构 `dye_st_chanliang`
--

CREATE TABLE IF NOT EXISTS `dye_st_chanliang` (
`id` int(10) NOT NULL,
  `gangId` int(10) NOT NULL COMMENT '缸号Id',
  `dateInput` date NOT NULL COMMENT '产量录入日期，取消计划后新增',
  `gang2stcarId` int(10) NOT NULL COMMENT '松筒计划Id，因计划取消，不用，暂时保留，以备不时之需',
  `className` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '班组名称',
  `banci` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '班次',
  `workerCode` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '工号',
  `cntKg` decimal(10,2) NOT NULL COMMENT '白纱实重',
  `netWeight` decimal(10,2) NOT NULL COMMENT '净重',
  `cntTongzi` int(5) NOT NULL COMMENT '筒子个数',
  `cntK` decimal(15,2) NOT NULL COMMENT '公斤数',
  `isHuixiu` tinyint(4) NOT NULL COMMENT '是否回修',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `carId` int(10) NOT NULL COMMENT '车辆id',
  `people` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '车辆联系人或者司机'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='松筒产量登记表';

-- --------------------------------------------------------

--
-- 表的结构 `dye_zcl_chanliang`
--

CREATE TABLE IF NOT EXISTS `dye_zcl_chanliang` (
`id` int(10) NOT NULL,
  `gangId` int(10) NOT NULL COMMENT 'plan_dye_gang主键',
  `cntTongzi` smallint(4) NOT NULL COMMENT '筒子数',
  `cntK` decimal(10,2) NOT NULL COMMENT '公斤数',
  `workerCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工号',
  `dateInput` date NOT NULL COMMENT '日期',
  `chanliangDate` date NOT NULL,
  `banci` smallint(5) NOT NULL COMMENT '班次',
  `caozuoren` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '操作工',
  `mChengsha` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '称纱',
  `mZhuanglon` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '装笼',
  `mChulon` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '出笼',
  `mTuoshui` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '脱水',
  `mHongshang` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '烘上',
  `mHongxia` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '烘下',
  `mHuihong` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '回烘',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `isHuixiu` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='装出笼产量表';

-- --------------------------------------------------------

--
-- 表的结构 `gongyi_dye_chufang`
--

CREATE TABLE IF NOT EXISTS `gongyi_dye_chufang` (
`id` int(10) NOT NULL,
  `order2wareId` int(10) NOT NULL COMMENT '订单明细id',
  `gangId` int(10) NOT NULL COMMENT '缸id',
  `dateChufang` date NOT NULL COMMENT '开处方日期',
  `dyeKind` char(10) COLLATE utf8_bin NOT NULL COMMENT '漂白|套色|修色',
  `chufangren` varchar(10) COLLATE utf8_bin NOT NULL,
  `chufangrenId` int(10) NOT NULL,
  `rhlZhelv` decimal(10,2) NOT NULL DEFAULT '1.00' COMMENT '染化料折率',
  `rsgyId` int(10) NOT NULL COMMENT '染色工艺Id',
  `qclId` int(10) NOT NULL COMMENT '前处理Id',
  `hclId` int(10) NOT NULL COMMENT '后处理id',
  `pisha_qcl` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '坯纱前处理，漂，热煮',
  `ranseKind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '染色类别'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='工艺处方主表';

-- --------------------------------------------------------

--
-- 表的结构 `gongyi_dye_chufang2ware`
--

CREATE TABLE IF NOT EXISTS `gongyi_dye_chufang2ware` (
`id` int(10) NOT NULL,
  `gongxuId` int(10) DEFAULT NULL COMMENT '工序id',
  `chufangId` int(10) NOT NULL COMMENT '处方主表id',
  `wareId` int(10) NOT NULL COMMENT '染料id',
  `unitKg` decimal(10,3) NOT NULL COMMENT '单位用量',
  `unit` char(10) COLLATE utf8_bin NOT NULL COMMENT '单位((包|g/L|%)',
  `tmp` int(5) NOT NULL COMMENT '温度',
  `timeRs` int(5) NOT NULL COMMENT '染色时间',
  `ord` smallint(2) NOT NULL COMMENT '放入次序',
  `memo` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='处方明细表';

-- --------------------------------------------------------

--
-- 表的结构 `gongyi_dye_merge`
--

CREATE TABLE IF NOT EXISTS `gongyi_dye_merge` (
`id` int(10) NOT NULL,
  `vatId` int(10) NOT NULL COMMENT '染缸id',
  `shuirong` int(10) NOT NULL COMMENT '并后水溶',
  `rsZhelv` decimal(5,2) NOT NULL COMMENT '染色折率',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='并缸处方';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_client`
--

CREATE TABLE IF NOT EXISTS `jichu_client` (
`id` int(10) NOT NULL COMMENT 'ID',
  `traderId` int(10) NOT NULL COMMENT '本单位联系人',
  `compCode` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '公司编码',
  `compName` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '公司名称',
  `people` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `fax` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '传真',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `accountId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '帐号',
  `taxId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '税号',
  `address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `loginName` varchar(20) COLLATE utf8_bin NOT NULL,
  `loginPsw` varchar(20) COLLATE utf8_bin NOT NULL,
  `isStop` tinyint(1) NOT NULL COMMENT '是否停止往来',
  `iURL` varchar(500) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '接口URL地址'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `jichu_client2artype`
--

CREATE TABLE IF NOT EXISTS `jichu_client2artype` (
`id` int(10) NOT NULL,
  `clientId` int(10) NOT NULL,
  `arTypeId` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户与业务范围的对应关系表';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_controllog`
--

CREATE TABLE IF NOT EXISTS `jichu_controllog` (
`id` int(10) NOT NULL,
  `item` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '操作项目',
  `action` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '动作',
  `user` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '操作人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '操作时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='基础资料修改日志';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_department`
--

CREATE TABLE IF NOT EXISTS `jichu_department` (
`id` int(10) NOT NULL,
  `depName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '部门'
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `jichu_department`
--

INSERT INTO `jichu_department` (`id`, `depName`) VALUES
(3, '财务科'),
(11, '销售科'),
(13, '工艺科');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_employ`
--

CREATE TABLE IF NOT EXISTS `jichu_employ` (
`id` int(10) NOT NULL,
  `employCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '员工编码',
  `employName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '员工名称',
  `workerCode` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '工号',
  `sex` smallint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `depId` int(10) NOT NULL COMMENT '部门ID',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `address` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `dateEnter` date NOT NULL COMMENT '入厂时间',
  `dateLeave` date NOT NULL COMMENT '离厂时间',
  `IDCard` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '身份证号',
  `imageUrl` varchar(20) CHARACTER SET ujis COLLATE ujis_bin NOT NULL COMMENT '图片地址'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `jichu_gongxu`
--

CREATE TABLE IF NOT EXISTS `jichu_gongxu` (
`id` int(10) NOT NULL,
  `gongxuCode` varchar(20) COLLATE utf8_bin NOT NULL,
  `gongxuName` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='工序表(设置工艺时用)';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_gongyi`
--

CREATE TABLE IF NOT EXISTS `jichu_gongyi` (
`id` int(11) NOT NULL,
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '前处理|染色|后处理',
  `gongyiName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工艺名称',
  `memo` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `jichu_gongyi2ware`
--

CREATE TABLE IF NOT EXISTS `jichu_gongyi2ware` (
`id` int(10) NOT NULL,
  `classId` int(5) NOT NULL COMMENT '工艺类型（1为前理，2染色，3后处理）',
  `gongyiId` int(10) NOT NULL COMMENT '处方ID',
  `wareId` int(10) NOT NULL COMMENT '纱支ID',
  `unitKg` float(5,1) NOT NULL COMMENT '单位用量',
  `unit` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '单位',
  `tmp` int(5) NOT NULL COMMENT '温度',
  `timeRs` int(5) NOT NULL COMMENT '时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='工艺明细表';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_print`
--

CREATE TABLE IF NOT EXISTS `jichu_print` (
`id` int(10) NOT NULL,
  `ip` varchar(30) COLLATE utf8_bin NOT NULL,
  `rowHeight` int(10) NOT NULL,
  `offsetLeft` int(10) NOT NULL,
  `offsetTop` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `jichu_salekind`
--

CREATE TABLE IF NOT EXISTS `jichu_salekind` (
`id` int(10) NOT NULL,
  `kindName` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '类别名称',
  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='销售产品大类';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_stcar`
--

CREATE TABLE IF NOT EXISTS `jichu_stcar` (
`id` int(10) NOT NULL,
  `carCode` char(10) COLLATE utf8_bin NOT NULL COMMENT '车编号',
  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='松筒车档案';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_supplier`
--

CREATE TABLE IF NOT EXISTS `jichu_supplier` (
`id` int(10) NOT NULL,
  `compCode` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '供应商编码',
  `compName` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '供应商名称',
  `people` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `fax` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '传真',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `accountId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '账号',
  `taxId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '税号',
  `address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `jichu_tongxun`
--

CREATE TABLE IF NOT EXISTS `jichu_tongxun` (
`id` int(11) NOT NULL,
  `proName` varchar(20) COLLATE utf8_bin NOT NULL,
  `tel` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='通讯录';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_vat`
--

CREATE TABLE IF NOT EXISTS `jichu_vat` (
`id` int(10) NOT NULL,
  `vatCode` char(10) COLLATE utf8_bin NOT NULL COMMENT '染缸编号',
  `minKg` int(8) NOT NULL COMMENT '最小公斤数',
  `maxKg` int(8) NOT NULL COMMENT '最大公斤数',
  `cntTongzi` smallint(4) NOT NULL COMMENT '筒子数',
  `orderLine` smallint(4) NOT NULL COMMENT '排列序号',
  `minYubi` float(10,2) NOT NULL COMMENT '最小浴比',
  `maxYubi` float(10,2) NOT NULL COMMENT '最大浴比',
  `shuiRong` float(10,2) NOT NULL COMMENT '水容量',
  `shuiRong1` decimal(10,2) NOT NULL,
  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='染缸档案';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_vehicle`
--

CREATE TABLE IF NOT EXISTS `jichu_vehicle` (
`id` int(10) NOT NULL,
  `carCode` char(10) COLLATE utf8_bin NOT NULL COMMENT '车编号',
  `people` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '联系人姓名，多人用; 隔开',
  `tel` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '电话',
  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='车辆档案';

-- --------------------------------------------------------

--
-- 表的结构 `jichu_ware`
--

CREATE TABLE IF NOT EXISTS `jichu_ware` (
`id` int(11) NOT NULL,
  `parentId` int(10) NOT NULL,
  `wareName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '品名',
  `guige` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '规格',
  `unit` char(10) COLLATE utf8_bin NOT NULL COMMENT '计量单位',
  `cntMin` float(10,2) NOT NULL COMMENT '最小库存',
  `cntMax` float(10,2) NOT NULL COMMENT '最大库存',
  `leftId` int(10) NOT NULL,
  `rightId` int(10) NOT NULL,
  `mnemocode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `isDel` int(1) NOT NULL DEFAULT '0' COMMENT '1表示删除',
  `orderLine` smallint(4) NOT NULL COMMENT '排列顺序',
  `isOfften` tinyint(1) NOT NULL COMMENT '是否常用坯纱规格',
  `danjia` decimal(10,2) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='仓库货品档案';

--
-- 转存表中的数据 `jichu_ware`
--

INSERT INTO `jichu_ware` (`id`, `parentId`, `wareName`, `guige`, `unit`, `cntMin`, `cntMax`, `leftId`, `rightId`, `mnemocode`, `isDel`, `orderLine`, `isOfften`, `danjia`) VALUES
(1, -1, '_#_ROOT_NODE_#_', '', '', 0.00, 0.00, 1, 10, '', 0, 0, 0, '0.00'),
(2, 0, '坯纱', '', 'KG', 0.00, 0.00, 2, 3, '', 0, 0, 0, '0.00'),
(5, 0, '染料助剂', '', '', 0.00, 0.00, 4, 9, '', 0, 0, 0, '0.00'),
(6, 5, '染料类', '', '', 0.00, 0.00, 5, 6, '', 0, 0, 0, '0.00'),
(7, 5, '助剂类', '', '', 0.00, 0.00, 7, 8, '', 0, 0, 0, '0.00');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_ware_wujin`
--

CREATE TABLE IF NOT EXISTS `jichu_ware_wujin` (
`id` int(11) NOT NULL,
  `parentId` int(10) NOT NULL,
  `wareName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '品名',
  `guige` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '规格',
  `unit` char(10) COLLATE utf8_bin NOT NULL COMMENT '计量单位',
  `cntMin` float(10,2) NOT NULL COMMENT '最小库存',
  `cntMax` float(10,2) NOT NULL COMMENT '最大库存',
  `leftId` int(10) NOT NULL,
  `rightId` int(10) NOT NULL,
  `mnemocode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `isDel` int(1) NOT NULL DEFAULT '0' COMMENT '1表示删除'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='五金仓库货品档案';

-- --------------------------------------------------------

--
-- 表的结构 `oa_message`
--

CREATE TABLE IF NOT EXISTS `oa_message` (
`id` int(10) NOT NULL,
  `classId` int(10) NOT NULL COMMENT '类别ID',
  `title` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `buildDate` date NOT NULL COMMENT '发布日期',
  `gangId` int(10) NOT NULL COMMENT '相关缸号',
  `userId` int(10) NOT NULL COMMENT '发布人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `oa_message_class`
--

CREATE TABLE IF NOT EXISTS `oa_message_class` (
`id` int(10) NOT NULL,
  `className` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '类别名称'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `oa_sm`
--

CREATE TABLE IF NOT EXISTS `oa_sm` (
`id` int(10) NOT NULL,
  `reUserId` int(10) NOT NULL COMMENT '收件人ID',
  `sendDate` date NOT NULL COMMENT '发送日期',
  `title` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `sendUserId` int(10) NOT NULL COMMENT '发件人ID',
  `state` tinyint(1) NOT NULL COMMENT '是否已阅读'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `other_newcode`
--

CREATE TABLE IF NOT EXISTS `other_newcode` (
`id` int(10) NOT NULL COMMENT 'ID',
  `type` smallint(1) NOT NULL COMMENT '编码类型, 1表示缸号',
  `code` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '编码'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `plan_dye_gang`
--

CREATE TABLE IF NOT EXISTS `plan_dye_gang` (
`id` int(10) NOT NULL,
  `planDate` date NOT NULL COMMENT '排计划日期',
  `order2wareId` int(10) NOT NULL,
  `vatNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '系统自动生成的逻辑 缸号',
  `cntJ` decimal(10,2) NOT NULL,
  `cntW` decimal(10,2) NOT NULL,
  `cntPlanTouliao` decimal(10,2) NOT NULL COMMENT '计划投料',
  `zhelv` decimal(5,2) NOT NULL COMMENT '折率',
  `pihao` smallint(1) NOT NULL COMMENT '批号',
  `vatId` smallint(2) NOT NULL COMMENT '物理缸号',
  `planTongzi` smallint(4) NOT NULL COMMENT '计划筒子数,输入值',
  `unitKg` decimal(3,2) NOT NULL COMMENT '每个筒子计划重量,一般为0.8',
  `parentGangId` int(10) NOT NULL COMMENT '出问题导致回修的缸号',
  `reasonHuixiu` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '回修原因',
  `dateAssign` date NOT NULL COMMENT '分配哪天染色',
  `dateAssign1` date NOT NULL COMMENT '双染的第二缸染色日期',
  `isJiaji` tinyint(1) NOT NULL COMMENT '是否加急',
  `ranseBanci` tinyint(1) NOT NULL DEFAULT '1' COMMENT '班次, 1为早班, 2为晚班',
  `ranseBanci1` tinyint(1) NOT NULL DEFAULT '1' COMMENT '双染第二次染色的班次',
  `fensanOver` smallint(1) NOT NULL COMMENT '双染时，分散工序是否完成',
  `dateLingsha` date NOT NULL COMMENT '领纱时间 ',
  `lingshaBanci` tinyint(1) NOT NULL DEFAULT '1' COMMENT '领纱班次',
  `timesPrint` smallint(2) NOT NULL COMMENT '打印次数',
  `markTwice` smallint(1) NOT NULL COMMENT '0未设置,1:分散+套棉,2:套棉,3分散连套',
  `rsZhelv` decimal(4,2) NOT NULL DEFAULT '1.00' COMMENT '染色折率',
  `shuirong` int(10) NOT NULL COMMENT '水容',
  `mergeId` int(10) NOT NULL COMMENT '合并处方的id',
  `binggangId` int(11) NOT NULL COMMENT '并缸id',
  `mergeChufangId` int(10) NOT NULL COMMENT '被合并的处方id',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `dateDuizhang` date NOT NULL,
  `stOver` tinyint(1) NOT NULL COMMENT '松筒完成标记',
  `zclOver` tinyint(1) NOT NULL COMMENT '装出笼完成标记',
  `rsOver` tinyint(1) NOT NULL COMMENT '染色完成标记',
  `hsOver` tinyint(1) NOT NULL COMMENT '烘纱完成标记',
  `hdOver` tinyint(1) NOT NULL COMMENT '回倒完成标记',
  `dbOver` tinyint(1) NOT NULL COMMENT '打包完成标记'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='筒染分缸计划和 流转卡一一对应';

-- --------------------------------------------------------

--
-- 表的结构 `plan_dye_gang_merge`
--

CREATE TABLE IF NOT EXISTS `plan_dye_gang_merge` (
`id` int(11) NOT NULL,
  `vatId` int(11) NOT NULL,
  `dateAssign` date NOT NULL,
  `dateAssign1` date NOT NULL,
  `ranseBanci` int(11) NOT NULL,
  `ransebBanci1` int(11) NOT NULL,
  `isJiaji` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='合并缸表';

-- --------------------------------------------------------

--
-- 表的结构 `sql_log`
--

CREATE TABLE IF NOT EXISTS `sql_log` (
`id` int(11) NOT NULL,
  `sql` varchar(200) COLLATE utf8_bin NOT NULL COMMENT 'SQL语句',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='数据库操作';

-- --------------------------------------------------------

--
-- 表的结构 `sys_compinfo`
--

CREATE TABLE IF NOT EXISTS `sys_compinfo` (
`id` int(10) NOT NULL COMMENT 'ID',
  `compCode` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '公司编码',
  `compName` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '公司名称',
  `primaryBusiness` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '公司主营业务',
  `people` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `fax` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '传真',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `accountId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '帐号',
  `taxId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '税号',
  `address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='帐套信息表';

-- --------------------------------------------------------

--
-- 表的结构 `sys_print`
--

CREATE TABLE IF NOT EXISTS `sys_print` (
`id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL COMMENT '要打印的字段名称',
  `left` int(11) NOT NULL COMMENT '左边距',
  `top` int(11) NOT NULL COMMENT '上边距',
  `isPrint` tinyint(4) NOT NULL COMMENT '是否打印'
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sys_print`
--

INSERT INTO `sys_print` (`id`, `name`, `left`, `top`, `isPrint`) VALUES
(104, 'offsetXY', 5, 2, 0),
(105, 'printDate', 21, 33, 1),
(106, 'vatNum', 96, 40, 1),
(107, 'compName', 30, 40, 1),
(108, 'cntPlanTouliao', 30, 70, 1),
(109, 'chandi', 30, 64, 1),
(110, 'guige', 56, 56, 1),
(111, 'planTongzi', 72, 70, 1),
(112, 'color', 96, 56, 1),
(113, 'colorNum', 96, 48, 1),
(114, 'vatCode', 113, 78, 1),
(115, 'unitKg', 113, 70, 1),
(116, 'huidao', 77, 86, 1),
(117, 'honggan', 30, 86, 1),
(118, 'orderCode', 30, 48, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sys_setup`
--

CREATE TABLE IF NOT EXISTS `sys_setup` (
`id` int(10) NOT NULL,
  `setName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '设置名称',
  `setValue` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '设置值'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='系统基本设置';

--
-- 转存表中的数据 `sys_setup`
--

INSERT INTO `sys_setup` (`id`, `setName`, `setValue`) VALUES
(1, 'PaigangXiguan', '1'),
(2, 'PageSize', '14');

-- --------------------------------------------------------

--
-- 表的结构 `trade_dye_order`
--

CREATE TABLE IF NOT EXISTS `trade_dye_order` (
`id` int(10) NOT NULL,
  `orderCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '合同编码',
  `orderCode2` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户合同号（自定议）',
  `clientId` int(10) NOT NULL,
  `traderId` int(10) NOT NULL COMMENT '业务员主键',
  `dateOrder` date NOT NULL COMMENT '签约日期',
  `dateJiaohuo` date NOT NULL COMMENT '交货日期',
  `saleKind` int(10) NOT NULL COMMENT '产品大类',
  `zhiliang` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '质量要求登记',
  `honggan` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '烘干要求',
  `fastness_gan` smallint(1) NOT NULL COMMENT '干磨色牢度登记',
  `fastness_shi` smallint(1) NOT NULL COMMENT '湿磨色牢度登记',
  `fastness_baizhan` smallint(1) NOT NULL COMMENT '白沾色牢度登记',
  `fastness_tuise` smallint(1) NOT NULL COMMENT '褪色色牢度登记',
  `huidao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '回倒要求',
  `packing_zhiguan` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '包装纸管要求',
  `packing_suliao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '包装塑料袋要求',
  `packing_out` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '外包装要求',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '客户特别要求',
  `isKongnian` smallint(1) NOT NULL COMMENT '是否空捻',
  `ranshaNum` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '染纱计划单号',
  `kind` int(1) NOT NULL COMMENT ' 0为加工，1为经销'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='筒染业务订单';

-- --------------------------------------------------------

--
-- 表的结构 `trade_dye_order2ware`
--

CREATE TABLE IF NOT EXISTS `trade_dye_order2ware` (
`id` int(10) NOT NULL,
  `manuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '生产编号',
  `orderId` int(10) NOT NULL COMMENT '订单主表id',
  `wareId` int(10) NOT NULL COMMENT '坯纱货品档案id',
  `chandi` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '坯纱产地',
  `color` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '颜色',
  `colorNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '色号',
  `cntKgJ` decimal(10,1) NOT NULL COMMENT '经纱用量',
  `cntKgW` decimal(10,1) NOT NULL COMMENT '纬纱用量',
  `cntKg` decimal(10,1) NOT NULL,
  `danjia` decimal(5,2) NOT NULL,
  `money` decimal(10,3) NOT NULL COMMENT '金额',
  `personDayang` int(10) NOT NULL COMMENT '打样人',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL,
  `dateDuizhang` date NOT NULL COMMENT '对账日期',
  `randanShazhi` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '染单纱支(对应主表染纱计划单号)',
  `isComplete` tinyint(4) NOT NULL COMMENT '标记处方完成'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='筒染订单从表';

-- --------------------------------------------------------

--
-- 替换视图以便查看 `view_cangku_chuku`
--
CREATE TABLE IF NOT EXISTS `view_cangku_chuku` (
`gangId` int(10)
,`chukuNum` varchar(20)
,`chukuDate` date
,`depId` int(10)
,`memo` varchar(100)
,`id` int(10)
,`chukuId` int(10)
,`wareId` int(10)
,`danjia` decimal(10,3)
,`cnt` decimal(10,3)
,`chandi` varchar(20)
,`money` decimal(20,6)
,`supplierId` int(10)
,`kind` int(1)
);
-- --------------------------------------------------------

--
-- 替换视图以便查看 `view_cangku_ruku`
--
CREATE TABLE IF NOT EXISTS `view_cangku_ruku` (
`isTuiku` int(1)
,`ruKuId` int(10)
,`ruKuNum` varchar(20)
,`songhuoCode` varchar(20)
,`ruKuDate` date
,`supplierId` int(10)
,`memo` varchar(100)
,`tag` tinyint(4)
,`id` int(10)
,`purchase2wareId` int(10)
,`wareId` int(10)
,`chandi` varchar(100)
,`danJia` decimal(10,3)
,`cnt` decimal(10,3)
,`invoiceId` int(10)
,`kind` int(1)
);
-- --------------------------------------------------------

--
-- 替换视图以便查看 `view_dye_all`
--
CREATE TABLE IF NOT EXISTS `view_dye_all` (
`clientId` int(10)
,`compName` varchar(40)
,`wareId` int(11)
,`wareName` varchar(20)
,`guige` varchar(100)
,`order2wareId` int(10)
,`color` varchar(20)
,`colorNum` varchar(20)
,`cntKg` decimal(10,1)
,`orderId` int(10)
,`orderCode` varchar(20)
,`orderCode2` varchar(20)
,`dateOrder` date
,`dateJiaohuo` date
,`gangId` int(10)
,`planDate` date
,`vatNum` varchar(20)
,`cntPlanTouliao` decimal(10,2)
,`planTongzi` smallint(4)
,`unitKg` decimal(3,2)
,`parentGangId` int(10)
,`zhelv` decimal(5,2)
,`markTwice` smallint(1)
,`ranseBanci` tinyint(1)
,`ranseBanci1` tinyint(1)
,`dateAssign` date
,`dateAssign1` date
,`dateLingsha` date
,`lingshaBanci` tinyint(1)
,`timesPrint` smallint(2)
,`vatId` int(10)
,`vatCode` char(10)
);
-- --------------------------------------------------------

--
-- 替换视图以便查看 `view_dye_cpck_ar`
--
CREATE TABLE IF NOT EXISTS `view_dye_cpck_ar` (
`id` int(10)
,`dateCpck` date
,`cntChuku` decimal(10,2)
,`jingKg` decimal(10,2)
,`cntJian` int(5)
,`cntTongzi` int(5)
,`cntSecond` decimal(10,1)
,`dt` timestamp
,`vatNum` varchar(20)
,`parentGangId` int(10)
,`cntPlanTouliao` decimal(10,2)
,`pihao` smallint(1)
,`vatId` smallint(2)
,`unitKg` decimal(3,2)
,`manuCode` varchar(20)
,`wareId` int(10)
,`color` varchar(20)
,`colorNum` varchar(20)
,`cntKg` decimal(10,1)
,`danjia` decimal(5,2)
,`money` decimal(10,3)
,`orderCode` varchar(20)
,`clientId` int(10)
,`dateOrder` date
,`dateJiaohuo` date
);
-- --------------------------------------------------------

--
-- 替换视图以便查看 `view_dye_gang`
--
CREATE TABLE IF NOT EXISTS `view_dye_gang` (
`clientId` int(10)
,`compName` varchar(40)
,`wareId` int(11)
,`wareName` varchar(20)
,`guige` varchar(100)
,`order2wareId` int(10)
,`color` varchar(20)
,`colorNum` varchar(20)
,`cntKg` decimal(10,1)
,`personDayang` int(10)
,`orderId` int(10)
,`orderKind` int(1)
,`orderCode` varchar(20)
,`orderCode2` varchar(20)
,`dateOrder` date
,`dateJiaohuo` date
,`gangId` int(10)
,`planDate` date
,`vatNum` varchar(20)
,`binggangId` int(11)
,`cntPlanTouliao` decimal(10,2)
,`planTongzi` smallint(4)
,`unitKg` decimal(3,2)
,`parentGangId` int(10)
,`reasonHuixiu` varchar(100)
,`zhelv` decimal(5,2)
,`markTwice` smallint(1)
,`fensanOver` smallint(1)
,`ranseBanci` tinyint(1)
,`ranseBanci1` tinyint(1)
,`dateAssign` date
,`dateAssign1` date
,`dateLingsha` date
,`lingshaBanci` tinyint(1)
,`timesPrint` smallint(2)
,`mergeId` int(10)
,`mergeChufangId` int(10)
,`isJiaji` tinyint(1)
,`stOver` tinyint(1)
,`zclOver` tinyint(1)
,`rsOver` tinyint(1)
,`hsOver` tinyint(1)
,`hdOver` tinyint(1)
,`dbOver` tinyint(1)
,`vatId` int(10)
,`vatCode` char(10)
,`maxKg` int(8)
);
-- --------------------------------------------------------

--
-- 替换视图以便查看 `view_yl_chuku`
--
CREATE TABLE IF NOT EXISTS `view_yl_chuku` (
`kind` int(11)
,`chuKuNum` varchar(20)
,`chuKuDate` date
,`depId` int(10)
,`memo` varchar(100)
,`id` int(10)
,`chukuId` int(10)
,`wareId` int(10)
,`danjia` decimal(10,4)
,`cnt` decimal(10,4)
,`money` decimal(15,2)
);
-- --------------------------------------------------------

--
-- 替换视图以便查看 `view_yl_ruku`
--
CREATE TABLE IF NOT EXISTS `view_yl_ruku` (
`ruKuNum` varchar(20)
,`ruKuDate` date
,`supplierId` int(10)
,`memo` varchar(100)
,`songhuoCode` varchar(20)
,`id` int(10)
,`rukuId` int(10)
,`wareId` int(10)
,`chandi` varchar(100)
,`danjia` decimal(10,4)
,`cnt` decimal(10,3)
,`invoiceId` int(10)
);
-- --------------------------------------------------------

--
-- 视图结构 `view_cangku_chuku`
--
DROP TABLE IF EXISTS `view_cangku_chuku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_cangku_chuku` AS select `x`.`gangId` AS `gangId`,`y`.`chukuNum` AS `chukuNum`,`y`.`chukuDate` AS `chukuDate`,`y`.`depId` AS `depId`,`y`.`memo` AS `memo`,`x`.`id` AS `id`,`x`.`chukuId` AS `chukuId`,`x`.`wareId` AS `wareId`,`x`.`danjia` AS `danjia`,`x`.`cnt` AS `cnt`,`x`.`chandi` AS `chandi`,(`x`.`cnt` * `x`.`danjia`) AS `money`,`x`.`supplierId` AS `supplierId`,`x`.`kind` AS `kind` from (`cangku_chuku2ware` `x` join `cangku_chuku` `y` on((`x`.`chukuId` = `y`.`id`)));

-- --------------------------------------------------------

--
-- 视图结构 `view_cangku_ruku`
--
DROP TABLE IF EXISTS `view_cangku_ruku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_cangku_ruku` AS select `y`.`isTuiku` AS `isTuiku`,`y`.`id` AS `ruKuId`,`y`.`ruKuNum` AS `ruKuNum`,`y`.`songhuoCode` AS `songhuoCode`,`y`.`ruKuDate` AS `ruKuDate`,`y`.`supplierId` AS `supplierId`,`y`.`memo` AS `memo`,`y`.`tag` AS `tag`,`x`.`id` AS `id`,`x`.`purchase2wareId` AS `purchase2wareId`,`x`.`wareId` AS `wareId`,`x`.`chandi` AS `chandi`,`x`.`danJia` AS `danJia`,`x`.`cnt` AS `cnt`,`x`.`invoiceId` AS `invoiceId`,`y`.`kind` AS `kind` from (`cangku_ruku` `y` join `cangku_ruku2ware` `x` on((`x`.`ruKuId` = `y`.`id`)));

-- --------------------------------------------------------

--
-- 视图结构 `view_dye_all`
--
DROP TABLE IF EXISTS `view_dye_all`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_dye_all` AS (select `n`.`id` AS `clientId`,`n`.`compName` AS `compName`,`m`.`id` AS `wareId`,`m`.`wareName` AS `wareName`,`m`.`guige` AS `guige`,`y`.`id` AS `order2wareId`,`y`.`color` AS `color`,`y`.`colorNum` AS `colorNum`,`y`.`cntKg` AS `cntKg`,`z`.`id` AS `orderId`,`z`.`orderCode` AS `orderCode`,`z`.`orderCode2` AS `orderCode2`,`z`.`dateOrder` AS `dateOrder`,`z`.`dateJiaohuo` AS `dateJiaohuo`,`x`.`id` AS `gangId`,`x`.`planDate` AS `planDate`,`x`.`vatNum` AS `vatNum`,`x`.`cntPlanTouliao` AS `cntPlanTouliao`,`x`.`planTongzi` AS `planTongzi`,`x`.`unitKg` AS `unitKg`,`x`.`parentGangId` AS `parentGangId`,`x`.`zhelv` AS `zhelv`,`x`.`markTwice` AS `markTwice`,`x`.`ranseBanci` AS `ranseBanci`,`x`.`ranseBanci1` AS `ranseBanci1`,`x`.`dateAssign` AS `dateAssign`,`x`.`dateAssign1` AS `dateAssign1`,`x`.`dateLingsha` AS `dateLingsha`,`x`.`lingshaBanci` AS `lingshaBanci`,`x`.`timesPrint` AS `timesPrint`,`t`.`id` AS `vatId`,`t`.`vatCode` AS `vatCode` from (((((`trade_dye_order` `z` left join `trade_dye_order2ware` `y` on((`y`.`orderId` = `z`.`id`))) left join `plan_dye_gang` `x` on((`x`.`order2wareId` = `y`.`id`))) left join `jichu_ware` `m` on((`y`.`wareId` = `m`.`id`))) left join `jichu_client` `n` on((`z`.`clientId` = `n`.`id`))) left join `jichu_vat` `t` on((`x`.`vatId` = `t`.`id`))));

-- --------------------------------------------------------

--
-- 视图结构 `view_dye_cpck_ar`
--
DROP TABLE IF EXISTS `view_dye_cpck_ar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_dye_cpck_ar` AS (select `x`.`id` AS `id`,`x`.`dateCpck` AS `dateCpck`,`x`.`cntChuku` AS `cntChuku`,`x`.`jingKg` AS `jingKg`,`x`.`cntJian` AS `cntJian`,`x`.`cntTongzi` AS `cntTongzi`,`x`.`cntSecond` AS `cntSecond`,`x`.`dt` AS `dt`,`y`.`vatNum` AS `vatNum`,`y`.`parentGangId` AS `parentGangId`,`y`.`cntPlanTouliao` AS `cntPlanTouliao`,`y`.`pihao` AS `pihao`,`y`.`vatId` AS `vatId`,`y`.`unitKg` AS `unitKg`,`z`.`manuCode` AS `manuCode`,`z`.`wareId` AS `wareId`,`z`.`color` AS `color`,`z`.`colorNum` AS `colorNum`,`z`.`cntKg` AS `cntKg`,`z`.`danjia` AS `danjia`,`z`.`money` AS `money`,`m`.`orderCode` AS `orderCode`,`m`.`clientId` AS `clientId`,`m`.`dateOrder` AS `dateOrder`,`m`.`dateJiaohuo` AS `dateJiaohuo` from (((`chengpin_dye_cpck` `x` left join `plan_dye_gang` `y` on((`x`.`planId` = `y`.`id`))) join `trade_dye_order2ware` `z` on((`y`.`order2wareId` = `z`.`id`))) join `trade_dye_order` `m` on((`z`.`orderId` = `m`.`id`))));

-- --------------------------------------------------------

--
-- 视图结构 `view_dye_gang`
--
DROP TABLE IF EXISTS `view_dye_gang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_dye_gang` AS (select `n`.`id` AS `clientId`,`n`.`compName` AS `compName`,`m`.`id` AS `wareId`,`m`.`wareName` AS `wareName`,`m`.`guige` AS `guige`,`y`.`id` AS `order2wareId`,`y`.`color` AS `color`,`y`.`colorNum` AS `colorNum`,`y`.`cntKg` AS `cntKg`,`y`.`personDayang` AS `personDayang`,`z`.`id` AS `orderId`,`z`.`kind` AS `orderKind`,`z`.`orderCode` AS `orderCode`,`z`.`orderCode2` AS `orderCode2`,`z`.`dateOrder` AS `dateOrder`,`z`.`dateJiaohuo` AS `dateJiaohuo`,`x`.`id` AS `gangId`,`x`.`planDate` AS `planDate`,`x`.`vatNum` AS `vatNum`,`x`.`binggangId` AS `binggangId`,`x`.`cntPlanTouliao` AS `cntPlanTouliao`,`x`.`planTongzi` AS `planTongzi`,`x`.`unitKg` AS `unitKg`,`x`.`parentGangId` AS `parentGangId`,`x`.`reasonHuixiu` AS `reasonHuixiu`,`x`.`zhelv` AS `zhelv`,`x`.`markTwice` AS `markTwice`,`x`.`fensanOver` AS `fensanOver`,`x`.`ranseBanci` AS `ranseBanci`,`x`.`ranseBanci1` AS `ranseBanci1`,`x`.`dateAssign` AS `dateAssign`,`x`.`dateAssign1` AS `dateAssign1`,`x`.`dateLingsha` AS `dateLingsha`,`x`.`lingshaBanci` AS `lingshaBanci`,`x`.`timesPrint` AS `timesPrint`,`x`.`mergeId` AS `mergeId`,`x`.`mergeChufangId` AS `mergeChufangId`,`x`.`isJiaji` AS `isJiaji`,`x`.`stOver` AS `stOver`,`x`.`zclOver` AS `zclOver`,`x`.`rsOver` AS `rsOver`,`x`.`hsOver` AS `hsOver`,`x`.`hdOver` AS `hdOver`,`x`.`dbOver` AS `dbOver`,`t`.`id` AS `vatId`,`t`.`vatCode` AS `vatCode`,`t`.`maxKg` AS `maxKg` from (((((`plan_dye_gang` `x` left join `trade_dye_order2ware` `y` on((`x`.`order2wareId` = `y`.`id`))) join `trade_dye_order` `z` on((`y`.`orderId` = `z`.`id`))) join `jichu_ware` `m` on((`y`.`wareId` = `m`.`id`))) join `jichu_client` `n` on((`z`.`clientId` = `n`.`id`))) left join `jichu_vat` `t` on((`x`.`vatId` = `t`.`id`))));

-- --------------------------------------------------------

--
-- 视图结构 `view_yl_chuku`
--
DROP TABLE IF EXISTS `view_yl_chuku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_yl_chuku` AS (select `y`.`kind` AS `kind`,`y`.`chukuNum` AS `chuKuNum`,`y`.`chukuDate` AS `chuKuDate`,`y`.`depId` AS `depId`,`y`.`memo` AS `memo`,`x`.`id` AS `id`,`x`.`chukuId` AS `chukuId`,`x`.`wareId` AS `wareId`,`x`.`danjia` AS `danjia`,`x`.`cnt` AS `cnt`,`x`.`money` AS `money` from (`cangku_yl_chuku2ware` `x` left join `cangku_yl_chuku` `y` on((`x`.`chukuId` = `y`.`id`))));

-- --------------------------------------------------------

--
-- 视图结构 `view_yl_ruku`
--
DROP TABLE IF EXISTS `view_yl_ruku`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_yl_ruku` AS (select `y`.`rukuNum` AS `ruKuNum`,`y`.`rukuDate` AS `ruKuDate`,`y`.`supplierId` AS `supplierId`,`y`.`memo` AS `memo`,`y`.`songhuoCode` AS `songhuoCode`,`x`.`id` AS `id`,`x`.`rukuId` AS `rukuId`,`x`.`wareId` AS `wareId`,`x`.`chandi` AS `chandi`,`x`.`danjia` AS `danjia`,`x`.`cnt` AS `cnt`,`x`.`invoiceId` AS `invoiceId` from (`cangku_yl_ruku2ware` `x` left join `cangku_yl_ruku` `y` on((`x`.`rukuId` = `y`.`id`))));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acm_func2role`
--
ALTER TABLE `acm_func2role`
 ADD PRIMARY KEY (`id`), ADD KEY `FuncId` (`funcId`), ADD KEY `RoleId` (`roleId`);

--
-- Indexes for table `acm_funcdb`
--
ALTER TABLE `acm_funcdb`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acm_roledb`
--
ALTER TABLE `acm_roledb`
 ADD PRIMARY KEY (`id`), ADD KEY `GroupName` (`roleName`);

--
-- Indexes for table `acm_user2role`
--
ALTER TABLE `acm_user2role`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UserId` (`userId`,`roleId`);

--
-- Indexes for table `acm_userdb`
--
ALTER TABLE `acm_userdb`
 ADD PRIMARY KEY (`id`), ADD KEY `UserId` (`userName`);

--
-- Indexes for table `caiwu_accountitem`
--
ALTER TABLE `caiwu_accountitem`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caiwu_artype`
--
ALTER TABLE `caiwu_artype`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caiwu_ar_init`
--
ALTER TABLE `caiwu_ar_init`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `clientId` (`clientId`);

--
-- Indexes for table `caiwu_ar_other`
--
ALTER TABLE `caiwu_ar_other`
 ADD PRIMARY KEY (`id`), ADD KEY `clientId` (`clientId`);

--
-- Indexes for table `caiwu_expense`
--
ALTER TABLE `caiwu_expense`
 ADD PRIMARY KEY (`id`), ADD KEY `dateExpense` (`dateExpense`);

--
-- Indexes for table `caiwu_expenseitem`
--
ALTER TABLE `caiwu_expenseitem`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caiwu_income`
--
ALTER TABLE `caiwu_income`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `caiwu_invoice`
--
ALTER TABLE `caiwu_invoice`
 ADD PRIMARY KEY (`id`), ADD KEY `code` (`invoiceNum`), ADD KEY `dateInput` (`dateInput`), ADD KEY `supplierId` (`supplierId`), ADD KEY `paymentId` (`paymentId`);

--
-- Indexes for table `caiwu_payment`
--
ALTER TABLE `caiwu_payment`
 ADD PRIMARY KEY (`id`), ADD KEY `datePay` (`datePay`), ADD KEY `supplierId` (`supplierId`);

--
-- Indexes for table `caiwu_yf_init`
--
ALTER TABLE `caiwu_yf_init`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `supplierId` (`supplierId`);

--
-- Indexes for table `caiwu_yf_other`
--
ALTER TABLE `caiwu_yf_other`
 ADD PRIMARY KEY (`id`), ADD KEY `dateRecord` (`dateRecord`);

--
-- Indexes for table `caiwu_yf_pisha`
--
ALTER TABLE `caiwu_yf_pisha`
 ADD PRIMARY KEY (`id`), ADD KEY `dateRecord` (`dateRecord`), ADD KEY `kind` (`kind`), ADD KEY `supplierId` (`supplierId`);

--
-- Indexes for table `cangku_chuku`
--
ALTER TABLE `cangku_chuku`
 ADD PRIMARY KEY (`id`), ADD KEY `chukuDate` (`chukuDate`);

--
-- Indexes for table `cangku_chuku2ware`
--
ALTER TABLE `cangku_chuku2ware`
 ADD PRIMARY KEY (`id`), ADD KEY `chukuId` (`chukuId`), ADD KEY `gangId` (`gangId`), ADD KEY `supplierId` (`supplierId`), ADD KEY `wareId` (`wareId`);

--
-- Indexes for table `cangku_chuku_log`
--
ALTER TABLE `cangku_chuku_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cangku_dye_pandian`
--
ALTER TABLE `cangku_dye_pandian`
 ADD PRIMARY KEY (`id`), ADD KEY `wareId` (`wareId`);

--
-- Indexes for table `cangku_init`
--
ALTER TABLE `cangku_init`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `wareId` (`wareId`);

--
-- Indexes for table `cangku_ruku`
--
ALTER TABLE `cangku_ruku`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `ruKuNum` (`ruKuNum`), ADD KEY `ruKuDate` (`ruKuDate`), ADD KEY `supplierId` (`supplierId`);

--
-- Indexes for table `cangku_ruku2ware`
--
ALTER TABLE `cangku_ruku2ware`
 ADD PRIMARY KEY (`id`), ADD KEY `purchase2wareId` (`purchase2wareId`), ADD KEY `ruKuId` (`ruKuId`), ADD KEY `wareId` (`wareId`);

--
-- Indexes for table `cangku_wujin_chuku`
--
ALTER TABLE `cangku_wujin_chuku`
 ADD PRIMARY KEY (`id`), ADD KEY `dateRuku` (`dateChuku`), ADD KEY `wareId` (`wareId`);

--
-- Indexes for table `cangku_wujin_ruku`
--
ALTER TABLE `cangku_wujin_ruku`
 ADD PRIMARY KEY (`id`), ADD KEY `dateRuku` (`dateRuku`), ADD KEY `wareId` (`wareId`);

--
-- Indexes for table `cangku_yl_chuku`
--
ALTER TABLE `cangku_yl_chuku`
 ADD PRIMARY KEY (`id`), ADD KEY `chukuDate` (`chukuDate`), ADD KEY `gangId` (`gangId`), ADD KEY `chufangId` (`chufangId`), ADD KEY `kind` (`kind`);

--
-- Indexes for table `cangku_yl_chuku2ware`
--
ALTER TABLE `cangku_yl_chuku2ware`
 ADD PRIMARY KEY (`id`), ADD KEY `chukuId` (`chukuId`), ADD KEY `wareId` (`wareId`);

--
-- Indexes for table `cangku_yl_ruku`
--
ALTER TABLE `cangku_yl_ruku`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `rukuNum` (`rukuNum`), ADD KEY `rukuDate` (`rukuDate`), ADD KEY `suppId` (`supplierId`);

--
-- Indexes for table `cangku_yl_ruku2ware`
--
ALTER TABLE `cangku_yl_ruku2ware`
 ADD PRIMARY KEY (`id`), ADD KEY `rukuId` (`rukuId`), ADD KEY `wareId` (`wareId`);

--
-- Indexes for table `chengpin_blog2cpck`
--
ALTER TABLE `chengpin_blog2cpck`
 ADD PRIMARY KEY (`id`), ADD KEY `cpckId` (`cpckId`,`blogId`), ADD KEY `blogId` (`blogId`);

--
-- Indexes for table `chengpin_dye_cpck`
--
ALTER TABLE `chengpin_dye_cpck`
 ADD PRIMARY KEY (`id`), ADD KEY `planId` (`planId`), ADD KEY `dateCpck` (`dateCpck`);

--
-- Indexes for table `chengpin_dye_cprk`
--
ALTER TABLE `chengpin_dye_cprk`
 ADD PRIMARY KEY (`id`), ADD KEY `planId` (`planId`), ADD KEY `dateCprk` (`dateCprk`);

--
-- Indexes for table `chengpin_printblog`
--
ALTER TABLE `chengpin_printblog`
 ADD PRIMARY KEY (`id`), ADD KEY `datePrint` (`datePrint`), ADD KEY `cpckCode` (`cpckCode`);

--
-- Indexes for table `color_tishi`
--
ALTER TABLE `color_tishi`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `color` (`color`), ADD KEY `memoCode` (`memoCode`);

--
-- Indexes for table `dye_db_chanliang`
--
ALTER TABLE `dye_db_chanliang`
 ADD PRIMARY KEY (`id`), ADD KEY `gangId` (`gangId`), ADD KEY `dateInput` (`dateInput`);

--
-- Indexes for table `dye_db_chanliang_mx`
--
ALTER TABLE `dye_db_chanliang_mx`
 ADD PRIMARY KEY (`id`), ADD KEY `chanliangId` (`chanliangId`);

--
-- Indexes for table `dye_fanxiu_record`
--
ALTER TABLE `dye_fanxiu_record`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dye_gang2stcar`
--
ALTER TABLE `dye_gang2stcar`
 ADD PRIMARY KEY (`id`), ADD KEY `gangId` (`gangId`), ADD KEY `stcarId` (`stcarId`);

--
-- Indexes for table `dye_hd_chanliang`
--
ALTER TABLE `dye_hd_chanliang`
 ADD PRIMARY KEY (`id`), ADD KEY `gangId` (`gangId`), ADD KEY `dateInput` (`dateInput`);

--
-- Indexes for table `dye_hs_chanliang`
--
ALTER TABLE `dye_hs_chanliang`
 ADD PRIMARY KEY (`id`), ADD KEY `gangId` (`gangId`), ADD KEY `dateInput` (`dateInput`);

--
-- Indexes for table `dye_rs_chanliang`
--
ALTER TABLE `dye_rs_chanliang`
 ADD PRIMARY KEY (`id`), ADD KEY `gangId` (`gangId`), ADD KEY `dateInput` (`dateInput`), ADD KEY `banci` (`banci`);

--
-- Indexes for table `dye_st_chanliang`
--
ALTER TABLE `dye_st_chanliang`
 ADD PRIMARY KEY (`id`), ADD KEY `gang2stcarId` (`gang2stcarId`), ADD KEY `dateInput` (`dateInput`);

--
-- Indexes for table `dye_zcl_chanliang`
--
ALTER TABLE `dye_zcl_chanliang`
 ADD PRIMARY KEY (`id`), ADD KEY `gangId` (`gangId`), ADD KEY `dateInput` (`dateInput`);

--
-- Indexes for table `gongyi_dye_chufang`
--
ALTER TABLE `gongyi_dye_chufang`
 ADD PRIMARY KEY (`id`), ADD KEY `order2wareId` (`order2wareId`), ADD KEY `dateChufang` (`dateChufang`), ADD KEY `chufangren` (`chufangren`);

--
-- Indexes for table `gongyi_dye_chufang2ware`
--
ALTER TABLE `gongyi_dye_chufang2ware`
 ADD PRIMARY KEY (`id`), ADD KEY `chufangId` (`chufangId`), ADD KEY `wareId` (`wareId`);

--
-- Indexes for table `gongyi_dye_merge`
--
ALTER TABLE `gongyi_dye_merge`
 ADD PRIMARY KEY (`id`), ADD KEY `vatId` (`vatId`);

--
-- Indexes for table `jichu_client`
--
ALTER TABLE `jichu_client`
 ADD PRIMARY KEY (`id`), ADD KEY `compName` (`compName`), ADD KEY `compCode` (`compCode`);

--
-- Indexes for table `jichu_client2artype`
--
ALTER TABLE `jichu_client2artype`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_controllog`
--
ALTER TABLE `jichu_controllog`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_department`
--
ALTER TABLE `jichu_department`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_employ`
--
ALTER TABLE `jichu_employ`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_gongxu`
--
ALTER TABLE `jichu_gongxu`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_gongyi`
--
ALTER TABLE `jichu_gongyi`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_gongyi2ware`
--
ALTER TABLE `jichu_gongyi2ware`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_print`
--
ALTER TABLE `jichu_print`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_salekind`
--
ALTER TABLE `jichu_salekind`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_stcar`
--
ALTER TABLE `jichu_stcar`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_supplier`
--
ALTER TABLE `jichu_supplier`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `comp_name` (`compName`), ADD UNIQUE KEY `comp_code` (`compCode`);

--
-- Indexes for table `jichu_tongxun`
--
ALTER TABLE `jichu_tongxun`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_vat`
--
ALTER TABLE `jichu_vat`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_vehicle`
--
ALTER TABLE `jichu_vehicle`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jichu_ware`
--
ALTER TABLE `jichu_ware`
 ADD PRIMARY KEY (`id`), ADD KEY `wareName` (`wareName`), ADD KEY `guige` (`guige`), ADD KEY `orderLine` (`orderLine`);

--
-- Indexes for table `jichu_ware_wujin`
--
ALTER TABLE `jichu_ware_wujin`
 ADD PRIMARY KEY (`id`), ADD KEY `wareName` (`wareName`), ADD KEY `guige` (`guige`);

--
-- Indexes for table `oa_message`
--
ALTER TABLE `oa_message`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oa_message_class`
--
ALTER TABLE `oa_message_class`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oa_sm`
--
ALTER TABLE `oa_sm`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_newcode`
--
ALTER TABLE `other_newcode`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_dye_gang`
--
ALTER TABLE `plan_dye_gang`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `vatNum` (`vatNum`), ADD KEY `order2wareId` (`order2wareId`), ADD KEY `vatId` (`vatId`), ADD KEY `planDate` (`planDate`), ADD KEY `dateAssign` (`dateAssign`), ADD KEY `dateAssign1` (`dateAssign1`);

--
-- Indexes for table `plan_dye_gang_merge`
--
ALTER TABLE `plan_dye_gang_merge`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sql_log`
--
ALTER TABLE `sql_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_compinfo`
--
ALTER TABLE `sys_compinfo`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `compName` (`compName`), ADD KEY `compCode` (`compCode`);

--
-- Indexes for table `sys_print`
--
ALTER TABLE `sys_print`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_setup`
--
ALTER TABLE `sys_setup`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trade_dye_order`
--
ALTER TABLE `trade_dye_order`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trade_dye_order2ware`
--
ALTER TABLE `trade_dye_order2ware`
 ADD PRIMARY KEY (`id`), ADD KEY `manuCode` (`manuCode`), ADD KEY `orderId` (`orderId`), ADD KEY `wareId` (`wareId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acm_func2role`
--
ALTER TABLE `acm_func2role`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `acm_funcdb`
--
ALTER TABLE `acm_funcdb`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=142;
--
-- AUTO_INCREMENT for table `acm_roledb`
--
ALTER TABLE `acm_roledb`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `acm_user2role`
--
ALTER TABLE `acm_user2role`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `acm_userdb`
--
ALTER TABLE `acm_userdb`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `caiwu_accountitem`
--
ALTER TABLE `caiwu_accountitem`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_artype`
--
ALTER TABLE `caiwu_artype`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_ar_init`
--
ALTER TABLE `caiwu_ar_init`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_ar_other`
--
ALTER TABLE `caiwu_ar_other`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_expense`
--
ALTER TABLE `caiwu_expense`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_expenseitem`
--
ALTER TABLE `caiwu_expenseitem`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_income`
--
ALTER TABLE `caiwu_income`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_invoice`
--
ALTER TABLE `caiwu_invoice`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_payment`
--
ALTER TABLE `caiwu_payment`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_yf_init`
--
ALTER TABLE `caiwu_yf_init`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_yf_other`
--
ALTER TABLE `caiwu_yf_other`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `caiwu_yf_pisha`
--
ALTER TABLE `caiwu_yf_pisha`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_chuku`
--
ALTER TABLE `cangku_chuku`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_chuku2ware`
--
ALTER TABLE `cangku_chuku2ware`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_chuku_log`
--
ALTER TABLE `cangku_chuku_log`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_dye_pandian`
--
ALTER TABLE `cangku_dye_pandian`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_init`
--
ALTER TABLE `cangku_init`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_ruku`
--
ALTER TABLE `cangku_ruku`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_ruku2ware`
--
ALTER TABLE `cangku_ruku2ware`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_wujin_chuku`
--
ALTER TABLE `cangku_wujin_chuku`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_wujin_ruku`
--
ALTER TABLE `cangku_wujin_ruku`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_yl_chuku`
--
ALTER TABLE `cangku_yl_chuku`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_yl_chuku2ware`
--
ALTER TABLE `cangku_yl_chuku2ware`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_yl_ruku`
--
ALTER TABLE `cangku_yl_ruku`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cangku_yl_ruku2ware`
--
ALTER TABLE `cangku_yl_ruku2ware`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chengpin_blog2cpck`
--
ALTER TABLE `chengpin_blog2cpck`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chengpin_dye_cpck`
--
ALTER TABLE `chengpin_dye_cpck`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chengpin_dye_cprk`
--
ALTER TABLE `chengpin_dye_cprk`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chengpin_printblog`
--
ALTER TABLE `chengpin_printblog`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `color_tishi`
--
ALTER TABLE `color_tishi`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT for table `dye_db_chanliang`
--
ALTER TABLE `dye_db_chanliang`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dye_db_chanliang_mx`
--
ALTER TABLE `dye_db_chanliang_mx`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dye_fanxiu_record`
--
ALTER TABLE `dye_fanxiu_record`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dye_gang2stcar`
--
ALTER TABLE `dye_gang2stcar`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dye_hd_chanliang`
--
ALTER TABLE `dye_hd_chanliang`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dye_hs_chanliang`
--
ALTER TABLE `dye_hs_chanliang`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dye_rs_chanliang`
--
ALTER TABLE `dye_rs_chanliang`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dye_st_chanliang`
--
ALTER TABLE `dye_st_chanliang`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dye_zcl_chanliang`
--
ALTER TABLE `dye_zcl_chanliang`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gongyi_dye_chufang`
--
ALTER TABLE `gongyi_dye_chufang`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gongyi_dye_chufang2ware`
--
ALTER TABLE `gongyi_dye_chufang2ware`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gongyi_dye_merge`
--
ALTER TABLE `gongyi_dye_merge`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_client`
--
ALTER TABLE `jichu_client`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `jichu_client2artype`
--
ALTER TABLE `jichu_client2artype`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_controllog`
--
ALTER TABLE `jichu_controllog`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_department`
--
ALTER TABLE `jichu_department`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `jichu_employ`
--
ALTER TABLE `jichu_employ`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_gongxu`
--
ALTER TABLE `jichu_gongxu`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_gongyi`
--
ALTER TABLE `jichu_gongyi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_gongyi2ware`
--
ALTER TABLE `jichu_gongyi2ware`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_print`
--
ALTER TABLE `jichu_print`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_salekind`
--
ALTER TABLE `jichu_salekind`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_stcar`
--
ALTER TABLE `jichu_stcar`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_supplier`
--
ALTER TABLE `jichu_supplier`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_tongxun`
--
ALTER TABLE `jichu_tongxun`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_vat`
--
ALTER TABLE `jichu_vat`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_vehicle`
--
ALTER TABLE `jichu_vehicle`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jichu_ware`
--
ALTER TABLE `jichu_ware`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `jichu_ware_wujin`
--
ALTER TABLE `jichu_ware_wujin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oa_message`
--
ALTER TABLE `oa_message`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oa_message_class`
--
ALTER TABLE `oa_message_class`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oa_sm`
--
ALTER TABLE `oa_sm`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `other_newcode`
--
ALTER TABLE `other_newcode`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `plan_dye_gang`
--
ALTER TABLE `plan_dye_gang`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `plan_dye_gang_merge`
--
ALTER TABLE `plan_dye_gang_merge`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sql_log`
--
ALTER TABLE `sql_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_compinfo`
--
ALTER TABLE `sys_compinfo`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `sys_print`
--
ALTER TABLE `sys_print`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT for table `sys_setup`
--
ALTER TABLE `sys_setup`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `trade_dye_order`
--
ALTER TABLE `trade_dye_order`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trade_dye_order2ware`
--
ALTER TABLE `trade_dye_order2ware`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
