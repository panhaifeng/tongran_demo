<?php
/**
 * 染色车间(筒染用)控制器
 */
FLEA::loadClass('TMIS_Controller');
class Controller_Chejian_Zhuangchulong extends Tmis_Controller {
	var $_modelExample;
	var $funcId=49;
	var $tn;
	function Controller_Chejian_Zhuangchulong() {
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelExample = & FLEA::getSingleton('Model_Chejian_ZhuangchulongChanliang');
		$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$this->_modelGang->enableLink('ZhuangchulongChanliang');
		$this->tn=$this->_modelExample->tableName;
		$this->_modelWareDj = & FLEA::getSingleton('Model_JiChu_WareDanjia');
		$this->typeDanjia = 'danjiaZcl';
		$this->_modelWages = & FLEA::getSingleton('Model_CaiWu_Wages');
	}

	//列出已登记的产量。
	function actionRight(){
		FLEA::loadClass('TMIS_Pager');
		$this->_modelExample->enableLink('VatView');
		$arr = TMIS_Pager::getParamArray(array(
			//ym=>'',
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			workerCode=>'',
			vatNum=>'',
			'banci'=>'',
			'isHuixiu'=>'',
			'isChulong'=>''
		));
		$condition=array();
		if($arr['dateFrom']!='')$condition[]=array('dateInput',$arr['dateFrom'],'>=');
		if($arr['dateTo']!='')$condition[]=array('dateInput',$arr['dateTo'],'<=');
		if($arr[workerCode]!='') $condition[] = array('workerCode',"%{$arr[workerCode]}%",'like');
		if($arr['isChulong']!='') $condition[] = array('isChulong',$arr['isChulong'],'=');
		if($arr[vatNum]!='') $condition[] = array('Vat.vatNum',"%{$arr['vatNum']}%",'like');
			if($arr['banci']!='') {
			$banci=$arr['banci']=='甲'?0:1;
			$condition[] = array('banci',$banci,'=');
		
		}
		if($arr['isHuixiu']!='') {
			$condition[] = array('isHuixiu',$arr['isHuixiu'],'=');
		}
		$pager = new TMIS_Pager($this->_modelExample,$condition);
		$rowset = $pager->findAll();

		foreach($rowset as &$v) {
			//$v[vatNum] = $v[Vat][vatNum];
			$v['VatView']['vatNum']=$this->_modelGang->setVatNum($v['VatView']['gangId'],$v['VatView']['order2wareId']);
			$v['VatView']['orderCode']=$this->_modelOrder->getOrderTrack($v['VatView'][orderId],$v['VatView']['orderCode']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['VatView']['orderId']));
			if($clientCode['orderCode2']!='') $v['VatView']['compName']=$v['VatView']['compName'].'('.$clientCode['orderCode2'].')';
			$con = array("gangId='$v[gangId]'");
			$gang = $this->_modelGang->findAllGang1($con);
			if(count($gang)>0) $v = array_merge($v,$gang[0]);
			$arrGang=$this->_modelGang->find(array('id'=>$v['gangId']));
			$str="select sum(cntK) as cntK from $this->tn where gangId='{$v['gangId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			if($arrGang['zclOver']==1&&$arrGang['cntPlanTouliao']>$re['cntK'])$v['_edit']="<a href='".$this->_url('CancelOver',array('id'=>$v['gangId']))."'>取消完成</a>  ";
			//已经过账的不能修改删除
			$checkGz = $this->_modelWages->find(array('chanliangId'=>$v['id']));
			if($checkGz){
				$v['_edit'] .= "已审核不能操作";
			}else{
				$v['_edit'].=$this->getEditHtml($v['id']).'  '.$this->getRemoveHtml($v['id']);
			}


			$v['guige'] = $v['VatView']['wareName'] .' '.$v['VatView']['guige'];
			$v['banci']=$v['banci']=='0'?'甲':'乙';
			$v['isHuixiu']=$v['isHuixiu']=='0'?'否':'是';
			$v['biaoji']=$v['Vat']['cntPlanTouliao']<=$v['cntK']?'完成':'未完成';
			$v['isChulong'] = $v['isChulong'] ? "出笼" : "装笼";


			//dump($v);exit;

		}
		$heji=$this->getHeji($rowset,array('cntK'),'dateInput');
		$rowset[]=$heji;
		$search_item1 = "工号:<input name=worderCode value='$_POST[worderCode]'>";
		$search_item2 = " 年月(如2008-01):<input name='ym' value='$_POST[ym]'>";
		$search_item3 = " 缸号:<input name='vatNum' value='$_POST[vatNum]'>";
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateInput=>'日期',
			'VatView.compName'=>"客户(客户单号)",
			'VatView.orderCode'=>"订单号",
			'VatView.vatNum'=>"缸号",
			'guige'=>"纱支",
			'VatView.color'=>"颜色",
			'banci'=>'班次',
			'isHuixiu'=>'是否回修',
            'biaoji'=>'标记完成',
			'workerCode'=>'工号',
            'Vat.cntPlanTouliao' =>'投料数',
			'cntTongzi'=>'筒子数',
			'isChulong'=>'类型',
			'cntK'=>'公斤数',
			'_edit'=>'操作'
		));
		/*$smarty->assign('arr_edit_info',array(
			"edit" =>"修改",
			"remove" =>"删除"
		));*/
               // dump($rowset);
		$smarty->assign('title','装出笼产量查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		$smarty->assign('search_item',$search_item1.$search_item2.$search_item3);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display('TableList.tpl');
	}
	function actionCancelOver(){
		$kk=array(
				'id'=>$_GET['id'],
				'zclOver'=>0
		);
		$this->_modelGang->save($kk);
		redirect($this->_url('chanliangList'));
	}
	#未完成查询
	function actionNotwanchen(){
		FLEA::loadClass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			ym=>'',
			worderCode=>'',
			vatNum=>''
		));
		$sql="SELECT x.*,y.cntPlanTouliao,y.order2wareId,z.compName,z.orderId,z.orderCode,z.vatNum,z.guige,z.wareName,z.color
				FROM `dye_zcl_chanliang` x
				LEFT JOIN plan_dye_gang y ON x.gangId = y.id
				LEFT JOIN view_dye_gang z ON x.gangId = z.gangId
				WHERE x.cntTongzi =0 and z.planDate>='".date('Y-m-d',strtotime('-30 day'))."' and z.planDate<='".date('Y-m-d')."'";
		if($arr[ym]!='') $sql.=" and x.dateInput like '%{$arr['ym']}%'";
		if($arr[worderCode]!='')  $sql.=" and x.worderCode like '%{$arr['worderCode']}%'";
		if($arr[vatNum]!='')  $sql.=" and z.vatNum like '%{$arr['vatNum']}%'";
		// dump($sql);
		$pager = & new TMIS_Pager($sql);
		$rowset=$pager->findAll();
		foreach($rowset as &$v) {
			$v['vatNum']=$this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$v['guige'] = $v['wareName'].' ' .$v['guige'];
		}
		//dump($rowset);
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateInput=>'日期',
			'compName'=>"客户(客户单号)",
			'orderCode'=>"订单号",
			'vatNum'=>"缸号",
			'guige'=>"纱支",
			'color'=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数',
		));
		$smarty->assign('arr_edit_info',array(
			"edit" =>"修改",
			"remove" =>"删除"
		));
		$smarty->assign('title','装出笼未完成产量查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		//$smarty->assign('search_item',$search_item1.$search_item2.$search_item3);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display('TableList.tpl');
	}
	//产量列表
	function actionChanliangList() {
		$this->actionRight();
	}

	//登记染色产量第一步，列出所有的缸号明细
	function actionChanliangInput1() {
		$mClient = & FLEA::getSingleton('Model_Jichu_Client');
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'orderCode'=>'',
			'vatNum'=>''
		));

		$sql = "select x.*,x.id as gangId,
		z.orderCode,z.orderCode2,z.clientId,
		w.wareName,w.guige,
		y.color,y.colorNum,y.orderId,y.wareId
		from plan_dye_gang x
		left join trade_dye_order2ware y on x.order2wareId=y.id
		left join trade_dye_order z on y.orderId = z.id
		left join jichu_ware w on y.wareId=w.id
		where x.zclOver=0";
		if($arr['orderCode']!='') {
			$sql .= " and z.orderCode like '%{$arr['orderCode']}%'";
		}
		if($arr['vatNum']!='') {
			$sql .= " and x.vatNum like '%{$arr['vatNum']}%'";
		}
		$sql .= " order by x.id desc";
		$pager= new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		// $condition=array();
		// if($arr[orderCode]!='') $condition[] = "orderCode like '%$arr[orderCode]%'";
		// if($arr[vatNum]!='') $condition[] = "vatNum like '%$arr[vatNum]%'";
		// $condition[]="zclOver=0";
  		//$condition[]="cntTongzi is null";
		// $pager=null;
		// $rowset=$this->_modelGang->findAllGang2($this->tn,$condition,$pager);
		if(count($rowset)>0) foreach($rowset as & $v) {
			$client = $mClient->find(array('id'=>$v['clientId']));
			$v['compName'] = $client['compName'].($v['orderCode2']?"({$v['orderCode2']})":'');
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v[orderCode]);
			//公斤产量
			$sql = "select sum(cntK) as cntK from dye_zcl_chanliang where gangId='{$v['gangId']}'";
			$_temp = $this->_modelOrder->findBySql($sql);
			$v['cntK'] = $_temp[0]['cntK'];
			if($v['cntK']>0)$v['_edit']="<a href='".$this->_url('SetOver',array('id'=>$v['gangId']))."'>设置完成</a> | ";
			$v[_edit].= "<a href='".$this->_url('ChanliangInput2',array(
				gangId => $v[gangId]
			))."'>单缸录入</a>"." | "."<a href='".$this->_url('ChanliangInputList',array('orderId'=>$v['orderId']))."'>整单录入</a>";
			$v['guige'] = $v['wareName'] . ' '.$v['guige'];
		}
		//dump($rowset[0]);exit;
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			"compName" => "客户(客户单号)",
			"orderCode" => "订单号",
			"vatNum" =>"缸号",
			"guige" => "纱织规格",
			"color" =>"颜色",
			"cntPlanTouliao" =>"计划投料",
			"planTongzi" =>"计划筒数",
			"unitKg" =>"定重",
			'cntK'=>'公斤数产量',
			//"chanliang"=>"产出筒子数",//显示在做车台，并用颜色表示完成情况
			"_edit" => '操作'
		));
		$smarty->assign('title','装出笼产量录入');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('ChanliangInput1')));
		$smarty->display('TableList.tpl');
	}
	#设置完成
	function actionSetOver(){
		$kk=array(
				'id'=>$_GET['id'],
				'zclOver'=>1
		);
		$this->_modelGang->save($kk);
		redirect($this->_url('ChanliangInput1'));
	}
    //根剧订单号登记订单号下所有松筒产量
    function actionChanliangInputList()
	{
	  $orderId=$_GET['orderId'];
	  $condition=array();
	  $condition[]="orderId=$orderId";
	  $pager=null;
	  $arr=$this->_modelGang->findAllGang1($condition,$pager);
	  //$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
	  //dump($arr[0]);
	  if(count($arr)>0)
		{
		  foreach($arr as $key=>& $v)
			{
				$v['Gang']= $this->_modelGang->find($v['gangId']);
                //$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
				$v['Client'] = $this->_modelGang->getClient($v['Gang']['id']);
				$v['Ware'] = $this->_modelGang->getWare($v['Gang']['id']);
			}
		}
      //dump($arr);exit;
	  $smarty=$this->_getView();
	  $smarty->assign('aRow',$arr);
	  $smarty->display('Chejian/ZclChanliangListEdit.tpl');
	}
	//登记染色产量第二步，根据选择的缸号登记产量
	function actionChanliangInput2() {
		if($_GET[gangId]!="") {
			//新增产量
			$arr = array();
			$arr[Gang] = $this->_modelGang->find($_GET[gangId]);
			$arr[Client] = $this->_modelGang->getClient($arr[Gang][id]);
			$arr[Ware] = $this->_modelGang->getWare($arr[Gang][id]);
			$arr[Ware] = $this->_modelGang->getWare($arr[Gang][id]);
			$wareDanjia = $this->_modelWareDj->findByField('wareId',$arr['Ware']['id']);
			$arr['danjia'] = $wareDanjia[$this->typeDanjia];
			//dump($arr);
		} elseif($_GET[id]!="") {
			//修改产量
		}

		$smarty = $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Chejian/ZclChanliangEdit.tpl');
	}

	//保存产量
	function actionSaveChanliang() {
		//dump($_POST);exit;
		$arr = & $_POST;
		$arr['money'] = $arr['danjia']*$arr['cntK'];
		$arr[dateInput] = date("Y-m-d");

		$this->_modelExample->save($arr);
		#判断输入的产量是否大于计划投料数
		// $arrGang=$this->_modelGang->find(array('id'=>$arr['gangId']));  //因为用户希望当标记完成时才会隐藏所以此功能注释
		// $str="select sum(cntK) as cntK from $this->tn where gangId='{$arr['gangId']}'";
		// $re=mysql_fetch_assoc(mysql_query($str));
		//dump($re['cntK']);dump($arrGang);
		//当标记完成时才会隐藏
		if($arr['isCom']){                             //$re['cntK']>=$arrGang['cntPlanTouliao']
			$kk=array(
				'id'=>$arr['gangId'],
				'zclOver'=>1
			);
		}
		else{
			$kk=array(
                'id'=>$arr['gangId'],
				'zclOver'=>0
			);
		}
			$this->_modelGang->save($kk);
		
		js_alert('保存成功!','',$this->_url('chanliangInput1'));
	}

	 //保存整个订单产量
    function actionSaveChanliangList()
	{
		$arrys=$_POST;
		$check=$_POST['check'];
		//dump($_POST);exit;
		for($i=0;$i<count($_POST['gangId']);$i++)
		{
			if(isset($check[$i]))
			{
				if(empty($_POST['cntTongzi'][$i])) continue;
				$arr=array(
					'gangId'=>$arrys['gangId'][$i],
					'dateInput'=>date("Y-m-d"),
					'netWeight'=>$arrys['netWeight'][$i],
					'workerCode'=>$arrys['workerCode'][$i],
					'cntTongzi'=>$arrys['cntTongzi'][$i],
					'cntK'=>$arrys['cntK'][$i]
					);
				$this->_modelExample->save($arr);
				#判断输入的产量是否大于计划投料数
				$arrGang=$this->_modelGang->find(array('id'=>$arrys['gangId'][$i]));
				$str="select sum(cntK) as cntK from $this->tn where gangId='{$arrys['gangId'][$i]}'";
				$re=mysql_fetch_assoc(mysql_query($str));
				if($re['cntK']>=$arrGang['cntPlanTouliao']){
					$kk=array(
						'id'=>$arrys['gangId'][$i],
						'zclOver'=>1
					);
					$this->_modelGang->save($kk);
				}
			}
		}
		//dump($arr);exit;
		redirect($this->_url('chanliangInput1'));
	}
	function actionRemove(){
		$rr=$this->_modelExample->find(array('id'=>$_GET['id']));
		$this->_modelExample->removeByPkv($_GET['id']);
		$arrGang=$this->_modelGang->find(array('id'=>$rr['gangId']));
		$str="select sum(cntK) as cntK from $this->tn where gangId='{$rr['gangId']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		//dump($re['cntK']);dump($arrGang);
		if($re['cntK']<=$arrGang['cntPlanTouliao']){
			$kk=array(
				'id'=>$rr['gangId'],
				'zclOver'=>0
			);
			$this->_modelGang->save($kk);
		}
		redirect($this->_url('chanliangList'));
	}
	//日报表
	function actionChanliangDayReport(){
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'banci'=>'',
			'isHuixiu'=>'',
			'isChulong'=>'',
			'vatNum' =>''
		));
		$condition=array(
			array('dateInput',$arr['dateFrom'],'>='),
			array('dateInput',$arr['dateTo'],'<='),
			
		);
		if($arr['banci']!=''){
			$banci=$arr['banci']=='甲'?'0':'1';
            $condition[]= array('banci',$banci,'=');
		}
		if($arr['isHuixiu']!=''){
		    $condition[]= array('isHuixiu',$arr['isHuixiu'],'=');
		}
        if($arr['isChulong']!='')
        	$condition[]= array('isChulong',$arr['isChulong'],'=');
        if($arr['vatNum']!='')
        	$condition[]= array('Vat.vatNum',"%{$arr['vatNum']}%",'like');
		$rowset = $this->_modelExample->findAll($condition,'id desc');

		foreach($rowset as &$v) {
			$v['vatNum'] = $v['Vat']['vatNum'];
			$con = array("gangId='$v[gangId]'");
			$gang = $this->_modelGang->findAllGang1($con);
			if ($gang[0]) $v = array_merge($v,$gang[0]);
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v[orderCode]);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$v['vatNum'] = $this->_modelGang->setVatNum($v['Vat']['id'],$v['Vat']['order2wareId']);
			$v['guige'] = $v['wareName'] . ' '.$v['guige'];
			$v['banci'] = $v['banci']=='0'?'甲':'乙';
			$v['isHuixiu'] = $v['isHuixiu']=='0'?'否':'是';
			$v['isChulong'] = $v['isChulong'] ? '出笼' : '装笼';
		}
		$heji = $this->getHeji($rowset,array('cntTongzi','cntK'),'dateInput');
		$rowset[] = $heji;

		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'		=>'日期',
			'compName'		=>"客户(客户单号)",
			'orderCode'		=>"订单号",
			'vatNum'		=>"缸号",
			'guige'			=>"纱支",
			'color'			=>"颜色",
			'banci'			=>"班次",
			'isHuixiu'		=>"是否回修",
			'isChulong'     =>'类型',
			'workerCode'	=>'工号',
			'cntK'          =>"公斤数",
			//'netWeight'		=>'净重',
			'cntTongzi'		=>'筒子数',
			//'dt'			=>'录入时间',
		));

		$smarty->assign('title','装出笼产量日报表');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		$smarty->display('TableList.tpl');
	}

	//修改产量
	function actionEdit() {
		$arr=$this->_modelExample->find($_GET[id]);
		$arr[Gang] = $this->_modelGang->find($arr[gangId]);
		$arr[Client] = $this->_modelGang->getClient($arr[gangId]);
		$arr[Ware] = $this->_modelGang->getWare($arr[gangId]);
		$wareDanjia = $this->_modelWareDj->findByField('wareId',$arr['Ware']['id']);
		$arr['danjia'] = $wareDanjia[$this->typeDanjia];
		//dump($arr);
		$smarty = $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Chejian/ZclChanliangEdit.tpl');
	}
	#由gangId取得已经登记的产量
	function actionGetCntByGangId(){
		$str="select sum(cntK) as cntK from $this->tn where 1";
		if($_GET['gangId']!='')$str.=" and gangId='{$_GET['gangId']}'";
		if($_GET['id']!='')$str.=" and id<>'{$_GET['id']}'";
		$str.=" group by gangId";
		$re=mysql_fetch_assoc(mysql_query($str));
		$arr['cntK']=$re['cntK']+0;
		$arr['id']=$_GET['id'];
		echo json_encode($arr);exit;
	}
}
?>