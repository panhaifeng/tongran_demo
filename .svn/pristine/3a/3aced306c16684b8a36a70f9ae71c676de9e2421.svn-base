<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Cangku_Yl_Kucun extends Tmis_Controller {
	var $_modelExample;
	//var $funcId = 111;
	var $funcId = 51;
	function Controller_Cangku_Yl_Kucun() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_Cangku_Yl_Kucun');
	}
	/**
	 * ps ： 染化料报表(new)
	 * Time：2017年12月12日 14:10:13
	 * @author zcc
	*/
	function actionMonthReport(){
		set_time_limit(0);
		$this->authCheck(118);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'rlzj'=>'染料类',
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d')
		));
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$ranliao=$mWare->find(array('wareName'=>$arr['rlzj']));
		//主sql
		$str="SELECT * 
			from jichu_ware 
			where leftId+1=rightId and leftId>'{$ranliao['leftId']}' and rightId<'{$ranliao['rightId']}' and isDel=0";
		if($arr['key']!='')$str.=" and wareName like '%{$arr['key']}%'";

		if ($arr['rlzj']=='染料类') {
			$str.=" order by parentId asc,convert(wareName using gbk) ASC";
		}else{
			$str.=" order by parentId asc,orderLine asc";
		}
		$pager= & new TMIS_Pager($str,null,null,20);		
		$rowset = $pager->findAll();
		// dump($rowset);die();
		if(count($rowset)>0) {
			foreach($rowset as $key=>& $v){
				//上期库存 则为 上期实际的库存
				$init = $this->_modelExample->getInitInfoReport($v['id'],$arr['dateFrom']);
				$v['kucunQc'] = $init['cnt'];
				//本期入库数 则为入库登记中kind=0的数据
				$sqlRk = "SELECT sum(y.cnt) as cnt,sum(y.cnt*y.danjia) as money
					FROM cangku_yl_ruku x
					LEFT JOIN cangku_yl_ruku2ware y on x.id = y.rukuId
					WHERE x.kind = 0 and y.wareId ={$v['id']} 
					and x.rukuDate>='{$arr['dateFrom']}' and x.rukuDate<='{$arr['dateTo']}'";
				$ruku = mysql_fetch_assoc(mysql_query($sqlRk));
				$v['cntRuku'] = $ruku['cnt'];	
				//本期转到车间的 数量（仓库转到车间）
				$sqlCj = "SELECT sum(y.cnt) as cnt,sum(y.cnt*y.danjia) as money 
					FROM cangku_yl_ruku x
					LEFT JOIN cangku_yl_ruku2ware y on x.id = y.rukuId
					WHERE x.kind = 8 and y.wareId ={$v['id']} and x.kuwei = 1
					and x.rukuDate>='{$arr['dateFrom']}' and x.rukuDate<='{$arr['dateTo']}'";
				// dump($sqlCj);die();	
				$rukuCj = mysql_fetch_assoc(mysql_query($sqlCj));
				$v['chejianCnt'] = $rukuCj['cnt'];	
				//本期车间领用 即为 领用出库 （现在领料出库只针对车间库位里面的染料进行领用）
				$sqlCk = "SELECT sum(y.cnt) as cnt,sum(y.cnt*y.danjia+y.money) as money 
					FROM cangku_yl_chuku x
					LEFT JOIN cangku_yl_chuku2ware y on x.id = y.chukuId
					WHERE x.kind = 0 and y.wareId ={$v['id']} 
					and x.chukuDate>='{$arr['dateFrom']}' and x.chukuDate<='{$arr['dateTo']}'";
				$chukuCj = mysql_fetch_assoc(mysql_query($sqlCk));
				$v['chukuCnt'] = $chukuCj['cnt'];
				// 车间库位数据 返回到 仓库	（车间返送仓库）
				$sqlFk = "SELECT sum(y.cnt) as cnt,sum(y.cnt*y.danjia) as money 
					FROM cangku_yl_ruku x
					LEFT JOIN cangku_yl_ruku2ware y on x.id = y.rukuId
					WHERE x.kind = 8 and y.wareId ={$v['id']} and x.kuwei = 0
					and x.rukuDate>='{$arr['dateFrom']}' and x.rukuDate<='{$arr['dateTo']}'";
				$rukuFk = mysql_fetch_assoc(mysql_query($sqlFk));
				$v['fankuCnt'] = $rukuFk['cnt'];
				//调库 数据
				$sqlTk = "SELECT sum(y.cnt) as cnt,sum(y.cnt*y.danjia+y.money) as money 
					FROM cangku_yl_chuku x
					LEFT JOIN cangku_yl_chuku2ware y on x.id = y.chukuId
					WHERE x.kind = 9 and y.wareId ={$v['id']} 
					and x.chukuDate>='{$arr['dateFrom']}' and x.chukuDate<='{$arr['dateTo']}'";
				$chukuTj = mysql_fetch_assoc(mysql_query($sqlTk));
				$v['tiaoCnt'] = $chukuTj['cnt'];

				//实际库存 = 期初+本期入库 -（仓库到车间）+（车间返送仓库)+abs(调库);
				$v['kucunSj'] = $v['kucunQc']+$v['cntRuku']-$v['chejianCnt']+$v['fankuCnt']+abs($v['tiaoCnt']);
				//理论库存 = 期初+本期入库 - 领用出库 +abs(调库)
				$v['kucunL'] = $v['kucunQc']+$v['cntRuku']-$v['chukuCnt']+abs($v['tiaoCnt']);
			}
		}
		$heji = $this->getHeji($rowset,array('kucunQc','cntRuku','chejianCnt','fankuCnt','chukuCnt','tiaoCnt','kucunSj','kucunL'),'wareName');
		$rowset[] = $heji;
		$smarty = & $this->_getView();
        $arrFieldInfo = array(
            'wareName'   =>'名称',
            'guige'  =>'规格',
            'unit'  =>'单位',
            'kucunQc' =>'上期库存',
            'cntRuku' => '本月入库',
            'chejianCnt' => '转拨车间',
            'fankuCnt'  =>'转回仓库',
            'chukuCnt' => '车间领料',
            'tiaoCnt'=>'调库数量',
            'kucunSj' => '实际库存',
            'kucunL' =>'理论库存',
        );
        $smarty->assign('title','染化料报表');
        $smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('add_display',none);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty->display('TableList.tpl');
        // $smarty-> display('CangKu/Yl/ReportNew.tpl');
		
	}
	//染化料月报表，染化料单位用克，助剂用斤
	function actionRight()	{
		set_time_limit(0);
		$title = '染化料仓库管理-库存查询';
		$this->authCheck(118);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'rlzj'=>'染料类',
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d')
			//'supplierId'=>0,
			//'traderId'=>0,
			//'type'=>0
		));

		/*$sql = $this->_modelExample->getKucunSql($arr['dateFrom'],$arr['dateTo']);
		//dump($sql);exit;ht
		//dump($condition);
		$pager =& new TMIS_Pager($sql,null,null,100);
		//echo $pager;
        $rowset =$pager->findAll();*/
		
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		// $ranliao=$mWare->find(array('wareName'=>'染料类'));
		// $zhuji=$mWare->find(array('wareName'=>'助剂类'));
		$ranliao=$mWare->find(array('wareName'=>$arr['rlzj']));
		$str="select * from jichu_ware 
			where leftId+1=rightId and leftId>'{$ranliao['leftId']}' and rightId<'{$ranliao['rightId']}' and isDel=0";
		if($arr['key']!='')$str.=" and wareName like '%{$arr['key']}%'";
		if ($arr['rlzj']=='染料类') {
			$str.=" order by parentId asc,convert(wareName using gbk) ASC";
		}else{
			$str.=" order by parentId asc,orderLine asc";
		}
		$pager= & new TMIS_Pager($str,null,null,20);		
		$rowset = $pager->findAll();
        //dump($rowset);exit;
		$m = & $this->_modelExample;
		// echo join(',',array_col_values($rowset,'id'));
		if(count($rowset)>0) foreach($rowset as $key=>& $v){
			// dump($v);exit;
			// /$v['Ware'] = $mWare->find(array('id'=>$v['id']));
			$init = $m->getInitInfo($v['id'],$arr['dateFrom']);
			$ruku = $m->getRukuInfo($v['id'],$arr['dateFrom'],$arr['dateTo']);
			$chuku = $m->getChukuInfo($v['id'],$arr['dateFrom'],$arr['dateTo'],10);
			$tiao = $m->getChukuInfo($v['id'],$arr['dateFrom'],$arr['dateTo'],9);//调库记录kind=9
			
			$v['cntInit'] = $init['cnt']+0;
			$v['moneyInit'] = round($init['money'],2);
            if($v['cntInit']!=0) $v['danjiaInit']=round($v['moneyInit']/$v['cntInit'],2);

			$v['cntRuku'] = $ruku['cnt']+0;
			$v['moneyRuku'] = round($ruku['money'],2);
            if($v['cntRuku']!=0) $v['danjiaRuku']=round($v['moneyRuku']/$v['cntRuku'],2);

			
			if ($v['cntRuku']) $danjia=round($v['moneyRuku']/$v['cntRuku'],4);
			else $danjia = 0;

			$v['cntChuku'] = $chuku['cnt']+0;

			//得到出库单价和出库金额
			// $str="select * from cangku_yl_ruku2ware where wareId='{$v['id']}' order by id desc";
			// $re=mysql_fetch_assoc(mysql_query($str));
			// if($re['danjia']>0) {
			// 	$v['danjiaChuku'] = $re['danjia'];
			// } else {
			// 	$sql="select y.money/y.cnt as danjia
			// 	from cangku_yl_chuku x
			// 	left join cangku_yl_chuku2ware y on y.chukuId=x.id
			// 	where x.kind=9
			// 	and y.wareId='{$v['id']}'
			// 	and y.money<>0
			// 	order by y.id desc";
			// 	$re1=mysql_fetch_assoc(mysql_query($sql));
			// 	if($re1['danjia']>0) {
			// 		$v['danjiaChuku'] = $re1['danjia'];
			// 	} else {
			// 		$v['danjiaChuku'] = $v['danjia'];
			// 	}
			// }
			// $v['moneyChuku']=round($v['danjiaChuku']*$v['cntChuku'],2);			
			$v['moneyChuku']=$chuku['money']+0;			
			

			$v['cntTiao'] = $tiao['cnt']+0;
			//$v['moneyChuku'] = $chuku['money'];
            //if($v['cntChuku']!=0) $v['danjiaChuku']=round($v['moneyChuku']/$v['cntChuku'],2);
			$v['danjiaTiao']=round($tiao['money']/$v['cntTiao'],2);
			$v['moneyTiao']=round($v['danjiaTiao']*$v['cntTiao'],2);

			$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku']-$v['cntTiao'],2);
			//dump($tiao);
			$v['moneyKucun'] = round($init['money'] + $ruku['money'] - $chuku['money']-$tiao['money'],2);
			if($v['cntKucun']!=0) $v['danjiaKucun']=round($v['moneyKucun']/$v['cntKucun'],4);
  
		}
		$heji = $this->getHeji($rowset,array('cntInit','cntRuku','cntChuku','cntKucun','cntTiao','moneyTiao','moneyInit','moneyRuku','moneyChuku','moneyKucun'),'wareName');		
		if(count($rowset)>0) foreach($rowset as & $v){
			$v['cntRuku'] = $v['cntRuku']!=0 ? "<a href='".url('Cangku_Yl_Ruku','RukuDetail',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'wareId'=>$v['id']
			))."' target='_blank'>".$v['cntRuku']."</a>":0;
			$v['cntChuku'] = $v['cntChuku']!=0 ? "<a href='".url('Cangku_Yl_Chuku','ChukuDetail',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'wareId'=>$v['id']
			))."' target='_blank'>".$v['cntChuku']."</a>":0;
			//$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'],2);
		}
		$rowset[] = $heji;

		//得到期初总计	

		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia) as money
		FROM	`cangku_yl_ruku2ware` `x`
		LEFT JOIN `cangku_yl_ruku` `y` ON((`x`.`rukuId` = `y`.`id`))
		left join jichu_ware z on x.wareId=z.id
		where z.leftId>'{$ranliao['leftId']}' and z.rightId<'{$ranliao['rightId']}' and z.isDel=0
		and y.rukuDate<'{$arr['dateFrom']}'";
		$ruku = mysql_fetch_assoc(mysql_query($sql));
		// dump($sql);dump($ruku);		
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia+x.money) as money
		FROM `cangku_yl_chuku2ware` `x`
		LEFT JOIN `cangku_yl_chuku` `y` ON((`x`.`chukuId` = `y`.`id`))
		left join jichu_ware z on x.wareId=z.id
		where z.leftId>'{$ranliao['leftId']}' and z.rightId<'{$ranliao['rightId']}' and z.isDel=0 and y.chukuDate<'{$arr['dateFrom']}'";		
		$chuku = mysql_fetch_assoc(mysql_query($sql));
		$_arr = array();
		$_arr['wareName']= '<b>总计</b>';
		$_arr['cntInit'] = round($ruku['cnt'] - $chuku['cnt'],2);
		$_arr['moneyInit'] = round($ruku['money'] - $chuku['money'],2);

		//得到入库总计
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia) as money
		FROM	`cangku_yl_ruku2ware` `x`
		LEFT JOIN `cangku_yl_ruku` `y` ON((`x`.`rukuId` = `y`.`id`))
		left join jichu_ware z on x.wareId=z.id
		where z.leftId>'{$ranliao['leftId']}' and z.rightId<'{$ranliao['rightId']}' and z.isDel=0 
		and y.rukuDate>='{$arr['dateFrom']}' and y.rukuDate<='{$arr['dateTo']}' ";
		$ruku = mysql_fetch_assoc(mysql_query($sql));
		$_arr['cntRuku'] = round($ruku['cnt'],2);
		$_arr['moneyRuku'] = round($ruku['money'],2);

		//得到出库总计
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia+x.money) as money
		FROM `cangku_yl_chuku2ware` `x`
		LEFT JOIN `cangku_yl_chuku` `y` ON((`x`.`chukuId` = `y`.`id`))
		left join jichu_ware z on x.wareId=z.id
		where z.leftId>'{$ranliao['leftId']}' and z.rightId<'{$ranliao['rightId']}' and z.isDel=0 
		and y.chukuDate>='{$arr['dateFrom']}' and y.chukuDate<='{$arr['dateTo']}'
		and y.kind<>9";
		// dump($sql);exit;
		// mysql_query($sql) or die(mysql_error());		
		$chuku = mysql_fetch_assoc(mysql_query($sql));
		$_arr['cntChuku'] = round($chuku['cnt'],2);
		$_arr['moneyChuku'] = round($chuku['money'],2);

		//得到调库总计
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia+x.money) as money
		FROM `cangku_yl_chuku2ware` `x`
		LEFT JOIN `cangku_yl_chuku` `y` ON((`x`.`chukuId` = `y`.`id`))
		left join jichu_ware z on x.wareId=z.id
		where z.leftId>'{$ranliao['leftId']}' and z.rightId<'{$ranliao['rightId']}' and z.isDel=0 
		and y.chukuDate>='{$arr['dateFrom']}' and y.chukuDate<='{$arr['dateTo']}'
		and y.kind=9";
		// mysql_query($sql) or die(mysql_error());		
		$chuku = mysql_fetch_assoc(mysql_query($sql));
		$_arr['cntTiao'] = round($chuku['cnt'],2);
		$_arr['moneyTiao'] = round($chuku['money'],2);

		$rowset[] = $_arr;
        //助剂类
		// $heji2 = $this->getHeji($rowset2,array('cntInit','cntRuku','cntChuku','cntKucun','moneyInit','moneyRuku','moneyChuku','moneyKucun'),'Ware.wareName');
		// if(count($rowset)>0) foreach($rowset2 as & $v){
		// 	$v['cntRuku'] = $v['cntRuku']!=0 ? "<a href='".url('Cangku_Yl_Ruku','RukuDetail',array(
		// 		'dateFrom'=>$arr['dateFrom'],
		// 		'dateTo'=>$arr['dateTo'],
		// 		'wareId'=>$v['id']
		// 	))."' target='_blank'>".$v['cntRuku']."</a>":0;
		// 	$v['cntChuku'] = $v['cntChuku']!=0 ? "<a href='".url('Cangku_Yl_Chuku','ChukuDetail',array(
		// 		'dateFrom'=>$arr['dateFrom'],
		// 		'dateTo'=>$arr['dateTo'],
		// 		'wareId'=>$v['id']
		// 	))."' target='_blank'>".$v['cntChuku']."</a>":0;
		// 	//$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'],2);
		// }
		
		//$rowset=array_column_sort($rowset,'wareId','SORT_ASC');
		//$rowset2=array_column_sort($rowset2,'wareId','SORT_ASC');
		//dump($rowset);dump($rowset2);exit;
		//echo(count($rowset));echo(count($rowset2));exit;
		//dump($rowset);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_field_value2',$rowset2);
		$smarty->assign('heji',$heji);
        $smarty->assign('heji2',$heji2);
		$smarty->assign('from',$arr['dateFrom']);
		$smarty->assign('to',$arr['dateTo']);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		$smarty->assign('nowrap', 1);
		$smarty->assign('page_info', $pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display('CangKu/Yl/Report.tpl');
	}

	// function getChukuInfo($wareId,$dateFrom,$dateTo,$kind){
	// 	$str="select sum(cnt) cnt,sum(cnt*danjia+money) money from view_yl_chuku where wareId = '{$wareId}' and chukuDate >= '{$dateFrom}' and chukuDate <= '{$dateTo}'";
	// 	if($kind>9)$str.=" and kind<>9";
	// 	else $str.=" and kind='{$kind}'";
	// 	//echo $str.'<br>';
	// 	$re=mysql_fetch_assoc(mysql_query($str));
	// 	return $re;
	// }
	//染化料月报表2，染化料单位用公斤，助剂用吨
	function actionRight2()	{
		$this->authCheck($this->funcId);
		$title = '染化料月报表2';
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d')
		));

		$sql = $this->_modelExample->getKucunSql($arr['dateFrom'],$arr['dateTo']);;
		$pager =& new TMIS_Pager($sql,null,null,100);
        $rowset =$pager->findAll();
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$m = & $this->_modelExample;
		$rowset2=array();
		if(count($rowset)>0) foreach($rowset as $key=>& $v){
			$v['Ware'] = $mWare->find(array('id'=>$v['wareId']));
			$init = $m->getInitInfo($v['wareId'],$arr['dateFrom']);
			$ruku = $m->getRukuInfo($v['wareId'],$arr['dateFrom'],$arr['dateTo']);
			$chuku = $m->getChukuInfo($v['wareId'],$arr['dateFrom'],$arr['dateTo']);

			//期初
			$v['cntInit'] = $init['cnt']+0;
			$v['moneyInit'] = $init['money'];
            if($v['cntInit']!=0) $v['danjiaInit']=round($v['moneyInit']/$v['cntInit'],4);
			//else $v['danjiaInit'] = 0;
			//期初换算，数量为公斤，单价*1000
			$v['cntInit'] = round($v['cntInit']/1000,4);
			$v['danjiaInit'] = $v['danjiaInit']*1000;
			

			//本期入库
			$v['cntRuku'] = $ruku['cnt']+0;
			$v['moneyRuku'] = $ruku['money'];
            if($v['cntRuku']!=0) $v['danjiaRuku']=round($v['moneyRuku']/$v['cntRuku'],4);
			else $v['danjiaRuku'] = 0;
			//期初换算
			$v['cntRuku'] = round($v['cntRuku']/1000,4);
			$v['danjiaRuku'] = $v['danjiaRuku']*1000;

			//本期出库
			if ($v['cntRuku']) $danjia=round($v['moneyRuku']/$v['cntRuku'],4);
			else $danjia = 0;			
			$v['cntChuku'] = $chuku['cnt']+0;
			$v['moneyChuku']=$danjia*$v['cntChuku'];
			$v['danjiaChuku']=$danjia;
			//期初换算
			$v['cntChuku'] = round($v['cntChuku']/1000,4);
			$v['danjiaChuku'] = $v['danjiaChuku']*1000;

			//本期库存
			$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'],2);
			$v['moneyKucun'] = round($v['moneyInit'] + $v['moneyRuku'] - $v['moneyChuku'],4);
			if($v['cntKucun']!=0) $v['danjiaKucun']=round($v['moneyKucun']/$v['cntKucun'],4);
			else $v['danjiaKucun'] = 0;
			//期初换算
			$v['cntKucun'] = round($v['cntKucun']/1000,4);
			$v['danjiaKucun'] = $v['danjiaKucun']*1000;


            $ranliao=$mWare->find(array('wareName'=>'染料类'));
			if($v['Ware']['leftId']>$ranliao['leftId'] && $v['Ware']['rightId']<$ranliao['rightId']){
				//$v=$v;
			}
			else{//助剂类
			    $zhuji=$v;
			    unset($rowset[$key]);
				$rowset2[]=$zhuji;
			}
		}
		$heji = $this->getHeji($rowset,array('cntInit','cntRuku','cntChuku','cntKucun','moneyInit','moneyRuku','moneyChuku','moneyKucun'),'Ware.wareName');
		if(count($rowset)>0) foreach($rowset as & $v){
			$v['cntRuku'] = $v['cntRuku']!=0 ? "<a href='".url('Cangku_Yl_Ruku','right',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'wareId'=>$v['wareId']
			))."' target='_blank'>".$v['cntRuku']."</a>":0;
			$v['cntChuku'] = $v['cntChuku']!=0 ? "<a href='".url('Cangku_Yl_Chuku','right1',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'wareId'=>$v['wareId']
			))."' target='_blank'>".$v['cntChuku']."</a>":0;
			//$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'],2);
		}


        //助剂类
		$heji2 = $this->getHeji($rowset2,array('cntInit','cntRuku','cntChuku','cntKucun','moneyInit','moneyRuku','moneyChuku','moneyKucun'),'Ware.wareName');
		if(count($rowset)>0) foreach($rowset2 as & $v){
			$v['cntRuku'] = $v['cntRuku']!=0 ? "<a href='".url('Cangku_Yl_Ruku','right',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'wareId'=>$v['wareId']
			))."' target='_blank'>".$v['cntRuku']."</a>":0;
			$v['cntChuku'] = $v['cntChuku']!=0 ? "<a href='".url('Cangku_Yl_Chuku','right',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'wareId'=>$v['wareId']
			))."' target='_blank'>".$v['cntChuku']."</a>":0;
			//$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'],2);
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_field_value2',$rowset2);
		$smarty->assign('heji',$heji);
        $smarty->assign('heji2',$heji2);
		$smarty->assign('from',$arr['dateFrom']);
		$smarty->assign('to',$arr['dateTo']);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display','none');
		$smarty->assign('nowrap',1);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('CangKu/Yl/Report2.tpl');
	}
	#库存调整
	function actionChangeKucun(){
		$this->authCheck(119);
		FLEA::loadClass('TMIS_Pager');
		$arr=& TMIS_Pager::getParamArray(array(
			'key'=>''	
		));
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$ranliao=$mWare->find(array('wareName'=>'染料类'));
		$zhuji=$mWare->find(array('wareName'=>'助剂类'));
		
		$str="select * from jichu_ware where leftId+1=rightId and leftId>'{$ranliao['leftId']}' and rightId<'{$ranliao['rightId']}' and isDel=0";
		if($arr['key']!='')$str.=" and wareName like '%{$arr['key']}%'";
		$str.=" order by parentId asc,orderLine asc";
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			$rowset[]=$re;
		}
		$str="select * from jichu_ware where leftId+1=rightId and leftId>'{$zhuji['leftId']}' and rightId<'{$zhuji['rightId']}' and isDel=0";
		//echo $str;exit;
		if($arr['key']!='')$str.=" and wareName like '%{$arr['key']}%'";
		$str.=" order by orderLine asc";
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			$rowset[]=$re;
		}
		if(count($rowset)>0)foreach($rowset as & $v){
			#取得入库数
			$str="select sum(cnt) as cnt
				from cangku_yl_ruku2ware
				where wareId='{$v['id']}'
			";
			//by zcc  改变算出库存的算法 2017年12月15日 16:20:57
			$strNewR = "SELECT sum(x.cnt) as cnt
				FROM cangku_yl_ruku2ware x 
				LEFT JOIN cangku_yl_ruku y on x.rukuId = y.id
				WHERE x.wareId='{$v['id']}' and y.kuwei = 0
				";
			$re=mysql_fetch_assoc(mysql_query($strNewR));

			#取得出库数
			$str1="select sum(cnt) as cnt
				from cangku_yl_chuku2ware
				where wareId='{$v['id']}'
			";
			$strNewC = "SELECT sum(cnt) as cnt
				FROM cangku_yl_chuku2ware x 
				LEFT JOIN cangku_yl_chuku y on x.chukuId = y.id
				WHERE x.wareId='{$v['id']}'and y.kuwei = 0 and y.kind <> 0 
				";
			$re1=mysql_fetch_assoc(mysql_query($strNewC));
			$v['cntKucun']=$re['cnt']-$re1['cnt'];
			$v['_edit']="<a href='".$this->_url('kucun',array('wareId'=>$v['id'],'TB_iframe'=>1))."' class='thickbox'>调整</a>";
		}
		$arr_field_info=array(
			'wareName'=>'品名',
			'guige'=>'规格',
			'unit'=>'单位',
			'cntKucun'=>'库存数',
			'_edit'=>'操作'
		);
		$smarty=& $this->_getView();
		$smarty->assign('title','库存调整');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('grid','thickbox')));
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList2.tpl');
	}
	function actionKucun(){
		$str="select * from jichu_ware where id='{$_GET['wareId']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		$row['wareName']=$re['wareName'];
		$row['guige']=$re['guige'];
		$row['wareId']=$_GET['wareId'];
		#取得入库数
		$str="select sum(cnt) as cnt,sum(danjia*cnt) as money
			from cangku_yl_ruku2ware
			where wareId='{$_GET['wareId']}'
		";
		$strNewR = "SELECT sum(x.cnt) as cnt,sum(x.danjia*x.cnt) as money
				FROM cangku_yl_ruku2ware x 
				LEFT JOIN cangku_yl_ruku y on x.rukuId = y.id
				WHERE x.wareId='{$_GET['wareId']}' and y.kuwei = 0
				";
		$re=mysql_fetch_assoc(mysql_query($strNewR));

		#取得出库数
		$str1="select sum(cnt) as cnt,sum(danjia*cnt+money) as money
			from cangku_yl_chuku2ware
			where wareId='{$_GET['wareId']}'
		";
		$strNewC = "SELECT sum(x.cnt) as cnt,sum(x.danjia*x.cnt+x.money) as money
			FROM cangku_yl_chuku2ware x 
			LEFT JOIN cangku_yl_chuku y on x.chukuId = y.id
			WHERE x.wareId='{$_GET['wareId']}'and y.kuwei = 0 and y.kind <> 0 
			";
		$re1=mysql_fetch_assoc(mysql_query($strNewC));
		$row['cntKucun']=$re['cnt']-$re1['cnt'];
		$row['kucunMoney']=$re['money']-$re1['money'];
		$smarty=& $this->_getView();
		$smarty->assign('aRow',$row);
		$smarty->display('CangKu/Yl/ChangeKucun.tpl');
	}
	function actionSaveChange(){
		//dump($_POST);exit;
		$m= & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$cnt=0-($_POST['cnt']-$_POST['cntKucun']);
		$money=0-($_POST['money']-$_POST['kucunMoney']);
		$kk[]=array(
			'wareId'=>$_POST['wareId'],
			'cnt'=>$cnt,
			//'danjia'=>$money/$cnt,
			'money'=>$money
		);
		$memo='库存调整'.',库存由：'.$_POST['cntKucun'].',调为：'.$_POST['cnt'];
		$arr=array(
			'chukuDate'=>date('Y-m-d'),
			'chukuNum'=>$m->getNewChukuNum(),
			'memo'=>$memo,
			'kind'=>9,
			'Wares'=>$kk
		);
		//dump($arr);exit;
		$m->save($arr);
		js_alert('保存成功！','window.parent.location.href=window.parent.location.href;');
	}
	#库存调整查询
	function actionSearch(){
		$this->authCheck(120);
		FLEA::loadClass('TMIS_Pager');
		$arr=& TMIS_Pager::getParamArray(array(
			'key'=>''	
		));
		$str="select x.*,y.wareName,y.guige,
			y.unit,z.memo,z.chukuDate
			from cangku_yl_chuku2ware x
			left join jichu_ware y on y.id=x.wareId
			left join cangku_yl_chuku z on z.id=x.chukuId
			where z.kind=9
		";
		if($arr['key']!='')$str.=" and y.wareName like '%{$arr['key']}%'";
		$pager=& new TMIS_Pager($str);
		$rowset=$pager->findAll();
		$arr_field_info=array(
			'chukuDate'=>'调整日期',
			'wareName'=>'品名',
			'guige'=>'规格',
			'unit'=>'单位',
			'cnt'=>'调整数量',
			'memo'=>'备注'
		);
		$smarty=& $this->_getView();
		$smarty->assign('title','库存调整查询');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('grid','thickbox')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList2.tpl');
	}

}
?>