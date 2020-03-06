<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Report_Cash extends Tmis_Controller {
	var $_modelExample;
	var $funcId=13;
	var $title ='现金日记帐';
	function Controller_CaiWu_Report_Cash() {
		$this->arrLeftHref = array(
			"CaiWu_Report_Cash" => "现金日记账",
			"CaiWu_Ar_Report" => "应收款报表",
			"CaiWu_Yf_Report" =>"应付款报表",
			"CaiWu_Report_DenimTrad" =>"牛仔业务考核报表",
			"CaiWu_Report_DenimManu" =>"牛仔生产考核报表"
			//库存报表喝生产考核报表通用
			//"CaiWu_Report_DenimStorage" =>"牛仔产品库存报表"
		);
		$this->leftCaption = '财务报表中心';
		//$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Report_Cash');
	}

	function actionRight(){
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
			//clientId=>'',
			//vatNum=>'',
			//orderCode=>''
			accountItemId=>0
		));
		$condition=array(
			"datePay>='$arrGet[dateFrom]'",
			"datePay<='$arrGet[dateTo]'"
		);

		if ($arrGet[accountItemId]>0) $condition[] = array('accountItemId', $arrGet[accountItemId]);

		//dump($condition);
		$arrRet = array();
		$i=0;		$totalIncome =0;		$totalExpense = 0;
		//应付款支出
		$model = FLEA::getSingleton('Model_CaiWu_Yf_Payment');
		$payment=$model->findAll($condition);
		//echo $conditionExt;exit;
		if (count($payment)>0) foreach($payment as & $v) {
			$arrRet[$i][date] = $v[datePay];
			$arrRet[$i][reason] = "采购付款,收款方:".$v[Supplier][compName];
			$arrRet[$i][expense] = $v[moneyPay];
			$arrRet[$i][income] = null;
			$arrRet[$i][memo] = $v[memo];
			$arrRet[$i][dt] = $v[dt];
			$arrRet[$i][account] = $v[AccountItem][itemName];
			$i++;
			$totalExpense += $v[moneyPay];
		}

		//费用支出
		$model = FLEA::getSingleton('Model_CaiWu_Expense');
		$condition = array(
			array('dateExpense',$arrGet['dateFrom'],'>='),
			array('dateExpense',$arrGet['dateTo'],'<=')
		);
		if ($arrGet[accountItemId]>0) $condition[] = array('accountItemId', $arrGet[accountItemId]);
		//dump($condition);
		//$payment=$model->findAll("dateExpense>='$arr[dateFrom]' and dateExpense<='$arr[dateTo]'" . $conditionExt);
		$payment=$model->findAll($condition);
		//dump($payment);
		if (count($payment)>0) foreach($payment as & $v) {
			$arrRet[$i][date] = $v[dateExpense];
			$arrRet[$i][reason] = "费用支出,".$v[ExpenseItem][itemType].",".$v[ExpenseItem][itemName];
			$arrRet[$i][expense] = $v[money];
			$arrRet[$i][income] = null;
			$arrRet[$i][memo] = $v[memo];
			$arrRet[$i][dt] = $v[dt];
			$arrRet[$i][account] = $v[AccountItem][itemName];
			$i++;
			$totalExpense += $v[money];
		}

		//收入
		$model = FLEA::getSingleton('Model_CaiWu_Ar_Income');
		$condition = array(
			array('dateIncome',$arrGet['dateFrom'],'>='),
			array('dateIncome',$arrGet['dateTo'],'<=')
		);
		if ($arrGet[accountItemId]>0) $condition[] = array('accountItemId', $arrGet[accountItemId]);
		//dump($condition);
		//$income=$model->findAll("dateIncome>='$arr[dateFrom]' and dateIncome<='$arr[dateTo]'" . $conditionExt);
		$income=$model->findAll($condition);
		if (count($income)>0) foreach($income as & $v) {
			$arrRet[$i][date] = $v[dateIncome];
			if ($v[Client]) {
				$arrRet[$i][reason] = "销售收入,打款方:".$v[Client][compName];
			} else {
				$arrRet[$i][reason] = "其他,".$v[ExpenseItem][itemType].",".$v[ExpenseItem][itemName];
			}
			$arrRet[$i][income] = $v[moneyIncome];
			$arrRet[$i][expense] = null;
			$arrRet[$i][memo] = $v[memo];
			$arrRet[$i][dt] = $v[dt];
			$arrRet[$i][account] = $v[AccountItem][itemName];
			$arrRet[$i][type] = $v[type];
			$i++;
			$totalIncome+=$v[moneyIncome];
		}

		//排序
		$arrRet = array_column_sort($arrRet,'dt');

		//加入合计行
		$arrRet[$i][date] ='<b>合计</b>';
		$arrRet[$i][income] = "<b>$totalIncome</b>";
		$arrRet[$i][expense] = "<b>$totalExpense</b>";
		$arrRet[$i][memo] = "<b>".($totalIncome-$totalExpense)."</b>";
		//dump($arrRet);exit;
		//增加合计行

		//设置模板
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"date" =>"日期",
			"account" => "帐户",
			"type" => "结算方式",
			"reason" =>"发生说明",
			"income" =>"收入",
			"expense" =>"支出",
			"memo" => "备注"
		);
		$smarty->assign('title',$this->title);
		$smarty->assign('compCode',$arr[compCode]);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$arrRet);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->display('TableList.tpl');
	}
}
?>