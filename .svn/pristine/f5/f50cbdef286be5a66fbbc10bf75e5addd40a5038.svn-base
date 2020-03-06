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
        'cangku_dye_pandian',
        'cangku_init',
        'cangku_ruku2ware',
        //'cangku_wujin_chuku',
        //'cangku_wujin_ruku',
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
    }

    #tmisMenu用的object
    /**
     *取得tmisMenu用的对象
     */
    function actionTmisMenu() {
        $subClasses = $this->_modelExample->getSubNodes1($_GET[parentId]);
        //dump($subClasses);exit;
        $ret="{items : [";
        for ($i=0;$i<count($subClasses);$i++) {
			/*$ret .= "{value:".$subClasses[$i][id].",isDirectory.",isDirectory:"
				. $subClasses[$i][rightId]-$subClasses[$i][leftId]>1?"1":"0"
				.",text:".$subClasses[$i][wareName]
				."},";
				*/
            $isD = ($subClasses[$i][rightId]-$subClasses[$i][leftId])>1?1:0;
            $value=$subClasses[$i][id];
            $text = $subClasses[$i][wareName];
            $text .= !$isD&&$subClasses[$i][guige]!=""?("||".$subClasses[$i][guige]):"";
            $json = json_encode($subClasses[$i]);
            //$text .= !$isD&&$subClasses[$i][danwei]!=""?("||".$subClasses[$i][danwei]):"";
            $ret .= "{value:$value,isDirectory:$isD,text:'$text',json:$json},";
        };
        $ret = substr($ret,0,-1);
        $ret .= "]}";
        echo $ret;exit;
		/*if($_GET[parentID]==0) {
			//显示根目录
			echo "{
				items : [
					{
						value:1,
						isDirectory:false,
						text:'test1'
					},
					{
						value:2,
						isDirectory:true,
						text:'test2',
						subMenu:{
							items:[
								{value:2.1,isDirectory:false,text:'test2.1'}
							]
						}
					},
					{value:3,isDirectory:false,text:'test3'}
				]
			}";
		}
		else echo "{items:[{value:'$_GET[a]-1',isDirectory:true,text:'$_GET[a]-1'}]}";
		exit;
		*/
    }


    function actionRight() {
        FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
        $arr = TMIS_Pager::getParamArray(array(
            key=>''
        ));

        if($arr['key']=='') {
			//echo 1;
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
		} else {
			$key = trim($_GET['key'])=='' ? trim($_POST['key']) : trim($_GET['key']);
			$sql = "select * from jichu_ware where (
				wareCode like '%{$key}%' or
				wareName like '%{$key}%' or
				mnemocode like '%{$key}%')";
			//echo $sql;exit;

			$subClasses = $this->_modelExample->findBySql($sql);
		}

        $arrFieldInfo = array(
            //"id"=>"系统编号",
			"wareCode"=>"物料编码|left",
            //"orderLine"=>"排列顺序<br>(点击修改)",
			'deepth'=>"级别深度|right",
			"pos"=>"位置|left",
            "wareName"=>"品名|left",
            "guige"=>"规格|left",
            "unit"=>"单位|left",
	    "cntMin"=>"最小库存|right",
	    "cntMax"=>"最大库存|right",
            "mnemocode"=>"助记码|left",
            "showSub" => "查看子项",
            "_edit"=>'操作'
        );

        if (count($subClasses)>0) {
            foreach($subClasses as &$row) {
                $this->makeEditable($row,'mnemocode');
		#如为根目录最小库存和最大库存显示为空
		$row['leftId']+1==$row['rightId']?$this->makeEditable($row,'cntMin'):$row['cntMin']='';
		$row['leftId']+1==$row['rightId']?$this->makeEditable($row,'cntMax'):$row['cntMax']='';
                $row[showSub] = "<a href='".$this->_url('right',array(
                    'parentId'=>$row['id'],
					'key'=>'',
					'default'=>$_GET['default'],
                    ))."'>".($row['leftId']+1==$row['rightId'] ? '<font color="green">无子项</font> >>进入':'<font color="red">有子项</font> >>进入')."</a>";
                $row['_edit'] = "<a href='".$this->_url('Edit',array(
                    'id'=>$row['id'],'default'=>$_GET['default']
                    ))."'>修改</a>". " | " . $this->getRemoveHtml($row['id']);
                $row['_edit'] .= " | <a href='".$this->_url('moveNode',array(
                    'sourceId'=>$row['id'],
					'default'=>$_GET['default'],
					'parentIdFrom'=>$_GET['parentId']
                    ))."' title='节点移动'>移动</a>";
                $v=$this->_modelExample->findAll(array(array('leftId',$row['leftId'],'>'),array('rightId',$row['rightId'],'<')));
                /*if(count($v)>o) {
                    $row['_edit'].=' | <span disabled >合并</span>';
                }
                else {
                    $row['_edit'].=' | <a href='.$this->_url('MergeNode',array('wareId'=>$row['id'],'name'=>$row['wareName'],'default'=>$_GET['default'])).'>合并</a>';
                }*/

            }
        }
	//dump($subClasses);
        $smarty = & $this->_getView();
        $smarty->assign("arr_field_info",$arrFieldInfo);
        $smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('add_url',$this->_url('add',array(
			'parentId'=>$parentId
		)));
		$smarty->assign("title","五金资料");
        $smarty->assign("arr_field_value",$subClasses);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','grid')));
        $smarty->assign("page_info",$this->showPathInfo());
        $smarty->display("TableList2.tpl");
    }

	#物料一览,港务需要，考虑排序问题
	function actionRight1() {
		$title="物料一览";
		FLEA::loadClass('TMIS_Pager');
		 $arr = TMIS_Pager::getParamArray(array(
            key=>''
        ));
		$sql = "select * from jichu_ware where leftId+1=rightId order by wareCode";
		$pager =& new TMIS_Pager($sql);
        $rowset =$pager->findAll();

		//$rowset = $this->_modelExample->findBySql($sql);
		$arr_field_info = array(
			"wareCode" =>"编码|left",
			"wareName" =>"品名|left",
			"guige" =>"规格|left",
			"unit" =>"单位|left",
			'mnemocode'=>'助记码|left'
		);
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss('calendar'));
		$smarty->assign('arr_field_value',$rowset);
		//$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList2.tpl');
	}

	#在弹出窗口中显示子项
	function actionShowChildren() {
        //$this->authCheck($this->funcId);
        FLEA::loadClass('TMIS_Pager');


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
            //"id"=>"系统编号",
			"wareCode"=>"物料编码",
            //"orderLine"=>"排列顺序<br>(点击修改)",
			'deepth'=>"级别深度",
			"pos"=>"位置",
            "wareName"=>"品名",
            "guige"=>"规格",
            "unit"=>"单位",
            "mnemocode"=>"助记码"
            //"showSub" => "查看子项",
           // "_edit"=>'操作'
        );

        $smarty = & $this->_getView();
        $smarty->assign("arr_field_info",$arrFieldInfo);
        $smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('add_url',$this->_url('add',array(
			'parentId'=>$parentId
		)));
		$smarty->assign("title","货品资料");
        $smarty->assign("arr_field_value",$subClasses);
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','grid')));
        $smarty->assign("page_info",$this->showPathInfo());
        $smarty->display("TableList2.tpl");
    }

    function _edit($class) {
        //$this->authCheck($this->funcId);
		$_mPos= & FLEA::getSingleton('Model_Jichu_Pos');
		$pos=$_mPos->findAll(null,'id desc');
        $smarty = $this->_getView();
        $smarty->assign('path_info',$this->showPathInfo($class));
		if($class['parentId']==0) $class['parentName'] = '根目录';
		else {
			$p = $this->_modelExample->find(array('id'=>$class['parentId']));
			$class['parentName'] = $p['wareName']. ' ' . $p['guige'];
		}

        $smarty->assign('aRow',$class);
		$smarty->assign('aPos',$pos);
        $smarty->display('JiChu/WareEdit.tpl');
    }
    #增加界面
    function actionAdd() {
        $func = array(
            'parentId' => isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0,
        );
        //$func['parentId']='';
        $this->_edit($func);
    }
    #保存
    function actionSave() {
        $class = & $_POST;
		//dump($class);exit;
		if($_POST['id']==''){
			$str="SELECT * FROM cangku_kucun where wareId='{$_POST['parentId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			if($re){
				js_alert('该物料已经初始化，不能再增加子项','',$this->_url('right',array('parantId'=>$_POST['parantId'])));
				exit;
			}
		}
        if ($_POST['id']) {
	    //复制到子节点
	    if($_POST['son']!=''){
		$ware=$this->_modelExample->find($_POST['id']);
		$leftId=$ware['leftId'];
		$rightId=$ware['rightId'];
		//dump($ware);
		//dump($_POST);
		$str="update jichu_ware set pos='$_POST[pos]' where leftId>='$leftId' and rightId<='$rightId'";
		mysql_query($str);
	    }
	    //exit;
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
            if($flag) {js_alert('品名规格重复!','window.history.go(-1)',null);exit;}

			//取得深度
			$pClass = $this->_modelExample->find(array('id'=>$_POST['parentId']));

			$class['deepth'] = $pClass['deepth']+1;
			//dump($class);exit;

            $id=$this->_modelExample->createClass($class, $_POST['parentId']);


            $log=array(
                'item'=>$this->title.' id='.$id,
                'action'=>'添加',
                'user'=>$_SESSION['USERNAME']
            );
            $this->mlog->save($log);
        }

        $ex = __CATCH();
        if (__IS_EXCEPTION($ex)) {
            js_alert($ex->getMessage(), '', $this->_url('right'));
        }
		if($_POST['Submit']=='确认并返回') {
			redirect($this->_url('right',array(
				"parentId"=>$_POST['parentId'],
				"default"=>$_POST['default']
			)));
		} else {
			redirect($this->_url('add',array(
				"parentId"=>$_POST['parentId'],
				"default"=>$_POST['default']
			)));
		}
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
		$str="SELECT * FROM cangku_kucun where wareId='{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re){
			js_alert('该物料已经初始化，不能删除！','',$this->_url('right',array('parantId'=>$_POST['parantId'])));
			exit;
		}
        $class=$this->_modelExample->getClass($_GET['id']);
		
        $count=$this->_modelExample->calcAllChildCount($class);
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
        }
        else {
            //js_alert('不能删除!', '',$_SERVER[HTTP_REFERER]);exit;
        }

		$this->_modelExample->removeClassById($_GET['id']);
		redirect($this->_url('right',array("parentId" => $class[parentId])));
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

        $ret = "当前位置：<a href='" . $this->_url('right') ."'>根目录</a>";
        foreach ($path as $part) {
            $ret .= "-><a href='" . $this->_url('right',array("parentId"=>$part[id])). "'>$part[wareName]</a>";
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
		//dump($_POST);exit;
		if(empty($_POST['parentId'])) {
			js_alert('父类未确定!');exit;
		}
		if($_POST['id']==''){
			$str="SELECT * FROM cangku_kucun where wareId='{$_POST['parentId']}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			if($re){
				js_alert('该物料已经初始化，不能移动到该物料下','',$this->_url('right',array('parantId'=>$_POST['parentId'])));
				exit;
			}
		}
        $sourceNode = $this->_modelExample->find(array('id'=>$_POST['sourceId']));
        $targetNode = $this->_modelExample->find(array('id'=>$_POST['parentId']));

        //dump($sourceNode);dump($targetNode);exit;
        if ($this->_modelExample->moveNodeAndChild($sourceNode,$targetNode)) {
			//修改深度
			$sourceNode['deepth'] = $targetNode['deepth']+1;
			$this->_modelExample->update($sourceNode);
            $log=array(
                'item'=>$this->title.' id '.$_POST['sourceId'].'->'.$_POST['parentId'],
                'action'=>'移动',
                'user'=>$_SESSION['USERNAME']
            );
            $this->mlog->save($log);
            redirect($this->_url('right',array(
				'parentId'=>$_POST['parentIdFrom']
			)));
        } else {
            echo "出错!";
		}
    }

	//利用ymPromtp弹出选择器,全部坯纱
    function actionPopup() {
        $str = "select * from jichu_ware where leftId+1=rightId";
        FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
        $arr = TMIS_Pager::getParamArray(array(
            //'traderId' => '',
            'key' => ''
        ));
		$arr['code'] = rawurldecode($_GET['code']);
		//dump($arr);exit;
        if ($arr['key']!='') $str .= " and (
			mnemocode like '%$arr[key]%' or wareName like '%$arr[key]%' or guige like '%$arr[key]%' or wareCode like '%$arr[key]%'
		)";
		if ($_GET['code']!='') $str .= " and (
			mnemocode like '%{$_GET['code']}%' or wareName like '%{$_GET['code']}%' or guige like '%{$_GET['code']}%' or wareCode like '%{$_GET['code']}%'
		)";
        $str .=" order by wareCode";
		//echo $str;
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAllBySql($str);
		$mKucun= & FLEA::getSingleton('Model_Cangku_Kucun');
		foreach($rowset as & $v) {
			//计算当前库存
			//$kucun=$mKucun->find(array('wareId'=>$v['id']));
			//$v['danjia'] = $this->_getJqDanjia($v['id']);
			$v['danjia'] = $this->_modelExample->getJqDanjia($v['id']);
			$kucun=$this->_modelExample->getKucun($v['id']);
			$v['cntKucun']=round($kucun['cnt'],2);
		}
        $arr_field_info = array(
            //"_edit" => "选择",
            "wareCode"=>'物料编码',
            "wareName" =>"名称",
            'guige'=>"规格",
            "mnemocode" =>"助记码",
			"cntKucun" =>"当前库存"
        );

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择纱支');
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        $smarty->assign('s',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/Ware.tpl');
    }
	//得到某个物料本期的加权单价
	function _getJqDanjia($wareId) {
		$sql = "select * from cangku_kucun where wareId='{$wareId}'";
		$row = $this->_modelExample->findBySql($sql);
		return $row[0]['jqDanjia'];
	}
    function actionPopup1() {
		//$wareId=array();
		$str="select y.leftId,y.rightId from acm_user2ware x left join jichu_ware y on x.wareId=y.id where userId='$_SESSION[USERID]'";
		//echo $str;exit;
		$query=mysql_query($str);
		$arrId = array();
		while($re=mysql_fetch_assoc($query)){
			//$wareId[]=$re['wareId'];
			$arrId[] = "(leftId>='{$re['leftId']}' and rightId<='{$re['rightId']}')";
		}

		$str = "select * from jichu_ware where 1";
		if(count($arrId)==0)$str.=" and leftId+1=rightId";
		if(count($arrId)>0)$str.=" and (".join(' or ',$arrId).")";
			FLEA::loadClass('TMIS_Pager');
			TMIS_Pager::clearCondition();
			$arr = TMIS_Pager::getParamArray(array(
				//'traderId' => '',
				'key' => ''
			));
			$arr['code'] = rawurldecode($_GET['code']);
			//dump($arr);exit;
			if ($arr['key']!='') $str .= " and (
				mnemocode like '%$arr[key]%' or wareName like '%$arr[key]%' or guige like '%$arr[key]%' or wareCode like '%$arr[key]%'
			)";
			if ($_GET['code']!='') $str .= " and (
				mnemocode like '%{$_GET['code']}%' or wareName like '%{$_GET['code']}%' or guige like '%{$_GET['code']}%' or wareCode like '%{$_GET['code']}%'
			)";
			$str .=" order by wareCode";
			//echo $str;
			$pager =& new TMIS_Pager($str);
			$rowset =$pager->findAllBySql($str);
		$mKucun= & FLEA::getSingleton('Model_Cangku_Kucun');
		foreach($rowset as & $v) {
			if(count($wareId)>0){
				if($v['leftId']+1!=$v['rightId']){
				$str="select * from jichu_ware where leftId>'$v[leftId]' and rightId<'$v[rightId]'";
				$query=mysql_query($str);
				while($re=mysql_fetch_assoc($query)){
					$rowset[]=$re;
				}
				}
			}
			//$v['_edit'] = '<a href="javascript:void(0)" name="btnOfften" id="btnOfften" onclick="setOfften(this,'.$v['id'].')">设为常用</a>';
			//if($v['isOfften']==1) $v['_bgColor']='lightgreen';
			//$this->makeEditable($v,'mnemocode');
			//计算当前库存
			$kucun=$mKucun->find(array('wareId'=>$v['id']));
			$v['cntKucun']=round($kucun['cnt'],2);
		}
	//dump($rowset);
        $arr_field_info = array(
            //"_edit" => "选择",
            "wareCode"=>'物料编码',
            "wareName" =>"名称",
            'guige'=>"规格",
            "mnemocode" =>"助记码",
			"cntKucun" =>"当前库存"
        );

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择纱支');
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        $smarty->assign('s',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/Ware.tpl');
    }
	//利用ymPromtp弹出选择器,选择父类
    function actionSelParent() {
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		//dump($arr);
		$parentId = isset($_GET['parentId']) ? (int)$_GET['parentId'] : 0;
		if($arr['key']!='') {
			//$key = trim($_GET['key'])=='' ? trim($_POST['key']) : trim($_GET['key']);
			$key = $arr['key'];
			$sql = "select * from jichu_ware where (
				wareCode like '%{$key}%' or
				wareName like '%{$key}%' or
				mnemocode like '%{$key}%')";
			$subClasses = $this->_modelExample->findBySql($sql);
		} else {
			if ($parentId) {
				$parent = $this->_modelExample->getClass($parentId);
				if (!$parent) {
					echo "无效分类 in actionRight!";exit;
				}
				$subClasses = $this->_modelExample->getSubNodes1($parent);
			} else {
				$subClasses = $this->_modelExample->getAllTopNodes1();
			}
		}
		//echo $sql;
		//echo $sql;
        $arr_field_info = array(
            "id"=>"系统编号",
			"wareCode"=>"物料编码",
            //"orderLine"=>"排列顺序<br>(点击修改)",
			'deepth'=>"级别深度",
            "wareName"=>"类名",
            "guige"=>"规格",
            "mnemocode"=>"助记码",
            "showSub" => "查看子项",
			"_edit" => "选择"
        );

		foreach($subClasses as & $v) {
			$json = htmlspecialchars(json_encode($v));

			if($v['leftId']+1<$v['rightId']) $v['showSub']= "<a href='".$this->_url('SelParent',array(
				'parentId'=>$v['id']
			))."'> > 进入</a>";
			$v['_edit']= "<a href='javascript:void(0)' onclick='ret({$json})'>选择</a>";
		}

        //dump($rowset); exit;
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择类别');
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$subClasses);
        $smarty->assign('arr_js_css',$this->makeArrayJsCss('grid'));
        //$smarty->assign('s',$arr);
		//$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty-> display('Popup/SelParent.tpl');
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

	//入库或者申请时，根据关键字取得匹配的物料，包括编码和助记码
	function actionGetJsonByKey() {
		 $str = "select x.*,y.cnt as cntKucun from jichu_ware x
			left join cangku_kucun y on x.id=y.wareId
			where leftId+1=rightId
			and leftId+1 = rightId";
		if ($_GET['key']!='') $str .= " and (
				mnemocode like '%$_GET[key]%' or wareName like '%$_GET[key]%' or guige like '%$_GET[key]%' or wareCode like '%$_GET[key]%'
			)";
			elseif ($_GET['code']!='') $str .= " and (
				mnemocode like '%$_GET[code]%' or wareName like '%$_GET[code]%' or guige like '%$_GET[key]%' or wareCode like '%$_GET[code]%'
			)";
			else {
				echo json_encode(null);exit;
			}
		$str .=" order by id desc limit 0,2";
			//echo $str;exit;
			//echo $str;exit;
		//$pager =& new TMIS_Pager($str);
		$rowset =$this->_modelExample->findBySql($str);
		foreach($rowset as & $v){
		    $v['cntKucun']=round($v['cntKucun'],2);
		}
		echo json_encode($rowset);exit;
	}

	//增加物料时，物料编码失去焦点时,显示与物料编码相匹配的物料信息
	function actionGetJsonByCode() {
		$ret = $this->_modelExample->find(array('wareCode'=>$_GET['code']));
		//获得路径信息
		if($ret) {
			$ret['pathInfo'] = '根目录';
			$path = $this->_modelExample->getPath($ret);
			if($path) foreach($path as & $v) {
				$ret['pathInfo'] .= "->".trim($v['wareName'] . ' ' . $v['guige']);
			}

		}
		echo json_encode($ret);exit;
	}

	function actionImport() {
		//导入
		 $smarty= & $this->_getView();
        $smarty->assign('aWare',$arr);
        $smarty->display('Jichu/WareImport.tpl');
	}

	function actionImportSure() {
		//echo $this->recode('&#22235&#37197&#22871');exit;
		if(empty($_POST['parentId'])) {
			js_alert('父类未确定!');exit;
		}

		$parent = $this->_modelExample->find(array('id'=>$_POST['parentId']));
		//dump($parent);exit;

		FLEA::loadFile('TMIS_Excel');
		Read_Excel_File($_FILES['file1']['tmp_name'],$arr);
		//dump($arr);exit;
		//dump($arr);exit;
		 $smarty= & $this->_getView();
        $smarty->assign('rowset',array_shift($arr));
        $smarty->display('Jichu/WareImportSure.tpl');
	}
	function actionSaveImport() {
		//echo $this->recode('&#22235&#37197&#22871');exit;
		//dump($_POST);exit;
		if(empty($_POST['parentId'])) {
			js_alert('父类未确定!');exit;
		}

		$parent = $this->_modelExample->find(array('id'=>$_POST['parentId']));
		//dump($_POST);exit;
		foreach($_POST['wareCode'] as $key => & $v) {
			//dump($v);exit;
			if($v=='') continue;
			//echo($this->recode($v[1]));exit;
			$temp = array(
				'deepth'=>$parent['deepth']+1,
				'parentId'=>$_POST['parentId'],
				'wareCode'=>$v,
				'wareName'=>$_POST['wareName'][$key],
				'guige'=>$_POST['guige'][$key],
				'unit'=>$_POST['unit'][$key],
				'mnemocode'=>$v,
				'pos'=>'材料仓库'
			);
			//print_r($temp);exit;
			$newId = $this->_modelExample->createClass($temp, $_POST['parentId']);

			//设置初始数据
			if($_POST['initCnt'][$key]==0) continue;
			$mKucun = & FLEA::getSingleton('Model_Cangku_Kucun');
			$temp = array(
				'wareId'=>$newId,
				'initCnt'=>$_POST['initCnt'][$key],
				'initMoney'=>$_POST['initMoney'][$key]
			);
			$mKucun->create($temp);
		}
		redirect($this->_url('import'));
	}

	//利用ajax展开某个节点调用的函数
	function actionGetTreeJson(){
		$parentId = $_POST['value'] +0;
		$rowset = $this->_modelExample->getSubNodes($parentId);
		$ret = array();
		if($rowset) foreach($rowset as & $v){
			$ret[] = array(
				"id"=>$v['id'],//节点id
				"text"=> $v['wareCode'].':'.$v['wareName'] . ($v['guige']==''?'':" {$v['guige']}"),//标签文本
				"value"=> $v['id'],//值
				"showcheck"=> true,//是否显示checkbox
				"isexpand"=> false,//是否展开,
				"checkstate"=> 0,//是否被选中
				"hasChildren"=> $v['leftId']+1==$v['rightId'] ? false : true,//是否有子节点
				"ChildNodes"=> null,//子节点,仅当complete为true时起作用，如果使用ajax获得子节点，这里定义的将不起作用
				"complete"=> $v['leftId']+1==$v['rightId'] ? true : false//是否已经完成，if true:不再进行递归检索，否则将搜索子项并展开,如果是ajax进行检索，childNodes属性将不再起作用
			);
		}
		echo json_encode($ret);exit;
	}
}
?>