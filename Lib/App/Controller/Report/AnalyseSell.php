<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Report_AnalyseSell extends Tmis_Controller {
	#申明 Sell_ChuKu 数据操作类变量
	var $_modelExample;
	
	#设置当前控制器名
	var $thisController = "Report_AnalyseSell";
	
	#设置标题
	var $title = "销售分析";
	var $funcId = 18;
	
	/**
 	 * 构造函数.
 	 */
	function Controller_Report_AnalyseSell() {
		if(!$this->authCheck()) die("禁止访问!");

		#实例化 Sell_ChuKu 数据操作类
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_ChuKu2Product');
	}
	
	//应收款报表
	function actionExtYingShou() {
		$this->funcId = 22;
		if(!$this->authCheck()) die("禁止访问!");
		require "Lib/App/View/Report/YingShou.php";exit;
	}

	function actionExtIndex() {
		require "Lib/App/View/Report/AnalyseSell.php";exit;
	}
	/**Ext中的采购分析
	*
	*/
	function actionExtList() {
		$sql = "select 
			y.chuKuNum,y.chuKuDate,x.batchCode,z.name,
			z.guige,z.material,z.standardCode,z.danWei,
			x.cnt,x.danJia,x.cntReturn
			from CangKu_chuku2product x
			left join CangKu_chuku y on x.chuKuId = y.id
			left join JiChu_product z on x.productId = z.id
			where 1";

		if($_POST[key]!="") {
			$sql .= " and (z.name like '%$_POST[key]%' or z.guige like '%$_POST[key]%' or z.standardCode like '%$_POST[key]%')";
		}
		if($_POST[clientId]!='') {
			$sql .= " and y.clientId = '$_POST[clientId]'";
		}
		if($_POST[dateFrom]!='') {
			$sql .= " and y.chuKuDate >= '$_POST[dateFrom]'";
		}
		if($_POST[dateTo]!='') {
			$sql .= " and y.chuKuDate <= '$_POST[dateTo]'";
		}

		$count = $this->_modelExample->findCountBySql($sql);
		FLEA::loadClass('TMIS_Pager');
		$pager = & new TMIS_Pager($sql);
		$dbo = FLEA::getDBO(false);
		$pager->setDBO($dbo);
		$pager->setCount($count);
		$rowset = $pager->findAll();
		//dump($dbo->log);exit;
		//dump($rowset);exit;
		echo $this->buildExtRecords($count,$rowset);
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
		$pk = $this->_modelSellAnalyse->primaryKey;
		$smarty->assign('pk',$pk);	*/	

        #设置标题		
		$smarty->assign('title', $this->title);
		
		#自定义显示字段
		$arrFieldInfo = array(
			"chuKuNum" =>"单号",
			"chuKuDate" =>"出库日期",
			"proCode" => "产品编码",
			"proName" => "产品名称",
			"cnt" => "数量",
			"danJia" => "单价"
		);
		$smarty->assign('arr_field_info',$arrFieldInfo);	
		
		/*#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);*/

		#开始显示
		$smarty->display('Sell/Analyse.tpl');
		
	}
	

	
	
	/**
 	 * 搜索 这个事件是由Analyse.tpl中的"搜索"按钮触发的.
	 * 产生一个入库单列表
 	 */
	function actionSearch() {
		#搜索条件	
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "(proName like '%$_POST[key]%' or proCode like '%$_POST[key]%')" : 1);
		$condition = $condition . " and " . (isset($_POST[clientId])&&$_POST[clientId]!="" ? "clientId = $_POST[clientId]" : 1);
		$condition = $condition . " and " . (isset($_POST[date_from])&&$_POST[date_to]!="" ? "chuKuDate >= '$_POST[date_from]' and chuKuDate <= '$_POST[date_to]'" : 1);
			

		
		$sql = "select id, chuKuNum, chuKuDate, clientId, compName, cnt, danJia, proCode, proName 
		from 
(
select sc_c2p.id as id, sc_c2p.chuKuNum as chuKuNum, sc_c2p.chuKuDate as chuKuDate,  sc_c2p.clientId as clientId, sc_c2p.compName as compName, sc_c2p.cnt as cnt, sc_c2p.danJia as danJia, jp.proCode as proCode, jp.proName as proName
from 
(
select sc.id as id, sc.chuKuNum as chuKuNum, sc.chuKuDate as chuKuDate, sc.clientId as clientId, sc.compName as compName, c2p.productId as productId,  c2p.cnt as cnt, c2p.danJia as danJia   
from sell_chuku2product as c2p 
left join 
(
select sc.id as id, chuKuNum, chuKuDate, clientId, compName from sell_chuKu as sc left join jichu_client as jc on sc.clientId = jc.id
) as sc on c2p.baseTableId = sc.id
) as sc_c2p
left join JiChu_product as jp on sc_c2p.productId = jp.id
) as sc_c2p_jp
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
			"chuKuNum" =>"单号",
			"chuKuDate" =>"日期",
			"proCode" =>"产品编号",
			"proName" =>"产品名称",
			"cnt" =>"数量",
			"danJia" =>"单价"
		);
		$smarty->assign('arr_field_info',$arrFieldInfo);

		#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);
		
		#分页信息
		$smarty->assign('page_info',$pager->getNavBar($this->_url()));		
		
		#开始显示
		$smarty->display('Sell/Analyse.tpl');
		
	}

}
?>