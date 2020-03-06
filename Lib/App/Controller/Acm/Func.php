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
			$ret .= "{value:$value,isDirectory:$isD,text:'$text'},";
		};
		$ret = substr($ret,0,-1);
		$ret .= "]}";
		echo $ret;exit;	
	}

	function actionRight() {
		$this->authCheck($this->funcId);
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
		$this->authCheck($this->funcId);
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
}
?>