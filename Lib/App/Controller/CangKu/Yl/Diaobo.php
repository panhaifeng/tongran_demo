<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :zcc
*  FName  :Diaobo.php
*  Time   :2014/08/30 09:18:48
*  Remark :
\*********************************************************************/
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Yl_Diaobo extends Tmis_Controller {
	function Controller_CangKu_Yl_Diaobo() {
		$this->_modelRuku = & FLEA::getSingleton('Model_CangKu_Yl_Ruku');
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_Yl_Ruku');
		$this->_modelRuku2Ware = & FLEA::getSingleton('Model_CangKu_Yl_Ruku2Ware');
		$this->_modelChuku = & FLEA::getSingleton('Model_CangKu_Yl_Chuku');
		$this->_modelChuku2Ware = & FLEA::getSingleton('Model_CangKu_Yl_Chuku2Ware');
		// $this->_setFuncId();
	}
	function actionRight(){
		$this->authCheck(146);
		FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            dateTo=>date("Y-m-d"),
            'rhlName' =>'',
            'guige' =>'',
            'rukuDanhao'=>''
        ));
        $sql = "SELECT  x.id as rukuId,x.rukuNum,x.rukuDate,y.wareId,w.wareName,w.guige,y.cnt,x.memo
        	FROM cangku_yl_ruku x 
        	left join cangku_yl_ruku2ware y on x.id = y.rukuId
        	left join cangku_yl_chuku2ware z on z.diaoboId = y.id
        	left join jichu_ware w on w.id = y.wareId
        	where 1 and x.kind = 8 ";
        if ($arr['wareId']>0) {
            $sql.=" and y.wareId='{$arr['wareId']}'";
        }
        if ($arr['rhlName']) {
            $sql.=" and w.wareName like '%{$arr['rhlName']}%'";
        }
        if ($arr['guige']) {
            $sql.=" and w.guige like '%{$arr['guige']}%'";
        }
        if ($arr['rukuDanhao']) {
            $sql.=" and x.rukuNum like '%{$arr['rukuDanhao']}%'";
        }
        if($arr['dateFrom']!=''){
        	$sql.=" and x.rukuDate>='{$arr['dateFrom']}' and x.rukuDate<='{$arr['dateTo']}'";
        }
        $sql .= " order by x.rukuNum desc";
        $pager = & new TMIS_Pager($sql);
        $rowset =$pager->findAll();
        foreach ($rowset as &$v) {
        	$sql = "SELECT x.kuwei as rukuKuwei,y.kuwei as chukuKuwei 
        	FROM cangku_yl_ruku x 
        	left join cangku_yl_chuku y on x.id = y.dbId 
        	where x.id = {$v['rukuId']}";
        	$kuwei = $this->_modelExample->findBySql($sql);
        	if ($kuwei[0]['rukuKuwei']=='0') {$v['rukuKuwei']='染化料仓库';}
        	if ($kuwei[0]['rukuKuwei']=='1') {$v['rukuKuwei']='车间';}
        	if ($kuwei[0]['chukuKuwei']=='0') {$v['chukuKuwei']='染化料仓库';}
        	if ($kuwei[0]['chukuKuwei']=='1') {$v['chukuKuwei']='车间';}
           	$v['_edit'] = "<a href='".$this->_url('Edit',array('id'=>$v['rukuId']))."'>修改</a>"; 
           	$v['_edit'] .= "  |  <a href='".$this->_url('Remove',array(
                'id'=>$v['rukuId']
            ))."' onclick='return confirm(\"您确认要整单删除吗？\");'>删除</a>";
        }
        $heji = $this->getHeji($rowset,array('cnt'),'rukuNum');
        $rowset[] = $heji;
        $smarty = & $this->_getView();
        $arrFieldInfo = array(
            'rukuNum'   =>'调拨单号',
            'rukuDate'  =>'调拨日期',
            'wareName'  =>'染化料名称',
            'guige'     =>'规格',
            'chukuKuwei' => '调出库位',
            'rukuKuwei' => '调入库位',
            'cnt'       =>'调拨数量',
            'memo' =>'备注',
            '_edit'     =>'操作',
        );

        $smarty->assign('title','库位调拨查询');
        $smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('arr_condition',$arr);
        // $smarty->assign('add_display',none);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty->display('TableList.tpl');	
	}
	function actionAdd(){
		$this->authCheck(146);
		$arr['rukuNum'] = $this->_modelExample->getRukuNum('DB');
		$smarty = & $this->_getView();
		$smarty->assign("title","调拨登记>>录入");
		$smarty->assign("arr_field_value",$arr);
		$smarty->display('CangKu/Yl/DiaoboEdit.tpl');
	}
	function actionEdit(){
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$arr = $this->_modelRuku->find($_GET['id']);
		$arr['rukuKuwei']  = $arr['kuwei'];
		$sql = "SELECT * FROM cangku_yl_chuku x where dbId = '{$arr['id']}'";
		$chuku = $this->_modelChuku->findBySql($sql);
		$arr['chukuKuwei']  = $chuku[0]['kuwei'];
		if(isset($arr['Wares'])){
			if(count($arr['Wares'])>0) foreach($arr['Wares'] as & $v){
				$rowWare = $mWare->findByField('id',$v['wareId']);
				$v['wareName'] = $rowWare['wareName'];
				$v['guige'] = $rowWare['guige'];
				$v['unit'] = 'kg';
			}
		}
		// dump($arr);die();
		$smarty = & $this->_getView();
		$smarty->assign("title","调拨登记>>录入");
		$smarty->assign("arr_field_value",$arr);
		$smarty->display('CangKu/Yl/DiaoboEdit.tpl');
	}
	// /保存
	function actionSave() {
		// dump($_POST);die();
		if ($_POST['rukuKuwei']=='0') {
			$_POST['chukuKuwei']= '1';
		}
		if ($_POST['rukuKuwei']=='1') {
			$_POST['chukuKuwei']= '0';
		}
		// if ($_POST['rukuKuwei'] == $_POST['chukuKuwei']) {
		// 	js_alert('调入调出库位相同，无法保存！','window.history.go(-1)');
		// 	exit();
		// }
		for($i=0;$i<count($_POST['wareId']);$i++){
			if(empty($_POST['wareId'][$i])|| empty($_POST['cnt'][$i])) continue;
			$arrRu[] = array(
				'id' => $_POST['id'][$i],
				'wareId' => $_POST['wareId'][$i],
				'cnt' => $_POST['cnt'][$i],
			);
		}
		
		//保存入库
		//对于调拨保存入库的数据，没有子表信息的不予保存，否则会导致出库子表diaoboId为0的数据被删除
		if(empty($_POST['wareId'][0])|| empty($_POST['cnt'][0])){
			js_alert('没有对应信息，保存失败','window.history.go(-1)');
			exit();
		}
		$rowruku=array(
				'id'			=>$_POST['rukuId'],
				'kuwei'			=>$_POST['rukuKuwei'],
				'rukuDate'		=>$_POST['rukuDate'],
				'rukuNum'		=>$_POST['rukuNum'],
				'memo'			=>$_POST['memo'],
				'kind'			=>'8',//调拨 入库操作
				'Wares'		=> $arrRu
		);
		// dump($rowruku);die();
		$ruId=$this->_modelRuku->save($rowruku);

		$ruId=$_POST['rukuId']==''?$ruId:$_POST['rukuId'];
		$ret=$this->_modelRuku->find(array('id'=>$ruId));

		foreach ($ret['Wares'] as & $v){
			$arrChu[] = array(
					'id' => '',
					'diaoboId' =>$v['id'],
					'wareId' => $v['wareId'],
					'cnt' => $v['cnt'],
			);
		}
		//修改的时候删除出库信息 重新生成数据 
        $sql="select x.id 
            from cangku_yl_chuku x
            left join cangku_yl_chuku2ware y on x.id=y.chukuId
            where x.dbId ='{$ret['id']}'";
        $chu2pro=$this->_modelChuku->findBySql($sql);
        $this->_modelChuku->removeByPkv($chu2pro[0]['id']);
	
		//保存出库
		$rowchuku=array(
				'id'			=>'',
				'kuwei'		=>$_POST['chukuKuwei'],
				'chukuDate'		=>$_POST['rukuDate'],
				'chukuNum'		=>$_POST['rukuNum'],
				'memo'		=>$_POST['memo'],
				'kind'			=>'8',//调拨 出库操作
				// 'orderCode'			=>$_POST['orderCode'],
				'dbId' 		=> $ret['id'],
				'Wares'		=> $arrChu
		);
		$this->_modelChuku->save($rowchuku);
		js_alert(null, '', $this->_url('right'));
	}
	/**
	 * ps ：登记界面ajax删除明细
	 * Time：2017年12月8日 16:37:00
	 * @author zcc
	*/
	function actionRemoveAjax(){
        //分别删除 入库数据和出库数据
        $sql = "SELECT x.id as rukuId,y.id as chukuId
            FROM cangku_yl_ruku2ware x 
            left join cangku_yl_chuku2ware y on x.id = y.diaoboId
            where 1 and x.id = '{$_GET['id']}'";
        $ret=$this->_modelChuku->findBySql($sql);
        $this->_modelRuku2Ware->removeByPkv($ret[0]['rukuId']);
        $this->_modelChuku2Ware->removeByPkv($ret[0]['chukuId']);
        $arr = array(
            'success'=>true,
            'msg'=>'删除成功'
        );
        echo json_encode($arr);exit;
	}
	/**
	 * ps ：登记界面ajax删除明细
	 * Time：2017年12月8日 16:37:04
	 * @author zcc
	*/
	function actionRemove(){
        $sql = "SELECT x.id
            FROM cangku_yl_chuku x 
            where x.dbId = {$_GET['id']}";
        $ret=$this->_modelChuku->findBySql($sql);
        $istrue = $this->_modelChuku->removeByPkv($ret[0]['id']);//删除出库
        if ($istrue) {
            if($this->_modelRuku->removeByPkv($_GET['id'])){//删除入库
                js_alert("成功删除","",$this->_url('right'));
            }
        }else{
            js_alert('出错，不允许删除!','',$this->_url('right'));
        }
	}
}