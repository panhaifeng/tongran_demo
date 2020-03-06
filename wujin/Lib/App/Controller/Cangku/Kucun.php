<?php
FLEA::loadClass('TMIS_Controller');
////////////////////////////////////////控制器名称
class Controller_Cangku_Kucun extends Tmis_Controller {
	var $_modelExample;
	function __construct() {
	////////////////////////////////默认model
		$this->_modelExample = & FLEA::getSingleton('Model_Cangku_Kucun');
		$this->_mRuku2ware = & FLEA::getSingleton('Model_Cangku_Ruku2Ware');
	}

	function actionRight() {
	////////////////////////////////标题
		$title = $_GET['update']==0?'库存查询':'库存上下限修改';
		///////////////////////////////模板文件
		if($_GET['export']==1) {
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
		$arr_field_info = array(
			'wareCode'=>'物料编码|left',
			'wareName'=>'品名|left',
			'guige'=>'规格|left',
			'unit'=>'单位|left',
			'cnt'=>'库存|right',
			'cntMin'=>'库存下限|right',
			'cntMax'=>'库存上限|right',
			'cntRequire'=>'采购需求|right',
			'cntOverflow'=>'库存溢出|right'
		);
		if($_GET['update']==1){
		    $arr_field_info['edit']='操作';
		}
		///////////////////////////////搜索条件
		$arrCon = array(
			'key'=>'',
			//'kind'=>0
		);
		///////////////////////////////模块定义
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray($arrCon);

		$str="select * from jichu_ware where leftId+1=rightId";
		if($arr['key']!='') $str.=" and(wareCode like '%$arr[key]%' or wareName like '%$arr[key]%' or guige like '%$arr[key]%')";
		/*if($arr['kind']==1){
		    $str.=" and x.cnt>y.cntMax";
		}elseif($arr['kind']==2){
		    $str.=" and x.cnt<y.cntMin";
		}elseif($arr['kind']==0){
		    $str.=" and x.cnt>=y.cntMin and x.cnt<=y.cntMax";
		}*/
		$str.=" order by id desc";
		//echo $str;
		//$pager =& new TMIS_Pager($this->_modelExample,$condition);
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAll();
		//dump($rowset);exit;
		//dump($_SESSION);
		$mWare = & FLEA::getSingleton('Model_Jichu_Ware');
		if(count($rowset)>0) foreach($rowset as & $v) {
			//$v['guige'] = $v['guige'];
			$arrK=$mWare->getKucun($v['id']);
			$v['cnt']=$arrK['cnt'];
			if($v['cntMin']>$v['cnt']) {
				$v['cntRequire'] = $v['cntMin'] - $v['cnt'];
				$v['_bgColor'] = 'pink';
			} elseif($v['cntMax']<$v['cnt']) {
				$v['cntOverflow'] = $v['cnt'] - $v['cntMax'];
				$v['_bgColor'] = 'lightblue';
			}
			/*if($_GET['update']==1){
			    $this->makeEditable($v,'cntMin','','AjaxEdit1');
			    $this->makeEditable($v,'cntMax','','AjaxEdit1');
			}*/
			if($_GET['update']==1)$v['edit']="<a href='".$this->_url('SetLimit',array('id'=>$v['id'],'TB_iframe'=>1))."' title='库存上下限设置' class='thickbox'>上下限修改</a>";
		///////////////////////////////
		//$this->makeEditable($v,'memoCode');
		//$v['_edit'] = $this->getEditHtml($v['id']) . ' | ' . $this->getRemoveHtml($v['id']);

		}
		$note='<font color=red>红色为库存不足,蓝色的为库存溢出的。</font>';
		//dump($rowset);
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);

		/*///////////////grid,thickbox,///////////////*/
		$mm="<input type='button' value=' 导 出 ' onclick=\"window.location.href='".$this->_url('Right',array(
			'export'=>1,
			'dateFrom'=>$arr['dateFrom'],
			'dateTo'=>$arr['dateTo']
			))."'\" />";
		$mm.="<input type='button' value=' 打 印 ' onclick=\"window.location.href='".$this->_url('Right',array(
			'print'=>1
			))."'\" />";
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)).$mm.$note);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','grid','thickbox')));
		$smarty->assign('add_display','none');
		$smarty->display($tpl);
	}
	
	function actionInit(){
		$tpl = 'Cangku/InitList.tpl';
		//获得第一级节点
		$ret = array();
		//$ret = $this->getAllNode(0,$ret);
		$mWare = & FLEA::getSingleton("Model_Jichu_Ware");
		$ret = $mWare->getTopNode();
		//取得所有的组
		$smarty = & $this->_getView();
		$smarty->assign('title','库存初始化');
		$smarty->assign('data',json_encode($ret));
		//dump($ret);exit;
		$smarty->display($tpl);
		exit;
	}
	function actionInitRight(){
		$title = '库存初始化';
		///////////////////////////////模板文件
		//$tpl = 'TableList2.tpl';
		$tpl = 'TableClear.tpl';
		///////////////////////////////表头
		$arr_field_info = array(
			'wareCode'=>'物料编码|left',
			'wareName'=>'品名|left',
			'guige'=>'规格|left',
			'unit'=>'单位|left',
			'initCnt'=>'初始库存|right',
			'initMoney'=>'初始金额|right',
			//'_edit'=>'操作'
		);

		///////////////////////////////模块定义

		/************构造condition**********/
		$parentId = $_GET['parentId'] +0;
		$sql = "select x.*,y.initCnt,y.initMoney from jichu_ware x left join cangku_kucun y on x.id=y.wareId where x.isDel=0 and x.parentId = '{$parentId}' order by x.wareCode";
		if($parentId>0) {
			$mWare = & FLEA::getSingleton("Model_Jichu_Ware");
			$ware = $mWare->find(array('id'=>$parentId));
			if($ware['leftId']+1==$ware['rightId']) {
				$sql = "select x.*,y.initCnt,y.initMoney from jichu_ware x
					left join cangku_kucun y on x.id=y.wareId
					where x.isDel=0 and x.id = '{$parentId}' order by wareCode";
			}
		}
		//echo $sql;
		$rowset = $this->_modelExample->findBySql($sql);
		//dump($rowset);exit;
		if(count($rowset)>0) foreach($rowset as & $v) {
			//dump($v);//exit;
			//dump($v['leftId']);dump($v['rightId']);
			//得到当前类下的所有子节点的初始金额汇总
				$sql = "select sum(x.initMoney) as initMoney,sum(x.initCnt) as initCnt
				from cangku_kucun x
				inner join jichu_ware y on x.wareId=y.id
				where y.isDel=0 and y.leftId>='{$v['leftId']}' and y.rightId<='{$v['rightId']}'";
				//if($v['wareId']==1700) {echo $sql;exit;}
				//echo $sql.'<br>';
				$r = $this->_modelExample->findBySql($sql);
				//dump($r);
				$v['initMoney']  = $r[0]['initMoney'];
				//$v['initCnt']  = $r[0]['initCnt'];

				///////////////////////////////
				if($v['leftId']+1==$v['rightId']) {
					//$v['initCnt']  = $r[0]['initCnt'];
					/*if($this->_canInit()) $v['_edit']='<a href="javascript:void(0)" onclick="window.showModalDialog(\''.$this->_url('InitEdit',array(
							'wareId'=>$v['id']
							)).'\',window,\'scroll:no\')">修改</a>';*/
					$this->makeEditable($v,'initCnt','int');
					$this->makeEditable($v,'initMoney','money');
				}
			//$v['_edit'] = $this->getEditHtml($v['id']) . ' | ' . $this->getRemoveHtml($v['id']);

			}

		$rowset[] = $this->getHeji($rowset,array('initCnt','initMoney'),'wareCode');
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);

		/*///////////////grid,thickbox,///////////////*/
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('grid')));
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display($tpl);
	}
	function actionAjaxEdit() {
		$row['wareId'] = $_GET['id'];
		$row[$_GET['fieldName']] = $_GET['value'];
		$sql = "select id,count(*) cnt from cangku_kucun where wareId='{$_GET['id']}' group by wareId";
		//echo $sql;exit;
		$re = mysql_fetch_assoc(mysql_query($sql));
		if ($re['cnt']>0) {
			$row['id'] = $re['id'];
		}
		//dump($row);exit;

		if ($this->_modelExample->save($row)) {
			$this->_mRuku2ware->_changeJqDanjia($row);
			echo "{successful:true,msg:'成功!'}";
		} else {
			echo "{successful:false,msg:'出错!'}";
		}
		exit;
	}
	function _canInit() {
		return true;
	}
	function _edit($Arr){

		$smarty=& $this->_getView();
		$smarty->assign('title','库存初始化');
		$smarty->assign('aRow',$Arr);
		$smarty->display('Cangku/KucunInit.tpl');
	}
	function actionEdit(){
		$row=$this->_modelExample->find(array('id'=>$_GET['id']));
		//dump($row);
		$this->_edit($row);
	}
	function actionSave(){
		//dump($_POST);exit;
		if($_POST['id']==''){
			$str="select * from cangku_kucun where wareId='{$_POST['wareId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			if($re){
				js_alert('该物料已经初始化!','window.history.go(-1)');
				exit;
			}
		}
		$arr=array(
			'id'=>$_POST['id'],
			'wareId'=>$_POST['wareId'],
			'initCnt'=>$_POST['initCnt']
		);
		$this->_modelExample->save($arr);
		redirect($this->_url('init'));
	}
	function actionRemove(){
		$this->_modelExample->RemoveByPkv($_GET['id']);
		redirect($this->_url('Init'));
	}
	#收发存月报表
	function actionMonth(){
		if($_GET['export']==1) {
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment;filename=test.xls");
			header("Content-Transfer-Encoding: binary");
			$tpl = 'Export2Excel.tpl';
		}else{
			if($_GET['print']==1){
				$tpl = 'Print1.tpl';
			}else{
				$tpl = 'TableList2.tpl';
			}
		}
		FLEA::loadClass('TMIS_Pager');
		$arr=& TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'key'=>''
		));
		$str="select * from jichu_ware where parentId>=0 and leftId+1=rightId and isDel=0";
		if($arr['key']!='')$str.=" and(wareName like '%{$arr['key']}%' or wareCode like '%{$arr['key']}%' or guige like '%{$arr['key']}%')";
		//echo $str;
		$pager=& new TMIS_Pager($str);
		$rowset=$pager->findAll();
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			$row[]=$re;
		}
		//dump($row);
		if(count($row)>0)foreach($row as & $v){
			#取得期初
			$str1="select sum(x.cnt) as cnt,sum(x.money) as money from cangku_ruku2ware x
				left join cangku_ruku y on y.id=x.rukuId
				where x.wareId='{$v['id']}'
				and y.rukuDate<'{$arr['dateFrom']}'
			";
			$re1=mysql_fetch_assoc(mysql_query($str1));
			$str2="select sum(x.cnt) as cnt,sum(x.money) as money from cangku_chuku2ware x
				left join cangku_chuku y on y.id=x.chukuId
				where x.wareId='{$v['id']}'
				and y.chukuDate<'{$arr['dateFrom']}'
			";
			$re2=mysql_fetch_assoc(mysql_query($str2));
			$str3="select * from cangku_kucun where wareId='{$v['id']}'";
			//echo $str3;
			$re3=mysql_fetch_assoc(mysql_query($str3));
			$v['cntInit']=$re3['initCnt']+$re1['cnt']-$re2['cnt'];
			$v['moneyInit']=$re3['initMoney']+$re1['money']-$re2['money'];
			#取得入库数
			$str="select sum(x.cnt) as cnt,sum(x.money) as money from cangku_ruku2ware x
				left join cangku_ruku y on y.id=x.rukuId
				where x.wareId='{$v['id']}'
				and y.rukuDate>='{$arr['dateFrom']}'
				and y.rukuDate<='{$arr['dateTo']}'
			";
			//echo $str.'<br>';//exit;
			$re=mysql_fetch_assoc(mysql_query($str));
			$v['cntRuku']=$re['cnt'];
			$v['moneyRuku']=$re['money'];
			#取得出库数
			$str="select sum(x.cnt) as cnt,sum(x.money) as money from cangku_chuku2ware x
				left join cangku_chuku y on y.id=x.chukuId
				where x.wareId='{$v['id']}'
				and y.chukuDate>='{$arr['dateFrom']}'
				and y.chukuDate<='{$arr['dateTo']}'
			";
			//echo $str;exit;
			$re=mysql_fetch_assoc(mysql_query($str));
			$v['cntChuku']=$re['cnt'];
			$v['moneyChuku']=$re['money'];
			#取得库存数
			//dump($v['cntInit']);dump($v['cntRuku']);dump($v['cntChuku']);
			$v['cntKucun']=$v['cntInit']+$v['cntRuku']-$v['cntChuku'];
			$v['moneyKucun']=$v['moneyInit']+$v['moneyRuku']-$v['moneyChuku'];
		}
		//dump($row);
		#取得总计
		$zj=$this->getHeji($row,array('cntInit','moneyInit','cntRuku','moneyRuku','cntChuku','moneyChuku','cntKucun','moneyKucun'),'wareCode');
		$zj['moneyKucun']=round($zj['moneyKucun'],2);
		$zj['wareCode']='<b>总计</b>';
		if(count($rowset)>0)foreach($rowset as & $v){
			#取得期初
			$str1="select sum(x.cnt) as cnt,sum(x.money) as money from cangku_ruku2ware x
				left join cangku_ruku y on y.id=x.rukuId
				where x.wareId='{$v['id']}'
				and y.rukuDate<'{$arr['dateFrom']}'
			";
			$re1=mysql_fetch_assoc(mysql_query($str1));
			$str2="select sum(x.cnt) as cnt,sum(x.money) as money from cangku_chuku2ware x
				left join cangku_chuku y on y.id=x.chukuId
				where x.wareId='{$v['id']}'
				and y.chukuDate<'{$arr['dateFrom']}'
			";
			$re2=mysql_fetch_assoc(mysql_query($str2));
			$str3="select * from cangku_kucun where wareId='{$v['id']}'";
			//echo $str3;
			$re3=mysql_fetch_assoc(mysql_query($str3));
			$v['cntInit']=$re3['initCnt']+$re1['cnt']-$re2['cnt'];
			$v['moneyInit']=$re3['initMoney']+$re1['money']-$re2['money'];
			#取得入库数
			$str="select sum(x.cnt) as cnt,sum(x.money) as money from cangku_ruku2ware x
				left join cangku_ruku y on y.id=x.rukuId
				where x.wareId='{$v['id']}'
				and y.rukuDate>='{$arr['dateFrom']}'
				and y.rukuDate<='{$arr['dateTo']}'
			";
			//echo $str;exit;
			$re=mysql_fetch_assoc(mysql_query($str));
			$v['cntRuku']=$re['cnt'];
			$v['moneyRuku']=$re['money'];
			#取得出库数
			$str="select sum(x.cnt) as cnt,sum(x.money) as money from cangku_chuku2ware x
				left join cangku_chuku y on y.id=x.chukuId
				where x.wareId='{$v['id']}'
				and y.chukuDate>='{$arr['dateFrom']}'
				and y.chukuDate<='{$arr['dateTo']}'
			";
			//echo $str;exit;
			$re=mysql_fetch_assoc(mysql_query($str));
			$v['cntChuku']=$re['cnt'];
			$v['moneyChuku']=$re['money'];
			#取得库存数
			$v['cntKucun']=$v['cntInit']+$v['cntRuku']-$v['cntChuku'];
			$v['moneyKucun']=round($v['moneyInit']+$v['moneyRuku']-$v['moneyChuku'],2);
		}
		$heji=$this->getHeji($rowset,array('cntInit','moneyInit','cntRuku','moneyRuku','cntChuku','moneyChuku','cntKucun','moneyKucun'),'wareCode');
		$heji['moneyKucun']=round($heji['moneyKucun'],2);
		$rowset[]=$heji;
		$rowset[]=$zj;
		if(count($rowset)>0)foreach($rowset as $key=>& $v){
			$v['cntInit']=round($v['cntInit'],2);
			$v['moneyInit']=round($v['moneyInit'],2);
			$v['cntRuku']=round($v['cntRuku'],2);
			$v['moneyRuku']=round($v['moneyRuku'],2);
			$v['cntChuku']=round($v['cntChuku'],2);
			$v['moneyChuku']=round($v['moneyChuku'],2);
			$v['cntKucun']=round($v['cntKucun'],2);
			$v['moneyKucun']=round($v['moneyKucun'],2);
			if($key!=count($rowset)-1&&$key!=count($rowset)-2){
				$v['cntRuku']="<a href='".$this->_url('rukuDetail',array('wareId'=>$v['id'],'dateFrom'=>$arr['dateFrom'],'dateTo'=>$arr['dateTo'],'TB_iframe'=>1))."' class='thickbox' title='入库明细'>".$v['cntRuku']."</a>";
				$v['moneyRuku']="<a href='".$this->_url('rukuDetail',array('wareId'=>$v['id'],'dateFrom'=>$arr['dateFrom'],'dateTo'=>$arr['dateTo'],'TB_iframe'=>1))."' class='thickbox' title='入库明细'>".$v['moneyRuku']."</a>";
				$v['cntChuku']="<a href='".$this->_url('chukuDetail',array('wareId'=>$v['id'],'dateFrom'=>$arr['dateFrom'],'dateTo'=>$arr['dateTo'],'TB_iframe'=>1))."' class='thickbox' title='出库明细'>".$v['cntChuku']."</a>";
				$v['moneyChuku']="<a href='".$this->_url('chukuDetail',array('wareId'=>$v['id'],'dateFrom'=>$arr['dateFrom'],'dateTo'=>$arr['dateTo'],'TB_iframe'=>1))."' class='thickbox' title='出库明细'>".$v['moneyChuku']."</a>";
			}
		}
		$row[]=$zj;
		if(count($row)>0)foreach($row as & $v){
			$v['cntInit']=round($v['cntInit'],2);
			$v['moneyInit']=round($v['moneyInit'],2);
			$v['cntRuku']=round($v['cntRuku'],2);
			$v['moneyRuku']=round($v['moneyRuku'],2);
			$v['cntChuku']=round($v['cntChuku'],2);
			$v['moneyChuku']=round($v['moneyChuku'],2);
			$v['cntKucun']=round($v['cntKucun'],2);
			$v['moneyKucun']=round($v['moneyKucun'],2);
		}
		$arr_field_info=array(
			'wareCode'=>'物料编码',
			'wareName'=>'品名',
			'guige'=>'规格',
			'unit'=>'单位',
			'cntInit'=>'上期结余',
			'moneyInit'=>'上期结余金额',
			'cntRuku'=>'本期入库数',
			'moneyRuku'=>'本期入库金额',
			'cntChuku'=>'本期出库数',
			'moneyChuku'=>'本期出库金额',
			'cntKucun'=>'库存数',
			'moneyKucun'=>'库存金额',
		);
		$mm="<input type='button' value=' 导 出 ' onclick=\"window.location.href='".$this->_url($_GET['action'],array(
			'export'=>1
			))."'\" />";
		$mm.="<input type='button' value=' 打 印 ' onclick=\"window.location.href='".$this->_url($_GET['action'],array(
			'print'=>1
			))."'\" />";
		$smarty=& $this->_getView();
		$smarty->assign('title','收发存月报表');
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$_GET['export']!=1?$rowset:$row);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('grid','calendar','thickbox')));
		if($_GET['export']!=1)$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)).$mm);
		$smarty->display($tpl);
	}
	#入库明细
	function actionRukuDetail(){
		//dump($_GET);exit;
		FLEA::loadClass('TMIS_Pager');
		$str="select x.*,a.employName,y.rukuDate,y.rukuCode,z.wareCode,z.unit,z.guige,z.wareName,m.compName from cangku_ruku2ware x
		    left join cangku_ruku y on y.id=x.rukuId
		    left join jichu_ware z on z.id=x.wareId
		    left join jichu_supplier m on m.id=y.supplierId
			left join jichu_employ a on y.jingshouRenId=a.id
		    where y.type=0
		";
		if($_GET['dateFrom']!='')$str.=" and y.rukuDate>='$_GET[dateFrom]'";
		if($_GET['dateTo']!='')$str.=" and y.rukuDate<='$_GET[dateTo]'";
		if($_GET['wareId']!='')$str.=" and x.wareId='$_GET[wareId]'";
		$str .= " order by y.rukuCode desc";
		//echo $str;
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		if(count($rowset)>0)foreach($rowset as & $v){
			$v['cnt']=round($v['cnt'],2);
			$v['danjia']=round($v['danjia'],2);
			$v['money']=round($v['money'],2);
		}
		$heji=$this->getHeji($rowset,array('cnt','money'),'rukuDate');
		$rowset[]=$heji;
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
			'money'=>'金额|right'
		);
		$smarty=& $this->_getView();
		$smarty->assign('nav_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->display('TableList.tpl');
	}
	#出库明细
	function actionChukuDetail(){
		FLEA::loadClass('TMIS_Pager');
		$str="select x.*,y.depId,y.chukuDate,y.chukuCode,
			y.faliaoren,z.wareCode,z.unit,z.guige,z.wareName
			from cangku_chuku2ware x
		    left join cangku_chuku y on y.id=x.chukuId
		    left join jichu_ware z on z.id=x.wareId
			left join jichu_department a on a.id=y.depId
		    where y.type=0
		";
		if($_GET['dateFrom']!='')$str.=" and y.chukuDate>='$_GET[dateFrom]'";
		if($_GET['dateTo']!='')$str.=" and y.chukuDate<='$_GET[dateTo]'";
		if($_GET['wareId']!='')$str.=" and x.wareId='$_GET[wareId]'";
		$str.=" order by x.id desc";
		//echo $str;
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		if(count($rowset)>0)foreach($rowset as & $v){
			$v['cnt']=round($v['cnt'],2);
			$v['danjia']=round($v['danjia'],2);
			$v['money']=round($v['money'],2);
		}
		$heji=$this->getHeji($rowset,array('cnt','money'),'chukuDate');
		$rowset[]=$heji;
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
			'danjia'=>'单价',
			'money'=>'金额',
		);
		$arr['dateFrom']=$_GET['dateFrom'];
		$arr['dateTo']=$_GET['dateTo'];
		$arr['wareId']=$_GET['wareId'];
		$smarty=& $this->_getView();
		$smarty->assign('nav_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList.tpl');
	}
}
?>