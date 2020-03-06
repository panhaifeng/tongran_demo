<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chejian_Dabao extends Tmis_Controller {
	var $_modelExample;
	var $funcId=49;
	var $title = '打包产量管理';
	var $tn;
	function Controller_Chejian_Dabao() {
		$this->_modelExample = & FLEA::getSingleton('Model_Chejian_DabaoChanliang');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$this->tn= $this->_modelExample->tableName;
		$this->_modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$this->_modelWareDj = & FLEA::getSingleton('Model_JiChu_WareDanjia');
		$this->typeDanjia = 'danjiaDb';
		$this->_modelWages = & FLEA::getSingleton('Model_CaiWu_Wages');
	}

	//列出已登记的产量。
	function actionRight(){
		FLEA::loadClass('TMIS_Pager');
		$this->_modelExample->enableLink('VatView');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'banci'=>'',
			'workerCode'=>'',
			vatNum=>'',
		));
		$condition=array();
		if($arr['dateFrom']!='')$condition[]=array('dateInput',$arr['dateFrom'],'>=');
		if($arr['dateTo']!='')$condition[]=array('dateInput',$arr['dateTo'],'<=');
		if($arr[workerCode]!='') $condition[] = array('workerCode',"%{$arr[workerCode]}%",'like');
		if($arr[vatNum]!='') $condition[] = array('Vat.vatNum',"%$arr[vatNum]%", 'like');
		if($arr['banci']!='') {
			$condition[] = array('banci',$arr['banci'],'=');
			$sql.= " and banci ='{$arr['banci']}'";
		}
		/*else {
			if($arr[dateFrom]!='') {
				$condition[] = array('dateInput',$arr[dateFrom],'>=');
				$condition[] = array('dateInput',$arr[dateTo],'<=');
			}
		}*/
		//if($arr[orderCode]!='') $condition[] = array('workerCode',$arr[orderCode]);
		$pager = new TMIS_Pager($this->_modelExample,$condition);
		$rowset = $pager->findAll();
		//dump($rowset[0]);
		foreach($rowset as &$v) {
			$v[vatNum] = $v[Vat][vatNum];
			$con = array("gangId='$v[gangId]'");
			$gang = $this->_modelGang->findAllGang1($con);
			//dump($gang);exit;
			$v = array_merge($v,$gang[0]);
			//$v[_edit] = "<a href='".$this->_url()."'>$v[id]</a>";
		}
		foreach($rowset as &$v){
			$v['vatNum']=$this->_modelGang->setVatNum($v['VatView']['gangId'],$v['VatView']['order2wareId']);
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v['orderCode']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$arrGang=$this->_modelGang->find(array('id'=>$v['gangId']));
			$str="select sum(cntK) as cntK from $this->tn where gangId='{$v['gangId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			if($arrGang['dbOver']==1&&$arrGang['cntPlanTouliao']>$re['cntK'])$v['_edit']="<a href='".$this->_url('CancelOver',array('id'=>$v['gangId']))."'>取消完成</a>  ";

			//已经过账的不能修改删除
			$checkGz = $this->_modelWages->find(array('chanliangId'=>$v['id']));
			if($checkGz){
				$v['_edit'] .= "已审核不能操作";
			}else{
				$v['_edit'].=$this->getEditHtml($v['id']).'  '.$this->getRemoveHtml($v['id']);
			}

			$v['guige'] = $v['wareName'].' ' .$v['guige'];
		}
		$heji=$this->getHeji($rowset,array('cntK'),'dateInput');
		$rowset[]=$heji;
		//dump($rowset[0]);
		//$this->_modelExample
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'=>'日期',
			'dt'=>'录入时间',
			'compName'=>"客户(客户单号)",
			'orderCode'=>"订单号",
			'vatNum'=>"缸号",
			'guige'=>"纱支",
			'color'=>"颜色",
			'workerCode'=>'工号',
            'Vat.cntPlanTouliao' =>'投料数',
			'cntTongzi'=>'筒子数',
			'cntK'=>'公斤数',
			'banci'=>'班次',
			'_edit'=>'操作'
		));

		/*$smarty->assign('arr_edit_info',array(
			"edit" =>"修改",
			"remove" =>"删除"
		));*/
		$smarty->assign('title','回倒产量查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('search_item',$search_item1.$search_item2.$search_item3);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}
	function actionCancelOver(){
		$kk=array(
				'id'=>$_GET['id'],
				'dbOver'=>0
		);
		$this->_modelGang->save($kk);
		redirect($this->_url('chanliangList'));
	}
	#未完成查询
	function actionNotwanchen(){
		FLEA::loadClass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			vatNum=>''
		));
		$sql="SELECT x.*,y.cntPlanTouliao,y.order2wareId,z.compName,z.orderId,z.orderCode,z.vatNum,z.guige,z.wareName,z.color
				FROM `dye_db_chanliang` x
				LEFT JOIN plan_dye_gang y ON x.gangId = y.id
				LEFT JOIN view_dye_gang z ON x.gangId = z.gangId
				WHERE x.cntTongzi =0 and z.planDate>='".date('Y-m-d',strtotime('-30 day'))."' and z.planDate<='".date('Y-m-d')."'";
		if($arr[vatNum]!='')  $sql.=" and z.vatNum like '%{$arr['vatNum']}%'";
		$pager = & new TMIS_Pager($sql);
		$rowset=$pager->findAll();
		foreach($rowset as &$v){
			$v['vatNum']=$this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v['orderCode']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$v['guige'] = $v['wareName'] .' ' .$v['guige'];
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateInput=>'日期',
			dt=>'录入时间',
			compName=>"客户(客户单号)",
			orderCode=>"订单号",
			vatNum=>"缸号",
			guige=>"纱支",
			color=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数'
		));

		$smarty->assign('arr_edit_info',array(
			"edit" =>"修改",
			"remove" =>"删除"
		));
		$smarty->assign('title','回倒未完成产量查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}
	//产量列表
	function actionChanliangList() {
		$this->actionRight();
	}

	//登记打包产量第一步，列出所有的缸号明细
	function actionChanliangInput1() {
		$mClient = & FLEA::getSingleton('Model_Jichu_Client');
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'clientId'=>0,
			'orderCode'=>'',
			'vatNum'=>'',
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
		where x.dbOver=0";
		if($arr['orderCode']!='') {
			$sql .= " and z.orderCode like '%{$arr['orderCode']}%'";
		}
		if($arr['vatNum']!='') {
			$sql .= " and x.vatNum like '%{$arr['vatNum']}%'";
		}
		if($arr['clientId']>0) {
			$sql .= " and z.clientId='{$arr['orderCode']}'";
		}
		if($arr['zhishu']!='') {
			$sql .= " and (w.wareName like '%{$arr['zhishu']}%' or w.guige like '%{$arr['zhishu']}%')";
		}
		$sql .= " order by x.id desc";
		$pager= new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		// $condition=array();
		// if($arr[clientId]>0) $condition[] = "clientId='$arr[clientId]'";
		// if($arr[orderCode]!='') $condition[] = "orderCode like '%$arr[orderCode]%'";
		// if($arr[vatNum]!='') $condition[] = "vatNum like '%$arr[vatNum]%'";
		// if($arr['zhishu']!='') $condition[] = "guige like '%{$arr['zhishu']}%'";
		// $condition[]="dbOver=0";
		// $pager=null;
		// //dump($condition); exit;
		// $rowset=$this->_modelGang->findAllGang2($this->tn,$condition,$pager);
		if(count($rowset)>0) foreach($rowset as & $v) {
			$client = $mClient->find(array('id'=>$v['clientId']));
			$v['compName'] = $client['compName'].($v['orderCode2']?"({$v['orderCode2']})":'');
			//公斤产量
			$sql = "select sum(cntK) as cntK from dye_db_chanliang where gangId='{$v['gangId']}'";
			$_temp = $this->_modelOrder->findBySql($sql);
			$v['cntK'] = $_temp[0]['cntK'];
			// $v['vatNum']=$this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);
			// //状态
			// $v[chanliang] = $this->_modelGang->getDbChanliang($v[gangId]);
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v['orderCode']);
			// //得到客户单号
			// $clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			// if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			if($v['cntK']>0)$v['_edit']="<a href='".$this->_url('SetOver',array('id'=>$v['gangId']))."'>设置完成</a> | ";
			$v[_edit] .= "<a href='".$this->_url('ChanliangInput2',array(
				gangId => $v[gangId]
			))."'>单缸录入</a>"." | "."<a href='".$this->_url('ChanliangInputList',array('orderId'=>$v['orderId']))."'>整单录入</a>";
			$v['guige'] = $v['wareName'].' '.$v['guige'];
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			"compName" => "客户(客户单号)",
			"orderCode" => "订单号",
			"vatNum" =>"缸号",
			"guige" => "纱织规格",
			"color" =>"颜色",
			"cntPlanTouliao" =>"计划投料",
			"planTongzi" =>"计划筒子数",
			"unitKg" =>"定重",
			'cntK'=>'公斤数产量',
			//"chanliang"=>"产出筒子数",//显示在做车台，并用颜色表示完成情况
			"_edit" => '操作'
		));
		$smarty->assign('title','打包产量录入');
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
				'dbOver'=>1
		);
		$this->_modelGang->save($kk);
		redirect($this->_url('ChanliangInput1'));
	}
	//登记打包产量第二步，根据选择的缸号登记产量
	function actionChanliangInput2() {
		if($_GET[gangId]!="") {
			//新增产量
			$arr = array();
			$arr[Gang] = $this->_modelGang->find($_GET[gangId]);
			$arr[Client] = $this->_modelGang->getClient($arr[Gang][id]);
			$arr[Ware] = $this->_modelGang->getWare($arr[Gang][id]);
			$wareDanjia = $this->_modelWareDj->findByField('wareId',$arr['Ware']['id']);
			$arr['danjia'] = $wareDanjia[$this->typeDanjia];
			//dump($arr);
		} elseif($_GET[id]!="") {
			//修改产量
		}

		$smarty = $this->_getView();
		$smarty->assign('$title', '增加修改打包产量');
		$smarty->assign('aRow',$arr);
		$smarty->display('Chejian/DbChanliangEdit.tpl');
	}

	//保存产量
	function actionSaveChanliang() {
		//dump($_POST);exit;
		$arr = $_POST;
		$arr['money'] = $arr['danjia']*$arr['cntK'];
		$arr[dateInput] = date("Y-m-d");

		//dump($arr); exit;

		$this->_modelExample->save($arr);
		#判断输入的产量是否大于计划投料数
		$arrGang=$this->_modelGang->find(array('id'=>$arr['gangId']));
		$str="select sum(cntK) as cntK from $this->tn where gangId='{$arr['gangId']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		//dump($re['cntK']);dump($arrGang);
		if($re['cntK']>=$arrGang['cntPlanTouliao']){
			$kk=array(
				'id'=>$arr['gangId'],
				'dbOver'=>1
			);
			$this->_modelGang->save($kk);
		}
		redirect($this->_url('chanliangInput1'));
		//js_alert('保存成功!','window.history.go(-2)');
	}

	//日报表
	function actionChanliangDayReport(){
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'vatNum'=>''
		));
		$condition=array(
			array('dateInput',$arr['dateFrom'],'>='),
			array('dateInput',$arr['dateTo'],'<='),
		);
        if($arr['vatNum']!='') $condition[]= array('Vat.vatNum',"%{$arr['vatNum']}%",'like');
		$rowset = $this->_modelExample->findAll($condition);
        // dump($rowset);exit;
		foreach($rowset as &$v) {
			//$v['vatNum'] = $v['Vat']['vatNum'];
			$con = array("gangId='$v[gangId]'");
			$gang = $this->_modelGang->findAllGang1($con);
			if ($gang[0]) $v = array_merge($v,$gang[0]);
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v['orderCode']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$v['vatNum'] = $this->_modelGang->setVatNum($v['Vat']['id'],$v['Vat']['order2wareId']);
			$v['guige'] = $v['wareName'] .' '.$v['guige'];
		}
		$heji = $this->getHeji($rowset,array('cntTongzi'),'dateInput');
		$rowset[] = $heji;
		//$rowset[] = $heji;
		/*foreach($rowset as &$v){
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v['orderCode']);
		}*/
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'		=>'日期',
			'compName'		=>"客户(客户单号)",
			'orderCode'		=>"订单号",
			'vatNum'		=>"缸号",
			'guige'			=>"纱支",
			'color'			=>"颜色",
			'workerCode'	=>'工号',
			//'netWeight'		=>'净重',
			'cntTongzi'		=>'筒子数',
			//'dt'			=>'录入时间',
		));

		$smarty->assign('title','打包产量日报表');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps ：//筒染产量车间日报表
	 * Time：2016/09/01 15:07:16
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionChejianChanliangDayReport(){
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
		));
		$arr['dateFrom1']=explode('-', $arr['dateFrom']);
		$arr['dateFrom1']['2']='01';
		$arr['dateFrom1']=join('-',$arr['dateFrom1']);
		$str = "select sum(cntK) FROM"; 
		$str1 = " where banci = '甲'";//by zcc 甲班次的所对应的产量
		$str2 = " where banci = '乙'";//乙班次的所对应的产量
		$str3 = " where (banci = '甲' or banci = '乙') ";//累计为取1号到日期dateTo 的甲乙数据之和
		$str4 = " where banci = 0";//由于烘纱数据库结构为0（甲） 1（乙） 故采用这方法
		$str5 = " where banci = 1";//乙班次的所对应的产量
		$str6 = " where (banci = 0 or banci = 1) ";//累计为取1号到日期dateTo 的甲乙数据之和
		if($arr['dateFrom']!=''){
            $str1.=" and dateInput>='{$arr['dateFrom']}'";
            $str2.=" and dateInput>='{$arr['dateFrom']}'";
            $str3.=" and dateInput>='{$arr['dateFrom1']}'";
            $str4.=" and dateInput>='{$arr['dateFrom']}'";
            $str5.=" and dateInput>='{$arr['dateFrom']}'";
            $str6.=" and dateInput>='{$arr['dateFrom1']}'";
		}
        if($arr['dateTo']!=''){
           	$str1.=" and dateInput<='{$arr['dateTo']}'";
           	$str2.=" and dateInput<='{$arr['dateTo']}'";
           	$str3.=" and dateInput<='{$arr['dateTo']}'";
           	$str4.=" and dateInput<='{$arr['dateTo']}'";
           	$str5.=" and dateInput<='{$arr['dateTo']}'";
           	$str6.=" and dateInput<='{$arr['dateTo']}'";
        }
        // dump($rowset);exit;
        $gongxu = array('松筒','染色','烘纱','回倒','打包');
		foreach($gongxu as $k => $v) {
			$rowset[$k]['gongxu'] = $v; 
			if ($v=='松筒') {
				$sql = "select sum(cntK) as cntK FROM dye_st_chanliang ".$str1;
				$jia = $this->_modelExample->findBySql($sql);
				$rowset[$k]['jiaban'] = (int)$jia[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_st_chanliang ".$str2;
				$yi = $this->_modelExample->findBySql($sql);
				$rowset[$k]['yiban'] = (int)$yi[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_st_chanliang ".$str3;
				//dump($sql);exit();
				$leiji = $this->_modelExample->findBySql($sql);
				$rowset[$k]['leiji'] = (int)$leiji[0]['cntK'];
				$rowset[$k]['heji'] =(int)$jia[0]['cntK']+(int)$yi[0]['cntK'];
			}
			if ($v=='染色') {
				$sql = "select sum(cntK) as cntK FROM dye_rs_chanliang ".$str1;
				$jia = $this->_modelExample->findBySql($sql);
				$rowset[$k]['jiaban'] = (int)$jia[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_rs_chanliang ".$str2;
				$yi = $this->_modelExample->findBySql($sql);
				$rowset[$k]['yiban'] = (int)$yi[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_rs_chanliang ".$str3;
				$leiji = $this->_modelExample->findBySql($sql);
				$rowset[$k]['leiji'] = (int)$leiji[0]['cntK'];
				$rowset[$k]['heji'] =(int)$jia[0]['cntK']+(int)$yi[0]['cntK'];
			}
			if ($v=='烘纱') {
				$sql = "select sum(cntK) as cntK FROM dye_hs_chanliang ".$str4;
				$jia = $this->_modelExample->findBySql($sql);
				$rowset[$k]['jiaban'] = (int)$jia[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_hs_chanliang ".$str5;
				$yi = $this->_modelExample->findBySql($sql);
				$rowset[$k]['yiban'] = (int)$yi[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_hs_chanliang ".$str6;
				//dump($sql);exit();
				$leiji = $this->_modelExample->findBySql($sql);
				$rowset[$k]['leiji'] = (int)$leiji[0]['cntK'];
				$rowset[$k]['heji'] =(int)$jia[0]['cntK']+(int)$yi[0]['cntK'];
			}
			if ($v=='回倒') {
				$sql = "select sum(cntK) as cntK FROM dye_hd_chanliang ".$str1;
				$jia = $this->_modelExample->findBySql($sql);
				$rowset[$k]['jiaban'] = (int)$jia[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_hd_chanliang ".$str2;
				$yi = $this->_modelExample->findBySql($sql);
				$rowset[$k]['yiban'] = (int)$yi[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_hd_chanliang ".$str3;
				$leiji = $this->_modelExample->findBySql($sql);
				$rowset[$k]['leiji'] = (int)$leiji[0]['cntK'];
				$rowset[$k]['heji'] =(int)$jia[0]['cntK']+(int)$yi[0]['cntK'];
			}
			if ($v=='打包') {
				$sql = "select sum(cntK) as cntK FROM dye_db_chanliang ".$str1;
				$jia = $this->_modelExample->findBySql($sql);
				$rowset[$k]['jiaban'] = (int)$jia[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_db_chanliang ".$str2;
				$yi = $this->_modelExample->findBySql($sql);
				$rowset[$k]['yiban'] = (int)$yi[0]['cntK'];
				$sql = "select sum(cntK) as cntK FROM dye_db_chanliang ".$str3;
				$leiji = $this->_modelExample->findBySql($sql);
				$rowset[$k]['leiji'] = (int)$leiji[0]['cntK'];
				$rowset[$k]['heji'] =(int)$jia[0]['cntK']+(int)$yi[0]['cntK'];
			}
			

		}
		//dump($rowset);exit();
		$heji = $this->getHeji($rowset,array('jiaban','yiban','heji','leiji'),'gongxu');
		$rowset[] = $heji;
		//$rowset[] = $heji;
		/*foreach($rowset as &$v){
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v['orderCode']);
		}*/
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'gongxu'	=>'工序',
			'jiaban'	=>'甲班',
			'yiban'		=>'乙班',
			'heji'		=>'合计',
			'leiji'		=>'累计',

		));
		$smarty->assign('title','筒染车间生产日报表');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('url_daochu',  $this->_url('ChejianChanliangDayReport',array('export'=>1)));
		$smarty->assign('add_display','none');
		if ($_GET['export']==1) {
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/download");
			//header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", '内销收款查询').".xls");
			header("Content-Disposition: attachment;filename=筒染车间生产日报表.xls");
			header("Content-Transfer-Encoding: binary");
			$smarty->display('Export2Excel.tpl');
			exit();
		}
		$smarty->display('TableList.tpl');
	}
    //根剧订单号登记订单号下所有产量
    function actionChanliangInputList()
	{
	  $orderId=$_GET['orderId'];
	  $condition=array();
	  $condition[]="orderId=$orderId";
	  $pager=null;
	  $arr=$this->_modelGang->findAllGang1($condition,$pager);
	  //dump($arr[0]);
	  if(count($arr)>0)
		{
		  foreach($arr as $key=>& $v)
			{
			    //echo($key);
			    //echo($v['gangId'].'</br>');
				$v['Gang']= $this->_modelGang->find($v['gangId']);
                //$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
				$v['Client'] = $this->_modelGang->getClient($v['Gang']['id']);
				$v['Ware'] = $this->_modelGang->getWare($v['Gang']['id']);
			}
		}
      //dump($arr);exit;
	  $smarty=$this->_getView();
	  $smarty->assign('aRow',$arr);
	  $smarty->display('Chejian/DbChanliangListEdit.tpl');
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
				$arrGang=$this->_modelGang->find(array('id'=>$arr['gangId']));
				$str="select sum(cntK) as cntK from $this->tn where gangId='{$arr['gangId']}'";
				$re=mysql_fetch_assoc(mysql_query($str));
				//dump($re['cntK']);dump($arrGang);
				if($re['cntK']>=$arrGang['cntPlanTouliao']){
					$kk=array(
						'id'=>$arr['gangId'],
						'dbOver'=>1
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
				'dbOver'=>0
			);
			$this->_modelGang->save($kk);
		}
		redirect($this->_url('chanliangList'));
	}
	//修改产量
	function actionEdit() {
		$arr=$this->_modelExample->find($_GET[id]);
		$arr[Gang] = $this->_modelGang->find($arr[gangId]);
		$arr[Client] = $this->_modelGang->getClient($arr[gangId]);
		$arr[Ware] = $this->_modelGang->getWare($arr[gangId]);
		$wareDanjia = $this->_modelWareDj->findByField('wareId',$arr['Ware']['id']);
		$arr['danjia'] = $wareDanjia[$this->typeDanjia];
		
		$smarty = $this->_getView();
		$smarty->assign('$title', '增加修改打包产量');
		$smarty->assign('aRow',$arr);
		$smarty->display('Chejian/DbChanliangEdit.tpl');
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
	//根据传入的ganghao关键字，进行提示，用于打包程序
	function actionSuggest() {
		$key = $_POST['key'];
		$sql = "select * from view_dye_gang where vatNum like '%{$key}' or vatNum like '%{$key}_' order by vatNum desc limit 0,20";
		//dump($sql);
		$rowset = $this->_modelExample->findBySql($sql);
		foreach($rowset as & $v) {
			$sql = "select * from trade_dye_order where id='{$v['orderId']}'";
			$row = $this->_modelExample->findBySql($sql);
			$v['zhiliang'] = $row[0]['zhiliang'];
			$v['packing_zhiguan'] = $row[0]['packing_zhiguan'];
			$v['packing_out'] = $row[0]['packing_out'];


			$dbs = $this->_modelExample->findAll(array('gangId'=>$v['gangId']));
			foreach($dbs as & $db) {
				if($db['Mingxi']) foreach($db['Mingxi'] as & $vv) {
					$vv['compName'] = $v['compName'];
					$vv['dateInput'] = $db['dateInput'];
					$vv['dengji'] = $v['zhiliang'];
					$vv['guige'] = $v['guige'];
					$vv['packing_zhiguan'] = $v['packing_zhiguan'];
					$vv['packing_out'] = $v['packing_out'];
					$vv['vatNum'] = $v['vatNum'];
					$vv['wareName'] = $v['wareName'];
					$vv['workerCode'] = $db['workerCode'];
					$vv['dabaoCode'] = $db['dabaoCode'];
				}
			}

			$v['Dabao'] = $dbs;
		}
		echo json_encode($rowset);
		exit;
	}
	//打包程序中传递过来的数据进行保存,并传回保存后的数据，用来更新打包程序界面。
	function actionSaveMingxi() {
		$gangId = $_POST['gangId'];
		$dabaoCode = $_POST['dabaoCode']?$_POST['dabaoCode']:$this->_getDabaoCode();
		$row = $this->_modelExample->find(array(
			'gangId'=>$gangId,
			'dabaoCode'=>$dabaoCode
		));
		if($_POST['mxId']>0) {//修改明
		foreach($row['Mingxi'] as & $v) {
				if($v['id']==$_POST['mxId']) {//
					$v['xianghao'] = $_POST['xianghao'];
					$v['cntTongzi'] = $_POST['cntTongzi'];
					$v['danzhongZhiguan'] = $_POST['danzhongZhiguan'];
					$v['danzhongBaozhuang'] = $_POST['danzhongBaozhuang'];
					$v['workerCode'] = $_POST['workerCode'];
					$v['maozhong'] = $_POST['maozhong'];
					$v['jingzhong'] = $_POST['jingzhong'];
					$v['memo'] = $_POST['memo'];
				}
			}
		} else {//新增明细
			//得到最大箱号并增1
			$sql = "select max(x.xianghao) as xianghao
			from dye_db_chanliang_mx x
			left join dye_db_chanliang y on x.chanliangId=y.id
			where y.dabaoCode='{$dabaoCode}' and x.gangId='{$gangId}'";
			$_rows = $this->_modelExample->findBySql($sql);
			$xianghao = $_rows[0]['xianghao']+1;
			//$xianghao = count($row['Mingxi']);

			$row['Mingxi'][] = array(
				'gangId'=>$_POST['gangId'],
				'xianghao'=>$xianghao,
				'maozhong'=>$_POST['maozhong'],
				'cntTongzi'=>$_POST['cntTongzi'],
				'danzhongZhiguan'=>$_POST['danzhongZhiguan'],
				'danzhongBaozhuang'=>$_POST['danzhongBaozhuang'],
				'jingzhong'=>$_POST['jingzhong'],
				'memo'=>$_POST['memo']
			);
		}
		//计算总箱数，总净重，总总重
		$x=0;
		$m=0;
		$j=0;
		$t=0;
		foreach($row['Mingxi'] as & $v) {
			$x++;
			$m+=$v['maozhong'];
			$j+=$v['jingzhong'];
			$t+=$v['cntTongzi'];
		}
		//第一次打包，主表也需要产生记录
		$row['dabaoCode']=$dabaoCode;
		$row['dateInput']=$_POST['dateInput'];
		$row['gangId']=$gangId;
		$row['cntTongzi']=$t;
		$row['workerCode']=$_POST['workerCode'];
		$row['dateInput']=date('Y-m-d');
		$row['maozhong']=$m;
		$row['cntK']=$m;
		$row['jingzhong']=$j;
		$row['cntXiang']=$x;
		//dump($row);exit;
		$dabaoId = $this->_modelExample->save($row);
		if($row['id']>0) $dabaoId = $row['id'];

		//修改成品入库数据
		$mRk = & FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
		$ruku = $mRk->find(array('dabaoId'=>$dabaoId));
		$ruku['dabaoId'] = $dabaoId;
		$ruku['dateCprk'] = $row['dateInput'];
		$ruku['planId'] = $row['gangId'];
		$ruku['jingKg'] = $row['jingzhong'];
		$ruku['maoKg'] = $row['maozhong'];
		$ruku['cntJian'] = $row['cntXiang'];
		$ruku['cntTongzi'] = $row['cntTongzi'];
		$ruku['memo'] = "称重系统自动产生";
		$mRk->save($ruku);
		//返回保存后的数据
		$_row = $this->_getDabaoInfoByDabaoCode($dabaoCode);
		echo json_encode($_row);
		exit;
	}

	//打包程序中删除明细的动作
	function actionDelMingxi() {
		$mxId = $_POST['mxId'];
		$gangId= $_POST['gangId'];
		$dabaoCode= $_POST['dabaoCode'];
		$m = & FLEA::getSingleton("Model_Chejian_DabaoChanliangMx");

		$mx = $m->find(array('id'=>$mxId));
		$chanliangId = $mx['chanliangId'];

		$m->removeByPkv($mxId);

		//如果全部删除了，删除主表记录
		$sql = "select count(*) cnt from dye_db_chanliang_mx where chanliangId='{$chanliangId}'";
		$_r = $m->findBySql($sql);
		if($_r[0]['cnt']==0) {
			$m = & FLEA::getSingleton("Model_Chejian_DabaoChanliang");
			$m->removeByPkv($chanliangId);

			//删除成品入库记录
			$mRk = & FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
			$ruku = $mRk->find(array('dabaoId'=>$chanliangId));
			$mRk->removeByPkv($ruku['id']);
		}
		//返回保存后的数据
		$row = $this->_getDabaoInfoByDabaoCode($dabaoCode);
		//dump($row);exit;
		echo json_encode($row['Mingxi']);
	}

	//打印时，传入gangId和dabaoCode,传回打印需要的信息
	function actionGetInfoForPrint() {
		$gangId = $_POST['gangId'];
		$dabaoCode = $_POST['dabaoCode'];
		$dabao = $this->_getDabaoInfoByDabaoCode($dabaoCode);
		$gang = $this->_getGangInfoByGangId($gangId);
		$gang['Dabao'][0] = $dabao;

		//备注取第一个明细中的备注
		$gang['memo'] = '';
		echo json_encode($gang);exit;
	}

	//对某个打包单号重新生产件号
	function actionReBaohao() {
        $sql = "select x.id,x.xianghao from dye_db_chanliang_mx x
        left join dye_db_chanliang y on x.chanliangId=y.id
        where y.dabaoCode='{$_POST['dabaoCode']}' and y.gangId='{$_POST['gangId']}'
        order by x.xianghao";
        $rowset = $this->_modelExample->findBySql($sql);
        $i = $_POST['startWith'];
        foreach($rowset as & $v) {
        	$v['xianghao'] = $i;
        	$i++;
        }
        $m = & FLEA::getSingleton("Model_Chejian_DabaoChanliangMx");
        $m->saveRowset($rowset);

        //返回保存后的明细数据
		$row = $this->_getDabaoInfoByDabaoCode($_POST['dabaoCode']);
		//dump($row);exit;
		echo json_encode($row['Mingxi']);
	}

	//根据ganghaoId获得完整的打包明细信息，用来在打包程序的grid中显示
	function _getDabaoInfoByDabaoCode($dabaoCode) {
		$row = $this->_modelExample->find(array('dabaoCode'=>$dabaoCode));
		$gangId = $row['gangId'];
		//加工$row,使之取得客户等信息
		$sql = "select * from view_dye_gang where gangId='{$gangId}'";
		$_r = $this->_modelExample->findBySql($sql);

		$sql = "select * from trade_dye_order where id='{$_r[0]['orderId']}'";
		$order = $this->_modelExample->findBySql($sql);
		//dump($order[0]);exit;
		if($row['Mingxi']) foreach($row['Mingxi'] as & $v) {
			$v['dabaoCode'] = $row['dabaoCode'];
			$v['compName'] = $_r[0]['compName'];
			$v['vatNum'] = $_r[0]['vatNum'];
			$v['wareName'] = $_r[0]['wareName'];
			$v['guige'] = $_r[0]['guige'];
			$v['dengji'] = $order[0]['zhiliang'];
			$v['packing_zhiguan'] = $order[0]['packing_zhiguan'];
			$v['packing_out'] = $order[0]['packing_out'];
			$v['dateInput'] = $row['dateInput'];
			$v['workerCode'] = $row['workerCode'];
		}
		return $row;
	}
	//根据gangId得到缸信息
	function _getGangInfoByGangId($gangId) {
		$sql = "select * from view_dye_gang where gangId='{$gangId}'";
		$rowset = $this->_modelExample->findBySql($sql);
		$v = $rowset[0];

		$sql = "select * from trade_dye_order where id='{$v['orderId']}'";
		$row = $this->_modelExample->findBySql($sql);
		$v['zhiliang'] = $row[0]['zhiliang'];
		$v['packing_zhiguan'] = $row[0]['packing_zhiguan'];
		$v['packing_out'] = $row[0]['packing_out'];
		return $v;
	}

	//获得打包流水号
	function _getDabaoCode() {
		$m = $this->_modelExample;
		$begin = "DB".date("ymd")."001";//DB120101xxx
		$sql = "select dabaoCode from `dye_db_chanliang` where dabaoCode like 'DB_________' order by dabaoCode desc limit 0,1";
		$rowset = $m->findBySql($sql);
		$code = $rowset[0]['dabaoCode'];
		if($begin>$code) {
			return $begin;
		}
		return "DB".date("ymd").substr(1001+substr($code,-3),1);
	}
}
?>