<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Acm_Func extends Tmis_Controller  {
	var $_modelFunc;
	var $funcId=22;
	function Controller_Acm_Func() {
		$this->_modelFunc = FLEA::getSingleton('Model_Acm_Func');
	}

	#tmisMenu用的object
	/**
	*取得tmisMenu用的对象
	*/
	function actionTmisMenu() {
		$subClasses = $this->_modelFunc->getSubNodes($_GET[parentId]);
		$ret="{items : [";
		for ($i=0;$i<count($subClasses);$i++) {
			$isD = ($subClasses[$i][rightId]-$subClasses[$i][leftId])>1?1:0;
			$value=$subClasses[$i][id];
			$text = $subClasses[$i][funcName];
			//$text .= !$isD&&$subClasses[$i][guige]!=""?("||".$subClasses[$i][guige]):"";
			$ret .= "{'value':$value,'isDirectory':$isD,'text':'$text'},";
		};
		$ret = substr($ret,0,-1);
		$ret .= "]}";
		echo $ret;exit;
	}

	function actionRight() {
		$this->authCheck(92);
		/**
         * 读取指定父分类下的直接子分类
         */
        $parentId = isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0;

        if ($parentId) {
            $parent = $this->_modelFunc->getClass($parentId);
            if (!$parent) {
                js_alert("无效分类 in actionIndex!",'add');
            }
            $subClasses = $this->_modelFunc->getSubNodes($parent);
        } else {
            $subClasses = $this->_modelFunc->getAllTopNodes();
        }
		$arrFieldInfo = array(
			"id"=>"编号",
			"funcName"=>"功能名",
			"showSub" => "查看子项"
		);
		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		if (count($subClasses)>0) {
			foreach($subClasses as &$row) {
				$row[showSub] = "<a href='?controller=Acm_Func&action=right&parentId=$row[id]'>查看子项目</a>";
			}
		}
		//dump($subClasses);

        $smarty = & $this->_getView();
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign("title","功能管理");
		$smarty->assign("arr_field_value",$subClasses);
        $smarty->assign('add_url',$this->_url('Add',array('parentId'=>$_GET['parentId'])));
		//$smarty->assign('search_display', 'none');
		$smarty->assign('pk','id');
		//dump($subClasses);exit;
		$smarty->assign("page_info",$this->showPathInfo());

		$smarty->display("TableList.tpl");
	}

	 /**
     * 创建新分类
     */
	function actionAdd() {
		$this->authCheck(93);
		$func = array(
            'id'  => null,
            'funcName'      => null,
            'parentId' => isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0,
        );
        $this->_edit($func);
	}

	 /**
     * 修改分类
     */
	function actionEdit() {
		$this->authCheck(93);
		$class = $this->_modelFunc->getClass((int)$_GET['id']);
        if (!$class) {
            echo "无效分类 in actionEdit!";exit;
        }
        $this->_edit($class);
	}

	/**
	*保存分类
	*/
	function actionSave() {
		$class = array(
            'funcName' => $_POST['funcName'],
        );
        __TRY();
        if ($_POST['id']) {
            // 更新分类
            $class['id'] = $_POST['id'];
            $this->_modelFunc->updateClass($class);
        } else {
            // 创建分类
            $this->_modelFunc->createClass($class, $_POST['parentId']);
        }

        $ex = __CATCH();
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), '', $this->_url('right'));
        }
		redirect($this->_url('right',array(
			"parentId"=>$_POST[parentId]
		)));
	}

	 /**
     * 删除分类
     */
	function actionRemove() {
		$this->authCheck(93);
		__TRY();
        $this->_modelFunc->removeClassById($_GET['id']);
        $ex = __CATCH();
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), '', $this->_getBack());
        }
        redirect($this->_url('right',array(
			"parentId" => $_GET[parentId]
		)));
	}

	/**
     * 显示添加或修改分类信息页面
     *
     * @param array $class
     */
	function _edit($class) {
		//$this->authCheck($this->funcId);
		$smarty = $this->_getView();
		$smarty->assign('path_info',$this->showPathInfo($class));
		$smarty->assign('aRow',$class);
		$smarty->display('Acm/FuncEdit.tpl');
	}

	 /**
     * 带链接显示路径,如: 1->1.1->1.1.1
     *
     * @param array $class
     *
     * @return int
     */
    function showPathInfo($class = null) {

		$parentId = empty($class) ? (isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0)
								  : $class[parentId] ;
		if ($parentId) {
            $parent = $this->_modelFunc->getClass($parentId);
            if (!$parent) {
                echo "无效分类 in actionIndex!";exit;
            }

            /**
             * 确定当前分类到顶级分类的完整路径
             */
            $path = $this->_modelFunc->getPath($parent);

            $path[] = $parent;

        } else {
            $parent = null;
            $path = array();
        }

		$ret = "当前位置：<a href='" . $this->_url('right') ."'>根目录</a>";
		foreach ($path as $part) {
			$ret .= "-><a href='" . $this->_url('right',array("parentId"=>$part[id])). "'>$part[funcName]</a>";
		}
		return $ret;
    }

   //设置权限
    function actionSetQx(){
	    $this->authCheck(67);
	    //获得第一级节点
	    //$rowset = $this->_modelFunc->getAllTopNodes();
	    $ret = array();
	    //$ret = $this->getAllNode(0,$ret);
	    $ret = $this->getTopNode();
	    //取得所有的组
	    $mRole = FLEA::getSingleton('Model_Acm_Role');
	    $rowRole = $mRole->findAll();
	    $smarty = & $this->_getView();
	    $smarty->assign('title','为组设置权限');
	    $smarty->assign('data',json_encode($ret));
	    $smarty->assign('rowRole',$rowRole);
	    $smarty->display("Acm/ShowFunc.tpl");
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
				//"isexpand"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否展开,
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
	//利用ajax展开某个节点调用的函数
	function actionGetTreeJson(){
		$parentId = $_POST['value'] +0;
		$rowset = $this->_modelFunc->getSubNodes($parentId);
		$ret = array();
		if($rowset) foreach($rowset as & $v){
			$ret[] = array(
				"id"=>$v['id'],//节点id
				"text"=> $v['funcName'],//标签文本
				"value"=> $v['id'],//值
				"showcheck"=> true,//是否显示checkbox
				"isexpand"=> false,//是否展开,
				"checkstate"=> 0,//是否被选中
				"hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
				"ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
				"complete"=> $v['leftId']+1==$v['rightId'] ? true : false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
			);
		}
		echo json_encode($ret);exit;
	}

	//从树形结构页面中以ajax方式提交过来的处理函数
	function actionAssignFuncByAjax(){
		//dump($_GET);exit;
		if(count($_GET['pSel'])>0){
		    #如部分选择存在
		    foreach($_GET['pSel'] as & $v){
			$str="select * from acm_funcdb where id='$v'";
			$rr=mysql_fetch_assoc(mysql_query($str));
			$str="select x.* from acm_func2role x
			    left join acm_funcdb y on y.id=x.funcId
			    where x.roleId='{$_GET['roleId']}' and y.leftId>'{$rr['leftId']}' and y.rightId<'{$rr['rightId']}'
			";
			$re=mysql_fetch_assoc(mysql_query($str));
			$mm[]=$re['id'];
		    }
		    #删除除了部分选择中的已分配关系
		    $sql = "delete from acm_func2role where roleId='{$_GET['roleId']}' and id not in(".join(array_unique($mm),',').")";
		    //echo $sql."<br>";exit;
		    mysql_query($sql);
		    //dump($mm);
		    
		}else{
		    //先删除相关角色下所有已经分配的权限关系
		    $sql = "delete from acm_func2role where roleId='{$_GET['roleId']}'";
		    $this->_modelFunc->execute($sql);
		}
		//exit;
		//过滤掉_GET['funcId']中父节点和所有子节点都被选中的节点，只保留父节点
		$path = array();
		if($_GET['funcId']) foreach($_GET['funcId'] as & $v) {
			$node = $this->_modelFunc->find(array('id'=>$v));
			$p = $this->_modelFunc->getPath($node);
			if($p) foreach($p as & $vv) {
				$path[$v][] = $vv['id'];
			} else $path[$v][]=null;
		}

		$ret = array();
		foreach($path as $key=>& $v) {
			if($v==null) $ret[] = array('id'=>$key);
			$found=false;
			if($v) foreach($v as $k=>& $vv) {
				if(in_array($vv,$_GET['funcId'])) {
					$found=true;
					break;
				}
			}
			if(!$found) $ret[] = array('id'=>$key);
		}

		$m = FLEA::getSingleton('Model_Acm_Func2Role');
		$i=0;
		foreach($ret as & $v){
		    $arr1=array(
			'id'=>'',
			'roleId'=>$_GET['roleId'],
			'funcId'=>$v['id']
		    );
		    if($m->save($arr1)) {
			$i++;
		    }
		}
		if($i==count($ret)) {
			echo '{"success":true}';
			exit;
		}
		echo '{"success":false,"msg":"出错"}';
		//dump($arr);exit;
		//$this->_modelFunc->getSubTree
		//保存
	}
}
?>