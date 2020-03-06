<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_RuKu extends Tmis_Controller {
	var $_modelRuku, $_modelRukuPeisha;
	var $funcId, $readFuncId, $addFuncId, $editFuncId, $delFuncId;
	var $rukuTag;	//1为坯纱, 2为染化料

	function Controller_CangKu_RuKu() {
		$this->_modelRuku = & FLEA::getSingleton('Model_CangKu_RukuDye');
		$this->_modelRukuPeisha = & FLEA::getSingleton('Model_CangKu_RuKu');
		$this->_setFuncId();
		$this->rukuTag=$_GET['rukuTag'];
	}

	/*坯纱入库登记
	function actionRight(){
		//$this->authCheck($this->readFuncId);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			//dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			'dateFrom'	=>date("Y-m-d",strtotime('-1 month')),
			'dateTo'	=>date("Y-m-d"),
			'clientId'	=>'',
		));

		$condition=array();
		$condition[] = array('rukuDate', $arrGet[dateFrom],'>=');
		$condition[] = array('rukuDate', $arrGet[dateTo],'<=');
		if ($arrGet['clientId'] != '') $condition[] = array('supplierId', $arrGet['clientId']);
		//去掉退库
		$condition[] = array('isTuiku', 0);

		$pager =& new TMIS_Pager($this->_modelRukuPeisha,$condition,'rukuDate desc');
		$rowset = $pager->findAll();

		//dump($rowset); exit;

		if (count($rowset)>0) foreach($rowset as & $v){
			$v['_edit']="<a href='".$this->_url('print',array('id'=>$v['id']))."'>打印</a>&nbsp;&nbsp;&nbsp;<a href='".$this->_url('edit',array('id'=>$v['id']))."'>修改</a>&nbsp;&nbsp;&nbsp;<a href='".$this->_url('remove',array('id'=>$v['id']))."'>整单删除</a>";
		}




		//模板变量设置
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"ruKuNum" =>"入库单号",
			"ruKuDate" =>"入库日期",
			"Client.compName" =>'客户名称',
			'memo'=>'备注',
			'_edit'=>'操作',
		);



		$smarty->assign('title','采购入库登记');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}*/

	/*坯纱入库登记明细
    function actionRight1(){
		//$this->authCheck($this->readFuncId);
		FLEA::loadClass('TMIS_Pager');

		$arrCompKind = 'clientId';

                //
			$thisModel = $this->_modelRukuPeisha;
			$compKind = '客户';
			$modelName = "Model_JiChu_Client";

			$str = "select
			x.ruKuId as id ,
			x.ruKuNum,
			x.ruKuDate,
			y.compName,
			x.cnt,
			x.chandi,
			x.danJia,
			z.wareName,
			z.guige,
			z.unit from view_Cangku_ruku x
			inner join jichu_client y on x.supplierId=y.id
			left join jichu_ware z on x.wareId=z.id where 1 and x.isTuiku=0 ";
		$arr = array($arrCompKind =>'');
		//if(isset($_GET[dateFrom])) {
			$arr[dateFrom]=date("Y-m-d",strtotime('-1 month'));
			$arr[dateTo] = date("Y-m-d");
		//} else $arr[date]=date("Y-m-d");

		$arrGet = TMIS_Pager::getParamArray($arr);

		if ($arrGet['date'] !='') $str .= " and ruKuDate = '$arrGet[date]'";
		else $str .= " and ruKuDate >= '$arrGet[dateFrom]' and ruKuDate<='$arrGet[dateTo]'";
		if ($arrGet[$arrCompKind] != '') $str .= " and supplierId = $arrGet[$arrCompKind]";
		if($_GET[wareId]!='') $str .= " and x.wareId='$_GET[wareId]'";
		$str .= " order by id desc";
		//echo $str;

		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		//dump($rowset[0]);
		if (count($rowset)>0) {
                    foreach($rowset as & $value) {
			if ($value['cnt']<0) {//坯纱
				$value['cntReturn'] = $value['cnt'];
				$value['cnt'] ='';
				$totalCntReturn += $value['cntReturn'];
			}
			$total[cnt] += $value[cnt];
			$total[money] += $value[money];
                        //$value['_edit'] =$this->getEditHtml($value['id'])." |"."<a href='".$this->_url('remove',array('id'=>$value['id']))."'>整单删除</a>";

                    }
                }
		$i = count($rowset);
		$rowset[$i][ruKuNum] = '<strong>合计</strong>';
		$rowset[$i][cnt] = '<strong>'.$total[cnt].'</strong>';
		$rowset[$i][money] = '<strong>'.$total['money'].'</strong>';
		if ($this->rukuTag==1) $rowset[$i]['cntReturn'] = $totalCntReturn;

		//模板变量设置
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"ruKuNum" =>"单号",
			"ruKuDate" =>"日期",
			"compName" =>$compKind,
			'wareName'=>'货品名称',
			'guige'=>'规格',
			'chandi'=>'产地',
			"cnt" =>'数量',
			//'_edit' => '操作',
			//'money' => '金额'
		);


		$smarty->assign('title','采购入库查询');
		$smarty->assign('arr_edit_info',$arr_edit_info);
                $smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}*/

	//坯纱入库登记，含明细，修改，删除，整单删除
	function actionRight(){
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom'	=> date("Y-m-d",strtotime('-1 month')),
			'dateTo'	=> date("Y-m-d"),
			'clientId'	=> '',
			'wareName'=>'',
			'chandi'=>'',
			'pihao'=>'',
		));

		$thisModel = $this->_modelRukuPeisha;
		$modelName = "Model_JiChu_Client";

		$str = "select
				x.ruKuId,
				x.id as ruku2wareId,
				x.ruKuNum,
				x.songhuoCode,
				x.ruKuDate,
				x.cnt,
				x.chandi,
				x.danJia,
				y.compName,
				z.wareName,
				z.guige,
				z.unit from view_Cangku_ruku x
				inner join jichu_client y on x.supplierId=y.id
				left join jichu_ware z on x.wareId=z.id
				left join cangku_ruku rk on rk.id = x.ruKuId
				 where 1 and x.isTuiku = 0 and x.kind = 0";
		//isYuling 是否预领料操作
		$str .= " and rk.isYuling = 0";		  
		if ($arrGet['date'] !='') $str .= " and x.ruKuDate = '$arrGet[date]'";
		else $str .= " and x.ruKuDate >= '$arrGet[dateFrom]' and x.ruKuDate<='$arrGet[dateTo]'";

		if ($arrGet['clientId'] >0) $str .= " and x.supplierId = $arrGet[clientId]";
		if ($arrGet['wareId']>0) {
			$str.=" and x.wareId='{$arrGet['wareId']}'";
		}
		if ($arrGet['wareName']) {
			$str.=" and z.wareName like '%{$arrGet['wareName']}%'";
		}
		if ($arrGet['chandi']) {
			$str.=" and x.chandi like '%{$arrGet['chandi']}%'";
		}
		if ($arrGet['pihao']) {
			$str.=" and x.id in ( SELECT id FROM cangku_ruku2ware where pihao like '%{$arrGet['pihao']}%')";
		}
		// if($_GET['wareId']>0) $str .= " and x.wareId='$_GET[wareId]'";

		$str .= " order by ruKuId desc";
		//dump($str);exit();
		$sql = "select * from (".$str.") as a where 1";
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAllBySql($sql);
		$ret=$this->_modelRuku->findBySql($sql);
		//dump($ret);exit();
		if (count($rowset)>0) foreach($rowset as & $v) {
			$sql = "SELECT * from cangku_ruku2ware where id = '{$v['ruku2wareId']}'";
			$ruku2ware = $this->_modelRuku->findBySql($sql);
			$v['pihao'] = $ruku2ware[0]['pihao'];

			if($v['cnt']<0) {
				$v['_bgColor'] = 'red';
				$v['cntTuiku']=abs($v['cnt']);
				$v['cnt']='';
			}
		}
		$heji = $this->getHeji($rowset,array('cnt','cntTuiku'),'ruKuNum');
		$zongji=$this->getHeji($ret, array('cnt','cntTuiku'),'ruKuNum');
		$zongji['ruKuNum']='<b>总计</b>';
		if (count($rowset)>0) foreach($rowset as & $v) {
			$v['_edit'] = "<a href='".$this->_url('edit',array('id'=>$v['ruKuId']))."'>修改</a>  |  <a href='".$this->_url('removeWare',array(
				'id' =>$v['ruku2wareId'],
				'ruKuId' => $v['ruKuId'],
			))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>  |  <a href='".$this->_url('remove',array(
				'id'=>$v['ruKuId']
			))."' onclick='return confirm(\"您确认要整单删除吗？\");'>整单删除</a>";
			//if($v['orderCode2']!='') $v['compName']=$v['compName'].'('.$v['orderCode2'].')';
		}
		$rowset[] = $heji;
		$rowset[] = $zongji;
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			'ruKuNum'	=>'单号',
			'ruKuDate'	=>'日期',
			'songhuoCode'=>'送货单号',
			'compName'	=>'客户',
			'wareName'	=>'货品名称',
			'guige'		=>'规格',
			'pihao'     =>'批号',
			'chandi'	=>'产地',
			'cnt'		=>'入库数量',
			'cntTuiku'		=>'退库数量',
			'_edit'		=>'',
		);

		$smarty->assign('title','坯纱入库登记');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}
    //入库明细
    function actionRight1(){
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom'	=> date("Y-m-d",strtotime('-1 month')),
			'dateTo'	=> date("Y-m-d"),
			'clientId'	=> ''
		));
		$thisModel = $this->_modelRukuPeisha;
		$modelName = "Model_JiChu_Client";

		$str = "SELECT
				x.ruKuId,
				x.id as ruku2wareId,
				x.ruKuNum,
				x.songhuoCode,
				x.ruKuDate,
				x.cnt,
				x.chandi,
				x.danJia,
				y.compName,
				z.wareName,
				z.guige,
				z.unit ,
				rk.kuwei,
				rk.pihao
			from view_Cangku_ruku x
			inner join jichu_client y on x.supplierId=y.id
			left join jichu_ware z on x.wareId=z.id 
			left join cangku_ruku2ware rk on rk.id = x.id
			where 1 and x.isTuiku = 0 ";

		if ($arrGet['date'] !='') $str .= " and x.ruKuDate = '$arrGet[date]'";
		else $str .= " and x.ruKuDate >= '$arrGet[dateFrom]' and x.ruKuDate<='$arrGet[dateTo]'";

		if ($arrGet['clientId'] >0) $str .= " and x.supplierId = $arrGet[clientId]";

		if($_GET['wareId']>0) $str .= " and x.wareId='$_GET[wareId]'";

		$str .= " order by x.ruKuId desc";
		//echo $str;
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		if (count($rowset)>0) foreach($rowset as & $v) {
			if($v['cnt']<0 && $v['isTuiku']==1) {
				$v['_bgColor'] = 'red';
				$v['cntTuiku']=abs($v['cnt']);
				$v['cnt']='';
			}
			if ($v['kuwei'] == 0) {
				$v['kuweiName'] =  '仓库';
			}
			if ($v['kuwei'] == 1) {
				$v['kuweiName'] =  '松筒车间';
			}
		}
		$heji = $this->getHeji($rowset,array('cnt','cntTuiku'),'ruKuNum');
		$rowset[] = $heji;
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			'ruKuNum'	=>'单号',
			'ruKuDate'	=>'日期',
			'songhuoCode'=>'送货单号',
			'compName'	=>'客户',
			//'wareName'	=>'货品名称',
			'pihao'     =>'批号',
			'guige'		=>'规格',
			'chandi'	=>'产地',
			'kuweiName' =>'库位',
			'cnt'		=>'入库数量',
			'cntTuiku'		=>'退库数量',
		);

		$smarty->assign('title','坯纱入库登记');
        $smarty->assign('nav_display','none');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}
	#可以看见单价和金额, 用于财务部门添加单价
	function actionRightHavePrice(){
		$this->authCheck(4);
		if ($_GET[rukuTag]) {
				$_SESSION['rukuTag'] = $_GET[rukuTag];
				$rukuTag = $_SESSION['rukuTag'];
		}
		elseif ($_SESSION['rukuTag']) $rukuTag = $_SESSION['rukuTag'];


		FLEA::loadClass('TMIS_Pager');

		$arrCondition = TMIS_Pager::getParamArray(array(
			supplierId => '',
			key => ''
		));

		$condition=array(
			array('SupplierId',"%$arrCondition[supplierId]%",'like'),
			array('Supplier.compName',"%$arrCondition[key]%",'like'),
			array('tag', $rukuTag)
		);


		if ($rukuTag == 2) $pager =& new TMIS_Pager($this->_modelRuku,$condition);
		elseif ($rukuTag == 1) $pager =& new TMIS_Pager($this->_modelRukuPeisha,$condition);
		else {
			echo"Error, 传值出错,请重新点击左侧连接!";
			exit;
		}

        $rowset =$pager->findAll();

		$modelWare = FLEA::getSingleton('Model_JiChu_Ware');

		//*****判断是染化料还是坯纱
		if ($rukuTag==1) {
			$modelSupplier = FLEA::getSingleton('Model_JiChu_Client');
			$supplierName = "客户";
		}
		else {
			$modelSupplier = FLEA::getSingleton('Model_JiChu_Supplier');
			$supplierName = "供应商";
		}

		foreach ($rowset as & $value) {
			$arr = $modelSupplier->find($value[supplierId]);
			$value[supplierName] = "<a href='".$this->_url('right',array(
				'supplierId'=>$value[supplierId]
			))."'>$arr[compName]</a>";

			$value[edit] = "<a href='?controller=CangKu_RuKu&action=ViewMore&id=$value[id]' target='main'>查看详细</a> | <a href='?controller=CangKu_RuKu&action=AddPrice&id=$value[id]' target='main'>添加单价</a>";
		}

		$smarty = & $this->_getView();
		//if ($rukuTag==1) $smarty->assign('add_action', 'AddPeisha');

		#对表头进行赋值
		$arrFieldInfo = array(
			"ruKuNum" =>"单号",
			"ruKuDate" =>"日期",
			"supplierName" =>$supplierName
		);

		#对操作栏进行赋值
		$arr_edit_info = array("ViewMore" =>"查看详细", "AddPrice" =>"添加单价");
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		//$smarty->assign('search_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrCondition)));
		$smarty->display('TableList.tpl');
	}

	#查看详细
	function actionViewMore() {
		//$this->authCheck($this->funcId);
		if ($_SESSION['rukuTag'] == 1) {
			$pk=$this->_modelRukuPeisha->primaryKey;
			$this->_editable($_GET[$pk]);
			$arrFieldValue=$this->_modelRukuPeisha->find($_GET[$pk]);
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
				$value["sx"] = $rowWare["mnemocode"];
				$value["unit"] = $rowWare["unit"];
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

		if ($_SESSION['rukuTag'] == 1) $smarty->assign("supplier_client", "客户");
		else $smarty->assign("supplier_client", "供应商");

		//$smarty->display('CangKu/RukuViewMore.tpl');
		$smarty->display('CangKu/RukuViewMore.tpl');
	}

	#查看详细
	function actionPrint() {
		$rowset=$this->_modelRukuPeisha->find($_GET['id']);
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		if (count($rowset["Wares"]) > 0) foreach ($rowset["Wares"] as & $value) {

				$rowWare = $modelWare->findByField('id', $value["wareId"]);
				$value["wareName"] = $rowWare["wareName"];
				$value["guige"] = $rowWare["guige"];
				$value["sx"] = $rowWare["mnemocode"];
				$value["unit"] = $rowWare["unit"];

		}

		//dump($rowset);exit;

		$smarty = & $this->_getView();

		$smarty->assign("arr_field_value",$rowset);
		$smarty->assign("arr_field_info",array(
			'wareName'=>'名称',
			'guige'=>'规格',
			'chandi'=>'产地',
			'pihao' =>'批号',
			'cntJian'=>'件数',
			'cnt'=>'数量',
			'unit'=>'单位'
		));

		$smarty->display('CangKu/PsRkPrint.tpl');
	}

	#添加单价
	function actionAddPrice() {
		//$this->authCheck($this->funcId);
		$pk=$this->_modelRuku->primaryKey;
		$aRow=$this->_modelRuku->find($_GET[$pk]);
		//dump($aRow);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$aRow);
		$smarty->assign("pk",$pk);
		$smarty->display('CangKu/AddPrice.tpl');
	}

	#修改货品界面
	function actionSavePrice() {
		$count = count($_POST[id]);
		for($i=0; $i<$count; $i++) {
			$rowset[$i][id] = $_POST[id][$i];
			$rowset[$i][danJia] = $_POST[danJia][$i];
		}
		//$this->authCheck($this->funcId);
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		if ($modelRuku2Wares->saveRowset($rowset))
			//redirect($this->_url('AddPrice',array('id'=>$_POST[rukuId])));
			redirect($this->_url('RightHavePrice'));
		else die('保存失败!');
	}

	#增加界面/常用模式
	function actionAdd() {
		$this->_edit(array());
	}
	#修改
	function actionEdit() {
		/*
		if ($_SESSION['rukuTag'] == 1) $this->funcId = 98;	//染化--入库--修改
		else $this->funcId = 62;	//坯纱--入库--修改
		$this->authCheck($this->funcId);*/

		//echo($_SESSION['rukuTag']);
		//echo($_GET[$pk]);

                $pk=$this->_modelRukuPeisha->primaryKey;
                $this->_editable($_GET[$pk]);
                $arrFieldValue=$this->_modelRukuPeisha->find($_GET[$pk]);

		//dump($arrFieldValue);
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
                'ruKuId'    => $_POST['rukuId'][$i],
				'wareId'	=> $_POST['wareId'][$i],
				'cnt'		=> $_POST['cnt'][$i],
                'chandi'    => $_POST['chandi'][$i],
                'pihao'  	=> $_POST['pihao'][$i],
				//'danjia'	=> $_POST['danjia'][$i],
                'cntJian'   => $_POST['cntJian'][$i],
				'memo'		=> $_POST['memo'][$i],
				'ifRemove'	=> $_POST['ifRemove'][$i]
			);
		}
                if($arr['id']==null) unset($arr['id']);
		$row=array(
				'id'			=> $_POST['id'],
				'ruKuNum'		=> $_POST['ruKuNum'],
				'songhuoCode'	=> $_POST['songhuoCode'],
			    'ruKuDate'		=> empty($_POST['ruKuDate'])?date("Y-m-d"):$_POST['ruKuDate'],
				'supplierId'	=> $_POST['clientId'],
				'memo'			=> $_POST['memo'],
				'Wares'			=> $arr
		);
        // dump($row);exit;
       	$return = $this->_modelRukuPeisha->save($row);

		//如果是修改则直接取POST中的ID，如果是新增，就直接取save的返回值。
		if ($_POST['rukuId'] == '') $rukuId = $return;
		else $rukuId = $_POST['rukuId'];

		//echo($rukuId); exit;

		if($rukuId) redirect($this->_url('Print',array('id'=>$rukuId)));
		else die('保存失败!');
	}

	function _edit() {
		$this->funcId = 98;	//坯纱--入库--新增修改
		$this->authCheck($this->funcId);
        if($arr['ruKuNum']=='') {
			//echo $this->_modelRukuPeisha->getNewRukuNum();exit;
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
                //dump($arr);
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
        $smarty->assign('aRow',$arr);
		$smarty->assign('user_id', $_SESSION['USERID']);
		$smarty->assign('real_name', $_SESSION['REALNAME']);
		//$smarty->assign("arr_field_value",$Arr);
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
		$smarty->assign("ruku_tag", $_SESSION['rukuTag']);
		$smarty->display('CangKu/RukuEdit.tpl');

	}

	#保存货品档案
	function actionSaveWares() {
		//echo "sadf";exit;
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		if ($modelRuku2Wares->save($_POST))
			redirect($this->_url('EditWare',array('rukuId'=>$_POST[rukuId],'tag'=>$_POST[tag])));
		else die('保存失败!');
	}

	#修改货品界面
	function actionEditWare() {
		//$this->authCheck($this->funcId);
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		//$ruku = $this->_modelRuku->find($_GET[rukuId]);
		$wares = $modelRuku2Wares->findAll("rukuId='$_GET[rukuId]'");
		//dump($wares);exit;
		$smarty = & $this->_getView();
		$smarty->assign('rows',$wares);

		$smarty->display('CangKu/RuKu2WareEdit.tpl');
	}

	#删除
	function actionRemove() {
		$this->funcId = 98;
		$pk = $_GET['id'];
		$this->_editable($pk);
		$this->_modelRukuPeisha->removeByPkv($pk);
		redirect($this->_url('right'));
	}

	function actionRemoveWare() {
	    $this->funcId = 98;
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$modelRuku2Wares->removeByPkv($_GET[id]);
		redirect($this->_url('right'));
	}

	#根据入库单号显示入库明细，再抵冲发票时用
	function actionGetWaresJson() {
		$ruku = $this->_modelRuku->find("ruKuNum='$_GET[rukuNum]'");
		$rukuId = $ruku[id];
		//echo $rukuId;exit;
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$wares = $modelRuku2Wares->findAll("rukuId='$rukuId'");

		for ($i=0;$i<count($wares);$i++) {
			$wares[$i][rukuNum] = $_GET[rukuNum];
		}
		echo json_encode($wares);exit;
		//dump($wares);exit;
	}

	/*
	 *判断id=$pkv的入库单是否允许被修改或删除,有以下情况返回false
	 *财务已经审核其中一笔货物。
	 */
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

	#显示invoiceId=$_GET[id]的所有的入库明细
	function actionShowWares2Invoice() {
		$_m = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$wares = $_m->findAll("invoiceId='$_GET[id]'");
		//dump($wares);exit;
		if (count($wares)>0) {
			$_modelSupplier = FLEA::getSingleton('Model_JiChu_Supplier');
			foreach($wares as &$value) {
				$temp = $_modelSupplier->find($value[Ruku][supplierId]);
				$value[supplierName] = $temp[compName];
				$value[rukuNum] = $value[Ruku][ruKuNum];
				$value[wareId] = $value[wareId];
				$value[wareName] = $value[Wares][wareName];
				$value[guige] = $value[Wares][guige];
				$value[unit]= $value[Wares][unit];
				$value[danjia] = $value[danJia];
				$value[cnt] = $value[cnt];
				$value[money] = number_format($value[danjia]*$value[cnt],2,".","");
			}
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$pk = $this->_modelRuku->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"rukuNum" =>"入库单号",
			"supplierName" =>"供应商",
			"wareId" =>"货品编号",
			"wareName" =>"品名",
			"guige" =>"规格",
			"unit" =>"单位",
			"cnt" => "数量",
			"danjia" => "单价",
			"money" => "金额",
		);
		$smarty->assign('title','入库明细');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$wares);
		//$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arr)));
		//$smarty->assign('controller', 'CaiWu_Yf_Report');
		$smarty->display('TableList.tpl');
	}

	#在染料领料出库时需要弹出某个染料入库的批次。
	function actionPopup() {
		$str = "select x.id,x.ruKuNum,x.ruKuDate,y.compName,x.cnt,x.danJia from
			view_cangku_ruku x inner join jichu_supplier y on x.supplierId=y.id
			where 1";
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'wareId'=>'$_GET[wareId]'
		));
		if ($arr[wareId]!='') $str .= " and x.wareId='$arr[wareId]'";
		$str .= " order by id desc";
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		$pageInfo = $pager->getNavBar('?'.$pager->getParamStr($arr));		//$dbo =& FLEA::getDbo();dump($dbo->log);
		//dump($condition);exit;
		if(count($rowset)>0) foreach($rowset as & $v){
			$v[_edit] = "<a href='#' onclick=\"retRuku($v[id],$v[danJia])\">选择</a>";
		}
		$smarty = & $this->_getView();
		$model= FLEA::getSingleton('Model_JiChu_Ware');
		$a = $model->find($_GET[wareId]);
		$smarty->assign('title', "<font color=red>".$a[wareName]."</font>的采购记录");
		$arr_field_info = array(
			"_edit" => "选择",
			"ruKuDate"=>"入库日期",
			"ruKuNum" =>"单据号码",
			"compName" =>"供应商",
			"cnt" =>"数量",
			"danJia"=>"单价"
		);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pageInfo);
		$smarty-> display('Popup/Ruku.tpl');
	}


	#坯纱入库日报表
	function actionReport() {
		$this->funcId = 96;		//坯纱--入库--查询
		$mSupplier = FLEA::getSingleton('Model_JiChu_Client');
		$this->authCheck($this->funcId);

		$condition=array(
			array('ruKuDate', date("Y-m-d"), '>='),
			array('ruKuDate', date("Y-m-d"), '<='),
		);

		$rowset = $this->_modelRukuPeisha->findAll($condition, 'ruKuDate desc');
		$modelWare = FLEA::getSingleton('Model_JiChu_Ware');
		$rowsetCopy = array();		//把rowset及附属表中的数据重新提取出来.
		$i = 0;
		$cntCount = 0;
		foreach ($rowset as & $value) {
			$rowSupplier = $mSupplier->find($value['clientId']);
			if (count($value['Wares']) > 0) {
				foreach ($value['Wares'] as & $item) {
					$rowsetCopy[$i]['ruKuNum']		= $value['ruKuNum'];
					$rowsetCopy[$i]['supplierName']	= $value['Supplier']['compName'];
					$rowsetCopy[$i]['ruKuDate']		= $value['ruKuDate'];
					$rowsetCopy[$i]['cnt']			= $item['cnt'];
					$cntCount += $item['cnt'];

					$rowWare = $modelWare->findByField('id', $item['wareId']);

					if (count($rowWare) > 0) {
						$rowsetCopy[$i]['wareName'] = $rowWare['wareName'].'||'.$rowWare['guige'];
						$rukuCount = $this->CountCnt('view_cangku_ruku', 'supplierId = '.$value['supplierId'].' and wareId = '.$item['wareId']);
						$chukuCount = $this->CountCnt('cangku_chuku2ware', 'supplierId = '.$value['supplierId'].' and wareId = '.$item['wareId']);
						$rowsetCopy[$i]['yushu'] = $rukuCount - $chukuCount;
					}
					$i++;
				}
			}
		}

		$heji = $this->getHeji($rowsetCopy,array('cnt', 'yushu'), 'ruKuNum');
		$rowsetCopy[] = $heji;

		#对表头进行赋值
		$arrFieldInfo = array(
			'ruKuNum'		=>'单号',
			'supplierName'	=>'客户',
			'ruKuDate'		=>'日期',
			'wareName'		=>'纱支',
			'cnt'			=>'数量',
			'yushu'			=>'余数'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', '坯纱入库日报表');
		$smarty->assign('supplierName', $supplierName);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowsetCopy);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->display('TableList.tpl');
	}

	/*
	#坯纱入库报表 日期, 客户
	function actionReport() {
		if ($_GET[rukuTag]) {
				$_SESSION['rukuTag'] = $_GET[rukuTag];
				$rukuTag = $_SESSION['rukuTag'];
		}
		elseif ($_SESSION['rukuTag']) $rukuTag = $_SESSION['rukuTag'];

		if ($_SESSION['rukuTag'] == 1) {
			$this->funcId = 96;		//坯纱--入库--查询
			$modelSupplier = FLEA::getSingleton('Model_JiChu_Client');
			$supplierName = '客户';
		}
		else {
			$this->funcId = 61;		//染化--入库--查询
			$modelSupplier = FLEA::getSingleton('Model_JiChu_Supplier');
			$supplierName = "供应商";
		}

		$this->authCheck($this->funcId);

		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
			supplierId => '',
			key => ''
		));

		$condition=array(
			array('SupplierId',"%$arrGet[supplierId]%", 'like'),
			//array('Supplier.compName',"%$arr[key]%", 'like'),
			array('ruKuDate', "$arrGet[dateFrom]", '>='),
			array('ruKuDate', "$arrGet[dateTo]", '<='),
			array('tag', $rukuTag)
		);

		$rowset = $this->_modelRukuPeisha->findAll($condition, 'ruKuDate desc');
		$modelWare = FLEA::getSingleton('Model_JiChu_Ware');
		$rowsetCopy = array();		//把rowset及附属表中的数据重新提取出来.
		$i = 0;
		$cntCount = 0;
		foreach ($rowset as & $value) {
			$rowSupplier = $modelSupplier->find($value["supplierId"]);
			if (count($value["Wares"]) > 0) {
				foreach ($value["Wares"] as & $item) {
					$rowsetCopy[$i]["ruKuNum"] = $value["ruKuNum"];
					$rowsetCopy[$i]["supplierName"] = $rowSupplier["compName"];
					$rowsetCopy[$i]["ruKuDate"] = $value["ruKuDate"];
					$rowsetCopy[$i]["cnt"] = $item["cnt"];
					$cntCount += $item["cnt"];

					$rowWare = $modelWare->findByField("id", $item["wareId"]);

					if (count($rowWare) > 0) {
						$rowsetCopy[$i]["wareName"] = $rowWare["wareName"]."||".$rowWare["guige"];
						$rukuCount = $this->CountCnt("view_cangku_ruku", "supplierId = ".$value["supplierId"]." and wareId = ".$item["wareId"]);
						$chukuCount = $this->CountCnt("cangku_chuku2ware", "supplierId = ".$value["supplierId"]." and wareId = ".$item["wareId"]);
						$rowsetCopy[$i]["yushu"] = $rukuCount - $chukuCount;
					}
					$i++;
				}
			}
		}

		//合计
		$rowsetCopy[$i][ruKuNum] ='<b>合计</b>';
		$rowsetCopy[$i][cnt] = "<b>".$cntCount."</b>";

		#对表头进行赋值
		$arrFieldInfo = array(
			"ruKuNum" =>"单号",
			"supplierName" =>$supplierName,
			"ruKuDate" =>"日期",
			"wareName" =>"纱支",
			"cnt" =>"数量",
			"yushu" =>"余数"
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', '坯纱入库报表');
		$smarty->assign('supplierName', $supplierName);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowsetCopy);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->display('TableList.tpl');
	}*/


	#返回坯纱入库单中指定客户和纱支的数量总数
	function CountCnt($tableName, $condition) {
		$modelChuku = & FLEA::getSingleton('Model_CangKu_ChuKu');
		$sqlRuku = "select sum(cnt) as countTotal from ".$tableName." where ".$condition;
		$rowRuku = $modelChuku->findBySql($sqlRuku);
		$countCnt = 0;
		foreach ($rowRuku as $value) {
			$countCnt =  $CountCnt+$value["countTotal"];
		}
		return $countCnt;
	}

