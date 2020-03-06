<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chengpin_Denim_Cprk extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 39;	
	function Controller_Chengpin_Denim_Cprk() {
		$this->arrLeftHref = array(
			"针织成品初始化",
			"Chengpin_Denim_Cprk" =>"针织成品入库",
			"Chengpin_Denim_Cpck" =>"针织成品出库",
			"筒纱入库"
		);
		$this->leftCaption = '针织成品';
		$this->_modelExample = & FLEA::getSingleton('Model_Chengpin_Denim_Cprk');
	}
	
	#列表	
	function actionRight() {
		$this->authCheck($this->funcId);
        $table = $this->_modelExample->tableName;
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "ruKuNum like '%$_POST[key]%'" : NULL);   		
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');		
		$rowset = $pager->findAll();		
		foreach ($rowset as & $value) {
			$value[clientName] = $value[Client][compName];
			//if ($this->_editable($value[id])) $value[state]='<font color=red>未审核</font>';
			//else $value[state]='<font color=green>已审核</font>';
		}		
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			//"state" => '状态',
			"cprkCode" =>"入库单号",
			"dateCprk" =>"入库日期",
			"memo" => "备注"			
		);		
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('title','针织牛仔入库');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));		
		$smarty->display('TableList.tpl');
	}	

	function _edit($Arr, $ArrProductList=null) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("title",'成品入库编辑');
		$smarty->assign("arr_field_value",$Arr);
		$smarty->display('Chengpin/Denim/CprkEdit.tpl');
	}
	
	//取得新的成品入库单号
	function _getNewCprkCode() {
		$arr=$this->_modelExample->find(null,'cprkCode desc','cprkCode');		
		$max = $arr[cprkCode];
		$temp = date("ym")."001";
		if ($temp>$max) return $temp;
		$a = substr($max,-3)+1001;
		return substr($max,0,-3).substr($a,1);
	}	
	
	#增加界面
	function actionAdd() {
		$this->_edit(array('cprkCode'=>$this->_getNewCprkCode()));
	}
	#保存
	function actionSave() {
       	$cprkId = $this->_modelExample->save($_POST);
		if (!empty($_POST[id])) $cprkId = $_POST[id];
		if ($cprkId) redirect($this->_url('EditOrdpro',array('cprkId'=>$cprkId)));
		else die('保存失败!');
	}
	#保存产品档案
	function actionSaveOrdpro() {
		//dump($_POST);exit;
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cprk2OrdPro');       	
		if ($model->save($_POST)) redirect($this->_url('EditOrdpro',array('cprkId'=>$_POST[cprkId])));
		else die('保存失败!');
	}
	#修改界面
	function actionEdit() {
		if (!$this->_editable($_GET[id])) js_alert('该入库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
		$arr_field_value=$this->_modelExample->find($_GET[id]);
		$this->_edit($arr_field_value);
	}
	#修改货品界面
	function actionEditOrdpro() {	
		$this->authCheck($this->funcId);
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cprk2OrdPro');  
		$modelPro = FLEA::getSingleton('Model_JiChu_Product');
		$pros = $model->findAll("cprkId='$_GET[cprkId]'");
		if (count($pros)>0) foreach($pros as & $v) {			
			$v[Product] = $modelPro->find($v[Ordpro][productId]);
		}
		//dump($pros);exit;
		
		$smarty = & $this->_getView();
		$smarty->assign('rows',$pros);
		$smarty->display('Chengpin/Denim/Cprk2OrdproEdit.tpl');
	}
	
	//删除
	function actionRemove() {
		if (!$this->_editable($_GET[id])) js_alert('该入库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
		else parent::actionRemove();
	}
	
	function actionRemoveOrdpro() {
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cprk2OrdPro'); 
		$pro = $model->find($_GET[id]);
		$cprkId = $pro[cprkId];
		$model->removeByPkv($_GET[id]);
		redirect($this->_url('editOrdpro',array('cprkId'=>$cprkId)));
	}
	//判断id=$pkv的入库单是否允许被修改或删除,
	function _editable($pkv) {
		//echo "adf";exit;	
		$c=$this->_modelExample->find($pkv);
		if (count($c)==0) js_alert('出错!','window.history.go(-1)');
		$d=array_col_values($c[Cprk],'id');
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cprk2OrdPro');
		foreach($d as $v){
			if ($model->isAuditted($v)) return false;
		}
		return true;
	}

	//
	function actionGetWaresJson(){
		$aRow = $this->_modelExample->find("cprkCode='$_GET[cprkCode]'");
		$id = $aRow[id];
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cprk2OrdPro');
		$modelPro = FLEA::getSingleton('Model_JiChu_Product');
		$ordpro = $model->findAll("cprkId='$id'");
		for ($i=0;$i<count($ordpro);$i++) {
			$ordpro[$i][cprkCode] = $_GET[cprkCode];
			$ordpro[$i][Product] = $modelPro->find($ordpro[$i][Ordpro][productId]);
		}
		//dump($wares);exit;
		echo json_encode($ordpro);exit;
	}
}
?>