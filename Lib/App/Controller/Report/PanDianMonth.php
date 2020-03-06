<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Report_PanDianMonth extends Tmis_Controller {
	var $_modelExample;
	var $thisController = "Report_PanDianMonth";	//当前控制器名
	var $queenController = "Report_PanDianMonthList";		//增加材料控制器
	var $title = "产品库存盘点";
	var $funcId = 17;
	
	function Controller_Report_PanDianMonth() {
		if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_RuKu');
	}

	function actionExtRemoveByPkvs() {
		$arrPkv = explode(",",$_POST[pkvs]);
		foreach( $arrPkv as $pkv) {
			$this->_modelExample->removeByPkv($pkv);
		}
		//成功
		echo 1;
		
	}

	#根据_get[id],返回订单信息的json字串
	function actionExtFind() {
		$pk=$this->_modelExample->primaryKey;
		$id = empty($_GET[id])?"0":$_GET[id];
		$rowset=$this->_modelExample->findAll("cangku_ruku.id = $id");
		//取得产品信息
		$_modelPro = & FLEA::getSingleton('Model_JiChu_Product');
		
		foreach ($rowset[0][RuKu2Product] as & $pro) {
			//dump($pro);dump($_modelPro->find($pro[productId]));exit;
			//其中id 字段重复，所以需要修改 pro_id的键名,取后面参数的id字段			
			$pro = array_merge($_modelPro->find($pro[productId]),$pro);
		}
		echo $this->buildExtRecords(1,$rowset);
	}

	#保存
	function actionExtSave() {       	
		$_POST[sign] = 1;
		$this->_modelExample->save($_POST);
		if(empty($_POST[id])) {
			$newId = $this->_modelExample->dbo->insertId();
		} else $newId = $_POST[id];	
		$_model2 = FLEA::getSingleton('Model_CangKu_RuKu2Product');
		$arrPro = json_decode($_POST[pros],true);
		foreach ($arrPro as & $row) {
			$row[ruKuId] = $newId;			
			//插入从表
			$_model2->save($row);
		}
		//echo 1;	
		echo "{success:true,saved:'yes',error:'NOERROR.'}";
	}
	
	#返回在ext中grid需要的json数据
	function actionExtList() {
		$condition = 'sign = 1';
		$table = $this->_modelExample->tableName;
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		$rowset = $pager->findAllOfPrimaryName();		
		//根据纪录总数和纪录数组构造Ext中的records数据格式
		echo $this->buildExtRecords($pager->totalCount,$rowset);
	}
	
	#返回在ext中grid需要的json数据
	function actionExtIndex() {		
		require("Lib/App/View/Report/PanDianMonth.php");exit;
	}

	
}
?>