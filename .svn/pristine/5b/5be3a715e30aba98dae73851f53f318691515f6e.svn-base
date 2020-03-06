<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Ware extends Tmis_Controller {
    var $_modelExample;
    var $thisController = "JiChu_Ware";
    var $title = "纱支资料档案";
    var $funcId = 24;
    var $mLog;
    var $tableName=array(
        'cangku_chuku2ware',
		'cangku_chuku_log',
        'cangku_dye_pandian',
        'cangku_init',
        'cangku_ruku2ware',
        'cangku_wujin_chuku',
        'cangku_wujin_ruku',
        'cangku_yl_chuku2ware',
        'cangku_yl_ruku2ware',
        'gongyi_dye_chufang2ware',
        'jichu_gongyi2ware',
        'trade_dye_order2ware',
        //'chanpin_dye_cpck_log'
    );
    function Controller_JiChu_Ware() {
    //if(!$this->authCheck()) die("禁止访问!");
        $this->_modelExample = & FLEA::getSingleton('Model_JiChu_Ware');
        $this->mlog=& FLEA::getSingleton('Model_JiChu_ControlLog');
        $this->_modelDanjia = & FLEA::getSingleton('Model_JiChu_WareDanjia');
    }

    #tmisMenu用的object
    /**
     *取得tmisMenu用的对象
     */
    function actionTmisMenu() {
        $subClasses = $this->_modelExample->getSubNodes1($_GET[parentId]);
        //dump($subClasses);exit;
        $r = array('items'=>array());
       // $ret="{items : [";
        for ($i=0;$i<count($subClasses);$i++) {
            $isD = ($subClasses[$i][rightId]-$subClasses[$i][leftId])>1?1:0;
            $value=$subClasses[$i][id];
            $text = $subClasses[$i][wareName];
            $text .= (!$isD&&$subClasses[$i][guige]!="")?("||".$subClasses[$i][guige]):"";
            $json = json_encode($subClasses[$i]);
            $r['items'][] = array('value'=>$value,'isDirectory'=>$isD,'text'=>$text,'json'=>$json);
            //$ret .= "{value:$value,isDirectory:$isD,text:'$text',json:$json},";
        };
        //$ret = substr($ret,0,-1);
        //$ret .= "]}";
        //echo $ret;exit;
		echo json_encode($r);exit;
    }

    function actionRight() {
        $this->authCheck($this->funcId);
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            'key'=>''
        ));

        /**
         * 读取指定父分类下的直接子分类
         */
        $parentId = isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0;
        if ($parentId) {
            $parent = $this->_modelExample->getClass($parentId);
            if (!$parent) {
                echo "无效分类 in actionRight!";exit;
            }
            $subClasses = $this->_modelExample->getSubNodes1($parent);
        } else {
            $subClasses = $this->_modelExample->getAllTopNodes1();
        }

        /*
		foreach ($subClasses as $offset => $class) {
            $subClasses[$offset]['child_count'] = $this->_modelExample->calcAllChildCount($class);
        }
		*/

        $arrFieldInfo = array(
            "id"=>"系统编号",
            "orderLine"=>"排列顺序<br>(点击修改)",
            "wareName"=>"品名",
            "guige"=>"规格",
            "unit"=>"单位",
            "mnemocode"=>"助记码",
            "showSub" => "查看子项",
            "_edit"=>'操作'
        );

        if (count($subClasses)>0) {
            foreach($subClasses as &$row) {
                $this->makeEditable($row,'orderLine');
                $row[showSub] = "<a href='".$this->_url('right',array(
                    'parentId'=>$row['id'],
					'default'=>$_GET['default'],
                    ))."'>".($row['leftId']+1==$row['rightId'] ? '<font color="green">无子项</font> >>进入':'有子项 >>进入')."</a>";
                $row['_edit'] = "<a href='".$this->_url('Edit',array(
                    'id'=>$row['id'],'parentId'=>$_GET['parentId'],'default'=>$_GET['default']
                    ))."'>修改</a>". " | " . $this->getRemoveHtml($row['id']);
                $row['_edit'] .= " | <a href='".$this->_url('moveNode',array(
                    'sourceId'=>$row['id'],'default'=>$_GET['default']
                    ))."' title='节点移动' target='_blank'>移动</a>";
                $v=$this->_modelExample->findAll(array(array('leftId',$row['leftId'],'>'),array('rightId',$row['rightId'],'<')));
                if(count($v)>o) {
                    $row['_edit'].=' | <span disabled >合并</span>';
                }
                else {
                    $row['_edit'].=' | <a href='.$this->_url('MergeNode',array('wareId'=>$row['id'],'name'=>$row['wareName'],'default'=>$_GET['default'])).'>合并</a>';
                }

                 //根节点可以设置单价
                if($row['leftId']+1==$row['rightId']){
                    $row['_edit'] .= " | <a href='".$this->_url('setDanjia',array(
                        'wareId'=>$row['id'],
                        'TB_iframe'=>1,
                        'width'=>'950'
                    ))."'  class='thickbox'  title='设置各产量单价' >设置各产量单价</a> ";
                }

            }
        }
        $smarty = & $this->_getView();
        $smarty->assign("arr_field_info",$arrFieldInfo);
        $smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign("title","货品资料");
        $smarty->assign("arr_field_value",$subClasses);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','grid','thickbox')));
        $smarty->assign("page_info",$this->showPathInfo());
        $smarty->display("TableList2.tpl");
    }
	function actionRight1(){
		FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            key=>''
        ));

        /**
         * 读取指定父分类下的直接子分类
         */
        $parentId = isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0;
        if ($parentId) {
            $parent = $this->_modelExample->getClass($parentId);
            if (!$parent) {
                echo "无效分类 in actionRight!";exit;
            }
			$str="select * from jichu_ware where parentId='{$parentId}'";
			if($arr['key']!='')$str.=" and(wareName like '%{$arr['key']}%' or guige like '%{$arr['key']}%')";
			$str.=" order by orderLine asc";
            $subClasses = $this->_modelExample->findBySql($str);
        } else {
			$str="select * from jichu_ware where parentId=0";
			if($arr['key']!='')$str.=" and(wareName like '%{$arr['key']}%' or guige like '%{$arr['key']}%')";
			$str.=" order by leftId asc";
            $subClasses = $this->_modelExample->findBySql($str);
        }
		$arr['parentId']=$parentId;
        /*
		foreach ($subClasses as $offset => $class) {
            $subClasses[$offset]['child_count'] = $this->_modelExample->calcAllChildCount($class);
        }
		*/

        $arrFieldInfo = array(
            "id"=>"系统编号",
            "orderLine"=>"排列顺序<br>(点击修改)",
            "wareName"=>"品名",
            "guige"=>"规格",
            "unit"=>"单位",
            "mnemocode"=>"助记码",
            "showSub" => "查看子项",
            "_edit"=>'操作'
        );

        if (count($subClasses)>0) {
            foreach($subClasses as &$row) {
                $this->makeEditable($row,'orderLine');
                $row[showSub] = "<a href='".$this->_url('right1',array(
                    'parentId'=>$row['id'],
					'default'=>$_GET['default'],
                    ))."'>".($row['leftId']+1==$row['rightId'] ? '<font color="green">无子项</font> >>进入':'有子项 >>进入')."</a>";
                $row['_edit'] = "<a href='".$this->_url('RemoveWare',array(
                    'id'=>$row['id'],'parentId'=>$_GET['parentId'],'default'=>$_GET['default']
                    ))."'>删除</a>";

            }
        }
        $smarty = & $this->_getView();
        $smarty->assign("arr_field_info",$arrFieldInfo);
        $smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign("title","货品资料");
        $smarty->assign("arr_field_value",$subClasses);
        $smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
        $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','grid')));
        $smarty->assign("page_info",$this->showPathInfo());
        $smarty->display("TableList2.tpl");
	}
	function actionRemoveWare(){
		#判断是否有入库记录，有则不能删除
		$str="select count(*) as cnt from cangku_yl_ruku2ware where wareId='{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re['cnt']>0){
			js_alert('该物料已有入库记录，不能删除！','',$this->_url('right1',array('parentId'=>$_GET['parentId'],'default'=>$_GET['default'])));
			exit;
		}
		#判断是否有出库记录，有则不能删除
		$str="select count(*) as cnt from cangku_yl_chuku2ware where wareId='{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re['cnt']>0){
			js_alert('该物料已有出库记录，不能删除！','',$this->_url('right1',array('parentId'=>$_GET['parentId'],'default'=>$_GET['default'])));
			exit;
		}
		$rr=$this->_modelExample->find(array('id'=>$_GET['id']));
		if($rr['leftId']+1!=$rr['rightId']){
			$str="select * from jichu_ware where leftId>'{$rr['leftId']}' and rightId<'{$rr['rightId']}'";
			$arr=$this->_modelExample->findBySql($str);
			foreach($arr as & $v){
				$this->_modelExample->removeByPkv($v['id']);
			}
		}
		$this->_modelExample->removeByPkv($_GET['id']);
		redirect($this->_url('right1',array('parentId'=>$_GET['parentId'],'default'=>$_GET['default'])));
	}
    function _edit($class) {
        $this->authCheck($this->funcId);
        $smarty = $this->_getView();
        $smarty->assign('path_info',$this->showPathInfo($class));
        $smarty->assign('aRow',$class);
        $smarty->display('JiChu/WareEdit.tpl');
    }
    #增加界面
    function actionAdd() {
        $func = array(
            'parentId' => isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0,
        );
        $this->_edit($func);
    }
    #保存
    function actionSave() {
       	/*$class = array(
            'wareName' => $_POST['wareName'],
        );
		*/
        $class = & $_POST;

        if ($_POST['id']) {
        // 更新分类
            $class['id'] = $_POST['id'];
            $this->_modelExample->updateClass($class);
            //写入日志
            $log=array(
                'item'=>$this->title.' id='.$_POST['id'],
                'action'=>'修改',
                'user'=>$_SESSION['USERNAME']
            );
            $this->mlog->save($log);
        } else {
        // 创建分类
        //dump($class);exit;
            $_POST['wareName']=trim($_POST['wareName']);
            $_POST['guige']=trim($_POST['guige']);
            //判断是否有相同纱支
            $flag=$this->_modelExample->find(array('wareName'=>$_POST['wareName'],'guige'=>$_POST['guige']));
            //dump($flag);exit;
            if($flag) {js_alert('纱支已存在','',$this->_url('add'));exit;}

            $id=$this->_modelExample->createClass($class, $_POST['parentId']);
            $log=array(
                'item'=>$this->title.' id='.$id,
                'action'=>'添加',
                'user'=>$_SESSION['USERNAME']
            );
            $this->mlog->save($log);
        //dump($this->_modelExample->dbo);exit;
        }

        $ex = __CATCH();
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), '', $this->_url('right'));
        }
        redirect($this->_url('right',array(
            "parentId"=>$_POST['parentId'],
			"default"=>$_POST['default']
        )));
    }
    #修改界面
    function actionEdit() {
        $class = $this->_modelExample->getClass((int)$_GET['id']);
        if (!$class) {
            echo "无效分类 in actionEdit!";exit;
        }
        $this->_edit($class);
    }

    function actionRemove() {
		#判断是否有入库记录，有则不能删除
		$str="select count(*) as cnt from cangku_yl_ruku2ware where wareId='{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re['cnt']>0){
			js_alert('该物料已有入库记录，不能删除！','window.history.go(-1)');
			exit;
		}
		#判断是否有出库记录，有则不能删除
		$str="select count(*) as cnt from cangku_yl_chuku2ware where wareId='{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re['cnt']>0){
			js_alert('该物料已有出库记录，不能删除！','window.history.go(-1)');
			exit;
		}
         //分配方案中是否有此纱支
        $m= FLEA::getSingleton('Model_JiChu_Gongyi2ware');
        $kk=$m->findAll(array('wareId'=>$_GET['id']));
		//dump($kk);exit;
        if(count($kk)>0){
            js_alert('方案中以有此纱支不能删除!', '',$_SERVER[HTTP_REFERER]);exit;
        }
        $class=$this->_modelExample->getClass($_GET['id']);
		//dump($class);exit;
        $count=$this->_modelExample->calcAllChildCount($class);
        //echo($count);exit;
        if($count==0) {
        //删除写入状态
            $arr=array('id'=>$_GET['id'],'isDel'=>'1');
            //dump($arr);exit;
            $this->_modelExample->save($arr);
            //写入日志
            $log=array(
                'item'=>$this->title.' id='.$_GET['id'],
                'action'=>'删除',
                'user'=>$_SESSION['USERNAME']
            );
            $this->mlog->save($log);
            redirect($this->_url('right',array("parentId" => $class[parentId])));
        }
        else {
            js_alert('不能删除!', '',$_SERVER[HTTP_REFERER]);
        }
    }
    

     function actionSaveDs(){
        $sqlClear = "truncate table jichu_ware_danjia";
        $this->_modelExample->execute($sqlClear);
        //die;
        $sql ="select id from jichu_ware where leftId+1=rightId";
        $rowset = $this->_modelExample->findBySql($sql);
               $arr6 =array();
        foreach ($rowset as $key => &$vala) {
           $arr6[$vala['id']]['wareId'] = $vala['id'];
           $arr6[$vala['id']]['gongxuId'] = '27';
           $arr6[$vala['id']]['danjia'] = '0.1';
           $arr6[$vala['id']]['id'] = '';
        }

         $this->_modelDanjia->saveRowset($arr6);
         $arr7 =array();
        foreach ($rowset as $key => &$vl) {
           $arr7[$vl['id']]['wareId'] = $vl['id'];
           $arr7[$vl['id']]['gongxuId'] = '28';
           $arr7[$vl['id']]['danjia'] = '0.11';
           $arr7[$vl['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr7);
            $arr8 =array();
        foreach ($rowset as $key => &$vla) {
           $arr8[$vla['id']]['wareId'] = $vla['id'];
           $arr8[$vla['id']]['gongxuId'] = '30';
           $arr8[$vla['id']]['danjia'] = '0.03';
           $arr8[$vla['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr8);
            $arr9 =array();
        foreach ($rowset as $key => &$vls) {
           $arr9[$vls['id']]['wareId'] = $vls['id'];
           $arr9[$vls['id']]['gongxuId'] = '31';
           $arr9[$vls['id']]['danjia'] = '0.03';
           $arr9[$vls['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr9);
          $arr10 =array();
        foreach ($rowset as $key => &$vlls) {
           $arr10[$vlls['id']]['wareId'] = $vlls['id'];
           $arr10[$vlls['id']]['gongxuId'] = '32';
           $arr10[$vlls['id']]['danjia'] = '0.02';
           $arr10[$vlls['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr10);
          $arr11 =array();
        foreach ($rowset as $key => &$vlk) {
           $arr11[$vlk['id']]['wareId'] = $vlk['id'];
           $arr11[$vlk['id']]['gongxuId'] = '33';
           $arr11[$vlk['id']]['danjia'] = '0.03';
           $arr11[$vlk['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr11);
              $arr12 =array();
        foreach ($rowset as $key => &$vlka) {
           $arr12[$vlka['id']]['wareId'] = $vlka['id'];
           $arr12[$vlka['id']]['gongxuId'] = '34';
           $arr12[$vlka['id']]['danjia'] = '0.03';
           $arr12[$vlka['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr12);
             $arr13 =array();
        foreach ($rowset as $key => &$vlkk) {
           $arr13[$vlkk['id']]['wareId'] = $vlkk['id'];
           $arr13[$vlkk['id']]['gongxuId'] = '35';
           $arr13[$vlkk['id']]['danjia'] = '0.03';
           $arr13[$vlkk['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr13);
                $arr14 =array();
        foreach ($rowset as $key => &$vlkkq ){
           $arr14[$vlkkq['id']]['wareId'] = $vlkkq['id'];
           $arr14[$vlkkq['id']]['gongxuId'] = '36';
           $arr14[$vlkkq['id']]['danjia'] = '0.02';
           $arr14[$vlkkq['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr14);
                      $arr15 =array();
        foreach ($rowset as $key => &$vlkpp) {
           $arr15[$vlkpp['id']]['wareId'] = $vlkpp['id'];
           $arr15[$vlkpp['id']]['gongxuId'] = '37';
           $arr15[$vlkpp['id']]['danjia'] = '0.02';
           $arr15[$vlkpp['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr15);
                            $arr16 =array();
        foreach ($rowset as $key => &$vlkpp1) {
           $arr16[$vlkpp1['id']]['wareId'] = $vlkpp1['id'];
           $arr16[$vlkpp1['id']]['gongxuId'] = '38';
           $arr16[$vlkpp1['id']]['danjia'] = '0.03';
           $arr16[$vlkpp1['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr16);
        //dump($rowset);die;
      
         echo "ok";die;
    }

    function actionAsave(){
        $sql ="select id from jichu_ware where leftId+1=rightId";
        $rowset = $this->_modelExample->findBySql($sql);
        $arr = array();
        foreach ($rowset as $key => &$value) {
           $arr[$value['id']]['wareId'] = $value['id'];
           $arr[$value['id']]['gongxuId'] = '16';
           $arr[$value['id']]['danjia'] = '0.01';
           $arr[$value['id']]['id'] = '';
        }
        $this->_modelDanjia->saveRowset($arr);
        $arr1 =array();
        foreach ($rowset as $key => &$valu) {
           $arr1[$valu['id']]['wareId'] = $valu['id'];
           $arr1[$valu['id']]['gongxuId'] = '18';
           $arr1[$valu['id']]['danjia'] = '0.043';
           $arr1[$valu['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr1);
        $arr2 =array();
        foreach ($rowset as $key => &$val) {
           $arr2[$val['id']]['wareId'] = $val['id'];
           $arr2[$val['id']]['gongxuId'] = '19';
           $arr2[$val['id']]['danjia'] = '0.025';
           $arr2[$val['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr2);
          $arr3 =array();
        foreach ($rowset as $key => &$vall) {
           $arr3[$vall['id']]['wareId'] = $vall['id'];
           $arr3[$vall['id']]['gongxuId'] = '20';
           $arr3[$vall['id']]['danjia'] = '0.013';
           $arr3[$vall['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr3);
           $arr4 =array();
        foreach ($rowset as $key => &$valla) {
           $arr4[$valla['id']]['wareId'] = $valla['id'];
           $arr4[$valla['id']]['gongxuId'] = '21';
           $arr4[$valla['id']]['danjia'] = '0.02';
           $arr4[$valla['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr4);
            $arr5 =array();
        foreach ($rowset as $key => &$vallaa) {
           $arr5[$vallaa['id']]['wareId'] = $vallaa['id'];
           $arr5[$vallaa['id']]['gongxuId'] = '17';
           $arr5[$vallaa['id']]['danjia'] = '0.03';
           $arr5[$vallaa['id']]['id'] = '';
        }
         $this->_modelDanjia->saveRowset($arr5);
         echo "oks";die;
    }

    function showPathInfo($class = null) {
        $parentId = empty($class) ? (isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0)
            : $class[parentId] ;
        if ($parentId) {
            $parent = $this->_modelExample->getClass($parentId);
            if (!$parent) {
                echo "无效分类 in actionIndex!";exit;
            }

            /**
             * 确定当前分类到顶级分类的完整路径
             */
            $path = $this->_modelExample->getPath($parent);
            $path[] = $parent;
        } else {
            $parent = null;
            $path = array();
        }

        $ret = "当前位置：<a href='" . $this->_url($_GET['action']) ."'>根目录</a>";
        foreach ($path as $part) {
            $ret .= "-><a href='" . $this->_url($_GET['action'],array("parentId"=>$part[id])). "'>$part[wareName]</a>";
        }
        return $ret;
    }

    function actionGetSuggestJson() {
        $re = array();
        $arr = $this->_modelExample->findAll(array(
            array('mnemocode',"$_GET[mnemocode]%",'like')
        ));
        foreach($arr as $key=>$v) {
            $re[$key][name]=$v[mnemocode].":".$v[wareName]." ".$v[guige]." /".$v[id];
            $re[$key][values]=$v[mnemocode];
        }
        echo json_encode($re);exit;
    }

    //移动节点界面
    function actionMoveNode() {
        $arr = $this->_modelExample->find(array('id'=>$_GET['sourceId']));
        $smarty = $this->_getView();

        $path = $this->_modelExample->getPath($arr);
        //dump($arr);exit;
        $smarty->assign('path_info',join('<font color=red>/</font>',array_col_values($path,'wareName')));

        $smarty->assign('aRow',$arr);
        $smarty->display('JiChu/WareMove.tpl');
    }
    function actionMoveNodeSave() {
        $sourceNode = $this->_modelExample->find(array('id'=>$_POST['sourceId']));//需要被移动的节点
        $targetNode = $this->_modelExample->find(array('id'=>$_POST['targetId']));//要移动到的节点下
        // dump($sourceNode);dump($targetNode);exit;
		$rr=$this->_modelExample->findAll(array('parentId'=>$_POST['targetId']));
		$i=0;
		if(count($rr)>0)foreach($rr as & $v){
			if($v['guige']==$sourceNode['guige']){
				$i++;
			}
		}
		if($i>0)js_alert('当前的规格和目标位置中的规格有相同，请确认后移动！','window.history.go(-1)');
        //dump($sourceNode);dump($targetNode);exit;
        if ($this->_modelExample->moveNodeAndChild($sourceNode,$targetNode)) {
            $log=array(
                'item'=>$this->title.' id '.$_POST['sourceId'].'->'.$_POST['targetId'],
                'action'=>'移动',
                'user'=>$_SESSION['USERNAME']
            );
            $this->mlog->save($log);
            redirect($this->_url('MoveNode',array('sourceId'=>$_POST['sourceId'])));
        }
        else {
            echo "出错!";}
    }


    //在模式对话框中显示待选择的纱支，返回某个纱支的json对象。
    function actionPopup() {
        $str = "select * from jichu_ware where 1";
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            //'traderId' => '',
            'key' => ''
        ));
        if ($arr[key]!='') $str .= " and mnemocode like '%$arr[key]%' or wareName like '%$arr[key]%'";
        $str .=" order by id desc";
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAllBySql($str);
        //$pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
        $arr_field_info = array(
            //"_edit" => "选择",
            "id"=>'系统序号',
            "wareName" =>"名称",
            'guige'=>"规格",
            "mnemocode" =>"助记码"
        );

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择纱支');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('pk', $pk);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss());
        $smarty->assign('s',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/CommonPopup.tpl');
    }

	//利用ymPromtp弹出选择器,全部坯纱
    function actionPopupPisha() {
		$str = "select * from jichu_ware where id=2";
		$p= mysql_fetch_assoc(mysql_query($str));

        $str = "select * from jichu_ware
			where leftId+1=rightId
			and leftId>={$p['leftId']} and rightId<={$p['rightId']}";
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            //'traderId' => '',
            'key' => ''
        ));
        if ($arr[key]!='') $str .= " and (
			mnemocode like '%$arr[key]%' or wareName like '%$arr[key]%' or guige like '%$arr[key]%'
		)";
        $str .=" order by id desc";
		//echo $str;
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAllBySql($str);
		foreach($rowset as & $v) {
			$v['_edit'] = '<a href="javascript:void(0)" name="btnOfften" id="btnOfften" onclick="setOfften(this,'.$v['id'].')">设为常用</a>';
			if($v['isOfften']==1) $v['_bgColor']='lightgreen';
			$this->makeEditable($v,'mnemocode');
		}
        $arr_field_info = array(
            //"_edit" => "选择",
            "id"=>'系统序号',
            "wareName" =>"名称",
            'guige'=>"规格",
            "mnemocode" =>"简写助记码",
			'_edit'=>'操作'
        );

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择纱支');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        $smarty->assign('s',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/Pisha.tpl');
    }

	//利用ymPromtp弹出选择器,常用坯纱
	function actionPopupPishaOfften() {
		$str = "select * from jichu_ware where id=2";
		$p= mysql_fetch_assoc(mysql_query($str));

        $str = "select * from jichu_ware
			where  isOfften=1 and leftId+1=rightId
			and leftId>={$p['leftId']} and rightId<={$p['rightId']}";
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            //'traderId' => '',
            'key' => ''
        ));
        if ($arr[key]!='') $str .= " and (
			mnemocode like '%$arr[key]%' or wareName like '%$arr[key]%' or guige like '%$arr[key]%'
		)";
        $str .=" order by id desc";
		//echo $str;
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAllBySql($str);
		foreach($rowset as & $v) {
			$v['_edit'] = '<a href="javascript:void(0)" name="btnOfften" id="btnOfften" onclick="setOfften(this,'.$v['id'].')">取消常用</a>';
			if($v['isOfften']==0) $v['_bgColor']='lightblue';
			$this->makeEditable($v,'mnemocode');
		}
        $arr_field_info = array(
            //"_edit" => "选择",
            "id"=>'系统序号',
            "wareName" =>"名称",
            'guige'=>"规格",
            "mnemocode" =>"简写助记码",
			'_edit'=>'操作'
        );

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择纱支');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        $smarty->assign('s',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/PishaOfften.tpl');
    }

	#将某个规格设置为常用坯纱
	function actionSetOfften() {
		$sql = "update jichu_ware set isOfften=1 where id='{$_GET['id']}'";
		mysql_query($sql) or die(mysql_error());
		echo '{success:true}';
	}

	#将某个规格设置为常用坯纱
	function actionCancelOfften() {
		$sql = "update jichu_ware set isOfften=0 where id='{$_GET['id']}'";
		mysql_query($sql);
		echo '{success:true}';
	}
    #合并节点界面
    function actionMergeNode() {
        $arr=array(
            'wareId'=>$_GET['wareId'],
            'wareName'=>$_GET['name']
        );
        $smarty= & $this->_getView();
        $smarty->assign('aWare',$arr);
        $smarty->display('Jichu/WareMergeEdit.tpl');
    }
    #合并节点
    function actionSaveMergeNode() {
    //dump($_POST);
        foreach($this->tableName as $v) {
            $sql='update '.$v.' set wareId='.$_POST['to'].' where wareId='.$_POST['wareId'];
            mysql_query($sql) or die('错误'.mysql_error());
        //echo($sql.<br/>);
        }
        //exit;
        $this->_modelExample->removeByPkv($_POST['wareId']);
        $parentId=$this->_modelExample->getClass($_POST['to']);
        redirect($this->_url('right',array('parentId'=>$parentId)));
    }

    //查找是否有相同的纱支，返回一个json对象flag:ture or flase.
    function actionGetflag() {
    //echo($_GET['wareName']);exit;
        $flag=$this->_modelExample->find(array('wareName'=>$_GET['wareName'],'guige'=>$_GET['guige']));
        //dump($flag);
        $arr=array(
            flag=>'false'
        );
        if($flag) {
            echo(json_encode($arr));
        }
        else {
            $arr['flag']='true';
            echo(json_encode($arr));
        }
    }

    /**
     * @desc ：弹出染化料选择，通过树形结构展开
     * Time：2016/05/19 16:47:54
     * @author Wuyou
    */
    function actionPopupByTreeNew(){
        //by zcc 增加搜索功能 功能单一 不能跟踪 还需要逐级点击（也就算隐藏不需要的类和子类）
        // dump($_GET);die();
        $key = array(
            'key'=>$_POST['key']
        );   
        $sql = "SELECT MIN(leftId) as minId,MAX(rightId)as maxId  from jichu_ware where parentId='5' order by orderLine,wareName";
        $arr = $this->_modelExample->findBySql($sql);
        if ($_POST['key']) {
            $sql = "SELECT
                *
            FROM
                jichu_ware as a
            WHERE
                a.parentId = '5'
            AND EXISTS(
                    SELECT id 
                    FROM jichu_ware as tmp 
                    WHERE tmp.wareName like '%{$_POST['key']}%' AND tmp.leftId>a.leftId AND tmp.rightId<a.rightId 
                ) 
            ORDER BY
                a.orderLine,
                a.wareName";
        }else{
            $sql ="SELECT * FROM jichu_ware where parentId = '5' ORDER BY orderLine,wareName";
        }
        // dump($sql);die();
        $rowset = $this->_modelExample->findBySql($sql);
        $ret = array();
        if($rowset) foreach($rowset as & $v) {
            $temp = array(
                "id"=>$v['id'],//节点id
                "text"=> $v['wareName'].' '.$v['guige'],//标签文本
                "value"=> $v['id'],//值
                "showcheck"=> false,//是否显示checkbox
                //"isexpand"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否展开,
                "isexpand"=>false,
                "checkstate"=> 0,//是否被选中
                "hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
                "ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
                "complete"=>false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
                //"complete"=> true
            );
            $ret[] = $temp;
        }
        //dump($ret);exit;
        //取得所有的组
        $smarty = & $this->_getView();
        $smarty->assign('title','选择染料助剂');
        $smarty->assign('data',json_encode($ret));
        $smarty->assign('arr_condition', $key);
        //$smarty->assign('rowRole',$rowRole);
        $smarty->display("Popup/WarePop.tpl");
    }
    function actionPopupByTree(){
        $key = array(
            'key'=>$_POST['key']
        );   
        if ($_POST['key']) {
            $sql = "SELECT * 
                FROM jichu_ware 
                where wareName like '%{$_POST['key']}%' 
                AND leftId+1=rightId";
        }else{
            $sql ="SELECT * FROM jichu_ware where parentId = '5' ORDER BY orderLine,wareName";
        }
        $rowset = $this->_modelExample->findBySql($sql);
        $ret = array();
        if($rowset) foreach($rowset as & $v) {
            $temp = array(
                "id"=>$v['id'],//节点id
                "text"=> $v['wareName'].' '.$v['guige'],//标签文本
                "value"=> $v['id'],//值
                "showcheck"=> false,//是否显示checkbox
                //"isexpand"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否展开,
                "isexpand"=>false,
                "checkstate"=> 0,//是否被选中
                "hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
                "ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
                "complete"=>false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
                //"complete"=> true
            );
            $ret[] = $temp;
        }
        //dump($ret);exit;
        //取得所有的组
        $smarty = & $this->_getView();
        $smarty->assign('title','选择染料助剂');
        $smarty->assign('data',json_encode($ret));
        $smarty->assign('arr_condition', $key);
        //$smarty->assign('rowRole',$rowRole);
        $smarty->display("Popup/WarePop.tpl");
    }
    /**
     * @desc ：纱支弹窗选择，树形结构
     * Time：2016/05/25 09:29:39
     * @author Wuyou
    */
    function actionPopupShazhi(){
        $sql = "select * from jichu_ware where parentId='2' order by orderLine,wareName";
        $rowset = $this->_modelExample->findBySql($sql);
        $ret = array();
        if($rowset) foreach($rowset as & $v) {
            $temp = array(
                "id"=>$v['id'],//节点id
                "text"=> $v['wareName'].' '.$v['guige'],//标签文本
                "value"=> $v['id'],//值
                "showcheck"=> false,//是否显示checkbox
                //"isexpand"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否展开,
                "isexpand"=>false,
                "checkstate"=> 0,//是否被选中
                "hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
                "ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
                "complete"=>false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
                //"complete"=> true
            );
            $ret[] = $temp;
        }
        //dump($ret);exit;
        //取得所有的组
        $smarty = & $this->_getView();
        $smarty->assign('title','选择纱支');
        $smarty->assign('data',json_encode($ret));
        $smarty->display("Popup/PishaGuige.tpl");
    }

    /**
     * @desc ：利用ajax展开某个节点调用的函数
     * Time：2016/05/19 17:04:09
     * @author Wuyou
    */
    function actionGetTreeJson() {
        // dump($_POST);exit;
        //判断出现乱码的情况 然后转换
        if(!preg_match('/^.*$/u', $_GET['key'])){
            $keyname=iconv('GB2312', 'UTF-8', $_GET['key']);
        }
        if ($keyname=='') {//没有乱码这调取get值
            $keyname = $_GET['key'];
        }
        $parentId = $_POST['value'] +0;
        if ($keyname) {
           $sql = "SELECT *
                from jichu_ware a 
                where a.parentId='{$parentId}'
                and a.isDel=0
                AND EXISTS(SELECT id FROM jichu_ware as tmp WHERE tmp.wareName like'%{$keyname}%' AND tmp.leftId>=a.leftId AND tmp.rightId<=a.rightId ) 
                order by a.orderLine";   
        }else{
            $sql = "SELECT *
                from jichu_ware
                where parentId='{$parentId}'
                and isDel=0
                order by orderLine";
        }
        $rowset = $this->_modelExample->findBySql($sql);
        $ret = array();
        if($rowset) foreach($rowset as & $v) {
                $ret[] = array(
                    "id"=>$v['id'],//节点id
                    "text"=> $v['wareName'] . ' '.$v['guige'],//标签文本
                    "value"=> $v['id'],//值
                    "wareName" => $v['wareName'],//品名
                    "guige" => $v['guige'],//规格
                    "showcheck"=> false,//是否显示checkbox
                    "isexpand"=> false,//是否展开,
                    "checkstate"=> 0,//是否被选中
                    "hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
                    "ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
                    "complete"=> $v['leftId']+1==$v['rightId'] ? true : false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
                );
            }  
        echo json_encode($ret);exit;
    }
    /**
     * ps ：根据指定的id 来获取纱支规格名称
     * Time：2017/07/12 09:43:39
     * @author zcc
    */
    function actionGetWare(){
        if ($_GET['id']) {
            $str = "select * from jichu_ware where id=2";
            $p= mysql_fetch_assoc(mysql_query($str));
            $str = "select * from jichu_ware
                where 1 and leftId+1=rightId
                and leftId>={$p['leftId']} and rightId<={$p['rightId']}";
            $str .= " and id = '{$_GET['id']}'";
            $arr = $this->_modelExample->findBySql($str);
            echo json_encode($arr[0]);
            exit();
        }
    }
    /**
     * date：2017-09-22 15:14:48
     * author：zcc
     * ps：把纱支和染料档案中的最子级数据修改或补充单位
     */
    function actionSetUnitPath(){
        if ($_GET['kind'] == '1') {//为所有的纱支
            $str = "select * from jichu_ware where id=2";
            $p= mysql_fetch_assoc(mysql_query($str));
            $sql = "UPDATE jichu_ware  SET unit ='kg' WHERE id in ( SELECT a.id FROM( SELECT
                    id
                FROM
                    jichu_ware
                WHERE
                    leftId + 1 = rightId
                AND leftId >={$p['leftId']}
                AND rightId <= {$p['rightId']} ) a );";
            $id = $this->_modelExample->execute($sql);
            echo "执行完毕！<br>";
            echo '<a href='.$this->_url('SetUnitPath').'>返回</a>';
            exit();
        }
        if ($_GET['kind'] == '2') {
            $str = "select * from jichu_ware where id=5";
            $p= mysql_fetch_assoc(mysql_query($str));
            $sql = "UPDATE jichu_ware  SET unit ='kg' WHERE id in ( SELECT a.id FROM( SELECT
                    id
                FROM
                    jichu_ware
                WHERE
                    leftId + 1 = rightId
                AND leftId >={$p['leftId']}
                AND rightId <= {$p['rightId']} ) a );";
            $id = $this->_modelExample->execute($sql);
            echo "执行完毕！<br>";
            echo '<a href='.$this->_url('SetUnitPath').'>返回</a>';
            exit();
        }
        $string = '<a href='.$this->_url('SetUnitPath',array('kind'=>1)).'>填充单位kg到纱支档案中最子级类中</a><br>';
        $string .= '<a href='.$this->_url('SetUnitPath',array('kind'=>2)).'>填充单位kg到染化料档案中最子级类中</a>';
        echo $string ;
        exit();

    }

    /**
     * ps ：设置产量单价
     * Time：#2018-02-27 12:44:42
     * @author zcc
    */
    function actionSetDanjia(){
        // $this->authCheck($this->funcId);
        $sql = "SELECT * FROM jichu_ware WHERE id = '{$_GET['wareId']}'";
        $ware = $this->_modelExample->findBySql($sql);
        $sql = "SELECT * FROM jichu_ware_danjia WHERE wareId = '{$_GET['wareId']}'";
        $rowset = $this->_modelExample->findBySql($sql);
        // $rowset['0']['wareId'] = $_GET['wareId'];
        // $rowset['0']['wareName'] = $ware[0]['wareName'];
        // $rowset['0']['guige'] = $ware[0]['guige'];
        $res['wareId'] = $_GET['wareId'];
        $res['wareName'] = $ware[0]['wareName'];
        $res['guige'] = $ware[0]['guige'];
        // dump($rowset);die();
        $smarty = & $this->_getView();
        $smarty->assign('title', $this->title);
        $smarty->assign('aRow',$rowset);
        $smarty->assign('res',$res);
        $smarty->assign('title','订单登记');
        $smarty->display('JiChu/WareDanjiaEdit.tpl');
    }

    function actionSaveDanjia(){
        //dump($_POST);die();
        // $id = $this->_modelDanjia->save($_POST);
        // js_alert('',"window.parent.location.href=window.parent.location.href");
        foreach ($_POST['gongxuId'] as $k =>&$v) {
            if(!$v) continue;
            $temp['id'] = $_POST['ids'][$k];
            $temp['gongxuId'] = $_POST['gongxuId'][$k];
            $temp['danjia']   = $_POST['danjia'][$k];
            $temp['wareId']   = $_POST['wareId'];
            $rowSon[] = $temp;
        }
        //dump($rowSon);die;
        $id = $this->_modelDanjia->saveRowset($rowSon);
        js_alert('',"window.parent.location.href=window.parent.location.href");
    }
}
?>