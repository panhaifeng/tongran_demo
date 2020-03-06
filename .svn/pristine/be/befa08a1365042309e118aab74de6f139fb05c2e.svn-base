<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_VatGxPrice extends TMIS_Controller {
	var $_modelExample;
	var $funcId = 153;
	function Controller_JiChu_VatGxPrice() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_RsPrice');
	}

	function actionRight() {
        $this->authCheck($this->funcId);
	   	FLEA::loadClass('TMIS_Pager');
	   	$arrGet=TMIS_Pager::getParamArray(
		   array('key'=>'')
		);
	   	if($arrGet['key']!='') $condition="gxName like %'".$arrGet['key']."%'";
	   	$arr=$this->_modelExample->findAll($condition);
       	foreach($arr as & $v){
		   $v['_edit'] =" |".$this->getEditHtml($v['id']);
		   $v['_edit'].=" |".$this->getRemoveHtml($v['id']);
		}
	   	$arr_field_info=array(
		   'id'=>'系统编号',
		   'gxName'=>'工序名称',
		   // 'price'=>'价格',
		   'kind'=>'类型',
	       '_edit'=>'操作'
	   	);
       	$smarty=& $this-> _getView();//add_display
	   	$smarty->assign('arr_field_value',$arr);
       	$smarty->assign('arr_field_info',$arr_field_info);
	   	//$smarty->assign('add_display','none');
	   	$smarty->display('TableList.tpl');
	}

	function actionGetware() {
      	$arr=$this->_modelExample->findAll(array('gongyiId'=>$_GET['id']));
	   	$arr=array_group_by($arr,'classId');
	   	//dump($arr);exit;
  	 	$smarty = & $this-> _getView();
  	 	$smarty->assign('aRow',$arr);
 	  	$smarty->assign('title','方案名称：<b style="color:red;">'.$_GET['name'].'</b>');
 	 	$smarty->assign('gongyiId',$_GET['id']);
	   	$smarty->display('JiChu/GongyiEdit.tpl');
	}
	function actionRemove() {
		//dump($_GET);exit;
		$this->_modelExample->removeByPkv($_GET['id']);
		js_alert('','',$this->_url('right'));
	}
	function actionRemove2Ware(){
		$this->_modelExample->removeByPkv($_GET['id']);
		js_alert('','history.go(-1)');
	}
	function actionEdit(){
		$arr=$this->_modelExample->find(array(id=>$_GET['id']));
		$this->_edit($arr);
	}
	function _edit($arr) {
	   $smarty= & $this->_getView();
	   $smarty->assign('aRow',$arr);
	   $smarty->display('JiChu/GxPrice.tpl');
	}
    function actionSaveIndex() {
		$arr=$_POST;
		$arr['kind'] = $arr['kind']?$arr['kind']:' ';
		//dump($arr);exit;
        $this->_modelExample->save($arr);
		//exit;
		js_alert('','',$this->_url('right'));
    }
	function actionSave() {
        //dump($_POST);exit;
		$arr=$_POST;


		//前处理
		foreach($arr['wareId'] as $key=>$v){
			if(trim($v)!=''&&$arr['ifRemove'][$key]==0){
			    $rowset[]=array(
					'id'=>$arr['id'][$key],
					'wareId'=>$v,
					'classId'=>'1',
					'gongyiId'=>$arr['gongyiId'][$key],
					'unitKg'=>$arr['unitKg'][$key],
					'unit'=>$arr['unit'][$key],
					'tmp'=>$arr['tmp'][$key],
					'timeRs'=>$arr['tmpRs'][$key],
					'ifRemove'=>$arr['ifRemove'][$key],
					);


			}
			else{
				continue;
			}
		}
		//染色
		foreach($arr['wareId2'] as $key=>$v){
			if(trim($v)!=''&&$arr['ifRemove'][$key]==0){
			    $rowset[]=array(
					'id'=>$arr['id2'][$key],
					'wareId'=>$v,
					'classId'=>'2',
					'gongyiId'=>$arr['gongyiId2'][$key],
					'unitKg'=>$arr['unitKg2'][$key],
					'unit'=>$arr['unit2'][$key],
					'tmp'=>$arr['tmp2'][$key],
					'timeRs'=>$arr['tmpRs2'][$key],
					'ifRemove'=>$arr['ifRemove'][$key],
					);


			}
			else{
				continue;
			}
		}
		//后处理
		foreach($arr['wareId3'] as $key=>$v){
			if(trim($v)!=''&&$arr['ifRemove'][$key]==0){
			    $rowset[]=array(
					'id'=>$arr['id3'][$key],
					'wareId'=>$v,
					'classId'=>'3',
					'gongyiId'=>$arr['gongyiId3'][$key],
					'unitKg'=>$arr['unitKg3'][$key],
					'unit'=>$arr['unit3'][$key],
					'tmp'=>$arr['tmp3'][$key],
					'timeRs'=>$arr['tmpRs3'][$key],
					'ifRemove'=>$arr['ifRemove'][$key],
					);


			}
			else{
				continue;
			}
		}
		//dump($rowset);exit;
		$this->_modelExample->saveRowset($rowset);
        js_alert('','',$this->_url('right'));
	}


}