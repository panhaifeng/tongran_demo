<?php
/**
 * 松筒车间(筒染用)控制器
 */
FLEA::loadClass('TMIS_Controller');
class Controller_SongTong_Dye extends Tmis_Controller {
	var $_modelExample;
	var $funcId=49;
	function Controller_SongTong_Dye() {
		//$this->_modelExample = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$this->_modelGang->enableLink('Car');
		$this->_modelPlan = & FLEA::getSingleton('Model_SongTong_Gang2StCar');
		$this->_modelPlan->enableLink('Chanliang');
		//$this->_pkName = $this->_modelExample->primaryKey;
	}

	//列出已安排的计划。
	function actionRight(){
		//车号,缸号 客户 纱织规格 颜色 计划投料 定重 计划支数
		$sql = "select
				x.id,z.carCode,y.vatNum,o.compName,r.wareName,r.guige,
				m.color,y.cntPlanTouliao,y.unitKg
				from dye_gang2stcar x
				inner join plan_dye_gang y on x.gangId=y.id
				inner join jichu_stcar z on x.stcarId = z.id
				inner join trade_dye_order2ware m on y.order2wareId=m.id
				inner join jichu_ware r on m.wareId=r.id
				inner join trade_dye_order n on m.orderId=n.id
				inner join jichu_client o on n.clientId=o.id
				where 1
		";
		if ($_POST[key]!='') $sql .= " and y.vatNum='$_POST[key]'";
		$sql .= " order by x.id desc";
		FLEA::loadClass('TMIS_Pager');
		$pager = & new TMIS_Pager($sql);
		$arr = $pager->findAll();

		if(count($arr)>0) foreach($arr as & $v) {
			$v[guige]=$v[wareName]." ".$v[guige];
			$v[cntTongzhi] = number_format($v[cntPlanTouliao]/$v[unitKg],0);
			//取得产量
			$cl = $this->_modelPlan->getChanliang($v[id]);
			$v[chanliang] = $cl[cntKg]."(".$cl[cntTongzhi].")";
			$v[_edit] = "<a href='".$this->_url('Setchanliang',array(
				planId => $v[id]
			))."'>录入产量</a>";//为了简化开发，暂时取消标志功能
		}
		//dump($arr);
		$arrField = array(
			carCode =>"松筒车号",
			vatNum =>"缸号",
			compName=>"客户",
			guige=>"纱织规格",
			color=>"颜色",
			cntPlanTouliao=>"计划投料",
			unitKg=>"定重",
			cntTongzhi=>"计划筒子数",
			chanliang => "产量",
			_edit=>"操作"
		);

		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',$arrField);
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display('TableList.tpl');
	}

	//登记松筒产量
	function actionSetChanliang() {

		if($_GET[planId]!="") {
			//新增产量
			$arr = $this->_modelPlan->find($_GET[planId]);
			$arr[Client] = $this->_modelGang->getClient($arr[Gang][id]);
			$arr[Ware] = $this->_modelGang->getWare($arr[Gang][id]);
		} elseif($_GET[id]!="") {
			//修改产量
		}
 		//dump($arr);

		$smarty = $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Songtong/ChanliangEdit.tpl');
	}

	//保存产量
	function actionSaveChanliang() {
		//dump($_POST);exit;
		$m = & FLEA::getSingleton('Model_SongTong_Chanliang');
		$m->save($_POST);
		js_alert('保存成功!','',$this->_url('right'));
	}
}
?>