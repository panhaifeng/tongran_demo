<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_AnalyseProduct extends Tmis_Controller {
	#申明 CangKu_ChuKu 数据操作类变量
	var $_modelExample;

	#设置当前控制器名
	var $thisController = "CangKu_AnalyseProduct";

	#设置标题
	var $title = "产品库存分析";

	var $funcId = 16;

	/**
 	 * 构造函数.
 	 */
	function Controller_CangKu_AnalyseProduct() {
		if(!$this->authCheck()) die("禁止访问!");
		#实例化 CangKu_ChuKu 数据操作类
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Product');
	}

	function actionExtIndex() {
		require("Lib/App/View/CangKu/AnalyseProduct.php");exit;
	}
	function actionExtList() {
		#搜索条件
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "(x.name like '%$_POST[key]%' or x.guige like '%$_POST[key]%' or x.standardCode like '%$_POST[key]%')" : 1);
		$sql = "select
			x.id,
			x.name,
			x.guige,
			x.material,
			x.standardCode,
			x.danWei,
			ifnull(y.cnt,0)+ifnull(z.cnt,0)-ifnull(m.cnt,0) as cnt
			from jichu_product x
			left join (
				select productId,sum(cnt) cnt
				from cangku_init_product
				group by productId
			) y on x.id=y.productId
			left join (
				select productId,sum(cnt) cnt
				from cangku_ruku2product
				group by productId
			) z on x.id=z.productId
			left join (select productId,sum(cnt) cnt
				from cangku_chuku2product
				group by productId
			) m on x.id=m.productId";
		$sql .= " where $condition";
		//echo $sql;exit;
		//$sql .= " group by x.id";
		//echo $sql;
		/*$sql = "select id, proCode, proName, danWei, qcCnt, qcMoney, rkCnt, rkMoney, ckCnt, ckMoney , qcCnt+rkCnt-ckCnt as cnt, qcMoney+rkCnt-ckCnt as Money
		from

		(
		select cip.id, cip.proCode, cip.proName, cip.danWei, cip.cnt as qcCnt, cip.money as qcMoney, cc2p.cnt as rkCnt, cc2p.money as rkMoney
		from

		(
		select jp.Id, jp.proCode, jp.proName, jp.danWei, cip.cnt, (cip.cnt*cip.danJia) as money
		from jichu_product as jp left join cangku_init_product as cip on jp.id =cip.productId
		) as cip

		left join

		(
		select productId, sum(cnt) as cnt, sum(cnt*danJia) as money
		from CangKu_cpRuKu2product
		group by productId
		) as cc2p
		on cip.id = cc2p.productId
		) as cip_cc2p

		left join
		(
		SELECT  productId,  sum(cnt) as ckCnt, sum(cnt*danJia) as ckMoney
		FROM Sell_ChuKu2Product
		GROUP BY productId
		) as sc2p
		on cip_cc2p.id = sc2p.productId

		where
		";*/
				//$sql .= $condition;
		$count = $this->_modelExample->findCountBySql($sql);
		FLEA::loadClass('TMIS_Pager');
		$pager = & new TMIS_Pager($sql);
		$dbo = FLEA::getDBO(false);
		$pager->setDBO($dbo);
		$pager->setCount($count);
		$rowset = $pager->findAll();
		echo $this->buildExtRecords($count,$rowset);exit;
	}


	/**
 	 * Index.
 	 */
	function actionIndex() {

		#初始化smarty对象,根据config.inc.php的设置进行初始化
		$smarty = & $this->_getView();

		#设置默认日期
		$smarty->assign('default_date',date("Y-m-d"));

		/*#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$pk = $this->_modelCangKuAnalyseProduct->primaryKey;
		$smarty->assign('pk',$pk);	*/

        #设置标题
		$smarty->assign('title', $this->title);

		#自定义显示字段
		$arrFieldInfo = array(
			"proCode" => "产品编码",
			"proName" => "产品名称",
			"qcCnt" => "期初数量",
			"qcMoney" => "期初金额",
			"rkCnt" => "入库数量",
			"rkMoney" => "入库金额",
			"ckCnt" => "出库数量",
			"ckMoney" => "出库金额",
			"cnt" => "库存数量",
			"money" => "库存金额"
		);
		$smarty->assign('arr_field_info',$arrFieldInfo);

		/*#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);*/

		#开始显示
		$smarty->display('CangKu/AnalyseProduct.tpl');

	}




	/**
 	 * 搜索 这个事件是由AnalyseProduct.tpl中的"搜索"按钮触发的.
	 * 产生一个入库单列表
 	 */
	function actionSearch() {
		#搜索条件
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "(proName like '%$_POST[key]%' or proCode like '%$_POST[key]%')" : 1);

		$sql = "select id, proCode, proName, danWei, qcCnt, qcMoney, rkCnt, rkMoney, ckCnt, ckMoney , qcCnt+rkCnt-ckCnt as cnt, qcMoney+rkCnt-ckCnt as Money
		from

		(
		select cip.id, cip.proCode, cip.proName, cip.danWei, cip.cnt as qcCnt, cip.money as qcMoney, cc2p.cnt as rkCnt, cc2p.money as rkMoney
		from

		(
		select jp.Id, jp.proCode, jp.proName, jp.danWei, cip.cnt, (cip.cnt*cip.danJia) as money
		from jichu_product as jp left join cangku_init_product as cip on jp.id =cip.productId
		) as cip

		left join

		(
		select productId, sum(cnt) as cnt, sum(cnt*danJia) as money
		from CangKu_cpRuKu2product
		group by productId
		) as cc2p
		on cip.id = cc2p.productId
		) as cip_cc2p

		left join
		(
		SELECT  productId,  sum(cnt) as ckCnt, sum(cnt*danJia) as ckMoney
		FROM Sell_ChuKu2Product
		GROUP BY productId
		) as sc2p
		on cip_cc2p.id = sc2p.productId

		where
		";
		$sql .= $condition;
		$count = $this->_modelExample->findCountBySql($sql);
		FLEA::loadClass('TMIS_Pager');
		$pager = & new TMIS_Pager($sql);
		$dbo = FLEA::getDBO(false);
		$pager->setDBO($dbo);
		$pager->setCount($count);
		$rowset = $pager->findAll();


		#自定义显示字段
		/*foreach ($rowset as & $value) {
			$value[chuKuNum] = $value[ChuKu][chuKuNum];
			$value[chuKuDate] = $value[ChuKu][chuKuDate];
			$value[proCode] = $value[Product][proCode];
			$value[proName] = $value[Product][proName];
		}*/

		/**下面两句可以用来跟踪所有执行过的sql语句*/
		# $dbo=& get_dbo(false);
		# dump($dbo->log);

		#初始化smarty对象,根据config.inc.php的设置进行初始化
		$smarty = & $this->_getView();

		#设置标题
		$smarty->assign('title', $this->title);

		#设置客户
		$smarty->assign('client_id', $_POST[clientId]);

		#设置日期
		$smarty->assign('date_from', $_POST[date_from]);
		$smarty->assign('date_to', $_POST[date_to]);

		#设置关键字
		$smarty->assign('key', $_POST[key]);

		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk',$pk);

		#对表头进行赋值
		$arrFieldInfo = array(
			"proCode" => "产品编码",
			"proName" => "产品名称",
			"qcCnt" => "期初数量",
			"qcMoney" => "期初金额",
			"rkCnt" => "入库数量",
			"rkMoney" => "入库金额",
			"ckCnt" => "出库数量",
			"ckMoney" => "出库金额",
			"cnt" => "库存数量",
			"money" => "库存金额"
		);
		$smarty->assign('arr_field_info',$arrFieldInfo);

		#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);

		#分页信息
		$smarty->assign('page_info',$pager->getNavBar($this->_url()));

		#开始显示
		$smarty->display('CangKu/AnalyseProduct.tpl');

	}

}
?>