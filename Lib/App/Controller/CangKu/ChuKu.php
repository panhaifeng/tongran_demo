<?php
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_ChuKu extends Tmis_Controller {
    var $_modelChuku;
    //var $thisController = "CangKu_ChuKu";	//当前控制器名
    //var $queenController = "CangKu_ChuKu2ware";		//增加产品控制器
    //var $title = "领料出库";
    var $funcId;

    function Controller_CangKu_ChuKu() {
        $this->_modelChuku = & FLEA::getSingleton('Model_CangKu_ChuKu');
		$this->_modelOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
        $this->_modelChuku2Ware = & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $this->_modelRuku2Ware = & FLEA::getSingleton('Model_CangKu_RuKu2Ware');
        $this->_modelGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
    }


    //坯纱领料登记，只显示基础信息
    function actionRight() {
        $this->authCheck(52);
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            clientId=>0,
            orderCode=>'',
            vatNum=>'',
            dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            dateTo=>date("Y-m-d"),
            //wareId=>0
            wareName=>'',
            'chandi'=>'',
        ));

        $condition=array();
        if ($arr[clientId]>0) $condition[]="x.supplierId='$arr[clientId]'";
        if ($arr[wareId]>0) $condition[] = "x.wareId='$arr[wareId]'";
        if ($arr[orderCode]!='') $condition[] = "y.orderCode like '%$arr[orderCode]%'";
        if ($arr[vatNum]!='') $condition[] = "y.vatNum like '%$arr[vatNum]%'";
        if ($arr['chandi']!='') $condition[] = "x.chandi like '%$arr[chandi]%'";
        if ($arr[dateFrom]) {
            $condition[] = "x.chukuDate>='$arr[dateFrom]'";
            $condition[] = "x.chukuDate<='$arr[dateTo]'";
        }
        
        //dump($arr);dump($condition);
        $str = "select x.chukuId, x.id as chuku2wareId,
            x.chukuDate,x.cnt,x.chandi,y.*,CONCAT(y.wareName,' ',y.guige) as zhibei
            from  view_cangku_chuku x
            left join view_dye_gang y on x.gangId=y.gangId
            where 1 and x.kind = 0
		";
        //加入下面的语句后，库存报表出现问题，y.planDate>'$dateFrom'
        if (count($condition)>0) $str .= " and ".join(' and ',$condition);
        $str .= " order by x.id desc";
        //echo $str;
        $sql = "select * from ($str) as a where 1";
        if ($arr[wareName]) {
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
                $value[edit] = "<a href='".$this->_url('editNum', array('chuku2wareId'=>$value[chuku2wareId]))."'>修改</a> <a href='".$this->_url('remove', array('id'=>$value['chukuId']))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>";
            }
        //dump($rowset[0]);exit;
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
            "color"=>"颜色",
			'chandi'=>'产地',
            "cntPlanTouliao"=>"计划投料",
            "cnt" =>"领出数量",
            'edit'=>"修改"
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
    //出库明细
    function actionRight2() {
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            clientId=>0,
            orderCode=>'',
            vatNum=>'',
            dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            dateTo=>date("Y-m-d"),
            wareId=>0
        ));

        $condition=array();
        if ($arr[clientId]>0) $condition[]="x.supplierId='$arr[clientId]'";
        if ($arr[wareId]>0) $condition[] = "x.wareId='$arr[wareId]'";
        if ($arr[orderCode]!='') $condition[] = "y.orderCode like '%$arr[orderCode]%'";
        if ($arr[vatNum]!='') $condition[] = "y.vatNum like '%$arr[vatNum]%'";
        if ($arr[dateFrom]) {
            $condition[] = "x.chukuDate>='$arr[dateFrom]'";
            $condition[] = "x.chukuDate<='$arr[dateTo]'";
        }
        //dump($arr);dump($condition);
        $str = "select x.chukuId, x.id as chuku2wareId, x.chukuDate,x.cnt,x.chandi,y.* from  view_cangku_chuku x left join view_dye_gang y on x.gangId=y.gangId where 1";
        //加入下面的语句后，库存报表出现问题，y.planDate>'$dateFrom'
        if (count($condition)>0) $str .= " and ".join(' and ',$condition);
        $str .= " order by x.id desc";
        //echo $str;
        $pager= & new TMIS_Pager($str);
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
            //"chukuNum" =>"单号",
            "chukuDate" =>"领料日期",
            //"depName" =>"领料部门",
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
            wareId=>0
        ));

        $condition=array();
        if ($arr[clientId]>0) $condition[]="x.supplierId='$arr[clientId]'";
        if ($arr[wareId]>0) $condition[] = "x.wareId='$arr[wareId]'";
        if ($arr[orderCode]!='') $condition[] = "y.orderCode like '%$arr[orderCode]%'";
        if ($arr[vatNum]!='') $condition[] = "y.vatNum like '%$arr[vatNum]%'";
        if ($arr[dateFrom]) {
            $condition[] = "x.chukuDate>='$arr[dateFrom]'";
            $condition[] = "x.chukuDate<='$arr[dateTo]'";
        }
        //dump($arr);dump($condition);
        $str = "select x.chukuId,
		x.id as chuku2wareId,
		x.chukuDate,
		sum(x.cnt) as cnt,
		y.*,
		sum(y.cntPlanTouliao) as cntPlanTouliao1
		from  view_cangku_chuku x
		left join view_dye_gang y on x.gangId=y.gangId
		where 1 and x.kind = 0";
        //加入下面的语句后，库存报表出现问题，y.planDate>'$dateFrom'
        if (count($condition)>0) $str .= " and ".join(' and ',$condition);
        $str .= " group by x.chukuDate,y.compName,y.guige";
        $str .= " order by x.id desc";
       // echo $str;exit;
        $pager= & new TMIS_Pager($str);
        $rowset= $pager->findAllBySql($str);
        //dump($rowset[0]);exit;
        $heji = $this->getHeji($rowset,array('cntPlanTouliao','cnt'),'chukuDate');

        if (count($rowset)>0) foreach($rowset as & $value) {
                $chuku=$this->_modelChuku2Ware->find(array('id'=>$value['chuku2wareId']));
                $mware = & FLEA::getSingleton('Model_Jichu_Ware');
                $ware=$mware->find($chuku['wareId']);
                $value[guige] = $ware[wareName].' '.$ware[guige];
                //$value[edit] = "<a href='".$this->_url('editNum', array('chuku2wareId'=>$value[chuku2wareId]))."'>修改</a> <a href='".$this->_url('remove', array('id'=>$value['chukuId']))."' onclick='return confirm(\"您确认要删除吗？\");'>删除</a>";

            }
        //dump($rowset[0]);exit;
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
    #库存不足报表
    function actionRight1(){
         $mlog= & FLEA::getSingleton('Model_CangKu_Log');
         $arr=$mlog->findAll();
         //dump($arr);exit;
         $arr_field_info=array(
            'id'=>'系统编号',
            'Wares.wareName'=>'品名',
            'Wares.guige'=>'规格',
            'Wares.unit'=>'单位',
            'cnt'=>'负库存数',
            'user'=>'操作人',
            'dt'=>'操作时间'
         );
         $smarty= & $this->_getView();
         $smarty->assign('arr_field_value',$arr);
         $smarty->assign('arr_field_info',$arr_field_info);
         $smarty->assign('add_display','none');
         $smarty->display('TableList.tpl');
    }
    //坏纱领料界面
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
        //dump($arrSub);exit();
        //合并相同纱支
        $arrShow=array();
        if(count($arrSub)>0) {
            foreach($arrSub as $key=>$v) {
                $wareId=$v['wareId'];
                unset($v['wareId']);
                $arrShow[$wareId][]=$v;
                $heji+=$v['cnt'];
                $str="select x.* from cangku_ruku2ware x
                left join cangku_ruku y on y.id=x.ruKuId
                where y.supplierId='{$arrSub[0]['supplierId']}'
                group by x.chandi
                ";
                //echo $str;
                $query=mysql_query($str);
                while($re=mysql_fetch_assoc($query)){
                    $kucun = $this->Getkucun($wareId,$arrSub[0]['supplierId'],$re['chandi']);
                    if ($kucun>0) {
                        $chandi[$wareId][]=$re['chandi'];
                    }
                    
                }
            }
            
        }
        // 注释原来的方法 by zcc
		// $str="select x.* from cangku_ruku2ware x
		// 	left join cangku_ruku y on y.id=x.ruKuId
		// 	where y.supplierId='{$arrSub[0]['supplierId']}'
		// 	group by x.chandi
		// ";
		// //echo $str;
		// $query=mysql_query($str);
		// while($re=mysql_fetch_assoc($query)){
		// 	$chandi[]=$re['chandi'];
		// }
        $chandi[$wareId] = array_unique($chandi[$wareId]);//by zcc 产地重复的问题
        //dump($chandi);dump($arrShow);exit();
        $smarty= & $this->_getView();
        $smarty->assign('time',date('Y-m-d'));
        $smarty->assign('heji',$heji);
        $smarty->assign('aRow',$arrShow);
		$smarty->assign('chandi',$chandi);
        $smarty->display('Cangku/LingliaoView.tpl');
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
            where y.supplierId='{$supplierId}'
            and x.wareId='{$wareId}'
            and x.chandi='{$chandi}'
        ";
        //echo $str.'<br>';
        $ruku=mysql_fetch_assoc(mysql_query($str));
        #出库数
        $str="select sum(cnt) as cnt
            from cangku_chuku2ware
            where supplierId='{$supplierId}'
            and wareId='{$wareId}'
            and chandi='{$chandi}'
        ";
        //echo $str.'<br>';
        $chuku=mysql_fetch_assoc(mysql_query($str));
        $arr['cntKucun']=$ruku['cnt']-$chuku['cnt'];
        return $arr['cntKucun'];
    }
    //坏纱领料打印界面
    function actionPrintLingliao() {
        // dump($_POST);exit();
        $arrSub=array();
        $heji='';
        $ids = array();
        if(count($_POST)>0) foreach($_POST['lingliao'] as $v) {
            $ids[] = $v;
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
                'wareName'=>$ware['wareName'].'['.$ware['guige'].']',
                'cnt' =>$gang['cntPlanTouliao'],
                'pihao' =>$gang['OrdWare']['pihao'],
                'color'=>$gang['OrdWare']['color'],
            );
        }
        
        //客户汇总
        $arrSub=array_group_by($arrSub,'supplierId');
        // dump($arrSub);die();
        //纱支汇总
        foreach($arrSub as & $v){
            $v=array_group_by($v,'pihao');
        }
        // dump($arrSub);die;
        foreach($arrSub as & $v){
            foreach($v as & $vv){
                $heji1=$this->getHeji($vv, array('cnt'), 'wareName');
                //dump($heji1);
                    $rowset[]=array(
                        'chukuDate'=>date('Y-m-d'),
                        'proName'=>$vv['0']['supplierName'],
                        //'guige'=>$vv['0']['wareName'],
                        'cnt'=>$heji1['cnt'],
                        'pihao' => $vv['0']['pihao'],
                        //'vatNum'=>$vv['0']['gangName'],
                        //'color'=>$vv['0']['color'],
                    );
            }
        }
        //dump($rowset);die;
        $gangName = array();
        $guige = array();
        $color = array();
        //dump($arrSub);die;
        foreach ($arrSub as $key => &$value) {
            foreach ($value as $ke => &$val) {
                foreach ($val as $kk => &$vals) {
                    $gangName[$key][$ke][] = $vals['gangName'];
                    $guige[$key][$ke][] = $vals['wareName'];
                    $color[$key][$ke][] = $vals['color'];
                }
            }
        }
        //dump($gangName);die;
        foreach ($arrSub as $key => &$va) {
           foreach ($va as $ke => &$vall) {
               foreach ($vall as $k => &$vaa) {
                   $vaa['gangName'] = $gangName[$key][$ke];
                   $vaa['guige'] = $guige[$key][$ke];
                   $vaa['color'] = $color[$key][$ke];
               }
           }
        }
        //dump($arrSub);die;
        // $arrSub = array_values($arrSub);
        foreach ($arrSub as $key => &$valu) {
            foreach ($valu as $ke => &$values) {
                foreach ($values as $k => &$val1) {
                    $arrNew[$key.'-'.$val1['pihao']]['gangName'] = $values[0]['gangName'];
                    $arrNew[$key.'-'.$val1['pihao']]['guige'] = $values[0]['guige'];
                    $arrNew[$key.'-'.$val1['pihao']]['color'] = $values[0]['color'];
                }
            }
        }
        $arrNew = array_values($arrNew);
        foreach ($arrNew as $key => &$vala) {
            $arrNew[$key]['chukuDate'] = $rowset[$key]['chukuDate'];
            $arrNew[$key]['proName'] = $rowset[$key]['proName'];
            $arrNew[$key]['cnt'] = $rowset[$key]['cnt'];
            $arrNew[$key]['pihao'] = $rowset[$key]['pihao'];

        }
        // dump($rowset);die;
        $heji =0;
        foreach ($arrNew as $key => &$vaq) {
           $vaq['vatNum'] = implode('<br>', $vaq['gangName']);
           $vaq['guige'] = implode('<br>', $vaq['guige']);
           $vaq['color'] = implode('<br>', $vaq['color']);
           $heji+=$vaq['cnt'];            
        }
        //dump($rowset);die;
        //将打印的缸 进行标记 打印次数+1（PishaPrintTimes）
        $ids = join($ids,',');
        $sql = "UPDATE plan_dye_gang SET PishaPrintTimes=PishaPrintTimes+1 WHERE id in ({$ids})";
        $this->_modelGang->execute($sql);
        $smarty= & $this->_getView();
        $smarty->assign('aRow',$arrNew);
        $smarty->assign('heji',$heji);
        $smarty->display('CangKu/LingliaoPrint2.tpl');
    }
    //保存坏纱领料
    function actionSaveRecords() {
		//dump($_POST);exit();
        $arrMain = array(
            chukuDate => date("Y-m-d")
            //chukuNum => ''
        );

        $mainId=$this->_modelChuku->create($arrMain);
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
                $arrSub['Wares'][$key]['pihao']=$arr['pihao'][$key];

            }
        //dump($arrSub);exit;
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
        //dump($cnt);
        //出库剩余数量
        if($cnt)foreach($cnt as $key=> & $v){
            $chuku=$this->_modelChuku2Ware->findAll(array('wareId'=>$key));
            $ruku=$this->_modelRuku2Ware->findAll(array('wareId'=>$key));
            $chukuCnt=$this->getHeji($chuku, array('cnt'));
            $rukuCnt=$this->getHeji($ruku, array('cnt'));
            //echo($rukuCnt['cnt']);exit;
            $v=$rukuCnt['cnt']-$chukuCnt['cnt']-$v;
        }
        //数量是否为负,为负写入日志
        //$msg='';
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
	#汇总打印
	function actionPrintRecords2(){
		$ware=& FLEA::getSingleton('Model_JiChu_Ware');
		$client=& FLEA::getSingleton('Model_JiChu_Client');
		$arr=$this->_modelChuku->find(array('id'=>$_GET['id']));
		//dump($arr);
		if($arr['Wares']){
			$arr['Wares']=array_group_by($arr['Wares'],'wareId');
		}

		if($arr['Wares'])foreach($arr['Wares'] as & $v){
			foreach($v as & $vv){
				$vv['Ware']=$ware->find(array('id'=>$vv['wareId']));
				$vv['Client']=$client->find(array('id'=>$vv['supplierId']));
			}
		}
		//dump($arr);exit;
		if($arr['Wares'])foreach($arr['Wares'] as & $v){
			$guige=$v['0']['Ware']['wareName']."[{$v['0']['Ware']['guige']}]";
			$proName=$v['0']['Client']['compName'];
			foreach($v as & $vv){
				$cnt+=$vv['cnt'];
			}
			$rowset[]=array(
				'chukuDate'=>$arr['chukuDate'],
				'Department'=>$arr['Department'],
				'proName'=>$proName,
				'guige'=>$guige,
				'cnt'=>$cnt,
			);
		}
		//dump($rowset);exit;
		$smarty= & $this->_getView();
        $smarty->assign('aRow',$rowset);
        $smarty->display('Cangku/LingliaoPrint2.tpl');
	}
    //根据排缸计划进行领料出库
    function actionChanliangInput1() {
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
        // $condition[]="orderId in (select id from trade_dye_order where kind = 0)";
        //0 为加工 1 为经销 
        $condition[]="x.orderKind = 0";
        $condition[]="y.PishaPrintTimes > 0";
        //if ($arr[wareId]>0) $condition[]="wareId='$arr[wareId]'";
        $pager=null;
        $rowset=$this->_modelGang->findAllGang1New($condition,$pager,0,'x.orderCode desc');
        //dump($rowset); exit;
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
 //对未领纱缸号进行打印
    function actionLingliao() {
        $this->authCheck(142);
        //$dateFrom = '2008-02-16';
        $this->_modelGang->enableLink('PishaLingliao');
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d'),
			'dateTo'=>date('Y-m-d'),
            'clientId'=>'',
            'vatNum'=>'',
            'isPrint'=>0,
        ));
        $condition=array(
            "x.parentGangId=0",
            "x.planDate>='{$arr['dateFrom']}'",
            "x.planDate>='2017-02-01'", //客户要求 2017-02-1 之前的数据不不显示
            "x.planDate<='{$arr['dateTo']}'"
        );
        $condition[]="x.gangId not in (select gangId from cangku_chuku2ware )";
        if ($arr[clientId]>0) $condition[]="x.clientId='$arr[clientId]'";
        if ($arr[orderCode]!='') $condition[]="x.orderCode like '%$arr[orderCode]%'";
        if ($arr[vatNum]!='') $condition[]="x.vatNum like '%$arr[vatNum]%'";
        if ($arr[guige]!='') $condition[]="x.guige like '%$arr[guige]%'";
        if ($arr['isPrint']!=''){
            if($arr['isPrint']=='0'){
                $condition[] = "y.PishaPrintTimes=0";
            }elseif ($arr['isPrint']=='1') {
                $condition[] = "y.PishaPrintTimes>0";
            }
        }
        //if ($arr[wareId]>0) $condition[]="wareId='$arr[wareId]'";
		//dump($condition);

        $pager=null;
        $rowset=$this->_modelGang->findAllGangNew($condition,$pager,40,'orderCode desc');
        if(count($rowset)>0) foreach($rowset as $key=>& $v) {
    		$v['vatNum']=$this->_modelGang->setVatNum($v['gangId'],$v['order2wareId']);;
            //$v[cntLingliao] = $this->_modelGang->getCntPishaLingliao($v[gangId]);
            $tTouliao += $v[cntPlanTouliao];
    		$v['orderCode']=$this->_modelOrder->getOrderTrack($v[orderId],$v[orderCode]);//得到客户单号
            $sql = "SELECT * FROM trade_dye_order2ware where id = '{$v['order2wareId']}'";
            $order2ware = $this->_modelOrder->findBySql($sql);
            $v['pihao'] = $order2ware[0]['pihao'];//得到批号
    		$clientCode=$this->_modelOrder->find(array('id'=>$v['orderId']));
    		if($clientCode['orderCode2']!='') $v['compName']=$v['compName'].'('.$clientCode['orderCode2'].')';
            if($v[cntLingliao]==$v[cntPlanTouliao]) {
                $v[_edit] = "<font color=red>已领</font>";
            } else $v['_edit']='<input type="checkbox" name="lingliao[]" id="lingliao[]" value="'.$v['gangId'].'" onclick="sss(this,'.$v['clientId'].')"/>';
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
            'wareName' => '品名',
            'pihao' => '批号',
            "guige" => "规格",
            "color" =>"颜色",
            "cntPlanTouliao" =>"计划投料",
            //"cntLingliao" => "已领数量",
            "_edit" => '<a href="javascript:void(0)" id="checkAll">[ 全选 ]</a><input type="submit" id="submit1" value="打印"/>'
        ));
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('url',$this->_url('PrintLingliao',array('clientId'=>$rowset['0']['clientId'])));
        $smarty->assign('add_display',0);
        $smarty->assign('page_info',$pager->getNavBar($this->_url('Lingliao',$arr)));
        $smarty->assign('title','打印领纱申请');
        $result=$smarty->display('TableList3.tpl');
		//by zcc 2017年11月9日 15:30:45 需求：让不同客户也进行打印 return false
		$result.="
                 <script>
                    $('#checkAll').click(function(){
                        $(\"input[name='lingliao[]']\").each(function(i){
                            $(this).click();
                        });
                    });
                   var clientId='';
                    function sss(obj,id){
                            if(clientId==''){
                                    clientId=id;
                            }
                            else{
                                    if(clientId==id){
                                    //同一个客户
                                        var i=0;
                                        $('input[@id=\"lingliao[]\"]').each(function(){
                                                if(this.checked==true){
                                                        i++;
                                                }
                                        });
                                        if(i==0){
                                                clientId='';
                                        }
                                    }
                                    else{
                                            return false;
                                            obj.checked=false;
                                            var i=0;
                                            $('input[@id=\"lingliao[]\"]').each(function(){
                                                    if(this.checked==true){
                                                            i++;
                                                    }
                                            });
                                            if(i==0){
                                                    clientId='';
                                                    obj.checked=true;
                                            }
                                            else{
                                                    alert('不是同一个客户！');
                                            }
                                            //return false;
                                    }
                            }
                    }
            </script>
                ";
        echo $result;
    }

    //根据合同进行领料出库
    function actionChanliangInput2() {
        $this->authCheck(52);
        $dateFrom = '2008-02-16';
        //$this->_modelGang->enableLink('PishaLingliao');
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            clientId=>0,
            orderCode=>''
        ));

        $condition = array();
        if ($arr[clientId]>0) $condition[clientId]=$arr[clientId];
        if ($arr[orderCode]!='') $condition[orderCode]=$arr[orderCode];
        $m = & FLEA::getSingleton("Model_Trade_Dye_Order");
        $m1 = & FLEA::getSingleton("Model_Trade_Dye_Order2Ware");
        $mWare = & FLEA::getSingleton("Model_JiChu_Ware");
        $pager = & new TMIS_Pager($m,$condition);
        $rowset= $pager->findAll();
        //dump($rowset[0]);
        if(count($rowset)>0) foreach($rowset as & $v) {
            //$v[cntLingliao] = $this->_modelGang->getCntPishaLingliao($v[gangId]);
                $v[compName] = $v[Client][compName];

                //规格
                if(count($v[Ware])>0) $arr_wareId = array_unique(array_col_values($v[Ware],'wareId'));
                foreach($arr_wareId as &$w) {
                    $aWare=$mWare->find(array(id=>$w));
                    $v[guige] .=$aWare[wareName]." ".$aWare[guige].",";
                }

                //得到总投料数和总领料数
                if(count($v[Ware])>0) foreach($v[Ware] as &$w) {
                        $v[cntPlanTouliao] += $m1->getCntPlanTouliao($w[id]);
                        $v[cntLingliao] += $m1->getCntPishaLingliao($w[id]);
                    }
                if($v[cntLingliao]==$v[cntPlanTouliao]) {
                    $v[_edit] = "<font color=red>已领</font>";
                } else $v[_edit] = "<a href='".$this->_url('makeRecord',array(
                        orderId=>$v[id]
                        ))."'>领用</a>";
            }
        $smarty = $this->_getView();
        $smarty->assign("supplier_name", '客户');
        $smarty->assign('arr_field_info',array(
            //"planDate" => "排缸日期",
            "compName" => "客户",
            "orderCode" => "订单号",
            //"vatNum" =>"缸号",
            "guige" => "纱织规格",
            //"color" =>"颜色",
            "cntPlanTouliao" =>"总投料",
            "cntLingliao" => "已领",
            "_edit" => '操作'
        ));
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('add_display',0);
        $smarty->assign('page_info',$pager->getNavBar($this->_url('ChanliangInput2',$arr)));
        $smarty->display('TableList.tpl');
    }

    //点击缸号列表中的出库链接后制作一条入库记录进行插入。
    //如果是整单录入则依次增加
    function actionMakeRecord() {
        $arrMain = array(
            chukuDate => date("Y-m-d")
            //chukuNum => ''
        );
        $mainId=$this->_modelChuku->create($arrMain);

        if ($_GET[gangId]) {
            $client = $this->_modelGang->getClient($_GET[gangId]);
            $m0 = &FLEA::getSingleton('Model_Trade_Dye_Order');

            $ware = $this->_modelGang->getWare($_GET[gangId]);
            $gang = $this->_modelGang->find("id='$_GET[gangId]'");
            $orderId = $gang[OrdWare][orderId];
            $aOrder=$m0->find(array(id=>$orderId));
            $orderCode=$aOrder[orderCode];

            $arrSub = array(
                chukuId => $mainId,
                gangId => $_GET[gangId],
                supplierId =>$client[id],
                wareId =>$ware[id],
                cnt =>$gang[cntPlanTouliao]
            );
            //dump($arrSub);exit;
            $subId = $this->_modelChuku2Ware->create($arrSub);
        }
        if ($_GET[orderId]) {
            $m = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
            $mGang = $this->_modelGang;
            $wares = $m->findAll(array(orderId=>$_GET[orderId]));
            foreach($wares as $v) {
                $order2wareId = $v[id];
                foreach($v[Pdg] as $aGang) {
                    $arrSub = array(
                        chukuId => $mainId,
                        gangId => $aGang[id],
                        supplierId =>$v[Order][clientId],
                        wareId =>$v[wareId],
                        cnt =>$aGang[cntPlanTouliao]
                    );
                    //dump($arrSub);exit;
                    $subId = $this->_modelChuku2Ware->create($arrSub);
                }
            }
        }
        //$m0 = & FLEA::getSingleton('Model_Trade_Dye_Order2ware');
        //$m0->find(array(array('Pdg.')));
        js_alert('','',url('CangKu_ChuKu','ChanliangInput1',array(
            orderCode=>$orderCode)));
    }

    function _edit($Arr, $ArrProductList=null) {
        $this->funcId = 102;		//坯纱领料登记-修改
        $this->authCheck($this->funcId);
        $smarty = & $this->_getView();
        //$smarty->assign('title', $this->title);
        //$smarty->assign('user_id', $_SESSION['USERID']);
        //$smarty->assign('real_name', $_SESSION['REALNAME']);
        $smarty->assign("arr_field_value",$Arr);

        #对默认日期变量赋值
        $smarty->assign('default_date',date("Y-m-d"));

        #增加产品控制器
        $smarty->assign('queen_controller', $this->queenController);

        #通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
        #在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
        $pk=$this->_modelChuku->primaryKey;
        $primary_key=(isset($_GET[$pk])?$pk:"");
        $smarty->assign("pk",$primary_key);
        $smarty->display('CangKu/ChuKuEdit.tpl');
    }

    #增加界面
    function actionAdd() {
        $this->_edit(array());
    }
    #保存
    function actionSave() {
        $chukuId = $this->_modelChuku->save($_POST);
        if (!empty($_POST[id])) $chukuId = $_POST[id];
        if ($chukuId) redirect($this->_url('EditWare',array('chukuId'=>$chukuId)));
        else die('保存失败!');
    }
    #保存货品档案
    function actionSaveWares() {
        $modelChuku2Wares = FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        if (empty($_POST[danjia]))	$_POST[danjia] = $modelChuku2Wares->getDanjia($_POST[wareId]);
        //dump($_POST);exit;
        if ($modelChuku2Wares->save($_POST)) redirect($this->_url('EditWare',array('chukuId'=>$_POST[chukuId])));
        else die('保存失败!');
    }
    #保存货品档案
    function actionSaveWare() {
    //dump($_POST); exit;
        if ($this->_modelChuku2Ware->save($_POST)) redirect($this->_url('right'));
        else die('保存失败!');
    }

    #修改界面
    function actionEdit() {
        $pk=$this->_modelChuku->primaryKey;
        $this->_editable($_GET[$pk]);
        $arr_field_value=$this->_modelChuku->find($_GET[$pk]);
        $this->_edit($arr_field_value);

    }
    #修改领出数量
    function actionEditNum() {
    //echo('-------------------'.$_GET[chuku2wareId]);
        $this->authCheck(102);
        $rowC2W=$this->_modelChuku2Ware->findByField('id', $_GET[chuku2wareId]);
        //$this->_editable($_GET[$pk]);
        //$arrFieldValue=$this->_modelChuku->find($_GET[$pk]);
        //dump($rowC2W);
		$str="select x.* from cangku_ruku2ware x
			left join cangku_ruku y on y.id=x.ruKuId
			where y.supplierId='{$rowC2W['supplierId']}'
			group by x.chandi
		";
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
    #修改货品界面
    function actionEditWare() {
        $modelChuku2Wares = FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $wares = $modelChuku2Wares->findAll("chukuId='$_GET[chukuId]'");
        $smarty = & $this->_getView();
        $smarty->assign('rows',$wares);
        $smarty->display('CangKu/ChuKu2WareEdit.tpl');
    }
    #删除
    function actionRemove() {
        $this->authCheck(102);
        $pk = $_GET['id'];
        $this->_editable($pk);
        $this->_modelChuku->removeByPkv($pk);
        redirect($this->_url('right'));
    }
    function actionRemoveWare() {
        $this->authCheck(102);
        $modelChuku2Wares = FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $modelChuku2Wares->removeByPkv($_GET['id']);
        redirect($this->_url('right'));
    }
    function actionGetWaresJson() {
        $chuku = $this->_modelChuku->find("chukuNum='$_GET[chukuNum]'");
        $chukuId = $chuku[id];
        $modelChuku2Wares = FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $wares = $modelChuku2Wares->findAll("chukuId='$chukuId'");
        for ($i=0;$i<count($wares);$i++) {
            $wares[$i][chukuNum] = $_GET[chukuNum];
        }
        echo json_encode($wares);exit;
    //dump($wares);exit;
    }
    //判断id=$pkv的出库单是否允许被修改或删除,有以下情况返回false
    //财务已经审核其中一笔货物。
    function _editable($pkv) {
        $arr_field_value=$this->_modelChuku->find($pkv);
        $wares = $arr_field_value[Wares];
        //判断相关凭证是否被审核
        $invoice = FLEA::getSingleton('Model_CaiWu_Yf_Invoice');
        if (count($wares)>0) {
            foreach($wares as & $value) {
                if ($invoice->isChecked($value[invoiceId])) {
                    js_alert('该出库单相关联的凭证已经审核，不允许修改!','',$_SERVER['HTTP_REFERER']);
                }
            }
        }
    }

    //显示invoiceId=$_GET[id]的所有的出库明细
    function actionShowWares2Invoice() {
        $_m = FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
        $wares = $_m->findAll("invoiceId='$_GET[id]'");
        if (count($wares)>0) {
            $_modelSupplier = FLEA::getSingleton('Model_JiChu_Supplier');
            foreach($wares as &$value) {
                $temp = $_modelSupplier->find($value[Chuku][supplierId]);
                $value[depName] = $temp[compName];
                $value[chukuNum] = $value[Chuku][chukuNum];
                $value[wareId] = $value[wareId];
                $value[wareName] = $value[Wares][wareName];
                $value[guige] = $value[Wares][guige];
                $value[unit]= $value[Wares][unit];
                $value[danjia] = $value[danJia];
                $value[cnt] = $value[cnt];
                $value[money] = number_format($value[danjia]*$value[cnt],2,".","");
            }
        }
        $smarty = & $this->_getView();
        $smarty->assign('title', $this->title);
        $pk = $this->_modelChuku->primaryKey;
        $smarty->assign('pk', $pk);
        $arr_field_info = array(
            "chukuNum" =>"出库单号",
            "depName" =>"部门",
            "wareId" =>"货品编号",
            "wareName" =>"品名",
            "guige" =>"规格",
            "unit" =>"单位",
            "cnt" => "数量",
            "danjia" => "单价",
            "money" => "金额",
        );
        $smarty->assign('title','出库明细');
        //$smarty->assign('arr_edit_info',$arr_edit_info);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$wares);
        //$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arr)));
        //$smarty->assign('controller', 'CaiWu_Yf_Report');
        $smarty->display('TableList.tpl');
    }


    //返回坯纱入库单中指定客户和纱支的数量总数
    function countCnt($tableName, $supplierId, $wareId) {
        $sqlRuku = "select sum(cnt) as countTotal from ".$tableName." where supplierId = ".$supplierId." and wareId = ".$wareId;

        //echo($sqlRuku);
        $rowRuku = $this->_modelChuku->findBySql($sqlRuku);
        $countCnt = 0;
        foreach ($rowRuku as $value) {
            $countCnt =  $countCnt+$value["countTotal"];
        }
        //echo("----------".$countCnt);
        //die();
        return $countCnt;
    }

    //显示计划修改日志
    function actionListChangeLog() {
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            dateFrom=>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
            dateTo=>date("Y-m-d")
        ));

        $condition=array('classId'=>6);
        if ($arr[dateFrom]) {
            $condition[] = array('buildDate',$arr['dateFrom'],'>=');
            $condition[] = array('buildDate',$arr['dateTo'],'<=');
        }
        //dump($condition);
        $mMsg = & FLEA::getSingleton('Model_OA_Message');
        $pager= & new TMIS_Pager($mMsg,$condition,null,null,100);
        $rowset= $pager->findAll();
        if (count($rowset)>0) foreach($rowset as & $value) {
            }
        $smarty = & $this->_getView();
        $smarty->assign('title', '计划修改日志');
        $arrFieldInfo = array(
            //"chukuNum" =>"单号",
            "buildDate" =>"计划修改日期",
            //"depName" =>"领料部门",
            "content" =>"计划修改内容"
        );
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('page_info',$pager->getNavBar($this->_url('ListChangeLog',$arr)));

        #开始显示
        $smarty->display('TableList.tpl');
    }
	#通过产地和客户取得库存
	function actionGetKucunByJsonOld(){
		#入库数
		$str="select sum(x.cnt) as cnt
			from cangku_ruku2ware x
			left join cangku_ruku y on y.id=x.ruKuId
			where y.supplierId='{$_GET['supplierId']}'
			and x.wareId='{$_GET['wareId']}'
			and x.chandi='{$_GET['chandi']}'
		";
		//echo $str.'<br>';
		$ruku=mysql_fetch_assoc(mysql_query($str));
		#出库数
		$str="select sum(cnt) as cnt
			from cangku_chuku2ware
			where supplierId='{$_GET['supplierId']}'
			and wareId='{$_GET['wareId']}'
			and chandi='{$_GET['chandi']}'
		";
		//echo $str.'<br>';
		$chuku=mysql_fetch_assoc(mysql_query($str));
		$arr['cntKucun']=$ruku['cnt']-$chuku['cnt'];
		echo json_encode($arr);
		exit;
	}
    #通过产地和客户和批号取得库存
    function actionGetKucunByJson(){
        #入库数
        $str="select sum(x.cnt) as cnt
            from cangku_ruku2ware x
            left join cangku_ruku y on y.id=x.ruKuId
            where y.supplierId='{$_GET['supplierId']}' 
            and y.kind ='0'
            and x.wareId='{$_GET['wareId']}'
            and x.chandi='{$_GET['chandi']}'
            and x.pihao='{$_GET['pihao']}'
        ";
        // echo $str.'<br>';
        $ruku=mysql_fetch_assoc(mysql_query($str));
        #出库数
        $str="select sum(cnt) as cnt
            from cangku_chuku2ware
            where supplierId='{$_GET['supplierId']}' and kind = '0'
            and wareId='{$_GET['wareId']}'
            and chandi='{$_GET['chandi']}'
            and pihao='{$_GET['pihao']}'
        ";
        // echo $str.'<br>';
        $chuku=mysql_fetch_assoc(mysql_query($str));
        $arr['cntKucun']=$ruku['cnt']-$chuku['cnt'];
        echo json_encode($arr);
        exit;
    }
    //得到不足库存数量，返回json数据
//    function actionGetcnt(){
//        //dump($_GET);
//        $chuku=$this->_modelChuku2Ware->findAll(array('wareId'=>$_GET['wareId']));
//        $ruku=$this->_modelRuku2Ware->findAll(array('wareId'=>$_GET['wareId']));
//        $chukuCnt=$this->getHeji($chuku, array('cnt'));
//        $rukuCnt=$this->getHeji($ruku, array('cnt'));
//        //echo($rukuCnt['cnt']);exit;
//        $cnt=$rukuCnt['cnt']-$chukuCnt['cnt']-$_GET['cnt'];
//        //数量是否为负,为负写入日志
//        //echo($cnt);
//        $mlog= & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
//        $mware=& FLEA::getSingleton('Model_Jichu_Ware');
//
//        $ware=$mware->find(array('id'=>$_GET['wareId']));
//        if($cnt<0){
//            $log=array('wareId'=>$_GET['wareId'],'cnt'=>abs($cnt),'user'=>$_SESSION['USERNAME']);
//            $mlog->save($log);
//        }
//        $json=array(
//            'wareName'=>$ware['wareName'],
//            'cnt'=>$cnt
//        );
//        echo(json_encode($json));exit;
//    }

}
?>