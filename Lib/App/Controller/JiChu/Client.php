<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Client extends Tmis_Controller {
	var $_modelExample;
	var $title = "客户档案";
	var $funcId = 25;
	function Controller_JiChu_Client() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Client');
	}
	/*
	function actionIndex() {
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign('caption', "客户资料");
		$smarty->assign('controller', 'JiChu_Client');
		$smarty->assign('action', 'right');
		$smarty->display('MainContent.tpl');
	}*/
	function actionRight()	{
		$this->authCheck($this->funcId);
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		//echo $condition;
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));

		$condition = array('isStop'=>0);
		if ($arr[key]!="") $condition[]="compCode like '$arr[key]%' or compName like '%$arr[key]%'";

		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		//echo $pager;
        $rowset =$pager->findAll();
		if(count($rowset)>0) foreach($rowset as & $v){
			//dump($v);
			if($v[isStop]==1){
				$v['_bgColor']='red';
			}
			$v[traderName] = $v[Trader][employName];
			if (count($v[ArType])>0) {
				$temp = array_col_values($v[ArType],'typeName');
				$v[arTypes] = join(',',$temp);
			}
			$v['_edit'] = $this->getEditHtml($v['id']) . " <a href='".$this->_url('Remove',array(
				'id'=>$v['id'],
				'isStop'=>1
			))."'>停止往来</a>";
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"compCode" =>"编码",
			"compName" =>"名称",
			"fullName" =>"客户全称",
			"arTypes" =>"业务范围",
			"people" =>"联系人",
			"tel" =>"电话",
			"traderName" =>"本厂联系人",
			'loginName' => '登陆用户名',
			'_edit'=>'操作'
		);

		#对操作栏进行赋值
		/*$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"停止往来",
			"isStop"=>1
		);*/
		//$smarty->assign('arr_edit_info',$arr_edit_info);

		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->assign('controller', 'JiChu_Client');
		$smarty-> display('TableList.tpl');
	}

	#已停止往来的客户
	function actionRight1()	{
		$this->authCheck($this->funcId);
		//$condition = (isset($_POST[key])&&$_POST[key]!="" ? "compCode like '%$_POST[key]%' or compCode like '%$_POST[key]%'" : NULL);
		//echo $condition;
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		$condition = array('isStop'=>1);
		if ($arr[key]!="") $condition[]="compCode like '$arr[key]%' or compName like '%$arr[key]%'";
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
		//echo $pager;
        $rowset =$pager->findAll();
		if(count($rowset)>0) foreach($rowset as & $v){
			//dump($v);
			if($v[isStop]==1){
				$v['_bgColor']='red';
			}
			$v[traderName] = $v[Trader][employName];
			if (count($v[ArType])>0) {
				$temp = array_col_values($v[ArType],'typeName');
				$v[arTypes] = join(',',$temp);
			}
			//echo $v['id'];exit;
			$v['_edit'] = $this->getEditHtml($v['id']) . " <a href='".$this->_url('Remove',array(
				'id'=>$v['id'],
				'isStop'=>0
			))."'>恢复往来</a>";
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"compCode" =>"编码",
			"compName" =>"名称",
			"arTypes" =>"业务范围",
			"people" =>"联系人",
			"tel" =>"电话",
			"traderName" =>"本厂联系人",
			'loginName' => '登陆用户名',
			'_edit'=>'操作'
		);

		#对操作栏进行赋值
		/*$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"恢复往来",
			"isStop"=>0
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);*/

		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->assign('controller', 'JiChu_Client');
		$smarty-> display('TableList.tpl');
	}
	private function _editJiChuClient($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aClient",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		$smarty->assign("pk",$primary_key);
		$smarty->display('JiChu/ClientEdit.tpl');
	}

	function actionAdd() {
		$this->_editJiChuClient(array());
	}

	function actionSave() {
		if ($_POST['compCode']) {
			if ($_POST['id']!='') {//判断为修改(修改时则判断编码是否修改过 修改过则判断是否重复)
				$sql = "SELECT * FROM jichu_client where id = '{$_POST['id']}'";
				$comp = $this->_modelExample->findBySql($sql);
				if ($comp[0]['compCode']!=$_POST['compCode']) {
					//判断编号是否重复
					$sql = "SELECT * FROM jichu_client where compCode = '{$_POST['compCode']}'";
					$comp2 = $this->_modelExample->findBySql($sql);
					if (count($comp2)>0) {//当存在数据则提示
						js_alert('已存在该编码，请重新输入！','',url("JiChu_Client","right"));
						exit();
					}
				}
			}else{
				//判断编号是否重复
				$sql = "SELECT * FROM jichu_client where compCode = '{$_POST['compCode']}'";
				$comp = $this->_modelExample->findBySql($sql);
				if (count($comp)>0) {//当存在数据则提示
					js_alert('已存在该编码，请重新输入！','',url("JiChu_Client","add"));
					exit();
				}
			}
		}else{
			js_alert('编码为空，保存失败！','',url("JiChu_Client","add"));
		}
       	$this->_modelExample->save($_POST);
		redirect(url("JiChu_Client","Right"));
	}
	//停止往来
	function actionRemove() {
		$_GET['isStop'] += 0;
		//dump($_GET);exit;
		$this->_modelExample->update($_GET);
		redirect(url("JiChu_Client","Right"));
	}

	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aClient=$this->_modelExample->find($_GET[$pk]);
		$this->_editJiChuClient($aClient);
	}



	//取得最大的同类供应商代码
	function actionGetMaxcompCode() {
		if (isset($_GET[compCode]))	$arr = $this->_modelExample->find("compCode like '$_GET[compCode]___'",'compCode desc','compCode');
		elseif (isset($_GET[userId]))	$arr = $this->_modelExample->find("traderId = '$_GET[userId]'",'compCode desc','compCode');
		echo json_encode($arr);exit;
	}

	//在模式对话框中显示待选择的客户，返回某个客户的json对象。
	function actionPopup() {
		$str = "select x.* from
			jichu_client x left join jichu_client2artype y on x.id=y.clientId
			where 1";
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'arType'=>'',
			'traderId' => '',
			'key' => ''
		));
		if ($arr[arType]!='') $str .= " and y.arTypeId='$arr[arType]'";
		if ($arr[traderId]!='') $str .= " and x.traderId='$arr[traderId]'";
		if ($arr[key]!='') $str .= " and x.compName like '%$arr[key]%'";
		$str .=" group by x.id order by x.compCode desc";
		$pager =& new TMIS_Pager($str);
		//echo $str;
		$rowset =$pager->findAllBySql($str);
		$pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
		$mTrader = FLEA::getSingleton('Model_JiChu_Employ');
		if(count($rowset)>0) foreach($rowset as & $v){
			$temp = $mTrader->find($v[traderId]);
			$v[traderName] = $temp[employName];
			$v[_edit] = "<a href='#' onclick=\"retClient($v[id],'$v[compName]')\">选择</a>";
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"_edit" => "选择",
			"compCode" =>"编码",
			"compName" =>"名称",
			"traderName" =>"本厂联系人"
		);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('s',$arr);
		$smarty->assign('page_info',$pageInfo);
		$smarty->assign('controller', 'JiChu_Client');
		$smarty-> display('Popup/Client.tpl');
	}

	//AJAX方式获得单个客户信息
	function actionGetSingleInfoByAjax(){
		$rowset = $this->_modelExample->findAll(array("id"=>$_GET["clientId"]));
		foreach ($rowset as &$v) {
			$sql = "SELECT * FROM trade_dye_order where clientId = '{$v[id]}' order by id desc limit 0,1";
			$order = $this->_modelExample->findBySql($sql);
			if (count($order)>=1) {
				$v['isShow'] = 1;
			}
			$v['packing_memo'] = $order[0]['packing_memo'];
			$v['special_memo'] = $order[0]['memo'];
			$v['qita_memo'] = $order[0]['qita_memo'];
		}
		//获取这个客户最新一次生产计划所对应的 包装要求 特别要求 其他备注

		$returnValue = array(
			"success" => true,
			"msg"     => "",
			"data"    => array()
		);
		if (count($rowset) > 0){
			$returnValue["data"] = $rowset;
		}else{
			$returnValue["success"] = false;
			$returnValue["msg"] = "客户资料不存在";
		}
		echo json_encode($returnValue);
	}
}
?>