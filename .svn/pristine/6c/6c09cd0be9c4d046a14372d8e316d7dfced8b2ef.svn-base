<?php
/**
 * 注释参考Client.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Ar_Record extends Tmis_Controller {
	var $_modelExample;
	var $title = "后整理";
	var $arTypeId=3;
	var $funcId = 10;
	function Controller_CaiWu_Ar_Record() {			
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Ar_Record');
	}
	
	
	function actionRight()	{
		$this->authCheck($this->funcId);		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' => date("Y-m-01"),
			'dateTo' =>date("Y-m-d"),
			'clientId' => '',
			'danjia' => ''
		));		
		$arrCondition = array();
		$arrCondition[arTypeId] = $this->arTypeId;
		$arrCondition[] = "dateRecord>='$arr[dateFrom]' and dateRecord<='$arr[dateTo]'";
		if ($arr[clientId]!='') $arrCondition[clientId] =$arr[clientId];
		if ($arr[danjia]!='') $arrCondition[danjia] =$arr[danjia];		
		//dump($arr);exit;
		//$pager =& new TMIS_Pager($this->_modelExample,$arrCondition);
        $rowset =$this->_modelExample->findAll($arrCondition);	
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][clientName] = $rowset[$i][Client][compName];
			$rowset[$i][money] = $rowset[$i][danjia]*$rowset[$i][cnt];
			$totalJian += $rowset[$i][standby2];
			$totalCnt += $rowset[$i][cnt];
			$totalMoney += $rowset[$i][money];
		}
		
		//合计
		$rowset[$i][dateRecord] = '合计';
		$rowset[$i][standby2] = $totalJian;
		$rowset[$i][cnt] = $totalCnt;
		$rowset[$i][money] = $totalMoney;
		
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"dateRecord" =>"日期",
			"clientName" =>"客户",
			"standby1" =>"规格",
			"standby2" =>"件数",
			"cnt" =>"数量",
			"danjia" =>"单价",
			"money" =>"金额",
			"memo" =>"备注"
		);
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->assign('controller', 'CaiWu_Ar_Init');
		$smarty-> display('CaiWu/Ar/RecordZhengli.tpl');
	}
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$smarty->display('CaiWu/Ar/ArZhengliEdit.tpl');
	}

	function actionAdd() {
		$this->_edit(array());
	}

	function actionSave() {
		if ($_POST[clientId]=="") js_alert('请选择客户','window.history.go(-1)');
		for ($i=0;$i<count($_POST[standby1]);$i++) {
			$temp = array();
			$temp[arTypeId]=$_POST[arTypeId];
			$temp[dateRecord]=$_POST[dateRecord];
			$temp[clientId]=$_POST[clientId];
			$temp[standby1]=$_POST[standby1][$i];
			$temp[standby2]=$_POST[standby2][$i];
			$temp[cnt]=$_POST[cnt][$i];
			$temp[danjia]=$_POST[danjia][$i];
			$temp[memo]=$_POST[memo][$i];
			$temp[id]=$_POST[id];
			//dump($temp);exit;
			if ($temp[standby1]!=''||$temp[standby2]!=''||
				$temp[cnt]!=''||$temp[danjia]!=''||
				$temp[memo]!='') $this->_modelExample->save($temp);
		}
		redirect($this->_url("Right"));
	}

	function actionEdit() {
		$aRow=$this->_modelExample->find($_GET[id]);
		$this->_edit($aRow);
	}
}
?>