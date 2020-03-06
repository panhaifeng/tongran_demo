<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Employ extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 27;
	function Controller_JiChu_Employ() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_Jichu_Employ');
	}

	function actionRight() {
        $table = $this->_modelExample->tableName;

		#TMIS_Pager继承自FLEA_Helper_Pager,加入了getPages()方法，获得分页的显示
		#注意,
		#--1,必须将TMIS/Pager.php放置在App目录中,App的位置Index.php有定义 App_Dir
		#--2,这里不能使用FLEA::getSingleton('TMIS_Pager');因为需要参数
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();
		//$dbo = & FLEA::getDBO(false);dump($dbo->log);exit;
		/*对$rowset进行处理，比如对sex=0输出为"男"*/
		foreach ($rowset as & $value) {
			$value[sex]=($value[sex]==0?"男":"女");
			$temp = array_pop($value);
			$value[depName]=$temp[depName];
		}

		/*FLEA_Helper_Pager::findAll([string $fields = '*'])
		与 FLEA_Db_TableDataGateway::findAll( [mixed $conditions = null],
		[string $sort = null], [mixed $limit = null], [string $fields = '*'] )
		参数不太一样，建议格式进行调整，统一成用字符串编码进
		*/

		/**下面两句可以用来跟踪所有执行过的sql语句*/
		#$dbo=& get_dbo(false);
		#dump($dbo->log);

		/**
		/*利用Smarty显示
		**/
		#初始化smarty对象,根据config.inc.php的设置进行初始化
		$smarty = & $this->_getView();

		#对变量赋值
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('title','员工信息');
		$smarty->assign('controller', 'JiChu_Employ');

		#对表头进行赋值
		$arr_field_info = array(
			"depName" =>"部门|left",
			"employCode" =>"员工代码|left",
			"employName" =>"姓名|left",
			"sex" =>"性别|left",
			"mobile" =>"电话|right",
			"address" =>"地址|left",
			"dateEnter" =>"上岗日期|right",
			"dateLeave" =>"离职日期|right"
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
		$smarty->assign('pk', $pk);

		$smarty->assign('arr_condition',$arr);

		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));

		#开始显示
		$smarty->display('TableList.tpl');
	}



	private function _editJiChuEmploy($Arr) {
		//$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aEmploy",$Arr);

		#通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
		#在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");

		//die($_GET[$pk]);
		$smarty->assign("pk",$primary_key);
		$smarty->display('JiChu/EmployEdit.tpl');
	}
	#增加界面
	function actionAdd() {
		$this->_editJiChuEmploy(array());
	}
	#保存
	function actionSave() {
       	$this->_modelExample->save($_POST);
		redirect(url("JiChu_Employ","Right"));
	}
	#修改界面
	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aEmploy=$this->_modelExample->find($_GET[$pk]);
		//dump($aEmploy);

		$this->_editJiChuEmploy($aEmploy);
	}
	function actionRemove() {
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[$pk]);
		redirect(url("JiChu_Employ","Right"));
	}

	//弹出选择
	function actionPopup() {
		////////////////////////////////标题
		$title = '选择员工';
		///////////////////////////////模板文件
		$tpl = 'Popup/Common.tpl';
		///////////////////////////////表头
		$arr_field_info = array(
			"departments.depName" =>"部门",
			"employCode" =>"员工代码",
			"employName" =>"姓名",
			"sex" =>"性别"
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
		if($arr['key']!='') {
			$condition[] = "employCode like '%{$arr['key']}%' or employName like '%{$arr['key']}%'";
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
	//根据代码查找到相应的员工信息
	function actionGetJsonByKey(){
	    $str="select * from jichu_employ where employCode like '%$_GET[key]%'";
	    $rowset=$this->_modelExample->findBySql($str);
	    //dump($rowset);
	    echo json_encode($rowset);exit;
	}
}
?>