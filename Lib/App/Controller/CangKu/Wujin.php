<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Wujin extends Tmis_Controller {
	#库存初始化
    function actionInit() {
		//权限判断
		$this->authCheck(122);
		redirect("wujin/Index.php?controller=Cangku_kucun&action=init");
	}
	#入库登记
	function actionRuku(){
		$this->authCheck(123);
		redirect("wujin/Index.php?controller=Cangku_Ruku&action=add");
	}
	function actionRukuSearch(){
		$this->authCheck(124);
		redirect("wujin/Index.php?controller=Cangku_Ruku&action=right");
	}
	function actionChuku(){
		$this->authCheck(125);
		redirect("wujin/Index.php?controller=Cangku_Chuku&action=add");
	}
	function actionChukuSearch(){
		$this->authCheck(126);
		redirect("wujin/Index.php?controller=Cangku_Chuku&action=right");
	}
	function actionKucun(){
		$this->authCheck(127);
		redirect("wujin/Index.php?controller=Cangku_Kucun&action=right");
	}
	function actionMonth(){
		$this->authCheck(128);
		redirect("wujin/Index.php?controller=Cangku_Kucun&action=month");
	}
	function actionJichu() {
		$this->authCheck(130);
		redirect("wujin/Index.php?controller=JiChu_Ware&action=right");
	}
	function actionDepartment() {
		$this->authCheck(132);
		redirect("wujin/Index.php?controller=JiChu_Department&action=right");
	}
	function actionSupplier() {
		$this->authCheck(133);
		redirect("wujin/Index.php?controller=JiChu_Supplier&action=right");
	}
	function actionEmploy() {
		$this->authCheck(134);
		redirect("wujin/Index.php?controller=JiChu_Employ&action=right");
	}
	function actionSetEmploy() {
		$this->authCheck(135);
		redirect("wujin/Index.php?controller=JiChu_Employkind&action=right");
	}
	#库存位置
	function actionPos(){
		$this->authCheck(131);
		redirect("wujin/Index.php?controller=JiChu_Pos&action=right");
	}
}
?>