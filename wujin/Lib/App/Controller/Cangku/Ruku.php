<?php
FLEA::loadClass('TMIS_Controller');
////////////////////////////////////////控制器名称
class Controller_Cangku_Ruku extends Tmis_Controller {
	var $_modelExample;
	function __construct() {
	////////////////////////////////默认model
		$this->_modelExample = & FLEA::getSingleton('Model_Cangku_Ruku');
		$this->_mRuku2ware = & FLEA::getSingleton('Model_Cangku_Ruku2Ware');
	}

	//入库明细查询
	function actionRight() {
	////////////////////////////////标题
		$title = '入库查询';
		///////////////////////////////模板文件
		if($_GET['export']==1) {
			if($_GET['dateFrom']!='')$title.='('.$_GET['dateFrom'].'--'.$_GET['dateTo'].')';
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment;filename=test.xls");
			header("Content-Transfer-Encoding: binary");
			$tpl = 'Export2Excel.tpl';
		}elseif($_GET['print']==1){
		    $tpl = 'Print1.tpl';
		}else{
		    $tpl = 'TableList2.tpl';
		}
		///////////////////////////////表头
		if($_GET['export']==1||$_GET['print']==1){
		    $arr_field_info = array(
			    'rukuDate'=>'入库日期',
			    'rukuCode'=>'入库单号',
			    //'Ruku.songhuoCode'=>'送货单/发票号',
			    'compName'=>'供应商',
			    'employName'=>'经手人',
			    'wareCode'=>'物料编码',
			    'wareName'=>'品名',
			    'guige'=>'规格',
			    'unit'=>'单位',
			    'cnt'=>'数量|right',
			    'danjia'=>'单价|right',
			    'money'=>'金额|right'
		    );
		}else{
		    $arr_field_info = array(
			    'rukuDate'=>'入库日期|left',
			    'rukuCode'=>'入库单号|left',
			    //'Ruku.songhuoCode'=>'送货单/发票号',
			    'compName'=>'供应商|left',
			    'employName'=>'经手人|left',
			    'wareCode'=>'物料编码|left',
			    'wareName'=>'品名|left',
			    'guige'=>'规格|left',
			    'unit'=>'单位|left',
			    'cnt'=>'数量|right',
			    'danjia'=>'单价|right',
			    'money'=>'金额|right',
			    '_edit'=>'操作'
		    );
		}
		///////////////////////////////搜索条件
		$arrCon = array(
			//'key'=>'',
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'supplierId'=>'',
			'pinGui'=>'',
			'code'=>'',
			'jingshouren'=>'',
			'rukuCode'=>''
		);
		///////////////////////////////模块定义
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray($arrCon);

		/************构造condition**********/
		//正常入库
		/*$condition=array(
			array('Ruku.type',0)
		);*/
		/*if($arr['']) {
			$condition[] = array('',$arr['']);
			//$condition[] = array('','%'.$arr[''].'%','like');
		}*/

		$str="select x.*,a.employName,y.rukuDate,y.rukuCode,z.wareCode,z.unit,z.guige,z.wareName,m.compName from cangku_ruku2ware x
		    left join cangku_ruku y on y.id=x.rukuId
		    left join jichu_ware z on z.id=x.wareId
		    left join jichu_supplier m on m.id=y.supplierId
			left join jichu_employ a on y.jingshouRenId=a.id
		    where y.type=0
		";
		if($arr['dateFrom']!='')$str.=" and y.rukuDate>='$arr[dateFrom]'";
		if($arr['dateTo']!='')$str.=" and y.rukuDate<='$arr[dateTo]'";
		if($arr['supplierId']!='')$str.=" and y.supplierId='$arr[supplierId]'";
		if($arr['pinGui']!='')$str.=" and z.wareName like '%$arr[pinGui]%'";
		if($arr['code']!='')$str.=" and z.wareCode like '%$arr[code]%'";
		if($arr['jingshouren']!='')$str.=" and a.employName like '%{$arr['jingshouren']}%'";
		if($arr['rukuCode']!='') $str.=" and y.rukuCode like '%{$arr['rukuCode']}%'";
		$str .= " order by y.rukuCode desc";
		//echo $str;
		$row=$this->_modelExample->findBySql($str);
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		//dump($rowset);
		$mSupplier = & FLEA::getSingleton("Model_Jichu_Supplier");
		$rukuId=0;
		if(count($rowset)>0) foreach($rowset as & $v) {
			if($v['rukuId']==$rukuId) {
				$v['rukuDate']='';
				$v['rukuCode']='';
				$v['compName']='';
				$v['employName']='';
				$v['_edit']='';
			} else {
				$rukuId=$v['rukuId'];
				$v['_edit']= $this->getEditHtml($v['rukuId']) . ' | ' . $this->getRemoveHtml($v['rukuId']);
			}
			///////////////////////////////
			//$this->makeEditable($v,'memoCode');
				$v['danjia'] = number_format($v['danjia'],2,'.','');
				$v['money']=number_format($v['money'],2,'.','');
				$v['cnt']=round($v['cnt'],2);
				//$v['Ruku']['Supplier'] = $mSupplier->find(array('id'=>$v['Ruku']['supplierId']));
				//$v['guige'] = $v['Ware']['wareName'] . ' ' . $v['Ware']['guige'];
				/*$v['_edit'] = "<a href='".$this->_url('print',array(
					'id'=>$v['rukuId'],
				))."' target='_blank' title='入库单打印'><img src='Resource/Image/System/print.gif' style='margin:0px;'></a>&nbsp&nbsp";*/
				$v['rukuCode']="<a href='".$this->_url('print',array('id'=>$v['rukuId'],'kind'=>1))."' target='_blank'>".$v['rukuCode']."</a>";

			}
		$rukuId=0;
		if(count($row)>0) foreach($row as & $v) {
		    if($v['rukuId']==$rukuId) {
			    $v['rukuDate']='';
			    $v['rukuCode']='';
			    $v['compName']='';
			    $v['employName']='';
			    //$v['_edit']='';
		    } else {
			    $rukuId=$v['rukuId'];
		    }
			    $v['danjia'] = number_format($v['danjia'],2,'.','');
			    $v['money']=number_format($v['money'],2,'.','');
			    $v['cnt']=round($v['cnt'],2);
		    }
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$_GET['export']==1?$row:$rowset);
		$smarty->assign('arr_condition', $arr);

