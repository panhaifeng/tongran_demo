<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Yl_Ruku extends Tmis_Controller {
	var $_modelRuku;
	var $funcId, $readFuncId, $addFuncId, $editFuncId, $delFuncId;

	function Controller_CangKu_Yl_Ruku() {
		$this->_modelRuku = & FLEA::getSingleton('Model_CangKu_Yl_Ruku');
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_Yl_Ruku');
		$this->_mWare = & FLEA::getSingleton('Model_CangKu_Yl_Ruku2Ware');
		$this->_setFuncId();
	}

	/*染化料入库登记，只显示基本信息
	function actionRight(){
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
		$condition[]=array('isTuiku','0','=');



		$pager =& new TMIS_Pager($this->_modelRuku,$condition,"rukuDate DESC");
		$rowset =$pager->findAll();
		
		$rl = & FLEA::getSingleton('Model_Jichu_Ware');

		if (count($rowset)>0) foreach($rowset as & $v) {
			//特效：提示详细信息
			$tempArr = array();
			if (count($v['Wares'])>0) foreach($v['Wares'] as $w){
				$row = $rl->findByField('id',$w['wareId']);
				$tempArr[] = "规格：<strong>".$row['wareName']."</strong>  数量：<strong>".$w['cnt']."</strong>  单价：<strong>".$w['danjia']."</strong>  金额：<strong>".$w['danjia']*$w['cnt']."</strong>";
			}
			if (count($tempArr)>0) $title = join("<br>",$tempArr);			
			$v['supplierName'] ="<span title='$title' onmouseover='tipOver(this,event)' onmouseout='tipOut(this)' style='cursor:pointer;'>".$v['Supplier']['compName']."<span>";
		}
                //dump($rowset);exit;
		//foreach($rowset['Wares'] as $v){
		//}
		$arrFieldInfo = array(
			'rukuNum' => '单号',
			'rukuDate' => '入库日期',
			'supplierName'=> '客户名称',
			'memo'=>'备注',
		);
		$arr_edit_info = array("Edit" =>"修改","remove" =>"删除");

		$smarty = & $this->_getView();
		$smarty->assign('title','入库登记');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('tip','calendar','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}*/

	//染化料入库登记，显示明细，且有删除，修改，整单删除
	function actionRight(){
		$this->authCheck(55);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-01"),
			'dateTo' => date("Y-m-d"),
			'supplierType'=>'',
			'supplierId'=>'',
			'rukuDanhao' => '',
			'rhlName'=>''
		));
		// dump($_POST);exit;
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
					jw.guige,
					y.memo
				from cangku_yl_ruku2ware x 
				left join cangku_yl_ruku y on x.rukuId = y.id 
				left join jichu_supplier js on y.supplierId = js.id 
				left join jichu_ware jw on x.wareId = jw.id";

		//非退库 
		$sql .= " where isTuiku = 0";
		//kond=0 为入库数据 kind = 8 调拨数据 by zcc
		$sql .= " and kind = 0";
		//时间段
		$sql .= " and rukuDate >= '".$arrGet['dateFrom']."'";
		$sql .= " and rukuDate <= '".$arrGet['dateTo']."'";

		//供应商搜索
		if ($arrGet['supplierId'] != '') $sql .= " and supplierId = ".$arrGet['supplierId'];
		if ($arrGet['supplierType'] != '') $sql .= " and js.compCode like '{$arrGet['supplierType']}%'";
        if ($arrGet['rukuDanhao'] != '') $sql .= " and y.rukuNum like '%{$arrGet['rukuDanhao']}%'";
        if ($arrGet['rhlName'] != '') $sql .= " and jw.wareName like '%{$arrGet['rhlName']}%'";
		//纱支搜索
		if($_GET['wareId']>0) $sql .= " and wareId = ".$_GET['wareId'];

		//排序
		$sql .= " order by rukuDate DESC";
		// dump($sql);
		//echo($sql); exit;
                $row=array();
                $query=mysql_query($sql);
                while($re=mysql_fetch_assoc($query)){
                    $row[]=$re;
                }
                //dump($row);exit;
                 $totalCnt=0;
               foreach($row as & $v){
                   //dump($v);
                    $totalMoney+=$v['cnt']*$v['danjia'];
                    $totalCnt+=$v['cnt'];
               }
		$pager = & new TMIS_Pager($sql);
		$rowset =$pager->findAll();

		if (count($rowset)>0) foreach($rowset as & $v) {
			$v['money']=round($v['cnt']*$v['danjia'],2);
			$v['_edit'] = "<a href='".$this->_url('edit',array('id'=>$v['rukuId']))."'>修改</a>  |  <a href='".$this->_url('removeWare',array(
				'id' =>$v['ruku2wareId'],
				'ruKuId' => $v['rukuId'],
			))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>  |  <a href='".$this->_url('remove',array(
				'id'=>$v['rukuId']
			))."' onclick='return confirm(\"您确认要整单删除吗？\");'>整单删除</a>";
		}
                $i=count($rowset)+1;
                //dump($i);
                $rowset[$i]['rukuNum']='总计';
                $rowset[$i]['cnt']=$totalCnt;
                $rowset[$i]['money']=$totalMoney;
		$arrFieldInfo = array(
			'rukuNum'		=> '单号',
			'rukuDate'		=> '入库日期',
			'supplierName'	=> '供应商名称',
			'wareName'		=> '染化料',
			'guige'			=> '规格',
			'cnt'			=> '数量',
			'danjia'		=> '单价',
			'money'			=> '金额',
			'memo'			=> '备注',
			'_edit'			=> '操作',
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','染化料入库登记');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('tip','calendar','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet))."<a href='".$this->_url('export2excel',$arrGet)."'>导出全部</a>");
		$smarty->display('TableList2.tpl');
	}
    //入库记录导出到excel文档中
    function actionExport2excel() {
    	FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d"),
			'dateTo' => date("Y-m-d"),
			'supplierType'=>'',
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

		//非退库
		$sql .= " where isTuiku = 0";
		$sql .= " and rukuDate >= '".$arrGet['dateFrom']."'";
		$sql .= " and rukuDate <= '".$arrGet['dateTo']."'";
		if ($arrGet['supplierId'] != '') $sql .= " and supplierId = ".$arrGet['supplierId'];
		if ($arrGet['supplierType'] != '') $sql .= " and js.compCode like '{$arrGet['supplierType']}%'";
		if($_GET['wareId']>0) $sql .= " and wareId = ".$_GET['wareId'];
		$sql .= " order by rukuDate DESC";

       //  $row=array();
       //  $query=mysql_query($sql);
       //  while($re=mysql_fetch_assoc($query)){
       //      $row[]=$re;
       //  }
       //   $totalCnt=0;
       // foreach($row as & $v){
       //      $totalMoney+=$v['cnt']*$v['danjia'];
       //      $totalCnt+=$v['cnt'];
       // }

		// $pager = & new TMIS_Pager($sql);
		$rowset =$this->_modelExample->findBySql($sql);

		if (count($rowset)>0) foreach($rowset as & $v) {
			$v['money']=round($v['cnt']*$v['danjia'],2);
			// $v['_edit'] = "<a href='".$this->_url('edit',array('id'=>$v['rukuId']))."'>修改</a>  |  <a href='".$this->_url('removeWare',array(
			// 	'id' =>$v['ruku2wareId'],
			// 	'ruKuId' => $v['rukuId'],
			// ))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>  |  <a href='".$this->_url('remove',array(
			// 	'id'=>$v['rukuId']
			// ))."' onclick='return confirm(\"您确认要整单删除吗？\");'>整单删除</a>";
		}
     	$rowset[] = $this->getHeji($rowset,array('cnt','money'),'rukuNum');
		$arrFieldInfo = array(
			'rukuNum'		=> '单号',
			'rukuDate'		=> '入库日期',
			'supplierName'	=> '客户名称',
			'wareName'		=> '纱支',
			'guige'			=> '规格',
			'cnt'			=> '数量',
			'danjia'		=> '单价',
			'money'			=> '金额',
			'memo'			=> '备注',
			// '_edit'			=> '操作',
		);

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		//header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", '内销收款查询').".xls");
		header("Content-Disposition: attachment;filename=Domestic collection.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty = & $this->_getView();
		$smarty->assign('title','入库记录清单');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		// $smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		// $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('tip','calendar','thickbox')));
		// $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet))."<a href='".$this->_url('export2excel',$arrGet)."'>导出全部</a>");
		$smarty->display('Export2Excel.tpl');

    }
    function actionRight1(){
		$this->authCheck($this->readFuncId);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-01",strtotime('-1 month')),
			'dateTo' => date("Y-m-d"),
			'supplierId'=>'',
		));

		//dump($arrGet); exit;
		$condition[] = array('rukuDate', $arrGet['dateFrom'], '>=');
		$condition[] = array('rukuDate', $arrGet['dateTo'], '<=');
		if ($arrGet['supplierId'] != '') $condition[] = array('supplierId', $arrGet['supplierId'], '=');
		if($_GET['wareId']>0) $condition[] = array('wareId', $_GET['wareId'], '=');
		//$condition[] = array('rukuNum', '%'.$arrGet['rukuNum'].'%', 'like');
		$condition[]=array('isTuiku','0','=');



		$pager =& new TMIS_Pager($this->_modelRuku,$condition,"rukuDate DESC");
		$rowset =$pager->findAll();
		//dump($rowset); exit;
		$rl = & FLEA::getSingleton('Model_Jichu_Ware');

		if (count($rowset)>0) foreach($rowset as & $v) {
			//特效：提示详细信息
			$tempArr = array();
			if (count($v['Wares'])>0) foreach($v['Wares'] as $w){
				$row = $rl->findByField('id',$w['wareId']);
				$v['guige'] .= $row['wareName']."<br/>";
                                $v['cnt'].=$w['cnt']."<br/>";
                                $v['danjia'].=$w['danjia']."<br/>";
                                $v['money'].=$w['danjia']*$w['cnt']."<br/>";
			}
			if (count($tempArr)>0) $title = join("<br>",$tempArr);
			$v['supplierName'] ="<span title='$title' onmouseover='tipOver(this,event)' onmouseout='tipOut(this)' style='cursor:pointer;'>".$v['Supplier']['compName']."<span>";
		}
                //dump($rowset);exit;
		//foreach($rowset['Wares'] as $v){
		//}
		$arrFieldInfo = array(
			'rukuNum' => '单号',
			'rukuDate' => '入库日期',
			'supplierName'=> '客户名称',
			'guige'=>'规格',
			'cnt'=>'数量',
			'danjia'=>'单价',
			'money'=>'金额',
			'memo'=>'备注',
		);
		//$arr_edit_info = array("Edit" =>"修改","remove" =>"删除");

		$smarty = & $this->_getView();
		$smarty->assign('title','入库查询');
		$smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('tip','calendar','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}
	#入库明细查询
	function actionRukuDetail(){
		$this->authCheck($this->readFuncId);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			//'dateFrom' =>date("Y-m-d"),
			//'dateTo' => date("Y-m-d"),
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

		//非退库
		//$sql .= " where isTuiku = 0";
		$sql .= " where 1";
		//时间段
		$sql .= " and rukuDate >= '".$_GET['dateFrom']."'";
		$sql .= " and rukuDate <= '".$_GET['dateTo']."'";

		//供应商搜索
		if ($arrGet['supplierId'] != '') $sql .= " and supplierId = ".$arrGet['supplierId'];

		//纱支搜索
		if($_GET['wareId']>0) $sql .= " and wareId = ".$_GET['wareId'];

		//排序
		$sql .= " order by rukuDate DESC";

		//echo($sql); exit;
		$row=array();
		$query=mysql_query($sql);
		while($re=mysql_fetch_assoc($query)){
			$row[]=$re;
		}
		//dump($row);exit;
		 $totalCnt=0;
	   foreach($row as & $v){
		   //dump($v);
			$totalMoney+=$v['cnt']*$v['danjia'];
			$totalCnt+=$v['cnt'];
	   }
		$pager = & new TMIS_Pager($sql);
		$rowset =$pager->findAll();

		$i=count($rowset)+1;
		//dump($i);
		$rowset[$i]['rukuNum']='总计';
		$rowset[$i]['cnt']=$totalCnt;
		$rowset[$i]['money']=$totalMoney;
		$arrFieldInfo = array(
			'rukuNum'		=> '单号',
			'rukuDate'		=> '入库日期',
			'supplierName'	=> '客户名称',
			'wareName'		=> '纱支',
			'guige'			=> '规格',
			'cnt'			=> '数量',
			'danjia'		=> '单价',
			'money'			=> '金额',
			'memo'			=> '备注',
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','入库明细');
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('tip','calendar','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}
/*
	#染化料仓库
	function actionRight(){
		$this->authCheck($this->readFuncId);
		$mSupplier = & FLEA::getSingleton('Model_JiChu_Supplier');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		FLEA::loadClass('TMIS_Pager');
		$arr = array('supplierId' =>0);
		$arr['dateFrom'] =date("Y-m-d");
		$arr['dateTo'] = date("Y-m-d");
		$arrGet = TMIS_Pager::getParamArray($arr);

		$sql = "select
			y.wareId,y.cnt,y.danjia,
			x.*
			from cangku_yl_ruku x
			left join cangku_yl_ruku2ware y
			on x.id=y.rukuId
			where x.rukuDate>='{$arrGet['dateFrom']}' and x.rukuDate<='{$arrGet['dateTo']}'";
		if ($arrGet['supplierId']>0) $sql .= " and x.supplierId='{$arrGet['supplierId']}'";
		if($_GET['wareId']>0) $sql.=" and y.wareId='{$_GET['wareId']}'";
		$pager =& new TMIS_Pager($sql,$condition);
		$rowset =$pager->findAll();
		//$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
		//dump($rowset);
		if($rowset) foreach($rowset as & $v) {
			$v['Supplier'] =$mSupplier->find(array('id'=>$v['supplierId']));
			$v['Ware'] =$mWare->find(array('id'=>$v['wareId']));
			$v['money'] = round($v['danjia']*$v['cnt'],2);
			$v['_edit'] = $this->getEditHtml($v['id']). ' | ' . $this->getRemoveHtml($v['id']);
		}
		$rowset[] = $this->getHeji($rowset,array('cnt','money'),'rukuNum');

		//模板变量设置
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			'rukuNum' =>'单号',
			'songhuoCode' =>'送货单号',
			'rukuDate' =>'日期',
			'Supplier.compName' =>'供应商',
			'Ware.wareName'=>'货品名称',
			'Ware.guige'=>'规格',
			//'Wares.unit'=>'单位',
			'cnt' =>'数量KG',
			'danjia' =>'单价',
			'money'=>'金额',
			'_edit'=>'操作'
		);
		//$arr_edit_info = array("ViewMore" =>"查看详细", "Edit" =>"修改","remove" =>"删除");
		$smarty->assign('title','入库查询');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}*/

	#查看详细
	function actionViewMore() {
		//$this->authCheck($this->funcId);
		if ($_SESSION['rukuTag'] == 1) {
			$pk=$this->_modelRukuYl->primaryKey;
			$this->_editable($_GET[$pk]);
			$arrFieldValue=$this->_modelRukuYl->find($_GET[$pk]);
		}
		else {
			$pk=$this->_modelRuku->primaryKey;
			$this->_editable($_GET[$pk]);
			$arrFieldValue=$this->_modelRuku->find($_GET[$pk]);
		}

		FLEA::loadClass('TMIS_Pager');
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$i = 0;
		$cntTotal = 0;
		if (count($arrFieldValue["Wares"]) > 0) {
			foreach ($arrFieldValue["Wares"] as & $value) {

				$rowWare = $modelWare->findByField('id', $value["wareId"]);
				$value["wareName"] = $rowWare["wareName"];
				$value["guige"] = $rowWare["guige"];
				$value["unit"] = $rowWare["unit"];
				$cntTotal += $value[cnt];
				$i++;
			}
			$arrFieldValue[Wares][$i][id] = '<strong>合计</strong>';
			$arrFieldValue[Wares][$i][cnt] = '<strong>'.$cntTotal.'</strong>';
		}

		//dump($arrFieldValue);

		$smarty = & $this->_getView();

		$smarty->assign("arr_field_value",$arrFieldValue);

		if ($_SESSION['rukuTag'] == 1) $smarty->assign("supplier_client", "客户");
		else $smarty->assign("supplier_client", "供应商");

		$smarty->display('CangKu/RukuViewMore.tpl');
	}

	function _edit($arr) {
		$this->authCheck($this->editFuncId);
		if($arr['rukuNum']=='') {
			$arr['rukuNum'] = $this->_modelExample->getRukuNum();
		}
		//dump($arr); //exit;
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		if(isset($arr['Wares'])){
			if(count($arr['Wares'])>0) foreach($arr['Wares'] as & $v){
				$rowWare = $mWare->findByField('id',$v['wareId']);
				$v['wareName'] = $rowWare['wareName'];
				$v['guige'] = $rowWare['guige'];
				$v['unit'] = 'kg';
			}
		}

		$smarty = & $this->_getView();
		$smarty->assign("title","入库登记>>录入");
		$smarty->assign("arr_field_value",$arr);
		$smarty->display('CangKu/Yl/RukuEdit.tpl');
	}

	#修改货品界面
	function actionEditWare() {
		//$this->authCheck($this->funcId);
		$modelRuku2Wares = $this->_mWare;
		//$ruku = $this->_modelRuku->find($_GET[rukuId]);
		$wares = $modelRuku2Wares->findAll("rukuId='$_GET[rukuId]'");

		$smarty = & $this->_getView();
		$smarty->assign('rows',$wares);
		$smarty->assign('title', '染化料助剂入库明细');
		$smarty->assign('action', 'Right');
		$smarty->display('CangKu/Yl/RuKu2WareEdit.tpl');
	}

	function actionRemove() {
		$this->_modelExample->removeByPkv($_GET['id']);
		redirect($this->_url('right'));
	}
	
	function actionRemoveWare() {
		$this->_mWare->removeByPkv($_GET[id]);
		redirect($this->_url('right'));
	}

	function actionSave() {
		$count=count($this->_modelExample->findAll(array('rukuNum'=>$_POST['rukuNum'])));
		if($_POST['rukuId']==''){if($count>0) js_alert('单号已存在!','history.go(-1)');}///////////////////////


		for ($i=0;$i<count($_POST['cnt']);$i++){
			if(empty($_POST['wareId'][$i]) || empty($_POST['cnt'][$i])) continue;
			$arr[] = array(
				'id'		=> $_POST['id'][$i],
				//'rukuId'	=> $_POST['rukuId'],
				'wareId'	=> $_POST['wareId'][$i],
				'cnt'		=> $_POST['cnt'][$i],
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
                                'songhuoCode'=>$_POST['songhuoCode'],
				'Wares'			=> $arr
		);

       	$rukuId = $this->_modelRuku->save($row);
		if($rukuId) redirect($this->_url('right'));
		else die('保存失败!');
	}

	#保存货品档案
	function actionSaveWares() {
		//dump($_POST);exit;
		$modelRuku2Wares = $this->_mWare;

		if ($modelRuku2Wares->save($_POST))
			redirect($this->_url('EditWare',array('rukuId'=>$_POST[rukuId])));
		else die('保存失败!');
	}

	#设置权限
	function _setFuncId() {
		//$rukuTag = $this->_checkModel();
		/*if ($rukuTag == 1) {
			$this->readFuncId = 96;
			$this->addFuncId =98;
			$this->editFuncId =98;
			$this->delFuncId =98;
		}
		else{*/
			$this->readFuncId = 61;
			$this->addFuncId =62;
			$this->editFuncId =62;
			$this->delFuncId =62;
		//}
	}

	#得到最后一次采购的单价
	function actionGetLastDanjia(){
		$sql = "select danjia from cangku_yl_ruku2ware where wareId='{$_GET['wareId']}' order by id desc";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if($re)	echo '{success:true,danjia:'.$re['danjia'].'}';
		else echo '{success:false,msg:"获取单价失败，请确认入库记录中存在该染料的入库记录，且单价不为0!或者您可以手工输入一个替代单价！"}';
	}
}
?>