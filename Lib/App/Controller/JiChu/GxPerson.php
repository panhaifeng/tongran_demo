<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_GxPerson extends TMIS_Controller {
	var $_modelExample;
	var $funcId = 153;
	function Controller_JiChu_GxPerson() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_GxPerson');
		$this->bgKind = array(
			'st'	=>'松筒',
			'zcl'	=>'装出笼',
			'hs'	=>'烘纱',
			'rs'	=>'染色',
			'hd'	=>'紧筒',
			'db'	=>'打包',
			'ts'	=>'脱水',
		);
	}

	function actionRight() {
        // $this->authCheck($this->funcId);
	   	FLEA::loadClass('TMIS_Pager');
	   	$arrGet=TMIS_Pager::getParamArray(
		   array('key'=>'')
		);
	   	if($arrGet['key']!='') $condition="perName like %'".$arrGet['key']."%'";
	   	$arr=$this->_modelExample->findAll($condition);
	   	$banci = array(
	   		'1'=>'早班',
	   		'2'=>'晚班',
   		);
       	foreach($arr as & $v){
		   $v['_edit'] =" |".$this->getEditHtml($v['id']);
		   $v['_edit'].=" |".$this->getRemoveHtml($v['id']);
		   $v['kindName'] = isset($this->bgKind[$v['type']])?$this->bgKind[$v['type']]:'';
		   $v['banciName'] = $banci[$v['banci']];
		}
	   	$arr_field_info=array(
		   'id'=>'系统编号',
		   'perName'=>'员工名称',
		   'workerCode'=>'工号',
		   'kindName'=>'类型',
		   'banciName'=>'班次',
	       '_edit'=>'操作'
	   	);
       	$smarty=& $this-> _getView();//add_display
	   	$smarty->assign('arr_field_value',$arr);
       	$smarty->assign('arr_field_info',$arr_field_info);
	   	//$smarty->assign('add_display','none');
	   	$smarty->display('TableList.tpl');
	}

	function actionRemove() {
		//dump($_GET);exit;
		$this->_modelExample->removeByPkv($_GET['id']);
		js_alert('','',$this->_url('right'));
	}
	
	function actionEdit(){
		$arr=$this->_modelExample->find(array(id=>$_GET['id']));
		$this->_edit($arr);
	}
	function _edit($arr) {
	   $smarty= & $this->_getView();
	   $smarty->assign('aRow',$arr);
	   $smarty->display('JiChu/GxPerson.tpl');
	}
    function actionSaveIndex() {
		$arr=$_POST;
		if ($_POST['workerCode']) {
			if($_POST['id']!=''){
				$sql = "select * from jichu_gxperson where id='{$_POST['id']}'";
				$comp = $this->_modelExample->findBySql($sql);
				if($comp[0]['workerCode']!=$_POST['workerCode']){
					$sql = "select * from jichu_gxperson where workerCode = '{$_POST['workerCode']}' and type='{$_POST['type']}'";
					$comp2=$this->_modelExample->findBySql($sql);
					if(count($comp2)>0){
						js_alert('已存在该员工编号与对应的工序','',url("Jichu_Gxperson","right"));exit;
					}
				}else if($comp[0]['workerCode']==$_POST['workerCode']&&$comp[0]['type']!=$_POST['type']){
					$sql = "select * from jichu_gxperson where workerCode = '{$_POST['workerCode']}' and type='{$_POST['type']}'";
					$comp3 = $this->_modelExample->findBySql($sql);
					if(count($comp3)>0){
		                js_alert('已存在该员工编号与对应的工序','',url("Jichu_Gxperson","right"));exit;	
					}
				}
			}else{
				$sql = "select * from jichu_gxperson where workerCode = '{$_POST['workerCode']}' and type='{$_POST['type']}'";
				$comp = $this->_modelExample->findBySql($sql);
				if(count($comp)>0){
					js_alert('已存在该员工编号与对应的工序,请重新输入！','',url("Jichu_Gxperson","add"));exit;
				}
			}
			// if ($_POST['id']!='') {//判断为修改(修改时则判断编码是否修改过 修改过则判断是否重复)
			// 	$sql = "SELECT * FROM jichu_gxperson where id = '{$_POST['id']}'";
			// 	$comp = $this->_modelExample->findBySql($sql);
			// 	if ($comp[0]['workerCode']!=$_POST['workerCode']) {
			// 		//判断编号是否重复
			// 		$sql = "SELECT * FROM jichu_gxperson where workerCode = '{$_POST['workerCode']}'";
			// 		$comp2 = $this->_modelExample->findBySql($sql);
			// 		if (count($comp2)>0) {//当存在数据则提示
			// 			js_alert('已存在该编码，请重新输入！','',url("Jichu_Gxperson","right"));
			// 			exit();
			// 		}
			// 	}
			// }else{
			// 	//判断编号是否重复
			// 	$sql = "SELECT * FROM jichu_gxperson where workerCode = '{$_POST['workerCode']}'";
			// 	$comp = $this->_modelExample->findBySql($sql);
			// 	if (count($comp)>0) {//当存在数据则提示
			// 		js_alert('已存在该编码，请重新输入！','',url("Jichu_Gxperson","add"));
			// 		exit();
			// 	}
			// }
		}else{
			js_alert('编码为空，保存失败！','',url("Jichu_Gxperson","add"));
		}
		//dump($arr);exit;
        $this->_modelExample->save($arr);
		js_alert('','',$this->_url('right'));
    }

}