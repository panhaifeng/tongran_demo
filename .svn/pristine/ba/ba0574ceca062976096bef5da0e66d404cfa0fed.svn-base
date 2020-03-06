<?php
/**
 * 注释参考Supplier.php
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Yf_Pisha extends Tmis_Controller {
	var $_modelExample;
	var $title = "坯纱应付款";
	// var $funcId = ;
	function Controller_CaiWu_Yf_Pisha() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Yf_Pisha');
		$this->_modelRuku =  & FLEA::getSingleton('Model_CangKu_RuKu');
		$this->_modelRuku2ware =  & FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$this->_mWare = & FLEA::getSingleton('Model_JiChu_Ware');
	}
	/**
	 * ps ：坯纱应付款登记列表
	 * Time：2017/09/05 09:20:08
	 * @author zcc
	*/
	function actionListforAdd(){
		$this->authCheck('154');
		FLEA::loadClass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
		    'dateFrom'=>date('Y-m-01'),
		    'dateTo'=>date('Y-m-d'),
		    'supplierIdPs'=>''
		));
		//获取为本厂
		$sql = "SELECT x.id as rukuId,x.rukuNum,x.rukuDate,y.cnt,y.danjia,s.compName,w.wareName,w.guige,y.id as ruku2wareId
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on y.rukuId = x.id 
			left join jichu_supplier s on x.supplierId2 = s.id
			left join jichu_ware w on w.id = y.wareId
			where 1 and x.kind = 1 and y.invoiceId = 0";
		if($arr['dateFrom']!=''&&$arr['dateTo']!=''){
			$sql .= " and x.rukuDate >='{$arr['dateFrom']}' and x.rukuDate<='{$arr['dateTo']}'";
		}
		if ($arr['supplierIdPs']!='') {
			$sql .= " and x.supplierId2 = '{$arr['supplierIdPs']}'";
		}
		$sql .= " order by x.rukuNum";
		$pager=& new TMIS_Pager($sql);
		$rowset=$pager->findAll();
		foreach($rowset as & $v){
			$v['money']=$v['danjia']*$v['cnt'];
		    $v['shazhi'] = $v['wareName'].''.$v['guige'];
		    $v['edit']="<a href='".$this->_url('Add',array('id'=>$v['rukuId']))."'>入账</a>";
		}
		$arr_field_info=array(
				'rukuNum'=>'入库单号',
				'rukuDate'=>'入库日期',
				'compName'=>'供应商',
				'shazhi' =>'纱支',
				'danjia' =>'单价',
				'cnt' =>'数量',
				'money'=>'总金额',
				'edit'=>'操作'
				);
		$smarty = & $this->_getView();
		$smarty->assign('title', '本厂采购入账');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty-> display('TableList.tpl');
	}
	/**
	 * ps ：入账登记
	 * Time：2017/09/05 10:11:22
	 * @author zcc
	*/
	function actionAdd(){
		$rowset=$this->_modelRuku->find($_GET['id']);
		$sql = "SELECT * FROM jichu_supplier where id = '{$rowset['supplierId2']}'";
		$supplier = $this->_modelRuku->findBySql($sql);
		$rowset['compName'] = $supplier[0]['compName'];
		$rowset['supplierId'] = $supplier[0]['id'];
		foreach($rowset['Wares'] as & $v){
			$v['danjia'] = $v['danJia'];
			$ware=$this->_mWare->find($v['wareId']);
			$v['guige']=$ware['wareName'].' '.$ware['guige'];
		}
		// dump($rowset);exit();
		$smarty = & $this->_getView();
		$smarty->assign('title', '采购入账');
		$smarty->assign('arr_field_value',$rowset);
		$smarty-> display('CaiWu/Yf/Ruzhang.tpl');
	}
	function actionSaveRuzhang(){
	    // dump($_POST);exit;
	    //求总金额
	    $money=0;
	    foreach($_POST['danjia'] as $key=>& $v){
			$money+=($v*$_POST['cnt'][$key]);
	    }
	    //将其入账
	    $arr = array(
	    	
			'dateRecord'=>$_POST['inDate'],
			'supplierId'=>$_POST[supplierId],
			'money'=>$money
	    );
	    if ($_POST['invoiceId']>0) {
	    	$arr[id] = $_POST['invoiceId'];
	    }
	    //修改入库明细表
	    foreach($_POST['id'] as $key=>& $v){
		$danjia=$_POST['danjia'][$key];
		$cnt=$_POST['cnt'][$key];
		$arr['Ruku2ware'][] = array(
		    'id'=>$v,
		    'danjiaGz'=>$danjia,//设置入库的子表的过账单价
		    'cnt'=>$cnt
		    );
	    }
	    // dump($arr);exit;
	    $this->_modelExample->save($arr);
	    js_alert('保存成功！','',$this->_url('Right'));
	}

	function actionRight()	{
		FLEA::loadClass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
		    'dateFrom'=>date('Y-m-01'),
		    'dateTo'=>date('Y-m-d'),
		    'supplierIdPs'=>''
		));
		$str="SELECT y.id,x.danjiaGz,x.cnt,y.dateRecord,z.compName,w.wareName,w.guige,x.ruKuId
		from caiwu_yf_pisha y 
		left join cangku_ruku2ware x on x.invoiceId=y.id
		left join jichu_supplier z on y.supplierId=z.id
		left join jichu_ware w on w.id = x.wareId
		where 1";
		if($arr['dateFrom']!=''&&$arr['dateTo']!=''){
		    $condition[]=array('dateRecord',$arr['dateFrom'],'>=');
		    $condition[]=array('dateRecord',$arr['dateTo'],'<=');
		    $str.=" and y.dateRecord>='{$arr['dateFrom']}'";
		    $str.=" and y.dateRecord<='{$arr['dateTo']}'";
		}
		if ($arr['supplierIdPs']){
			$condition[] = array('supplierId', $arr['supplierIdPs']);
			 $str.=" and y.supplierId = '{$arr['supplierIdPs']}'";
		}
		$str.=" and y.kind = 0";
		$pager=& new TMIS_Pager($str);
		$rowset=$pager->findAll();
		// dump($rowset);exit;
		if(count($rowset)>0)foreach($rowset as & $v){
			$v['shazhi'] = $v['wareName'].' '.$v['guige'];
			// $v['_edit'] = "<a href='".$this->_url('Edit',array('id'=>$v['id'],'ruKuId'=>$v['ruKuId'],'fromAction'=>$_GET['action']))."'>修改</a>";
		    $v['_edit'] .= " <a href='".$this->_url('Remove',array('id'=>$v['id']))."'>删除</a>";
		    $v['money']=$v['danjiaGz']* $v['cnt'];
		}

		$arr_field_info=array(
		    'dateRecord'=>'入账日期',
		    'compName'=>'供应商',
		    'shazhi' =>'纱支',
		    'cnt'=>'数量',
		    'danjiaGz'=>'单价',
		    'money'=>'金额',
		    'memo'=>'备注',
		    '_edit'=>'操作'
		);
		// dump($rowset);
		$smarty = & $this->_getView();
		$smarty->assign('title', '入账查询');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty-> display('TableList.tpl');
	}
	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);

		$rowset=$this->_modelRuku->find($_GET['ruKuId']);
		$sql = "SELECT * FROM jichu_supplier where id = '{$rowset['supplierId2']}'";
		$supplier = $this->_modelRuku->findBySql($sql);
		$rowset['compName'] = $supplier[0]['compName'];
		$rowset['supplierId'] = $supplier[0]['id'];
		$rowset['inDate'] = $aRow['dateRecord'];
		foreach($rowset['Wares'] as & $v){
			$v['danjia'] = $v['danjiaGz'];
			$ware=$this->_mWare->find($v['wareId']);
			$v['guige']=$ware['wareName'].' '.$ware['guige'];
			$rowset['invoiceId'] = $v['invoiceId'];
		}


		$smarty = & $this->_getView();
		$smarty->assign('title', '采购入账');
		$smarty->assign('arr_field_value',$rowset);
		$smarty-> display('CaiWu/Yf/Ruzhang.tpl');
	}	

	function actionRemove() {
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[$pk]);
		redirect(url("CaiWu_Yf_Init","Right"));
	}
}
?>