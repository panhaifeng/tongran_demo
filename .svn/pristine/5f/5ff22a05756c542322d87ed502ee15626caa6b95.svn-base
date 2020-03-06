<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Report_DenimTrad extends Tmis_Controller {
	var $_modelExample;
	var $funcId=47;
	var $title ='牛仔业务考核';
	function Controller_CaiWu_Report_DenimTrad() {		
		$this->_modelExample = & FLEA::getSingleton('Model_Trade_Denim_Order');
	}

	function actionRight(){
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arrParam = array('dateFrom'=>date("Y-m-01"),'dateTo'=>date("Y-m-d"),'traderId'=>'');
		$arr = TMIS_Pager::getParamArray($arrParam);
		$arrCondition = array();
		$arrCondition[] = "dateOrder>='$arr[dateFrom]' and dateOrder<='$arr[dateTo]'";
		if ($arr[traderId]!="") $arrCondition[] = "trade_denim_order.traderId = '$arr[traderId]'";
		
		$orders =$this->_modelExample->findAll($arrCondition);
		$arrR = array();
		$mPro = FLEA::getSingleton('Model_JiChu_Product');
		$i=0;
		if (count($orders)>0) foreach($orders as & $v) {			
			if (count($v[Products])>0) foreach ($v[Products] as & $va) {
				$arrR[$i][dateOrder] = $v[dateOrder];
				$arrR[$i][clientName] = $v[Client][compName];
				$arrR[$i][orderCode] = $v[orderCode];
				$arrR[$i][manuCode] = $va[manuCode];
				$pro = $mPro->find($va[productId]);
				$arrR[$i][proCode] = $pro[proCode];
				$arrR[$i][proName] = $pro[proName];
				$arrR[$i][guige] = $pro[guige];
				$arrR[$i][danjia] = $va[danjia];
				$arrR[$i][cntKg] = $va[cntKg];
				
				$str = "select sum(cntKg) sum from chengpin_denim_cpck2ordpro where order2ProductId ='$va[id]'";
				
				$temp =mysql_fetch_array(mysql_query($str));
				$arrR[$i][cntSend] = $temp[sum];
				$temp = $temp[sum] - $va[cntKg];
				if ($temp<0) $color="red";else $color="blue";
				$arrR[$i][tot] = "<font color='$color'>$temp</font>";
				$i++;
			}
		}
		
		//设置模板
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"dateOrder" =>"接单日期",
			"clientName" => "客户",
			"orderCode" => "合同号",
			"manuCode" =>"生产编号",
			"proCode" =>"产品编号",
			"proName" =>"品名",
			"guige" =>"规格",		
			"danjia" =>"单价",	
			"cntKg" =>"要货数量",
			"cntSend" =>"已发数量",
			"tot" =>"小计"
		);		
		$smarty->assign('title',$this->title);		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$arrR);
		$smarty-> display('CaiWu/Report/DenimTrad.tpl');
	}	
}
?>