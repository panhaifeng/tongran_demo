<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Yuling extends Tmis_Controller {
	var $funcId=52;
	function Controller_CangKu_Yuling() {
		$this->_modelRuku = & FLEA::getSingleton('Model_CangKu_RuKu');
        $this->_modelChuku = & FLEA::getSingleton('Model_CangKu_ChuKu');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
        $this->_modelChuku2Ware = & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $this->_modelRuku2Ware = & FLEA::getSingleton('Model_CangKu_RuKu2Ware');
        $this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
    }
    /**
     * ps ：预领纱登记列表界面
     * Time：2017年12月5日 11:13:06
     * @author zcc
     * @param 参数类型
     * @return 返回值类型
    */
    function actionYuLingList(){
        // $this->authCheck();
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            'wareName'=>'',
            'guige' =>'',
            'chandi'=>'',
            'pihao'=>'',
        ));
        //入库数据 kind =0 为客户坯纱仓库，1 为本厂坯纱仓库（也就是一个厂里不同的库位）
        $sqlRuku = "SELECT
                pihao,wareId,chandi,SUM(cnt) as cntRuku,0 as cntChuku,w.wareName,w.guige,x.supplierId as clientId
            FROM
                cangku_ruku x
            LEFT JOIN cangku_ruku2ware y ON x.id = y.ruKuId
            LEFT JOIN jichu_ware w on w.id = y.wareId
            WHERE 1 AND x.kind = 0";
        $sqlRuku .= " GROUP BY wareId,chandi,pihao,x.supplierId";

        $sqlChuku = "SELECT 
                pihao,wareId,chandi,0 as cntRuku,SUM(cnt) as cntChuku,w.wareName,w.guige,y.supplierId as clientId
            FROM
                cangku_chuku x
            LEFT JOIN cangku_chuku2ware y ON x.id = y.chukuId
            LEFT JOIN jichu_ware w on w.id = y.wareId
            WHERE 1 AND y.kind =0";
        $sqlChuku .= " GROUP BY wareId,chandi,pihao,y.supplierId";

        $sql = "SELECT pihao,wareId,chandi,SUM(cntRuku-cntChuku) as kucun,wareName,guige,c.compName,c.id as clientId
            FROM 
                ($sqlRuku union $sqlChuku) a 
            left JOIN jichu_client c on c.id = a. clientId    
            WHERE 1 ";
        if ($_GET['clientId']) {
            $sql .= " AND c.id = '{$_GET['clientId']}'";
        }
        if ($arr['wareName']) {
            $sql .= " AND a.wareName = '{$arr['wareName']}'";
        }
        if ($arr['guige']) {
            $sql .= " AND a.guige = '{$arr['guige']}'";
        }
        if ($arr['chandi']) {
            $sql .= " AND a.chandi = '{$arr['chandi']}'";
        }
        if ($arr['pihao']) {
            $sql .= " AND a.pihao = '{$arr['pihao']}'";
        }     
        $sql .= " GROUP BY a.wareId,a.chandi,a.pihao,a.clientId order by a.clientId,a.pihao";    
        $pager = & new TMIS_Pager($sql);
        $rowset=$pager->findAll();
        foreach ($rowset as &$v) {
            // $v['_edit'] = "<a href='".$this->_url('YuAdd',array('id'=>$v['YuAdd']))."'>预领纱登记</a>";
        }
        $heji = $this->getHeji($rowset,array('kucun'),'compName');
        $rowset[] = $heji;
        $arrFieldInfo = array(
            'compName'      => '客户',
            'pihao'         => '批号',
            'chandi'        => '产地',
            'wareName'      => '纱支',
            'guige'         => '规格',
            'kucun'         => '库存',
            // '_edit'         => '操作',
        );

        $smarty = & $this->_getView();
        $smarty->assign('title','入库登记');
        //$smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('tip','calendar','thickbox')));
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr+$_GET)));
        // $smarty->display('TableList2.tpl');  
        $smarty-> display('Popup/Popup2.tpl');      
    }
    /**
     * ps ：预领纱登记界面
     * Time：2017年12月5日 14:13:10s    
     * @author zcc
    */
    function actionAdd(){
    	$this->authCheck(52);
        $arr['ruKuNum'] = $this->GetNewYulingCode('YL','cangku_ruku','ruKuNum');
        $smarty = & $this->_getView();
        $smarty->assign('title', "松筒预领纱");
        $smarty->assign('aRow',$arr);
        $smarty->assign('user_id', $_SESSION['USERID']);
        $smarty->assign('real_name', $_SESSION['REALNAME']);
        $smarty->display('CangKu/YulingEdit.tpl');
    }
    /**
     * ps ：预领保存
     * Time：2017年12月7日 13:21:45
     * @author zcc
    */
    function actionSave(){
        // dump($_POST);die();
        $modelRuku = & FLEA::getSingleton('Model_CangKu_RuKu');
        $rukuNum =  $this->GetNewYulingCode('YL','cangku_ruku','ruKuNum');
        //先是 让松筒库位数据入库 然后把原库位 数量进行负数的入库
        // ps:kind 为 相当于大库位 而kuwei 是区分小的的
        for ($i=0;$i<count($_POST['cnt']);$i++){
            if(empty($_POST['wareId'][$i]) || empty($_POST['cnt'][$i])) continue;
            $rukuSon[] = array(
                'id'      => $_POST['id'][$i],
                'ruKuId'  => $_POST['rukuId'][$i],
                'wareId'  => $_POST['wareId'][$i],
                'cnt'     => $_POST['cnt'][$i],
                'chandi'  => $_POST['chandi'][$i],
                'pihao'   => $_POST['pihao'][$i],
                'cntJian' => $_POST['cntJian'][$i],
                'kuwei'   =>'1',
            );
        }
        $ruku = array(
            'id' => $_POST['rukuId'],
            'ruKuNum' =>$rukuNum,
            'ruKuDate'  => empty($_POST['ruKuDate'])?date("Y-m-d"):$_POST['ruKuDate'],
            'supplierId' => $_POST['clientId'],
            'isYuling' => '1',
            'memo' => $_POST['memo'],
            'Wares' => $rukuSon
        );
        // dump($ruku);exit;
        $id = $modelRuku->save($ruku);
        $ruId=$_POST['rukuId']==''?$id:$_POST['rukuId'];
        $ret=$modelRuku->find(array('id'=>$ruId));
        foreach ($ret['Wares'] as & $v){
            if ($v['yulingId']>0) {
               continue;
            }
            //找正入库数据有没有对应的负数据？
            $yuling = $this->_modelRuku2Ware->find(array('yulingId'=>$v['id']));
            if ($yuling) {//存在 则为修改
                $rukuSon2[] = array(
                    'id'       =>$yuling['id'],
                    'ruKuId'   =>$yuling['ruKuId'],
                    'wareId'   =>$v['wareId'],
                    'cnt'      =>$v['cnt']*(-1),
                    'chandi'   =>$v['chandi'],
                    'pihao'    =>$v['pihao'],
                    'cntJian'  =>$v['cntJian']*(-1),
                    'kuwei'    =>'0',
                    'yulingId' =>$yuling['yulingId']
                );
            }else{
                $rukuSon2[] = array(
                    'id'       =>'',
                    'ruKuId'   =>$ruId,
                    'wareId'   =>$v['wareId'],
                    'cnt'      =>$v['cnt']*(-1),
                    'chandi'   =>$v['chandi'],
                    'pihao'    =>$v['pihao'],
                    'cntJian'  =>$v['cntJian']*(-1),
                    'kuwei'    =>'0',
                    'yulingId' =>$v['id']
                );
            }
            
        }
        // dump($rukuSon2);die();
        $this->_modelRuku2Ware->saveRowset($rukuSon2);
        js_alert('保存成功', '', $this->_url('Right'));
        
    }
    /**
     * ps ：预领纱修改
     * Time：#TM_TH_DTTM
     * @author zcc
    */
    function actionEdit(){
        $modelRuku = & FLEA::getSingleton('Model_CangKu_RuKu');
        $arr = $modelRuku->find($_GET['id']);
        //yulingId=0 只取每对 对应的一条数据
        $sql = "SELECT y.*,w.wareName,w.guige,w.unit
            FROM cangku_ruku x 
            left join cangku_ruku2ware y on x.id = y.ruKuId
            left join jichu_ware w on w.id = y.wareId
            where 1 AND x.id = '{$_GET['id']}' AND y.yulingId=0";
        $arr2 = $this->_modelRuku->findBySql($sql);
        $arr['Wares'] = $arr2;    
        $smarty = & $this->_getView();
        $smarty->assign('title', "松筒预领纱");
        $smarty->assign('aRow',$arr);
        $smarty->assign('user_id', $_SESSION['USERID']);
        $smarty->assign('real_name', $_SESSION['REALNAME']);
        $smarty->display('CangKu/YulingEdit.tpl');
    }
    /**
     * ps ：预领纱查询界面删除（整单删除）
     * Time：2017年12月7日 16:23:14
     * @author zcc
    */
    function actionRemove(){

        $modelRuku = & FLEA::getSingleton('Model_CangKu_RuKu');
        $ruku=$modelRuku->find(array('id'=>$_GET['id']));
        $id = $ruku['Wares'][0]['id'];
        // $sql = "SELECT x.id
        //     FROM cangku_chuku x 
        //     where x.yulingId = {$id}";
        // $ret=$this->_modelChuku->findBySql($sql);
        if($modelRuku->removeByPkv($_GET['id'])){//删除入库
            js_alert("成功删除","",$this->_url('Right'));
        }else{
            js_alert('出错，不允许删除!','',$this->_url('Right'));
        }
    }
    /**
     * ps ：修改界面中删除按钮删除（ajax）
     * Time：2017年12月7日 16:23:18
     * @author zcc
    */
    function actionRemoveAjax(){
        $modelRuku2Ware = & FLEA::getSingleton('Model_CangKu_RuKu2Ware');
        $modelChuku2Ware = & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        //分别删除 单行的两条不同kuwei 正负值的id
        $sql = "SELECT x.id as rukuId
            FROM cangku_ruku2ware x 
            where 1 AND x.yulingId = {$_GET['id']}";
        $ret=$this->_modelChuku->findBySql($sql);
        $modelRuku2Ware->removeByPkv($_GET['id']);
        $modelRuku2Ware->removeByPkv($ret[0]['rukuId']);
        $arr = array(
            'success'=>true,
            'msg'=>'删除成功'
        );
        echo json_encode($arr);exit;
    }
    /**
     * ps ：预领纱查询
     * Time：2017年12月7日 15:30:57
     * @author zcc
    */
    function actionRight(){
    	$this->authCheck(52);
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            clientId=>0,
            dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            dateTo=>date("Y-m-d"),
            wareName=>'',
            'guige'=>'',
            'chandi'=>'',
            'pihao'=>'',
        ));
        $sql = "SELECT x.id as ruKuId,x.ruKuNum,x.ruKuDate,c.compName,w.wareName,w.guige,y.pihao,y.chandi,y.cnt
            FROM cangku_ruku x 
            left join cangku_ruku2ware y on x.id = y.ruKuId
            left join jichu_client c on c.id = x.supplierId
            left join jichu_ware w on w.id = y.wareId
            where 1 AND x.isYuling = 1 AND y.yulingId=0";
        if ($arr[dateFrom]) $sql .= " AND x.ruKuDate >= '$arr[dateFrom]' and x.ruKuDate<='$arr[dateTo]'";    
        if ($arr[clientId]>0) $sql .= " AND x.supplierId='$arr[clientId]'";
        if ($arr['wareId']>0) {
            $sql.=" and y.wareId='{$arr['wareId']}'";
        }
        if ($arr['wareName']) {
            $sql.=" and w.wareName like '%{$arr['wareName']}%'";
        }
        if ($arr['guige']) {
            $sql.=" and w.guige like '%{$arr['guige']}%'";
        }
        if ($arr['chandi']) {
            $sql.=" and y.chandi like '%{$arr['chandi']}%'";
        }
        if ($arr['pihao']) {
            $sql.=" and y.pihao like '%{$arr['pihao']}%'";
        }
        $pager = & new TMIS_Pager($sql);
        $rowset =$pager->findAll();
        foreach ($rowset as &$v) {
           $v['_edit'] = "<a href='".$this->_url('Edit',array('id'=>$v['ruKuId']))."'>修改</a>"; 
           $v['_edit'] .= "  |  <a href='".$this->_url('Remove',array(
                'id'=>$v['ruKuId']
            ))."' onclick='return confirm(\"您确认要整单删除吗？\");'>删除</a>";
        }
        $heji = $this->getHeji($rowset,array('cnt'),'ruKuNum');
        $rowset[] = $heji;
        $smarty = & $this->_getView();
        $arrFieldInfo = array(
            'ruKuNum'   =>'单号',
            'ruKuDate'  =>'日期',
            'compName'  =>'客户',
            'wareName'  =>'货品名称',
            'guige'     =>'规格',
            'pihao'     =>'批号',
            'chandi'    =>'产地',
            'cnt'       =>'预领数量',
            '_edit'     =>'操作',
        );

        $smarty->assign('title','预领纱查询');
        $smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('add_display',none);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty->display('TableList.tpl');
    }
    function GetNewYulingCode($head,$tblName,$fieldName){
        $m = & FLEA::getSingleton('Model_Acm_User');
        $ym=$head.date("ym");
        $sql = "select {$fieldName} from {$tblName} where {$fieldName} like '{$ym}___' order by {$fieldName} desc limit 0,1";
        $arr=$m->findBySql($sql);
        $max = $arr[0][$fieldName];
        $temp = $head.date("ym")."001";
        if ($temp>$max) return $temp;
        $a = substr($max,-3)+1001;
        return substr($max,0,-3).substr($a,1);
    }
}
?>