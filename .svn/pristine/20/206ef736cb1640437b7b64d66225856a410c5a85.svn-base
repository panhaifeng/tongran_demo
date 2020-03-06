<?php
/*********************************************************************\
*  Copyright (c) 1998-2013, TH. All Rights Reserved.
*  Author :wuyou
*  FName  :Login.php
*  Time   :2019/07/17 14:16:27
*  Remark :二维码验证接口
\*********************************************************************/
FLEA::loadClass('Api_Response');
class Api_Lib_MiniPro extends Api_Response {

    function __construct() {
        $this->_modelExample = & FLEA::getSingleton('Model_Trade_Dye_Order2ware');
    }

    //重写_checkParams,参数是否合法可能包含业务逻辑
    function _checkParams($params) {
        $_modelUser = FLEA::getSingleton('Model_Acm_User');
        if($params['account']){
            $stoped = $_modelUser->find(array('userName'=>$params['account'],'isFire'=>0));
            if(!$stoped){
                return false;
            }
        }
        return true;
    }

    /**
     * @desc 获取项目配置信息
     * Time：2020年2月2日 14:26:24
     * @author ShenHao
    */
    function SettingData($params=array()){
        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        $res = array(
            'bg' => false
        );
        if($res){
            $data['params'] = $res;
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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


    /**
     * @desc 合同汇总数据(柱形图)
     * Time：2019年8月28日 16:41:36
     * @author ShenHao
    */
    function getBarMonthData($params = array()){
        $mOrder = & FLEA::getSingleton('Model_Trade_Order');
        $year = isset($params['year'])?$params['year']:date('Y');//年份检索

        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        $default = $dataArr = $legend = array();
        for ($i=1; $i <= 12; $i++) {
            $default[$i] = '';
        }
        $arr = array(
            'dhMoney' => '大货下单',
            'dyMoney' => '大样下单',
        );
        foreach ($arr as $key => &$value) {
            $kind = $key == 'dhMoney'?'0':'1';
            $sqlOrd = "SELECT id FROM trade_order
                    WHERE orderKind={$kind}
                    and orderDate like '{$year}%'";
            $temp = $mOrder->findBySql($sqlOrd);
            $orderIds = join(',', array_col_values($temp,'id'));
            if($orderIds!=''){
                $sql = "SELECT
                         round(sum(if(t.unit<>t.unitDanjia,if(t.unitDanjia='Y',t.danjia/0.9144*t.cntYaohuo*b.huilv,t.danjia*0.9144*t.cntYaohuo*b.huilv),t.cntYaohuo*t.danjia*b.huilv)),2) as money,
                         left(b.orderDate,7) as month
                        FROM trade_order2product t
                        LEFT JOIN trade_order b on t.orderId=b.id
                        WHERE t.orderId IN({$orderIds})
                        GROUP BY left(b.orderDate,7)";
                $re = $mOrder->findBySql($sql);
            }else{
                $re = array();
            }

            $dataBar = $default;
            // if($re){
                foreach ($re as $kk => $vv) {
                    $index = substr($vv['month'], 5,2)/1;
                    round($vv['money'],2) && $dataBar[$index] = round($vv['money'],2);
                }
                $dataArr[] = array('name'=>$value,'data'=>array_values($dataBar));
            // }
        }

        if($dataArr){
            $data['params'] = $dataArr;
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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


    /**
     * @desc ：获得汇总表数据(月份，客户，业务员)
     * Time：2019年8月29日 14:50:27
     * @author ShenHao
    */
    function getMonthData($params = array()){
        FLEA::loadClass('TMIS_Controller');
        $mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
        $type = $params['type'];
        $year = $params['year'];
        $month = $params['month'];
        //当月最大日期
        $monthDays = $this->getMonthLastDay($month, $year);
        $dateFrom = $params['dateFrom'];
        $dateTo = $params['dateTo'];
        $vatNum = $params['vatNum']?$params['vatNum']:'';
        $groupBy = $type=='Month'?'left(orderDate,7)':($type=='Client'?'clientId':'traderId');
        $finalGroup = $type=='Month'?'month':($type=='Client'?'clientId':'traderId');
        $orderBy = $type=='Month'?'month':'dhMoney desc,dyMoney desc';
        $textField = $type=='Month'?'month':($type=='Client'?'compName':'employName');

        //检索条件
        $clientName = $params['clientName']?$params['clientName']:'';
        $salesName = $params['salesName']?$params['salesName']:'';
        $where = '';
        if($clientName){
            $where .= "and a.compName like '%{$clientName}%'" ;
        }
        if($salesName){
            $where .= "and e.employName like '%{$salesName}%'" ;
        }
        if($vatNum){
            $where .= "and g.vatNum like '%{$vatNum}%'" ;
        }
        $pagesize = $params['pagesize']?$params['pagesize']:9;//默认9一页
        $pageNum = $params['pageNum']?$params['pageNum']:0;//页码

        $limit = '';
        //计算偏移量
        if($pageNum){
            $begin = ($pageNum-1)*$pagesize;
            $limit = ' LIMIT'." {$begin},{$pagesize}";
        }
        //该订单下的信息
        $str ="SELECT g.vatNum,j.guige,w.color,w.colorNum,w.id as order2wareId,g.cntPlanTouliao,g.id as planId,
                c.compName,o.orderCode
                from trade_dye_order2ware w
                LEFT JOIN plan_dye_gang g on w.id=g.order2wareId
                LEFT JOIN jichu_ware j on j.id=w.wareId
                LEFT JOIN trade_dye_order o on o.id=w.orderId
                LEFT JOIN jichu_client c on c.id=o.clientId
                where 1 and o.dateOrder>='{$year}-{$month}-01' and o.dateOrder<='{$year}-{$month}-{$monthDays}'";
        if($vatNum){
            $str.=" and g.vatNum like '%{$vatNum}%'";
        }
        $str.=" ORDER BY w.id DESC,g.id DESC {$limit}";
        // dump2file($str);
        $rowset = $this->_modelExample->findBySql($str);
        //订单
        $rowOrder = array();
        foreach ($rowset as $key => &$vaa) {
            $rowOrder[$key]['orderCode'] = $vaa['orderCode'];
            $rowOrder[$key]['vatNum'] = $vaa['vatNum'].'';
        }
        // dump2file($rowOrder);
        // dump2file($rowset);
        $arr = array();
        $arr1 = array();
        $arr2 = array();
        $arr3 = array();
        $arr4 = array();
        $arr5 = array();
        $arr6 = array();
        $arr7 = array();
        $arr8 = array();
        $arr9 = array();
        foreach ($rowset as $key => &$v) {
            $v['order2wareId'] = $v['order2wareId'].'-'.$key;
        }
        //客户
        foreach ($rowset as $key => &$vv) {
            $arr0['list'][$vv['order2wareId']]['compName'] = $vv['compName'].'';
            $arr['list'][$vv['order2wareId']]['guige'] = $vv['guige'].'';
            $arr1['list'][$vv['order2wareId']]['color'] = $vv['color'].'';
            $arr2['list'][$vv['order2wareId']]['vatNum'] = $vv['vatNum'].'';
            $arr3['list'][$vv['order2wareId']]['jwAll'] = $vv['cntPlanTouliao'].'';
            if($vv['planId']){
                $sql="SELECT * from dye_st_chanliang where gangId='{$vv['planId']}'";
                $st = $this->_modelExample->findBySql($sql);
                if($st){
                    $arr4['list'][$vv['order2wareId']]['HaveSt'] = 1;
                }else{
                    $arr4['list'][$vv['order2wareId']]['HaveSt'] = 0;
                }
                $sql1="SELECT id from dye_rs_chanliang where gangId='{$vv['planId']}'";
                $rs = $this->_modelExample->findBySql($sql1);
                $rsStr = "SELECT rsOver from plan_dye_gang where id='{$vv['planId']}'";
                $rsWc = $this->_modelExample->findBySql($rsStr);
                if($rs&&$rsWc[0]['rsOver']){
                    $arr5['list'][$vv['order2wareId']]['HaveRs'] = 2; //表示染色完成
                }elseif ($rs) {
                    $arr5['list'][$vv['order2wareId']]['HaveRs'] = 1;//表示染色有产量
                }else{
                    $arr5['list'][$vv['order2wareId']]['HaveRs'] = 0; //表示染色无产量
                }
                $sql2="SELECT id from dye_hs_chanliang where gangId='{$vv['planId']}'";
                $hs = $this->_modelExample->findBySql($sql2);
                if($hs){
                    $arr6['list'][$vv['order2wareId']]['HaveHs'] = 1; //表示烘纱完成
                }else{
                    $arr6['list'][$vv['order2wareId']]['HaveHs'] = 0; //表示烘纱无产量
                }
                $sql3="SELECT id from dye_hd_chanliang where gangId='{$vv['planId']}'";
                $hd = $this->_modelExample->findBySql($sql3);
                if($hd){
                    $arr7['list'][$vv['order2wareId']]['Havehd'] = 1; //表示回倒完成
                }else{
                    $arr7['list'][$vv['order2wareId']]['Havehd'] = 0; //表示回倒无产量
                }
                $sql4="SELECT id from chengpin_dye_cpck where planId='{$vv['planId']}'";
                $fh = $this->_modelExample->findBySql($sql4);
                if($fh){
                    $arr8['list'][$vv['order2wareId']]['HaveFh'] = 1; //表示已有发货
                }else{
                    $arr8['list'][$vv['order2wareId']]['HaveFh'] = 0; //表示未发货
                }
                $sql5="SELECT sum(jingKg) as cntAll from chengpin_dye_cpck where planId='{$vv['planId']}'";
                $cntfh = $this->_modelExample->findBySql($sql5);
                if($cntfh[0]['cntAll']){
                    $arr9['list'][$vv['order2wareId']]['cntCpck'] = $cntfh[0]['cntAll']; //发货数量
                }else{
                    $arr9['list'][$vv['order2wareId']]['cntCpck'] = 0+0; //表示未发货
                }
            }else{
                $arr4['list'][$vv['order2wareId']]['HaveSt'] = 0;
                $arr5['list'][$vv['order2wareId']]['HaveRs'] = 0; //表示染色无产量
                $arr6['list'][$vv['order2wareId']]['HaveHs'] = 0; //表示烘纱无产量
                $arr7['list'][$vv['order2wareId']]['Havehd'] = 0; //表示回倒无产量
                $arr8['list'][$vv['order2wareId']]['HaveFh'] = 0;//表示未发获
                $arr9['list'][$vv['order2wareId']]['cntCpck'] = 0+0;//表示未发获
            }
        }
        $arr0['list'] = array_values($arr0['list']);
        $arr0['name'] = '客户';

        $arr['list'] = array_values($arr['list']);
        $arr['name'] = '规格';

        $arr1['list'] = array_values($arr1['list']);
        $arr1['name'] = '颜色';

        $arr2['list'] = array_values($arr2['list']);
        $arr2['name'] = '缸号';

        $arr3['list'] = array_values($arr3['list']);
        $arr3['name'] = '经纬合计';

        $arr4['list'] = array_values($arr4['list']);
        $arr4['name'] = '松筒';

        $arr5['list'] = array_values($arr5['list']);
        $arr5['name'] = '染色';

        $arr6['list'] = array_values($arr6['list']);
        $arr6['name'] = '烘纱';

        $arr7['list'] = array_values($arr7['list']);
        $arr7['name'] = '回倒';

        $arr8['list'] = array_values($arr8['list']);
        $arr8['name'] = '发货';

        $arr9['list'] = array_values($arr9['list']);
        $arr9['name'] = '发货数量';
        $res=array();
        $res[0] = $arr0;
        $res[1] = $arr;
        $res[2] = $arr1;
        $res[3] = $arr2;
        $res[4] = $arr3;
        $res[5] = $arr4;
        $res[6] = $arr5;
        $res[7] = $arr6;
        $res[8] = $arr7;
        $res[9] = $arr8;
        $res[10] = $arr9;
        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        // dump2file($rowset);
        if($rowOrder){
            $data['params'] = array(
                'data'=>$rowOrder,
                'dataOne'=>$res,
                'total'=>count($rowOrder)
            );
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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

    //获取当月最大日期
    function getMonthLastDay($month, $year) {
        switch ($month) {
            case 4 :
            case 6 :
            case 9 :
            case 11 :
                $days = 30;
                break;
            case 2 :
              if ($year % 4 == 0) {
                if ($year % 100 == 0) {
                    $days = $year % 400 == 0 ? 29 : 28;
                } else {
                    $days = 29;
                }
                } else {
                    $days = 28;
                }
                   break;
            default :
                   $days = 31;
                   break;
         }
         return $days;
    }
    /**
     * @desc ：返回利润汇总数据
     * Time：2019年8月30日 13:47:42
     * @author ShenHao
    */
    function getProfitData($params = array()){
        $mOrder = & FLEA::getSingleton('Model_Trade_Order');
        $dateFrom = $params['dateFrom']?$params['dateFrom']:date('Y-m-1');
        $dateTo = $params['dateTo']?$params['dateTo']:date('Y-m-d');
        $pagesize = $params['pagesize']?$params['pagesize']:20;//默认20一页
        $pageNum = $params['pageNum']?$params['pageNum']:0;//页码

        $limit = '';
        //计算偏移量
        if($pageNum){
            $begin = ($pageNum-1)*$pagesize;
            $limit = ' LIMIT'." {$begin},{$pagesize}";
        }

        $sql = "SELECT group_concat(distinct x.id) as id,a.compName,y.clientId,y.traderId,b.employName
                from trade_order_chengben x
                left join trade_order y on y.id=x.orderId
                left join jichu_client a on y.clientId=a.id
                left join jichu_employ b on y.traderId=b.id
                where y.chengbenCheckDate<>'0000-00-00'";
        if($dateFrom!='') {
            $sql.= " and y.chengbenCheckDate>='{$dateFrom}' and y.chengbenCheckDate<='{$dateTo}'";
        }
        $sql.=" group by y.clientId,y.traderId order by y.clientId desc,y.traderId desc";
        $sql.= $limit;
        $row = $mOrder->findBySql($sql);

        $arr_info=array();
        $rowset=array();
        $heji=array();
        foreach($row as & $v) {
            //获取总成本和总利润
            $str = "SELECT sum(x.money) as money,sum(x.chengben) as chengben
                    from trade_order_chengben x
                    left join trade_order y on y.id=x.orderId
                    where y.chengbenCheckDate<>'0000-00-00' and y.clientId='{$v['clientId']}' and y.traderId='{$v['traderId']}'";
            $str.= " and y.chengbenCheckDate>='{$dateFrom}' and y.chengbenCheckDate<='{$dateTo}'";
            $str .= " order by x.id desc";
            $re=mysql_fetch_assoc(mysql_query($str));
            $v['money'] = $re['money']+0;
            $v['chengben'] = $re['chengben']+0;
            $v['lirun'] = round($v['money']-$v['chengben'],2);
            //查找出库总米数
            $sql = "SELECT sum(if(unit='M',x.ckCnt+x.cyCnt,(x.ckCnt+x.cyCnt)*0.9144)) as cntM
                    from caiwu_ar_guozhang x
                    left join trade_order y on y.id=x.orderId
                    where 1 and y.clientId='{$v['clientId']}' and y.traderId='{$v['traderId']}' and y.chengbenCheckDate<>'0000-00-00'";
            $sql.= " and y.chengbenCheckDate>='{$dateFrom}' and y.chengbenCheckDate<='{$dateTo}'";
            $result=mysql_fetch_assoc(mysql_query($sql));
            $v['cntMCpck']=$result['cntM'];

            if(($v['money'] && $v['money']!=0) || ($v['chengben'] && $v['chengben']!=0)) {
                $rowset[]=$v;
            }
        }

        foreach($rowset as & $v) {
            $heji['cntMCpck']+=$v['cntMCpck'];
            $v['cntMCpck']=round($v['cntMCpck'],1);
            $heji['money']+=$v['money'];
            $heji['chengben']+=$v['chengben'];
            $heji['lirun']+=$v['lirun'];
        }
        $heji['cntMCpck']=round($heji['cntMCpck'],1);
        $rowset[]=$heji;

        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        if($rowset){
            $data['params'] = array(
                'data'=>$rowset,
                'total'=>count($rowset)
            );
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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

        /**
     * @desc ：获取销售额汇总数据(当天总销售额，当月总销售额，当天下货数量(M)，当月下货数量(M))
     * Time：2019年8月30日 13:47:42
     * @author ShenHao
    */
    function getSalesData(){
        $mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
        $today  = date('Y-m-d');

        $beginDate = date('Y-m-01', strtotime(date("Y-m-d")));
        $endDate = date('Y-m-d', strtotime("$beginDate +1 month -1 day"));//本月最后一天

        //本日计划数
        $currSql = "SELECT
                sum(cntPlanTouliao) as cntM_Today
                FROM plan_dye_gang t
                WHERE t.planDate='{$today}'";
        $dataToday = $mOrder->findBySql($currSql);
        $rowToday = $dataToday[0];
        //本月计划数
        $monthSql = "SELECT
                sum(cntPlanTouliao) as cntM_month
                FROM plan_dye_gang t
                WHERE t.planDate>='{$beginDate}' and t.planDate<='{$endDate}'";
        $dataMonth = $mOrder->findBySql($monthSql);
        $rowMonth = $dataMonth[0];
         //本日发货数
        $monthFh = "SELECT sum(jingKg) as cntFhAllTd
                    FROM chengpin_dye_cpck c
                    WHERE c.dateCpck='{$today}'";
        $dataTodayFh = $mOrder->findBySql($monthFh);
        $rowFhDay = $dataTodayFh[0];
        //本月发货数
        $monthFh = "SELECT sum(jingKg) as cntFhAll
                    FROM chengpin_dye_cpck c
                    WHERE c.dateCpck>='{$beginDate}' and c.dateCpck<='{$endDate}'";
        $dataMonthFh = $mOrder->findBySql($monthFh);
        $rowFh = $dataMonthFh[0];
        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        if($rowMonth || $rowToday){
            $data['params'] = array(
                'cntM_Today'=>$rowToday['cntM_Today']+0,  //本日计划数
                'cntM_month'=>$rowMonth['cntM_month']+0,  //本月计划数
                'cntFh_Today'=>$rowFhDay['cntFhAllTd']+0 , //本月发货数
                'cntFh_Month'=>$rowFh['cntFhAll']+0 , //本月发货数
                'money_month'=>0 ,
            );
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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
    /**
     * @desc ：返回年份列表
     * Time：2019年8月30日 15:17:00
     * @author ShenHao
    */
    function getYearList(){
        $mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
        // 获得最小年份
        $sql = "SELECT min(dateOrder) as minDate FROM trade_dye_order WHERE dateOrder<>'0000-00-00'";
        $temp = $mOrder->findBySql($sql);
        $cntYear = date('Y') - substr($temp[0]['minDate'], 0,4);
        $yearArr = array();
        for ($i=0; $i <= $cntYear; $i++) {
            $yearArr[] = $temp[0]['minDate'] + $i;
        }

        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        if($yearArr){
            $data['params'] = $yearArr;
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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



    /**
     * @desc ：返回工序列表
     * Time：2020年2月6日 10:52:08
     * @author ShenHao
    */
    function getGxList($params = array(),& $service){
        //获取染色工序
        $gongxuModel = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
        $rsGongxu = $gongxuModel->findAll(array('type'=>3));
        $rsGongxRe = array();
        foreach ($rsGongxu as $key => &$val) {
            $rsGongxRe[] = array('text'=>$val['gongxuName'],'value'=>$val['id']);
        }

        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        if($rsGongxRe){
            $data['params'] = $rsGongxRe;
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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

    
    /**
     * @desc ：返回报工人员列表 
     * Time：2020年2月6日 10:52:08
     * @author ShenHao
    */
    function getOutPeople($params = array(),& $service){
        //获取报工人员
        $gxPersonModel = & FLEA::getSingleton('Model_JiChu_GxPerson');
        $Person = $gxPersonModel->findAll(array('type'=>'rs'));
        $rePerson = array();
        foreach ($Person as $key => &$value) {
            $rePerson[] = array('text'=>$value['perName'],'value'=>$value['id']);
        }
        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        if($rePerson){
            $data['params'] = $rePerson;
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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

    /**
     * @desc ：条码信息
     * Time：2020年2月6日 10:52:08
     * @author ShenHao
    */
    function barcodeDetail($params = array(),& $service){
        $this->_modelChanliang = & FLEA::getSingleton('Model_Dye_Chanliang');
        $gongxuModel = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
        $sql ="select g.*,j.wareName,j.guige,w.color,w.colorNum,v.vatCode,j.leixing
               from plan_dye_gang g
               left join trade_dye_order2ware w on w.id=g.order2wareId
               left join jichu_ware j on j.id=w.wareId
               left join jichu_vat v on v.id=g.vatId
               where g.vatNum='{$params['code']}'";
        $arr = $gongxuModel->findBySql($sql);
        foreach ($arr as $key => &$vv) {
            if($vv['leixing']==1){
                $vv['leixing'] = '全棉';
            }elseif ($vv['leixing']==2) {
                $vv['leixing'] = '人棉';
            }elseif ($vv['leixing']==3) {
                $vv['leixing'] = '氨纶';
            }elseif ($vv['leixing']==4) {
                $vv['leixing'] = '麻棉';
            }
        }
        //染色工序显示
        $sql = "SELECT *
                from jichu_chanliang_gongxu
                where 1 and type='3'";
        $rowset =$this->_modelChanliang->findBySql($sql);
        $isBg = $this->_modelChanliang->findAll(array('gangId'=>$arr[0]['id'],'type'=>'3'),null,null,'gxIds');
        $temp =  array();
        foreach ($isBg as $k => &$v) {
            $temp[] = $v['gxIds'];
        }
        //查询出双染的类型,区分分散和套棉的工序
        $sqlRs = "select markTwice,fensanOver from plan_dye_gang where id='{$arr[0]['id']}'";
        $rsLeixing = $this->_modelChanliang->findBySql($sqlRs);
        $sqlfs ="select id from jichu_chanliang_gongxu where fensan=1";
        $fensanGx = $this->_modelChanliang->findBySql($sqlfs);
        $fensanGx = array_col_values($fensanGx,'id');
        $sqltm = "select id from jichu_chanliang_gongxu where taomian=1";
        $taomianGx = $this->_modelChanliang->findBySql($sqltm);
        $taomianGx = array_col_values($taomianGx,'id');
        $sqlFsG = "select gxIds from dye_chanliang where gangId='{$arr[0]['id']}' and rsType='分散'";
        $fsGx = $this->_modelChanliang->findBySql($sqlFsG);//分散已报工序
        $fensB = array_col_values($fsGx,'gxIds');
        $sqltmGx = "select gxIds from dye_chanliang where gangId='{$arr[0]['id']}' and rsType='套棉'";
        $taomG = $this->_modelChanliang->findBySql($sqltmGx);
        $taomB = array_col_values($taomG,'gxIds');

        //查找回修过的缸号，染色工序有哪些是不需要再报工的
        $sqlhui = "select parentGangId from plan_dye_gang where id='{$arr[0]['id']}'";
        $ishui = $this->_modelChanliang->findBySql($sqlhui);
        if($ishui[0]['parentGangId']){
            $huixiu=$this->findparentgx($ishui[0]['parentGangId']);         
        }
        // dump($arr);die;
        //查找单染的染色工序
        if($arr[0]['leixing']=='麻棉'){
            $sqldr = "select id from jichu_chanliang_gongxu where quanbu=1 or mamianps=1";
            $danranGx = $this->_modelChanliang->findBySql($sqldr);
            $danranGxB = array_col_values($danranGx,'id');
        }else{
            $sqldr="SELECT id from jichu_chanliang_gongxu where quanbu=1 and mamianps=0";
            $danranGx = $this->_modelChanliang->findBySql($sqldr);
            $danranGxB = array_col_values($danranGx,'id');
        }
        // dump($rowset);die;
        $ganghao = $params['code'];
        if($arr[0]['markTwice']==1&&$arr[0]['fensanOver']==0){
            if($arr[0]['dateAssign']==$arr[0]['dateAssign1'] && $arr[0]['ranseBanci']==$arr[0]['ranseBanci1']) $ganghao = $params['code'].="分散+套棉";
            else $ganghao = $params['code'].="分散";
        }
        if($arr[0]['markTwice']==1 && $arr[0]['fensanOver']==1) {
           $ganghao = $params['code'].="套棉";
        }
        if($arr[0]['markTwice']==1&& $arr[0]['fensanOver']==2&&$arr[0]['taomianOver']==0){
            $ganghao = $params['code'].="套棉";
        }
        foreach ($rowset as $key => &$value) {
            //如果是双染情况，产量报工的缸号选择
        
            // $value['gxTypeId'] = $this->_modelWare->getTopClass($aGang['OrdWare']['wareId'],$wareArr['parentId']); //染色类型

            //如果不是回修的缸，就不需要出现清缸和加色这两道工序
            if(!$ishui[0]['parentGangId']){
                if($value['gongxuName']=='清缸'||$value['gongxuName']=='加色'){
                    unset($rowset[$key]);
                }
            }
            if($rsLeixing[0]['markTwice']!=1){
                if(!in_array($value['id'], $danranGxB)){
                   unset($rowset[$key]);
                }
                if(in_array($value['id'],$temp)){
                  //unset($rowset[$key]);
                  $rowset[$key]['disabled'] = disabled; //已经选过的，不能被选中
                }elseif($ishui[0]['parentGangId']){
                  //当有回修时，除了回修的工序，其他工序不显示。回修过的只能报工回修过的工序
                   if(!in_array($value['id'], $huixiu)){
                        unset($rowset[$key]);
                   }
                }
            }else{
                 //如果是双染的情况下，报工
                 if($rsLeixing[0]['markTwice']==1&&$rsLeixing[0]['fensanOver']==0){
                        //如果是双染的情况,如果是分散，找到分散的工序
                        if(!in_array($value['id'], $fensanGx)){
                            unset($rowset[$key]);
                        }
                        if(in_array($value['id'], $fensB)){
                            $rowset[$key]['disabled'] = 'disabled';
                        }

                 }if(($rsLeixing[0]['markTwice']==1&&$rsLeixing[0]['fensanOver']==1)||($rsLeixing[0]['markTwice']==1&&$rsLeixing[0]['fensanOver']==2&&$rsLeixing[0]['taomianOver']==0)){
                        //dump($taomianGx);die;
                    //dump($taomB);die;
                        //如果是双染的情况,如果是套棉，找到套棉的工序
                        if(!in_array($value['id'], $taomianGx)){

                            unset($rowset[$key]);
                        }
                        if(in_array($value['id'], $taomB)){
                            $rowset[$key]['disabled'] = 'disabled';
                        }
                 }
            }
            //查找当前缸是否有binggangId，是否并缸，并缸的话，物理缸号就不是原来的缸号了，是新的物理缸号了 by pan 2018-05-18
            $sqlHebing = "select binggangId from plan_dye_gang where id='{$arr[0]['id']}'";
            $binggangIds = $this->_modelChanliang->findBySql($sqlHebing);
            $v['binggangIds'] = $binggangIds[0]['binggangId'];
            if($v['binggangIds']>0){
               $sqlVat = "select vatId from plan_dye_gang_merge where id='{$v['binggangIds']}'";
               $vatId = $this->_modelChanliang->findBySql($sqlVat);
               $aGang['vatId'] = $vatId[0]['vatId'];
            }
            $sqlPrice = "select price from jichu_vat2gxprice where vatId='{$aGang['vatId']}' and gxId='{$value['id']}' and leixing='{$_GET['leixing']}'"; 
            $gxPrices = $this->_modelChanliang->findBySql($sqlPrice);
            $value['danjia'] = $gxPrices[0]['price'];
            //$value['danjia'] = $gxPrice['price'];
        }
        $rsGongx = array();
        $rsGongxAll = array();
        foreach ($rowset as $key => &$vals) {
            $rsGongxAll[] = array('id'=>$vals['id']);
            if($vals['disabled']=='disabled')
            $rsGongx[] = array('id'=>$vals['id']);
        }
        $rsGongxAll = array_col_values($rsGongxAll,'id');
        $rsGongx = array_col_values($rsGongx,'id');
        $barcode = array(
            'info' => $arr[0],
            'gongxuInfo'=>$rsGongx,
            'gongxuAll'=>$rsGongxAll,
            'ganghao'=>$ganghao
        );

        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        if($barcode){
            $data['params'] = $barcode;
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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

    /**
     * @desc ：保存报工信息
     * Time：2020年2月6日 16:56:49
     * @author ShenHao
    */
    function outputSave($params = array(),& $service){
        $formData = json_decode($params['formData'],true);
        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        //组织数据
        foreach ($formData['peopleArr'] as &$v) {
            if($v['checked']){
                $formData['gxPersonId'][] = $v;
            }
        }
        $countPerson = count($formData['gxPersonId']);
        foreach ($formData['gxArr'] as &$v) {
            if($v['checked']){
                $gxIds[] = $v['value'];
            }
        }
        $formData['gxIds'] = implode(',', $gxIds);
        
        $this->_modelCl = & FLEA::getSingleton('Model_Dye_Chanliang');
        $this->_modelRsPrice = & FLEA::getSingleton('Model_JiChu_Vat2GxPrice');
        $this->_modelWareDj = & FLEA::getSingleton('Model_JiChu_WareDanjia');
        $this->_modelClGx = & FLEA::getSingleton('Model_JiChu_Chanliang_Gongxu');
        $this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
        $this->_mGx = & FLEA::getSingleton('Model_Ganghao_Gx');
        $formData['leixing'] = '1';
        foreach ($formData['gxPersonId'] as $b => &$c) {
                if(!$c ||!$formData['gxIds']) continue;
                $temp['id']         = $formData['id'];
                $temp['dateInput']  = $formData['dateInput'];
                $temp['gangId']     = $formData['gangId'];
                $temp['gxIds']      = $formData['gxIds'];
                $temp['wareName']   = $formData['guige'];
                $temp['gongxu']     = $formData['gongxu'];
                $temp['gxTypeId']   = $formData['gxTypeId'];
                $temp['cnt']        = 1;
                $temp['type']       = 3; //标记产量类型
                $temp['workerId']   = $c['value'];
                $temp['leixing']    = $formData['leixing'];
                $rowset['Gang'] = $this->_modelGang->find($formData['gangId']);
                $rowset['Ware'] = $this->_modelGang->getWare($formData['gangId']);
                $temp['vatNum']     = $formData['vatId'];
                $temp['vatId']      = $rowset['Gang']['vatId'];
                $temp['isOverRsV']  =$formData['isOver'];
                $rowSon[] = $temp;
        }
        foreach ($rowSon as $keys => &$b) {
            if(!$b['gangId']){
                $data['rsp']['success'] = false;
                $data['rsp']['msg'] = '未选择工序，请检查';
                return $data;
            }
        }
        foreach ($rowSon as $ke => &$val) {
           $sql ="update plan_dye_gang set rsWc='{$val['isOverRsV']}',inputRsDate='{$val['dateInput']}' where id='{$val['gangId']}'";
           $this->_mGx->execute($sql);
           $sql1 = "update plan_dye_gang set rsStart=1 where id='{$val['gangId']}'";
           $this->_mGx->execute($sql1);

           //查看是否存在并缸，对并缸的缸号
           $sqlb = "select binggangId from plan_dye_gang where id='{$val['gangId']}'";
           $binggang = $this->_modelCl->findBySql($sqlb);
           if($binggang[0]['binggangId']){
                $sql2 ="update plan_dye_gang_merge set isStartRs=1 where id='{$binggang[0]['binggangId']}'";
                $this->_mGx->execute($sql2); 
           }

           $sql3 = "select markTwice,fensanOver,dateAssign1,dateAssign,ranseBanci,ranseBanci1,rsWc from plan_dye_gang where id='{$val['gangId']}'";
           $shuangr = $this->_modelCl->findBySql($sql3);

           $val['markTwice'] = $shuangr[0]['markTwice'];
           $val['fensanOver'] = $shuangr[0]['fensanOver'];
           $val['ranseBanci'] = $shuangr[0]['ranseBanci'];
           $val['ranseBanci1'] = $shuangr[0]['ranseBanci1'];
           $val['dateAssign'] = $shuangr[0]['dateAssign'];
           $val['dateAssign1'] = $shuangr[0]['dateAssign1'];
           $val['rsWc'] = $shuangr[0]['rsWc'];
        }
        foreach ($rowSon as $key => &$vaa) {
           if ($vaa['markTwice']==1){
                if($vaa['fensanOver']==0) {//如果分散没有完成,表示产量是第一道工序分散产量
                    //判断是否双染分配在同一班做掉
                    if($vaa['dateAssign']==$vaa['dateAssign1'] && $vaa['ranseBanci']==$vaa['ranseBanci1']) {
                        $sql = "update plan_dye_gang set fensanOver=2 where id='{$vaa['gangId']}'";
                        $vaa['rsType']='分套同班';
                        $this->_mGx->execute($sql);
                    } else {
                        if($vaa['rsWc']==1){
                           $sql = "update plan_dye_gang set fensanOver=1 where id='{$vaa['gangId']}'";
                           $vaa['rsType']='分散';
                           $this->_mGx->execute($sql);
                        }
                        $vaa['rsType'] = '分散';
                        
                    }
                } else {
                    $sql = "update plan_dye_gang set fensanOver=2 where id='{$vaa['gangId']}'";
                    $vaa['rsType']='套棉';
                    $this->_mGx->execute($sql);
                    if($vaa['isOver']==1){
                        $sql = "update plan_dye_gang set taomianOver=1 where id='{$vaa['gangId']}'";
                        $this->_mGx->execute($sql);
                    }else{
                        $sql = "update plan_dye_gang set taomianOver=0 where id='{$vaa['gangId']}'";
                        $this->_mGx->execute($sql);
                    }
                }
           }
        }
        foreach ($rowSon as $k => &$v) {
            $gxIds = $v['gxIds'];
            $gxIdsArr = explode(',',$gxIds);
            foreach ($gxIdsArr as $key => $c) {
                $res = array();
                $res['dateInput']       = $v['dateInput'];
                $res['gangId']          = $v['gangId'];
                $res['vatId']           = $v['vatId'];
                $res['gxIds']           = $gxIdsArr[$key];
                $res['wareName']        = $v['wareName'];
                $res['gongxu']          = $v['gxIds'];
                $res['gxTypeId']        = $v['gxTypeId'];
                $res['cnt']             = $v['cnt'];
                $res['type']            = 3;
                $res['workerId']        = $v['workerId'];
                $res['id']              = $v['id'];
                $res['leixing']         = $v['leixing'];
                $res['rsType']          = $v['rsType'];
                $res['rsMoney']         = $v['rsMoney'];
                $res['memoRs']           = $v['memoRs'];
                $sqlHebings ="select binggangId from plan_dye_gang where id='{$v['gangId']}'";
                $binggangIdNew = $this->_modelGang->findBySql($sqlHebings);
                $v['binggangIdNew'] = $binggangIdNew[0]['binggangId'];
                //dump($v['binggangIdNew']);die;
                if($v['binggangIdNew']>0){
                    $sqlVat = "select vatId from plan_dye_gang_merge where id='{$v['binggangIdNew']}'";
                    $vatId = $this->_modelGang->findBySql($sqlVat);
                    $v['vatId'] = $vatId[0]['vatId'];
                    $sqlbgs = "select count(*) as counts from plan_dye_gang where binggangId='{$v['binggangIdNew']}'";
                    $coutS = $this->_modelCl->findBySql($sqlbgs);
                }
                $rsDanjia = $this->_modelRsPrice->find(array('gxId'=>$gxIdsArr[$key],'vatId'=>$v['vatId'],'leixing'=>$v['leixing']));

                $res['danjia'] = $rsDanjia['price']>0?$rsDanjia['price']:'0';
                if($v['binggangIdNew']>0){
                    if($coutS[0]['counts']>0){
                        $res['danjia'] = $res['danjia']/$coutS[0]['counts'];
                    }
                }   
                $res['money'] = $res['danjia']*$res['cnt']/$countPerson;
                $res['danjia'] = $rsDanjia['price']>0?$rsDanjia['price']:'0';
                $res['rsMoney'] = $res['rsMoney']/$countPerson;
                $arr[]                  = $res;
            }
        }
        if(!count($arr)){
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
        $id = $this->_modelCl->saveRowset($arr);
        if($id){
            $data['params'] = array();
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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

    /**
     * @desc ：返回订单进度信息
     * Time：2020年2月8日 14:58:46
     * @author ShenHao
    */
    function getOrderProcess($params = array(),& $service){
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
                where 1 and o.dateOrder>='{$dateFrom}' and o.dateOrder<='{$dateTo}'";
        $vatNum = $params['vatNum']?$params['vatNum']:'';
        $orderCode = $params['orderCode']?$params['orderCode']:'';
        $clientIds = $params['clientId']>0?$params['clientId']:'';
        $compName = $params['dataSearch']?$params['dataSearch']:'';
        if($vatNum){
            $str.=" and g.vatNum like '%{$vatNum}%'";
        }
        if($orderCode){
            $str.=" and o.orderCode like '%{$orderCode}%'";
        }
        if($clientIds!=''){
            $str.=" and c.id = '{$clientIds}'";
        }
        if($compName!=''){
            $str.=" and c.compName like '%{$compName}%'";
        }
        $str.=" group by w.orderId";
        $str.=" ORDER BY w.id DESC,g.id DESC {$limit}";
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
        // dump($row);die;
        // dump2file($rowset);die;
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

    function getOrderData($params = array(),& $service){
        $mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
        $today  = date('Y-m-d');

        $beginDate = date('Y-m-01', strtotime(date("Y-m-d")));
        $endDate = date('Y-m-d', strtotime("$beginDate +1 month -1 day"));//本月最后一天

        //本日计划数
        $currSql = "SELECT
                sum(cntPlanTouliao) as cntM_Today
                FROM plan_dye_gang t
                WHERE t.planDate='{$today}'";
        $dataToday = $mOrder->findBySql($currSql);
        $rowToday = $dataToday[0];
        //本月计划数
        $monthSql = "SELECT
                sum(cntPlanTouliao) as cntM_month
                FROM plan_dye_gang t
                WHERE t.planDate>='{$beginDate}' and t.planDate<='{$endDate}'";
        $dataMonth = $mOrder->findBySql($monthSql);
        $rowMonth = $dataMonth[0];
         //本日发货数
        $monthFh = "SELECT sum(jingKg) as cntFhAllTd
                    FROM chengpin_dye_cpck c
                    WHERE c.dateCpck='{$today}'";
        $dataTodayFh = $mOrder->findBySql($monthFh);
        $rowFhDay = $dataTodayFh[0];
        //本月发货数
        $monthFh = "SELECT sum(jingKg) as cntFhAll
                    FROM chengpin_dye_cpck c
                    WHERE c.dateCpck>='{$beginDate}' and c.dateCpck<='{$endDate}'";
        $dataMonthFh = $mOrder->findBySql($monthFh);
        $rowFh = $dataMonthFh[0];
        $data = array();
        $data['rsp'] = array(
            'success' => true,
            'msg'     => '请求成功'
        );
        if($rowMonth || $rowToday){
            $data['params'] = array(
                'cntM_Today'=>$rowToday['cntM_Today']+0,  //本日计划数
                'cntM_month'=>$rowMonth['cntM_month']+0,  //本月计划数
                'cntFh_Today'=>$rowFhDay['cntFhAllTd']+0 , //本月发货数
                'cntFh_Month'=>$rowFh['cntFhAll']+0 , //本月发货数
                'money_month'=>0 ,
            );
        }else{
            $data['rsp']['success'] = false;
            $data['rsp']['msg'] = '未找到相关记录';
            return $data;
        }
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