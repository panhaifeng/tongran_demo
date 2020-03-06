<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Tool extends Tmis_Controller{
    function Controller_Tool() {
        $this->_modelExample = & FLEA::getSingleton('Model_Index');
    }
    /**
     * @desc ：返回订单进度信息
     * Time：2020年2月8日 14:58:46
     * @author ShenHao
    */
    function actiongetOrderProcess($params = array(),& $service){
        FLEA::loadClass('TMIS_Controller');
        $mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');

        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );

        $dateFrom = $params['dateFrom'];
        $dateTo = $params['dateTo'];
        
        $pagesize = $params['pagesize']?$params['pagesize']:15;//默认9一页
        $pageNum = $params['pageNum']?$params['pageNum']:1;//页码

        $limit = '';
        //计算偏移量
        if($pageNum){
            $begin = ($pageNum-1)*$pagesize;
            $limit = ' LIMIT'." {$begin},{$pagesize}";
        }
        //该订单下的信息
        $str ="SELECT g.vatNum,j.guige,w.color,w.colorNum,w.id as order2wareId,g.cntPlanTouliao,g.id as planId,
                c.compName,o.orderCode,o.id as orderId
                from trade_dye_order2ware w
                LEFT JOIN plan_dye_gang g on w.id=g.order2wareId
                LEFT JOIN jichu_ware j on j.id=w.wareId
                LEFT JOIN trade_dye_order o on o.id=w.orderId
                LEFT JOIN jichu_client c on c.id=o.clientId
                where 1 and o.dateOrder>='2019-01-1' and o.dateOrder<='2019-02-20'";
        $vatNum = $params['vatNum']?$params['vatNum']:'';
        $orderCode = $params['orderCode']?$params['orderCode']:'';
        $clientIds = $params['clientId']>0?$params['clientId']:'';

        if($vatNum){
            $str.=" and g.vatNum like '%{$vatNum}%'";
        }
        if($orderCode){
            $str.=" and o.orderCode like '%{$orderCode}%'";
        }
        if($clientIds!=''){
            $str.=" and c.id = '{$clientIds}'";
        }
        $str.=" group by w.orderId";
        $str.=" ORDER BY w.id DESC,g.id DESC {$limit}";
        //dump2file($str);
        $rowset = $this->_modelExample->findBySql($str);
        foreach ($rowset as $key => &$value) {
            $row[$key]['orderCode'] = $rowset[$key]['orderCode'];
            $sql="SELECT g.vatNum,j.guige,w.color,w.colorNum,w.id as order2wareId,g.cntPlanTouliao,g.id as planId,
                c.compName,o.orderCode,o.id as orderId
                  from trade_dye_order2ware w
                  left join plan_dye_gang g on w.id=g.order2wareId
                  left join jichu_ware j on j.id=w.wareId
                  left join trade_dye_order o on o.id=w.orderId
                  left join jichu_client c on c.id=o.clientId
                  where w.orderId='{$value['orderId']}'";
            $ar = $this->_modelExample->findBySql($sql);
            foreach ($ar as $k => &$vv) {
                $vv['vatNum'] = $vv['vatNum']?$vv['vatNum']:'';
                $vv['guige'] = $vv['guige']?$vv['guige']:'';
                $vv['color'] = $vv['color']?$vv['color']:'';
                $vv['compName'] = $vv['compName']?$vv['compName']:'';
                $vv['jwAll'] = $vv['cntPlanTouliao']?$vv['cntPlanTouliao']:'';
                if($vv['planId']){
                    $sql="SELECT * from dye_st_chanliang where gangId='{$vv['planId']}'";
                    $st = $this->_modelExample->findBySql($sql);
                    if($st){    
                        $vv['HaveSt'] = 1;
                    }else{
                        $vv['HaveSt'] = 0;
                    }
                    $sql1="SELECT id from dye_rs_chanliang where gangId='{$vv['planId']}'";
                    $rs = $this->_modelExample->findBySql($sql1);
                    $rsStr = "SELECT rsOver from plan_dye_gang where id='{$vv['planId']}'";
                    $rsWc = $this->_modelExample->findBySql($rsStr);
                    if($rs&&$rsWc[0]['rsOver']){
                        $vv['HaveRs'] = 2; //表示染色完成
                    }elseif ($rs) {
                        $vv['HaveRs'] = 1;//表示染色有产量
                    }else{
                        $vv['HaveRs'] = 0; //表示染色无产量
                    }
                    $sql2="SELECT id from dye_hs_chanliang where gangId='{$vv['planId']}'";
                    $hs = $this->_modelExample->findBySql($sql2);
                    if($hs){
                        $vv['HaveHs'] = 1; //表示烘纱完成
                    }else{
                        $vv['HaveHs'] = 0; //表示烘纱无产量
                    }
                    $sql3="SELECT id from dye_hd_chanliang where gangId='{$vv['planId']}'";
                    $hd = $this->_modelExample->findBySql($sql3);
                    if($hd){
                        $vv['Havehd'] = 1; //表示回倒完成
                    }else{
                        $vv['Havehd'] = 0; //表示回倒无产量
                    }
                    $sql4="SELECT id from chengpin_dye_cpck where planId='{$vv['planId']}'";
                    $fh = $this->_modelExample->findBySql($sql4);
                    if($fh){
                        $vv['HaveFh'] = 1; //表示已有发货
                    }else{
                        $vv['HaveFh'] = 0; //表示未发货
                    }
                    $sql5="SELECT sum(jingKg) as cntAll from chengpin_dye_cpck where planId='{$vv['planId']}'";
                    $cntfh = $this->_modelExample->findBySql($sql5);
                    if($cntfh[0]['cntAll']){
                        $vv['cntCpck'] = $cntfh[0]['cntAll']; //发货数量
                    }else{
                        $vv['cntCpck'] = 0+0; //表示未发货
                    }
                    }else{
                        $vv['HaveSt'] = 0;
                        $vv['HaveRs'] = 0; //表示染色无产量
                        $vv['HaveHs'] = 0; //表示烘纱无产量
                        $vv['Havehd'] = 0; //表示回倒无产量
                        $vv['HaveFh'] = 0;//表示未发获
                        $vv['cntCpck'] = 0+0;//表示未发获
                    }
            }
            $rowset[$key] = $ar;
            
        }
        $data = array(
            'params'    => $rowset,
            'orderCode' => $row,
            'success'   => true,
            'msg'       => '请求成功',
            'errorcode' => '0',
            'status'    => '200',
        );
        // if($rowset){
        //     $data['params'] = $rowset;
        //     $data['orderCode'] = $row;
        // }else{
        //     $data['rsp']['success'] = false;
        //     $data['rsp']['msg'] = '未找到相关记录';
        //     return $data;
        // }
        __TRY();
        $ex = __CATCH();
        if (__IS_EXCEPTION($ex)) {
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = $ex->getMessage();
            $data['rsp']['code'] = 'E4499';
            return $data;
        }
        return $data;
    }
}



?>