<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_ChanliangGx extends TMIS_Controller {
	var $_modelExample;
	var $funcId = 153;
	function Controller_JiChu_ChanliangGx() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
		$this->bgKind = array(
			'1'	=>'松紧筒打包',
			'2'	=>'装出笼',
			'3'	=>'染色',
		);
	}

	function actionRight() {
        // $this->authCheck($this->funcId);
	   	FLEA::loadClass('TMIS_Pager');
	   	$arrGet=TMIS_Pager::getParamArray(
		   array('key'=>'')
		);
	   	// if($arrGet['key']!='') $condition="gongxuName like %'".$arrGet['key']."%'";
	   	// $arr=$this->_modelExample->findAll($condition);
	   	$sql ="select * from jichu_chanliang_gongxu where 1";
	   	if($arrGet['key']!=''){
	   		$sql.="and gongxuName like '%{$arrGet['key']}%' ";
	   	}
	   	$sql.= " order by type,gongxuCode asc";
	   	$arr = $this->_modelExample->findBySql($sql);
       	foreach($arr as & $v){
		   $v['_edit'] =" |".$this->getEditHtml($v['id']);
		   $v['_edit'].=" |".$this->getRemoveHtml($v['id']);
		   $v['kindName'] = isset($this->bgKind[$v['type']])?$this->bgKind[$v['type']]:'';
		}
	   	$arr_field_info=array(
		   'id'=>'系统编号',
		   'gongxuName'=>'工序名称',
		   'gongxuCode'=>'编号',
		   'kindName'=>'类型',
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
	   $smarty->assign('title','产量工序录入');
	   $smarty->display('JiChu/GxChanliang.tpl');
	}

    function actionSaveIndex() {
		$arr=$_POST;

		if ($_POST['gongxuCode']) {
			if ($_POST['id']!='') {//判断为修改(修改时则判断编码是否修改过 修改过则判断是否重复)
				$sql = "SELECT * FROM jichu_chanliang_gongxu where id = '{$_POST['id']}'";
				$comp = $this->_modelExample->findBySql($sql);
				if ($comp[0]['gongxuCode']!=$_POST['gongxuCode']) {
					//判断编号是否重复
					$sql = "SELECT * FROM jichu_chanliang_gongxu where gongxuCode = '{$_POST['gongxuCode']}' and type='{$_POST['type']}'";
					$comp2 = $this->_modelExample->findBySql($sql);
					if (count($comp2)>0) {//当存在数据则提示
						js_alert('已存在该编码，请重新输入！','',url("Jichu_ChanliangGx","right"));
						exit();
					}
				}
			}else{
				//判断编号是否重复
				$sql = "SELECT * FROM jichu_chanliang_gongxu where gongxuCode = '{$_POST['gongxuCode']}' and type='{$_POST['type']}'";
				$comp = $this->_modelExample->findBySql($sql);
				if (count($comp)>0) {//当存在数据则提示
					js_alert('已存在该编码，请重新输入！','',url("Jichu_ChanliangGx","add"));
					exit();
				}
			}
		}else{
			js_alert('编码为空，保存失败！','',url("Jichu_ChanliangGx","add"));
		}
		if(!$arr['taomian']){
			$arr['taomian'] = 0;
		}
		if(!$arr['quanbu']){
			$arr['quanbu'] = 0;
		}
		if(!$arr['fensan']){
			$arr['fensan'] = 0;
		}
		if(!$arr['huixiu']){
			$arr['huixiu'] = 0;
		}
		if(!$arr['mamianps']){
			$arr['mamianps'] = 0;
		}
		// dump($arr);exit;
        $this->_modelExample->save($arr);
		js_alert('','',$this->_url('right'));
    }

}