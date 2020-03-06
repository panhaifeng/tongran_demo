<?php
/**
 * 松筒车间(筒染用)控制器
 */
FLEA::loadClass('TMIS_Controller');
class Controller_Chejian_Songtong extends Tmis_Controller {
	var $_modelExample;
	var $funcId=49;
	var $tn='';
	function Controller_Chejian_Songtong() {
		$this->_modelExample = & FLEA::getSingleton('Model_Chejian_SongtongChanliang');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$this->tn =$this->_modelExample->tableName;
		$this->view = & FLEA::getSingleton('Model_Plan_Dye_ViewGang');
		$this->_modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$this->_modelWareDj = & FLEA::getSingleton('Model_JiChu_WareDanjia');
		$this->typeDanjia = 'danjiaSt';
		$this->_modelWages = & FLEA::getSingleton('Model_CaiWu_Wages');
	}

	//列出已登记的产量。
	function actionRight(){
		FLEA::loadClass('TMIS_Pager');
		//dump($this->view);exit;
		$this->_modelExample->enableLink('VatView');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'orderCode'=>'',
			'vatNum'=>'',
			'banci'=>'',
			'workerCode'=>''
		));
		//if($arr[ym]!='') $condition[] = array('dateInput',$arr[ym].'-__','like');

		//总计sql
		$sql = "select sum(cntK) as cntK from dye_st_chanliang where 1";

		if($arr['dateFrom']!='') {
			$condition[]=array('dateInput',$arr['dateFrom'],'>=');
			$sql.= " and dateInput>='{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!='') {
			$condition[]=array('dateInput',$arr['dateTo'],'<=');
			$sql.= " and dateInput<='{$arr['dateTo']}'";
		}
		if($arr['workerCode']!='') {
			$condition[] = array('workerCode',"%{$arr[workerCode]}%",'like');
			// $sql.= " and workerCode like '%{$arr['workerCode']}%'";
		}
		if($arr['orderCode']!='') {
			$condition[] = array('VatView.orderCode',"%{$arr[orderCode]}%",'like');
			// $sql.= " and dateInput like '%{$arr['workerCode']}%'";
		}
		if($arr['vatNum']!='') {
			$condition[] = array('VatView.vatNum',"%{$arr[vatNum]}%",'like');
			// $sql.= " and dateInput like '%{$arr['workerCode']}%'";
		}
		if($arr['banci']!='') {
			$condition[] = array('banci',$arr['banci'],'=');
			$sql.= " and banci ='{$arr['banci']}'";
		}
		$zongji = $this->_modelExample->findBySql($sql);
		$tKg = $zongji[0]['cntK'];
		// dump($sql);exit;
		$pager = new TMIS_Pager($this->_modelExample,$condition);
		$rowset = $pager->findAll();
		//$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
		//dump($rowset[0]);exit;
        //$tableName=$this->_modelExample->tableName;
		foreach($rowset as &$v) {
			$sql = "SELECT * FROM jichu_vehicle where id ='{$v['carId']}'";
			$car = $this->_modelExample->findBySql($sql);
			$v['carinfo'] = $car[0]['carCode'];
			// dump($v);exit;
			$v['VatView']['vatNum']=$this->_modelGang->setVatNum($v['VatView']['gangId'],$v['VatView']['order2wareId']);
			$v['VatView']['orderCode']=$this->_modelOrder->getOrderTrack($v['VatView'][orderId],$v['VatView']['orderCode']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['VatView']['orderId']));
			if($clientCode['orderCode2']!='') $v['VatView']['compName']=$v['VatView']['compName'].'('.$clientCode['orderCode2'].')';
			//dump($v);
			$arrGang=$this->_modelGang->find(array('id'=>$v['gangId']));
			$str="select sum(cntK) as cntK from $this->tn where gangId='{$v['gangId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			if($arrGang['stOver']==1&&$arrGang['cntPlanTouliao']>$re['cntK'])$v['_edit']="<a href='".$this->_url('CancelOver',array('id'=>$v['gangId']))."'>取消完成</a>  ";

			$checkGz = $this->_modelWages->find(array('chanliangId'=>$v['id']));
			if($checkGz){
				$v['_edit'] .= "已审核不能操作";
			}else{
				$v['_edit'].=$this->getEditHtml($v['id']).'  '.$this->getRemoveHtml($v['id']);
			}

			$v['isHuixiu'] = $v['isHuixiu']?'是':'否';
			$v['guige'] = $v['VatView']['wareName'] . ' ' .$v['VatView']['guige'];
		}
		//dump($rowset[0]);
		//$this->_modelExample
		$heji=$this->getHeji($rowset,array('cntK','netWeight','cntTongzi'),'dateInput');
		$rowset[]=$heji;
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'		=>'日期',
			'VatView.compName'		=>"客户(客户单号)",
			'VatView.orderCode'		=>"订单号",
			'VatView.vatNum'		=>"缸号",
			'guige'			=>"纱支",
			'VatView.color'			=>"颜色",
			'banci'	=>'班次',
			'isHuixiu'	=>'是否回修',
			'workerCode'	=>'工号',
            'Vat.cntPlanTouliao' =>'投料数',
			// 'netWeight'		=>'净重',
			'cntTongzi'		=>'筒子数',
			'cntK'		=>'公斤数',
			'carinfo' =>'车辆',
			'_edit'=>'操作'
			//'dt'			=>'录入时间'
		));
		$search_item1 = "工号:<input name=worderCode value='$_POST[worderCode]'>";
		$search_item2 = " 年月(如2008-01):<input name='ym' value='$_POST[ym]'>";
		$search_item3 = " 缸号:<input name='vatNum' value='$_POST[vatNum]'>";
		/*$smarty->assign('arr_edit_info',array(
			"edit" =>"修改",
			"remove" =>"删除"
		));*/
                //dump($rowset);
		$smarty->assign('title','松筒产量查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		$smarty->assign('search_item',$search_item1.$search_item2.$search_item3);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action']))."<font color='red'>本时间段内产量总计：{$tKg} Kg</font>");
		$smarty->display('TableList.tpl');
	}
	function actionCancelOver(){
		$kk=array(
				'id'=>$_GET['id'],
				'stOver'=>0
		);
		$this->_modelGang->save($kk);
		redirect($this->_url('chanliangList'));
	}
	function actionNotwanchen(){
		FLEA::loadClass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			workerCode=>'',
			vatNum=>'',
			orderCode=>''
		));
		$sql="SELECT x.*,y.cntPlanTouliao,y.order2wareId,z.compName,z.orderCode,z.vatNum,z.wareName,z.guige,z.color
				FROM `dye_st_chanliang` x
				LEFT JOIN plan_dye_gang y ON x.gangId = y.id
				LEFT JOIN view_dye_gang z ON x.gangId = z.gangId
				WHERE x.cntTongzi =0 and z.planDate>='".date('Y-m-d',strtotime('-30 day'))."' and z.planDate<='".date('Y-m-d')."'";
		if($arr[workerCode]!='') $sql.=" and x.workerCode like '%{$arr['workerCode']}%'";
		if($arr[orderCode]!='')  $sql.=" and z.orderCode like '%{$arr['orderCode']}%'";
		if($arr[vatNum]!='')  $sql.=" and z.vatNum like '%{$arr['vatNum']}%'";
		//echo $sql;
		$pager = & new TMIS_Pager($sql);
		$rowset=$pager->findAll();
		//dump($rowset);
		foreach($rowset as &$v) {
			$v['vatNum']=$this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);
			$v['VatView']['orderCode']=$this->_modelOrder->getOrderTrack($v['VatView'][orderId],$v['VatView']['orderCode']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['VatView']['orderId']));
			if($clientCode['orderCode2']!='') $v['VatView']['compName']=$v['VatView']['compName'].'('.$clientCode['orderCode2'].')';
			$v['guige'] = $v['wareName'] . ' ' .$v['guige'];
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'		=>'日期',
			'compName'		=>"客户(客户单号)",
			'orderCode'		=>"订单号",
			'vatNum'		=>"缸号",
			'guige'			=>"纱支",
			'color'			=>"颜色",
			'workerCode'	=>'工号',
			'netWeight'		=>'净重',
			'cntTongzi'		=>'筒子数',
			//'dt'			=>'录入时间'
		));
		$smarty->assign('arr_edit_info',array(
			"edit" =>"修改",
			"remove" =>"删除"
		));
		$smarty->assign('title','松筒产量未完成查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		$smarty->assign('search_item',$search_item1.$search_item2.$search_item3);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display('TableList.tpl');
	}
	//产量列表
	function actionChanliangList() {
		$this->actionRight();
	}

	//登记松筒产量第一步，列出所有的缸号明细
	function actionChanliangInput1() {
		$mClient = & FLEA::getSingleton('Model_Jichu_Client');
		FLEA::loadClass('TMIS_Pager');
		//$this->_modelExample->enableLink('VatView');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'orderCode'=>'',
			'vatNum'=>'',
			'clientId'=>0,
			'zhishu'=>''
		));

		$sql = "select x.*,x.id as gangId,
		z.orderCode,z.orderCode2,z.clientId,
		w.wareName,w.guige,
		y.color,y.colorNum,y.orderId,y.wareId
		from plan_dye_gang x
		left join trade_dye_order2ware y on x.order2wareId=y.id
		left join trade_dye_order z on y.orderId = z.id
		left join jichu_ware w on y.wareId=w.id
		where x.stOver=0";
		if($arr['orderCode']!='') {
			$sql .= " and z.orderCode like '%{$arr['orderCode']}%'";
		}
		if($arr['vatNum']!='') {
			$sql .= " and x.vatNum like '%{$arr['vatNum']}%'";
		}
		if($arr['clientId']>0) {
			$sql .= " and z.clientId='{$arr['clientId']}'";
		}
		if($arr['zhishu']!='') {
			$sql .= " and (w.wareName like '%{$arr['zhishu']}%' or w.guige like '%{$arr['zhishu']}%')";
		}
		$sql .= " order by x.id desc";
		$pager= new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		if(count($rowset)>0) foreach($rowset as & $v) {
			$client = $mClient->find(array('id'=>$v['clientId']));
			$v['compName'] = $client['compName'].($v['orderCode2']?"({$v['orderCode2']})":'');
			// $v['vatNum']=$this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);
			// $v['guige'] = $v['guige'];
			//产量
			//$v['cntK'] = $this->_modelGang->getStChanliang($v['gangId']);

			$v['netWeight'] = $this->_modelGang->getStNetWeight($v['gangId']);
			// $v['guige'] = $v['wareName'] . ' ' . $v['guige'];
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v[orderCode]);

			//公斤产量
			$sql = "select sum(cntK) as cntK,sum(cntTongzi) as cntTongzi from dye_st_chanliang where gangId='{$v['gangId']}'";
			$_temp = $this->_modelOrder->findBySql($sql);
			$v['cntK'] = $_temp[0]['cntK'];
			$v['cntTongzi'] = $_temp[0]['cntTongzi'];
			//得到客户单号
			// $clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			// if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			if($v['cntK']>0)$v['_edit']="<a href='".$this->_url('SetOver',array('id'=>$v['gangId']))."'>设置完成</a> | ";
			$v['_edit'].= "<a href='".$this->_url('ChanliangInput2',array(
				'gangId' => $v['gangId'],
				'cntk'=>$v['cntK'],//已有产量
				'cntTongzi'=>$v['cntTongzi']//已有筒子数
			))."'>单缸录入</a>"." | "."<a href='".$this->_url('ChanliangInputList',array('orderId'=>$v['orderId']))."'>整单录入</a>";
			$v['guige'] = $v['wareName'] . ' '.$v['guige'];
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			"compName" => "客户(客户单号)",
			"orderCode" =>"订单号",
			"vatNum" =>"缸号",
			"guige" => "纱织规格",
			"color" =>"颜色",
			"cntPlanTouliao" =>"计划投料",
			"planTongzi" =>"计划筒子数",
			"unitKg" =>"定重",
			"netWeight"=>'净重',
			'cntK'=>'产量(kg)',
	        //'dt'=>'录入时间',
			"cntTongzi"=>"产出筒子数",//显示在做车台，并用颜色表示完成情况
			"_edit" => '操作'
		));
		$smarty->assign('title','松筒产量录入');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('ChanliangInput1',$arr)));
		$smarty->display('TableList.tpl');
	}
	#设置完成
	function actionSetOver(){
		$kk=array(
				'id'=>$_GET['id'],
				'stOver'=>1
		);
		$this->_modelGang->save($kk);
		redirect($this->_url('ChanliangInput1'));
	}
	//登记松筒产量第二步，根据选择的缸号登记产量
	function actionChanliangInput2() {
		if($_GET[gangId]!="") {
			//新增产量
			$arr = array();
			$arr[Gang] = $this->_modelGang->find($_GET[gangId]);
			$arr[Client] = $this->_modelGang->getClient($arr[Gang][id]);
			$arr[Ware] = $this->_modelGang->getWare($arr[Gang][id]);
			$wareDanjia = $this->_modelWareDj->findByField('wareId',$arr['Ware']['id']);
			$arr['danjia'] = $wareDanjia[$this->typeDanjia];
			// dump($arr);die;
		} elseif($_GET[id]!="") {
			//修改产量
		}

		$smarty = $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Chejian/StChanliangEdit.tpl');
	}
    //根剧订单号登记订单号下所有松筒产量
    function actionChanliangInputList()
	{
	  $orderId=$_GET['orderId'];
	  $condition=array();
	  $condition[]="orderId=$orderId";
	  $pager=null;
	  $arr=$this->_modelGang->findAllGang1($condition,$pager);
	  //dump($arr[0]);exit;
	  if(count($arr)>0)
		{
		  foreach($arr as $key=>& $v)
			{
			    //echo($key);
			    //echo($v['gangId'].'</br>');
				$v['Gang']= $this->_modelGang->find($v['gangId']);
                //$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
				//dump($v);
				$v['Client'] = $this->_modelGang->getClient($v['Gang']['id']);
				$v['Ware'] = $this->_modelGang->getWare($v['Gang']['id']);
			}
		}
      //dump($arr);exit;
	  $smarty=$this->_getView();
	  $smarty->assign('aRow',$arr);
	  $smarty->display('Chejian/StChanliangListEdit.tpl');
	}
	//保存产量
	function actionSaveChanliang() {
		$arr =& $_POST;
		$arr['money'] = $arr['danjia']*$arr['cntK'];
		$arr['dateInput'] = date("Y-m-d");
		// dump($arr);die;
		$this->_modelExample->save($arr);
		#判断输入的产量是否大于计划投料数
		$arrGang=$this->_modelGang->find(array('id'=>$arr['gangId']));
		$str="select sum(cntK) as cntK from {$this->tn} where gangId='{$arr['gangId']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($arr['biaoji']){          //$re['cntK']>=$arrGang['cntPlanTouliao']
			$kk=array(
				'id'=>$arr['gangId'],
				'stOver'=>1
			);
		}
		else{
            $kk=array(
				'id'=>$arr['gangId'],
				'stOver'=>0
			);
		}
		$this->_modelGang->save($kk);
		redirect($this->_url($_POST['id']>0?'chanliangList':'chanliangInput1'));
	}
    //保存整个订单产量
    function actionSaveChanliangList()
	{
		$arrys=$_POST;
		$check=$_POST['check'];
		dump($_POST);exit;
		for($i=0;$i<count($_POST['gangId']);$i++)
		{
			if(isset($check[$i]))
			{
				if(empty($_POST['cntK'][$i])) continue;
				$arr=array(
					'gangId'=>$arrys['gangId'][$i],
					'dateInput'=>date("Y-m-d"),
					'netWeight'=>$arrys['netWeight'][$i],
					'workerCode'=>$arrys['workerCode'][$i],
					'cntTongzi'=>$arrys['cntTongzi'][$i],
					'cntK'=>$arrys['cntK'][$i],
					'carId'=>$arrys['carId'][$i],
					'people'=>$arrys['people'][$i]
					);
				$this->_modelExample->save($arr);
				#判断输入的产量是否大于计划投料数
				$arrGang=$this->_modelGang->find(array('id'=>$arrys['gangId'][$i]));
				$str="select sum(cntK) as cntK from $this->tn where gangId='{$arrys['gangId'][$i]}'";
				$re=mysql_fetch_assoc(mysql_query($str));
				if($re['cntK']>=$arrGang['cntPlanTouliao']){
					$kk=array(
						'id'=>$arrys['gangId'][$i],
						'stOver'=>1
					);
					$this->_modelGang->save($kk);
				}
			}
		}
		//dump($arr);exit;
		redirect($this->_url('chanliangInput1'));
		//js_alert('','window.history.go(-2)');
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
				'stOver'=>0
			);
			$this->_modelGang->save($kk);
		}
		redirect($this->_url('chanliangList'));
	}
	//日报表
	function actionChanliangDayReport(){
		set_time_limit(0);
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'banci'=>'',
			'isHuixiu'=>'',
			'vatNum' =>''
		));
		$condition=array(
			array('dateInput',$arr['dateFrom'],'>='),
			array('dateInput',$arr['dateTo'],'<='),
		);
		if($arr['banci']!='') {
			$banci=$arr['banci']=='甲'?0:1;
			$condition[] = array('banci',$arr['banci'],'=');
		}
		if($arr['isHuixiu']!='') {
			$condition[] = array('isHuixiu',$arr['isHuixiu'],'=');
		}
        if($arr['vatNum']!='') $condition[]= array('Vat.vatNum',"%{$arr['vatNum']}%",'like');
		$rowset = $this->_modelExample->findAll($condition);

		foreach($rowset as &$v) {
			
			//$v['vatNum'] = $v['Vat']['vatNum'];
			

			$con = array("gangId='$v[gangId]'");
			$gang = $this->_modelGang->findAllGang1($con);
			if ($gang[0]) $v = array_merge($v,$gang[0]);
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v[orderCode]);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$v['vatNum'] = $this->_modelGang->setVatNum($v['Vat']['id'],$v['Vat']['order2wareId']);

			$v['isHuixiu'] = $v['isHuixiu']?'是':'否';

			$v['guige'] = $v['wareName'] .' '.$v['guige'];
		}
		$heji = $this->getHeji($rowset,array('cntK', 'cntTongzi'),'dateInput');
		$rowset[] = $heji;

		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'		=>'日期',
			'compName'		=>"客户(客户单号)",
			'orderCode'		=>"订单号",
			'vatNum'		=>"缸号",
			'guige'			=>"纱支",
			'color'			=>"颜色",
			'banci'			=>'班次',
			'isHuixiu'		=>'是否回修',
			'workerCode'	=>'工号',
			'cntK'			=>'产量',
			'cntTongzi'		=>'筒子数',
			//'dt'			=>'录入时间',
		));

		$smarty->assign('title','松筒产量日报表');
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
		//获取车辆信息
		$sql = "SELECT * FROM jichu_vehicle where id ='{$arr['carId']}'";
		$car = $this->_modelExample->findBySql($sql);
		$string = $car[0]['people'];
		$people = explode(';', $string);
		$smarty = $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->assign('people',$people);
		$smarty->display('Chejian/StChanliangEdit.tpl');
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