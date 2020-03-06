<?php
FLEA::loadClass('TMIS_Nodes');
class Model_JiChu_Ware extends TMIS_Nodes {
    var $tableName = 'jichu_ware';
    var $primaryKey = 'id';
    var $primaryName = 'wareName';


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
    //判断是否存在入库记录
        $_model=FLEA::getSingleton('Model_CangKu_RuKu2Ware');
        if (!$_model->find("wareId='$classId'")) {
            parent::removeByPkv($classId);
            return true;
        };
        return false;
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

    /**
     *判断染料是否是助剂
     */
    function isZhuji($pkv) {
        $zj=$this->findByField('wareName','助剂类');
        $leftId = $zj[leftId];
        $rightId = $zj[rightId];

        $tZj = $this->find($pkv);
        if($tZj[leftId]>$leftId&&$tZj[rightId]<$rightId) return true;
        return false;
    }


    function getSubNodes($node) {
        if (is_array($node)) $pkv = $node[$this->primaryKey];
        else $pkv = $node;
        $conditions = "{$this->_parentNodeFieldName} = '$pkv' and isDel=0";
        //$sort = $this->_leftNodeFieldName . ' ASC';
        $sort = 'wareCode asc';
        return $this->findAll($conditions, $sort);
    }


    function getSubNodes1($node) {
        if (is_array($node)) $pkv = $node[$this->primaryKey];
        else $pkv = $node;
        //$conditions = "{$this->_parentNodeFieldName} = '$pkv'";
        $conditions=array(
            $this->_parentNodeFieldName=>$pkv,
            'isDel'=>'0',
        );
        //$sort = $this->_leftNodeFieldName . ' ASC';
        $sort = 'wareCode asc';
        return $this->findAll($conditions, $sort);
    }

    /**
     * 获取所有顶级节点（既 _#_ROOT_NODE_#_ 的直接子节点）
     *
     * @return array
     */
    function getAllTopNodes1() {
    //$conditions = "{$this->_parentNodeFieldName} = 0";
        $conditions=array(
            $this->_parentNodeFieldName=>'0',
            'isDel'=>'0',
			array('id','5','<>'),
        );
        $sort = $this->_leftNodeFieldName . ' ASC';
        //$sort = 'orderLine';
        $rowset = $this->findAll($conditions, $sort);
        //$dbo = &FLEA::getDBO(false);dump($dbo->log);exit;
        return $rowset;
    }
	function getAllTopNodes() {
        $conditions = "{$this->_parentNodeFieldName} = 0 and isDel=0";
        $sort = $this->_leftNodeFieldName . ' ASC';
        return $this->findAll($conditions, $sort);
    }
	//只得到顶级节点,形成treeview能用的格式
	function getTopNode($parentId) {
		$rowset = $this->getAllTopNodes();
		$arr = array();
		if($rowset) foreach($rowset as & $v){
			$temp = array(
				"id"=>$v['id'],//节点id
				"text"=> $v['wareCode'].':'.$v['wareName'] . ($v['guige']==''?'':" {$v['guige']}"),//标签文本
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
	function getKucun($wareId){
		#初始化
		$str="select * from cangku_kucun where wareId='{$wareId}'";
		$init=mysql_fetch_assoc(mysql_query($str));
		#入库
		$str="select sum(cnt) as cnt from cangku_ruku2ware where wareId='{$wareId}'";
		$ruku=mysql_fetch_assoc(mysql_query($str));
		#出库
		$str="select sum(cnt) as cnt from cangku_chuku2ware where wareId='{$wareId}'";
		$chuku=mysql_fetch_assoc(mysql_query($str));
		$arr['cnt']=$init['initCnt']+$ruku['cnt']-$chuku['cnt'];
		return $arr;
	}
	function getJqDanjia($wareId){
		$m = FLEA::getSingleton('Model_Cangku_Kucun');
		//初始
		$sql = "select * from cangku_kucun where wareId='{$wareId}'";
		$rowset = $this->findBySql($sql);
		//dump($rowset);
		$initCnt = $rowset[0]['initCnt'];
		$initMoney = $rowset[0]['initMoney'];

		//修改本月加权单价
		//所有入库
		$sql = "select sum(x.cnt*x.danjia) money,sum(x.cnt) as cnt
			from cangku_ruku2ware x
			inner join cangku_ruku y on x.rukuId=y.id
			where x.wareId='{$wareId}'
		";
		//echo $sql;
		$rowset = $this->findBySql($sql);
		$rukuCnt = $rowset[0]['cnt'];
		$rukuMoney = $rowset[0]['money'];
		//所有本期之前的出库
		$sql = "select sum(x.cnt*x.danjia) money,sum(x.cnt) as cnt
			from cangku_chuku2ware x
			inner join cangku_chuku y on x.chukuId=y.id
			where x.wareId='{$wareId}'
		";
		//echo $sql;exit;
		$rowset = $this->findBySql($sql);
		$chukuCnt = $rowset[0]['cnt'];
		$chukuMoney = $rowset[0]['money'];

		$cnt = $initCnt+$rukuCnt-$chukuCnt;
		if($cnt==0) $danjia=0;
		else {
			$money = $initMoney + $rukuMoney - $chukuMoney;
			$danjia = round($money/$cnt,3);
		}
		return $danjia;
	}
}