<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chengpin_Denim_Cpck extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 40;	
	function Controller_Chengpin_Denim_Cpck() {
		$this->_modelExample = & FLEA::getSingleton('Model_Chengpin_Denim_Cpck');
	}
	
	#列表	
	function actionRight() {
		$this->authCheck($this->funcId);
        $table = $this->_modelExample->tableName;
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "ruKuNum like '%$_POST[key]%'" : NULL);   		
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');		
		$rowset = $pager->findAll();		
		if (count($rowset)>0) foreach ($rowset as & $value) {
			$value[clientName] = $value[Client][compName];
			$value[orderCode] = $value[Order][orderCode];
			if ($this->_editable($value[id])) $value[state]='<font color=red>未审核</font>';
			else $value[state]='<font color=green>已审核</font>';
		}		
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"state" => '状态',
			"cpckCode" =>"出库单号",
			"orderCode" =>"配货订单号",
			"dateCpck" =>"发货日期",
			"memo" => "备注"			
		);		
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('title','针织牛仔发货');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));		
		$smarty->display('TableList.tpl');
	}	

	function _edit($Arr, $ArrProductList=null) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("arr_field_value",$Arr);
		$smarty->display('Chengpin/Denim/CpckEdit.tpl');
	}
	
	//取得新的成品出库单号
	function _getNewCpckCode() {
		$arr=$this->_modelExample->find(null,'cpckCode desc','cpckCode');		
		$max = $arr[cpckCode];
		$temp = date("ym")."001";
		if ($temp>$max) return $temp;
		$a = substr($max,-3)+1001;
		return substr($max,0,-3).substr($a,1);
	}	
	
	#增加界面
	function actionAdd() {
		$this->_edit(array('cpckCode'=>$this->_getNewCpckCode()));
	}
	#保存
	function actionSave() {
		$model = FLEA::getSingleton('Model_Trade_Denim_Order');
		if (!$o=$model->find("orderCode = '$_POST[orderCode]'")) {
			js_alert('配货合同号不存在，请确认后重新输入!','window.history.go(-1)');
		}
		$_POST[orderId] = $o[id];
		//dump($o);exit;
       	$cpckId = $this->_modelExample->save($_POST);
		if (!empty($_POST[id])) $cpckId = $_POST[id];
		if ($cpckId) redirect($this->_url('EditOrdpro',array(
			'cpckId'=>$cpckId,
			'orderId'=>$_POST[orderId]
		)));
		else die('保存失败!');
	}
	
	#修改主信息界面
	function actionEdit() {
		if (!$this->_editable($_GET[id])) js_alert('该出库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
		$arr_field_value=$this->_modelExample->find($_GET[id]);
		$this->_edit($arr_field_value);
	}
	
	#修改明细界面
	function actionEditOrdpro() {			
		$this->authCheck($this->funcId);		
		//取得_post[orderCode] 对应的pros信息,并取得关联的cpck信息
		$arr_pros = array();
		$_model = FLEA::getSingleton('Model_Trade_Denim_Order2Product');
		$_modelKc = FLEA::getSingleton('Model_Chengpin_Denim_Report');
		$_model->enableLink('Cpck');
		
		$order2Pro = $_model->findAll("orderId = '$_GET[orderId]'");
		
		$_model->disableLink('Cpck');
		if(count($order2Pro)>0) foreach($order2Pro as $key =>& $v) {
			//配货合同信息
			$arr_pros[$key][manuCode] =$v[manuCode];
			$arr_pros[$key][cntKgYh] = $v[cntKg];
			$arr_pros[$key][order2ProductId] = $v[id];
			$arr_pros[$key][Product] = $v[Product];			
			
			//从$v[Cpck]中搜索cpckId=$_GET[cpckId]的记录
			if (count($v[Cpck])>0) foreach($v[Cpck] as & $v1) {
				if ($v1[cpckId]==$_GET[cpckId]) {
					$arr_pros[$key][cpckId] = $v1[id];
					$arr_pros[$key][order2ProductId1] = $v1[order2ProductId1];
					$arr_pros[$key][cntKg] = $v1[cntKg];
					$arr_pros[$key][cntKgC] = $v1[cntKgC];
					$arr_pros[$key][cntKgF] = $v1[cntKgF];
					
					$temp = $_model->find($v1[order2ProductId1]);
					$arr_pros[$key][manuCode1] = $temp[manuCode];
					$arr_pros[$key][Product1] = $temp[Product];
					
					$arr_pros[$key][Kucun] = $_modelKc->getKucunOfManuCode($temp[manuCode]);
					break;
				}
			}
		}
		//dump($arr_pros);
		$smarty = & $this->_getView();
		$smarty->assign('pros',$arr_pros);
		$smarty->display('Chengpin/Denim/Cpck2OrdproEdit.tpl');
	}
	
	#保存出库明细
	function actionSaveOrdpro() {
		//dump($_POST);exit;
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');				
		$arr = array();
		for ($i=0;$i<count($_POST[order2ProductId]);$i++) {
			if (empty($_POST[cntKg][$i])&&empty($_POST[cntKgC][$i])&&
			empty($_POST[cntKgF][$i])) {
				//如存在记录且数量都为空，则删除记录
				if ($_POST[id][$i]>0) $model->removeByPkv($_POST[id][$i]);
				continue;
			}
			$arr[cpckId] = $_POST[cpckId];
			$arr[id] = $_POST[id][$i];
			$arr[order2ProductId] = $_POST[order2ProductId][$i];
			$arr[order2ProductId1] = $_POST[order2ProductId1][$i];
			$arr[cntKg] = $_POST[cntKg][$i];
			$arr[cntKgC] = $_POST[cntKgC][$i];
			$arr[cntKgF] = $_POST[cntKgF][$i];
			$model->save($arr);
		}
		redirect($this->_url('right'));		
	}
	
	//删除
	function actionRemove() {
		if (!$this->_editable($_GET[id])) js_alert('该出库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
		else parent::actionRemove();
	}
	
	function actionRemoveOrdpro() {
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro'); 
		$pro = $model->find($_GET[id]);
		$cpckId = $pro[cpckId];
		$model->removeByPkv($_GET[id]);
		redirect($this->_url('editOrdpro',array('cpckId'=>$cpckId)));
	}
	//判断id=$pkv的出库单是否允许被修改或删除,
	function _editable($pkv) {
		$c=$this->_modelExample->find($pkv);		
		if (count($c)==0) js_alert('出错!','window.history.go(-1)');
		if (count($c[Cpck])>0) $d=array_col_values($c[Cpck],'id');		
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
		if (count($d)>0) foreach($d as $v){
			if ($model->isAuditted($v)) return false;
		}
		return true;
	}

	//
	function actionGetWaresJson(){
		$aRow = $this->_modelExample->find("cpckCode='$_GET[cpckCode]'");
		$id = $aRow[id];
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
		$modelPro = FLEA::getSingleton('Model_JiChu_Product');
		$ordpro = $model->findAll("cpckId='$id'");
		for ($i=0;$i<count($ordpro);$i++) {
			$ordpro[$i][cpckCode] = $_GET[cpckCode];
			$ordpro[$i][Product] = $modelPro->find($ordpro[$i][Ordpro][productId]);
		}
		//dump($wares);exit;
		echo json_encode($ordpro);exit;
	}
}
?>