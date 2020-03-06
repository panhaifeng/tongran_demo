<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chanliang_InputZcl extends Tmis_Controller {
	var $_modelExample;
	var $funcId= 49;
	var $title = '产量登记';
	var $tn;
	function Controller_Chanliang_InputZcl() {
		$this->_modelExample = & FLEA::getSingleton('Model_Dye_Chanliang');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$this->tn= $this->_modelExample->tableName;
		$this->_modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$this->_modelWareDj = & FLEA::getSingleton('Model_JiChu_WareDanjia');
		$this->_modelEmploy = & FLEA::getSingleton('Model_JiChu_Employ');
		$this->_mGx = & FLEA::getSingleton('Model_Ganghao_Gx');
	}

	//列出已登记的产量。
	function actionRight(){
		// $this->authCheck('10-1-3');
		FLEA::loadClass('TMIS_Pager');
		$this->_modelExample->enableLink('VatView');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'workerIdZcl'=>'',
			'gongxuZcl'=>'',
			'vatNum'=>'',
		));

		$sql = "SELECT x.*,y.vatNum,y.cntPlanTouliao,z.perName,a.gongxuName,b.color
			FROM dye_chanliang x 
			LEFT JOIN plan_dye_gang y on x.gangId=y.id
			LEFT JOIN jichu_gxperson z on x.workerId=z.id
			LEFT JOIN jichu_chanliang_gongxu a on a.id=x.gxIds
			LEFT JOIN trade_dye_order2ware b on b.id=y.order2wareId
			where 1 and x.type='2'";

		if($arr['dateFrom']!=''){
            $sql.=" and x.dateInput>='{$arr['dateFrom']}' and x.dateInput<='{$arr['dateTo']}'";
		}

		if($arr['workerIdZcl']!=''){
            $sql.=" and x.workerId ='{$arr['workerIdZcl']}'";
		}
		if($arr['vatNum']!=''){
            $sql.=" and y.vatNum  like '%{$arr['vatNum']}%'";
		}
		if($arr['gongxuZcl']!=''){
            $sql.=" and x.gxIds  = '{$arr['gongxuZcl']}'";
		}
		$pager = &new TMIS_Pager($sql);
        $rowset = $pager->findAll();
        $rowsetAll = $this->_modelOrder->findBySql($sql);
		foreach($rowset as &$v){
			$sqlSh = "select * from caiwu_wages_guozhang where chanliangId='{$v['id']}'";
            $shenhes = $this->_modelExample->findBySql($sqlSh);
            if($shenhes){
            	$v['shenhes'] = true;
            }
            if($v['shenhes']){
            	$v['_edit'].="<a href='#' title='已审核禁止修改'>修改</span>";
				$v['_edit'].="&nbsp;&nbsp;<a href='#' title='已审核不能删除'>删除</span>";
            }else{
            	$v['_edit'].=$this->getEditHtml($v['id']).'  '.$this->getRemoveHtml($v['id']);
            }
			$v['guige'] = $v['wareName'].' ' .$v['guige'];
			$wares = $this->_modelGang->getWare($v['gangId']);
			$sql1 =" select danjia from jichu_ware_danjia where wareId='{$wares['id']}' and gongxuId='{$v['gxIds']}'";
			$danjas = $this->_modelExample->findBySql($sql1);
			foreach ($danjas as $key => &$value) {
				$v['danjia'] = $value['danjia'];
			}
			$v['money'] = $v['cnt']*$v['danjia'];		
		}
		//dump($rowset);die;
		$heji=$this->getHeji($rowset,array('cnt','money'),'dateInput');
		$zongji = $this->getHeji($rowsetAll,array('cnt','money'),'dateInput');
		$zongji['dateInput']="<b>总计</b>";
		$rowset[]=$heji;
		$rowset[]=$zongji;
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'=>'日期',
			'dt'=>'录入时间',
			'vatNum'=>"缸号",
			'guige'=>"纱支",
			'color'=>"颜色",
			'perName'=>'操作人',
            'cntPlanTouliao' =>'投料数',
			'gongxuName'=>'工序',
			'cnt'=>'公斤数',
			'danjia'=>'单价',
			'money'=>'金额',
			// 'banci'=>'班次',
			'_edit'=>'操作'
		));

		$smarty->assign('title','产量查询');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('search_item',$search_item1.$search_item2.$search_item3);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	function actionRemove(){
		$rr=$this->_modelExample->find(array('id'=>$_GET['id']));
		$this->_modelExample->removeByPkv($_GET['id']);
		// $arrGang=$this->_modelGang->find(array('id'=>$rr['gangId']));
		// $str="select sum(cntK) as cntK from $this->tn where gangId='{$rr['gangId']}'";
		// $re=mysql_fetch_assoc(mysql_query($str));
		// if($re['cntK']<=$arrGang['cntPlanTouliao']){
		// 	$kk=array(
		// 		'id'=>$rr['gangId'],
		// 		'dbOver'=>0
		// 	);
		// 	$this->_modelGang->save($kk);
		// }
		redirect($this->_url('Right'));
	}
	//修改产量
	function actionEdit() {
		// $this->authCheck('10-1-3');
		$this->_modelClGx = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
		$arr=$this->_modelExample->find($_GET[id]);
		$arr['Gang'] = $this->_modelGang->find($arr['gangId']);
		$gx = $this->_modelClGx->find(array('id'=>$arr['gxIds']));
		$arr['gxName'] = $gx['gongxuName'];
		// $arr['Client'] = $this->_modelGang->getClient($arr['gangId']);
		// $arr['Ware'] = $this->_modelGang->getWare($arr['gangId']);
		// $wareDanjia = $this->_modelWareDj->findByField('wareId',$arr['Ware']['id']);
		// $arr['danjia'] = $wareDanjia[$this->typeDanjia];
		// dump($arr);die;
		$smarty = $this->_getView();
		$smarty->assign('$title', '增加修改打包产量');
		$smarty->assign('aRow',$arr);
		$smarty->assign('gxType','2');
		$smarty->display('Chanliang/inputZcl.tpl');
	}

	function actionAdd(){
		$arr['employ'] = $this->_modelEmploy->findAll();

		// dump($arr);die;
		$smarty = $this->_getView();
		$smarty->assign('$title', '增加修改打包产量');
		$smarty->assign('aRow',$arr);
		$smarty->assign('gxType','2');
		$smarty->display('Chanliang/inputZcl.tpl');
	}

	function actionSave(){
		// dump($_POST);die;
		$countPerson = count($_POST['gxPersonId']);
		// dump($countPerson);die;
		
		$this->_modelWareDj = & FLEA::getSingleton('Model_JiChu_WareDanjia');
		$this->_modelClGx = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
		
		foreach ($_POST['gxPersonId'] as $b => &$c) {
			foreach ($_POST['gangId'] as $key => &$v) {
				if(!$v) continue;
				$temp['id'] 		= $_POST['id'];
				$temp['dateInput'] 	= $_POST['dateInput'];
				$temp['gangId'] 	= $_POST['gangId'][$key];
				$temp['vatId']  	= $_POST['vatId'][$key];
				$temp['gxIds']  	= $_POST['gxIds'][$key];
				$temp['wareName']  	= $_POST['wareName'][$key];
				$temp['gongxu']  	= $_POST['gongxu'][$key];
				$temp['gxTypeId']  	= $_POST['gxTypeId'][$key];
				$temp['cnt']  		= round($_POST['cnt'][$key]/$countPerson,2);
				$temp['type']		= 2;
				$temp['workerId']	= $c;

				$arr['Gang'] = $this->_modelGang->find($_POST['gangId'][$key]);
				$arr['Ware'] = $this->_modelGang->getWare($_POST['gangId'][$key]);
				$wareDanjia = $this->_modelWareDj->find(array('wareId'=>$arr['Ware']['id'],'gongxuId'=>$_POST['gxIds'][$key]));
				$temp['danjia'] = $wareDanjia['danjia']>0?$wareDanjia['danjia']:'0';
				$temp['money'] = $temp['danjia']*$temp['cnt'];
				$rowSon[] = $temp;
			}
		}
		// dump($rowSon);die;
		foreach ($rowSon as $ke => &$val) {
		   $sql ="update plan_dye_gang set zclWc='{$_POST['isOverZclV'][$ke]}' where id='{$val['gangId']}'";
		   $this->_mGx->execute($sql);

		}
		foreach ($rowSon as $k => &$v) {

			$gxIdsArr = explode(',',$v['gxIds']);
			$i = count($gxIdsArr);
			foreach ($gxIdsArr as $b => &$c) {
				$res['id'] 				= $v['id'];
				$res['dateInput'] 		= $v['dateInput'];
				$res['gangId'] 			= $v['gangId'];
				$res['vatId']  			= $v['vatId'];
				$res['gxIds']  			= $gxIdsArr[$b];
				$res['wareName']  		= $v['wareName'];
				$res['gongxu']  		= $v['gongxu'];
				$res['gxTypeId']  		= $v['gxTypeId'];
				$res['cnt']  			= $v['cnt'];
				$res['type']			= 2;
				$res['workerId']		= $v['workerId'];
				$res['danjia']			= $v['danjia'];
				$res['money']			= $v['money'];
				$arr[]  				= $res;
			}
		}

		if(!count($arr)){
         	echo ("<script>alert('请填写明细');history.go(-1)</script>");exit;
			exit;
		}
		
		// 验证报工数量是否超出投料数
		foreach ($arr as $k => &$v) {
			if($v['gangId']>0 && $v['gxIds']>0){
				$arrGang=$this->_modelGang->find(array('id'=>$v['gangId']));
				$cntPlanTouliao = $arrGang['cntPlanTouliao'];
              if($v['id']==''){
				$sql = "select sum(cnt) as allcl FROM dye_chanliang where gangId='{$v['gangId']}' and gxIds='{$v['gxIds']}' and type=2";
				$row = $this->_modelExample->findBySql($sql);
				$hasBg = $row[0]['allcl'];
				if($hasBg+$v['cnt']*$countPerson>$cntPlanTouliao){
					echo ("<script>alert('保存失败,缸号".$arrGang['vatNum']." 报工数量超出投料数');history.go(-1)</script>");exit;
					exit;
				}
			  }else{
			  	$sql = "select sum(cnt) as allcl FROM dye_chanliang where gangId='{$v['gangId']}' and gxIds='{$v['gxIds']}' and type=2";
				$row = $this->_modelExample->findBySql($sql);
				$hasBg = $row[0]['allcl'];
				$sqls = "select cnt as cntZj FROM dye_chanliang where gangId='{$v['gangId']}' and gxIds='{$v['gxIds']}' and type=2 and id='{$v['id']}'";
				$rowZj = $this->_modelExample->findBySql($sqls);
                $zjCnt = $rowZj[0]['cntZj'];
                $realCnt = $hasBg-$zjCnt;
                if($realCnt+$v['cnt']*$countPerson>$cntPlanTouliao){
                	echo ("<script>alert('保存失败,缸号".$arrGang['vatNum']." 报工数量超出投料数');history.go(-1)</script>");exit;
					exit;
                }
			  }
			}
		}

		// dump($arr);die;
		if(!$this->_modelExample->saveRowset($arr)) {
         	echo ("<script>alert('保存失败');history.go(-1)</script>");exit;
			exit;
		}
		
		//跳转
		js_alert('保存成功!',null,$this->_url('Right'));
		exit;
	}

	function actionPopupGanghao(){
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            'key' => ''
        ));

        $str = "SELECT x.*,w.wareName,w.guige,
			y.color,y.colorNum
        	from plan_dye_gang x
			left join trade_dye_order2ware y on x.order2wareId=y.id
			left join jichu_ware w on y.wareId=w.id
			where 1";

        if ($arr['key']!='') $str .= " and (
			vatNum like '%$arr[key]%'
		)";
        $str .=" order by planDate desc";
		//echo $str;
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAllBySql($str);
		foreach($rowset as & $v) {
			if($v['isOfften']==0) $v['_bgColor']='lightblue';
			$this->makeEditable($v,'mnemocode');
		}
        $arr_field_info = array(
            //"_edit" => "选择",
            "vatNum" =>"缸号",
            'cntPlanTouliao'=>"计划投料",
            "planTongzi" =>"计划筒子数",
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
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/vatNumChoose.tpl');
	}

	function actionViewChoose(){
        // dump($_GET);die;
	 	$sql = "SELECT *
	        from jichu_chanliang_gongxu
	        where 1 and type='{$_GET['type']}'";
        $rowset =$this->_modelExample->findBySql($sql);

       	$isBg = $this->_modelExample->findAll(array('gangId'=>$_GET['gangId'],'type'=>$_GET['type']),null,null,'gxIds');
       	$temp =  array();
       	foreach ($isBg as $k => &$v) {
       		$temp[] = $v['gxIds'];
       	}


		$aGang = $this->_modelGang->find($_GET['gangId']);//查找物理缸号
        // dump($aGang);die;
        $wareArr = $this->_modelWare->find($aGang['OrdWare']['id']);


        foreach ($rowset as $key => &$value) {
         //    if(in_array($value['id'],$temp)){
        	// 	//unset($rowset[$key]);
        	// 	$rowset[$key]['disabled'] = disabled; //已经选过的，不能被选中
        	// }
        	$sqlC = "select sum(cnt) as cnt from dye_chanliang where gxIds='{$value['id']}' and gangId='{$_GET['gangId']}'";
        	$cntsGx = $this->_modelExample->findBySql($sqlC);
        	$value['cnts'] = $cntsGx[0]['cnt'];
        	if($value['cnts']>=$aGang['cntPlanTouliao']){
        		$rowset[$key]['disabled'] = disabled;
        	}
        	$gxPrice = $this->_modelWareDj->find(array('wareId'=>$aGang['OrdWare']['wareId'],'gongxuId'=>$value['id']));
        	$value['danjia'] = $gxPrice['danjia'];
        }
        // dump($rowset);die;

        $smarty = & $this->_getView();
        $smarty->assign('rowset', $rowset);
        $smarty->display("Chanliang/GxSelectZ.tpl");
	}

	function actionPopupGanghao1(){
		//dump($_GET);die;
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            'key' => '',
            'clientId'=>'',
            'cntRs'=>'',
            'color'=>'',
            'dateFrom'=>date("Y-m-d",strtotime("-1 day")),
            'dateTo'=>date('Y-m-d'),
        ));

        $str = "SELECT x.*,w.wareName,w.guige,w.id as wareId,w.parentId,
			y.color,y.colorNum,t.clientId
        	from plan_dye_gang x
			left join trade_dye_order2ware y on x.order2wareId=y.id
			left join jichu_ware w on y.wareId=w.id
			left join trade_dye_order t on t.id=y.orderId
			where 1 and x.zclWc=0";

        if ($arr['key']!='') $str .= " and (
			vatNum like '%$arr[key]%'
		)";
		if ($arr['clientId']!='') $str .= " and (
			t.clientId = '$arr[clientId]'
		)";
		if ($arr['cntRs']!='') $str .= " and (
			x.cntPlanTouliao = '$arr[cntRs]'
		)";
	    if ($arr['color']!='') $str .= " and (
			y.color like '%$arr[color]%'
		)";
		if($arr['dateFrom']!=''){
			$str .= " and (x.planDate>='$arr[dateFrom]' and x.planDate<='$arr[dateTo]')";
		}
        $str .=" order by planDate desc";
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAllBySql($str);
        // dump($rowset);die;
		foreach($rowset as & $v) {
			$v['gxTypeId'] = $this->_modelWare->getTopClass($v['wareId'],$v['parentId']);
			if($v['isOfften']==0) $v['_bgColor']='lightblue';
			$this->makeEditable($v,'mnemocode');
			$v['wareName'] = $v['wareName'] .' '. $v['guige'];
			$sqlClient = "select compName from jichu_client where id='{$v['clientId']}'";
			$clientName = $this->_modelExample->findBySql($sqlClient);
            $v['compName'] = $clientName[0]['compName'];
		}
        $arr_field_info = array(
            //"_edit" => "选择",
            "vatNum" =>"缸号",
            "compName" =>"客户",
            "wareName" =>"纱支规格",
            'cntPlanTouliao'=>"计划投料",
           // 'overCnt'=>"已完成数量",
            "planTongzi" =>"计划筒子数",
            "color" =>"颜色",
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
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/vatNumChoose.tpl');
	}

	public function actionYanzhengCnt(){
		//dump($_POST);die;
       // $arrGang=$this->_modelGang->find(array('id'=>$_POST['gangId']));
       // $arrGang=$this->_modelGang->find(array('id'=>$_POST['gangId']));
	  // $cntPlanTouliao = $arrGang['cntPlanTouliao'];
	   $info = array();
	   foreach ($_POST['id'] as $kk => &$vva) {
	   	  $isEdit = $vva;
	   }

	   	   if($isEdit==''){
	   	  foreach ($_POST['gangId'] as $key => &$value) {
	   	       $info[$key]['gangId'] = $value;       
	      }
		  foreach ($_POST['cnt'] as $ke => &$va) {
		   	   $info[$ke]['cnt'] = $va;
		  }
		  foreach ($_POST['id'] as $ka => &$val) {
		   	   $info[$ka]['id'] = $val;
		  }
		  foreach ($_POST['gxId'] as $y => &$vaaa) {
		  	   $info[$y]['gxId'] = $vaaa;
		  }
		  foreach ($info as $kk => &$vaa) {
		   	   $arrGang=$this->_modelGang->find(array('id'=>$vaa['gangId']));
			   $cntPlanTouliao = $arrGang['cntPlanTouliao'];
			   $vaa['cntPlanTouliao'] = $cntPlanTouliao;
		  }
		  //dump($info);die;
		  foreach ($info as $ky => &$vv) {
		   	   $sumCnt = 0;
		   	   $sql = "select sum(cnt) as allcl from dye_chanliang where gangId='{$vv['gangId']}' and gxIds='{$vv['gxId']}' and type=2";
		   	   $row = $this->_modelExample->findBySql($sql);
		   	   $hasBg = $row[0]['allcl'];
		   	   $sumCnt = $hasBg+$vv['cnt'];
		   	   $vv['realCnt'] = round($sumCnt,2);
		   	  
		   }
		   //dump($info);die;
		   foreach ($info as $kyy => &$vvv) {
		   	   if($vvv['realCnt']>$vvv['cntPlanTouliao']){
		   	   	  echo  json_encode(array('succ'=>false,'msg'=>'报工数量超出投料数'));exit;
		   	   }else{
		   	   	  continue;
		   	   }
		   }
	   }else{
	   	   foreach ($_POST['gangId'] as $key => &$value) {
	   	       $info[$key]['gangId'] = $value;       
	       }
		   foreach ($_POST['cnt'] as $ke => &$va) {
		   	   $info[$ke]['cnt'] = $va;
		   }
		   foreach ($_POST['id'] as $ka => &$val) {
		   	   $info[$ka]['id'] = $val;
		   }
		   foreach ($info as $ky => &$vaa) {
		   	   $arrGang=$this->_modelGang->find(array('id'=>$vaa['gangId']));
			   $cntPlanTouliao = $arrGang['cntPlanTouliao'];
			   $vaa['cntPlanTouliao'] = $cntPlanTouliao;
		   }
		   foreach ($info as $kyy => &$vl) {
		   	   $sqls = "select sum() as allcl from dye_chanliang where gangId='{$vl['gangId']}' and gxIds='{$_POST['gxId']}' and type=2";
		   	   $row = $this->_modelExample->findBySql($sql);
		   	   $hasBg = $row[0]['allcl'];
		   	   $sqlZj = "select cnt as cntZj FROM dye_chanliang where gangId='{$vl['gangId']}' and gxIds='{$_POST['gxId']}' and type=2 and id='{$vl['id']}'";
		   	   $rowZj = $this->_modelExample->findBySql($sqlZj);
		   	   $zjCnt = $rowZj[0]['cntZj'];
		   	   $realCnt = $hasBg-$zjCnt;
		   	   $vl['realCnt'] = $realCnt;
		   	   if(($vl['realCnt']+$vl['cnt'])>$vl['cntPlanTouliao']){
		   	   	  echo  json_encode(array('succ'=>false,'msg'=>'报工数量超出投料数'));exit;
		   	   }

		   }

	   }
	  //  if($_POST['id']==''){
	  //  	   $sql = "select sum(cnt) as allcl FROM dye_chanliang where gangId='{$_POST['gangId']}' and gxIds='{$_POST['gxId']}' and type=2";
		 //   $row = $this->_modelExample->findBySql($sql);
		 //   $hasBg = $row[0]['allcl'];
		 //   $sumCnt = $hasBg+$_POST['cnt'];
		 //   if(($sumCnt)>$cntPlanTouliao){
			// echo  json_encode(array('succ'=>false,'msg'=>'报工数量超出投料数'));exit;
		 //   }else{
		 //   	echo  json_encode(array('succ'=>true,'msg'=>'成功'));exit;
		 //   }
	  //  }else{          
   //         $sql = "select sum(cnt) as allcl FROM dye_chanliang where gangId='{$_POST['gangId']}' and gxIds='{$_POST['gxId']}' and type=2";
		 //   $row = $this->_modelExample->findBySql($sql);
		 //   $hasBg = $row[0]['allcl'];
		 //   $sqls = "select cnt as cntZj FROM dye_chanliang where gangId='{$_POST['gangId']}' and gxIds='{$_POST['gxId']}' and type=2 and id='{$_POST['id']}'";
		 //   $rowZj = $this->_modelExample->findBySql($sqls);
	  //      $zjCnt = $rowZj[0]['cntZj'];
	  //      $realCnt = $hasBg-$zjCnt;
	  //      if($realCnt+$_POST['cnt']>$cntPlanTouliao){
	  //       	echo  json_encode(array('succ'=>false,'msg'=>'报工数量超出投料数'));exit;
	  //      }else{
   //              echo  json_encode(array('succ'=>true,'msg'=>'成功'));exit;
	  //      }
	  //  }
	   
	}

}
?>