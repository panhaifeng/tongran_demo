<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_Public_Search extends Tmis_Controller {
	var $_modelExample;
	//var $funcId = 32;
	function Controller_Public_Search() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		//$this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Expense');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelExample = & FLEA::getSingleton('Model_Trade_Dye_Order2ware');
		$this->_modelClient = &FLEA::getSingleton('Model_JiChu_Client');
		$this->_modelChufang =  &FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$this->_modelChufang2Ware =  &FLEA::getSingleton('Model_Gongyi_Dye_Chufang2Ware');
		$this->_modelVat = &FLEA::getSingleton('Model_JiChu_Vat');
		$this->_modelGang =  &FLEA::getSingleton('Model_Plan_Dye_Gang');
	}

	//按缸号排列,有些颜色没有排计划，所以不能从view_dye_gang中取数据
	function actionRight1() {
		$this->_modelExample->enableLink('Chufang');
		$this->_modelGang->enableLink('SongtongChanliang');
		$this->_modelGang->enableLink('PishaLingliao');
		$this->_modelGang->enableLink('RanseChanliang');
		$this->_modelGang->enableLink('HongshaChanliang');
		$this->_modelGang->enableLink('HuidaoChanliang');
		$this->_modelGang->enableLink('ZhuangchulongChanliang');
		$this->_modelGang->enableLink('DabaoChanliang');
		$this->_modelGang->enableLink('Cprk');
		$this->_modelGang->enableLink('Cpck');


		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			orderId=>0,
			vatNum=>'',
			orderCode=>''
		));
		$condition=array();
		//if ($arr[orderId]!='') $condition[] ="orderId='$arr[orderId]'";
		if ($arr[orderId]>0) $condition[orderId] =$arr[orderId];
		if($arr[vatNum]!='') $condition[] = array('Pdg.vatNum',"%$arr[vatNum]%","like");
		if($arr[orderCode]!='') $condition[] = array('Order.orderCode',"%$arr[orderCode]%","like");
		//dump($condition);
		$rowset =$this->_modelExample->findAll($condition);
		$newRow = array();
		$i=0;
		$curClient=$curOrderCode='';
		if(count($rowset)>0) foreach($rowset as & $row) {
			$head = array(
				guige => $row[Ware][wareName] . " ".$row[Ware][guige],
				color=>$row[color],
				colorNum=>$row[colorNum],
				cntKg=>$row[cntKg]
			);
			//dump($rowset[Pdg]);continue;
			if(count($row[Pdg])==0) {
				$newRow[$i] = $head;
			} else {
				foreach ($row[Pdg] as & $g) {
					$tail = array(
						vatNum=>$g[vatNum],
						planDate=>$g[planDate],
						cntPlanTouliao=>$g[cntPlanTouliao],
						planTongzi=>$g[planTongzi]
					);

					$gang = $this->_modelGang->find(array(id=>$g[id]));
					//dump($gang);exit;
					if($gang['markTwice']==1) {
						if($gang['fensanOver']==0) {//第一道工序分散未做
							//如果分散套棉安排在同一班做显示分散+套棉
							if($gang['dateAssign']==$gang['dateAssign1'] && $gang['ranseBanci']==$gang['ranseBanci1']) $tail['vatNum'] .= "分散+套棉";
							else $tail['vatNum'] .= "分散";
						} elseif($gang['fensanOver']==1) {//第一道工序已做
							$tail['vatNum'] .= "套棉";
						}
					}
					//工艺
					/*if(!$this->_modelExample->isGongyiOk($row[id])) {
						$tail[chufang] = "<font color=red>未开</font>";
					} else{
						$tail[chufang] = "ok";
					}*/
					$m = &FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
					$arr=$m->findByField('order2wareId',$row[id]);
					if($arr){
						$tail[chufang] = 'OK '.$arr['Chufangren']['employName'];
					}
					else{
						$tail[chufang] = "<font color=red>未开</font>";
					}
					//物理缸号
					if($gang['Vat']){
						$tail['vatCode']=$gang['Vat']['vatCode'];
					}
					//排缸日期
					$tail['planDate']=$gang['planDate'];
					//定重
					$tail['unitKg']=$gang['unitKg'];

					//松筒产量
					if ($gang[SongtongChanliang]) foreach($gang[SongtongChanliang] as &$v1){
						$tail[st] += $v1['cntTongzi'];
						$tNetWeight += $v1['netWeight'];
						$tail['stTimeInput'] = substr($v1['dt'], 5);
					}
					if ($tail['st'])
					$tail['st']='<a href="'.$this->_url('stList',array('gangId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$v1['cntTongzi'].' / '.$v1['netWeight'].'</a>';

					//坯纱领料
					if(count($gang[PishaLingliao])>0)foreach($gang['PishaLingliao'] as &$v1){
						$tail[ll]+=$v1[cnt];
					}
					//$tail[ll]=$gang[PishaLingliao];

					//装出笼
					if ($gang[ZhuangchulongChanliang]) foreach($gang[ZhuangchulongChanliang] as &$v1){
						$tail[zcl] += $v1[cntTongzi];
						$tail['zclTimeInput'] = substr($v1['dateInput'], 5);
					}
					if ($tail['zcl'])
					$tail['zcl']='<a href="'.$this->_url('zclList',array('gangId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$tail['zcl'].'</a>';

					//染色产量
					//dump($gang['RanseChanliang']);exit;
					//$tail = array();
					if ($gang['RanseChanliang']) foreach($gang[RanseChanliang] as &$v1){
						if($tail['rsTimeInput']) {
							$tail['rsTimeInput'].="<br>";$tail['rs'].="<br>";
						}
						$tail['rsTimeInput'] .= substr($v1['dt'], 5);
						//if(!$tail['rsTimeInput'])
						$temp = '<a href="'.$this->_url('rsList',array('gangId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$v1['cntTongzi'].'</a>';
						if($v1['type']) $tail['rs'] .= $temp."({$v1['type']})";
						else $tail['rs'] .= $temp;
					//dump($tail);exit;
						//if ($tail['rs']) $tail['rs'].='<a href="'.$this->_url('rsList',array('gangId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$tail['rs'].'</a>';
					}
					//dump($tail);exit;
					//$tail[rs] = $this->_modelGang->getRanseChanliang($g[id]);

//dump($tail);exit;

					//烘纱产量
					if ($gang[HongshaChanliang]) foreach($gang[HongshaChanliang] as &$v1){
						$tail[hs] += $v1[cntTongzi];
						$tail['hsTimeInput'] = substr($v1['dt'], 5);
					}
					if ($tail['hs'])
					$tail['hs']='<a href="'.$this->_url('hsList',array('gangId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$tail['hs'].'</a>';

					//if ($tail['hs']) $tail[hs] = $tDateInput.' / '.$v1['cntTongzi'];


					//回倒
					if ($gang[HuidaoChanliang]) foreach($gang[HuidaoChanliang] as &$v1){
						$tail[hd] += $v1[cntTongzi];
						$tail['hdTimeInput'] = substr($v1['dt'], 5);
					}
					if($tail['hd'])
					$tail['hd']='<a href="'.$this->_url('hdList',array('gangId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$tail['hd'].'</a>';

					//打包

					if ($gang[DabaoChanliang]) foreach($gang[DabaoChanliang] as &$v1){
						$tail[db] += $v1[cntTongzi];
						$tail['dbTimeInput'] = substr($v1['dt'], 5);
					}
					if($tail['db'])
					$tail['db']='<a href="'.$this->_url('dbList',array('gangId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$tail['db'].'</a>';

					//入库
					if ($gang[Cprk]) foreach($gang[Cprk] as &$v1){
						$tail['rk'] += $v1['jingKg'];
					}
					if($tail['rk'])
					$tail['rk']='<a href="'.$this->_url('rkList',array('planId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$tail['rk'].'</a>';

					//发货
					if ($gang[Cpck]) foreach($gang[Cpck] as &$v1){
						$tail[ck] += $v1[jingKg];
					}
					if($tail['ck'])
					$tail['ck']='<a href="'.$this->_url('ckList',array('planId'=>$gang['id'],'TB_iframe'=>'1')).'" class="thickbox" >'.$tail['ck'].'</a>';

					$tail[sunhao] = number_format($tail[ck]/$gang[cntPlanTouliao]*100,2,".","") . '%';
					//dump($tail);exit;

					$newRow[$i] = array_merge($head,$tail);

					//控制重复显示的问题
					if ($curClient==$v[clientName]) $v[clientName]='';
					else $curClient=$v[clientName];
					if ($curOrderCode==$v[orderCode]) $v[orderCode]='';
					else $curOrderCode=$v[orderCode];

						$i++;
					}
			}
			$i++;
		}
		//$newRow[] = $this->getHeji($newRow,array('cntPlanTouliao','planTongzi'),'guige');
		$con=array('id'=>$_GET[orderId]);
		$r=$this->_modelOrder->findAll($con);
		foreach($r as & $v){
			$v[employName]=$v[Trader][employName];
			$v[compName]=$v[Client][compName];
		}
		//dump($newRow);exit;
		$row=array();
		foreach($newRow as & $v){
			$v[cntPlanTouliao]+=cntPlanTouliao;
			//$v['PishaLingliao']+=
			$key=$v[guige].' '.$v[color];
			$row[$key][]=$v;
		}
		foreach($row as $key=>& $v){
			foreach($v as & $vv){
				$vv[guige2color]=$vv[guige].' '.$vv[color];
				$vv[Sum]=$this->getHeji($v,array('cntPlanTouliao','planTongzi','ll'),'guige');
			}
		}
		//dump($newRow);exit;
		$arr_field_info = array(
			//dateOrder => '下单日期',
			//compName => '客户',
			//orderCode => '订单号',

			'guige' => '坯纱规格',
			'color' => '颜色',
			//colorNum => '色号',
			//cntKg => '要货数量',
			'vatNum' =>'缸号',
			//planDate => '计划日期',
			'cntPlanTouliao' => '计划投料',
			'planTongzi'=>'计划筒子',
			"chufang" =>"工艺",
			"st" =>"松筒",
			'stTimeInput' => '松筒时间',
			//"ll" =>"领料",
			//"zcl" =>"装出笼",
			"rs" =>"高台染色",
			'rsTimeInput' => '染色时间',
			"hs" =>"烘纱",
			'hsTimeInput' => '烘纱时间',
			"hd" =>"回倒",
			'hdTimeInput' => '回倒时间',
			//"rk" =>"入库净重",
			"ck" =>"发货净重",
			'sunhao' =>'制成率'
		);
		$arr_field_info1 = array(
			orderCode => '合同编码',
			employName => '业务员',
			dateOrder => '签约日期',
			compName => '客户'
		);
		//dump($row);
		$smarty = & $this->_getView();
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$row);
		$smarty->assign("arr_field_info1",$arr_field_info1);
		$smarty->assign('arr_field_value1',$r);
		$smarty->assign('add_display', 'none');
		//$smarty->assign('page_info',$pager->getNavBar($this->_url('right1',$arr)));
		$smarty->assign('arr_condition',$arr);
		//$smarty->display('Chengpin/Dye/CprkList.tpl');
		$smarty->display('OrderTrack.tpl');
	}

	//按每个订单进行排列
	function actionRight0(){
		//dump($_GET);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom=>date('Y-m-01'),
			dateTo=>date('Y-m-d'),
			clientId=>0,
			orderCode=>'',
			vatNum=>'',
			'color'=>'',
			'colorNum'=>'',
			'kuanhao' =>'',
		));
		if($_GET[vatNum]!=''||$_GET[orderCode]!=''){
			$arr['dateFrom']='';
			$arr['dateTo']='';
		}
		$sql = "select *,
		group_concat(distinct wareId order by wareId) as wareIds,
		group_concat(distinct wareName order by wareId) as wareNames,
		group_concat(distinct guige order by wareId) as guiges
		from view_dye_all where 1";
		if ($arr[clientId]>0) $sql.= " and clientId='{$arr[clientId]}'";
		if ($arr[orderCode]!='') $sql.= " and orderCode like '%{$arr[orderCode]}%'";
		if ($arr[dateFrom]!=''&$arr[dateTo]!='') $sql.= " and dateOrder>='{$arr['dateFrom']}' and dateOrder<='{$arr['dateTo']}'";
		if ($arr[vatNum]!='') $sql.= " and vatNum like '%{$arr[vatNum]}%'";
		if ($arr[color]!='') $sql.= " and color like '%{$arr[color]}%'";
		if ($arr[colorNum]!='') $sql.= " and colorNum like '%{$arr[colorNum]}%'";
		if ($arr[kuanhao]!='') $sql.= " and order2wareId in (select id from trade_dye_order2ware where kuanhao like '%{$arr[kuanhao]}%') 
			";
		$sql.= " group by orderId order by orderId desc";
		$pager =& new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		if($rowset) foreach($rowset as & $v) {
			//处理不同的wareId,并汇总数量
			$v['guige'] = $this->_modelOrder->getGuigeDescByWare($v['orderId']);
			$v['_edit'] = "<a href='".$this->_url('right1',array(
				//'orderCode'=>$row[Order][orderCode]
				orderId =>$v[orderId]
			))."' target='_blank'>详细进度</a>";
			$sql = "select sum(cntKg) as cnt from trade_dye_order2ware where orderId='{$v['orderId']}'";
			$rrr = mysql_fetch_assoc(mysql_query($sql));
			$v['cntTotal'] = $rrr['cnt'];
			 //得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$v['kuanhao'] = $this->_modelOrder->getDescByWare($v['orderId'],'kuanhao');
			$v['color'] = $this->_modelOrder->getDescByWare($v['orderId'],'color');
			$v['colorNum'] = $this->_modelOrder->getDescByWare($v['orderId'],'colorNum');
		}
		//dump($rowset);
		$arr_field_info = array(
			dateOrder => '下单日期',
			compName => '客户(客户单号)',
			orderCode => '订单号',
			'kuanhao' => '款号',
			guige => '规格-要货数',
			'color' =>'颜色',
			'colorNum'=>'色号',
			cntTotal => '总要货数量',
			//cntPlan => '总投料数',
			_edit=>'操作'
		);
		$smarty = & $this->_getView();
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('right0',$arr)));
		$smarty->display('TableList.tpl');
		//echo "显示计划单列表";exit;
	}

	//按每个颜色进行排列
	function actionRight(){
		//echo "显示计划单列表";exit;
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			//dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			//dateTo => date("Y-m-d"),
			clientId=>'',
			vatNum=>'',
			orderCode=>''
		));
		//dump($arr);
		$condition=array();
		if ($arr[clientId]!='') $condition[]=array('Order.clientId',$arr[clientId]);
		if ($arr[orderCode]!='') $condition[]=array('Order.orderCode',"%$arr[orderCode]%",'like');
		//if ($arr[vatNum]!='') $condition[] ="vatNum like '%$arr[vatNum]%'";

		//if ($arr[key]!='') $condition[] = array('Pdg.vatNum',$arr[key]);
		//if ($arr[key]!='') $condition[] = array('Order.orderCode',$arr[key]);
		//if ($arr[supplierId]!='') $condition[] = array('Order.clientId', $arr[supplierId]);
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset = $pager->findAll();
		//dump($rowset[0]);
		if(count($rowset)>0) foreach($rowset as & $row) {
			$row[_edit] = "<a href='".$this->_url('right1',array(
				//'orderCode'=>$row[Order][orderCode]
				orderId =>$row[orderId]
			))."' target='_blank'>详细</a>";
			$row[dateOrder] = $row[Order][dateOrder];
			$row[dateJiaohuo] = $row[Order][dateJiaohuo];
			$row[orderCode] = $row[Order][orderCode];
			$cli = $this->_modelClient->find($row[Order][clientId]);
			$row[compName] = $cli[compName];
			$row[guige] = $row[Ware][wareName] . " " . $row[Ware][guige];
			if(count($row[Pdg])>0) {
				foreach($row[Pdg] as $tv) $row[cntPlan]+=$tv[cntPlanTouliao];
			}
			/*if(count($row[Pdg])==0) {
				$row[vatNum] = '<font color=red>未计划</font>';
			} else {
				$row[vatNum] = join("<br>",array_col_values($row[Pdg],'vatNum'));
			}
			//状态 开处方次数
			if(count($row[Chufang])==0) {
				$row[chufang] = "<font color=red>未开</font>";
			} else $row[chufang] = 'ok';


			$stKg = $stTongzi = $rkKg=$rkTongzi=$ckKg=$ckTongzi=0;
			if(count($row[Pdg])>0) foreach($row[Pdg] as &$v) {
				//松筒产量
				$tempCnt = $this->_modelGang->getStChanliang($v[id]);
				$stKg += $tempCnt[cntKg];
				$stTongzi += $tempCnt[cntTongzi];


				$gang = $this->_modelGang->findByField('id',$v[id]);
				//dump($gang);
				//装出笼
				if ($gang[ZhuangchulongChanliang]) foreach($gang[ZhuangchulongChanliang] as &$v1){
					$row[zcl] += $v1[cntTongzi];
				}

				//染色产量
				if ($gang[RanseChanliang]) foreach($gang[RanseChanliang] as &$v1){
					$row[rs] += $v1[cntTongzi];
				}

				//烘纱产量
				if ($gang[HongshaChanliang]) foreach($gang[HongshaChanliang] as &$v1){
					$row[hs] += $v1[cntTongzi];
				}

				//回倒
				if ($gang[HuidaoChanliang]) foreach($gang[HuidaoChanliang] as &$v1){
					$row[hd] += $v1[cntTongzi];
				}

				//入库
				if ($gang[Cprk]) foreach($gang[Cprk] as &$v1){
					$rkKg += $v1[jingKg];
					$rkTongzi += $v1[cntTongzi];
				}

				//发货
				if ($gang[Cpck]) foreach($gang[Cpck] as &$v1){
					$ckKg += $v1[jingKg];
					$ckTongzi += $v1[cntTongzi];
				}



			if($stKg>0) $row[st] = $stKg."KG(".$stTongzi."个)";
			if($rkKg>0) $row[rk] = $rkKg."KG(".$rkTongzi."个)";
			if($ckKg>0) $row[ck] = $ckKg."KG(".$ckTongzi."个)";
			*/
		}
		$arr_field_info = array(
			dateOrder => '下单日期',
			compName => '客户',
			orderCode => '订单号',
			dateJiaohuo => '交货日期',
			guige => '坯纱规格',
			color => '颜色',
			colorNum => '色号',
			cntKg => '要货数量',
			cntPlan => '已计划数',
			_edit=>'操作'
		);
		$smarty = & $this->_getView();
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList.tpl');
	}

	//直接按缸号排列出所有计划,有些颜色没有排计划，所以不能从view_dye_gang中取数据
	//比先看到订单再看详细更加直接方便
	function actionRight2() {
		//$this->_modelGang->enableLink('RanseChanliang');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			clientId=>'',
			vatNum=>'',
			orderCode=>''
		));
		$condition=array();
		if($arr[orderCode]!='') $condition[] = "orderCode like '%$arr[orderCode]%'";
		if($arr[vatNum]!='') $condition[] = "vatNum like '%$arr[vatNum]%'";
		if($arr[clientId]!='') $condition[] = "clientId='$arr[vatNum]'";


		$pager=null;
		$m = $this->_modelGang;
		$rowset=$m->findAllGang1($condition,$pager);
		//dump($rowset[0]);
		if(count($rowset)>0) foreach($rowset as & $v) {
			$v[chufang] = $m->getCntOfChufang($v[gangId]);
			$v[guige] = $v[wareName]." ".$v[guige];
			$v[st]=$m->getStChanliang($v[gangId]);
			$v[hs]=$m->getHsChanliang($v[gangId]);
			$v[hd]=$m->getHdChanliang($v[gangId]);
			$v[rs]=$m->getRanseChanliang($v[gangId]);//染色产量
			$v[ck]=$m->getCpckJingzhong($v[gangId]);//发货净重
			$v[sunhao] = number_format($v[ck]/$v[cntPlanTouliao]*100,2,".","") . '%';
			//$v[zcl]=$m->getZclChanliang($v[gangId]);
			//$v[lingliao]=$m->getCntPishaLingliao($v[gangId]);
			//echo
		}
		$smarty = $this->_getView();
		$arr_field_info = array(
			dateOrder => '下单日期',
			compName => '客户',
			orderCode => '订单号',
			guige => '坯纱规格',
			color => '颜色',
			vatNum =>'缸号',
			planDate => '计划日期',
			cntPlanTouliao => '计划投料',
			planTongzi=>'计划筒子',
			"chufang" =>"工艺",
			"st" =>"松筒",
			//"ll" =>"领料",
			//"zcl" =>"装出笼",
			"rs" =>"高台染色",
			"hs" =>"烘纱",
			"hd" =>"回倒",
			//"rk" =>"入库净重",
			"ck" =>"发货净重",
			sunhao =>'制成率'
		);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('right2',$arr)));
		$smarty->display('TableList.tpl');
	}



	//客户搜索
	function actionClientSearch(){
		if (!$_GET[clientId]) {
			redirect(url('index')); exit;
		}
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			//dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			//dateTo => date("Y-m-d"),
			//vatNum=>'',
			clientId => $_GET[clientid],
			orderCode=>''
		));
		$condition=array();
		$condition[]=array('Order.clientId',$arr[clientId]);
		if ($arr[orderCode]!='') $condition[]=array('Order.orderCode',"%$arr[orderCode]%",'like');

		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset = $pager->findAll();
		//dump($rowset[0]);
		if(count($rowset)>0) foreach($rowset as & $row) {
			$row[_edit] = "<a href='".$this->_url('right1',array(
				//'orderCode'=>$row[Order][orderCode]
				orderId =>$row[orderId]
			))."' target='_blank'>详细</a>";
			$row[dateOrder] = $row[Order][dateOrder];
			$row[dateJiaohuo] = $row[Order][dateJiaohuo];
			$row[orderCode] = $row[Order][orderCode];
			$cli = $this->_modelClient->find($row[Order][clientId]);
			$row[compName] = $cli[compName];
			$row[guige] = $row[Ware][wareName] . " " . $row[Ware][guige];
			if(count($row[Pdg])>0) {
				foreach($row[Pdg] as $tv) $row[cntPlan]+=$tv[cntPlanTouliao];
			}
		}

		$arr_field_info = array(
			dateOrder => '下单日期',
			compName => '客户',
			orderCode => '订单号',
			dateJiaohuo => '交货日期',
			guige => '坯纱规格',
			color => '颜色',
			colorNum => '色号',
			cntKg => '要货数量',
			cntPlan => '已计划数',
			_edit=>'操作'
		);

		$smarty = & $this->_getView();
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('ClientSearch',$arr)));
		$smarty->display('ClientSearch.tpl');
	}
	/**
	 * ps ：计划进度一览表(新) 可以根据订单明细信息搜索
	 * Time：2017年11月17日 14:35:11
	 * @author zcc
	*/
	function actionPlanTrace(){
		set_time_limit(0);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-15,date("Y"))),
			dateTo => date("Y-m-d"),
			//vatNum=>'',
			clientId => 0,
			orderCode=>'',
			// "saleKind"=>'',
			'kuanhao' =>'',
			'color' =>'',
			'colorNum' =>'',
			'vatNum' =>'',
			overMark=>0,
		));

		$sql = "SELECT x.*,y.id as order2wareId 
			FROM trade_dye_order x 
			left join trade_dye_order2ware y on x.id = y.orderId
			left join plan_dye_gang p on p.order2wareId = y.id
			where x.dateOrder>='{$arr['dateFrom']}' and x.dateOrder<='{$arr['dateTo']}'";
		if ($arr['clientId']>0) $sql.= " and x.clientId='{$arr[clientId]}'";
		if ($arr['orderCode']!='') $sql.= " and x.orderCode like '%{$arr[orderCode]}%'";
		if ($arr['vatNum']!='') $sql.= " and p.vatNum like '%{$arr[vatNum]}%'";
		if ($arr['kuanhao']!='') $sql.= " and y.kuanhao like '%{$arr[kuanhao]}%'";
		if ($arr['color']!='') $sql.= " and y.color like '%{$arr[color]}%'";
		if ($arr['colorNum']!='') $sql.= " and y.colorNum like '%{$arr[colorNum]}%'";
		$sql .= " group by x.id  order by x.id desc";
		$rowset = $this->_modelExample->findBySql($sql);
		// dump($rowset);die();
		if($rowset)foreach ($rowset as &$v) {
			$mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
			$mOrder->disableLink('Ware');
			$order = $mOrder->find($v['id']);
			// dump($order);die();
			$sql2 = "SELECT x.*,y.id as order2wareId 
			FROM trade_dye_order x 
			left join trade_dye_order2ware y on x.id = y.orderId
			left join plan_dye_gang p on p.order2wareId = y.id
			where x.id = '{$v['id']}' and ";
			$condition['orderId'] = $v['id'];
			
			if ($arr['kuanhao']!='') $condition[] = array('kuanhao',"%".$arr['kuanhao']."%",'like');
			if ($arr['color']!='') $condition[] = array('color',"%".$arr['color']."%",'like');
			if ($arr['colorNum']!='') $condition[] = array('colorNum',"%".$arr['colorNum']."%",'like');
			if ($arr['vatNum']!='')$condition[] = array('Pdg.vatNum',"%".$arr['vatNum']."%",'like');
			//dump($condition);die;
			$order2ware = $this->_modelExample->findAll($condition);
			//dump($order2ware);die;
			$order['Ware'] = $order2ware;
			$v = $order;
			$v = $mOrder->formatRet($v);
			//设置是否显示的标记
			if ($arr['overMark']==0) {//显示未完成
				$found = false;
				if($v['Ware'])
				foreach ($v['Ware'] as & $aWare) {
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						$aGang['cntPlanTouliao'] = round($aGang['cntPlanTouliao'],2);
						if (!$aGang['haveFh']){//如果有未完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif($arr['overMark']==1) {//显示已完成
				$found = false;
				if($v['Ware'])
					foreach ($v['Ware'] as & $aWare) {
					//dump($aWare);exit;
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if ($aGang['haveFh']){//如果有已完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif ($arr['overMark']==2) {//显示全部
				if($v['Ware']) foreach ($v['Ware'] as & $aWare) {
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						$aGang['isShow']  = true;
					}
					$aWare['isShow'] = true;
				}
				$v['isShow'] = true;
			}		
		}
		// dump($rowset);die();
		foreach($rowset as & $v){
		    //dump($v);
		    if($v['isShow']==1){
			//dump($v);
			foreach($v['Ware'] as $key=>& $vv){
			    //dump($key);
				foreach($vv['Gang'] as & $gang){
					//当存在回修缸号时 回修缸的经纬合计 不进行叠加到合计栏 by zcc 2017年12月6日 10:07:41
					$gang['cntPlanTouliao2'] = $gang['cntPlanTouliao'];
					if ($gang['parentGangId']>0) {
						$gang['cntPlanTouliao2'] = '';
					}
					if(count($gang['RanseChanliang'])>0){
						$gang['haveRs']=1;
						$c=$i=0;
						foreach($gang['RanseChanliang'] as & $g){
							if($g['type']=='分套同班'||$g['type']=='套棉'){
								$c++;
							}elseif($g['type']=='分散'){
								$i++;
							}
						}
						if($c>0){
							$gang['haveRs']=3;
						}elseif($i>0){
							$gang['haveRs']=2;
						}
					}
				}
			    if($vv['isShow']==1){
				$vv['wareName2guige']=$vv['Ware']['wareName'].' '.$vv['Ware']['guige'];
			    }
			}
			$v['Ware']=array_group_by($v['Ware'],'wareName2guige');
		    }
		}
		$smarty = & $this->_getView();
		$smarty->assign("orders",$rowset);
		$smarty->assign('url_daochu', $this->_url('export2excel',$arr));
		//$smarty->assign("orders",$arr_field_info);
		$smarty->assign("arr_condition",$arr);
		$smarty->assign("add_display",'none');
		$smarty->display('Plan/PlanTrace.tpl');
	}
	/**
	 * ps ：给财务对账栏目添加一个有单价和小缸价的计划进度一览表
	 * Time：2017年11月30日 13:20:52
	 * @author zcc
	*/
	function actionPlanTrace2(){
		$this->authCheck(145);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-15,date("Y"))),
			dateTo => date("Y-m-d"),
			//vatNum=>'',
			clientId => 0,
			orderCode=>'',
			// "saleKind"=>'',
			'kuanhao' =>'',
			'color' =>'',
			'colorNum' =>'',
			'vatNum' =>'',
			overMark=>0,
		));

		$sql = "SELECT x.*,y.id as order2wareId,y.danjia,y.money
			FROM trade_dye_order x 
			left join trade_dye_order2ware y on x.id = y.orderId
			left join plan_dye_gang p on p.order2wareId = y.id
			where x.dateOrder>='{$arr['dateFrom']}' and x.dateOrder<='{$arr['dateTo']}'";
		if ($arr['clientId']>0) $sql.= " and x.clientId='{$arr[clientId]}'";
		if ($arr['orderCode']!='') $sql.= " and x.orderCode like '%{$arr[orderCode]}%'";
		if ($arr['vatNum']!='') $sql.= " and p.vatNum like '%{$arr[vatNum]}%'";
		if ($arr['kuanhao']!='') $sql.= " and y.kuanhao like '%{$arr[kuanhao]}%'";
		if ($arr['color']!='') $sql.= " and y.color like '%{$arr[color]}%'";
		if ($arr['colorNum']!='') $sql.= " and y.colorNum like '%{$arr[colorNum]}%'";
		$sql .= " group by x.id  order by x.id desc";
		$rowset = $this->_modelExample->findBySql($sql);
		// dump($rowset);die();
		if($rowset)foreach ($rowset as &$v) {
			$mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
			$mOrder->disableLink('Ware');
			$order = $mOrder->find($v['id']);
			// dump($order);die();
			$sql2 = "SELECT x.*,y.id as order2wareId,y.danjia,y.money
			FROM trade_dye_order x 
			left join trade_dye_order2ware y on x.id = y.orderId
			left join plan_dye_gang p on p.order2wareId = y.id
			where x.id = '{$v['id']}' and ";
			$condition['orderId'] = $v['id'];
			
			if ($arr['kuanhao']!='') $condition[] = array('kuanhao',"%".$arr['kuanhao']."%",'like');
			if ($arr['color']!='') $condition[] = array('color',"%".$arr['color']."%",'like');
			if ($arr['colorNum']!='') $condition[] = array('colorNum',"%".$arr['colorNum']."%",'like');
			if ($arr['vatNum']!='')$condition[] = array('Pdg.vatNum',"%".$arr['vatNum']."%",'like');

			$order2ware = $this->_modelExample->findAll($condition);
			$order['Ware'] = $order2ware;
			$v = $order;
			$v = $mOrder->formatRet($v);
			// dump($v);die();
			//设置是否显示的标记
			if ($arr['overMark']==0) {//显示未完成
				$found = false;
				if($v['Ware'])
				foreach ($v['Ware'] as & $aWare) {
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if (!$aGang['haveFh']){//如果有未完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif($arr['overMark']==1) {//显示已完成
				$found = false;
				if($v['Ware'])
					foreach ($v['Ware'] as & $aWare) {
					//dump($aWare);exit;
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if ($aGang['haveFh']){//如果有已完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif ($arr['overMark']==2) {//显示全部
				if($v['Ware']) foreach ($v['Ware'] as & $aWare) {
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						$aGang['isShow']  = true;
					}
					$aWare['isShow'] = true;
				}
				$v['isShow'] = true;
			}		
		}
		// dump($rowset);die();
		foreach($rowset as & $v){
		    //dump($v);
		    if($v['isShow']==1){
			//dump($v);
			foreach($v['Ware'] as $key=>& $vv){
			    //dump($key);
				foreach($vv['Gang'] as & $gang){
					//当存在回修缸号时 回修缸的经纬合计 不进行叠加到合计栏 by zcc 2017年12月6日 10:07:41
					$gang['cntPlanTouliao2'] = $gang['cntPlanTouliao'];
					if ($gang['parentGangId']>0) {
						$gang['cntPlanTouliao2'] = '';
					}
					if(count($gang['RanseChanliang'])>0){
						$gang['haveRs']=1;
						$c=$i=0;
						foreach($gang['RanseChanliang'] as & $g){
							if($g['type']=='分套同班'||$g['type']=='套棉'){
								$c++;
							}elseif($g['type']=='分散'){
								$i++;
							}
						}
						if($c>0){
							$gang['haveRs']=3;
						}elseif($i>0){
							$gang['haveRs']=2;
						}
					}
				}
			    if($vv['isShow']==1){
				$vv['wareName2guige']=$vv['Ware']['wareName'].' '.$vv['Ware']['guige'];
			    }
			}
			$v['Ware']=array_group_by($v['Ware'],'wareName2guige');
		    }
		}
		$smarty = & $this->_getView();
		$smarty->assign("orders",$rowset);
		$smarty->assign('url_daochu', $this->_url('export2excel',$arr));
		//$smarty->assign("orders",$arr_field_info);
		$smarty->assign("add_display",'none');
		$smarty->assign("arr_condition",$arr);
		$smarty->display('Plan/PlanTrace2.tpl');
	}


	//计划进度一览表
	function  actionPlanTraceOld(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-15,date("Y"))),
			dateTo => date("Y-m-d"),
			//vatNum=>'',
			clientId => 0,
			orderCode=>'',
			// "saleKind"=>'',
			'kuanhao' =>'',
			'color' =>'',
			'colorNum' =>'',
			'vatNum' =>'',
			overMark=>0,
		));

		$sql = "SELECT x.*,y.id as order2wareId 
			FROM trade_dye_order x 
			left join trade_dye_order2ware y on x.id = y.orderId
			left join plan_dye_gang p on p.order2wareId = y.id
			where x.dateOrder>='{$arr['dateFrom']}' and x.dateOrder<='{$arr['dateTo']}'";
		if ($arr['clientId']>0) $sql.= " and x.clientId='{$arr[clientId]}'";
		if ($arr['orderCode']!='') $sql.= " and x.orderCode like '%{$arr[orderCode]}%'";
		if ($arr['vatNum']!='') $sql.= " and p.vatNum like '%{$arr[vatNum]}%'";
		if ($arr['kuanhao']!='') $sql.= " and y.kuanhao like '%{$arr[kuanhao]}%'";
		if ($arr['color']!='') $sql.= " and y.color like '%{$arr[color]}%'";
		if ($arr['colorNum']!='') $sql.= " and y.colorNum like '%{$arr[colorNum]}%'";
		$sql .= " group by x.id  order by x.id desc";
		$rowset = $this->_modelExample->findBySql($sql);
		if($rowset)
		foreach($rowset as & $v) {
			$mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
			$mOrder->disableLink('Ware');
			$order = $mOrder->find($v['id']);
			// dump($order);die();
			$sql2 = "SELECT x.*,y.id as order2wareId 
			FROM trade_dye_order x 
			left join trade_dye_order2ware y on x.id = y.orderId
			left join plan_dye_gang p on p.order2wareId = y.id
			where x.id = '{$v['id']}' and ";
			$condition['orderId'] = $v['id'];
			
			if ($arr['kuanhao']!='') $condition[] = array('kuanhao',"%".$arr['kuanhao']."%",'like');
			if ($arr['color']!='') $condition[] = array('color',"%".$arr['color']."%",'like');
			if ($arr['colorNum']!='') $condition[] = array('colorNum',"%".$arr['colorNum']."%",'like');
			if ($arr['vatNum']!='')$condition[] = array('Pdg.vatNum',"%".$arr['vatNum']."%",'like');

			$order2ware = $this->_modelExample->findAll($condition);
			$order['Ware'] = $order2ware;
			$v = $order;
			$v = $mOrder->formatRet($v);
			//设置是否显示的标记
			if ($arr['overMark']==0) {//显示未完成
				$found = false;
				if($v['Ware'])
				foreach ($v['Ware'] as & $aWare) {
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if (!$aGang['haveFh']){//如果有未完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif($arr['overMark']==1) {//显示已完成
				$found = false;
				if($v['Ware'])
					foreach ($v['Ware'] as & $aWare) {
					//dump($aWare);exit;
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if ($aGang['haveFh']){//如果有已完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif ($arr['overMark']==2) {//显示全部
				if($v['Ware']) foreach ($v['Ware'] as & $aWare) {
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						$aGang['isShow']  = true;
					}
					$aWare['isShow'] = true;
				}
				$v['isShow'] = true;
			}
		}
		foreach($rowset as & $v){
		    //dump($v);
		    if($v['isShow']==1){
			//dump($v);
			foreach($v['Ware'] as $key=>& $vv){
			    //dump($key);
				foreach($vv['Gang'] as & $gang){
					if(count($gang['RanseChanliang'])>0){
						$gang['haveRs']=1;
						$c=$i=0;
						foreach($gang['RanseChanliang'] as & $g){
							if($g['type']=='分套同班'||$g['type']=='套棉'){
								$c++;
							}elseif($g['type']=='分散'){
								$i++;
							}
						}
						if($c>0){
							$gang['haveRs']=3;
						}elseif($i>0){
							$gang['haveRs']=2;
						}
					}
				}
			    if($vv['isShow']==1){
				$vv['wareName2guige']=$vv['Ware']['wareName'].' '.$vv['Ware']['guige'];
			    }
			}
			$v['Ware']=array_group_by($v['Ware'],'wareName2guige');
		    }
		}
		//dump($rowset);exit();
		$smarty = & $this->_getView();
		$smarty->assign("orders",$rowset);
		$smarty->assign('url_daochu', $this->_url('export2excel',$arr));
		//$smarty->assign("orders",$arr_field_info);
		$smarty->assign("arr_condition",$arr);

		$smarty->display('Plan/PlanTrace.tpl');
	}
	/**
	 * ps ：
	 * Time：2017年11月17日 15:55:57
	 * @author zcc
	*/
	function actionExport2excel(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-15,date("Y"))),
			dateTo => date("Y-m-d"),
			//vatNum=>'',
			clientId => 0,
			orderCode=>'',
			overMark=>0,
			"saleKind"=>''
		));

		$condition = array(
			array('dateOrder',$arr['dateFrom'],'>='),
			array('dateOrder',$arr['dateTo'],'<=')
		);
		if ($arr['clientId']>0) $condition['clientId'] = $arr['clientId'];
		if ($arr['orderCode']!='') $condition[] = array('orderCode',"%".$arr['orderCode']."%",'like');
		if ($arr['saleKind']!='') $condition[] = array('saleKind',"{$arr['saleKind']}",'=');
		$mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$rowset = $mOrder->findAll($condition);
		//dump($rowset[0]); exit;

		if($rowset)
		foreach($rowset as & $v) {
			$v = $mOrder->formatRet($v);
			//设置是否显示的标记
			if ($arr['overMark']==0) {//显示未完成
				$found = false;
				if($v['Ware'])
				foreach ($v['Ware'] as & $aWare) {
					//dump($aWare['personDayangName']);exit();
					if ($aWare['personDayangName'] == '<font color=#cccccc>未指定</font>') {
						$aWare['personDayangName'] = '未指定';
					}
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if (!$aGang['haveFh']){//如果有未完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif($arr['overMark']==1) {//显示已完成
				$found = false;
				if($v['Ware'])
					foreach ($v['Ware'] as & $aWare) {
					//dump($aWare);exit;
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if ($aGang['haveFh']){//如果有已完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif ($arr['overMark']==2) {//显示全部
				if($v['Ware']) foreach ($v['Ware'] as & $aWare) {
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						$aGang['isShow']  = true;
					}
					$aWare['isShow'] = true;
				}
				$v['isShow'] = true;
			}
		}
		//dump($rowset);exit();
		foreach($rowset as & $v){
		    //dump($v);
		    if($v['isShow']==1){
			//dump($v);
			foreach($v['Ware'] as $key=>& $vv){
			    //dump($key);
				foreach($vv['Gang'] as & $gang){
					if(count($gang['RanseChanliang'])>0){
						$gang['haveRs']=1;
						$c=$i=0;
						foreach($gang['RanseChanliang'] as & $g){
							if($g['type']=='分套同班'||$g['type']=='套棉'){
								$c++;
							}elseif($g['type']=='分散'){
								$i++;
							}
						}
						if($c>0){
							$gang['haveRs']=3;
						}elseif($i>0){
							$gang['haveRs']=2;
						}
					}
				}
			    if($vv['isShow']==1){
				$vv['wareName2guige']=$vv['Ware']['wareName'].' '.$vv['Ware']['guige'];
			    }
			}
			$v['Ware']=array_group_by($v['Ware'],'wareName2guige');
		    }
		}
		//dump($rowset);exit();
		$title = '计划进度列表';
		$smarty = & $this->_getView();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment;filename={$title}.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty->assign('title','计划进度列表');
		//$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign("orders",$rowset);
		$smarty->display('Plan/JinduExport.tpl');
	}
	function actionExport2excelOld(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-15,date("Y"))),
			dateTo => date("Y-m-d"),
			//vatNum=>'',
			clientId => 0,
			orderCode=>'',
			overMark=>0,
			"saleKind"=>''
		));

		$condition = array(
			array('dateOrder',$arr['dateFrom'],'>='),
			array('dateOrder',$arr['dateTo'],'<=')
		);
		if ($arr['clientId']>0) $condition['clientId'] = $arr['clientId'];
		if ($arr['orderCode']!='') $condition[] = array('orderCode',"%".$arr['orderCode']."%",'like');
		if ($arr['saleKind']!='') $condition[] = array('saleKind',"{$arr['saleKind']}",'=');
		$mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$rowset = $mOrder->findAll($condition);
		//dump($rowset[0]); exit;

		if($rowset)
		foreach($rowset as & $v) {
			$v = $mOrder->formatRet($v);
			//dump($v);exit();
			//设置是否显示的标记
			if ($arr['overMark']==0) {//显示未完成
				$found = false;
				if($v['Ware'])
				foreach ($v['Ware'] as & $aWare) {
					//dump($aWare['personDayangName']);exit();
					if ($aWare['personDayangName'] == '<font color=#cccccc>未指定</font>') {
						$aWare['personDayangName'] = '未指定';
					}
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if (!$aGang['haveFh']){//如果有未完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif($arr['overMark']==1) {//显示已完成
				$found = false;
				if($v['Ware'])
					foreach ($v['Ware'] as & $aWare) {
					//dump($aWare);exit;
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						if ($aGang['haveFh']){//如果有已完成的缸,需要显示
							$found = true;
							$aGang['isShow']  = true;
						}
					}
					if ($found) $aWare['isShow'] = true;
				}
				if ($found) $v['isShow'] = true;
			} elseif ($arr['overMark']==2) {//显示全部
				if($v['Ware']) foreach ($v['Ware'] as & $aWare) {
					if($aWare['Gang']) foreach($aWare['Gang'] as & $aGang) {
						$aGang['isShow']  = true;
					}
					$aWare['isShow'] = true;
				}
				$v['isShow'] = true;
			}
		}
		//dump($rowset);exit();
		foreach($rowset as & $v){
		    //dump($v);
		    if($v['isShow']==1){
			//dump($v);
			foreach($v['Ware'] as $key=>& $vv){
			    //dump($key);
				foreach($vv['Gang'] as & $gang){
					if(count($gang['RanseChanliang'])>0){
						$gang['haveRs']=1;
						$c=$i=0;
						foreach($gang['RanseChanliang'] as & $g){
							if($g['type']=='分套同班'||$g['type']=='套棉'){
								$c++;
							}elseif($g['type']=='分散'){
								$i++;
							}
						}
						if($c>0){
							$gang['haveRs']=3;
						}elseif($i>0){
							$gang['haveRs']=2;
						}
					}
				}
			    if($vv['isShow']==1){
				$vv['wareName2guige']=$vv['Ware']['wareName'].' '.$vv['Ware']['guige'];
			    }
			}
			$v['Ware']=array_group_by($v['Ware'],'wareName2guige');
		    }
		}
		//dump($rowset);exit();
		$title = '计划进度列表';
		$smarty = & $this->_getView();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment;filename={$title}.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty->assign('title','计划进度列表');
		//$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign("orders",$rowset);

		$smarty->display('Plan/JinduExport.tpl');
	}



	function actionhdList(){
		$mhd= & FLEA::getSingleton('Model_Chejian_HuidaoChanliang');
		$mgang=  & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr=$mhd->findAll(array('gangId'=>$_GET['gangId']));
		//dump($arr);exit;
		foreach($arr as &$v) {
			$v[vatNum] = $v[Vat][vatNum];
			$con = array("gangId='$v[gangId]'");
			$gang =$mgang->findAllGang1($con);
			$v = array_merge($v,$gang[0]);
		}
		//dump($arr);exit;
		$arr_field_info=array(
			dateInput=>'日期',
			dt=>'录入时间',
			compName=>"客户",
			orderCode=>"订单号",
			vatNum=>"缸号",
			guige=>"纱支",
			color=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数'
		);
		$smarty=& $this->_getView();
		$smarty->assign('title','回倒产量明细');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('nav_display','none');
		$smarty->display('TableList.tpl');
	}

	function actionstList(){
		$mst= & FLEA::getSingleton('Model_Chejian_SongtongChanliang');
		$mst->enableLink('VatView');
		$arr=$mst->findAll(array('gangId'=>$_GET['gangId']));
		//dump($arr);
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'		=>'日期',
			'VatView.compName'		=>"客户",
			'VatView.orderCode'		=>"订单号",
			'VatView.vatNum'		=>"缸号",
			'VatView.guige'			=>"纱支",
			'VatView.color'			=>"颜色",
			'workerCode'	=>'工号',
			'netWeight'		=>'净重',
			'cntTongzi'		=>'筒子数',
			//'dt'			=>'录入时间'
		));
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('nav_display','none');
		$smarty->display('TableList.tpl');
	}
	function actionzclList(){
		$mchl= & FLEA::getSingleton('Model_Chejian_ZhuangchulongChanliang');
		$mchl->enableLink('VatView');
		$mgang=  & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr=$mchl->findAll(array('gangId'=>$_GET['gangId']));
		foreach($arr as &$v) {
			$v[vatNum] = $v[Vat][vatNum];
			$con = array("gangId='$v[gangId]'");
			$gang = $mgang->findAllGang1($con);
			if(count($gang)>0) $v = array_merge($v,$gang[0]);
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateInput=>'日期',
			'VatView.compName'=>"客户",
			'VatView.orderCode'=>"订单号",
			'VatView.vatNum'=>"缸号",
			'VatView.guige'=>"纱支",
			'VatView.color'=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数',
		));
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('nav_display','none');
		$smarty->display('TableList.tpl');
	}
	function actionrsList(){
		$mrs= & FLEA::getSingleton('Model_Chejian_RanseChanliang');
		$mgang=  & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr=$mrs->findAll(array('gangId'=>$_GET['gangId']));
		foreach($arr as &$v) {
			$v[vatNum] = $v[Vat][vatNum];
			$con = array("gangId='$v[gangId]'");
			$gang = $mgang->findAllGang1($con);
			if(count($gang)>0) $v = array_merge($v,$gang[0]);
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateInput=>'日期',
			//dt=>'录入时间',
			compName=>"客户",
			orderCode=>"订单号",
			vatNum=>"缸号",
			type=>"类别",
			guige=>"纱支",
			color=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数',
		));
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('nav_display','none');
		$smarty->display('TableList.tpl');
	}
	function actionhsList(){
		$mrs= & FLEA::getSingleton('Model_Chejian_HongshaChanliang');
		$mgang=  & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr=$mrs->findAll(array('gangId'=>$_GET['gangId']));
		foreach($arr as &$v) {
			$v[vatNum] = $v[Vat][vatNum];
			$con = array("gangId='$v[gangId]'");
			$gang = $mgang->findAllGang1($con);
			if(count($gang)>0) $v = array_merge($v,$gang[0]);
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateInput=>'日期',
			//dt=>'录入时间',
			compName=>"客户",
			orderCode=>"订单号",
			vatNum=>"缸号",
			guige=>"纱支",
			color=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数'
		));
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('nav_display','none');
		$smarty->display('TableList.tpl');
	}
	function actiondbList(){
		$mrs= & FLEA::getSingleton('Model_Chejian_DabaoChanliang');
		$mgang=  & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr=$mrs->findAll(array('gangId'=>$_GET['gangId']));
		foreach($arr as &$v) {
			$v[vatNum] = $v[Vat][vatNum];
			$con = array("gangId='$v[gangId]'");
			$gang = $mgang->findAllGang1($con);
			if(count($gang)>0) $v = array_merge($v,$gang[0]);
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateInput=>'日期',
			dt=>'录入时间',
			compName=>"客户",
			orderCode=>"订单号",
			vatNum=>"缸号",
			guige=>"纱支",
			color=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数'
		));
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('nav_display','none');
		$smarty->display('TableList.tpl');
	}
	function actionckList(){
		$mrs= & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$mgang=  & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr=$mrs->findAll(array('planId'=>$_GET['planId']));
		foreach($arr as &$v) {
			$v[vatNum] = $v[Vat][vatNum];
			$con = array("gangId='$v[planId]'");
			$gang = $mgang->findAllGang1($con);
			if(count($gang)>0) $v = array_merge($v,$gang[0]);
		}
		//dump($arr);exit;
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateCpck=>'出库日期',
			//dt=>'录入时间',
			compName=>"客户",
			orderCode=>"订单号",
			vatNum=>"缸号",
			guige=>"纱支",
			color=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数',
			'jingKg'=>'出库数',
		));
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('nav_display','none');
		$smarty->display('TableList.tpl');
	}
	function actionrkList(){
		$mrs= & FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
		$mgang=  & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr=$mrs->findAll(array('planId'=>$_GET['planId']));
		foreach($arr as &$v) {
			$v[vatNum] = $v[Vat][vatNum];
			$con = array("gangId='$v[planId]'");
			$gang = $mgang->findAllGang1($con);
			if(count($gang)>0) $v = array_merge($v,$gang[0]);
		}
		//dump($arr);exit;
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			dateCprk=>'入库日期',
			//dt=>'录入时间',
			compName=>"客户",
			orderCode=>"订单号",
			vatNum=>"缸号",
			guige=>"纱支",
			color=>"颜色",
			workerCode=>'工号',
			cntTongzi=>'筒子数',
			'jingKg'=>'入库数',
		));
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('nav_display','none');
		$smarty->display('TableList.tpl');
	}

}
?>