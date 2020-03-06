<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chanliang_Input extends Tmis_Controller {
	var $_modelExample;
	var $funcId= 145;
	var $title = '产量登记';
	var $tn;
	function Controller_Chanliang_Input() {
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
		// $this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		$this->_modelExample->enableLink('VatView');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'workerIdSt'=>'',
			'gongxuSt'=>'',
			'vatNum'=>'',
		));

		$sql = "SELECT x.*,y.vatNum,y.cntPlanTouliao,z.perName,a.gongxuName,b.color,b.orderId
			FROM dye_chanliang x 
			LEFT JOIN plan_dye_gang y on x.gangId=y.id
			LEFT JOIN jichu_gxperson z on x.workerId=z.id
			LEFT JOIN jichu_chanliang_gongxu a on a.id=x.gxIds
			LEFT JOIN trade_dye_order2ware b on b.id=y.order2wareId
			where 1 and x.type='1'";

		if($arr['dateFrom']!=''){
            $sql.=" and x.dateInput>='{$arr['dateFrom']}' and x.dateInput<='{$arr['dateTo']}'";
		}

		if($arr['workerIdSt']!=''){
            $sql.=" and x.workerId ='{$arr['workerIdSt']}'";
		}
		if($arr['vatNum']!=''){
            $sql.=" and y.vatNum  like '%{$arr['vatNum']}%'";
		}
		if($arr['gongxuSt']!=''){
			//dump($arr['gongxu']);die;
            $sql.=" and x.gxIds  = '{$arr['gongxuSt']}'";
		}
		$pager = &new TMIS_Pager($sql);
        $rowset = $pager->findAll();
        $rowsetAll = $this->_modelOrder->findBySql($sql);
        $zongji = $this->getHeji($rowsetAll,array('cnt','money'),'dateInput');
        $zongji['dateInput']="<b>总计</b>";
		foreach($rowset as &$v){
			$v['danjia'] = round($v['danjia'],3);
            $v['money'] =  round($v['money'],3);
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
			$sqlkh ="select clientId from trade_dye_order where id='{$v['orderId']}'";
            $clientIds = $this->_modelExample->findBySql($sqlkh);
            $v['clientIds'] = $clientIds[0]['clientId'];
            $sqlClientName = "select compName from jichu_client where id='{$v['clientIds']}'";
            $clientName = $this->_modelExample->findBySql($sqlClientName);
            $v['clientName'] = $clientName[0]['compName'];
		}
		$heji=$this->getHeji($rowset,array('cnt','money'),'dateInput');
		$rowset[]=$heji;
        $rowset[]=$zongji;
		$smarty = $this->_getView();
		$smarty->assign('arr_field_info',array(
			'dateInput'=>'日期',
			'dt'=>'录入时间',
			'vatNum'=>"缸号",
			'clientName'=>"客户",
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
		// dump($_GET['id']);die;
		$rr=$this->_modelExample->find(array('id'=>$_GET['id']));
		$this->_modelExample->removeByPkv($_GET['id']);
		$sql ="select id from ganghao_gx where ganghao='{$rr['gangId']}' and gxId='{$rr['gxIds']}'";
        $infos = $this->_mGx->findBySql($sql);
        if($infos){
		   $sql1 = "delete from ganghao_gx where id='{$infos[0]['id']}'";
		   $this->_mGx->execute($sql1);
        }
        
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
		// $this->authCheck($this->funcId);
		$arr=$this->_modelExample->find($_GET[id]);
		// dump($arr);die;
		$arr['Gang'] = $this->_modelGang->find($arr['gangId']);
	    $sql ="select * from ganghao_gx where gxId='{$arr['gxIds']}' and ganghao='{$arr['gangId']}'";
	    $gxOvers = $this->_mGx->findBySql($sql);
	    $arr['overGxs'] = $gxOvers[0];
	    $sqlCnt = "select sum(cnt) as overCnt from dye_chanliang where gangId='{$arr['gangId']}' and gxIds='{$arr['gxIds']}' and type=1";
		//dump($sqlCnt);die;
		$overCnt = $this->_modelGang->findBySql($sqlCnt);
		$arr['overCnt'] = $overCnt[0]['overCnt'];
		$arr['overCnt']=$arr['overCnt']?$arr['overCnt']:0;
	    // dump($arr['overGxs']);die;
		// $arr['Client'] = $this->_modelGang->getClient($arr['gangId']);
		// $arr['Ware'] = $this->_modelGang->getWare($arr['gangId']);
		// $wareDanjia = $this->_modelWareDj->findByField('wareId',$arr['Ware']['id']);
		// $arr['danjia'] = $wareDanjia[$this->typeDanjia];
		// dump($arr);die;
		$smarty = $this->_getView();
		$smarty->assign('$title', '增加修改打包产量');
		$smarty->assign('aRow',$arr);
		$smarty->assign('gxType','1');
		$smarty->display('Chanliang/input.tpl');
	}

	function actionAdd(){
		$arr['employ'] = $this->_modelEmploy->findAll();

		// dump($arr);die;
		$smarty = $this->_getView();
		$smarty->assign('$title', '增加修改打包产量');
		$smarty->assign('aRow',$arr);
		$smarty->assign('gxType','1');
		$smarty->display('Chanliang/input.tpl');
	}

	function actionSave(){
		//dump($_POST);die;
		$countPerson = count($_POST['gxPersonId']);
		// dump($countPerson);die;
		$this->_modelWareDj = & FLEA::getSingleton('Model_JiChu_WareDanjia');
		$this->_modelClGx = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
		
		foreach ($_POST['gxPersonId'] as $b => &$c) {
			foreach ($_POST['gangId'] as $key => &$v) {
				if(!$v) continue;
				$temp['dateInput'] 	= $_POST['dateInput'];
				$temp['gangId'] 	= $_POST['gangId'][$key];
				$temp['vatId']  	= $_POST['vatId'][$key];
				$temp['gxIds']  	= $_POST['gxId'];
				$temp['wareName']  	= $_POST['wareName'][$key];
				$temp['gxTypeId']  	= $_POST['gxTypeId'][$key];
				$temp['cnt']  		= round($_POST['cnt'][$key]/$countPerson,2);
				$temp['type']		= 1;
				$temp['workerId']	= $c;
				$temp['id']			= $_POST['id'];
                $temp['isOverGx']   = $_POST['isOverGxV'][$key];
				$rowset['Gang'] = $this->_modelGang->find($_POST['gangId'][$key]);
				$rowset['Ware'] = $this->_modelGang->getWare($_POST['gangId'][$key]);

				$temp['wareId']	= $rowset['Ware']['id'];
				$rowSon[] = $temp;
			}
		}
		// dump($rowSon);die;
		foreach ($rowSon as $k => &$v) {
			$gxIdsArr = explode(',',$v['gxIds']);
			$i = count($gxIdsArr);
			foreach ($gxIdsArr as $b => &$c) {
				$res['dateInput'] 		= $v['dateInput'];
				$res['gangId'] 			= $v['gangId'];
				$res['vatId']  			= $v['vatId'];
				$res['gxIds']  			= $v['gxIds'];
				$res['wareName']  		= $v['wareName'];
				$res['gxTypeId']  		= $v['gxTypeId'];
				$res['cnt']  			= $v['cnt'];
				$res['type']			= 1;
				$res['workerId']		= $v['workerId'];
				$res['id']				= $v['id'];

				$wareDanjia = $this->_modelWareDj->find(array('wareId'=>$v['wareId'],'gongxuId'=>$gxIdsArr[$b]));
				$res['danjia'] = $wareDanjia['danjia']>0?$wareDanjia['danjia']:'0';
				$res['money'] = round($res['danjia']*$res['cnt'],3);
				$arr[]  				= $res;
			}
		}
		if(!count($arr)){
         	echo ("<script>alert('请填写明细');history.go(-1)</script>");exit;
			exit;
		}
		// dump($arr);die;
		// 验证报工数量是否超出投料数
		//dump($arr);die;
		$_temp=array();
		foreach ($arr as $k => $val) {
			$_temp[$val['gangId']][]=$val['cnt'];
		}
		
        foreach ($_temp as $key => &$value) {
        	$n=0;
        	$n=array_sum($value);
        	$_temp[$key]=$n;
        }
       // dump($_temp);
		// foreach ($arr as $k => &$v) {
		// 	if($v['gangId']>0 && $v['gxIds']>0){
		// 		$arrGang=$this->_modelGang->find(array('id'=>$v['gangId']));
		// 		$cntPlanTouliao = $arrGang['cntPlanTouliao'];
		// 		//dump($cntPlanTouliao);
  //               foreach ($_temp as $key => $values) {
  //               	//dump($key);

  //               	if($key==$v['gangId']){
  //               		if($values>$cntPlanTouliao){
  //               			//dump($values);
  //               			js_alert('报工数量超出投料数!','window.history.go(-1)');
  //               			exit();
  //               		}
  //               	}
  //               }
                
  //             if($v['id']==''){           
		// 		$sql = "select sum(cnt) as allcl FROM dye_chanliang where gangId='{$v['gangId']}' and gxIds='{$v['gxIds']}' and type=1";
		// 		$row = $this->_modelExample->findBySql($sql);
		// 		$hasBg = $row[0]['allcl'];
		// 		if($hasBg+$v['cnt']*$countPerson>$cntPlanTouliao){
		// 			js_alert('报工数量超出投料数!','window.history.go(-1)');exit;
		// 		}
		// 	  }else{
		// 	  	$sql = "select sum(cnt) as allcl FROM dye_chanliang where gangId='{$v['gangId']}' and gxIds='{$v['gxIds']}' and type=1";
		// 		$row = $this->_modelExample->findBySql($sql);
		// 		$hasBg = $row[0]['allcl'];
		// 		$sqls = "select cnt as cntZj FROM dye_chanliang where gangId='{$v['gangId']}' and gxIds='{$v['gxIds']}' and type=1 and id='{$v['id']}'";
		// 		$rowZj = $this->_modelExample->findBySql($sqls);
  //               $zjCnt = $rowZj[0]['cntZj'];
  //               $realCnt = $hasBg-$zjCnt;
  //               if($realCnt+$v['cnt']*$countPerson>$cntPlanTouliao){
  //               	js_alert('报工数量超出投料数!','window.history.go(-1)');
  //               }
		// 	  }
		// 	}
		// }
		if(!$this->_modelExample->saveRowset($arr)) {
         	echo ("<script>alert('保存失败');history.go(-1)</script>");exit;
			exit;
		}
        
		$this->_mGx->_afterCreateDb($rowSon);
		
		//跳转
		js_alert('保存成功!',null,$this->_url('Right'));
		exit;
	}

	function actionPopupGanghao(){
		//dump($_GET);die;
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            'key' => '',
            'clientId'=>'',
            'cntRs'=>'',
            'color'=>'',
            'dateFrom'=>date("Y-m-d",strtotime("-1 day")),
            'dateTo'=>date('Y-m-d'),
            // 'selGangHao'=>0
        ));

        $str = "SELECT x.*,w.wareName,w.guige,w.id as wareId,w.parentId,
			y.color,y.colorNum,t.clientId
        	from plan_dye_gang x
			left join trade_dye_order2ware y on x.order2wareId=y.id
			left join jichu_ware w on y.wareId=w.id
			left join trade_dye_order t on t.id=y.orderId
			where 1 and x.id not in(select ganghao from ganghao_gx where gxId='{$_GET['gxidNew']}')";
         // dump($str);die;
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
	        
			$sqlCnt = "select sum(cnt) as overCnt from dye_chanliang where gangId='{$v['id']}' and gxIds='{$_GET['gxidNew']}' and type=1";
			//dump($sqlCnt);die;
			$overCnt = $this->_modelGang->findBySql($sqlCnt);
			$v['overCnt'] = $overCnt[0]['overCnt'];
			$v['overCnt']=$v['overCnt']?$v['overCnt']:0;
			$sqlClient = "select compName from jichu_client where id='{$v['clientId']}'";
			$clientName = $this->_modelExample->findBySql($sqlClient);
            $v['compName'] = $clientName[0]['compName'];

		}
        $arr_field_info = array(
            //"_edit" => "选择",
           /* "over"=>"完成",*/
            "vatNum" =>"缸号",
            "compName" =>"客户",
            "wareName" =>"纱支规格",
            'cntPlanTouliao'=>"计划投料",
            "planTongzi" =>"计划筒子数",
            "color" =>"颜色",
        );

       // dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择纱支');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        $smarty->assign('s',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr+$_GET)));
        $smarty-> display('Popup/vatNumChoose.tpl');
	}

	function actionViewChoose(){
	 	$sql = "SELECT *
	        from jichu_chanliang_gongxu
	        where 1 and type='{$_GET['type']}'";
        $rowset =$this->_modelExample->findBySql($sql);
        // dump($rowset);die;
        foreach ($rowset as $key => &$value) {
            
        }

        $smarty = & $this->_getView();
        $smarty->assign('rowset', $rowset);
        $smarty->display("Chanliang/GxSelect.tpl");
	}

    //缸号标记已完成未完成，页面默认显示未完成
	public function actionSetVatOver(){
       $id = $_POST['id'];
       $row= $this->_modelGang->find(array('id'=>$id));
       $selGangHao = $row['selGangHao'];
       if($selGangHao){
       	 $sql="update plan_dye_gang set selGangHao=0 where id='{$id}'";
       	 $ret = $this->_modelGang->execute($sql);
         echo  json_encode(array('succ'=>'wei','msg'=>'完成'));
       }else{
       	 $sql="update plan_dye_gang set selGangHao=1 where id='{$id}'";
       	 $ret = $this->_modelGang->execute($sql);
         echo  json_encode(array('succ'=>'yi','msg'=>'取消完成'));
       }
	}

	public function actionYanzhengCnt(){
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
		  foreach ($info as $kk => &$vaa) {
		   	   $arrGang=$this->_modelGang->find(array('id'=>$vaa['gangId']));
			   $cntPlanTouliao = $arrGang['cntPlanTouliao'];
			   $vaa['cntPlanTouliao'] = $cntPlanTouliao;
		  }
		  // dump($info);die;
		  foreach ($info as $ky => &$vv) {
		   	   $sumCnt = 0;
		   	   $sql = "select sum(cnt) as allcl from dye_chanliang where gangId='{$vv['gangId']}' and gxIds='{$_POST['gxId']}' and type=1";
		   	   $row = $this->_modelExample->findBySql($sql);
		   	   $hasBg = $row[0]['allcl'];
		   	   $sumCnt = $hasBg+$vv['cnt'];
		   	   $vv['realCnt'] = round($sumCnt,2);
		   	  
		   }
		   foreach ($info as $kyy => &$vvv) {
		   	   if($vvv['realCnt']>$vvv['cntPlanTouliao']){
		   	   	  echo  json_encode(array('succ'=>false,'msg'=>'报工数量超出投料数'));exit;
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
		   	   $sqls = "select sum() as allcl from dye_chanliang where gangId='{$vl['gangId']}' and gxIds='{$_POST['gxId']}' and type=1";
		   	   $row = $this->_modelExample->findBySql($sql);
		   	   $hasBg = $row[0]['allcl'];
		   	   $sqlZj = "select cnt as cntZj FROM dye_chanliang where gangId='{$vl['gangId']}' and gxIds='{$_POST['gxId']}' and type=1 and id='{$vl['id']}'";
		   	   $rowZj = $this->_modelExample->findBySql($sqlZj);
		   	   $zjCnt = $rowZj[0]['cntZj'];
		   	   $realCnt = $hasBg-$zjCnt;
		   	   $vl['realCnt'] = $realCnt;
		   	   if(($vl['realCnt']+$vl['cnt'])>$vl['cntPlanTouliao']){
		   	   	  echo  json_encode(array('succ'=>false,'msg'=>'报工数量超出投料数'));exit;
		   	   }

		   }

	   }
	   
	}
}
?>