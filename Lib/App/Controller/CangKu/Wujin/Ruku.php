<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Cangku_Wujin_Ruku extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 111;
	function Controller_Cangku_Wujin_Ruku() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_Cangku_Wujin_Ruku');
	}

	#厂部自拖货浏览
	function actionRight()	{
		$title = '五金仓库管理-入库查询';
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d')
			//'supplierId'=>0,
			//'wujinWareId'=>0
			//'type'=>0
		));
		$condition = array(
			//'type'=>$arr['type'],
			array('dateRuku',$arr['dateFrom'],'>='),
			array('dateRuku',$arr['dateTo'],'<=')
		);
		if ($_GET['wareId']>0) $condition['wareId'] = $_GET['wareId'];
		//if ($arr['traderId']>0) $condition['traderId'] = $arr['traderId'];
		//dump($condition);
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		//echo $pager;
        $rowset =$pager->findAll();
		if(count($rowset)>0) foreach($rowset as & $v){
			//$v['money'] = $v['danjia']*$v['dfWeight'];
			//$v['dif'] = round($v['jingWeight'] - $v['dfWeight'],2);
			//$v['dif'] = $v['dif']==0 ? '': "<font color='red'>".$v['dif']."</font>";
			$v['money'] = round($v['danjia']*$v['cnt'],2);
			$v['_edit'] = $this->getEditHtml($v['id']) . ' | ' . $this->getRemoveHtml($v['id']);

		}
		$rowset[] = $this->getHeji($rowset,array('cnt','money'),'dateRuku');
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$arr_field_info = array(
			"dateRuku"				=>"日期",
			"Ware.wareName"			=>"品名",
			//"Supplier.compName"		=>"拉货单位",
			"cnt"					=>"数量",
			"danjia"				=>"单价",
			"money"					=>"金额",
			"memo"					=>"备注",
			'_edit'					=>'操作'
		);

		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('nowrap', 1);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display('TableList2.tpl');
		//echo "<a href='".$this->_url('export2excel')."'>导出</a>";
	}


	function _edit($Arr) {
		$title = '五金仓库-入库登记';
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign("aRow",$Arr);
		$smarty->display('Cangku/Wujin/Ruku.tpl');
	}

}
?>