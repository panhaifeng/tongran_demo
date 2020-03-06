<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Sys_Sys extends Tmis_Controller
{
	var $_modelSys;
   function Controller_Sys_Sys()
	{
	   $this->_modelSys = FLEA::getSingleton('Model_Sys_Sys');
	}
   function actionRight(){
       $smarty = & $this->_getView();
	   $smarty->display('Sys/SysEdit.tpl');
	}

	//保存执行的sql记录
   function actionSave(){
       $sql=trim($_POST['sql']);
	   $sql=str_replace("","\r\n",$sql);
       //echo($sql);exit;
	   $str=substr($sql,strrpos($sql,";")+1);
	   if($str=="") $sql=substr($sql,0,strrpos($sql,";"));
	   $array= explode(";",$sql);
	   //dump($array);exit;
	   foreach( $array as $sql1)
		{
            $sql1=trim($sql1);
			//echo($sql1.".<br>");
	        mysql_query($sql1) or die ('执行错误:'.mysql_error());
		}
       $this->_modelSys->save($_POST);
	   echo("<script> alert('执行成功!!');history.go(-1) </script>");
	}

   function actionRight1(){
		FLEA::loadClass('TMIS_Pager');
		$smarty= & $this->_getView();
		$smarty->assign('title','历史执行记录');
        $smarty->assign('controller','Sys_Sys');
		$arr_field_info = array
		(
		'sql'=>"SQL语句内容",
		'memo'=>"备注"
		);
		$arr_edit_info = array
		(
			'remove'=>"删除"
		);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$pager= & new TMIS_Pager($this->_modelSys,null);
		$rowset =$pager->findAll();
		//dump ($rowset);exit;
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('pk',$this->_modelSys->primaryKey);
		$smarty->assign('this_controller', $this->thisController);
		$smarty->display('TableList.tpl');
		//echo("<a href='#' onclick='history.go(-1)' style='font:bold;'>返回</a>");
	}
   function actionRemove(){
		$pk=$this->_modelSys->primaryKey;
		$this->_modelSys->removeByPkv($_GET[$pk]);
		redirect(url("Sys_Sys","Right1"));
	}

	//显示系统基础设置
   function actionSet(){
		$m = & FLEA::getSingleton('Model_Sys_Set');
		$rowset = $m->findAll();
		if($rowset) $ret = array_to_hashmap($rowset, 'setName','setValue');
		$smarty= & $this->_getView();
		$smarty->assign('title','系统基本设置');
		$smarty->assign('row',$ret);
		//dump($ret);
		$smarty->display('Sys/SysSetup.tpl');
	}
	//保存系统设置
   function actionSaveSet(){
	    //dump($_POST);
		$m = & FLEA::getSingleton('Model_Sys_Set');
		foreach($_POST['setName'] as $key=>& $v) {
			if($_POST['setValue'][$key]==='') continue;
			//如果存在setName相同的记录，取得id值进行修改
			$temp = $m->find(array('setName'=>$v));
			$id=$temp ? $temp['id']:0;

			$arr[] = array(
				'id'=>$id,
				'setValue'=>$_POST['setValue'][$key],
				'setName'=>$_POST['setName'][$key]
			);
		}
		//dump($arr);exit;

		if($m->saveRowset($arr)){
			js_alert(null,null,$this->_url('set'));
		}
	}
	//基础资料，操作日志
   function actionRight2(){
      $mlog=& FLEA::getSingleton('Model_JiChu_ControlLog');
	  $arr=$mlog->findAll();
	  foreach($arr as & $v)
	   {
		  $v['_edit']="<a href='".$this->_url('Remove2',array('id'=>$v['id']))."'>删除</a>";
	   }
	  $arr_field_info=array(
		  'item'=>'操作内容',
		  'action'=>'动作',
		  'user'=>'操作人',
		  'dt'=>'时间',
	      '_edit'=>'操作'
		  );
	  $smarty= & $this->_getView();
	  $smarty->assign('title','基础资料操作日志');
	  $smarty->assign('add_display','none');
	  $smarty->assign('arr_field_info',$arr_field_info);
	  $smarty->assign('arr_field_value',$arr);
	  $smarty->display('TableList.tpl');
   }

   function actionRemove2(){
      $mlog=& FLEA::getSingleton('Model_JiChu_ControlLog');
	  $mlog->removeByPkv($_GET['id']);
	  js_alert('','',$_SERVER[HTTP_REFERER]);
   }

   /**
    * ps ：执行清除除基础档案的所有业务数据（仓库财务生产）
    * Time：2017年10月31日 13:48:38
    * @author zcc
   */
   function actionClearDatabase(){
   	//验证code 
   	if ($_GET['code']!='eqinfo888') {
   		echo "code错误，请联系管理员确认！";die();
   	}
   	//需要执行的数据库表数组
   	$data = array(
   		'caiwu_accountitem','caiwu_ar_init','caiwu_ar_other','caiwu_artype','caiwu_expense','caiwu_expenseitem','caiwu_income',
   		'caiwu_invoice','caiwu_payment','caiwu_yf_init','caiwu_yf_other','caiwu_yf_pisha','cangku_chuku','cangku_chuku_log',
   		'cangku_chuku2ware','cangku_dye_pandian','cangku_init','cangku_ruku','cangku_ruku2ware','cangku_wujin_chuku',
   		'cangku_wujin_ruku','cangku_yl_chuku','cangku_yl_chuku2ware','cangku_yl_ruku','cangku_yl_ruku2ware',
   		'chengpin_blog2cpck','chengpin_dye_cpck','chengpin_dye_cprk','chengpin_printblog','dye_db_chanliang',
   		'dye_db_chanliang_mx','dye_fanxiu_record','dye_gang2stcar','dye_hd_chanliang','dye_hs_chanliang','dye_rs_chanliang',
   		'dye_st_chanliang','dye_zcl_chanliang','gongyi_dye_chufang','gongyi_dye_chufang2ware','gongyi_dye_merge',
   		'plan_dye_gang','plan_dye_gang_merge','trade_dye_order','trade_dye_order2ware','other_newcode'
   	);
   	foreach ($data as $key => $value) {
   		$sql = "TRUNCATE `{$data[$key]}`";
   		$id = $this->_modelSys->execute($sql);
   		if ($id) {
   			echo "$data[$key] 表已清空！<br>";
   		}
   	}
   	die();
   }
   /**
    * ps ：订单产地数据补丁
    * Time：2017年11月14日 14:47:36
    * @author zcc
   */
   function actionRestoreOrderChandi(){
   		//找出订单明细表中 产地为空的数据
   		$sql = "SELECT x.* 
   			FROM trade_dye_order2ware x
   			where x.chandi='' and x.pihao <>'' ";
   		$rowset = $this->_modelSys->findBySql($sql);
   		if (count($rowset)>0){
   			foreach ($rowset as &$v) {
	   			$sql = "SELECT * FROM cangku_ruku2ware where pihao = '{$v['pihao']}'";
	   			$cangku = $this->_modelSys->findBySql($sql);
	   			$execute = "UPDATE trade_dye_order2ware set chandi = '{$cangku[0]['chandi']}' where id ='{$v['id']}'";
	   			$id = $this->_modelSys->execute($execute);
	   			if ($id) {
	   				echo "批号 $v[pihao] 已经修复产地<br>";
	   			}
   			}	
   		}else{
   			echo "没有要修复的数据！请关闭本页面！";
   			exit();
   		}
   		
   }
}
?>