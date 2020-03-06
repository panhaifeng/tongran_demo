<?php
/**
 * 员工产量工资的审核页面，相当于财务过账功能
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_Confirm extends Tmis_Controller {
    var $_modelExample;
    var $funcId = 143;
    function Controller_CaiWu_Confirm() {
        /*if(!$this->authCheck()) die("禁止访问!");*/
        
        $this->leftCaption = '员工产量审核';      
        $this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Wages');
    }   
    
    function actionListGuozhang(){
        $this->authCheck($this->funcId);
        FLEA::loadClass("TMIS_Pager");
        $arr = &TMIS_Pager::getParamArray(array(
            "dateFrom" => date('Y-m-01'),
            "dateTo" => date('Y-m-d'),
            'orderCode'=>'',
            'workerId'=>'',
            'clientId'=>'',
        ));
        $sql="SELECT x.*,r.compName,w.orderCode,y.vatNum,u.wareName,i.perName
            FROM dye_chanliang x 
            LEFT JOIN plan_dye_gang y on x.gangId=y.id
            LEFT JOIN trade_dye_order2ware z on y.order2wareId=z.id
            LEFT JOIN trade_dye_order w on z.orderId = w.id
            LEFT JOIN jichu_client r on r.id=w.clientId
            LEFT JOIN jichu_ware u on u.id=z.wareId
            LEFT JOIN jichu_gxperson i on i.id=x.workerId
            LEFT JOIN caiwu_wages_guozhang f on f.chanliangId=x.id
            where 1 and x.danjia>0 and f.id is null";

        if($arr['dateFrom'] !=''){
            $sql.=" and dateInput>='{$arr['dateFrom']}' and dateInput<='{$arr['dateTo']}'";
        }

        if($arr['orderCode']!='') $sql .=" and w.orderCode like '%{$arr['orderCode']}%' ";
        if($arr['workerId']!='') $sql .=" and x.workerId='{$arr['workerId']}' ";
        if($arr['clientId']!='') $sql .=" and w.clientId='{$arr['clientId']}' ";
        // $sql.=" order by chukuDate desc,orderCode desc";
        $pager = &new TMIS_Pager($sql);
        $rowset = $pager->findAll();

        foreach ($rowset as & $v) {
            $sqlLuoji = "select vatCode from jichu_vat where id='{$v['vatId']}'";
            $gangluoJi = $this->_modelExample->findBySql($sqlLuoji);
            $v['vatCode'] = $gangluoJi[0]['vatCode'];
            $sql = "select gongxuName from jichu_chanliang_gongxu where id='{$v['gxIds']}'";
            $gName = $this->_modelExample->findBySql($sql);
            $v['gongxuName'] = $gName[0]['gongxuName'];
            $hj['_edit']='合计';
            $v['danjia']=round($v['danjia'],3);
            $v['money']=round($v['money'],2);
            $v['cntK']=round($v['cnt'],2);
            $hj['cntK'] += $v['cntK'];
            $hj['cntK'] = round($hj['cntK']);
            $v['_edit']="<input type='checkbox' id='chk[]' name='chk[]' value='chanliangId:{$v['id']},cntK:{$v['cntK']},orderId:{$v['orderId']},clientId:{$v['clientId']},productId:{$v['productId']},chanliangDate:{$v['dateInput']},vatNum:{$v['vatNum']},gangId:{$v['gangId']},kind:{$v['type']},danjia:{$v['danjia']},money:{$v['money']},banci:{$v['banci']},workerId:{$v['workerId']}'/>";
            $heji += $v['money'];
            $hj['money']="<div id='heji' name='heji'>$heji</div>";
            $v['zhekouMoney']="<input type='text' id='zhekouMoney[]' name='zhekouMoney[]' value='{$v['zhekouMoney']}'size='3'/>"."<input type='hidden' id='oldZhekou[]' name='oldZhekou[]' value='{$v['zhekouMoney']}'/>";
            /*$v['_money']="<input type='text' id='_money[]' readonly='true' name='_money[]' value='{$v['money']}'size='3'/>";*/
            $v['_money'] = $v['money']."<input type='hidden' id='_money[]' name='_money[]' value='{$v['money']}'/>";
            $v['money']="<input type='text' id='money[]' readonly='true' name='money[]' value='{$v['money']}' size='3'/>"."<input type='hidden' id='oldMoney[]' name='oldMoney[]' value='{$v['money']}'/>";
            $v['memo']="<input type='text' id='memo[]' name='memo[]' value='{$v['memo']}' size='2'/>";
            $kindArr = array(
                '1'=>'松紧筒打包',
                '2'=>'装出笼',
                '3'=>'染色',
            );
            $v['kind'] = isset($kindArr[$v['type']])?$kindArr[$v['type']]:'';
        }
        $rowset[] = $hj;
        $arrFieldInfo = array(
            "_edit"     => array('text'=>"<input type='checkbox' id='checkedAll' title='全选/反选'/>",'width'=>40),
            "compName"  => '客户',
            'perName'   => '员工',
            "orderCode" => '订单号',
            "vatCode"   => '逻辑缸号',
            "vatNum"    => '缸号',
            "wareName"  => '纱织规格',
            "gongxuName"      => ' 工序名称',
            "cntK"      => '数量',
            "danjia"    => '单价',
            "_money"     => '发生金额',
            "zhekouMoney" => '附加金额',
            "money"     => '入账金额',
            'memo'     => '备注',
        );

        $smarty = &$this->_getView();
        $smarty->assign('title', '收发存报表');
        // $smarty->assign('pk', $this->_modelDefault->primaryKey);
        $smarty->assign('arr_field_info', $arrFieldInfo);
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_value', $rowset);
        $other_url="<button type='button' class='btn btn-info btn-sm' id='save2' name='save2'>保存</button>";
        $smarty->assign('other_url', $other_url);
        $smarty->assign('sonTpl', 'Caiwu/Confirm.tpl');
        $smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
        $smarty->display('TableListNews.tpl');
    }
    

    function actionSave() {
        //dump($_GET);die;
        $money=$_GET['money'];
        $memo=$_GET['memo'];
        $ids=json_decode($_GET['ids']);
        //dump($ids);die;
        foreach ($ids as $key=>&$v){
            $arr=array();
            $temp=explode(',',$v);
            foreach ($temp as &$t){
                $tempt=explode(':',$t);
                $arr[$tempt[0]]=$tempt[1].'';
            }
            $arr['guozhangDate']=date('Y-m-d');
            $arr['creater']=$_SESSION['REALNAME'];
            $arr['money'] = $money[$key];
            $arr['memo'] = $memo[$key];
            // dump($arr);die;
            $arr['workerCode'] = $arr['workerId'];
            $id=$this->_modelExample->save($arr);
        }
        echo json_encode('true');exit;
    }

    function actionRemove() {
        $pk=$this->_modelExample->primaryKey;
        $this->_modelExample->removeByPkv($_GET[id]);       
        redirect($this->_url("Right"));
    }

    function actionRight(){
        $this->authCheck($this->funcId);
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            'dateTo' => date("Y-m-d"),
            'clientId'=>'',
            'vatNum'=>'',
            'orderCode'=>'',
            'workerId'=>''
        ));
    
        // if ($arrGet[accountItemId]>0) $condition[] = array('accountItemId', $arrGet[accountItemId]);

        $model = FLEA::getSingleton('Model_CaiWu_Wages');

        $sql = "SELECT x.*,y.vatNum,
                z.orderCode,z.clientId,
                w.wareName,w.guige,w.id as productId,
                v.color,v.colorNum,v.orderId,v.wareId,u.compName,o.perName
                from caiwu_wages_guozhang x
                left join plan_dye_gang y on x.gangId=y.id
                left join trade_dye_order2ware v on y.order2wareId=v.id
                left join trade_dye_order z on v.orderId = z.id
                left join jichu_ware w on v.wareId=w.id
                left join jichu_client u on u.id=z.clientId
                left join jichu_gxperson o on o.id=x.workerCode
                where 1
        ";
         if($arr['dateFrom'] !=''){
            $sql.=" and x.guozhangDate>='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
        }

        if($arr['orderCode']!='') $sql .=" and z.orderCode like '%{$arr['orderCode']}%' ";
        if($arr['workerId']!='') $sql .=" and x.workerCode = '{$arr['workerId']}' ";
        if($arr['vatNum']!='') $sql .=" and y.vatNum like '%{$arr['vatNum']}%' ";
        if($arr['clientId']!='') $sql .=" and z.clientId='{$arr['clientId']}' ";

        // dump($sql);die;
        $pager =& new TMIS_Pager($sql);
        $rowset =$pager->findAll();     
        // dump($rowset);die;


        if (count($rowset)>0) foreach($rowset as & $v) {
            $kindArr = array(
                '1'=>'松紧筒打包',
                '2'=>'装出笼',
                '3'=>'染色',
            );
            $v['kind'] = isset($kindArr[$v['kind']])?$kindArr[$v['kind']]:$v['kind'];

            $v['_edit'] = $this->getRemoveHtml($v['id']);
            $sqlCl ="select gxIds from dye_chanliang where id='{$v['chanliangId']}'";
            $gxIdss = $this->_modelExample->findBySql($sqlCl);
            $sql = "select gongxuName from jichu_chanliang_gongxu where id='{$gxIdss[0]['gxIds']}'";
            $gName = $this->_modelExample->findBySql($sql);
            $v['gongxuName'] = $gName[0]['gongxuName'];
        }
        $heji = $this->getHeji($rowset,array('cntK','money'),'_edit');
        $rowset[] = $heji;

        $smarty = & $this->_getView();
        $smarty->assign('title', $this->title);
        $arr_field_info = array(
            "_edit"         =>  "操作",
            "guozhangDate"  =>  "过账日期",
            "chanliangDate" =>  "产量日期",
            "orderCode"     =>  "订单",
            "wareName"      =>  "纱织规格",
            "gongxuName"          =>  "工序名称",
            "perName"       =>  "操作员工",
            "cntK"          =>  "数量",
            "danjia"        =>  "单价",
            "money"         =>  "金额",
            "memo"          =>  "备注"
        );
        $smarty->assign('title',$this->title);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_condition', $arr);
        $smarty->display('TableList.tpl');
    }

}
?>