		/*///////////////grid,thickbox,///////////////*/
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$mm="<input type='button' value=' 导 出 ' onclick=\"window.location.href='".$this->_url('Right',array(
			'export'=>1,
			'dateFrom'=>$arr['dateFrom'],
			'dateTo'=>$arr['dateTo']
			))."'\" />";
		$mm.="<input type='button' value=' 打 印 ' onclick=\"window.location.href='".$this->_url('Right',array(
			'print'=>1,
			'dateFrom'=>$arr['dateFrom'],
			'dateTo'=>$arr['dateTo']
			))."'\" />";
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)).$mm);
		$smarty-> display($tpl);
	}
	function _edit($Arr) {
	///////////////////////////////标题
		$title = '采购入库';
		///////////////////////////////模板
		$tpl = 'Cangku/RukuEdit.tpl';
		///////////////////////////////模块定义
		$aWare = & FLEA::getSingleton('Model_Jichu_Ware');
		$aKucun = & FLEA::getSingleton('Model_Cangku_Kucun');
		$this->employKind = & FLEA::getSingleton('Model_Jichu_EmployKind');
		$row=$this->employKind->findAll();

		foreach($Arr['Ware'] as & $v) {
		//dump($v);
			$ware=$aWare->find($v['wareId']);
			$v['Wares']=$ware;
			$kucun=$aKucun->find(array('wareId'=>$v['wareId']));
			$v['cntKucun']=round($kucun['cnt'],2);
			$v['money']=number_format($v['money'],2,'.','');
			$v['cnt']=round($v['cnt'],2);
			$v['danjia']=round($v['danjia'],4);
		}
		//dump($Arr);
		$heji=$this->getHeji($Arr['Ware'], array('money'));
		$Arr['tCnt']=number_format($heji['money'],2,'.','');
		//dump($Arr);exit;
		$this->authCheck();
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign("arr_field_value",$Arr);
		$smarty->assign("kind",$row);
		$smarty->display($tpl);
	}

	function actionAdd() {
		$arr = array(
			'rukuCode'=>$this->_modelExample->getNewCode()
		);
		$this->_edit($arr);
	}

	function actionSave() {
		//dump($_POST);exit;
		/*$arrDate = $this->getBenqi();
		if($_POST['rukuDate']<$arrDate['dateFrom']||$_POST['rukuDate']>$arrDate['dateTo']){
		    js_alert('入库日期不在本期内！','window.history.go(-1)');
		}

		//如果修改的是上期数据，禁止
		if($_POST['id']>0) {
			$old = $this->_modelExample->find(array('id'=>$_POST['id']));
			if($old['rukuDate']<$arrDate['dateFrom']||$old['rukuDate']>$arrDate['dateTo']) {
				js_alert('入库日期不在本期内！','window.history.go(-1)');
			}
		}*/

		$p=$_POST;
		$p['Ware'] = array();
		foreach($p['cnt'] as $key=>&$v) {
			if($v==''||$p['wareId'][$key]=='') continue;
			$p['Ware'][] = array(
				'id'=>$p['ruku2wareId'][$key],
				'wareId'=>$p['wareId'][$key],
				'cnt'=>$p['cnt'][$key],
				'danjia'=>$p['danjia'][$key],
				'money'=>$p['money'][$key]
			);
			//判断物料的修改情况，并形成日志的备注
			if($p['ruku2wareId'][$key]==''){
			    $memo="新增了物料:".$p['wareName'][$key].",数量为:".$p['cnt'][$key]."，单价为:".$p['danjia'][$key];
			}elseif($p['ruku2wareId'][$key]!=''){
			    $ruku2wareId=$p['ruku2wareId'][$key];
			    $str="select * from cangku_ruku2ware where id='$ruku2wareId'";
			    //echo $str."<br>";
			    $re=mysql_fetch_assoc(mysql_query($str));
			    //echo $memo."<br>";
			    if($re['danjia']!=$p['danjia'][$key]&&$re['cnt']==$p['cnt'][$key]){
				//echo 'danjia'."<br>";
				$memo1="物料:".$p['wareName'][$key].",单价由".$re['danjia']."变为:".$p['danjia'][$key]."。";
			    }elseif($re['cnt']!=$p['cnt'][$key]&&$re['danjia']==$p['danjia'][$key]){
				//echo 'cnt'."<br>";
				$memo2="物料:".$p['wareName'][$key].",数量由".$re['cnt']."变为:".$p['cnt'][$key]."。";
			    }elseif($re['cnt']!=$p['cnt'][$key]&&$re['danjia']!=$p['danjia'][$key]){
				//echo 'danjia2cnt'."<br>";
				$memo3="物料:".$p['wareName'][$key].",单价由".$re['danjia']."变为:".$p['danjia'][$key]."数量由".$re['cnt']."变为:".$p['cnt'][$key]."。";
			    }
			}
			//echo $memo."<br>";
		}
		$memo4=$memo.($memo==''?"  ":"<br>").$memo1.($memo1==''?"  ":"<br>").$memo2.($memo2==''?"  ":"<br>").$memo3;
		//echo $memo4;exit;

		$arrDisappear = array();//消失的物料
		//删除同单中需要删除的领料明细
		$ids = join(',',$p['ruku2wareId']);
		if($ids) {
			$sql = "select * from cangku_ruku2ware where rukuId='{$p['id']}' and id not in({$ids})";
			$rowToDel = $this->_modelExample->findBySql($sql);
			//取得删除的物料名称
			$wuliao='';
			foreach($rowToDel as & $v){
			    $str="select * from jichu_ware where id='$v[wareId]'";
			    $rr=mysql_fetch_assoc(mysql_query($str));
			    $wuliao.=$rr['wareName'].'、';
			}
			//echo $wuliao;
			//dump($rowToDel);exit;
			$sql = "delete from cangku_ruku2ware where rukuId='{$p['id']}' and id not in({$ids})";
			$this->_modelExample->execute($sql);

			if($rowToDel) foreach($rowToDel as & $v) {
				$arrDisappear[] = $v;
			}
			if(count($arrDisappear)>0)$memo5="删除了物料:".$wuliao;
		}
		$memo6=$memo4.$memo5;
		//echo $memo6;exit;
		//将操作保存到日志中
		$ip=$_SERVER['REMOTE_ADDR'];
		$userName=$_SESSION['USERNAME'];
		$handleDate=date('Y-m-d');
		if($_POST['id']==''){
		    $memo="入库记录中新增了物料，入库单号为:".$_POST['rukuCode'].",供应商为:".$_POST['supplierName'];
		    $str="insert into cangku_log(ip,userName,handleDate,memo) values('$ip','$userName','$handleDate','$memo')";
		    mysql_query($str);
		}else{
		    $str="insert into cangku_log(ip,userName,handleDate,memo) values('$ip','$userName','$handleDate','$memo6')";
		    mysql_query($str);
		}

		if(count($p['Ware'])==0) {
			js_alert('必须选择有效物料！','window.history.go(-1)');
			exit;
		}
		//如果修改的是物料编码，需要修改新老物料的库存和加权单价
		foreach($p['ruku2wareId'] as $key=>&$v) {
			if(!$v) continue;
			$sql = "select * from cangku_ruku2ware where id='{$v}' and wareId<>'{$p['wareId'][$key]}'";
			$rowToDel = $this->_modelExample->findBySql($sql);
			if($rowToDel) $arrDisappear[] = $rowToDel[0];
		}


		$arr = & $p;
		//'shenqingCode'=>$_POST['id']>0 ? $_POST['shenqingCode'] : $this->_modelExample->getNewCode(),
		$arr['rukuCode']=$arr['id']>0 ? $arr['rukuCode'] : $this->_modelExample->getNewCode();

		$rukuId=$this->_modelExample->save($arr);
		if($arr['id']>0) $rukuId = $arr['id'];

		//重新计算库存,并修改
		if($arr['Ware']) {
			foreach($arr['Ware'] as & $v) {
				$v['rukuId'] = $rukuId;
				$this->_mRuku2ware->_changeJqDanjia($v);
				$this->_modelExample->changeKucun($v);
			}
		}

		if($arrDisappear) foreach($arrDisappear as & $v) {
			$this->_mRuku2ware->_changeJqDanjia($v);
			$this->_modelExample->changeKucun($v);
		}


		if($p['kind']=='确定并返回') {
			js_alert('保存成功',null,$this->_url('right'));
		}elseif($p['kind']=='确定并打印') {
			redirect($this->_url('print',array('id'=>$p['id']==''?$rukuId:$p['id'])));
		}else {
			js_alert('保存成功',null,$this->_url('add'));
		}
	}

	function actionRemove() {
		//dump();
		$m = & FLEA::getSingleton("Model_Cangku_Ruku2ware");
		$mRuku = & FLEA::getSingleton("Model_Cangku_Ruku");
		$m->clearLinks();
		$condition = array('rukuId'=>$_GET['id']);
		$ruku2ware= $m->findAll($condition);
		//判断入库日期是否在本期内
		$ruku=$mRuku->find($_GET['id']);
		/*$arrDate = $this->getBenqi();
		if($ruku['rukuDate']<$arrDate['dateFrom']||$ruku['rukuDate']>$arrDate['dateTo']){
		    js_alert('入库日期不在本期内！','window.history.go(-1)');
		}*/
		/*dump($_SERVER);dump($_SESSION);
		dump($ruku);exit;*/
		$this->_modelExample->removeByPkv($_GET['id']);
		if($ruku2ware) {
			foreach($ruku2ware as & $v) {
				$this->_mRuku2ware->_changeJqDanjia($v);
				$this->_modelExample->changeKucun($v);
			}
		}
		//将操作保存到日志中
		$ip=$_SERVER['REMOTE_ADDR'];
		$userName=$_SESSION['USERNAME'];
		$handleDate=date('Y-m-d');
		$memo="入库记录中删除记录，入库单号为:".$ruku['rukuCode'].",供应商为:".$ruku['Supplier']['compName'];
		$str="insert into cangku_log(ip,userName,handleDate,memo) values('$ip','$userName','$handleDate','$memo')";
		mysql_query($str);
		redirect($this->_url('right'));
	}
	function actionPrint() {
		//dump($_GET);exit;
		$row=$this->_modelExample->find($_GET['id']);
		$mWare=& FLEA::getSingleton('Model_Jichu_Ware');
		$mEmploy=& FLEA::getSingleton('Model_Jichu_Employ');
		$tCon=0;
		foreach($row['Ware'] as & $v) {
			$ware=$mWare->find($v['wareId']);
			$v['Wares']=$ware;
			$v['danjia'] = round($v['danjia'],2);
			$tCon+=$v['money'];
		}
		//dump(count($row['Ware']));
		/*$t = 5-count($row['Ware']);
		if($t>0) for($i=0;$i<$t;$i++) {
			$row['Ware'][] = array();
		}*/
		$row['tCnt']=number_format($tCon,2,'.','');
		$zhidanRen=$mEmploy->find($row['zhidanRenId']);
		$row['zhidanRenName']=$zhidanRen['employName'];
		$yanshouRen=$mEmploy->find($row['yanshouRenId']);
		$row['yanshouRenName']=$yanshouRen['employName'];
		$shenheRen=$mEmploy->find($row['shenheRenId']);
		$row['shenheRenName']=$shenheRen['employName'];
		$jingshouRen=$mEmploy->find($row['jingshouRenId']);
		$row['jingshouRenName']=$jingshouRen['employName'];
		//判断物料是否超过5行，超过5行则分页显示
		//dump($row['Ware']);
		//将打印的行数控制为五行
		$mm=array();
		for($i=0;$i<=ceil(count($row['Ware'])/5);$i++){
		    for($j=1;$j<=count($row['Ware']);$j++){
			if(($i+1)==(ceil($j/5))){
			    $mm[$i][]=$row['Ware'][$j-1];
			}
		    }
		}
		//如没有五行则用空行补齐
		foreach($mm as & $v){
		    if(count($v)<5){
			for($i=0;$i<5;$i++){
			    $v[$i]=$v[$i];
			}
		    }
		}
		//将金额和数量及单价保留2位小数
		foreach($mm as & $v){
		    foreach($v as & $vv){
			if($vv!=''){
			    $vv['cnt']=round($vv['cnt'],2);
			    $vv['danjia']=number_format($vv['danjia'],2,'.','');
			    $vv['money']=number_format($vv['money'],2,'.','');
			}
		    }
		}
		//exit;
		//dump($mm);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title','入库打印');
		$smarty->assign("arr_field_value",$row);
		$smarty->assign('row',$mm);
		$smarty->assign('cnt',count($mm));
		load_file('TMIS_Common');
		$smarty->assign('tRmb',TMIS_Common::trans2rmb($row['tCnt']));
		$smarty->assign("kind",$row);
		$smarty->display('Cangku/RukuPrint.tpl');
	}
	//lodop控件打印
	function actionPrintLodop(){
		//dump($_GET);exit;
		$row=$this->_modelExample->find($_GET['id']);
		$mWare=& FLEA::getSingleton('Model_Jichu_Ware');
		$mEmploy=& FLEA::getSingleton('Model_Jichu_Employ');
		$tCon=0;
		foreach($row['Ware'] as & $v) {
			$ware=$mWare->find($v['wareId']);
			$v['Wares']=$ware;
			$v['danjia'] = round($v['danjia'],2);
			$tCon+=$v['money'];
		}
		$row['tCnt']=number_format($tCon,2,'.','');
		$zhidanRen=$mEmploy->find($row['zhidanRenId']);
		$row['zhidanRenName']=$zhidanRen['employName'];
		$yanshouRen=$mEmploy->find($row['yanshouRenId']);
		$row['yanshouRenName']=$yanshouRen['employName'];
		$shenheRen=$mEmploy->find($row['shenheRenId']);
		$row['shenheRenName']=$shenheRen['employName'];
		$jingshouRen=$mEmploy->find($row['jingshouRenId']);
		$row['jingshouRenName']=$jingshouRen['employName'];
		//将打印的行数控制为五行
		$mm=array();
		for($i=0;$i<=ceil(count($row['Ware'])/5);$i++){
		    for($j=1;$j<=count($row['Ware']);$j++){
			if(($i+1)==(ceil($j/5))){
			    $mm[$i][]=$row['Ware'][$j-1];
			}
		    }
		}
		//如没有五行则用空行补齐
		foreach($mm as & $v){
		    if(count($v)<5){
			for($i=0;$i<5;$i++){
			    $v[$i]=$v[$i];
			}
		    }
		}
		//将金额和数量及单价保留2位小数
		foreach($mm as & $v){
		    foreach($v as & $vv){
			if($vv!=''){
			    $vv['cnt']=round($vv['cnt'],2);
			    $vv['danjia']=number_format($vv['danjia'],2,'.','');
			    $vv['money']=number_format($vv['money'],2,'.','');
			}
		    }
		}
		//exit;
		$row['Wares']=$mm;
		load_file('TMIS_Common');
		$row['tRmb']=TMIS_Common::trans2rmb($row['tCnt']);
		$row['cnt']=count($mm);
		foreach($mm as & $v){
		    $v['rukuCode']=$row['rukuCode'];
		    $v['songhuoCode']=$row['songhuoCode'];
		    $v['rukuDate']=$row['rukuDate'];
		    $v['compName']=$row['Supplier']['compName'];
		    $v['zhidanRenName']=$row['zhidanRenName'];
		    $v['yanshouRenName']=$row['yanshouRenName'];
		    $v['shenheRenName']=$row['shenheRenName'];
		    $v['jingshouRenName']=$row['jingshouRenName'];
		    $v['tRmb']=$row['tRmb'];
		    $v['cnt']=$row['cnt'];
		    $v['tCnt']=$row['tCnt'];
		    $v['title']=FLEA::getAppInf('compName');

		}
		//dump($mm);exit;
		//dump($row);exit;
		//dump($kk);exit;
		//dump($mm);
		echo json_encode($mm);exit;
		/*$smarty = & $this->_getView();
		$smarty->assign("obj",$mm);
		$smarty->display('Cangku/RukuPrintDirectly.tpl');*/
	}
	//操作日志查看
	function actionLog(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d')
		));
		$str="select * from cangku_log where 1";
		if($arr['dateFrom']!='')$str.=" and handleDate>='$arr[dateFrom]'";
		if($arr['dateTo']!='')$str.=" and handleDate<='$arr[dateTo]'";
		if($_GET['kind']!='')$str.=" and kind='{$_GET['kind']}'";
		$pager = & new TMIS_Pager($str);
		$rowset =$pager->findAll();

		$arr_field_info = array(
			'ip'=>'ip地址|left',
			'userName'=>'用户名|left',
			'handleDate'=>'操作日期|left',
			'memo'=>'备注|left'
		);
		$smarty = & $this->_getView();
		$smarty->assign('title',$_GET['kind']==0?'出入库日志':'上下限修改日志');
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display('TableList2.tpl');
	}
	function actionSaveChukuDanjia() {
		$sql = "update cangku_kucun set jqDanjia='{$_GET['danjia']}' where wareId='{$_GET['wareId']}'";
		mysql_query($sql);
		js_alert('修改成功!','window.opener=null;window.close()');
		//exit;
	}
}
?>