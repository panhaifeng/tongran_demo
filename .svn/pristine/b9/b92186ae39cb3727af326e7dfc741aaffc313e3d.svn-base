<?php
FLEA::loadClass('TMIS_Nodes');
class Model_JiChu_Department extends TMIS_Nodes {
    var $tableName = 'jichu_department';
    var $primaryKey = 'id';
    var $primaryName = 'depName';


    /**
     * 取得指定 ID 的分类
     *
     * @param int $classId
     *
     * @return array
     */
    function getClass($classId) {
        return $this->find((int)$classId);
    }

    /**
     * 创建新分类，并返回新分类的 ID
     *
     * @param array $class
     * @param int $parentId
     *
     * @return int
     */
    function createClass($class, $parentId) {
        return $this->create($class, $parentId);
    }

    /**
     * 更新分类信息
     *
     * @param array $class
     *
     * @return boolean
     */
    function updateClass($class) {
        return $this->update($class);
    }

    /**
     * 删除指定的分类及其子分类树
     *
     * @param array $class
     *
     * @return boolean
     */
    function removeClass($class) {
        return $this->remove($class);
    }

    /**
     * 删除指定 ID 的分类及其子分类树
     *
     * @param int $classId
     *
     * @return boolean
     */
    function removeClassById($classId) {
		parent::removeByPkv($classId);
		return true;
    }

    /**
     * 获取指定分类同级别的所有分类
     *
     * @param array $node
     *
     * @return array
     */
    function getCurrentLevelClasses($class) {
        return $this->getCurrentLevelNodes($class);
    }

    /**
     * 计算所有子分类的总数
     *
     * @param array $class
     *
     * @return int
     */
    function calcAllChildCount($class) {
        return parent::calcAllChildCount($class);
    }




    function getSubNodes($node) {
        if (is_array($node)) $pkv = $node[$this->primaryKey];
        else $pkv = $node;
        $conditions = "{$this->_parentNodeFieldName} = '$pkv'";
        //$sort = $this->_leftNodeFieldName . ' ASC';
        $sort = 'depCode asc';
        return $this->findAll($conditions, $sort);
    }

    /**
     * 获取所有顶级节点（既 _#_ROOT_NODE_#_ 的直接子节点）
     *
     * @return array
     */
    function getAllTopNodes() {
    //$conditions = "{$this->_parentNodeFieldName} = 0";
        $conditions=array(
            $this->_parentNodeFieldName=>'0'
        );
        $sort = 'depCode ASC';
        //$sort = 'orderLine';
        $rowset = $this->findAll($conditions, $sort);
        //$dbo = &FLEA::getDBO(false);dump($dbo->log);exit;
        return $rowset;
    }
	
	//只得到顶级节点,形成treeview能用的格式
	function getTopNode($parentId) {
		$rowset = $this->getAllTopNodes();
		$arr = array();
		if($rowset) foreach($rowset as & $v){
			$temp = array(
				"id"=>$v['id'],//节点id
				"text"=> $v['depCode'].':'.$v['depName'],//标签文本
				"value"=> $v['id'],//值
				//"showcheck"=> true,//是否显示checkbox
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

	//单车报表中只得到顶级节点,形成treeview能用的格式
	function getTopNode1($parentId) {
		$rowset = $this->getAllTopNodes();	
		//$rowset = $this->findBySql($sql);
		$arr = array();
		if($rowset) foreach($rowset as & $v){
			$temp = array(
				"id"=>$v['id'],//节点id
				"text"=> $v['depCode'].':'.$v['depName'],//标签文本
				"value"=> $v['id'],//值
				//"showcheck"=> true,//是否显示checkbox
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
}