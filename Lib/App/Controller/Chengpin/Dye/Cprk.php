<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chengpin_Dye_Cprk extends Tmis_Controller {
    var $_modelExample;
    var $funcId;
    function Controller_Chengpin_Dye_Cprk() {
	$this->leftCaption = '筒染成品';
	$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
	$this->_modelExample = & FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
	$this->_modelClient = & FLEA::getSingleton('Model_JiChu_Client');
	$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
	$this->_viewgang= & FLEA::getSingleton('Model_Plan_Dye_ViewGang');//Model_Plan_Dye_ViewGang
    }

    #列表
    function actionRight() {
    //$this->funcId = 71;				//成品-入库-查询


	$this->authCheck($this->funcId);

	$table = $this->_modelExample->tableName;
	FLEA::loadClass('TMIS_Pager');
	$arr = TMIS_Pager::getParamArray(array(
	    'dateFrom'=>date("Y-m-d"),
	    'dateTo'=>date("Y-m-d"),
	    'clientId'=>0,
	    'vatNum'=>'',
	    'orderCode'=>''
	));

	/*$condition=array(
	    array('dateCprk',$arr[dateFrom],'>='),
	    array('dateCprk',$arr[dateTo],'<=')
	);
	if($arr['vatNum']!='') $condition[]=array('Plan.vatNum',"%$arr[vatNum]%",'like');*/
	//if($arr['orderCode']!='') $condition[]=array('orderCode','%$arr[orderCode]%','like');
	//dump($condition);
	/*$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');
	$rowset = $pager->findAll();*/
	$str="select x.*,y.vatNum,y.cntPlanTouliao,y.planTongzi,y.planDate,y.unitKg,z.compName,z.order2wareId,z.orderCode,z.orderCode2
	    from chengpin_dye_cprk x
	    left join plan_dye_gang y on y.id=x.planId
	    left join view_dye_gang z on z.gangId=y.id
	    where 1
	    ";
	if($arr[dateFrom]!=''&&$arr[dateTo]!='') $str.=" and x.dateCprk>='$arr[dateFrom]' and x.dateCprk<='$arr[dateTo]'";
	if($arr['vatNum']!='') $str.=" and y.vatNum like '%$arr[vatNum]%'";
	if($arr['clientId']!=0) $str.=" and z.clientId='$arr[clientId]'";
	if($arr['orderCode']!=0) $str.=" and z.orderCode like '%$arr[orderCode]%'";
	$str.=" order by x.id desc";
	$pager = new TMIS_Pager($str);
	$rowset = $pager->findAllBySql($str);

	//dump($rowset);
	$modelOrder2Ware = &FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
	foreach ($rowset as & $value) {
	//dump($rowOrder2Ware);
	    //dump($value);
	    /*$value[vatNum] = $value[Plan][vatNum];
	    $value[cntPlanTouliao] = $value[Plan][cntPlanTouliao];
	    $value[planTongzi] = $value[Plan][planTongzi];
	    $value[planDate] = $value[Plan][planDate];
	    $value[unitKg] = $value[Plan][unitKg];
	    $value[vatCode] = $value[Plan][vatId];
	    $r=$this->_viewgang->findAll(array('order2wareId'=>$value['Plan']['order2wareId']));
	    //dump($r);
	    $value['compName']=$r[0]['compName'];
	    $rowOrder2Ware = $modelOrder2Ware->findByField('id', $value[Plan][order2wareId]);
	    $value[orderCode] = $this->_modelOrder->getOrderTrack($rowOrder2Ware[Order][id],$rowOrder2Ware[Order][orderCode]);*/
	    $rowOrder2Ware = $modelOrder2Ware->findByField('id', $value[order2wareId]);
	    //dump($rowOrder2Ware);
	    $value[color] = $rowOrder2Ware[color];
	    $value[guige] = $rowOrder2Ware[Ware][wareName]." ".$rowOrder2Ware[Ware][guige];
	    //得到客户单号
	    if($value['orderCode2']!='') $value['compName']=$value['compName'].'('.$value['orderCode2'].')';
	   	$arrGang=$this->_modelGang->find(array('id'=>$value['planId']));
	   	// dump($arrGang);die();
	    if ($arrGang['isCpRuku']==1) {
	    	$value['_edit'] ="<a href='".$this->_url('CancelOver',array('id'=>$value['planId']))."'>取消完成  |</a>  ";
	    }
	    $value['_edit'] .="<a href='".$this->_url('edit',array('id'=>$value['id'],))."'>修改</a>" . ' ' . $this->getRemoveHtml($value['id']);
	}
	//dump($rowset);
	//exit;
	$smarty = & $this->_getView();
	$arrFieldInfo = array(
	    "dateCprk" =>"入库日期",
	    "vatNum" =>"缸号",
	    "planDate" =>"计划日期",
	    "orderCode" =>"订单号",
	    'compName' => '客户(客户单号)',
	    "guige" =>"纱支",
	    "color" =>"颜色",
	    "cntPlanTouliao" =>"投料",
	    "planTongzi" =>"计划筒数",
	    //"vatCode" =>"物理缸号",
	    "color" =>"颜色",
	    "jingKg"=>"净重",
	    "cntJian"=>"件数",
	    "cntTongzi"=>"筒子数",
	    '_edit' =>'操作',

	);
	// $arr_edit_info = array(
	//     "edit" =>"修改",
	//     "remove" =>"删除"
	// );
	$smarty->assign('title','筒染成品入库');
	$smarty->assign('arr_edit_info',$arr_edit_info);
	$smarty->assign('arr_field_info',$arrFieldInfo);
	$smarty->assign('arr_field_value',$rowset);
	$smarty->assign('add_display', 'none');
	$smarty->assign('arr_condition',$arr);
	$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
	$smarty->display('TableList.tpl');
    }

    function _edit($Arr, $ArrProductList=null) {
	$this->funcId = 73;				//成品-入库-增加修改
	$this->authCheck($this->funcId);

	$smarty = & $this->_getView();
	$smarty->assign("title",'成品入库编辑');
	$smarty->assign("arr_field_value",$Arr);
	$smarty->display('Chengpin/Dye/CprkEdit.tpl');
    }

    //取得新的成品入库单号
    function _getNewCprkCode() {
	$arr=$this->_modelExample->find(null,'cprkCode desc','cprkCode');
	$max = $arr[cprkCode];
	$temp = date("ym")."001";
	if ($temp>$max) return $temp;
	$a = substr($max,-3)+1001;
	return substr($max,0,-3).substr($a,1);
    }

    #增加界面
    function actionAdd() {
	if($_GET[gangId]>0) {
	    $arr=array(
		Plan=>$this->_modelGang->find($_GET[gangId])
	    );
	}
	$this->_edit($arr);
    }

    #修改界面
    function actionEdit() {
    //if (!$this->_editable($_GET[id])) js_alert('该入库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
	$arr_field_value=$this->_modelExample->find($_GET[id]);
	$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
	$arr = $model->find($arr_field_value[planId]);
	$arr_field_value[isCpRuku] = $arr[isCpRuku];
	$this->_edit($arr_field_value);
    }
    #保存
    function actionSave() {
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr = $model->find("vatNum='$_POST[vatNum]'");
		$_POST[planId] = $arr[id];
		//标记完成 字段填入数据库 
		$isCpRuku = $_POST['isCpRuku']?1:0;
		$sql = "UPDATE plan_dye_gang set isCpRuku = '{$isCpRuku}' where id ='{$_POST['planId']}'";
		$this->_modelExample->execute($sql);

		$cprkId = $this->_modelExample->save($_POST);
		redirect($this->_url('right'));
	    //js_alert('入库成功','window.close();window.opener.history.go()');
    }

    //成品入库向导模式
    //第一步:列出计划单
    function actionAddGuide () {
	$this->authCheck(71);

	//显示某客户下已计划的缸，和计划投料数,计划筒子数,输入净重，筒子数，和件数,需要把计划投料数copy到出库表中
	//作为应收款凭据。
	FLEA::loadClass('TMIS_Pager');
	//TMIS_Pager::clearCondition();
	$arr = TMIS_Pager::getParamArray(array(
	    dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
	    dateTo => date("Y-m-d"),
	    clientId=>'',
	    vatNum=>'',
	    orderCode=>'',
	    'isOverRk' =>'',
	));
	/*$condition=array(
	    "planDate>='$arr[dateFrom]'",
	    "planDate<='$arr[dateTo]'"
	);
	if($arr['clientId']!='') $condition[]="clientId='$arr[clientId]'";
	if ($arr[orderCode]!='') $condition[]="orderCode like '%$arr[orderCode]%'";
	if ($arr[vatNum]!='') $condition[] ="vatNum like '%$arr[vatNum]%'";*/
	$str="SELECT x.*,p.isCpRuku
		from view_dye_gang x
	    left join plan_dye_gang p on p.id = x.gangId
	     where 1";
	if($arr[dateFrom]!=''&&$arr[dateTo]!='') $str.=" and x.planDate>='$arr[dateFrom]' and x.planDate<='$arr[dateTo]'";
	if($arr['clientId']!='') $str.=" and x.clientId='$arr[clientId]'";
	if ($arr[orderCode]!='') $str.="and x.orderCode like '%$arr[orderCode]%'";
	if ($arr[vatNum]!='') $str.="and x.vatNum like '%$arr[vatNum]%'";
	if ($arr[isOverRk]=='1') {
		$str.="and p.isCpRuku = 1";
	}else{
		$str.="and p.isCpRuku = 0";
	}
	//2013-6-18 by jeff,回修的缸不需要进行入库
	// $str .= " and x.parentGangId=0";
	$str.=" order by x.gangId desc ";

	$pager = & new TMIS_pager($str);
	$rowset =$pager->findAll();
	//求总计
	$str="SELECT x.* from view_dye_gang x
	     left join plan_dye_gang p on p.id = x.gangId
	     where 1";
	if($arr[dateFrom]!=''&&$arr[dateTo]!='') $str.=" and x.planDate>='$arr[dateFrom]' and x.planDate<='$arr[dateTo]'";
	if($arr['clientId']!='') $str.=" and x.clientId='$arr[clientId]'";
	if ($arr[orderCode]!='') $str.="and x.orderCode like '%$arr[orderCode]%'";
	if ($arr[vatNum]!='') $str.="and x.vatNum like '%$arr[vatNum]%'";
	if ($arr[isOverRk]=='1') {
		$str.="and p.isCpRuku = 1";
	}else{
		$str.="and p.isCpRuku = 0";
	}
	$str.=" order by x.gangId desc";
	$row=$this->_viewgang->findBySql($str);
	//dump($row);
	$heji=$this->getHeji($row, array('cntPlanTouliao','planTongzi'),'planDate');
	$heji['planDate']='总计';
	//dump($heji);
	//echo $str;
	//dump($rowset);
	/*$pager=null;
	$rowset=$this->_modelGang->findAllGang1($condition,$pager);*/
	if(count($rowset)>0) foreach($rowset as & $v) {
		$v[guige]=$v[wareName]." ".$v[guige];
		//$v[jingKg] = "<input name='jingKg' id='jingKg' size=6 style='width:50' onBlur='aa(this)'>";
		//$v[cntTongzi] = "<input name='cntTongzi' id='cntTongzi' style='width:50' onBlur='aa(this)'>";
		//$v[cntJian] = "<input name='cntJian' id='cntJian' size=6 style='width:50' onBlur='aa(this)'>";
		//$v[_edit]= "<input type=button value='入库' disabled='true' name='btnCk' onclick='subm($v[gangId],this)'>";
		$v[cntRuku] = $this->_modelGang->getCprkChanliang($v['gangId']);
		//公斤产量
		$sql = "select count(*) as cout from chengpin_dye_cprk where planId='{$v['gangId']}'";
		$_temp = $this->_modelOrder->findBySql($sql);
		if ($_temp[0]['cout']>=1) {
			$v['_edit']="<a href='".$this->_url('SetOver',array('id'=>$v['gangId']))."'>设置完成</a> | ";
		}
		$v[_edit].="<a href='".$this->_url('AddRuku',array(
		    'orderId'=>$v['orderId'],
		    'order2wareId' =>$v['order2wareId'],
		    'gangId' =>$v['gangId'],
		    'TB_iframe'=>'1',
		    'width'=>900,
		    'height'=>550
		    ))."' class='thickbox'>入库</a>";
		if ($v['isCpRuku']=='1') {
			$v['_edit'] = "<a href='".$this->_url('CancelOver',array('id'=>$v['gangId'],'function'=>$_GET['action']))."' onclick='return confirm(\"您确认要操作吗?\")'>取消完成入库</a>";
		}


		// $v[_edit].="<a href='".$this->_url('AddGuide1',array(
		//     'orderId'=>$v['orderId'],
		//     'order2wareId' =>$v['order2wareId'],
		//     'gangId' =>$v['gangId'],
		//     'TB_iframe'=>'1',
		//     'width'=>900,
		//     'height'=>550
		//     ))."' class='thickbox'>入库</a>";
		//得到客户单号
		$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
		if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
		//dump($clientCode);
	    }
	$rowset[]=$heji;
	//dump($rowset);exit;
	$arr_field_info = array(
	    planDate => '计划日期',
	    vatNum => '缸号',
	    orderCode => '订单号',
	    compName => '客户(客户单号)',
	    guige => '纱支',
	    color => '颜色',
	    colorNum => '色号',
	    cntPlanTouliao => '计划投料',
	    planTongzi => '计划筒子数',
	    cntRuku => '已入库(个)',
	    //jingKg=>'净重',
	    //cntTongzi=>'筒子数',
	    //cntJian=>'件数',
	    //cntOut => '已入库',
	    _edit => '操作'
	);
	$smarty = & $this->_getView();
	$smarty->assign('成品入库登记',$title);
	$smarty->assign("arr_field_info",$arr_field_info);
	$smarty->assign('arr_field_value',$rowset);
	//$smarty->assign('add_display', 'none');
	$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','thickbox')));
	$smarty->assign('page_info',$pager->getNavBar($this->_url('addGuide',$arr)));
	$smarty->assign('arr_condition',$arr);
	//$smarty->display('Chengpin/Dye/CprkList.tpl');
	$smarty->display('TableList2.tpl');
    }

    //成品入库向导模式
    //第二步:列出该订单下所有的缸号,并输入入库数据
    //取消
    function actionAddGuide1 () {
	$condition = array(
	    array('OrdWare.orderId',$_GET[orderId])
	);
	$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
	$mCprk = & FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
	$mHuidao = & FLEA::getSingleton('Model_Chejian_HuidaoChanliang');
	$pager = null;
	$rowset = $m->findAllGang($condition,$pager,100);
	//dump($condition);
	//取得已经入库的值
	foreach($rowset as & $v){
		#回倒
		$huidao=$mHuidao->find(array('gangId'=>$v['id']));
		$v['cntTongzi1']=$huidao['cntTongzi'];
	    $cprk=$mCprk->findAll(array('planId'=>$v[id]));
	    $mm=0;
	    $mm=count($cprk)-1;
	    //dump($cprk[$mm]['cntTongzi']);
	    if($cprk){
		/*$cntTongzi=0;
		$jingKg=0;
		$cntJian=0;
		foreach($cprk as & $vv){
		    //dump($vv);
		    $cntTongzi+=$vv['cntTongzi'];
		    $jingKg+=$vv['jingKg'];
		    $cntJian+=$vv['cntJian'];
		}
		$v['cntTongzi']=$cntTongzi;
		$v['jingKg']=$jingKg;
		$v['cntJian']=$cntJian;*/
		$v['cntTongzi']=$cprk[$mm]['cntTongzi'];
		$v['jingKg']=$cprk[$mm]['jingKg'];
		$v['maoKg']=$cprk[$mm]['maoKg'];
		$v['cntJian']=$cprk[$mm]['cntJian'];
		$v['isShow']=true;
	    }else{
		$v['isShow']=false;
	    }
	    //dump($cprk);
	}
	$smarty = & $this->_getView();
	$smarty->assign('rows',$rowset);
	//$smarty->assign('page_info',$pager->getNavBar($this->_url('addGuide')));
	$smarty->display('Chengpin/Dye/CprkList1.tpl');
    }

    //成品入库向导模式
    //第三步:保存入库数据
    function actionSaveGuide () {
	$p = $_POST;
	//dump($p);exit;
	for($i=0;$i<count($_POST[gangId]);$i++) {
	    if(empty($p[jingKg][$i])||empty($p[cntJian][$i])||empty($p[cntTongzi][$i])) continue;
	    $arr = array(
		dateCprk => date("Y-m-d"),
		planId => $p[gangId][$i],
		jingKg => $p[jingKg][$i],
		maoKg => $p[maoKg][$i], //新增毛重字段 by zcc
		cntJian => $p[cntJian][$i],
		cntTongzi => $p[cntTongzi][$i]
	    );
	    $this->_modelExample->save($arr);
	}
	js_alert('','parent.tb_remove();',$this->_url('AddGuide'));
    }


    //删除
    function actionRemove() {
		$this->funcId = 73;				//成品-入库-删除
		$this->authCheck($this->funcId);
		if (!$this->_editable($_GET[id])) js_alert('该入库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
		else {
			//删除前 解除完成入库标记
			$cprk = $this->_modelExample->find($_GET[id]);
			$gangId = $cprk['planId'];
			if ($gangId) {
				$sql = "UPDATE plan_dye_gang SET isCpRuku = 0 WHERE id={$gangId};";
				$this->_modelExample->execute($sql);
			}
			parent::actionRemove();
		}
    }

    //判断id=$pkv的入库单是否允许被修改或删除,
    function _editable($pkv) {
	return true;
    }

    function actionGetJsonByVatNum() {
	$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
	$arr = $model->find("vatNum='$_GET[vatNum]'");
	echo json_encode($arr);
    }
    /**
     * ps ：成品入库登记（新）ps:根据每一个订单明细来进行登记 会存在一个数据多次入库的问题
     * Time：2017年11月13日 14:45:44
     * @author zcc
    */
    function actionAddRuku(){
	    $condition = array(
		    array('id',$_GET['gangId'])
		);
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mCprk = & FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
		$mHuidao = & FLEA::getSingleton('Model_Chejian_HuidaoChanliang');
		$rowset = $m->find($condition);
		//获取客户名称
		$sql = "SELECT x.*,y.orderCode
			FROM jichu_client x 
			left join trade_dye_order y on x.id = y.clientId
			where y.id = '{$_GET['orderId']}'";
		$client = $this->_modelExample->findBySql($sql);
		$sql = "SELECT * 
			FROM trade_dye_order2ware x 
			left join jichu_ware y on x.wareId = y.id 
			where x.id = {$_GET['order2wareId']}";
		$ware = $this->_modelExample->findBySql($sql);	
		// dump($client);die();
		$rowset['wareName'] = $ware[0]['wareName'];
		$rowset['guige'] = $ware[0]['guige'];
		$rowset['clientName'] = $client[0]['compName'];
		$rowset['orderCode'] = $client[0]['orderCode'];
		$huidao=$mHuidao->find(array('gangId'=>$rowset['id']));
		$rowset['cntTongzi1']=$huidao['cntTongzi'];
		$cprk=$mCprk->findAll(array('planId'=>$rowset[id]));
		// dump($cprk);die();
		$mm=0;
		$mm=count($cprk)-1;
		if($cprk){
			$v['cntTongzi']=$cprk[$mm]['cntTongzi'];
			$v['jingKg']=$cprk[$mm]['jingKg'];
			$v['cntJian']=$cprk[$mm]['cntJian'];
			$v['isShow']=true;
		}else{
			$v['isShow']=false;
		}	
		// dump($rowset);die();
		$smarty = & $this->_getView();
		$smarty->assign('aRow',$rowset);
		$smarty->display('Cangku/Ruku/RukuEdit.tpl');
    }
    /**
     * ps ：成品入库登记保存(不是修改保存)
     * Time：2017年11月13日 16:16:40
     * @author zcc
    */
    function actionSaveAdd(){
		$p = $_POST;
		if(empty($p[jingKg])||empty($p[cntJian])||empty($p[cntTongzi])) continue;
		$row = array(
			'dateCprk' => date("Y-m-d"),
			'planId' => $_POST['gangId'],
			'maoKg' => $_POST['maoKg'],
			'jingKg' => $_POST['jingKg'],
			'cntTongzi' => $_POST['cntTongzi'],
			'cntJian' => $_POST['cntJian'],

		);
		$isCpRuku = $_POST['isCpRuku']?1:0;
		$sql = "UPDATE plan_dye_gang set isCpRuku = '{$isCpRuku}' where id ='{$_POST['gangId']}'";
		$this->_modelExample->execute($sql);
		$this->_modelExample->save($row);
		// js_alert('','parent.tb_remove();',$this->_url('AddGuide'));
		js_alert('保存成功!','window.parent.location.href="'.$this->_url('AddGuide').'"');
		die();
    }
    //设置完成
	function actionSetOver(){
		$kk=array(
				'id'=>$_GET['id'],
				'isCpRuku'=>1
		);
		$this->_modelGang->save($kk);
		redirect($this->_url('addGuide'));
	}
	//取消完成
	function actionCancelOver(){
		$kk=array(
				'id'=>$_GET['id'],
				'isCpRuku'=>0
		);
		$this->_modelGang->save($kk);
		if ($_GET['function']) {
			redirect($this->_url($_GET['function']));
		}else{
			redirect($this->_url('right'));
		}
		
	}
	/**
	 * ps ：成品入库日报表
	 * Time：2017年11月17日
	 * @author zcc
	*/
	function actionDayReport(){
		$this->authCheck($this->funcId);
		$table = $this->_modelExample->tableName;
		FLEA::loadClass('TMIS_Pager');

		$arr = TMIS_Pager::getParamArray(array(
		    'dateFrom'=>date("Y-m-d"),
		    'dateTo'=>date("Y-m-d"),
		    'clientId'=>0,
		    'vatNum'=>'',
		    'orderCode'=>'',
		    'orderKind'=>'',
		));
		$str="SELECT x.*,y.vatNum,y.cntPlanTouliao,y.planTongzi,y.planDate,y.unitKg,y.parentGangId,
				z.compName,z.order2wareId,z.orderCode,z.orderCode2,o.kind as orderKind,y.id as gangId
		    from chengpin_dye_cprk x
		    left join plan_dye_gang y on y.id=x.planId
		    left join view_dye_gang z on z.gangId=y.id
		    left join trade_dye_order o on o.id = z.orderId
		    where 1
		    ";
		if($arr[dateFrom]!=''&&$arr[dateTo]!='') $str.=" and x.dateCprk>='$arr[dateFrom]' and x.dateCprk<='$arr[dateTo]'";
		if($arr['vatNum']!='') $str.=" and y.vatNum like '%$arr[vatNum]%'";
		if($arr['clientId']!=0) $str.=" and z.clientId='$arr[clientId]'";
		if($arr['orderCode']!=0) $str.=" and z.orderCode like '%$arr[orderCode]%'";
		if($arr['orderKind']!='') $str.=" and o.kind = '$arr[orderKind]'";
		$str.=" order by x.dateCprk desc,x.id desc";
		$sql = "SELECT * FROM($str) a where 1";//页码条数显示有问题 重新包装下
		$pager = new TMIS_Pager($sql);
		$rowset = $pager->findAllBySql($sql);
		// dump();die();
		$rowsetAll = $this->_modelExample->findBySql($sql);
		$modelOrder2Ware = &FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		foreach ($rowset as & $value) {
		    $rowOrder2Ware = $modelOrder2Ware->findByField('id', $value[order2wareId]);
		    //dump($rowOrder2Ware);
		    $value[color] = $rowOrder2Ware[color];
		    $value[guige] = $rowOrder2Ware[Ware][wareName]." ".$rowOrder2Ware[Ware][guige];
		    $value[zhelvMx] = $rowOrder2Ware[zhelvMx];
		    //得到客户单号
		    if($value['orderCode2']!='') $value['compName']=$value['compName'].'('.$value['orderCode2'].')';
		   	$arrGang=$this->_modelGang->find(array('id'=>$value['planId']));
		   	$value['cntPlanTouliao2'] = $value['cntPlanTouliao'];
		   	//回修的缸号 和 多次入库的缸号 投料数 不进行叠加到合计和总计
		   	
		   	if ($value['parentGangId']>0) {
		   		$value['cntPlanTouliao2'] = '';
		   	}
		   	//获取这个入库的 第一条数据
			$sql = "SELECT * 
				FROM chengpin_dye_cprk  
				where planId= '{$value['gangId']}' order by id asc limit 0,1";
			$cpck = $this->_modelExample->findBySql($sql);
			if ($cpck[0]['id'] != $value['id']) {//当本条数据不等于第一条出库数据时
				$value['cntPlanTouliao2'] = ''; //让金额为空数据
			}
            $value['jiliangZ'] = round($value['jingKg']/(1-$value['zhelvMx']),3);

		}
		foreach ($rowsetAll as & $va) {
			$va['cntPlanTouliao2'] = $va['cntPlanTouliao'];
		   	//回修的缸号 和 多次入库的缸号 投料数 不进行叠加到合计和总计
		   	if ($va['parentGangId']>0) {
		   		$va['cntPlanTouliao2'] = '';
		   	}
		   	//获取这个入库的 第一条数据
			$sql = "SELECT * 
				FROM chengpin_dye_cprk  
				where planId= '{$va['gangId']}' order by id asc limit 0,1";
			$cpck = $this->_modelExample->findBySql($sql);
			if ($cpck[0]['id'] != $va['id']) {//当本条数据不等于第一条出库数据时
				$va['cntPlanTouliao2'] = ''; //让金额为空数据
			}
			$rowOrder2Ware = $modelOrder2Ware->findByField('id', $value[order2wareId]);
			$va['zhelvMx'] = $rowOrder2Ware['zhelvMx'];
			$va['jiliangZ'] = round($va['jingKg']/(1-$va['zhelvMx']),3);
		}
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','cntPlanTouliao2','jiliangZ','planTongzi','jingKg','maoKg'),'dateCprk');
		$heji['cntPlanTouliao'] = $heji['cntPlanTouliao2'];
		$zongji = $this->getHeji($rowsetAll,array('cntPlanTouliao','cntPlanTouliao2','jiliangZ','planTongzi','jingKg','maoKg'),'dateCprk');
		$zongji['cntPlanTouliao'] = $zongji['cntPlanTouliao2'];
		$rowset[] =  $heji;
		$zongji['dateCprk'] = '<b>总计</b>';
		$rowset[] =  $zongji;
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
		    "dateCprk" =>"入库日期",
		    "vatNum" =>"缸号",
		    "planDate" =>"计划日期",
		    "orderCode" =>"订单号",
		    'compName' => '客户(客户单号)',
		    "guige" =>"纱支",
		    "color" =>"颜色",
		    "cntPlanTouliao" =>"投料",
		   
		    "planTongzi" =>"计划筒数",
		    "maoKg"=>"毛重",
		    //"vatCode" =>"物理缸号",
		    // "color" =>"颜色",
		    "jingKg"=>"净重",
		    "jiliangZ"=>"计价重",
		    "cntJian"=>"件数",
		    "cntTongzi"=>"筒子数",

		);
		$smarty->assign('title','筒染成品入库日报表');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList.tpl');
	}
}
?>