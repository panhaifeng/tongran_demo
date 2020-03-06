<?php
class TMIS_Controller extends FLEA_Controller_Action {
/**
 代表模块代码的变量
 默认为0,表示不需要进行权限判断
 */
	var $funcId=0;

	//显示左右分割的iframe框架
	function actionIndex() {
		$smarty = & $this->_getView();
		$smarty->assign('arr_left_list', $this->arrLeftHref);
		//$smarty->assign('title', $this->rightCaption);
		$smarty->assign('caption', $this->leftCaption);
		$smarty->assign('controller', $this->_controllerName);
		$smarty->assign('action', 'right');
		$smarty->display('MainContent.tpl');
	}

	#根据主键删除,并返回到action=right
	function actionRemove() {
		if ($this->_modelExample->removeByPkv($_GET[id])) redirect($this->_url("right"));
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
	 $funcId = 0 表示只检查是否登陆
	 $funcId = -1 表示以当前的controller和action为基础匹配acm_funcdb中的记录,
	 需要进行数据升级,ALTER TABLE `acm_funcdb` ADD `controller` VARCHAR( 100 ) NOT NULL COMMENT '控制器',ADD `action` VARCHAR( 100 ) NOT NULL COMMENT '动作';
	 同时对controller_acm_func进行适当修改，可以进行controller和action的定义
	 */
	function authCheck($funcId = 0,$isReturn=false) {
		$warning = "<div align=center style='font-size:12px; color=#cc0000'><img src='Resource/Image/System/s_warn.png'>&nbsp&nbsp您没有登录或没有当前模块访问权限!</img></div>";
		if ($funcId === 0) {//检查是否登录
			if($_SESSION['USERID']>0) return true;
			if ($isReturn) return false;
			$_SESSION['TARGETURL'] = $_SERVER[REQUEST_URI];
			if ($isReturn) return false;
			redirect(url('Login','logout'));
			exit;
		}

		//处理$funcId>0的情况
		if(empty($_SESSION['USERID'])) {//没有登录,显示登录界面
		//保存当前地址到session
			$_SESSION['TARGETURL'] = $_SERVER[REQUEST_URI];
			if ($isReturn) return false;
			redirect(url('Login','logout'));
			exit;
		}

		$mUser = FLEA::getSingleton('Model_Acm_User');
		$user = $mUser->find($_SESSION[USERID]);
		if($user[userName]=='admin') {//管理员直接跳过
			return true;
		}

		$mFunc = FLEA::getSingleton('Model_Acm_Func');
		if ($funcId == -1) {//从Acm_FuncDb中搜索controller和action匹配的记录
			$sql = "select count(*) cnt,id from acm_funcdb where LOWER(controller)='".strtolower($_GET['controller'])."' and LOWER(action)='".strtolower($_GET['action'])."'";
			$r = mysql_fetch_assoc(mysql_query($sql));
			if($r['cnt']==0) {
				if(!$isReturn) die('没有定义该功能模块！请在模块定义中定义该功能！点击自动增加 [增加]');
				return false;
			}
			$funcId=$r['id'];
		}

		$userRoles = $mUser->getRoles($_SESSION[USERID]);
		if(count($userRoles)==0) {
			if (!$isReturn) die($warning);
			return false;
		}
		//取得$funcId的path,依次判断path上每个节点
		$funcRoles = $mFunc->getRoles($funcId);
		if (empty($funcRoles)) $funcRoles=array();
		$func = $mFunc->find(array('id'=>$funcId));
		$path = $mFunc->getPath($func);
		$pathRoles = array();
		if (count($path)>0) {
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
	function showLogin() {
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
				if ($v=='noRight') {
					$arrJs[] = 'NoRight.js';
				}
			}
		//dump($arrJs);
		return array(
		jsFile=>$arrJs,
		cssFile=>$arrCss
		);
	}

	//可编辑的grid进行修改动作中，控件失去焦点时通过ajax调用.
	//传入id,fieldName,value3个值
	//返回json数据对象{success:true,msg:'成功'}
	//注意$this->_modelExample必须为相应的model.
	function actionAjaxEdit() {
		$row[id] = $_GET[id];
		$row[$_GET[fieldName]] = $_GET[value];
		//dump($this->_modelExample);exit;
		$this->_modelExample->update($row);
		//$dbo =& FLEA::getDBO(false);dump($dbo);exit;
		if ($this->_modelExample->update($row)) {
		//$dbo = FLEA::getDBO(false);dump($dbo->log);exit;
			echo "{successful:true,msg:'成功!'}";
		} else {
			echo "{successful:false,msg:'出错!'}";
		}
		exit;
	}

	//将普通显示的字段以可编辑的形式显示出来
	//type=text,以"无"显示没有
	//type=int,以"0"显示没有
	//type='money',以"0.00"显示没有
	function makeEditable(& $arr,$fieldName,$type='text',$action='') {
		//$action=$action==''?0:$action;
		if($type=='text') $zero = '无';
		elseif($type=='int') {
			$zero = '0';
			$arr[$fieldName] = round($arr[$fieldName]);
		}
		elseif($type=='money') {
			$zero = '0.00';
			$arr[$fieldName] = number_format($arr[$fieldName], 2, '.', '');
		}
		$title = $arr[$fieldName]=='' ? $zero : $arr[$fieldName] ;
		$arr[$fieldName] = '<span onclick="gridEdit(this,\''.$fieldName.'\','.$arr[id].',\''.$action.'\')" title="点击修改" onmouseover="this.style.cssText = \'background: #278296;\'" onmouseout="this.style.cssText = \'background: yellow;\'" style="background:yellow;">'.$title.'</span>';
	}

	function getEditHtml($pkv,$action='Edit') {
		if(!is_array($pkv)) return "<a href='".$this->_url($action,array(id=>$pkv))."' title='修改'><img src='Resource/Image/System/edit.gif' style='margin:0px;'></a>";
		//foreach ($pkv as $key=>&$v){
		return "<a href='".$this->_url($action,$pkv)."' title='修改'><img src='Resource/Image/System/edit.gif' style='margin:0px;'></a>";
	//}

	}

	//返回"删除"操作按钮
	function getRemoveHtml($pkv,$action='Remove') {
		if(!is_array($pkv)) return "<a href='".$this->_url($action,array(id=>$pkv))."' onclick='return confirm(\"您确认要删除吗?\")' title='删除'><img src='Resource/Image/System/del.gif' style='margin:0px;'></a>";
		return "<a href='".$this->_url($action,$pkv)."' onclick='return confirm(\"您确认要删除吗?\")' title='删除'><img src='Resource/Image/System/del.gif' style='margin:0px;'></a>";
	}


	#清空搜索条件
	function clearCondition() {
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
	}


	#对rowset的某几个字段进行合计,
	#firstField表示需要显示为"合计"字样的字段
	#返回合计行的数据
	function getHeji(&$rowset,$arrField,$firstField='') {
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

	//得到本期的起始日期和截止日期
	function getBenqi(){
	    $day=FLEA::getAppInf('day');
	    if(date('d')>=$day+1){
		$arr['dateFrom']=date('Y-m-d',mktime(0,0,0,date('m'),$day+1,date('Y')));
		$arr['dateTo']=date('Y-m-d',mktime(0,0,0,date('m')+1,$day,date('Y')));
	    }else{
		$arr['dateFrom']=date('Y-m-d',mktime(0,0,0,date('m')-1,$day+1,date('Y')));
		$arr['dateTo']=date('Y-m-d',mktime(0,0,0,date('m'),$day,date('Y')));
	    }
	    return $arr;
	}
}
?>
