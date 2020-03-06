<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Department extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 28;
	function Controller_JiChu_Department() {
		/*if(!$this->authCheck()) die("禁止访问!");*/
		$this->_modelExample = & FLEA::getSingleton("Model_Jichu_Department");
	}

	function actionRight() {
		FLEA::loadClass('TMIS_Pager');
		//$arr = TMIS_Pager::getParamArray(array('key'=>''));
		//if (isset($_POST[key])&&$_POST[key]!="") $condition = "depName like '%$_POST[key]%'";
		$parentId = isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0;

		if ($parentId) {
		    $parent = $this->_modelExample->getClass($parentId);
		    if (!$parent) {
			js_alert("无效分类 in actionIndex!",'add');
		    }
		    $rowset = $this->_modelExample->getSubNodes($parent);
		} else {
		    $rowset = $this->_modelExample->getAllTopNodes();
		}
		/*$pager = & new TMIS_Pager($this->_modelExample, $condition);
		$rowset = $pager->findAll();*/
		foreach($rowset as & $v){
		    $v['showSub'] = "<a href='".$this->_url('right',array('parentId'=>$v['id']))."'>".($v['leftId']+1==$v['rightId'] ? '<font color="green">无子项</font> >>进入':'<font color="red">有子项</font> >>进入')."</a>";
		}

		$arrFieldInfo = array (
		    "depCode" => "编码|right",
		    //'deepth'=>'级别深度',
		    "depName" => "部门名称|left",
		    "showSub" => "查看子项",
		);
		//dump($_GET);
		$pk = $this->_modelExample->primaryKey;
		$smarty = & $this->_getView();

		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除",
			'moveNode'=>'移动'
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);

		$smarty->assign("title","部门管理");
		$smarty->assign('controller', 'JiChu_Department');
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign("arr_field_value",$rowset);
		$smarty->assign('add_url','?controller=JiChu_Department&action=add&parentId='.$_GET['parentId']);
		//$smarty->assign('arr_condition',$arr);
		$smarty->assign('pk', $pk);
		$smarty->assign("page_info",$this->showPathInfo());
		$smarty->display("TableList.tpl");
	}

	function _edit($aDep) {
		//$this->authCheck($this->funcId);
		$smarty = $this->_getView();
		$pk = $this->_modelExample->primaryKey;
		//dump($aDep);
		$smarty->assign('aDep',$aDep);
		$smarty->assign('pk', $pk);
		$smarty->assign('path_info',$this->showPathInfo($aDep));
		$smarty->display('JiChu/DepartmentEdit.tpl');
	}
	function actionAdd() {
		$func = array(
		    'id'  => null,
		    'parentId' => isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0,
		);
		$this->_edit($func);
	}
	function actionEdit() {
		$row = $this->_modelExample->getClass($_GET['id']);
		if (!$row) {
		    echo "无效分类 in actionEdit!";exit;
		}
		$this->_edit($row);
	}

	function actionSave() {
		//dump($_POST);exit;
		$arr=array(
		    'id'=>$_POST['id'],
		    'parentId'=>(int)$_POST['parentId'],
		    'depCode'=>$_POST['depCode'],
		    'depName'=>$_POST['depName']
		);
		if ($_POST['id']) {
		    // 更新分类
		    $class['id'] = $_POST['id'];
		    $this->_modelExample->updateClass($arr);
		} else {
		    // 创建分类
		    $this->_modelExample->createClass($arr, $_POST['parentId']);
		}
		redirect($this->_url("Right",array(
			"parentId"=>$_POST[parentId]
		)));
	}
	function actionRemove() {
		$this->_modelExample->removeByPkv($_GET[id]);
		redirect($this->_url("Right",array(
			"parentId" => $_GET[parentId]
		)));
	}

	function actionUpgrade() {
		//老部门数据
		$arr = array(
			'人力','港汽','港拖','铲车','叉车','港机','企管财务','机务','常务人秘','生产安保'
		);
		//清空原部门数据
		$sql = "truncate table jichu_department";
		mysql_query($sql);

		$sql = "update cangku_chuku set depId= depId+1";
		mysql_query($sql) or die(mysql_error());

		$sql = "update cangku_shenqing set depId= depId+1";
		mysql_query($sql) or die(mysql_error());

		//以无限分类模式重新插入第一级数据
		foreach($arr as & $v) {
			$class = array(
				'depCode'=>$v,
				'depName'=>$v
			);
			$this->_modelExample->createClass($class, 0);
		}

		//将汽车数据插入
		$sql = "select * from jichu_car";
		$query = mysql_query($sql);
		while ($re=mysql_fetch_assoc($query)){
			//dump($re);exit;
			$temp = array(
				'depCode'=>$re['carCode'],
				'depName'=>$re['carName']
			);
			$this->_modelExample->createClass($temp, $re['depId']+1);
		}
		echo '升级完毕';exit;
	}
	function actionPopup() {
		////////////////////////////////标题
		$title = '申请部门';
		///////////////////////////////模板文件
		$tpl = 'Popup/Common.tpl';
		///////////////////////////////表头
		$arr_field_info = array(
			//'id'=>'编号',
			'depCode'=>'部门代码',
			'depName'=>'部门名称'
		);
		///////////////////////////////搜索条件
		$arrCon = array(
			'key'=>''
		);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray($arrCon);
		///////////////////////////////模块定义

		TMIS_Pager::clearCondition();
		$str="select * from jichu_department where leftId+1=rightId";
		if($_GET['code']!='') $str.=" and (depName like '%{$_GET['code']}%' or depCode like '%{$_GET['code']}%')";
		if($arr['key']!='') $str.=" and (depName like '%{$arr['key']}%' or depCode like '%{$arr['key']}%')";
		$str .= " order by depCode";
		//echo $str;
		//$con=array('depName','%$_GET[code]%','like');
		//$pager =& new TMIS_Pager($str);
		$rowset =$this->_modelExample->findBySql($str);
		//$mm=array();
		/*foreach($rowset as & $v){
		    //dump($v);
		    if($v['leftId']+1!=$v['rightId']){
			$str="select * from jichu_department where leftId>'$v[leftId]' and rightId<'$v[rightId]'";
			$query=mysql_query($str);
			while($re=mysql_fetch_assoc($query)){
			    $rowset[]=$re;
			}
		    }
		}*/
		//dump($rowset);
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arrCon);

		/*///////////////grid,thickbox,///////////////*/
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display($tpl);
	}
	//申请登记时的部门
	function actionPopup1() {
		////////////////////////////////标题
		$title = '申请部门';
		///////////////////////////////模板文件
		$tpl = 'Popup/Common.tpl';
		///////////////////////////////表头
		$arr_field_info = array(
			//'id'=>'编号',
			'depCode'=>'部门代码',
			'depName'=>'部门名称'
		);
		///////////////////////////////搜索条件
		$arrCon = array(
			'key'=>''
		);
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray($arrCon);
		///////////////////////////////模块定义

		TMIS_Pager::clearCondition();
		$depId=array();
		$str="select y.leftId,y.rightId from acm_user2dep x left join jichu_department y on x.depId=y.id where x.userId='$_SESSION[USERID]'";
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
		    $depId[]= "(leftId>='{$re['leftId']}' and rightId<='{$re['rightId']}')";
		}
		//dump($depId);
		$str="select * from jichu_department where 1";
		if(count($depId)==0)$str.=" and leftId+1=rightId";
		if(count($depId)>0)$str.=" and (".join(' or ',$depId).")";
		if($_GET['code']!='') $str.=" and (depName like '%{$_GET['code']}%' or depCode like '%{$_GET['code']}%')";
		if($arr['key']!='') $str.=" and (depName like '%{$arr['key']}%' or depCode like '%{$arr['key']}%')";
		$str .= " order by depCode";
		//echo $str;
		//$con=array('depName','%$_GET[code]%','like');
		//$pager =& new TMIS_Pager($str);
		$rowset =$this->_modelExample->findBySql($str);
		if(count($depId)>0){
		    foreach($rowset as & $v){
			//dump($v);
			if($v['leftId']+1!=$v['rightId']){
			    $str="select * from jichu_department where leftId>'$v[leftId]' and rightId<'$v[rightId]'";
			    $query=mysql_query($str);
			    while($re=mysql_fetch_assoc($query)){
				$rowset[]=$re;
			    }
			}
		    }
		}
		//dump($rowset);
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arrCon);

		/*///////////////grid,thickbox,///////////////*/
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty-> display($tpl);
	}
	function actionGetJsonByKey(){
		 $str = "select * from jichu_department where leftId+1=rightId";
		if ($_GET['code']!='') $str .= " and (depName like '%$_GET[code]%' or depCode like '%$_GET[code]%')";
		//echo $str;exit;
        //$pager =& new TMIS_Pager($str);
        $rowset =$this->_modelExample->findBySql($str);
		echo json_encode($rowset);exit;
	}
	function showPathInfo($class = null) {

		$parentId = empty($class) ? (isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0): $class[parentId] ;
		if ($parentId) {
		$parent = $this->_modelExample->getClass($parentId);
		if (!$parent) {
		    echo "无效分类 in actionIndex!";exit;
		}

		/**
		 * 确定当前分类到顶级分类的完整路径
		 */
		$path = $this->_modelExample->getPath($parent);

		$path[] = $parent;

	    } else {
		$parent = null;
		$path = array();
	    }

		    $ret = "当前位置：<a href='" . $this->_url('right') ."'>根目录</a>";
		    foreach ($path as $part) {
			    $ret .= "-><a href='" . $this->_url('right',array("parentId"=>$part[id])). "'>$part[depName]</a>";
		    }
		    return $ret;
    }
     //移动节点界面
    function actionMoveNode() {
		//dump($_GET);exit;
        $arr = $this->_modelExample->find(array('id'=>$_GET['id']));
        $smarty = $this->_getView();

        $path = $this->_modelExample->getPath($arr);
        //dump($arr);exit;
        $smarty->assign('path_info',join('<font color=red>/</font>',array_col_values($path,'wareName')));

        $smarty->assign('aRow',$arr);
        $smarty->display('JiChu/DepartmentMove.tpl');
    }
    function actionMoveNodeSave() {
		//dump($_POST);exit;
		if(empty($_POST['parentId'])) {
			js_alert('父类未确定!');exit;
		}
        $sourceNode = $this->_modelExample->find(array('id'=>$_POST['sourceId']));
        $targetNode = $this->_modelExample->find(array('id'=>$_POST['parentId']));

        //dump($sourceNode);dump($targetNode);exit;
        if ($this->_modelExample->moveNodeAndChild($sourceNode,$targetNode)) {
			//修改深度
			$sourceNode['deepth'] = $targetNode['deepth']+1;
			$this->_modelExample->update($sourceNode);
            /*$log=array(
                'item'=>$this->title.' id '.$_POST['sourceId'].'->'.$_POST['parentId'],
                'action'=>'移动',
                'user'=>$_SESSION['USERNAME']
            );
            $this->mlog->save($log);*/
            redirect($this->_url('right',array(
				'parentId'=>$_POST['parentIdFrom']
			)));
        } else {
            echo "出错!";
		}
    }

    function actionSelParent() {
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		if($arr['key']=='') {
			//echo 1;
			$parentId = isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0;
			if ($parentId) {
				$parent = $this->_modelExample->getClass($parentId);
				if (!$parent) {
					echo "无效分类 in actionRight!";exit;
				}
				$subClasses = $this->_modelExample->getSubNodes($parent);
			} else {
				$subClasses = $this->_modelExample->getAllTopNodes();
			}
		} else {
			$key = trim($_GET['key'])=='' ? trim($_POST['key']) : trim($_GET['key']);
			$sql = "select * from jichu_department where (
				depCode like '%{$key}%' or
				depName like '%{$key}%')";
			//echo $sql;exit;

			$subClasses = $this->_modelExample->findBySql($sql);
		}
		//echo $sql;
		$arr_field_info = array(
		    "id"=>"系统编号",
				"depCode"=>"物料编码",
		    //"orderLine"=>"排列顺序<br>(点击修改)",
				'deepth'=>"级别深度",
		    "depName"=>"类名",
		    "showSub" => "查看子项",
		    "_edit" => "选择"
		);

		foreach($subClasses as & $v) {
			$json = htmlspecialchars(json_encode($v));

			if($v['leftId']+1<$v['rightId']) $v['showSub']= "<a href='".$this->_url('SelParent',array(
				'parentId'=>$v['id']
			))."'> > 进入</a>";
			$v['_edit']= "<a href='javascript:void(0)' onclick='ret({$json})'>选择</a>";
		}

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择类别');
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$subClasses);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        //$smarty->assign('s',$arr);
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/SelParent.tpl');
    }

	//利用ajax展开某个节点调用的函数
	function actionGetTreeJson(){
		$parentId = $_POST['value'] +0;
		$rowset = $this->_modelExample->getSubNodes($parentId);
		$ret = array();
		if($rowset) foreach($rowset as & $v){
			$ret[] = array(
				"id"=>$v['id'],//节点id
				"text"=> $v['depCode'].':'.$v['depName'],//标签文本
				"value"=> $v['id'],//值
				//"showcheck"=> false,//是否显示checkbox
				"isexpand"=> false,//是否展开,
				"checkstate"=> 0,//是否被选中
				"hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
				"ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
				"complete"=> $v['leftId']+1==$v['rightId'] ? true : false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
			);
		}
		echo json_encode($ret);exit;
	}

	//只返回包括了汽车的所有子节点。
	function actionGetTreeJson1(){
		$parentId = $_POST['value'] +0;
		$rowset = $this->_modelExample->getSubNodes($parentId);
		$ret = array();
		if($rowset) foreach($rowset as & $v){
			$ret[] = array(
				"id"=>$v['id'],//节点id
				"text"=> $v['depCode'].':'.$v['depName'],//标签文本
				"value"=> $v['id'],//值
				//"showcheck"=> false,//是否显示checkbox
				"isexpand"=> false,//是否展开,
				"checkstate"=> 0,//是否被选中
				"hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
				"ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
				"complete"=> $v['leftId']+1==$v['rightId'] ? true : false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
			);
		}
		echo json_encode($ret);exit;
	}

	function actionTest(){
		$tpl = 'Popup/SelDep.tpl';
		$ret = array();
	    //$ret = $this->getAllNode(0,$ret);
		$mDep = & FLEA::getSingleton("Model_Jichu_Department");
	    $ret = $mDep->getTopNode();
		 $smarty = & $this->_getView();
	    $smarty->assign('title','领用汇总报表');
	    $smarty->assign('data',json_encode($ret));
		$smarty->assign('ym',date('Y-m'));
		//dump($ret);exit;
	    $smarty->display($tpl);
		exit;
	}
}
?>