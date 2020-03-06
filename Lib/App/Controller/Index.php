<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Index extends Tmis_Controller {
    var $_modelExample;
	//var $title = "客户档案";
	//var $funcId = 25;
	
	function Controller_Index() {
		$this->_modelExample = & FLEA::getSingleton('Model_Index');
	}
	
	function actionIndex() {
		redirect(url("Login"));	exit;

		$ui =& FLEA::initWebControls();
		$rowset1 =$this->_modelExample->findAll("classId=1","buildDate desc","5");
		$rowset2 =$this->_modelExample->findAll("classId=2","buildDate desc","5");
		$rowset3 =$this->_modelExample->findAll("classId=3","buildDate desc","5");
		$rowset4 =$this->_modelExample->findAll("classId=4","buildDate desc","5");
		$rowset5 =$this->_modelExample->findAll("classId=5","buildDate desc","5");
		
		
		$smarty = & $this->_getView();		
		$pk = $this->_modelExample->primaryKey;
		
		$arr_field_info = array(			
			"title" =>"标题",
			"buildDate" =>"日期"	
		);
		
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('pk', $pk);
		$smarty->assign('arr_field_value1',$rowset1);
		$smarty->assign('arr_field_value2',$rowset2);
		$smarty->assign('arr_field_value3',$rowset3);
		$smarty->assign('arr_field_value4',$rowset4);
		$smarty->assign('arr_field_value5',$rowset5);
		$smarty->display('Index.tpl');
	}
	
		//天气预报
	/*
	function ArrWeather() {
			$fcont = @file_get_contents("http://tq.tom.com/china/index.html"); //把带天气预报的网站加进来
			$date = explode(" align=center><td><font color=#005FC9>", $fcont); //截取天气字符串
			$fdate = substr($date[66],11,59);	//准备获取
			$fcastarr = explode("</td><td>",$fdate); //分离
			return $fcastarr;
	}	
	*/

	
	function actionView() {
		$pk=$this->_modelExample->primaryKey;

		$aRow=$this->_modelExample->find($_GET[$pk]);		
		//$this->_edit($aRow);
		
		$smarty = & $this->_getView();
		$smarty->assign("aRow",$aRow);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");	
		//die($primary_key);	
		$smarty->assign("pk",$primary_key);	
		//$smarty->assign('default_date',date("Y-m-d"));	
		$smarty->display('OA/View.tpl');
		
	}
		
		
}
?>