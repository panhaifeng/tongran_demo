<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Plan_Dye extends Tmis_Controller {
	var $_modelExample;
	var $_modelPlan;
	var $funcId=49;
	var $_pkName;
	function Controller_Plan_Dye() {
		$this->arrLeftHref = array(
			"Plan_Dye" =>"筒染订单",
			"<a href='Index.php?controller=Plan_Dye&action=SearchPlan' target='main'>计划单查询</a>"
		);
		$this->leftCaption = '生产计划管理';
		$this->_modelExample = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelPlan = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$this->_pkName = $this->_modelExample->primaryKey;
        $this->_modelWare= & FLEA::getSingleton('Model_JiChu_Ware');
	}

	function actionRight(){
		$this->authCheck(90);
		redirect("Index.php?controller=Trade_Dye_Order&action=PlanManage");
	}

	function actionSearchPlan() {
		redirect("Index.php?controller=Trade_Dye_Order&action=SearchOrder");
	}

	function actionMakeGang1() {
     	if($_GET['wareId']){
           $_order2ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
           $rowset = $this->_modelExample->findByField($this->_pkName, $_GET[$this->_pkName]);
           $row = $_order2ware->findAll(array('id'=>$_GET['wareId']));
           $rowset['Ware']=$row;
        }else{
            $rowset = $this->_modelExample->findByField($this->_pkName, $_GET[$this->_pkName]);
            $mWare  = & FLEA::getSingleton('Model_JiChu_Ware');
            $m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
            //dump($rowset);
            if (count($rowset[Ware])>0) foreach($rowset[Ware] as & $v) {
                $v[cntGang] = $m->findCount(array(order2wareId=>$v[id]));
                $v[Ware] = $mWare->find(array('id'=>$v['wareId']));
            }
        }
		// dump($rowset);die();
		$smarty = & $this->_getView();
		$smarty->assign('pk_name', $this->_pkName);
		$smarty->assign('arr_field_value',$rowset);
		//dump($rowset);
		$smarty->display('Plan/DyeMakeGang1.tpl');
	}

	function actionMakeGang2() {
		$mWare  = & FLEA::getSingleton('Model_JiChu_Ware');
		$mOrdWare = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$rowset = $this->_modelExample->findByField($this->_pkName, $_POST[$this->_pkName]);
		$arrGangCount = $_POST["gangCount"];

		$arrFieldValueWare = array();
		$arrOrd2ware = array();
		$zongjiCnt = 0;
		for ($i=0;$i<count($_POST['ord2WareId']);$i++) {
			if ($_POST['gangCount'][$i]==0) continue;
			$row = $mOrdWare->find(array('id'=>$_POST['ord2WareId'][$i]));
			//取得这个客户 这个纱支 最近一次的排缸折率
			$clientId = $row['Order']['clientId'];
			$sql= "SELECT x.zhelv
				FROM plan_dye_gang x 
				LEFT JOIN trade_dye_order2ware y on x.order2wareId = y.id
				LEFT JOIN trade_dye_order o on o.id = y.orderId
				WHERE 1 and o.clientId ={$clientId} and y.wareId = {$row[Ware]['id']} 
				ORDER BY x.id desc LIMIT 0,1";
			$a = $this->_modelExample->findBySql($sql);
			$row['zhelv'] = $a[0]['zhelv'];	
			// dump($row);exit;
			$arrOrd2ware[$row['id']] = array(
				'id'=>$row['id'],
				'color'=>$row['color'],
				'wareName'=>$row['Ware']['wareName'],
				'guige'=>$row['Ware']['guige'],
				'cntKg'=>$row['cntKg']
			);
			$zongjiCnt+=$row['cntKg'];
			$row['cntPlanTouliao'] = $row[cntKg] / $_POST['gangCount'][$i];
			$row['sunJz'] = round($row['zhelv']*$row['cntPlanTouliao'],3);	
			for ($j=0;$j<$_POST['gangCount'][$i];$j++) {
				$arrFieldValueWare[] = $row;
			}
		}
		// dump($arrOrd2ware);exit;
		//得到已排缸列表
		//dump($_POST);exit;
		$str = "select * from view_dye_gang where orderId = {$_POST['id']}";
		//echo $str;
		$r = $mWare->findBySql($str);
		foreach ($r as &$va) {
			$va['sunJz'] = round($va['cntPlanTouliao'] * $va['zhelv'],2);
		}
		$r[] = $this->getHeji($r,array('cntKg','cntPlanTouliao','cntPlanTouliaoJ','cntPlanTouliaoW','planTongzi','sunJz'),'vatNum');

		$smarty = & $this->_getView();
		$smarty->assign('pk_name', $this->_pkName);
		$smarty->assign('arr_field_value',$rowset);
		// dump($arrFieldValueWare);exit;
		$smarty->assign('arr_field_value_ware',$arrFieldValueWare);
        $smarty->assign('page',$_GET['page']);
		$smarty->assign('arr_gang',$r);
		$smarty->assign('gang_total', $j);
		//dump($arrOrd2ware);exit;
		$smarty->assign('arrOrd2ware', $arrOrd2ware);
		$smarty->assign('zongjiCnt', $zongjiCnt);
		//得到每个颜色的合计
		//dump($arrFieldValueWare);exit;

		//取得系统设置中的排缸习惯,
		$mS = & FLEA::getSingleton("Model_Sys_Set");
		$xg = $mS->find(array('setName'=>'PaigangXiguan'));
		//dump($xg);exit;
		if($xg['setValue']==1) {//由定重计算出筒子数
			$smarty->display('Plan/DyeMakeGang2_1.tpl');;
		}
		else {//由筒子数计算出定重
			$smarty->display('Plan/DyeMakeGang2.tpl');
		}
	}

	function actionSavePlan() {
		//dump($_POST);exit;
		$modelpdg = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$_POST['gangTotal'] = count($_POST['cntJ']);
		$arrNew = array();
		//dump($_POST);exit;
		$arrGangNum = $this->getNewGangNum($_POST['gangTotal']);
		for ($i=0; $i<count($_POST['cntJ']); $i++) {
		   $arrNew[$i]['pihao'] = $_POST['pihao'][$i];
		   $arrNew[$i]['cntJ'] = $_POST['cntJ'][$i];
		   $arrNew[$i]['cntW'] = $_POST['cntW'][$i];
		   $arrNew[$i]['cntPlanTouliao'] = $_POST['cntJ'][$i]+$_POST['cntW'][$i];
		   $arrNew[$i]['zhelv'] = $_POST['zhelv'][$i];
		   $arrNew[$i]['vatId'] = $_POST['vatId'][$i];
		   $arrNew[$i]['vat2shuirongId'] = $_POST['vat2shuirongId'][$i];
		   $arrNew[$i]['planTongzi'] = $_POST['planTongzi'][$i];
		   $arrNew[$i]['unitKg'] = $_POST['unitKg'][$i];
		   //$arrNew[$i]['unitKg'] = $_POST['cntPlanTouliao'][$i]/$_POST['planTongzi'][$i];
		   $arrNew[$i]['order2wareId'] = $_POST["order2wareId"][$i];
		   $arrNew[$i]['vatNum'] = $arrGangNum[$i];
		   $arrNew[$i]['planDate'] = date("Y-m-d");
		}
		/*$lastGangNum = $arrGangNum[count($arrGangNum)-1];
		$sql = "update other_newcode set code = '{$lastGangNum}' where type = 1";
		mysql_query($sql) or die(mysql_error());*/
		$arrPkvs = $modelpdg->createRowset($arrNew);
		/*foreach($arrNew as & $arrAdd) {
			$modelpdg->save($arrAdd);
		}*/

		$rowset = $this->_modelExample->findByField($this->_pkName, $_POST[$this->_pkName]);
		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');

		$rowOrder2Ware = $modelOrder2Ware->findAllByField("orderId", $_POST[$this->_pkName]);

		$smarty = & $this->_getView();
		$smarty->assign('pk_name', $this->_pkName);
                $smarty->assign('page', $_POST['page']);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_pdg', $rowOrder2Ware);

		$printUrl = $this->_url('printNewGang',array(
			'pkvs'=>join('|',$arrPkvs)
		));
		$smarty->assign('print_url', $printUrl);
		$smarty->display('Plan/DyeMakeGang3.tpl');
	}

	#计划完成后，列出新增的缸等待打印
	function actionPrintNewGang() {
		/*$arrPkv = explode('|',$_GET['pkvs']);
		$arrGang = $this->_modelPlan->findAllByPkvs($arrPkv);
		//dump($arrGang);exit;
		echo "<b>计划已排完，发现如下新产生的缸，请打印！</b>";
		foreach($arrGang as & $v) {
			echo "<li>{$v['vatNum']} [ <a href='".$this->_url('PrintVatCard',array(
				'id'=>$v['id']
			))."' target='_blank'>打印</a> ]</li>";
		}
		echo "<p><input type='button' value=' 关 闭 ' onclick='if(window.opener) window.close();else window.location.href=\"".url('Trade_Dye_Order','right')."\"'></p>";*/
                $arrPkv = explode('|',$_GET['pkvs']);
		$arrGang = $this->_modelPlan->findAllByPkvs($arrPkv);
                //dump($arrGang);exit;
       	foreach($arrGang as & $v) {
       		//by zcc 重新定向一个到新的流转卡打印界面 2017年11月2日 13:06:19 原方法为PrintVatCard
			$v['print']="<a href='".$this->_url('PrintCard2',array(
				'id'=>$v['id']
			))."' target='_blank'>打印流转卡</a>";
			$v['print'] .= "&nbsp;&nbsp;<a href='".$this->_url('PrintPaiGang',array(
				'id'=>$v['id']
			))."' target='_blank'>排缸卡</a>";
            $arr=$this->_modelExample->find(array('id'=>$v['OrdWare']['orderId']));
            $ware= $this->_modelWare->find(array('id'=>$v['OrdWare']['wareId']));
            $v['compName']=$arr['Client']['compName'];
            $v['guige']=$ware['guige'];
            $v['orderCode']=$arr['orderCode'];
		}
                $smarty = & $this->_getView();
		$smarty->assign('title', '新增缸打印');
                $smarty->assign('page',$_GET['page']);
		$smarty->assign('arr_field_value',$arrGang);
		$smarty->display('Plan/PrintNewGang.tpl');
	}
	function actionPrintPlan() {
		if($_POST[$this->_pkName]) $pkName = $_POST[$this->_pkName];
		if($_GET[$this->_pkName]) $pkName = $_GET[$this->_pkName];

		$rowset = $this->_modelExample->findByField($this->_pkName, $pkName);

		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$rowOrder2Ware = $modelOrder2Ware->findAllByField("orderId", $pkName);

		$i = 0;
		$cntKgTotal = 0;
		$touliaoTotal = 0;

		foreach($rowOrder2Ware as & $value) {
			$value[wareName] = $value[Ware][wareName].' '.$value[Ware][guige];
			$cntKgTotal += $value[cntKg];
			if ($value[Pdg]) {
				foreach($value[Pdg] as & $item) {
					$touliaoTotal += $item[cntPlanTouliao];
				}
			}
			$i++;
		}

		$rowOrder2Ware[i][id] = "<strong>合计</strong>";
		$rowOrder2Ware[i][cntKg] = "<strong>".$cntKgTotal."</strong>";
		$rowOrder2Ware[i][Pdg][0][cntPlanTouliao] = "<strong>".$touliaoTotal."</strong>";

		//dump($rowset);
		$smarty = & $this->_getView();
		$smarty->assign('pk_name', $this->_pkName);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_pdg', $rowOrder2Ware);
		$smarty->assign('cntkg_total', $cntKgTotal);
		$smarty->assign('touliao_total', $touliaoTotal);
		$smarty->display('Plan/DyePrint.tpl');
	}

	function actionGetJsonByVatNum() {
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$modelVat = FLEA::getSingleton('Model_JiChu_Vat');
		$rowVat = $modelVat->findByField('id', $_GET[vatId]);
		$vatCode = substr($rowVat[vatCode],0,2)+100;

		$temp = date("ymd").substr($vatCode,1);
		$arr = $model->find("vatNum like '%$temp%'", 'id desc', 'vatNum');
		$value = $temp.substr((substr($arr[vatNum],-2)+101), 1);
		echo json_encode($value);
	}

	//获得新的逻辑缸号
	//按吴工的要求进行修改格式为 ymd(订单序号)(缸次)
	//同一个订单下可能会有很多缸，$cntVat代表总的缸数
	//返回一个数组,数组的前8位都一样，后面2位递增
	//20080223修改规则为ymd(3位序号)
	function getNewGangNum($cntVat) {
		return $this->_modelPlan->getNewGangNum($cntVat);
	}

	//打印生产流转卡
	function actionPrintVatCard() {
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mGang->addTimesPrint($_GET['id']);
		$ip = $_SERVER['REMOTE_ADDR'];
		$mPrint = & FLEA::getSingleton('Model_JiChu_Print');
		$print = $mPrint->find(array('ip'=>$ip));
		//dump($print);
		$tplName=FLEA::getAppInf('LiuzhuankaMoBan');
                //echo $tplName;exit;
		$arr = $this->_modelPlan->find($_GET[id]);
		$arr['jingzhong'] = round($arr['cntPlanTouliao']*$arr['zhelv'],2);
		$_model = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$_model->disableLink('Ware');
		$arr[Order] = $_model->find($arr[OrdWare][orderId]);

		//根据id取得产品大类名称
		$mSaleKind =& FLEA::getSingleton('Model_JiChu_SaleKind');
		$rowSK = $mSaleKind->find($arr['Order']['saleKind']);
		if (count($rowSK)>0) $kindName = $rowSK['kindName'];
		else $kindName = '';

		$_modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$arr[Ware] = $_modelWare->find($arr[OrdWare][wareId]);
		$arr[Ware][guige] =$_modelWare->formatGuige($arr[Ware][guige]);
		$arr[Ware][mnemocode] =$_modelWare->formatGuige($arr[Ware][mnemocode]);

		$arr['pinggui']=$arr['Ware']['wareName']?$arr['Ware']['wareName'].','.$arr['Ware']['guige']:$arr['Ware']['guige'];
		$arr['length']=strlen($arr['pinggui']);
                //dump($arr);
		$smarty = & $this->_getView();
		$smarty->assign('row',$arr);
		$smarty->assign('print',$print);
		$smarty->assign('top',$print['offsetTop']);
		$smarty->assign('left',$print['offsetLeft']);
		$smarty->assign('lineHeight', $print['rowHeight']);
		$smarty->assign('kind_name', $kindName);
		$smarty->display('Plan/'.$tplName);
	}
	//保存打印设置
	function actionSavePrint(){
		$mPrint = & FLEA::getSingleton('Model_JiChu_Print');
		$arr = $mPrint->find(array('ip'=>$_SERVER['REMOTE_ADDR']));
		if ($arr) $_POST['id'] = $arr['id'];
		else $_POST['ip'] = $_SERVER['REMOTE_ADDR'];
		//dump($_POST);exit;
		$mPrint->save($_POST);
		redirect($this->_url('PrintVatCard',array('id'=>$_POST['dyeId'])));
	}

	/*********************by wuyou 2015-05-22***************************/
	//流转卡打印
	function actionPrintCard(){
		// dump($_GET);
        $sql="select 
        x.cntPlanTouliao,x.planTongzi,x.vatNum,x.planDate as printDate,x.unitKg,
        y.color,y.colorNum,y.chandi,
        z.guige,z.wareName,
        c.compName,
        m.huidao, m.honggan,m.orderCode,
        v.vatCode
        from plan_dye_gang x 
        left join trade_dye_order2ware y on x.order2wareId=y.id
        left join jichu_ware z on y.wareId=z.id
        left join trade_dye_order m on y.orderId=m.id
        left join jichu_vat v on v.id=x.vatId 
        left join jichu_client c on c.id=m.clientId
        where x.id='{$_GET['id']}'";
        $arr=$this->_modelExample->findBySql($sql);
        // dump($arr);
        $arr[0]['guige']=$arr[0]['wareName'].' ' .$arr[0]['guige']; //拼接纱支成分
       
 
        $sysPrint = & FLEA::getSingleton('Model_SysPrint');
        $print = $sysPrint->find(array('name'=>'offsetXY'));
        $parr=$sysPrint->findAll(array('isPrint'=>1));
        // dump($parr);exit;
        if(!$parr[0]){
           js_alert('请先设置打印值','',$this->_url('ShowPrintEdit'));
        }
        $rowset=$arr[0];
		foreach ($parr as & $v) {
			$v['Printname']=$rowset[$v['name']];  //通过key获取值
			$v['left']=$v['left']==''?0:$v['left'];
			$v['top']=$v['top']==''?0:$v['top'];
			// $lrprint[$v['name']]['id']=$v['id'];
    		// $lrprint[$v['name']]['cntTop']=$v['top'];
    		// $lrprint[$v['name']]['cntLeft']=$v['left'];
		}
        //dump($parr);exit;
        $smarty=$this->_getView();
        $smarty -> assign('aRow',$parr);
        $smarty -> assign('top',$print['top']);
		$smarty -> assign('left',$print['left']);
		//$smarty-> assign('xyIndex',$lrprint);
		//$smarty->assign('lineHeight', $print['rowHeight']);		
        $smarty -> display('Plan/PrintCard.tpl');
	}
	/**
	 * ps 新流转卡打印
	 * Time：2017-09-30 13:42:25
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionPrintCard2(){
		$sql="select 
        x.cntPlanTouliao,x.planTongzi,x.vatNum,x.planDate as printDate,x.unitKg,x.zhelv,
        y.color,y.colorNum,y.chandi,y.ganghaoKf,y.kuanhao,y.wareNameBc,y.isJiaji as jiaji,
        z.guige,z.wareName,
        c.compName,
        m.huidao, m.honggan,m.orderCode,m.dateJiaohuo,m.memo as yaoqiu,
        m.packing_zhiguan,m.packing_suliao,m.packing_out,m.qita_memo,
        v.vatCode,v2.cengCnt,y.pihao,m.packing_memo,y.memo as order2memo
        from plan_dye_gang x 
        left join trade_dye_order2ware y on x.order2wareId=y.id
        left join jichu_ware z on y.wareId=z.id
        left join trade_dye_order m on y.orderId=m.id
        left join jichu_vat v on v.id=x.vatId 
        left join jichu_client c on c.id=m.clientId
        left join jichu_vat2shuirong v2 on v2.id = x.vat2shuirongId
        where x.id='{$_GET['id']}'";
        $arr=$this->_modelExample->findBySql($sql);
        foreach ($arr as &$v) {
        	$v['sunJkg'] = $v['cntPlanTouliao']*$v['zhelv'];
        	if ($v['wareNameBc']) {
        		$v['guigeNew'] = $v['wareNameBc'].'<br>'.'('.$v['wareName'].' '.$v['guige'].')';
        	}else{
        		$v['guigeNew'] = $v['wareName'].' '.$v['guige'];
        	}
        	$v['isJiaji'] = $v['jiaji']=='1'?'是':'否';
        }
        $mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mGang->addTimesPrint($_GET['id']);//数据库 中流转卡打印次数+1
		$smarty=$this->_getView();
		$smarty -> assign('aRow',$arr[0]);
		$smarty -> display('Plan/PrintCardNew.tpl');
	}
    
    function actionShowPrintEdit(){
    	$sysPrint = & FLEA::getSingleton('Model_SysPrint');
    	$rowset=$sysPrint->findAll();
        //$sql="select * from jichu_print where ip='{$_SERVER['REMOTE_ADDR']}'";
        $py=$sysPrint->find(array('name'=>'offsetXY'));
        //$py=$this->_modelExample->findBySql($sql);
        
     
    	foreach ($rowset as & $v) {
    		$arr[$v['name']]['id']=$v['id'];
    		$arr[$v['name']]['cntTop']=$v['top'];
    		$arr[$v['name']]['cntLeft']=$v['left'];
    		$arr[$v['name']]['isPrint']=$v['isPrint'];
            
    	}
        $arr['py']=$py;
    	$smarty=$this->_getView();
    	$smarty->assign('row',$arr);
    	$smarty->display('Plan/PrintCardEdit.tpl');
    }
    //保存打印设置
    function actionSavePrint2(){
    	// dump($_POST);exit;
    	// array(
    	// 	'printDate'=>记录1,
    	// 	'vatNum'=>记录2
    	// )
    	$rowset = array();
    	foreach($_POST['setName'] as $k=>&$v) {
    		$rowset[$v] = array(
    			'id'=>$_POST['id'][$k],
    			'name'=>$v,
    			'top'=>$_POST['cntTop'][$k],
    			'left'=>$_POST['cntLeft'][$k],
    			'isPrint'=>0    			
    		);
    	}
    	foreach($_POST['isPrint'] as & $v) {
    		$rowset[$v]['isPrint'] = 1;
    	}
    	$sysPrint = & FLEA::getSingleton('Model_SysPrint');
    	$sysPrint->saveRowset($rowset);
    	js_alert('保存成功','',url('Trade_Dye_Order','PlanManage'));
    	
    }
  
	/*********************by wuyou 2015-05-22***************************/

	//安排松筒计划
	function actionListForSt() {
		$this->_modelPlan->enableLink('Car');
		$pager=null;
		if ($_POST[key]!='') $condition = array(
			vatNum=>$_POST[key]
		);
		$rowset=$this->_modelPlan->findAllGang($condition,$pager);
		//dump($rowset[0]);
		if(count($rowset)>0) foreach($rowset as & $v) {
			//状态
			if($v[Car]) {
				//if已经安排计划现实 修改 | 取消
				$v[_edit] = "<a href='".$this->_url('SetStCar',array(
					id => $v[id]
				))."'>修改</a> | <a href='".$this->_url('CancelStCar',array(
					id => $v[id]
				))."'>取消</a>";
				$v[statu] = join(',',array_col_values($v[Car],'carCode'));
			} else {
				//if 没有安排过
				$v[_edit] = "<a href='".$this->_url('SetStCar',array(
					id => $v[id]
				))."'>分配车台</a>";
				$v[statu]="未安排";
			}
		}
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			"vatNum" =>"缸号",
			"clientName" => "客户",
			"guige" => "纱织规格",
			"color" =>"颜色",
			"cntPlanTouliao" =>"计划投料",
			"unitKg" =>"定重",
			"dateJiaohuo" => "交期",
			"statu"=>"计划情况",//显示在做车台，并用颜色表示完成情况
			"_edit" => '操作'
		));

		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('ListForSt')));
		$smarty->display('TableList.tpl');
	}

	//为某缸安排松筒车台
	function actionSetStCar() {
		$this->_modelPlan->enableLink('Car');
		$arr = $this->_modelPlan->findByField('id',$_GET[id]);
		//dump($arr);
		$smarty=$this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Plan/StPlanEdit.tpl');
	}

	//保存某缸松筒车台计划
	function actionSaveStCar() {
		//dump($_POST);exit;
		$this->_modelPlan->enableLink('Car');
		$this->_modelPlan->save($_POST);
		js_alert('分配成功','window.history.go(-2)');
	}

	//取消某缸松筒车台计划
	function actionCancelStCar() {
		$this->_modelPlan->enableLink('Car');
		$arr = array(
			id=>$_GET[id],
			Car=>array()
		);
		$this->_modelPlan->save($arr);
		js_alert('成功取消','window.history.go(-1)');
	}

	//排缸表
	//显示每个物理缸上安排有多少缸的计划，
	//消失的标志是有染色产量出现
	//如果出现回修等要求，需要重新进入排缸计划中，这里有两个方案供选择：
	//1,产生新的缸号，
	//2,在plan_dye_gang中增加一个标志字段，
	//首选第一个方案，因为第二个方案会产生很多附加的维护代码。
	function actionPaigangSchedule() {
		FLEA::loadClass('TMIS_Pager');
		$arrGet=TMIS_Pager::getParamArray(array(
			'clientId'=>''	
		));
		$modelVat = & FLEA::getSingleton('Model_JiChu_Vat');
		//$rowVat = $modelVat->findAll(null,"replace(vatCode,'#','')+0",null, 'id,vatCode',false);
		$rowVat = $modelVat->findAll(null,"orderLine asc",null, 'id,vatCode',false);
		//dump($rowVat);exit;
		$countVat = count($rowVat);
		//60天未完成的缸取消
		$dateFrom = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-120,date('Y')));

		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');	//trade_dye_order2ware
		$modelVat = & FLEA::getSingleton('Model_JiChu_Vat');
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$modelClient = & FLEA::getSingleton('Model_JiChu_Client');
		$modelGongyi = & FLEA::getSingleton('Model_Gongyi_Dye_Chufang');

		//取得用户设置中的染色起始日期;
		$mSys = & FLEA::getSingleton('Model_Sys_Set');
		$row = $mSys->find(array('setName'=>'DyeStartDate'));
		$dateStart = $row ? $row['setValue'] : '0000-00-00';

		$totalCount = 0;
		$totalVat = 0;

		$i = 0;
		//dump($rowVat);exit();
		if ($countVat>0) foreach($rowVat as & $value) {
			$str = "select
				x.*,
				z.dateJiaohuo,
				z.orderCode,
				z.clientId,
				z.id as orderId,
				y.id as ord2wareId,
				y.color,
				y.colorNum,
				y.wareId,
				x.cntPlanTouliao as cnt1,
				x.id as planId,
				y.kuanhao
				from plan_dye_gang x
				left join trade_dye_order2ware y on x.order2wareId=y.id
				left join trade_dye_order z on y.orderId=z.id
				left join dye_rs_chanliang m on x.id=m.gangId
				where  x.planDate>'{$dateStart}' and x.planDate>'{$dateFrom}' and
				(m.id is null or (x.markTwice=1 and x.fensanOver<2))
				and x.vatId>0 and x.vatId='$value[id]'
				and (x.binggangId=0 or x.parentGangId>0) and (x.rsStart=0 or (x.taomianOver=0 and x.markTwice=1 and x.fensanOver<2))
			";
			if($arrGet['clientId']!='')$str.=" and z.clientId='{$arrGet['clientId']}'";
			$str .= " order by z.id";
			$rowPlan = $modelVat->findBySql($str);
           // dump($rowPlan);exit;
			#取得合并缸的内容
			$str="select x.*
				from plan_dye_gang_merge x
				left join plan_dye_gang y on x.id=y.binggangId
				left join dye_rs_chanliang z on y.id=z.gangId
				left join trade_dye_order2ware m on y.order2wareId=m.id
				left join trade_dye_order n on m.orderId=n.id
				where  y.planDate>'{$dateStart}' and y.planDate>'$dateFrom' and
				(z.id is null or (y.markTwice=1 and y.fensanOver<2))
				and y.vatId>0 and x.vatId='$value[id]'
				and y.binggangId>0 and x.isStartRs=0";
			if($arrGet['clientId']!='')$str.=" and n.clientId='{$arrGet['clientId']}'";
			$str.=" group by x.id";
			//dump($value);dump($str);
			$rr=$modelVat->findBySql($str);
			if(count($rr)>0)foreach($rr as & $v){
				$sql="select x.id,x.order2wareId,x.vatNum,x.cntPlanTouliao,x.planDate,
					y.color,y.colorNum,z.orderCode,z.dateJiaohuo,m.compName,x.dateAssign,x.dateAssign1,
					x.ranseBanci,x.ranseBanci1,x.fensanOver,x.markTwice,
					n.guige,y.kuanhao
					from plan_dye_gang x
					left join trade_dye_order2ware y on x.order2wareId=y.id
					left join trade_dye_order z on y.orderId=z.id
					left join jichu_client m on m.id=z.clientId
					left join jichu_ware n on n.id=y.wareId
					where x.binggangId='{$v['id']}'";				
				$rr1=$modelVat->findBySql($sql);
				$kk=array();
				$rr1=array_group_by($rr1,'binggangId');
				//$mm=array();
				if($rr1)foreach($rr1 as $key=>& $v1){
					$planId=$order2wareId=$compName=$orderCode=$vatNum=$guige=$color=$colorNum=$employName=$planDate=$cntPlanTouliao=$dateJiaohuo='';
					$cntTouliao=$cnt1=0;
					foreach($v1 as & $vv){
						//dump($vv);
						$planId.=$vv['id'].',';
						$order2wareId.=$vv['order2wareId'].',';
						$orderCode.=$vv['orderCode'].'<br>';
						$compName.=$vv['compName'].'<br>';
						if ($vv['markTwice']==1) {
							//dump(1);exit();
							if($vv['fensanOver']==0) {
								//dump(2);exit();
								if($vv['dateAssign']==$vv['dateAssign1'] && $vv['ranseBanci']==$vv['ranseBanci1']) $vv['vatNum'] .= "分散+套棉";
								else $vv['vatNum'] .= "分散";
								//dump($vv['vatNum']);exit();
							}
							elseif($vv['fensanOver']==1) {
								$vv['vatNum'] .= "套棉";
							}
						}else{
							if ($vv['dateAssign'] !='0000-00-00'){
								$vv['bgColor']='lightgreen';
								if($vv['ranseBanci']==1){
									$vv['ranseBanci']='早班';
								}
								elseif ($vv['ranseBanci']==2) {
									$vv['ranseBanci'] = '晚班';
								}elseif ($vv['ranseBanci']==3) {
									$vv['ranseBanci'] = '早班1';
								}elseif ($vv['ranseBanci']==4) {
									$vv['ranseBanci'] = '早班2';
								}elseif ($vv['ranseBanci']==5) {
									$vv['ranseBanci'] = '早班3';
								}elseif ($vv['ranseBanci']==6) {
									$vv['ranseBanci'] = '晚班1';
								}elseif ($vv['ranseBanci']==7) {
									$vv['ranseBanci'] = '晚班2';
								}elseif ($vv['ranseBanci']==8) {
									$vv['ranseBanci'] = '晚班3';
								}
							} else {
								$vv['dateAssign'] ='';
								$vv['ranseBanci']='';
							}
						}
						//dump($vv['vatNum']);exit();
						$vatNum.=$vv['vatNum'].'<br>';
						$guige.=$vv['guige'].'<br>';
						$color.=$vv['color'].'<br>';
						$colorNum.=$vv['colorNum'].'<br>';
						$employName.=$vv['employName'].'<br>';
						$planDate.=$vv['planDate'].'<br>';
						$cntPlanTouliao.=$vv['cntPlanTouliao'].'<br>';
						$cntTouliao+=$vv['cntPlanTouliao'];
						$dateJiaohuo.=$vv['dateJiaohuo'].'<br>';
						$kuanhao.=$vv['kuanhao'].'<br>';
						$cnt1+=$vv['cntPlanTouliao'];
					}
					//dump($guige);
					$mm=array(
						'planId'=>$planId,
						'order2wareId'=>$order2wareId,
						'clientName'=>$compName,
						'orderCode'=>$orderCode,
						'vatNum'=>$vatNum,
						'guige'=>$guige,
						'color'=>$color,
						'colorNum'=>$colorNum,
						'employName'=>$employName,
						'cntPlanTouliao'=>$cntPlanTouliao,
						'cnt1'=>$cnt1,
						'planDate'=>$planDate,
						'dateJiaohuo'=>$dateJiaohuo,
						'dateAssign'=>$v['dateAssign'],
						'ranseBanci'=>$v['ranseBanci'],
						'key'=>$v1[0]['order2wareId'],
						'planarr'=>$planId,
						'kuanhao'=>$kuanhao
						
					);
					//$kk[]=$mm;
					//dump($mm);exit();
					$rowPlan[]=$mm;
				}

			}
			//exit();
			
			//dump($kk);
			$curClient=$curOrderCode='';
			$tTouliao =$tcnt= 0;
			$planDye=array();
			$order2ware=array();
			//dump($rowPlan);exit();
			if(count($rowPlan)>0) foreach($rowPlan as & $v) {
				$planDye=explode(',',$v['planId']);
				$order2ware=explode(',',$v['order2wareId']);
				//dump($v);
				$cp=count($planDye);
				//dump($plan);
				if ($v['planarr']=='') {
					if($cp>1){
						$num='';
						for($j=0;$j<$cp;$j++){
							$arrNum1=$modelGang->setVatNum($planDye[$j],$order2ware[$j]);
							$num.=$arrNum1.($j!=($cp-1)?'<br>':'');
						}
						$v['vatNum']=$num;
					}else{
						$arrNum=$modelGang->setVatNum($planDye[0],$order2ware[0]);
						$v['vatNum']=$arrNum;
					}
				}
				//dump($v);exit;
				if($v['markTwice']==1) {//处理双染的情况;
					if($v['fensanOver']==0) {//第一道工序分散未做
						//如果分散套棉安排在同一班做显示分散+套棉
						if($v['dateAssign']==$v['dateAssign1'] && $v['ranseBanci']==$v['ranseBanci1']) $v['vatNum'] .= "分散+套棉";
						else $v['vatNum'] .= "分散";
						if($v['ranseBanci']==1){
							$v['ranseBanci']='早班';
						}
						elseif ($v['ranseBanci']==2) {
							$v['ranseBanci'] = '晚班';
						}elseif ($v['ranseBanci']==3) {
							$v['ranseBanci'] = '早班1';
						}elseif ($v['ranseBanci']==4) {
							$v['ranseBanci'] = '早班2';
						}elseif ($v['ranseBanci']==5) {
							$v['ranseBanci'] = '早班3';
						}elseif ($v['ranseBanci']==6) {
							$v['ranseBanci'] = '晚班1';
						}elseif ($v['ranseBanci']==7) {
							$v['ranseBanci'] = '晚班2';
						}elseif ($v['ranseBanci']==8) {
							$v['ranseBanci'] = '晚班3';
						}
						if ($v['dateAssign'] !='0000-00-00') $v['bgColor']='lightgreen';
						else {
							$v['dateAssign'] ='';
							$v['ranseBanci']='';
						}
					} elseif($v['fensanOver']==1) {//第一道工序已做
						$v['vatNum'] .= "套棉";
						if($v['ranseBanci1']==1){
							$v['ranseBanci']='早班';
						}
						elseif ($v['ranseBanci']==2) {
							$v['ranseBanci'] = '晚班';
						}elseif ($v['ranseBanci']==3) {
							$v['ranseBanci'] = '早班1';
						}elseif ($v['ranseBanci']==4) {
							$v['ranseBanci'] = '早班2';
						}elseif ($v['ranseBanci']==5) {
							$v['ranseBanci'] = '早班3';
						}elseif ($v['ranseBanci']==6) {
							$v['ranseBanci'] = '晚班1';
						}elseif ($v['ranseBanci']==7) {
							$v['ranseBanci'] = '晚班2';
						}elseif ($v['ranseBanci']==8) {
							$v['ranseBanci'] = '晚班3';
						}
						if ($v['dateAssign1'] !='0000-00-00') {
							$v['bgColor']='lightgreen';
							$v['dateAssign'] =$v['dateAssign1'];
						} else {
							$v['dateAssign'] ='';
							$v['ranseBanci']='';
						}
					}
				} else {//处理普通情况
					if ($v['dateAssign'] !='0000-00-00'){
						$v['bgColor']='lightgreen';
						if($v['ranseBanci']==1){
							$v['ranseBanci']='早班';
						}
						elseif ($v['ranseBanci']==2) {
							$v['ranseBanci'] = '晚班';
						}elseif ($v['ranseBanci']==3) {
							$v['ranseBanci'] = '早班1';
						}elseif ($v['ranseBanci']==4) {
							$v['ranseBanci'] = '早班2';
						}elseif ($v['ranseBanci']==5) {
							$v['ranseBanci'] = '早班3';
						}elseif ($v['ranseBanci']==6) {
							$v['ranseBanci'] = '晚班1';
						}elseif ($v['ranseBanci']==7) {
							$v['ranseBanci'] = '晚班2';
						}elseif ($v['ranseBanci']==8) {
							$v['ranseBanci'] = '晚班3';
						}
					} else {
						$v['dateAssign'] ='';
						$v['ranseBanci']='';
					}
				}
				$client = $modelClient->find($v[clientId]);
				$v[clientName] =$v['clientName']==''? $client[compName]:$v['clientName'];
				$ware = $modelWare->find($v[wareId]);
				$v[guige] =$v['guige']==''?$ware[wareName] . " " .$ware[guige]:$v['guige'];
				$v['orderCode']=$this->_modelExample->getOrderTrack($v[orderId],$v[orderCode]);
				//松筒产量
				// $stChanliang = $modelGang->getStChanliang($v[id]);
				// if($stChanliang[cntKg]>0) $v[stChanliang] = $stChanliang[cntKg]."kg($stChanliang[cntTongzi]个)";
				//dump($v[ord2wareId]);
				$gongyi = $modelGongyi->findByField('order2wareId',$v[ord2wareId]);
				if ($gongyi=="") {
					$gongyi = $modelGongyi->findByField('order2wareId',$v[key]);
				}
				//dump($gongyi);exit();
				$v['ranseKind']=$gongyi['ranseKind'];
				$v['employName']=$gongyi['Chufangren']['employName'];

				//控制重复显示的问题
				if ($curClient==$v[clientName]) $v[clientName]='';
				else $curClient=$v[clientName];
				if ($curOrderCode==$v[orderCode]) $v[orderCode]='';
				else $curOrderCode=$v[orderCode];
				$tTouliao+=$v[cntPlanTouliao];
				$tcnt+=$v[cnt1];
				//计算缸数
				$totalVat++;
			}
			////增加合计
			$count = count($rowPlan);
			//dump($rowPlan);exit();
			$rowPlan[$count]['clientName']='<strong>合计</strong>';
			$rowPlan[$count]['cntPlanTouliao']='<strong>'.($tcnt).'</strong>';

			$vatCode[$i] = $value['vatCode'];
			$schedule[$i] = $rowPlan;

			$totalCount += $tTouliao;

			$i++;
		}
		//exit();
		if(count($schedule)>0)foreach($schedule as & $v){
			$c=count($v)-1;
			$k=0;
			foreach($v as $key=>& $vv){
				#判断是否有松筒产量
				$str="select count(*) as cnt from dye_st_chanliang where gangId='{$vv['id']}'";
				$re=mysql_fetch_assoc(mysql_query($str));
				$vv['songtong']=$re['cnt']>0?'√':'';
				//dump($order);
				if($vv['ranseBanci']!=''){
					$k++;
				}
			}
			$v[$c]['cntPlanTouliao']='共'.$c.'记录，已排班'.$k.',未排班'.($c-$k);
		}
		//die("计算完成");
		//dump($vatCode);	dump($schedule); exit;
		
		$arrFieldInfo = array(
			'clientName' =>'客户',
			'orderCode' =>'合同编号',
			'vatNum' =>'缸号',
			'guige' =>'规格',
			'color' =>'颜色',
			'colorNum'=>'色号',
			'cntPlanTouliao' =>'计划投料',
			'planDate' =>'排缸日期',
			'dateJiaohuo' =>'交期',
			'kuanhao'=>'款号',
			'ranseKind'=>'染色类别',
			//'stChanliang'=>'松筒产量',
			'dateAssign'=>'染色计划时间',
			'ranseBanci'=>'染色班次',
			'employName'=>'打样人',
			'songtong'=>'松筒',
			//'gongyiStatu'=>'工艺单'
			//'rsChanliang' => '染色产量'
		);
		$arr_edit_info=array(
			'取消',
		);
		//echo "计算完成";exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','计划单查询');
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('supplier_name', '客户');
		$smarty->assign('count', $countVat);
		$smarty->assign('arr_edit_info', $arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('vat_code', $vatCode);
		$smarty->assign('total_count', $totalCount);
		$smarty->assign('total_vat', $totalVat);
		$smarty->assign('arr_field_value', $schedule);
		//dump($schedule);//exit;
        //dump($this->makeArrayJsCss(array('grid')));
		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('pk', $this->_pkName);
		$smarty->display('Plan/PaigangSchedule.tpl');
	}
	#并缸
	function actionBinggang(){
		$smarty=& $this->_getView();

		$smarty->display('Plan/Binggang.tpl');
	}
	function actionSaveBinggang(){
		//$_POST['isJihua']=explode(',', $_POST['planid']);
		$mGangmerge = & FLEA::getSingleton('Model_Plan_Dye_Gangmerge');
		$arr=array(
			'vatId'=>$_POST['vatId'],
			'ranseBanci'=>$_POST['ranseBanci'],
			'dateAssign'=>$_POST['dateAssign'],
			'isJiaji'=>$_POST['isJiaji']+0
		);
		$id=$mGangmerge->save($arr);
		foreach($_POST['gangId'] as & $v){
			$rr=array(
				'id'=>$v,
				'binggangId'=>$id,
				'ranseBanci'=>$_POST['ranseBanci'],
				'dateAssign'=>$_POST['dateAssign'],
			);
			$this->_modelPlan->save($rr);
		}

		$found = false;
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
			if($_POST['gangId'] )foreach($_POST['gangId']  as $key=>$v){
				$gang = $this->_modelPlan->find(array('id'=>$v));
				//dump($gang);
				//判断是否存在化纤并且未设置双染工艺
				if ($gang['markTwice']==0 && $mWare->isHuaxian($gang['OrdWare']['wareId'])) {
					$found = true;
				}
				
			}
			//dump(1);
		 	 if ($found){
		 	 	//dump(2);
		 	 	js_alert('保存成功！请到染料排班登记进行双染！','',$this->_url('paigangSchedule'));
				exit;
			}

		js_alert('保存成功！','',$this->_url('paigangSchedule'));
	}
	#并缸查询
	function actionSearchBinggang(){
		FLEA::loadClass('TMIS_Pager');
		$arr=& TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d')
		));
		$str="select x.*,y.vatCode
			from plan_dye_gang_merge x
			left join jichu_vat y on y.id=x.vatId
			where 1
		";
		if($arr['dateFrom']!='')$str.=" and x.dateAssign>='{$arr['dateFrom']}'";
		if($arr['dateTo']!='')$str.=" and x.dateAssign<='{$arr['dateTo']}'";
		//echo $str;
		$pager=& new TMIS_Pager($str);
		$rowset=$pager->findAll();
		if(count($rowset)>0)foreach($rowset as & $v){
			//$v['ranseBanci']=$v['ranseBanci']==1?'早班':'晚班';
			if($v['ranseBanci']==1){
               $v['ranseBanci'] = '早班';
			}elseif ($v['ranseBanci']==2) {
			   $v['ranseBanci'] = '晚班';
			}elseif ($v['ranseBanci']==3) {
			   $v['ranseBanci'] = '早班1';
			}elseif ($v['ranseBanci']==4) {
			   $v['ranseBanci'] = '早班2';
			}elseif ($v['ranseBanci']==5) {
			   $v['ranseBanci'] = '早班3';
			}elseif ($v['ranseBanci']==6) {
			   $v['ranseBanci'] = '晚班1';
			}elseif ($v['ranseBanci']==7) {
			   $v['ranseBanci'] = '晚班2';
			}elseif ($v['ranseBanci']==8) {
			   $v['ranseBanci'] = '晚班3';
			}
			$str="select x.id,x.vatNum,x.cntPlanTouliao,x.planDate,y.id as order2wareId,
				y.color,z.orderCode,m.guige,n.compName 
				from plan_dye_gang x
				left join trade_dye_order2ware y on y.id=x.order2wareId 
				left join trade_dye_order z on z.id=y.orderId
				left join jichu_ware m on m.id=y.wareId
				left join jichu_client n on n.id=z.clientId

				where x.binggangId='{$v['id']}'
			";
			//echo $str;
			$rr=$this->_modelPlan->findBySql($str);
			//dump($rr);
			$gangId=$compName=$orderCode=$vatNum=$guige=$color=$planDate=$cntPlanTouliao='';
			if(count($rr)>0)foreach($rr as & $vv){
				$compName.=$vv['compName'].'<br>';
				$orderCode.=$vv['orderCode'].'<br>';
				//$vatNum.=$vv['vatNum'].'<br>';
				$vatNum.=$this->_modelPlan->setVatNum($vv['id'],$vv['order2wareId']).'<br>';
				$guige.=$vv['guige'].'<br>';
				$color.=$vv['color'].'<br>';
				$planDate.=$vv['planDate'].'<br>';
				$cntPlanTouliao.=$vv['cntPlanTouliao'].'<br>';
				$gangId.=$vv['id'].',';
			}
			$v['compName']=$compName;
			$v['orderCode']=$orderCode;
			$v['vatNum']=$vatNum;
			$v['guige']=$guige;
			$v['color']=$color;
			$v['planDate']=$planDate;
			$v['cntPlanTouliao']=$cntPlanTouliao;
			$v['_edit']="<a href='".$this->_url('EditBinggang',array('id'=>$v['id']))."'>修改</a>  ";
			$v['_edit'].="<a href='".$this->_url('CancelBinggang',array('gangId'=>$gangId,'id'=>$v['id']))."'>取消并缸</a>";
		}
		$arr_field_info=array(
			'compName'=>'客户',
			'orderCode'=>'合同',
			'dateAssign'=>'染色计划日期',
			'vatCode'=>'物理缸号',
			'vatNum'=>'缸号',
			'guige'=>'规格',
			'color'=>'颜色',
			'ranseBanci'=>'班次',
			'cntPlanTouliao'=>'计划投料',
			'planDate'=>'排缸日期',
			'_edit'=>'操作'
		);
		$smarty=& $this->_getView();
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList.tpl');
	}
	#修改并缸记录
	function actionEditBinggang(){
		//dump($_GET);exit;
		$mGangmerge = & FLEA::getSingleton('Model_Plan_Dye_Gangmerge');
		$row=$mGangmerge->find(array('id'=>$_GET['id']));
		//dump($row);exit;
		$smarty=& $this->_getView();
		$smarty->assign('aRow',$row);
		$smarty->display('Plan/BinggangEdit.tpl');
	}
	function actionBinggangSave(){
		//dump($_POST);exit;
		$mGangmerge = & FLEA::getSingleton('Model_Plan_Dye_Gangmerge');
		$str="update plan_dye_gang set
			dateAssign='{$_POST['dateAssign']}',
			ranseBanci='{$_POST['ranseBanci']}'
			where binggangId='{$_POST['id']}'
		";
		//echo $str;exit;
		mysql_query($str);
		$arr=array(
			'id'=>$_POST['id'],
			'vatId'=>$_POST['vatId'],
			'dateAssign'=>$_POST['dateAssign'],
			'ranseBanci'=>$_POST['ranseBanci'],
			'isJiaji'=>$_POST['isJiaji'],
		);
		$mGangmerge->save($arr);
		js_alert('保存成功!','',$this->_url('SearchBinggang'));
	}
	#取消并缸
	function actionCancelBinggang(){
		//dump($_GET);exit;
		$gangId=explode(',',$_GET['gangId']);
		//dump($gangId);exit;
		if(count($gangId)>0)foreach($gangId as & $v){
			if($v=='')continue;
			$arr=array(
				'id'=>$v,
				'binggangId'=>0,
				'dateAssign'=>'0000-00-00',
				'ranseBanci'=>1,
				'markTwice'=>0
			);
			$this->_modelPlan->save($arr);
		}
		$mGangmerge = & FLEA::getSingleton('Model_Plan_Dye_Gangmerge');
		$mGangmerge->removeByPkv($_GET['id']);
		redirect($this->_url('SearchBinggang'));
	}
	function actionPopup(){
		FLEA::loadClass('TMis_Pager');
		$dateFrom=date('Y-m-d',mktime(0,0,0,date('m'),date('d')-60,date('Y')));
		$dateTo=date('Y-m-d');
		//dump($dateFrom);
		$arr = TMis_Pager::getParamArray(array(
			'key'=>'',
		));
		$str = "select x.*,y.color,y.wareId,z.orderCode,
			m.compName,n.vatCode
			from plan_dye_gang x
			left join trade_dye_order2ware y on y.id=x.order2wareId 
			left join trade_dye_order z on z.id=y.orderId
			left join jichu_client m on m.id=z.clientId
			left join jichu_vat n on n.id=x.vatId
			left join dye_rs_chanliang a on x.id=a.gangId
			left join dye_hd_chanliang b on x.id=b.gangId
			where x.dateAssign='0000-00-00'
			and x.dateAssign1='0000-00-00'
			and x.vatId>0
			and x.binggangId=0
			and x.planDate>='{$dateFrom}'
			and x.planDate<='{$dateTo}'
			and a.id is null
			and b.id is null
		";
		if($arr['key']!='')$str.=" and( x.vatNum like '%{$arr['key']}%' or y.color like '%{$arr['key']}%')";
		$str.=" group by x.id";
		//echo $str;
		$pager = new TMIS_Pager($str);
		$rowset = $pager->findAll();
		//$orderId=0;
		$mWare = & FLEA::getSingleton('Model_Jichu_Ware');
		if(count($rowset)>0)foreach($rowset as & $v){
			//dump($v);
			$arrWare=$mWare->find(array('id'=>$v['wareId']));
			$v['guige']=$arrWare['guige'];
		}
		#在成品出库中客户显示编码
		$arrField = array(
			"vatNum" =>"缸号",
			'planDate'=>'排计划日期',
			"compName" =>"客户",
			"orderCode" =>"订单号",
			'guige'=>'纱支',
			'color'=>'颜色',
			'cntPlanTouliao'=>'计划投料数',
			//'zhishu'=>'支数',
			'vatCode'=>'染缸'
		);
		$smarty = & $this->_getView();
		$smarty->assign("arr_field_info",$arrField);
		$smarty->assign("arr_field_value",$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('grid','calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display("Popup/Common1.tpl");
		exit;
	}
	//未染色计划列表,有两种选择，以染色产量为准,
	function actionPaigangSchedule1() {
		FLEA::loadClass('TMIS_Pager');
		$arrGet=TMIS_Pager::getParamArray(array(
			'clientId'=>''	
		));
		$dateFrom = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-120,date('Y')));
		//echo $dateFrom;
		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');	//trade_dye_order2ware
		$modelVat = & FLEA::getSingleton('Model_JiChu_Vat');
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$modelClient = & FLEA::getSingleton('Model_JiChu_Client');
		$modelGongyi = & FLEA::getSingleton('Model_Gongyi_Dye_Chufang');

		//取得用户设置中的染色起始日期;
		$mSys = & FLEA::getSingleton('Model_Sys_Set');
		$row = $mSys->find(array('setName'=>'DyeStartDate'));
		$dateStart = $row ? $row['setValue'] : '0000-00-00';
		
		//2013-6-18 update by 珈蓝厂长，直接在这里排计划
		$str = "select
			x.*,
			z.dateJiaohuo,
			z.orderCode,
			z.clientId,
			z.id as orderId,
			y.id as ord2wareId,
			y.color,
			y.wareId,
			y.cntKgJ,y.cntKgW
			from plan_dye_gang x
			left join trade_dye_order2ware y on x.order2wareId=y.id
			left join trade_dye_order z on y.orderId=z.id
			left join dye_rs_chanliang m on x.id=m.gangId
			where x.planDate>'$dateFrom' and x.planDate>'{$dateStart}' and m.id is null
			and x.dateAssign='0000-00-00' and x.dateAssign1='0000-00-00'";
		if($arrGet['clientId']!='')$str.=" and z.clientId='{$arrGet['clientId']}'";
		$str .= " order by x.planDate asc,z.clientId,z.id";
		//echo $str;exit;
		$rowPlan = $modelVat->findBySql($str);

		$curClient=$curOrderCode='';
		$tTouliao=0;
		if(count($rowPlan)>0) foreach($rowPlan as & $v) {
			$v['vatNum']=$modelGang->setVatNum($v['id'],$v['order2wareId']);
			$client = $modelClient->find($v[clientId]);
			$v[clientName] = $client[compName];

			$ware = $modelWare->find($v[wareId]);
			$v[guige] = $ware[wareName] . " " .$ware[guige];
			$v['orderCode']=$this->_modelExample->getOrderTrack($v[orderId],$v[orderCode]);
			//松筒产量
			$stChanliang = $modelGang->getStChanliang($v[id]);
			$v['stChanliang']=$stChanliang;
			//if($stChanliang[cntKg]>0) $v[stChanliang] = $stChanliang[cntKg]."kg($stChanliang[cntTongzi]个)";

			//工艺
			$gongyi = $modelGongyi->findByField('order2wareId',$v[ord2wareId]);
			$v[gongyiStatu] = $gongyi ? 'ok':'&nbsp;';

			//取得物理缸号
			/**/
			$modelVat = & FLEA::getSingleton('Model_JiChu_Vat');
			$vat = $modelVat->findByField('id', $v[vatId]);
			$v[vatCode] = $vat[vatCode];

			//控制重复显示的问题
			if ($curClient==$v[clientName]) $v[clientName]='';
			else $curClient=$v[clientName];
			if ($curOrderCode==$v[orderCode]) $v[orderCode]='';
			else $curOrderCode=$v[orderCode];

			$tTouliao+=$v[cntPlanTouliao];

			$v['_edit']='<input type="checkbox" value="on" style="border:0px;" name="isJihua['.$v['id'].']" id="isJihua[]"/>';
			$v['isJiaji'] = '<input name="isJiaji['.$v['id'].']" id="isJiaji['.$v['id'].']" type="checkbox"/>';
		}
		//增加合计
		$count = count($rowPlan);
		//dump($rowPlan);
		$rowPlan[$count][clientName]='<strong>合计</strong>';
		$rowPlan[$count][cntPlanTouliao]='<strong>'.$tTouliao.'</strong>';

		$totalCount += $tTouliao;

		//dump($vatCode);	dump($schedule); exit;

		$arrFieldInfo = array(
			'clientName' =>'客户',
			'orderCode' =>'合同编号',
			'vatNum' =>'逻辑缸号',
			'vatCode' =>'物理缸号',
			'guige' =>'规格',
			'color' =>'颜色',
			'cntKgJ'=>'经',
			'cntKgW'=>'纬',
			'cntPlanTouliao' =>'计划投料',
			'planDate' =>'排缸日期',
			'dateJiaohuo' =>'交期',
			'stChanliang'=>'松筒产量',
			'gongyiStatu'=>'工艺单',
			'_edit'=>'选择',
			'isJiaji'=>'加急'
			// 'id'=>'id'
			//'rsChanliang' => '染色产量'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','计划单查询');
		$smarty->assign('supplier_name', '客户');
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('count', 1);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('vat_code', $vatCode);
		$smarty->assign('total_count', $tTouliao);
		$smarty->assign('total_vat', $count);
		$smarty->assign('arr_field_value', $rowPlan);

		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('pk', $this->_pkName);
		$smarty->display('Plan/PaigangSchedule1.tpl');
	}
	
	//按客户来排
	function actionPaigangSchedule2() {
		$modelClient = & FLEA::getSingleton('Model_JiChu_Client');
		$rowClient = $modelClient->findAll(null,'id',null, 'id,compName', false);
		$countClient = count($rowClient);
		//dump($rowClient); exit();
		$dateFrom = '2008-02-16';

		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');	//trade_dye_order2ware
		$modelVat = & FLEA::getSingleton('Model_JiChu_Vat');
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		//$modelClient = & FLEA::getSingleton('Model_JiChu_Client');
		$modelGongyi = & FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		//dump($rowVat); exit();
		$totalCount = 0;
		$totalVat = 0;

		$i = 0;
		if ($countClient>0) foreach($rowClient as & $value) {
			//dump($value); exit;
			$str = "select
				x.*,
				z.dateJiaohuo,
				z.orderCode,
				z.clientId,
				y.id as ord2wareId,
				y.color,
				y.wareId
				from plan_dye_gang x
				left join trade_dye_order2ware y on x.order2wareId=y.id
				left join trade_dye_order z on y.orderId=z.id
				left join dye_rs_chanliang m on x.id=m.gangId
				where x.planDate>'$dateFrom' and m.id is null and z.clientId>0 and z.clientId='$value[id]'";
			$str .= " order by z.clientId,z.id";
			$rowPlan = $modelVat->findBySql($str);

			$curClient=$curOrderCode='';
			$tTouliao = 0;
			if(count($rowPlan)>0) foreach($rowPlan as & $v) {
				$client = $modelClient->find($v[clientId]);
				$v[clientName] = $client[compName];

				$ware = $modelWare->find($v[wareId]);
				$v[guige] = $ware[wareName] . " " .$ware[guige];

				//松筒产量
				$stChanliang = $modelGang->getStChanliang($v[id]);
				if($stChanliang[cntKg]>0) $v[stChanliang] = $stChanliang[cntKg]."kg($stChanliang[cntTongzi]个)";

				//工艺
				$gongyi = $modelGongyi->findByField('order2wareId',$v[ord2wareId]);
				$v[gongyiStatu] = $gongyi ? 'ok':'&nbsp;';

				//取得物理缸号
				/**/
				$modelVat = & FLEA::getSingleton('Model_JiChu_Vat');
				$vat = $modelVat->findByField('id', $v[vatId]);
				$v[vatCode] = $vat[vatCode];

				//控制重复显示的问题
				if ($curClient==$v[clientName]) $v[clientName]='';
				else {
					$curClient=$v[clientName];
					$compName[$i] = $curClient;
				}
				if ($curOrderCode==$v[orderCode]) $v[orderCode]='';
				else $curOrderCode=$v[orderCode];
				$tTouliao+=$v[cntPlanTouliao];

				$totalVat++;


			}
			//增加合计
			$count = count($rowPlan);
			//dump($rowPlan);
			$rowPlan[$count][clientName]='<strong>合计</strong>';
			$rowPlan[$count][cntPlanTouliao]='<strong>'.$tTouliao.'</strong>';

			//$vatCode[$i] = $value[vatCode];
			$schedule[$i] = $rowPlan;

			$totalCount += $tTouliao;

			$i++;
		}

		//dump($vatCode);	dump($schedule); exit;
		//dump($compName); //exit;

		$arrFieldInfo = array(
			'clientName' =>'客户',
			'orderCode' =>'合同编号',
			'vatNum' =>'逻辑缸号',
			'vatCode'=>'物理缸号',
			'guige' =>'规格',
			'color' =>'颜色',
			'cntPlanTouliao' =>'计划投料',
			'planDate' =>'排缸日期',
			'dateJiaohuo' =>'交期',
			//'stChanliang'=>'松筒产量',
			'gongyiStatu'=>'工艺单'
			//'rsChanliang' => '染色产量'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','计划单查询');
		$smarty->assign('supplier_name', '客户');
		$smarty->assign('count', $countClient);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		//$smarty->assign('vat_code', $vatCode);
		$smarty->assign('comp_name',$compName);
		$smarty->assign('total_count', $totalCount);
		$smarty->assign('total_vat', $totalVat);
		$smarty->assign('arr_field_value', $schedule);

		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('pk', $this->_pkName);

		$smarty->display('Plan/PaigangSchedule.tpl');
	}


	//对某一缸进行回修需求
	//产生一个新的缸号，标志字段标志为回修
	function huiXiu() {
		$gangId = $_GET[id];
		$newGang = $this->_modelPlan->find(array('id'=>$gangId));
		$newGang[parentGangId] = $newGang[id];
		$newGang[id]='';
		$newGang[rsOver] = 0;
		$newGang[hsOver] = 0;
		$newGang[hdOver] = 0;
		$newGang[dbOver] = 0;
		$newGang[planDate] = date("Y-m-d");
		//$arr = $this->getNewGangNum(1);
		$newGang[vatNum]=$this->_modelPlan->getGangNumOfFanxiu($newGang['vatNum']);
		$newGang[OrdWare]=NULL;
		$newGang[Vat]=NULL;
		//回修缸时 要清除标记 
		$newGang['isCpRuku']=0;
		//dump($newGang);exit;
		$this->_modelPlan->create($newGang);
	}
	/**
	 * ps ：未出库整缸回修
	 * Time：2017年12月28日 14:24:56
	 * @author zcc
	*/
	function huiXiuZg() {
		$gangId = $_GET[id];
		$newGang = $this->_modelPlan->find(array('id'=>$gangId));
		$newGang[parentGangId] = $newGang[id];
		$newGang[id]='';
		$newGang[planDate] = date("Y-m-d");
		//$arr = $this->getNewGangNum(1);
		$newGang[vatNum]=$this->_modelPlan->getGangNumOfFanxiu($newGang['vatNum']);
		$newGang[OrdWare]=NULL;
		$newGang[Vat]=NULL;
		//回修缸时 要清除标记 
		$newGang['isCpRuku']=0;
		//判断为未出库整缸回修
		$newGang['isHuixiuCk']=1;
		//dump($newGang);exit;
		$this->_modelPlan->create($newGang);
	}
	// function actionHuixiu() {
	// 	$smarty = & $this->_getView();
	// 	$smarty->display('Plan/Huixiu.tpl');
	// }
	function actionHuixiu() {
		// $smarty = & $this->_getView();
		// $smarty->display('Plan/Huixiu.tpl');
		$this->_modelChanliang = & FLEA::getSingleton('Model_Dye_Chanliang');
		$this->_modelGxHuix =& FLEA::getSingleton('Model_Ganghuixiu_Gx');
		//查询出此缸号已经选过的回修工序
		// $huixiuGx = $this->_modelGxHuix->findAll(array('gangId'=>$_GET['id']),null,null,'gxId');
		// $huixiuGx = array_col_values($huixiuGx,'gxId');
		//dump($huixiuGx);die;
		//回修
		// $sqlgx = "select id from jichu_chanliang_gongxu where type=3";
		// $row = $this->_modelExample->findBySql($sqlgx);
		$row = $this->_modelChanliang->findAll(array('gangId'=>$_GET['id']),null,null,'gxIds');
		$fensan =array();
		$taomian = array();
		$gxIds = array();
        foreach ($row as $key => &$value) {
        	//$value['gxIds'] = $value['id'];
        	//去重
        	unset($row[$key]['Vat']);
        	if(in_array($value['gxIds'],$gxIds)){
        		unset($row[$key]);
        		continue;
        	} 
        	$gxIds[] = $value['gxIds'];
        	$sqls ="select gongxuName,fensan,taomian,type from jichu_chanliang_gongxu where id='{$value['gxIds']}'";
        	//dump($sqls);die;
        	$gongxName =$this->_modelExample->findBySql($sqls);
        	$value['gongxuName'] = $gongxName[0]['gongxuName'];
        	$value['fensan'] = $gongxName[0]['fensan'];
        	$value['taomian'] = $gongxName[0]['taomian'];
        	$value['type'] = $gongxName[0]['type'];
        	if($value['fensan']==1){
               $fensan[$key]['id'] = $value['gxIds'];
               $fensan[$key]['gongxuName'] = $value['gongxuName'];
        	}
        	if($value['taomian']==1){
               $taomian[$key]['id'] = $value['gxIds'];
               $taomian[$key]['gongxuName'] = $value['gongxuName'];
        	}
        	//dump($gongxName);die;
        	//已经选过的回修工序不能再选
        	// if(in_array($value['gxIds'],$huixiuGx )){
        	// 	$row[$key]['disabled'] = 'disabled';
        	// }
        }
        $fensan = array_values($fensan);
        $taomian = array_values($taomian);
       //dump($fensan);
       // dump($taomian);die;
        $temps = array();
        foreach ($row as $key => &$val) {
        	$temps[$val['type']][] = $val;
        }
        foreach ($temps as $k => &$va) {
        	if($k==''){
        		unset($temps[$k]);
        	}
        	foreach ($va as $key => &$vs) {
        		if($k==1){
        		$vs['typeName'] = '松紧筒打包工序';
	        	}elseif($k==2){
	                $vs['typeName'] = '装出笼工序';
	        	}elseif($k==3){
	                $vs['typeName'] = '染色工序';
	        	}
        	}
        	
        }
        // $temps =  array_values($temps);
       // dump($temps);die;
		$smarty = & $this->_getView();
		$smarty->assign('aRow', $temps);
		$smarty->assign('fensan', $fensan);//暂时用不到，先放在这
		$smarty->assign('taomian', $taomian);//暂时用不到，先放在这
		$smarty->display('Chanliang/gongxuRs.tpl');
	}

	  //查看已选择的回修工序
    function actionHuixiuGongxu(){
    	// dump($_GET);die;
    	$sql = "select gxId from ganghuixiu_gx where gangId='{$_GET['id']}'";
    	$hxGx =$this->_modelExample->findBySql($sql);
    	foreach ($hxGx as $key => &$value) {
    		$sqlN = "select gongxuName from jichu_chanliang_gongxu where id='{$value['gxId']}'";
    		$gongxuN = $this->_modelExample->findBySql($sqlN);
    		$value['gongxName'] = $gongxuN[0]['gongxuName'];
    	}
        $smarty = & $this->_getView();
        $smarty->assign('aRow', $hxGx);
        $smarty->display('Chanliang/gongXuHuixiu.tpl');
    }

    function actionSaveHuixiu() {
		if(!$_POST['docheck']){
			js_alert('请选择需要回修的工序!',"window.history.go(-1)");
		}
		//dump($_POST);exit;
		$gangId = $_POST[id];
		$newGang = $this->_modelPlan->find(array('id'=>$gangId));
		//dump($newGang);
		$newGang['rsWc'] = 0;
		$newGang['zclWc'] = 0;
		$newGang['rsStart'] = 0;
		$newGang['fensanOver'] = 0;
		$newGang['taomianOver'] = 0;

		$newGang['dateAssign'] = '0000-00-00';
		$newGang[parentGangId] = $newGang[id];
		$newGang[id]='';
		$newGang[planDate] = date("Y-m-d");
		//$arr = $this->getNewGangNum(1);
		$newGang[vatNum]=$this->_modelPlan->getGangNumOfFanxiu($newGang['vatNum']);
		$newGang['reasonHuixiu'] = $_POST['reasonHuixiu'];
		$newGang[OrdWare]=NULL;
		$newGang[Vat]=NULL;
		$newGang['dateDuizhang']='0000-00-00';
		$newGang['stOver']=0;
		$newGang['zclOver']=0;
		$newGang['rsOver']=0;
		$newGang['hsOver']=0;
		$newGang['hdOver']=0;
		$newGang['dbOver']=0;
		//dump($newGang);exit;
		$this->_modelPlan->create($newGang);
		$this->_modelGxHuix =& FLEA::getSingleton('Model_Ganghuixiu_Gx');
        foreach ($_POST['docheck'] as $key => &$vals) {
        	$rows[$key]['gxId'] = $vals;
        	$rows[$key]['gangId'] = $_POST['id'];
        }
        if(!$this->_modelGxHuix->saveRowset($rows)) {
         	echo ("<script>alert('保存失败');history.go(-1)</script>");exit;
			exit;
		}
		//刷新父窗口
		js_alert(null,"window.parent.location.href=window.parent.location.href");
	}

	//排计划时根据输入的筒子数取出装筒数大于或=计划筒子数的最前两个染缸
	//以json格式返回
	function actionGetVatOption() {
		$m = & FLEA::getSingleton('Model_JiChu_Vat');
		echo json_encode($m->getVatOptionNew($_GET[cntTongzi]));
		exit;
	}

	////////////////////////染色//////////////////////////////
	//制定染色日计划
	function actionMakeDayPlan(){
		$this->authCheck(109);
		$smarty = & $this->_getView();
		$smarty->display('Plan/MakeDayPlan.tpl');
	}
	//得到所有没有安排计划的缸号,包括分散+套棉染法只染了一次的缸
	/*function actionGetJsonByVatId(){
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$str = "select * from plan_dye_gang
			where vatId='{$_GET['vatId']}' and (
				dateAssign='0000-00-00' or (
				dateAssign1='0000-00-00' and markTwice=1
				)
			)";
		//$modelVat = FLEA::getSingleton('Model_JiChu_Vat');
		//echo $str;
		$rowVat = $model->findBySql($str);

		if($rowVat) foreach($rowVat as & $v) {
			$v = $model->formatRet($v);
			#双染的缸号进行格式化
			if($v['markTwice']==1 && $v['dateAssign1']=='0000-00-00') {
				$v['vatNumFormat'] = $v['vatNum'] . "-套棉";
			} else $v['vatNumFormat'] = $v['vatNum'];
		}
		//dump($rowVat);
		echo json_encode($rowVat);
	}

	//得到所有没有安排计划的缸号
	function actionGetJsonByClientId(){
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$str = "select * from view_dye_gang
			where clientId='{$_GET['clientId']}' and (
				dateAssign='0000-00-00' or (
				dateAssign1='0000-00-00' and markTwice=1
				)
			)";
		//$modelVat = FLEA::getSingleton('Model_JiChu_Vat');
		//echo $str;
		$rowVat = $model->findBySql($str);
		//dump($rowVat[0]);exit;
		if($rowVat) foreach($rowVat as & $v) {
			$v = $model->formatRet($v);

			#双染的缸号进行格式化
			if($v['markTwice']==1 && $v['dateAssign1']=='0000-00-00') {
				$v['vatNumFormat'] = $v['vatNum'] . "-套棉";
			} else $v['vatNumFormat'] = $v['vatNum'];
		}
		//dump($rowVat);
		echo json_encode($rowVat);exit;
	}

	//得到所有安排在某一天的计划的缸号
	function actionGetJsonByDateAssign(){
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$str = "select * from plan_dye_gang
			where
			(dateAssign='{$_GET['dateAssign']}' and ranseBanci = '{$_GET['ranseBanci']}') or
			(dateAssign1='{$_GET['dateAssign']}' and ranseBanci1 = '{$_GET['ranseBanci']}')
			";

		$rowVat = $model->findBySql($str);

		if($rowVat) foreach($rowVat as & $v) {
			$v = $model->formatRet($v);
			#双染的缸号进行格式化
			if ($v['markTwice']==1) {
				if($v['dateAssign']==$_GET['dateAssign'] && $v['ranseBanci']==$_GET['ranseBanci']) {
					if($v['dateAssign1']==$_GET['dateAssign'] && $v['ranseBanci1']==$_GET['ranseBanci']) {
						$v['vatNumFormat'] = $v['vatNum'] . "-分散+套棉";
					} else $v['vatNumFormat'] = $v['vatNum'] . "-分散";
				} elseif($v['dateAssign1']==$_GET['dateAssign'] && $v['ranseBanci1']==$_GET['ranseBanci']) {
					$v['vatNumFormat'] = $v['vatNum']. "-套棉";
				}
			} else $v['vatNumFormat'] = $v['vatNum'];
		}
		echo json_encode($rowVat);
	}*/

	function actionSaveDayPlan(){
		//将需要删除且不是双染的染色时间置空
		$sql = "update plan_dye_gang set dateAssign = '0000-00-00' where markTwice<>1 and id not in ({$_POST['vatIds']}) and dateAssign = '{$_POST['dateAssign']}' and ranseBanci = '{$_POST['ranseBanci']}'";
		//echo $sql;exit;
		//echo "<br>将不是双染的染色时间置空,影响行数:".mysql_affected_rows();
		mysql_query($sql) or die($sql.mysql_error());

		//将需要删除且且是双染的第一次染色时间为当前班次的记录的两个染色时间都置空，并将双染标记置0
		$sql = "update plan_dye_gang set dateAssign = '0000-00-00',ranseBanci='',dateAssign1 = '0000-00-00',ranseBanci1='',markTwice=0		where markTwice=1 and dateAssign = '{$_POST[dateAssign]}' and ranseBanci =					'{$_POST[ranseBanci]}' and id not in ({$_POST[vatIds]})";
		//echo "<br>将双染的第一次染色时间为当前班次的记录的两个染色时间都置空，并将双染标记置0,影响行数:".mysql_affected_rows();
		mysql_query($sql) or die(mysql_error());

		//将需要删除且是双染的第二次染色时间为当前班次的记录的第二个染色时间置空
		$sql = "update plan_dye_gang set dateAssign1 = '0000-00-00',ranseBanci1=''	where markTwice =1 and dateAssign1 = '{$_POST[dateAssign]}' 	and ranseBanci1 = '{$_POST[ranseBanci]}' and id not in ({$_POST[vatIds]})";
		//echo "<br>将双染的第二次染色时间为当天的记录的第二个染色时间置空,影响行数:".mysql_affected_rows();
		mysql_query($sql) or die(mysql_error());

		//增加
		$arr = array_unique(explode(',',$_POST['vatIds']));
		//dump($arr);exit;
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		foreach($arr as & $v) {
			$gang = $this->_modelPlan->find(array('id'=>$v));
			//判断是否存在cvc,t/c并且未设置双染工艺
			if ($gang['markTwice']==0 && $mWare->isHuaxian($gang['OrdWare']['wareId'])) {
				$found = true;
			}

			//处理双染要求下的问题
			if($gang['markTwice']!=1) {
				$rowset[] = array(
					'id'=>$v,
					'dateAssign'=>$_POST['dateAssign'],
					'ranseBanci'=>$_POST['ranseBanci']
				);
			} else {//如果是双染
				//如果markTwice为1,第一缸肯定已经安排过了，所以只需要处理第二缸的问题
				if($gang['dateAssign1']=='0000-00-00'){
					$rowset[] = array(
						'id'=>$v,
						'dateAssign1'=>$_POST['dateAssign'],
						'ranseBanci1'=>$_POST['ranseBanci']
					);
				}
			}
		}
		//dump($rowset);exit;
		__TRY();
		$this->_modelPlan->updateRowset($rowset);
		$ex = __CATCH();
		if (__IS_EXCEPTION($ex)) {
			js_alert('保存出错!', '', $this->_url('MakeDayPlan',array('dateAssign'=>$_POST['dateAssign'], 'ranseBanci'=>$_POST['ranseBanci'])));
		} else {
			//如果需要设置双染,跳到双染设置界面
			if ($found){
				js_alert('检测到有需要设置双染的化纤类棉纱,下面将进入双染设置界面!',null,$this->_url('SetTwice',array('dateAssign'=>$_POST['dateAssign'], 'ranseBanci'=>$_POST['ranseBanci'])));
				exit;
			}
			if ($_POST['button2']){
				js_alert('保存成功!', '', $this->_url('MakeDayPlan',array('dateAssign'=>$_POST['dateAssign'], 'ranseBanci'=>$_POST['ranseBanci'])));
			} else {

				$url100 = $this->_url('MakeDayPlan',array('dateAssign'=>$_POST['dateAssign'], 'ranseBanci'=>$_POST['ranseBanci']));
				$url200 = $this->_url('PrintDayPlan',array('dateAssign'=>$_POST['dateAssign'], 'ranseBanci'=>$_POST['ranseBanci']));

				$out = "<script language=\"javascript\" type=\"text/javascript\">\n";
				$out .= "document.location.href=\"";
				$out .= $url100;
				$out .= "\";\n";

				$out .= "window.open(\"";
				$out .= $url200;
				$out .= "\");\n";
				$out .= "</script>";
				echo($out);
			}
		}
	}



	function actionPrintDayPlan(){
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$sql = "select * from view_dye_gang";
		$sql .= " where (dateAssign = '{$_GET['dateAssign']}' and ranseBanci = {$_GET['ranseBanci']}) or
			(dateAssign1 = '{$_GET['dateAssign']}' and ranseBanci1 = {$_GET['ranseBanci']})
		order by vatCode";
		//echo $sql;
		$rowVat = $model->findBySql($sql);
		if(count($rowVat)>0) foreach($rowVat as & $v) {
			$v['wareName'] = $v['guige'].' '.$v['wareName'];
		}


		if ($_GET['ranseBanci'] == 1) $ranseBanci = '早班1';
		else if ($_GET['ranseBanci'] == 2) $ranseBanci = '晚班1';
		else if ($_GET['ranseBanci'] == 3) $ranseBanci = '早班2';
		else if ($_GET['ranseBanci'] == 4) $ranseBanci = '晚班2';
		else $ranseBanci = '000000';

		//精简精简精简精简精简精简精简精简精简精简精简精简精简
		//插入空行
		if (count($rowVat)>0) {

			$vatCode = $rowVat[0]['vatCode'];
			$i = 0;
			$aaa = 0;
			$count = count($rowVat);
			foreach($rowVat as & $v) {
				$aaa++;

				if ($v['vatCode'] != $vatCode) {
					$remain = 10 - $i;
					if ($remain>0) {
						for ($j=0; $j<$remain; $j++){
							$newRowVat[] = array();
						}
					} else {
						$newRowVat[] = array();
					}
					$vatCode = $v['vatCode'];
					$i = 0;
				}
				#双染的缸号进行格式化
				if ($v['markTwice']==1) {
					if($v['dateAssign']==$_GET['dateAssign'] && $v['ranseBanci']==$_GET['ranseBanci']) {
						if($v['dateAssign1']==$_GET['dateAssign'] && $v['ranseBanci1']==$_GET['ranseBanci']) {
							$v['vatNumFormat'] = $v['vatNum'] . "-分散+套棉";
						} else $v['vatNumFormat'] = $v['vatNum'] . "-分散";
					} elseif($v['dateAssign1']==$_GET['dateAssign'] && $v['ranseBanci1']==$_GET['ranseBanci']) {
						$v['vatNumFormat'] = $v['vatNum']. "-套棉";
					}
				} else $v['vatNumFormat'] = $v['vatNum'];
				$newRowVat[] = & $v;

				$i++;

				if ($aaa >= $count) {
					$remain = 10 - $i;
					if ($remain>0) {
						for ($j=0; $j<$remain; $j++){
							$newRowVat[] = array();
						}
					} else {
						$newRowVat[] = array();
					}
					$vatCode = $v['vatCode'];
					$i = 0;
				}
			}
		}

		//dump($newRowVat); exit;
		$arr_field_info = array(
            "vatCode"			=> "缸号",
			'compName'			=>'加工单位',
			"vatNumFormat"			=> "逻辑缸号",
			'wareName'			=> '纱支',
			//'guige'				=> '规格',
			'color'				=> '色别',
            "cntPlanTouliao"	=> '计划投料',
			'employName'		=>'打样人',
            //"planTongzi"		=> '筒子个数',
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','染部日生产计划单');
		$smarty->assign('date_assign', $_GET['dateAssign']);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value', $newRowVat);
		$smarty->assign('ranseBanci', $ranseBanci);
		$smarty->display('Plan/PrintDayPlan.tpl');
	}

	////////////////////领纱日计划安排/////////////////////////////
	function actionLingshaDayPlan(){
		$this->authCheck(110);
		$smarty = & $this->_getView();
		$smarty->display('Plan/LingshaDayPlan.tpl');
	}
	function actionSaveLingshaDayPlan(){
		//dump($_POST); EXIT;
		//删除
		//$sql = "update plan_dye_gang set dateLingsha = '0000-00-00' where id not in ({$_POST[vatIds]}) and dateLingsha = '{$_POST[dateLingsha]}' and ranseBanci = '{$_POST[lingshaBanci]}'";
		//mysql_query($sql) or die(mysql_error());

		//增加
		$arr = explode(',',$_POST['vatIds']);
		foreach($arr as & $v) {
			$rowset[] = array(
				'id'=>$v,
				'dateLingsha'=>$_POST['dateLingsha'],
				'lingshaBanci'=>$_POST['lingshaBanci']
			);
		}

		__TRY();
		$this->_modelPlan->updateRowset($rowset);
		$ex = __CATCH();
		if (__IS_EXCEPTION($ex)) {
			js_alert('保存出错!', '', $this->_url('LingshaDayPlan',array('dateLingsha'=>$_POST['dateLingsha'], 'lingshaBanci'=>$_POST['lingshaBanci'])));
		} else {
			if ($_POST['button2']){
				js_alert('保存成功!', '', $this->_url('LingshaDayPlan',array('dateLingsha'=>$_POST['dateLingsha'], 'lingshaBanci'=>$_POST['lingshaBanci'])));
			} else {
				$url100 = $this->_url('LingshaDayPlan',array('dateLingsha'=>$_POST['dateLingsha'], 'lingshaBanci'=>$_POST['lingshaBanci']));
				$url200 = $this->_url('PrintDayPlanByCompName',array('dateLingsha'=>$_POST['dateLingsha'], 'lingshaBanci'=>$_POST['lingshaBanci']));

				$out = "<script language=\"javascript\" type=\"text/javascript\">\n";
				$out .= "document.location.href=\"";
				$out .= $url100;
				$out .= "\";\n";

				$out .= "window.open(\"";
				$out .= $url200;
				$out .= "\");\n";
				$out .= "</script>";
				echo($out);
			}
		}
	}
	////////////////////领纱日计划查询/////////////////////////////
	function actionListLingshaDayPlan(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d')
			//worderCode=>'',
			//vatNum=>''
		));
		$condition=array(
			array('dateLingsha',$arr['dateFrom'],'>='),
			array('dateLingsha',$arr['dateTo'],'<='),
		);
		$pager = new TMIS_Pager($this->_modelPlan,$condition);
		$rowset = $pager->findAll();

		foreach($rowset as &$v) {
			$v = $this->_modelPlan->formatRet($v);
			$v['guige'] = $v['OrdWare']['Ware']['wareName'] . ' ' . $v['OrdWare']['Ware']['guige'];
			$v['_edit'] = "<a href='".$this->_url('cancelLingshaPlan',array(
				'gangId'=>$v['id']
			))."' onclick='return confirm(\"您确认要取消该领纱计划吗？\");'>取消</a>";
			//$v[vatNum] = $v[Vat][vatNum];
			//$con = array("gangId='$v[gangId]'");
			//$gang = $this->_modelGang->findAllGang1($con);
			//if ($gang[0]) $v = array_merge($v,$gang[0]);
		}
		//dump($rowset[0]);
		//$this->_modelExample
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateLingsha'=>'计领日期',
			'lingshaBanci'=>'领纱班次',
			'Client.compName'=>"客户",
			'OrdWare.Order.orderCode'=>"订单号",
			'vatNum'=>"缸号",
			'guige'=>"纱支",
			'OrdWare.color'=>"颜色",
			'OrdWare.cntKg'=>'计领数量',
			'_edit'=>'操作'
		));

		$smarty->assign('title','领纱计划查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		$smarty->assign('search_item',$search_item1.$search_item2.$search_item3);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('ListLingshaDayPlan')));
		$smarty->display('TableList.tpl');
	}
	//取消领纱计划
	function actionCancelLingshaPlan() {
		if(empty($_GET['gangId'])) {
			js_alert('输入非法',null,$this->_url('ListLingshaDayPlan'));
			exit;
		}

		//将待取消的领纱计划和待删除的缸号信息形成生产信息插入oa_message表中
		$gang = $this->_modelPlan->formatRet($this->_modelPlan->find(array(
			'id'=>$_GET['gangId']
		)));
		//dump($gang);exit;
		$title = date("Y-m-d").",取消领纱计划,缸号:{$gang['vatNum']}({$gang['Client']['compName']},{$gang['OrdWare']['Ware']['wareName']} {$gang['OrdWare']['Ware']['guige']},{$gang['OrdWare']['color']}),投料{$gang['OrdWare']['cntKg']}kg";

		$msg = date("Y-m-d").",<font color='blue'>取消领纱计划</font>,缸号:<font color='red'>{$gang['vatNum']}</font>(<font color='blue'>{$gang['Client']['compName']},{$gang['OrdWare']['Ware']['wareName']} {$gang['OrdWare']['Ware']['guige']},{$gang['OrdWare']['color']},投料{$gang['OrdWare']['cntKg']}kg</font>),相关领纱记录请手工清除!";

		$mMsg = & FLEA::getSingleton('Model_OA_Message');
		$arr = array(
			'classId'=>6,
			'title'=>$title,
			'content'=>$msg,
			'buildDate'=>date('Y-m-d'),
			'userId'=>$_SESSION['USERID']
		);
		$mMsg->create($arr);
		$arr = array(
			'id'=>$_GET['gangId'],
			'dateLingsha'=>'0000-00-00',
			'lingshaBanci'=>1
		);
		if($this->_modelPlan->update($arr)) js_alert('操作成功!',null,$this->_url('ListLingshaDayPlan'));
	}

	//得到所有没有安排计划的缸号
	function actionGetJsonByVatIdLingsha(){
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$str = "select* from plan_dye_gang
			where vatId='{$_GET['vatId']}' and dateLingsha='0000-00-00'";
		//$modelVat = FLEA::getSingleton('Model_JiChu_Vat');
		//echo $str;
		$rowVat = $model->findBySql($str);

		if($rowVat) foreach($rowVat as & $v) {
			$v = $model->formatRet($v);
		}
		//dump($rowVat);
		echo json_encode($rowVat);
	}

	//得到所有没有安排计划的缸号
	function actionGetJsonByClientIdLingsha(){
		$returnRowset = array(); //返回变量
		$i = 0;
		$model = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$mVat = FLEA::getSingleton('Model_JiChu_Vat');
		$mClient =& FLEA::getSingleton('Model_JiChu_Client');
		$row = $mClient->find($_GET['clientId']);
		$compName = $row['compName'];

		$conditions[] = array('Order.clientId', $_GET['clientId']);
		$rowset = $model->findAll($conditions);

		if (count($rowset)>0) foreach($rowset as & $v) {
			if (count($v['Pdg'])>0) foreach($v['Pdg'] as & $t) {
				if ($t['dateLingsha'] == '0000-00-00') {
					$returnRowset[$i]['id']					= $t['id'];
					$returnRowset[$i]['vatNum']				= $t['vatNum'];
					$returnRowset[$i]['cntPlanTouliao']		= $t['cntPlanTouliao'];
					$returnRowset[$i]['planTongzi']			= $t['planTongzi'];
					//$returnRowset[$i]['dateAssign']		= $t['dateAssign'];
					$returnRowset[$i]['color']				= $v['color'];
					$returnRowset[$i]['compName']			= $compName;
					$returnRowset[$i]['wareName']			= $v['Ware']['wareName'];
					$returnRowset[$i]['guige']				= $v['Ware']['guige'];
					$row = $mVat->find($t['vatId']);
					$returnRowset[$i]['vatCode']			= $row['vatCode'];
					$i++;
				}
			}
		}
		echo json_encode($returnRowset);
	}

	//得到所有安排在某一天的计划的缸号
	function actionGetJsonByDateLingsha(){
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$str = "select * from plan_dye_gang
			where dateLingsha='{$_GET['dateLingsha']}' and lingshaBanci = '{$_GET['lingshaBanci']}'";

		$rowVat = $model->findBySql($str);

		if($rowVat) foreach($rowVat as & $v) {
			$v = $model->formatRet($v);
		}
		echo json_encode($rowVat);
	}

	function actionSearchDayPlan(){

		if (!empty($_POST['printList'])) {
			$url100 = $this->_url('SearchDayPlan',array('date'=>$_POST['date']));
			$url200 = $this->_url('PrintDayPlanByCompName',array('date'=>$_POST['date']));

			$out = "<script language=\"javascript\" type=\"text/javascript\">\n";
			$out .= "document.location.href=\"";
			$out .= $url100;
			$out .= "\";\n";

			$out .= "window.open(\"";
			$out .= $url200;
			$out .= "\");\n";
			$out .= "</script>";
			echo($out);
		}
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'date' => date("Y-m-d"),
			'printList'=>'',
		));

		$today = $arrGet['date'];
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$sql = "select n.id AS clientId,
					n.compName AS compName,
					m.id AS wareId,
					m.wareName AS wareName,
					m.guige AS guige,
					y.id AS order2wareId,
					y.color AS color,
					y.colorNum AS colorNum,
					y.cntKg AS cntKg,
					z.id AS orderId,
					z.orderCode AS orderCode,
					z.dateOrder AS dateOrder,
					z.dateJiaohuo AS dateJiaohuo,
					x.id AS gangId,
					x.planDate AS planDate,
					x.vatNum AS vatNum,
					x.cntPlanTouliao AS cntPlanTouliao,
					x.planTongzi AS planTongzi,
					x.unitKg AS unitKg,
					x.parentGangId AS parentGangId,
					x.dateAssign AS dateAssign,
					t.id AS vatId,
					t.vatCode AS vatCode
			from (((((plan_dye_gang x left join trade_dye_order2ware y on((x.order2wareId = y.id)))
			join trade_dye_order z on((y.orderId = z.id)))
			join jichu_ware m on((y.wareId = m.id)))
			join jichu_client n on((z.clientId = n.id))) left
			join jichu_vat t on((x.vatId = t.id)))";

		$sql .= " where  planDate= '{$today}' order by compName";

		$rowVat = $model->findBySql($sql);

		//dump($rowVat); exit;
		$arr_field_info = array(
			'compName'			=>'加工单位',
			"vatCode"			=> "缸号",
            "vatNum"			=> "逻辑缸号",
			'wareName'			=> '纱支',
			'guige'				=> '规格',
			'color'				=> '色别',
            //"planDate"		=> '计划日期',
            "cntPlanTouliao"	=> '计划投料',
            "planTongzi"		=> '筒子个数',
			'aaaaaa'			=>'色号',
            //"order2wareId"		=> 81
            //"pihao"				=> 0
            //"vatId"				=> 17
            //"unitKg"			=> '定重',
            //"parentGangId"		=> 0
            //"memo"				=> '备注'
		);

		$smarty = & $this->_getView();
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value', $rowVat);
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('add_display', 'none');
		$smarty->display('TableList.tpl');
	}

	function actionPrintDayPlanByCompName(){
		//dump($_GET); EXIT;
		$date = $_GET['dateLingsha'];
		$banci = $_GET['lingshaBanci'];
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$sql = "select n.id AS clientId,
					n.compName AS compName,
					m.id AS wareId,
					m.wareName AS wareName,
					m.guige AS guige,
					y.id AS order2wareId,
					y.color AS color,
					y.colorNum AS colorNum,
					y.cntKg AS cntKg,
					z.id AS orderId,
					z.orderCode AS orderCode,
					z.dateOrder AS dateOrder,
					z.dateJiaohuo AS dateJiaohuo,
					x.id AS gangId,
					x.planDate AS planDate,
					x.vatNum AS vatNum,
					x.cntPlanTouliao AS cntPlanTouliao,
					x.planTongzi AS planTongzi,
					x.unitKg AS unitKg,
					x.parentGangId AS parentGangId,
					x.dateLingsha AS dateLingsha,
					x.lingshaBanci as lingshaBanci,
					t.id AS vatId,
					t.vatCode AS vatCode
			from (((((plan_dye_gang x left join trade_dye_order2ware y on((x.order2wareId = y.id)))
			join trade_dye_order z on((y.orderId = z.id)))
			join jichu_ware m on((y.wareId = m.id)))
			join jichu_client n on((z.clientId = n.id))) left
			join jichu_vat t on((x.vatId = t.id)))";

		$sql .= " where  dateLingsha= '{$date}' and lingshaBanci = '{$banci}' order by n.id,y.wareId";

		//echo($sql); exit;

		$rowVat = $model->findBySql($sql);
		$newArr = array();
		$tKg = 0;
		if(count($rowVat)>0) foreach($rowVat as & $v) {
			$v['wareName'] = $v['guige'].' '.$v['wareName'];
			//$v['wareName'] .= $tKg;

			if (($v['clientId']!=$clientId || $v['wareId']!=$wareId)) {
				if($clientId!='') {//显示合计行
					$newArr[] = array(
						'cntPlanTouliao'=>'共计:'.$tKg
					);
					$tKg=0;
				}
				$clientId = $v['clientId'];
				$wareId = $v['wareId'];
			}
			$tKg+=$v['cntPlanTouliao'];
			$newArr[] = $v;
		}
		$newArr[] = array(
			'cntPlanTouliao'=>'共计:'.$tKg
		);
		//dump($newArr);exit;

		if ($banci == 1) $lingshaBanci = '早班1';
		else if ($banci == 2) $lingshaBanci = '晚班1';
		else if ($banci == 3) $lingshaBanci = '早班2';
		else if ($banci == 4) $lingshaBanci = '晚班2';
		else $lingshaBanci = '000000';


		$arr_field_info = array(
			'compName'			=>'加工单位',
			"vatCode"			=> "缸号",
            "vatNum"			=> "逻辑缸号",
			'wareName'			=> '纱支',
			//'guige'				=> '规格',
			'color'				=> '色别',
            //"planDate"		=> '计划日期',
            "cntPlanTouliao"	=> '计划投料',
            "planTongzi"		=> '筒子个数',
			'aaaaaaaa'			=>'色号'
            //"order2wareId"		=> 81
            //"pihao"				=> 0
            //"vatId"				=> 17
            //"unitKg"			=> '定重',
            //"parentGangId"		=> 0
            //"memo"				=> '备注'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','染部日生产计划单');
		$smarty->assign('date_lingsha', $date);
		$smarty->assign('lingshaBanci', $lingshaBanci);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value', $newArr);
		$smarty->display('Plan/PrintDayPlanByCompName.tpl');
	}

	#对某一缸进行加急操作，显示在消息栏目中
	function actionJiaji(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mWare =& FLEA::getSingleton('Model_JiChu_Ware');
		$gang = $m->formatRet($m->find(array('id'=>$_GET['id'])));
		//dump($gang);exit;
		$title = "缸号 {$gang['vatNum']} 加急通知!";
		$con = "缸号 {$gang['vatNum']},".$mWare->getGuigeDesc($gang['OrdWare']['wareId'])." {$gang['OrdWare']['color']},加急!!!,请各部门注意!";
		$mMsg = & FLEA::getSingleton('Model_OA_Message');
		$arr = array(
			'classId'=>7,
			'title'=>$title,
			'content'=>$con,
			'buildDate'=>date('Y-m-d'),
			'gangId'=>$_GET['id'],
			'userId'=>$_SESSION['USERID']
		);
		//dump($arr);exit;
		if($mMsg->create($arr)) {
			js_alert('加急成功，已经发送加急通知！','window.opener.history.go(0);window.close();');
		};

	}
	#整单加急
	function actionTotalJiaji()
	{
       $m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
	   $arr=$m->findAll(array('order2wareId'=>$_GET['order2wareId']));
	   //dump($arr);
	   foreach($arr as $v)
		{
			$mWare =& FLEA::getSingleton('Model_JiChu_Ware');
			$gang = $m->formatRet($m->find(array('id'=>$v['id'])));
			//dump($gang);exit;
			$title = "缸号 {$gang['vatNum']} 加急通知!";
			$con = "缸号 {$gang['vatNum']},".$mWare->getGuigeDesc($gang['OrdWare']['wareId'])." {$gang['OrdWare']['color']},加急!!!,请各部门注意!";
			$mMsg = & FLEA::getSingleton('Model_OA_Message');
			$i=count($mMsg->findAll(array('gangId'=>$v['id'])));
			if($i>0) continue;
			$marr = array(
				'classId'=>7,
				'title'=>$title,
				'content'=>$con,
				'buildDate'=>date('Y-m-d'),
				'gangId'=>$v['id'],
				'userId'=>$_SESSION['USERID']
			);
			//dump($marr);
			$mMsg->create($marr);
		}
       // exit;
		 if($_GET['page']=='jiaji'){
                  js_alert('整单加急成功，已经发送加急通知！','window.history.go(-1);window.close();');
              }else{
		js_alert('整单加急成功，已经发送加急通知！','window.opener.history.go(0);window.close();');
              }

	}
	function actionCancelJiaji(){
		$sql = "delete from oa_message where classId=7 and gangId='{$_GET['id']}'";
		mysql_query($sql) or die(mysql_error());
		js_alert('取消加急成功!加急提醒将自动消失!','window.opener.history.go(0);window.close();');
	}
    #对整单取消加急
	function actionCancelTotalJiaji(){
	    $m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
	    $arr=$m->findAll(array('order2wareId'=>$_GET['order2wareId']));
		$mMsg = & FLEA::getSingleton('Model_OA_Message');
		$gangid='';
		foreach($arr as $v){
			$marr=$mMsg->find(array('gangId'=>$v['id']));
			if(count($marr)>0){
                $gangid.=$v['id'].',';
			};
		}
		$gangid=substr($gangid,0,strrpos($gangid,','));
		//echo($gangid);
		if(id!='')
		$sql="delete from oa_message where classId=7 and gangId in (".$gangid.")";
		//echo($sql);
		mysql_query($sql) or die(mysql_error());
		if($_GET['page']=='jiaji'){
                    js_alert('取消加急成功!加急提醒将自动消失!','window.history.go(-1);window.close();');
                }else{
                    js_alert('取消加急成功!加急提醒将自动消失!','window.opener.history.go(0);window.close();');
                }

	}
	#得到一个星期内的加急缸数
	function actionGetJiajiJson(){
		$dateFrom = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-7,date('Y')));
		$sql = "select count(*) cnt from oa_message where buildDate>'$dateFrom' and classId=7";
		$r = mysql_fetch_assoc(mysql_query($sql));
		echo '{cntJiaji:'.$r['cnt'].'}';
	}
	#排染计划
	function actionsaveJihua(){
		 //dump($_POST);
		if($_POST['submit1']=='并缸双染'){
			if ($_POST['isJihua1']) {
		 	$string;
		 	foreach ($_POST['isJihua1'] as $key => $value) {
		 	 	$string .= $key;
		 	}
		 	 
		 	$string = substr($string,0,strlen($string)-1);
		 	//dump($string);
		 	$str = explode(',', $string);
		 	// dump($str);exit();
		 	$found = false;
			$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
			$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
			if($str)foreach($str as $key=>$v){
				$gang = $this->_modelPlan->find(array('id'=>$v));
				//dump($gang);
				//判断是否存在化纤并且未设置双染工艺
				if ($gang['markTwice']==0 && $mWare->isHuaxian($gang['OrdWare']['wareId'])) {
					$found = true;
				}
				if($gang['markTwice']!=1) {//分散+套棉(mark=1)才需要染两次
					$rowset[]=array(
						'id'=>$key,
						'dateAssign'=>$_POST['dateAssign'],
						'ranseBanci'=>$_POST['ranseBanci'],
						'isJiaji'=>$_POST['isJiaji'][$key]=='on'?1:0
					);
				} else {//如果是双染
					//根据fensanOver判断是分散还是套棉工序
					if($gang['fensanOver']==0) {//说明是第一道工序
						//判断分散和套棉是否安排在同一班
						if($gang['dateAssign']==$gang['dateAssign1'] && $gang['ranseBanci']==$gang['ranseBanci1']) {
							$rowset[] = array(
								'id'=>$key,
								'dateAssign'=>$_POST['dateAssign'],
								'ranseBanci'=>$_POST['ranseBanci'],
								'dateAssign1'=>$_POST['dateAssign'],
								'ranseBanci1'=>$_POST['ranseBanci'],
								'isJiaji'=>$_POST['isJiaji'][$key]=='on'?1:0
							);
						} else $rowset[] = array(
							'id'=>$key,
							'dateAssign'=>$_POST['dateAssign'],
							'ranseBanci'=>$_POST['ranseBanci'],
							'isJiaji'=>$_POST['isJiaji'][$key]=='on'?1:0
						);
					}

					if($gang['fensanOver']==1) {//说明是第二道工序
						$rowset[] = array(
							'id'=>$key,
							'dateAssign1'=>$_POST['dateAssign'],
							'ranseBanci1'=>$_POST['ranseBanci'],
							'isJiaji'=>$_POST['isJiaji'][$key]=='on'?1:0
						);
					}
				}

			}
			//dump(1);
		 	 if ($found){
		 	 	//dump(2);
				js_alert('检测到有需要设置双染的化纤类棉纱,下面将进入双染设置界面!',null,$this->_url('SetTwice1',array(
					'dateAssign'=>$_POST['dateAssign'],
					'ranseBanci'=>$_POST['ranseBanci'],
					'gangId'=>$string,
					'fromController'=>$_POST['fromController'],
					'fromAction'=>$_POST['fromAction']
				)));
				exit;
			}
			js_alert('不存在双染或者已经做完！',null,$this->_url('paigangSchedule'));
		 }
		}
		 
		// exit;
		if($_POST['submit1']=='取消排班'){
			if(!$_POST['isCancel']) {
				js_alert('请选择需取消排班的缸',null,$this->_url('paigangSchedule'));
			}
			$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
			if($_POST['isCancel'])foreach($_POST['isCancel'] as $key=>$v){
				$gang = $m->find(array('id'=>$key));
				//如果是双染且
				$arr=array('id'=>$key);
				if($gang['markTwice']==1) {
					//如果分散未做，取消第一个班次
					if($gang['fensanOver']==0) {
						$arr['dateAssign'] = '0000-00-00';
						$arr['ranseBanci'] = '1';
						$arr['dateAssign1'] = '0000-00-00';
						$arr['ranseBanci1'] = '1';
						$arr['markTwice']=0;
					} elseif($gang['fensanOver']==1) {
						$arr['dateAssign1'] = '0000-00-00';
						$arr['ranseBanci1'] = '1';
					}
					//如果分散已做,取消第二个班次
				} else {
					$arr['markTwice'] = 0;//16-08-12 zcc 添加 
					$arr['dateAssign'] = '0000-00-00';
					$arr['ranseBanci'] = '1';
				}
				$m->update($arr);
			}
			//exit;
			js_alert('','',$this->_url('paigangSchedule'));
		}else{
			//dump($_POST);exit();
			if(!$_POST['isJihua']) {
				js_alert('请选择排缸号',null,$this->_url('paigangSchedule'));
			}
			if(!$_POST['dateAssign']){
				js_alert('请指定排班日期!',null,$this->_url('paigangSchedule'));
			}

			$found = false;
			$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
			$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
			if($_POST['isJihua'])foreach($_POST['isJihua'] as $key=>$v){
				$gang = $this->_modelPlan->find(array('id'=>$key));
				//判断是否存在化纤并且未设置双染工艺
				if ($gang['markTwice']==0 && $mWare->isHuaxian($gang['OrdWare']['wareId'])) {
					$found = true;
				}
				if($gang['markTwice']!=1) {//分散+套棉(mark=1)才需要染两次
					$rowset[]=array(
						'id'=>$key,
						'dateAssign'=>$_POST['dateAssign'],
						'ranseBanci'=>$_POST['ranseBanci'],
						'isJiaji'=>$_POST['isJiaji'][$key]=='on'?1:0
					);
				} else {//如果是双染
					//根据fensanOver判断是分散还是套棉工序
					if($gang['fensanOver']==0) {//说明是第一道工序
						//判断分散和套棉是否安排在同一班
						if($gang['dateAssign']==$gang['dateAssign1'] && $gang['ranseBanci']==$gang['ranseBanci1']) {
							$rowset[] = array(
								'id'=>$key,
								'dateAssign'=>$_POST['dateAssign'],
								'ranseBanci'=>$_POST['ranseBanci'],
								'dateAssign1'=>$_POST['dateAssign'],
								'ranseBanci1'=>$_POST['ranseBanci'],
								'isJiaji'=>$_POST['isJiaji'][$key]=='on'?1:0
							);
						} else $rowset[] = array(
							'id'=>$key,
							'dateAssign'=>$_POST['dateAssign'],
							'ranseBanci'=>$_POST['ranseBanci'],
							'isJiaji'=>$_POST['isJiaji'][$key]=='on'?1:0
						);
					}

					if($gang['fensanOver']==1) {//说明是第二道工序
						$rowset[] = array(
							'id'=>$key,
							'dateAssign1'=>$_POST['dateAssign'],
							'ranseBanci1'=>$_POST['ranseBanci'],
							'isJiaji'=>$_POST['isJiaji'][$key]=='on'?1:0
						);
					}
				}

			}
			// dump($_POST);dump($rowset);exit;
			$m->saveRowset($rowset);

			if ($found){
				js_alert('检测到有需要设置双染的化纤类棉纱,下面将进入双染设置界面!',null,$this->_url('SetTwice',array(
					'dateAssign'=>$_POST['dateAssign'],
					'ranseBanci'=>$_POST['ranseBanci'],
					'fromController'=>$_POST['fromController'],
					'fromAction'=>$_POST['fromAction']
				)));
				exit;
			}
			if($_POST['submit1']=='保存并返回'){
				js_alert('','',$this->_url($_POST['fromAction']?$_POST['fromAction']:'paigangSchedule'));
			}
			else{
				//$this->PrintJihua($rowset);
				redirect($this->_url('JihuaList1',array(
					'date'=>$_POST['dateAssign'],
					'bc'=>$_POST['ranseBanci']
				)));
			}
		}
	}

	#针对化纤类纱线进行双染工序设置
	function actionSetTwice(){
		$condition = array(
			'dateAssign'=>$_GET['dateAssign'],
			'ranseBanci'=>$_GET['ranseBanci'],
			'markTwice'=>0
		);
		//dump($condition);exit;
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$rowset = $this->_modelPlan->findAll($condition);
		$r = array();
		foreach($rowset as & $v) {
			if($mWare->isHuaxian($v['OrdWare']['wareId'])) {
				$v['Ware'] = $mWare->find(array('id'=>$v['OrdWare']['wareId']));
				$r[] = $v;
			}
		}
		//dump($r);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','染部日生产计划单');
		$smarty->assign('date_assign', $_GET['dateAssign']);
		$smarty->assign('arr_field_value', $r);
		$smarty->display('Plan/SetTwice.tpl');
	}
	#针对化纤类纱线进行双染工序设置
	function actionSetTwice1(){
		// $condition = array(
		// 	'dateAssign'=>$_GET['dateAssign'],
		// 	'ranseBanci'=>$_GET['ranseBanci'],
		// 	'markTwice'=>0
		// );
		//dump($condition);exit;
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$condition[] = "  id in ({$_GET['gangId']}) and markTwice = 0 ";
		$rowset = $this->_modelPlan->findAll($condition);
		$r = array();
		foreach($rowset as & $v) {
			if($mWare->isHuaxian($v['OrdWare']['wareId'])) {
				$v['Ware'] = $mWare->find(array('id'=>$v['OrdWare']['wareId']));
				$r[] = $v;
			}
		}
		//dump($r);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','染部日生产计划单');
		$smarty->assign('date_assign', $_GET['dateAssign']);
		$smarty->assign('arr_field_value', $r);
		$smarty->display('Plan/SetTwice.tpl');
	}
	function actionSetTwiceSave(){
		//dump($_POST);exit;
		for($i=0;$i<count($_POST['gangId']);$i++) {
			$gang = $this->_modelPlan->find(array('id'=>$_POST['gangId'][$i]));
			if($_POST['oneBanci'][$i] == 1 && $_POST['markTwice'][$i]==1) {//同一班做掉
				//dump($gang);exit;
				$rowset[] = array(
					'id'=>$_POST['gangId'][$i],
					'markTwice'=>$_POST['markTwice'][$i],
					'dateAssign1'=>$gang['dateAssign'],
					'ranseBanci1'=>$gang['ranseBanci']
				);
			} else $rowset[] = array(
				'id'=>$_POST['gangId'][$i],
				'markTwice'=>$_POST['markTwice'][$i]
			);
		}
		//dump($rowset);exit;
		if ($this->_modelPlan->updateRowset($rowset)) {
			if($_POST['Submit']=='完成并打印') {
				redirect($this->_url('JihuaList1',array(
					'date'=>$gang['dateAssign'],
					'bc'=>$gang['ranseBanci']
				)));
				exit;
			}
			redirect($this->_url('paigangSchedule'));exit;
		}
	}
	
	#排染计划打印
	function PrintJihua($row){
		//dump($row);exit;
		foreach($row as & $v){
			$id[]=$v['id'];
		}
		$idList=join(',',$id);
		$sql="select x.* ,y.orderLine
			from view_dye_gang x
			left join jichu_vat y on x.vatId = y.id
			where gangId in({$idList}) order by y.orderLine asc";
		$arr=$this->_modelExample->findBySql($sql);
		//dump($arr);exit();
		$m = & FLEA::getSingleton("Model_Plan_Dye_Gang");
		$modelGongyi = & FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		foreach($arr as & $v){
			#判断该缸是否有染色产量
			$str="select * from dye_rs_chanliang where gangId='{$v['gangId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			if($re){
				$v['isChanliang']=1;
				$v['dateInput']=$re['dateInput'];
			}
			$v['cntPlanTouliao']=round($v['cntPlanTouliao'],2);
			if($v['isJiaji']==1) $v['isJiaji'] = "√";
			else $v['isJiaji'] = "";
			$v['twiceStatu'] = '';
			if($v['markTwice']==1) {
				if($v['dateAssign']==$_GET['date'] && $v['ranseBanci']==$_GET['bc'] && $v['dateAssign1']==$_GET['date'] && $v['ranseBanci1']==$_GET['bc']) $v['twiceStatu'] = '分散+套棉';
				elseif($v['dateAssign']==$_GET['date'] && $v['ranseBanci']==$_GET['bc']) $v['twiceStatu'] = '分散';
				elseif($v['dateAssign1']==$_GET['date'] && $v['ranseBanci1']==$_GET['bc']) $v['twiceStatu'] = '套棉';
			}
			$v['cntTouliao']=$v['cntPlanTouliao'];
			if($v['ranseBanci']==1){
				$v['ranseBanci']='早班';
			}
			elseif ($v['ranseBanci']==2) {
				$v['ranseBanci'] = '晚班';
			}
			elseif ($v['ranseBanci']==3) {
				$v['ranseBanci'] = '早班1';
			}
			elseif ($v['ranseBanci']==4) {
				$v['ranseBanci'] = '早班2';
			}
			elseif ($v['ranseBanci']==5) {
				$v['ranseBanci'] = '早班3';
			}
			elseif ($v['ranseBanci']==6) {
				$v['ranseBanci'] = '晚班1';
			}
			elseif ($v['ranseBanci']==7) {
				$v['ranseBanci'] = '晚班2';
			}
			elseif ($v['ranseBanci']==8) {
				$v['ranseBanci'] = '晚班3';
			}
			$v['guige']=$v['wareName'].' '.$v['guige'];
			$gongyi = $modelGongyi->findByField('order2wareId',$v['order2wareId']);
			//dump($gongyi);
			$v['ranseKind']=$gongyi['ranseKind'];
			$v['employName']=$gongyi['Chufangren']['employName'];
		}
                //dump($arr);exit;
                $i=0;
                $arr1=array();
                foreach($arr as & $vv){
                    if($temp==$vv['vatCode']){
                        $arr1[]=$vv;
                    }
                    else{
                        /*if($i>0){
                            $arr1[]=array();
                        }*/
                        $temp=$vv['vatCode'];
                        $arr1[]=$vv;
                    }
                    $i++;
                }
		//$arr1[] = $this->getHeji($arr1,array('cntPlanTouliao'),'isJiaji');
		// dump($arr1);exit;
		$arr1=array_group_by($arr1,'binggangId');
		if($arr1)foreach($arr1 as $key=>& $v){
			if($key==0){
				foreach($arr1[$key] as & $vv){
					$vv['vatCode1'] = $vv['vatCode'];
					if($vv['isChanliang']==1)$vv['isJiaji']="<font color=red>".$vv['isJiaji']."</font>";
					if($vv['isChanliang']==1)$vv['vatCode']="<font color=red>".$vv['vatCode']."</font>";
					if($vv['isChanliang']==1)$vv['compName']="<font color=red>".$vv['compName']."</font>";
					if($vv['isChanliang']==1)$vv['colorNum']="<font color=red>".$vv['colorNum']."</font>";
					if($vv['isChanliang']==1)$vv['vatNum']="<font color=red>".$vv['vatNum']."</font>";
					if($vv['isChanliang']==1)$vv['guige']="<font color=red>".$vv['guige']."</font>";
					if($vv['isChanliang']==1)$vv['color']="<font color=red>".$vv['color']."</font>";
					if($vv['isChanliang']==1)$vv['cntPlanTouliao']="<font color=red>".$vv['cntPlanTouliao']."</font>";
					if($vv['isChanliang']==1)$vv['dateInput']="<font color=red>".$vv['dateInput']."</font>";
					if($vv['isChanliang']==1)$vv['ranseKind']="<font color=red>".$vv['ranseKind']."</font>";
					if($vv['isChanliang']==1)$vv['employName']="<font color=red>".$vv['employName']."</font>";
					if($vv['isChanliang']==1)$vv['memo']="<font color=red>".$vv['memo']."</font>";
					$kk[]=$vv;
				}
			}else{
				$str="select x.*,y.vatCode
					from plan_dye_gang_merge x
					left join jichu_vat y on y.id=x.vatId
					where x.id='{$key} '
				";
				//dump($str);
				$re=mysql_fetch_assoc(mysql_query($str));
				$vatCode=$compName=$orderCode=$vatNum=$guige=$color=$colorNum=$employName=$dateInput=$planDate=$cntPlanTouliao=$memo=$ranseKind='';
				$cntTouliao=0;
				foreach($arr1[$key] as & $vv){
					//dump($vv['dateInput']);
					//dump($vv);
					$compName.=($vv['isChanliang']==1?"<font color=red>".$vv['compName']."</font>":$vv['compName']).($vv['compName']==''?'':'<br>');
					$vatCode.=($vv['isChanliang']==1?"<font color=red>".$vv['vatCode']."</font>":$vv['vatCode']).($vv['vatCode']==''?'':'<br>');
					$vatNum.=($vv['isChanliang']==1?"<font color=red>".$vv['vatNum']."</font>":$vv['vatNum']).($vv['vatNum']==''?'':'<br>');
					$guige.=($vv['isChanliang']==1?"<font color=red>".$vv['guige']."</font>":$vv['guige']).($vv['guige']==''?'':'<br>');
					$color.=($vv['isChanliang']==1?"<font color=red>".$vv['color']."</font>":$vv['color']).($vv['color']==''?'':'<br>');
					$colorNum.=($vv['isChanliang']==1?"<font color=red>".$vv['colorNum']."</font>":$vv['colorNum']).'<br>';
					$planDate.=($vv['isChanliang']==1?"<font color=red>".$vv['planDate']."</font>":$vv['planDate']).($vv['planDate']==''?'':'<br>');
					$dateInput.=($vv['isChanliang']==1?"<font color=red>".$vv['dateInput']."</font>":$vv['dateInput']).($vv['dateInput']==''?'':'<br>');
					$cntPlanTouliao.=($vv['isChanliang']==1?"<font color=red>".$vv['cntPlanTouliao']."</font>":$vv['cntPlanTouliao']).($vv['cntPlanTouliao']==''?'':'<br>');
					$ranseKind.=($vv['isChanliang']==1?"<font color=red>".$vv['ranseKind']."</font>":$vv['ranseKind']).($vv['ranseKind']==''?'':'<br>');
					$employName.=($vv['isChanliang']==1?"<font color=red>".$vv['employName']."</font>":$vv['employName']).($vv['employName']==''?'':'<br>');
					$cntTouliao+=$vv['cntPlanTouliao'];
					$memo.=$vv['memo']!=''?($vv['isChanliang']==1?"<font color=red>".$vv['memo']."</font>":$vv['memo']).($vv['memo']==''?'':'<br>'):'';
					
				}
				if($re['isJiaji']==1) $re['isJiaji'] = "√";
				else $re['isJiaji']='';
				$mm=array(
					'isJiaji'=>$re['isJiaji'],
					'vatCode'=>$re['vatCode'],
					'vatCode1'=>$re['vatCode'],
					'vatNum'=>$vatNum,
					'compName'=>$compName,
					'guige'=>$guige,
					'color'=>$color,
					'colorNum'=>$colorNum,
					'employName'=>$employName,
					'cntPlanTouliao'=>$cntPlanTouliao,
					'dateInput'=>$dateInput,
					'cntTouliao'=>$cntTouliao,
					'ranseKind'=>$ranseKind,
					'memo'=>$memo
				);
				$kk[]=$mm;
			}
		}
		$kk1=array_group_by($kk,'vatCode1');//by zcc  因vatCode 中会存在变红的格式 估重新定义一个因vatCode1 来做分组判定
		//dump($kk1);exit();
		//ksort($kk1);// by zcc 键名排序  2017年4月18日 19:34:03 zcc 先注销然后
		// foreach ($kk1 as $key => $v) {
		// 	echo "$key";
		// }
		//uksort($kk1);
		//dump($kk1);exit();
		if(count($kk1)>0)foreach($kk1 as & $v){
			$cnt=count($v);
			foreach($v as $key=>& $vv){
				$kk2[]=$vv;
			}
			$kk2[]='';
			$kk2[]='';
			$kk2[]='';
			$kk2[]='';
		}

		$heji= $this->getHeji($kk2,array('cntTouliao'),'isJiaji');
		$heji['cntPlanTouliao']=$heji['cntTouliao'];
		$kk2[]=$heji;
		//删除合计上面得空格
		// $countZj = count($kk2)-1;
		// foreach ($kk2 as $key => &$vals) {
		// 	if($key==$countZj){
		// 		unset($kk2[$key-1]);
		// 		unset($kk2[$key-2]);
		// 		unset($kk2[$key-3]);
		// 	}
		// }
		//dump($kk2);exit();
		//dump($mm);exit;
        //dump($arr);exit;
		//dump($rowset[0]);exit;
		$arr_field_info=array(
			'isJiaji'=>'是否加急',
			'vatCode'=>'锅号',
			//'maxKg'=>'最大公斤数',
			//'dateAssign'=>'排染日期',
			//'ranseBanci'=>'班次',
			'compName'=>'客户',
			'colorNum'=>'色号',
			//'orderCode'=>'合同号',
			'vatNum'=>'缸号',
			'guige'=>'规格',
			'color'=>'颜色',
			'cntPlanTouliao'=>'计划投料',
			'dateInput'=>'染色产量日期',
			// 'ranseKind'=>'方式',
			// 'employName'=>'打样人',
			'ranseKind'=>'染色类别',
            'memo'=>'备 注'
			//'Order.dateJiaohuo'=>'交期',
			//'dateAssign'=>'染色计划时间',
			//'ranseBanci'=>'染色班次',
		);
		if($_GET['bc']==1){
            $bc = '白班';
		}elseif ($_GET['bc']==2) {
			$bc = '晚班';
		}elseif ($_GET['bc']==3) {
	        $bc = '白班1';
		}elseif ($_GET['bc']==4) {
	        $bc = '白班2';
		}elseif ($_GET['bc']==5) {
	        $bc = '白班3';
		}elseif ($_GET['bc']==6) {
	        $bc = '晚班1';
		}elseif ($_GET['bc']==7) {
	        $bc = '晚班2';
		}elseif ($_GET['bc']==8) {
	        $bc = '晚班3';
		}
		//dump($kk2);exit;
		//$kk2 = array_column_sort($kk2,'vatCode');
		$note="<font color=red>红色字体的为已经有染色产量的缸。</font>";
		$smarty=& $this->_getView();
		$smarty->assign('note',$note);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$kk2);
		$smarty->assign('arr_main_value',array(
			'排染日期'=>$_GET['date'],
			'班次'=>$bc
		));
		$smarty->assign('title','染色日计划安排');
		$smarty->display('Plan/Print.tpl');
	}
	#取消计划
	function actionCanelJihua(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$gang = $m->find(array('id'=>$_GET['id']));
		//如果是双染且
		$arr=array('id'=>$_GET['id']);
		if($gang['markTwice']==1) {
			//如果分散未做，取消第一个班次
			if($gang['fensanOver']==0) {
				$arr['dateAssign'] = '0000-00-00';
				$arr['ranseBanci'] = '1';
				$arr['dateAssign1'] = '0000-00-00';
				$arr['ranseBanci1'] = '1';
				$arr['markTwice']=0;
			} elseif($gang['fensanOver']==1) {
				$arr['dateAssign1'] = '0000-00-00';
				$arr['ranseBanci1'] = '1';
			}
			//如果分散已做,取消第二个班次
		} else {
			$arr['dateAssign'] = '0000-00-00';
			$arr['ranseBanci'] = '1';
		}
		$m->update($arr);
		js_alert('','',$this->_url('paigangSchedule'));
	}

	function actionJihuaList(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		FLEA::loadClass('TMIS_Pager');
		$arrG= TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
		));
		/*$condition[]=array('dateAssign','0000-00-00','>');
		//if($arrG['dateFrom']!='') $condition[]=array('dateAssign',$arrG['dateFrom'],'>=');
		//if($arrG['dateTo']!='') $condition[]=array('dateAssign',$arrG['dateTo'],'<=');
		$condition[] = "(dateAssign>='{$arrG['dateFrom']}' and dateAssign<='{$arrG['dateTo']}') or (dateAssign1>='{$arrG['dateFrom']}' and dateAssign1<='{$arrG['dateTo']}')";
		//dump($condition);
		$pager = & new TMIS_Pager($m,$condition);
		$arr=$pager->findAll();*/
		$str="select * from plan_dye_gang where dateAssign>'0000-00-00' and((dateAssign>='{$arrG['dateFrom']}' and dateAssign<='{$arrG['dateTo']}') or (dateAssign1>='{$arrG['dateFrom']}' and dateAssign1<='{$arrG['dateTo']}'))";

		$arr=$m->findBySql($str);
		//dump($arr);
		$starTime=$arrG['dateFrom'];$endTime=$arrG['dateTo'];
		foreach($arr as $v){
			if($v['dateAssign']>$endTime || $v['dateAssign1']>$endTime) {
				$endTime=$v['dateAssign']>$v['dateAssign1'] ? $v['dateAssign']: $v['dateAssign1'];
			}
			if($v['dateAssign']!='0000-00-00'&&$v['dateAssign']<$starTime || $v['dateAssign1']!='0000-00-00'&&$v['dateAssign1']<$starTime) {
				$starTime=$v['dateAssign']<$v['dateAssign1'] ? $v['dateAssign']: $v['dateAssign1'];
			}
		}
		//echo $starTime;exit;
		//时间差
		$days=round((strtotime(date($endTime))-strtotime(date($starTime)))/3600/24);
		
		//echo $days."__".$starTime."___".$endTime.'<br />';
		for($i=0;$i<=$days;$i++){
			$date=date('Y-m-d',strtotime($starTime.' +'.$i.' day'));
			//dump($date);
			foreach($arr as $v){
				//dump($v['dateAssign']);
				if($v['dateAssign']==$date||$v['dateAssign1']==$date){
					if($v['dateAssign']==$date&&$v['ranseBanci']==1||$v['dateAssign1']==$date&&$v['ranseBanci1']==1){
						$rowset[$date][0]="<span style='background:red;width:100px;'><a href='{$this->_url('JihuaList1',array('date'=>$date,'bc'=>'1'))}'>早班</a></span>";
					}
					if($v['dateAssign']==$date&&$v['ranseBanci']==3||$v['dateAssign1']==$date&&$v['ranseBanci1']==3){
						$rowset[$date][2]="<span style='background:red;width:100px;'><a href='{$this->_url('JihuaList1',array('date'=>$date,'bc'=>'3'))}'>早班1</a></span>";
					}
					if($v['dateAssign']==$date&&$v['ranseBanci']==4||$v['dateAssign1']==$date&&$v['ranseBanci1']==4){
						$rowset[$date][3]="<span style='background:red;width:100px;'><a href='{$this->_url('JihuaList1',array('date'=>$date,'bc'=>'4'))}'>早班2</a></span>";
					}
					if($v['dateAssign']==$date&&$v['ranseBanci']==5||$v['dateAssign1']==$date&&$v['ranseBanci1']==5){
						$rowset[$date][4]="<span style='background:red;width:100px;'><a href='{$this->_url('JihuaList1',array('date'=>$date,'bc'=>'5'))}'>晚班</a></span>";
					}
					if($v['dateAssign']==$date&&$v['ranseBanci']==2||$v['dateAssign1']==$date&&$v['ranseBanci1']==2){
						$rowset[$date][1]="<span style='background:red;width:100px;'><a href='{$this->_url('JihuaList1',array('date'=>$date,'bc'=>'2'))}'>晚班</a></span>";
					}
					if($v['dateAssign']==$date&&$v['ranseBanci']==6||$v['dateAssign1']==$date&&$v['ranseBanci1']==6){
						$rowset[$date][5]="<span style='background:red;width:100px;'><a href='{$this->_url('JihuaList1',array('date'=>$date,'bc'=>'6'))}'>晚班1</a></span>";
					}
					if($v['dateAssign']==$date&&$v['ranseBanci']==7||$v['dateAssign1']==$date&&$v['ranseBanci1']==7){
						$rowset[$date][6]="<span style='background:red;width:100px;'><a href='{$this->_url('JihuaList1',array('date'=>$date,'bc'=>'7'))}'>晚班2</a></span>";
					}
					if($v['dateAssign']==$date&&$v['ranseBanci']==8||$v['dateAssign1']==$date&&$v['ranseBanci1']==8){
						$rowset[$date][7]="<span style='background:red;width:100px;'><a href='{$this->_url('JihuaList1',array('date'=>$date,'bc'=>'8'))}'>晚班3</a></span>";
					}
					if(isset($rowset[$date][0]) && isset($rowset[$date][1]) && isset($rowset[$date][2]) && isset($rowset[$date][3]) && isset($rowset[$date][4]) && isset($rowset[$date][5]) && isset($rowset[$date][6]) && isset($rowset[$date][7])){
						break;
					}
					continue;
				}
			}
			if(!isset($rowset[$date][0])){
				$rowset[$date][0]="早班";
			}
			if(!isset($rowset[$date][2])){
				$rowset[$date][2]="早班1";
			}
			if(!isset($rowset[$date][3])){
				$rowset[$date][3]="早班2";
			}
			if(!isset($rowset[$date][4])){
				$rowset[$date][4]="早班3";
			}
			if(!isset($rowset[$date][1])){
				$rowset[$date][1]="晚班";
			}
			if(!isset($rowset[$date][5])){
				$rowset[$date][5]="晚班1";
			}
			if(!isset($rowset[$date][6])){
				$rowset[$date][6]="晚班2";
			}
			if(!isset($rowset[$date][7])){
				$rowset[$date][7]="晚班3";
			}
		}
		//dump($rowset);
		foreach($rowset as $key=> $v){
			$temp['date']=$key;
			$temp['zb']=$v[0];
			$temp['zb1']=$v[2];
			$temp['zb2']=$v[3];
			$temp['zb3']=$v[4];
			$temp['wb']=$v[1];
			$temp['wb1']=$v[5];
			$temp['wb2']=$v[6];
			$temp['wb3']=$v[7];
			if($temp['date']=='1970-01-01'){
				continue;
			}
			else{
				$row[]=$temp;
			}
		}
		//dump($row);
		$arr_field_info=array(
			'date'=>'日期',
			'zb'=>'早班',
            'zb1'=>'早班1',
            'zb2'=>'早班2',
            'zb3'=>'早班3',
			'wb'=>'晚班',
			'wb1'=>'晚班1',
			'wb2'=>'晚班2',
			'wb3'=>'晚班3',
		);
		$smarty=& $this->_getView();
		$smarty->assign('title','染色计划查询');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_condition',$arrG);
		$smarty->assign('add_display','none');
		$smarty->assign('page_info','<font color="red">红色表示已有排班记录</font>');
		$smarty->assign('arr_field_value',$row);
		$smarty->display('tableList.tpl');

	}
	#某天早，晚班查询
	function actionJihuaList1(){
		// dump($_GET);die;
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr=$m->findAll(array(
			"(dateAssign='{$_GET['date']}' and ranseBanci='{$_GET['bc']}') or (dateAssign1='{$_GET['date']}' and ranseBanci1='{$_GET['bc']}')"
		),'isJiaji desc');
		// dump(array_col_values($arr,'isJiaji'));exit;
		$this->PrintJihua($arr);exit;

	}
	function actionFanXiu(){
		FLEA::loadClass('TMIS_Pager');
		$arr= TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-1'),
			'dateTo'=>date('Y-m-d'),
		));
		$condition[] = array(dateFanxiu,$arr[dateFrom], '>=');
		$condition[] = array(dateFanxiu, $arr[dateTo], '<=');
		$this->_mFanxiu=  & FLEA::getSingleton('Model_Plan_Dye_FanXiu');
		$pager =& new TMIS_Pager($this->_mFanxiu,$condition);
		$rowset =$pager->findAll();
		foreach($rowset as & $v){
			$v['cnt']=$v['cntByGongyi']+$v['cntByRanse'];
			$v['rate']= round($v['cnt']/$v['cntTotal']*100,2);
			$v['_edit'] = "<a href='".$this->_url('SetFanxiu',array(
				'id'=>$v['id']
			))."'>修改</a> | <a href='".$this->_url('RemoveFanxiu',array(
				'id'=>$v['id']
			))."' onclick='return confirm(\"您确认要删除吗?\")'>删除</a>";
		}
		$heji = $this->getHeji($rowset,array('cntTotal','cntByGongyi','cntByRanse','cnt'),'dateFanxiu');
		$heji['rate'] = $heji['cntTotal']>0 ? round($heji['cnt']/$heji['cntTotal']*100,2) : '';
		$rowset[] = $heji;
		$arr_field_info=array(
			'dateFanxiu'=>'日期',
			'cntTotal'=>'生产总数',
			'cntByGongyi'=>'工艺返修',
			'cntByRanse'=>'染色返修',
			'cnt'=>'总返修',
			'rate'=>'返修率%',
			'memo'=>'返修说明',
			'_edit'=>'操作',
		);
		$smarty=& $this->_getView();//$add_url
		$smarty->assign('title','返修登记');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_url','SetFanxiu');
		$smarty->display('tableList.tpl');
	}
	function actionSetFanxiu(){
		if($_GET['id']>0) {
			$m = & FLEA::getSingleton('Model_Plan_Dye_Fanxiu');
			$arr = $m->find(array('id'=>$_GET['id']));
		}
		$smarty = & $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Plan/SetFanxiu.tpl');
	}
	function actionSaveFanxiu(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Fanxiu');
		if($m->save($_POST)) {
			js_alert('登记成功!',null,$this->_url('fanxiu'));
			exit;
		};
	}
	function actionRemoveFanxiu(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Fanxiu');
		if($m->removeByPkv($_GET['id'])) {
			js_alert('删除成功!',null,$this->_url('fanxiu'));
			exit;
		};
	}
	/**
	 * ps ：打印条码
	 * Time：2017/09/05 16:27:31
	 * @author zcc
	*/
	function actionPrintTzCodeList(){
		$sql = "SELECT * from view_dye_gang where gangId = '{$_GET['id']}'";
		$row = $this->_modelExample->findBySql($sql);
		$arr = array(
			'wareName'=>$row[0]['wareName'],
			'colorNum'=>$row[0]['colorNum'],
			'vatNum' =>$row[0]['vatNum'],
			'printCnt' =>$row[0]['planTongzi']//打印的个数等于计划筒子数
		);
		$smarty = & $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Plan/PrintTzCode.tpl');
	}
	/**
	 * ps ：打印排缸卡
	 * Time：2017年10月24日 12:43:35
	 * @author zcc
	*/
	function actionPrintPaiGang(){
		$sql = "SELECT x.*,y.pihao,y.memo as View
			from view_dye_gang x
			left join trade_dye_order2ware y on x.order2wareId = y.id
			where gangId = '{$_GET['id']}'";
		$row = $this->_modelExample->findBySql($sql);
		foreach ($row as $key => &$value) {
			$sql = "select cengCnt from jichu_vat2shuirong where id='{$value['vat2shuirongId']}'";
			$fenceng = $this->_modelExample->findBySql($sql);
			$value['fenceng'] = $fenceng[0]['cengCnt'];
		}
		//整理所需求的字段
		$arr = array(
			'compName' => $row[0]['compName'],//客户名称
			'vatCode' => $row[0]['vatCode'],//物理缸号 对应页面显示机号
			'color' => $row[0]['color'],
			'pihao' => $row[0]['pihao'],
			'colorNum' =>$row[0]['colorNum'],//色号
			'wareName' => $row[0]['wareName'].' '.$row[0]['guige'],//纱支名称 + 规格
			'planTongzi' => $row[0]['planTongzi'],//只数
			'cntPlanTouliao' => $row[0]['cntPlanTouliao'],//重量
			'sunJkg' => round($row[0]['cntPlanTouliao']*$row[0]['zhelv'],2),//损重
			'memo' => $row[0]['View'].'',
			'vatNum' => $row[0]['vatNum'],
			'fenceng' => $row[0]['fenceng'],
		);
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mGang->addTimesPrintPg($_GET['id']);//数据库 中排杠卡打印次数+1
		$smarty = & $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display('Plan/PrintPaiGang.tpl');
	}
	/**
	 * ps ：ajax保存新缸号
	 * Time：2017年11月3日 10:21:02
	 * @author zcc
	*/
	function actionSetVatNumBc(){
		$sql = "update plan_dye_gang set vatNum='{$_POST['value']}',vatNumBc='{$_POST['valueOld']}' where id = '{$_POST['id']}'";
		$id = $this->_modelExample->execute($sql);
		if ($id) {
			echo json_encode(array(
				'sucess'=>true,
			));
		}else{
			echo json_encode(array(
				'sucess'=>false,
			));
		}
		exit;
	}
}
?>
