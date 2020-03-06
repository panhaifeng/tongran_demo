<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_TuikuChuku extends Tmis_Controller {
	var $_modelChuku;
	//var $thisController = "CangKu_ChuKu";	//当前控制器名
	//var $queenController = "CangKu_ChuKu2ware";		//增加产品控制器
	//var $title = "领料出库";
	var $funcId;

	function Controller_CangKu_TuikuChuku() {
		$this->_modelChuku = & FLEA::getSingleton('Model_CangKu_ChuKu');
		$this->_modelChuku2Ware = & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
		$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
	}

	#坯纱领料明细
	function actionRight1() {
		//$this->funcId = 100;		//坯纱领料登记-查询
		$dateFrom = '2009-05-01';   //计划日期在2月16号之后的缸
		//if ($_GET['rukuTag']==1) $this->authCheck(52);
	   // $this->authCheck(51);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			clientId=>0,
			orderCode=>'',
			vatNum=>'',
			dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo=>date("Y-m-d"),
			wareId=>0
		));

		$condition=array();
		if ($arr[clientId]>0) $condition[]="x.supplierId='$arr[clientId]'";
		if ($arr[wareId]>0) $condition[] = "x.wareId='$arr[wareId]'";
		if ($arr[orderCode]!='') $condition[] = "y.orderCode like '%$arr[orderCode]%'";
		if ($arr[vatNum]!='') $condition[] = "y.vatNum like '%$arr[vatNum]%'";
		if ($arr[dateFrom]) {
			$condition[] = "x.chukuDate>='$arr[dateFrom]'";
			$condition[] = "x.chukuDate<='$arr[dateTo]'";
		}
		//dump($arr);dump($condition);
		$str = "select x.chukuId as id, x.id as chuku2wareId, x.chukuDate,x.cnt,y.* from  view_cangku_chuku x
			left join view_dye_gang y on x.gangId=y.gangId where 1";
		//加入下面的语句后，库存报表出现问题，y.planDate>'$dateFrom'
		if (count($condition)>0) $str .= " and ".join(' and ',$condition);
		$str .= " order by x.id desc";
		//echo $str;
		$pager= & new TMIS_Pager($str);
		$rowset= $pager->findAllBySql($str);
		//dump($rowset[0]);
		//$heji = $this->getHeji($rowset,array('cntPlanTouliao','cnt'),'chukuDate');
		if (count($rowset)>0) foreach($rowset as & $value) {
			$value[guige] = $value[wareName].' '.$value[guige];
			//$value[edit] = "<a href='".$this->_url('editNum', array('chuku2wareId'=>$value[chuku2wareId]))."'>修改</a>";
		}
		//$rowset[] = $heji;

		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);

		#对表头进行赋值
		$arrFieldInfo = array(
			//"chukuNum" =>"单号",
			"chukuDate" =>"领料日期",
			//"depName" =>"领料部门",
			"compName" =>"客户",
			"orderCode"=>"订单号",
			"vatNum"=>"缸号",
			"guige" =>"规格",
			"color"=>"颜色",
			"cntPlanTouliao"=>"计划投料",
			"cnt" =>"领出数量",
			'edit'=>"操作"
		);


		$smarty->assign('title','坯纱领料出库明细');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);

		#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);

		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('pk',$pk);

		#分页信息
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));

		#开始显示
		$smarty->display('TableList.tpl');
	}


}
?>