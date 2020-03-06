<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_ChuKuBc extends Tmis_Controller {
    var $_modelChuku;
    //var $thisController = "CangKu_ChuKu";	//当前控制器名
    //var $queenController = "CangKu_ChuKu2ware";		//增加产品控制器
    //var $title = "领料出库";
    var $funcId;

    function Controller_CangKu_ChuKuBc() {
        $this->_modelChuku = & FLEA::getSingleton('Model_CangKu_ChuKu');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
        $this->_modelChuku2Ware = & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $this->_modelRuku2Ware = & FLEA::getSingleton('Model_CangKu_RuKu2Ware');
        $this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
    }
     /**
     * ps ：#修改领出数量
     * Time：2017/09/01 13:55:18
     * @author zcc
    */
    function actionEditNum() {
        //$this->authCheck();
        $rowC2W=$this->_modelChuku2Ware->findByField('id', $_GET['chuku2wareId']);
        $str="SELECT
            x.*
        FROM
            cangku_ruku2ware x
        LEFT JOIN cangku_ruku y ON y.id = x.ruKuId
        WHERE
            1 and y.kind = '1' and x.wareId = '{$rowC2W['wareId']}'
        GROUP BY
            x.chandi";
        //echo $str;
        $query=mysql_query($str);
        while($re=mysql_fetch_assoc($query)){
            $chandi[]=$re['chandi'];
        }
        $smarty = & $this->_getView();
        $smarty->assign("arr_field_value",$rowC2W);
        $pkName=$this->_modelChuku2Ware->primaryKey;
        $smarty->assign("pk_name",$pkName);
        $smarty->assign('chandi',$chandi);
        $smarty->display('CangKu/ChuKu2WareEdit2.tpl');
    }
    /**
     * ps ：领料查询 
     * Time：2017/09/01 11:20:10
     * @author zcc
    */
    function actionRight() {
        $this->authCheck(52);
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            clientId=>0,
            orderCode=>'',
            vatNum=>'',
            dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            dateTo=>date("Y-m-d"),
            wareName=>'',
            'chandi'=>'',
        ));
        $sql = "SELECT
            x.chukuDate,
            c.compName,
            a.orderCode,
            g.vatNum,
            t.color,
            y.chandi,
            y.cnt,
            x.id AS chukuId,
            y.id AS chuku2wareId,
            g.cntPlanTouliao,
            CONCAT(w.wareName, ' ', w.guige) AS zhibei
        FROM
            cangku_chuku x
        LEFT JOIN cangku_chuku2ware y ON x.id = y.chukuId
        LEFT JOIN plan_dye_gang g ON g.id = y.gangId
        LEFT JOIN trade_dye_order2ware t ON t.id = g.order2wareId
        LEFT JOIN trade_dye_order a ON a .id = t.orderId
        LEFT JOIN jichu_ware w ON w.id = t.wareId
        LEFT JOIN jichu_client c ON c.id = a .clientId
        WHERE 1 and y.kind = '1'";
        if ($arr['clientId']>0) $sql .= " and a.clientId = '{$arr['clientId']}' ";
        if ($arr['wareId']>0) $sql .= " and y.wareId = '{$arr['wareId']}' ";
        if ($arr['orderCode']!='') $sql .= " and a.orderCode like '%$arr[orderCode]%'";
        if ($arr['vatNum']!='') $sql .= " and g.vatNum like '%$arr[vatNum]%'";
        if ($arr['chandi']!='') $sql .= " and y.chandi like '%$arr[chandi]%'";
        if ($arr[dateFrom]) {
            $sql .= " and x.chukuDate>='$arr[dateFrom]'";
            $sql .= " and x.chukuDate<='$arr[dateTo]'";
        }
        $sql .= " order by x.id desc";
        //组合的字段筛选 进行包装
        $sql = "SELECT * FROM ($sql) as a WHERE 1";
        if ($arr['wareName']) {
            $sql .=" and a.zhibei like '%{$arr['wareName']}%'";
        }     
        $pager= & new TMIS_Pager($sql);
        // $rowset= $pager->findAllBySql($str);
        $rowset=$pager->findAll();    
        // dump($rowset);exit();
        if (count($rowset)>0)foreach ($rowset as &$v) {
            $v['guige'] = $v['zhibei'];
            $v['_edit'] = "<a href='".$this->_url('editNum', array('chuku2wareId'=>$v[chuku2wareId]))."'>修改</a> 
            <a href='".$this->_url('remove', array('id'=>$v['chukuId']))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>";
        }
        $heji = $this->getHeji($rowset,array('cntPlanTouliao','cnt'),'chukuDate');
        $rowset[] = $heji;
        $smarty = & $this->_getView();
        #对表头进行赋值
        $arrFieldInfo = array(
            "chukuDate" =>"领料日期",
            "compName" =>"客户",
            "orderCode"=>"订单号",
            "vatNum"=>"缸号",
            "guige" =>"规格",
            "color"=>"颜色",
            'chandi'=>'产地',
            "cntPlanTouliao"=>"计划投料",
            "cnt" =>"领出数量",
            '_edit'=>"修改"
        );
        $smarty->assign('title','坯纱领料出库明细');
        $smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_condition',$arr);
        #对字段内容进行赋值:
        $smarty->assign('arr_field_value',$rowset);
        #设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
        $smarty->assign('pk',$pk);
        #分页信息
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        #开始显示
        $smarty->display('TableList.tpl');
    }
    /**
     * ps ：本厂领料出库
     * Time：2017/08/31 17:18:37
     * @author zcc
    */
    function actionListforAdd(){
        $this->authCheck(52);
        $dateFrom = '2012-04-22';
        $this->_modelGang->enableLink('PishaLingliao');
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            clientId=>'',
            orderCode=>'',
            vatNum=>'',
            guige=>''
        ));
        $condition=array("x.parentGangId=0","x.planDate>'$dateFrom'");
        $condition[]="x.gangId not in (select gangId from cangku_chuku2ware)";
        if ($arr[clientId]>0) $condition[]="x.clientId='$arr[clientId]'";
        if ($arr[orderCode]!='') $condition[]="x.orderCode like '%$arr[orderCode]%'";
        if ($arr[vatNum]!='') $condition[]="x.vatNum like '%$arr[vatNum]%'";
        if ($arr[guige]!='') $condition[]="x.guige like '%$arr[guige]%'";
        $condition[]="x.orderId in (select id from trade_dye_order where kind = 1)";
        $condition[]="y.PishaPrintTimes > 0";
        //if ($arr[wareId]>0) $condition[]="wareId='$arr[wareId]'";
        $pager=null;
        $rowset=$this->_modelGang->findAllGang1New($condition,$pager,0,'orderCode desc');
        if(count($rowset)>0) foreach($rowset as $key=>& $v) {
            //$v[cntLingliao] = $this->_modelGang->getCntPishaLingliao($v[gangId]);
                $tTouliao += $v[cntPlanTouliao];
                $v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v[orderCode]);
                if($v[cntLingliao]==$v[cntPlanTouliao]) {
                    $v[_edit] = "<font color=red>已领</font>";
                } else $v['_edit']='<input type="checkbox" name="lingliao[]" id="lingliao[]" value="'.$v['gangId'].'" onclick="sss(this,'.$v['clientId'].')" />';
        //得到客户的单号
        $mm=$this->_modelOrder->find(array('id'=>$v['orderId']));
        $v['orderCode2']=$mm['orderCode2'];
        if($v['orderCode2']!='') $v['compName']=$v['compName'].'('.$v['orderCode2'].')';
        //dump($mm);
            }
        //加入合计
        $i = count($rowset);
        $rowset[$i][planDate] = '<b>合计</b>';
        //$rowset[$i]['_edit']=;
        $rowset[$i][cntPlanTouliao] = "<b>$tTouliao</b>";

        //dump($rowset);exit;
        $smarty = $this->_getView();
        $smarty->assign("supplier_name", '客户');
        $smarty->assign('arr_field_info',array(
            "planDate" => "排缸日期",
            "compName" => "客户(客户单号)",
            "orderCode" => "订单号",
            "vatNum" =>"缸号",
            'wareName' => '纱织',
            "guige" => "规格",
            "color" =>"颜色",
            "cntPlanTouliao" =>"计划投料",
            //"cntLingliao" => "已领数量",
            "_edit" => '<input type="submit" id="submit1" value="领料"/>'
        ));
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('url',$this->_url('MakeRecords',array('clientId'=>$rowset['0']['clientId'])));
        $smarty->assign('add_display',0);
        $smarty->assign('page_info',$pager->getNavBar($this->_url('ChanliangInput1',$arr)));
        $smarty->assign('title','坯纱领料出库登记');
        $result=$smarty->fetch('TableList3.tpl');
        $result.="
        <script>
            var clientId='';
            function sss(obj,id){
                if(clientId==''){
                    clientId=id;
                }
                else{
                    if(clientId==id){
                    //同一个客户
                    }
                    else{
                        alert('请选择同一个客户!!');
                        $('input[@id=\"lingliao[]\"]').each(function(){
                            if(this==obj){
                                this.checked=false;
                            }
                        });
                        return false;
                    }
                }
            }
        </script>
        ";
        echo $result;
    }
    function actionMakeRecords() {
        $arrSub=array();
        $heji='';
        if(count($_POST)>0) foreach($_POST['lingliao'] as $v) {
            $client = $this->_modelGang->getClient($v);
            $m0 = &FLEA::getSingleton('Model_Trade_Dye_Order');

            $ware = $this->_modelGang->getWare($v);
            $gang = $this->_modelGang->find($v);
            $orderId = $gang[OrdWare][orderId];
            $aOrder=$m0->find(array(id=>$orderId));
            $orderCode=$aOrder[orderCode];

            $arrSub[] = array(
                'chukuId' => $mainId,
                'gangId' => $v,
                'gangName'=>$gang['vatNum'],
                'supplierId' =>$client[id],
                'supplierName'=>$client['compName'],
                'wareId' =>$ware[id],
                'chandi'=>$gang['OrdWare']['chandi'],
                'wareName'=>$ware['wareName'].'['.$ware['guige'].']',
                'cnt' =>$gang['cntPlanTouliao'],
                'pihao' =>$gang['OrdWare']['pihao']
            );
        }
        //合并相同纱支
        $arrShow=array();
        if(count($arrSub)>0) {
            foreach($arrSub as $key=>$v) {
                $wareId=$v['wareId'];
                unset($v['wareId']);
                $arrShow[$wareId][]=$v;
                $heji+=$v['cnt'];
                $str="select x.* 
                from cangku_ruku2ware x
                left join cangku_ruku y on y.id=x.ruKuId
                where y.kind = 1
                group by x.chandi
                ";
                $query=mysql_query($str);
                while($re=mysql_fetch_assoc($query)){
                    $kucun = $this->Getkucun($wareId,0,$re['chandi']);
                    if ($kucun>0) {
                        $chandi[$wareId][]=$re['chandi'];
                    }
                    
                }
            }
            
        }
        $chandi[$wareId] = array_unique($chandi[$wareId]);//by zcc 产地重复的问题
        // dump($chandi);dump($arrShow);exit();
        $smarty= & $this->_getView();
        $smarty->assign('time',date('Y-m-d'));
        $smarty->assign('heji',$heji);
        $smarty->assign('aRow',$arrShow);
        $smarty->assign('chandi',$chandi);
        $smarty->display('Cangku/LingliaoViewBc.tpl');
    }
        /**
     * ps ：用来返回库存值
     * Time：2016/12/19 15:12:34
     * @author zcc
     * @return 返回值类array型
    */
    function Getkucun($wareId,$supplierId,$chandi){
        #入库数
        $str="select sum(x.cnt) as cnt
            from cangku_ruku2ware x
            left join cangku_ruku y on y.id=x.ruKuId
            where y.kind = 1
            and x.wareId='{$wareId}'
            and x.chandi='{$chandi}'
        ";
        //echo $str.'<br>';
        $ruku=mysql_fetch_assoc(mysql_query($str));
        #出库数
        $str="select sum(cnt) as cnt
            from cangku_chuku2ware
            where 1
            and wareId='{$wareId}'
            and chandi='{$chandi}'
        ";
        //echo $str.'<br>';
        $chuku=mysql_fetch_assoc(mysql_query($str));
        $arr['cntKucun']=$ruku['cnt']-$chuku['cnt'];
        return $arr['cntKucun'];
    }
        #通过产地和客户取得库存
    function actionGetKucunByJson(){
        #入库数
        $str="select sum(x.cnt) as cnt
            from cangku_ruku2ware x
            left join cangku_ruku y on y.id=x.ruKuId
            where 1 and y.kind = '1'
            and x.wareId='{$_GET['wareId']}'
            and x.chandi='{$_GET['chandi']}'
            and x.pihao='{$_GET['pihao']}'
        ";
        //echo $str.'<br>';
        $ruku=mysql_fetch_assoc(mysql_query($str));
        #出库数
        $str="select sum(cnt) as cnt
            from cangku_chuku2ware
            where supplierId='{$_GET['supplierId']}' and kind = '1'
            and wareId='{$_GET['wareId']}'
            and chandi='{$_GET['chandi']}'
            and pihao='{$_GET['pihao']}'
        ";
        //echo $str.'<br>';
        $chuku=mysql_fetch_assoc(mysql_query($str));
        $arr['cntKucun']=$ruku['cnt']-$chuku['cnt'];
        echo json_encode($arr);
        exit;
    }
        //保存坏纱领料
    function actionSaveRecords() {
        // dump($_POST);exit();
        $arrMain = array(
            chukuDate => date("Y-m-d")
            //chukuNum => ''
        );

        // $mainId=$this->_modelChuku->create($arrMain);
        $arr=$_POST;
        $arrSub=array();
        $arrSub['chukuDate']=date("Y-m-d");
        if(count($_POST)>0) foreach($_POST['wareId'] as $key=>$v) {
            $arrSub['Wares'][$key]['wareId']=$arr['wareId'][$key];
            if($arr['wareId2'][$v]!='')
            $arrSub['Wares'][$key]['wareId']=$arr['wareId2'][$v];
            $arrSub['Wares'][$key]['gangId']=$arr['gangId'][$key];
            $arrSub['Wares'][$key]['supplierId']=$arr['supplierId'][$key];
            $arrSub['Wares'][$key]['cnt']=$arr['cnt'][$key];
            $arrSub['Wares'][$key]['chandi']=$arr['chandi'][$key];
            $arrSub['Wares'][$key]['kind']=1;

        }
        // dump($arrSub);exit;
        /*****是否库存不足**********************/
        $ware=array_group_by($arrSub['Wares'],'wareId');
        $cnt=array();
        if($ware)foreach($ware as $key=> $v){
            $temp=0;
            foreach($v as $vv){
                $temp+=$vv['cnt'];
            }
            $cnt[$key]=$temp;
        }
        //得到纱支的库存数
        if($cnt)foreach($cnt as $key=> & $v){
            $chuku=$this->_modelChuku2Ware->findAll(array('wareId'=>$key));
            $ruku=$this->_modelRuku2Ware->findAll(array('wareId'=>$key));
            $chukuCnt=$this->getHeji($chuku, array('cnt'));
            $rukuCnt=$this->getHeji($ruku, array('cnt'));
            $v=$rukuCnt['cnt']-$chukuCnt['cnt']-$v;
        }
        // dump($cnt);exit();
        //数量是否为负,为负写入日志
        $mlog= & FLEA::getSingleton('Model_CangKu_Log');
        $mware=& FLEA::getSingleton('Model_Jichu_Ware');
        foreach($cnt as $key=> $v){
            $ware=$mware->find(array('id'=>$key));
            if($v<0){
                //$msg.=$ware['wareName'].$ware['guige'].'['.$ware['unit'].'] 不足:'.abs($v).'  ';
                $log=array('wareId'=>$key,'cnt'=>abs($v),'user'=>$_SESSION['USERNAME']);
                $mlog->save($log);
            }

        }
        //dump($cnt);
        // dump($arrSub);exit;
        $subId = $this->_modelChuku->save($arrSub);
        if($_POST['submit']=='确定并打印'){
            js_alert('','',$this->_url('PrintRecords',array('id'=>$subId)));
        }
        else
        {
            js_alert('','',url('CangKu_ChuKu','ChanliangInput1'));
        }
    }

    function actionPrintRecords(){
        $ware=& FLEA::getSingleton('Model_JiChu_Ware');
        $client=& FLEA::getSingleton('Model_JiChu_Client');
        $arr=$this->_modelChuku->find(array('id'=>$_GET['id']));
        //dump($arr);
        if($arr['Wares'])foreach($arr['Wares'] as & $v){
            $v['Gang']=$this->_modelGang->find(array('id'=>$v['gangId']));
            $v['Ware']=$ware->find(array('id'=>$v['wareId']));
            $v['Client']=$client->find(array('id'=>$v['supplierId']));
        }
        //dump($arr);exit;
        $smarty= & $this->_getView();
        $smarty->assign('aRow',$arr);
        $smarty->display('Cangku/LingliaoPrint.tpl');
    }
    #删除
    function actionRemove() {
        $pk = $_GET['id'];
        $this->_editable($pk);
        $this->_modelChuku->removeByPkv($pk);
        redirect($this->_url('right'));
    }
    function actionRemoveWare() {
        $modelChuku2Wares = FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $modelChuku2Wares->removeByPkv($_GET['id']);
        redirect($this->_url('right'));
    }
    //领料统计
    function actionTongji(){
        $this->authCheck(52);
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            clientId=>0,
            orderCode=>'',
            vatNum=>'',
            dateFrom=>date("Y-m-d"),
            dateTo=>date("Y-m-d"),
            // wareId=>0
        ));

        $sql = "SELECT
            x.chukuDate,
            c.compName,
            a.orderCode,
            g.vatNum,
            t.color,
            y.chandi,
            sum(y.cnt) as cnt,
            x.id AS chukuId,
            y.id AS chuku2wareId,
            sum(g.cntPlanTouliao) as cntPlanTouliao1,
            CONCAT(w.wareName, ' ', w.guige) AS zhibei
        FROM
            cangku_chuku x
        LEFT JOIN cangku_chuku2ware y ON x.id = y.chukuId
        LEFT JOIN plan_dye_gang g ON g.id = y.gangId
        LEFT JOIN trade_dye_order2ware t ON t.id = g.order2wareId
        LEFT JOIN trade_dye_order a ON a .id = t.orderId
        LEFT JOIN jichu_ware w ON w.id = t.wareId
        LEFT JOIN jichu_client c ON c.id = a .clientId
        WHERE 1 and y.kind = '1'";
        if ($arr['clientId']>0) $sql .= " and a.clientId = '{$arr['clientId']}' ";
        if ($arr['wareId']>0) $sql .= " and y.wareId = '{$arr['wareId']}' ";
        if ($arr['orderCode']!='') $sql .= " and a.orderCode like '%$arr[orderCode]%'";
        if ($arr['vatNum']!='') $sql .= " and g.vatNum like '%$arr[vatNum]%'";
        if ($arr['chandi']!='') $sql .= " and y.chandi like '%$arr[chandi]%'";
        if ($arr[dateFrom]) {
            $sql .= " and x.chukuDate>='$arr[dateFrom]'";
            $sql .= " and x.chukuDate<='$arr[dateTo]'";
        }
        $sql .= " group by x.chukuDate,c.compName,w.guige order by x.id desc";
        // dump($sql);die();
        $pager= & new TMIS_Pager($sql);
        $rowset= $pager->findAllBySql($str);
        //dump($rowset[0]);exit;
        $heji = $this->getHeji($rowset,array('cntPlanTouliao','cnt'),'chukuDate');

        if (count($rowset)>0) foreach($rowset as & $value) {
            $chuku=$this->_modelChuku2Ware->find(array('id'=>$value['chuku2wareId']));
            $mware = & FLEA::getSingleton('Model_Jichu_Ware');
            $ware=$mware->find($chuku['wareId']);
            $value[guige] = $ware[wareName].' '.$ware[guige];
        }
        $rowset[] = $heji;

        $smarty = & $this->_getView();
        $smarty->assign('title', $this->title);

        #对表头进行赋值
        $arrFieldInfo = array(
            //"chukuNum" =>"单号",
            "chukuDate" =>"领料日期",
            //"depName" =>"领料部门",
            "compName" =>"客户",
            "orderCode"=>"订单号",
            "vatNum"=>"缸号",
            "guige" =>"规格",
            //"color"=>"颜色",
            "cntPlanTouliao1"=>"计划投料",
            "cnt" =>"领出数量",
            //'edit'=>"修改"
        );
        $smarty->assign('title','坯纱领料统计');
        $smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_condition',$arr);
        #对字段内容进行赋值:
        $smarty->assign('arr_field_value',$rowset);
        #设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
        $smarty->assign('pk',$pk);
        #分页信息
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        #开始显示
        $smarty->display('TableList.tpl');
    }
    /**
     * ps ：本厂收发存 中出库领料明细
     * Time：2017/09/04 10:34:52
     * @author zcc
    */
    function actionDetailChuku(){
         FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            clientId=>0,
            orderCode=>'',
            vatNum=>'',
            dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            dateTo=>date("Y-m-d"),
            wareId=>0
        ));

        $sql = "SELECT
            x.chukuDate,
            c.compName,
            a.orderCode,
            g.vatNum,
            t.color,
            y.chandi,
            y.cnt,
            x.id AS chukuId,
            y.id AS chuku2wareId,
            g.cntPlanTouliao,
            CONCAT(w.wareName, ' ', w.guige) AS zhibei
        FROM
            cangku_chuku x
        LEFT JOIN cangku_chuku2ware y ON x.id = y.chukuId
        LEFT JOIN plan_dye_gang g ON g.id = y.gangId
        LEFT JOIN trade_dye_order2ware t ON t.id = g.order2wareId
        LEFT JOIN trade_dye_order a ON a .id = t.orderId
        LEFT JOIN jichu_ware w ON w.id = t.wareId
        LEFT JOIN jichu_client c ON c.id = a .clientId
        WHERE 1 and y.kind = '1'";
        if ($arr['clientId']>0) $sql .= " and a.clientId = '{$arr['clientId']}' ";
        if ($arr['wareId']>0) $sql .= " and y.wareId = '{$arr['wareId']}' ";
        if ($arr['orderCode']!='') $sql .= " and a.orderCode like '%$arr[orderCode]%'";
        if ($arr['vatNum']!='') $sql .= " and g.vatNum like '%$arr[vatNum]%'";
        if ($arr['chandi']!='') $sql .= " and y.chandi like '%$arr[chandi]%'";
        if ($arr[dateFrom]) {
            $sql .= " and x.chukuDate>='$arr[dateFrom]'";
            $sql .= " and x.chukuDate<='$arr[dateTo]'";
        }
        $sql .= " order by x.id desc";
        //组合的字段筛选 进行包装
        $sql = "SELECT * FROM ($sql) as a WHERE 1";
        if ($arr['wareName']) {
            $sql .=" and a.zhibei like '%{$arr['wareName']}%'";
        }  

        $pager= & new TMIS_Pager($sql);
        $rowset= $pager->findAllBySql($str);
        //dump($rowset[0]);exit;
        $heji = $this->getHeji($rowset,array('cntPlanTouliao','cnt'),'chukuDate');

        if (count($rowset)>0) foreach($rowset as & $value) {
                $chuku=$this->_modelChuku2Ware->find(array('id'=>$value['chuku2wareId']));
                $mware = & FLEA::getSingleton('Model_Jichu_Ware');
                $ware=$mware->find($chuku['wareId']);
                $value[guige] = $ware[wareName].' '.$ware[guige];
            }
        //dump($rowset[0]);exit;
        $rowset[] = $heji;

        $smarty = & $this->_getView();
        $smarty->assign('title', $this->title);

        #对表头进行赋值
        $arrFieldInfo = array(
            "chukuDate" =>"领料日期",
            "compName" =>"客户",
            "orderCode"=>"订单号",
            "vatNum"=>"缸号",
            "guige" =>"规格",
            "color"=>"颜色",
            'chandi'=>'产地',
            "cntPlanTouliao"=>"计划投料",
            "cnt" =>"领出数量",
        );

        $smarty->assign('title','坯纱领料出库明细');
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('nav_display','none');

        #对字段内容进行赋值:
        $smarty->assign('arr_field_value',$rowset);

        #设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
        $smarty->assign('pk',$pk);

        #分页信息
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));

        #开始显示
        $smarty->display('TableList.tpl');
    }
}    