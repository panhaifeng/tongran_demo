<?php
FLEA::loadClass('Controller_CaiWu_Ar_Record');
class Controller_CaiWu_Ar_RecordDenim extends Controller_CaiWu_Ar_Record {
	var $title = '针织牛仔';
	var $funcId = 41;
	var $arTypeId=array(4,5,6,7);
	
	//钱会计临时报表
	function actionTempReport() {		
		//$this->authCheck($this->funcId);
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Ar_TempReport');
		FLEA::loadClass('TMIS_Pager');
		$arrParam = array(
			'dateFrom'=>date("Y-m-01"),
			'dateTo'=>date("Y-m-d",mktime(0,0,0,date("m")+1,date("d")-1,date("Y"))),
			'arTypeId'=>4,
			'traderId'=>''
		);
		$arr = TMIS_Pager::getParamArray($arrParam);
		
		//连成query字串
		$queryStr = TMIS_Pager::getParamStr($arr);
		$arrCondition = array();
		if (!empty($arr[arTypeId])) $arrCondition[] = "compCode like '0$arr[arTypeId]%'";
		if (!empty($arr[traderId])) $arrCondition[traderId] = $arr[traderId];
		if ($arr[traderId]!="") $rowset =$this->_modelExample->findAll($arrCondition);
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][traderName] = $rowset[$i][Trader][employName];
			$clientId = $rowset[$i][id];
			$rowset[$i][initMoney]  = $this->_modelExample->getMoneyInit($clientId,$arr[dateFrom]);			
			$rowset[$i][rukuMoney]  = $this->_modelExample->getMoneyRuku($clientId,$arr[dateFrom],$arr[dateTo]);
			$rowset[$i][chukuMoney] = $this->_modelExample->getMoneyChuku($clientId,$arr[dateFrom],$arr[dateTo]);
			$rowset[$i][remainMoney] = $rowset[$i][initMoney]+$rowset[$i][rukuMoney]-$rowset[$i][chukuMoney];
			$tInit += $rowset[$i][initMoney];
			$tRuku += $rowset[$i][rukuMoney];
			$tChuku += $rowset[$i][chukuMoney];
			$tRemainMoney += $rowset[$i][remainMoney];
			//if ($rowset[$i][initMoney]>0) $rowset[$i][returnRate] = number_format($rowset[$i][chukuMoney]/$rowset[$i][initMoney]*100,2,".","")."%";
		}	
		
		//合计
		$rowset[$i][compCode] = "合计";
		$rowset[$i][initMoney] =$tInit;
		$rowset[$i][rukuMoney] =$tRuku;
		$rowset[$i][chukuMoney] =$tChuku;
		$rowset[$i][remainMoney] =$tRemainMoney;
			
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"compCode" =>"客户代码",
			"compName" =>"客户名称",
			"traderName" =>"业务员",
			"initMoney" =>"上期结余",
			"rukuMoney" =>"借(本期发生额)",
			"chukuMoney" =>"贷(本期收款)",
			"remainMoney" => "本期结余"		
		);		
		$smarty->assign('title','应收款报表');
		$smarty->assign('arTypeId',$arr[arTypeId]);		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arr)));
		$smarty->assign('controller', 'CaiWu_Ar_Report');
		$smarty-> display('CaiWu/Ar/Report.tpl');
	}
	function actionRight()	{
		$this->authCheck($this->funcId);
		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' => date("Y-m-01"),
			'dateTo' =>date("Y-m-d"),
			'clientId' => '',
			'arTypeId' => ''
		));		
		$arrCondition = array();
		$arrCondition[] = "arTypeId in (".join(",",$this->arTypeId).")";
		$arrCondition[] = "dateRecord>='$arr[dateFrom]' and dateRecord<='$arr[dateTo]'";
		if ($arr[clientId]!='') $arrCondition[clientId] =$arr[clientId];
		if ($arr[arTypeId]!='') $arrCondition[arTypeId] =$arr[arTypeId];		
		
		//$pager =& new TMIS_Pager($this->_modelExample,$arrCondition);
        $rowset =$this->_modelExample->findAll($arrCondition);	
		
		$modelEmploy = FLEA::getSingleton('Model_JiChu_Employ');		
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][clientName] = $rowset[$i][Client][compName];
			$rowset[$i][arType] = $rowset[$i][ArType][typeName];
			$temp = $modelEmploy->find($rowset[$i][standby1]);
			$rowset[$i][trader] = $temp[employName];
			$totalMoney += $rowset[$i][cnt];
			$totalM += $rowset[$i][standby3];
			$totalKg += $rowset[$i][standby2];
		}
		
		//合计
		$rowset[$i][dateRecord] = "合计";
		$rowset[$i][cnt] = $totalMoney;
		$rowset[$i][standby2] = $totalKg;
		$rowset[$i][standby3] = $totalM;
		
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"dateRecord" =>"日期",
			"clientName" =>"客户",
			"trader" =>"业务员",
			"arType" =>"业务类型",
			"cnt" =>"金额",//单价统一为1
			"standby2" =>"公斤数",
			"standby3" =>"米数",			
			"memo" =>"备注"
		);
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arTypeId',$arr[arTypeId]);
		//$modelClient= FLEA::getSingleton('Model_JiChu_Client');
		//$smarty->assign('client',$modelClient->find($arr[clientId]));
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty-> display('CaiWu/Ar/RecordDenim.tpl');
	}
	
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$smarty->display('CaiWu/Ar/ArDenimEdit.tpl');
	}
	function actionSave() {
		if ($_POST[clientId]=="") js_alert('请选择客户','window.history.go(-1)');
		$this->_modelExample->save($_POST);
		redirect($this->_url("Right"));
	}
	
	//显示待审核的记录
	function actionAuditChuku() {		
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom=>date("Y-m-01"),
			dateTo => date("Y-m-d"),
			clientId => ""
		));
		$str = "select * from view_chengpin_denim_cpck_for_ar where dateCpck>='$arr[dateFrom]' and dateCpck<='$arr[dateTo]'";
		if ($arr[clientId]!="") $str .= " and clientId = '$arr[clientId]'";
		$pager = new TMIS_Pager($str);
		$rowset = $pager->findAllBySql($str);
		
		if (count($rowset)>0) foreach($rowset as & $v) {
			$model = FLEA::getSingleton('Model_JiChu_Client');
			$a = $model->find($v[clientId]);
			$v[clientName] = $a[compName];
			
			$model = FLEA::getSingleton('Model_JiChu_Employ');
			$a = $model->find($v[traderId]);
			$v[trader] = $a[employName];
			
			$model = FLEA::getSingleton('Model_JiChu_Product');
			$a = $model->find($v[productId]);
			$v[proCode] = $a[proCode];
			$v[proName] = $a[proName];
			$v[guige] = $a[guige];
			
			$v[money] = number_format($v[danjia]*$v[cnt],2,".","");
			
			if ($v[isAuditted]==0) {$temp = '确认审核';$v[statu]='<font color=red>未审核</font>';}
			if ($v[isAuditted]==1) {$temp = '取消审核';$v[statu]='已审核';}
			$v[edit] = "<a href='?controller=CaiWu_Ar_RecordDenim&action=doAuditChuku&cpck2OrderproId=$v[cpck2OrderproId]'>$temp</a>";
		}
		
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"statu"=>"状态",
			"dateCpck" =>"日期",
			"clientName" =>"客户",
			"trader" =>"业务员",
			"proCode" =>"产品编码",
			"proName" =>"品名",
			"guige" =>"规格",
			"cnt" =>"出货公斤数",//单价统一为1
			"danjia" =>"单价",
			"money" =>"金额",
			"edit" => "操作"
		);
		
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arTypeId',$arr[arTypeId]);
		//$modelClient= FLEA::getSingleton('Model_JiChu_Client');
		//$smarty->assign('client',$modelClient->find($arr[clientId]));
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display('CaiWu/Ar/RecordDenim.tpl');
	}
	//确认审核出库
	function actionDoAuditChuku() {
		$this->authCheck($this->funcId);
		$id = $_GET[cpck2OrderproId];
		$model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
		if (!$model->isAuditted($id)) $check=1;
		else $check = 0;
		$model->updateField("id='$id'",'isAuditted',$check);
		redirect($this->_url('AuditChuku'));		
	}
}
?>