<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Yf_Invoice extends Tmis_Controller {
	var $_modelExample;
	var $funcId;
	function Controller_CaiWu_Yf_Invoice() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Yf_Invoice');
	}

	function actionRight(){
		$this->funcId = 136;		//仓库-染化料-付款凭证登记-查询
		$this->authCheck($this->funcId);

		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			'dateTo' => date("Y-m-d"),
			'supplierId'=>'',
			//'key'=>''
		));

		$condition[] = array('type', 2, '<'); //凭证的类型,从0开始递增，分别代表采购发票,采购对账明细单,销售发票,销售对账明细单等
		$condition[] = array('dateInput', $arr['dateFrom'], '>=');
		$condition[] = array('dateInput', $arr['dateTo'], '<=');
		if ($arr['supplierId']) $condition[] = array('supplierId', $arr['supplierId']);
		//if ($arr['key'] != '') $condition[] = array('invoiceNum', $arr['key']);

		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		$rowset =$pager->findAll();
		$row=$this->_modelExample->findAll($condition);
		for ($i=0;$i<count($rowset);$i++) {
			if ($rowset[$i]['type']=='0') {
				$rowset[$i]['type'] = '采购发票';
			}
			if ($rowset[$i]['type']=='1') {
				$rowset[$i]['type'] = '采购对账单';
			}
			$rowset[$i][supplierName] = $rowset[$i][Supplier][compName];
			$rowset[$i][rukuMoney] = $this->_modelExample->getMoneyRuku($rowset[$i][id]);
			$rowset[$i]['_edit']=$this->getEditHtml($rowset[$i]['id']).'  '.$this->getRemoveHtml($rowset[$i]['id']);
		}
		$heji=$this->getHeji($rowset,array('money'),'invoiceNum');
		$rowset[]=$heji;
		$zongji=$this->getHeji($row,array('money'));
		$zongji['invoiceNum']='<b>总计</b>';
		$rowset[]=$zongji;
		$smarty = & $this->_getView();
		$smarty->assign('title', '付款凭证登记');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"invoiceNum" =>"凭据号码",
			"type" =>"凭据类型",
			"dateInput" =>"录入日期",
			"supplierName" =>"供应商",
			"money" => "凭证金额",
			"rukuMoney" => "抵冲金额",
			"memo" => "备注",
			'_edit'=>'操作'
		);
		$smarty->assign('supplier_name', '供应商');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->assign('controller', 'CaiWu_Yf_Invoice');
		$smarty-> display('TableList.tpl');
	}

	//显示待审核的付款凭证
	function actionCheckInvoice() {
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		$condition = 'type<2';
		$this->authCheck(11);
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();

		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][supplierName] = $rowset[$i][Supplier][compName];
			$rowset[$i][rukuMoney] = $this->_modelExample->getMoneyRuku($rowset[$i][id]);
		}

		//dump($rowset);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','付款凭证审核');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"statu"=>"状态",
			"invoiceNum" =>"凭据号码",
			"type" =>"凭据类型",
			"dateInput" =>"录入日期",
			"supplierName" =>"供应商",
			"money" => "凭证金额",
			"rukuMoney" => "抵冲金额",
			"memo" => "备注",
			"edit" => "操作"
		);
		#对操作栏进行赋值
		if (count($rowset)>0) {
			foreach ($rowset as & $aRow) {
				if ($aRow[isChecked]==0) {$temp = '确认审核';$aRow[statu]='<font color=red>未审核</font>';}
				if ($aRow[isChecked]==1) {$temp = '取消审核';$aRow[statu]='已审核';}
				$aRow[edit] = "<a href='?controller=CangKu_RuKu&action=ShowWares2Invoice&id=$aRow[id]' target='_blank'>显示入库明细</a>
				<a href='?controller=CaiWu_Yf_Invoice&action=doCheck&id=$aRow[id]'>$temp</a>";
			}
		}
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		//$smarty->assign('search_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=CaiWu_Yf_Invoice&action=CheckInvoice'));
		$smarty-> display('TableList.tpl');
	}

	function actionDoCheck() {
		$id = $_GET[id];
		if (!$this->_modelExample->isChecked($id)) $check=1;
		else $check = 0;
		$this->_modelExample->updateField("id='$id'",'isChecked',$check);
		redirect($this->_url('checkInvoice'));
	}

	function _edit($Arr) {
		//$this->funcId = 67;		//仓库-染化料-付款凭证登记-修改
		//$this->authCheck($this->funcId);
		//假如已经审核则不允许修改
		if ($this->_modelExample->isChecked($Arr[id])) {
			js_alert('该凭证已经审核，不允许修改!','',$_SERVER['HTTP_REFERER']);
		}
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		$smarty->assign("pk",$primary_key);
		//设置radio控件
		$smarty->assign('typeValues', array(0,1,2));
		$smarty->assign('typeCaptions', array('采购发票','对账明细单','其他'));
		//$smarty->assign('customer_id', 1001);

		$smarty->display('CaiWu/Yf/Invoice.tpl');
	}

	function actionAdd() {
		$this->_edit(array());
	}

	function actionSave() {
       	$id = $this->_modelExample->save($_POST);
		if ($_POST[id]!="") $id = $_POST[id];
		if ($_POST[Submit]=='确定')	redirect(url("CaiWu_Yf_Invoice","Right"));
		elseif ($_POST[Submit]=='确定并抵冲入库单') redirect(url("CaiWu_Yf_Invoice","Invoice2Ruku",array('id'=>$id)));
	}

	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);
		$this->_edit($aRow);
	}

	function actionRemove() {
		$this->funcId = 67;		//仓库-染化料-付款凭证登记-删除
		$this->authCheck($this->funcId);

		//假如已经审核则不允许修改
		/**/
		if ($this->_modelExample->isChecked($_GET[id])) {
			js_alert('该凭证已经审核，不允许修改!','',$_SERVER['HTTP_REFERER']);
		}
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[id]);

		redirect(url("CaiWu_Yf_Invoice","Right"));
	}
	//抵冲入库单
	function actionInvoice2Ruku() {
		$this->authCheck($this->funcId);
		$invoice = $this->_modelExample->find($_GET[id]);
		$invoice[supplierName] = $invoice[Supplier][compName];

		$_model = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$wares = $_model->findAll("invoiceId='$_GET[id]'");
		//dump($wares);exit;
		//dump($invoice);exit;
		//显示抵冲模板
		$smarty = & $this->_getView();
		$smarty->assign('total_money',$this->_modelExample->getMoneyRuku($_GET[id]));
		$smarty->assign('aInvoice',$invoice);
		$smarty->assign('arr_wares',$wares);
		$smarty->display('CaiWu/Yf/Invoice2Ruku.tpl');
	}
	//保存要抵冲的入库单信息
	function actionSaveRuku(){
		//dump($_POST);exit;
		$_model = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$ids = join("','",$_POST[ruku2WareId]);
		$_model->updateField("id in ('$ids')",'invoiceId',$_POST[id]);
		redirect(url("CaiWu_Yf_Invoice","Right"));
		//dump($_model->dbo->log);exit;
	}
	//取消凭证和某笔入库记录的对应关系
	function actionCancelRuku() {
		$_model = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$ware = $_model->updateField("id='$_GET[ruku2WareId]'",'invoiceId',0);
		redirect($this->_url('invoice2Ruku',array('id'=>$_GET[invoiceId])));
	}
	//取得json数组
	function actionGetInvoiceJson(){
		$invoices = $this->_modelExample->findAll("invoiceNum like '%$_GET[invoiceNum]%'");
		echo json_encode($invoices);exit;
	}
}
?>