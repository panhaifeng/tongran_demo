<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_TableDataGateway');
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Yf_Report extends Tmis_Controller {
	var $_modelExample;
	var $funcId=13;
	function Controller_CaiWu_Yf_Report() {
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Yf_Report');
	}

	function actionRight(){
		$this->authCheck($this->funcId);

		$modelInvoice =& FLEA::getSingleton('Model_Caiwu_Yf_Invoice');
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
			supplierId=>''
		));


		$initTotal=0;$rukuTotal=0;$chukuTotal=0;
		
		if ($arr[supplierId] != '') $condition[] = array('id', $arr[supplierId]);
		
		$arrR = array();
		//dump($condition2);
		$rowset =$this->_modelExample->findAll($condition);
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][compName] = "<a href='?controller=CangKu_RuKu&action=right&supplierId={$rowset[$i][id]}&dateFrom={$arr[dateFrom]}&dateTo={$arr[dateTo]}' target='_blank'>{$rowset[$i][compName]}</a>";

			$supplierId = $rowset[$i][id];
			$condition = array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo' => $arr['dateTo'],
				'supplierId' => $supplierId
			);
			
			//期初
			$rowset[$i][initMoney]  = $this->_modelExample->getMoneyInit($supplierId,$arr[dateFrom]);
			$initTotal += $rowset[$i][initMoney];
			//本期其他应付的金额
			$rowset[$i]['otherMoney'] =  $this->_modelExample->getOtherMoney($supplierId,$arr[dateFrom],$arr[dateTo]);
			//本期应付金额
			$rowset[$i][rukuMoney]  = $rowset[$i]['otherMoney'] + $this->_modelExample->getMoneyRukuNew($supplierId,$arr[dateFrom],$arr[dateTo]);
			$rukuTotal += $rowset[$i][rukuMoney];
			
			$rowset[$i][chukuMoney] = $this->_modelExample->getMoneyChuku($supplierId,$arr[dateFrom],$arr[dateTo]);
			$chukuTotal += $rowset[$i][chukuMoney];			

			$rowset[$i][remainMoney] = round($rowset[$i][initMoney]+$rowset[$i][rukuMoney]-$rowset[$i][chukuMoney],2);

			//已开发票
			$invoiceSum = $modelInvoice->getInvoiceSum($arr['dateFrom'], $arr['dateTo'], $supplierId);
			if (!$invoiceSum) $invoiceSum = 0;
			$tInvoiceSum += $invoiceSum;
			$rowset[$i]['invoiceSum'] = "<a href='".url('Caiwu_Yf_Invoice', 'right', $condition)."' target='_blank'>{$invoiceSum}</a>";

			$arrR[] = $rowset[$i];
		}
		//加入合计
		//$supplierId = $rowset[$i][id];
		$i= count($arrR);
		$arrR[$i][compCode] = '合计';
		$arrR[$i][initMoney]  = $initTotal;
		$arrR[$i][rukuMoney]  = $rukuTotal;
		$arrR[$i][chukuMoney] = $chukuTotal;
		$arrR[$i][invoiceSum] = $tInvoiceSum;
		$arrR[$i][remainMoney] = $initTotal+$rukuTotal-$chukuTotal;
		if ($arrR[$i][initMoney]>0) $arrR[$i][returnRate] = number_format($rowset[$i][chukuMoney]/$arrR[$i][initMoney]*100,2,".","")."%";
		$arrR[$i][memo] = $memoTotal;

		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"compCode" =>"供应商代码",
			"compName" =>"供应商",
			"initMoney" =>"上期结余",
			"rukuMoney" =>"本期发生",
			"chukuMoney" =>"本期付款",
			"remainMoney" => "本期结余",
			'invoiceSum' => '本期已开票',
			//"returnRate" => "还款率",
			//"memo" => "未开票"
					
		);		
		$smarty->assign('title','应付款报表');
		//$smarty->assign('arr_edit_info',$arr_edit_info);		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$arrR);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		//$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arr)));
		$smarty->assign('controller', 'CaiWu_Yf_Report');
		$smarty-> display('TableList.tpl');
	}
}
?>