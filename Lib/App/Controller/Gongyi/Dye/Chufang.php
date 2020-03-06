<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Gongyi_Dye_Chufang extends Tmis_Controller {
	var $_modelExample;
	//var $funcId;
	function Controller_Gongyi_Dye_Chufang() {
		$this->_modelExample = & FLEA::getSingleton('Model_Trade_Dye_Order2ware');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelExample->enableLink('Chufang');
		$this->_modelClient = & FLEA::getSingleton('Model_JiChu_Client');
		$this->_modelPlan =  & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$this->_modelChufang =  & FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$this->_modelChufang2Ware =  &FLEA::getSingleton('Model_Gongyi_Dye_Chufang2Ware');
		$this->_modelVat = &FLEA::getSingleton('Model_JiChu_Vat');
		$this->_modelVat2s = & FLEA::getSingleton('Model_JiChu_Vat2shuirong');
		$this->_modelWare = &FLEA::getSingleton('Model_jiChu_Ware');
		//$this->_modelPlan = & FLEA::getSingleton('Model_Gongyi_Dye_Chufang_Gang');
	}


	/**
	 * @desc ：处方登记列表，仅显示未并缸的单号
	 * Time：2016/07/04 15:03:50
	 * @author Wuyou
	*/

	function actionRight(){
		$this->authCheck(81);

		//echo "显示计划单列表";exit;
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			clientId	=>'',
			wareId		=>'',
			color		=>'',
			orderCode	=>'',
			colorNum    =>'',
			cntPlanTouliao=>'',
			'vatNum' =>'',
		));

		/*if ($arrGet[clientId] != '') $condition[] = array('Order.clientId', $arrGet[clientId]);
		if ($arrGet[color]!='') $condition[]=array('color',"%$arrGet[color]%", 'like');
		if ($arrGet[colorNum]!='') $condition[]=array('colorNum',"%$arrGet[colorNum]%", 'like');
		if ($arrGet[orderCode] != '') $condition[] = array('Order.orderCode', "%$arrGet[orderCode]%", 'like');
		if ($arrGet[wareId] != '') $condition[] = array('wareId', $arrGet[wareId]);
		if ($arrGet[cntPlanTouliao] != '') $condition[] = array('Pdg.cntPlanTouliao', $arrGet[cntPlanTouliao]);
		//dump($condition); exit;
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset = $pager->findAll();*/
		//dump($rowset[10]);
		$sql="select * from jichu_ware where wareName='CVC' and guige=''";
		$re=mysql_fetch_assoc(mysql_query($sql));
		$sql1="select * from jichu_ware where wareName='40/2TR中长' and guige=''";
		$re1=mysql_fetch_assoc(mysql_query($sql1));
		$sql2="select * from jichu_ware where wareName='T/C' and guige=''";
		$re2=mysql_fetch_assoc(mysql_query($sql2));
		$sql3="select * from jichu_ware where wareName='涤粘TR' and guige=''";
		$re3=mysql_fetch_assoc(mysql_query($sql3));
		//echo 1;exit;
		/*$str="select x.*,y.dateOrder,y.clientId,y.orderCode,
			n.wareName,n.guige
			from trade_dye_order2ware x
			left join trade_dye_order y on y.id=x.orderId
			left join plan_dye_gang z on z.order2wareId=x.id
			left join gongyi_dye_chufang m on m.order2wareId=x.id
			left join jichu_ware n on n.id=x.wareId
			where (m.id is NULL or( n.leftId>='{$re['leftId']}' and n.rightId<='{$re['rightId']}' and m.id is not NULL))
		";*/
		/*$str="select x.*,y.dateOrder,y.clientId,y.orderCode,
			n.wareName,n.guige
			from trade_dye_order2ware x
			left join trade_dye_order y on y.id=x.orderId
			left join plan_dye_gang z on z.order2wareId=x.id
			left join jichu_ware n on n.id=x.wareId
			where ( not exists(
				select m.* from gongyi_dye_chufang m where ((m.gangId=0 and m.order2wareId=x.id) or (m.gangId>0 and m.gangId=z.id))
			) or(
				((n.leftId>='{$re['leftId']}' and n.rightId<='{$re['rightId']}') or (n.leftId>='{$re1['leftId']}' and n.rightId<='{$re1['rightId']}') or (n.leftId>='{$re2['leftId']}' and n.rightId<='{$re2['rightId']}') or (n.leftId>='{$re3['leftId']}' and n.rightId<='{$re3['rightId']}')) and exists(
					select m.* from gongyi_dye_chufang m where ((m.gangId=0 and m.order2wareId=x.id) or (m.gangId>0 and m.gangId=z.id)))
				)
			)
		";*/
		$str = "select x.*,y.dateOrder,y.clientId,y.orderCode,
			n.wareName,n.guige
			from trade_dye_order2ware x
			left join trade_dye_order y on y.id=x.orderId
			left join plan_dye_gang z on z.order2wareId=x.id
			left join jichu_ware n on n.id=x.wareId
			where	((
				(n.leftId>='{$re['leftId']}' and n.rightId<='{$re['rightId']}') or
				(n.leftId>='{$re1['leftId']}' and n.rightId<='{$re1['rightId']}') or
				(n.leftId>='{$re2['leftId']}' and n.rightId<='{$re2['rightId']}') or
				(n.leftId>='{$re3['leftId']}' and n.rightId<='{$re3['rightId']}')
			) || (
				!(
					(n.leftId>='{$re['leftId']}' and n.rightId<='{$re['rightId']}') or
					(n.leftId>='{$re1['leftId']}' and n.rightId<='{$re1['rightId']}') or
					(n.leftId>='{$re2['leftId']}' and n.rightId<='{$re2['rightId']}') or
					(n.leftId>='{$re3['leftId']}' and n.rightId<='{$re3['rightId']}')
				)
			)) and x.isComplete=0 and z.binggangId<=0";
		//echo $str;exit;
		if ($arrGet['clientId'] != '') $str.=" and y.clientId='{$arrGet['clientId']}'";
		if ($arrGet['color']!='') $str.=" and x.color like '%{$arrGet['color']}%'";
		if ($arrGet['colorNum']!='') $str.=" and x.colorNum like '%{$arrGet['colorNum']}%'";
		if ($arrGet['orderCode'] != '') $str.=" and y.orderCode like '%{$arrGet['orderCode']}%'";
		if ($arrGet['wareId'] != '') $str.=" and x.wareId='{$arrGet['wareId']}'";
		if ($arrGet['cntPlanTouliao'] != '') $str.=" and z.cntPlanTouliao='{$arrGet['cntPlanTouliao']}'";
		if ($arrGet['vatNum'] != '') $str.=" and z.vatNum like '%{$arrGet['vatNum']}%'";
		$str.=" group by x.id";
		$str.=" order by y.dateOrder desc,z.vatNum";
		//dump($str);//exit;
		$pager =& new TMIS_Pager($str);
		$rowset = $pager->findAll();

		if(count($rowset)>0) foreach($rowset as & $row) {
			/*$row[dateOrder] = $row[Order][dateOrder];
			$row[orderCode] = $this->_modelOrder->getOrderTrack($row[Order][id],$row[Order][orderCode]);;*/
			$cli = $this->_modelClient->find($row[clientId]);
			$row[compName] = $cli[compName];
			$row[guige] = $row[wareName] . " " . $row[guige];
			$row['Pdg']=$this->_modelPlan->findAll(array('order2wareId'=>$row['id']));
			$row['Chufang']=$this->_modelChufang->findAll(array('order2wareId'=>$row['id']));
			if(count($row[Pdg])==0) {
				$row[vatNum] = '<font color=red>未计划</font>';
			} else {
				$row[vatNum] = join("<br>",array_col_values($row[Pdg],'vatNum'));
				$row[cntPlanTouliao] = join("<br>",array_col_values($row[Pdg],'cntPlanTouliao'));
			}
			/*$paigang=array();
			if(count($row['Pdg'])>0)foreach($row['Pdg'] as & $v){
				//dump($v);
				$v['vatNum']=$this->_modelPlan->setVatNum($v['id'],$v['order2wareId']);
				#将已经开了处方的缸去掉
				$str="select * from gongyi_dye_chufang where order2wareId='{$v['order2wareId']}' and gangId='{$v['id']}'";
				$re=mysql_fetch_assoc(mysql_query($str));
				if(!$re){
					$paigang[]=$v;
				}
			}
			$row['Pdg1']=$paigang;
			if(count($row[Pdg1])==0) {
				$row[vatNum] = '<font color=red>未计划</font>';
			} else {
				$row[vatNum] = join("<br>",array_col_values($row[Pdg1],'vatNum'));
				$row[cntPlanTouliao] = join("<br>",array_col_values($row[Pdg1],'cntPlanTouliao'));
			}*/

			//状态 开处方次数
			if(count($row[Chufang])==0) {
				$row[statue] = "<font color=red>未开</font>";
			} else $row[statue] = count($row[Chufang]);

			$row[_edit] = "<a href='".$this->_url('setChufang',array(
				'order2wareId' => $row[id],
				'return' => $_GET['action']
			))."'>开处方</a>";

			$row['color'] =" <a href='".$this->_url('setChufang',array(
				'order2wareId' => $row[id],
				'return' => $_GET['action']
			))."'>".($row['color']==''?'&nbsp;':$row['color'])."</a>";
			 //得到客户单号
			$clientCode=$this->_modelOrder->find(array('id'=>$row['orderId']));
			if($clientCode['orderCode2']!='') $row['compName']=$row['compName'].'('.$clientCode['orderCode2'].')';
		}
		$arr_field_info = array(
			dateOrder => '下单日期',
			vatNum => '缸号',
			orderCode => '订单号',
			compName => '客户(客户单号)',
			guige => '坯纱规格',
			color => '颜色',
			colorNum => '色号',
			cntKg => '要货数量',
			// vatNum => '缸号',
			cntPlanTouliao => '计划投料数',
			statue => '已开处方',
			_edit => '操作'
		);
		//dump($rowset);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','开处方');
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}

	//新增处方
	function actionSetChufang() {
		$this->authCheck(83);
		//已经领料，系统禁止修改
		$chuku = FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$ck=$chuku->findAll(array('chufangId'=>$_GET['chufangId']));
		//dump(count($ck));exit;
		if(count($ck)>0){
			js_alert('已经领料，禁止修改!', '',$_SERVER[HTTP_REFERER]);
		}
		//获得这个处方的客户
		$sql = "SELECT y.clientId
		FROM trade_dye_order2ware x
		left join trade_dye_order y on y.id = x.orderId
		where x.id = {$_GET['order2wareId']}";
		$order = $this->_modelExample->findBySql($sql);
		$clientId = $order[0]['clientId'];
		//得到前处理方案
		$qclRow=array();
		$qclSql="SELECT * FROM `jichu_gongyi` where kind='前处理' group by gongyiName";
		$query=mysql_query($qclSql);
		while($re=mysql_fetch_assoc($query)) {
			$qclRow[]=$re;
		}
		//得到染色方案
		$rsRow=array();
		$rsSql="SELECT * FROM `jichu_gongyi` where kind='染色' group by gongyiName";
		$query=mysql_query($rsSql);
		while($re=mysql_fetch_assoc($query)) {
			$rsRow[]=$re;
		}
		//得到后处理方案
		$hclRow=array();
		$hclSql="SELECT * FROM `jichu_gongyi` where kind='后处理' group by gongyiName";
		$query=mysql_query($hclSql);
		while($re=mysql_fetch_assoc($query)) {
			$hclRow[]=$re;
		}
		//得到染色染料的方案
		$rscfRow=array();
		$hclSql="SELECT * FROM `jichu_gongyi` where kind='染色染料' group by gongyiName";
		$query=mysql_query($hclSql);
		while($re=mysql_fetch_assoc($query)) {
			$rscfRow[]=$re;
		}
		$this->authCheck(83);
		$mgy= & FLEA::getSingleton('Model_Jichu_Gongyi');
		$gongyi=$mgy->findAll(null,'gongyiName');
		$con = array(
			'order2wareId'	=> $_GET['order2wareId'],
			'id'			=> $_GET['chufangId']
		);
		if($con['id']>0)
		$chufang = $this->_modelChufang->find($con);
		//by zcc 给自动完成的文本框带入修改的值
		$sql = "SELECT * FROM `jichu_gongyi` where id='{$chufang['rsgyId']}'";
		$a = $this->_modelExample->findBySql($sql);
		$selRanseName = $a[0]['gongyiName'];
		$sql = "SELECT * FROM `jichu_gongyi` where id='{$chufang['qclId']}'";
		$a = $this->_modelExample->findBySql($sql);
		$selQclName = $a[0]['gongyiName'];
		$sql = "SELECT * FROM `jichu_gongyi` where id='{$chufang['hclId']}'";
		$a = $this->_modelExample->findBySql($sql);
		$selHclName = $a[0]['gongyiName'];
		$sql = "SELECT * FROM `jichu_gongyi` where id='{$chufang['rscfId']}'";
		$a = $this->_modelExample->findBySql($sql);
		$selRscfName = $a[0]['gongyiName'];

		$str="select y.* from acm_userdb x
			left join jichu_employ y on y.id=x.employId
			where x.id='{$_SESSION['USERID']}'
			and y.id is not NULL
		";
		$re=mysql_fetch_assoc(mysql_query($str));
		$chufangren=$re;
		if($re&&empty($chufang)){
			$chufang['chufangrenId']=$re['id'];
		}
		//dump($_SESSION);
		if($_GET['chufangId']!=''&&$chufangren['id']!=$chufang['chufangrenId']&&$_SESSION['USERNAME']!='admin'){
			js_alert('您不能修改该处方人的处方单！','',$this->_url('list'));
			exit;
		}

		$m = & FLEA::getSingleton('Model_JiChu_Ware');
		$arrQ = array();//前处理
		$arrR = array();//染色数组
		$arrZ = array();//后处理数组
		$arrC = array();//染色处理数组
		//dump($chufang['Ware']);exit;
		if(count($chufang['Ware'])>0)
		foreach($chufang['Ware'] as & $row) {
			$row['Ware'] = $m->find($row['wareId']);
			if ($_GET['editModel']=='copy')
			$row['id']='';
			if($row['gongxuId']==1)
				$arrQ[] = $row;
			else if($row['gongxuId']==3)
				$arrZ[] = $row;
			else if($row['gongxuId']==2)
				$arrR[] = $row;
			else if($row['gongxuId']==4)
				$arrC[] = $row;
		}
		// dump($arrQ);exit;
		//某一颜色下所有的缸
		$m1 = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$gang1=$m1->findAll(array(order2wareId=>$_GET[order2wareId]));
		$gangs=array();
		if($_GET['chufangId']==''){
			if(count($gang1))foreach($gang1 as & $v){
				$v['Ware'] = $this->_modelWare->find($v['OrdWare']['wareId']);
				$vat2s = $this->_modelVat2s->find($v['vat2shuirongId']);
				$v['Vat']['shuirongNew'] = $vat2s['shuirong'];
				// $str="select * from gongyi_dye_chufang where order2wareId='{$v['order2wareId']}' and gangId='{$v['id']}'";
				// $re=mysql_fetch_assoc(mysql_query($str));
				// if(!$re){
				// 	$gangs[]=$v;
				// }
				$gangs[] = $v; //这里的意思是：之前判断开过处方的就不显示在适用缸号下拉框里，现在客户提到了双染的情况，一个缸号可以开1次以上的处方，所以把上面的代码注释。
			}
		}else{
			if(count($gang1))foreach($gang1 as & $v){
				$vat2s = $this->_modelVat2s->find($v['vat2shuirongId']);
				$v['Vat']['shuirongNew'] = $vat2s['shuirong'];
				$v['Ware'] = $this->_modelWare->find($v['OrdWare']['wareId']);

			}
			$gangs=$gang1;
		}


		$loop=count($arrR);
		if($loop<4) $loop=3;
		$loop2=count($arrZ);
		if($loop2<6) $loop2=5;
		$loop3=count($arrQ);
		if($loop3<6) $loop3=5;
		$loop4=count($arrC);
		if($loop4<6) $loop4=5;
		//开始显示
		// dump($gangs);die();
		$smarty = & $this->_getView();
		$smarty->assign('loop',$loop);
		$smarty->assign('loop2',$loop2);
		$smarty->assign('loop3',$loop3);
		$smarty->assign('loop4',$loop4);
		$smarty->assign('chufang',$chufang);
		$smarty->assign('gongyi',$gongyi);
		$smarty->assign('ranliao',$arrR);
		$smarty->assign('zhuji',$arrZ);
		$smarty->assign('qcl',$arrQ);
		$smarty->assign('rscf',$arrC);
		$smarty->assign('edit_model', $_GET['editModel']);
		$smarty->assign('gangs',$gangs);
		$smarty->assign('rsRow',$rsRow);
		$smarty->assign('hclRow',$hclRow);
		$smarty->assign('qclRow',$qclRow);
		$smarty->assign('rscfRow',$rscfRow);
		$smarty->assign('chufangren',$chufangren);
		$smarty->assign('clientId',$clientId);
		$smarty->assign('selRanseName',$selRanseName);
		$smarty->assign('selQclName',$selQclName);
		$smarty->assign('selHclName',$selHclName);
		$smarty->assign('selRscfName',$selRscfName);
		//dump($chufang);
		$smarty->assign('chufang_id', $_GET['chufangId']);
		$smarty->assign('order2ware_id', $_GET['order2wareId']);
		$smarty->display('Gongyi/Dye/ChufangEdit.tpl');
	}

	//拷贝处方
	function actionCopyChufang() {
		$this->authCheck(83);
		redirect($this->_url('SetChufang',array(
			'order2wareId'	=> $_GET['order2wareId'],
			'chufangId'		=> $_GET['chufangId'],
			'editModel'		=> 'copy' //告诉edit是copy模式
		)));
	}

	//保存处方,以多行方式提交的界面
	function actionSaveChufang() {
		// dump($_POST);exit;
		//更新主表数据, 并得出chufangId
		$count = count($_POST['shuirong']);
		if ($count>0) for($i=0; $i<$count; $i++){
			if ($_POST['shuirong2'][$i] > 0) {
				$_POST['shuirong'][$i] = $_POST['shuirong2'][$i];
			}
		}
		$mGang = & FLEA::getSingleton("Model_Plan_Dye_Gang");
		if($_POST['gangId']) foreach ($_POST['gangId'] as $key=>&$v){
			$arrGang[] = array(
				'id'=>$v,
				'zhelv'=>$_POST['zhelv'][$key]+0,
				'shuirong'=>$_POST['shuirong'][$key],
			);
		}
		$mGang->saveRowset($arrGang);
		//更新主表数据, 并得出chufangId
		//dump($_POST);exit;
		$arr = array(
			'id' =>  $_POST['chufangId']+0,
			'dyeKind' => $_POST['dyeKind'],
			'vatId' => $_POST['vatId'],
			'chufangren' => 'xxx', //为了兼容以前的版本中的fuchfangren设定的默认值
			'chufangrenId' => $_POST['chufangrenId']+0,
			'order2wareId'=> $_POST['order2wareId']+0,
			'gangId'=>$_POST['gangId2']+0,
			'dateChufang' => $_POST['dateChufang'],
			//'gongyiKind'=>$_POST['gongyiKind'],
			'rhlZhelv'=>$_POST['rhlZhelv'],
			'rsgyId'=>$_POST['selRanse'],
			'hclId'=>$_POST['selHcl'],
			'qclId'=>$_POST['selQcl'],
			'rscfId'=>$_POST['selRscf'],
            //'pisha_qcl'=>$_POST['pisha_qcl']
			'ranseKind'=>$_POST['ranseKind'],
			//'isComplete'=>$_POST['isComplete']
			'memoQcl'=>$_POST['memoQcl'],
			'memoRs'=>$_POST['memoRs'],
			'memoHcl'=>$_POST['memoHcl'],
			'memoCf'=>$_POST['memoCf'],
			'chufangKind'=>$_POST['chufangKind'],//by zcc 新增 处方性质
		);
		//dump($arr);exit;
		if($_POST['order2wareId']&&$_POST['isComplete'])
		$this->_modelExample->update(array('id'=>$_POST['order2wareId'],'isComplete'=>$_POST['isComplete']));
		$chufangId=$this->_modelChufang->save($arr);//如果是新增, 则返回新增数量主健, 如果是修改, 则返回bool类型
		if($_POST[chufangId]>0) $chufangId=$_POST[chufangId];


		//插入明细
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		//dump($_POST);EXIT;
		foreach($_POST['unitKg'] as $key=>$v) {
			//如果没有选择染料跳过不保存
			if($_POST['mnemocode'][$key]=='')
			{
				if($_POST['chufang2WareId']!=''){
					$this->_modelChufang2Ware->removeByPkv($_POST['chufang2WareId'][$key]);
				}
			    continue;
			}
			//如果没有数量则跳过不保存
			if(empty($v)) {
				//在edit模块下, 如果数量不存在, 还在删除数量没有的老数据
				if(!empty($_POST[chufang2WareId][$key])) {
					$this->_modelChufang2Ware->removeByPkv($_POST[chufang2WareId][$key]);
				}
				continue;
			}
			//dump($_POST);exit;
			//保存数据
			$temp = explode('/',$_POST['mnemocode'][$key]);
			$last = count($temp)-1;
			$ware = $mWare->find($temp[$last]);
			//dump($ware);exit;

			if ($ware && $_POST['unitKg'][$key]!='0.0') {
				//echo($_POST['unit'][$key]."<br>");
				$w[]=array(
					'id'=>$_POST['chufang2WareId'][$key],
					'gongxuId'=>$_POST['gongxuId'][$key],
					'chufangId' => $chufangId,
					'wareId'=>$ware['id'],
					'unitKg'=>$_POST['unitKg'][$key],
					'unit'=>$_POST['unit'][$key],
					'tmp'=>$_POST['tmp'][$key],
					'timeRs'=>$_POST['timeRs'][$key],
					'memo' => $_POST['memo'][$key],
					'nums'=>$key,
				);
			}
		}
		//exit;
		//dump($w);exit;
		$newId = $this->_modelChufang2Ware->saveRowset($w);
		if($newId===true) $newId =$_POST[chufangId];

		if($_POST['Submit']=='确定并打印') {
			//dump($_POST);exit;
			$m = & FLEA::getSingleton("Model_Plan_Dye_Gang");
			$m->clearLinks();

			//dump($gangs);exit;
			if($_POST['gangId2']>0) {
				redirect($this->_url('PrintDirectly',array(
					'chufangId'		=> $chufangId,
					'gangId'=>$_POST['gangId2'],
					'kind'=>'1'
				)));
				exit;
			}
			$gangs = $m->findAll(array('order2wareId'=>$_POST['order2wareId']));
			//dump($gangs);exit;
			if(count($gangs)>0) {//如果有多个缸，显示缸列表
				if(count($gangs)==1){
					redirect($this->_url('PrintDirectly',array(
					'chufangId'		=> $chufangId,
					'gangId'=>$gangs[0]['id'],
					'kind'=>'1'
				)));
				exit;
				}
				echo "请选择打印<br/>";
				foreach($gangs as $v){
				echo "<a href='{$this->_url('PrintDirectly',array(
										'chufangId'		=> $chufangId,
										'gangId'=>$v['id'],
										'kind'=>'1'
									))}' target='__blank'>{$v['vatNum']}</a><br/>";
				}
				exit;
			} else {
				js_alert('未发现有缸!!','',$this->_url($_POST['return']));
			}
		}
		else{
			//dump($_POST['return']);exit;
			redirect($this->_url($_POST['return']));
		}
	}

	//处方管理列表
	function actionList() {
		$this->authCheck(85);
		$mChufang = FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$mClient = FLEA::getSingleton('Model_Jichu_Client');

		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			//dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			//dateTo => date("Y-m-d"),
			clientId=>'',
			orderCode=>'',
			vatNum=>'',
			wareId=>'',
			color=>'',
			'colorNum' =>'',
			cntPlanTouliao=>'',
			//chufangren=>'0',
			chufangrenId=>0,
			chufangId=>0,

		));


		$sql = "select a.*, b.color, b.colorNum, b.wareId, b.cntKg, c.orderCode,c.orderCode2, c.clientId,c.id as orderId
			from gongyi_dye_chufang a
			left join trade_dye_order2ware b on a.order2wareId = b.id
			left join trade_dye_order c on b.orderId = c.id
			where 1";
		if ($arr['clientId']!='') $sql .=	" and clientId=$arr[clientId]";
		if ($arr[orderCode]!='') $sql .= " and orderCode like '%$arr[orderCode]%'";
		if ($arr[vatNum]!='') {
			//$sql .= " and order2wareId in (select order2wareId from plan_dye_gang
			//where vatNum like '%$arr[vatNum]%')";
			$ss = "select order2wareId from plan_dye_gang
			where vatNum like '%$arr[vatNum]%'";
			$temp = $mClient->findBySql($ss);
			$tempArr = array('');
			foreach($temp as &$v) {
				$tempArr[] = $v['order2wareId'];
			}
			if(count($temp)>0) {
				$sql .= " and order2wareId in ('".join("','",$tempArr)."')";
			}else{
				$sql .=" and 0";
			}
		}
		if ($arr[wareId] != '') $sql .= " and wareId=$arr[wareId]";
		if ($arr[color] != '') $sql .= " and color like '%$arr[color]%'";
		if ($arr[colorNum] != '') $sql .= " and b.colorNum like '%$arr[colorNum]%'";
		if ($arr[cntPlanTouliao] != '') $sql .= " and cntKg = $arr[cntPlanTouliao]";
		//if ($arr[chufangren]!='0') $sql .= " and chufangren='$arr[chufangren]'";
		if ($arr[chufangrenId]>0) $sql .= " and chufangrenId='$arr[chufangrenId]'";
		if ($arr[chufangId]>0) $sql .= " and a.id='$arr[chufangId]'";

		//点击订单号之后按订单号排序 by-zhujunjie
		if($_GET['sort']==1){
			$arr['sort']=1;
		}

		//点击订单号之后按订单号排序
		if($_GET['sort']==1||$arr['sort']==1){
			$sql .= " group by a.id order by orderCode desc";
		}else{
			$sql .= " group by a.id order by dateChufang desc";
		}

		$pageSize = 20;
		$pager = & new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAll();

		//dump($rowset[0]);
		$mEmploy = &FLEA::getSingleton('Model_JiChu_Employ');

		if(count($arr)>0) foreach($rowset as & $row) {
			if ($row[chufangrenId] != 0) {
				$rowEmploy = $mEmploy->find($row[chufangrenId]);
				$row[chufangren] = $rowEmploy[employName];
			}
			#取得规格参数
			if($row[wareId]>0) $rowWare=$this->_modelWare->find($row[wareId]);
			$row[guige] = $rowWare[wareName] . " " .$rowWare[guige];

			#取得公司名称
			$rowClient = $mClient->find($row[clientId]);
			$row[clientName] = $rowClient[compName];
			$row['orderCode']=$this->_modelOrder->getOrderTrack($row[orderId],$row[orderCode]);
			//取得客户单号
			if($row['orderCode2']!='') $row['clientName']=$row['clientName'].'('.$row['orderCode2'].')';
			#显示操作项
			$row[_edit] = "<a href='".$this->_url('CopyChufang',array(
				'order2wareId' => $row[order2wareId],
				chufangId => $row[id]
			))."'>复制</a> | <a href='".$this->_url('setChufang',array(
				'order2wareId' => $row[order2wareId],
				chufangId => $row[id],
				'return'=>$_GET['action']
			))."'>编辑</a> | <a href='".$this->_url('RemoveChufang',array(
				id => $row[id],
			))."'>删除</a>";
			$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
                #显示逻辑缸号和打印,如果gangId>0则只显示某一缸
                if ($row[gangId]>0) {//只显示某一缸

                    $aGang = $m->find(array(id=>$row[gangId]));
					$row['vatNum']=$m->setVatNum($row['gangId'],$row['order2wareId']);
                    $row[vatNum] = "<a href='".$this->_url('PrintDirectly', array(
						'id' => $row['order2wareId'],
                        'chufangId' => $row['id'],
						'gangId'=>$row['gangId'],
						'preview'=>1
					))."' title='点击查看详细' target='_blank'>".$row[vatNum]."</a>&nbsp;&nbsp;&nbsp;<a href='".$this->_url('PrintDirectly', array(
                        'id' => $row['order2wareId'],
                        'chufangId' => $row['id'],
						'gangId'=>$row['gangId']
                    ))."'  target='_blank' >打印</a>";
                } else {
                    $ordWare = $this->_modelExample->find($row[order2wareId]);
					$str="select * from plan_dye_gang where order2wareId='{$row['order2wareId']}' and parentGangId=0";
					$query=mysql_query($str);
					$ordWare1=array();
					while($re=mysql_fetch_assoc($query)){
						$ordWare1[]=$re;
					}
                    //if(count($ordWare[Pdg])>0) {
					if(count($ordWare1)>0) {
                        //foreach($ordWare[Pdg] as &$tempV) {
						foreach($ordWare1 as &$tempV) {
                            if ($arr[vatNum] != '') {
                                if ($tempV[vatNum] == trim($arr[vatNum]))
                                    $row[display] = 'true';
                            }
							$tempV['vatNum']=$m->setVatNum($tempV['id'],$row['order2wareId']);
                            $tempV[vatNum] = "<a href='".$this->_url('PrintDirectly', array(
								id => $row[order2wareId],
								chufangId => $row[id],
								gangId => $tempV[id],
								'preview'=>1
							))."' title='点击查看详细' target='_blank'>".$tempV[vatNum]."</a>&nbsp;&nbsp;&nbsp;<a href='".$this->_url('PrintDirectly', array(
                                id => $row[order2wareId],
                                chufangId => $row[id],
                                gangId => $tempV[id]
                            ))."'  target='_blank' >打印</a>";

                        }
                        //$tempArr = array_col_values($ordWare[Pdg],'vatNum');
						$tempArr = array_col_values($ordWare1,'vatNum');
                        $row[vatNum] = join("<br>",$tempArr);
                    }
                }
            }

		//dump($rowset[0]); exit;

		$arr_field_info = array(
			dateChufang => '开方日期',
			orderCode => "<a href='".$this->_url($_GET['action'],array('sort'=>1))."'>订单号</a>",
			clientName => '客户(客户单号)',
			guige => '坯纱规格',
			color => '颜色',
			'colorNum'=>'色号',
			cntKg => '总公斤数',
			vatNum => '适用缸号',
			chufangren => '处方人',
			_edit => '操作'
		);
        // dump($rowset);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','已开处方管理');
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');		//取消新增按钮
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('List', $arr)));
		$smarty->display('TableList.tpl');
	}

	//处方合并操作列表
	function actionMerge() {
		$smarty = & $this->_getView();
		$smarty->display('Gongyi/Dye/ChufangMerge.tpl');
	}

	//处方管理列表
	function actionListForMerge() {
		//$this->authCheck(85);
		$title = '选择需要合并的缸';
		$mChufang = FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$mClient = FLEA::getSingleton('Model_Jichu_Client');

		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom=>date('Y-m-d'),
			dateTo=>date('Y-m-d'),
			clientId=>'',
			vatNum=>'',
			color=>'',
			//orderCode=>'',
			//vatNum=>''
		));


		$sql = "select a.*,
			b.color, b.colorNum, b.wareId, b.cntKg, b.orderCode, b.clientId,b.compName,
			b.vatNum,b.wareName,b.guige,b.orderId,b.cntPlanTouliao,b.gangId as realGangId
			from gongyi_dye_chufang a
			left join view_dye_gang  b on a.order2wareId = b.order2wareId
			where mergeId=0";
		if ($arr['clientId']!='') $sql .=	" and clientId=$arr[clientId]";
		if ($arr[dateFrom]!='') $sql .=	" and a.dateChufang>='{$arr[dateFrom]}'";
		if ($arr[dateTo]!='') $sql .=	" and a.dateChufang<='{$arr[dateTo]}'";
		if ($arr['vatNum']!='') $sql .=	" and b.vatNum like '%$arr[vatNum]%'";
		if ($arr['color']!='') $sql .=	" and b.color like '%$arr[color]%'";
		$sql .= " order by dateChufang DESC";

		//echo($sql);
		$pageSize = 20;
		$pager = & new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAll();
		//dump($rowset[0]);
		$mEmploy = &FLEA::getSingleton('Model_JiChu_Employ');
		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		if(count($arr)>0) foreach($rowset as & $row) {
			$row['vatNum']=$modelGang->setVatNum($row['realGangId'],$row['order2wareId']);
			if ($row[chufangrenId] != 0) {
				$rowEmploy = $mEmploy->find($row[chufangrenId]);
				$row[chufangren] = $rowEmploy[employName];
			}

			$row['guige'] = $row['wareName'].' ' . $row['guige'];
			//$row['orderCode']=$this->_modelOrder->getOrderTrack($row[orderId],$row[orderCode]);
			 //得到客户单号
			$clientCode=$this->_modelExample->find(array('id'=>$row['orderId']));
			if($clientCode['orderCode2']!='') $row['compName']=$row['compName'].'('.$clientCode['orderCode2'].')';
			#显示操作项
			$row[_edit] = "<a href='#' onclick='window.parent.addRow(".json_encode($row).")'>选择1</a>";
			//$row[_edit] = "<a href='#' onclick=\"window.parent.addRow(".json_encode($row).")\">选择1</a>";
		}

		//dump($rowset[0]); exit;

		$arr_field_info = array(
			vatNum => '缸号',
			dateChufang => '开方日期',
			orderCode => '订单号',
			compName => '客户(客户单号)',
			guige => '坯纱规格',
			color => '颜色',
			cntKg => '总公斤数',
			chufangren => '处方人',
			_edit => '操作'
		);
		$smarty = & $this->_getView();
		$smarty->assign('title',$title);
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');		//取消新增按钮
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	function actionSaveMerge() {
		//dump($_POST);exit;
		$p=&$_POST;
		$mMerge = & FLEA::getSingleton("Model_Gongyi_Dye_Merge");
		$arr = array(
			'vatId'=>$p['vatId'],
			'shuirong'=>$p['shuirong'],
			'rsZhelv'=>$p['rsZhelv']
		);
		if ($p['gangId']){
			foreach($p['gangId'] as $k =>&$v){
				$arr['Gang'][] = array(
					'id'=>$_POST['gangId'][$k],
					'mergeChufangId'=>$_POST['chufangId'][$k]
				);
			}
		}
		//dump($arr);exit;
		$id=$mMerge->save($arr);
		if($id) {
			if($_POST['Submit']=='确定并打印') {
				redirect($this->_url('PrintMerge',array(
					'mergeId'=>$id
				)));
			} else {
				redirect($this->_url('ListMerge'));
			}
		};

	}
	function actionListMerge() {
		////////////////////////////////标题
		$title = '合并处方列表';
		///////////////////////////////模板文件
		$tpl = 'TableList2.tpl';
		///////////////////////////////表头
		$arr_field_info = array(
			'vatNums'=>'缸号',
			'guiges'=>'纱支',
			'colors'=>'颜色',
			'cnts'=>'投料',
			'shuirong'=>'水容',
			'_edit'=>'操作'
		);
		///////////////////////////////搜索条件
		$arrCon = array(
			//'dateFrom'=>''
		);
		///////////////////////////////模块定义
		$this->authCheck();
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray($arrCon);

		/************构造condition**********/
		/*if($arr['']) {
			$condition[] = array('',$arr['']);
			//$condition[] = array('','%'.$arr[''].'%','like');
		}*/

		$mMerge = & FLEA::getSingleton("Model_Gongyi_Dye_Merge");
		$mGang = & FLEA::getSingleton("Model_Plan_Dye_Gang");
		$pager =& new TMIS_Pager($mMerge,$condition);
        $rowset =$pager->findAll();
		//dump($rowset);
		if(count($rowset)>0) foreach($rowset as & $v){
			///////////////////////////////
			//$this->makeEditable($v,'memoCode');
			$arrGuige = array();
			$arrColor = array();
			$arrCnt = array();
			foreach($v['Gang'] as & $vv) {
				$vv =$mGang->formatRet($vv);
				$arrGuige[] = $vv[OrdWare][Ware][wareName] . ' ' .$vv[OrdWare][Ware][guige];
				$arrColor[] = $vv[OrdWare][color];
				$arrCnt[] = $vv[cntPlanTouliao];
				$vv['vatNum']=$mGang->setVatNum($vv['id'],$vv['order2wareId']);
			}
			//$v = $mGang->formatRet($v);
			//dump($v);exit;
			$v['vatNums'] = join('<br>',array_col_values($v['Gang'],'vatNum'));
			$v['guiges'] = join('<br>',$arrGuige);
			$v['cnts'] = join('<br>',$arrCnt);
			$v['colors'] = join('<br>',$arrColor);
			$v['_edit'] = "<a href='".$this->_url('PrintMerge',array(
				'mergeId'=>$v['id'])
			)."' target='_blank'>打印</a> <a href='".$this->_url('removeMerge',array('id'=>$v['id']))."' onclick=\"return confirm('确认删除吗?')\">删除</a>";

		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
                $smarty->assign('add_display', 'none');		//取消新增按钮
		/*///////////////grid,thickbox,///////////////*/
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display($tpl);
	}
	function actionRemoveMerge() {
		$mMerge = & FLEA::getSingleton("Model_Gongyi_Dye_Merge");
		if($mMerge->removeByPkv($_GET['id'])) redirect($this->_url('listMerge'));
	}
	function actionPrintMerge() {
		//dump($_GET);
		$m = & FLEA::getSingleton("Model_Gongyi_Dye_Merge");
		$mGang = & FLEA::getSingleton("Model_Plan_Dye_Gang");
		$mWare = & FLEA::getSingleton("Model_Jichu_Ware");
		$mChufang = & FLEA::getSingleton("Model_Gongyi_Dye_Chufang");
		$mGongyi = & FLEA::getSingleton("Model_Jichu_Gongyi");
		$arr=$m->find(array('id'=>$_GET['mergeId']));
		if ($arr['Gang']){
			foreach ($arr['Gang'] as $key=>&$v){
				$v= $mGang->formatRet($v);
				$v['Chufang'] = $mChufang->find(array('id'=>$v['mergeChufangId']));
			}
		}
		$ret = array(
			'dateChufang'=>date('Y-m-d'),
			'compName'=>$arr['Gang'][0]['Client']['compName'],
			'color'=>$arr['Gang'][0]['OrdWare']['color'],
			'colorNum'=>$arr['Gang'][0]['OrdWare']['colorNum'],
			'dyeKind'=>$arr['Gang'][0]['Chufang']['dyeKind'],
			'vatCode'=>$arr['Vat']['vatCode'],
			'rsZhelv'=>$arr['rsZhelv'],
			'shuirong'=>$arr['shuirong'],
			'chufangren'=>$arr['Gang'][0]['Chufang']['Chufangren']['employName'],
			'chufangKind'=>$arr['Gang'][0]['Chufang']['dyeKind']
			//'yubi' => round($arr['shuirong']/$gang['cntPlanTouliao'],2),
		);
		//计算要合并的缸
		if ($arr['Gang']){
			foreach ($arr['Gang'] as $key=>&$v){
				$guige = $v['OrdWare']['Ware']['wareName'] . ' ' .$v['OrdWare']['Ware']['guige'];
				$ret['Gang'][] = array(
					'vatNum'=>$v['vatNum'],
					'guige'=>$guige,
					'unitKg'=>$v['unitKg'],
					'planTongzi'=>$v['planTongzi'],
					'cntPlanTouliao'=>$v['cntPlanTouliao'],
					'cntBao'=>$v['cntPlanTouliao']/5,
					'jingzhong'=>$v['cntPlanTouliao']*$v['zhelv']
				);
			}
		}
		$cntPlans = 0;
		$cntTongziAll = 0;
		$cntJingzhongAll = 0;
		foreach ($ret['Gang'] as $key => &$vass) {
			$cntPlans+=$vass['cntPlanTouliao'];
			$gangAll[] = $vass['vatNum'];
			$cntTongziAll+=$vass['planTongzi'];
			$cntJingzhongAll+=$vass['jingzhong'];
		}
		$ret['cntPlanTouliao'] = $cntPlans;
		$ret['cntTongziAll'] = $cntTongziAll;
		$ret['cntJingzhongAll'] = $cntJingzhongAll;
		$ret['ganghao'] = implode(' ', $gangAll);  //缸号
		$ret['yubi'] = round($arr['shuirong']/$ret['cntPlanTouliao'],2);  //浴比
		$ret['touliaoCnt'] = $ret['cntPlanTouliao']*$arr['Gang'][0]['zhelv'];  //投料数
		$rr=$ret;
		//前处理工序
		$qcl=$mGongyi->find(array('id'=>$arr['Gang'][0]['Chufang']['qclId']));
		$arr['Ware']['Qclgy']=$arr['Gang'][0]['memoQcl']!=''?$arr['Gang'][0]['memoQcl']:$qcl['gongyiName'];
        $Qclgy = $arr['Ware']['Qclgy'];
        //染色工序
        $ranse=$mGongyi->find(array('id'=>$arr['Gang'][0]['Chufang']['rsgyId']));
		$arr['Ware']['Rsgy']=$arr['Gang'][0]['memoRs']!=''?$arr['Gang'][0]['memoRs']:$ranse['gongyiName'];
		$Rsgy = $arr['Ware']['Rsgy'];
		//后处理工序
		$hcl=$mGongyi->find(array('id'=>$arr['Gang'][0]['Chufang']['hclId']));
		$arr['Ware']['Hclgy']=$arr['Gang'][0]['memoHcl']!=''?$arr['Gang'][0]['memoHcl']:$hcl['gongyiName'];
		$Hclgy = $arr['Ware']['Hclgy'];
		//新增染色染料工艺
		$rscf=$mGongyi->find(array('id'=>$arr['Gang'][0]['Chufang']['rscfId']));
		$arr['Ware']['rscfgy']= $arr['Gang'][0]['memoCf']!=''?$arr['Gang'][0]['memoCf']:$rscf['gongyiName'];
		$rscfgy = $arr['Ware']['rscfgy'];

		$ret['cntKg'] = array_sum(array_col_values($ret['Gang'],'cntPlanTouliao'));
		$ret['shuirong'] =$arr['shuirong'];
		$ret['cntTongzi'] = array_sum(array_col_values($ret['Gang'],'planTongzi'));
		$ret['cntJingzhong'] = array_sum(array_col_values($ret['Gang'],'jingzhong'));
		//计算染化料
		// $arrR = array();	//染料数组
		// $arrZ = array();	//助剂数组
		$arrQ = array();//前处理数组
		$arrR = array();//染色数组
		$arrZ = array();//后处理数组
		$arrC = array();//染色染料数组
		$all=array();
		if ($arr['Gang'][0]['Chufang']){
			//dump($arr['Gang'][0]['Chufang']['Ware']);
			foreach ($arr['Gang'][0]['Chufang']['Ware'] as $key=>&$v){
				$ware  = $mWare->find(array('id'=>$v['wareId']));
				if($v['unit']=='g/包') $cntKg = $v['unitKg']*$ret['cntKg']*$ret['rsZhelv']/5;
				elseif($v['unit']=='g/升') $cntKg = $v['unitKg']*$ret['shuirong'];
				elseif($v['unit']=='%') $cntKg = $v['unitKg']*$ret['cntJingzhong']*10*$ret['rsZhelv'];//这里客户要求乘以总净重
				$temp = array(
					'guige'=>$ware['wareName'].' '.$ware['guige'],
					'peifang'=>$v['unitKg'],
					'unitKg'=>$v['unitKg'].$v['unit'],
					'unit'=>$v['unit'],
					'cntKg'=> round($cntKg,3),
					'tmp'=>$v['tmp'],
					'cntK'=> round($cntKg/1000,2),
					'gongxuId'=>$v['gongxuId'],
					'timeRs'=>$v['timeRs'],
					'memo'=>$v['memo'],
					'wareId' =>$ware['id']
				);
				//判断$temp中 规格是否超过16个字符 超过则截断 by zcc 2017年11月2日 10:43:58
				$temp['guige'] = mb_substr($temp['guige'],0,16,'utf-8');

				// if($mWare->isZhuji($v['wareId'])) {
				// 	$arrZ[$key+1]=$temp;
				// } else {
				// 	$arrR[$key] =$temp;
				// }

				if($v['gongxuId']==1){
					if($arr['Ware']['Qclgy']!='')
					$temp['gongxu']='前处理'.$arr['Ware']['Qclgy'];
					else $temp['gongxu']='前处理';
					$arrQ[$key]=  $temp;
					$arrQ_m[]=  $temp;//重新开始的键名
				}
				else if($v['gongxuId']==2){
					if($arr['Ware']['Rsgy']!='')
					$temp['gongxu']='染色'.$arr['Ware']['Rsgy'];
					else $temp['gongxu']='染色';
					$arrR[$key]=  $temp;
					$arrR_m[]=  $temp;
				}
				if($v['gongxuId']==3){
					if($arr['Ware']['Hclgy']!='')
					$temp['gongxu']='后处理'.$arr['Ware']['Hclgy'];
					else $temp['gongxu']="后处理";
					$arrZ[$key]=  $temp;
					$arrZ_m[]=  $temp;
				}
				if($v['gongxuId']==4){
					if($arr['Ware']['rscfgy']!='')
					$temp['gongxu']='染色染料'.$arr['Ware']['rscfgy'];
					else $temp['gongxu']="染色染料";
					$arrC[$key]=  $temp;
					$arrC_m[]=  $temp;
				}

			}
		}
		$Arr=$arrC+$arrQ+$arrR+$arrZ;
		//让染料和 助剂有个空行 by zcc （简单模式）
		foreach ($Arr as &$va2) {
			$isTrue =$this->_modelWare->isZhuji($va2['wareId']);
			$va2['isZhuji'] = $isTrue?1:2; //1 助剂 2染料
		}
		if ($arrQ_m[0]['memo']) {
			$memo .= "前处理:".$arrQ_m[0]['memo']."\n";
		}
		if ($arrR_m[0]['memo']) {
			$memo .= "染色:".$arrR_m[0]['memo']."\n";
		}
		if ($arrZ_m[0]['memo']) {
			$memo .= "后处理:".$arrZ_m[0]['memo']."\n";
		}
		if ($arrC_m[0]['memo']) {
			$memo .= "染色染料:".$arrC_m[0]['memo']."\n";
		}
		// $Arr = array_column_sort($Arr,'gongxuId');
		$gongxu = '';
		foreach ($Arr as $key => $value) {
			if ($Arr[$key]['gongxuId']==$gongxu) {
				$Arr[$key]['gongxu']='';
			}
			$gongxu = $Arr[$key]['gongxuId'];
		}
		// for($i=0;$i<count($Arr);$i++){
		// 	if($Arr[$i+1]['gongxuId']==$Arr[$i]['gongxuId']){
		// 		$Arr[$i+1]['gongxu']='';
		// 	}
		// }
		$aRow=$rr;
		$aRow['Arr']=$Arr;

		$str="select * from sys_setup where setName='PageSize'";
		//echo $str;
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re){
			$pageSize=$re['setValue']*10;

		}else{
			$pageSize=100;
		}
		$page=ceil(22*$pageSize/6);
		$pageCnt =ceil((192+22*count($Arr))/$page);
		//dump($pageCnt);exit;
		//dump($pageSize);dump($page);exit;
		//$PAPER=$pageCnt*352;
		//echo $cnt;exit;704
		//dump($aRow);exit;
		$aRow['Height']=array(
			'px'=>$pageCnt*$page,
			'mm'=>$pageCnt*$pageSize*10,
			'pageCnt'=>$pageCnt,
			'page'=>$page
		);
		//dump($aRow);exit;
		//$_GET['kind']=1;
		$cntKg = array_sum(array_col_values($aRow['Arr'],'cntKg'));//所有染料助剂总数 单位g
		//新增工艺名称
		$gy = array(
			'Qclgy' =>$Qclgy,
			'Rsgy' =>$Rsgy,
			'Hclgy' =>$Hclgy,
			'rscfgy' =>$rscfgy,
			'cntKg' => $cntKg,
			'memo' =>$memo
		);
		//echo "打印合并处方";
		// dump($gy);exit;
		$smarty = & $this->_getView();
		$smarty->assign('row',$aRow);
		$smarty->assign('gy',$gy);
		$smarty->display('Gongyi/Dye/PrintMergeDirectly.tpl');
	}


	//按工艺单领料时调用,列出已开工艺单的各缸
	function actionListForLl(){
		//$mChufang = FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		//$mClient = FLEA::getSingleton('Model_Jichu_Client');
		$title = "请选择需要领料的缸号";
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),date('d')-6,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId=>'',
			orderCode=>'',
			vatNum=>'',
			color=>'',
			chufangrenId=>0,
			chufangId=>0
		));


		$sql = "select x.*,y.dateChufang,y.chufangRen,y.id as chufangId
			from view_dye_gang x
			inner join gongyi_dye_chufang y on x.order2wareId = y.order2wareId
			left join cangku_yl_chuku z on y.id=z.chufangId and x.gangId=z.gangId
			where z.id is null and y.dateChufang>='{$arr['dateFrom']}' and y.dateChufang<='{$arr['dateTo']}'";

		if ($arr['clientId']!='') $sql .=	" and x.clientId=$arr[clientId]";
		if ($arr[orderCode]!='') $sql .= " and x.orderCode like '%$arr[orderCode]%'";
		if ($arr[vatNum]!='') $sql .= " and x.vatNum like '%$arr[vatNum]%'";
		if ($arr[color] != '') $sql .= " and color like '%$arr[color]%'";
		$sql .= " group by x.gangId order by dateChufang DESC";

		//echo($sql);
		$pageSize = 20;
		$pager = & new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAll();
		//dump($rowset[0]);
		$con = array(
			order2wareId => $_GET[id],
			id => $_GET[chufangId]
		);
		if(count($arr)>0) foreach($rowset as & $row) {
			$row['guige'] = $row['wareName']. ' ' .$row['guige'];
			#显示操作项
			$row[_edit] = "<a href='".$this->_url('Print',array(
				'id' => $row[order2wareId],
				'chufangId' => $row[chufangId],
				'gangId'=>$row['gangId'],
				'for'=>'ll'
			))."'>确定领用</a>";
		}

		//dump($rowset[0]); exit;

		$arr_field_info = array(
			dateChufang => '开方日期',
			vatNum => '缸号',
			orderCode => '订单号',
			compName => '客户',
			guige => '坯纱规格',
			color => '颜色',
			cntKg => '总公斤数',
			chufangRen => '处方人',
			_edit => '操作'
		);
		$smarty = & $this->_getView();
		$smarty->assign('title','已开处方管理');
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');		//取消新增按钮
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('ListForLl', $arr)));
		$smarty->display('TableList.tpl');
	}

	//打印处方
	function actionPrint() {
		//$this->authCheck(83);
		$modelOrder2Ware = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$modelClient = & FLEA::getSingleton('Model_JiChu_Client');
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mGongxu = & FLEA::getSingleton('Model_JiChu_Gongxu');

		$con = array(
			order2wareId => $_GET[id],
			id => $_GET[chufangId]
		);

		if($con[id]>0) {
			$chufang = $this->_modelChufang->find($con);
			if ($chufang[Chufangren]) {
				$chufang[chufangren] = $chufang[Chufangren][employName];
			}

			//取得客户名称
			$rowOrder2Ware = $modelOrder2Ware->findByField('id', $con[order2wareId]);
			$rowClient = $modelClient->findByField('id', $rowOrder2Ware[Order][clientId]);
			$chufang[clientName] = $rowClient[compName];

			//取得缸号信息
			$rowGang = $modelGang->findByField('id',$_GET[gangId]);
			$chufang[Gang] = $rowGang;

			$rowWare = $modelWare->findByField('id', $chufang[OrdWare][wareId]);
			$chufang[guige] = $rowWare[guige].' '.$rowWare[wareName];
		}

		$arrR = array();	//染料数组
		$arrZ = array();	//助剂数组
		if(count($chufang[Ware])>0) foreach($chufang[Ware] as $key=>& $row) {
			$rowWare = $modelWare->find($row[wareId]);
			$row[wareName] = $rowWare[guige].' '.$rowWare[wareName];
			$row['Gongxu'] = $mGongxu->find(array('id'=>$row['gongxuId']));
			$z =$chufang[Gang][rsZhelv];

			if($row['unit']=='g/升') {//g/l缸用量 = 单位用量*缸的水容量/1000
				//echo(count($chufang[Gang][Vat])); exit;
				if ($chufang[Gang][Vat] != '') {
					$row[vatCnt] = round($row[unitKg]*$chufang[Gang][shuirong]/1000,2);
				}
				else $row[vatCnt] = 0;
			} elseif($row['unit']=='%') {//%用量 = 单位用量*投纱量/1000
				//echo(count($chufang[Gang][Vat])); exit;
				if ($chufang[Gang][Vat] != '') {
					$row[vatCnt] = round($row[unitKg]*$z*$chufang[Gang][cntPlanTouliao]/100,2);
				}
				else $row[vatCnt] = 0;
			}
			else {//染化料缸用量=总公斤数/(包用量*5)
				$row[vatCnt] = round($chufang[Gang][cntPlanTouliao]*$z*$row[unitKg]/5,2);
			}
			if($modelWare->isZhuji($row[wareId])) {
				$arrZ[$key]=& $row;
			}
			else
			{
			  $arrR[$key] = & $row;
			}
			//$arrR[] =  $row;
		}

        //加一行空值
        $arrR[count($arrR+$arrZ)]=array();
        //合并数组
        $arr=$arrR+$arrZ;
        //dump($arrR);dump($arrZ);
        //dump($chufang);
        //开始显示
        $smarty = & $this->_getView();
        $smarty->assign("number",$this->_modelChufang->getCntOfChufang($_GET[id]));
        $smarty->assign('chufang',$chufang);
        //$smarty->assign('chufangren', $_SESSION[REALNAME]);
        $smarty->assign('ranliao',$arr);
        //$smarty->assign('zhuji',$arrZ);
        $smarty->display('Gongyi/Dye/ChufangView.tpl');
    }
    /**
     * ps ：
     * Time：2017/06/06 11:00:09
     * @author zcc
     * @param 参数类型
     * @return 返回值类型
    */
    function actionPrintChoose(){
	    $a = "&nbsp;&nbsp;&nbsp;<a href='".$this->_url('PrintDirectly', array(
	            id => $_GET[id],
	            chufangId => $_GET[chufangId],
	            gangId => $_GET[gangId],
	            'kind' =>'0',
	            'preview'=>1
	        ))."' target='_blank'>横向打印</a>";
	    $b = "&nbsp;&nbsp;&nbsp;<a href='".$this->_url('PrintDirectly', array(
	            id => $_GET[id],
	            chufangId => $_GET[chufangId],
	            gangId => $_GET[gangId],
	            'kind' =>'1',
	            'preview'=>1
	        ))."' target='_blank'>纵向打印</a>";
	    $str = "<div style='text-align:center;'><span>$a<br></br>$b</span></div>";
	    echo $str;

    }


    //弹出窗口调用lodop进行打印后关闭窗口
    function actionPrintDirectly() {
    	//dump($_GET);exit();
		$mGang = & FLEA::getSingleton("Model_Plan_Dye_Gang");
        $mWare = & FLEA::getSingleton("Model_Jichu_Ware");
		$mGongyi = & FLEA::getSingleton("Model_Jichu_Gongyi");
        $mChufang = & FLEA::getSingleton("Model_Gongyi_Dye_Chufang");
        $arr = $mChufang->find(array('id'=>$_GET['chufangId']));
        //按照登记的时候排列顺序排序
		foreach ($arr['Ware'] as $key => $value) {
			$tempss[$key] = $value['nums'];
		}
        array_multisort($tempss,'asc',$arr['Ware']);
        //dump($arr);exit;
        $gang =$mGang->formatRet($mGang->find(array('id'=>$_GET['gangId'])));
		$qcl=$mGongyi->find(array('id'=>$arr['qclId']));
		$arr['Ware']['Qclgy']=$arr['memoQcl']!=''?$arr['memoQcl']:$qcl['gongyiName'];
		$Qclgy = $arr['Ware']['Qclgy'];
		$ranse=$mGongyi->find(array('id'=>$arr['rsgyId']));
		$arr['Ware']['Rsgy']=$arr['memoRs']!=''?$arr['memoRs']:$ranse['gongyiName'];
		$Rsgy = $arr['Ware']['Rsgy'];
		$hcl=$mGongyi->find(array('id'=>$arr['hclId']));
		$arr['Ware']['Hclgy']=$arr['memoHcl']!=''?$arr['memoHcl']:$hcl['gongyiName'];
		$Hclgy = $arr['Ware']['Hclgy'];
		//新增染色染料工艺
		$rscf=$mGongyi->find(array('id'=>$arr['rscfId']));
		$arr['Ware']['rscfgy']= $arr['memoCf']!=''?$arr['memoCf']:$rscf['gongyiName'];
		$rscfgy = $arr['Ware']['rscfgy'];
		//dump($arr);exit;
		$ret = array(
			'dateChufang' =>$arr['dateChufang'],
			'datePrint'=>date('Y-m-d'),
			'compName'=>$gang['Client']['compName'],
			'color'=>$gang['OrdWare']['color'],
			'colorNum'=>$gang['OrdWare']['colorNum'],
			'dyeKind'=>$arr['dyeKind'],
			'vatCode'=>$gang['Vat']['vatCode'],
			'zhelv'=>$gang['zhelv'],
			'shuirong'=>$gang['shuirong'],
			'chufangren'=>$arr['Chufangren']['employName'],
			'rhlZhelv'=>$arr['rhlZhelv'],
			'yubi' => round($gang['shuirong']/$gang['cntPlanTouliao'],2),
			'touliaoCnt' => round($gang['cntPlanTouliao']*$gang['zhelv'],2),
		);
		$ret['Gang'][] = array(
			'vatNum'=>$gang['vatNum'],
			'guige'=>$gang['OrdWare']['Ware']['wareName'] . ' ' .$gang['OrdWare']['Ware']['guige'],
			'unitKg'=>$gang['unitKg'],
			'planTongzi'=>$gang['planTongzi'],
			'cntPlanTouliao'=>$gang['cntPlanTouliao'],
			'cntBao'=>$gang['cntPlanTouliao']/5,
		);
		$ret['cntKg'] = array_sum(array_col_values($ret['Gang'],'cntPlanTouliao'));
		//$ret['shuirong'] =$arr['shuirong'];
		$ret['cntTongzi'] = array_sum(array_col_values($ret['Gang'],'planTongzi'));
        $ret['pisha_qcl']=$arr['pisha_qcl'];
		$rr=$ret;
		// dump($ret);exit;
		//计算染化料
		// dump($arr);exit;

		$arrQ = array();//前处理数组
		$arrR = array();//染色数组
		$arrZ = array();//后处理数组
		$arrC = array();//染色染料数组
		$all=array();
		//dump($arr['Ware']);die;
		if ($arr['Ware']){
			foreach ($arr['Ware'] as $key=>&$v){
				//$v['unitKg'] = round($v['unitKg'],6);
				if($v['unit']=='g/包'||$v['unit']=='g/升'){
					 $v['unitKg'] = round($v['unitKg'],4);
				}else{
                     $v['unitKg'] = number_format($v['unitKg'],6);
				}
				$ware  = $mWare->find(array('id'=>$v['wareId']));
				// by zcc 2017年11月3日 13:23:58 调整公司  针对 g/包 和 %  都乘以缸的折率（折率取到小数点后三位）
				if($v['unit']=='g/包') {$cntKg = $v['unitKg']*$ret['cntKg']*$ret['rhlZhelv']/5*round($ret['zhelv'],3);
					// dump($v['unitKg']);dump($ret['cntKg']);dump($ret['rhlZhelv']);exit();
				// dump($cntKg);exit();
				}

				elseif($v['unit']=='g/升') $cntKg = $v['unitKg']*$ret['shuirong'];
				elseif($v['unit']=='%') $cntKg = $v['unitKg']*$ret['cntKg']*10*$ret['rhlZhelv']*round($ret['zhelv'],3);
				//dump($v['unitKg']);dump($ret['cntKg']);dump($ret['zhelv']);
				//dump($cntKg);exit;

				$temp = array(
					'id'=>$v['id'],
					'guige'=>$ware['wareName'].' '.$ware['guige'],
					'peifang'=>$v['unitKg'],
					'unitKg'=>$v['unitKg'].$v['unit'],
					'unit'=>$v['unit'],
					'cntKg'=> round($cntKg,3),
					'cntK'=> round($cntKg/1000,3),
					'tmp'=>$v['tmp'],
					'timeRs'=>$v['timeRs'],
					'gongxuId'=>$v['gongxuId'],
					'memo'=>$v['memo'],
					'wareId' =>$ware['id'],
					// 'nums'=>$v['nums']
					//'Qclgy'=>$arr['Ware']['Qclgy'],
					//'Rsgy'=>$arr['Ware']['Rsgy'],
					//'Hclgy'=>$arr['Ware']['Hclgy'],
				);
				//$arr['Ware']数组里面索引是工序名称的跳过
				if (!is_numeric($key)) {
					continue;
				}
				//判断$temp中 规格是否超过16个字符 超过则截断 by zcc 2017年11月2日 10:43:58
				$temp['guige'] = mb_substr($temp['guige'],0,16,'utf-8');
				if($v['gongxuId']==1){
					if($arr['Ware']['Qclgy']!='')
					$temp['gongxu']='前处理'.$arr['Ware']['Qclgy'];
					else $temp['gongxu']='前处理';
					$arrQ[$key]=  $temp;
					$arrQ_m[]=  $temp;//重新开始的键名
				}
				else if($v['gongxuId']==2){
					if($arr['Ware']['Rsgy']!='')
					$temp['gongxu']='染色'.$arr['Ware']['Rsgy'];
					else $temp['gongxu']='染色';
					$arrR[$key]=  $temp;
					$arrR_m[]=  $temp;
				}
				if($v['gongxuId']==3){
					if($arr['Ware']['Hclgy']!='')
					$temp['gongxu']='后处理'.$arr['Ware']['Hclgy'];
					else $temp['gongxu']="后处理";
					$arrZ[$key]=  $temp;
					$arrZ_m[]=  $temp;
				}
				if($v['gongxuId']==4){
					if($arr['Ware']['rscfgy']!='')
					$temp['gongxu']='染色染料'.$arr['Ware']['rscfgy'];
					else $temp['gongxu']="染色染料";
					$arrC[$key]=  $temp;
					$arrC_m[]=  $temp;
				}
			}
		}
		// dump($arrQ_m); dump($arrR_m); dump($arrZ_m);dump($arrC_m);die();
		$Arr=$arrC+$arrQ+$arrR+$arrZ;
		
		//重写染料助剂循环模式 2019年6月10日 10:15:05 begin
		$rlzj = array();
		foreach ($Arr as &$va2) {
			$isTrue =$this->_modelWare->isZhuji($va2['wareId']);
			$va2['isZhuji'] = $isTrue?1:2; //1 助剂 2染料
			if($va2['gongxuId']==4){
				$rlzj[] = $va2;
			}
		}
		$rlzjData = array();
		foreach ($rlzj as $k => &$v) {
			$rlzjData[$v['isZhuji']][] = $v;
		}
		$temp = array();
		foreach ($rlzjData as &$v3) {
			$son = array();
			foreach ($v3 as &$v1) {
				$son[] = $v1;
			}
			$temp[] = $son;
		}
		//重写染料助剂循环模式 2019年6月10日 10:15:05 end

		if ($arrQ_m[0]['memo']) {
			$memo .= "前处理:".$arrQ_m[0]['memo']."\n";
		}
		if ($arrR_m[0]['memo']) {
			$memo .= "染色:".$arrR_m[0]['memo']."\n";
		}
		if ($arrZ_m[0]['memo']) {
			$memo .= "后处理:".$arrZ_m[0]['memo']."\n";
		}
		if ($arrC_m[0]['memo']) {
			$memo .= "染色染料:".$arrC_m[0]['memo']."\n";
		}
		// $Arr = array_column_sort($Arr,'gongxuId');
		$gongxu = '';
		foreach ($Arr as $key => $value) {
			if ($Arr[$key]['gongxuId']==$gongxu) {
				$Arr[$key]['gongxu']='';
			}
			$gongxu = $Arr[$key]['gongxuId'];
		}
		// for($i=0;$i<count($Arr);$i++){
		// 	if($Arr[$i+1]['gongxuId']==$Arr[$i]['gongxuId']){
		// 		$Arr[$i+1]['gongxu']='';
		// 	}
		// }
		$aRow=$rr;
		$aRow['Arr']=$Arr;
		$aRow['rlzj']=$temp;

		$str="select * from sys_setup where setName='PageSize'";
		//echo $str;
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re){
			$pageSize=$re['setValue']*10;

		}else{
			$pageSize=100;
		}
		$page=ceil(22*$pageSize/6);
		$pageCnt =ceil((192+22*count($Arr))/$page);
		//dump($pageCnt);exit;
		//dump($pageSize);dump($page);exit;
		//$PAPER=$pageCnt*352;
		//echo $cnt;exit;704
		//dump($aRow);exit;
		$aRow['Height']=array(
			'px'=>$pageCnt*$page,
			'mm'=>$pageCnt*$pageSize*10,
			'pageCnt'=>$pageCnt,
			'page'=>$page
		);
		//$_GET['kind']=1;
		$cntKg = array_sum(array_col_values($aRow['Arr'],'cntKg'));//所有染料助剂总数 单位g
		//新增工艺名称
		$gy = array(
			'Qclgy' =>$Qclgy,
			'Rsgy' =>$Rsgy,
			'Hclgy' =>$Hclgy,
			'rscfgy' =>$rscfgy,
			'cntKg' => $cntKg,
			'memo' =>$memo
		);

		$smarty = & $this->_getView();
		$smarty->assign('row',$aRow);
		$smarty->assign('gy',$gy);
		// $smarty->display('Gongyi/Dye/PrintDirectly.tpl');
		$smarty->display('Gongyi/Dye/PrintDirectlyNew.tpl');
	}
	//保存染料领用数据
	function actionSaveForLl(){
		//dump($_POST);
		$m = & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$arr = array(
			'chukuDate'=>date('Y-m-d'),
			'gangId'=>$_POST['gangId'],
			'chufangId'=>$_POST['chufangId'],
			'chukuNum'=>$m->getNewChukuNum(),
			'memo'=>'自动生成'
		);
		if($_POST['wareId']) foreach($_POST['wareId'] as $key=>& $v) {
			$arr['Wares'][] = array(
				'wareId'=>$_POST['wareId'][$key],
				'danjia'=>$m->getRukuDanjia($v)+0,
				'cnt'=>$_POST['cnt'][$key]
			);
		}
		//dump($arr);exit;
		if($m->save($arr)) redirect($this->_url('ListForLl'));
		//dump($arr);
		exit;
	}

	function actionRemoveChufang() {
		$this->authCheck(83);
		$chuku = FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$ck=$chuku->findAll(array('chufangId'=>$_GET['id']));
		//dump(count($ck));exit;
		if(count($ck)>0){
			js_alert('已经领料，禁止删除!', '',$_SERVER[HTTP_REFERER]);
		}
		$m = FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$rr=$m->find(array('id'=>$_GET['id']));
		$str="select y.* from acm_userdb x
			left join jichu_employ y on y.id=x.employId
			where x.id='{$_SESSION['USERID']}'
			and y.id is not NULL
		";
		$re=mysql_fetch_assoc(mysql_query($str));
		//dump($_SESSION);
		if($re['id']!=$rr['chufangrenId']&&$_SESSION['USERNAME']!='admin'){
			js_alert('您不能删除该处方人的处方单！','',$this->_url('list'));
			exit;
		}

		$m->removeByPkv($_GET[id]);
		redirect($this->_url('list'));
	}

	//删除处方明细的某个染化料
	function actionRemoveWare() {
		$model = FLEA::getSingleton('Model_Gongyi_Dye_Chufang2Ware');
		$model->removeByPkv($_GET[id]);
		redirect($_SERVER['HTTP_REFERER']);
	}

	function actionCountVatCntRanliaoJson() {
		$rowChufang = $this->_modelChufang->find("id=$_GET[chufangId]");
		$value = $rowChufang[OrdWare][cntKg] / ($_GET[unitKg] * 5);
		echo json_encode($value);exit;
	}

	function actionCountVatCntZhujiJson() {
		$rowVat = $this->_modelVat->find("id=$_GET[vatId]");
		$value = $_GET[unitKg]*$rowVat[shuiRong];
		echo json_encode($value);exit;
	}

	//统计某一段时间, 某一种原料的用量
	function actionYlCostReport(){
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom'	=>date('Y-m-01'),
			'dateTo'	=>date('Y-m-d'),
			'ylId'		=>'',
		));

		$condition[] = array('Chufang.dateChufang', $arrGet['dateFrom'], '>=');
		$condition[] = array('Chufang.dateChufang', $arrGet['dateTo'], '<=');
		if ($arrGet['ylId']) $condition[] = array('wareId', $arrGet['ylId']);

		$pager =& new TMIS_Pager($this->_modelChufang2Ware,$condition,'id desc',300);
		$rowset = $pager->findAll();
		//dump($rowset[0]); exit;

		$modelGang =& FLEA::getSingleton('Model_Plan_Dye_Gang');
		$i = 1; //序号
		if(count($rowset)>0) foreach($rowset as & $v) {
			$v['num'] = $i++;
			$v['dateChufang'] = $v['Chufang']['dateChufang'];
			$v['wareName'] = $v['Ware']['wareName']." ".$v['Ware']['guige'];

			$gangId = $v['Chufang']['gangId'];
			$gang = $modelGang->find($gangId);

			if ($v['unit'] == "g/包") $cnt = round($v[unitKg]*$gang['cntPlanTouliao']/100,2);
			else if ($v['unit'] = "g/升") $cnt = round($v[unitKg]*$gang['Vat']['shuiRong']/1000,2);
			$v['cnt'] = $cnt;
		}

		$heji = $this->getHeji($rowset,array('cnt'),'num');
		$rowset[] = $heji;

		$arrFieldInfo = array(
			'num'			=>'序号',
			'dateChufang'	=> '日期',
			'wareName'		=>'原料名称',
			'cnt'			=> '数量',
			'unit'			=> '单位',
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','染化料用量统计报表');
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('YlCostReport',$arrGet)));
		$smarty->display('TableList.tpl');
	}

	#修改染色折率
	function actionChangeRsZhelv(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr =$m->find(array('id'=>$_GET['gangId']));
		$smarty = & $this->_getView();
		$smarty->assign('aRow', $arr);
		//dump($arr);
		$smarty->display('Gongyi/Dye/ChangeRsZhelv.tpl');
	}

	function actionSaveRsZhelv(){
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		if($m->update($_POST)) {
			redirect($this->_url('Print',array(
				'chufangId'=>$_POST['chufangId'],
				'gangId'=>$_POST['id'],
				'id'=>$_POST['ordwareId']
			)));
		}
	}

	//获得Json参数
