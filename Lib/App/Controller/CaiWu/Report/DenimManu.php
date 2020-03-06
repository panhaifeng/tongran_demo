<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Report_DenimManu extends Tmis_Controller {
	var $_modelExample;
	var $funcId=48;
	var $title ='牛仔生产考核';
	function Controller_CaiWu_Report_DenimManu() {		
		$this->_modelExample = & FLEA::getSingleton('Model_Trade_Denim_Order2Product');
		$this->_modelExample->enableLink('Cpck');
		$this->_modelExample->enableLink('Cprk');
	}

	function actionRight(){
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arrParam = array('manuCode'=>'');
		$arr = TMIS_Pager::getParamArray($arrParam);
		$condition = "manuCode like '%$arr[manuCode]%'";
		
		$pager = & new TMIS_pager($this->_modelExample,$condition);
		$rows =$pager->findAll();
		$arrR = array();
		$mPro = FLEA::getSingleton('Model_JiChu_Product');
		$i=0;
		if (count($rows)>0) foreach($rows as & $v) {			
			$v[proCode] = $v[Product][proCode];
			$v[proName] = $v[Product][proName];
			$v[guige] = $v[Product][guige];
			//成品入库数量
			if (count($v[Cprk])>0) $v[cntManu] = array_sum(array_col_values($v[Cprk],'cntKg'));
			//发货数量
			if (count($v[Cpck])>0) $v[cntSend] =array_sum(array_col_values($v[Cpck],'cntKg'));
			//库存数量
			$v[remain] = $v[cntManu]-$v[cntSend];			
		}
		
		//设置模板
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"manuCode" =>"生产编号",
			"proCode" =>"产品编号",
			"proName" =>"品名",
			"guige" =>"规格",
			"cntKg" =>"要货数量",
			"cntManu" =>"生产数量",
			"cntSend" =>"发出数量",
			"remain" =>"目前余存"
		);		
		$smarty->assign('title',$this->title);		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rows);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display('CaiWu/Report/DenimManu.tpl');
	}	
}
?>