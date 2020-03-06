<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Ar_Report extends Tmis_Controller {
	var $_modelExample;
	var $funcId=45;
	function Controller_CaiWu_Ar_Report() {
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Ar_Report');
	}

	//显示调整的记录
	function actionAdjust() {
		$this->authCheck($this->funcId);

		$m=& FLEA::getSingleton('Model_CaiWu_Ar_Income');
		$condition = array(
			type=>9,
			clientId=>$_GET['clientId'],
			array('dateIncome',$_GET[dateFrom],'>='),
			array('dateIncome',$_GET[dateTo],'<=')
		);
		$rowset=$m->find($condition);

		$smarty = & $this->_getView();
		if(!$rowset) {
			$_m = & FLEA::getSingleton('Model_JiChu_Client');
			$cli = $_m->find(array('id'=>$_GET[clientId]));
			$rowset = array(
				Client => array(
					id=>$_GET[clientId],
					compName=>$cli[compName]
				),
				dateIncome => $_GET[dateFrom],
				clientId =>$_GET[clientId]
			);
		}
		//$dbo = FLEA::getDBO(false);
		//dump($dbo->log);exit;
		$smarty->assign('row',$rowset);
		$smarty->display('CaiWu/Ar/AdjustEdit.tpl');
	}

	function actionSaveAdjust() {
		$m=& FLEA::getSingleton('Model_CaiWu_Ar_Income');
		if($m->save($_POST)) {
			js_alert('折扣修改成功','window.close();window.opener.history.go()');
		}
	}

	function actionRight(){
		set_time_limit(0);
		$this->authCheck($this->funcId);
		$modelInvoice =& FLEA::getSingleton('Model_Caiwu_Ar_Invoice');
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId=>0,
			month=>0
		));
        //$m=$_POST['date'];
        if($arrGet['month']>0)
		{
			$m =$arrGet['month'];
			$arrGet['dateFrom']=date("Y-").$m."-01";
			$arrGet['dateTo']= date('Y-m-d',mktime(0,0,0,$m+1,0,date("Y")));

		//dump($arrGet);
		}

		//$condition = array();
		if ($arrGet[clientId] >0) $condition[] = array('id', $arrGet[clientId]);

		$pager =& new TMIS_Pager($this->_modelExample,$condition,null,100);
		$rowset =$pager->findAll();
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i]['traderName'] = $rowset[$i]['Trader']['employName'];
			$clientId = $rowset[$i][id];
			$condition = array(
				'dateFrom'=>$arrGet['dateFrom'],
				'dateTo' => $arrGet['dateTo'],
				'clientId' => $clientId
			);

			$rowset[$i][initMoney]  = round($this->_modelExample->getMoneyInit($clientId,$arrGet[dateFrom]),2);	$t1+=$rowset[$i][initMoney];

			//本期发生额,即成品出库产生的数据
			$rukuInfo = $this->_modelExample->getRukuInfo($clientId,$arrGet['dateFrom'],$arrGet['dateTo']);
			//dump($rukuInfo);exit;
			$rCnt = round($rukuInfo['cnt'],2);$t8+=$rCnt;
			$rowset[$i][rukuCnt] = $rCnt;
			$rMoney = round($rukuInfo['money'],2);$t2+=$rMoney;
			$rowset[$i][rukuMoney]  = "<a href='".url('Chengpin_Dye_Cpck','PrintCheckForm',$condition)."' target='_blank'>".$rMoney."</a>";

			//其他应收款
			$otherMoney = round($this->_modelExample->getOtherMoney($clientId,$arrGet[dateFrom],$arrGet[dateTo]),2);$t3+=$otherMoney;
			$rowset[$i][otherMoney]= $otherMoney;

			//在收款登记中产生的数据
			$rowset[$i][chukuMoney] = round($this->_modelExample->getMoneyChuku($clientId,$arrGet[dateFrom],$arrGet[dateTo]),2);$t4+=$rowset[$i][chukuMoney];
			$rowset[$i][adjustMoney] = round($this->_modelExample->getAdjustMoney($clientId,$arrGet[dateFrom],$arrGet[dateTo]),2);$t5+=$rowset[$i][adjustMoney];
			$rowset[$i][remainMoney] = round($rowset[$i][initMoney]+$rMoney+$otherMoney-$rowset[$i][adjustMoney]-$rowset[$i][chukuMoney],2);$t6+=$rowset[$i][remainMoney];
			$rowset[$i][_edit] = "<a href='".url('CaiWu_Ar_Report','Adjust', array(
				'clientId'	=>$clientId,
				'dateFrom'	=>$arrGet['dateFrom'],
				'dateTo'	=>$arrGet['dateTo'],
				'TB_iframe'	=>1
			))."' title='打折' class='thickbox'>打折</a> | <a href='".url('Chengpin_Dye_Cpck','PrintCheckFormCk',array(
				clientId=>$clientId,
				dateFrom=>$arrGet[dateFrom],
				dateTo=>$arrGet[dateTo]
			))."' target='_blank'>对账单</a>";
			//if ($rowset[$i][initMoney]>0) $rowset[$i][returnRate] = number_format($rowset[$i][chukuMoney]/$rowset[$i][initMoney]*100,2,".","")."%";
			//已开发票
			$invoiceSum = round($modelInvoice->getInvoiceSum($arrGet['dateFrom'], $arrGet['dateTo'], $clientId),2);
			if (!$invoiceSum) $invoiceSum = 0;
			$t7+=$invoiceSum;
			$rowset[$i]['invoiceSum'] = "<a href='".url('Caiwu_Ar_Invoice', 'right', $condition)."' target='_blank'>{$invoiceSum}</a>";
		}
		$heji = array(
			"compCode" =>"合计",
			"initMoney" =>$t1,
			"rukuMoney" =>$t2,
			"otherMoney"=>$t3,
			'adjustMoney' =>$t5,
			"chukuMoney" =>$t4,
			"remainMoney" =>$t6,
			'invoiceSum' =>$t7,
			'rukuCnt'=>$t8
		);
		if($rowset) foreach($rowset as & $v) {
			$v['chukuMoney'] .= "[ <a href='".url('CaiWu_Ar_Income','add1',array(
				'clientId'=>$v['id'],
				'dateIncome'=>$arrGet['dateFrom'],
				'TB_iframe'=>1
			))."' title='增加收款纪录' class='thickbox'>新增</a> ]";
		}
		$rowset[] = $heji;
		$smarty = & $this->_getView();
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
		  "id" =>"id",
			"compCode" =>"客户代码",
			"compName" =>"客户名称",
			//"traderName" =>"业务员",
			"initMoney" =>"上期结余",
			"rukuCnt" =>	"本月投料数",
			"rukuMoney" =>"筒染发生额",
			"otherMoney"=>"其他发生额",
			'adjustMoney' => '折扣金额',
			"chukuMoney" =>"本期收款",
			"remainMoney" => "本期结余",
			'invoiceSum' => '本期已开票',
			"_edit" => "操作"
		);
		$smarty->assign('title','应收款报表');
		$smarty->assign('arTypeId',$arr[arTypeId]);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('thickbox','calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty-> display('TableList2.tpl');
	}
        //财务对账中的对账单

	function actionDuizhang(){
        $this->authCheck(141);
		$modelInvoice =& FLEA::getSingleton('Model_Caiwu_Ar_Invoice');
		$mClient =& FLEA::getSingleton('Model_Jichu_Client');
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date('Y-m-d',mktime(0,0,0,date('m')-2,26,date('Y'))),
			'dateTo' => date('Y-m-d',mktime(0,0,0,date('m')-1,25,date('Y'))),
			'clientId'=>0,
			'month'=>0
		));
		//dump($arrGet);exit;
        //$m=$_POST['date'];
        if($arrGet['month']>0)
		{
			$m =$arrGet['month'];
			$arrGet['dateFrom']=date("Y-").$m."-01";
			$arrGet['dateTo']= date('Y-m-d',mktime(0,0,0,$m+1,0,date("Y")));

		//dump($arrGet);
		}

		//$condition = array();
		if ($arrGet[clientId] >0) $condition[] = array('id', $arrGet[clientId]);
		//dump($condition);
		//$pager =& new TMIS_Pager($this->_modelExample,$condition,null,100);
		$pager =& new TMIS_Pager($mClient,$condition,null,200);
		$rowset =$pager->findAll();
		for ($i=0;$i<count($rowset);$i++) {
			$rowset[$i][traderName] = $rowset[$i][Trader][employName];
			$clientId = $rowset[$i][id];
			$condition = array(
				'dateFrom'=>$arrGet['dateFrom'],
				'dateTo' => $arrGet['dateTo'],
				'clientId' => $clientId
			);

			// $rowset[$i][initMoney]  = round($this->_modelExample->getMoneyInit($clientId,$arrGet[dateFrom]),2);	$t1+=$rowset[$i][initMoney];

			//本期发生额,即成品出库产生的数据
			$rukuInfo = $this->_modelExample->getRukuInfo($clientId,$arrGet[dateFrom],$arrGet[dateTo]);
			//dump($rukuInfo);exit;
			$rCnt = round($rukuInfo['cnt'],2);
			$t8+=$rCnt;
			$rowset[$i][rukuCnt] = $rCnt;
			//$rMoney = round($rukuInfo['money'],2);$t2+=$rMoney;
			//$rowset[$i][rukuMoney]  = "<a href='".url('Chengpin_Dye_Cpck','PrintCheckForm',$condition)."' target='_blank'>".$rMoney."</a>";

			//其他应收款
			//$otherMoney = round($this->_modelExample->getOtherMoney($clientId,$arrGet[dateFrom],$arrGet[dateTo]),2);$t3+=$otherMoney;
			//$rowset[$i][otherMoney]= $otherMoney;

			//在收款登记中产生的数据
			//$rowset[$i][chukuMoney] = round($this->_modelExample->getMoneyChuku($clientId,$arrGet[dateFrom],$arrGet[dateTo]),2);$t4+=$rowset[$i][chukuMoney];
			//$rowset[$i][adjustMoney] = round($this->_modelExample->getAdjustMoney($clientId,$arrGet[dateFrom],$arrGet[dateTo]),2);$t5+=$rowset[$i][adjustMoney];
			//$rowset[$i][remainMoney] = round($rowset[$i][initMoney]+$rMoney+$otherMoney-$rowset[$i][adjustMoney]-$rowset[$i][chukuMoney],2);$t6+=$rowset[$i][remainMoney];
			$rowset[$i][_edit] = "<a href='".url('Chengpin_Dye_Cpck','PrintCheckForm',array(
				clientId=>$clientId,
				dateFrom=>$arrGet[dateFrom],
				dateTo=>$arrGet[dateTo]
			))."' target='_blank'>缸号对账单</a>";
			$rowset[$i][_edit] .= "  |   <a href='".url('Chengpin_Dye_Cpck','PrintCheckFormCk',array(
				clientId=>$clientId,
				dateFrom=>$arrGet[dateFrom],
				dateTo=>$arrGet[dateTo]
			))."' target='_blank'>发货对账单</a>";
			//if ($rowset[$i][initMoney]>0) $rowset[$i][returnRate] = number_format($rowset[$i][chukuMoney]/$rowset[$i][initMoney]*100,2,".","")."%";
			//已开发票
			//$invoiceSum = round($modelInvoice->getInvoiceSum($arrGet['dateFrom'], $arrGet['dateTo'], $clientId),2);
			if (!$invoiceSum) $invoiceSum = 0;
			$t7+=$invoiceSum;
			//$rowset[$i]['invoiceSum'] = "<a href='".url('Caiwu_Ar_Invoice', 'right', $condition)."' target='_blank'>{$invoiceSum}</a>";
		}
		//dump($rowset);
		$heji = array(
			"compName" =>"合计",
			"initMoney" =>$t1,
			"rukuMoney" =>$t2,
			"otherMoney"=>$t3,
			'adjustMoney' =>$t5,
			"chukuMoney" =>$t4,
			"remainMoney" =>$t6,
			'invoiceSum' =>$t7,
			'rukuCnt'=>$t8
		);
		if($rowset) foreach($rowset as & $v) {
			$v['chukuMoney'] .= "[ <a href='".url('CaiWu_Ar_Income','add1',array(
				'clientId'=>$v['id'],
				'dateIncome'=>$arrGet['dateFrom'],
				'TB_iframe'=>1
			))."' title='增加收款纪录' class='thickbox'>新增</a> ]";
		}
		$rowset[] = $heji;
		$smarty = & $this->_getView();
		$pk = $this->_modelExample->primaryKey;
                //dump($rowset);exit;
		foreach($rowset as & $v){
			//dump($v);
			if($v['rukuCnt']>0){
				$row[]=$v;
			}
		}
		//dump($rowset);
		//dump($row);
                //dump($rowset);
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
		 // "id" =>"id",
			//"compCode" =>"客户代码",
			"compName" =>"客户名称",
			//"traderName" =>"业务员",
			//"initMoney" =>"上期结余",
			"rukuCnt" =>	"本月发货数",
			//"rukuMoney" =>"筒染发生额",
			//"otherMoney"=>"其他发生额",
			//'adjustMoney' => '折扣金额',
			//"chukuMoney" =>"本期收款",
			//"remainMoney" => "本期结余",
			//'invoiceSum' => '本期已开票',
			"_edit" => "操作"
		);
		$smarty->assign('title','对账单');
		$smarty->assign('arTypeId',$arr[arTypeId]);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('thickbox','calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty-> display('TableList2.tpl');
     }
}
?>