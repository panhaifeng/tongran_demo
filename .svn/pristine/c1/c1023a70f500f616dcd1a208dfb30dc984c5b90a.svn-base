<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Supplier extends Tmis_Controller {
	var $_modelExample;
	var $title = "供应商资料";
	var $funcId = 26;
	function Controller_JiChu_Supplier() {
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Supplier');
	}	
	
	function actionRight() {
		$this->authCheck($this->funcId);
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
			"compCode" =>"编码",
			"compName" =>"名称",
			"people" =>"联系人",
			"tel" =>"电话",
			"fax" =>"传真",
			"mobile" =>"手机",
			"accountId" =>"帐号",
			"taxId" =>"税号",
			"address" =>"地址",
			"memo" =>"备注"
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
		$this->authCheck($this->funcId);
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
	 * ps ：增加新的提示信息防止空保存和重复编码
	 * Time：2017/09/11 09:34:06
	 * @author zcc
	*/
	function actionSave() {
		if ($_POST['compCode']) {
			//判断供应商编号是否重复
			$sql = "SELECT * FROM jichu_supplier where compCode = '{$_POST['compCode']}'";
			$comp = $this->_modelExample->findBySql($sql);
			if (count($comp)>0) {//当存在数据则提示
				js_alert('已存在该编码，请重新输入！','',url("JiChu_Supplier","add"));
				exit();
			}
		}else{
			js_alert('编码为空，保存失败！','',url("JiChu_Supplier","add"));
		}
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
	function actionGetJsonByName(){
		$str="select count(*) as cnt from jichu_supplier where compName='{$_GET['compName']}'";
		if($_GET['id']!='')$str.=" and id<>'{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		$arr['cnt']=$re['cnt']+0;
		$arr['id']=$_GET['id'];
		echo json_encode($arr);
		exit;
	}
}
?>