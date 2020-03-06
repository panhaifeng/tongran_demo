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

    //根据userId判断哪些目录节点需要隐藏,
    function changeVisible(&$node,$arr) {
        FLEA::loadClass('Model_Acm_User');
        $m = & FLEA::getSingleton('Model_Acm_User');
        if($arr['userName']=='admin') return $node;
        //dump($arr);exit;
        //得到用户属于的组
        if(!$arr['roles']) {
            $sql = "select group_concat(roleId) as roles
                from acm_user2role x
                left join acm_userdb y on x.userId=y.id
                where y.userName='{$arr['userName']}'";
            //dump($sql);exit;
            $r = $m->findBySql($sql);
            if($r[0]['roles']=='') {
                $node['hidden']=true;
                return false;
            }
            $arr['roles'] = $r[0]['roles'];
        }
        if($node['leaf']) {
            //如果未定义id,可见
            if(!isset($node['id'])) return $node;
            //在数据库中查找是否可使用当前节点
            $sql = "select count(*) cnt from acm_func2role x
                where (x.funcId like '{$node['id']}-%' or x.funcId='{$node['id']}') and roleId in({$arr['roles']})";
            //dump($node);
            $r = $m->findBySql($sql);
            if($r[0]['cnt']==0) {
                $node['hidden']=true;
                return false;
            }
            return $node;
        } else {//如果是目录
            //在数据库中查找，如果没有子功能可以访问，目录消失
            $sql = "select count(*) cnt from acm_func2role x
                where (x.funcId like '{$node['id']}-%' or x.funcId='{$node['id']}') and roleId in({$arr['roles']})";
            $r = $m->findBySql($sql);
            if($r[0]['cnt']==0) {
                //子节点里是否有未定义id的节点，如果有,可见
                $f = $this->_noIdInChildren($node);
                if(!$f) {//如果不存在未定义id的子节点，隐藏
                    $node['hidden']=true;
                    return false;
                }

            }

            //构造返回值
            $r = array();
            // dump($node);exit;
            foreach($node as $k=>& $v) {
                if($k=='children') continue;
                $r[$k] = $v;
            }
            //循环处理children
            foreach($node['children'] as $k=>& $v) {
                $a = $this->changeVisible($v,$arr);
                if($a) $r['children'][] = $a;
            }
            return $r;
        }
    }

}