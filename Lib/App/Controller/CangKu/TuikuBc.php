<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_TuikuBc extends Tmis_Controller {
	var $_modelChuku;
	var $funcId;
    var $rukuTag;
	function Controller_CangKu_TuikuBc() {
    	$this->_modelRuku = & FLEA::getSingleton('Model_CangKu_RukuDye');
		$this->_modelRukuPeisha= & FLEA::getSingleton('Model_CangKu_RuKu');
		$this->rukuTag=$_GET['rukuTag'];
	}    
	//坯纱退库登记浏览介面，显示详细信息，并可以修改，删除，整单删除
	function actionRight(){
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom'	=> date("Y-m-d",strtotime('-1 month')),
			'dateTo'	=> date("Y-m-d"),
			'supplierIdPs'	=> '',
			'wareName'  =>'',
		));

		$thisModel = $this->_modelRukuPeisha;
		$modelName = "Model_JiChu_Client";

		$str = "select
				x.id as ruKuId,
				x2.id as ruku2wareId,
				x.ruKuNum,
				x.ruKuDate,
				x2.cnt,
				x2.chandi,
				x2.danJia,
				x.memo,
				y.compName,
				z.wareName,
				z.guige,
				z.unit 
				from cangku_ruku x
				left join cangku_ruku2ware x2 on x2.rukuId = x.id
				inner join jichu_supplier y on x.supplierId2=y.id
				left join jichu_ware z on x2.wareId=z.id
				where 1 and x.isTuiku=1 and x.kind = 1";


		if ($arrGet['date'] !='') $str .= " and ruKuDate = '$arrGet[date]'";
		else $str .= " and ruKuDate >= '$arrGet[dateFrom]' and ruKuDate<='$arrGet[dateTo]'";
		if ($arrGet['supplierIdPs'] >0) $str .= " and x.supplierId2 = $arrGet[supplierIdPs]";
		if ($arrGet['clientId'] != '') $str .= " and supplierId = $arrGet[clientId]";

		if($arrGet['wareId']!='') $str .= " and x.wareId='$arrGet[wareId]'";
		if($arrGet['wareName']!='') $str .= " and z.wareName like '%$arrGet[wareName]%'";

		$str .= " order by ruKuId desc";
		// dump($str);exit();
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		if (count($rowset)>0) foreach($rowset as & $v) {
			$sql = "SELECT * from cangku_ruku2ware where ruKuId = '{$v['ruKuId']}'";
			$ruku2ware = $this->_modelRuku->findBySql($sql);
			$v['pihao'] = $ruku2ware[0]['pihao'];

			$v['cnt']=abs($v['cnt']);
			$v['_edit'] = "<a href='".$this->_url('edit',array('id'=>$v['ruKuId']))."'>修改</a>  |  <a href='".$this->_url('removeWare',array(
				'id' =>$v['ruku2wareId'],
				'ruKuId' => $v['ruKuId'],
			))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>  |  <a href='".$this->_url('remove',array(
				'id'=>$v['ruKuId']
			))."' onclick='return confirm(\"您确认要整单删除吗？\");'>整单删除</a>";
		}
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			'ruKuNum'	=>'单号',
			'ruKuDate'	=>'日期',
			'compName'	=>'供应商',
			'wareName'	=>'货品名称',
			'guige'		=>'规格',
			'pihao'		=>'批号',
			'chandi'	=>'产地',
			'cnt'		=>'数量',
			'memo'		=>'备注',
			'_edit'		=>'',
		);

		$smarty->assign('title','坯纱退库登记');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}


    function actionViewMore() {
		$pk=$this->_modelRukuPeisha->primaryKey;
		$arrFieldValue=$this->_modelRukuPeisha->find($_GET[$pk]);

		FLEA::loadClass('TMIS_Pager');
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$i = 0;
		$cntTotal = 0;
		if (count($arrFieldValue["Wares"]) > 0) {
			foreach ($arrFieldValue["Wares"] as & $value) {
				$rowWare = $modelWare->findByField('id', $value["wareId"]);
				$value["wareName"] = $rowWare["wareName"];
				$value["guige"] = $rowWare["guige"];
				$value["sx"] = $rowWare["mnemocode"];
				$value["unit"] = $rowWare["unit"];
				$value['cnt']=abs($value['cnt']);
				$cntTotal += $value[cnt];
				$i++;
			}
			$arrFieldValue[Wares][$i][wareName] = '<strong>合计</strong>';
			$arrFieldValue[Wares][$i][cnt] = '<strong>'.$cntTotal.'</strong>';
		}

		//dump($arrFieldValue);

		$smarty = & $this->_getView();

		$smarty->assign("arr_field_value",$arrFieldValue);
		//dump($arrFieldValue);
		$smarty->assign("arr_field_info",array(
			'wareName'=>'名称',
			'guige'=>'规格',
			'chandi'=>'产地',
			'cntJian'=>'件数',
			'cnt'=>'数量',
			'unit'=>'单位'
		));

		$smarty->assign("supplier_client", "客户");
		$smarty->display('CangKu/RukuViewMore.tpl');
	}

	function actionEdit() {
		$pk=$this->_modelRukuPeisha->primaryKey;
		$this->_editable($_GET[$pk]);
		$arrFieldValue=$this->_modelRukuPeisha->find($_GET[$pk]);
		$this->_edit($arrFieldValue);
	}
	#保存
	function actionSave() {
		//dump($_POST); EXIT;
		$count=count($this->_modelRukuPeisha->findAll(array('rukuNum'=>$_POST['rukuNum'])));
		if($_POST['rukuId']==''){if($count>0) js_alert('单号已存在!','history.go(-1)');}


		for ($i=0;$i<count($_POST['cnt']);$i++){
			if(empty($_POST['wareId'][$i]) || empty($_POST['cnt'][$i])) continue;
			$arr[] = array(
				'id'		=> $_POST['id2'][$i],
				//'rukuId'	=> $_POST['rukuId'],
				'wareId'	=> $_POST['wareId'][$i],
                'chandi'    =>$_POST['chandi'][$i],
                'pihao'    	=>$_POST['pihao'][$i],
				'cnt'		=> 0-$_POST['cnt'][$i],
				'cntJian'   => $_POST['cntJian'][$i],
				'danJia'	=> $_POST['danJia'][$i],
				'memo'		=> $_POST['memo'][$i],
				'ifRemove'	=> $_POST['ifRemove'][$i],
                                
			);
		}

		$row=array(
				'id'			=> $_POST['id'],
				'rukuNum'		=> $_POST['ruKuNum'],
                'ruKuDate'		=> empty($_POST['ruKuDate'])?date("Y-m-d"):$_POST['ruKuDate'],
                'supplierId2'	=> $_POST['supplierId'],
                'isTuiku'       => '1',
                'kind'       	=> '1',
				'memo'			=> $_POST['memo'],
				'Wares'			=> $arr
		);
        // dump($row);exit;
       	$rukuId = $this->_modelRukuPeisha->save($row);
		if($rukuId) redirect($this->_url('right'));
		else die('保存失败!');
	}

	function _edit() {
		// $this->funcId = 98;	//坯纱--入库--新增修改
            if($arr['ruKuNum']=='') {
			$arr['ruKuNum'] = $this->_modelRukuPeisha->getNewRukuNum();
		}
		//dump($arr); //exit;
		if(isset($_GET['id'])){
		   $arr=$this->_modelRukuPeisha->find($_GET['id']);
		}

		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		if(count($arr['Wares'])>0) foreach($arr['Wares'] as & $v){
			$rowWare = $mWare->findByField('id',$v['wareId']);
			$v['wareName'] = $rowWare['wareName'];
			$v['guige'] = $rowWare['guige'];
			$v['danwei'] = $rowWare['danwei'];
		}

		if (count($arr['Wares'])>0) foreach($arr['Wares'] as & $v){
			$v['cnt']=abs($v['cnt']);
		}

        //dump($arr);exit;
		$this->authCheck($this->funcId);

		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
        $smarty->assign('aRow',$arr);
		$smarty->assign('user_id', $_SESSION['USERID']);
		$smarty->assign('real_name', $_SESSION['REALNAME']);
		$smarty->assign("arr_field_value",$Arr);

		//dump($Arr);
		#对默认日期变量赋值
		$smarty->assign('default_date',date("Y-m-d"));

		#增加产品控制器
		$smarty->assign('queen_controller', $this->queenController);

		#通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
		#在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
		$pk=$this->_modelRuku->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		$smarty->assign("pk",$primary_key);
		$smarty->assign("ruku_tag",'1');
		$smarty->display('CangKu/RukuTuihuoEditBc.tpl');
	}

	#保存货品档案
	function actionSaveWares() {
		//echo "sadf";exit;
		$arr=$_POST;
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$arr['cnt']=0-$arr['cnt'];
		$arr['cntJian']=0-$arr['cntJian'];
		//dump($arr);exit;
		if ($modelRuku2Wares->save($arr))
			redirect($this->_url('EditWare',array('rukuId'=>$_POST[rukuId],'tag'=>1)));
		else die('保存失败!');
	}

    function _editable($pkv) {
	/*
		$arr_field_value=$this->_modelRuku->find($pkv);
		$wares = $arr_field_value[Wares];
		//判断相关凭证是否被审核
		$invoice = FLEA::getSingleton('Model_CaiWu_Yf_Invoice');
		if (count($wares)>0) {
			foreach($wares as & $value) {
				if ($invoice->isChecked($value[invoiceId])) {
					js_alert('该入库单相关联的凭证已经审核，不允许修改!','',$_SERVER['HTTP_REFERER']);
				}
			}
		}
	*/
	}
	#修改货品界面
	function actionEditWare() {
		//$this->authCheck($this->funcId);
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		//$ruku = $this->_modelRuku->find($_GET[rukuId]);
		$wares = $modelRuku2Wares->findAll("rukuId='$_GET[rukuId]'");
		foreach($wares as & $v)
		{
			$v['cnt']=abs($v['cnt']);
			$v['cntJian']=abs($v['cntJian']);
		}
		//dump($wares);exit;
		$smarty = & $this->_getView();
		$smarty->assign('rows',$wares);

		$smarty->display('CangKu/RuKu2WareEdit.tpl');
	}

	//删除整单
	function actionRemove() {
		// $this->authCheck(98);
		$pk = $_GET['id'];
		$this->_editable($pk);
		$this->_modelRukuPeisha->removeByPkv($pk);
		redirect($this->_url('right'));
	}

	//删除详细记录
	function actionRemoveWare() {
	    // $this->funcId = 98;
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$modelRuku2Wares->removeByPkv($_GET[id]);
		redirect($this->_url('right'));
	}
}
?>