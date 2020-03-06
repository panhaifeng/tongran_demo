<?php
FLEA::loadClass('TMIS_Controller');
////////////////////////////////////////控制器名称
class Controller_Cangku_Chuku extends Tmis_Controller {
	var $_modelExample;
	function __construct() {
		////////////////////////////////默认model
		$this->_modelExample = & FLEA::getSingleton('Model_Cangku_Chuku');
		$this->_mChuku2ware = & FLEA::getSingleton('Model_Cangku_Chuku2Ware');
		$this->_mWare = & FLEA::getSingleton('Model_JiChu_Ware');
	}

	function actionRight()	{
		////////////////////////////////标题
		$title = '出库查询';
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
			    'chukuDate'=>'出库日期',
			    'chukuCode'=>'出库单号',
			    'faliaoren'=>'发料人',
			    'Chuku.Dep.depName'=>'领用部门',
			    'wareCode'=>'物料编码',
			    'wareName'=>'品名',
			    'guige'=>'规格',
			    'unit'=>'单位',
			    'cnt'=>'数量|right',
			    //'danjia'=>'单价',
			    //'money'=>'金额',
		    );
		}else{
		    $arr_field_info = array(
			    'chukuDate'=>'出库日期|left',
			    'chukuCode'=>'出库单号|left',
			    'faliaoren'=>'发料人|left',
			    'Chuku.Dep.depName'=>'领用部门|left',
			    'wareCode'=>'物料编码|left',
			    'wareName'=>'品名|left',
			    'guige'=>'规格|left',
			    'unit'=>'单位|left',
			    'cnt'=>'数量|right',
			    //'danjia'=>'单价',
			    //'money'=>'金额',
			    '_edit'=>'操作'
		    );
		}
		///////////////////////////////搜索条件
		$arrCon = array(
			//'key'=>'',
			//'ym'=>date('Y-m')
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'depId'=>'',
			'pinGui'=>'',
			'code'=>'',
			'chukuCode'=>''
		);
		///////////////////////////////模块定义
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray($arrCon);

		/************构造condition**********/
		//正常入库
		$condition=array(
			array('Chuku.type',0)
		);
		/*if($arr['']) {
			$condition[] = array('',$arr['']);
			//$condition[] = array('','%'.$arr[''].'%','like');
		}*/

		$str="select x.*,y.depId,y.chukuDate,y.chukuCode,y.faliaoren,z.wareCode,z.unit,z.guige,z.wareName from cangku_chuku2ware x
		    left join cangku_chuku y on y.id=x.chukuId
		    left join jichu_ware z on z.id=x.wareId
			left join jichu_department a on a.id=y.depId
		    where y.type=0
		";
		if($arr['dateFrom']!='')$str.=" and y.chukuDate>='$arr[dateFrom]'";
		if($arr['dateTo']!='')$str.=" and y.chukuDate<='$arr[dateTo]'";
		if($arr['depId']!='') {
			$mDep = & FLEA::getSingleton("Model_Jichu_Department");
			$dep = $mDep->find(array('id'=>$arr['depId']));
			$str.=" and a.leftId>='{$dep['leftId']}' and a.rightId<='{$dep['rightId']}'";
		}
		if($arr['pinGui']!='')$str.=" and z.wareName like '%$arr[pinGui]%'";
		if($arr['code']!='')$str.=" and z.wareCode like '%$arr[code]%'";
		if($arr['chukuCode']!='') $str.=" and y.chukuCode like '%{$arr['chukuCode']}%'";
		$str.=" order by x.id desc";
		$row=$this->_modelExample->findBySql($str);
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		//dump($rowset[0]);//exit;
		$mDep = & FLEA::getSingleton("Model_Jichu_Department");
		if(count($rowset)>0) foreach($rowset as & $v){
			$v['chukuCode']="<a href='".$this->_url('print',array('id'=>$v['id']))."' target='_blank'>".$v['chukuCode']."</a>";
			$v['Chuku']['Dep'] = $mDep->find(array('id'=>$v['depId']));
			$v['money'] = number_format($v['danjia']*$v['cnt'],2,'.','');
			$v['cnt']=round($v['cnt'],2);
			$v['_edit'] = $this->getEditHtml($v['chukuId']).$this->getRemoveHtml(array('id'=>$v['id'],'chukuId'=>$v['chukuId']));

		}
		if(count($row)>0) foreach($row as & $v){
			$v['Chuku']['Dep'] = $mDep->find(array('id'=>$v['depId']));
			$v['money'] = number_format($v['danjia']*$v['cnt'],2,'.','');
			$v['cnt']=round($v['cnt'],2);
		}
		//dump($rowset);
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
			'print'=>1
			))."'\" />";
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)).$mm);
		$smarty-> display($tpl);
	}
	
	function actionPrint(){
		$str="select x.*,y.depId,y.chukuDate,y.chukuCode,y.faliaoren,z.wareCode,z.unit,z.guige,z.wareName from cangku_chuku2ware x
		    left join cangku_chuku y on y.id=x.chukuId
		    left join jichu_ware z on z.id=x.wareId
			left join jichu_department a on a.id=y.depId
		    where y.type=0 and x.id='{$_GET['id']}'
		";
		//$str.=" order by x.id desc";
		$rowset=$this->_modelExample->findBySql($str);
		$mDep = & FLEA::getSingleton("Model_Jichu_Department");
		if(count($rowset)>0) foreach($rowset as & $v){
			$v['Chuku']['Dep'] = $mDep->find(array('id'=>$v['depId']));
			$v['money'] = number_format($v['danjia']*$v['cnt'],2,'.','');
			$v['cnt']=round($v['cnt'],2);
		}
		$arr_field_info = array(
			    'chukuDate'=>'出库日期',
			    'chukuCode'=>'出库单号',
			    'faliaoren'=>'发料人',
			    'Chuku.Dep.depName'=>'领用部门',
			    'wareCode'=>'物料编码',
			    'wareName'=>'品名',
			    'guige'=>'规格',
			    'unit'=>'单位',
			    'cnt'=>'数量',
		 );
		$smarty = & $this->_getView();
		$smarty->assign('title', '出库单');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty-> display('Print.tpl');
	}
	function _edit($Arr) {
		///////////////////////////////标题
		$title = '领用出库';
		///////////////////////////////模板
		$tpl = 'Cangku/ChukuEdit.tpl';
		///////////////////////////////模块定义
		//dump($Arr);
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign("aRow",$Arr);

		//取得发料人
		$m = & FLEA::getSingleton('Model_Jichu_EmployKind');
		$condition = array('kind'=>'发料');
		$row=$m->findAll($condition);
		//dump($row);exit;
		$smarty->assign('faliao',$row);
		$smarty->display($tpl);
	}
	function actionAdd(){
		$arr['chukuCode']=$this->_modelExample->getNewCode();
		//dump($arr);
		$this->_edit($arr);
	}
	#修改
	function actionEdit(){
		$row=$this->_modelExample->find(array('id'=>$_GET['id']));
		if(count($row['Ware'])>0)foreach($row['Ware'] as & $v){
			$v['Ware']=$this->_mWare->find(array('id'=>$v['wareId']));
			#取得库存数
			$str="select * from cangku_kucun where wareId='{$v['wareId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			$v['cntKucun']=$re['cnt']+$v['cnt'];
		}
		$this->_edit($row);
	}
	//删除
	function actionRemove() {
		$m = & FLEA::getSingleton("Model_Cangku_Chuku2ware");
		$mChuku = & FLEA::getSingleton("Model_Cangku_Chuku");
		$m->clearLinks();

		$condition = array('chukuId'=>$_GET['chukuId']);
		$chuku2ware= $m->findAll($condition);
		//判断入库日期是否在本期内
		$chuku=$mChuku->find($_GET['chukuId']);
		/*$arrDate = $this->getBenqi();
		if($chuku['chukuDate']<$arrDate['dateFrom']||$chuku['chukuDate']>$arrDate['dateTo']){
		    js_alert('出库日期不在本期内！','window.history.go(-1)');
		}*/
		//dump($chuku);exit;
		//将操作保存到日志中
		$ip=$_SERVER['REMOTE_ADDR'];
		$userName=$_SESSION['USERNAME'];
		$handleDate=date('Y-m-d');
		$memo="出库记录中删除记录，出库单号为:".$chuku['chukuCode'];
		$str="insert into cangku_log(ip,userName,handleDate,memo) values('$ip','$userName','$handleDate','$memo')";
		mysql_query($str);
		//将出口主表中记录删除
		$this->_modelExample->removeByPkv($_GET['chukuId']);

		//修改库存表
		if($chuku2ware) {
			foreach($chuku2ware as & $v) {
				$m->changeKucun($v);
			}
		}

		//修改申请表中的记录
		$str="update cangku_shenqing set chukuId=0 where chukuId='$_GET[chukuId]'";
		mysql_query($str);
		redirect($this->_url('right'));
	}

	function actionSave() {
		//dump($_POST);exit;
		/*$arrDate = $this->getBenqi();
		if($_POST['chukuDate']<$arrDate['dateFrom']||$_POST['chukuDate']>$arrDate['dateTo']){
		    js_alert('出库日期不在本期内！','window.history.go(-1)');
		}*/
		//判断是否有出库数大于库存数的情况
		foreach($_POST['cnt'] as & $v) {
			if($v=='') continue;
			if($v>$_POST['cntKucun']) {
				js_alert('发现出库数大于库存数,禁止出库!','window.history.go(-1)');
				exit;
			}
		}
		foreach($_POST['cnt'] as $key=>& $v){
			if($v=='') continue;
			//$danjia = $this->_getJqDanjia($_POST['wareId'][$key]);
			#将金额计算出来。并保存到数据库中
			$money=$_POST['cnt'][$key]*$_POST['danjia'][$key];
			$arr[]=array(
				'id'=>$_POST['chuku2wareId'][$key],
				'wareId'=>$_POST['wareId'][$key],
				'cnt'=>$_POST['cnt'][$key],
				'danjia'=>$_POST['danjia'][$key],
				'money'=>$money
			);
		}
		if(count($arr)==0){
			js_alert('请至少输入一个物料信息!','window.history.go(-1)');
			exit;
		}
		$row=array(
			'id'=>$_POST['id'],
			'chukuCode'=>$_POST['chukuCode'],
			'chukuDate'=>$_POST['chukuDate'],
			'depId'=>$_POST['depId'],
			'faliaoren'=>$_POST['faliaoren'],
			'Ware'=>$arr
		);
		//dump($row);exit;
		//保存操作到日志中
		$ip=$_SERVER['REMOTE_ADDR'];
		$userName=$_SESSION['USERNAME'];
		$handleDate=date('Y-m-d');
		$memo="出库记录中新增出库记录，出库单号为:".$row['chukuCode'];
		$str="insert into cangku_log(ip,userName,handleDate,memo) values('$ip','$userName','$handleDate','$memo')";
		mysql_query($str);
		if($newId = $this->_modelExample->save($row)) {
			if($_POST['id']>0) $newId = $_POST['id'];
			//修改库存表中的库存数量
			foreach($row['Ware'] as & $v) {
				$v['chukuId']=$newId;
				$this->_modelExample->changeKucun($v);
			}
			js_alert('出库成功!',null,$this->_url(($_POST['id']!=''?'right':'add')));
		}
	}
	//得到某个物料本期的加权单价
	function _getJqDanjia($wareId) {
		$sql = "select * from cangku_kucun where wareId='{$wareId}'";
		$row = $this->_modelExample->findBySql($sql);
		return $row[0]['jqDanjia'];
	}
}
?>