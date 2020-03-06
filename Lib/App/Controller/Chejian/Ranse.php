<?php
/**
 * 染色车间(筒染用)控制器
 */
FLEA::loadClass('TMIS_Controller');
class Controller_Chejian_Ranse extends Tmis_Controller {
	var $_modelExample;
	var $funcId=49;
	var $tn;
	function Controller_Chejian_Ranse() {
		$this->_modelExample = & FLEA::getSingleton('Model_Chejian_RanseChanliang');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$this->tn=$this->_modelExample->tableName;
		$this->_modelRsGx = &FLEA::getSingleton('Model_JiChu_RsPrice');
		$this->_modelVat = &FLEA::getSingleton('Model_JiChu_Vat');
		//$this->_modelGang->enableLink('Car');
		//$this->_modelPlan = & FLEA::getSingleton('Model_Dey_Gang2StCar');
		//$this->_modelPlan->enableLink('Chanliang');
		//$this->_pkName = $this->_modelExample->primaryKey;
	}

	//列出已登记的产量。
	function actionRight(){
		FLEA::loadClass('TMIS_Pager');
		$this->_modelExample->enableLink('VatView');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'workerCode'=>'',
			'vatNum'=>'',
			'banci'=>'',
		));
		$condition=array();
		if($arr['dateFrom']!='')$condition[]=array('dateInput',$arr['dateFrom'],'>=');
		if($arr['dateTo']!='')$condition[]=array('dateInput',$arr['dateTo'],'<=');
		if($arr['workerCode']!='') $condition[] = array('workerCode',"%{$arr[workerCode]}%",'like');
		if($arr['vatNum']!='') $condition[] = array('Vat.vatNum',"%$arr[vatNum]%",'like');
		if($arr['banci']!='') $condition[] = array('banci',$arr['banci'],'=');

		$pager = new TMIS_Pager($this->_modelExample,$condition);
		$rowset = $pager->findAll();

		foreach($rowset as &$v) {
			//dump($v);exit;
			$v[kindName] = $this->_modelExample->getKindName($v[chanliangKind]);
			if ($v[chanliangKind]>0) {
				$v[cntTongzi] = "<font color='red'>$v[cntTongzi]</font>";
				$v[kindName] = "<font color='red'>$v[kindName]</font>";
			}
			$con = array("gangId='$v[gangId]'");
			$gang = $this->_modelGang->findAllGang1($con);
			if(count($gang)>0) $v = array_merge($v,$gang[0]);
			if($v['type']) $v[vatNum] = $v[Vat][vatNum]."(".$v['type'].")";
		}
		// dump($rowset);die;
		foreach($rowset as &$v){
			$v['guige']=$v['wareName'].' '.$v['guige'];
			$v['vatNum']=$this->_modelGang->setVatNum($v['VatView']['gangId'],$v['VatView']['order2wareId']);
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v['orderCode']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$arrGang=$this->_modelGang->find(array('id'=>$v['gangId']));
			$str="select sum(cntK) as cntK from $this->tn where gangId='{$v['gangId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			if($arrGang['rsOver']==1&&$arrGang['cntPlanTouliao']>$re['cntK'])$v['_edit']="<a href='".$this->_url('CancelOver',array('id'=>$v['gangId']))."'>取消完成</a>  ";
			//已经被财务审核过的不能删除
			if($v['rsGxCl'][0]['danjia']>0){
				$v['_edit'] .= "已审核不能操作";
			}else{
				$v['_edit'].=$this->getEditHtml($v['id']).'  '.$this->getRemoveHtml($v['id']);
			}
		}
		$heji=$this->getHeji($rowset,array('cntK'),'dateInput');
		$rowset[]=$heji;
		$smarty = $this->_getView();
		//dump($rowset[0]);exit;
		$smarty->assign('arr_field_info',array(
			'dateInput'=>'日期',
			//dt=>'录入时间',
			'compName'=>"客户(客户单号)",
			'orderCode'=>"订单号",
			'vatNum'=>"缸号",
			'guige'=>"纱支",
			'color'=>"颜色",
			'banci'=>"班次",
			'workerCode'=>'工号',
            'Vat.cntPlanTouliao' =>'投料数',
			'cntTongzi'=>'筒子数',
			'cntK'=>'公斤数',
			'_edit'=>'操作'
		));

		/*$smarty->assign('arr_edit_info',array(
			"edit" =>"修改",
			"remove" =>"删除"
		));*/
		$smarty->assign('title','染色产量查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display('TableList.tpl');
	}
	function actionCancelOver(){
		$kk=array(
				'id'=>$_GET['id'],
				'rsOver'=>0
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
		$sql="SELECT x.*,y.cntPlanTouliao,y.order2wareId,z.compName,z.orderId,z.orderCode,z.vatNum,z.guige,z.color
				FROM `dye_rs_chanliang` x
				LEFT JOIN plan_dye_gang y ON x.gangId = y.id
				LEFT JOIN view_dye_gang z ON x.gangId = z.gangId
				WHERE x.cntTongzi =0 and z.planDate>='".date('Y-m-d',strtotime('-30 day'))."' and z.planDate<='".date('Y-m-d')."'";
		if($arr[vatNum]!='')  $sql.=" and z.vatNum like '%{$arr['vatNum']}%'";
		$pager = & new TMIS_Pager($sql);
		$rowset=$pager->findAll();
		foreach($rowset as &$v) {
			$v['vatNum']=$this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
		}
		//dump($rowset);
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateInput=>'日期',
			//dt=>'录入时间',
			compName=>"客户(客户单号)",
			orderCode=>"订单号",
			vatNum=>"缸号",
			guige=>"纱支",
			color=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数',
		));

		$smarty->assign('arr_edit_info',array(
			"edit" =>"修改",
			"remove" =>"删除"
		));
		$smarty->assign('title','染色未完成产量查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display('TableList.tpl');
	}
	//产量列表
	function actionChanliangList() {
		$this->actionRight();
	}

	//登记染色产量第一步，列出所有的缸号明细
	function actionChanliangInput1() {
		$this->_modelGang->enableLink('RanseChanliang');
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			orderCode=>'',
			vatNum=>''
		));
		$chanliang="select sum(cntK) as cntK,gangId from dye_rs_chanliang where 1 group by gangId";
		$sql = "select x.*,y.cntK
			from view_dye_gang x
			left join ({$chanliang}) y on x.gangId=y.gangId
			where 1
		";
		if($arr[orderCode]!='') $sql.= " and x.orderCode like '%$arr[orderCode]%'";
		if($arr[vatNum]!='') $sql.= " and x.vatNum like '%$arr[vatNum]%'";
        //$condition[]="(IFNULL(y.cntK,0)>0 or (markTwice=1 and fensanOver<2))";
		//$condition[]=" (id is NULL or (markTwice=1 and fensanOver<2))";
		$sql.=" and ((x.rsOver=0 ) or (x.rsOver=1 and x.markTwice=1 and x.fensanOver<2))";
		$sql.=" order by x.gangId desc";
		//dump($condition);
		//echo $sql;exit;
		$pager=null;
		//$rowset=$this->_modelGang->findAllGang2($this->tn,$condition,$pager);
		$pager = new TMIS_Pager($sql);
		$rowset = $pager->findAllBySql($sql);
		//dump($rowset[0]);
		if(count($rowset)>0) foreach($rowset as & $v) {
			$v['vatNum']=$this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);
			//染色产量
			$v[guige] = $v[wareName]." ".$v[guige];
			$arrCl = $this->_modelGang->getArrRanseChanliang($v[gangId]);
			//dump($arrCl);
			$v[chanliang] = $arrCl[0];
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v[orderCode]);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			if($v['markTwice']==1 && $v['fensanOver']==0) {
				if($v['dateAssign']==$v['dateAssign1'] && $v['ranseBanci']==$v['ranseBanci1']) $v['vatNum'].="分散+套棉";
				else $v['vatNum'].="分散";
			}
			if($v['markTwice']==1 && $v['fensanOver']==1) $v['vatNum'].="套棉";
			if($arrCl[1]>0) $v[chanliang] .= ",修:".$arrCl[1];
			if($arrCl[2]>0) $v[chanliang] .= ",加:".$arrCl[2];
			if($v[chanliang]>0&&$v[planTongzi]>0&&$v[cntPlanTouliao]>0) $v[chanliangKg] = round($v[chanliang]/$v[planTongzi]*$v[cntPlanTouliao], 2);

			//if ($this->_modelExample->wareLeach($v[wareId]) && ($v[chanliang] > 0)) $v[_edit] = "<font color=red>已有产量</a>";
			if($v['cntK']>0)$v['_edit']="<a href='".$this->_url('SetOver',array('id'=>$v['gangId']))."'>设置完成</a> | ";
			$v[_edit] .= "<a href='".$this->_url('ChanliangInput2',array(
						gangId => $v[gangId]
					))."'>单缸输入</a>";

			$v[_edit] .= " | <a href='".$this->_url('ChanliangInput3',array(
				orderId => $v[orderId],
				plan => $v['cntPlanTouliao']
			))."'>整单录入</a>";
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
			//"chanliang"=>"产出筒子数",//显示在做车台，并用颜色表示完成情况
			"chanliangKg"=>"折合公斤数",
			'cntK'=>'公斤数产量',
			//"chanliang1"=>"修色产量",
			//"chanliang2"=>"加色产量",
			"_edit" => '操作'
		));
		$smarty->assign('title','染色产量录入');
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
				'rsOver'=>1
		);
		$this->_modelGang->save($kk);
		redirect($this->_url('ChanliangInput1'));
	}
	//登记染色产量第二步，根据选择的缸号登记产量
	function actionChanliangInput2() {
		if($_GET[gangId]!="") {
			//新增产量
			$arr = array();
			$arr[Gang] = $this->_modelGang->find($_GET[gangId]);
			$arr['Gang']['vatNum'] .= ' '.$this->_modelGang->getTwiceStatu($arr['Gang']);
			$arr[Client] = $this->_modelGang->getClient($arr[Gang][id]);
			$arr[Ware] = $this->_modelGang->getWare($arr[Gang][id]);
		

			$arr['rsGxCl'] = array();
			$rsGxCount = count($arr['rsGxCl']);
			for ($i=0; $i < 5-$rsGxCount; $i++) { 
				$arr['rsGxCl'][] = array();
			}
			// dump($arr);die;
		} elseif($_GET[id]!="") {
			//修改产量
		}

		$smarty = $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Chejian/RsChanliangEdit.tpl');
	}

	//保存产量
	function actionSaveChanliang() {
		// dump($_POST);exit;
		$arr = $_POST;
		$arr['dateInput'] = date("Y-m-d");
		//处理双染情况
		$gang = $this->_modelGang->find(array('id'=>$arr['gangId']));

		//整合该缸的染色工序单价
		$vatDetail = $this->_modelVat->find(array('id'=>$gang['Vat']['id']));
		if(count($vatDetail['RsgxPrice']>0)){
			$RsgxPrice = array();
			foreach ($vatDetail['RsgxPrice'] as $k => &$v) {
				$RsgxPrice[$v['gxId']]['price'] = $v['price'];
			}
		}
		// dump($RsgxPrice);die;

		//dump($gang);exit;
		if ($gang['markTwice']==1){
			if($gang['fensanOver']==0) {//如果分散没有完成,表示产量是第一道工序分散产量
				//判断是否双染分配在同一班做掉
				if($gang['dateAssign']==$gang['dateAssign1'] && $gang['ranseBanci']==$gang['ranseBanci1']) {
					$sql = "update plan_dye_gang set fensanOver=2 where id='{$arr['gangId']}'";
					$arr['type']='分套同班';
				} else {
					$sql = "update plan_dye_gang set fensanOver=1 where id='{$arr['gangId']}'";
					$arr['type']='分散';
				}
			} else {
				$sql = "update plan_dye_gang set fensanOver=2 where id='{$arr['gangId']}'";
				$arr['type']='套棉';
			}
			//echo $sql;exit;
			mysql_query($sql) or die(mysql_error());
		}
		$temp = array();
		foreach ($_POST['gxId'] as $key => &$v) {
			if(!$v['gxId']) continue;
			$temp[$key]['id'] = $_POST['rs2gxId'][$key];
			$temp[$key]['gxId'] = $_POST['gxId'][$key];
			$temp[$key]['cntK'] = $_POST['cnt'][$key];
			if($RsgxPrice[$_POST['gxId'][$key]]){
				$temp[$key]['danjia'] = $RsgxPrice[$_POST['gxId'][$key]]['price'];
				$temp[$key]['money'] = $temp[$key]['danjia']*$temp[$key]['cntK'];
			}else{
				$temp[$key]['danjia'] = $_POST['danjia'][$key];
				$temp[$key]['money'] = $_POST['money'][$key];
			}
		}

		// dump($temp);die;
		
		unset($arr['gxId']);
		unset($arr['cnt']);
		unset($arr['rs2gxId']);
		$arr['rsGxCl'] = $temp;
		// dump($arr);exit;
		$this->_modelExample->save($arr);
		#判断输入的产量是否大于计划投料数
		//$arrGang=$this->_modelGang->find(array('id'=>$arr['gangId']));       //用户需求有变可能要多次投料 取消产量大于计划投料就标记完成 改为手动标记完成
		//$str="select sum(cntK) as cntK from $this->tn where gangId='{$arr['gangId']}'";
		//$re=mysql_fetch_assoc(mysql_query($str));
		//dump($re['cntK']);dump($arrGang); 
		// dump($arr);exit;

		if($arr['biaoji']){           /*$re['cntK']>=$arrGang['cntPlanTouliao']||*/
			$kk=array(
				'id'=>$arr['gangId'],
				'rsOver'=>1
			);	
		}else{
			$kk=array(
				'id'=>$arr['gangId'],
				'rsOver'=>0
			);	
		}
		$this->_modelGang->save($kk);
		js_alert('保存成功!','',$this->_url('chanliangInput1'));
	}


	//批量向导式录入,显示某个订单的所有缸次，等待录入,对应保存的actionSaveChanliang1();
	function actionChanliangInput3() {
		$condition = array(
			array('OrdWare.orderId',$_GET[orderId])
		);
		$pager = null;
		// $rowset = $this->_modelGang->findAllGang($condition,$pager);//原方法 by zcc 注释操作
		$rowset = $this->findAllGang($condition,$pager);
		//dump($condition);
		//dump($rowset[0]);
		if (count($rowset)>0) foreach ($rowset as & $v) {
			//echo('____________'.$v[vatNum].'__________');
			$rsChanliang = $this->_modelExample->getRanseChanliang($v[vatNum]);
			if ($rsChanliang > 0) {
				$v[rsChanliang]=$rsChanliang;
				$arrRs[] = $v;
			}
			else $newArr[]=$v;
		}
		$smarty = & $this->_getView();
		$smarty->assign('rows',$newArr);
		$smarty->assign('rows1',$arrRs);
		//$smarty->assign('page_info',$pager->getNavBar($this->_url('addGuide')));
		$smarty->display('Chejian/RsChanliangEdit1.tpl');
	}
	/**
	 * ps ：脱离原来通用的方法 用于actionChanliangInput3 方法中调用 
	 * Time：2017/04/21 11:15:00
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function findAllGang($condition=NULL,&$pager=null,$pageSize=0) {
		$mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		FLEA::loadClass('TMIS_Pager');
		$modelO2w = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$pager = new TMIS_Pager($modelO2w,$condition,null,200);//原来方法有分页问题BUG 设置200 防止分页
		$rowO2w = $pager->findAll();
		//$dbo=FLEA::getDBO(false);
		//dump($dbo->log);exit;
		//dump($rowO2w);
		/**/
		foreach($rowO2w as & $value) {
				$rowset = $mOrder->findByField('id', $value[OrdWare][orderId]);
				//订单号
				$value[orderCode] = $rowset[orderCode];
				//客户
				$value[clientName] = $rowset[Client][compName];
				//纱支规格
				$Ware = $mWare->findByField('id',$value[OrdWare][wareId]);
				$value[guige] = $Ware[wareName]." ".$Ware[guige];
				//颜色
				$value[color] = $value[OrdWare][color];
				//交货日期
				$value[dateJiaohuo] = $rowset[dateJiaohuo];
		}
		return $rowO2w;
	}
	//批量录入时保存产量
	function actionSaveChanliang1() {
		$p = $_POST;
		$check=$_POST['check'];
        //dump($p);exit;
		for($i=0;$i<count($p['gangId']);$i++) {
			if(isset($check[$i]))
			{
				//echo($i);
				if (empty($p['cntK'][$i])) continue;
				$arr = array(
					gangId => $p[gangId][$i],
					dateInput => date("Y-m-d"),
					cntTongzi => $p[cntTongzi][$i],
					cntK => $p[cntK][$i],
					chanliangKind => $p[chanliangKind][$i],
					workerCode => $p[workerCode][$i],
				);

				$gang = $this->_modelGang->find(array('id'=>$p['gangId'][$i]));
				if ($gang['markTwice']==1){
					if($gang['fensanOver']==0) {//如果分散没有完成,表示产量是第一道工序分散产量
						//判断是否双染分配在同一班做掉
						if($gang['dateAssign']==$gang['dateAssign1'] && $gang['ranseBanci']==$gang['ranseBanci1']) {
							$sql = "update plan_dye_gang set fensanOver=2 where id='{$p['gangId'][$i]}'";
							$arr['type']='分套同班';
						} else {
							$sql = "update plan_dye_gang set fensanOver=1 where id='{$p['gangId'][$i]}'";
							$arr['type']='分散';
						}
					} else {
						$sql = "update plan_dye_gang set fensanOver=2 where id='{$p['gangId'][$i]}'";
						$arr['type']='套棉';
					}
					//echo $sql;exit;
					mysql_query($sql) or die(mysql_error());
				}
				//dump($gang);exit;

				$this->_modelExample->save($arr);
				#判断输入的产量是否大于计划投料数
				$arrGang=$this->_modelGang->find(array('id'=>$arr['gangId']));
				$str="select sum(cntK) as cntK from $this->tn where gangId='{$arr['gangId']}'";
				$re=mysql_fetch_assoc(mysql_query($str));
				if($re['cntK']>=$arrGang['cntPlanTouliao']){
					$kk=array(
						//'id'=>$arrys['gangId'][$i],
						'id'=>$arr['gangId'],
						'rsOver'=>1
					);
					$this->_modelGang->save($kk);
				}
			}
		}
		js_alert('保存成功!','',$this->_url('chanliangInput1'));
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
				'rsOver'=>0
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
			'color'=>'',
			'chanliangKind'=>'',
			'banci'=>'',
			'vatNum'=>'',
			'clientId'=>''
		));
		/*$condition=array(
			array('dateInput',$arr['dateFrom'],'>='),
			array('dateInput',$arr['dateTo'],'<='),
		);

		$rowset = $this->_modelExample->findAll($condition);*/
		//$str .= " and x.gangId='16608'";
		if($arr['dateFrom']!='')$con.=" and x.dateInput>='{$arr['dateFrom']}'";
		if($arr['dateTo']!='')$con.=" and x.dateInput<='{$arr['dateTo']}'";
		if($arr['color']!='')$con.=" and z.color like '%{$arr['color']}%'";
		if($arr['chanliangKind']!='')$con.=" and x.chanliangKind='{$arr['chanliangKind']}'";
		if($arr['banci']!='')$con.=" and x.banci='{$arr['banci']}'";
		if($arr['vatNum']!='') $con.=" and y.vatNum like '%{$arr['vatNum']}%'";
        if($arr['clientId']!='') $con.=" and o.clientId={$arr['clientId']}";
		// $con.=" group by x.gangId";
		$str="SELECT x.*,z.id as order2wareId
			from dye_rs_chanliang x
			left join plan_dye_gang y on y.id=x.gangId
			left join trade_dye_order2ware z on z.id=y.order2wareId
			left join trade_dye_order o on o.id = z.orderId
			where y.parentGangId=0 $con 
			-- 有时候同一天会登记两笔染色产量入库，在报表中将会显示一条记录
			-- group by x.gangId
		";
		//获得总计的sql语句
		$zjsql = "SELECT sum(a.cntTongzi) as cntTongzi,
		       sum(a.cntK) as cntK,
		       sum((select cntK from dye_rs_chanliang where gangId=a.gangId and type='套棉' limit 1)) as cntSr
		          from(
		          	select sum(x.cntTongzi) as cntTongzi,sum(x.cntK) as cntK,x.gangId
				from dye_rs_chanliang x
				left join plan_dye_gang y on y.id=x.gangId
				left join trade_dye_order2ware z on z.id=y.order2wareId
				left join trade_dye_order o on o.id = z.orderId
				where y.parentGangId=0 $con group by x.gangId
			) as a";
		// dump($zjsql);exit;
			$zj = $this->_modelExample->findBySql($zjsql);
			// dump($zj);exit;
		// $rowset=$this->_modelExample->findBySql($str);
             $pager = & new TMIS_Pager($str,null,null,100);
             $rowset = $pager->findAll();
		foreach($rowset as &$v) {			
			//$v['vatNum'] = $v['Vat']['vatNum'];
			$con = array("gangId='$v[gangId]'");
			$gang = $this->_modelGang->findAllGang1($con);
			
			if ($gang[0]) $v = array_merge($v,$gang[0]);
			$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v['orderCode']);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$v['vatNum'] = $this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);

			$v['guige'] = $v['wareName'].' '.$v['guige'];
			
			//判断是否有双染
			//dump($v);exit;
			$sql = "select * from dye_rs_chanliang where gangId='{$v['gangId']}' and type='套棉'";
			$_r = $this->_modelGang->findBySql($sql);
			if(count($_r)>0) {
				$v['_bgColor'] = 'pink';
				$v['cntSr'] = $_r[0]['cntK'];
			}

			$v['chanliangKind'] = $v['chanliangKind']==0 ?'正常':($v['chanliangKind']==1?'回修':'加料');
		}
		$heji = $this->getHeji($rowset,array('cntTongzi','cntK','cntSr'),'dateInput');
		$zj = $zj[0];
		$zj['dateInput'] = "<b>总计</b>";
		$rowset[] = $heji;
		$rowset[] = $zj;
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'		=>'日期',
			'compName'		=>"客户(客户单号)",
			'orderCode'		=>"订单号",
			'vatNum'		=>"缸号",
			'guige'			=>"纱支",
			'color'			=>"颜色",
			'chanliangKind'=>'产量类别',
			'workerCode'	=>'工号',
			//'netWeight'		=>'净重',
			'cntTongzi'		=>'筒子数',
			'cntK'=>'染色产量(kg)',
			'cntSr'=>'双染产量(kg)',
			//'dt'			=>'录入时间',
		));

		$smarty->assign('title','染色产量统计表');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		// $smarty->assign("");
		$smarty->assign('page_info',$pager->getNavBar($this->_url("ChanliangDayReport")).'<font color="red">注：红色代表双染产量!</font>');
		$smarty->display('TableList.tpl');
	}

	//修改产量
	function actionEdit() {
		$arr=$this->_modelExample->find($_GET[id]);
		$arr[Gang] = $this->_modelGang->find($arr[gangId]);
		$arr[Client] = $this->_modelGang->getClient($arr[gangId]);
		$arr[Ware] = $this->_modelGang->getWare($arr[gangId]);

		$rsGxCount = count($arr['rsGxCl']);
		for ($i=0; $i < 5-$rsGxCount; $i++) { 
			$arr['rsGxCl'][] = array();
		}
		// dump($arr);die;
		$smarty = $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Chejian/RsChanliangEdit.tpl');
	}
	#由gangId取得已经登记的产量
	function actionGetCntByGangId(){
		$str="select sum(cntK) as cntK from $this->tn where 1";
		if($_GET['gangId']!='')$str.=" and gangId='{$_GET['gangId']}'";
		if($_GET['id']!='')$str.=" and id<>'{$_GET['id']}'";
		$str.=" group by gangId";
		$re=mysql_fetch_assoc(mysql_query($str));
		$sql="select * from plan_dye_gang where gangId='{$_GET['gangId']}'";
		$rr=mysql_fetch_assoc(mysql_query($sql));//x.markTwice=1 and x.fensanOver<2
		$arr['markTwice']=$rr['markTwice']+0;
		$arr['fensanOver']=$rr['fensanOver']+0;
		$arr['cntK']=$re['cntK']+0;
		$arr['id']=$_GET['id'];
		echo json_encode($arr);exit;
	}
}
?>