<?php
class TMIS_Controller extends FLEA_Controller_Action {
	/**
	代表模块代码的变量
	默认为0,表示不需要进行权限判断
	*/
	var $funcId=0;

	//显示左右分割的iframe框架
	function actionIndex() {
		/*
		$smarty = & $this->_getView();
		$smarty->assign('arr_left_list', $this->arrLeftHref);
		//$smarty->assign('title', $this->rightCaption);
		$smarty->assign('caption', $this->leftCaption);
		$smarty->assign('controller', $this->_controllerName);
		$smarty->assign('action', 'right');
		$smarty->display('MainContent.tpl');*/
	}

	#根据主键删除,并返回到action=right
	function actionRemove() {
		//if ($this->_modelExample->removeByPkv($_GET[id])) redirect($this->_url("right"));
		if ($this->_modelExample->removeByPkv($_GET[id])) redirect($_SERVER['HTTP_REFERER']);
		else js_alert('出错，不允许删除!',"window.history.go(-1)");
	}

	//新增
	function actionAdd() {
		$this->_edit(array());
	}
	//修改
	function actionEdit() {
		$aRow=$this->_modelExample->find($_GET[id]);
		$this->_edit($aRow);
	}
	//保存
	function actionSave() {
		$id = $this->_modelExample->save($_POST);
		redirect($this->_url("Right"));
	}

	/**
	*get the arr data from $pager(TMIS_pager),  and conver to the json data which can be used in extjs datgrid
	*/
	function getJsonDataOfExt(& $pager) {
		$rowset = $pager->findAll();
		return '{"totalCount": ' . $pager->totalCount . ',"rows": ' . json_encode($rowset) . '}';
	}

	/**
	*根据纪录总数和纪录数组构造Ext中的records数据格式
	*/
	function buildExtRecords($cnt,& $arr) {
		return '{"totalCount": ' . $cnt . ',"rows": ' . json_encode($arr) . '}';
	}

	/**
	判断当前用户是否允许访问$this->funcId
	$isReturn=false 表示显示没有权限的提示,否则表示只返回true或者false;

	$funcId = -1 表示只检查是否登陆
	*/
	function authCheck($funcId = null,$isReturn=false) {
		//echo($funcId); exit;
		if ($funcId == null) {
			return true; exit;
		}

		$warning = "<div align=center style='font-size:12px; color=#cc0000'><img src='Resource/Image/System/s_warn.png'>&nbsp&nbsp您没有当前模块访问权限!</img></div>";

		$mUser = FLEA::getSingleton('Model_Acm_User');
		if(empty($_SESSION['USERID'])) {
			//保存当前地址到session
			//echo $_SERVER[REQUEST_URI];exit;
			$_SESSION['TARGETURL'] = $_SERVER[REQUEST_URI];
			if ($isReturn) return false;
			//dump($_SESSION);exit;
			//假如没有登陆，显示登陆界面

			redirect(url('Login','logout'));
			exit;
		}

		if ($funcId == -1) {
			return true; exit;
		}
		//如果是admin用户,始终认为有权限
		$user = $mUser->find($_SESSION['USERID']);
		if($user['userName']=='admin') {
			return true;
		}

		$mFunc = FLEA::getSingleton('Model_Acm_Func');
		$userRoles = $mUser->getRoles($_SESSION['USERID']);
		if(count($userRoles)==0) {
			if (!$isReturn) die($warning);
			return false;
		}
		//取得$funcId的path,依次判断path上每个节点
		$funcRoles = $mFunc->getRoles($funcId);
		if (empty($funcRoles)) $funcRoles=array();
		$path = $mFunc->getPath($mFunc->find($funcId));
		$pathRoles = array();
		if (count($path)>0){
			foreach ($path as &$value) {
				if (is_array($value[roles])) $pathRoles=array_merge($pathRoles,$value[roles]);
			}
		}
		$funcRoles = array_merge($funcRoles,$pathRoles);
		if(count($funcRoles)==0) {

			if (!$isReturn) die($warning);
			return false;
		}

		//判断各个role是否具有对当前funcId的访问权限.
		$t = array_intersect(array_col_values($userRoles,'id'),array_col_values($funcRoles,'id'));
		if(count($t)==0) {
			if (!$isReturn) die($warning);
			return false;
		}
		return true;
	}



