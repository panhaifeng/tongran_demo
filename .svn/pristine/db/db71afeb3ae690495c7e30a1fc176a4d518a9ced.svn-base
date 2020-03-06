<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Kucun extends Tmis_Controller {
    var $_modelChuku;   
    var $funcId;

    function Controller_CangKu_Kucun() {
        $this->_modelChuku = & FLEA::getSingleton('Model_CangKu_ChuKu');
        $this->_modelChuku2Ware = & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $this->_modelRuku2Ware = & FLEA::getSingleton('Model_CangKu_RuKu2Ware');
        $this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
    }


    
    //得到库存数量，返回json数据
    function actionGetcntKucun(){
		//dump($_GET);
        $chuku=$this->_modelChuku2Ware->findAll(array(
			'wareId'=>$_GET['wareId'],
			'supplierId'=>$_GET['clientId'],
		));
        $ruku=$this->_modelRuku2Ware->findAll(array(
			'wareId'=>$_GET['wareId'],
			'Ruku.supplierId'=>$_GET['clientId'],
		));
        $chukuCnt=$this->getHeji($chuku, array('cnt'));		
        $rukuCnt=$this->getHeji($ruku, array('cnt'));
        $cnt=$rukuCnt['cnt']-$chukuCnt['cnt'];
		//echo $cnt;exit;
        $mlog= & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $mware=& FLEA::getSingleton('Model_Jichu_Ware');
        $ware=$mware->find(array('id'=>$_GET['wareId']));
        //dump($ware);exit;
        $json=array(
            'wareName'=>$ware['wareName'].'['.$ware['guige'].']',
            'cnt'=>$cnt
        );
        echo(json_encode($json));exit;
    }
   
}
?>