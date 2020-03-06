<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Color extends Tmis_Controller {
	var $_modelExample;
	function __construct() {
		////////////////////////////////默认model
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Color');
	}

	function actionRight()	{
		////////////////////////////////标题
		$title = '颜色自动完成设置';
		///////////////////////////////模板文件
		$tpl = 'TableList2.tpl';
		///////////////////////////////表头
		$arr_field_info = array(
			'memoCode'=>'助记码',
			'color'=>'颜色',
			"_edit"=>"操作"
		);
		///////////////////////////////搜索条件
		$arrCon = array(
			'key'=>''
		);
		///////////////////////////////模块定义
		$this->authCheck();
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray($arrCon);

		/************构造condition**********/
		if($arr['key']) {
			//$condition[] = array('',$arr['']);
			$condition[] = array('color','%'.$arr['key'].'%','like');
		}


		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();
		if(count($rowset)>0) foreach($rowset as & $v){
			///////////////////////////////
			$this->makeEditable($v,'memoCode');
			$v['_edit'] = $this->getEditHtml($v['id']) . ' | ' . $this->getRemoveHtml($v['id']);

		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);

		/*///////////////grid,thickbox,///////////////*/
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('grid')));
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display($tpl);
	}

	function _edit($Arr) {
		///////////////////////////////标题
		$title = '颜色输入提示';
		///////////////////////////////模板
		$tpl = 'JiChu/ColorEdit.tpl';
		///////////////////////////////模块定义
		$this->authCheck();
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign("aRow",$Arr);
		$smarty->display($tpl);
	}

	function actionGetSuggestJson() {
		if(trim($_GET[mnemocode])==='') echo "{}";
		$re = array();

		$arr = $this->_modelExample->findAll(array(
			array('memoCode',"$_GET[mnemocode]%",'like')
		));
		foreach($arr as $key=>$v) {
			$re[$key][name]=$v[color];
			$re[$key][values]=$v[color];
		}
		echo json_encode($re);exit;
	}
}
?>