<?php
class Controller_Main extends FLEA_Controller_Action {
    function actionIndex() {
        $ui =& FLEA::initWebControls();
        if ($_GET['menuName']) $_SESSION['MENUNAME'] = $_GET['menuName'];
        if (!$_SESSION['REALNAME']) {
            redirect(url("Login"));	exit;
        }
        $smarty =& $this->_getView();
        $smarty->display('Main.tpl');
    }

    function actionTop() {
        $ui =& FLEA::initWebControls();
        $smarty =& $this->_getView();
        if ($_SESSION['REALNAME'] != "") $realName = $_SESSION['REALNAME'];
        else $realName = "未登陆";
        $smarty->assign('real_name', $realName);
        $smarty->assign('menu', FLEA::getAppInf('menu'));
        $smarty->display('MainTop.tpl');
    }

    function actionLeftMenu() {
        $smarty = & $this->_getView();
        $smarty->assign('menu', FLEA::getAppInf('menu'));
        $smarty->display('MainLeft.tpl');
    }

    function actionContent() {

        $smarty = & $this->_getView();
        $smarty->display('Welcome.tpl');
    }

    function actionCalculator() {
        $smarty = & $this->_getView();
        $smarty->display('Calculator.tpl');
    }
}


?>