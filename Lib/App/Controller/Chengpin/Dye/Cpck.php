<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chengpin_Dye_Cpck extends Tmis_Controller {
	var $_modelExample;
	var $funcId;
	function Controller_Chengpin_Dye_Cpck() {
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelExample = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$this->_modelClient = & FLEA::getSingleton('Model_JiChu_Client');
		$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
	}

	#列表
	function actionRight() {
		//$this->funcId = 75;				//成品-出库-查询
		$this->authCheck($this->funcId);
		//$table = $this->_modelExample->tableName;
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),date('d')-30,date("Y"))),
			dateTo=>date("Y-m-d"),
			clientId=>0,
			vatNum=>'',
			zhishu=>'',
			'color'=>'',
			isReport=>0
		));
		//if ($arr[isReport]==1) $arr['clientId'] = $_POST[clientId]?$_POST[clientId]:$_GET[clientId];
		$str = "select
			x.*,
			y.compName,y.orderCode,y.vatNum,y.wareName,y.guige,y.color,y.vatCode,y.cntPlanTouliao,y.orderId,y.order2wareId,
			concat(y.guige,' ',y.wareName) as zhishu,y.clientId
			from chengpin_dye_cpck x
			inner join view_dye_gang y on x.planId=y.gangId
			where ";

		$condition=array();
		if ($arr[dateFrom]) {
			//echo($arr[dateTo]);
			$condition[] = "date(x.dateCpck)>='$arr[dateFrom]'";
			$condition[] = "date(x.dateCpck)<='$arr[dateTo]'";
		}
		if ($arr[vatNum]!='') {
			$condition[] = "y.vatNum like '%$arr[vatNum]%'";
		}
		//if ($arr[zhishu]!='') $condition[] = "y.guige like '%$arr[zhishu]%'";
		if ($arr['color']!='') $condition[] = "y.color like '%$arr[color]%'";
		if ($arr['clientId']>0) $condition[] = "y.clientId='$arr[clientId]'";
		// $condition[] = "x.kind = 0 ";
		$str .= join(" and ",$condition);
		$str .= " order by dt DESC";
		//重新构造一个sql 让zhushu 能进行搜索
		$sql = "select * from ($str) as a where 1";
		if ($arr[zhishu]!='') $sql .= " and a.zhishu like '%$arr[zhishu]%'";
		//echo $str;
		$pager =& new TMIS_Pager($sql,null,null,200);
		$rowset = $pager->findAllBySql($sql);
		//dump($rowset[0]);
		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		foreach($rowset as & $value) {
			$sqlp = "SELECT paymentWay FROM trade_dye_order where id='{$value['orderId']}'";
			$paym = $this->_modelExample->findBySql($sqlp);
			$value['paymentWay'] = $paym[0]['paymentWay'];
            $rowOrder2Ware = $modelOrder2Ware->findByField('id', $value['order2wareId']);
            $value['danjia'] = $rowOrder2Ware['danjia'];
            $value['moneys'] = $rowOrder2Ware['money'];
            if($value['paymentWay']==0){
            	if($value['danjia']>0){
            	   $value['money'] = round($value['cntPlanTouliao']*$value['danjia'],2);
            	}else{
            	   $value['money'] = round($value['moneys'],2);
            	}
            	//获取这个出库的 第一条数据
				$sql = "SELECT * 
					FROM chengpin_dye_cpck  
					where planId= '{$value['planId']}' order by id asc limit 0,1";
				$cpck = $this->_modelExample->findBySql($sql);
				if ($cpck[0]['id'] != $value['id']) {//当本条数据不等于第一条出库数据时
					$value['money'] = ''; //让金额为空数据
				}     	
            }
            if ($value['paymentWay']=='1') {//净重
				if ($value['danjia']>0) {
					$value['money'] = round($value['jingKg']*$value['danjia'],2);
				}else{
					$value['money'] = round($value['moneys'],2);
				}
			}
			if ($value['paymentWay']=='2') {//折率净重
				if ($value['danjia']>0) {
					$value['money'] = round($value['jingKgZ']*$value['danjia'],2);
				}else{
					$value['money'] = round($value['moneys'],2);
				}		
			}
		    $sql = "select count(*) cnt from chengpin_blog2cpck where cpckId={$value['id']}";
		    $re = mysql_fetch_assoc(mysql_query($sql));
		    if($re['cnt']>0) {
			$value['_bgColor'] ='#cccccc';
		    }
			//dump($value);
			$tTouliao += $value[cntPlanTouliao];
			$jingKg += $value[jingKg];
			$jingKgZ += $value[jingKgZ];
			$cntChuku += $value[cntChuku];
			$cntJian += $value[cntJian];
			$cntTongzi += $value[cntTongzi];
			$money += $value[money];
			$value[guige] =$value[guige]." ".$value[wareName];
			//dump($value[guige]);exit;
			$value[orderCode]=$this->_modelOrder->getOrderTrack($value[orderId],$value[orderCode]);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$value['orderId']));
			if($clientCode['orderCode2']!='') $value['compName']=$value['compName'].'('.$clientCode['orderCode2'].')';
		}
		//dump($rowset[0]);
		$i = count($rowset);
		$rowset[$i][dateCpck]="<b>合计</b>";
		$rowset[$i][cntPlanTouliao] = "<b>$tTouliao</b>";
		$rowset[$i][jingKg] ="<b>$jingKg</b>";
		$rowset[$i][jingKgZ] ="<b>$jingKgZ</b>";
		$rowset[$i][cntChuku] ="<b>$cntChuku</b>";
		$rowset[$i][cntJian] ="<b>$cntJian</b>";
		$rowset[$i][cntTongzi] ="<b>$cntTongzi</b>";
		$rowset[$i][money] ="<b>$money</b>";
		//dump($rowset[0]);
		//dump($rowset[$i]);
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"dateCpck" =>"出库日期",
			'compName' => '客户(客户单号)',
			"orderCode" =>"定单号",
			"vatNum" =>"缸号",
			"guige" => "规格",
			"color" =>"颜色",
			"vatCode" =>"物理缸号",
			"cntPlanTouliao" =>"投料数",
			'cntChuku'=>'本次发货',
			"jingKg"=>"净重",
			"jingKgZ"=>"计价重量",
			"cntJian"=>"件数",
			"cntTongzi"=>"筒子数",
			"danjia"=>"单价",
			"money"=>"金额",
			"dt"=>"创建时间"
		);
		if ($arr[isReport]!=1) $arrEditInfo = array("edit" =>"修改", "remove" =>"删除");

		$smarty->assign('title','筒染成品出库');
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('isClient',1);//是否显示客户不同 1 为是 0 为否
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		if ($arr[isReport]!=1) $smarty->display('Chengpin/Dye/CpckManage.tpl');
		else $smarty->display('TableList.tpl');
	}

	function actionRightMx2() {
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
		));
		//if ($arr[isReport]==1) $arr['clientId'] = $_POST[clientId]?$_POST[clientId]:$_GET[clientId];
		$str = "select
			x.*,
			y.compName,y.orderCode,y.vatNum,y.wareName,y.guige,y.color,y.vatCode,y.cntPlanTouliao,y.orderId,
			concat(y.guige,' ',y.wareName) as zhishu
			from chengpin_dye_cpck x
			inner join view_dye_gang y on x.planId=y.gangId
			where ";

		$condition=array();

		$condition[] = "date(x.dateCpck)>='$_GET[dateFrom]'";
		$condition[] = "date(x.dateCpck)<='$_GET[dateTo]'";
		
		if ($_GET['clientId']>0) $condition[] = "y.clientId='$_GET[clientId]'";
		if ($_GET['wareId']>0) $condition[] = "y.wareId='$_GET[wareId]'";
		$str .= join(" and ",$condition);
		$str .= " order by dt DESC";
		//重新构造一个sql 让zhushu 能进行搜索
		$sql = "select * from ($str) as a where 1";
		if ($arr[zhishu]!='') $sql .= " and a.zhishu like '%$arr[zhishu]%'";
		//echo $str;
		$pager =& new TMIS_Pager($sql,null,null,200);
		$rowset = $pager->findAllBySql($sql);
		//dump($rowset[0]);
		foreach($rowset as & $value) {
		    $sql = "select count(*) cnt from chengpin_blog2cpck where cpckId={$value['id']}";
		    $re = mysql_fetch_assoc(mysql_query($sql));
		    if($re['cnt']>0) {
			$value['_bgColor'] ='#cccccc';
		    }
			//dump($value);
			$tTouliao += $value[cntPlanTouliao];
			$jingKg += $value[jingKg];
			$cntChuku += $value[cntChuku];
			$cntJian += $value[cntJian];
			$cntTongzi += $value[cntTongzi];
			$value[guige] =$value[guige]." ".$value[wareName];
			//dump($value[guige]);exit;
			$value[orderCode]=$this->_modelOrder->getOrderTrack($value[orderId],$value[orderCode]);
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$value['orderId']));
			if($clientCode['orderCode2']!='') $value['compName']=$value['compName'].'('.$clientCode['orderCode2'].')';
		}
		//dump($rowset[0]);
		$i = count($rowset);
		$rowset[$i][dateCpck]="<b>合计</b>";
		$rowset[$i][cntPlanTouliao] = "<b>$tTouliao</b>";
		$rowset[$i][jingKg] ="<b>$jingKg</b>";
		$rowset[$i][cntChuku] ="<b>$cntChuku</b>";
		$rowset[$i][cntJian] ="<b>$cntJian</b>";
		$rowset[$i][cntTongzi] ="<b>$cntTongzi</b>";
		//dump($rowset[0]);
		//dump($rowset[$i]);
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"dateCpck" =>"出库日期",
			'compName' => '客户(客户单号)',
			"orderCode" =>"定单号",
			"vatNum" =>"缸号",
			"guige" => "规格",
			"color" =>"颜色",
			"vatCode" =>"物理缸号",
			"cntPlanTouliao" =>"投料数",
			'cntChuku'=>'本次发货',
			"jingKg"=>"净重",
			"cntJian"=>"件数",
			"cntTongzi"=>"筒子数",
			//"dt"=>"创建时间"
		);
		$smarty->assign('title','筒染成品出库');
		$smarty->assign('nav_display','none');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		//$smarty->assign('arr_condition',$arr);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList.tpl');
	}
	#成品发货日报表
	function actionDayReport() {
		//$this->funcId = 75;				//成品-出库-查询
		//$this->authCheck($this->funcId);
		//$table = $this->_modelExample->tableName;
                //dump($_POST);exit;
		$compName=& FLEA::getAppInf('compName');
		$title = $compName."成品出库报表";
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date("Y-m-d"),
			'dateTo'=>date("Y-m-d"),
			'clientId'=>'',
			'guige'=>'',
			'orderKind'=>'',
			'memo'=>''
		));
		//if ($arr[isReport]==1) $arr['clientId'] = $_POST[clientId]?$_POST[clientId]:$_GET[clientId];
		$str = "select
			x.*,
			y.compName,y.orderCode,y.vatNum,y.wareName,y.guige,y.color,y.vatCode,y.cntPlanTouliao,y.orderId,y.parentGangId
			from chengpin_dye_cpck x
			inner join view_dye_gang y on x.planId=y.gangId
			left join trade_dye_order o on o.id = y.orderId
			where ";

		$condition=array();
		if ($arr[dateFrom]!=''||$arr[dateTo]!='') {
			//echo($arr[dateTo]);
			$condition[] = "date(x.dateCpck)>='$arr[dateFrom]'";
			$condition[] = "date(x.dateCpck)<='$arr[dateTo]'";
		}
        if($arr['clientId']){
          $condition[] = "y.clientId='$arr[clientId]'";
        }
         if($arr[guige]){// by zcc  由于规格是由guige+wareName 拼接而成
             $condition[] = "(y.guige like '%{$arr[guige]}%' or  y.wareName like '%{$arr[guige]}%' ) ";
        }
        if ($arr[orderKind]!='') {
        	$condition[] = "o.kind = '$arr[orderKind]'";
        }
		$str .= join(" and ",$condition);
		if($arr['memo']!='')$str.=" and x.memo like '%{$arr['memo']}%'";
		$str .= " order by vatNum,dt DESC";
		//echo $str;exit;
		//$pager =& new TMIS_Pager($str,null,null,400);
		//dump($str);exit();
		$rowset = $this->_modelExample->findBySql($str);
		$preVatnum='';
		$arrTouliao = array();
		foreach($rowset as & $value) {
			//入库数
			$sqlRk = "select sum(jingKg) as jingKgRk from chengpin_dye_cprk where planId='{$value['planId']}'";
            $rk = $this->_modelExample->findBySql($sqlRk);
            $value['jingKgRk'] = $rk[0]['jingKgRk'];
            $value['zhichenglv'] = round($value['jingKgRk']/$value['cntPlanTouliao']*100,2);
            if($value['zhichenglv']<93||$value['zhichenglv']>100){
            	$value['zhichenglv'] = "<p style='color:red'>{$value['zhichenglv']}"."%</p>";
            }else{
            	$value['zhichenglv'] = $value['zhichenglv'].'%';
            }
			$jingKg += $value[jingKg];
			$maoKg += $value[maoKg];
			$jingKgZ += $value[jingKgZ];
			$cntChuku += $value[cntChuku];
			$cntJian += $value[cntJian];
			$cntTongzi += $value[cntTongzi];
			$value[guige] =$value[guige]." ".$value[wareName];
			$value[orderCode]=$this->_modelOrder->getOrderTrack($value[orderId],$value[orderCode]);
			if ($value['vatNum']) {
				$sql = "SELECT * FROM plan_dye_gang WHERE id = '{$value['planId']}'";
				$Gang = $this->_modelExample->findBySql($sql);
				$value['isHuixiuCk'] = $Gang[0]['isHuixiuCk'];
				//获取这个出库的 第一条数据
				$sql = "SELECT * 
					FROM chengpin_dye_cpck  
					where planId= '{$value['planId']}' order by id asc limit 0,1";
				$cpck = $this->_modelExample->findBySql($sql);
				if ($cpck[0]['id'] != $value['id']) {//当本条数据不等于第一条出库数据时 投料不进行叠加合计
					$arrTouliao[$value['vatNum']] += 0;//防止之后出库的数据最后执行 导致值为0 然后+=0
					$value['_bgColor']= 'pink';
					// continue;
				}else{
					$arrTouliao[$value['vatNum']] = $value['cntPlanTouliao'];

					//判断为回修缸号 退库回修缸号也不进行投料数叠加
					//未出库整缸回修 进行投料数叠加
					if ($value['parentGangId']>0) { 
						if ($value['isHuixiuCk']==1) {//未出库整缸回修
							$arrTouliao[$value['vatNum']] = $value['cntPlanTouliao'];
						}else{//退库回修缸号
							$arrTouliao[$value['vatNum']] = 0;
						}
					}
				}
				

			}
			//if($value['vatNum']!=$preVatnum) {
				//$tTouliao += $value[cntPlanTouliao];
				//$preVatnum = $value['vatNum'];
			//}
			//$tTouliao += $value[cntPlanTouliao];
			
			//dump($value[guige]);exit;
		}
		//by zcc 客户需求 每缸投料数只算一次 由于会一个缸分批出库 这样就会出现多条缸投料 然后合计就会增多 2017年9月7日
		$TouliaoHj ='';
		foreach ($arrTouliao as &$v) {
			$TouliaoHj+=$v;
		}
		//dump($rowset[0]);
		$i = count($rowset);
		$rowset[$i][dateCpck]="<b>合计</b>";
		$rowset[$i][cntPlanTouliao] = "<b>$TouliaoHj</b>";
		$rowset[$i][jingKg] ="<b>$jingKg</b>";
		$rowset[$i][maoKg] ="<b>$maoKg</b>";
		$rowset[$i][jingKgZ] ="<b>$jingKgZ</b>";
		$rowset[$i][cntChuku] ="<b>$cntChuku</b>";
		$rowset[$i][cntJian] ="<b>$cntJian</b>";
		$rowset[$i][cntTongzi] ="<b>$cntTongzi</b>";
		//dump($rowset[0]);
		//dump($rowset[$i]);
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"dateCpck" =>"出库日期",
			'compName' => '客户',
			//"orderCode" =>"定单号",
			"vatNum" =>"缸号",
			"guige" => "规格",
			"color" =>"颜色",
			//"vatCode" =>"物理缸号",
			"cntPlanTouliao" =>"每缸投料数KG",
			//'cntChuku'=>'本次发货',
			"jingKg"=>"净重",
			"maoKg"=>"毛重",
			"jingKgZ"=>"计价重",
			"cntTongzi"=>"筒子数",
			"cntJian"=>"件数",
			//"jingKgRk"=>"入库数",
			"zhichenglv"=>"制成率",
			'memo'=>'备注'
			
		);
		if ($arr[isReport]!=1) $arrEditInfo = array("edit" =>"修改", "remove" =>"删除");
		$smarty->assign('arr_main_value',array(
			//'日期'=>$arr['dateFrom'],
			'当前用户'=>$_SESSION['REALNAME']
		));
		$smarty->assign('title',$title);
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		//$smarty->assign('other_button',);
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		//if ($arr[isReport]!=1) $smarty->display('Chengpin/Dye/CpckManage.tpl');
		//$smarty->assign('other_button','<input type="button" name="button" id="button" value="重新选择日期" onclick="window.location.href='."'".$this->_url('setDay')."'".'"/>' . ($cntChuku>0 ? (' 制成率：'.round($jingKg/$cntChuku,2)) : ''));
		$smarty->display('Chengpin/Dye/Print.tpl');
	}

	function actionSetDay(){

		$smarty = $this->_getView();
		$smarty->assign('title','成品出库日报表设置日期');
		$smarty->display('Chengpin/Dye/Setday.tpl');
	}
	//成品出库向导模式
	//第一步:列出缸号
	function actionAddGuide() {
		//echo(date("Y-m-d h-s-i"));
		//$this->authCheck(71);

		//显示某客户下已计划的缸，和计划投料数,计划筒子数,输入净重，筒子数，和件数,需要把计划投料数copy到出库表中
		//作为应收款凭据。

		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId=>'',
			vatNum=>'',
			orderCode=>''
		));
		$condition=array(
			"planDate >= '$arr[dateFrom]'",
			"planDate <= '$arr[dateTo]'"
			//"clientId = '$arr[clientId]'"
		);
		if ($arr['clientId']!='') $condition[] ="clientId='$arr[clientId]'";
		if ($arr['vatNum']!='') $condition[] ="vatNum like '%$arr[vatNum]%'";
		if ($arr['orderCode']!='') $condition[]="orderCode like '%$arr[orderCode]%'";
		// $condition[] = "parentGangId <= 0";
		//dump($condition);
		$pager=null;
		//if ($arr['clientId']!=''||$arr[vatNum]!='')
		// $rowset=$this->_modelGang->findAllGang1($condition,$pager,400);
		
		// by zcc 2017年12月29日 10:26:08 重构sql（针对未出库整缸回修问题 整缸回修的原缸号不能出库故隐藏）
		$sql = "SELECT
				x.*
			FROM
				view_dye_gang x 
			WHERE 1
			AND NOT EXISTS(SELECT * FROM plan_dye_gang a WHERE a.parentGangId = x.gangId AND a.isHuixiuCk=1)";	
		if ($arr[dateFrom]) {
			$sql .=" AND x.planDate >= '$arr[dateFrom]' AND x.planDate <= '$arr[dateTo]'";
		}	
		if ($arr['clientId']!='') $sql .=" and x.clientId='$arr[clientId]'";
		if ($arr['vatNum']!='') $sql .=" and x.vatNum like '%$arr[vatNum]%'";
		if ($arr['orderCode']!='') $sql .=" and x.orderCode like '%$arr[orderCode]%'";
		$sql .= " ORDER BY x.gangId DESC ";
		$pager = new TMIS_Pager($sql,null,null,400);
		$rowset = $pager->findAllBySql($sql);
		if(count($rowset)>0) foreach($rowset as & $v) {
			$v[guige]=$v[wareName]." ".$v[guige];
			//$v[jingKg] = "<input name='jingKg' id='jingKg' size=6 style='width:50' onBlur='aa(this)'>";
			//$v[cntTongzi] = "<input name='cntTongzi' id='cntTongzi' style='width:50' onBlur='aa(this)'>";
			//$v[cntJian] = "<input name='cntJian' id='cntJian' size=6 style='width:50' onBlur='aa(this)'>";
			//$v[_edit]= "<input type=button value='入库' disabled='true' name='btnCk' onclick='subm($v[gangId],this)'>";
			$v[cntChuku] = $this->_modelGang->getCpckChanliang($v[gangId]);
			$v[_edit]="<a href='".$this->_url('AddGuide1',array(
				//gangId=>$v[gangId]
				orderId=>$v[orderId]
				//ordwarId=>$v[order2wareId]
			))."'>出库</a>";
		    //得到客户单号
		    $clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
		    if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
		}
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
			cntChuku => '已出库',
			//jingKg=>'净重',
			//cntTongzi=>'筒子数',
			//cntJian=>'件数',
			//cntOut => '已入库',
			_edit => '操作'
		);
		// dump($rowset);die;
		$smarty = & $this->_getView();
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		if ($pager!=null) $smarty->assign('page_info',$pager->getNavBar($this->_url('addGuide',$arr)));
		$smarty->assign('arr_condition',$arr);
		//$smarty->display(Chengpin/Dye/CprkList.tpl
		//echo 'adsf';
		$smarty->display('TableList.tpl');
		//可以给不同的order出库在同一张订单上使用到框架，下面只是显示待选择的缸。
		//编辑界面需要调用actionAddGuide2()
		//$smarty->display('Chengpin/Dye/CpckNew.tpl');
	}

	//用iframe增加成品入库的编辑界面与addguide3搭配使用
	function actionAddGuide2() {
            //dump($_POST);exit;
		$smarty = & $this->_getView();
		$smarty->assign('dateCpck',date("Y-m-d"));
		$smarty->display('Chengpin/Dye/CpckNewBottom.tpl');
	}

	function actionAddGuide3() {
		//$this->authCheck(71);

		//显示某客户下已计划的缸，和计划投料数,计划筒子数,输入净重，筒子数，和件数,需要把计划投料数copy到出库表中
		//作为应收款凭据。
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			vatNum		=>'',
			clientId	=>'',
			cntPlanTouliao=>'',
			dateFrom	=>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			dateTo		=>date("Y-m-d"),
			orderCode	=>''
		));
		// $condition=array(
		// 	"planDate >= '$arr[dateFrom]'",
		// 	"planDate <= '$arr[dateTo]'"
		// 	//"clientId = '$arr[clientId]'"
		// );
		// if ($arr['clientId']!='') $condition[] ="clientId='$arr[clientId]'";
		// if ($arr[vatNum]!='') $condition[] ="vatNum like '%$arr[vatNum]%'";
		// if ($arr[orderCode]!='') $condition[]="orderCode like '%$arr[orderCode]%'";
		// if ($arr['cntPlanTouliao']!='') $condition[] ="cntPlanTouliao={$arr['cntPlanTouliao']}";

		// //dump($condition);
		// $pager=null;
		// if ($arr['clientId']!=''||$arr[vatNum]!=''||$arr[orderCode]!='') {
		// 	//$condition[] = "gangId not in (select parentGangId from plan_dye_gang)";
		// 	// $condition[] = "parentGangId <= 0";
		// 	$rowset=$this->_modelGang->findAllGang1($condition,$pager,400);
		// }
		// by zcc 2017年12月29日 10:26:08 重构sql（针对未出库整缸回修问题 整缸回修的原缸号不能出库故隐藏）
		$sql = "SELECT
				x.*
			FROM
				view_dye_gang x 
			WHERE 1
			";	
		if ($arr[dateFrom]) {
			$sql .=" AND x.planDate >= '$arr[dateFrom]' AND x.planDate <= '$arr[dateTo]'";
		}	
		if ($arr['clientId']!='') $sql .=" and x.clientId='$arr[clientId]'";
		if ($arr['vatNum']!='') $sql .=" and x.vatNum like '%$arr[vatNum]%'";
		if ($arr['orderCode']!='') $sql .=" and x.orderCode like '%$arr[orderCode]%'";
		if ($arr['cntPlanTouliao']!='') $condition[] ="cntPlanTouliao={$arr['cntPlanTouliao']}";
		$sql .=" AND NOT EXISTS(SELECT * FROM plan_dye_gang a WHERE a.parentGangId = x.gangId AND a.isHuixiuCk=1)";
		$sql .= " ORDER BY x.gangId DESC ";
		if ($arr['clientId']!=''||$arr[vatNum]!=''||$arr[orderCode]!='') {
			$pager = new TMIS_Pager($sql,null,null,400);
			$rowset = $pager->findAllBySql($sql);
		}	
		if(count($rowset)>0) foreach($rowset as & $v) {
			$v[guige]=$v[wareName]." ".$v[guige];
			$v[cntChuku] = $this->_modelGang->getCpckChanliang($v[gangId]);
			$v[_edit]="<a href='#' onclick='window.parent.addNewRow($v[gangId])'>出库</a>";
			//得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
			if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
		}
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
			cntChuku => '已出库',
			//jingKg=>'净重',
			//cntTongzi=>'筒子数',
			//cntJian=>'件数',
			//cntOut => '已入库',
			_edit => '操作'
		);
		$smarty = & $this->_getView();
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		if ($pager!=null) $smarty->assign('page_info',$pager->getNavBar($this->_url('addGuide',$arr)));
		$smarty->assign('arr_condition',$arr);
		//$smarty->display(Chengpin/Dye/CprkList.tpl
		//echo 'adsf';
		//$smarty->display('TableList.tpl');
		//可以给不同的order出库在同一张订单上使用到框架，下面只是显示待选择的缸。
		//编辑界面需要调用actionAddGuide2()
		$smarty->display('Chengpin/Dye/CpckNew.tpl');
	}

	//成品出库向导模式
	//第二步:列出该订单下所有的缸号,并输入出库数据
	function actionAddGuide1 () {
		$condition = array(
			array('OrdWare.orderId',$_GET[orderId])
			//array('OrdWare.id',$_GET[ordwarId])
		);
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$pager = null;
		$rowset = $m->findAllGang($condition,$pager,100);
		$newArr = array();
		//echo "asdf";
		// dump($rowset);die();
		$arrCk = array();//已经出库的数组
		foreach($rowset as & $v) {
			//判断这个订单是什么结算方式
			$sql = "select x.*,y.zhelvMx
				from trade_dye_order x 
				left join trade_dye_order2ware y on x.id =y.orderId
				where y.id = {$v['order2wareId']}";
			$order = $this->_modelExample->findBySql($sql);	
			$paymentWay = $order[0]['paymentWay'];
			$zhelv = $order[0]['zhelv'];
			//$chanliang = $m->getCpckChanliang($v[id]);//不知道 为什么要去查产量 不是净重的 by zcc
			$chanliang = $m->getCpckJingkg($v[id]);
			$jingKgZ = $m->getCpckJingkgZ($v[id]);
			$maoKg = $m->getCpckMaokg($v[id]);
			if ($chanliang>0) {
				$v[chanliang]=$chanliang;
				$v[jingKgZ]=$jingKgZ;
				$v[maoKg]=$maoKg;
				$arrCk[] = $v;
			}
			else $newArr[]=$v;
		}
		// dump($arrCk);die();
		//dump($condition);
		// dump($rowset[0]);die();
		$smarty = & $this->_getView();
		$smarty->assign('rows',$newArr);
		$smarty->assign('rows1',$arrCk);
		$smarty->assign('paymentWay',$paymentWay);
		$smarty->assign('zhelv',$zhelv);
		$smarty->assign('dateCpck',date("Y-m-d"));
		//$smarty->assign('page_info',$pager->getNavBar($this->_url('addGuide')));
		$smarty->display('Chengpin/Dye/CpckList1.tpl');
	}

	//成品出库向导模式
	//第三步:保存出库数据
	function actionSaveGuide () {
		$p = $_POST;
		for($i=0;$i<count($_POST[gangId]);$i++) {
			if(empty($p[cntJian][$i])) continue;
			$arr = array(
				dateCpck => $p[dateCpck],
				planId => $p[gangId][$i],
				cntChuku=>$p[cntChuku][$i],
				jingKg => $p[jingKg][$i],
				jingKgZ => $p[jingKgZ][$i],
				cntJian => $p[cntJian][$i],
				cntTongzi => $p[cntTongzi][$i],
				maoKg => $p[maoKg][$i],//新增 字段毛重
				'creater' =>$_SESSION['REALNAME'],
				//memo => $p[memo][$i]
			);
			if ($p[memo][$i]!='') $arr[memo]=$p[memo][$i];
			if ($p['memo2'][$i] != '') $arr['memo'] .=",余".$p['memo2'][$i]."件";
			if ($p[memo1][$i]!='') $arr[memo] .=",有".$p[memo1][$i]."只胶筒";
			$r[]= $arr;
			//dump($p);dump($arr);exit;

		}
		// dump($r);exit;
		$mOrder2ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		//判断是否应该修改对账日期
		if($r) foreach($r as & $v) {
			$gang = $this->_modelGang->find(array('id'=>$v['planId']));
			//dump($gang);exit;
			if($gang['dateDuizhang']>$p['dateCpck'] || $gang['dateDuizhang']=='0000-00-00') {
				$uRowNew = array('id'=>$gang['order2wareId'],'dateDuizhang'=>$p['dateCpck'],'isShenhe'=>1);
				$mOrder2ware->update($uRowNew); //出库时订单审核通过，不允许修改单价价格
				$uRow = array('id'=>$gang['id'],'dateDuizhang'=>$p['dateCpck']);
				//$gang['OrdWare']['dateDuizhang'] = $p['dateCpck'];
				//$m = & FLEA::getSingleton("Model_Trade_Dye_Order2Ware");
				//dump($uRow);exit;	
				$this->_modelGang->update($uRow);
			}
		}

		$ids = $this->_modelExample->createRowset($r);

		if ($_POST[Submit]=='确定') js_alert('出库成功!',null,$this->_url('AddGuide'));
		else if($_POST[Submit]=='确定并打印') {
			foreach($ids as & $v) {
				$param[] = array('printId[]'=>$v);
			}
			js_alert('',null,$this->_url('right',$param));
		}else if ($_POST[Submit]=='保存并打印') {
			foreach($ids as & $v) {
				$param[] = array('printId[]'=>$v);
			}
			js_alert('',null,$this->_url('PrintLodop',$param));
		}
	}

	//选择缸号
	function actionChoseGang() {
		$orderId = $_GET[id];
		echo($orderId); //exit;

		$modelClient = & FLEA::getSingleton('Model_JiChu_Client');
		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');

		$rowOrder2Ware = $modelOrder2Ware->findAllByField('orderId', $orderId);
		//dump($rowOrder2Ware);exit;


		foreach($rowOrder2Ware as & $value) {
			if (!$value[Pdg]) {js_alert('此单未生成计划!','window.history.go(-2)');}
			$rowClient = $modelClient->findByField('id', $value[Order][clientId]);
			$value[clientName] = $rowClient[compName];
		}

		//dump($rowOrder2Ware[0]); exit();

		$smarty = & $this->_getView();
		$smarty->assign('arr_field_value',$rowOrder2Ware);
		$smarty->display('Chengpin/Dye/ChoseGang.tpl');
	}
	/**
	 * ps ：成品出库单打印（新）
	 * Time：2017年12月4日 10:26:34
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionPrint(){
		//需要的引用model
		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		if($_POST['print']=='直接打印') {
			$this->actionPrintLodop();exit;
		}
		$p = $_POST[printId] ? $_POST : $_GET;
		$rowCpck=$this->_modelExample->findAllByPkvs($p[printId]);
		//先判断这打印的客户属于哪种结算方式 当为投料结算的时候 金额只有第一条出库的显示
		$sql = "SELECT c.paymentWay
			FROM trade_dye_order x 
			left join trade_dye_order2ware y on x.id=y.orderId 
			left join jichu_client c on c.id = x.clientId
			where y.id = '{$rowCpck[0]['Plan']['order2wareId']}'";
		$payment = $this->_modelExample->findBySql($sql);
		$paymentWay = $payment[0]['paymentWay'];
		//根据指定的键值对数组排序
		$rowCpck = array_column_sort($rowCpck,'planId');
		// dump($rowCpck);
		$arrCount = count($p[printId]);
		$j = 0;
		foreach($rowCpck as & $value) {
			for($i=0; $i<$arrCount; $i++) {
				if ($value[id] == $p[printId][$i])	{
					$rowCpckPrint[$j] = $value;
					$j++;
				}
			}
		}
		// dump($rowCpckPrint);die();
		if (count($rowCpckPrint))foreach($rowCpckPrint as & $value) {
			$value['cntChuku'] = $value['cntChuku'];
			$rowOrder2Ware = $modelOrder2Ware->findByField('id', $value[Plan][order2wareId]);
			$rowOrder = $modelOrder->findByField('id', $rowOrder2Ware[orderId]);
			//通用数据的赋值
			$value['orderCode'] = $rowOrder[orderCode];
			$value['kuanhao'] = $rowOrder2Ware['kuanhao'];
			$value['vatNum'] = $value['Plan']['vatNum'];
			// 订单明细中写了纱支别名的时候 就显示别名
			$value['wareName'] = $rowOrder2Ware['wareNameBc']?$rowOrder2Ware['wareNameBc']:($rowOrder2Ware['Ware']['wareName'].'||'.$rowOrder2Ware[Ware][guige]);
			$value['vatCode'] = $value['Plan']['vatId'];
			$value['color'] = $rowOrder2Ware['color'];
			$value['colorNum'] = $rowOrder2Ware['colorNum'];
			$value['colorSeCode'] = $rowOrder2Ware['color'].'/'.$rowOrder2Ware['colorNum'];
			$value['vatNum'] = $value['Plan']['vatNum'];
			$value['cntPlanTouliao'] = $value['Plan']['cntPlanTouliao'];
			$value['cntPlanTouliao2'] = $value['cntPlanTouliao'];
			$value['danjia'] = $rowOrder2Ware['danjia'];
			$value['zhelv'] = $rowOrder2Ware['zhelvMx']*100;
			$value['clientName'] = $rowOrder['Client']['fullName']?$rowOrder['Client']['fullName']:$rowOrder['Client']['compName'];
			// dump($paymentWay);die();
			if ($paymentWay==0) {//当结算方式为  投料数结算
				if ($value['danjia']>0) {
					$value['money'] = round($value['danjia']*$value['cntPlanTouliao'],2);//单价*投料数
				}else{
					$value['money'] = round($rowOrder2Ware['money'],2);//小缸价
				}
				
				//获取这个出库的 第一条数据
				$sql = "SELECT * 
					FROM chengpin_dye_cpck  
					where planId= '{$value['planId']}' order by id asc limit 0,1";
				$cpck = $this->_modelExample->findBySql($sql);
				if ($cpck[0]['id'] != $value['id']) {//当本条数据不等于第一条出库数据时
					$value['money'] = ''; //让金额为空数据
				}
			}
			if ($paymentWay==1) {//当结算方式为  净重结算
				if ($value['danjia']>0) {
					$value['money'] = round($value['danjia']*$value['jingKg'],2);//单价*净重
				}else{
					$value['money'] = round($rowOrder2Ware['money'],2);//小缸价
				}
			}
			if ($paymentWay==2) {//当结算方式为  折率净重结算
				if ($value['danjia']>0) {
					$value['money'] = round($value['danjia']*$value['jingKgZ'],2);//单价*折率净重
				}else{
					$value['money'] = round($rowOrder2Ware['money'],2);//小缸价
				}
			}
			//重复的缸号 合计不叠加投料数
			if($tempVatNum!=$value[Plan][vatNum]) {
				$ifShow = 1;
				$tempVatNum=$value[Plan][vatNum];
			} else $ifShow = 0;
			if ($ifShow == 0) {//判断该条为重复缸号数据 
				$value['cntPlanTouliao2'] = 0;
			}
			//by zcc 2017年12月29日 13:14:49
			//(1)当为回修缸号时 打印时金额显示为空 投料数合计不进行叠加 
			//(2)当为回修缸号时 如果出现未出库整缸回修 标记 则金额显示,投料数合计进行叠加，否则如上
			//(3)当为回修缸号时 是未出库整缸回修 会出现回修多次的情况 最后一次才正在发货
			if ($value['Plan']['parentGangId']) {
				if ($value['Plan']['isHuixiuCk']!=1) {
					$value['cntPlanTouliao2'] = 0;
					if ($paymentWay=='0') {
						$value['money'] = '';
					}
				}else{//可能会用不到 提前设下机制
					//获取同一原缸的所有未出库整缸回修
					$sql = "SELECT id FROM plan_dye_gang 
						WHERE parentGangId={$value['Plan']['parentGangId']} 
						AND isHuixiuCk=1  order by id desc limit 0,1";
					$LastHuixiu = $this->_modelExample->findBySql($sql);
					if ($value['Plan']['id']!=$LastHuixiu[0]['id']) {
						$value['cntPlanTouliao2'] = 0;
						if ($paymentWay=='0') {
							$value['money'] = '';
						}
					}	
				}
				
			}


			//合计项
			$tJingKg +=$value['jingKg'];
			$tCntPlanTouliao +=$value['cntPlanTouliao2'];
			$tCcntJian +=$value['cntJian'];
			$tCcntTongzi +=$value['cntTongzi'];
			$tMaoKg += $value['maoKg'];
			$tMoney += $value['money'];
			$cntChuKu += $value['cntChuku'];
		}
		$rowCpckPrint[$i]['vatNum'] = '<strong>合计</strong>';
		$rowCpckPrint[$i]['cntPlanTouliao'] = '<strong>'.$tCntPlanTouliao.'</strong>';
		$rowCpckPrint[$i]['jingKg'] = '<strong>'.$tJingKg.'</strong>';
		$rowCpckPrint[$i]['cntJian'] = '<strong>'.$tCcntJian.'</strong>';
		$rowCpckPrint[$i]['cntTongzi'] = '<strong>'.$tCcntTongzi.'</strong>';
		$rowCpckPrint[$i]['maoKg'] = '<strong>'.$tMaoKg.'</strong>';
		$rowCpckPrint[$i]['money'] = '<strong>'.$tMoney.'</strong>';
        $rowCpckPrint[$i]['cntChuku'] = '<strong>'.$cntChuKu.'</strong>';
		$arrFieldInfo = array(
			// "orderCode" =>"订单号",
			"vatNum" =>"缸号",
			'wareName' => '纱支规格',
			'colorSeCode' =>'色号/色别',
			"kuanhao" =>"款号",
			"cntJian"=>"件数",
			"cntPlanTouliao" =>"投染数(kg)",
			"maoKg"=>"毛重(kg)",
			'jingKg'=>'净重(kg)',
			'danjia'=>'染色单价',
			'money'=>'金额',
		);
		//dump($rowOrder['Client']);die;
		if($rowOrder['Client']['paymentWay']=='0' && $rowOrder['Client']['compName']!='霍雅'&&$rowOrder['Client']['compName']!='香盈' && $rowOrder['Client']['compName']!='张氏加工'){ //霍雅特殊，需要显示毛重和净重
			$arrFieldInfo = array(
				// "orderCode" =>"订单号",
				"vatNum" =>"缸号",
				'wareName' => '纱支规格',
				'colorSeCode' =>'色号/色别',
				"kuanhao" =>"款号",
				"cntJian"=>"件数",
				"cntPlanTouliao" =>"投染数(kg)",
				"cntChuku"=>"出库数量",
				'danjia'=>'染色单价',
				'money'=>'金额',
			);
		}
		if ($rowOrder['Client']['paymentWay']=='2') {
			$arrFieldInfo = array(
				// "orderCode" =>"订单号",
				"vatNum" =>"缸号",
				'wareName' => '纱支规格',
				'colorSeCode' =>'色号/色别',
				"kuanhao" =>"款号",
				"cntJian"=>"件数",
				"color" =>"颜色",
				"cntPlanTouliao" =>"投染数(kg)",
				"maoKg"=>"毛重(kg)",
				'jingKgZ'=>'计价重(kg)',
				'zhelv' =>'损率',
				'danjia'=>'染色单价',
				'money'=>'金额',
			);
		}
		//为净重的时候，不显示投染数
		if ($rowOrder['Client']['paymentWay']=='1') {
			$arrFieldInfo = array(
				// "orderCode" =>"订单号",
				"vatNum" =>"缸号",
				'wareName' => '纱支规格',
				'colorSeCode' =>'色号/色别',
				"kuanhao" =>"款号",
				"cntJian"=>"件数",
				"color" =>"颜色",
				// "cntPlanTouliao" =>"投染数(kg)",
				"maoKg"=>"毛重(kg)",
				'jingKgZ'=>'计价重(kg)',
				'zhelv' =>'损率',
				'danjia'=>'染色单价',
				'money'=>'金额',
			);
		}
		$mphone = & FLEA::getSingleton('Model_Sys_CompInfo');
        $Phone=$mphone->findAll();
		//将打印的信息保存到打印日志中
		$date=date("Y-m-d");
		$user=$_SESSION['REALNAME'];
		$cpckCode=$this->getNewCpckCode();
		$str="insert into chengpin_printblog(datePrint,user,cpckCode) values('$date','$user','$cpckCode')";
		//dump($str);
		mysql_query($str);
		$blogId=mysql_insert_id();
		foreach($_POST['printId'] as & $v){
			$cpckId=$v;
			$sql="insert into chengpin_blog2cpck(cpckId,blogId) values('$cpckId','$blogId')";
			mysql_query($sql);
		}
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign("arr_field_value",$rowCpckPrint);
		$smarty->assign("phone",$Phone);
		$smarty->assign("cpckcode",$cpckCode);
		$smarty->assign('fahuoren', $_SESSION[REALNAME]);
		$smarty->display('Chengpin/Dye/CpckPrint.tpl');
	}

	//成品出库单打印
	function actionPrintOld() {
		if($_POST['print']=='直接打印') {
			$this->actionPrintLodop();exit;
		}
		//dump('asdf');exit;
		//echo(count($_POST[printId])); exit;
		$p = $_POST[printId] ? $_POST : $_GET;
		//dump($p);exit;
		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');

	    $rowCpck=$this->_modelExample->findAllByPkvs($p[printId]);
		// dump($rowCpck);exit;
		$rowCpck = array_column_sort($rowCpck,'planId');
		$arrCount = count($p[printId]);
		$j = 0;
		foreach($rowCpck as & $value) {
			for($i=0; $i<$arrCount; $i++) {
				if ($value[id] == $p[printId][$i])	{
					$rowCpckPrint[$j] = $value;
					$j++;
				}
			}
		}
		// dump($rowCpckPrint[0]);die();
		$i = count($rowCpckPrint);
		$tempVatNum = '';
		if ($i > 0 ) {
			foreach($rowCpckPrint as & $value) {
				//dump($value);exit;
				//如果缸号一致，不显示缸号和计划投料等
				//$a = array($tempVatNum,$value[Plan][vatNum]);
				$rowOrder2Ware = $modelOrder2Ware->findByField('id', $value[Plan][order2wareId]);
				$rowOrder = $modelOrder->findByField('id', $rowOrder2Ware[orderId]);
				// dump($rowOrder);die();
				//遇到缸号相同的不进行计算金额和投料数合计也不进行叠加
				if($tempVatNum!=$value[Plan][vatNum]) {
					$ifShow = 1;
					$tempVatNum=$value[Plan][vatNum];
				} else $ifShow = 0;



				if($ifShow) {
					$value['orderCode'] = $rowOrder[orderCode];
					//$value[clientName] = $rowOrder[Client][compName];
					$value['vatNum'] = $value['Plan']['vatNum'];
					$value['cntPlanTouliao'] = $value['Plan']['cntPlanTouliao'];
					$tCntPlanTouliao +=$value['cntPlanTouliao'];
					$value['orderCode'] = $rowOrder['orderCode'];
					$value['clientName'] = $rowOrder['Client']['fullName']?$rowOrder['Client']['fullName']:$rowOrder['Client']['compName'];
					$value['vatCode'] = $value['Plan']['vatId'];
					$value['color'] = $rowOrder2Ware['color'];
					$value['colorNum'] = $rowOrder2Ware['colorNum'];
					$value['colorSeCode'] = $rowOrder2Ware['color'].'/'.$rowOrder2Ware['colorNum'];
					$value['zhelv'] = $rowOrder2Ware['zhelvMx']*100;
					//纱支档案是否有助记码 有则显示助记码 
					// $value['wareName'] = $rowOrder2Ware['Ware']['mnemocode'] ? $rowOrder2Ware['Ware']['mnemocode']:($rowOrder2Ware['Ware']['wareName'].'||'.$rowOrder2Ware[Ware][guige]);
					// 订单明细中写了纱支别名的时候 就显示别名
					$value['wareName'] = $rowOrder2Ware['wareNameBc']?$rowOrder2Ware['wareNameBc']:($rowOrder2Ware['Ware']['wareName'].'||'.$rowOrder2Ware[Ware][guige]);
					$value['chandi'] = $rowOrder2Ware['chandi'];

					if ($rowOrder['Client']['paymentWay']==2) {//当结算方式为折率净重的时候
						$value['cntChuku'] = $value['jingKgZ'];
					}
					$value['danjia'] = $rowOrder2Ware['danjia'];
					if ($rowOrder['Client']['paymentWay']=='2') {//当结算方式为折率净重时
						$value['money'] = round($value['danjia']*$value['jingKgZ'],2);
					}
					if ($rowOrder['Client']['paymentWay']=='0'){

						$value['money'] = round($value['danjia']*$value['cntPlanTouliao'],2);
					}
					if ($rowOrder['Client']['paymentWay']=='1'){
						$value['money'] = round($value['danjia']*$value['jingKg'],2);
					}
					$value['money'] = $rowOrder2Ware['money']=='0'?$value['money']:$rowOrder2Ware['money'];

					if ($rowOrder['Client']['paymentWay']=='0'){ //投料结算
						//获取这个出库的 第一条数据
						$sql = "SELECT * 
							FROM chengpin_dye_cpck  
							where planId= '{$value['planId']}' order by id asc limit 0,1";
						$cpck = $this->_modelExample->findBySql($sql);
						if ($cpck[0]['id'] != $value['id']) {//当本条数据不等于第一条出库数据时
							$value['money'] = ''; //让金额为空数据
						}	
					}


				} else {
					$value['orderCode'] = $rowOrder[orderCode];
					$value['vatNum'] = $value['Plan']['vatNum'];
					// 订单明细中写了纱支别名的时候 就显示别名
					$value['wareName'] = $rowOrder2Ware['wareNameBc']?$rowOrder2Ware['wareNameBc']:($rowOrder2Ware['Ware']['wareName'].'||'.$rowOrder2Ware[Ware][guige]);
					$value['colorSeCode'] = $rowOrder2Ware['color'].'/'.$rowOrder2Ware['colorNum'];
					$value['vatNum'] = $value['Plan']['vatNum'];
					$value['cntPlanTouliao'] = $value['Plan']['cntPlanTouliao'];
					$value['danjia'] = $rowOrder2Ware['danjia'];
				}

				//dump($value);

				$tJingKg +=$value['jingKg'];
				$tCntChuku +=$value['cntChuku'];
				$tCcntJian +=$value['cntJian'];
				$tCcntTongzi +=$value['cntTongzi'];
				$tMaoKg += $value['maoKg'];
				$tMoney += $value['money'];

			}

			$rowCpckPrint[$i]['orderCode'] = '<strong>合计</strong>';
			$rowCpckPrint[$i]['cntChuku'] = '<strong>'.$tCntChuku.'</strong>';
			$rowCpckPrint[$i]['cntPlanTouliao'] = '<strong>'.$tCntPlanTouliao.'</strong>';
			$rowCpckPrint[$i]['jingKg'] = '<strong>'.$tJingKg.'</strong>';
			$rowCpckPrint[$i]['cntJian'] = '<strong>'.$tCcntJian.'</strong>';
			$rowCpckPrint[$i]['cntTongzi'] = '<strong>'.$tCcntTongzi.'</strong>';
			$rowCpckPrint[$i]['maoKg'] = '<strong>'.$tMaoKg.'</strong>';
			$rowCpckPrint[$i]['money'] = '<strong>'.$tMoney.'</strong>';
		}

		//dump($rowCpckPrint);exit;

		$arrFieldInfo = array(
			"orderCode" =>"订单号",
			'wareName' => '纱支规格',
			'colorSeCode' =>'色号/色别',
			"vatNum" =>"缸号",
			"cntJian"=>"件数",
			// "color" =>"颜色",
			"cntPlanTouliao" =>"投染数(kg)",
			//"cntChuku"=>"本次发货",
			// "cntChuku"=>"毛重(kg)",
			"maoKg"=>"毛重(kg)",
			'jingKg'=>'净重(kg)',
			// "cntJian"=>"件数",
			// "cntTongzi"=>"筒子数",
			'danjia'=>'染色单价',
			'money'=>'金额',
			// 'memo'=>'备注'
		);
		if ($rowOrder['Client']['paymentWay']=='2') {
			$arrFieldInfo = array(
				"orderCode" =>"订单号",
				'wareName' => '纱支规格',
				'colorSeCode' =>'色号/色别',
				"vatNum" =>"缸号",
				"cntJian"=>"件数",
				//'chandi' => '厂地',
				//"colorNum" =>"色号",
				"color" =>"颜色",
				"cntPlanTouliao" =>"投染数(kg)",
				//"cntChuku"=>"本次发货",
				"maoKg"=>"毛重(kg)",
				'jingKgZ'=>'计价重(kg)',
				// "cntTongzi"=>"筒子数",
				'zhelv' =>'损率',
				'danjia'=>'染色单价',
				'money'=>'金额',
			// 'memo'=>'备注'
			);
		}
		
		/*$Phone=FLEA::getAppInf('PrintCpck');
		if($Phone=='Cpck/JianliPrintCpck.js'){
			$Phone='jianli';
		}else{
			$Phone='haisha';
		}*/
                $mphone = & FLEA::getSingleton('Model_Sys_CompInfo');
                $Phone=$mphone->findAll();
		//将打印的信息保存到打印日志中
		$date=date("Y-m-d");
		$user=$_SESSION['REALNAME'];
		$cpckCode=$this->getNewCpckCode();
		$str="insert into chengpin_printblog(datePrint,user,cpckCode) values('$date','$user','$cpckCode')";
		//dump($str);
		mysql_query($str);
		$blogId=mysql_insert_id();
		foreach($_POST['printId'] as & $v){
		$cpckId=$v;
		$sql="insert into chengpin_blog2cpck(cpckId,blogId) values('$cpckId','$blogId')";
		//dump($sql);
		mysql_query($sql);
		}
                //dump($Phone);
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign("arr_field_value",$rowCpckPrint);
		$smarty->assign("phone",$Phone);
		$smarty->assign("cpckcode",$cpckCode);
		$smarty->assign('fahuoren', $_SESSION[REALNAME]);
		$smarty->display('Chengpin/Dye/CpckPrint.tpl');
	}
	 //打印日志
        function actionPrintLog(){
            FLEA::loadClass('TMIS_Pager');
            TMIS_Pager::clearCondition();
            $arr = TMIS_Pager::getParamArray(array(
                    'dateFrom'	=>date("Y-m-1"),
                    'dateTo'	=>date("Y-m-d"),
                    'clientId'	=>'',
                    //'vatNum'		=>'',
                    'orderCode'	=>''
            ));
            $str="select x.datePrint,x.cpckCode,y.cpckId,y.blogId,z.dateCpck,m.compName,m.orderCode from chengpin_printblog x
                   left join chengpin_blog2cpck y on y.blogId=x.id
                   left join chengpin_dye_cpck z on z.id=y.cpckId
                   left join view_dye_gang m on z.planId=m.gangId
                   where 1
                ";
            if($arr['dateFrom']!=''&&$arr['dateTo']!=''){
                $str.=" and x.datePrint>='$arr[dateFrom]' and x.datePrint<='$arr[dateTo]'";
            }
            if($arr['clientId']!=''){
                $str.=" and m.clientId='$arr[clientId]' ";
            }
             if($arr['orderCode']!=''){
                $str.=" and m.orderCode like '%{$arr[orderCode]}%' ";
            }
            //$str.="group by x.id ";
            //echo $str;
            $query=mysql_query($str);
            while($re=mysql_fetch_assoc($query)){
                $rowset[]=$re;
            }
            foreach($rowset as & $v){
		//dump($v);
                $v['edit']="<a href='".$this->_url('LogDetail',array(
				'blogId'=>$v['blogId'],
				'printId'=>$v['cpckId']
			))."' target='_blank'>详细</a>";
            }
            //dump($rowset);
            $arrFieldInfo = array(
                        "datePrint"=>"打印日期",
			'compName' => '客户',
			"orderCode" =>"定单号",
                        "dateCpck" =>"出库日期",
			"cpckCode"=>"出库单号",
			"edit"=>"操作"
		);
                $smarty = & $this->_getView();
		$smarty->assign('title','打印日志');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
                $smarty->display('TableList.tpl');
        }
	//日志详细
       function actionLogDetail(){
             //dump($_GET);exit;
             $str="select cpckId  from chengpin_blog2cpck where blogId='$_GET[blogId]]'";
             $query=mysql_query($str);
            while($re=mysql_fetch_assoc($query)){
                $p['printId'][]=$re['cpckId'];
            }
             $str="select cpckCode  from chengpin_printblog  where id='$_GET[blogId]]'";
             $query=mysql_query($str);
            $re=mysql_fetch_assoc($query);
            $cpckCode=$re['cpckCode'];
            //dump($p);exit;
             /*$p = $r;
		dump($p);exit;*/
		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
                //dump($p[printId]);exit;
	    $rowCpck=$this->_modelExample->findAllByPkvs($p[printId]);

		$rowCpck = array_column_sort($rowCpck,'planId');
		$arrCount = count($p[printId]);
		$j = 0;
		foreach($rowCpck as & $value) {
			for($i=0; $i<$arrCount; $i++) {
				if ($value[id] == $p[printId][$i])	{
					$rowCpckPrint[$j] = $value;
					$j++;
				}
			}
		}
		//dump($rowCpckPrint[0]);
		$i = count($rowCpckPrint);
		$tempVatNum = '';
		if ($i > 0 ) {
			foreach($rowCpckPrint as & $value) {
				//dump($value);exit;
				//如果缸号一致，不显示缸号和计划投料等
				//$a = array($tempVatNum,$value[Plan][vatNum]);
				$rowOrder2Ware = $modelOrder2Ware->findByField('id', $value[Plan][order2wareId]);
				$rowOrder = $modelOrder->findByField('id', $rowOrder2Ware[orderId]);
				if($tempVatNum!=$value[Plan][vatNum]) {
					$ifShow = 1;
					$tempVatNum=$value[Plan][vatNum];
				} else $ifShow = 0;



				if($ifShow) {
					$value[orderCode] = $rowOrder[orderCode];
					//$value[clientName] = $rowOrder[Client][compName];
					$value[vatNum] = $value[Plan][vatNum];
					$value[cntPlanTouliao] = $value[Plan][cntPlanTouliao];$tCntPlanTouliao +=$value[cntPlanTouliao];
					$value[orderCode] = $rowOrder[orderCode];
					$value[clientName] = $rowOrder[Client][compName];
					$value[vatCode] = $value[Plan][vatId];
					$value[color] = $rowOrder2Ware[color];
					$value[colorNum] = $rowOrder2Ware[colorNum];
					$value[wareName] = $rowOrder2Ware[Ware][mnemocode] ? $rowOrder2Ware[Ware][mnemocode]:($rowOrder2Ware[Ware][wareName].'||'.$rowOrder2Ware[Ware][guige]);

					$value['chandi'] = $rowOrder2Ware['chandi'];

				} else {
					//$value[orderCode] = '';
					$value[vatNum] = '';
					$value[wareName] = '';
					$value[color] = '';
					$value[cntPlanTouliao] = '';
					//$value[vatNum] = '';
				}

				//dump($value);

				$tJingKg +=$value[jingKg];
				$tCntChuku +=$value[cntChuku];
				$tCcntJian +=$value[cntJian];
				$tCcntTongzi +=$value[cntTongzi];

			}

			$rowCpckPrint[$i][orderCode] = '<strong>合计</strong>';
			$rowCpckPrint[$i][cntChuku] = '<strong>'.$tCntChuku.'</strong>';
			$rowCpckPrint[$i][cntPlanTouliao] = '<strong>'.$tCntPlanTouliao.'</strong>';
			$rowCpckPrint[$i][jingKg] = '<strong>'.$tJingKg.'</strong>';
			$rowCpckPrint[$i][cntJian] = '<strong>'.$tCcntJian.'</strong>';
			$rowCpckPrint[$i][cntTongzi] = '<strong>'.$tCcntTongzi.'</strong>';
		}
		$arrFieldInfo = array(
			"orderCode" =>"订单号",
			"vatNum" =>"缸号",
			'wareName' => '纱支',
			"color" =>"颜色",
			"cntPlanTouliao" =>"计划投料",
			"jingKg"=>"净重",
			"cntJian"=>"件数",
			"cntTongzi"=>"筒子数",
			'memo'=>'备注'
		);
                $mphone = & FLEA::getSingleton('Model_Sys_CompInfo');
                $Phone=$mphone->findAll();
		$smarty = & $this->_getView();
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign("arr_field_value",$rowCpckPrint);
		$smarty->assign("phone",$Phone);
                $smarty->assign("cpckcode",$cpckCode);
		$smarty->assign('fahuoren', $_SESSION[REALNAME]);
		$smarty->display('Chengpin/Dye/CpckPrint.tpl');
         }
	 //自动获取出库单号
	function getNewCpckCode() {
                $str="select * from chengpin_printblog";
                $str.=" order by id desc";
                $query=mysql_query($str);
                $re=mysql_fetch_assoc($query);
		$max = $re['cpckCode'];
		$temp = date("ym")."001";
		if ($temp>$max){
                    return $temp;
                }else{
                     $a = substr($max,-3)+1;
                     if($a<10){
                         return substr($max,0,6).$a;
                     }elseif($a<=99){
                         return substr($max,0,5).$a;
                     }else{
                         return substr($max,0,4).$a;
                     }
                }
	}

	//成品出库单利用lodop控件打印
	function actionPrintLodop() {
		$perPage = 10;//每页的行数
		$ret = array();
		$ret['title'] = FLEA::getAppInf('compName');
		$ret['memo'] = "1.请收货单位收货时认真核对收货数量，金额和累积账款，并由收货方财务签字确认后回传苏彩坊财务（或由驾驶员带回）"."\n"."2.请认真核对色光、色号无误后入库。如有质量异议需在五天内以书面形式通知染厂。织造成品后如出现质量问题由此而造成的赔款或退货，染厂概不负责。";
		//dump($_POST);exit;
		//echo(count($_POST[printId])); exit;
		$p = $_POST[printId] ? $_POST : $_GET;
		//dump($p);exit;
		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$mGang = & FLEA::getSingleton("Model_Plan_Dye_Gang");
		//$mClient = & FLEA::getSingleton("Model_Jichu_Client");

	    $rowCpck=$this->_modelExample->findAllByPkvs($p['printId']);
	    $rowCpck = array_column_sort($rowCpck,'planId');
	    // dump($rowCpck);die();
	    $tempVatNum='';
		if($rowCpck) foreach($rowCpck as & $v) {
			$temp = $mGang->formatRet($v['Plan']);
			$v['Plan'] = $temp;
			//判断这个出库数据结算方式 s算出金额 by zcc 2017年10月27日 14:01:22
			// 按照投料数的字段有：投料数，毛重，净重;金额=投料数*单价
			// 按照净重的字段：投料数，毛重，净重；金额=净重*单价
			// 按照折率的字段：净重，计价重（折率净重）；金额=计价重*单价
			$paymentWay = $temp['Client']['paymentWay'];
			$money = 0 ;
			if ($paymentWay=='0') {//投料
				if ($temp['OrdWare']['danjia']>0) {
					$money = round($temp['cntPlanTouliao']*$temp['OrdWare']['danjia'],2);
				}else{
					$money = round($temp['OrdWare']['money'],2);
				}
				
				//获取这个出库的 第一条数据
				$sql = "SELECT * 
					FROM chengpin_dye_cpck  
					where planId= '{$v['planId']}' order by id asc limit 0,1";
				$cpck = $this->_modelExample->findBySql($sql);
				if ($cpck[0]['id'] != $v['id']) {//当本条数据不等于第一条出库数据时
					$money = ''; //让金额为空数据
				}
			}
			if ($paymentWay=='1') {//净重
				if ($temp['OrdWare']['danjia']>0) {
					$money = round($v['jingKg']*$temp['OrdWare']['danjia'],2);
				}else{
					$money = round($temp['OrdWare']['money'],2);
				}
			}
			if ($paymentWay=='2') {//折率净重
				if ($temp['OrdWare']['danjia']>0) {
					$money = round($v['jingKgZ']*$temp['OrdWare']['danjia'],2);
				}else{
					$money = round($temp['OrdWare']['money'],2);
				}
				
			}
			// dump($temp);die();
			if($tempVatNum!=$v[Plan][vatNum]) {
				$ifShow = 1;
				$tempVatNum=$v[Plan][vatNum];
			} else $ifShow = 0;
			if ($ifShow == 0) {//判断该条为重复缸号数据 
				$v['cntPlanTouliao2'] = 0;
			}else{
				$v['cntPlanTouliao2'] = $temp['cntPlanTouliao'];
			}


			//by zcc 2017年12月29日 13:14:49
			//(1)当为回修缸号时 打印时金额显示为空 投料数合计不进行叠加 
			//(2)当为回修缸号时 如果出现未出库整缸回修 标记 则金额显示,投料数合计进行叠加，否则如上
			//(3)当为回修缸号时 是未出库整缸回修 会出现回修多次的情况 最后一次才正在发货
			if ($temp['parentGangId']) {
				if ($temp['isHuixiuCk']!=1) {
					$v['cntPlanTouliao2'] = 0;
					if ($paymentWay=='0') {
						$money = '';
					}
				}
				else{//可能会用不到 提前设下机制(防止多次回修的数据有出库记录)
					//获取同一原缸的所有未出库整缸回修
					$sql = "SELECT id FROM plan_dye_gang 
						WHERE parentGangId={$temp['parentGangId']} 
						AND isHuixiuCk=1  order by id desc limit 0,1";
					$LastHuixiu = $this->_modelExample->findBySql($sql);
					if ($temp['id']!=$LastHuixiu[0]['id']) {
						$v['cntPlanTouliao2'] = 0;
						if ($paymentWay=='0') {
							$money = '';
						}
					}	
				}
				
			}
			$ret['Gang'][] = array(
				"orderCode" => $temp['OrdWare']['Order']['orderCode'],
				"vatNum" =>$temp['vatNum'],
				'wareName' => $temp['OrdWare']['wareNameBc']?$temp['OrdWare']['wareNameBc']:$temp['OrdWare']['Ware']['wareName'].' '.$temp['OrdWare']['Ware']['guige'],
				'chandi' => $temp['OrdWare']['chandi'],
				"colorNum" =>$temp['OrdWare']['colorNum'],
				"kuanhao" =>$temp['OrdWare']['kuanhao'],
				"color" =>$temp['OrdWare']['color'],
				"cntPlanTouliao" =>$temp['cntPlanTouliao'],
				"cntPlanTouliao2" =>$v['cntPlanTouliao2'],
				"cntChuku"=>$v['cntChuku'],
				"jingKg"=>$v['jingKg'],
				"cntJian"=>$v['cntJian'],
				"cntTongzi"=>$v['cntTongzi'],
				'memo'=>$v['memo'],
				'danjia' =>$temp['OrdWare']['money']==0?$temp['OrdWare']['danjia']:'',//新增 染色单价
				'colorSeCode' =>$temp['OrdWare']['color'].'/'.$temp['OrdWare']['colorNum'],//打印界面的 色号/色别组合
				'kindName' => $temp['OrdWare']['Order']['kind']=='0'?'加工':'经销',//类别
				"jingKgZ"=>$v['jingKgZ'],//折率净重 对应的打印 计价重
				'zhelv'=>$temp['OrdWare']['zhelvMx']*100,//折率 化成 百分比
				'moneyFs' =>$money,
				"maoKg"=>$v['maoKg'],
			);
		}
		// dump($rowCpck);exit;
		$ret['Client'] = $rowCpck[0]['Plan']['Client'];
		$ret['dateCpck'] = $rowCpck[0]['dateCpck'];
		$ret['clientName'] = $ret['Client']['fullName']?$ret['Client']['fullName']:$ret['Client']['compName'];
		//dump($ret);exit;
		$ret['datePint'] = date('Y-m-d');
		$ret['senderName'] = $rowCpck[0]['creater']?$rowCpck[0]['creater']:$_SESSION[REALNAME];
		$ret['timeInput'] = $rowCpck[0]['dt'];
		$str="select * from sys_setup where setName='PrintCpck'";
		$query=mysql_query($str);
		$re=mysql_fetch_assoc($query);
		if($re['setValue']=='PrintCpck.js'){
			$cntPlanTouliao2 = $this->getHeji1($ret['Gang'],array('cntPlanTouliao2'),'vatNum');
			$heji = $this->getHeji1($ret['Gang'],array('cntPlanTouliao','cntChuku','jingKg','cntJian','cntTongzi','jingKgZ','moneyFs','maoKg'),'vatNum');
			$heji['cntPlanTouliao'] = $cntPlanTouliao2['cntPlanTouliao2'];
		}else{
			$cntPlanTouliao2 = $this->getHeji1($ret['Gang'],array('cntPlanTouliao2'),'vatNum');
			$heji = $this->getHeji1($ret['Gang'],array('cntPlanTouliao','cntChuku','jingKg','cntJian','cntTongzi','jingKgZ','moneyFs','maoKg'),'vatNum');
			$heji['cntPlanTouliao'] = $cntPlanTouliao2['cntPlanTouliao2'];
		}
		$ret['Gang'][] = $heji;
		$cnt = ceil(count($ret['Gang'])/$perPage);

		$gangs = $ret['Gang'];
		//dump($cnt);dump($gangs);exit;
		for($i=0;$i<$cnt;$i++) {
			$temp = $ret;
			$temp['Gang'] = array_slice($gangs,$i*$perPage,$perPage);
			$r[] = $temp;
			unset($temp);
		}
		// dump($r);exit;
		//dump($rowCpck[0]);exit;
		//将打印的信息保存到打印日志中
		if(!$_POST['cpckcode']) {//post中没有cpckCode说明是直接打印，需要记录日志
			$date=date("Y-m-d");
			$user=$_SESSION['REALNAME'];
			 $cpckCode=$this->getNewCpckCode();
		   $str="insert into chengpin_printblog(datePrint,user,cpckCode) values('$date','$user','$cpckCode')";
			 //dump($str);
			mysql_query($str);
			$blogId=mysql_insert_id();
			foreach($_POST['printId'] as & $v){
				$cpckId=$v;
				$sql="insert into chengpin_blog2cpck(cpckId,blogId) values('$cpckId','$blogId')";
				//dump($sql);
				mysql_query($sql);
			}
		}
		if($r)foreach($r as & $v){
			//$v['compName'] = $r[0]['title'];
			foreach($v['Gang'] as  $key=> & $vv){
				$len=strlen($vv['colorNum']);
				if($len>=11){
					$s=substr($vv['colorNum'],-11);
					$vv[colorNum]=$s;
				}
				if($_POST['cpckcode']){
					$v['cpckcode']=$_POST['cpckcode'];
				}else{
					 $v['cpckcode']=$cpckCode;
				}
			}
		}
		$smarty = & $this->_getView();
		//$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign("obj",$r);

		$servTel = $this->getServTel();
		$smarty->assign("tel",$servTel);
		//$smarty->assign('fahuoren', $_SESSION[REALNAME]);
		//dump($paymentWay);die;
		if ($paymentWay=='2') {// 为结算方式为折率净重时 走专用模版
			$smarty->display('Chengpin/Dye/PrintDirectlyTwo.tpl');
			die;
		}
		if($paymentWay=='0' && $r[0]['Client']['compName']!='霍雅' && $r[0]['Client']['compName']!='香盈'&&$r[0]['Client']['compName']!='张氏加工'){
			$smarty->display('Chengpin/Dye/PrintDirectlyThree.tpl');
			die;
		}
		if ($paymentWay=='1') {// 为结算方式为净重时 走专用模版
			$smarty->display('Chengpin/Dye/PrintDirectlyFour.tpl');
			die;
		}
		$smarty->display('Chengpin/Dye/PrintDirectly.tpl');
	}

	function _edit($Arr, $ArrProductList=null) {
		$this->funcId = 77;				//成品-出库-增加修改
		$this->authCheck($this->funcId);
		$sql = "SELECT y.zhelvMx as zhelv,c.paymentWay as paymentWay
 		FROM plan_dye_gang x 
		left join trade_dye_order2ware y on y.id = x.order2wareId
		left join trade_dye_order z on z.id = y.orderId
		left join jichu_client c on c.id = z.clientId
		where x.id ='{$Arr['planId']}'";
		$order = $this->_modelExample->findBySql($sql);
		// dump($sql);die();
		$smarty = & $this->_getView();
		$smarty->assign("title",'成品出库编辑');
		$smarty->assign("arr_field_value",$Arr);
		$smarty->assign("zhelv",$order[0]['zhelv']);
		$smarty->assign("paymentWay",$order[0]['paymentWay']);
		$smarty->display('Chengpin/Dye/CpckEdit.tpl');
	}

	//取得新的成品出库单号
	function _getNewCpckCode() {
		$arr=$this->_modelExample->find(null,'cpckCode desc','cpckCode');
		$max = $arr[cpckCode];
		$temp = date("ym")."001";
		if ($temp>$max) return $temp;
		$a = substr($max,-3)+1001;
		return substr($max,0,-3).substr($a,1);
	}

	#增加界面
	function actionAdd() {
		$this->_edit(array());
	}
	#保存
	function actionSave() {
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr = $model->find("vatNum='$_POST[vatNum]'");

		//判断是否应该修改对账日期
		if($arr['dateDuizhang']>$_POST['dateCpck'] || $arr['dateDuizhang']=='0000-00-00') {
			$uRow = array('id'=>$arr['id'],'dateDuizhang'=>$_POST['dateCpck']);
			$model->update($uRow);
		}

		$_POST[planId] = $arr[id];
		$_POST['creater'] = $_SESSION['REALNAME'];
        $cpckId = $this->_modelExample->save($_POST);
		redirect($this->_url('right'));
	}

	#修改界面
	function actionEdit() {
		if (!$this->_editable($_GET[id])) js_alert('该出库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
		$arrFieldValue=$this->_modelExample->find($_GET[id]);
		//$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		//$arr = $model->find($arrFieldValue[planId]);
		//$arrFieldValue[vatNum] = $arr[vatNum];
		$this->_edit($arrFieldValue);
	}

	//删除
	function actionRemove() {
		$this->funcId = 77;				//成品-出库-删除
		$this->authCheck($this->funcId);
		$row=$this->_modelExample->find(array('id'=>$_GET['id']));
		//dump($row);exit;
		if (!$this->_editable($_GET[id])) js_alert('该出库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
		else{
			//parent::actionRemove();
			$this->_modelExample->removeByPkv($_GET['id']);
			#出库记录删除后，判断该缸是否有别的出库记录，有将对账日期设置为最早的出库日期，没有，设置为0000-00-00
			$str="select * from chengpin_dye_cpck where planId='{$row['planId']}' and kind='0' order by dateCpck asc";
			//echo $str;
			$re=mysql_fetch_assoc(mysql_query($str));
			if($re){
				$dateDuizhang=$re['dateCpck'];
			}else{
				$dateDuizhang='0000-00-00';
			}
			//dump($dateDuizhang);exit;
			$sql="update plan_dye_gang set dateDuizhang='{$dateDuizhang}' where id='{$row['planId']}'";
			mysql_query($sql);
			redirect($this->_url('right'));
		}
	}

	//判断id=$pkv的出库单是否允许被修改或删除,
	function _editable($pkv) {
		$row=$this->_modelExample->find(array('id'=>$_GET['id']));
		$sql = "SELECT * FROM trade_dye_order2ware where id = '{$row['Plan']['order2wareId']}'";
		$order2pro = $this->_modelExample->findBySql($sql);
		if ($order2pro[0]['isShenhe']==1) {//已经审核 无法删除
			return false;
		}
		return true;
	}

	function actionGetJsonByVatNum() {
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr = $model->find("vatNum='$_GET[vatNum]'");
		echo json_encode($arr);
	}

	function actionGetJsonByGangId() {
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$cprk = FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
		$cpck = FLEA::getSingleton('Model_Chengpin_Dye_Cpck');

		$arr = $model->findAllGang1(array("gangId='$_GET[gangId]'"));
		$arr[0][guige] = $arr[0][wareName]." ".$arr[0][guige];
		#取得入库数
		$arrCprk=$cprk->findAll(array('planId'=>$_GET['gangId']));
		$heji=$this->getHeji($arrCprk,array('jingKg','cntJian','cntTongzi','maoKg'));
		//$arr[0]['Cprk']=$heji;
		#取得出库数
		$arrCpck=$cpck->findAll(array('planId'=>$_GET['gangId']));
		$hj=$this->getHeji($arrCpck,array('jingKg','cntJian','cntTongzi','maoKg'));
		$sql = "SELECT * FROM trade_dye_order2ware where id = '{$arr[0]['order2wareId']}'";
		$order = $this->_modelExample->findBySql($sql);	
		$sql = "SELECT * FROM jichu_client where id = '{$arr[0]['clientId']}'";
		$client = $this->_modelExample->findBySql($sql);	
		$arr[0]['cntChuku']=$arr[0]['cntPlanTouliao']-$hj['jingKg'];
		$arr[0]['jingKg']=$heji['jingKg']-$hj['jingKg'];
		$arr[0]['cntTongzi']=$heji['cntTongzi']-$hj['cntTongzi'];
		$arr[0]['cntJian']=$heji['cntJian']-$hj['cntJian'];
		$arr[0]['zhelvOrder']=$order[0]['zhelvMx'];
		$arr[0]['paymentWay']=$client[0]['paymentWay'];
		$arr[0]['maoKg']=$heji['maoKg']-$hj['maoKg'];

		echo json_encode($arr[0]);
	}

   //财务管理中关于成品出库的报表
   function actionCaiwuCpckBaobiao(){
            $title = "成品发货报表";
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom=>date("Y-m-1"),
                        dateTo=>date("Y-m-d"),
                        clientId=>'',
                        guige=>''
		));
		//if ($arr[isReport]==1) $arr['clientId'] = $_POST[clientId]?$_POST[clientId]:$_GET[clientId];
		$str = "select
			x.*,
			y.compName,y.orderCode,y.vatNum,y.wareName,y.guige,y.color,y.vatCode,y.cntPlanTouliao,y.orderId
			from chengpin_dye_cpck x
			inner join view_dye_gang y on x.planId=y.gangId
			where ";

		$condition=array();
		if ($arr[dateFrom]!=''||$arr[dateTo]!='') {
			//echo($arr[dateTo]);
			$condition[] = "date(x.dateCpck)>='$arr[dateFrom]'";
			$condition[] = "date(x.dateCpck)<='$arr[dateTo]'";
		}
                if($arr['clientId']){
                  $condition[] = "y.clientId='$arr[clientId]'";
                }
                 if($arr[guige]){
                     $condition[] = "y.guige like '%{$arr[guige]}%'";
                }
		$str .= join(" and ",$condition);
		$str .= " order by dt DESC";
		//echo $str;exit;
		$pager =& new TMIS_Pager($str,null,null,400);
		$rowset = $pager->findAllBySql($str);
		//dump($rowset[0]);
		foreach($rowset as & $value) {
			$tTouliao += $value[cntPlanTouliao];
			$jingKg += $value[jingKg];
			$cntChuku += $value[cntChuku];
			$cntJian += $value[cntJian];
			$cntTongzi += $value[cntTongzi];
			$value[guige] =$value[guige]." ".$value[wareName];
			$value[orderCode]=$this->_modelOrder->getOrderTrack($value[orderId],$value[orderCode]);
			//dump($value[guige]);exit;
		}
		//dump($rowset[0]);
		$i = count($rowset);
		$rowset[$i][dateCpck]="<b>合计</b>";
		$rowset[$i][cntPlanTouliao] = "<b>$tTouliao</b>";
		$rowset[$i][jingKg] ="<b>$jingKg</b>";
		$rowset[$i][cntChuku] ="<b>$cntChuku</b>";
		$rowset[$i][cntJian] ="<b>$cntJian</b>";
		$rowset[$i][cntTongzi] ="<b>$cntTongzi</b>";
		//dump($rowset[0]);
		//dump($rowset[$i]);
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"dateCpck" =>"出库日期",
			'compName' => '客户',
			"orderCode" =>"定单号",
			//"vatNum" =>"缸号",
			"guige" => "规格",
			"color" =>"颜色",
			"vatCode" =>"缸号",
			"cntPlanTouliao" =>"投料数",
			//'cntChuku'=>'本次发货',
			"jingKg"=>"净重",
			"cntJian"=>"件数",
			"cntTongzi"=>"筒数"
		);
		if ($arr[isReport]!=1) $arrEditInfo = array("edit" =>"修改", "remove" =>"删除");
		$smarty->assign('arr_main_value',array(
			//'日期'=>$arr['dateFrom'],
			'当前用户'=>$_SESSION['REALNAME']
		));
		$smarty->assign('title',$title);
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		//$smarty->assign('other_button',);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		//if ($arr[isReport]!=1) $smarty->display('Chengpin/Dye/CpckManage.tpl');
		//$smarty->assign('other_button','<input type="button" name="button" id="button" value="重新选择日期" onclick="window.location.href='."'".$this->_url('setDay')."'".'"/>' . ($cntChuku>0 ? (' 制成率：'.round($jingKg/$cntChuku,2)) : ''));
		$smarty->display('Chengpin/Dye/CaiwuCpckBaobiao.tpl');
        }

	//打印界面数据的导出
    function actionOutData(){
    	//输出导出文件的头
    	header("Pragma: public");
	    header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=test.xls");
		header("Content-Transfer-Encoding: binary");

		// $sql="select y.cntPlanTouliao,y.dateDuizhang,z.color,z.colorNum,z.danjia,z.money,m.orderCode,z.danjia*y.cntPlanTouliao+z.money as money
		//       from plan_dye_gang y
		//       join trade_dye_order2ware z on y.order2wareId = z.id
		//       join trade_dye_order m on z.orderId = m.id
		//       where m.clientId='$clientId' and y.dateDuizhang>='$dateFrom' and y.dateDuizhang<='$dateTo' and y.parentGangId=0
		//       order by";
		// $rowset=$this->_modelExample->findBySql($sql);
		$str = "select
			`y`.`vatNum` AS `vatNum`,
			`y`.`parentGangId` AS `parentGangId`,
			`y`.`cntPlanTouliao` AS `cntPlanTouliao`,
			`y`.`pihao` AS `pihao`,
			`y`.`vatId` AS `vatId`,
			`y`.`unitKg` AS `unitKg`,
			y.dateDuizhang as dateDuizhang,
			`z`.`manuCode` AS `manuCode`,
			`z`.`wareId` AS `wareId`,
			`z`.`color` AS `color`,
			`z`.`colorNum` AS `colorNum`,
			`z`.`cntKg` AS `cntKg`,
			`z`.`danjia` AS `danjia`,
			`z`.`money` AS `money`,
			`m`.`orderCode` AS `orderCode`,
			`m`.`clientId` AS `clientId`,
			`m`.`dateOrder` AS `dateOrder`,
			`m`.`dateJiaohuo` AS `dateJiaohuo`,
			m.orderCode2,
			z.danjia*y.cntPlanTouliao+z.money as money
			from plan_dye_gang y
			join trade_dye_order2ware z on `y`.`order2wareId` = `z`.`id`
			join `trade_dye_order` `m` on `z`.`orderId` = `m`.`id`
			where m.clientId='$clientId' and y.dateDuizhang>='$dateFrom' and y.dateDuizhang<='$dateTo' and y.parentGangId=0
			order by ";
		$str .= isset($_GET['sortBy']) ? $_GET['sortBy'] : "dateDuizhang,orderCode";
		//echo $str;
		$m = FLEA::getSingleton('Model_JiChu_Client');
		$arr = $m->find($clientId);$compName = $arr[compName];
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$rowset = $m->findBySql($str);
		foreach ($rowset as & $value) {
			$modelPlan = & FLEA::getSingleton('Model_Plan_Dye_Gang');
			$rowPlan = $modelPlan->findByField('vatNum',$value[vatNum]);
			$modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
			$rowOrder = $modelOrder->findByField('id', $rowPlan[OrdWare][orderId], null, 'orderCode');
			$value[orderCode] = $rowOrder[orderCode];
			//$value[cntPlanTouliao] = $rowPlan[cntPlanTouliao];
			$rowWare = $modelWare->find($value[wareId]);
			if (count($rowWare)>0) {
				$value[wareName] = $rowWare[wareName].' '.$rowWare[guige];
			}
			$totalCnt += $value[cntChuku];
			$totalMone += $value[money];
			$value['dateCpck']=$value['dateDuizhang'];
		}
		//$rowset = array_column_sort($rowset,'dateCpck',SORT_ASC);
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','money'),'orderCode');
		$rowset[] = $heji;
		// $arrFieldInfo = array(

		// 	"orderCode" =>"<a href='".$this->_url($_GET['action'],array(
		// 		'sortBy'=>'orderCode',
		// 		'dateFrom'=>$_GET['dateFrom'],
		// 		'dateTo'=>$_GET['dateTo'],
		// 		'clientId'=>$_GET['clientId'],
		// 	))."'>定单号</a>",
		// 	"dateDuizhang" =>"<a href='".$this->_url($_GET['action'],array(
		// 		'dateFrom'=>$_GET['dateFrom'],
		// 		'dateTo'=>$_GET['dateTo'],
		// 		'clientId'=>$_GET['clientId'],
		// 	))."'>发货日期</a>",
		// 	//"vatNum" =>"缸号",
		// 	"wareName"=>"纱支",
		// 	'colorNum'=>'色号',
		// 	"color"=>"颜色",
		// 	"cntPlanTouliao"=>"投料数",
		// 	//"cntKg"=>"投料数",
		// 	//"cntJian"=>"件数",
		// 	//"cntTongzi"=>"筒子数"
		// 	"danjia"=>"染色单价",
		// 	"money"=>"发生金额",
		// );
            
        //输出模板

        $arr = array(
        	array('orderCode'=>'定单号'),
        	array('dateDuizhang'=>'发货日期'),
        	array('wareName'=>'纱支'),
        	array('colorNum'=>'色号'),
        	array('color'=>'颜色'),
        	array('cntPlanTouliao'=>'投料数'),
            array('danjia'=>'染色单价'),
            array('money'=>'发生金额'),
        );

        $smarty = $this->_getView();
        $smarty->assign('title',"筒染对账单-$compName({$_GET['dateFrom']} 到 {$_GET['dateTo']})");
        $smarty->assign('rowset',$arr);
        //$smarty->assign('arr_field_info',$arrFieldInfo);
		//$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('arr_field_info200',$psFieldInfo);
		//$smarty->assign('arr_field_value200',$psRowset);
		$smarty->assign('client_name',$compName);

        $smarty->display('CaiWu/Ar/OutData.tpl');
    }
    /**
     * ps ：改良PrintCheckFormOld（上一版）
     * Time：2017-09-30 10:39:47
     * @author zcc
     * @param 参数类型
     * @return 返回值类型
    */
    function actionPrintCheckForm(){
    	$clientId	= $_GET['clientId'];
		$dateFrom	= $_GET['dateFrom'];
		$dateTo		= $_GET['dateTo'];
		$str = "SELECT 
			y.vatNum,y.parentGangId,y.cntPlanTouliao,y.pihao,y.vatId,y.unitKg,y.dateDuizhang,y.id as planId,y.isHuixiuCk,
			z.wareId,z.color,z.colorNum,z.cntKg,z.danjia,z.money,z.wareNameBc,z.kuanhao,
			m.orderCode2,m.paymentWay,m.orderCode,m.clientId,m.dateOrder,m.dateJiaohuo,z.zhelvMx
			FROM plan_dye_gang y
			left join trade_dye_order2ware z on z.id = y.order2wareId
			left join trade_dye_order m on m.id = z.orderId
			where m.clientId='$clientId' and y.dateDuizhang>='$dateFrom' and y.dateDuizhang<='$dateTo' 
			order by ";
		$str .= isset($_GET['sortBy']) ? $_GET['sortBy'] : "dateDuizhang,orderCode,y.id";	
		$m = FLEA::getSingleton('Model_JiChu_Client');
		$arr = $m->find($clientId);
		$compName = $arr[fullName]?$arr[fullName]:$arr[compName];
		if ($arr[paymentWay]==0) $paymentWayName = '投料';
		if ($arr[paymentWay]==1) $paymentWayName = '净重';
		if ($arr[paymentWay]==2) $paymentWayName = '折率净重';
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$rowset = $m->findBySql($str);
		foreach ($rowset as &$v) {
			//求出折率净重
			$v['jingKgZ'] = $jingKgZ=$this->_modelGang->getCpckJingkgZ($v['planId']);
			$v['jingKg'] = $jingKg=$this->_modelGang->getCpckJingkg($v['planId']);
			$v['jingMg'] = $jingMg=$this->_modelGang->getCpckMaokg($v['planId']);
			if ($arr['paymentWay']==0) {
				$v[cnt] = $v['cntPlanTouliao'];
			}
			if ($arr['paymentWay']==1) {
				$v[cnt] = $jingKg;
			}
			if ($arr['paymentWay']==2) {
				$v[cnt] = $jingKgZ;
			}
			if ($v['danjia']>0) { //存在单价时 则用单价*数量 
				$v['moneyFs'] = round($v['danjia']*$v['cnt'],2);
			}else{//否则则调取订单设置那边的总价
				$v['moneyFs'] = $v['money'];
			}
			$v['cntPlanTouliao2'] = $v['cntPlanTouliao'];
			// if ($v['parentGangId']>0) {
			// 	$v['moneyFs'] = '';
			// 	$v['cntPlanTouliao2'] = '';
			// }
			if ($v['parentGangId']>0) {
				if ($v['isHuixiuCk']==1) {//未出库整缸回修
					//获取同一原缸的所有未出库整缸回修(可能无效，防止讲不是最后一缸回修出库导致数据问题)
					$sql = "SELECT id FROM plan_dye_gang 
						WHERE parentGangId={$v['parentGangId']} 
						AND isHuixiuCk=1  order by id desc limit 0,1";
					$LastHuixiu = $this->_modelExample->findBySql($sql);
					if ($v['planId']!=$LastHuixiu[0]['id']) {
						$v['cntPlanTouliao2'] = 0;
						if ($arr['paymentWay']==0) {
							$v['moneyFs'] = '';
						}
					}
				}else{
					$v['cntPlanTouliao2'] = 0;
					if ($arr['paymentWay']==0) {
						$v['moneyFs'] = '';
					}
				}

			}
			$rowWare = $modelWare->find($v[wareId]);
			if (count($rowWare)>0) {
				if ($v['wareNameBc']) {
					$v[wareName] = $v['wareNameBc'];
				}else{
					$v[wareName] = $rowWare[wareName].' '.$rowWare[guige];
				}
			}
		}
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','cntPlanTouliao2','cnt','money','moneyFs','jingMg','jingKg','jingKgZ'),'dateCpck');
		$heji['cntPlanTouliao'] = $heji['cntPlanTouliao2'];
		$rowset[] = $heji;
		$arrFieldInfo = array(
			// "orderCode" =>"<a href='".$this->_url($_GET['action'],array(
			// 	'sortBy'=>'orderCode',
			// 	'dateFrom'=>$_GET['dateFrom'],
			// 	'dateTo'=>$_GET['dateTo'],
			// 	'clientId'=>$_GET['clientId'],
			// ))."'>定单号</a>",
			"dateDuizhang" =>"<a href='".$this->_url($_GET['action'],array(
				'dateFrom'=>$_GET['dateFrom'],
				'dateTo'=>$_GET['dateTo'],
				'clientId'=>$_GET['clientId'],
			))."'>发货日期</a>",
			"vatNum" =>"缸号",
			"wareName"=>"纱支",
			'colorNum'=>'色号',
			'kuanhao'=>'款号',
			"color"=>"颜色",
			// 'zhelvMx'=>'折率',
			'cntPlanTouliao'=>'投料数',
			'jingMg'=>'毛重',
			'jingKg'=>'净重',
			'jingKgZ'=>'计价重',
			// "cnt"=>"数量",
			"danjia"=>"染色单价",
			"moneyFs"=>"发生金额",
		);
		$smarty = & $this->_getView();
		$smarty->assign('title',"筒染对账单-$compName({$_GET['dateFrom']} 到 {$_GET['dateTo']})");
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('client_name',$compName);
		$smarty->assign('paymentWayName',$paymentWayName);
        if($_GET['export']==1) {
			header("Pragma: public");
		    header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment;filename=test.xls");
			header("Content-Transfer-Encoding: binary");
			$smarty->display('Export2Excel.tpl');exit;
		}
		$smarty->display('CaiWu/Ar/ArCheckForm.tpl');exit;
    }
    /**
     * ps ：根据成品出库明细来显示对账单
     * Time：2017年12月6日 10:40:38
     * @author zcc
    */
    function actionPrintCheckFormCk(){
    	$clientId	= $_GET['clientId'];
		$dateFrom	= $_GET['dateFrom'];
		$dateTo		= $_GET['dateTo'];
		$Sql = "SELECT
				x.dateCpck,x.jingKgZ,x.jingKg,x.maoKg as jingMg,x.id as chukuId,
				y.vatNum,y.cntPlanTouliao,y.parentGangId,y.id as gangId,y.isHuixiuCk,
				z.danjia,z.money,z.wareNameBc,z.wareId,z.colorNum,z.color,z.kuanhao,
				m.clientId,m.paymentWay
			FROM
				chengpin_dye_cpck x
			LEFT JOIN plan_dye_gang y ON x.planId = y.id
			LEFT JOIN trade_dye_order2ware z ON z.id = y.order2wareId
			LEFT JOIN trade_dye_order m ON m.id = z.orderId
			where m.clientId='$clientId' and x.dateCpck>='$dateFrom' and x.dateCpck<='$dateTo' 
			order by  ";
		$Sql .= isset($_GET['sortBy']) ? $_GET['sortBy'] : "dateCpck,y.id";	
		$m = FLEA::getSingleton('Model_JiChu_Client');
		$arr = $m->find($clientId);
		$compName = $arr[fullName]?$arr[fullName]:$arr[compName];
		if ($arr[paymentWay]==0) $paymentWayName = '投料';
		if ($arr[paymentWay]==1) $paymentWayName = '净重';
		if ($arr[paymentWay]==2) $paymentWayName = '折率净重';
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		// dump($Sql);die();
		$rowset = $m->findBySql($Sql);
		$hejiNew = array();
		foreach ($rowset as &$v) {
			if ($arr['paymentWay']==0) {
				$v[cnt] = $v['cntPlanTouliao'];
			}
			if ($arr['paymentWay']==1) {
				$v[cnt] = $v['jingKg'];
			}
			if ($arr['paymentWay']==2) {
				$v[cnt] = $v['jingKgZ'];
			}
			if ($v['danjia']>0) { //存在单价时 则用单价*数量 
				$v['moneyFs'] = round($v['danjia']*$v['cnt'],2);
			}else{//否则则调取订单设置那边的总价
				$v['moneyFs'] = $v['money'];
			}
			$v['cntPlanTouliao2'] = $v['cntPlanTouliao'];
			if ($v['parentGangId']>0) {
				if ($v['isHuixiuCk']==1) {//未出库整缸回修
					//获取同一原缸的所有未出库整缸回修(可能无效，防止讲不是最后一缸回修出库导致数据问题)
					$sql = "SELECT id FROM plan_dye_gang 
						WHERE parentGangId={$v['parentGangId']} 
						AND isHuixiuCk=1  order by id desc limit 0,1";
					$LastHuixiu = $this->_modelExample->findBySql($sql);
					if ($v['gangId']!=$LastHuixiu[0]['id']) {
						$v['cntPlanTouliao2'] = 0;
						if ($arr['paymentWay']==0) {
							$v['moneyFs'] = '';
						}
					}
				}else{
					$v['cntPlanTouliao2'] = 0;
					if ($arr['paymentWay']==0) {
						$v['moneyFs'] = '';
					}
				}
			}
			//相同缸号的 的投料数不进行叠加如合计
			$hejiNew[$v['gangId']] = $v['cntPlanTouliao2'];
			if ($arr['paymentWay']==0) {
				//获取这个出库的 第一条数据
				$sql = "SELECT * 
					FROM chengpin_dye_cpck  
					where planId= '{$v['gangId']}' order by id asc limit 0,1";
				$cpck = $this->_modelExample->findBySql($sql);
				if ($cpck[0]['id'] != $v['chukuId']) {//当本条数据不等于第一条出库数据时
					$v['moneyFs'] = ''; //让金额为空数据
				}
			}
			$rowWare = $modelWare->find($v[wareId]);
			if (count($rowWare)>0) {
				if ($v['wareNameBc']) {
					$v[wareName] = $v['wareNameBc'];
				}else{
					$v[wareName] = $rowWare[wareName].' '.$rowWare[guige];
				}
			}
		}
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','cntPlanTouliao2','cnt','money','moneyFs','jingMg','jingKg','jingKgZ'),'dateCpck');
		$heji['cntPlanTouliao'] = array_sum($hejiNew);
		$rowset[] = $heji;
		$arrFieldInfo = array(
			// "orderCode" =>"<a href='".$this->_url($_GET['action'],array(
			// 	'sortBy'=>'orderCode',
			// 	'dateFrom'=>$_GET['dateFrom'],
			// 	'dateTo'=>$_GET['dateTo'],
			// 	'clientId'=>$_GET['clientId'],
			// ))."'>定单号</a>",
			"dateCpck" =>"<a href='".$this->_url($_GET['action'],array(
				'dateFrom'=>$_GET['dateFrom'],
				'dateTo'=>$_GET['dateTo'],
				'clientId'=>$_GET['clientId'],
			))."'>发货日期</a>",
			"vatNum" =>"缸号",
			"wareName"=>"纱支",
			'colorNum'=>'色号',
			"color"=>"颜色",
			"kuanhao"=>"款号",
			// 'zhelvMx'=>'折率',
			'cntPlanTouliao'=>'投料数',
			'jingMg'=>'毛重',
			'jingKg'=>'净重',
			'jingKgZ'=>'计价重',
			// "cnt"=>"数量",
			"danjia"=>"染色单价",
			"moneyFs"=>"发生金额",
		);
		$smarty = & $this->_getView();
		$smarty->assign('title',"筒染对账单-$compName({$_GET['dateFrom']} 到 {$_GET['dateTo']})");
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('client_name',$compName);
		$smarty->assign('paymentWayName',$paymentWayName);
        if($_GET['export']==1) {
			header("Pragma: public");
		    header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment;filename=test.xls");
			header("Content-Transfer-Encoding: binary");
			$smarty->display('Export2Excel.tpl');exit;
		}
		$smarty->display('CaiWu/Ar/ArCheckForm.tpl');exit;	
    }
    //打印应收款对账单
	function actionPrintCheckFormOld() {
  //   if($_GET['export']==1){
  //       header("Pragma: public");
	 //    header("Expires: 0");
		// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		// header("Content-Type: application/force-download");
		// header("Content-Type: application/download");
		// header("Content-Disposition: attachment;filename=test.xls");
		// header("Content-Transfer-Encoding: binary");
  //       $tpl='CaiWu/Ar/OutData.tpl';
  //   }else{
  //   	$tpl='CaiWu/Ar/ArCheckForm.tpl'
  //   }
		$clientId	= $_GET['clientId'];
		$dateFrom	= $_GET['dateFrom'];
		$dateTo		= $_GET['dateTo'];

		//应收款,除掉回修的缸。parentGangId=0
		$str = "select x.*,y.compName,x.danjia*x.cntChuku+money as money
			from view_dye_cpck_ar x
			inner join jichu_client y on x.clientId=y.id
			where x.clientId='$clientId' and dateCpck>='$dateFrom' and dateCpck<='$dateTo' and parentGangId=0 order by ";
		$str .= isset($_GET['sortBy']) ? $_GET['sortBy'] : "dateCpck,orderCode";

		$str = "select
			`y`.`vatNum` AS `vatNum`,
			`y`.`parentGangId` AS `parentGangId`,
			`y`.`cntPlanTouliao` AS `cntPlanTouliao`,
			`y`.`pihao` AS `pihao`,
			`y`.`vatId` AS `vatId`,
			`y`.`unitKg` AS `unitKg`,
			y.dateDuizhang as dateDuizhang,
			`z`.`manuCode` AS `manuCode`,
			`z`.`wareId` AS `wareId`,
			`z`.`color` AS `color`,
			`z`.`colorNum` AS `colorNum`,
			`z`.`cntKg` AS `cntKg`,
			`z`.`danjia` AS `danjia`,
			`z`.`money` AS `money`,
			`m`.`orderCode` AS `orderCode`,
			`m`.`clientId` AS `clientId`,
			`m`.`dateOrder` AS `dateOrder`,
			`m`.`dateJiaohuo` AS `dateJiaohuo`,
			m.orderCode2,m.paymentWay,
			z.danjia*y.cntPlanTouliao+z.money as money,
			y.id as planId
			from plan_dye_gang y
			join trade_dye_order2ware z on `y`.`order2wareId` = `z`.`id`
			join `trade_dye_order` `m` on `z`.`orderId` = `m`.`id`
			where m.clientId='$clientId' and y.dateDuizhang>='$dateFrom' and y.dateDuizhang<='$dateTo' and y.parentGangId=0
			order by ";
		$str .= isset($_GET['sortBy']) ? $_GET['sortBy'] : "dateDuizhang,orderCode";
		//echo $str;
		$m = FLEA::getSingleton('Model_JiChu_Client');
		$arr = $m->find($clientId);
		$compName = $arr[compName];
		if ($arr[paymentWay]==0) $paymentWayName = '投料';
		if ($arr[paymentWay]==1) $paymentWayName = '净重';
		if ($arr[paymentWay]==2) $paymentWayName = '折率净重';

		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$rowset = $m->findBySql($str);
		foreach ($rowset as & $value) {
			$sql = "SELECT * FROM chengpin_dye_cpck where planId = '{$value['planId']}'";
			
			$chenpin = $this->_modelExample->findBySql($sql);
			// dump($chenpin);die();
			if ($value['paymentWay']=='2') {
				$value['ShijiCnt'] = $chenpin[0]['jingKgZ'];
			}else{
				$value['ShijiCnt'] = $chenpin[0]['jingKg'];
			}
			$value['money'] = $value['danjia']*$value['ShijiCnt'];
			$modelPlan = & FLEA::getSingleton('Model_Plan_Dye_Gang');
			$rowPlan = $modelPlan->findByField('vatNum',$value[vatNum]);
			$modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
			$rowOrder = $modelOrder->findByField('id', $rowPlan[OrdWare][orderId], null, 'orderCode');
			$value[orderCode] = $rowOrder[orderCode];
			//$value[cntPlanTouliao] = $rowPlan[cntPlanTouliao];
			$rowWare = $modelWare->find($value[wareId]);
			if (count($rowWare)>0) {
				$value[wareName] = $rowWare[wareName].' '.$rowWare[guige];
			}
			$totalCnt += $value[cntChuku];
			$totalMone += $value[money];
			$value['dateCpck']=$value['dateDuizhang'];
		}
		//$rowset = array_column_sort($rowset,'dateCpck',SORT_ASC);
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','money'),'orderCode');

		$rowset[] = $heji;

		$arrFieldInfo = array(
			"orderCode" =>"<a href='".$this->_url($_GET['action'],array(
				'sortBy'=>'orderCode',
				'dateFrom'=>$_GET['dateFrom'],
				'dateTo'=>$_GET['dateTo'],
				'clientId'=>$_GET['clientId'],
			))."'>定单号</a>",
			"dateDuizhang" =>"<a href='".$this->_url($_GET['action'],array(
				'dateFrom'=>$_GET['dateFrom'],
				'dateTo'=>$_GET['dateTo'],
				'clientId'=>$_GET['clientId'],
			))."'>发货日期</a>",
			//"vatNum" =>"缸号",
			"wareName"=>"纱支",
			'colorNum'=>'色号',
			"color"=>"颜色",
			'zhelv'=>'折率',
			"cntPlanTouliao"=>"数量",
			//"cntKg"=>"投料数",
			//"cntJian"=>"件数",
			//"cntTongzi"=>"筒子数"
			"danjia"=>"染色单价",
			"money"=>"发生金额",
		);

		//$mm="<input id=outbutt type=button value=" 导 出 " onClick=\"window.location.href='{url controller=$smarty.get.controller action="OutData"},'export'=>1'\">"
		$smarty = & $this->_getView();
		$smarty->assign('title',"筒染对账单-$compName({$_GET['dateFrom']} 到 {$_GET['dateTo']})");
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);

        //$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'],$arr)).$mm);
		// $smarty->assign('arr_field_info200',$psFieldInfo);
		// $smarty->assign('arr_field_value200',$psRowset);

		$smarty->assign('client_name',$compName);
		$smarty->assign('paymentWayName',$paymentWayName);
        if($_GET['export']==1) {
        	//dump($rowset);exit;
        	//dump($psRowset);dump($rowset);exit;
			header("Pragma: public");
		    header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment;filename=test.xls");
			header("Content-Transfer-Encoding: binary");
			$smarty->display('Export2Excel.tpl');exit;
		}
		$smarty->display('CaiWu/Ar/ArCheckForm.tpl');exit;
	}

	//对账单改为以第一次出库日期为基础，以投料数为准计算金额，以下为调整老数据的方法
	function actionUpDb() {
		set_time_limit(0);
		mysql_query("ALTER TABLE plan_dye_gang ADD `dateDuizhang` DATE NOT NULL COMMENT '财务对账日期以第一次出库为准',ADD INDEX ( `dateDuizhang` )");
		$sql = "select min(dateCpck) as d,x.planId  from chengpin_dye_cpck x
			group by x.planId";
		$query = mysql_query($sql) or die(mysql_error());
		while($re = mysql_fetch_assoc($query)) {
			$s = "update plan_dye_gang set dateDuizhang='{$re['d']}' where id='{$re['planId']}'";
			mysql_query($s) or die(mysql_error());
			//$arr[] = array('id'=>$re['planId'],'dateDuizhang'=>$re['d']);
		}
		echo "升级完毕";
	}

	//一个月内的计划查询
		function actionOrderSearch() {
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			//dateFrom =>date("Y-m-d"),
			dateTo => date("Y-m-d"),
			clientId => '',
			orderCode => ''
		));

		$condition=array(
			array('dateOrder', "$arrGet[dateFrom]", '>='),
			array('dateOrder', "$arrGet[dateTo]", '<='),
			//array('clientId', $arrGet[clientId])
		);
		if ($arrGet[clientId] != '') $condition[]=array('clientId',"$arrGet[clientId]");
		if ($arrGet[orderCode] != '') $condition[] = array('orderCode', "%$arrGet[orderCode]%", 'like');

		$rowset = $this->_modelOrder->findAll($condition,'dateOrder desc');
		//dump($rowset[0]);
		$modelWare = FLEA::getSingleton('Model_JiChu_Ware');
		$modelClient = FLEA::getSingleton('Model_JiChu_Client');
		$mOrdware = FLEA::getSingleton('Model_Trade_Dye_Order2Ware');

		$i = 0;
		$cntCount = 0;
		foreach ($rowset as & $value) {
			//dump($value);
			$arr = $modelClient->find($value["clientId"]);
			if (count($value["Ware"]) > 0) {
				foreach ($value["Ware"] as & $item) {
					$rowsetCopy[$i]["dateOrder"] = $value["dateOrder"];
					$rowsetCopy[$i]["orderCode"] = $this->_modelOrder->getOrderTrack($value["id"],$value["orderCode"]);
					$rowsetCopy[$i][color] = $item[color];
					$rowsetCopy[$i][colorNum] = $item[colorNum];
					$rowsetCopy[$i][cntKg] = $item[cntKg];
					if($value['orderCode2']!=''){
					    $rowsetCopy[$i]['clientName'] = $value[Client][compName].'('.$value['orderCode2'].')';
					}else{
					    $rowsetCopy[$i]["clientName"] = $value[Client][compName];
					}

					$cntCount += $item[cntKg];
					$rowsetCopy[$i][cntPlanTouliao] = $mOrdware->getCntPlanTouliao($item[id]);
					$rowsetCopy[$i][cntCpck] = $mOrdware->getCpckChanliang($item[id]);

					$rowWare = $modelWare->findByField("id", $item["wareId"]);
					if (count($rowWare) > 0) {
						$rowsetCopy[$i]["wareName"] = $rowWare["wareName"]."||".$rowWare["guige"];
					}
					$i++;
				}
			}
		}

		//dump($rowsetCopy);

		//加入合计行

		$rowsetCopy[$i][dateOrder] ='<b>合计</b>';
		$rowsetCopy[$i][cntKg] = "<b>".$cntCount."</b>";

		#对表头进行赋值
		$arrFieldInfo = array(
			"dateOrder" =>"日期",
			"clientName" =>"客户(客户编号)",
			"orderCode" =>"订单号",
			"wareName" =>"纱支",
			"color" =>"颜色",
			"colorNum" =>"色号",
			"cntKg" =>"要货数",
			"cntPlanTouliao"=>"投料数",
			"cntCpck"=>"成品发出"
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', '订单查询');
		$smarty->assign('arr_field_value',$rowsetCopy);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition', $arrGet);
		$smarty->display('TableList.tpl');
	}
	#将对账日期进行补漏
	function actionBulou(){
		set_time_limit(0);
		$str="select * from plan_dye_gang where dateDuizhang='0000-00-00'";
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			//dump($re);
			$str1="select * from trade_dye_order2ware where id='{$re['order2wareId']}'";
			//echo $str1.'<br>';
			$re1=mysql_fetch_assoc(mysql_query($str1));
			$str2="update plan_dye_gang set dateDuizhang='{$re1['dateDuizhang']}' where id='{$re['id']}'";
			mysql_query($str2);
		}
		//exit;
		echo '操作成功！';
		exit;
	}
	/**
	 * ps ：退库缸号列表
	 * Time：2017年12月1日 14:04:09
	 * @author zcc
	*/
	function actionTuikuList(){
		FLEA::loadClass('TMIS_Pager');
		//TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),date('d')-30,date("Y"))),
			dateTo=>date("Y-m-d"),
			clientId=>0,
			vatNum=>'',
			'color'=>'',
			'wareName'=>'',
			isReport=>0
		));

		$Sql ="SELECT x.dateCpck,SUM(x.cntChuku)as cntChuku,SUM(x.jingKg)as jingKg,SUM(x.jingKgZ)as jingKgZ,
				SUM(x.maoKg)as maoKg,y.compName,concat(y.guige,' ',y.wareName) as shazhi,y.color,
				y.vatCode,y.cntPlanTouliao,y.orderId,y.clientId,y.orderCode,y.vatNum,y.gangId
			FROM chengpin_dye_cpck x 
			inner join view_dye_gang y on x.planId=y.gangId
			WHERE 1 and x.kind = 0
			";
		if ($arr['dateFrom']) {
			$Sql .= " and x.dateCpck >='$arr[dateFrom]' and x.dateCpck<='$arr[dateTo]'";
		}	
		if ($arr[vatNum]!='') {
			$Sql .= " and y.vatNum like '%$arr[vatNum]%'";
		}
		if ($arr['color']!='') $Sql .= " and y.color like '%$arr[color]%'";
		if ($arr['clientId']>0) $Sql .= " and y.clientId='$arr[clientId]'";

		$Sql .= " GROUP BY y.gangId  order by dateCpck desc,vatNum";
		//重新构造一个sql 让zhushu 能进行搜索
		$sql = "select * from ($Sql) as a where 1 ";
		//echo $str;
		if ($arr[shazhi]!='') $sql .= " and a.shazhi like '%$arr[wareName]%'";
		$pager =& new TMIS_Pager($sql);
		$rowset = $pager->findAllBySql($sql);
		// dump($rowset);die();
		foreach ($rowset as &$v) {
			$v['_edit'] = '<a href="'.$this->_url('AddTuiku',array('gangId'=>$v['gangId'])).'">退库</a> ';
		}
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','cntChuku','jingKg','jingKgZ','cntJian','cntTongzi'),'dateCpck');
		$rowset[] = $heji;
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"dateCpck" =>"出库日期",
			'compName' => '客户',
			"orderCode" =>"定单号",
			"vatNum" =>"缸号",
			"shazhi" => "纱支",
			"color" =>"颜色",
			"vatCode" =>"物理缸号",
			"cntPlanTouliao" =>"投料数",
			'cntChuku'=>'本次发货',
			"jingKg"=>"净重",
			"jingKgZ"=>"计价重量",
			"_edit" => '操作',
			// "cntJian"=>"件数",
			// "cntTongzi"=>"筒子数",
		);
		$smarty->assign('title','筒染成品出库');
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('isClient',1);//是否显示客户不同 1 为是 0 为否
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps ：退库登记界面
	 * Time：2017年12月1日 14:58:15
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionAddTuiku(){
		// if (!$this->_editable($_GET[id])) js_alert('该出库单已经被财务审核过了！您不能修改！','window.history.go(-1)');
		$sql = "SELECT x.id as gangId,x.vatNum,x.cntPlanTouliao,x.unitKg,x.planTongzi,v.vatCode,
			y.zhelvMx as zhelv,c.paymentWay as paymentWay
 		FROM plan_dye_gang x 
		left join trade_dye_order2ware y on y.id = x.order2wareId
		left join trade_dye_order z on z.id = y.orderId
		left join jichu_client c on c.id = z.clientId
		left join jichu_vat v on v.id = x.vatId
		where x.id ='{$_GET['gangId']}'";
		// dump($sql);die();
		$order = $this->_modelExample->findBySql($sql);
		$smarty = & $this->_getView();
		$smarty->assign("title",'成品退库登记');
		$smarty->assign("arr_field_value",$order[0]);
		$smarty->assign("zhelv",$order[0]['zhelv']);
		$smarty->assign("paymentWay",$order[0]['paymentWay']);
		$smarty->display('Chengpin/Dye/CptkEdit.tpl');
	}
	function actionSaveTuiku(){
		$model = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr = $model->find("vatNum='$_POST[vatNum]'");

		// //判断是否应该修改对账日期
		// if($arr['dateDuizhang']>$_POST['dateCpck'] || $arr['dateDuizhang']=='0000-00-00') {
		// 	$uRow = array('id'=>$arr['id'],'dateDuizhang'=>$_POST['dateCpck']);
		// 	$model->update($uRow);
		// }
		$row = array(
			'id' =>$_POST['id'],
			'dateCpck' =>$_POST['dateCpck'],
			'planId' =>$_POST['gangId'],
			'cntChuku' =>$_POST['cntChuku']*-1,
			'jingKg' =>$_POST['jingKg']*-1,
			'cntJian' =>$_POST['cntJian']*-1,
			'cntTongzi' =>$_POST['cntTongzi']*-1,
			'jingKgZ' =>$_POST['jingKgZ']*-1,
			'maoKg' =>$_POST['maoKg']*-1,
			'kind' =>1,
			'memo' =>$_POST['memo'],
			'creater' =>$_SESSION['REALNAME']

		);
		// dump($row);die();
        $cpckId = $this->_modelExample->save($row);
        if ($cpckId) {
        	redirect($this->_url('Tuiku'));
        }
		
	}
	/**
	 * ps ：退库数据查询
	 * Time：2017年12月1日 15:53:52
	 * @author zcc
	*/
	function actionTuiku(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),date('d')-30,date("Y"))),
			dateTo=>date("Y-m-d"),
			clientId=>0,
			vatNum=>'',
			'color'=>'',
			'wareName'=>'',
			isReport=>0
		));

		$Sql ="SELECT x.*,y.compName,concat(y.guige,' ',y.wareName) as shazhi,y.color,
				y.vatCode,y.cntPlanTouliao,y.orderId,y.clientId,y.orderCode,y.vatNum,y.gangId
			FROM chengpin_dye_cpck x 
			inner join view_dye_gang y on x.planId=y.gangId
			WHERE 1 and x.kind = 1
			";
		if ($arr['dateFrom']) {
			$Sql .= " and x.dateCpck >='$arr[dateFrom]' and x.dateCpck<='$arr[dateTo]'";
		}	
		if ($arr[vatNum]!='') {
			$Sql .= " and y.vatNum like '%$arr[vatNum]%'";
		}
		if ($arr['color']!='') $Sql .= " and y.color like '%$arr[color]%'";
		if ($arr['clientId']>0) $Sql .= " and y.clientId='$arr[clientId]'";

		$Sql .= " order by dateCpck desc,vatNum";
		//重新构造一个sql 让zhushu 能进行搜索
		$sql = "select * from ($Sql) as a where 1 ";
		//echo $str;
		if ($arr[shazhi]!='') $sql .= " and a.shazhi like '%$arr[wareName]%'";
		$pager =& new TMIS_Pager($sql);
		$rowset = $pager->findAllBySql($sql);
		// dump($rowset);die();
		foreach ($rowset as &$v) {
			$v['_edit'] .= '<a href="'.$this->_url('EditTuiku',array('id'=>$v['id'])).'">修改</a> ';
			$v['_edit'] .= '&nbsp;&nbsp;<a href="'.$this->_url('RemoveTuiku',array('id'=>$v['id'])).'" onclick="return confirm(\'您确认要删除吗?\')">删除</a> ';
			$v['cntChuku'] = abs($v['cntChuku']);
			$v['jingKg'] = abs($v['jingKg']);
			$v['jingKgZ'] = abs($v['jingKgZ']);
			$v['cntJian'] = abs($v['cntJian']);
			$v['cntTongzi'] = abs($v['cntTongzi']);
		}
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','cntChuku','jingKg','jingKgZ','cntJian','cntTongzi'),'dateCpck');
		$rowset[] = $heji;
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			"dateCpck" =>"退库日期",
			'compName' => '客户',
			"orderCode" =>"定单号",
			"vatNum" =>"缸号",
			"shazhi" => "纱支",
			"color" =>"颜色",
			"vatCode" =>"物理缸号",
			"cntPlanTouliao" =>"投料数",
			'cntChuku'=>'本次退库',
			"jingKg"=>"退库净重",
			"jingKgZ"=>"退库计价重量",
			"cntJian"=>"件数",
			"cntTongzi"=>"筒子数",
			"dt"=>"创建时间",
			"_edit" => '操作',
		);
		$smarty->assign('title','筒染成品出库');
		$smarty->assign('arr_edit_info',$arrEditInfo);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('isClient',1);//是否显示客户不同 1 为是 0 为否
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList.tpl');
	}
	//退库修改
	function actionEditTuiku(){

		$sql = "SELECT x.id as gangId,x.vatNum,x.cntPlanTouliao,x.unitKg,x.planTongzi,v.vatCode,
			y.zhelvMx as zhelv,c.paymentWay as paymentWay,cp.*
 		FROM plan_dye_gang x 
 		left join chengpin_dye_cpck cp on cp.planId = x.id
		left join trade_dye_order2ware y on y.id = x.order2wareId
		left join trade_dye_order z on z.id = y.orderId
		left join jichu_client c on c.id = z.clientId
		left join jichu_vat v on v.id = x.vatId
		where cp.id ='{$_GET['id']}'";
		// dump($sql);die();
		$order = $this->_modelExample->findBySql($sql);
		foreach ($order as &$v) {
			$v['cntChuku'] = abs($v['cntChuku']);
			$v['maoKg'] = abs($v['maoKg']);
			$v['jingKg'] = abs($v['jingKg']);
			$v['jingKgZ'] = abs($v['jingKgZ']);
			$v['cntJian'] = abs($v['cntJian']);
			$v['cntTongzi'] = abs($v['cntTongzi']);
		}
		$smarty = & $this->_getView();
		$smarty->assign("title",'成品退库登记');
		$smarty->assign("arr_field_value",$order[0]);
		$smarty->assign("zhelv",$order[0]['zhelv']);
		$smarty->assign("paymentWay",$order[0]['paymentWay']);
		$smarty->display('Chengpin/Dye/CptkEdit.tpl');
	}
	//退库删除
	function actionRemoveTuiku(){
		// dump($this->delFuncId);die();
		$this->authCheck($this->delFuncId);
		// $this->_editable($_GET[$pk]);
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[$pk]);
		redirect($this->_url("Tuiku"));
	}
	/**
	 * ps ：未发货汇总表
	 * Time：2018年1月12日 09:26:48
	 * @author zcc
	*/
	function actionNoFahuoReport(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),date('d')-30,date("Y"))),
			'dateTo'   =>date("Y-m-d"),
			'clientId' =>0,
			'vatNum'   =>'',
			'orderCode' =>'',
			'orderKind' =>'',
		));
		//整缸回修的原缸号不显示
		$str="SELECT x.*,z.compName,z.orderCode,z.orderCode2,x.id as planId
			FROM plan_dye_gang x
			LEFT JOIN (SELECT * FROM chengpin_dye_cpck GROUP BY planId) y ON x.id = y.planId
			left join view_dye_gang z on z.gangId=x.id
			WHERE 1 
			AND x.isCpRuku = 1 AND y.id is null
			AND NOT EXISTS (SELECT id FROM plan_dye_gang b WHERE b.parentGangId = x.id AND b.isHuixiuCk=1)
	    ";
		if($arr[dateFrom]!=''&&$arr[dateTo]!='') $str.=" and x.planDate>='$arr[dateFrom]' and x.planDate<='$arr[dateTo]'";
		if($arr['vatNum']!='') $str.=" and x.vatNum like '%$arr[vatNum]%'";
		if($arr['clientId']!=0) $str.=" and z.clientId='$arr[clientId]'";
		if($arr['orderCode']!='') $str.=" and z.orderCode like '%$arr[orderCode]%'";
		if($arr['orderKind']!='') $str.=" and z.orderKind='$arr[orderKind]'";
		$str.=" order by x.planDate desc ,x.id desc";
		$sql= "SELECT * FROM($str) as a WHERE 1";
		// dump($sql);die;
		$pager = new TMIS_Pager($sql);
		// dump($pager);die();
		$rowset = $pager->findAllBySql($sql);
		$rowsetAll = $this->_modelExample->findBySql($sql);
		$modelOrder2Ware = &FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		foreach ($rowset as & $v) {
			//求出这个缸号的入库数据
			$sql = "SELECT SUM(jingKg) as jingKg,SUM(maoKg) as maoKg,SUM(cntJian) as cntJian,SUM(cntTongzi) as cntTongzi
				FROM chengpin_dye_cprk 
				WHERE planId='{$v['planId']}'";
			$ruku = $this->_modelExample->findBySql($sql);
			$v['maoKg'] = $ruku[0]['maoKg'];
			$v['jingKg'] = $ruku[0]['jingKg'];
			$v['cntJian'] = $ruku[0]['cntJian'];
			$v['cntTongzi'] = $ruku[0]['cntTongzi'];
		    $rowOrder2Ware = $modelOrder2Ware->findByField('id', $v[order2wareId]);
		    //dump($rowOrder2Ware);
		    $v[color] = $rowOrder2Ware[color];
		    $v[guige] = $rowOrder2Ware[Ware][wareName]." ".$rowOrder2Ware[Ware][guige];
		    //得到客户单号
		    if($v['orderCode2']!='') $v['compName']=$v['compName'].'('.$v['orderCode2'].')';
		   	$arrGang=$this->_modelGang->find(array('id'=>$v['planId']));
		   	$v['cntPlanTouliao2'] = $v['cntPlanTouliao'];
		   	if ($v['parentGangId']>0) {//判断为回修缸 (由于整缸回修不显示圆钢这样就排除了振刚回修导致的投料数合计影响)
		   		if ($v['isHuixiuCk']==0) {//不是整缸回修的情况下
		   			$v['cntPlanTouliao2'] = 0;
		   		}
		   	}
		}
		$heji = $this->getHeji($rowset,array('cntPlanTouliao','cntPlanTouliao2','planTongzi','maoKg','jingKg','cntJian','cntTongzi'),'planDate');
		$heji['cntPlanTouliao'] = $heji['cntPlanTouliao2'];
		foreach ($rowsetAll as & $va) {
			$sql = "SELECT SUM(jingKg) as jingKg,SUM(maoKg) as maoKg,SUM(cntJian) as cntJian,SUM(cntTongzi) as cntTongzi
				FROM chengpin_dye_cprk 
				WHERE planId='{$va['planId']}'";
			$ruku = $this->_modelExample->findBySql($sql);
			$va['maoKg'] = $ruku[0]['maoKg'];
			$va['jingKg'] = $ruku[0]['jingKg'];
			$va['cntJian'] = $ruku[0]['cntJian'];
			$va['cntTongzi'] = $ruku[0]['cntTongzi'];
			$va['cntPlanTouliao2'] = $va['cntPlanTouliao'];
			if ($va['parentGangId']>0) {//判断为回修缸 (由于整缸回修不显示圆钢这样就排除了振刚回修导致的投料数合计影响)
		   		if ($va['isHuixiuCk']==0) {//不是整缸回修的情况下
		   			$va['cntPlanTouliao2'] = 0;
		   		}
		   	}
		}
		$zongji = $this->getHeji($rowsetAll,array('cntPlanTouliao','cntPlanTouliao2','planTongzi','maoKg','jingKg','cntJian','cntTongzi'),'planDate');
		$zongji['cntPlanTouliao'] = $zongji['cntPlanTouliao2'];
		$zongji['planDate'] = "<b>总计</b>";
		$rowset[] = $heji;
		$rowset[] = $zongji;
		//dump($rowset);
		//exit;
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
		   "planDate" =>"计划日期",
		    "vatNum" =>"缸号",
		    "orderCode" =>"订单号",
		    'compName' => '客户(客户单号)',
		    "guige" =>"纱支",
		    "color" =>"颜色",
		    "cntPlanTouliao" =>"投料",
		    "planTongzi" =>"计划筒数",
		    //"vatCode" =>"物理缸号",
		    'maoKg' =>'入库毛重',
		    "jingKg"=>"入库净重",
		    "cntJian"=>"入库件数",
		    "cntTongzi"=>"入库筒子数",

		);
		$span = "&nbsp;&nbsp;<span><b>显示的数据均为已完成入库未出库的缸号汇总</b></span>";
		$smarty->assign('title','未发货汇总表');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])).$span);
		$smarty->display('TableList.tpl');
	}
    

    //成品收发存报表，按照缸号来汇总
	function actionMonthReport(){
        FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
			vatNum => '',
			clientId=>'',
			isKucun=>0
		));
		$dateFrom = $arrGet['dateFrom'];
		$dateTo = $arrGet['dateTo'];
		if($arrGet['vatNum']!=''){
			$str = " and vatNum like '%{$arrGet['vatNum']}%'";
		}
		if($arrGet['clientId']!=''){
			$str.=" and clientId ='{$arrGet['clientId']}'";
		}
		if($arrGet['isKucun']>=0){
			if($arrGet['isKucun']==1){
                $str1.= " having sum(initCnt+rukuCnt-chukuCnt)=0 ";
			}elseif ($arrGet['isKucun']==0) {
				$str1.=" having sum(initCnt+rukuCnt-chukuCnt)<>0";
			}
		}
		//期初入库
		$initRk = "SELECT sum(jingKg) as initCnt,0 as rukuCnt,0 as chukuCnt,x.planId
			FROM chengpin_dye_cprk x 
			where 1 and x.dateCprk<'{$arrGet['dateFrom']}' group by x.planId";
		//期初出库
		$initCk = "SELECT sum(-1*jingKg) as initCnt,0 as rukuCnt,0 as chukuCnt,x.planId
			FROM chengpin_dye_cpck x 
			where 1 and x.dateCpck<'{$arrGet['dateFrom']}' group by x.planId";	
		//本期入库
		$benqiRk = "SELECT 0 as initCnt,sum(jingKg) as rukuCnt,0 as chukuCnt,x.planId
			FROM chengpin_dye_cprk x 
			where 1 and x.dateCprk>='{$arrGet['dateFrom']}' and x.dateCprk<='{$arrGet['dateTo']}' group by x.planId";
		//本期出库	
		$benqiCk = "SELECT 0 as initCnt,0 as rukuCnt,sum(jingKg) as chukuCnt,x.planId
			FROM chengpin_dye_cpck x 
			where 1 and x.dateCpck>='{$arrGet['dateFrom']}' and x.dateCpck<='{$arrGet['dateTo']}' group by x.planId";	
		$sql = "SELECT 
			sum(initCnt) as initCnt,
			sum(rukuCnt) as rukuCnt,
			sum(chukuCnt) as chukuCnt,
			sum(initCnt+rukuCnt-chukuCnt) as kucun,
			w.vatNum,c.compName,CONCAT(j.wareName,j.guige) as wareName,c.id as clientId
			FROM ($initRk union $initCk union $benqiRk union $benqiCk) as a
			left join plan_dye_gang w on w.id = a.planId
			left join trade_dye_order2ware o on o.id=w.order2wareId
			left join trade_dye_order d on d.id=o.orderId
			left join jichu_client c on c.id=d.clientId
			left join jichu_ware j on j.id=o.wareId
			WHERE 1 and w.id is not null ".$str;
		$sql .= " GROUP BY a.planId {$str1} order by a.planId";		
		// dump($sql);exit;
		$pager = new TMIS_Pager($sql);
		$rowset=$pager->findAll();
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
		    "vatNum" =>"缸号",
		    "compName"=>"客户",
		    "wareName"=>"纱支",
		    "initCnt" =>"期初",
		    "rukuCnt" =>"入库",
		    "chukuCnt" =>"出库",
		    'kucun' => '结存',
		);
		$smarty->assign('title','成品收发存报表');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display('TableList.tpl');
	}
}

?>