<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Chengpin_Denim_Cpck2Ordpro extends Tmis_Controller {
	var $_modelExample;
	
	function Controller_Chengpin_Denim_Cpck2Ordpro() {
		$this->_modelExample = & FLEA::getSingleton('Model_Chengpin_Denim_Cpck2OrdPro');
	}	

	#列表	
	function actionIndex() {	
	}	
}
?>