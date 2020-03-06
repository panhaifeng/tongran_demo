<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Yl_ChukuTuiku extends Tmis_Controller {
	var $_modelExample;
	var $_modelChuku;
	var $_mWare;

	function Controller_CangKu_Yl_ChukuTuiku() {
		$this->_modelChuku = & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$this->_mWare = & FLEA::getSingleton('Model_CangKu_Yl_Chuku2Ware');
                $this->_modelWare=& FLEA::getSingleton('Model_JiChu_Ware');
	}
        //退库查询
        function actionRight(){
		$this->authCheck($this->readFuncId);
		$mDep = & FLEA::getSingleton('Model_JiChu_Department');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$mView = & FLEA::getSingleton('Model_Plan_Dye_ViewGang');
		FLEA::loadClass('TMIS_Pager');
		//$arr = array('supplierId' =>0);
		$arr['dateFrom'] =date("Y-m-d");
		$arr['dateTo'] = date("Y-m-d");
		$arrGet = TMIS_Pager::getParamArray($arr);
		$condition=array(
			array('chukuDate',$arrGet['dateFrom'],'>='),
			array('chukuDate',$arrGet['dateTo'],'<='),
			array('isTuiku','1','=')
		);

		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		$rowset =$pager->findAll();
		//$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
		//dump($rowset);
		if($rowset) foreach($rowset as & $v) {
                    foreach($v['Wares'] as & $vv){
                         $ware=$this->_modelWare->find($vv['wareId']);
                         $v['guige'].=$ware['wareName'].$ware['guige'].'<br/>';
                         $v['cnt'].=abs($vv['cnt']).'<br/>';

                    }
			 //$v['_edit'] ="<a href='".$this->_url('View',array('id'=>$v['id']))."'>查看详细</a>"." |".$this->getEditHtml($v['id'])." | ".$this->getRemoveHtml($v['id']);
		}
		//$rowset[] = $this->getHeji($rowset,array('cnt','money'),'chukuDate');

		//模板变量设置
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			'chukuDate' =>'日期',
			'chukuNum' =>'出库单号',
			//'Gang.vatNum'=>'缸号',
			'Department.depName' =>'退库部门',
                        'guige' => '品名',
                        'cnt' => '数量',
                        //'danjia' => '单价',
                        //'money' => '金额',
                        'memo'=>'备注',
			//'_edit'=>'操作'
		);
		//dump($rowset);exit;
		$smarty->assign('title','领料退库查询');
		//$smarty->assign('add_display','none');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
                $smarty->assign('add_display','none');
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}
	//退库登记
	function actionRight1(){
		$this->authCheck($this->readFuncId);
		$mDep = & FLEA::getSingleton('Model_JiChu_Department');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$mView = & FLEA::getSingleton('Model_Plan_Dye_ViewGang');
		FLEA::loadClass('TMIS_Pager');
		//$arr = array('supplierId' =>0);
		$arr['dateFrom'] =date("Y-m-d");
		$arr['dateTo'] = date("Y-m-d");
		$arrGet = TMIS_Pager::getParamArray($arr);
		$condition=array(
			array('chukuDate',$arrGet['dateFrom'],'>='),
			array('chukuDate',$arrGet['dateTo'],'<='),
			array('isTuiku','1','=')
		);

		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		$rowset =$pager->findAll();
		//$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
		//dump($rowset);
		if($rowset) foreach($rowset as & $v) {

			$v['_edit'] ="<a href='".$this->_url('View',array('id'=>$v['id']))."'>查看详细</a>"." |".$this->getEditHtml($v['id'])." | ".$this->getRemoveHtml($v['id']);
		}
		//$rowset[] = $this->getHeji($rowset,array('cnt','money'),'chukuDate');

		//模板变量设置
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			'chukuDate' =>'日期',
			'chukuNum' =>'出库单号',
			//'Gang.vatNum'=>'缸号',
			'Department.depName' =>'领料部门',
			'memo'=>'备注',
			'_edit'=>'操作'
		);
		//dump($rowset);exit;
		$smarty->assign('title','领料退库登记');
		//$smarty->assign('add_display','none');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}
        //查看详细
	function actionList(){
		$this->authCheck($this->readFuncId);
		$mDep = & FLEA::getSingleton('Model_JiChu_Department');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$mView = & FLEA::getSingleton('Model_Plan_Dye_ViewGang');
		FLEA::loadClass('TMIS_Pager');
		//$arr = array('supplierId' =>0);
		$arr['dateFrom'] =date("Y-m-d");
		$arr['dateTo'] = date("Y-m-d");
		$arrGet = TMIS_Pager::getParamArray($arr);

		$sql = "select
			y.wareId,y.cnt,y.danjia,
			x.*
			from cangku_yl_chuku x
			left join cangku_yl_chuku2ware y on x.id=y.chukuId
			where x.chukuDate>='{$arrGet['dateFrom']}' and x.chukuDate<='{$arrGet['dateTo']}'";
		if($_GET['wareId']>0) $sql.=" and y.wareId='{$_GET['wareId']}'";
        if($_GET['id']>0) $sql.=" and x.id='{$_GET['id']}'";
		//if ($arrGet['supplierId']>0) $sql .= " and x.supplierId='{$arrGet['supplierId']}'";

		$pager =& new TMIS_Pager($sql,$condition);
		$rowset =$pager->findAll();
		//$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
		//dump($rowset);
		if($rowset) foreach($rowset as & $v) {
			$v['Department'] =$mDep->find(array('id'=>$v['depId']));
			$v['Gang'] = $mView->find(array('gangId'=>$v['gangId']));
			$v['Ware'] =$mWare->find(array('id'=>$v['wareId']));
			$v['guige'] = $v['Ware']['wareName'] . ' ' . $v['Ware']['guige'];
			$v['money'] = round($v['danjia']*$v['cnt'],2);
			//$v['_edit'] = $this->getEditHtml($v['id']). ' | ' . $this->getRemoveHtml($v['id']);
		}
		$rowset[] = $this->getHeji($rowset,array('cnt','money'),'guige');
        //dump($rowset);
		//模板变量设置
		$smarty = & $this->_getView();
		/*$arrFieldInfo = array(
			'chukuDate' =>'日期',
			'chukuNum' =>'流水号',
			'Gang.vatNum'=>'缸号',
			//'Department.depName' =>'领料部门',
			//'Supplier.compName' =>'领料部门',
			//'Ware.wareName'=>'货品名称',
			'guige'=>'品名规格',
			//'Wares.unit'=>'单位',
			'cnt' =>'数量KG',
			'danjia' =>'单价',
			'money'=>'金额',
			//'_edit'=>'操作'
		);
		//$arr_edit_info = array("ViewMore" =>"查看详细", "Edit" =>"修改","remove" =>"删除");*/
		$smarty->assign('title','出库查询');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		//$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('CangKu/Yl/PrintTuikuChuku.tpl');
	}
	//退库面界
    function _edit($arr=array()) {
		if($arr['chukuNum']=='') {
			$arr['chukuNum'] = $this->_modelExample->getNewChukuNum();
		}
		 $mWare = & FLEA::getSingleton('Model_JiChu_Ware');

		if (count($arr['Wares'])>0) foreach($arr['Wares'] as & $v)
		{
             $v['Ware'] =$mWare->find(array('id'=>$v['wareId']));
			 $v['cnt']=abs($v['cnt']);
		}
		//dump($arr);exit;
		//$this->authCheck($this->editFuncId);
		$smarty = & $this->_getView();
		$smarty->assign("arr_field_value",$arr);
		$smarty->display('CangKu/Yl/ChukuTuiku.tpl');
	}

	function actionSave(){
	    $row=$_POST;
		$count=count($this->_modelExample->findAll(array('chukuNum'=>$_POST['chukuNum'])));
		if($_POST['id']==''){if($count>0) js_alert('单号已存在!','history.go(-1)');}
		if(count($row['wareId'])>0){
			foreach($_POST['wareId'] as  $key=>$v)
			{
				if($v=='' || $_POST['cnt'][$key]=='') continue;
				$row['Wares'][$key]['cnt']=0-$_POST['cnt'][$key];
				//$arr['Wares'][$key]['danjia']=$_POST['danjia'][$key];
				$row['Wares'][$key]['wareId']=$v;
				if($_POST['chuku2WareId'][$key]!='')  $arr['row'][$key]['id']=$_POST['chuku2WareId'][$key];
				$row['isTuiku']='1';
			}
		}
        if(isset($_GET['id'])){
			$row=$this->_modelExample->find($_GET['id']);
			unset($row['id']);
			foreach($row['Wares'] as & $v)
			{
			  unset($v['id']);
			  $v['cnt']=0-$v['cnt'];
			}
			$row['isTuiku']='1';
		}
		//dump($row);exit;
       	$tuikuId = $this->_modelExample->save($row);
		if($tuikuId) redirect($this->_url('right1'));
		else die('保存失败!');
	}

	function actionView(){
     $arr=$this->_modelExample->find($_GET['id']);
	 //dump($arr);
	 $modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
	 foreach($arr['Wares'] as & $v){
	     $ware=$modelWare->find($v['wareId']);
	     $v['WareName']=$ware['wareName'];
		 $v['Guige']=$ware['guige'];
		 $v['Unit']=$ware['unit'];
		 $v['cnt']=abs($v['cnt']);
	 }
	 //dump($arr);
	 $smarty= & $this->_getView();
	 $smarty->assign('arr_field_value',$arr);
	 $smarty->display('CangKu/Yl/TuikuChukuView.tpl');
	}


}
?>