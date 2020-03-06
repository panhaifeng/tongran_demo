<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Vat extends Tmis_Controller {
	var $_modelExample;
	var $title = "染缸档案";
	var $funcId = 26;
	function Controller_JiChu_Vat() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Vat');
		$this->_modelShuirong = & FLEA::getSingleton('Model_JiChu_Vat2shuirong');
	}

	/**
	 * 入口文件
	*/
	function actionIndex() {
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign('caption', "染缸档案");
		$smarty->assign('controller', 'JiChu_Vat');
		$smarty->assign('action', 'right');
		$smarty->display('MainContent.tpl');
	}

	function actionRight() {
		$this->authCheck($this->funcId);
		FLEA::loadClass('TMIS_Pager');
		//$arrParam = TMIS_Pager::getParamArray(array('key'=>''));
		//$condition = $arrParam[key]!='' ? "vatCode like '$arrParam[key]%'" : NULL;
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'orderLine asc');
        $rowset =$pager->findAll();
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign('controller', 'JiChu_Vat');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
			"vatCode" =>"染缸代码",
			"orderLine"=>"排列顺序(点击修改)",
			"minKg" =>"最小染纱量",
			"maxKg" =>"最大染纱量",
			"cntTongzi" =>"装筒数",
			"minYubi" =>"最小浴比",
			"maxYubi" =>"最大浴比",
			"shuiRong" =>"水容量",
			"shuiRong1" =>"水容量1",
			"memo" =>"备注"
		);
		$smarty->assign('arr_field_info',$arr_field_info);

		#对操作栏进行赋值
		$arr_edit_info = array(
			"edit" =>"修改",
			"remove" =>"删除"
		);
		$smarty->assign('arr_edit_info',$arr_edit_info);

		#对字段内容进行赋值:
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);

		#分页信息
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));

		#开始显示
		$smarty->display('TableList.tpl');
	}


	/**
	 * 修改,增加综合处理函数
	 */
	function _edit($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aVat",$Arr);

		#通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
		#在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		$smarty->assign("pk",$primary_key);
		$smarty->display('JiChu/VatEditNew.tpl');
	}
	function actionRemove(){
		#判断该染缸是否有处方的并缸记录
		$str="select * from gongyi_dye_merge where vatId='{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re){
			js_alert('处方的并缸中有该染缸的记录，不能删除!','',$this->_url('right'));
			exit;
		}
		#判断排缸中是否有该记录
		$str="select * from plan_dye_gang where vatId='{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re){
			js_alert('排缸中有该染缸的记录，不能删除!','',$this->_url('right'));
			exit;
		}
		#判断排缸的并缸中是否有该记录
		$str="select * from plan_dye_gang_merge where vatId='{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re){
			js_alert('并缸中有该染缸的记录，不能删除!','',$this->_url('right'));
			exit;
		}
		$this->_modelExample->removeByPkv($_GET['id']);
		redirect($this->_url('right'));
	}

	//取得某类下的所有客户,返回json对象
	function actionGetJson() {
		$arr = $this->_modelExample->findAll("vatCode like '$_GET[type]___'");
		echo json_encode($arr);exit;
	}

	//取得最大的同类供应商代码
	function actionGetMaxvatCode() {
		$arr = $this->_modelExample->find("vatCode like '$_GET[vatCode]___'",'vatCode desc','vatCode');
		echo json_encode($arr);exit;
	}

	function actionGetJsonShuirong() {
		$arr = $this->_modelExample->find(array('id'=>$_GET['vatId']));
		echo json_encode($arr);exit;
	}
	/**
	 * ps ：保存方法重写(移植的建立)
	 * Time：2015/11/03 22:19:14
	 * @author Wuyou
	 * @param _POST
	*/
	function actionSave() {
		// dump($_POST);exit;
		for ($i=0;$i<count($_POST['cengCnt']);$i++){
			if(empty($_POST['cengCnt'][$i]) || empty($_POST['shuirong'][$i])) continue;
				$arr[] = array(
					'id'			=> $_POST['shuirongId'][$i],
					'cengCnt'		=> $_POST['cengCnt'][$i],
					'shuirong'		=> $_POST['shuirong'][$i],
					'minCntTongzi'		=> $_POST['minCntTongzi'][$i],
					'maxCntTongzi'		=> $_POST['maxCntTongzi'][$i],
					'shuirong'		=> $_POST['shuirong'][$i],
					'kind'			=> $_POST['kind'][$i],
				);
		}

		for ($i=0;$i<count($_POST['gxName']);$i++){
			if(empty($_POST['gxName'][$i]) || empty($_POST['price'][$i])) continue;
				$rsGx[] = array(
					'id'			=> $_POST['rsgxId'][$i],
					'gxId'		=> $_POST['gxName'][$i],
					'price'		=> $_POST['price'][$i],
				);
		}

		$row = array(
					'id'			=> $_POST['id'],
					'vatCode'		=> $_POST['vatCode'],
				    'cntTongzi'		=> $_POST['cntTongzi'],
					'minKg'			=> $_POST['minKg'],
					'maxKg'			=> $_POST['maxKg'],
	                'minYubi'		=> $_POST['minYubi'],
	                'maxYubi'		=> $_POST['maxYubi'],
	                'shuiRong'		=> $_POST['shuiRong'],
	                'shuiRong1'		=> $_POST['shuiRong1'],
	                'orderLine'     => $_POST['orderLine'],
	                'memo'			=> $_POST['memo'],
					'Shuirongs'		=> $arr,
					'RsgxPrice'		=> $rsGx
		);
		// dump($row);exit;
		$id = $this->_modelExample->save($row);
		if($id) redirect($this->_url('Right'));
		else die('保存失败!');
	}
	/**
	 * ps ：排计划时根据所选染缸得到染缸的层数作为选项返回
	 * Time：2015/11/04 10:18:02
	 * @author Wuyou
	 * @param _GET
	 * @return json
	*/
	function actionGetCengOption(){
		// dump($_GET);exit;
		$vatId = $_GET['vatId'];
		$Shuirongs = $this->_modelShuirong->findAll(array('vatId'=>$vatId));
		// dump($Shuirongs);exit;
		echo json_encode($Shuirongs);
		exit;
	}
}
?>