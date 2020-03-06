<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Product extends Tmis_Controller {
	var $_modelExample;
	var $thisController = "JiChu_Product";
	var $title = "产品资料";
	var $funcId = 23;
	function Controller_JiChu_Product() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Product');
	}
	
	/**
	 * 入口文件
	 	
	 function actionIndex() {			
		$smarty = & $this->_getView();		
		$smarty->assign('title', $this->title);
		$smarty->assign('caption', "产品资料");
		$smarty->assign('controller', 'JiChu_Product');
		$smarty->assign('action', 'right');		
		$smarty->display('MainContent.tpl');
	}*/	
	
	function actionRight() {
		$this->authCheck($this->funcId);
		
		#TMIS_Pager继承自FLEA_Helper_Pager,加入了getPages()方法，获得分页的显示
		#注意,
		#--1,必须将TMIS/Pager.php放置在App目录中,App的位置Index.php有定义 App_Dir
		#--2,这里不能使用FLEA::getSingleton('TMIS_Pager');因为需要参数
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		$condition = (isset($_POST[key])&&$_POST[key]!="" ? "name like '%$_POST[key]%'" : NULL);      
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();

		#初始化smarty对象,根据config.inc.php的设置进行初始化
		$smarty = & $this->_getView();
		
		#对变量赋值
		$smarty->assign('title', $this->title);
		$smarty->assign('controller', 'JiChu_Product');
		
		#对表头进行赋值
		$arr_field_info = array(
			"proCode" =>"产品编码",
			"proName" =>"品名",
			"guige" =>"规格",
			"menfu" =>"门幅",
			"kezhong" =>"克重",
			"y"=>"直向",
			"x"=>"横向"
		);
		$smarty->assign('arr_field_info',$arr_field_info);
		
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);
	
		#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);
		
		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);			
		$smarty->assign('arr_condition',$arr);	
		#分页信息
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));		

		$smarty->assign('this_controller', $this->thisController);		
		
		#开始显示
		$smarty->display('TableList.tpl');
	}
	
	
	private function _editJiChuProduct($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aProduct",$Arr);
		
		#通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
		#在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");		
		$smarty->assign("pk",$primary_key);		
		$smarty->display('JiChu/ProductEdit.tpl');
	}
	#增加界面
	function actionAdd() {		
		$this->_editJiChuProduct(array());
	}
	#保存
	function actionSave() {
       	$this->_modelExample->save($_POST);
		$_POST[proCode] = strtoupper($_POST[proCode]);
		redirect(url("JiChu_Product","Right"));
	}
	#修改界面
	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aProduct=$this->_modelExample->find($_GET[$pk]);		
		$this->_editJiChuProduct($aProduct);
	}	
	function actionRemove() {
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[$pk]);
		redirect(url("JiChu_Product","Right"));
	}
	//根据proCode检索出产品信息,并返回json字串
	function actionGetJsonByCode(){
		echo json_encode($this->_modelExample->find("proCode='".strtoupper($_GET[proCode])."'"));exit;

	}
}
?>