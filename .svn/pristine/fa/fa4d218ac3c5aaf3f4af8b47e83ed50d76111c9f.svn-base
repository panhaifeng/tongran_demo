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

    /**
     *得到坯纱规格档案的顶级节点
     */
    function getTopNodeOfPisha() {
        return $this->find("wareName='坯纱'");
    }

    /**
     *得到染料规格档案的顶级节点
     */
    function getTopNodeOfRanliao() {
    }

    #判断某个纱支是否是化纤
    /*function isHuaxian($pkv) {
        $parent = $this->find(array('wareName'=>'化纤类'));

        $ware = $this->find(array('id'=>$pkv));
        //dump($ware['leftId'].$parent['leftId'] . $ware['rightId'].$parent['rightId']);dump($ware);exit;
        if (!($ware['leftId']<$parent['leftId']) && !($ware['rightId']>$parent['rightId'])) {
            return true;
        }
        return false;
    }*/
	function isHuaxian($pkv) {
		// $str="select * from jichu_ware where (wareName='CVC' or wareName='T/C' or wareName='涤粘TR' or wareName='40/2TR中长')";
        $str="select * from jichu_ware where wareName='双染'";// by zcc 2017年9月6日  设计一个双染大类让这个大类中都可以双染
		$arr=$this->findBySql($str); 
        $ware = $this->find(array('id'=>$pkv));
        //dump($ware['leftId'].$parent['leftId'] . $ware['rightId'].$parent['rightId']);dump($ware);exit;
		$i=0;
		if(count($arr)>0)foreach($arr as & $v){
			if (!($ware['leftId']<$v['leftId']) && !($ware['rightId']>$v['rightId'])) {
				//return true;
				$i++;
			}
		}
		if($i>0)return true;
        return false;
    }
    function getSubNodes($node) {
        if (is_array($node)) $pkv = $node[$this->primaryKey];
        else $pkv = $node;
        $conditions = "{$this->_parentNodeFieldName} = '$pkv'";
        //$sort = $this->_leftNodeFieldName . ' ASC';
        $sort = 'guige asc';
        return $this->findAll($conditions, $sort);
    }

    #将最后的S作为上标显示
    function formatGuige($guige) {
        if(!$guige) return '';
        $guige = str_replace('s','<sup>s</sup>',$guige);
        $guige = str_replace('S','<sup>s</sup>',$guige);
        return $guige;
    }

    #得到纱支的规格说明,简写和<sup>
    function getGuigeDesc($pkv) {
        $arr = $this->find(array('id'=>$pkv));
        if($arr['mnemocode']) return $this->formatGuige($arr['mnemocode']);
        return $this->formatGuige($arr['wareName'].' '.$arr['guige']);
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
        $sort = 'orderLine asc';
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

     /**
     * 获取坯纱下面的子节点节点
     *
     * @return array
     */
    function getTopClass($wareId, $parentId){
        $conditions=array(
            'isDel'=>'0',
        );
        $sort = $this->_leftNodeFieldName . ' ASC';
        $rowset = $this->findAll($conditions, $sort,null,'id,parentId');
        $topId = $this->findParent($parentId,$rowset,$temp);
        return $topId;
    }

    function findParent($parentId, $rowset=array(), &$temp){
        if($temp>0){
            return $temp;
        }else{
            $temp = 0;
            foreach ($rowset as $k => &$v) {
                if($parentId == $v['id']){
                    if($v['parentId'] == 2){
                        $temp = $temp==0? $v['id']:$temp;
                        break;  
                    }else{
                        $this->findParent($v['parentId'],$rowset , $temp);
                        break;
                    }
                }
            }
        }
        return $temp;
    }
}