<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Yl_RukuTuiku extends Tmis_Controller {
	var $_modelExample;
	var $_modelRuku;

	function Controller_CangKu_Yl_RukuTuiku() {
		$this->_modelRuku = & FLEA::getSingleton('Model_CangKu_Yl_Ruku');
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_Yl_Ruku');
                $this->_modelWare= & FLEA::getSingleton('Model_JiChu_Ware');
	}

	//退库登记，有删除，修改，整单删除
	function actionRight(){
		$this->authCheck(56);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-01",strtotime('-1 month')),
			'dateTo' => date("Y-m-d"),
			'supplierId'=>'',
		));

		$sql = "select x.id as ruku2wareId,
					x.rukuId,
					x.wareId,
					x.chandi,
					x.danjia,
					x.cnt,
					(x.danjia * x.cnt) as money,
					y.rukuNum,
					y.rukuDate,
					y.supplierId,
					y.songhuoCode,
					y.isTuiku,
					js.compName as supplierName,
					jw.wareName,
					jw.guige from cangku_yl_ruku2ware x 
				left join cangku_yl_ruku y on x.rukuId = y.id 
				left join jichu_supplier js on y.supplierId = js.id 
				left join jichu_ware jw on x.wareId = jw.id";

		//为退库数据
		$sql .= " where isTuiku = 1";

		//时间段
		$sql .= " and rukuDate >= '".$arrGet['dateFrom']."'";
		$sql .= " and rukuDate <= '".$arrGet['dateTo']."'";

		//供应商搜索
		if ($arrGet['supplierId'] != '') $sql .= " and supplierId = ".$arrGet['supplierId'];

		//纱支搜索
		if($_GET['wareId']>0) $sql .= " and wareId = ".$_GET['wareId'];

		//排序
		$sql .= " order by rukuDate DESC";

		//echo($sql); exit;

		$pager = & new TMIS_Pager($sql);
		$rowset =$pager->findAll();

		if (count($rowset)>0) foreach($rowset as & $v) {
			//使数量显示为绝对值 
			$v['cnt'] = abs($v['cnt']);
			$v['money'] = abs($v['money']);
			//操作
			$v['_edit'] = "<a href='".$this->_url('edit',array('id'=>$v['rukuId']))."'>修改</a>  |  <a href='".$this->_url('removeWare',array(
				'id' =>$v['ruku2wareId'],
				'rukuId' => $v['rukuId'],
			))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>  |  <a href='".$this->_url('remove',array(
				'id'=>$v['rukuId']
			))."' onclick='return confirm(\"您确认要整单删除吗？\");'>整单删除</a>";
		}

		$arrFieldInfo = array(
			'rukuNum'		=> '单号',
			'rukuDate'		=> '退库日期',
			'supplierName'	=> '供应商',
			'wareName'		=> '染化料',
			'guige'			=> '规格',
			'cnt'			=> '数量',
			'danjia'		=> '单价',
			'money'			=> '金额',
			'memo'			=> '备注',
			'_edit'			=> '操作',
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','退库登记');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('tip','calendar','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}
    
	//退库查询，没有修改，删除
    function actionRight2(){
         	FLEA::loadClass('TMIS_Pager');
			$arrGet = TMIS_Pager::getParamArray(array(
				'dateFrom' =>date("Y-m-01",strtotime('-1 month')),
				'dateTo' => date("Y-m-d"),
				'supplierId'=>'',
				'rukuNum'=>'',
			));

			//dump($arrGet); exit;
			$condition[] = array('rukuDate', $arrGet['dateFrom'], '>=');
			$condition[] = array('rukuDate', $arrGet['dateTo'], '<=');
			if ($arrGet['supplierId'] != '') $condition[] = array('supplierId', $arrGet['supplierId'], '=');
			$condition[] = array('rukuNum', '%'.$arrGet['rukuNum'].'%', 'like');
			$condition[] = array('isTuiku','1','=');


					//dump($condition);exit;
			$pager =& new TMIS_Pager($this->_modelRuku,$condition);
			//$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
			$rowset =$pager->findAll();
					//dump($rowset);exit;
			if (count($rowset)>0) foreach($rowset as $key=> & $v) {
				//$v['_edit']="<a href='".$this->_url('View',array('id'=>$v['id']))."'>查看详情</a>"." |".$this->getEditHtml($v['id'])." | ".$this->getRemoveHtml($v['id']);
				$v['supplierName'] = $v['Supplier']['compName'];
							foreach($v['Wares'] as & $vv){
								$ware=$this->_modelWare->find($vv['wareId']);
								$v['guige'].=$ware['wareName'].$ware['guige'].'<br/>';
								$v['chandi'].=$vv['chandi'].'<br/>';
								$v['cnt'].=abs($vv['cnt']).'<br/>';
								$v['danjia'].=$vv['danjia'].'<br/>';
								$v['money'].=abs($vv['cnt'])*$vv['danjia'].'<br/>';
							}
			}

			$arrFieldInfo = array(
				'rukuNum' => '单号',
				'rukuDate' => '入库日期',
				'supplierName' => '客户名称',
				'guige' => '品名',
							'cnt' => '数量',
							'danjia' => '单价',
							'money' => '金额',
							'memo'=>'备注',
			);

			$smarty = & $this->_getView();
			$smarty->assign('title','退库查询');
			//$smarty->assign('add_display','none');
			$smarty->assign('arr_field_info',$arrFieldInfo);
			$smarty->assign('arr_condition',$arrGet);
			$smarty->assign('arr_field_value',$rowset);
					$smarty->assign('add_display','none');
			$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
			$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
			$smarty->display('TableList2.tpl');
	}
    
	/*退库登记,只显示基础资料。
	function actionRight1(){
		$this->authCheck($this->readFuncId);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-01",strtotime('-1 month')),
			'dateTo' => date("Y-m-d"),
			'supplierId'=>'',
			'rukuNum'=>'',
		));

		//dump($arrGet); exit;
		$condition[] = array('rukuDate', $arrGet['dateFrom'], '>=');
		$condition[] = array('rukuDate', $arrGet['dateTo'], '<=');
		if ($arrGet['supplierId'] != '') $condition[] = array('supplierId', $arrGet['supplierId'], '=');
		$condition[] = array('rukuNum', '%'.$arrGet['rukuNum'].'%', 'like');
		$condition[] = array('isTuiku','1','=');


                //dump($condition);exit;
		$pager =& new TMIS_Pager($this->_modelRuku,$condition);
		//$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
		$rowset =$pager->findAll();
		if (count($rowset)>0) foreach($rowset as $key=> & $v) {
                        //"<a href='".$this->_url('View',array('id'=>$v['id']))."'>查看详情</a>"." |".
			$v['_edit']=$this->getEditHtml($v['id'])." | ".$this->getRemoveHtml($v['id']);
			$v['supplierName'] = $v['Supplier']['compName'];
		}

		$arrFieldInfo = array(
			'rukuNum' => '单号',
			'rukuDate' => '入库日期',
			'supplierName' => '客户名称',
			'memo'=>'备注',
			'_edit' => '操作'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','退库登记');
		//$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}*/

	//退库面界
    function _edit($arr=array()) {
		if($arr['rukuNum']=='') {
			$arr['rukuNum'] = $this->_modelExample->getNewRukuNum();
		}
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		if(count($arr['Wares'])>0) foreach($arr['Wares'] as & $v){
			$rowWare = $mWare->findByField('id',$v['wareId']);
			$v['wareName'] = $rowWare['wareName'];
			$v['guige'] = $rowWare['guige'];
			$v['danwei'] = $rowWare['danwei'];
			$v['cnt']=abs($v['cnt']);
		}

		//dump($arr);
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign("title","退库登记>>录入");
		$smarty->display('CangKu/Yl/TuikuEdit.tpl');
	}

	function actionSave(){
	    $count=count($this->_modelExample->findAll(array('rukuNum'=>$_POST['rukuNum'])));
		if($_POST['rukuId']==''){if($count>0) js_alert('单号已存在!','history.go(-1)');}
		if(count($_POST['cnt'])>0){
			for ($i=0;$i<count($_POST['cnt']);$i++){
				if(empty($_POST['wareId'][$i]) || empty($_POST['cnt'][$i])) continue;
				$arr[] = array(
					'id'		=> $_POST['id'][$i],
					//'rukuId'	=> $_POST['rukuId'],
					'wareId'	=> $_POST['wareId'][$i],
					'cnt'		=> 0-$_POST['cnt'][$i],
					'danjia'	=> $_POST['danjia'][$i],
					'memo'		=> $_POST['memo'][$i],
					'ifRemove'	=> $_POST['ifRemove'][$i]
				);
			}

			$row=array(
					'id'			=> $_POST['rukuId'],
					'rukuNum'		=> $_POST['rukuNum'],
					'rukuDate'		=> empty($_POST['rukuDate'])?date("Y-m-d"):$_POST['rukuDate'],
					'supplierId'	=> $_POST['supplierId'],
					'memo'			=> $_POST['memo'],
					'Wares'			=> $arr,
				    'isTuiku'       =>'1'
			);
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
       	$rukuId = $this->_modelExample->save($row);
		if($rukuId) redirect($this->_url('right'));
		else die('保存失败!');

		//dump($arr);exit;
		//$this->_modelExample->save($arr);
		//js_alert('','',$this->_url('Tuiku'));
	}
	function actionRemoveWare(){
		$mRuku = & FLEA::getSingleton('Model_CangKu_Yl_Ruku2Ware');
		$mRuku->removeByPkv($_GET['id']);
		redirect($this->_url('right'));
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
	 $smarty->display('CangKu/Yl/TuikuView.tpl');
	}


}
?>