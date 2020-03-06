<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Acm_User extends Tmis_Controller {
	var $_modelUser;
	var $funcId = 22;
	function Controller_Acm_User() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelUser = FLEA::getSingleton('Model_Acm_User');
	}	
	
	function actionChangePwd() {
		$this->authCheck(68);
		$realName = $_SESSION[REALNAME];
		$userName = $_SESSION[USERNAME];
		$userId = $_SESSION[USERID];
		$aUser = $this->_modelUser->find($userId);
		$smarty = $this->_getView();
		$smarty->assign('add_display','none');
		$smarty->assign('aUser',$aUser);
		$smarty->assign('title',"密码修改");
		$smarty->display('Acm/ChangePwd.tpl');
	}	
	function actionRight() {
		$this->authCheck(88);
		if (isset($_POST[key])&&$_POST[key]!="") $condition = "realName like '%$_POST[key]%'";
		FLEA::loadClass('TMIS_Pager');
		$pager = new TMIS_Pager($this->_modelUser,$condition);
		$rowSet = $pager->findAll();
		$arrFieldInfo = array(
			"id"=>"编号|right",
			"userName"=>"用户名|left",
			"realName"=>"真实姓名|left",
			"sn"=>"动态密码卡SN|right",
		);
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除",
			'setDep'=>'设置部门',
			'setWare'=>'设置物料'
		);
		$pk = $this->_modelJiChuDepartment->primaryKey;
		$smarty = & $this->_getView();
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign("title","用户管理");
		$smarty->assign("arr_field_value",$rowSet);
		//$smarty->assign('search_display', 'none');
		$smarty->assign('pk','id');	
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display("TableList.tpl");
	}
	/*
	function actionIndex() {
		$arrLeftList = array(
			"Acm_User" =>"用户管理",
			"Acm_Role" =>"角色管理",
			"Acm_Func" =>"模块定义"
		);
		
		$smarty = & $this->_getView();		
		$smarty->assign('arr_left_list', $arrLeftList);
		$smarty->assign('title', '用户管理');
		$smarty->assign('caption', '权限管理');
		//$smarty->assign('child_caption', "应付款凭据录入");
		$smarty->assign('controller', 'Acm_User');
		$smarty->assign('action', 'right');		
		$smarty->display('MainContent.tpl');
	}*/
	function actionAdd() {
		$this->authCheck(89);
		$this->_edit(array());
	}
	function actionEdit() {
		$this->authCheck(89);
		$aUser = $this->_modelUser->find($_GET[id]);
		//$dbo = FLEA::getDbo(false);
		//dump($dbo->log);exit;
		$this->_edit($aUser);
	}
	function actionSave() {
		$this->_modelUser->save($_POST);
		if ($_POST[Submit]=='确认修改') js_alert('修改密码成功!','window.close()');
		redirect($this->_url('right'));
	}
	function actionRemove() {
		$this->authCheck(89);
		$this->_modelUser->removeByPkv($_GET[id]);
		redirect($this->_url('right'));
	}
	function _edit($Arr) {
		//$this->authCheck($this->funcId);
		$smarty = $this->_getView();
		$smarty->assign('aUser',$Arr);
		$smarty->assign('title',"用户信息编辑");
		$smarty->display('Acm/UserEdit.tpl');
	}
	 //只得到顶级节点
	function getTopNode($parentId) {
		$rowset = $this->_modelFunc->getAllTopNodes();
		$arr = array();
		if($rowset) foreach($rowset as & $v){
			$temp = array(
				"id"=>$v['id'],//节点id
				"text"=> $v['funcName'],//标签文本
				"value"=> $v['id'],//值
				"showcheck"=> true,//是否显示checkbox
				"isexpand"=>false,
				"checkstate"=> 0,//是否被选中
				"hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
				"ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
				"complete"=>false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
				//"complete"=> true
			);
			$arr[] = $temp;
		}
		return $arr;
	}
	//设置部门
	function actionSetDep(){
		//dump($_GET);exit;
		$Arr=$this->_modelUser->find($_GET['id']);
		$ret = array();
		$mDep = & FLEA::getSingleton("Model_Jichu_Department");
		$ret = $mDep->getTopNode();
		//所有部门信息的内容,包括子目录
		$row = $mDep->getAllTopNodes();
		foreach($row as & $v){
		    //dump($v);
		    $mm=array();
		    $str="select * from jichu_department where leftId>='$v[leftId]' and rightId<='$v[rightId]'";
		    $query=mysql_query($str);
		    while($re=mysql_fetch_assoc($query)){
		       $mm[]=$re;
		    }
		    $v['path'] = array_col_values($mm,'id');
		    //dump($v);
		}
		//dump($Arr);
		$smarty = $this->_getView();
		$smarty->assign('title',"用户部门设置");
		$smarty->assign('row',$Arr);
		$smarty->assign('aRow',json_encode($Arr['deps']));
		$smarty->assign('data',json_encode($ret));
		$smarty->assign('row1',json_encode($row));
		$smarty->assign('ym',date('Y-m'));
		$smarty->display('Acm/SetDep.tpl');
	}
	//从树形结构页面中以ajax方式提交过来的处理函数
	function actionAssignDepByAjax(){
		//dump($_GET);exit;
		//先删除相关角色下所有已经分配的权限关系
		$sql = "delete from acm_user2dep where userId='{$_GET['userId']}'";
		$this->_modelUser->execute($sql);

		//过滤掉_GET['funcId']中父节点和所有子节点都被选中的节点，只保留父节点
		$path = array();
		$mDep = & FLEA::getSingleton("Model_Jichu_Department");
		if($_GET['depId']) foreach($_GET['depId'] as & $v) {
			$node = $mDep->find(array('id'=>$v));
			$p = $mDep->getPath($node);
			if($p) foreach($p as & $vv) {
				$path[$v][] = $vv['id'];
			} else $path[$v][]=null;
		}

		$ret = array();
		foreach($path as $key=>& $v) {
			if($v==null) $ret[] = array('id'=>$key);
			$found=false;
			if($v) foreach($v as $k=>& $vv) {
				if(in_array($vv,$_GET['depId'])) {
					$found=true;
					break;
				}
			}
			if(!$found) $ret[] = array('id'=>$key);
		}

		$arr = array('id'=>$_GET['userId'],'deps'=>$ret);
		$m = FLEA::getSingleton('Model_Acm_User');
		if($m->update($arr)) {
			echo '{"success":true}';
			exit;
		}
		echo '{"success":false,"msg":"出错"}';
		//dump($arr);exit;
		//$this->_modelFunc->getSubTree
		//保存
	}
	//设置物料
	function actionSetWare(){
		$Arr=$this->_modelUser->find($_GET['id']);
		$ret = array();
		$mWare = & FLEA::getSingleton("Model_Jichu_Ware");
		$ret = $mWare->getTopNode();

		//所有部门信息的内容,包括子目录
		$row = $mWare->getAllTopNodes();
		foreach($row as & $v){
		    //dump($v);
		    $mm=array();
		    $str="select * from jichu_ware where leftId>='$v[leftId]' and rightId<='$v[rightId]'";
		    $query=mysql_query($str);
		    while($re=mysql_fetch_assoc($query)){
		       $mm[]=$re;
		    }
		    $v['path'] = array_col_values($mm,'id');
		    //dump($v);
		}
		$smarty = $this->_getView();
		$smarty->assign('title',"用户物料设置");
		$smarty->assign('row',$Arr);
		$smarty->assign('aRow',json_encode($Arr['Ware']));
		$smarty->assign('data',json_encode($ret));
		$smarty->assign('row1',json_encode($row));
		$smarty->assign('ym',date('Y-m'));
		$smarty->display('Acm/SetWare.tpl');
	}
	function actionAssignWareByAjax(){
		//dump($_GET);exit;
		//先删除相关角色下所有已经分配的权限关系
		$sql = "delete from acm_user2ware where userId='{$_GET['userId']}'";
		$this->_modelUser->execute($sql);

		//过滤掉_GET['funcId']中父节点和所有子节点都被选中的节点，只保留父节点
		$path = array();
		$mWare = & FLEA::getSingleton("Model_Jichu_Ware");
		if($_GET['wareId']) foreach($_GET['wareId'] as & $v) {
			$node = $mWare->find(array('id'=>$v));
			$p = $mWare->getPath($node);
			if($p) foreach($p as & $vv) {
				$path[$v][] = $vv['id'];
			} else $path[$v][]=null;
		}

		$ret = array();
		foreach($path as $key=>& $v) {
			if($v==null) $ret[] = array('id'=>$key);
			$found=false;
			if($v) foreach($v as $k=>& $vv) {
				if(in_array($vv,$_GET['wareId'])) {
					$found=true;
					break;
				}
			}
			if(!$found) $ret[] = array('id'=>$key);
		}

		$arr = array('id'=>$_GET['userId'],'Ware'=>$ret);
		$m = FLEA::getSingleton('Model_Acm_User');
		if($m->update($arr)) {
			echo '{"success":true}';
			exit;
		}
		echo '{"success":false,"msg":"出错"}';
		//dump($arr);exit;
		//$this->_modelFunc->getSubTree
		//保存
	}
	//打印设置
	function actionSetPrint(){
		$smarty = $this->_getView();
		//$smarty->assign('aUser',$Arr);
		$smarty->assign('title',"打印设置");
		$smarty->display('Acm/PrintEdit.tpl');
	}
}
?>