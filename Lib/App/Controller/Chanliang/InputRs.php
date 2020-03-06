<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chanliang_InputRs extends Tmis_Controller {
	var $_modelExample;
	var $funcId= 49;
	var $title = '产量登记';
	var $tn;
	function Controller_Chanliang_InputRs() {
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
		// $this->authCheck('10-1-2');
		FLEA::loadClass('TMIS_Pager');
		$this->_modelExample->enableLink('VatView');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
			'workerIdRs'=>'',
			'gongxuRs'=>'',
			'vatNum'=>'',
		));

		$sql = "SELECT x.*,y.vatNum,y.cntPlanTouliao,z.perName,b.color,a.gongxuName
			FROM dye_chanliang x 
			LEFT JOIN plan_dye_gang y on x.gangId=y.id
			LEFT JOIN jichu_gxperson z on x.workerId=z.id
			LEFT JOIN jichu_chanliang_gongxu a on a.id=x.gxIds
			LEFT JOIN trade_dye_order2ware b on b.id=y.order2wareId
			where 1 and x.type='3'";

		if($arr['dateFrom']!=''){
            $sql.=" and x.dateInput>='{$arr['dateFrom']}' and x.dateInput<='{$arr['dateTo']}'";
		}

		if($arr['workerIdRs']!=''){
            $sql.=" and x.workerId ='{$arr['workerIdRs']}'";
		}
		if($arr['vatNum']!=''){
            $sql.=" and y.vatNum  like '%{$arr['vatNum']}%'";
		}
		if($arr['gongxuRs']!=''){
            $sql.=" and x.gxIds  = '{$arr['gongxuRs']}'";
		}
		$pager = &new TMIS_Pager($sql);
        $rowset = $pager->findAll();
        $rowsetAll = $this->_modelExample->findBySql($sql);
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
		}
		$heji=$this->getHeji($rowset,array('money'),'dateInput');
		$zongji=$this->getHeji($rowsetAll,array('money'),'dateInput');
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
			// 'cnt'=>'公斤数',
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
		$sql = "select gangId from dye_chanliang where id='{$_GET['id']}'";
		$gangId = $this->_modelExample->findBySql($sql);
		$ganghao = $gangId[0]['gangId'];
		$sqlCount = "select count(*) as counts from dye_chanliang where gangId='{$ganghao}' and type=3";
		$counts = $this->_modelExample->findBySql($sqlCount);
		if($counts[0]['counts']==1){
			$sqlChange ="update plan_dye_gang set rsStart=0 where id='{$ganghao}'";
			$this->_modelGang->execute($sqlChange);
		}
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
		// $this->authCheck('10-1-2');
		$this->_modelClGx = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
		$this->_modelRs = & FLEA::getSingleton('Model_JiChu_RsPrice');
		$arr=$this->_modelExample->find($_GET[id]);
		$arr['Gang'] = $this->_modelGang->find($arr['gangId']);
		// $arr['Client'] = $this->_modelGang->getClient($arr['gangId']);
		// $arr['Ware'] = $this->_modelGang->getWare($arr['gangId']);
		// $wareDanjia = $this->_modelWareDj->findByField('wareId',$arr['Ware']['id']);
		// $arr['danjia'] = $wareDanjia[$this->typeDanjia];
		//$gx = $this->_modelClGx->find(array('id'=>$arr['gxIds']));
		$gxs = $this->_modelRs->find(array('id'=>$arr['gxIds']));
		$arr['gxName'] = $gxs['gxName'];
		//$arr['gxName'] = $gx['gongxuName'];

		// dump($arr);die;
		$smarty = $this->_getView();
		$smarty->assign('$title', '增加修改打包产量');
		$smarty->assign('aRow',$arr);
		$smarty->assign('gxType','3');
		$smarty->display('Chanliang/inputRs.tpl');
	}

	function actionAdd(){
		$arr['employ'] = $this->_modelEmploy->findAll();

		// dump($arr);die;
		$smarty = $this->_getView();
		$smarty->assign('$title', '增加修改打包产量');
		$smarty->assign('aRow',$arr);
		$smarty->assign('gxType','3');
		$smarty->display('Chanliang/inputRs.tpl');
	}

	function actionSave(){
		//dump($_POST);die;
		$countPerson = count($_POST['gxPersonId']);
		// dump($countPerson);die;
		
		$this->_modelRsPrice = & FLEA::getSingleton('Model_JiChu_Vat2GxPrice');
		$this->_modelWareDj = & FLEA::getSingleton('Model_JiChu_WareDanjia');
		$this->_modelClGx = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
		
		foreach ($_POST['gxPersonId'] as $b => &$c) {
			foreach ($_POST['gangId'] as $key => &$v) {
				if(!$v ||!$_POST['gxIds'][$key]) continue;
				$temp['id'] 		= $_POST['id'];
				$temp['dateInput'] 	= $_POST['dateInput'];
				$temp['gangId'] 	= $_POST['gangId'][$key];
				$temp['gxIds']  	= $_POST['gxIds'][$key];
				$temp['wareName']  	= $_POST['wareName'][$key];
				$temp['gongxu']  	= $_POST['gongxu'][$key];
				$temp['gxTypeId']  	= $_POST['gxTypeId'][$key];
				$temp['cnt']  		= 1;
				$temp['type']		= 3; //标记产量类型
				$temp['workerId']	= $c;
                $temp['leixing']    = $_POST['leixing'][$key]+0;
				$rowset['Gang'] = $this->_modelGang->find($_POST['gangId'][$key]);
				$rowset['Ware'] = $this->_modelGang->getWare($_POST['gangId'][$key]);
				$temp['vatNum']  	= $_POST['vatId'][$key];
				$temp['vatId']  	= $rowset['Gang']['vatId'];

				
				$rowSon[] = $temp;
			}
		}
		foreach ($rowSon as $ke => &$val) {
		   $sql ="update plan_dye_gang set rsWc='{$_POST['isOverRsV'][$ke]}',inputRsDate='{$val['dateInput']}' where id='{$val['gangId']}'";
		   $this->_mGx->execute($sql);
           $sql1 = "update plan_dye_gang set rsStart=1 where id='{$val['gangId']}'";
           $this->_mGx->execute($sql1);
           //查看是否存在并缸，对并缸的缸号
           $sqlb = "select binggangId from plan_dye_gang where id='{$val['gangId']}'";
           $binggang = $this->_modelExample->findBySql($sqlb);
           if($binggang[0]['binggangId']){
           	$sql2 ="update plan_dye_gang_merge set isStartRs=1 where id='{$binggang[0]['binggangId']}'";
           	$this->_mGx->execute($sql2); 
           }
		}
		foreach ($rowSon as $k => &$v) {
			$gxIdsArr = explode(',',$v['gxIds']);
			$i = count($gxIdsArr);
			foreach ($gxIdsArr as $b => &$c) {
				$res['dateInput'] 		= $v['dateInput'];
				$res['gangId'] 			= $v['gangId'];
				$res['vatId']  			= $v['vatId'];
				$res['gxIds']  			= $gxIdsArr[$b];
				$res['wareName']  		= $v['wareName'];
				$res['gongxu']  		= $v['gxIds'];
				$res['gxTypeId']  		= $v['gxTypeId'];
				$res['cnt']  			= $v['cnt'];
				$res['type']			= 3;
				$res['workerId']		= $v['workerId'];
				$res['id']				= $v['id'];
				$res['leixing']         = $v['leixing'];

				// $rsDanjia = $this->_modelRsPrice->find(array('gxId'=>$gxIdsArr[$b],'vatId'=>$v['vatId'],'gxTypeId'=>$v['gxTypeId']));
                $sqlHebings ="select binggangId from plan_dye_gang where id='{$v['gangId']}'";
                $binggangIdNew = $this->_modelGang->findBySql($sqlHebings);
                $v['binggangIdNew'] = $binggangIdNew[0]['binggangId'];
                //dump($v['binggangIdNew']);die;
                if($v['binggangIdNew']>0){
                    $sqlVat = "select vatId from plan_dye_gang_merge where id='{$v['binggangIdNew']}'";
	                $vatId = $this->_modelGang->findBySql($sqlVat);
	                $v['vatId'] = $vatId[0]['vatId'];
	                $sqlbgs = "select count(*) as counts from plan_dye_gang where binggangId='{$v['binggangIdNew']}'";
	                $coutS = $this->_modelExample->findBySql($sqlbgs);
                }
				$rsDanjia = $this->_modelRsPrice->find(array('gxId'=>$gxIdsArr[$b],'vatId'=>$v['vatId']));

				$res['danjia'] = $rsDanjia['price']>0?$rsDanjia['price']:'0';
				if($coutS[0]['counts']>0){
					$res['danjia'] = $res['danjia']/$coutS[0]['counts'];
				}
				$res['money'] = $res['danjia']*$res['cnt']/$countPerson;
				$arr[]  				= $res;
			}
		}
		//dump($arr);die;
		if(!count($arr)){
         	echo ("<script>alert('请填写明细');history.go(-1)</script>");exit;
			exit;
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
            //'selGangHao'=>0
        ));

        $str = "SELECT x.*,w.wareName,w.guige,w.id as wareId,w.parentId,
			y.color,y.colorNum,t.clientId
        	from plan_dye_gang x
			left join trade_dye_order2ware y on x.order2wareId=y.id
			left join jichu_ware w on y.wareId=w.id
			left join trade_dye_order t on t.id=y.orderId
			where 1 and x.rsWc=0";

        if ($arr['key']!='') $str .= " and (
			vatNum like '%$arr[key]%'
		)";
		if ($arr['selGangHao']!='') $str .= " and (
			x.selGangHao like '%$arr[selGangHao]%'
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
			$str .= " and (x.dateAssign>='$arr[dateFrom]' and x.dateAssign<='$arr[dateTo]')";
		}
        $str .=" order by planDate desc";
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAllBySql($str);
        //dump($rowset);die;
		foreach($rowset as & $v) {
			$v['gxTypeId'] = $this->_modelWare->getTopClass($v['wareId'],$v['parentId']);
			// dump($v['gxTypeId']);die;
			// $sqlType = "select leixing from jichu_ware where id='{$v['gxTypeId']}'";
			// $leiXing = $this->_modelWare->findBySql($sqlType);
			// $v['leixing'] = $leiXing[0]['leixing'];
			if($v['isOfften']==0) $v['_bgColor']='lightblue';
			$this->makeEditable($v,'mnemocode');
			if($v['selGangHao']){
				$over='取消完成';
			}else{
				$over='完成';
			}
			$v['wareName'] = $v['wareName'] .' '. $v['guige'];
			$v['over']="<a url='' class='over' values='".$v['id']."' style='cursor:pointer;'>".$over."</a>";
            $sqlClient = "select compName from jichu_client where id='{$v['clientId']}'";
			$clientName = $this->_modelExample->findBySql($sqlClient);
            $v['compName'] = $clientName[0]['compName'];
		}
		//dump($rowset);die;
        $arr_field_info = array(
            //"_edit" => "选择",
            //"over"=>"完成",
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
		$this->_modelVatPrice = & FLEA::getSingleton('Model_JiChu_Vat2GxPrice');
        $aGang = $this->_modelGang->find($_GET['gangId']);//查找物理缸号
       // dump($aGang);die;
	 	$sql = "SELECT j.*,r.gxName
		        from jichu_vat2gxprice j
		        left join jichu_rsprice r on r.id=j.gxId
		        where 1 and j.vatId='{$aGang['vatId']}'";
        $rowset =$this->_modelExample->findBySql($sql);
       	$isBg = $this->_modelExample->findAll(array('gangId'=>$_GET['gangId'],'type'=>$_GET['type']),null,null,'gxIds');
		
        $wareArr = $this->_modelWare->find($aGang['OrdWare']['wareId']);
       	$temp =  array();
       	foreach ($isBg as $k => &$v) {
       		$temp[] = $v['gxIds'];
       	}
        foreach ($rowset as $key => &$value) {
			// $value['gxTypeId'] = $this->_modelWare->getTopClass($aGang['OrdWare']['wareId'],$wareArr['parentId']); //染色类型
        	if(in_array($value['gxId'],$temp)){
        		//unset($rowset[$key]);
        		$rowset[$key]['disabled'] = disabled; //已经选过的，不能被选中
        	}
        	//查找当前缸是否有binggangId，是否并缸，并缸的话，物理缸号就不是原来的缸号了，是新的物理缸号了 by pan 2018-05-18
        	$sqlHebing = "select binggangId from plan_dye_gang where id='{$_GET['gangId']}'";
        	$binggangIds = $this->_modelGang->findBySql($sqlHebing);
        	$v['binggangIds'] = $binggangIds[0]['binggangId'];
        	if($v['binggangIds']>0){
               $sqlVat = "select vatId from plan_dye_gang_merge where id='{$v['binggangIds']}'";
               $vatId = $this->_modelGang->findBySql($sqlVat);
               $aGang['vatId'] = $vatId[0]['vatId'];
        	}
        	$sqlPrice = "select price from jichu_vat2gxprice where vatId='{$aGang['vatId']}' and gxId='{$value['id']}'"; 
        	$gxPrices = $this->_modelExample->findBySql($sqlPrice);
        	$value['danjia'] = $gxPrices[0]['price'];
        }
        // dump($rowset);die;

        $smarty = & $this->_getView();
        $smarty->assign('rowset', $rowset);
        $smarty->display("Chanliang/GxSelect.tpl");
	}

}
?>