#设置权限
	function _setFuncId() {
		$rukuTag = $this->_checkModel();

		if ($rukuTag == 1) {
			$this->readFuncId = 96;
			$this->addFuncId =98;
			$this->editFuncId =98;
			$this->delFuncId =98;
		}
		else{
			$this->readFuncId = 61;
			$this->addFuncId =62;
			$this->editFuncId =62;
			$this->delFuncId =62;
		}
	}

	function _checkModel() {
		if ($_GET[rukuTag]) {
			$_SESSION['rukuTag'] = $_GET[rukuTag];
			$this->rukuTag = $_SESSION['rukuTag'];
		}
		elseif ($_SESSION['rukuTag']) $this->rukuTag = $_SESSION['rukuTag'];

		return $this->rukuTag;
	}

	function actionIni(){
		$condition = array(
			'tag'=>1,
			array('ruKuDate','2009-05-13','<')
		);
		$this->_modelRukuPeisha->removeByConditions($condition);
	}

	//根据客户和坯纱规格得到产地列表
	function actionGetJsonChandi(){
		$sql = "select distinct(chandi) from view_cangku_ruku where supplierId='{$_GET['clientId']}' and wareId='{$_GET['wareId']}'";
		//echo $sql;
		echo json_encode($this->_modelRuku->findBySql($sql));
	}
	/**
	 * ps ：根据客户和坯纱规格得到产地列表（new）根据不同坯纱仓库和本厂坯纱仓库来分别显示
	 * Time：2017年10月23日 17:30:57
	 * @author zcc
	*/
	function actionGetJsonChandiNew(){
		if ($_GET['kind']=='0') {//加工类型 调取客户坯纱仓库
			$sql = "SELECT distinct(y.chandi) 
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.rukuId
			where 1 and x.kind = '{$_GET['kind']}' and x.supplierId='{$_GET['clientId']}' and y.wareId='{$_GET['wareId']}'";
		}elseif ($_GET['kind']=='1') {//当为调取本厂坯纱时 坯纱供应商即为 产地
			$sql = "SELECT distinct(y.chandi) 
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.rukuId
			where 1 and x.kind = '{$_GET['kind']}' and y.wareId='{$_GET['wareId']}'";
		}
		echo json_encode($this->_modelRuku->findBySql($sql));
	}
	//根据客户和坯纱规格得到批号列表
	function actionGetJsonPihao(){
		// $sql = "select distinct(pihao) from view_cangku_ruku where supplierId='{$_GET['clientId']}' and wareId='{$_GET['wareId']}'";
		if ($_GET['kind']=='0') {
			$sql = "SELECT pihao 
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId 
			where 1 and x.kind='{$_GET['kind']}' 
			and x.supplierId='{$_GET['clientId']}' 
			and y.wareId='{$_GET['wareId']}' 
			group by pihao";
		}elseif($_GET['kind']=='1'){
			$sql = "SELECT pihao 
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId 
			where 1 and x.kind='{$_GET['kind']}' 
			and y.wareId='{$_GET['wareId']}' 
			group by pihao";
		}
		echo json_encode($this->_modelRuku->findBySql($sql));
	}

	//根据客户+坯纱规格+批号来确定产地列表
	function actionGetJsonChandiByPihao()
	{
		$sql = "SELECT distinct(chandi)
				FROM cangku_ruku y
				INNER JOIN cangku_ruku2ware x ON x.ruKuId = y.id
				WHERE y.supplierId='{$_GET['clientId']}' and x.wareId = '{$_GET['wareId']}' and x.pihao ='{$_GET['pihao']}'
		";
		if ($_GET['kind']=='1') {
			$sql = "SELECT distinct(chandi)
				FROM cangku_ruku y
				INNER JOIN cangku_ruku2ware x ON x.ruKuId = y.id
				WHERE y.kind='{$_GET['kind']}' and x.wareId = '{$_GET['wareId']}' and x.pihao ='{$_GET['pihao']}'
		";
		}
		echo json_encode($this->_modelRuku->findBySql($sql));
	}

	function actionGetKucun(){
		//by zcc 客户要求 获取的库存 也要算上下了生产计划的 一旦下了生产计划 库存就会相应的减少 2017年10月13日
		//算法为：库存 = 入库 - 计划已领用(出库) - 计划未领用(计划数-出库). 
		//客户都是计划多少出库多少 就是 为 库存 = 入库- 计划数
		//获取入库数据
		$sql = "SELECT sum(cnt) as rukuCnt
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId 
			where 1 and x.supplierId='{$_GET['clientId']}' and y.wareId='{$_GET['wareId']}' and y.pihao='{$_GET['pihao']}' ";
		$rukucnt = $this->_modelRuku->findBySql($sql);
		//获取计划已领用(出库)数据
		$sql = "SELECT sum(cnt) as chukuCnt
			FROM cangku_chuku2ware 
			where supplierId='{$_GET['clientId']}' and wareId='{$_GET['wareId']}' and pihao='{$_GET['pihao']}'";
		$chukuCnt = $this->_modelRuku->findBySql($sql);
		//计划数
		$sql = "SELECT sum(x.cntKg) as cnt  
			FROM trade_dye_order2ware x
			left join trade_dye_order y on x.orderId = y.id
			where 1 and y.clientId='{$_GET['clientId']}' and x.wareId='{$_GET['wareId']}' and x.pihao='{$_GET['pihao']}'";
		$planCnt = $this->_modelRuku->findBySql($sql);
		$kucun = round($rukucnt[0]['rukuCnt']-$planCnt[0]['cnt']);	
		echo json_encode(array('kucun'=>$kucun));
	}
	//ajax 判断pihao是否重复
	function actionGetIsCheck(){
		$sql = "SELECT count(*) as counts FROM cangku_ruku2ware where pihao = '{$_GET['pihao']}'";
		$ruku = $this->_modelRuku->findBySql($sql);
		if ($ruku[0]['counts']>=1) {
			echo json_encode(array('isCheck'=>1));
		}else{
			echo json_encode(array('isCheck'=>0));
		}
		
	}
	/**
	 * ps ：获取批号 自动完成
	 * Time：2017-09-28 14:27:29
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionGetpihaoByAjax(){
		$sql = "select id,pihao from cangku_ruku2ware where pihao like '%{$_GET['q']}%'  GROUP BY pihao"; 
		$jsonCode = $this->_modelRuku->findBySql($sql);
		$arr=array();
		foreach ($jsonCode as $key => & $v) {
			$arr[]=array($v['pihao'],$v);
		}
		echo json_encode($arr);
	}
}
?>