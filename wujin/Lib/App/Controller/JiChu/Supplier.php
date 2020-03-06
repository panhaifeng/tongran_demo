<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Supplier extends Tmis_Controller {
    var $_modelExample;
    var $title = "供应商资料";
    var $funcId = 26;
    function Controller_JiChu_Supplier() {
        $this->_modelExample = & FLEA::getSingleton('Model_Jichu_Supplier');
    }

    function actionRight() {
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array('key'=>''));
        $condition = $arrParam[key]!='' ? "compCode like '$arrParam[key]%'" : NULL;

        $pager =& new TMIS_Pager($this->_modelExample,$condition,'compCode desc');
        $rowset =$pager->findAll();
        $smarty = & $this->_getView();
        $smarty->assign('title', $this->title);
        $smarty->assign('controller', 'JiChu_Supplier');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('pk', $pk);
        $arr_field_info = array(
            "compCode" =>"编码|left",
            "compName" =>"名称|left",
            "people" =>"联系人|left",
            "tel" =>"电话|right",
            "fax" =>"传真|right",
            "mobile" =>"手机|right",
            "accountId" =>"帐号|right",
            //"taxId" =>"税号|right",
            "address" =>"地址|left",
            "memo" =>"备注|left"
        );
        $smarty->assign('arr_field_info',$arr_field_info);

        #对操作栏进行赋值
        $arr_edit_info = array(
            "edit" =>"修改",
            "remove" =>"删除"
        );
        $smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arr)));
        $smarty->display('TableList.tpl');
    }


    /**
     * 修改,增加综合处理函数
     */
    private function _editJiChuSupplier($Arr) {
    //$this->authCheck($this->funcId);
        $smarty = & $this->_getView();
        $smarty->assign("aSupplier",$Arr);

        #通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
        #在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
        $pk=$this->_modelExample->primaryKey;
        $primary_key=(isset($_GET[$pk])?$pk:"");
        $smarty->assign("pk",$primary_key);
        $smarty->display('JiChu/SupplierEdit.tpl');
    }


    /**
     * 增加界面
     */
    function actionAdd() {
        $this->_editJiChuSupplier(array());
    }


    /**
     * 保存
     */
    function actionSave() {
    //dump($_POST);
    //die();
        $this->_modelExample->save($_POST);
        redirect(url("JiChu_Supplier","Right"));
    }


    /**
     * 修改
     */
    function actionEdit() {
        $pk=$this->_modelExample->primaryKey;
        $aSupplier=$this->_modelExample->find($_GET[$pk]);
        $this->_editJiChuSupplier($aSupplier);
    }


    /**
     * 删除
     */
    function actionRemove() {
        $pk=$this->_modelExample->primaryKey;
        if ($this->_modelExample->removeByPkv($_GET[$pk]))	redirect(url("JiChu_Supplier","Right"));
        else js_alert('不能删除!','',$_SERVER[HTTP_REFERER]);
    }

    //取得某类下的所有客户,返回json对象
    function actionGetJson() {
        $arr = $this->_modelExample->findAll("compCode like '$_GET[type]___'");
        echo json_encode($arr);exit;
    }

    //取得最大的同类供应商代码
    function actionGetMaxcompCode() {
        $arr = $this->_modelExample->find("compCode like '$_GET[compCode]___'",'compCode desc','compCode');
        echo json_encode($arr);exit;
    }

    function actionPopup() {
    ////////////////////////////////标题
        $title = '选择供应商';
        ///////////////////////////////模板文件
        $tpl = 'Popup/Common.tpl';
        ///////////////////////////////表头
        $arr_field_info = array(
            "compCode" =>"编码",
            "compName" =>"名称",
            "address" =>"地址"
        );
        ///////////////////////////////搜索条件
        $arrCon = array(
            'key'=>''
        );
        ///////////////////////////////模块定义
        FLEA::loadClass('TMIS_Pager');
        TMIS_Pager::clearCondition();
        $arr = TMIS_Pager::getParamArray($arrCon);

		/************构造condition**********/
        if($arr['key']) {
            $condition[] = "compCode like '%{$arr['key']}%' or compName like '%{$arr['key']}%'";
        //$condition[] = array('','%'.$arr[''].'%','like');
        }

        //if($_GET['code']) $condition[] =array('shenqingCode',"%{$_GET['code']}%",'like');
        //dump($condition);
        $pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();

        //$mWare = & FLEA::getSingleton("Model_Jichu_Ware");
        //if(count($rowset)>0) foreach($rowset as & $v){}

        $smarty = & $this->_getView();
        $smarty->assign('title', $title);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_condition', $arr);

		/*///////////////grid,thickbox,///////////////*/
        $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display($tpl);
    }
}
?>