//    function actionPopgongyi() {
//		$mgongyi=& FLEA::getSingleton("Model_JiChu_Gongyi");
//		$arr=$mgongyi->find($_GET['id']);
//		$arr['GongyiWares']=array_group_by($arr['GongyiWares'],'classId');
//		//dump($arr);exit;
//		$rowset['0']=array_merge($arr['GongyiWares']['1'],$arr['GongyiWares']['3']);
//		if(!$rowset['0']){
//			if($arr['GongyiWares']['1']){
//				$rowset["0"]=$arr['GongyiWares']['1'];
//			}
//			else if($arr['GongyiWares']['3']){
//				$rowset["0"]=$arr['GongyiWares']['3'];
//			}
//			else{
//				//没有助剂
//			}
//		}
//		//dump($rowset);exit;
//		$rowset['1']=$arr['GongyiWares']['2'];
//		foreach($rowset as & $v){
//
//			foreach($v as & $vv){
//                if($vv['unitKg']=='0.0'){
//                    $vv['unitKg']='';
//                }
//				if($vv['classId']==1){
//					$vv['Class']='前处理';
//				}
//				else if($vv['classId']==2){
//					$vv['Class']='染色';
//				}
//				else{
//					$vv['Class']='后整理';
//				}
//				$vv['Ware'] = $this->_modelWare->find(array('id'=>$vv['wareId']));
//			}
//		}
//        //dump($rowset);exit;
//        echo json_encode($rowset);exit;
//	}
	function actionPopgongyi() {
		$mgongyi=& FLEA::getSingleton("Model_JiChu_Gongyi");
		$ware=& FLEA::getSingleton("Model_JiChu_Ware");;
		if ($_GET['id']=='') {
			$_GET['id'] = 0;
		}
		$arr=$mgongyi->find($_GET['id']);
		foreach ($arr['GongyiWares'] as $key => $value) {
			$temp[$key] = $value['num'];
		}
        array_multisort($temp,'asc',$arr['GongyiWares']);
		if($arr){
			foreach($arr['GongyiWares'] as & $v){
				$sql="SELECT * FROM `jichu_ware` where id={$v['wareId']}";
				$re=mysql_fetch_assoc(mysql_query($sql));
				$v['Ware']=$re;
			}

		}
		//dump($arr);die;
		echo json_encode($arr);exit;
		//dump($arr);exit;
	}

	function actionYlCost(){
		$this->authCheck(117);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom'	=>date('Y-m-d'),
			'dateTo'	=>date('Y-m-d'),
			'class'	=>'',
			//'isReturn'=>3
		));
		//dump($_POST);
		$mWare = & FLEA::getSingleton("Model_Jichu_Ware");

		if ($arrGet['class'] == 'ranliao') $rowWare = $mWare->findByField('wareName','染料类');
		elseif ($arrGet['class'] == 'zhuji') $rowWare = $mWare->findByField('wareName', '助剂类');
		else $rowWare = $mWare->findByField('wareName', '染料类');
		//dump($mWare->findByField('wareName', '助剂类'));exit;

		$topClassLeftId = $rowWare['leftId'];
		$topClassRightId = $rowWare['rightId'];

		//出库表中搜索wareId
		/*$table = "select
			x.unitKg, x.unit,
			y.dateChufang, g.cntPlanTouliao, round(CASE x.unit
			WHEN 'g/包'
			THEN x.unitKg * ( g.cntPlanTouliao /5 )
			WHEN 'g/升'
			THEN x.unitKg * g.shuirong
			WHEN '%'
			THEN x.unitKg * g.cntPlanTouliao *10
			ELSE 0
			END) as gangCnt,
			x.wareId, w.leftId, w.rightId, g.vatNum,g.shuirong,w.wareName, w.guige
				from gongyi_dye_chufang2ware x
				left join gongyi_dye_chufang y on x.chufangId = y.id
				left join trade_dye_order2ware t on y.order2wareId = t.id
				left join plan_dye_gang g on y.gangId = g.id
				left join jichu_ware w on w.id = x.wareId
				where dateChufang >= '{$arrGet['dateFrom']}' and dateChufang <= '{$arrGet['dateTo']}'
				and leftId > {$topClassLeftId} and rightId < {$topClassRightId} and y.id is not null
		";

		$sql = "select sum(unitKg) as unitKg, cntPlanTouliao,x.unit, wareId, wareName, guige, sum(gangCnt) as gangCnt from (".$table.") x	group
by wareId";

		$rowset = $this->_modelExample->findBySql($sql);*/
		//得到其他出库的数量
		set_time_limit(0);
		$this->_mCangkuchuku = &FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$str="SELECT sum(y.cnt) as cnt,z.wareName,y.wareId,z.leftId, z.rightId,z.guige
			from cangku_yl_chuku x
		    left join cangku_yl_chuku2ware y on y.chukuId=x.id
		    left join jichu_ware z on z.id=y.wareId

		    where x.chukuDate>='{$arrGet['dateFrom']}' and x.chukuDate <= '{$arrGet['dateTo']}'
		    and leftId > {$topClassLeftId} and rightId < {$topClassRightId}
		    and x.kind = 0
		";

		$str.=" group by y.wareId";
		$row=$this->_mCangkuchuku->findBySql($str);
		/*$sql= "select
		    x.wareId,
            w.unit,
            w.unitKg,
            g.shuirong,
            g.cntPlanTouliao
        from cangku_yl_chuku x
		    left join cangku_yl_chuku2ware y on y.chukuId=x.id
		    left join plan_dye_gang g on x.gangId = g.id
		    left join gongyi_dye_chufang  zw on  zw.order2wareId = g.order2wareId
		    left join gongyi_dye_chufang2ware w on w.chufangId=zw.id
		    where x.chukuDate>='{$dateFrom}' and x.chukuDate <= '{$dateTo}'
		    and y.wareId>'{$topClassLeftId}' and y.wareId<'{$topClassRightId}'
		    and w.wareId>'{$topClassLeftId}' and w.wareId<'{$topClassRightId}'
		";
		$arr = $this->_modelExample->findBySql($sql);*/
		foreach($row as & $v){


			$v['gangCnt1'] = $v['cnt'];
		    $v['gangCnt']="<a href=".$this->_url('wareMx',array('wareId'=>$v['wareId'],'dateTo'=>$arrGet['dateTo'],'dateFrom'=>$arrGet['dateFrom'])).">".$v['cnt']."</a>";

		    $v['guige'].= ' '.$v['wareName'];

		    $arrGet['ylId'] = $v['wareId'];

		}

		if (count($rowset)>0) foreach($rowset as & $value) {
			$value['guige'] .= ' '.$value['wareName'];
			$arrGet['ylId'] = $value['wareId'];
			$value['more'] = "<a href='".$this->_url("YlCostReportMore", $arrGet)."' title='点击查看详细' target='_blank'>明细</a>";
		}
	    $rowset = $row;
		$heji = $this->getHeji($rowset,array('unitKg', 'gangCnt1'), 'guige');
		$heji['gangCnt'] = $heji['gangCnt1'];
		$rowset[] = $heji;
		$classSearch =  "<a href='".$this->_url('YlCost', array('class'=>'ranliao', 'dateFrom'=>$arrGet['dateFrom'], 'dateTo'=>$arrGet
['dateTo']))."'>染料</a> | <a href='".$this->_url('YlCost', array('class'=>'zhuji', 'dateFrom'=>$arrGet['dateFrom'], 'dateTo'=>$arrGet['dateTo']))."'>助剂
</a>";

		$arrFieldInfo = array(
			//'dateChufang'	=> '日期',
			//'wareName'		=>'原料名称',
			'guige'			=> '规格',
			//'unitKg'		=> '单位用量(克)',
			//'cntKg'			=> '总公斤数',
			'gangCnt'		=> '缸用量(千克)',
			//'more'			=> '操作'
			//'unit'			=> '单位',
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','染料用量日报表');
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('other_search_item',$classSearch);
		$smarty->display('TableList.tpl');

	}

	/**************************by liu 2013-8-13******************************/

	function actionWareMx(){
		//dump($_GET);exit;
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'wareId'	=>$_GET['wareId'],
			//'color'		=>'',
			'dateFrom'  =>$_GET['dateFrom'],
			'dateTo'    =>$_GET['dateTo']
		));
		 //dump($arrGet);exit;
       $str="select
        x.chukuDate,
        sum(y.cnt) as cnt,
        z.wareName,
        y.wareId,
        z.leftId,
        z.rightId,
        z.guige,
        g.vatNum,
        g.shuirong,
        g.cntPlanTouliao,
        g.id as gangId,
        v.vatCode,
        sum(w.unitKg) as unitKg,
        w.unit,
        o.color,
        o.id as order2wareId,
        zw.id as chufangId,
        zw.rhlZhelv
        from cangku_yl_chuku x
		    left join cangku_yl_chuku2ware y on y.chukuId=x.id
		    left join jichu_ware z on z.id=y.wareId
		    left join plan_dye_gang g on x.gangId = g.id
		    left join jichu_vat v on v.id=g.vatId
		    left join gongyi_dye_chufang  zw on  zw.order2wareId = g.order2wareId
		    left join gongyi_dye_chufang2ware w on w.chufangId=zw.id
		    left join trade_dye_order2ware o on o.id = g.order2wareId
		    where x.chukuDate>='{$arrGet ['dateFrom']}' and x.chukuDate <= '{$arrGet['dateTo']}'
		    and y.wareId='{$arrGet['wareId']}' and w.wareId='{$arrGet['wareId']}'  group by g.vatNum
		";

		$arr_field_info = array(
			'vatNum'=>"缸号",
			'guige' =>'纱支',
			'color' =>'颜色',
			'cntPlanTouliao' =>'投料数',
			'vatCode' =>'物理缸号',
			'shuirong' =>'水溶',
			'wareName'=>'染料/ 助剂',
		    'unitKg'  =>'单位用量',
		    'unit'  =>'单位',
		    'cnt'   =>"缸用量kg",
		    'chukuDate'=>'领料日期'
		);

		$pager = & new TMIS_Pager($str);
		//dump($pager);exit;


		$rowset = $pager->findAll();


		// foreach ($rowset as $i => & $v) {

		// 		// if($v['unit']=='g/包') $cntKg = $v['unitKg']*$ret['cntKg']*$ret['rhlZhelv']/5;
		// 		// elseif($v['unit']=='g/升') $cntKg = $v['unitKg']*$ret['shuirong'];
		// 		// elseif($v['unit']=='%') $cntKg = $v['unitKg']*$ret['cntKg']*10*$ret['rhlZhelv'];//*$ret['zhelv'];
  //               //$v['cnt']=$v['unitKg']
		// 	}
		// }

		//dump($rowset);exit;
		foreach ($rowset as $i => & $v) {
			//if($v['unit']=="g/包"){
			//
			//	$v[cnt] = round($v[unitKg]*$v[cntPlanTouliao]*$v[rhlZhelv]/5,2);
			//}
			//elseif($v['unit']=='g/升') $v['cnt'] = $v['unitKg']*$v['shuirong'];
			//elseif($v['unit']=='%') $v['cnt'] = $v['unitKg']*$v['cntPlanTouliao']*10*$v['rhlZhelv'];
			$v['vatNum']="<a href=".$this->_url('PrintDirectly',array(
				'id'=>$v['order2wareId'],
				'chufangId'=>$v['chufangId'],
			    'gangId'   =>$v['gangId']
			))." target=_blank >{$v['vatNum']}</a>";
		}

		$heji = $this->getHeji($rowset,array( 'unitKg',"cnt"), 'vatNum');

		$rowset[]=$heji;

		$smarty = $this->_getView();
		$smarty -> assign('arr_condition',$arrGet);
		$smarty -> assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty -> assign('arr_field_info',$arr_field_info);
		$smarty -> assign('arr_field_value',$rowset);
        $smarty -> display('TableList.tpl');
	}
	/**************************       end      ******************************/


	/**
	 * @desc ：已并缸处方登记列表
	 * Time：2016/07/04 15:06:05
	 * @author Wuyou
	*/
	function actionListBinggang(){
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			clientId	=>'',
			wareId		=>'',
			color		=>'',
			orderCode	=>'',
			colorNum    =>'',
			cntPlanTouliao=>''
		));
		$sql="select * from jichu_ware where wareName='CVC' and guige=''";
		$re=mysql_fetch_assoc(mysql_query($sql));
		$sql1="select * from jichu_ware where wareName='40/2TR中长' and guige=''";
		$re1=mysql_fetch_assoc(mysql_query($sql1));
		$sql2="select * from jichu_ware where wareName='T/C' and guige=''";
		$re2=mysql_fetch_assoc(mysql_query($sql2));
		$sql3="select * from jichu_ware where wareName='涤粘TR' and guige=''";
		$re3=mysql_fetch_assoc(mysql_query($sql3));
		$str = "SELECT x.*,y.clientId,z.id as planId,z.binggangId
						,GROUP_CONCAT(distinct x.color SEPARATOR '<br>') as color
						,GROUP_CONCAT(x.cntKg SEPARATOR '<br>') as cntKg
						,GROUP_CONCAT(x.colorNum SEPARATOR '<br>') as colorNum
						,GROUP_CONCAT(y.dateOrder SEPARATOR '<br>') as dateOrder
						,GROUP_CONCAT(y.orderCode SEPARATOR '<br>') as orderCode
						,GROUP_CONCAT(distinct CONCAT(n.wareName,n.guige) SEPARATOR '<br>') as guige
			from plan_dye_gang z
			left join trade_dye_order2ware x on z.order2wareId=x.id
			left join trade_dye_order y on y.id=x.orderId
			left join jichu_ware n on n.id=x.wareId
			where	((
				(n.leftId>='{$re['leftId']}' and n.rightId<='{$re['rightId']}') or
				(n.leftId>='{$re1['leftId']}' and n.rightId<='{$re1['rightId']}') or
				(n.leftId>='{$re2['leftId']}' and n.rightId<='{$re2['rightId']}') or
				(n.leftId>='{$re3['leftId']}' and n.rightId<='{$re3['rightId']}')
			) || (
				!(
					(n.leftId>='{$re['leftId']}' and n.rightId<='{$re['rightId']}') or
					(n.leftId>='{$re1['leftId']}' and n.rightId<='{$re1['rightId']}') or
					(n.leftId>='{$re2['leftId']}' and n.rightId<='{$re2['rightId']}') or
					(n.leftId>='{$re3['leftId']}' and n.rightId<='{$re3['rightId']}')
				)
			)) and x.isComplete=0 and z.binggangId>0";
		//echo $str;exit;
		if ($arrGet['clientId'] != '') $str.=" and y.clientId='{$arrGet['clientId']}'";
		if ($arrGet['color']!='') $str.=" and x.color like '%{$arrGet['color']}%'";
		if ($arrGet['colorNum']!='') $str.=" and x.colorNum like '%{$arrGet['colorNum']}%'";
		if ($arrGet['orderCode'] != '') $str.=" and y.orderCode like '%{$arrGet['orderCode']}%'";
		if ($arrGet['wareId'] != '') $str.=" and x.wareId='{$arrGet['wareId']}'";
		if ($arrGet['cntPlanTouliao'] != '') $str.=" and z.cntPlanTouliao='{$arrGet['cntPlanTouliao']}'";
		$str.=" group by z.binggangId";
		$str.=" order by z.id desc";
		// dump($str);exit;
		$pager =& new TMIS_Pager($str);
		$rowset = $pager->findAll();
		// dump($rowset);exit;

		if(count($rowset)>0) foreach($rowset as & $row) {
			$sql = "SELECT b.vatCode
					FROM plan_dye_gang_merge a
					LEFT JOIN jichu_vat b ON a.vatId=b.id
					WHERE a.id={$row['binggangId']}";
			$temp = $this->_modelExample->findBySql($sql);
			$row['vatCode'] = $temp[0]['vatCode'];
			// 客户名称
			$cli = $this->_modelClient->find($row[clientId]);
			$row[compName] = $cli[compName];

			$row['Pdg']=$this->_modelPlan->findAll(array('binggangId'=>$row['binggangId']));
			if(count($row[Pdg])==0) {
				$row[vatNum] = '<font color=red>未计划</font>';
			} else {
				$row[vatNum] = join("<br>",array_col_values($row[Pdg],'vatNum'));
				$row[cntPlanTouliao] = join("<br>",array_col_values($row[Pdg],'cntPlanTouliao'));
			}
			$row['Chufang']=$this->_modelChufang->findAll(array('order2wareId'=>$row['Pdg'][0]['order2wareId']));
			//状态 开处方次数
			if(count($row[Chufang])==0) {
				$row[statue] = "<font color=red>未开</font>";
			} else $row[statue] = count($row[Chufang]);

			$row[_edit] = "<a href='".$this->_url('setChufangMerge',array(
				'binggangId' => $row[binggangId],
				'return' => $_GET['action']
			))."'>开处方</a>";

		}
		$arr_field_info = array(
			dateOrder => '下单日期',
			orderCode => '订单号',
			compName => '客户(客户单号)',
			guige => '坯纱规格',
			color => '颜色',
			colorNum => '色号',
			cntKg => '要货数量',
			vatNum => '缸号',
			vatCode => '物理缸号',
			cntPlanTouliao => '计划投料数',
			statue => '已开处方',
			_edit => '操作'
		);
		//dump($rowset);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','开处方');
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}

	/**
	 * @desc ：合并的缸，处方登记方法
	 * Time：2016/07/04 16:20:29
	 * @author Wuyou
	*/
	function actionSetChufangMerge(){
		$this->authCheck(83);
		//已经领料，系统禁止修改
		$chuku = FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$ck=$chuku->findAll(array('chufangId'=>$_GET['chufangId']));
		//dump(count($ck));exit;
		if(count($ck)>0){
			js_alert('已经领料，禁止修改!', '',$_SERVER[HTTP_REFERER]);
		}


		//得到前处理方案
		$qclRow=array();
		$qclSql="SELECT * FROM `jichu_gongyi` where kind='前处理' group by gongyiName";
		$query=mysql_query($qclSql);
		while($re=mysql_fetch_assoc($query)) {
			$qclRow[]=$re;
		}
		//得到染色方案
		$rsRow=array();
		$rsSql="SELECT * FROM `jichu_gongyi` where kind='染色' group by gongyiName";
		$query=mysql_query($rsSql);
		while($re=mysql_fetch_assoc($query)) {
			$rsRow[]=$re;
		}
		//得到后处理方案
		$hclRow=array();
		$hclSql="SELECT * FROM `jichu_gongyi` where kind='后处理' group by gongyiName";
		$query=mysql_query($hclSql);
		while($re=mysql_fetch_assoc($query)) {
			$hclRow[]=$re;
		}
		//得到染色染料方案
		$rscfRow=array();
		$rscfSql="SELECT * FROM `jichu_gongyi` where kind='染色染料' group by gongyiName";
		$query=mysql_query($rscfSql);
		while($re=mysql_fetch_assoc($query)) {
			$rscfRow[]=$re;
		}
		$this->authCheck(83);
		$mgy= & FLEA::getSingleton('Model_Jichu_Gongyi');
		$gongyi=$mgy->findAll(null,'gongyiName');
		$con = array(
			'order2wareId'	=> $_GET['order2wareId'],
			'id'			=> $_GET['chufangId']
		);
		if($con['id']>0)
		$chufang = $this->_modelChufang->find($con);
		//dump($chufang);exit;
		//by zcc 给自动完成的文本框带入修改的值
		$sql = "SELECT * FROM `jichu_gongyi` where id='{$chufang['rsgyId']}'";
		$a = $this->_modelExample->findBySql($sql);
		$selRanseName = $a[0]['gongyiName'];
		$sql = "SELECT * FROM `jichu_gongyi` where id='{$chufang['qclId']}'";
		$a = $this->_modelExample->findBySql($sql);
		$selQclName = $a[0]['gongyiName'];
		$sql = "SELECT * FROM `jichu_gongyi` where id='{$chufang['hclId']}'";
		$a = $this->_modelExample->findBySql($sql);
		$selHclName = $a[0]['gongyiName'];
		$sql = "SELECT * FROM `jichu_gongyi` where id='{$chufang['rscfId']}'";
		$a = $this->_modelExample->findBySql($sql);
		$selRscfName = $a[0]['gongyiName'];

		$str="select y.* from acm_userdb x
			left join jichu_employ y on y.id=x.employId
			where x.id='{$_SESSION['USERID']}'
			and y.id is not NULL
		";
		$re=mysql_fetch_assoc(mysql_query($str));
		$chufangren=$re;
		if($re&&empty($chufang)){
			$chufang['chufangrenId']=$re['id'];
		}
		//dump($_SESSION);
		if($_GET['chufangId']!=''&&$chufangren['id']!=$chufang['chufangrenId']&&$_SESSION['USERNAME']!='admin'){
			js_alert('您不能修改该处方人的处方单！','',$this->_url('list'));
			exit;
		}

		$m = & FLEA::getSingleton('Model_JiChu_Ware');
		$arrQ = array();
		$arrR = array();//染色数组
		$arrZ = array();//后处理数组
		$arrC = array();//染色染料数组
		//dump($chufang['Ware']);exit;
		if(count($chufang['Ware'])>0)
		foreach($chufang['Ware'] as & $row) {
			$row['Ware'] = $m->find($row['wareId']);
			if ($_GET['editModel']=='copy')
			$row['id']='';
			if($row['gongxuId']==1)
				$arrQ[] = $row;
			else if($row['gongxuId']==3)
				$arrZ[] = $row;
			else if($row['gongxuId']==2)
				$arrR[] = $row;
			else if($row['gongxuId']==4)
				$arrC[] = $row;
		}
		//dump($arrQ);exit;
		//该并缸下所有的缸
		$m1 = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$m2 = & FLEA::getSingleton('Model_Plan_Dye_Gangmerge');
		$gangs = $m1->findAll(array(binggangId=>$_GET[binggangId]));
		//并缸的物理缸号和水溶量
		$binggang = $m2->find($_GET['binggangId']);
		// dump($binggang);exit;
		$loop=count($arrR);
		if($loop<4) $loop=3;
		$loop2=count($arrZ);
		if($loop2<6) $loop2=5;
		$loop3=count($arrQ);
		if($loop3<6) $loop3=5;
		$loop4=count($arrC);
		if($loop4<6) $loop4=5;
		//开始显示
		$smarty = & $this->_getView();
		$smarty->assign('loop',$loop);
		$smarty->assign('loop2',$loop2);
		$smarty->assign('loop3',$loop3);
		$smarty->assign('loop4',$loop4);
		$smarty->assign('chufang',$chufang);
		$smarty->assign('gongyi',$gongyi);
		$smarty->assign('ranliao',$arrR);
		$smarty->assign('zhuji',$arrZ);
		$smarty->assign('qcl',$arrQ);
		$smarty->assign('rscf',$arrC);
		$smarty->assign('edit_model', $_GET['editModel']);
		$smarty->assign('gangs',$gangs);
		$smarty->assign('binggang',$binggang);
		$smarty->assign('rsRow',$rsRow);
		$smarty->assign('hclRow',$hclRow);
		$smarty->assign('qclRow',$qclRow);
		$smarty->assign('rscfRow',$rscfRow);
		$smarty->assign('chufangren',$chufangren);
		//赋值
		$smarty->assign('selRanseName',$selRanseName);
		$smarty->assign('selQclName',$selQclName);
		$smarty->assign('selHclName',$selHclName);
		$smarty->assign('selRscfName',$selRscfName);

		$smarty->assign('chufang_id', $_GET['chufangId']);
		$smarty->assign('order2ware_id', $_GET['order2wareId']);
		$smarty->display('Gongyi/Dye/ChufangEdit4Merge.tpl');
	}

	/**
	 * @desc ：合并缸的处方保存
	 * Time：2016/07/04 16:32:56
	 * @author Wuyou
	*/
	function actionSaveChufang4Merge(){
		//更新主表数据, 并得出chufangId
		// dump($_POST);exit;
		$chufangIds = array();
		$count = count($_POST['shuirong']);
		if ($count>0) for($i=0; $i<$count; $i++){
			if ($_POST['shuirong2'][$i] > 0) {
				$_POST['shuirong'][$i] = $_POST['shuirong2'][$i];
			}
		}
		$mGang = & FLEA::getSingleton("Model_Plan_Dye_Gang");
		if($_POST['gangId']) foreach ($_POST['gangId'] as $key=>$v){
			$arrGang[] = array(
				'id'=>$v,
				'zhelv'=>$_POST['zhelv'][$key]+0,
				'shuirong'=>$_POST['shuirong'][$key],
			);
			//更新主表数据, 并得出chufangId
			// dump($_POST);exit;
			$arr = array(
				'dyeKind' => $_POST['dyeKind'],
				'chufangren' => 'xxx', //为了兼容以前的版本中的fuchfangren设定的默认值
				'chufangrenId' => $_POST['chufangrenId']+0,
				'order2wareId'=> $_POST['order2wareId'][$key]+0,
				'dateChufang' => $_POST['dateChufang'],
				'rhlZhelv'=>$_POST['rhlZhelv'],
				'rsgyId'=>$_POST['selRanse'],
				'hclId'=>$_POST['selHcl'],
				'qclId'=>$_POST['selQcl'],
				'ranseKind'=>$_POST['ranseKind'],
				'rscfId'=>$_POST['selRscf'],
				'memoQcl'=>$_POST['memoQcl'].'',
				'memoRs'=>$_POST['memoRs'].'',
				'memoHcl'=>$_POST['memoHcl'].'',
				'memoCf'=>$_POST['memoCf'].'',
			);
			$this->_modelExample->update(array('id'=>$_POST['order2wareId'][$key],'isComplete'=>$_POST['isComplete']));
			$chufangId=$this->_modelChufang->save($arr);//如果是新增, 则返回新增数量主健, 如果是修改, 则返回bool类型
			if($_POST[chufangId][$key]>0) $chufangId=$_POST[chufangId][$key];
			$chufangIds[] = $chufangId;


			//插入明细
			$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
			//dump($_POST);EXIT;
			$w = array();
			foreach($_POST['unitKg'] as $key=>$v) {
				//如果没有选择染料跳过不保存
				if($_POST['mnemocode'][$key]=='')
				{
					if($_POST['chufang2WareId']!=''){
						$this->_modelChufang2Ware->removeByPkv($_POST['chufang2WareId'][$key]);
					}
				    continue;
				}
				//如果没有数量则跳过不保存
				if(empty($v)) {
					//在edit模块下, 如果数量不存在, 还在删除数量没有的老数据
					if(!empty($_POST[chufang2WareId][$key])) {
						$this->_modelChufang2Ware->removeByPkv($_POST[chufang2WareId][$key]);
					}
					continue;
				}
				//dump($_POST);exit;
				//保存数据
				$temp = explode('/',$_POST['mnemocode'][$key]);
				$last = count($temp)-1;
				$ware = $mWare->find($temp[$last]);
				//dump($ware);exit;

				if ($ware && $_POST['unitKg'][$key]!='0.0') {
					//echo($_POST['unit'][$key]."<br>");
					$w[]=array(
						'id'=>$_POST['chufang2WareId'][$key],
						'gongxuId'=>$_POST['gongxuId'][$key],
						'chufangId' => $chufangId,
						'wareId'=>$ware['id'],
						'unitKg'=>$_POST['unitKg'][$key],
						'unit'=>$_POST['unit'][$key],
						'tmp'=>$_POST['tmp'][$key],
						'timeRs'=>$_POST['timeRs'][$key],
						'memo' => $_POST['memo'][$key]
					);
				}
			}
			//exit;
			$newId = $this->_modelChufang2Ware->saveRowset($w);
		}
		$mGang->saveRowset($arrGang);
		// 保存合并的处方
		$mMerge = & FLEA::getSingleton("Model_Gongyi_Dye_Merge");
		$arr = array(
			'vatId'=>$_POST['bgVatId'],
			'shuirong'=>$_POST['bgShuirong'],
			'rsZhelv'=>$_POST['rhlZhelv']
		);
		// dump($_POST['gangId']);exit;
		if ($_POST['gangId']){
			foreach($_POST['gangId'] as $k =>&$v){
				$arr['Gang'][] = array(
					'id'=>$v,
					'mergeChufangId'=>$chufangIds[$k]
				);
			}
		}
		// dump($arr);exit;
		$id=$mMerge->save($arr);
		if($id) {
			if($_POST['Submit']=='确定并打印') {
				redirect($this->_url('PrintMerge',array(
					'mergeId'=>$id
				)));
			} else {
				redirect($this->_url('ListMerge'));
			}
		};
	}
	/**
	 * ps ：处方登记界面的选择处方弹窗显示内容
	 * Time：2017年10月19日
	 * @author zcc
	*/
	function actionPopupChufang(){
		$mChufang = FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$mClient = FLEA::getSingleton('Model_Jichu_Client');

		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			clientId=>'',
			orderCode=>'',
			vatNum=>'',
			wareName=>'',
			color=>'',
			chufangId=>0
		));


		$sql = "SELECT a.*, b.color, b.colorNum, b.wareId, b.cntKg,
				c.orderCode,c.orderCode2, c.clientId,c.id as orderId,
				CONCAT(w.wareName, ' ', w.guige) AS zhibei
			from gongyi_dye_chufang a
			left join trade_dye_order2ware b on a.order2wareId = b.id
			left join trade_dye_order c on b.orderId = c.id
			left join jichu_ware w on w.id = b.wareId
			where 1";
		if ($arr['clientId']!='') $sql .=	" and clientId=$arr[clientId]";
		if ($arr[orderCode]!='') $sql .= " and orderCode like '%$arr[orderCode]%'";
		if ($arr[vatNum]!='') {
			$ss = "select order2wareId from plan_dye_gang
			where vatNum like '%$arr[vatNum]%'";
			$temp = $mClient->findBySql($ss);
			$tempArr = array('');
			foreach($temp as &$v) {
				$tempArr[] = $v['order2wareId'];
			}
			if(count($temp)>0) {
				$sql .= " and order2wareId in ('".join("','",$tempArr)."')";
			}

		}
		// if ($arr[wareId] != '') $sql .= " and wareId=$arr[wareId]";
		// if ($arr[wareName] != '') $sql .= " and wareId=$arr[wareId]";
		if ($arr[color] != '') $sql .= " and color like '%$arr[color]%'";
		if ($arr[cntPlanTouliao] != '') $sql .= " and cntKg = $arr[cntPlanTouliao]";
		//if ($arr[chufangren]!='0') $sql .= " and chufangren='$arr[chufangren]'";
		if ($arr[chufangrenId]>0) $sql .= " and chufangrenId='$arr[chufangrenId]'";
		if ($arr[chufangId]>0) $sql .= " and a.id='$arr[chufangId]'";

		//点击订单号之后按订单号排序 by-zhujunjie
		if($_GET['sort']==1){
			$arr['sort']=1;
		}
		$pageSize = 20;
		//组合的字段筛选 进行包装
		$sql = "SELECT * FROM ($sql) as x WHERE 1";
        if ($arr['wareName']) {
            $sql .=" and x.zhibei like '%{$arr['wareName']}%'";
        }
        //点击订单号之后按订单号排序
		if($_GET['sort']==1||$arr['sort']==1){
			$sql .= " group by x.id order by x.orderCode desc";
		}else{
			$sql .= " group by x.id order by x.dateChufang desc";
		}
		$pager = & new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAll();
		//dump($rowset[0]);
		$mEmploy = &FLEA::getSingleton('Model_JiChu_Employ');

		if(count($arr)>0) foreach($rowset as & $row) {
			//构造备注显示数据 by zcc 2017年11月30日 17:06:31 把每一个类型的第一个备注获取并且组装
			// $Chufang2Ware = $this->_modelChufang2Ware->findAll(array('chufangId'=>$row['id']));
			$sql = "SELECT a.*
			FROM (
				SELECT * FROM gongyi_dye_chufang2ware where chufangId = {$row['id']} order by id asc
			) a
			group by a.gongxuId ";
			$chufang2ware = $this->_modelExample->findBySql($sql);
			// dump($chufang2ware);die();
			$memo = '';
			foreach ($chufang2ware as &$value) {
				if ($value['gongxuId']==4 && $value['memo']) {
					$memo4 = " 染色染料:".$value['memo'];
				}
				if ($value['gongxuId']==1 && $value['memo']) {
					$memo1 = " 前处理:".$value['memo'];
				}
				if ($value['gongxuId']==2 && $value['memo']) {
					$memo3 = " 染色助剂:".$value['memo'];
				}
				if ($value['gongxuId']==3 && $value['memo']) {
					$memo2 = " 后处理:".$value['memo'];
				}
			}
			$row['memo'] = $memo4.$memo1.$memo3.$memo2;
			if ($row[chufangrenId] != 0) {
				$rowEmploy = $mEmploy->find($row[chufangrenId]);
				$row[chufangren] = $rowEmploy[employName];
			}
			#取得规格参数
			if($row[wareId]>0) $rowWare=$this->_modelWare->find($row[wareId]);
			$row[guige] = $rowWare[wareName] . " " .$rowWare[guige];

			#取得公司名称
			$rowClient = $mClient->find($row[clientId]);
			$row[clientName] = $rowClient[compName];
			// $row['orderCode']=$this->_modelOrder->getOrderTrack($row[orderId],$row[orderCode]);
			//取得客户单号
			if($row['orderCode2']!='') $row['clientName']=$row['clientName'].'('.$row['orderCode2'].')';

			$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
                #显示逻辑缸号和打印,如果gangId>0则只显示某一缸
                if ($row[gangId]>0) {//只显示某一缸

                    $aGang = $m->find(array(id=>$row[gangId]));
					$row['vatNum']=$m->setVatNum($row['gangId'],$row['order2wareId']);
                    $row[vatNum] = $row[vatNum];
                } else {
                    $ordWare = $this->_modelExample->find($row[order2wareId]);
					$str="select * from plan_dye_gang where order2wareId='{$row['order2wareId']}' and parentGangId=0";
					$query=mysql_query($str);
					$ordWare1=array();
					while($re=mysql_fetch_assoc($query)){
						$ordWare1[]=$re;
					}
                    //if(count($ordWare[Pdg])>0) {
					if(count($ordWare1)>0) {
                        //foreach($ordWare[Pdg] as &$tempV) {
						foreach($ordWare1 as &$tempV) {
                            if ($arr[vatNum] != '') {
                                if ($tempV[vatNum] == trim($arr[vatNum]))
                                    $row[display] = 'true';
                            }
							$tempV['vatNum']=$m->setVatNum($tempV['id'],$row['order2wareId']);
                            $tempV[vatNum] = $tempV[vatNum];
                        }
                        //$tempArr = array_col_values($ordWare[Pdg],'vatNum');
						$tempArr = array_col_values($ordWare1,'vatNum');
                        $row[vatNum] = join("<br>",$tempArr);
                    }
                }
                if ($row['chufangKind']=='0') {
                	$row['chufangKindName'] = '正常';
                }
                if ($row['chufangKind']=='1') {
                	$row['chufangKindName'] = '加料';
                }
                if ($row['chufangKind']=='2') {
                	$row['chufangKindName'] = '修色';
                }
            }

		//dump($rowset[0]); exit;

		$arr_field_info = array(
			dateChufang => '开方日期',
			orderCode => "订单号",
			clientName => '客户(客户单号)',
			guige => '坯纱规格',
			color => '颜色',
			cntKg => '总公斤数',
			vatNum => '适用缸号',
			chufangren => '处方人',
			'chufangKindName' =>'处方性质',
			'ranseKind' =>'染色类别',
			'memo' =>'备注',
		);
        // dump($rowset);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','已开处方管理');
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');		//取消新增按钮
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arr)));
		// $smarty->display('TableList.tpl');

		$smarty-> display('Popup/Popup2.tpl');

	}
	/**
	 * ps ：获取某个处方的处方明细数据
	 * Time：2017年10月19日 12:49:25
	 * @author zcc
	*/
	function actionAjaxGetChufangMx(){
		$sql = "SELECT y.gongxuId,y.wareId,y.unitKg,y.unit,y.timeRs,y.memo,w.wareName,w.guige,y.wareId,w.mnemocode,y.tmp
			FROM gongyi_dye_chufang x
			left join gongyi_dye_chufang2ware y on x.id =y.chufangId
			left join jichu_ware w on w.id = y.wareId
			where 1 and x.id = '{$_GET['id']}'";
		$row = $this->_modelExample->findBySql($sql);
		$arrQ = array();
		$arrR = array();
		$arrH = array();
		$arrC = array();
		foreach ($row as &$v) {
			// $v['wareName'] = $v['wareName'].'     /'.$v['wareId'];
			if ($v['gongxuId']==1) {
				$arrQ[] = $v;
			}
			if ($v['gongxuId']==2) {
				$arrR[] = $v;
			}
			if ($v['gongxuId']==3) {
				$arrH[] = $v;
			}
			if ($v['gongxuId']==4) {
				$arrC[] = $v;
			}
		}
		//找出这处方使用的方案和方案别名
		$sql = "SELECT x.rsgyId,x.memoRs,a.gongyiName as gongyiNameRsgy,
			x.qclId,x.memoQcl,b.gongyiName as gongyiNameQcl,
			x.hclId,x.memoHcl,c.gongyiName as gongyiNameHcl,
			x.rscfId,x.memoCf,d.gongyiName as gongyiNameRscf
			FROM gongyi_dye_chufang x
			left join jichu_gongyi a on x.rsgyId = a.id
			left join jichu_gongyi b on x.qclId = b.id
			left join jichu_gongyi c on x.hclId = c.id
			left join jichu_gongyi d on x.rscfId = d.id
			where x.id = '{$_GET['id']}'";
		$fangan	 = $this->_modelExample->findBySql($sql);
		foreach ($fangan as &$va) {
			//移除null值
			if ($va['rsgyId']==0) {
				$va['gongyiNameRsgy'] = '';
			}
			if ($va['qclId']==0) {
				$va['gongyiNameQcl'] = '';
			}
			if ($va['hclId']==0) {
				$va['gongyiNameHcl'] = '';
			}
			if ($va['rscfId']==0) {
				$va['gongyiNameRscf'] = '';
			}
		}
		//带入数组
		$arr = array(
			'success'=>count($row)>0?true:false,
			'fangan'=>$fangan[0],
			'arrQ'=>$arrQ,
			'arrR'=>$arrR,
			'arrH'=>$arrH,
			'arrC'=>$arrC,
		);
		echo json_encode($arr);
	}
}
?>
