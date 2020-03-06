<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Gongyi extends Tmis_Controller {
	var $_modelExample;
	var $mGongyi;
	var $funcId = 27;
	function Controller_JiChu_Gongyi() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Gongyi');
		$this->mGongyi = & FLEA::getSingleton('Model_JiChu_Gongyi2ware');
	}

	function actionright() {
	   FLEA::loadClass('TMIS_Pager');
	   $arrGet=TMIS_Pager::getParamArray(
		   array('key'=>'')
		);
	   if($arrGet['key']!='') $condition="gongyiName like %'".$arrGet['key']."%'";
	   $arr=$this->_modelExample->findAll($condition);
       foreach($arr as & $v){
		   $v['_edit']="<a href='".$this->_url('Getware',array('id'=>$v['id'],'name'=>$v['gongyiName']))."'>方案分配</a>";
		   $v['_edit'].=" |".$this->getEditHtml($v['id']);
		   $v['_edit'].=" |".$this->getRemoveHtml($v['id']);
		}
	   $arr_field_info=array(
		   'id'=>'系统编号',
		   'kind'=>'分类',
		   'gongyiName'=>'工艺名称',
		   'memo'=>'备注',
	       '_edit'=>'操作'
		   );
       $smarty=& $this-> _getView();//add_display
	   $smarty->assign('arr_field_value',$arr);
       $smarty->assign('arr_field_info',$arr_field_info);
	   //$smarty->assign('add_display','none');
	   $smarty->display('TableList.tpl');
	}

	function actionGetware() {
       $arr=$this->mGongyi->findAll(array('gongyiId'=>$_GET['id']),'id asc');
	   $arr=array_group_by($arr,'classId');
	   // dump($arr);die();
	   $gongyi = $this->_modelExample->find($_GET['id']);
	   // dump($gongyi);die();
	   if ($gongyi['kind']=='染色染料') {
	   		$defaultUnit = "%";
	   }
	   $smarty = & $this-> _getView();
       $smarty->assign('aRow',$arr);
	   $smarty->assign('title','方案名称：<b style="color:red;">'.$_GET['name'].'</b>');
	   $smarty->assign('gongyiId',$_GET['id']);
	   $smarty->assign('defaultUnit',$defaultUnit);
	   $smarty->display('JiChu/GongyiEdit.tpl');
	}
	function actionRemove() {
		//dump($_GET);exit;
		$this->_modelExample->removeByPkv($_GET['id']);
		js_alert('','',$this->_url('right'));
	}
	function actionRemove2Ware(){
		$this->mGongyi->removeByPkv($_GET['id']);
		js_alert('','history.go(-1)');
	}
	function actionEdit(){
		$arr=$this->_modelExample->find(array(id=>$_GET['id']));
		$this->_edit($arr);
	}
	function _edit($arr) {
	   $smarty= & $this->_getView();
	   $smarty->assign('aRow',$arr);
	   $smarty->display('JiChu/GongyiStyle.tpl');
	}
    function actionSaveIndex() {
			$arr=$_POST;

		//dump($arr);exit;
        $this->_modelExample->save($arr);
		//exit;
		js_alert('','',$this->_url('right'));
    }
	function actionSave() {
		$arr=$_POST;
		//dump($arr);die;
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
					'num'=>$key,
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
					'num'=>$key,
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
					'num'=>$key,
					);


			}
			else{
				continue;
			}
		}

		$this->mGongyi->saveRowset($rowset);
        js_alert('','',$this->_url('right'));
	}

	/**
	 * ps ：获取工艺名称
	 * Time：2017年10月10日 15:33:31
	 * @author zcc
	 * @param 参数类型
	 * @return 返回值类型
	*/
	function actionGetGongYiByAjax(){
		// $sql = "SELECT * FROM  jichu_gongyi where gongyiName like '%{$_GET['q']}%' and kind='{$_GET['kind']}'  GROUP BY gongyiName"; 
		$sql = "SELECT * FROM  jichu_gongyi where gongyiName like '%{$_GET['q']}%' and kind='染色处方'  GROUP BY gongyiName";
		$jsonCode = $this->_modelExample->findBySql($sql);
		$arr=array();
		foreach ($jsonCode as $key => & $v) {
			$arr[]=array($v['gongyiName'],$v);
		}
		echo json_encode($arr);
	}
	function actionPopup(){
		$str = "select * from jichu_gongyi where 1";
        FLEA::loadClass('TMIS_Pager');
        TMIS_Pager::clearCondition();
        $arr = TMIS_Pager::getParamArray(array(
            //'traderId' => '',
            'key' => ''
        ));
        if ($arr[key]!='') $str .= " and gongyiName like '%$arr[key]%'";
        if ($_GET['kind']) {
        	$str .= " and kind='{$_GET['kind']}'";
        }
        $str .=" order by id desc";
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAll();
        //$pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
        $arr_field_info = array(
            //"_edit" => "选择",
            "id"=>'系统序号',
            "gongyiName" =>"方案名称",
            "memo" =>"备注"
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
        $smarty-> display('Popup/Popup.tpl');
	}
}