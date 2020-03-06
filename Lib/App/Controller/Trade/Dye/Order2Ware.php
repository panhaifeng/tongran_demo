<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Trade_Dye_Order2Ware extends Tmis_Controller {
	var $_modelExample;
	var $errorMsg='';
	function Controller_Trade_Dye_Order2Ware() {
		$this->_modelExample = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
	}

	//成品车间出库时输入生产编号，得到相关的json数据
	function actionGetJsonByManuCode(){
		echo json_encode($this->_modelExample->find("manuCode='$_GET[manuCode]'"));exit;
	}

	//在订单明细里利用json修改要货数量
	function actionJsonUpdate() {
		$this->_modelExample->updateField("id='$_GET[id]'",'cntKg',$_GET[cnt]);
		echo "1";exit;
	}

	//清除该计划下的所有缸,需要在新窗口中打开
	function actionRemoveAllGang() {
		$m=& FLEA::getSingleton('Model_Plan_Dye_Gang');
		$arr = $m->findAll(array(order2wareId=>$_GET[order2wareId]));
		foreach($arr as $v) {
			//$m->removeByPkv($v[id]);
			if(!$m->removeByPkv($v[id])) {
				js_alert($m->errorMsg,'window.opener.history.go();window.close()');
			};
		}
		js_alert('','window.opener.history.go();window.close()');//成功清除!请刷新父窗口!
	}

}
?>