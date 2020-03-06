<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Yl_Chuku extends Tmis_Controller {
	var $_modelChuku;
	var $funcId, $readFuncId, $addFuncId, $editFuncId, $delFuncId;

	function Controller_CangKu_Yl_Chuku() {
		$this->_modelChuku = & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$this->_mWare = & FLEA::getSingleton('Model_CangKu_Yl_Chuku2Ware');
		$this->_modelChufang =  & FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$this->_modelEmploy =  & FLEA::getSingleton('Model_JiChu_Employ');
		$this->_setFuncId();
		//echo("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb"); exit;
	}
	//按工艺单领料时调用,列出已开工艺单的各缸
	function actionRight(){
		$this->authCheck(113);
		$title = "请选择需要领料的缸号";
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'		=>date("Y-m-d",mktime(0,0,0,date("m"),date('d')-6,date("Y"))),
			'dateTo'		=>date("Y-m-d"),
			//'clientId'		=>'',
			'orderCode'		=>'',
			'vatNum'		=>'',
			//'color'			=>'',
			//'chufangrenId'	=>0,
			//'chufangId'		=>0
		));

		$date='2012-04-30';
		$sql = "select x.*,y.dateChufang,m.employName as chufangRen,y.id as chufangId
			from view_dye_gang x
			inner join gongyi_dye_chufang y on x.order2wareId = y.order2wareId and (
				(y.gangId>0 and x.gangId=y.gangId)
				or y.gangId=0
			)
			left join cangku_yl_chuku z on y.id=z.chufangId and x.gangId=z.gangId
			left join jichu_employ m on m.id=y.chufangrenId
			where z.id is null and y.dateChufang>='{$arr['dateFrom']}' and y.dateChufang<='{$arr['dateTo']}' and y.dateChufang>'{$date}'";

		//echo($sql);exit;

		if ($arr['clientId']!='') $sql .=	" and x.clientId=$arr[clientId]";
		if ($arr['orderCode']!='') $sql .= " and x.orderCode like '%$arr[orderCode]%'";
		if ($arr['vatNum']!='') $sql .= " and x.vatNum like '%$arr[vatNum]%'";
		if ($arr['color'] != '') $sql .= " and color like '%$arr[color]%'";
		$sql .= " group by x.gangId,y.id order by dateChufang DESC";

		$pageSize = 20;
		$pager = & new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAll();
		//dump($rowset[0]);
		$con = array(
			order2wareId => $_GET[id],
			id => $_GET[chufangId]
		);
		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		if(count($arr)>0) foreach($rowset as & $row) {
			//dump($row);
			$row['vatNum']=$modelGang->setVatNum($row['gangId'],$row['order2wareId']);
			$row['guige'] = $row['wareName']. ' ' .$row['guige'];
			#显示操作项
			$row['orderCode']=$this->_modelOrder->getOrderTrack($row[orderId],$row[orderCode]);
			$row[_edit] = "<a href='".$this->_url('Print',array(
				'id' => $row[order2wareId],
				'chufangId' => $row[chufangId],
				'gangId'=>$row['gangId'],
				'for'=>'ll'
			))."'>确定领用</a>";
		}

		//dump($rowset[0]); exit;
		//exit;
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
		$smarty->assign('title','染化料领料登记');
		$smarty->assign("arr_field_info",$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display',none);//这边的添加 为其他出库 现在不需要其他出库 by zcc 2017年12月15日 13:42:19
		$smarty->assign('page_info',$pager->getNavBar($this->_url('Right', $arr)));
		$smarty->display('TableList.tpl');
	}
	//其他出库
    function actionRight3() {
		//$this->authCheck($this->readFuncId);
		$this->authCheck(115);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' => date("Y-m-d",strtotime('-1 month')),
			'dateTo' => date("Y-m-d"),
			'clientId'=>'',
			'chuKuType'=>3
		));
		$sql = "select x.gangId,
				x.id as chukuId,
				x.chufangId,
				x.chukuDate,
				x.chukuNum,
				x.depId,
				x.memo,
				x.dt,
				y.id as chuku2wareId,
				y.wareId,
				y.cnt,
				y.danjia,
				z.employName,
				a.employName as chufangRen,
				b.compName,
				(y.cnt*y.danjia) as money from cangku_yl_chuku x
				left join cangku_yl_chuku2ware y on x.id=y.chukuId
				left join jichu_employ z on z.id=x.employId
				left join jichu_employ a on a.id=x.chufangRen
				left join jichu_client b on b.id=x.clientId
				";

		$sql .= " where x.chukuDate>='{$arrGet['dateFrom']}' and x.chukuDate<='{$arrGet['dateTo']}'";
		if($_GET['wareId']>0) $sql .= " and y.wareId='{$_GET['wareId']}'";
		if($arrGet['clientId']>0) $sql .= " and x.clientId='{$arrGet['clientId']}'";
		if($arrGet['chuKuType']>0) $sql.=" and x.kind='{$arrGet['chuKuType']}'";
		//$sql.=" and x.isTuiku=2";
		//$sql.=" and x.kind=3";
		$sql .= " order by chukuDate desc";

		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();

		$mDep = & FLEA::getSingleton('Model_JiChu_Department');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$mView = & FLEA::getSingleton('Model_Plan_Dye_ViewGang');

		if(count($rowset)>0) foreach($rowset as & $v) {
			//dump($v);
			$v['Department']	= $mDep->find(array('id'=>$v['depId']));
			$v['Gang']			= $mView->find(array('gangId'=>$v['gangId']));
			$v['Ware']			= $mWare->find(array('id'=>$v['wareId']));
			$v['guige']			= $v['Ware']['wareName'] . ' ' . $v['Ware']['guige'];
			//$v['cnt']			= abs($v['cnt'])*1000;
			$v[_edit] = "<a href='".$this->_url('edit',array('id'=>$v['chukuId'],'update'=>'other'))."'>修改</a>".'  '."<a href='".$this->_url('Remove',array('id'=>$v['chukuId'],'other'=>'other'))."'>删除</a>";
			$v['unit']=$v['Ware']['unit'];
		}
			//dump($rowset);exit;
		$heji=$this->getHeji($rowset, array('cnt'),'chukuDate');
		$rowset[]=$heji;
		$arrFieldInfo = array(
			'chukuDate' =>'日期',
			'chukuNum' =>'流水号',
			//'Gang.vatNum'=>'缸号',
			'employName' =>'染色工',
			'Department.depName' =>'领料部门',
			'chufangRen' =>'处方人',
			'compName' =>'客户',
			'guige'=>'品名规格',
			'cnt' =>'数量',
			'unit' =>'单位',
			'_edit'=>'操作'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','其他出库');
		//$smarty->assign('add_display','none');
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}
	#出库明细查询
	function actionChukuDetail(){
		$this->authCheck($this->readFuncId);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			//'dateFrom' => date("Y-m-d",strtotime('-1 month')),
			//'dateTo' => date("Y-m-d"),
			'key'=>''
		));
		$arrGet['dateFrom1']=$_GET['dateFrom']==''?$_GET['dateFrom1']:$_GET['dateFrom'];
		$arrGet['dateTo1']=$_GET['dateTo']==''?$_GET['dateTo1']:$_GET['dateTo'];
		$arrGet['wareId1']=$_GET['wareId']==''?$_GET['wareId1']:$_GET['wareId'];
		//dump($arrGet);
		$sql = "select x.gangId,
			x.id as chukuId,
			x.chufangId,
			x.chukuDate,
			x.chukuNum,
			x.depId,
			x.memo,
			x.dt,
			y.id as chuku2wareId,
			y.wareId,
			y.cnt,
			y.danjia,
			(y.cnt*y.danjia) as money
			from cangku_yl_chuku x
			left join cangku_yl_chuku2ware y on x.id=y.chukuId
		";

		$sql .= " where x.chukuDate>='{$arrGet['dateFrom1']}' and x.chukuDate<='{$arrGet['dateTo1']}'";
		if($arrGet['wareId1']>0) $sql .= " and y.wareId='{$arrGet['wareId1']}'";
		$sql .= " order by chukuDate desc";
		
		//echo $sql;exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();

		$mDep = & FLEA::getSingleton('Model_JiChu_Department');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$mView = & FLEA::getSingleton('Model_Plan_Dye_ViewGang');

		if(count($rowset)>0) foreach($rowset as & $v) {
			$v['Department']	= $mDep->find(array('id'=>$v['depId']));
			$v['Gang']			= $mView->find(array('gangId'=>$v['gangId']));
			$v['Ware']			= $mWare->find(array('id'=>$v['wareId']));
			$v['guige']			= $v['Ware']['wareName'] . ' ' . $v['Ware']['guige'];
            $v['cnt']			= abs($v['cnt']);
		}


		$arrFieldInfo = array(
			'chukuDate' =>'日期',
			'chukuNum' =>'流水号',
			'Gang.vatNum'=>'缸号',
			'guige'=>'品名规格',
			'Ware.unit'=>'单位',
			'cnt' =>'数量KG',
			'danjia' =>'单价',
			'money'=>'金额',
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','染化料领料查询');
        $smarty->assign('add_display','none');
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}
	//显示处方单明细，对应入库
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
					$row[vatCnt] = round($row[unitKg]*$chufang[Gang][shuirong]/1000*round($chufang[Gang]['zhelv'],3),4);
				}
				else $row[vatCnt] = 0;
			} elseif($row['unit']=='%') {//%用量 = 单位用量*投纱量/1000
				//echo(count($chufang[Gang][Vat])); exit;
				if ($chufang[Gang][Vat] != '') {
					$row[vatCnt] = round($row[unitKg]*$z*$chufang[Gang][cntPlanTouliao]/100*round($chufang[Gang]['zhelv'],3),4);
				}
				else $row[vatCnt] = 0;
			}
			else {//染化料缸用量=总公斤数/(包用量*5)
				$row[vatCnt] = round($chufang[Gang][cntPlanTouliao]*$chufang['rhlZhelv']/1000*$row[unitKg]/5,4);
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

	//保存染料领用数据
	function actionSaveForLl(){
		$m = & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$arr = array(
			'chukuDate'=>date('Y-m-d'),
			'gangId'=>$_POST['gangId'],
			'chufangId'=>$_POST['chufangId'],
			'chukuNum'=>$m->getRukuNum(),
			'memo'=>'自动生成'
		);
		// dump($_POST);exit;
		if($_POST['wareId']) foreach($_POST['wareId'] as $key=>& $v) {
			if ($_POST['wareId'][$key]=='') {
				continue;
			}
			$arr['Wares'][] = array(
				'wareId'=>$_POST['wareId'][$key],
				'danjia'=>$m->getRukuDanjia($v)+0,
				'cnt'=>$_POST['cnt'][$key]
			);
		}
		// dump($arr);die();
		if($m->save($arr)) redirect($this->_url('Right'));
		//dump($arr);
		exit;
	}

	//染化料领用查询
    function actionRight1(){
		$this->authCheck(114);
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' => date("Y-m-d",strtotime('-1 month')),
			'dateTo' => date("Y-m-d"),
			'vatNum'=>'',
		));

		$sql = "select x.gangId,
			x.id as chukuId,
			x.chufangId,
			x.chukuDate,
			x.chukuNum,
			x.depId,
			x.memo,
			x.dt,
			y.id as chuku2wareId,
			y.wareId,
			sum(y.cnt) as cnt,
			y.danjia,
			(y.cnt*y.danjia) as money from cangku_yl_chuku x
			left join cangku_yl_chuku2ware y on x.id=y.chukuId
			left join plan_dye_gang z on z.id=x.gangId
		";
		$sql .= " where x.chukuDate>='{$arrGet['dateFrom']}' and x.chukuDate<='{$arrGet['dateTo']}' ";
		// by zcc 原语句为 and x.kind<>9  领料查询只能查看领料的数据 kind=0 为领料 3为其他 8为调拨 9为调库
		$sql .= " and x.kind = 0";  
		if($_GET['wareId']>0) $sql .= " and y.wareId='{$_GET['wareId']}'";
		if($arrGet['vatNum']!='')$sql.=" and z.vatNum like '%{$arrGet['vatNum']}%'";
		$sql.=" group by y.id,y.wareId";
		$sql .= " order by chukuDate desc,chukuNum,y.id";
		//echo $sql;exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();

		$mDep = & FLEA::getSingleton('Model_JiChu_Department');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$mView = & FLEA::getSingleton('Model_Plan_Dye_ViewGang');
		$modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		if(count($rowset)>0) foreach($rowset as & $v) {
			$v['Department']	= $mDep->find(array('id'=>$v['depId']));
			$v['Gang']			= $mView->find(array('gangId'=>$v['gangId']));
			$v['Ware']			= $mWare->find(array('id'=>$v['wareId']));
			$v['guige']			= $v['Ware']['wareName'] . ' ' . $v['Ware']['guige'];
            $v['cnt']			= abs($v['cnt']);
			$v['Gang']['vatNum']=$modelGang->setVatNum($v['Gang']['gangId'],$v['Gang']['order2wareId']);
			//$v['_edit'] = "<a href='".$this->_url('edit',array('id'=>$v['chukuId']))."'>修改</a>  |  ";
			/*$v['_edit'].="<a href='".$this->_url('removeWare',array(
				'id' =>$v['chuku2wareId'],
				'chukuId' => $v['chukuId'],
			))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>  |  ";*/
			$v['_edit'].="<a href='".$this->_url('remove',array(
				'id'=>$v['chukuId']
			))."' onclick='return confirm(\"您确认要整单删除吗？\");'>整单删除</a>";
		}

		$heji = $this->getHeji($rowset,array('cnt'),'chukuDate');
		$rowset[] = $heji;
		$arrFieldInfo = array(
			'chukuDate' =>'日期',
			'chukuNum' =>'流水号',
			'Gang.vatNum'=>'缸号',
			//'Department.depName' =>'领料部门',
			//'Supplier.compName' =>'领料部门',
			//'Ware.wareName'=>'货品名称',
			'guige'=>'品名规格',
			'Wares.unit'=>'单位',
			'cnt' =>'数量KG',
			//'danjia' =>'单价',
			//'money'=>'金额',
			'_edit'=>'操作'
		);

		$smarty = & $this->_getView();
		$smarty->assign('title','染化料领料查询');
        $smarty->assign('add_display','none');
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList2.tpl');
	}

	#查看详细
	function actionViewMore() {
		//$this->authCheck($this->funcId);
		if ($_SESSION['rukuTag'] == 1) {
			$pk=$this->_modelChukuYl->primaryKey;
			$this->_editable($_GET[$pk]);
			$arrFieldValue=$this->_modelChukuYl->find($_GET[$pk]);
		}
		else {
			$pk=$this->_modelChuku->primaryKey;
			$this->_editable($_GET[$pk]);
			$arrFieldValue=$this->_modelChuku->find($_GET[$pk]);
		}

		FLEA::loadClass('TMIS_Pager');
		$modelWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$i = 0;
		$cntTotal = 0;
		if (count($arrFieldValue["Wares"]) > 0) {
			foreach ($arrFieldValue["Wares"] as & $value) {

				$rowWare = $modelWare->findByField('id', $value["wareId"]);
				$value["wareName"] = $rowWare["wareName"];
				$value["guige"] = $rowWare["guige"];
				$value["unit"] = $rowWare["unit"];
				$cntTotal += $value[cnt];
				$i++;
			}
			$arrFieldValue[Wares][$i][id] = '<strong>合计</strong>';
			$arrFieldValue[Wares][$i][cnt] = '<strong>'.$cntTotal.'</strong>';
		}

		//dump($arrFieldValue);

		$smarty = & $this->_getView();

		$smarty->assign("arr_field_value",$arrFieldValue);

		//if ($_SESSION['rukuTag'] == 1) $smarty->assign("supplier_client", "客户");
		//else $smarty->assign("supplier_client", "供应商");

		$smarty->display('CangKu/ChukuViewMore.tpl');
	}

	function _edit($arr) {
		//dump($arr);
		FLEA::loadClass('TMIS_Pager');
		//员工名称
		$str="select * from jichu_employ where depId=10";
		$pager =& new TMIS_Pager($str);
		$row =$pager->findAll();
		//		/dump($row);
		if($arr['chukuNum']=='') {
			$arr['chukuNum'] = $this->_modelExample->getNewChukuNum();
		}
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');

		if (count($arr['Wares'])>0) foreach($arr['Wares'] as & $v) {
			$v['Ware'] =$mWare->find(array('id'=>$v['wareId']));
			//dump($v);
			//dump($update);exit;
	//			if($update=='other') {
	//				$v['cnt']=$v['cnt']*1000;
	//			}
			}
		//dump($arr);exit;
		//$this->authCheck($this->editFuncId);
		$smarty = & $this->_getView();
		$smarty->assign("title",'其他出库');
		$smarty->assign("arr_employ",$row);
		$smarty->assign("arr_field_value",$arr);
		$smarty->display('CangKu/Yl/ChukuEdit.tpl');
	}

	function actionSave() {
		//$arr= $this->_modelExample->find(array('id'=>'1'));
		//dump($_POST);exit;
		$arr=$_POST;
		$count=count($this->_modelExample->findAll(array('chukuNum'=>$_POST['chukuNum'])));
		//dump($count);exit;
		if($_POST['id']=='') {if($count>0) js_alert('单号已存在!','history.go(-1)');}
		$m = & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		//保存领料的内容
		if($_POST['update']=='lingliao') {
			foreach($_POST['wareId'] as  $key=>$v) {
				if($v=='' || $_POST['cnt'][$key]=='') continue;
				$arr['Wares'][$key]['cnt']=$_POST['cnt'][$key];
				$arr['Wares'][$key]['danjia']=$m->getRukuDanjia($v);
				//$arr['Wares'][$key]['danjia']=$_POST['danjia'][$key];
				$arr['Wares'][$key]['wareId']=$v;
				if($_POST['chuku2WareId'][$key]!='')  $arr['Wares'][$key]['id']=$_POST['chuku2WareId'][$key];
			}
		}else {
			foreach($_POST['wareId'] as  $key=>$v) {
				if($v=='' || $_POST['cnt'][$key]=='') continue;
				$arr['Wares'][$key]['cnt']=$_POST['cnt'][$key];
				$arr['Wares'][$key]['danjia']=$m->getRukuDanjia($v);
				//$arr['Wares'][$key]['danjia']=$_POST['danjia'][$key];
				$arr['Wares'][$key]['wareId']=$v;
				if($_POST['chuku2WareId'][$key]!='')
					$arr['Wares'][$key]['id']=$_POST['chuku2WareId'][$key];
				$arr['kind']=3;
			}
		}
		//dump($arr);exit;
		$newId=$this->_modelExample->save($arr);
		//$dbo = &FLEA::getDBO(false);dump($dbo->log);exit;
		if($newId===true) $newId=$_POST['id'];
		if($_POST['submit1']=='确定并打印') {
			redirect($this->_url('PrintLodop',array(
			'id'=>$newId
			)));
			exit;
		} else {
			if($_POST['update']=='lingliao') {
			redirect($this->_url('right1'));
			}else {
			redirect($this->_url('right3'));
			}
		}
    }

	function actionRemove(){
		$this->_modelExample->removeByPkv($_GET['id']);
		redirect($this->_url('right1'));
	}

	function actionRemoveWare() {
		$this->_mWare->removeByPkv($_GET['id']);
        redirect($this->_url('right1'));
	}

	#设置权限
	function _setFuncId() {
		//$rukuTag = $this->_checkModel();
		/*if ($rukuTag == 1) {
			$this->readFuncId = 96;
			$this->addFuncId =98;
			$this->editFuncId =98;
			$this->delFuncId =98;
		}
		else{*/
			$this->readFuncId = 61;
			$this->addFuncId =62;
			$this->editFuncId =62;
			$this->delFuncId =62;
		//}
	}
	function actionPrintLodop(){
		$arr = $this->_modelChuku->find(array('id'=>$_GET['id']));
		foreach($arr['Wares'] as $key=>$v){
			$r=$arr['Wares'][$key]['wareId'];
			$arr['cnt'][]=$arr['Wares'][$key]['cnt'];

			$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
			$arr[ware][]=$mWare->find(array('id'=>$r));
			$arr['guige'][]=$arr['ware'][$key]['guige'];//将规格单独列出
			$arr['unit'][]=$arr['ware'][$key]['unit'];//将单位单独列出
		}
		$ret = array($arr);
		//将超过六行的数据，另外存储
		$cnt = ceil(count($arr['guige'])/6);
		$guiges = $arr['guige'];
		$units = $arr['unit'];
		$cnts = $arr['cnt'];
		for($i=0;$i<$cnt;$i++) {
			$temp = $arr;
			$temp['guige'] = array_slice($guiges,$i*6,6);
			$temp['unit'] = array_slice($units,$i*6,6);
			$temp['cnt'] = array_slice($cnts,$i*6,6);
			$ret[] = $temp;
			unset($temp);
		}

		//dump($ret);//exit;
		$smarty = & $this->_getView();
		$smarty->assign("obj",$ret);
		$smarty->display('CangKu/Yl/printDirectly.tpl');

	}
	#染料耗用分析
    function actionYlAnalyse() {
		$this->authCheck(116);
		$mWare = & FLEA::getSingleton('Model_Jichu_Ware');
		$ranliao = $mWare->find(array('wareName'=>'染料类'));
		$rLeftId = $ranliao['leftId'];
		$rRightId = $ranliao['rightId'];
		$zhuji = $mWare->find(array('wareName'=>'助剂类'));
		$zLeftId = $zhuji['leftId'];
		$zRightId = $zhuji['rightId'];
		//dump($ranliao);exit;
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom'	=>date('Y-m-01'),
			'dateTo'	=>date('Y-m-d'),
			'chufangrenId'=>''
		));


		$str="select x.*,y.cnt,y.wareId,z.wareName,z.guige,m.chufangrenId
				from cangku_yl_chuku x
				left join cangku_yl_chuku2ware y on y.chukuId=x.id
				left join jichu_ware z on z.id=y.wareId
				left join gongyi_dye_chufang m on m.id=x.chufangId
				where z.leftId>'{$rLeftId}' and z.rightId<'{$rRightId}'
				";
		if($arrGet['chufangrenId']!='') $str.=" and m.chufangrenId='{$arrGet['chufangrenId']}'";
		if($arrGet['dateFrom']!=''&&$arrGet['dateTo']!='') $str.=" and x.chukuDate>='{$arrGet['dateFrom']}' and x.chukuDate<='{$arrGet['dateTo']}'";
		$row=$this->_modelChuku->findBySql($str);
		//dump($row);
		foreach($row as & $v) {
		//得到处方人
			$chufangren=$this->_modelEmploy->find($v['chufangrenId']);
			//dump($chufangren);
			$v['chufangren']=$chufangren['employName'];
			$v['ware']=$v['wareName'].' '.$v['guige'];
		}
		$row=array_group_by($row,'chufangren');
		foreach($row as & $v) {
			$v=array_group_by($v,'ware');
		}
		//dump($row);

		$rowset=array();
		foreach($row as $key=>& $v) {

			foreach($v as $key1=>& $vv) {
			$normal=0;
			$jialiao=0;
			$other=0;
			foreach($vv as & $m) {
			//dump($m);
				if($m['kind']==0) {//正常
				$normal+=$m['cnt'];
				}elseif($m['kind']==1) {//修色
				$other+=$m['cnt'];
				}elseif($m['kind']==2) {//加料
				$jialiao+=$m['cnt'];
				}
			// dump($normal);
			}
			$arr=array(
				'chufangren'=>$key,
				'wareName'=>$key1,
				'normal'=>$normal==0?'':$normal,
				'other'=>$other==0?'':$other,
				'jialiao'=>$jialiao==0?'':$jialiao
			);
			$rowset[]=$arr;
			}
		}
		if($rowset) {
			$rheji=$this->getHeji($rowset, array('normal','other','jialiao'),'chufangren');
			$rowset[]=$rheji;
			$rowset[] = array();
		}


		//产生助剂类报表
		$str="select x.*,y.cnt,y.wareId,z.wareName,z.guige,m.chufangrenId
				from cangku_yl_chuku x
				left join cangku_yl_chuku2ware y on y.chukuId=x.id
				left join jichu_ware z on z.id=y.wareId
				left join gongyi_dye_chufang m on m.id=x.chufangId
				where z.leftId>'{$zLeftId}' and z.rightId<'{$zRightId}'
				";
		if($arrGet['chufangrenId']!='') $str.=" and m.chufangrenId='{$arrGet['chufangrenId']}'";
		if($arrGet['dateFrom']!=''&&$arrGet['dateTo']!='') $str.=" and x.chukuDate>='{$arrGet['dateFrom']}' and x.chukuDate<='{$arrGet['dateTo']}'";
		$row=$this->_modelChuku->findBySql($str);
		//dump($row);
		foreach($row as & $v) {
		//得到处方人
			$chufangren=$this->_modelEmploy->find($v['chufangrenId']);
			//dump($chufangren);
			$v['chufangren']=$chufangren['employName'];
			$v['ware']=$v['wareName'].' '.$v['guige'];
		}
		$row=array_group_by($row,'chufangren');
		foreach($row as & $v) {
			$v=array_group_by($v,'ware');
		}
		//dump($row);

		//$rowset=array();
		foreach($row as $key=>& $v) {
			foreach($v as $key1=>& $vv) {
			$normal=0;
			$jialiao=0;
			$other=0;
			foreach($vv as & $m) {
			//dump($m);
				if($m['kind']==0) {//正常
				$normal+=$m['cnt']/1000;
				}elseif($m['kind']==1) {//修色
				$other+=$m['cnt']/1000;
				}elseif($m['kind']==2) {//加料
				$jialiao+=$m['cnt']/1000;
				}
			// dump($normal);
			}
			$arr=array(
				'chufangren'=>$key,
				'wareName'=>$key1,
				'normal'=>$normal==0?'':round($normal,3),
				'other'=>$other==0?'':round($other,3),
				'jialiao'=>$jialiao==0?'':round($jialiao,3)
			);
			$rowset[]=$arr;
			}
		}
		$heji=$this->getHeji($rowset, array('normal','other','jialiao'),'chufangren');
		//dump($heji);
		$zHeji=array(
			'chufangren'=>$heji['chufangren'],
			'normal'=>number_format($heji['normal']-$rheji['normal']-$rheji['normal'], 3, '.', ''),
			'other'=>$heji['other']-$rheji['other']-$rheji['other'],
			'jialiao'=>number_format($heji['jialiao']-$rheji['jialiao']-$rheji['jialiao'], 2, '.', '')
		);
		$rowset[]=$zHeji;
		//dump($rowset);

		$smarty = & $this->_getView();
		$smarty->assign('title','染化料耗用分析');
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');//
		$smarty->assign('arr_field_info', array(
			'chufangren'=>'处方人',
			'wareName'=>'染料名称',
			'normal'=>'正常处方(KG)',
			//'jialiao'=>'加料(KG)',
			//'other'=>'回修(KG)',
		));
		$smarty->assign('arr_condition', $arrGet);
		$smarty->display('Tablelist.tpl');
    }

}
?>