	//显示登陆界面
	function showLogin(){
		$smarty = & $this->_getView();
		$smarty->assign("aProduct",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		$smarty->assign("pk",$primary_key);
		$smarty->display('JiChu/ProductEdit.tpl');
	}

	//根据传入的js_func数组,得到需要载入的js文件和css文件列表
	function makeArrayJsCss($js_func=null) {
		$arrCss = array(
			'Main.css',
			'page.css'
		);
		$arrJs = array(
			'jquery.js',
			'jquery.query.js',//可以取得url中的get参数
			'common.js'
		);
		if(is_string($js_func)) $arr_js_func[] = $js_func;
		else $arr_js_func = & $js_func;
		if (is_array($arr_js_func)) foreach($arr_js_func as & $v) {
			if ($v=='tip') {
				$arrJs[] = 'tip.js';
			}
			if ($v=='calendar') {
				$arrJs[] = 'calendar.js';
			}
			if ($v=='grid') {
				$arrJs[] = 'TmisGrid.js';
			}
			if ($v=='suggest') {
				$arrJs[] = 'TmisSuggest.js';
			}
			if ($v=='thickbox') {
				//$arrJs[] = 'thickbox/thickbox-compressed.js';
				$arrJs[] = 'thickbox/thickbox.js';
				//$arrJs[] = 'jquery.form.js';
				$arrCss[] = 'thickbox.css';
			}
		}
		//dump($arrJs);
		return array(
			'jsFile'=>$arrJs,
			'cssFile'=>$arrCss
		);
	}

	//可编辑的grid进行修改动作中，控件失去焦点时通过ajax调用.
	//传入id,fieldName,value3个值
	//返回json数据对象{success:true,msg:'成功'}
	//注意$this->_modelExample必须为相应的model.
	function actionAjaxEdit() {
		$row[id] = $_GET[id];
		$row[$_GET[fieldName]] = $_GET[value];
		if ($this->_modelExample->update($row)) {
			echo "{successful:true,msg:'成功!'}";
		} else {
			echo "{successful:false,msg:'出错!'}";
		}
		exit;
	}

	//将普通显示的字段以可编辑的形式显示出来
	function makeEditable(& $arr,$fieldName) {
		$title = $arr[$fieldName]=='' ? '无' : $arr[$fieldName] ;
		$arr[$fieldName] = '<span onclick="gridEdit(this,\''.$fieldName.'\','.$arr[id].')" title="点击修改" onmouseover="this.style.cssText = \'background: #278296;\'" onmouseout="this.style.cssText = \'\'">'.$title.'</span>';
	}

	//返回"编辑"操作按钮
	function getEditHtml($pkv) {
		$str = "<a href='".$this->_url('Edit',array(id=>$pkv))."'>修改</a>";
		return $str;
	}

	//返回"删除"操作按钮
	function getRemoveHtml($pkv) {
		$str = "<a href='".$this->_url('Remove',array(id=>$pkv))."' onclick='return confirm(\"您确认要删除吗?\")'>删除</a>";
		return $str;
	}

	#清空搜索条件
	function clearCondition(){
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
	}


	/*
		应用对象:	审核系统.
		函数功能:	是否允许审核.
		Returns:	bool类型(false, true).
		CreatDate:	2008.11.07 by eqinfo.archer
		参数:	tableName	表名
				gongxu		上一级审核工序
				pkv			主健
	*/
	function checkAudit($tableName, $gongxu, $pkv){
		if ($gongxu == 'tradeAudit') {	//如果是第一级审核(工艺..),则判断生产是否审核过.
			$str = "select manuAudit from $tableName where id = $pkv";
			$re=mysql_fetch_assoc(mysql_query($str));
			if ($re['manuAudit'] >0){
				js_alert('生产已经审核，不允许审核!(此单可能是库存或外购)','',$_SERVER['HTTP_REFERER']);
				return false;
			}
		}elseif($gongxu == 'manuAudit'){	//如果是最终审核, 则只要判断生产审核是否通过.
			$str = "select $gongxu from $tableName where id = $pkv";
			$re=mysql_fetch_assoc(mysql_query($str));
			if ($re[$gongxu] == 0) {
				js_alert('上一级审核未通过，不允许审核!','',$_SERVER['HTTP_REFERER']);
				return false;
			}
		}else{	//其它的中间审核,既要判断上级审核是否通过, 又要判断生产审核是否通过.
			$str = "select $gongxu, manuAudit from $tableName where id = $pkv";
			$re=mysql_fetch_assoc(mysql_query($str));
			if ($re[$gongxu] == 0) {
				js_alert('上一级审核未通过，不允许审核!','',$_SERVER['HTTP_REFERER']);
				return false;
			}elseif ($re['manuAudit'] > 0){
				js_alert('生产已经审核，不允许审核!(此单可能是库存或外购)','',$_SERVER['HTTP_REFERER']);
				return false;
			}
		}
		return true;
	}

	/*
		应用对象:	审核系统.
		函数功能:	是否允许撤消审核.
		Returns:	bool类型(false, true).
		CreatDate:	2008.11.07 by eqinfo.archer
		参数:	tableName	表名
				gongxu		下一级审核工序
				pkv			主健
	*/
	function checkResetAudit($tableName, $gongxu, $pkv){
		$str = "select $gongxu from $tableName where id = $pkv";
		//echo($str); exit;
		$re=mysql_fetch_assoc(mysql_query($str));
		if ($re[$gongxu]>0){
			js_alert('下一级审核已通过，不允许撤消!','',$_SERVER['HTTP_REFERER']);
			return false;
		}
		return true;
	}

	#对rowset的某几个字段进行合计,
	#firstField表示需要显示为"合计"字样的字段
	#返回合计行的数据
	function getHeji(&$rowset,$arrField,$firstField=''){
		$str = "\$newRow[\"" . join('"]["',explode('.',$firstField)) . '"]="<b>合计</b>";';
		//echo $str;exit;
		//eval('$newRow'.$str . '= "<b>合计</b>"');
		eval($str);
		//dump($newRow);exit;
		//$newRow[$firstField] = "<b>合计</b>";
		foreach($rowset as & $v) {
			foreach($arrField as & $f) {
				$newRow[$f] += $v[$f];
				$newRow[$f] = $newRow[$f];
			}
		}
		//dump($newRow); exit;
		return $newRow;
	}

	function getHeji1(&$rowset,$arrField,$firstField=''){//打印时不能够解释<b></b>，因而增加了该方法
		$str = "\$newRow[\"" . join('"]["',explode('.',$firstField)) . '"]="合计";';
		//echo $str;exit;
		//eval('$newRow'.$str . '= "<b>合计</b>"');
		eval($str);
		//dump($newRow);exit;
		//$newRow[$firstField] = "<b>合计</b>";
		foreach($rowset as & $v) {
			foreach($arrField as & $f) {
				$newRow[$f] += $v[$f];
				$newRow[$f] = $newRow[$f];
			}
		}
		//dump($newRow); exit;
		return $newRow;
	}

	function getServTel(){
		$servTel = FLEA::getCache('Service.Tel',-1);
		if(!$servTel){
			require_once('Config/NewLogin_config.php');
			$servTel = $_login_config['servTel'];
		}
		return $servTel;
	}

	function getCompName(){
        // $sys = $this->getSysSet();
        $_compName = FLEA::getAppInf('compName');
        $compName = $sys['company_name'] ? $sys['company_name'] : $_compName;
        return $compName;
    }
}


?>
