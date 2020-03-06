<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :zcc
*  FName  :RuKuBc.php
*  Time   :2014/08/30 09:18:48
*  Remark :本厂采购入库
\*********************************************************************/
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_RuKuBc extends Tmis_Controller {
	var $_modelRuku, $_modelRukuPeisha;
	var $funcId, $readFuncId, $addFuncId, $editFuncId, $delFuncId;

	function Controller_CangKu_RuKuBc() {
		$this->title = '本厂采购入库';
		$this->_modelRuku = & FLEA::getSingleton('Model_CangKu_RuKu');
		$this->_modelRukuPeisha = & FLEA::getSingleton('Model_CangKu_RuKu');

	}
	/**
	 * ps ：新增方法
	 * Time：2017/08/31 16:20:30
	 * @author zcc
	*/
	function actionAdd(){
        if($arr['ruKuNum']=='') {
			$arr['ruKuNum'] = $this->_modelRukuPeisha->getNewRukuNum();
		}
		// dump($arr);exit();
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
        $smarty->assign('aRow',$arr);
		$smarty->display('CangKu/RukuEditBc.tpl');
	}
	/**
	 * ps ：修改界面
	 * Time：2017/08/31 16:20:30
	 * @author zcc
	*/	
	function actionEdit(){
		$arr=$this->_modelRuku->find($_GET['id']);
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$arr['supplierId'] = $arr['supplierId2'];
		if(count($arr['Wares'])>0) foreach($arr['Wares'] as &$v){
			$rowWare = $mWare->findByField('id',$v['wareId']);
			$v['wareName'] = $rowWare['wareName'];
			$v['guige'] = $rowWare['guige'];
			$v['danwei'] = $rowWare['danwei'];
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
        $smarty->assign('aRow',$arr);
		$smarty->display('CangKu/RukuEditBc.tpl');
	}
	/**
	 * ps ：查询
	 * Time：2017/08/31 16:20:30
	 * @author zcc
	*/	
	function actionRight(){
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom'	=> date("Y-m-d",strtotime('-1 month')),
			'dateTo'	=> date("Y-m-d"),
			'supplierIdPs'	=> '',
			//'wareId'=>0,
			'wareName'=>'',
			'chandi'=>'',
			'pihao' =>'',
		));

		$thisModel = $this->_modelRukuPeisha;
		$modelName = "Model_JiChu_Client";

		$sql = "SELECT x.id as ruKuId,y.id as ruku2wareId,x.ruKuNum,x.ruKuDate,x.songhuoCode,
			y.cnt,y.danjia,y.chandi,s.compName,z.wareName,z.guige,z.unit,y.pihao
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId
			left join jichu_supplier s on s.id = x.supplierId2
			left join jichu_ware z on y.wareId=z.id 
			where 1  and x.kind = 1 and x.isTuiku = 0";
		if ($arrGet['date'] !='') $sql .= " and x.ruKuDate = '$arrGet[date]'";
		else $sql .= " and x.ruKuDate >= '$arrGet[dateFrom]' and x.ruKuDate<='$arrGet[dateTo]'";
		if ($arrGet['supplierIdPs'] >0) $sql .= " and x.supplierId2 = $arrGet[supplierIdPs]";
		if ($arrGet['wareId']>0) {
			$sql.=" and y.wareId='{$arrGet['wareId']}'";
		}
		if ($arrGet['wareName']) {
			$sql.=" and z.wareName like '%{$arrGet['wareName']}%'";
		}
		if ($arrGet['chandi']) {
			$sql.=" and y.chandi like '%{$arrGet['chandi']}%'";
		}
		if ($arrGet['pihao']) {
			$sql.=" and y.pihao like '%{$arrGet['pihao']}%'";
		}
		$sql .= " order by ruKuId desc";
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		$ret=$this->_modelRuku->findBySql($sql);//总计
		if (count($rowset)>0) foreach($rowset as & $v) {
			if($v['cnt']<0) {
				$v['_bgColor'] = 'red';
				$v['cntTuiku']=abs($v['cnt']);
				$v['cnt']='';
			}
		}
		$heji = $this->getHeji($rowset,array('cnt','cntTuiku'),'ruKuNum');
		$zongji=$this->getHeji($ret, array('cnt','cntTuiku'),'ruKuNum');
		$zongji['ruKuNum']='<b>总计</b>';
		if (count($rowset)>0) foreach($rowset as & $v) {
			$v['_edit'] = "<a href='".$this->_url('edit',array('id'=>$v['ruKuId']))."'>修改</a>  |  <a href='".$this->_url('removeWare',array(
				'id' =>$v['ruku2wareId'],
				'ruKuId' => $v['ruKuId'],
			))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>  |  <a href='".$this->_url('remove',array(
				'id'=>$v['ruKuId']
			))."' onclick='return confirm(\"您确认要整单删除吗？\");'>整单删除</a>";
		}
		$rowset[] = $heji;
		$rowset[] = $zongji;
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			'ruKuNum'	=>'单号',
			'ruKuDate'	=>'日期',
			'songhuoCode'=>'送货单号',
			'compName'	=>'供应商',
			'wareName'	=>'货品名称',
			'guige'		=>'规格',
			'pihao'     =>'批号',
			'chandi'	=>'产地',
			'cnt'		=>'入库数量',
			'cntTuiku'	=>'退库数量',
			'_edit'		=>'操作',
		);

		$smarty->assign('title','本厂采购入库');
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_condition',$arrGet);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps ：
	 * Time：2017/08/31 16:20:30
	 * @author zcc
	*/	
	function actionSave(){
		$count=count($this->_modelRukuPeisha->findAll(array('rukuNum'=>$_POST['rukuNum'])));
		if($_POST['rukuId']==''){if($count>0) js_alert('单号已存在!','history.go(-1)');}
		for ($i=0;$i<count($_POST['cnt']);$i++){
			if(empty($_POST['wareId'][$i]) || empty($_POST['cnt'][$i])) continue;
			$arr[] = array(
				'id'		=> $_POST['id2'][$i],
                'ruKuId'    => $_POST['rukuId'][$i],
				'wareId'	=> $_POST['wareId'][$i],
				'cnt'		=> $_POST['cnt'][$i],
				'pihao'     => $_POST['pihao'][$i],
                'chandi'    => $_POST['chandi'][$i],
				'danJia'	=> $_POST['danJia'][$i],
                'cntJian'   => $_POST['cntJian'][$i],
				'memo'		=> $_POST['memo'][$i],
				'ifRemove'	=> $_POST['ifRemove'][$i]
			);
		}
        if($arr['id']==null) unset($arr['id']);
		$row=array(
				'id'			=> $_POST['id'],
				'ruKuNum'		=> $_POST['ruKuNum'],
				'songhuoCode'	=> $_POST['songhuoCode'],
			    'ruKuDate'		=> empty($_POST['ruKuDate'])?date("Y-m-d"):$_POST['ruKuDate'],
				'supplierId2'	=> $_POST['supplierId'],
				'memo'			=> $_POST['memo'],
				'kind' 			=> '1',//kind 为1 则为本厂采购的数据
				'Wares'			=> $arr
		);
        // dump($row);exit;
       	$return = $this->_modelRukuPeisha->save($row);

		//如果是修改则直接取POST中的ID，如果是新增，就直接取save的返回值。
		if ($_POST['rukuId'] == '') $rukuId = $return;
		else $rukuId = $_POST['rukuId'];

		//echo($rukuId); exit;
		if($rukuId) redirect($this->_url('Right'));
		// if($rukuId) redirect($this->_url('Print',array('id'=>$rukuId)));
		else die('保存失败!');
	}
	/**
	 * ps ：本厂收发存中入库明细
	 * Time：2017/09/04 10:31:56
	 * @author zcc
	*/
	function actionDetailRuku(){
		// dump($_GET);exit();
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
		));
		$thisModel = $this->_modelRukuPeisha;
		$modelName = "Model_JiChu_Client";

		$str = "select
				x.id as ruKuId,
				x2.id as ruku2wareId,
				x.ruKuNum,
				x.songhuoCode,
				x.ruKuDate,
				x2.cnt,
				x2.pihao,
				x2.chandi,
				x2.danJia,
				z.wareName,
				z.guige,
				z.unit 
				from cangku_ruku x
				left join cangku_ruku2ware x2 on x2.rukuId = x.id 
				left join jichu_ware z on x2.wareId=z.id 
				where 1 and x.isTuiku = 0 and x.kind = '1'";
		if ($_GET['date'] !='') $str .= " and ruKuDate = '$_GET[date]'";
		else $str .= " and x.ruKuDate >= '$_GET[dateFrom]' and x.ruKuDate<='$_GET[dateTo]'";
		if($_GET['wareId']>0) $str .= " and x2.wareId='$_GET[wareId]'";
		$str .= " order by ruKuId desc";
		// dump($str);exit();
		$pager =& new TMIS_Pager($str);
		$rowset =$pager->findAllBySql($str);
		if (count($rowset)>0) foreach($rowset as & $v) {
			if($v['cnt']<0) {
				$v['_bgColor'] = 'red';
				$v['cntTuiku']=abs($v['cnt']);
				$v['cnt']='';
			}
		}
		$heji = $this->getHeji($rowset,array('cnt','cntTuiku'),'ruKuNum');
		$rowset[] = $heji;
		$smarty = & $this->_getView();
		$arrFieldInfo = array(
			'ruKuNum'	=>'单号',
			'ruKuDate'	=>'日期',
			'songhuoCode'=>'送货单号',
			'guige'		=>'规格',
			'pihao'		=>'批号',	
			'chandi'	=>'产地',
			'cnt'		=>'入库数量',
			// 'cntTuiku'	=>'退库数量',
		);

		$smarty->assign('title','坯纱入库登记');
        $smarty->assign('nav_display','none');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
		$smarty->display('TableList.tpl');
	}
	#删除
	function actionRemove() {
		$pk = $_GET['id'];
		$this->_modelRukuPeisha->removeByPkv($pk);
		redirect($this->_url('right'));
	}

	function actionRemoveWare() {
		$modelRuku2Wares = FLEA::getSingleton('Model_CangKu_RuKu2Ware');
		$modelRuku2Wares->removeByPkv($_GET[id]);
		redirect($this->_url('right'));
	}
}