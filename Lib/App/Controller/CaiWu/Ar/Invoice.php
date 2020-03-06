<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Ar_Invoice extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 42;
	function Controller_CaiWu_Ar_Invoice() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Ar_Invoice');
	}	
	function actionRight(){
		$this->authCheck($this->funcId);

		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			'dateTo' => date("Y-m-d"),
			'clientId'=>'',
			//'key'=>''
		));

		$condition[] = array('type', 1, '>'); //凭证的类型,从0开始递增，分别代表采购发票,采购对账明细单,销售发票,销售对账明细单等
		$condition[] = array('dateInput', $arr['dateFrom'], '>=');	
		$condition[] = array('dateInput', $arr['dateTo'], '<=');
		if ($arr['clientId']) $condition[] = array('clientId', $arr['clientId']);
		//if ($arr['key'] != '') $condition[] = array('invoiceNum', $arr['key']);

		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();
		$row=$this->_modelExample->findAll($condition);
		//dump($row);
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][clientName] = $rowset[$i][Client][compName];
			//$rowset[$i][chukuMoney] = $this->_modelExample->getMoneyChuku($rowset[$i][id]);
			$rowset[$i]['_edit']=$this->getEditHtml($rowset[$i]['id']).'  '.$this->getRemoveHtml($rowset[$i]['id']); 
		}
		$heji=$this->getHeji($rowset,array('money'),'invoiceNum');
		$rowset[]=$heji;
		$zongji=$this->getHeji($row,array('money'));
		$zongji['invoiceNum']='<b>总计</b>';
		$rowset[]=$zongji;
		$smarty = & $this->_getView();		
		$smarty->assign('title', '销售发票登记');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"invoiceNum" =>"凭据号码",
			"type" =>"凭据类型",
			"dateInput" =>"录入日期",
			"clientName" =>"客户",
			"money" => "凭证金额",
			//"chukuMoney" => "抵冲金额",
			"memo" => "备注",
			'_edit'=>'操作'
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=CaiWu_Ar_Invoice&action=Right'));
		$smarty->assign('arr_condition', $arr);
		$smarty-> display('TableList.tpl');
	}

	function _edit($Arr) {
		$this->authCheck($this->funcId);		
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$smarty->display('CaiWu/Ar/Invoice.tpl');
	}

	function actionAdd() {		
		$this->_edit(array());
	}

	function actionSave() {
       	$id = $this->_modelExample->save($_POST);
		if ($_POST[id]!="") $id = $_POST[id];
		if ($_POST[Submit]=='确定')	redirect(url("CaiWu_Ar_Invoice","Right"));
		elseif ($_POST[Submit]=='确定并抵冲发货单') redirect(url("CaiWu_Ar_Invoice","Invoice2Chuku",array('id'=>$id)));
	}

	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);		
		$this->_edit($aRow);
	}

	#根据主键删除,并返回到action=right
	function actionRemove() {
		$aaa = $this->_modelExample->removeByPkv($_GET['id'], false);
		//if ($aaa) echo("true");
		//else echo("false"); 

		redirect($this->_url("right"));
		//else js_alert('出错，不允许删除!',"window.history.go(-1)");
	}
	
	//抵冲入库单
	function actionInvoice2Chuku() {
		$this->authCheck($this->funcId);
		$invoice = $this->_modelExample->find($_GET[id]);		
		$invoice[clientName] = $invoice[Client][compName];	
		
		$_model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
		$modelPro = FLEA::getSingleton('Model_JiChu_Product');
		$wares = $_model->findAll("invoiceId='$_GET[id]'");
		if (count($wares)>0) foreach($wares as &$v){
			$v[Product] = $modelPro->find($v[Ordpro][productId]);
		}
		//dump($wares);exit;
		//显示抵冲模板		
		$smarty = & $this->_getView();
		$smarty->assign('total_money',$this->_modelExample->getMoneyChuku($_GET[id]));
		$smarty->assign('aInvoice',$invoice);
		$smarty->assign('arr_wares',$wares);
		$smarty->display('CaiWu/Ar/Invoice2Chuku.tpl');
	}

	//保存要抵冲的入库单信息
	function actionSaveChuku(){
		$_model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
		$ids = join("','",$_POST[cpck2OrdproId]);
		$_model->updateField("id in ('$ids')",'invoiceId',$_POST[id]);
		redirect(url("CaiWu_Ar_Invoice","Right"));
	}

	//取消凭证和某笔入库记录的对应关系
	function actionCancelChuku() {
		$_model = FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
		$ware = $_model->updateField("id='$_GET[cpck2OrdproId]'",'invoiceId',0);
		redirect($this->_url('invoice2Chuku',array('id'=>$_GET[invoiceId])));
	}

	//取得json数组
	function actionGetInvoiceJson(){		
		$invoices = $this->_modelExample->findAll("invoiceNum like '%$_GET[invoiceNum]%'");		
		echo json_encode($invoices);exit;
	}
}
?>