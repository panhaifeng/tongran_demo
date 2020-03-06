<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Trade_Dye_Order extends Tmis_Controller {
	var $_modelExample;
	var $funcId, $readFuncId, $addFuncId, $editFuncId, $delFuncId;

	function Controller_Trade_Dye_Order() {
		$this->_modelExample = & FLEA::getSingleton('Model_Trade_Dye_Order');
		//$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_pkName = $this->_modelExample->primaryKey;
		$this->_setFuncId();
	}

	#当日排缸列表
	function actionRight1() {
		$this->authCheck($this->readFuncId);
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'clientId'	=>'',
			'orderCode' =>'',
			'vatNum'=>'',
			// 'isPlan' =>'0',
		));

		$sql = "select *,sum(cntPlanTouliao)+0 as cntPlan
		from view_dye_all
		where dateOrder>='".date('Y-m-d',mktime(0,0,0,date('m'),date('d')-60,date('Y')))."'";
		//and dateOrder>='{$arr['dateFrom']}' and dateOrder<='{$arr['dateTo']}'
		if ($arr[clientId]>0) $sql.= " and clientId='{$arr[clientId]}'";
		if ($arr[orderCode]!='') $sql.= " and orderCode like '%{$arr[orderCode]}%'";
		if ($arr[vatNum]!='') $sql.= " and vatNum like '%{$arr[vatNum]}%'";
		$sql.= " group by orderId ";
		if ($arr[isPlan]=='1') $sql.= "having cntPlan > 0";
		if ($arr[isPlan]=='0') $sql.= "having cntPlan is null";
		$sql.=" order by orderId desc";
		$rowset=$this->_modelExample->findBySql($sql);
		$TotalcntPlan=0;
		if($rowset) foreach($rowset as $key=> & $v) {
			//dump($v);
			$v['dateOrder'] = "<a href='".$this->_url('right',array(
				'dateFrom'=>$v['dateOrder'],
				'dateTo'=>$v['dateOrder']
			))."'>".$v['dateOrder']."</a>";
			$v['compName'] = "<a href='".$this->_url('right',array(
				'clientId'=>$v['clientId']
			))."'>".$v['compName']."</a>";
			$v['guige'] = $this->_modelExample->getGuigeDescByWare($v['orderId']);
			$v['cntYaohuo'] = $this->_modelExample->getCntYaohuo($v['orderId']);

			if($v['cntPlan']>=$v['cntYaohuo']){unset($rowset[$key]); continue;}
			$v['cntPlan']+=0;
			$cntYaohuo+=$v['cntYaohuo'];
			$cntPlan+=$v['cntPlan'];
			$v['cntPlanN'] = $v['cntYaohuo']-$v['cntPlan'];
			$cntPlanN+=$v['cntPlanN'];
			//$TotalcntPlan+=$v['cntPlan'];
			$v['orderCode']=$this->_modelExample->getOrderTrack($v[orderId],$v[orderCode]);
			 //得到客户单号
			$clientCode=$this->_modelExample->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			if($v['cntPlan']!=$v['cntYaohuo']) $v['cntPlan'] = "<font color='red'>{$v['cntPlan']}</font>";
			$v['cntPlanN'] = "<font color='blue'>{$v['cntPlanN']}</font>";
			$v['_edit'] = '<a href="'.url("CangKu_Report_Month",'right1',array('clientId'=>$v['clientId'])).'" target="_blank">查看坯纱</a> ' . "<a href='".$this->_url('Edit',array('id'=>$v['orderId'],'page'=>'paigang'))."'>修改</a>" . ' ' . $this->getRemoveHtml($v['orderId']);
		}
		 $heji=array(
			'compName'=>'<b>总计</b>',
		    "orderCode" =>"",
			"dateOrder" =>"",
			"dateJiaohuo" => "",
			"colorNum" => "",
			"guige" => "",
			"cntYaohuo" => $cntYaohuo,
			"cntPlan"=>$cntPlan,
			"cntPlanN"=>$cntPlanN,
			'_edit'=>''
			);
        //$heji=$this->getHeji($rowset,array('cntYaohuo'),'compName');
		//$heji['cntPlan']=$TotalcntPlan;
		$rowset[]=$heji;
		#对操作栏进行赋值

		$arrFieldInfo = array(
			"compName" =>"客户(客户单号)[<a href='".$this->_url($_GET['action'],array('clientId'=>0))."'>全部</a>]",
			"orderCode" =>"合同编号",
			"dateOrder" =>"定单日期",
			"dateJiaohuo" => "交货日期",
			"colorNum" => "色号",
			"guige" => "规格:总数",
			"cntYaohuo" => "本单总数",
			"cntPlan"=>"已排计划数",
			'cntPlanN'=>'未排计划数',
			//"other" => "其他",
			'_edit'=>'操作'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', '筒染订单');

		if ($_GET[display] == '') {	//display为空,就代表要显示全部
			$smarty->assign('arr_edit_info',$arr_edit_info);
			//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
			$smarty->assign('arr_condition', $arrGet);
		}
		else{
			$smarty->assign('add_display', 'none');
			$smarty->assign('page_info',"<a href='".url('plan_dye','paigangSchedule')."' target='_blank'>显示排缸表</a>");
			//$smarty->assign('arr_condition', $arrGet);
		}

		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('other_search_item',$cHtml);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('pk',$this->_modelExample->primaryKey);
		$smarty->assign('page_info','<font color="red">本页显示的为60天内计划数与投料数不符的所有订单数据</font>');
		$smarty->display('TableList.tpl');
	}
	//销售定单列表
	function actionRight() {
		$this->authCheck($this->readFuncId);
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'	=>date("Y-m-d"),
			'dateTo'	=>date("Y-m-d"),
			'clientId'	=>'',
			'orderCode' =>'',
			'vatNum'=>'',
			'zhishu'=>''
		));
		$sql = "select *,sum(cntPlanTouliao) as cntPlan
		from view_dye_all
		where dateOrder>='{$arr['dateFrom']}' and dateOrder<='{$arr['dateTo']}'";
		if ($arr['clientId']>0) $sql.= " and clientId='{$arr[clientId]}'";
		if ($arr['orderCode']!='') $sql.= " and orderCode like '%{$arr[orderCode]}%'";
		if ($arr['vatNum']!='') $sql.= " and vatNum like '%{$arr[vatNum]}%'";
		if ($arr['zhishu']!='') $sql.= " and wareName like '%{$arr[zhishu]}%'";
		$sql.= " group by orderId order by orderId desc";
		//echo $sql;
		$pager = & new TMIS_Pager($sql);
		$rowset=$pager->findAll();

		//dump($rowset[1]);exit;
		// dump($rowset);die();
		//sql 问中添加了 and parentGangId=0 只显示原缸的数据投料叠加，但是有些数据客户把原缸删除，那只能去调取这个原缸的回修数据（最后一条的回修数据）
		$TotalcntPlan=0;
		if($rowset) foreach($rowset as $key=> & $v) {
			//dump($v);exit;
			$v['cntPlan'] += 0;
			$v['dateOrder'] = "<a href='".$this->_url('right',array(
				'dateFrom'=>$v['dateOrder'],
				'dateTo'=>$v['dateOrder']
			))."'>".$v['dateOrder']."</a>";
			$v['compName'] = "<a href='".$this->_url('right',array(
				'clientId'=>$v['clientId']
			))."'>".$v['compName']."</a>";
			$v['guige'] = $this->_modelExample->getGuigeDescByWare($v['orderId']);
			$v['cntYaohuo'] = $this->_modelExample->getCntYaohuo($v['orderId']);
			//$v['cntPlan']+=0;
			$cntYaohuo+=$v['cntYaohuo'];
			$cntPlan+=$v['cntPlan'];
			//if($v['cntPlan']>=$v['cntYaohuo']){unset($rowset[$key]); continue;}
			//$TotalcntPlan+=$v['cntPlan'];
			$v['orderCode']=$this->_modelExample->getOrderTrack($v[orderId],$v[orderCode]);
			if($v['cntPlan']!=$v['cntYaohuo']) $v['cntPlan'] = "<font color='red'>{$v['cntPlan']}</font>";
			//得到客户单号
			$clientCode=$this->_modelExample->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			$v['_edit'] = '<a href="'.url("CangKu_Report_Month",'right1',array('clientId'=>$v['clientId'])).'" target="_blank">查看坯纱</a> ' . "<a href='".$this->_url('Edit',array('id'=>$v['orderId'],'page'=>'EnterOrder'))."'>修改</a>" . ' ' . $this->getRemoveHtml($v['orderId']);
		}

		//合计
        $heji=array(
			'compName'=>'<b>本页合计</b>',
		    "orderCode" =>"",
			"dateOrder" =>"",
			"dateJiaohuo" => "",
			"colorNum" => "",
			"guige" => "",
			"cntYaohuo" => $cntYaohuo,
			"cntPlan"=>$cntPlan,
			'_edit'=>''
			);
		$rowset[]=$heji;

		//总计
		$sql2="SELECT cntKg, orderId, order2wareId, gangId, vatCode, vatNum, count( DISTINCT order2wareId ) , count( * )
					FROM view_dye_all
		where dateOrder>='{$arr['dateFrom']}' and dateOrder<='{$arr['dateTo']}'";
		if ($arr['clientId']>0) $sql2.= " and clientId='{$arr[clientId]}'";
		if ($arr['orderCode']!='') $sql2.= " and orderCode like '%{$arr[orderCode]}%'";
		if ($arr['vatNum']!='') $sql2.= " and vatNum like '%{$arr[vatNum]}%'";
		if ($arr['zhishu']!='') $sql2.= " and wareName like '%{$arr[zhishu]}%'";
		$sql2.=" GROUP BY order2wareId";
		//echo $sql2;
		$arr2=$this->_modelExample->findBySql($sql2);
		//dump($arr2);
		foreach($arr2 as & $v){
			$zongji['cntYaohuo']+=$v['cntKg'];
			if($v['order2wareId']>0) {
				$sql3="select cntPlanTouliao,parentGangId from view_dye_all where order2wareId=".($v['order2wareId']+0);
				$temp=$this->_modelExample->findBySql($sql3);
				foreach($temp as $vv){
					$zongji['cntPlan']+=$vv['cntPlanTouliao'];
					// if ($vv['parentGangId']==0) {//如果是原缸号 直接叠加
					// 	$zongji['cntPlan']+=$vv['cntPlanTouliao'];
					// }else{//当为 回修缸号时
					// 	//先判断这个原缸号是否存在（被删除）如果不存在则
					// 	$sql = "SELECT * FROM plan_dye_gang where id ='{$vv['parentGangId']}'";
					// 	$Yuangang = $this->_modelExample->findBySql($sql);
					// 	if (count($Yuangang)>=1) {//原缸号存在 则不计算回修缸

					// 	}else{//不存在原缸号 只去计算最后一条回修缸
					// 		$sql = "SELECT * FROM plan_dye_gang WHERE parentGangId = '{$vv['parentGangId']}' order by id desc limit 0,1";
					// 		$huixiuGang = $this->_modelExample->findBySql($sql);
					// 		if ($huixiuGang[0]['id'] == $v['gangId']) {
					// 			$zongji['cntPlan']+=$vv['cntPlanTouliao'];
					// 		}
					// 	}
					// }

				}

			}
		}
		$rowset[]=array(
			'compName'=>'<b>总计</b>',
		    "orderCode" =>"",
			"dateOrder" =>"",
			"dateJiaohuo" => "",
			"colorNum" => "",
			"guige" => "",
			"cntYaohuo" => $zongji['cntYaohuo'],
			"cntPlan"=>$zongji['cntPlan'],
			'_edit'=>''
		);

		#对操作栏进行赋值
		$arrFieldInfo = array(
			"compName"    => "客户(客户单号)[<a href='".$this->_url($_GET['action'],array('clientId'=>0))."'>全部</a>]",
			"orderCode"   => "合同编号",
			"dateOrder"   => "定单日期",
			"dateJiaohuo" => "交货日期",
			"orderCode2"   => "客户单号",
			"colorNum"    => "色号",
			"guige"       => "规格:总数",
			"cntYaohuo"   => "本单总数",
			"cntPlan"     => "已排计划数",
			//"other"     => "其他",
			'_edit'       => '操作'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', '筒染订单');

		if ($_GET[display] == '') {	//display为空,就代表要显示全部
			$smarty->assign('arr_edit_info',$arr_edit_info);
			$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
			$smarty->assign('arr_condition', $arrGet);
		}
		else{
			$smarty->assign('add_display', 'none');
			$smarty->assign('page_info',"<a href='".url('plan_dye','paigangSchedule')."' target='_blank'>显示排缸表</a>");
			//$smarty->assign('arr_condition', $arrGet);
		}

		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_value',$rowset);
		//dump($rowset[19]);//exit;
		$smarty->assign('other_search_item',$cHtml);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('pk',$this->_modelExample->primaryKey);
		$smarty->assign('url_print', $this->_url('Print',$arr+array('preview'=>1)));
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps 生产计划单打印
	 * Time：2017/06/12 10:42:03
	 * @author zcc
	*/
	function actionPrint(){
		FLEA::loadClass('TMIS_Pager');
		$sql = "SELECT x.dateOrder,x.orderCode,c.compName,y.colorNum,y.color,y.kuanhao,y.cntKgJ,y.cntKgW,y.cntKg,y.danjia,x.dateJiaohuo,w.wareName,w.guige,y.memo,y.wareNameBc,y.dateJiaoqi
			FROM trade_dye_order x
			left join trade_dye_order2ware y on x.id = y.orderId
			left join plan_dye_gang p on p.order2wareId = y.id
			left join jichu_client c on c.id = x.clientId
			left join jichu_ware w on w.id = y.wareId
			where x.dateOrder>='{$_GET['dateFrom']}' and x.dateOrder<='{$_GET['dateTo']}'
		";
		if ($_GET['clientId']>0) $sql.= " and x.clientId='{$_GET[clientId]}'";
		if ($_GET['orderCode']!='') $sql.= " and x.orderCode like '%{$_GET[orderCode]}%'";
		if ($_GET['vatNum']!='') $sql.= " and p.vatNum like '%{$_GET[vatNum]}%'";
		if ($_GET['zhishu']!='') $sql.= " and w.wareName like '%{$_GET[zhishu]}%'";
		$sql .= " order by orderId desc,y.id asc";
		$pager = & new TMIS_Pager($sql);
		$rowset=$pager->findAll();
		foreach ($rowset as &$v) {
			if ($v['wareNameBc']) {
				$v['name'] = $v['wareNameBc'];
			}else{
				$v['name'] = $v['wareName'].' '.$v['guige'];
			}
			// by zcc 2017年11月15日 16:27:13  超过一定长度就把剩下的 一到下面的色号一栏中
			// $v['color_s'] = mb_substr($v['color'],0,6,'utf-8');
			$content = iconv("utf-8","gb2312//IGNORE",$v['color']);//现将编码转换成gb （原因 在打印控件那边2个字母或者数字接近与一个中文的宽度 ps:只是很接近 但不相等 可能会存在误差问题）
			// $v[num] = strlen($content);
			// $v[str1] = mb_substr($content,0,8,'gb2312');
			$v[str1] = substr($content,0,10);//大概空间那边显示为10为字母数据的宽度 然后这个进行截取前10字节宽度
			// $v[str1_1] = mb_substr($content,8,'gb2312');
			$v[str1_1] = substr($content,10);//截取后面的内容
			$v['str2']= iconv("gb2312","utf-8//IGNORE",$v[str1]);//在进行转换成utf 用来显示到控件打印上
			$v['str2_1']= iconv("gb2312","utf-8//IGNORE",$v[str1_1]);//在进行转换成utf
			if ($v['str2_1']) {
				$v['colorNum'] = $v['str2_1']."  ".$v['colorNum'];
			}
		}
		// dump($rowset);die();
		$smarty = & $this->_getView();
		$smarty->assign('title', '筒染订单');
		$smarty->assign('row',$rowset);
		$smarty->display('Trade/Dye/print.tpl');
	}

    //日排缸任务表2
    function actionRight2() {
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d"),
			//dateFrom =>date("Y-m-d"),
			dateTo => date("Y-m-d"),
			clientId => '',
			orderCode => ''
		));

		$condition=array(
			array('Order.dateOrder', "$arrGet[dateFrom]", '>='),
			array('Order.dateOrder', "$arrGet[dateTo]", '<='),
			//array('clientId', $arrGet[clientId])
		);
		//$condition[] = " order by Order.orderCode ";
		if ($arrGet[clientId] != '') $condition[]=array('Order.clientId',"$arrGet[clientId]");
		if ($arrGet[orderCode] != '') $condition[] = array('Order.orderCode', "%$arrGet[orderCode]%", 'like');

		//$rowset = $this->_modelExample->findAll($condition,'dateOrder desc');
		$mOrdware = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$rowset = $mOrdware->findAll($condition);
		//dump($rowset[0]);exit;
		//$modelWare = FLEA::getSingleton('Model_JiChu_Ware');
		$modelClient = FLEA::getSingleton('Model_JiChu_Client');

		if($rowset) foreach($rowset as & $v) {
			//dump($v);
			$v['Client'] = $modelClient->find(array('id'=>$v['Order']['clientId']));
			//dump($v['Client']);
			$v['guige'] = $v['Ware']['wareName'].','.$v['Ware']['guige'];
			$v['vatNum'] = join('<br>',array_col_values($v['Pdg'],'vatNum'));
			$v['cntPlanTouliao'] = join('<br>',array_col_values($v['Pdg'],'cntPlanTouliao'));
			if($cMark!=$v['Client']['id']) {
				$cMark=$v['Client']['id'];
			} else $v['Client'][compName]='';
			if($oMark!=$v['Order']['id']) {
				$oMark = $v['Order']['id'];
				$v['Order']['orderCode']=$this->_modelExample->getOrderTrack($v['Order']['id'],$v['Order'][orderCode]);
			} else $v['Order'][orderCode]='';
		}
		$rowset[] = $this->getHeji($rowset,array('cntKg'),'Order.orderCode');
		/*dump($rowset[0]);exit;
		$i = 0;
		$cntPlanTouliao = 0;
		foreach ($rowset as & $value) {
			//dump($value);
			$arr = $modelClient->find($value["clientId"]);
			if (count($value["Ware"]) > 0) {
				foreach ($value["Ware"] as & $item) {
					if($mOrdware->getCntPlanTouliao($item[id])>0){
						 $sql = "select * from view_dye_all where order2wareId ='{$item[id]}'";
						$pager = & new TMIS_Pager($sql);
						$row=$pager->findAll();
					   // dump($row);
						$rowsetCopy[$i]["vatNum"] = $row[0]['vatNum'];
						$rowsetCopy[$i]["orderCode"] = $this->_modelExample->getOrderTrack($value["id"],$value["orderCode"]);
						$rowsetCopy[$i][color] = $item[color];
						$rowsetCopy[$i][cntPlanTouliao] = $mOrdware->getCntPlanTouliao($item[id]);
						$cntPlanTouliao+= $mOrdware->getCntPlanTouliao($item[id]);
						$rowWare = $modelWare->findByField("id", $item["wareId"]);
						if (count($rowWare) > 0) {
								$rowsetCopy[$i]["wareName"] = $rowWare["wareName"]."||".$rowWare["guige"];
						}
						$i++;
					}
				}
			}
		}
		//加入合计行
		$rowsetCopy[$i][orderCode] ='<b>合计</b>';
		$rowsetCopy[$i][cntPlanTouliao] = "<b>".$cntPlanTouliao."</b>";
               // dump($rowsetCopy);
               // exit;
		*/
		//dump($rowset);
		#对表头进行赋值
		$arrFieldInfo = array(
			"Client.compName" =>"客户",
			"Order.orderCode" =>"订单号",
			"guige" =>"纱支",
			"color" =>"颜色",
			"vatNum"=>"缸号",
			'cntPlanTouliao'=>'投料',
			"cntKg"=>"数量",
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', '订单查询');
                $smarty->assign('add_display','none');
		//dump($rowsetCopy[0]);exit;
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition', $arrGet);
		$smarty->display('TableList.tpl');
	}
	//可以看见单价和金额, 用于财务部门添加单价
	function actionRightHavePrice(){
		$title='设置单价';
		$this->authCheck(139);	//4是财务部门总权限
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId => '',
			orderCode =>'',
			//key => ''
			'colorNum'=>''
		));
		$condition=array(
			array('dateOrder', "$arrGet[dateFrom]", '>='),
			array('dateOrder', "$arrGet[dateTo]", '<=')
		);
		if ($arrGet[clientId] != '') $condition[]=array('clientId',"$arrGet[clientId]");
		if ($arrGet[orderCode] != '') $condition[]=array('orderCode', "%$arrGet[orderCode]%", 'like');
		if ($arrGet['colorNum'] != '') $condition[]=array('Ware.colorNum', "%$arrGet[colorNum]%", 'like');

		$pager = & new TMIS_Pager($this->_modelExample, $condition, 'dateOrder desc,orderCode');
		$rowset = $pager->findAll();

		foreach ($rowset as & $value) {
			//$value[departmentName] = $value[Department][depName];
			//dump($value);
			$value[clientName] = $value[Client][compName];
			$value[trader] = $value[Trader][employName];
			$value[money] =0;

			if (count($value[Ware])>0) foreach($value[Ware] as $r) {
					$value[money]+= $r[danjia]*$r[cntKg]+$r[money];
				if ($value[money] == 0.00) $value[other] = "<a href='Index.php?controller=Trade_Dye_Order&action=AddPrice&id=$value[id]' target='_blank'><font color=red>添加单价</font></a>";
				else $value[other] = "<a href='Index.php?controller=Trade_Dye_Order&action=AddPrice&id=$value[id]' target='_blank'>已有单价</a>";
			}
			$value['orderCode']=$this->_modelExample->getOrderTrack($value[id],$value['orderCode']);
			//得到客户单号
			if($value['orderCode2']!='') $value['clientName']=$value['clientName'].'('.$value['orderCode2'].')';
			$value['colorNum']=$value['Ware'][0]['colorNum'];
		}
		$heji = $this->getHeji($rowset,array('money'),'orderCode');
		$rowset[] = $heji;
		//dump($rowset[0]); exit;

		$arrFieldInfo = array(
			"orderCode"		=>"合同编号",
			"dateOrder"		=>"日期",
			"clientName"	=>"客户(客户单号)",
			"trader"		=>"业务员",
			'colorNum'		=>'色号',
			'money'			=>'整单金额',
			'memo'			=>'备注',
			"other"			=>"操作"
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign('title',$title);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('pk',$this->_modelExample->primaryKey);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('RightHavePrice', $arrGet)));
		$smarty->display('TableList.tpl');
	}

	//已有单价的修改
	function actionRightHavePrice1(){
		$this->authCheck(140);	//4是财务部门总权限
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId => '',
			orderCode =>'',
			//key => ''
		));
		$condition=array(
			array('Order.dateOrder', "$arrGet[dateFrom]", '>='),
			array('Order.dateOrder', "$arrGet[dateTo]", '<=')
		);
		if ($arrGet[clientId] != '') $condition[]=array('Order.clientId',"$arrGet[clientId]");
		if ($arrGet[orderCode] != '') $condition[]=array('Order.orderCode', "%$arrGet[orderCode]%", 'like');
		$condition[] = array('danjia', 0, '>');

		$m = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$mC = & FLEA::getSingleton('Model_Jichu_Client');
		$mW = & FLEA::getSingleton('Model_Jichu_Ware');
		$pager = & new TMIS_Pager($m, $condition, 'dateOrder desc');
		$rowset = $pager->findAll();

		foreach ($rowset as & $value) {
			//dump($value);
			//$value[departmentName] = $value[Department][depName];
			$value[orderCode] = $this->_modelExample->getOrderTrack($value[Order][id],$value[Order][orderCode]);
			$value[dateOrder] = $value[Order][dateOrder];
			$client = $mC->find(array(id=>$value[Order][clientId]));
			$value[clientName] = $client[compName];
			$value[shazhi] = $value[Ware][wareName] . " " . $value[Ware][guige];
			//取得客户单号
			if($value['Order']['orderCode2']!='') $value['clientName']=$value['clientName'].'('.$value['Order']['orderCode2'].')';
			if ($value['isShenhe']==1) {
				$value[danjia] = "<span id='spanDanjia' title='已审核无法修改！'>".$value['danjia']."</span>";
			}else{
				$value[danjia] = "<span id='spanDanjia' onmouseover='this.style.backgroundColor=\"#828282\"' onmouseout='this.style.backgroundColor=\"\"' onclick='beginSet(this,$value[id])'>$value[danjia]</span>";
			}

		}

		$smarty = & $this->_getView();

		#对变量赋值
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('title', $this->title);

		#对表头进行赋值
		$arrFieldInfo = array(
			"orderCode" =>"合同编号",
			"dateOrder" =>"日期",
			"clientName" =>"客户",
			"shazhi" => "纱支",
			color =>"颜色",
			cntKg=>"公斤数",
			danjia => "单价"
			//"other" => "其他"
		);

		$smarty->assign('title','筒染订单');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('other_script','<script language="javascript" src="Resource/Script/Ajax/setDanjia.js"></script>');
		//$smarty->assign('search_display', 'none');
		$smarty->assign('pk',$pk); //设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('page_info',$pager->getNavBar($this->_url('RightHavePrice1', $arrGet)));
		$smarty->display('TableList.tpl');
	}


	//可以看见单价和金额, 用于财务部门添加单价
	/*function actionRightHavePrice(){
		$this->authCheck(4);	//4是财务部门总权限
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId => '',
			orderCode =>'',
			//key => ''
		));
		$condition=array(
			array('Order.dateOrder', "$arrGet[dateFrom]", '>='),
			array('Order.dateOrder', "$arrGet[dateTo]", '<=')
		);
		if ($arrGet[clientId] != '') $condition[]=array('Order.clientId',"$arrGet[clientId]");
		if ($arrGet[orderCode] != '') $condition[]=array('Order.orderCode', "%$arrGet[orderCode]%", 'like');
		$condition[] = array('danjia', 0, '=');

		$m = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$mC = & FLEA::getSingleton('Model_Jichu_Client');
		$mW = & FLEA::getSingleton('Model_Jichu_Ware');
		$pager = & new TMIS_Pager($m, $condition, 'dateOrder desc');
		$rowset = $pager->findAll();

		foreach ($rowset as & $value) {
			//$value[departmentName] = $value[Department][depName];
			$value[orderCode] = $value[Order][orderCode];
			$value[dateOrder] = $value[Order][dateOrder];
			$client = $mC->find(array(id=>$value[Order][clientId]));
			$value[clientName] = $client[compName];
			$value[shazhi] = $value[Ware][wareName] . " " . $value[Ware][guige];

			$value[danjia] = "<span id='spanDanjia' onmouseover='this.style.backgroundColor=\"#828282\"' onmouseout='this.style.backgroundColor=\"\"' onclick='beginSet(this,$value[id])'>$value[danjia]</span>";
		}

		$smarty = & $this->_getView();

		#对变量赋值
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('title', $this->title);

		#对表头进行赋值
		$arrFieldInfo = array(
			"orderCode" =>"合同编号",
			"dateOrder" =>"日期",
			"clientName" =>"客户",
			"shazhi" => "纱支",
			color =>"颜色",
			cntKg=>"公斤数",
			danjia => "单价"
			//"other" => "其他"
		);

		$smarty->assign('title','筒染订单');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('other_script','<script language="javascript" src="Resource/Script/Ajax/setDanjia.js"></script>');
		//$smarty->assign('search_display', 'none');
		$smarty->assign('pk',$pk); //设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('page_info',$pager->getNavBar($this->_url('RightHavePrice', $arrGet)));
		$smarty->display('TableList.tpl');
	}*/

	//利用ajax方式修改单价
	function actionSetPriceAjax(){
		$m = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		//dump($_GET);exit;
		//判断 要修改的订单数据中 是否存在小缸价或单价 如果任意一个存在则另一个不允许修改单价
		$order2pro = $m->find($_GET[id]);
		if ($order2pro['money']>0) {
			echo "{success:false}";die();
		}
		$m->updateField(array(id=>$_GET[id]),'danjia',$_GET[danjia]);
		$dbo=&FLEA::getDBO(false);
		//dump($dbo->log);exit;
		echo "{success:true}";
	}
	//添加单价
	function actionAddPrice() {
		//$this->authCheck();
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);
		$m = & FLEA::getSingleton('Model_JiChu_Ware');

		$i = count($aRow[Ware]);
		if ($i>0) {
			foreach($aRow[Ware] as & $v){
				$w = $m->find($v[wareId]);
				$v[shazhi] = $w[wareName]." ".$w[guige];
				$tCntKg += $v[cntKg];
				$tDanjia += $v[danjia];
				$v['money1']=$v['danjia']*$v['cntKg'];
			}

		}
		$aRow[Total][tCntKg] = "<strong>".$tCntKg."</strong>";
		$aRow[Total][tDanjia] = "<strong>".$tDanjia."</strong>";

		//dump($aRow); //exit;
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$aRow);
		$smarty->assign('tabindex', 1);
		$smarty->assign("pk",$pk);
		$smarty->display('Trade/Dye/AddPrice.tpl');
	}

	//整单添加单价
	function actionAddPriceAll() {
		//$this->authCheck();
		$pk=$this->_modelExample->primaryKey;
		$aRow=$this->_modelExample->find($_GET[$pk]);

		$smarty = & $this->_getView();
		$smarty->assign("aRow",$aRow);
		$smarty->assign('tabindex', 1);
		$smarty->assign("pk",$pk);
		$smarty->display('Trade/Dye/AddPriceAll.tpl');
	}


	#保存单价
	function actionSavePrice() {
		//dump($_POST);EXIT;

		$count = count($_POST[id]);
		for($i=0; $i<$count; $i++) {
			$rowset[$i][id] = $_POST[id][$i];
			$rowset[$i][danjia] = $_POST[danJia][$i];
			$rowset[$i]['money'] = $_POST['money'][$i];
		}
		//dump($rowset); exit;
		$modelOrder2Ware = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$modelOrder2Ware->saveRowset($rowset);
		//$dbo = & FLEA::getDBO(false);
		//dump($dbo->log);exit;

		if ($modelOrder2Ware->saveRowset($rowset))	js_alert('单价保存成功!','window.opener.location.href=window.opener.location.href;window.close()');
		else die('保存失败!');
	}

	function actionSavePriceAll() {
		$sql = "select id, cntKg from trade_dye_order2ware where orderId = ".$_POST['orderId'];
		$rowset = $this->_modelExample->findBySql($sql);
		$cntKg = 0;
		if (count($rowset)>0) foreach($rowset as & $v) {
			$cntKg += $v['cntKg'];
		}
		//dump($rowset); exit;

		/*
		$count = count($rowset);
		if (($count>0) && ($_POST['wholePrice']>0) && ($cntKg>0)) {
			$danjia = round($_POST['wholePrice']/$cntKg, 3);
			foreach($rowset as & $v) {
				$updateRow[] = array(
					'id' => $v['id'],
					'danjia' => $danjia,
				);
			}
		}

		$wholePrice = $_POST['wholePrice'];
		if (($count>0) && ($wholePrice>0) && ($cntKg>0)) {
			$danjiaLast = $wholePrice%($cntKg-1);
			$danjia = ($wholePrice-$danjiaLast) / ($cntKg-1);
			for($i=0; $i<($count-1); $i++) {
				$updateRow[$i]['id'] = $rowset[$i]['id'];
				$updateRow[$i]['danjia'] = $danjia;
			}
			$updateRow[$count-1]['id'] = $rowset[$count-1]['id'];
			$updateRow[$count-1]['danjia'] = $danjiaLast;
		}

		*/

		//dump($updateRow);exit;
		$modelO2w = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		if ($modelO2w->saveRowset($updateRow))
			//redirect($this->_url('AddPrice',array('id'=>$_POST[orderId])));
			redirect($this->_url('RightHavePrice'));
		else die('保存失败!');
	}

	//计划单管理
	function actionPlanManage(){
		$this->authCheck(156);
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mGang->clearLinks();
		FLEA::loadClass('TMIS_Pager');
		$arr = array(
			'clientId'=>0,
			'vatNum'=>'',
			'orderCode'=>'',
			'isReport'=>0,	//是否是报表的开关,如果是1，则不显示操作栏目,且显示单个的date控件
			'pihao' =>'',
		);
		if ($_GET[isReport]==1) {
			$arr[date]=date("Y-m-d");
		} else {
			//$arr[dateFrom]=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-25,date("Y")));
			$arr[dateFrom]=date("Y-m-d");
			$arr[dateTo]=date("Y-m-d");
		}

		$arr = TMIS_Pager::getParamArray($arr);
		if ($_POST['isHuixiu'] == 1) $arr['isHuixiu'] = 1;
		else $arr['isHuixiu'] = 0;

		if (isset($arr[dateFrom])) $condition=array("planDate>='$arr[dateFrom]'","planDate<='$arr[dateTo]'");
		else $condition = array("planDate='$arr[date]'");
		if ($arr['clientId']>0) $condition[]="clientId='$arr[clientId]'";
		if ($arr['orderCode']!='') $condition[]="orderCode like '%$arr[orderCode]%'";
		if ($arr['vatNum']!='') $condition[] ="vatNum like '%$arr[vatNum]%'";
		if ($arr['isHuixiu'] == 1) $condition[] = "parentGangId>0";
		if($_GET['order2wareId']>0) $condition[] = "order2wareId={$_GET['order2wareId']}";
		if($arr['pihao']) $condition[] = "order2wareId in (select id from trade_dye_order2ware where pihao like '%{$arr['pihao']}%')";
		$pager=null;
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$pageSize=50;
		$rowPlan=$mGang->findAllGang1($condition,$pager,$pageSize,'vatNum asc');
		//得到总计
		$sql = "select
			sum(cntPlanTouliao) as cntPlanTouliao,
			count(*) as cntGang,
			sum(planTongzi) as planTongzi
			from view_dye_gang where 1 ".($condition ? ('and '.join(' and ',$condition)) : '');
		$zongji = mysql_fetch_assoc(mysql_query($sql));
		$zongji['compName'] = '总计';

		$tTouliao = 0;//合计投料数
		$cMark=$oMark=0;
		if(count($rowPlan)>0) foreach($rowPlan as & $value) {
			//在已排缸查询界面添加产地一栏，取生产计划中的产地数据 chen
			$sqlc="select chandi,ganghaoKf,wareNameBc,pihao from trade_dye_order2ware x where x.id='{$value['order2wareId']}'";
			$chandi = mysql_fetch_assoc(mysql_query($sqlc));
			$value['chandi']=$chandi['chandi'];
			$value['ganghaoKf']=$chandi['ganghaoKf'];
			$value['wareNameBc']=$chandi['wareNameBc'];
			$value['pihao']=$chandi['pihao'];
			$value['vatNum']=$mGang->setVatNum($value['gangId'],$value['order2wareId']);;
			$m=$this->_modelExample->find(array('id'=>$value['orderId']));
			$value['orderCode2']=$m['orderCode2'];
			if($value['orderCode2']!=''){
			    $value['compName']=$value['compName']."(".$value['orderCode2'].")";
			}
			$value['Gang'] = $mGang->find(array('id'=>$value['gangId']));
			/*if($cMark!=$value[clientId]) {
				$cMark=$value[clientId];
			} else $value[compName]='';*/
			/*if($oMark!=$value[orderId]) {
				$oMark = $value[orderId];
				$value['orderCode']=$this->_modelExample->getOrderTrack($value[orderId],$value[orderCode]);
			} else $value[orderCode]='';*/
			$value[guige] = $value[wareName]." ".$value[guige];
			if ($value[parentGangId]>0) {
				$value['vatNum'] = "<span style='color:blue' title='{$value['reasonHuixiu']}'>{$value[vatNum]}</span>";
			} else $ext='';

			$rsChanliang = $mGang->getRanseChanliang($value[gangId]);
			if ($rsChanliang>0) {
				$value[planTongzi] .= "<font color=red>(产:$rsChanliang)</font>";
				$value[vatNum] = "<font color=red>$value[vatNum]".$ext."</font>";
			}
			else $value[vatNum] = $value[vatNum].$ext;

			//处理合计数据
			$tTouliao += $value[cntPlanTouliao];
			if ($arr[isReport]==1) continue;

			// $value[edit] = "<a  href='".url("Plan_Dye","PrintCard",array("id" => $value[gangId]))."'>流转卡(打印{$value['Gang']['timesPrint']})</a>  ";
			$value[edit] .= " <a href='".$this->_url('EditGang',array(id=>$value[gangId]))."'>修改</a> ";
			$value[edit] .= " | <a href='".$this->_url('CaiGang',array(
				'id'=>$value['gangId'],
				'TB_iframe'=>1,
				'width'=>'950'
			))."'  class='thickbox'  title='拆缸' >拆缸</a> ";
			$value[edit] .= "| <a href='".$this->_url('CopyGang',array(id=>$value[gangId]))."'>复制</a> ";
			$value[edit] .= " | <a href='".$this->_url('RemoveGang',array(id=>$value[gangId]))."' onclick='return confirm(\"您确认要删除吗?\")'>删除</a>";
			$value[edit] .= " | <a href='".$this->_url('huixiu',array(id=>$value[gangId]))."' onclick='return confirm(\"您确认要回修吗?\")'>回修</a>";
			$value[edit] .= " | <a href='".$this->_url('huixiuNew',array(id=>$value[gangId]))."' onclick='return confirm(\"您确认要回修吗?\")'>回修2</a>";
			// $value[edit] .= "| <a href='".url("Plan_Dye","PrintTzCodeList",array("id" => $value[gangId]))."' class='thickbox'>打印条码</a>";
			$value[edit] .= " | <a href='".url("Plan_Dye","PrintCard2",array("id" => $value[gangId]))."'> 流转卡({$value['Gang']['timesPrint']})</a>";
			$value[edit] .= " | <a href='".url("Plan_Dye","PrintPaiGang",array("id" => $value[gangId]))."'> 排缸卡({$value['Gang']['timesPrint2']})</a>";
			// $value[edit] .= " | <a href='".$this->_url('CopyData',array(id=>$value[gangId]))."'>打印内容</a> ";
			// $value[edit] .= " | <a href='".$this->_url('CaiGang',array(id=>$value[gangId]))."' onclick='return confirm(\"您确认要回修吗?\")'>拆缸</a>";

			//班次
			if ($value['ranseBanci'] ==1) $value['ranseBanci'] = '早班1';
			elseif ($value['ranseBanci']==2) $value['ranseBanci'] = '晚班1';
			elseif ($value['ranseBanci']==3) $value['ranseBanci'] = '早班2';
			elseif ($value['ranseBanci'==4]) $value['ranseBanci'] = '晚班2';
			else $value['ranseBanci'] = '';

			if($value['Gang']['timesPrint']>0) $value['_bgColor']= '#cccccc';
			if($value['Gang']['timesPrint2']>0) $value['_bgColor']= '#cccccc';
		}
		//加入合计行
		$rowPlan[] = $this->getHeji($rowPlan,array(
			'cntPlanTouliao','planTongzi'
		),'compName');
		$rowPlan[] = $zongji;
		$arrFieldInfo = array(
			'compName' =>'客户(客户单号)',
			'pihao' =>'批号',
			'orderCode' =>'合同编号',
			'vatNum' =>'缸号',
			'planDate' =>'排缸日期',
			'ganghaoKf' =>'客户缸号',
			'wareNameBc' =>'纱支别名',
			'guige'=>'规格',
			'color' =>'颜色',
			'colorNum' =>'色号',
			'cntPlanTouliao' =>'计划投料',
			'planTongzi' =>'计划筒数',
			'vatCode' =>'物理缸号',
			'dateAssign' =>'排染日期',
			'ranseBanci' =>'班次',
			'chandi' =>'产地'
		);
		if ($arr[isReport]!=1) $arrFieldInfo[edit] = "操作";
		$smarty = & $this->_getView();
		$smarty->assign('title','计划单查询');
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('search_more', 'true');
		$smarty->assign('supplier_name', '客户');
		$smarty->assign('dateFrom',$arr[dateFrom]);
		$smarty->assign('dateTo',$arr[dateTo]);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('arr_field_value', $rowPlan);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url('PlanManage',$arr))."<font color='blue'>蓝色表示回修</font>,<font color='red'>红色表示有产量出来</font>,单击订单号可进行生产跟踪.<b>回修2:表示未出库整缸回修操作</b>");
		$smarty->assign('url_daochu', $this->_url('PlanDaoExcel',$arr+array('preview'=>1)));
		$smarty->display('TableList2.tpl');
		exit;
	}
	/**
	 * ps ：已排缸查询界面的导出
	 * Time：2017年11月29日 14:36:40
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionPlanDaoExcel(){
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mGang->clearLinks();
		FLEA::loadClass('TMIS_Pager');
		$arr = array(
			'clientId'=>0,
			'vatNum'=>'',
			'orderCode'=>'',
			'isReport'=>0,	//是否是报表的开关,如果是1，则不显示操作栏目,且显示单个的date控件
			'pihao' =>'',
		);
		$arr = TMIS_Pager::getParamArray($arr);

		$sql = "SELECT x.*,y.dateJiaoqi,y.wareNameBc
			FROM view_dye_gang  x
			left join trade_dye_order2ware y on y.id = x.order2wareId
			where 1 ";
		if($_GET[dateFrom]!=''&&$_GET[dateTo]!='') $sql.=" and x.planDate>='$_GET[dateFrom]' and x.planDate<='$_GET[dateTo]'";
		if ($_GET['clientId']>0) $sql .= " and x.clientId='$_GET[clientId]'";
		if ($_GET['orderCode']!='') $sql .= " and x.orderCode like '%$_GET[orderCode]%'";
		if ($_GET['vatNum']!='') $sql .= " and x.vatNum like '%$_GET[vatNum]%'";
		if ($_GET['isHuixiu'] == 1) $sql .= "and x.parentGangId>0";
		if($_GET['pihao']) $sql .= " and y.pihao like '%{$arr['pihao']}%'";
		$sql .= "order by x.vatNum asc";
		$rowset = $this->_modelExample->findBySql($sql);
		if (count($rowset)>0)foreach($rowset as & $value) {
			$value['vatNum']=$mGang->setVatNum($value['gangId'],$value['order2wareId']);;
			$value['shahzi'] = $value['wareName'].' '.$value['guige'];
			$value['dateJiaohuo2'] = date('y.m.d',strtotime($value['dateJiaoqi']));
			$value['cntPlanTouliao'] = round($value['cntPlanTouliao'],2);
		}
		$heji = $this->getHeji($rowset,array('cntPlanTouliao'),'vatNum');
		$rowset[] = $heji;
		// dump($rowset);die();
		//excel 模版改良 添加 列宽额设置（像素）
		$arrFieldInfo = array(
			'vatNum' =>'缸号',
			'compName' =>'客户简称',
			'colorNum' =>'色号',
			'shahzi' =>'纱支',
			'color' =>'颜色',
			'cntPlanTouliao' =>array('text'=>'数量','width'=>'45.75'),
			'dateJiaohuo2'=>array('text'=>'交期','width'=>'45.75'),
			'gongyi' =>array('text'=>'工艺','width'=>'27.75'),
			'songtong' =>array('text'=>'松筒','width'=>'27.75'),
			'ranse' =>array('text'=>'染色','width'=>'27.75'),
			'zhijian' =>array('text'=>'质检','width'=>'27.75'),
			'honggan' =>array('text'=>'烘干','width'=>'27.75'),
			'jintong' =>array('text'=>'紧筒','width'=>'27.75'),
			'baozhuang' =>array('text'=>'包装','width'=>'27.75'),
			'fahuo' =>array('text'=>'发货','width'=>'27.75'),
			'memo' =>array('text'=>'备注','width'=>'27.75'),

		);
		if ($_GET['dateFrom']!=$_GET['dateTo']) {
			$dataRoud = "{$_GET['dateFrom']} ～ {$_GET['dateTo']}";
		}else{
			$dataRoud = "{$_GET['dateFrom']}";
		}
		// dump($arrFieldInfo);die();
		$smarty = & $this->_getView();
		$smarty->assign('title',' 生产流程一览表');
		$smarty->assign('date',$dataRoud);
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('search_more', 'true');
		$smarty->assign('supplier_name', '客户');
		$smarty->assign('dateFrom',$arr[dateFrom]);
		$smarty->assign('dateTo',$arr[dateTo]);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('arr_field_value', $rowset);
		// $smarty->assign('page_info',$pager->getNavBar($this->_url('PlanManage',$arr)));
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		//header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", '内销收款查询').".xls");
		header("Content-Disposition: attachment;filename=生产流程一览表.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty->display('Plan/PlanDaoExcel.tpl');
		exit;
	}
	/**
	 * ps ：公共查询区下的已排缸查询（操作只显示打印内容一栏）
	 * Time 2017年11月16日
	 * @author zcc
	*/
	function actionPlanManage2(){
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mGang->clearLinks();
		FLEA::loadClass('TMIS_Pager');
		$arr = array(
			'clientId'=>0,
			'vatNum'=>'',
			'orderCode'=>'',
			'isReport'=>0,	//是否是报表的开关,如果是1，则不显示操作栏目,且显示单个的date控件
			'pihao' =>'',
		);
		if ($_GET[isReport]==1) {
			$arr[date]=date("Y-m-d");
		} else {
			//$arr[dateFrom]=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-25,date("Y")));
			$arr[dateFrom]=date("Y-m-d");
			$arr[dateTo]=date("Y-m-d");
		}

		$arr = TMIS_Pager::getParamArray($arr);
		if ($_POST['isHuixiu'] == 1) $arr['isHuixiu'] = 1;
		else $arr['isHuixiu'] = 0;

		if (isset($arr[dateFrom])) $condition=array("planDate>='$arr[dateFrom]'","planDate<='$arr[dateTo]'");
		else $condition = array("planDate='$arr[date]'");
		if ($arr['clientId']>0) $condition[]="clientId='$arr[clientId]'";
		if ($arr['orderCode']!='') $condition[]="orderCode like '%$arr[orderCode]%'";
		if ($arr['vatNum']!='') $condition[] ="vatNum like '%$arr[vatNum]%'";
		if ($arr['isHuixiu'] == 1) $condition[] = "parentGangId>0";
		if($_GET['order2wareId']>0) $condition[] = "order2wareId={$_GET['order2wareId']}";
		if($arr['pihao']) $condition[] = "order2wareId in (select id from trade_dye_order2ware where pihao like '%{$arr['pihao']}%')";
		$pager=null;
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$pageSize=50;
		$rowPlan=$mGang->findAllGang1($condition,$pager,$pageSize,'vatNum asc');
		//得到总计
		$sql = "select
			sum(cntPlanTouliao) as cntPlanTouliao,
			count(*) as cntGang,
			sum(planTongzi) as planTongzi
			from view_dye_gang where 1 ".($condition ? ('and '.join(' and ',$condition)) : '');
		$zongji = mysql_fetch_assoc(mysql_query($sql));
		$zongji['compName'] = '总计';

		$tTouliao = 0;//合计投料数
		$cMark=$oMark=0;
		if(count($rowPlan)>0) foreach($rowPlan as & $value) {
			//在已排缸查询界面添加产地一栏，取生产计划中的产地数据 chen
			$sqlc="select chandi,ganghaoKf,wareNameBc,pihao from trade_dye_order2ware x where x.orderId='{$value['orderId']}'";
			$chandi = mysql_fetch_assoc(mysql_query($sqlc));
			$value['chandi']=$chandi['chandi'];
			$value['ganghaoKf']=$chandi['ganghaoKf'];
			$value['wareNameBc']=$chandi['wareNameBc'];
			$value['pihao']=$chandi['pihao'];
			$value['vatNum']=$mGang->setVatNum($value['gangId'],$value['order2wareId']);;
			$m=$this->_modelExample->find(array('id'=>$value['orderId']));
			$value['orderCode2']=$m['orderCode2'];
			if($value['orderCode2']!=''){
			    $value['compName']=$value['compName']."(".$value['orderCode2'].")";
			}
			$value['Gang'] = $mGang->find(array('id'=>$value['gangId']));
			/*if($cMark!=$value[clientId]) {
				$cMark=$value[clientId];
			} else $value[compName]='';*/
			/*if($oMark!=$value[orderId]) {
				$oMark = $value[orderId];
				$value['orderCode']=$this->_modelExample->getOrderTrack($value[orderId],$value[orderCode]);
			} else $value[orderCode]='';*/
			$value[guige] = $value[wareName]." ".$value[guige];
			if ($value[parentGangId]>0) {
				$value['vatNum'] = "<span style='color:blue' title='{$value['reasonHuixiu']}'>{$value[vatNum]}</span>";
			} else $ext='';

			$rsChanliang = $mGang->getRanseChanliang($value[gangId]);
			if ($rsChanliang>0) {
				$value[planTongzi] .= "<font color=red>(产:$rsChanliang)</font>";
				$value[vatNum] = "<font color=red>$value[vatNum]".$ext."</font>";
			}
			else $value[vatNum] = $value[vatNum].$ext;

			//处理合计数据
			$tTouliao += $value[cntPlanTouliao];
			if ($arr[isReport]==1) continue;

			$value[edit] .= "<a href='".$this->_url('CopyData',array(id=>$value[gangId]))."'>打印内容</a> ";
			//班次
			if ($value['ranseBanci'] ==1) $value['ranseBanci'] = '早班1';
			elseif ($value['ranseBanci']==2) $value['ranseBanci'] = '晚班1';
			elseif ($value['ranseBanci']==3) $value['ranseBanci'] = '早班2';
			elseif ($value['ranseBanci'==4]) $value['ranseBanci'] = '晚班2';
			else $value['ranseBanci'] = '';

			if($value['Gang']['timesPrint']>0) $value['_bgColor']= '#cccccc';
			if($value['Gang']['timesPrint2']>0) $value['_bgColor']= '#cccccc';
		}
		//加入合计行
		$rowPlan[] = $this->getHeji($rowPlan,array(
			'cntPlanTouliao','planTongzi'
		),'compName');
		$rowPlan[] = $zongji;
		$arrFieldInfo = array(
			'compName' =>'客户(客户单号)',
			'pihao' =>'批号',
			'orderCode' =>'合同编号',
			'vatNum' =>'缸号',
			'planDate' =>'排缸日期',
			'ganghaoKf' =>'客户缸号',
			'wareNameBc' =>'纱支别名',
			'guige'=>'规格',
			'color' =>'颜色',
			'colorNum' =>'色号',
			'cntPlanTouliao' =>'计划投料',
			'planTongzi' =>'计划筒数',
			'vatCode' =>'物理缸号',
			'dateAssign' =>'排染日期',
			'ranseBanci' =>'班次',
			'chandi' =>'产地'
		);
		if ($arr[isReport]!=1) $arrFieldInfo[edit] = "操作";
		$smarty = & $this->_getView();
		$smarty->assign('title','计划单查询');
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('search_more', 'true');
		$smarty->assign('supplier_name', '客户');
		$smarty->assign('dateFrom',$arr[dateFrom]);
		$smarty->assign('dateTo',$arr[dateTo]);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('arr_field_value', $rowPlan);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr))."<font color='blue'>蓝色表示回修</font>,<font color='red'>红色表示有产量出来</font>,单击订单号可进行生产跟踪");
		$smarty->display('TableList2.tpl');
		exit;
	}
	function actionHuixiuList(){
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$sql="select * from view_dye_gang where  parentGangId<>0";
		FLEA::loadClass('TMIS_Pager');
		$arrG=TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'clientId'=>0,
			'vatNum'=>'',
			'orderCode'=>'',
		));
		if($arrG['clientId']>0){$sql.=" and clientId={$arrG['clientId']}";}
		if ($arrG['orderCode']!='') $sql.=" and orderCode like '%{$arrG['orderCode']}%'";
		if ($arrG['vatNum']!='') $sql.=" and vatNum like '%$arrG[vatNum]%'";
		if($arrG['dateFrom']!=''){$sql.=" and planDate>='{$arrG[dateFrom]}' and planDate<='{$arrG[dateTo]}'";}
		if ($_GET['export']==1) {
			$arr = $this->_modelExample->findBySql($sql);
		}else{
			$pager = & new TMIS_Pager($sql);
			$arr=$pager->findAll();
		}
		foreach($arr as & $v){
			//dump($v);
			$v['vatNum']=$mGang->setVatNum($v['gangId'],$v['order2wareId']);
			$temp=$mGang->find(array('id'=>$v['parentGangId']));
			if ($v['ranseBanci'] ==1) $v['ranseBanci'] = '早班1';
			elseif ($v['ranseBanci']==2) $v['ranseBanci'] = '晚班1';
			elseif ($v['ranseBanci']==3) $v['ranseBanci'] = '早班2';
			elseif ($v['ranseBanci'==4]) $v['ranseBanci'] = '晚班2';
			else $v['ranseBanci'] = '';
			 //得到客户单号
			$clientCode=$this->_modelExample->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
			if ($v['reasonHuixiu']=='') {
				if ($_GET['export']!=1) {
					$v['reasonHuixiu']="<a href='".$this->_url('Huixiu1',array('id'=>$v['gangId'],'rukuTag'=>1,'TB_iframe'=>1))."' class='thickbox'>".'[添加]'."</a>";
				}
			}else{
				$v['reasonHuixiu']="<a href='".$this->_url('Huixiu1',array('id'=>$v['gangId'],'rukuTag'=>1,'reasonHuixiu'=>$v['reasonHuixiu'],'TB_iframe'=>1))."' class='thickbox'>".$v['reasonHuixiu']."</a>";
			}
		}
		$arr[]=$this->getHeji($arr, array('cntPlanTouliao','planTongzi'),'compName');
		$arr_filed_info = array(
			'planDate' =>'排缸日期',
			'compName' =>'客户(客户单号)',
			'orderCode' =>'合同编号',
			'vatNum' =>'缸号',
			'reasonHuixiu' =>'回修原因',
			'guige'=>'规格',
			'color' =>'颜色',
			'cntPlanTouliao' =>'计划投料',
			'planTongzi' =>'计划筒数',
			'vatCode' =>'物理缸号',
			'dateAssign' =>'排染日期',
			'ranseBanci' =>'班次'
		);
		$smarty=& $this->_getView();
		$smarty->assign('title','回修统计报表');
		$smarty->assign('arr_field_info',$arr_filed_info);
		$smarty->assign('arr_field_value',$arr);
		$smarty->assign('arr_condition',$arrG);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','thickbox')));
		$smarty->assign('url_daochu',$this->_url($_GET['action'],$arrG+array('export'=>1)));
		$smarty->assign('add_display','none');
		if ($_GET['export']==1) {
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/download");
			//header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", '内销收款查询').".xls");
			header("Content-Disposition: attachment;filename=回修统计报表.xls");
			header("Content-Transfer-Encoding: binary");
			$smarty->display('Export2Excel.tpl');
			exit();
		}
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrG)));
		$smarty->display('tableList2.tpl');
	}

	function actionHuixiu1() {
		$smarty = & $this->_getView();
		$smarty->display('Plan/Huixiu.tpl');
	}
	function actionSaveHuixiu() {
		$this->authCheck(142);
		$this->_modelPlan = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$gangId = $_POST[id];
		$newGang = $this->_modelPlan->find(array('id'=>$gangId));
		$gang = array(
			'id'=>$_POST[id],
			'reasonHuixiu'=>$_POST['reasonHuixiu'],
			);
		$this->_modelPlan->save($gang);
		//刷新父窗口
		js_alert(null,"window.parent.location.href=window.parent.location.href");
	}
	//针对某个颜色进行的计划修改，可合并几缸，拆分某缸,增加缸，复制缸,删除缸，对某缸进行加急,重排计划
	function actionPlanManage1(){
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$sql = "select * from view_dye_gang where order2wareId='{$_GET['order2wareId']}' order by vatNum desc";
		$rowset = $mGang->findBySql($sql);
		if($rowset) foreach($rowset as & $v) {
			$jiaji = $mGang->isJiaji($v['gangId']);
			$v['sel'] = "<input type='checkbox' name='sel[]' id='sel[]' value='{$v['gangId']}'/>";
			$v['_edit'] = "<a href='".$this->_url('EditGang',array('id'=>$v['gangId'],'from'=>1))."' target='_blank'>修改</a> |
			<a href='".$this->_url('RemoveGang',array('id'=>$v['gangId']))."' onclick='return confirm(\"您确认要删除吗？\")'>删除</a> |
			<a href='".$this->_url('CopyGangDirectly',array('gangId'=>$v['gangId']))."'>复制</a> |
			<a href='".$this->_url('CaiGang',array(
				'id'=>$v['gangId'],
				'TB_iframe'=>1,
				'width'=>'950'
			))."' class='thickbox'  title='拆缸'>拆分</a> |";
			$v['_edit'] .= " <a href='".url('Plan_Dye',($jiaji?'cancelJiaji':'jiaji'),array('id'=>$v['gangId']))."' target='_blank'>".($jiaji?'取消':'')."加急</a> |	<a href='".url('Plan_Dye','printVatCard',array('id'=>$v['gangId']))."' target='_blank'>打印</a>";

			//如果是加急，用红色表示
			if($mGang->isJiaji($v['gangId'])) {
				$v['_bgColor']='#FF5B5B';
			}
		}
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','planTongzi'),'vatNum');
                $heji['sel']='<input type="button" name="btnMerge" id="btnMerge" value="合并" />';
		$rowset[] = &$heji;
		$a = $rowset[0];
		$arrFieldInfo = array(
			'sel'=>'选择',
			'vatNum' =>'缸号',
			'planDate' =>'排缸日期',
			'cntPlanTouliao' =>'计划投料',
			'planTongzi' =>'计划筒数',
			'vatCode' =>'物理缸号',
			'_edit'=>'操作'
		);
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_main_value',array(
			'订单号'=>$a['orderCode'],
			'客户'=>$a['compName'],
			'纱支规格'=>$a['wareName'] . ' ' .$a['guige'],
			'色号'=>$a['colorNum'],
			'颜色'=>$a['color'],
			'下单日期'=>$a['dateOrder'],
			'要货数'=>$a['cntKg']." KG",
			'已计划数'=>$heji['cntPlanTouliao'],
			'剩余数'=>"<font color='red'>".round($a['cntKg']-$heji['cntPlanTouliao'],2)."</font>"

		));
		$smarty->assign('arr_field_value', $rowset);
		$smarty->display('Plan/GangUpdate.tpl');
		exit;
	}

	//对某缸进行拆分
	function actionCaigang(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$gang = $m->find(array('id'=>$_GET['id']));
		//dump($gang);
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_value',$gang);
		$smarty->display('Plan/Caigang.tpl');
	}
	function actionSaveCai(){
		// dump($_POST);exit;
		$p = & $_POST;
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mChufang = & FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$gang = $m->find(array('id'=>$p['id']));
		$nums = $m->getNewGangNum($p['cntGang']-1);
		$str="select * from gongyi_dye_chufang where order2wareId='{$gang['order2wareId']}' and gangId='{$gang['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re){
			$arrChufang=$mChufang->find(array('id'=>$re['id']));
		}else{
			$arrChufang=$mChufang->find(array('order2wareId'=>$gang['order2wareId']));
		}

		// dump($nums);exit;
		$gangId=array();
		foreach($p['planTongzi'] as $k =>& $v) {
			$temp = $gang;
			$temp['cntJ'] = $p['cntJ'][$k];
			$temp['cntW'] = $p['cntW'][$k];
			$temp['cntPlanTouliao'] = $p['cntJ'][$k]+$p['cntW'][$k];
			$temp['planTongzi'] = $p['planTongzi'][$k];
			$temp['vatId'] = $p['vatId'][$k];
			$temp['unitKg'] = $p['unitKg'][$k];
			$temp['vat2shuirongId']= $p['vat2shuirongId'][$k];
			$temp['planDate']=date('Y-m-d');
			$temp['dateLingsha']='0000-00-00';
			$temp['timesPrint']=0;
			//$temp['cntPlanTouliao'] = $p['cntPlanTouliao'][$k];
			//从第二个开始要使用新的缸号和
			if($k>0){
				$temp['id'] = '';
				$temp['vatNum']=$nums[$k-1];
				$temp['dateDuizhang']='0000-00-00';
				//$temp['shuirong']=0;
				$temp['stOver']=0;
				$temp['zclOver']=0;
				$temp['rsOver']=0;
				$temp['hsOver']=0;
				$temp['hdOver']=0;
				$temp['dbOver']=0;
				//$temp['order2wareId']=$p['order2wareId'];
			}
			//$arr[] = $temp;
			//$m->save($temp);
			if($k>0){
				$gangId[]=$m->save($temp);
			}else{
				$m->save($temp);
			}
		}
		//dump($gangId);exit;
		//dump($arr);exit;
		//if($m->saveRowset($arr)) {
			//dump($arrChufang);exit;
			if(count($arrChufang['Ware']))foreach($arrChufang['Ware'] as & $v){
				$v['chufangId']='';
				$v['id']='';
			}
			if(count($arrChufang['Ware']))foreach($gangId as & $v){
				$arr1 = array(
					'dyeKind' => $arrChufang['dyeKind'],
					'chufangren' => 'xxx', //为了兼容以前的版本中的fuchfangren设定的默认值
					'chufangrenId' => $arrChufang['chufangrenId']+0,
					'order2wareId'=> $arrChufang['order2wareId']+0,
					'gangId'=>$v+0,
					'dateChufang' => $arrChufang['dateChufang'],
					//'gongyiKind'=>$_POST['gongyiKind'],
					'rhlZhelv'=>$arrChufang['rhlZhelv'],
					'rsgyId'=>$arrChufang['rsgyId']+0,
					'hclId'=>$arrChufang['hclId']+0,
					'qclId'=>$arrChufang['qclId']+0,
					//'pisha_qcl'=>$_POST['pisha_qcl']
					'ranseKind'=>$arrChufang['ranseKind'],
					'Ware'=>$arrChufang['Ware']
				);
				//dump($arr);exit;
				$mChufang->save($arr1);
			}
			js_alert('',"window.parent.location.href=window.parent.location.href");
		//}
	}

	//在订单明细修改界面中新增缸
	function actionAddgang(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$gang = $m->find(array('order2wareId'=>$_GET['order2wareId']));
		// dump($gang);die();
		//取到这个客户这个纱支的 最新一次排缸折率 by zcc
		//d
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_value',$gang);
		$smarty->display('Plan/Addgang.tpl');
	}
	function actionSaveAdd(){
		//dump($_POST);exit;
		$p = & $_POST;
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$nums = $m->getNewGangNum(1);
		$k=0;
		$temp = array(
			'order2wareId'=>$p['order2wareId'],
			'cntPlanTouliao'=>$p['cntPlanTouliao'][$k],
			'cntJ'=>$p['cntPlanTouliao'][$k],
			'zhelv'=>$p['zhelv'][$k],
			'planTongzi'=>$p['planTongzi'][$k],
			'unitKg'=>$p['unitKg'][$k],
			'vatId'=>$p['vatId'][$k],
			'vat2shuirongId' =>$p['vat2shuirongId'][$k],
			'planDate'=>date("Y-m-d"),
			'vatNum'=>$nums[$k]
		);
		// dump($temp);exit;
		if($m->create($temp)) {
			js_alert('',"window.opener.location.href=window.opener.location.href;window.close()");
		}
	}

	//在订单明细修改界面中合并缸
	function actionMergegang(){
		//dump($_GET);exit;
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$gang = $m->findAllByPkvs($_GET['gangId']);
		$gang[] = $this->getHeji($gang,array('cntPlanTouliao','planTongzi'),'vatNum');
		//dump($gang);exit;
		$smarty = & $this->_getView();
		$smarty->assign('gangs',$gang);
		$smarty->display('Plan/MergeGang.tpl');
	}
	function actionSaveMerge(){
		//dump($_POST);exit;
		$p = & $_POST;
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');

		//新增一缸
		$nums = $m->getNewGangNum(1);
		$k=0;
		$temp = array(
			'order2wareId'=>$p['order2wareId'],
			'cntPlanTouliao'=>$p['cntPlanTouliao'][$k],
			'zhelv'=>$p['zhelv'][$k],
			'planTongzi'=>$p['planTongzi'][$k],
			'unitKg'=>$p['unitKg'][$k],
			'vatId'=>$p['vatId'][$k],
			'planDate'=>date("Y-m-d"),
			'vatNum'=>$nums[$k]
		);

		//删除原来的缸
		if($p['gangId']) foreach($p['gangId'] as &$v) {
			if(empty($v)) continue;
			$m->removeByPkv($v);
		}
		//dump($temp);exit;
		if($m->create($temp)) {
			js_alert('',"window.opener.location.href=window.opener.location.href;window.close()");
		}
	}

	//缸号回修
	function actionHuixiu() {
		$c = & FLEA::getSingleton('Controller_Plan_Dye');
		$c->huixiu();
		js_alert('回修缸号已成功生成',"",$_SERVER['HTTP_REFERER']);
	}
	/**
	 * ps ：未出库整缸回修
	 * Time：2017年12月28日 14:43:29
	 * @author zcc
	*/
	function actionHuixiuNew() {
		// 先判断要此操作的缸是否做过出库，如果做过则终止
		$sql = "SELECT id FROM chengpin_dye_cpck WHERE planId = '{$_GET['id']}'";
		$cpck = $this->_modelExample->findBySql($sql);
		if (count($cpck)>=1) {
			js_alert('已经存在出库无法生成！',"",$_SERVER['HTTP_REFERER']);
			die();
		}
		$c = & FLEA::getSingleton('Controller_Plan_Dye');
		$c->huiXiuZg();
		js_alert('回修缸号已成功生成',"",$_SERVER['HTTP_REFERER']);
	}
	//计划单搜索
	function actionPlanSearch(){
		$this->authCheck(1008);
		FLEA::loadClass('TMIS_Pager');
		$modelPlan = & FLEA::getSingleton('Model_Plan_Dye_Gang');	//trade_dye_order2ware
		$pager =& new TMIS_Pager($modelPlan);
		$rowPlan = $pager->findAll();

		foreach($rowPlan as & $value) {
				$rowset = $this->_modelExample->findByField($this->_pkName, $value[OrdWare][orderId]);
				$value[orderCode] = $rowset[orderCode];
				$value[dateOrder] = $rowset[dateOrder];
				$value[clientName] = $rowset[Client][compName];
				$value[tradeName] = $rowset[Trader][employName];

				$value[color] = $value[OrdWare][color];
				$value[cntKg] = $value[OrdWare][cntKg];
				$value[vatCode] = $value[Vat][vatCode];


				$orderId = $value[OrdWare][orderId];
				$value[edit] = "<a href='".url('Plan_Dye', 'PrintPlan', array('id' => $orderId))."' target='_blank'>查看详细信息</a> | <a target='_blank' href='".url("Plan_Dye","printVatCard",array("id" => $value[id]))."'>打印流转卡</a>";

		}

		#对表头进行赋值
		$arrFieldInfo = array(
			'orderCode' =>'合同编号',
			'dateOrder' =>'日期',
			'clientName' =>'客户',
			'tradeName' => '业务员',
			'color' =>'颜色',
			'cntKg' =>'重量',
			'vatNum' =>'逻辑缸号',
			'vatCode' =>'物理缸号',
			'edit' =>'操作'
		);

		$arrEditInfo = array('editGang' =>'修改', 'removeGang' =>'删除');

		$smarty = & $this->_getView();
		$smarty->assign('title','计划单查询');
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');		//取消新增按钮
		$smarty->assign('arr_field_value', $rowPlan);

		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('pk', $this->_pkName);

		#分页信息
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));

		#开始显示
		$smarty->display('TableList.tpl');

	}

	//删除排缸信息
	function actionRemoveGang() {
		//dump($_SERVER);exit;
		$this->authCheck(105);
		$this->RemoveGangCheck($_GET['id']);
		//删除排缸时判读是否符合要求1.是否有产量2是否出入库3是否有开处方4是否有回修缸号
		$modelPlan = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$pkName=$modelPlan->primaryKey;
		if(!$modelPlan->removeByPkv($_GET[$pkName])) js_alert($modelPlan->errorMsg,'',$_SERVER['HTTP_REFERER']);
		else redirect($_SERVER['HTTP_REFERER']);
	}
	/**
	 * ps ：//删除排缸时判读是否符合要求1.是否有产量2是否出入库3是否有开处方4是否有回修缸号
	 * Time：2017年12月29日 18:39:28
	 * @author zcc
	*/
	function RemoveGangCheck($gangId){
		$sql = "SELECT * FROM chengpin_dye_cprk WHERE planId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在成品入库数据，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
		$sql = "SELECT * FROM chengpin_dye_cpck WHERE planId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在成品出库数据，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
		$sql = "SELECT * FROM dye_hd_chanliang WHERE gangId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在回倒产量数据，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
		$sql = "SELECT * FROM dye_hs_chanliang WHERE gangId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在烘纱产量数据，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
		$sql = "SELECT * FROM dye_rs_chanliang WHERE gangId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在染色产量数据，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
		$sql = "SELECT * FROM dye_st_chanliang WHERE gangId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在松筒产量数据，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
		$sql = "SELECT * FROM dye_zcl_chanliang WHERE gangId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在装出笼产量数据，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
		$sql = "SELECT * FROM gongyi_dye_chufang WHERE gangId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在处方单，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
		$sql = "SELECT * FROM plan_dye_gang WHERE parentGangId = '{$gangId}'";
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re) {
			js_alert("已存在回修缸，无法删除！",'',$_SERVER['HTTP_REFERER']);
			die();
		}
	}
	//修改排缸信息
	function actionEditGang() {
		$this->authCheck(105);
		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$pkName=$modelGang->primaryKey;
		$rowGang = $modelGang->findByField('id', $_GET[$pkName]);
		if ($rowGang['zhelv']) {
			//客户需求添加净损重 投料数* 折率 by zcc 2017年11月10日 15:14:52
			$rowGang['sunJz'] =round($rowGang['cntPlanTouliao']*$rowGang['zhelv'],2);
		}
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_value', $rowGang);
		//取得系统设置中的排缸习惯,
		$mS = & FLEA::getSingleton("Model_Sys_Set");
		$xg = $mS->find(array('setName'=>'PaigangXiguan'));
		if($xg['setValue']==1) {//由定重计算出筒子数
			$smarty->display('Plan/DyeGangEdit_1.tpl');
		}
		else {//由筒子数计算出定重
			$smarty->display('Plan/DyeGangEdit.tpl');
		}
	}

	//复制排缸记录, 用于新增
	function actionCopyGang() {
		$this->authCheck(105);
		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$pkName=$modelGang->primaryKey;
		//echo('----------------'.$pkName);
		//echo($_GET[$pkName]);exit;
		$rowGang = $modelGang->findByField('id', $_GET[$pkName]);
		$arr = $modelGang->getNewGangNum(1);
		$rowGang['vatNum']=$arr[0];
		//dump($rowGang);
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_value', $rowGang);
		$smarty->assign('pk_disabled', 'disabled');
		$smarty->display('Plan/DyeGangEdit.tpl');
	}

	//直接复制某缸
	function actionCopyGangDirectly() {
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$m->clearLinks();
		$arr = $m->find(array('id'=>$_GET['gangId']));
		$arr['id']=0;
		$arr['planDate']=date('Y-m-d');
		$new =$m->getNewGangNum();
		$arr['vatNum']=$new[0];
		$arr['dateLingsha']='0000-00-00';
		$arr['dateDuizhang']='0000-00-00';
		$arr['lingshaBanci']=0;
		$arr['timesPrint']=0;
		$arr['stOver']=0;
		$arr['zclOver']=0;
		$arr['rsOver']=0;
		$arr['hsOver']=0;
		$arr['hdOver']=0;
		$arr['dbOver']=0;
		//dump($arr);exit;
		if($m->create($arr)) redirect($this->_url('PlanManage1',array('order2wareId'=>$arr['order2wareId'])));
	}

	#保存缸的修改结果,因为修改都是以弹出窗口形式产生，所以这里直接关闭，并刷新
	function actionSaveGang() {
		// dump($_POST);exit;
		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$gang = $modelGang->find($_POST['id']);
		if ($gang['vatNum']!=$_POST['vatNum']) {//如果登记保存的数据缸号 和 取出数据库中的不一样  则判断为修改缸号
			if ($gang['vatNumBc']=='') {//如果存被修改缸号 的字段为空 则判定为第一次修改 第一次修改则保存 原始缸号
				$_POST['vatNumBc'] = $gang['vatNum'];
			}
		}
		if (!$_POST[planTongzi][0]>0) js_alert('排缸失败，计划筒子数必须大于0!','window.history.go(-1)');
		$_POST[cntPlanTouliao] = $_POST[cntJ][0]+$_POST[cntW][0];
		$_POST[cntJ] = $_POST[cntJ][0];
		$_POST[cntW] = $_POST[cntW][0];
		$_POST[sunJz] = $_POST[sunJz][0];
		$_POST[planTongzi] = $_POST[planTongzi][0];
		$_POST[vatId] = $_POST[vatId][0];
		$_POST[vat2shuirongId] = $_POST[vat2shuirongId][0];
		$_POST[unitKg]= $_POST['unitKg'][0];
		if (empty($_POST['planDate'])) $_POST['planDate']=date("Y-m-d");
		$_POST['zhelv'] = $_POST['zhelv'][0];
		__TRY();
       		$rukuId = $modelGang->save($_POST);
		$ex = __CATCH();
		//从订单明细修改界面中进行修改
		if($_POST['from']=='1') {js_alert('','window.opener.history.go(0);window.close();');exit;}
		if (__IS_EXCEPTION($ex)) js_alert('逻辑缸号重复!请核实后重新输入',"window.history.go(-1)");
		else redirect($this->_url('PlanManage'));
	}

	function actionPrintDingdan (){
		$pk=$this->_modelExample->primaryKey;
		$this->_editable($_GET[$pk]);
		$arr_field_value=$this->_modelExample->find($_GET[$pk]);
		//$this->_edit($arr_field_value)

		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		//$smarty->assign('title', $this->title);
		//$smarty->assign('user_id', $_SESSION['USERID']);
		//$smarty->assign('real_name', $_SESSION['REALNAME']);
		$smarty->assign('arr_field_value',$arr_field_value);

		#对默认日期变量赋值
		//$smarty->assign('default_date',date('Y-m-d'));

		#增加产品控制器
		$smarty->assign('queen_controller', $this->queenController);

		#通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
		#在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:'');
		$smarty->assign('pk',$primary_key);

		#开始显示
		$smarty->display('Trade/Dye/PrintDingdan.tpl');

	}

	function actionPrintSell (){
		$pk=$this->_modelExample->primaryKey;
		$this->_editable($_GET[$pk]);
		$arr_field_value=$this->_modelExample->find($_GET[$pk]);
		$model = FLEA::getSingleton('Model_JiChu_Ware');
		if (count($arr_field_value[Wares])>0) foreach ($arr_field_value[Wares] as &$v){
			$v[Ware]= $model->find($v[productId]);
			$totalMoney += $v[danjia]*$v[cntKg];
		}
		$totalMoney =number_format($totalMoney,2,'.','');
		//dump($arr_field_value);exit;

		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$arr_field_value);
		$smarty->assign("total_money",$totalMoney);
		FLEA::loadClass('TMIS_Common');
		$smarty->assign("total_rmb",TMIS_Common::trans2rmb($totalMoney));
		#开始显示
		$smarty->display('Trade/Dye/PrintSell.tpl');

	}

	function _edit($Arr, $ArrWareList=null) {
		//dump($Arr);
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign("arr_field_value",$Arr);
		$smarty->assign('title','订单登记');
		$smarty->display('Trade/Dye/OrderEdit.tpl');
	}

	#增加界面--新增主信息
	function actionAdd() {
		/*$this->authCheck($this->addFuncId);
		$this->_edit(array(orderCode=>$this->getNewOrderCode()));*/
		$this->authCheck($this->addFuncId);
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign("arr_field_value",array(
			'orderCode'=>$this->getNewOrderCode(),
			'zhiliang'=>'C')
		);
		$smarty->assign('title','订单登记');
		$smarty->display('Trade/Dye/OrderEditMain.tpl');
	}
	/**
	 * ps ：新增子信息流程
	 * Time：2017年11月21日 10:12:59
	 * @author zcc
	*/
	function actionAddSon(){

		$this->authCheck($this->editFuncId);
		$pk=$this->_modelExample->primaryKey;
		// dump($pk);die();
		$this->_editable($_GET[$pk]);
		$arr_field_value=$this->_modelExample->find($_GET[$pk]);
		$clientId = $arr_field_value['clientId'];
		if ($_POST['orderCode'] != '') {
			$row = $this->_modelExample->findByField('orderCode', $_POST[orderCode]);
			$row[orderCode] = $_POST[newOrderCode];
			$row[dateOrder] = '';
			$row[dateJiaohuo] = '';
			$row = array_merge($row, array(type=>copy));//标志是复制数据
			$arr_field_value = $row;
		}
		$mKucun = & FLEA::getSingleton('Model_CangKu_Report_Month');
		$mGang = &FLEA::getSingleton('Model_Plan_Dye_Gang');
		$model = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$model->disableLink('Order');$model->disableLink('Pdg');
		if($arr_field_value['Ware']) foreach($arr_field_value['Ware'] as & $v) {
			$v = $model->find(array('id'=>$v['id']));
			$v['kucun'] = $mKucun->getCntKucn($v['Order']['clientId'],$v['wareId']);
			$v['cntGang'] = $mGang->findCount(array('order2wareId'=>$v['id']));
			$v['cntPlan'] = $model->getCntPlanTouliao($v['id'])+0;
			if($v['cntPlan']!=$v['cntKg']) $v['cntPlan'] = "<font color='red'>{$v['cntPlan']}</font>";
			$sumCntKg += $v['cntKg'];
			//判断是否订单类型 由于订单类型不一样获取的坯纱类型也不一样
			if ($arr_field_value['kind']=='0') {//加工
				$sql = "SELECT pihao
					FROM cangku_ruku x
					left join cangku_ruku2ware y on x.id = y.ruKuId
					where 1 and x.kind='0' and x.supplierId='{$clientId}' and y.wareId='{$v['wareId']}' group by pihao";
				$pihao = $this->_modelExample->findBySql($sql);
				$v['kuCun'] = $this->GetKucun($clientId,$v['wareId'],$v['pihao'],$arr_field_value['kind']);
			}
			if ($arr_field_value['kind']=='1') {//经销
				$sql = "SELECT pihao
					FROM cangku_ruku x
					left join cangku_ruku2ware y on x.id = y.ruKuId
					where 1 and x.kind='1' and y.wareId='{$v['wareId']}' group by pihao";
				$pihao = $this->_modelExample->findBySql($sql);
				$v['kuCun'] = $this->GetKucunBc($clientId,$v['wareId'],$v['pihao'],$arr_field_value['kind']);
			}
			$v['pihaoArr'] = $pihao;

			$v['money'] = $v['money']==0?'':$v['money'];
		}
		if ($arr_field_value['zhelv']==0) {//折率为零时 显示空数据
			$arr_field_value['zhelv'] ='';
		}
		// dump($arr_field_value);exit();
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign("arr_field_value",$arr_field_value);
		$smarty->assign("rows",$arr_field_value['Ware']);
		$pros = $arr_field_value['Ware'];
		$defaultWare = $pros[count($pros)-1]['Ware'];
		$smarty->assign('defaultWare',$defaultWare);
		$smarty->assign('title','订单登记');
		$smarty->assign('sum_cntkg', $sumCntKg);
		$smarty->display('Trade/Dye/OrderEditSon.tpl');
	}
	#保存
	/*function actionSave() {
		if (!$_POST[isKongnian]) $_POST[isKongnian] = 0;
		if (!$_POST[isFandan]) $_POST[isFandan] = 0;

		if ($_POST[type] == 'copy') {
			$postId = $_POST[id];
			$_POST[id] = '';
		}
		//dump($_POST);exit;
       	$orderId = $this->_modelExample->save($_POST);


		if (!empty($_POST[id])) $orderId = $_POST[id];
		if ($orderId) {
			if ($_POST[type] == 'copy') {
				$model = &FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
				$row = $model->findAll("orderId = $postId");
				if (count($row)>0) foreach($row as $value) {
					$value[id] = '';
					$value[orderId] = $orderId;
					$model->save($value);
				}
			}
			redirect($this->_url('EditWare',array(
				'orderId'=>$orderId,
				'clientId'=>$_POST['clientId']
			)));
		}
		else die('保存失败!');
	}*/
	/**
	 * ps ：保存订单主信息
	 * Time：2017年11月21日 09:55:56
	 * @author zcc
	*/
	function actionSaveMain(){
		if ($_POST['clientId']!='') {
			$rowset = array(
				'id'               =>$_POST['orderId'],
				'orderCode'        =>$_POST['orderCode'],
				'traderId'         =>$_POST['traderId'],
				'clientId'         =>$_POST['clientId'],
				'orderCode2'       =>$_POST['orderCode2'],
				'dateOrder'        =>$_POST['dateOrder'],
				'saleKind'         =>$_POST['saleKind'],
				'zhiliang'         =>$_POST['zhiliang'],
				'honggan'          =>$_POST['honggan'],
				'dateJiaohuo'      =>$_POST['dateJiaohuo'],
				'huidao'           =>$_POST['huidao'],
				'fastness_gan'     =>$_POST['fastness_gan'],
				'fastness_shi'     =>$_POST['fastness_shi'],
				'fastness_baizhan' =>$_POST['fastness_baizhan'],
				'fastness_tuise'   =>$_POST['fastness_tuise'],
				'fastness_yuanyang'   =>$_POST['fastness_yuanyang'],
				'fastness_hanzi'   =>$_POST['fastness_hanzi'],
				'fastness_rishai'   =>$_POST['fastness_rishai'],
				'packing_zhiguan'  =>$_POST['packing_zhiguan'].'',
				'packing_suliao'   =>$_POST['packing_suliao'].'',
				'packing_out'      =>$_POST['packing_out'].'',
				'memo'             =>$_POST['memo'],
				'qita_memo'        =>$_POST['qita_memo'],
				'packing_memo'     =>$_POST['packing_memo'],
				'ranshaNum'        =>$_POST['ranshaNum'],
				'kind'        	   =>$_POST['kind'],
				'paymentWay'	   =>$_POST['paymentWay'].'',
			);
			$id = $this->_modelExample->save($rowset);
			$orderId = $id?$id:$_POST['orderId'];
			//跳转到下一步 登记明细数据
			redirect($this->_url('Edit',array(
				'id'=>$orderId,
			)));
		}
	}


	#保存产品档案
	function actionSaveWare() {
		for ($i=0;$i<count($_POST['cntKg']);$i++){
			if(empty($_POST['wareId'][$i]) || empty($_POST['cntKg'][$i])) continue;
			$arr[] = array(
				'id'           => $_POST['id'][$i],
				'wareId'       => $_POST['wareId'][$i],
				'color'        => $_POST['color'][$i],
				'chandi'       => $_POST['chandi'][$i],
				'pihao'        => $_POST['pihao'][$i],
				'colorNum'     => $_POST['colorNum'][$i],
				'cntKgJ'       => $_POST['cntKgJ'][$i],
				'cntKgW'       => $_POST['cntKgW'][$i],
				'cntKg'        => $_POST['cntKg'][$i],
				'personDayang' => $_POST['personDayang'][$i],
				'ifRemove'     => $_POST['ifRemove'][$i],
				'randanShazhi' => $_POST['randanShazhi'][$i].'',
				'isJiaji'	   =>$_POST['isJiajiV'][$i]+0,
				'kuanhao'	   =>$_POST['kuanhao'][$i],
				'ganghaoKf'	   =>$_POST['ganghaoKf'][$i],
				'zhelvMx'	   =>$_POST['zhelvMx'][$i],
				'danjia'	   =>$_POST['danjia'][$i]?$_POST['danjia'][$i]:0,
				'dateJiaoqi'   =>$_POST['dateJiaoqi'][$i],
				'wareNameBc'   =>$_POST['wareNameBc'][$i].'',
				'memo'   	   =>$_POST['memo'][$i].'',
				'money'   	   =>$_POST['money'][$i].'',
				'isShenhe' 	   =>'0',//默认为审过通过	2018年3月16日 taskId：3885
				                     //2018年04月17   默认为审核不通过 by pan
			);
		}

		$row=array(
				'id'               =>$_POST['orderId'],
				'orderCode'        =>$_POST['orderCode'],
				'traderId'         =>$_POST['traderId'],
				'clientId'         =>$_POST['clientId'],
				'orderCode2'       =>$_POST['orderCode2'],
				'dateOrder'        =>$_POST['dateOrder'],
				'saleKind'         =>$_POST['saleKind'],
				'zhiliang'         =>$_POST['zhiliang'],
				'honggan'          =>$_POST['honggan'],
				'dateJiaohuo'      =>$_POST['dateJiaohuo'],
				'huidao'           =>$_POST['huidao'],
				'fastness_gan'     =>$_POST['fastness_gan'],
				'fastness_shi'     =>$_POST['fastness_shi'],
				'fastness_baizhan' =>$_POST['fastness_baizhan'],
				'fastness_tuise'   =>$_POST['fastness_tuise'],
				'fastness_yuanyang'   =>$_POST['fastness_yuanyang'],
				'fastness_hanzi'   =>$_POST['fastness_hanzi'],
				'fastness_rishai'   =>$_POST['fastness_rishai'],

				'packing_zhiguan'  =>$_POST['packing_zhiguan'].'',
				'packing_suliao'   =>$_POST['packing_suliao'].'',
				'packing_out'      =>$_POST['packing_out'].'',
				'memo'             =>$_POST['memo'],
				'qita_memo'        =>$_POST['qita_memo'],
				'packing_memo'     =>$_POST['packing_memo'],
				'ranshaNum'        =>$_POST['ranshaNum'],
				'kind'        	   =>$_POST['kind'],
				'paymentWay'	   =>$_POST['paymentWay'].'',
				'zhelv'	   		   =>$_POST['zhelv']+0,
				'Ware'             =>$arr
		);
		$modelOrder = FLEA::getSingleton('Model_Trade_Dye_Order');
		$isOrderCodeExist = $this->isOrderCodeExist($row['orderCode']);
		//当 编号存在的情况下，$isOrderCodeExist为1  by-zhujunjie
		//$isOrderCodeExist为1 判断已存在 重新获取编号 by zcc 2017年11月13日
		if ($_POST['orderId']=='') {//新增时 才会 生成订单号
			$row['orderCode'] = $isOrderCodeExist!=1?$row['orderCode']:$this->getNewOrderCode();
		}else{
			//一般情况下是不允许修改 订单编码的
			// $order = $modelOrder->find($_POST['orderId']);
			// if ($row['orderCode']!=$order['orderCode'] && $isOrderCodeExist!=1) {
			// 	$row['orderCode'] = $row['orderCode'];
			// }else{
			// 	$row['orderCode'] = $order['orderCode'];
			// }
		}
		// dump($row);die();
       	$return = $modelOrder->save($row);
		//根据按钮决定转向地址
		if($_POST['sub']=='保存并排计划'){
			redirect(url('Plan_Dye','MakeGang1',array(
				'id'=> ($return===true ? $_POST['orderId'] : $return)
			)));
		} elseif($_POST['sub']=='保存并返回') {
			if($_POST['page']=='paigang'){
                redirect($this->_url('right1'));
            }else{
                redirect($this->_url('right'));
            }
		}
		//if($return) redirect($this->_url('right'));
		//else die('保存失败!');


/*
        dump($_POST);exit;
		$p = & $_POST;
		$modelO2w = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		foreach($_POST['wareId'] as $k=>& $v ) {
			if($p['wareId'][$k]==0) continue;
			$arr[] = array(
				'id'=>$p['id'][$k],
				'orderId'=>$p['orderId'],
				'wareId'=>$p['wareId'][$k],
				'chandi'=>$p['chandi'][$k].'',
				'color'=>$p['color'][$k],
				'colorNum'=>$p['colorNum'][$k],
				'cntKgJ'=>$p['cntKgJ'][$k],
				'cntKgW'=>$p['cntKgW'][$k],
				'cntKg'=>$p['cntKg'][$k],
				'personDayang'=>$p['personDayang'][$k]
			);
		}
		if ($modelO2w->saveRowset($arr)) {
			redirect($this->_url('EditWare',array(
				'orderId'=>$_POST[orderId],
				'defaultWareId'=>$_POST[wareId][0],
				'defaultColorNum'=>$_POST[colorNum][0]
			)));
		}
		else die('保存失败!');
		//修改相同wareId的同一订单的产品明细
		/*if ($_POST[id]>0) {
			$arr = $modelO2w->find(array(id=>$_POST[id]));
			$orderId= $arr[orderId];
			$wareId= $arr[wareId];
			$newWareId = $_POST[wareId];
			$modelO2w->updateField(array(
				orderId => $orderId,
				wareId=>$wareId
			),'wareId',$newWareId);
		}

		if ($modelO2w->save($_POST)) {
			//$modelO2w->updateChuku2wareId($_POST[id], $_POST[wareId]);
			redirect($this->_url('EditWare',array('orderId'=>$_POST[orderId], 'defaultWareId'=>$_POST[wareId])));
		}
		else die('保存失败!');


		for ($i=0;$i<count($_POST['cnt']);$i++){
			if(empty($_POST['productId'][$i]) || empty($_POST['cnt'][$i])) continue;
			$arr[] = array(
				'id'			=> $_POST['id'][$i],
				'productId'		=> $_POST['productId'][$i],
				'cnt'			=> $_POST['cnt'][$i],
				'danjia'		=> $_POST['danjia'][$i],
				'memo'			=> $_POST['memo'][$i],
				'ifRemove'		=> $_POST['ifRemove'][$i]
			);
		}

		$row=array(
				'id'				=>$_POST['chukuId'],
				'chukuNum'			=>$_POST['chukuNum'],
				'chukuDate'			=>empty($_POST['chukuDate'])?date("Y-m-d"):$_POST['chukuDate'],
				'clientId'			=>$_POST['clientId'],
				//'deliverymanId'		=>$_POST['deliverymanId'],
				'operatorId'		=>$_POST['operatorId'],
				//'deliveryTypeId'	=>$_POST['deliveryTypeId'],
				'memo'				=>$_POST['chukuMemo'],
				'orderType'			=>$_POST['orderType'],
				'Products'			=>$arr
		);

		__TRY();
       	$chukuId = $this->_modelChuku->save($row);
		$ex = __CATCH();
		if (__IS_EXCEPTION($ex)) js_alert('入库单号重复!请核实后重新输入',"window.history.go(-1)");
		if($chukuId) redirect($this->_url('right'));
		else die('保存失败!');


*/
		//////////////////////////////////////////////////////////////////////////////////
	}
	#修改界面
	function actionEdit() {
		$this->authCheck($this->editFuncId);
		$pk=$this->_modelExample->primaryKey;
		$this->_editable($_GET[$pk]);
		$arr_field_value=$this->_modelExample->find($_GET[$pk]);
		$clientId = $arr_field_value['clientId'];
		if ($_POST['orderCode'] != '') {
			$row = $this->_modelExample->findByField('orderCode', $_POST[orderCode]);
			$row[orderCode] = $_POST[newOrderCode];
			$row[dateOrder] = '';
			$row[dateJiaohuo] = '';
			$row = array_merge($row, array(type=>copy));//标志是复制数据
			$arr_field_value = $row;
		}
		$mKucun = & FLEA::getSingleton('Model_CangKu_Report_Month');
		$mGang = &FLEA::getSingleton('Model_Plan_Dye_Gang');
		$model = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$model->disableLink('Order');$model->disableLink('Pdg');
		if($arr_field_value['Ware']) foreach($arr_field_value['Ware'] as & $v) {
			$v = $model->find(array('id'=>$v['id']));
			$v['kucun'] = $mKucun->getCntKucn($v['Order']['clientId'],$v['wareId']);
			$v['cntGang'] = $mGang->findCount(array('order2wareId'=>$v['id']));
			$v['cntPlan'] = $model->getCntPlanTouliao($v['id'])+0;
			if($v['cntPlan']!=$v['cntKg']) $v['cntPlan'] = "<font color='red'>{$v['cntPlan']}</font>";
			$sumCntKg += $v['cntKg'];
			//判断是否订单类型 由于订单类型不一样获取的坯纱类型也不一样
			if ($arr_field_value['kind']=='0') {//加工
				$sql = "SELECT pihao
					FROM cangku_ruku x
					left join cangku_ruku2ware y on x.id = y.ruKuId
					where 1 and x.kind='0' and x.supplierId='{$clientId}' and y.wareId='{$v['wareId']}' group by pihao";
				$pihao = $this->_modelExample->findBySql($sql);
				$v['kuCun'] = $this->GetKucun($clientId,$v['wareId'],$v['pihao'],$arr_field_value['kind']);
			}
			if ($arr_field_value['kind']=='1') {//经销
				$sql = "SELECT pihao
					FROM cangku_ruku x
					left join cangku_ruku2ware y on x.id = y.ruKuId
					where 1 and x.kind='1' and y.wareId='{$v['wareId']}' group by pihao";
				$pihao = $this->_modelExample->findBySql($sql);
				$v['kuCun'] = $this->GetKucunBc($clientId,$v['wareId'],$v['pihao'],$arr_field_value['kind']);
			}
			$v['pihaoArr'] = $pihao;

			$v['money'] = $v['money']==0?'':$v['money'];
			//判断这个订单明细中的缸号是否已经有产量 有则无法进行 清空功能
			$v['islock'] = $this->ClearCheck($v['id']);
		}
		if ($arr_field_value['zhelv']==0) {//折率为零时 显示空数据
			$arr_field_value['zhelv'] ='';
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign("arr_field_value",$arr_field_value);
		$smarty->assign("rows",$arr_field_value['Ware']);
		$pros = $arr_field_value['Ware'];
		$defaultWare = $pros[count($pros)-1]['Ware'];
		$smarty->assign('defaultWare',$defaultWare);
		$smarty->assign('title','订单登记');
		$smarty->assign('sum_cntkg', $sumCntKg);
		$smarty->display('Trade/Dye/OrderEdit.tpl');
	}
	function GetKucun($clientId,$wareId,$pihao,$kind){
		//by zcc 客户要求 获取的库存 也要算上下了生产计划的 一旦下了生产计划 库存就会相应的减少 2017年10月13日
		//算法为：库存 = 入库 - 计划已领用(出库) - 计划未领用(计划数-出库).
		//客户都是计划多少出库多少 就是 为 库存 = 入库- 计划数
		//获取入库数据
		$sql = "SELECT sum(cnt) as rukuCnt
			FROM cangku_ruku x
			left join cangku_ruku2ware y on x.id = y.ruKuId
			where 1 and x.supplierId='{$clientId}' and y.wareId='{$wareId}' and y.pihao='{$pihao}' and x.kind='{$kind}' ";
		$ruku = $this->_modelExample->findBySql($sql);
		//获取计划已领用(出库)数据
		$sql = "SELECT sum(cnt) as chukuCnt
			FROM cangku_chuku2ware
			where supplierId='{$clientId}' and wareId='{$wareId}' and pihao='{$pihao}' and kind='{$kind}'";
		$chuku = $this->_modelExample->findBySql($sql);
		//计划数
		$sql = "SELECT sum(x.cntKg) as cnt
			FROM trade_dye_order2ware x
			left join trade_dye_order y on x.orderId = y.id
			where 1 and y.clientId='{$clientId}' and y.kind='{$kind}' and x.wareId='{$wareId}' and x.pihao='{$pihao}'";
		$planCnt = $this->_modelExample->findBySql($sql);

		$kucun = round($ruku[0]['rukuCnt']-$planCnt[0]['cnt']);
		return $kucun;
	}
	/**
	 * ps ：本厂坯纱可用库存(原理同GetKucun)
	 * Time：2017年10月26日 10:01:07
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function GetKucunBc($clientId,$wareId,$pihao,$kind){
		$sql = "SELECT sum(cnt) as rukuCnt
			FROM cangku_ruku x
			left join cangku_ruku2ware y on x.id = y.ruKuId
			where 1 and x.kind='{$kind}' and y.wareId='{$wareId}' and y.pihao='{$pihao}' ";
		$ruku = $this->_modelExample->findBySql($sql);
		//获取计划已领用(出库)数据
		$sql = "SELECT sum(cnt) as chukuCnt
			FROM cangku_chuku2ware
			where kind='{$kind}' and wareId='{$wareId}' and pihao='{$pihao}'";
		$chuku = $this->_modelExample->findBySql($sql);
		//计划数
		$sql = "SELECT sum(x.cntKg) as cnt
			FROM trade_dye_order2ware x
			left join trade_dye_order y on x.orderId = y.id
			where 1 and y.kind='{$kind}' and x.wareId='{$wareId}' and x.pihao='{$pihao}'";
		$planCnt = $this->_modelExample->findBySql($sql);
		$kucun = round($ruku[0]['rukuCnt']-$planCnt[0]['cnt']);
		return $kucun;
	}
	#修改货品界面
	function actionEditWare() {
		$smarty = & $this->_getView();
		$model = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$modelWare = FLEA::getSingleton('Model_JiChu_Ware');
		$mGang = &FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mKucun = & FLEA::getSingleton('Model_CangKu_Report_Month');
		$pros = $model->findAll("orderId='$_GET[orderId]'");
		$order = $this->_modelExample->find(array('id'=>$_GET['orderId']));
		//dump($pros);exit;
		if ($_GET['defaultWareId']) {
			$rowWare = $modelWare->findByField('id', $_GET[defaultWareId]);
			$smarty->assign('ware', $rowWare);
		}

		$sumCntKg = 0;

		if (count($pros)>0) foreach($pros as &$p) {
			$p['kucun'] = $mKucun->getCntKucn($p['Order']['clientId'],$p['wareId']);
			$p['cntGang'] = $mGang->findCount(array('order2wareId'=>$p['id']));
			$p['cntPlan'] = $model->getCntPlanTouliao($p['id'])+0;
			if($p['cntPlan']!=$p['cntKg']) $p['cntPlan'] = "<font color='red'>{$p['cntPlan']}</font>";
			$sumCntKg += $p['cntKg'];
		}
		//dump($pros[0]);
		//dump($pros);exit;
		$smarty->assign('rows',$pros);
		$smarty->assign('sum_cntkg', $sumCntKg);
		$smarty->assign('order',$order);
		$smarty->assign('clientId',$pros[0]['Order']['clientId']);
		$smarty->assign('orderCode',$pros[0][Order][orderCode]);

		$defaultWare = $pros[count($pros)-1]['Ware'];
		$smarty->assign('defaultWare',$defaultWare);
		$smarty->display('Trade/Dye/Order2WareEdit.tpl');
	}
	#删除
	function actionRemove() {
		$this->authCheck($this->delFuncId);
		$this->_editable($_GET[$pk]);
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[$pk]);
		redirect($this->_url("right"));
	}

	//在合同编辑界面中采用ajax方式进行删除
	function actionRemoveWare() {
		$model = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$pro = $model->find($_GET[id]);

		$orderId = $pro[orderId];
		if(!$model->removeByPkv($_GET[id])) {
			echo '{success:false,msg:"该颜色已排缸，如要删除，请先清除其排缸记录！"}';exit;
		}
		echo '{success:true,msg:"成功删除!"}';exit;
	}

	function actionGetWaresJson() {
		$ruku = $this->_modelExample->find("ruKuNum='$_GET[rukuNum]'");
		$rukuId = $ruku[id];
		$modelRuku2Wares = FLEA::getSingleton('Model_Trad_Order_Dye2Ware');
		$wares = $modelRuku2Wares->findAll("rukuId='$rukuId'");
		for ($i=0;$i<count($wares);$i++) {
			$wares[$i][rukuNum] = $_GET[rukuNum];
		}
		echo json_encode($wares);exit;
	}

	//判断id=$pkv的入库单是否允许被修改或删除,有以下情况返回false
	//财务已经审核其中一笔货物。
	function _editable($pkv) {
		$arr_field_value=$this->_modelExample->find($pkv);
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
	}

	//获得新的orderId
	function getNewOrderCode() {
		$model = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$arr=$model->find(null,'orderCode desc','orderCode');
		$max = substr($arr[orderCode],-8);
		$temp = date("ymd")."01";
		if ($temp>$max) return "DN".$temp;
               $a = substr($max,-2)+101;
		return "DN".substr($max,0,-2).substr($a,1);
	}

	// 判断订单号是否已存在
	function isOrderCodeExist($orderCode){
		$model = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$arr=$model->find(array('orderCode'=>$orderCode));
		//当数组不存在的时候，count($arr)还是会等于1的。所以这边设计成大于1的时候。(谬论  $arr 为空字符串 不是数组by zcc)
		return count($arr)>1?true:false;
	}

	//订单搜索
	function actionOrderSearch() {
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-20,date("Y"))),
			//dateFrom =>date("Y-m-d"),
			'dateTo' => date("Y-m-d"),
			'clientId' => '',
			'orderCode' => '',
			'zhishu'=>''
		));
		$sql = "select x.*,y.dateOrder,y.ranshaNum,c.compName,
		y.orderCode,z.wareName,z.guige
		from trade_dye_order2ware x
		inner join trade_dye_order y on x.orderId=y.id
		left join jichu_ware z on x.wareId=z.id
		left join jichu_client c on y.clientId=c.id
		where y.dateOrder>='{$arrGet['dateFrom']}'
		and y.dateOrder<='{$arrGet['dateTo']}'";
		if($arrGet['clientId']!='') {
			$sql .= " and y.clientId='{$arrGet['clientId']}'";
		}
		if($arrGet['orderCode']!='') {
			$sql .= " and y.orderCode like '%{$arrGet['orderCode']}%'";
		}
		if($arrGet['zhishu']!='') {
			$sql .= " and z.wareName like '%{$arrGet['zhishu']}%'";
		}
		$sql .= " order by x.orderId desc";

		$rowset = $this->_modelExample->findBySql($sql);
		foreach($rowset as & $v) {
			//dump($v);exit;
			//取得投料数
			$sql = "select sum(cntPlanTouliao) as cnt
			from plan_dye_gang where order2wareId='{$v['id']}'";
			$re = mysql_fetch_assoc(mysql_query($sql));
			$v['cntPlanTouliao'] = $re['cnt'];

			//取得成品发出数
			$sql = "select sum(x.cntChuku) as cnt
			from chengpin_dye_cpck x
			left join plan_dye_gang y on x.planId=y.id
			where y.order2wareId='{$v['id']}'";
			$re = mysql_fetch_assoc(mysql_query($sql));
			$v['cntCpck'] = $re['cnt'];

			$v['guige'] = $v['wareName'].' '.$v['guige'];
		}

		$heji = $this->getHeji($rowset,array('cntKg','cntPlanTouliao','cntCpck'),'dateOrder');
		$rowset[] = $heji;
		#对表头进行赋值
		$arrFieldInfo = array(
			"dateOrder"      =>"日期",
			"compName"       =>"客户",
			"orderCode"      =>"订单号",
			"ranshaNum"      =>"染纱计划单号",
			"guige"          =>"纱支",
			"color"          =>"颜色",
			"colorNum"       =>"色号",
			"cntKg"          =>"要货数kg",
			"cntPlanTouliao" =>"投料数",
			"cntCpck"        =>"成品发出"
		);
		$smarty = & $this->_getView();
		$smarty->assign('title', '订单查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition', $arrGet);
		$smarty->display('TableList.tpl');
	}

	#设置权限
	function _setFuncId() {
		$rukuTag = $this->_checkModel();
		$this->readFuncId = 107;
		$this->addFuncId =108;
		$this->editFuncId =108;
		$this->delFuncId =108;
	}

	function _checkModel() {
		if ($_GET[rukuTag]) {
			$_SESSION['rukuTag'] = $_GET[rukuTag];
			$this->rukuTag = $_SESSION['rukuTag'];
		}
		elseif ($_SESSION['rukuTag']) $this->rukuTag = $_SESSION['rukuTag'];

		return $this->rukuTag;
	}
	#将排缸中的对账日期转移到订单明细中
	function actionBulou(){
		set_time_limit(0);
		$str="select *
			from plan_dye_gang
			where dateDuizhang <> '0000-00-00'
			group by order2wareId
			order by dateDuizhang
		";
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			$str="update trade_dye_order2ware
				set dateDuizhang='{$re['dateDuizhang']}'
				where id='{$re['order2wareId']}'
			";
			mysql_query($str);
		}
		echo '执行成功！';
	}

	//获得染纱计划单号是否已经安排
	function actionGetRsJihua(){

		$returnValue = array(
			"success" => true,
			"msg"     => ""
		);

		$strNum = $_GET["ranshaNum"];//染纱计划单号

		$rowset = $this->_modelExample->findAll(array("ranshaNum"=>$strNum));
		// dump($rowset);exit;
		if (count($rowset) > 0){
			$returnValue["success"] = false;
			$returnValue["msg"] = "染纱计划单号：{$strNum}，已经安排过，不要重复安排。";
		}

		echo json_encode($returnValue);
	}
	/**
	 * ps ：生产计划登记中选择纱支 的弹窗(选择纱支品种调用有库存的纱支种类，注意，是可用库存，并非是实际库存。)
	 * Time：2017年10月23日
	 * @author zcc
	*/
	function actionPopup(){
		// dump($_GET);die();
		//可用库存 = 入库数量- 计划数量
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'key'=>'',
		));
		$_modelWare =  & FLEA::getSingleton('Model_JiChu_Ware');
		//入库数据
		$sqlRk = "SELECT sum(y.cnt) as rukuCnt,0 as chukuCnt,w.id as wareId,w.wareName,w.guige,c.compName,c.id as clientId,y.pihao,y.chandi
			FROM cangku_ruku x
			left join cangku_ruku2ware y on x.id = y.rukuId
			left join jichu_client c on c.id = x.supplierId
			left join jichu_ware w on w.id = y.wareId
			where 1 and x.kind = 0 and c.id = {$_GET['clientId']}";
		$topNode = $_modelWare->getTopNodeOfPisha();
		$leftId = $topNode[leftId];
		$rightId = $topNode[rightId];
		$sqlRk .= " and w.leftId>'$leftId' and w.rightId<'$rightId' and w.leftId+1=w.rightId";
		$sqlRk .= " group by c.id,w.id,y.pihao,y.chandi";
		//计划数量
		$sqlCk = "SELECT 0 as rukuCnt,sum(x.cntKg) as chukuCnt,w.id as wareId,w.wareName,w.guige,c.compName,c.id as clientId,x.pihao,x.chandi
			FROM trade_dye_order2ware x
			left join trade_dye_order y on x.orderId = y.id
			left join jichu_client c on c.id = y.clientId
			left join jichu_ware w on w.id = x.wareId
			where 1 and y.kind = 0 and c.id = {$_GET['clientId']}
			";
		$sqlCk .= " and w.leftId>'$leftId' and w.rightId<'$rightId' and w.leftId+1=w.rightId";
		$sqlCk .= " group by c.id,w.id,x.pihao,x.chandi";

		$sql = "SELECT sum(a.rukuCnt) as rukuCnt,sum(a.chukuCnt) as chukuCnt,sum(a.rukuCnt)-sum(a.chukuCnt) as kuCun,a.compName,a.clientId,a.wareId as id,a.wareName,a.guige,a.pihao,a.chandi
			FROM ( $sqlRk union $sqlCk ) as a
			where 1
			";
		if ($arr['key']!='') {
			$sql .= " and (a.wareName like '%{$arr['key']}%' or a.guige like '%{$arr['key']}%' or a.pihao like '%{$arr['key']}%' or a.chandi like '%{$arr['key']}%')";
		}
		$sql .= " GROUP BY a.clientId,a.wareId,a.pihao,a.chandi having kuCun > 0";
		$pager =& new TMIS_Pager($sql);
        $rowset =$pager->findAllBySql($sql);
        foreach ($rowset as &$v) {
        	//获取这个纱支 和批号 最近在生产计划中填写的纱支别名 by zcc 需求id 3194
        	$sql = "SELECT wareNameBc FROM  trade_dye_order2ware  where wareId='{$v['id']}' and pihao = '{$v['pihao']}' order by id desc limit 0,1";
        	$name = $this->_modelExample->findBySql($sql);
        	$v['wareNameBc'] = $name[0]['wareNameBc']?$name[0]['wareNameBc']:'';
        }
		// dump($rowset);die();
		$arr_field_info = array(
            //"_edit" => "选择",
            'compName' => '客户',
            "wareName" => "名称",
            'guige' => "规格",
			'pihao' => '批号',
			'chandi' => '产地',
			'kuCun' => '有效库存',
        );

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择纱支');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        $smarty->assign('s',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr+$_GET)));
        $smarty-> display('Popup/common.tpl');
	}
	/**
	 * ps ：生产计划登记选择纱支 当订单类型为经销时
	 * Time：#2017年10月23日 15:09:52
	 * @author zcc
	*/
	function actionPopupBc(){
		//可用库存 = 入库数量- 计划数量
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'key'=>'',
		));
		$_modelWare =  & FLEA::getSingleton('Model_JiChu_Ware');
		//入库数据
		$sqlRk = "SELECT sum(y.cnt) as rukuCnt,0 as chukuCnt,w.id as wareId,w.wareName,w.guige,y.pihao,y.chandi
			FROM cangku_ruku x
			left join cangku_ruku2ware y on x.id = y.rukuId
			left join jichu_ware w on w.id = y.wareId
			where 1 and x.kind = 1 ";
		$topNode = $_modelWare->getTopNodeOfPisha();
		$leftId = $topNode[leftId];
		$rightId = $topNode[rightId];
		$sqlRk .= " and w.leftId>'$leftId' and w.rightId<'$rightId' and w.leftId+1=w.rightId";
		$sqlRk .= " group by w.id,y.pihao,y.chandi";
		//计划数量
		$sqlCk = "SELECT 0 as rukuCnt,sum(x.cntKg) as chukuCnt,w.id as wareId,w.wareName,w.guige,x.pihao,x.chandi
			FROM trade_dye_order2ware x
			left join trade_dye_order y on x.orderId = y.id
			left join jichu_ware w on w.id = x.wareId
			where 1 and y.kind = 1
			";
		$sqlCk .= " and w.leftId>'$leftId' and w.rightId<'$rightId' and w.leftId+1=w.rightId";
		$sqlCk .= " group by w.id,x.pihao,x.chandi";

		$sql = "SELECT sum(a.rukuCnt) as rukuCnt,sum(a.chukuCnt) as chukuCnt,sum(a.rukuCnt)-sum(a.chukuCnt) as kuCun,a.wareId as id,a.wareName,a.guige,a.pihao,a.chandi
			FROM ( $sqlRk union $sqlCk ) as a
			where 1
			";
		if ($arr['key']!='') {
			$sql .= " and (a.wareName like '%{$arr['key']}%' or a.guige like '%{$arr['key']}%' or a.pihao like '%{$arr['key']}%' or a.chandi like '%{$arr['key']}%')";
		}
		$sql .= " GROUP BY a.wareId,a.pihao,a.chandi having kuCun > 0";
		$pager =& new TMIS_Pager($sql);
        $rowset =$pager->findAllBySql($sql);
        foreach ($rowset as &$v) {
        	$v['compName'] = '本厂';
        	//获取这个纱支 和批号 最近在生产计划中填写的纱支别名 by zcc 需求id 3194
        	$sql = "SELECT wareNameBc FROM  trade_dye_order2ware  where wareId='{$v['wareId']}' and pihao = '{$v['pihao']}' order by id desc limit 0,1";
        	$name = $this->_modelExample->findBySql($sql);
        	$v['wareNameBc'] = $name[0]['wareNameBc']?$name[0]['wareNameBc']:'';
        }
		// dump($rowset);die();
		$arr_field_info = array(
            //"_edit" => "选择",
            // 'compName' => '客户',
            "wareName" => "名称",
            'guige' => "规格",
			'pihao' => '批号',
			'chandi' => '产地',
			'kuCun' => '有效库存',
        );

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择纱支');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        $smarty->assign('s',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr+$_GET)));
        $smarty-> display('Popup/common.tpl');
	}
	/**
	 * ps ：客户要去复制的所有订单数据(未完成) 客户，缸号，纱支，客户缸号，色号，颜色，投坯数，筒子只数  纱支别名
	 * Time：2017年11月1日 10:28:12
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionCopyData(){
		$sql = "SELECT c.compName as clientName,p.vatNum,w.wareName,w.guige,y.wareNameBc,y.color,y.colorNum,
		p.cntPlanTouliao,p.planTongzi,y.ganghaoKf
			FROM  trade_dye_order x
			left join trade_dye_order2ware y on x.id = y.orderId
			left join plan_dye_gang p on p.order2wareId = y.id
			left join jichu_client c on c.id = x.clientId
			left join jichu_ware w on w.id = y.wareId
			where p.id = '{$_GET['id']}'";
		$row = $this->_modelExample->findBySql($sql);
		foreach ($row as &$v) {
			$arr['clientName']  = "客户:".$v['clientName'];
			$arr['vatNum']  = "缸号:".$v['vatNum'];
			$arr['ganghaoKf']  = "客户缸号:".$v['ganghaoKf'];
			$arr['wareName'] = "纱支:".$v['wareName'].' '.$v['guige'];
			if ($v['wareNameBc']!='') {
				$arr['wareName'] = "纱支:".$v['wareNameBc'];
			}
			$arr['color']  = "颜色:".$v['color'];
			$arr['colorNum']  = "色号:".$v['colorNum'];
			$arr['cntPlanTouliao']  = "投料数:".$v['cntPlanTouliao'];
			$arr['planTongzi']  = "筒子数:".$v['planTongzi'];
		}
		$arr['text'] = join("\n",$arr);
		$smarty = & $this->_getView();
		$smarty->assign('title', '选择纱支');
		$smarty->assign('arr_field_value',$arr);
		$smarty->display('Plan/CopyData.tpl');
	}
	/**
	 * ps ：保存单条的订单明细数据（ajax）
	 * Time：2017年11月21日 17:09:49
	 * @author zcc
	*/
	function actionAjaxSaveRow(){
		if (empty($_GET['wareId']) || empty($_GET['cntKg'])) {
			echo json_encode(array('success'=>false,'msg'=>'没有选择纱支或者纱支重量为空!'));
			die();
		}
		if (empty($_GET['danjia']) && empty($_GET['money'])) {
			echo json_encode(array('success'=>false,'msg'=>'单价或者小缸价，其中一个没有填写或者为0!'));
			die();
		}
		// dump($_GET);
		$row = array(
			'id'           => $_GET['id'],
			'wareId'       => $_GET['wareId'],
			'color'        => $_GET['color'],
			'chandi'       => $_GET['chandi'],
			'pihao'        => $_GET['pihao'],
			'colorNum'     => $_GET['colorNum'],
			'cntKgJ'       => $_GET['cntKgJ'],
			'cntKgW'       => $_GET['cntKgW'],
			'cntKg'        => $_GET['cntKg'],
			'personDayang' => $_GET['personDayang'].'',
			// 'ifRemove'     => $_GET['ifRemove'],
			'randanShazhi' => $_GET['randanShazhi'].'',
			'isJiaji'	   =>$_GET['isJiaji']==='true'?1:0,
			'kuanhao'	   =>$_GET['kuanhao'],
			'ganghaoKf'	   =>$_GET['ganghaoKf'],
			'zhelvMx'	   =>$_GET['zhelvMx'],
			'danjia'	   =>$_GET['danjia'],
			'dateJiaoqi'   =>$_GET['dateJiaoqi'],
			'wareNameBc'   =>$_GET['wareNameBc'].'',
			'memo'   	   =>$_GET['memo'].'',
			'money'   	   =>$_GET['money'].'',
			'orderId'      =>$_GET['orderId']
		);
		// dump($row);die();
		$modelOrder2 = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$id = $modelOrder2->save($row);
		if ($id) {
			if ($_GET['id']=='') {
				echo json_encode(array('success'=>true,'msg'=>'保存成功！','id'=>$id,));
			}else{
				echo json_encode(array('success'=>true,'msg'=>'保存成功！',));
			}

		}
		die();
	}
	/**
	 * ps ：财务对账中的小缸价修改
	 * Time：2017年12月13日 14:29:35
	 * @author zcc
	*/
	function actionRightHavePrice2(){
		$this->authCheck(143);	//4是财务部门总权限
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId => '',
			orderCode =>'',
			//key => ''
		));
		$condition=array(
			array('Order.dateOrder', "$arrGet[dateFrom]", '>='),
			array('Order.dateOrder', "$arrGet[dateTo]", '<=')
		);
		if ($arrGet[clientId] != '') $condition[]=array('Order.clientId',"$arrGet[clientId]");
		if ($arrGet[orderCode] != '') $condition[]=array('Order.orderCode', "%$arrGet[orderCode]%", 'like');
		$condition[] = array('money', 0, '>');

		$m = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$mC = & FLEA::getSingleton('Model_Jichu_Client');
		$mW = & FLEA::getSingleton('Model_Jichu_Ware');
		$pager = & new TMIS_Pager($m, $condition, 'dateOrder desc');
		$rowset = $pager->findAll();

		foreach ($rowset as & $value) {
			//dump($value);
			//$value[departmentName] = $value[Department][depName];
			$value[orderCode] = $this->_modelExample->getOrderTrack($value[Order][id],$value[Order][orderCode]);
			$value[dateOrder] = $value[Order][dateOrder];
			$client = $mC->find(array(id=>$value[Order][clientId]));
			$value[clientName] = $client[compName];
			$value[shazhi] = $value[Ware][wareName] . " " . $value[Ware][guige];
			//取得客户单号
			if($value['Order']['orderCode2']!='') $value['clientName']=$value['clientName'].'('.$value['Order']['orderCode2'].')';
			if ($value['isShenhe']==1) {
				$value[money] = "<span id='spanDanjia' title='已审核无法修改！'>".$value['money']."</span>";
			}else{
				$value[money] = "<span id='spanMoney' onmouseover='this.style.backgroundColor=\"#828282\"' onmouseout='this.style.backgroundColor=\"\"' onclick='beginSet(this,$value[id])'>$value[money]</span>";
			}
		}

		$smarty = & $this->_getView();

		#对变量赋值
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('title', $this->title);

		#对表头进行赋值
		$arrFieldInfo = array(
			"orderCode" =>"合同编号",
			"dateOrder" =>"日期",
			"clientName" =>"客户",
			"shazhi" => "纱支",
			"color" =>"颜色",
			"cntKg"=>"公斤数",
			"money" => "小缸价"
			//"other" => "其他"
		);

		$smarty->assign('title','筒染订单');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('other_script','<script language="javascript" src="Resource/Script/Ajax/setMoney.js"></script>');
		//$smarty->assign('search_display', 'none');
		$smarty->assign('pk',$pk); //设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arrGet)));
		$smarty->display('TableList.tpl');
	}
	//利用ajax方式修改单价 by zcc
	function actionSetMoneyAjax(){
		$this->authCheck(143);
		$m = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		//判断 要修改的订单数据中 是否存在小缸价或单价 如果任意一个存在则另一个不允许修改单价
		$order2pro = $m->find($_GET[id]);
		if ($order2pro['danjia']>0) {
			echo "{success:false}";die();
		}
		//dump($_GET);exit;
		$m->updateField(array(id=>$_GET[id]),'money',$_GET[money]);
		$dbo=&FLEA::getDBO(false);
		//dump($dbo->log);exit;
		echo "{success:true}";
	}
	/**
	 * ps ：订单明细的审核（当完成审核 则对应的订单明细中的单价和小缸价无法进行修改）
	 * Time：2017年12月13日 14:53:30
	 * @author zcc
	*/
	function actionOrderShenhe(){
		$this->authCheck(144);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			"dateFrom" =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			"dateTo" => date("Y-m-d"),
			"clientId" => '',
			"orderCode" =>'',
			//key => ''
		));
		$sql = "SELECT
			o.orderCode,o.dateOrder,o.clientId,o2.*,w.wareName,w.guige,c.compName as clientName
		FROM
			 trade_dye_order2ware o2
		LEFT JOIN trade_dye_order o ON o.id = o2.orderId
		left join jichu_client c on c.id = o.clientId
		left join jichu_ware w on w.id = o2.wareId
		WHERE 1 ";
		if ($arrGet['dateFrom']!='') {
			$sql .= " and o.dateOrder >= '{$arrGet['dateFrom']}' and o.dateOrder <= '{$arrGet['dateTo']}'";
		}
		if ($arrGet['clientId']!='') {
			$sql .= " and o.clientId = '{$arrGet['clientId']}'";
		}
		if ($arrGet['orderCode']!='') {
			$sql .= " and o.orderCode like '%{$arrGet['orderCode']}%'";
		}
		$sql .= " group by o2.id order by o.dateOrder,o.orderCode";
		// dump($sql);die();
		$pager = & new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		foreach ($rowset as &$v) {
			$v['_edit'].="<a href='".$this->_url('Shenhe',array('id'=>$v['id'],'isShenhe'=>$v['isShenhe']==0?1:0))."' onclick='return confirm(\"您确认要操作吗?\")'>".($v['isShenhe']==0?'审核':'取消审核')."</a>  ";
			if ($v['isShenhe']==1) {
				$v['danjia'] = "<span id='spanDanjia' title='已审核无法修改！'>".$v['danjia']."</span>";
				$v['money'] = "<span id='spanMoney' title='已审核无法修改！'>".$v['money']."</span>";
			}else{
				$v['danjia'] = "<span id='spanDanjia' onmouseover='this.style.backgroundColor=\"#828282\"' onmouseout='this.style.backgroundColor=\"\"' onclick='beginSetD(this,$v[id])'>$v[danjia]</span>";
				$v['money'] = "<span id='spanMoney' onmouseover='this.style.backgroundColor=\"#828282\"' onmouseout='this.style.backgroundColor=\"\"' onclick='beginSetM(this,$v[id])'>$v[money]</span>";
			}

		}
		$smarty = & $this->_getView();
		#对变量赋值
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('title', $this->title);
		#对表头进行赋值
		$arrFieldInfo = array(
			"orderCode" =>"合同编号",
			"dateOrder" =>"日期",
			"clientName" =>"客户",
			"wareName" => "纱支",
			'guige' =>'规格',
			"color" =>"颜色",
			'colorNum' =>'色号',
			'danjia' =>'单价',
			'money' =>'小缸价',
			"_edit" => "操作"
			//"other" => "其他"
		);
		$smarty->assign('title','订单明细审核');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition', $arrGet);
		//$smarty->assign('search_display', 'none');
		$smarty->assign('other_script','<script language="javascript" src="Resource/Script/Ajax/setDanjiaMoney.js"></script>');
		$smarty->assign('pk',$pk); //设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arrGet)));
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps ：订单明细审核方法
	 * Time：2019/08/05 14:04:05
	 * @author zcc
	*/
	#审核
	function actionShenhe(){
		$this->authCheck(144);
		$_modelOrder2pro = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$arr=array(
			'id'=>$_GET['id'],
			'isShenhe'=>$_GET['isShenhe']
		);
		$_modelOrder2pro->save($arr);
		redirect($this->_url('OrderShenhe'));
	}
	/**
	 * ps ：订单明细折率修改
	 * Time：2017年12月13日 17:20:29
	 * @author zcc
	*/
	function actionRightHaveZhelv(){
		// $this->authCheck(145);	//4是财务部门总权限
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId => '',
			orderCode =>'',
			//key => ''
		));
		$condition=array(
			array('Order.dateOrder', "$arrGet[dateFrom]", '>='),
			array('Order.dateOrder', "$arrGet[dateTo]", '<=')
		);
		if ($arrGet[clientId] != '') $condition[]=array('Order.clientId',"$arrGet[clientId]");
		if ($arrGet[orderCode] != '') $condition[]=array('Order.orderCode', "%$arrGet[orderCode]%", 'like');
		$condition[] = array('money', 0, '>');

		$m = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$mC = & FLEA::getSingleton('Model_Jichu_Client');
		$mW = & FLEA::getSingleton('Model_Jichu_Ware');
		$pager = & new TMIS_Pager($m, $condition, 'dateOrder desc');
		$rowset = $pager->findAll();

		foreach ($rowset as & $value) {
			//dump($value);
			//$value[departmentName] = $value[Department][depName];
			$value[orderCode] = $this->_modelExample->getOrderTrack($value[Order][id],$value[Order][orderCode]);
			$value[dateOrder] = $value[Order][dateOrder];
			$client = $mC->find(array(id=>$value[Order][clientId]));
			$value[clientName] = $client[compName];
			$value[shazhi] = $value[Ware][wareName] . " " . $value[Ware][guige];
			//取得客户单号
			if($value['Order']['orderCode2']!='') $value['clientName']=$value['clientName'].'('.$value['Order']['orderCode2'].')';

			$value['_edit'].="<a href='".$this->_url('SetZhelv',array('id'=>$v['id']))."'>"."修改折率"."</a>  ";
		}

		$smarty = & $this->_getView();

		#对变量赋值
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('title', $this->title);

		#对表头进行赋值
		$arrFieldInfo = array(
			"orderCode" =>"合同编号",
			"dateOrder" =>"日期",
			"clientName" =>"客户",
			"shazhi" => "纱支",
			"color" =>"颜色",
			'colorNum' =>'色号',
			'_edit' =>'操作',
			//"other" => "其他"
		);

		$smarty->assign('title','筒染订单明细');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition', $arrGet);
		//$smarty->assign('search_display', 'none');
		$smarty->assign('pk',$pk); //设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arrGet)));
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps ：(待完善)
	 * Time：2019/08/05 14:04:05
	 * @author zcc
	*/
	function actionSetZhelv(){

	}
	/**
	 * ps ：检测订单明细是否有缸已经有产量数据 防止删除
	 * Time：2018年1月15日 13:19:31
	 * @author zcc
	*/
	function ClearCheck($order2wareId){
		$m=& FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr = $m->findAll(array(order2wareId=>$order2wareId));
		foreach($arr as $v) {
			$sqlhd = "SELECT * FROM dye_hd_chanliang WHERE gangId = '{$v['id']}'";
			$re1 = mysql_fetch_assoc(mysql_query($sqlhd));
			$sqlhs = "SELECT * FROM dye_hs_chanliang WHERE gangId = '{$v['id']}'";
			$re2 = mysql_fetch_assoc(mysql_query($sqlhs));
			$sqlrs = "SELECT * FROM dye_rs_chanliang WHERE gangId = '{$v['id']}'";
			$re3 = mysql_fetch_assoc(mysql_query($sqlrs));
			$sqlst = "SELECT * FROM dye_st_chanliang WHERE gangId = '{$v['id']}'";
			$re4 = mysql_fetch_assoc(mysql_query($sqlst));
			$sqlzcl = "SELECT * FROM dye_zcl_chanliang WHERE gangId = '{$v['id']}'";
			$re5 = mysql_fetch_assoc(mysql_query($sqlzcl));
			if ($re1 || $re2 || $re3 || $re4 || $re5) {
				return 1;
			}
		}
		return 0;
	}

}
?>