<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Yf_Payment extends Tmis_Controller {
	var $_modelExample;
	var $title = "付款登记";
	var $funcId = 32;
	function Controller_CaiWu_Yf_Payment() {
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Yf_Payment');
	}	

	function actionRight()	{
		$this->authCheck($this->funcId);
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			payType=>'',
			dateFrom=>date("Y-m-01"),
			dateTo=>date("Y-m-d"),
		));
		$condition = array(
			array('datePay',$arr[dateFrom],'>='),
			array('datePay',$arr[dateTo],'<=')
		);
		$pager =& new TMIS_Pager($this->_modelExample,$condition,null,200);
        $rowset =$pager->findAll();
		
		for ($i=0;$i<count($rowset);$i++) {
			if ($rowset[$i]['type']=='0') $rowset[$i]['type'] = '现金';
			if ($rowset[$i]['type']=='1') $rowset[$i]['type'] = '支票';
			if ($rowset[$i]['type']=='2') $rowset[$i]['type'] = '电汇';
			if ($rowset[$i]['type']=='3') $rowset[$i]['type'] = '其他';
			if ($rowset[$i]['type']=='4') $rowset[$i]['type'] = '承兑';
			if ($rowset[$i]['type']=='5') $rowset[$i]['type'] = '汇票';
			$rowset[$i][supplierName] = $rowset[$i][Supplier][compName];
			$rowset[$i][accountItemName] = $rowset[$i][AccountItem][itemName];
			$totalMoney += $rowset[$i][moneyPay];
		}

		$i = count($rowset);
		$rowset[$i][payNum] = '<strong>合计</strong>';
		$rowset[$i][moneyPay] = '<strong>'.$totalMoney.'</strong>';
		
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"payNum" =>"付款记录编号",
			"type" =>"付款类型",
			"datePay" =>"付款日期",
			"accountItemName" => "银行帐户",
			"supplierName" =>"收款供应商",
			"moneyPay" => "金额",
			"memo" => "备注"
		);
		
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('search_item',"<select onchange=\"window.location.href='Index.php?controller=CaiWu_Expense&action=right'\"><option>采购付款记录</option><option>非采购付款记录</option></select>");
		$smarty->assign('arr_edit_info',$arr_edit_info);
		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=CaiWu_Yf_Payment&action=Right', $arr));
		$smarty->assign('controller', 'CaiWu_Yf_Payment');
		$smarty->assign('arr_condition',$arr);
		$smarty-> display('TableList.tpl');
	}
	
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");		
		$smarty->assign("pk",$primary_key);
		//设置radio控件
		$smarty->assign('typeOptions', FLEA::getAppInf('paymentTypes'));	
		$smarty->display('CaiWu/Yf/Payment.tpl');
	}

	function actionAdd() {		
		$this->_edit(array('payNum'=>$this->getNextPayNum()));
	}

	function actionSave() {       	
		$id = $this->_modelExample->save($_POST);
		if ($_POST[id]!="") $id = $_POST[id];
		if ($_POST[Submit]=='确定')	redirect($this->_url("Right"));
		elseif ($_POST[Submit]=='确定并抵冲凭证') redirect($this->_url("payment2Invoice",array('id'=>$id)));		
	}

	function actionEdit() {
		//$this->_editable($_GET[id]);
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);		
		$this->_edit($aRow);
	}	

	function actionRemove() {
		$this->_editable($_GET[id]);
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[$pk]);
		redirect(url("CaiWu_Yf_Payment","Right"));
	}
	//显示抵冲凭证的界面
	function actionPayment2Invoice() {
		$this->authCheck($this->funcId);
		$payment = $this->_modelExample->find($_GET[id]);
		$payment[supplierName] = $payment[Supplier][compName];	
		
		$_model = FLEA::getSingleton('Model_CaiWu_Yf_Invoice');
		$invoices = $_model->findAll("paymentId='$_GET[id]'");
		
		//显示抵冲模板		
		$smarty = & $this->_getView();
		$smarty->assign('total_money',$this->_modelExample->getMoneyInvoice($_GET[id]));
		$smarty->assign('aPayment',$payment);
		$smarty->assign('arr_invoices',$invoices);
		$smarty->display('CaiWu/Yf/payment2Invoice.tpl');
	}
	//设置凭证的paymentId
	function actionSaveLink(){
		$_model = FLEA::getSingleton('Model_CaiWu_Yf_Invoice');
		$ids = join("','",$_POST[invoiceId]);
		$_model->updateField("id in ('$ids')",'paymentId',$_POST[id]);
		redirect($this->_url("Right"));
	}
	//取消付款信息和某笔凭证的对应关系
	function actionCancelLink() {
		$_model = FLEA::getSingleton('Model_CaiWu_Yf_Invoice');
		$ware = $_model->updateField("id='$_GET[invoiceId]'",'paymentId',0);
		redirect($this->_url('payment2Invoice',array('id'=>$_GET[paymentId])));
	}

	//判断是否允许修改,有下列情况之一不允许修改或者删除
	//1,操作日期超过24小时。
	function _editable($pkv) {
	/**/
		$p = $this->_modelExample->find($pkv);
		if (date("Y-m-d H:i:s",mktime(date("H")-24,0,0,date("m"),date("d"),date("Y")))>$p[dt]) 
			js_alert('录入时间已经超过24小时，不允许修改!','',$_SERVER['HTTP_REFERER']);
			
	
	}

	//取得最大的凭证编号
	function getMaxPayNum() {
		$arr=$this->_modelExample->find(null,'payNum desc');		
		$model = FLEA::getSingleton("Model_CaiWu_Expense");
		$arr2 = $model->find(null,'payNum desc');
		return $arr[payNum]>$arr2[payNum]?$arr[payNum]:$arr2[payNum];		
	}
	function getNextPayNum(){
		$maxPayNum = $this->getMaxPayNum();
		$temp = date("ym")."001";
		if ($temp>$maxPayNum) return $temp;
		$a = substr($maxPayNum,-3)+1001;
		return substr($maxPayNum,0,-3).substr($a,1);
	}
}
?>