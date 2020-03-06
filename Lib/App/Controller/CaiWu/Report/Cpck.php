<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Report_Cpck extends Tmis_Controller {
	var $_modelExample;
	var $funcId;
	function Controller_CaiWu_Report_Cpck() {
		$this->_modelExample = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
	}

	#列表
	function actionRight(){
		$title = "成品发货报表";
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom=>date("Y-m-1"),
                        dateTo=>date("Y-m-d"),
                        clientId=>'',
                        guige=>''
		));
		//if ($arr[isReport]==1) $arr['clientId'] = $_POST[clientId]?$_POST[clientId]:$_GET[clientId];
		$str = "select
			x.*,
			y.compName,y.orderCode,y.vatNum,y.wareName,y.guige,y.color,y.vatCode,y.cntPlanTouliao,y.orderId
			from chengpin_dye_cpck x
			inner join view_dye_gang y on x.planId=y.gangId
			where ";

		$condition=array();
		if ($arr[dateFrom]!=''||$arr[dateTo]!='') {
			//echo($arr[dateTo]);
			$condition[] = "date(x.dateCpck)>='$arr[dateFrom]'";
			$condition[] = "date(x.dateCpck)<='$arr[dateTo]'";
		}
                if($arr['clientId']){
                  $condition[] = "y.clientId='$arr[clientId]'";
                }
                 if($arr[guige]){
                     $condition[] = "y.guige like '%{$arr[guige]}%'";
                }
		$str .= join(" and ",$condition);
		$str .= " order by dt DESC";
		//echo $str;exit;
		$pager =& new TMIS_Pager($str,null,null,400);
		$rowset = $pager->findAllBySql($str);
		//dump($rowset[0]);
		foreach($rowset as & $value) {
			$tTouliao += $value[cntPlanTouliao];
			$jingKg += $value[jingKg];
			$cntChuku += $value[cntChuku];
			$cntJian += $value[cntJian];
			$cntTongzi += $value[cntTongzi];
			$value[guige] =$value[guige]." ".$value[wareName];
			$value[orderCode]=$this->_modelOrder->getOrderTrack($value[orderId],$value[orderCode]);
			//dump($value[guige]);exit;
		}
		//dump($rowset[0]);
		$i = count($rowset);
		$rowset[$i][dateCpck]="<b>合计</b>";
		$rowset[$i][cntPlanTouliao] = "<b>$tTouliao</b>";
		$rowset[$i][jingKg] ="<b>$jingKg</b>";
		$rowset[$i][cntChuku] ="<b>$cntChuku</b>";
		$rowset[$i][cntJian] ="<b>$cntJian</b>";
		$rowset[$i][cntTongzi] ="<b>$cntTongzi</b>";
		//dump($rowset[0]);
		//dump($rowset[$i]);
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"dateCpck" =>"出库日期",
			'compName' => '客户',
			"orderCode" =>"定单号",
			//"vatNum" =>"缸号",
			"guige" => "规格",
			"color" =>"颜色",
			"vatCode" =>"物理缸号",
			"cntPlanTouliao" =>"投料数",
			//'cntChuku'=>'本次发货',
			"jingKg"=>"净重",
			"cntJian"=>"件数",
			"cntTongzi"=>"筒子数"
		);
		if ($arr[isReport]!=1) $arrEditInfo = array("edit" =>"修改", "remove" =>"删除");
		$smarty->assign('arr_main_value',array(
			//'日期'=>$arr['dateFrom'],
			'当前用户'=>$_SESSION['REALNAME']
		));
		$smarty->assign('title',$title);
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		//$smarty->assign('other_button',);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		//if ($arr[isReport]!=1) $smarty->display('Chengpin/Dye/CpckManage.tpl');
		//$smarty->assign('other_button','<input type="button" name="button" id="button" value="重新选择日期" onclick="window.location.href='."'".$this->_url('setDay')."'".'"/>' . ($cntChuku>0 ? (' 制成率：'.round($jingKg/$cntChuku,2)) : ''));
		$smarty->display('CaiWu/Report/Cpck.tpl');
		}
}
?>