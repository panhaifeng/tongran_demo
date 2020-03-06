<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Report_MonthDye extends Tmis_Controller {
	var $_modelExample;
	var $funcId=106;
	function Controller_CangKu_Report_MonthDye() {		
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_Report_MonthDye');		
		$this->mWare =  & FLEA::getSingleton('Model_JiChu_Ware');
	}
	
	//坯纱加工库存报表
	function actionRight(){
		$this->authCheck(13);
		//必须选客户		
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m")-1,26,date("Y"))),
			dateTo => date("Y-m-d",mktime(0,0,0,date("m"),25,date("Y"))),
			ylId=>0
		));
		//限制起始和截止日期必须为26号和25号
		if('26'!=substr($arrGet['dateFrom'],-2)) {
			TMIS_Pager::clearCondition();
			js_alert('起始日期为26号!');
		}
		if('25'!=substr($arrGet['dateTo'],-2)) {
			TMIS_Pager::clearCondition();
			js_alert('截止日期为25号!');
		}
		$ymd = explode('-',$arrGet['dateTo']);
		$datePandian = date("Y-m-d",mktime(0,0,0,$ymd[1],25,$ymd[0]));

		if ($_GET['parentId']!='') {
			//$clientId = $arrGet['clientId'];			
			//得到坯纱规格id的范围
			$topNode = $this->mWare->find(array('id'=>$_GET['parentId']));
			$leftId = $topNode[leftId];
			$rightId = $topNode[rightId];
			$nodeCondition = "leftId>'$leftId' and rightId<'$rightId' and leftId+1=rightId";
			if($arrGet['ylId']>0) $nodeCondition .= " and id={$arrGet['ylId']}";
			$arrNode = $this->mWare->findAll($nodeCondition);
			//dump($arrNode);
			////对每一个坯纱的品种进行搜索,如果3个项目都空，则不显示。
			$dateFrom = $arrGet[dateFrom];			
			$dateTo = $arrGet[dateTo];
			$newArr = array();
			foreach($arrNode as $v) {
				$wareId = $v[id];
				$ware = $this->mWare->find("id='$wareId'");
				$tempArr=array();
				$tempArr[wareId] = $wareId;
				$tempArr[shazhi] = $ware[wareName] . " " . $ware[guige];
				$init = $this->_modelExample->getInitInfo($wareId,$dateFrom);
				
				$ruku = $this->_modelExample->getRukuInfo($wareId,$dateFrom,$dateTo);
				$pandian = $this->_modelExample->getPandianInfo($wareId,$datePandian);

				$tempArr[cntInit] = $init['cnt'];$tempArr[moneyInit] = $init['money'];
				$tempArr[cntRuku] = $ruku['cnt'];$tempArr[moneyRuku] = $ruku['money'];
				$tempArr[cntRemain] = $pandian['cnt'];$tempArr[moneyRemain] = $pandian['money'];
				//echo $pandian['cnt']."-".$init['cnt']."-".$ruku['cnt'];
				$tempArr[moneyChuku] = ($pandian['money']-$init['money']-$ruku['money'])*-1;
				$tempArr[cntChuku] = ($pandian['cnt']-$init['cnt']-$ruku['cnt'])*-1;
				$tempArr['_edit'] = "<a href='".$this->_url('addPandian',array(
					'wareId'=>$wareId,
					'datePandian'=>$datePandian
				))."' onclick='return confirm(\"录入数据将作为".$datePandian."的盘点结果保存,您确认吗？\")' target='_blank'>录入盘点数据</a>";
				$newArr[] = $tempArr;	
				
			}
			$initTotal=0;$rukuTotal=0;$chukuTotal=0;
			$initMoneyTotal=0;$rukuMoneyTotal=0;$chukuMoneyTotal=0;
			
			//加入合计
			$i = count($newArr);
			$newArr[$i][shazhi] = '<b>合计</b>';
			$newArr[$i][cntInit]  = '<b>'.$initCntTotal.'</b>';
			$newArr[$i][cntRuku]  = '<b>'.$rukuCntTotal.'</b>';
			$newArr[$i][cntChuku] = '<b>'.$chukuCntTotal.'</b>';
			$newArr[$i][cntTuiku] = '<b>'.$tuikuCntTotal.'</b>';
			$newArr[$i][cntRemain] = '<b>'.($initCntTotal+$rukuCntTotal+$tuikuCntTotal-$chukuCntTotal).'</b>';
		}

		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"shazhi" => "品名",
			"cntInit"=>"上月余存数量",
			"moneyInit"=>"金额",	
			"cntRuku" =>"入库数量",
			"moneyRuku"=>"金额",
			"cntChuku" =>"发出数",
			"moneyChuku"=>"金额",
			//"cntTuiku" =>"退库",
			"cntRemain" => "库存数"	,	
			"moneyRemain"=>"金额",
			"_edit"=>"操作"
		);		
		$smarty->assign('title','月末报表');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$newArr);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		//$smarty->assign('other_search_item',$cHtml);
		//$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arrGet)));
		$smarty->display('TableList.tpl');
	}

	function actionAddPandian(){
		$m = & FLEA::getSingleton('Model_CangKu_DyePandian');
		$arr = $m->find(array('wareId'=>$_GET['wareId'],'datePandian'=>$_GET['datePandian']));
		//dump($arr);
		$smarty = & $this->_getView();	
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$ware = $mWare->find(array('id'=>$_GET['wareId']));
		if($arr) $smarty->assign('aRow',$arr);
		else $smarty->assign('aRow',array('Ware'=>$ware));
		$smarty->display('Cangku/pandianEdit.tpl');
	}

	function actionSavePandian(){
		$m = & FLEA::getSingleton('Model_CangKu_DyePandian');
		if($m->save($_POST)) js_alert('数据保存成功!请刷新主页面，以显示最新数据.','window.close()');
	}
}
?>