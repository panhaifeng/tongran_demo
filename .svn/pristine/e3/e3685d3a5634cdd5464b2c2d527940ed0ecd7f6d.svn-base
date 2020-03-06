<?php
/**
 * 员工产量工资的审核页面，相当于财务过账功能
 */ 
FLEA::loadClass('TMIS_Controller');
class Controller_CaiWu_CheckCost extends Tmis_Controller {
    var $_modelExample;
    var $funcId = 144;
    function Controller_CaiWu_CheckCost() {
        /*if(!$this->authCheck()) die("禁止访问!");*/
        $this->leftCaption = '成本核算';      
        $this->_modelExample = & FLEA::getSingleton('Model_CaiWu_Wages');
        $this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
        $this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
    }   
    
    function actionRight(){
        //$this->authCheck($this->funcId);
        $this->authCheck('4-5-3');
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            'dateTo' => date("Y-m-d"),
            'clientId'=>'',
            'vatNum'=>'',
            'orderCode'=>'',
            'workerCode'=>''
        ));
    
        // if ($arrGet[accountItemId]>0) $condition[] = array('accountItemId', $arrGet[accountItemId]);

        $model = FLEA::getSingleton('Model_CaiWu_Wages');

        $sql = "SELECT x.*,x.id as gangId,
            z.orderCode,z.orderCode2,z.clientId,
            w.wareName,w.guige,
            y.color,y.colorNum,y.orderId,y.wareId
            from plan_dye_gang x
            left join trade_dye_order2ware y on x.order2wareId=y.id
            left join trade_dye_order z on y.orderId = z.id
            left join jichu_ware w on y.wareId=w.id
            where 1";
        if($arr['orderCode']!='') {
            $sql .= " and z.orderCode like '%{$arr['orderCode']}%'";
        }
        if($arr['vatNum']!='') {
            $sql .= " and x.vatNum like '%{$arr['vatNum']}%'";
        }
        if($arr['clientId']>0) {
            $sql .= " and z.clientId='{$arr['clientId']}'";
        }
        if($arr['zhishu']!='') {
            $sql .= " and (w.wareName like '%{$arr['zhishu']}%' or w.guige like '%{$arr['zhishu']}%')";
        }
        $sql .= " order by x.id desc";
        $pager= new TMIS_Pager($sql);
        $rowset = $pager->findAll();
        // dump($rowset);die;


        if (count($rowset)>0) foreach($rowset as & $v) {
            $rhlCost = $this->getRhlCost($v['gangId'],$v['order2wareId']);
            $v['rhlCost'] = $rhlCost['heji'];

            $employeeWages = $this->getEmployeeCost($v['gangId']);
            $v['employeeWages'] = $employeeWages;
            $kindArr = array(
                '1'=>'松紧筒打包',
                '2'=>'装出笼',
                '3'=>'染色',
            );
            $v['kind'] = isset($kindArr[$v['kind']])?$kindArr[$v['kind']]:$v['kind'];

            $mClient = & FLEA::getSingleton('Model_Jichu_Client');
            $client = $mClient->find(array('id'=>$v['clientId']));
            $v['compName'] = $client['compName'].($v['orderCode2']?"({$v['orderCode2']})":'');
            $v['netWeight'] = $this->_modelGang->getStNetWeight($v['gangId']);
            $v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v[orderCode]);

            //公斤产量
            $sql = "select sum(cntK) as cntK,sum(cntTongzi) as cntTongzi from dye_st_chanliang where gangId='{$v['gangId']}'";
            $_temp = $this->_modelOrder->findBySql($sql);
            $v['cntK'] = $_temp[0]['cntK'];
            $v['cntTongzi'] = $_temp[0]['cntTongzi'];
            $v['guige'] = $v['wareName'] . ' '.$v['guige'];
            $v['danjiaCost'] = round(($v['rhlCost']+$v['employeeWages'])/$v['cntPlanTouliao'],3);
        }
        $heji = $this->getHeji($rowset,array('cntK','money'),'_edit');
        $rowset[] = $heji;

        $smarty = & $this->_getView();
        $smarty->assign('title', $this->title);
        $smarty->assign('arr_field_info',array(
            "compName" => "客户(客户单号)",
            "orderCode" =>"订单号",
            "vatNum" =>"缸号",
            "guige" => "纱织规格",
            "color" =>"颜色",
            "cntPlanTouliao" =>"计划投料",
            "planTongzi" =>"计划筒子数",
            "unitKg" =>"定重",
            //"netWeight"=>'净重',
            //'cntK'=>'产量(kg)',
            //"cntTongzi"=>"产出筒子数",//显示在做车台，并用颜色表示完成情况
            'danjiaCost'=>'成本单价',
            'rhlCost'=>'染化料成本',
            'employeeWages'=>'员工工资',
            // "_edit" => '操作'
        ));
        $smarty->assign('title',$this->title);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_condition', $arr);
        $smarty->display('TableList.tpl');
    }


    function getRhlCost($gangId,$ord2proId){
        $this->_modelChufang =  &FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
        $modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');

        $sql = "SELECT
                 y.*
                FROM
                gongyi_dye_chufang x
                LEFT JOIN gongyi_dye_chufang2ware y ON x.id = y.chufangId
                LEFT JOIN trade_dye_order2ware c ON c.id = x.order2wareId 
                where 1
                ";
        $sql.="and ((x.gangId>0 and x.gangId=".$gangId.") or x.gangId=0) and c.id=".$ord2proId." AND EXISTS (
                SELECT
                    ii.chufangId
                FROM
                    cangku_yl_chuku  ii
                WHERE ii.chufangId=x.id
            )
            ORDER BY
            y.id";

        $rowset = $this->_modelExample->findBySql($sql);

        $costHj = 0;
        foreach ($rowset as $k => &$v) {
            // 计算用量
            $chufang = $this->_modelChufang->find($v['chufangId']);
            $rowGang = $modelGang->findByField('id',$gangId);
            $chufang['Gang'] = $rowGang;
            $z =$chufang[Gang][rsZhelv];
            if($v['unit']=='g/升') {//g/l缸用量 = 单位用量*缸的水容量/1000
                if ($chufang['Gang']['Vat'] != '') {
                    $v['vatCnt'] = round($v['unitKg']*$chufang['Gang']['shuirong']/1000,4);
                }
                else $v['vatCnt'] = 0;
            } elseif($v['unit']=='%') {//%用量 = 单位用量*投纱量/1000
                if ($chufang['Gang']['Vat'] != '') {
                    $v['vatCnt'] = round($v['unitKg']*$z*$chufang['Gang']['cntPlanTouliao']/100,4);
                }
                else $v['vatCnt'] = 0;
            }
            else {//染化料缸用量=总公斤数/(包用量*5)
                $v['vatCnt'] = round($chufang['Gang']['cntPlanTouliao']*$chufang['rhlZhelv']/1000*$v['unitKg']/5,4);
            }
            //计算单价
            $rhlInfo = $this->getRhlDj($v['wareId']);
            $v['danjia'] = $rhlInfo;
            $v['cost'] = $v['danjia'] *$v['vatCnt'];
            $costHj+=$v['cost'];
            // dump($v);die;
        }
        $rowset['heji'] = $costHj;
        return $rowset;
    }

    function getRhlDj($wareId){
        $sql="SELECT x.danjia 
            from cangku_yl_ruku2ware x 
            left join cangku_yl_ruku y on x.rukuId = y.id 
            where 1 and x.wareId='{$wareId}' and x.danjia>0 order by y.rukuDate desc ";
        $rowset = $this->_modelExample->findBySql($sql);
        return $rowset[0]['danjia']>0?$rowset[0]['danjia']:'0';
    }

    function getEmployeeCost($gangId){
        $sql="SELECT sum(x.money) as employeeCost 
            from caiwu_wages_guozhang x 
            where 1 and x.gangId='{$gangId}' ";
        $rowset = $this->_modelExample->findBySql($sql);
        return $rowset[0]['employeeCost']>0?$rowset[0]['employeeCost']:'0';
    }
}
?>