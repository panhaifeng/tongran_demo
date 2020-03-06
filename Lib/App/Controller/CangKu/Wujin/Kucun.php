<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Cangku_Wujin_Kucun extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 111;
	function Controller_Cangku_Wujin_Kucun() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_Cangku_Wujin_Kucun');
	}

	#厂部自拖货浏览
	function actionRight()	{
		$title = '五金仓库管理-库存查询';
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d')
			//'supplierId'=>0,
			//'traderId'=>0,
			//'type'=>0
		));

		$sql = $this->_modelExample->getKucunSql($arr['dateFrom'],$arr['dateTo']);
		//dump($sql);exit;
		//if ($arr['supplierId']>0) $condition['supplierId'] = $arr['supplierId'];
		//if ($arr['traderId']>0) $condition['traderId'] = $arr['traderId'];
		//dump($condition);
		$pager =& new TMIS_Pager($sql,null,null,100);
		//echo $pager;
        $rowset =$pager->findAll();
		$mWare = & FLEA::getSingleton('Model_JiChu_WareWujin');
		$m = & $this->_modelExample;
		if(count($rowset)>0) foreach($rowset as & $v){
			//$v['money'] = $v['danjia']*$v['dfWeight'];
			//$v['dif'] = round($v['jingWeight'] - $v['dfWeight'],2);
			//$v['dif'] = $v['dif']==0 ? '': "<font color='red'>".$v['dif']."</font>";
			$v['Ware'] = $mWare->find(array('id'=>$v['wareId']));
			$init = $m->getInitInfo($v['wareId'],$arr['dateFrom']);
			$ruku = $m->getRukuInfo($v['wareId'],$arr['dateFrom'],$arr['dateTo']);
			$chuku = $m->getChukuInfo($v['wareId'],$arr['dateFrom'],$arr['dateTo']);

			$v['cntInit'] = $init['cnt'];
			$v['cntRuku'] = $ruku['cnt'];
			$v['cntChuku'] = $chuku['cnt'];
			$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'],2);
		}
		$heji = $this->getHeji($rowset,array('cntInit','cntRuku','cntChuku','cntKucun'),'wareId');
		if(count($rowset)>0) foreach($rowset as & $v){
			$v['cntRuku'] = "<a href='".url('Cangku_Wujin_Ruku','right',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'wareId'=>$v['wareId']
			))."' target='_blank'>".$v['cntRuku']."</a>";
			$v['cntChuku'] = "<a href='".url('Cangku_Wujin_Chuku','right',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'wareId'=>$v['wareId']
			))."' target='_blank'>".$v['cntChuku']."</a>";
			//$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'],2);
		}

		$rowset[] = $heji;
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$arr_field_info = array(
			"wareId"				=>"系统编号",
			"Ware.wareName"			=>"品名",
			//"Supplier.compName"		=>"拉货单位",
			"cntInit"					=>"期初数量",
			"cntRuku"				=>"本期入库",
			"cntChuku"					=>"本期出库",
			"cntKucun"					=>"本期结余"
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
		$title = '五金仓库-出库登记';
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign("aRow",$Arr);
		$smarty->display('Wujin/Chuku.tpl');
	}

	function actionSave(){
		//取得最近的采购单价
		$sql = "select danjia from wujin_ruku where wareId='{$_POST['wareId']}' order by id desc limit 0,1";
		$re = $this->_modelExample->findBySql($sql);
		$_POST['danjia']=$re[0]['danjia']+0;
		parent::actionSave();
	}

}
?>