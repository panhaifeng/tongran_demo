<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_TableDataGateway');
FLEA::loadClass('TMIS_Controller');
class Controller_Chengpin_Denim_Report extends Tmis_Controller {
	var $_modelExample;
	var $funcId=13;
	function Controller_Chengpin_Denim_Report() {
		$this->_modelExample = & FLEA::getSingleton('Model_Chengpin_Denim_Report');
	}
	
	//成品出库时用，根据生产编号取得该编号下的库存量和
	function actionGetJsonByManuCode() {
		$manuCode = $_GET[manuCode];
		$_modelReport = $this->_modelExample;
		$_modelOrdpro = FLEA::getSingleton('Model_Trade_Denim_Order2Product');
		
		if ($ordpro = $_modelOrdpro->find("manuCode='$_GET[manuCode]'")) {			
			//取得出库数量
			$arr = array();
			$arr[proCode] =$ordpro[Product][proCode];
			$arr[order2ProductId1] =$ordpro[id];
			$arr[Kucun] = $_modelReport->getKucunOfManuCode($_GET[manuCode]);
			echo json_encode($arr);
		} else {
			echo "{error:'无效的生产编号!'}";
		}
	}
	
	function actionRight(){
		$this->authCheck($this->funcId);
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		FLEA::loadClass('TMIS_Pager');
		$arrParam = array('dateFrom'=>date("Y-m-01"),'dateTo'=>date("Y-m-d",mktime(0,0,0,date("m")+1,date("d")-1,date("Y"))),'compCode'=>'01');
		$arr = TMIS_Pager::getParamArray($arrParam);
		$initTotal=0;$rukuTotal=0;$chukuTotal=0;
		
		//连成query字串
		//$queryStr = TMIS_Pager::getParamStr($arr);
		if (!empty($arr[compCode])) $condition = "compCode like '$arr[compCode]%'";
		
		//$pager =& new TMIS_Pager($this->_modelExample,$condition);        
		$rowset =$this->_modelExample->findAll($condition);
		for ($i=0;$i<count($rowset);$i++) {
			$supplierId = $rowset[$i][id];
			$rowset[$i][initMoney]  = $this->_modelExample->getMoneyInit($supplierId,$arr[dateFrom]);
			$initTotal += $rowset[$i][initMoney];
			$rowset[$i][rukuMoney]  = $this->_modelExample->getMoneyRuku($supplierId,$arr[dateFrom],$arr[dateTo]);
			$rukuTotal += $rowset[$i][rukuMoney];
			$rowset[$i][chukuMoney] = $this->_modelExample->getMoneyChuku($supplierId,$arr[dateFrom],$arr[dateTo]);
			$chukuTotal += $rowset[$i][chukuMoney];
			$rowset[$i][remainMoney] = $rowset[$i][initMoney]+$rowset[$i][rukuMoney]-$rowset[$i][chukuMoney];
			if ($rowset[$i][initMoney]>0) $rowset[$i][returnRate] = number_format($rowset[$i][chukuMoney]/$rowset[$i][initMoney]*100,2,".","")."%";
			$rowset[$i][memo] = number_format($this->_modelExample->getMoneyNoInvoice($supplierId),2,".","");
			$memoTotal += $rowset[$i][memo];
		}
		
		//加入合计
		//$supplierId = $rowset[$i][id];
		$rowset[$i][compCode] = '合计';
		$rowset[$i][initMoney]  = $initTotal;
		$rowset[$i][rukuMoney]  = $rukuTotal;
		$rowset[$i][chukuMoney] = $chukuTotal;
		$rowset[$i][remainMoney] = $initTotal+$rukuTotal-$chukuTotal;
		if ($rowset[$i][initMoney]>0) $rowset[$i][returnRate] = number_format($rowset[$i][chukuMoney]/$rowset[$i][initMoney]*100,2,".","")."%";
		$rowset[$i][memo] = $memoTotal;

		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"compCode" =>"供应商代码",
			"compName" =>"供应商",
			"initMoney" =>"上期结余",
			"rukuMoney" =>"借(本期采购用款)",
			"chukuMoney" =>"贷(本期付款)",
			"remainMoney" => "本期结余",
			"returnRate" => "还款率",
			"memo" => "未开票"
					
		);		
		$smarty->assign('title','应付款报表');
		//$smarty->assign('arr_edit_info',$arr_edit_info);		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arr)));
		$smarty->assign('controller', 'CaiWu_Yf_Report');
		$smarty-> display('CaiWu/Yf/Report.tpl');
	}	
}
?>