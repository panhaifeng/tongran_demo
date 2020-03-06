<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Sell_ShouKuan extends Tmis_Controller {
	#申明 Sell_ChuKu 数据操作类变量
	var $_modelExample;
	
	#申明 Sell_ShouKuan 数据操作类变量
	var $_modelSellShouKuan;
	
	#设置当前控制器名
	var $thisController = "Sell_ShouKuan";

	var $funcId = 14;
	#设置标题
	var $title = "销售收款";
	
	
	/**
 	 * 构造函数.
 	 */
	function Controller_Sell_ShouKuan() {
		if(!$this->authCheck()) die("禁止访问!");
		#实例化 Sell_ChuKu 数据操作类
		$this->_modelExample = & FLEA::getSingleton('Model_Cangku_ChuKu');
		
		#实例化 Sell_ShouKuan 数据操作类
		$this->_modelSellShouKuan = & FLEA::getSingleton('Model_Sell_ShouKuan');
	}
	
	function actionExtRemoveByPkvs() {
		$arrPkv = explode(",",$_POST[pkvs]);
		foreach( $arrPkv as $pkv) {
			$this->_modelSellShouKuan->removeByPkv($pkv);			
		}
		//成功
		echo 1;
	}

	#根据_get[id],返回订单信息的json字串
	function actionExtFind() {		
		$id = empty($_GET[id])?"0":$_GET[id];
		$rowset=$this->_modelSellShouKuan->findAll("sell_shoukuan.id = $id");
		//dump($rowset);exit;
		echo $this->buildExtRecords(1,$rowset);
	}
	
	#保存
	function actionExtSave() {  
		//dump($_POST);exit;
		$this->_modelSellShouKuan->save($_POST);		
		echo "{success:true,saved:'yes',error:'NOERROR.'}";
	}


	#返回在ext中grid需要的json数据
	function actionExtList() {		
		//if (isset($_POST[key])&&$_POST[key]!="") $condition = "RealName like '%$_POST[key]%'";
		$table = $this->_modelSellShouKuan->tableName;
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelSellShouKuan,$condition);
		$rowset = $pager->findAllOfPrimaryName();		
		//根据纪录总数和纪录数组构造Ext中的records数据格式
		echo $this->buildExtRecords($pager->totalCount,$rowset);
	}
	
	#返回在ext中grid需要的json数据
	function actionExtIndex() {
		require("Lib/App/View/Sell/ShouKuan.php");exit;
	}
	
	/**
 	 * Index.
 	 */		
	function actionIndex() {	
		#搜索条件	
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? array("clientName", $_POST[key]) : NULL);
		
		#根据条件找出记录列表      
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelSellShouKuan,$condition);		
		$rowset = $pager->findAll();

		#自定义显示列表
		foreach ($rowset as & $value) {
			$value[clientName] = $value[Client][compName];
			$value[userName] = $value[User][realName];
		}
		
		#初始化smarty对象,根据config.inc.php的设置进行初始化
		$smarty = & $this->_getView();
		
		#设置默认日期
		$smarty->assign('default_date',date("Y-m-d"));	
		
		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$pk = $this->_modelSellShouKuan->primaryKey;
		$smarty->assign('pk',$pk);		

        #设置标题		
		$smarty->assign('title', $this->title);
		
		#自定义显示字段
		$arrFieldInfo = array(
			"chuKuNum" =>"单号",
			"clientName" =>"客户",
			"userName"=>"操作人",
			"benCiShouKuan" =>"本次收款",
			"shouKuanDate" =>"收款时间"
		);
		$smarty->assign('arr_field_info',$arrFieldInfo);	
		
		#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);

		#开始显示
		$smarty->display('TableList.tpl');
		
	}
	
	
	
	/**
 	 * 删除 TableList.tpl中的.
	 * 这里比较特殊的地方在于: 在删除ShouKuan中的记录时, 要同时更新ChuKu中的已收款值.
	 * ChuKu->已收款 = ChuKu->已收款 - ShouKuan->本次收款.
 	 */
	function actionRemove() {
		#通过传过来的ShouKuan表的主健值, 找到该条记录并赋给变量$row.
		$pk=$this->_modelSellShouKuan->primaryKey;
		$row = $this->_modelSellShouKuan->findByField("id", $_GET[$pk]);
		
		#取出$row中的chuKuId字段值, 此值为chuKu表的主健值.
		#以同样方式找到相关记录并赋给变量$row_chuKu
		$condition = "id = ".$row[chuKuId];
		$row_chuKu = $this->_modelExample->findByField("id", $row[chuKuId]);

		#更新ChuKu中的已收款字段值.
		$yiShouKuan = $row_chuKu[yiShouKuan] - $row[benCiShouKuan];
		$data = array("yiShouKuan"=>$yiShouKuan);
		$this->_modelExample->updateByConditions($condition, $data);
		
		#删除ShouKuan记录.
		$this->_modelSellShouKuan->removeByPkv($_GET[$pk]);
		
		#回到主页面.
		redirect(url($this->thisController, "index"));
	}
	
	
	
	/**
 	 * 增加 转到Sell/ShouKuan.tpl
 	 */
	function actionAdd() {		
		#初始化smarty对象,根据config.inc.php的设置进行初始化
		$smarty = & $this->_getView();
		
		#对默认日期变量赋值
		$smarty->assign('default_date',date("Y-m-d"));	
		
		$smarty->assign('title', $this->title);
		
		#对表头进行赋值
		$arrFieldInfo = array(
			"chuKuNum" =>"单号",
			"chuKuDate" =>"日期",
			"clientName" =>"客户",
			"totalMoney" =>"总金额",
			"yiShouKuan" =>"已收款",
			"weiShouKuan" =>"未收款",
			"lastShouKuanDate" =>"最后收款时间"
		);
		$smarty->assign('arr_field_info',$arrFieldInfo);	
		
		#开始显示
		$smarty->display('Sell/ShouKuan.tpl');
	}
	
	
	/**
 	 * 修改 转到Sell/ShouKuanEdit.tpl
 	 */
	function actionEdit() {
		#通过TableList.tpl传过来的主健值, 找出相当记录
		$pk=$this->_modelExample->primaryKey;		
		$arrFieldValue=$this->_modelExample->find($_GET[$pk]);	

		#初始化smarty.
		$smarty = & $this->_getView();
		
		#设置标题
		$smarty->assign('title', "收款");
		
		#设置记录数组.
		$smarty->assign("arr_field_value",$arrFieldValue);
		
		#对默认日期变量赋值
		$smarty->assign('default_date',date("Y-m-d"));
		
		#设置主键字段
		$pk=$this->_modelExample->primaryKey;
		$smarty->assign("pk",$primary_key);

		#转到显示页面
		$smarty->display('Sell/ShouKuanEdit.tpl');
	}	


	/**
 	 * 保存 这个事件是由ShouKuanEdit.tpl中的"完成"按钮触发的.
	 * 1>更新chuKu表的中的已收款和最后收款日期
	 * 2>增加一条ShouKuan记录
 	 */
	function actionSave() {
		#更新已收款和最后收款日期
		$condition = (isset($_POST[id])&&$_POST[id]!="" ? "id = $_POST[id]" : 0);		
		$lastShouKuanDate = $_POST[lastShouKuanDate];
		$yiShouKuan = $_POST[yiShouKuan] + $_POST[benCiShouKuan];
		$data = array("yiShouKuan"=>$yiShouKuan, "lastShouKuanDate"=>$lastShouKuanDate);
		$this->_modelExample->updateByConditions($condition, $data);
		
		#增加ShouKuan记录
		$row = array("chuKuId"=>$_POST[id], "chuKuNum"=>$_POST[chuKuNum], "clientId"=>$_POST[clientId], "userId"=>$_SESSION['USERID'], "benCiShouKuan"=>$_POST[benCiShouKuan], "ShouKuanDate"=>$lastShouKuanDate);
		$this->_modelSellShouKuan->create($row);
		
		#回到ShouKuan主介面, 即TableList.tpl
		redirect($this->_url());
	}

	
	
	/**
 	 * 搜索 这个事件是由ShouKuan.tpl中的"搜索"按钮触发的.
	 * 产生一个入库单列表
 	 */
	function actionSearch() {
		#搜索条件: 客户,时间段, 入库单号
		$condition = (isset($_POST[clientId])&&$_POST[clientId]!="" ? "clientId = $_POST[clientId]" : 1);		
		$condition = $condition . " and " . (isset($_POST[date_from])&&$_POST[date_to]!="" ? "chuKuDate >= '$_POST[date_from]' and chuKuDate <= '$_POST[date_to]'" : 1);		
		$condition = $condition . " and " . (isset($_POST[chuKuNum])&&$_POST[chuKuNum]!="" ? "chuKuNum like '%chuKuNum%'" : 1);
		
		#搜索条件: =0 为已结清, >0为未结清
		if ($_POST[state] == 0) 
			$condition = $condition . " and (totalMoney-yiShouKuan) > 0";
		elseif ($_POST[state] == 1)
			$condition = $condition . " and (totalMoney-yiShouKuan) = 0";

		#根据条件产生出记录列表(带分页的)
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition);		
		$rowset = $pager->findAll();
		
		#自定义显示字段
		foreach ($rowset as & $value) {
			$value[clientName] = $value[Client][compName];
			$value[userName] = $value[User][realName];
			$value[weiShouKuan] = $value[totalMoney] - $value[yiShouKuan];
		}

		#初始化smarty对象,根据config.inc.php的设置进行初始化
		$smarty = & $this->_getView();
		
		#设置标题
		$smarty->assign('title', $this->title);
		
		#设置默认日期
		$smarty->assign('default_date',date("Y-m-d"));
		
		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk',$pk);			
		
		#对表头进行赋值
		$arrFieldInfo = array(
			"chuKuNum" =>"单号",
			"chuKuDate" =>"日期",
			"clientName" =>"客户",
			"totalMoney" =>"总金额",
			"yiShouKuan" =>"已收款",
			"weiShouKuan" =>"未收款",
			"lastShouKuanDate" =>"最后收款时间"
		);
		$smarty->assign('arr_field_info',$arrFieldInfo);

		#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);
		
		#分页信息
		$smarty->assign('page_info',$pager->getNavBar($this->_url()));		
		
		#开始显示
		$smarty->display('Sell/ShouKuan.tpl');
		
	}

}
?>