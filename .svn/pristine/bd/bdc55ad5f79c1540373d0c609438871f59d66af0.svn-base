<?php
FLEA::loadClass('TMIS_Nodes');
class Model_Acm_Func extends TMIS_Nodes {
	var $tableName = 'acm_funcdb';
	var $primaryKey = 'id';
	var $primaryName = 'funcName';	
	var $manyToMany = array(		
		array (
			'tableClass' => 'Model_Acm_Role' ,			
			'mappingName' => 'roles',
			'joinTable' => 'acm_func2role',
			'foreignKey' => 'funcId',
			'assocForeignKey' => 'roleId'
		)
	);
	
	/**
	取得对应的role
	**/
	function getRoles($funcId) {
		$arr = $this->find($funcId);
		return $arr[roles];
	}

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
        return $this->removeByPkv($classId);
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
        return $this->calcAllChildCount($class);
    }	
	
	/**
	*判断该结点的父结点是否被分配过,
	*在为一个role分配新的func时需要用到
	*/
	function isAssigned($funcId,$roleId) {
		#1,取得funcid的所有parentid
		$aFunc = $this->find($funcId);
		$arr = $this->getPath($aFunc);		
		$arrParentId = count($arr)>0 ? array_col_values($arr,'id') : array();		
		
		#取得所有的与roleid关联的funcid,然后取交集判断是否存在。
		$modelRole = FLEA::getSingleton('Model_Acm_Role');
		$aRole = $modelRole->find($roleId);
		$arrAssigenedFuncId = count($aRole[funcs])>0?array_col_values($aRole[funcs],'id'):array();
		if (count(array_intersect($arrParentId,$arrAssigenedFuncId))>0) return true;		
		return false;
	}
}