<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_OA_Message extends Tmis_Controller {
	var $_modelExample;
	var $title = "信息管理";
	var $funcId = 6;
	function Controller_OA_Message() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_OA_Message');
	}

/*
	function actionIndex() {
		$smarty = & $this->_getView();
		//$smarty->assign('arr_left_list', $arrLeftList);
		$smarty->assign('title', $this->title);
		$smarty->assign('caption', '首页信息管理');
		//$smarty->assign('child_caption', "应付款初始化");
		$smarty->assign('controller', 'OA_Message');
		$smarty->assign('action', 'right');
		$smarty->display('MainContent.tpl');
	}*/



	function actionRight()
	{
		$this->authCheck($this->funcId);
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "title like '%$_POST[key]%'" : NULL);
		//echo $condition;
		FLEA::loadClass('TMIS_Pager');
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		//dump($pager);

        $rowset =$pager->findAll();

		//die("error");

		foreach ($rowset as & $value) {
			$value[userName] = $value[User][userName];
		}

		//dump($rowset);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"classId" =>"类别ID",
			"title" =>"标题",
			"buildDate" =>"日期",
			"userName" =>"操作人员"
		);

		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);


		$smarty->assign('arr_edit_info',$arr_edit_info);

		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('search_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=OA_Message&action=Right'));
		$smarty->assign('controller', 'OA_message');
		$smarty-> display('TableList.tpl');
	}


	function _edit($Arr) {
		//dump($Arr);
		//die();
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		//die($primary_key);
		$smarty->assign("pk",$primary_key);
		$smarty->assign('default_date',date("Y-m-d"));
		$smarty->display('OA/Edit.tpl');
	}

	function actionAdd() {
		$this->_edit(array());
	}

	function actionSave() {
		$_POST['classId'] = 6;
       	$this->_modelExample->save($_POST);
		redirect(url("OA_message","Right"));
	}

	function actionEdit() {
		$this->authCheck($this->funcId);
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);
		$this->_edit($aRow);
	}

	function actionRemove() {
        $this->authCheck($this->funcId);
		//if ($this->_modelExample->removeByPkv($_GET[id])) redirect($this->_url("right"));
		if ($this->_modelExample->removeByPkv($_GET[id])) redirect($_SERVER['HTTP_REFERER']);
		else js_alert('出错，不允许删除!',"window.history.go(-1)");
	}


	#得到一个星期内的加急缸数
	function actionListJiaji(){
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m'),date('d')-7,date('Y'))),
			'dateTo'=>date('Y-m-d')
			//worderCode=>'',
			//vatNum=>''
		));
		$condition=array(
			'classId'=>7,
			array('buildDate',$arr['dateFrom'],'>='),
			array('buildDate',$arr['dateTo'],'<='),
		);
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'',100);
        $rowset =$pager->findAll();
		foreach ($rowset as & $v) {
			$v['Gang'] =$mGang->formatRet($mGang->find(array('id'=>$v['gangId'])));
			$v['orderCode'] = $v['Gang']['OrdWare']['Order']['orderCode'];
			$v['compName'] = $v['Gang']['Client']['compName'];
			$v['guige'] = $mWare->getGuigeDesc($v['Gang']['OrdWare']['wareId']);
			$v['_edit'] = $this->getEditHtml($v['id'])  . ' ' . $this->getRemoveHtml($v['id']);
		}

		//dump($rowset[0]);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', '加急缸号列表');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arrFieldInfo = array(
			'compName' =>'客户',
			//'orderCode' =>'合同编号',
			'Gang.vatNum' =>'缸号',
			'guige'=>'规格',
			'Gang.OrdWare.color' =>'颜色',
			'Gang.OrdWare.colorNum' =>'色号',
			//'Gang.planDate' =>'排缸日期',
			'Gang.cntPlanTouliao' =>'投料',
			'Gang.planTongzi' =>'筒数',
			//'Gang.vatCode' =>'物理缸号',
			'dt'=>'时间',
			//'User.realName'=>'加急人',
			'_edit'=>'操作'
		);

		$smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('search_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar('Index.php?controller=OA_Message&action=listjiaji'). ' <center><input type="button" value="打印" onclick="window.location.href='."'".$this->_url($_GET['action'],array('for'=>'print'))."'".'"/></center>');
		$smarty->assign('controller', 'OA_message');
		if($_GET['for']=='print') {
			$smarty->assign('arr_main_value',array(
				'date'=>date('Y-m-d'),
				'当前用户'=>$_SESSION['REALNAME']
			));
			$smarty-> display('print2.tpl');
		} else $smarty-> display('TableList.tpl');
	}
        

}
?>