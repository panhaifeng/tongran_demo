<?php
FLEA::loadClass('FLEA_Helper_Pager');
class TMIS_Pager extends FLEA_Helper_Pager {	
	function TMIS_Pager(& $source, $conditions = null, $sortby = null, $pageSize=0,$currentPage=-1) {
   	  if (empty($pageSize)) $pageSize = FLEA::getAppInf('pageSize');
	  //以get方式提交page,正常模式
	  if(intval($currentPage) < 0) $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : (
		  isset($_SESSION['SEARCH']['page'])? $_SESSION['SEARCH']['page'] : 0
	  );
	  if ($sortby==null) $sortby = 'id desc';
	  //dump($sortby);exit;
	  //$currentPage = isset($_POST[start]) ? (int)($_POST[start]/$pageSize) : 0;
	  
	  //在extjs中以$_POST[start],$_POST[limit],$_POST[sort],$_POST[dir]=asc||desc提交
	  //$currentPage = isset($_POST[start]) ? (int)($_POST[start]/$pageSize) : 0;
	  //下面为extjs使用时的语句，暂时去掉。
	  //$sortby = (isset($_POST[dir]) && isset($_POST[sort])) ? ("$_POST[sort] $_POST[dir]") : ($source->primaryKey . " desc");
   	  parent::FLEA_Helper_Pager($source, $currentPage, $pageSize, $conditions, $sortby);
	}   
   
	/*
	[Discuz!] (C)2001-2006 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms
	$RCSfile: global.func.php,v $
	$Revision: 1.83.2.7 $
	$Date: 2006/10/27 08:08:18 $   
	$num记录总数,
	$perpage每页记录数,
	$curpage当前页码，
	$mpurl跳转url，
	$maxpages允许查看最大页码。
	$page每屏允许显示的页数
	$pages 实际页数
	$offset 偏移数
	*/
	function getNavBar($mpurl) {
	   $multipage = '';
	   $num = $this->count;
	   $mpurl .= strpos($mpurl, '?') ? '&' : '?';
	   $curpage = $this->currentPage;
	   $perpage = $this->pageSize;
	   $maxpages = 0;	   
	   if($num > $perpage) {
		   $page = 8; #每屏允许显示的页数
		   $offset = 2;#偏移量
		   $pages = $this->pageCount;
		   if($page > $pages) {//总页数不足每屏显示个数
			   $from = 1;
			   $to = $pages;
		   } else {//总页数多于每屏显示个数
			   $from = $curpage - $offset + 1;
			   $to = $from + $page - 1;
			   if($from < 1) {
				   $to = $curpage - $from + 1;
				   $from = 1;
				   if($to - $from < $page) {
					   $to = $page;
				   }
			   } elseif($to > $pages) {
				   $from = $pages - $page + 1;
				   $to = $pages;
			   }			   
		   }
		   $multipage = ($curpage > $offset && $pages > $page ? '<a class="p_redirect" href="'.$mpurl.'page='.$this->firstPage.'">|‹</a>' : '').
			   ($curpage > 0 ? '<a class="p_redirect" href="'.$mpurl.'page='.$this->prevPage.'">‹‹</a>' : '');
		   for($i = $from; $i <= $to; $i++) {
			   $multipage .= $i == $curpage + 1 ? '<a class="p_curpage">'.$i.'</a>' :
				   '<a href="'.$mpurl.'page='.($i-1).'" class="p_num">'.$i.'</a>';
		   }	
		   $multipage .= ($curpage+1 < $pages ? '<a class="p_redirect" href="'.$mpurl.'page='. $this->nextPage .'">››</a>' : '').
			   ($to < $pages ? '<a class="p_redirect" href="'.$mpurl.'page='. $this->lastPage .'">›|</a>' : '').
			   ($curpage+1 == $maxpages ? '<a class="p_redirect" href="misc.php?action=maxpages&pages='.$maxpages.'">›?</a>' : '').
			   ($pages > $page ? '<a class="p_pages" style="padding: 0px">
			   					<input class="p_input" type="text" name="custompage" 
								onKeyDown="if(event.keyCode==13) {window.location=\''.$mpurl.'page=\'+(this.value-1); return false;}"></a>' : '');	
		   $multipage = $multipage ? '<div class="p_bar"><a class="p_total"> '.$num.' </a><a class="p_pages"> '.$this->currentPageNumber.'/'.$this->pageCount.' </a>'.$multipage.'</div>' : '';
	   }
	   return $multipage;
	}

	//处理查询参数,在查询结果分页时需要用到，
	//arr = array('key'=>'value','key1'=>'value1');
	//key需要传递的变量名称，
	//value是需要传递的变量的值
	function getParamArrayBak($arr) {	
		$cnt = count($arr);		
		$arrRet = array();		
		//如果controller和session中的一致，不需要清空session,只需要取得相关搜索参数.
		//但是当popup供选择时(比如选择客户时)会发生不必要的更改。故需要判断action中是否有popup参数
		if ($_SESSION[SEARCH][curController]==$_GET[controller]||$_SERVER[REQUEST_METHOD]=='POST') {			
			if ($_SERVER[REQUEST_METHOD]=='POST') {
				//保存当前的controller,并清空session
				session_unregister('SEARCH');
				$_SESSION[SEARCH][curController]=$_GET[controller];
				foreach ($arr as $key=>$value) {
					//存入session
					if (isset($_POST[$key])) $_SESSION[SEARCH][$key] = $_POST[$key];				
				}			
			} else {
				//因为有需要根据arr_condition设置搜索项目，所以必须所有的$arr都设置值
				foreach ($arr as $key=>$value) {
					if (isset($_GET[$key]))	$_SESSION[SEARCH][$key] = $_GET[$key];
				}			
			}			
		} else {
			//保存当前的controller,并清空session
			session_unregister('SEARCH');
			$_SESSION[SEARCH][curController]=$_GET[controller];		
			foreach ($arr as $key=>$value) {
				if (isset($_GET[$key]))	$_SESSION[SEARCH][$key] = $_GET[$key];
			}				
		}
		foreach ($arr as $key=>$value) {
			$arrRet[$key] = !isset($_SESSION[SEARCH][$key]) ? trim(rawurldecode($value)) : trim($_SESSION[SEARCH][$key]);
				$arrRet[$key] = !isset($_SESSION[SEARCH][$key]) ? 
							(isset($_GET[$key]) ? $_GET[$key] : rawurldecode($value)) : 
							$_SESSION[SEARCH][$key];
		}		
		return $arrRet;
	}
	
	function getParamArray($arr) {	
		$cnt = count($arr);		
		$arrRet = array();
		///echo '传入参数';dump($arr);
		//echo 'post:';dump($_POST);
		//echo 'session';dump($_SESSION);
		
		//如果controller和session中的一致或者是弹出选择窗口，不需要清空session,只需要取得相关搜索参数.
		if (strtolower($_SESSION['SEARCH']['curController'])==strtolower($_GET['controller']) || 'popup'==strtolower($_GET['action'])) {
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				//更新所有的参数
				session_unregister('SEARCH');
				$_SESSION['SEARCH']['curController']=strtolower($_GET['controller']);
				$_SESSION['SEARCH']['curAction']=strtolower($_GET['action']);
				foreach ($arr as $key=>$value) {
					if (array_key_exists($key,$_POST)) $_SESSION['SEARCH'][$key] = $_POST[$key];				
				}				
			} else {//如果不是提交页面
				//如果action不一致,重置分页
				if(strtolower($_GET['action'])!=$_SESSION['SEARCH']['curAction']) {
					$_SESSION['SEARCH']['page'] =0;
					$_SESSION['SEARCH']['curAction'] = strtolower($_GET['action']);
				}

				//保存分页信息
				if(isset($_GET['page'])) $_SESSION['SEARCH']['page'] = (int)$_GET['page'];

				//因为有需要根据arr_condition设置搜索项目，所以必须所有的$arr都设置值				
				foreach ($arr as $key=>$value) {					
					if (isset($_GET[$key]))	$_SESSION['SEARCH'][$key] = $_GET[$key];
				}				
			}			
		} else {
			//如果controller和session中的不一致且不是弹出，保存当前的controller,并清空session			
			session_unregister('SEARCH');
			$_SESSION['SEARCH']['curController']=strtolower($_GET['controller']);
			$_SESSION['SEARCH']['curAction']=strtolower($_GET['action']);	
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				foreach ($arr as $key=>$value) {
					//echo $_POST[$key];exit;
					//存入session
					if (array_key_exists($key,$_POST)) $_SESSION['SEARCH'][$key] = $_POST[$key];				
				}				
			}
		}
		foreach ($arr as $key=>$value) {
				$arrRet[$key] = !isset($_SESSION['SEARCH'][$key]) ? 
							(isset($_GET[$key]) ? $_GET[$key] : rawurldecode($value)) : 
							$_SESSION['SEARCH'][$key];
		}
		return $arrRet;
	}
	
	#清空session中的搜索项目,
	function clearCondition(){
		session_unregister('SEARCH');
		$_SESSION[SEARCH][curController]=$_GET[controller];	
	}
	
	//除page外其他所有的参数形成queryString
	//paramArr为
	function getParamStr($paramArr){
		$controller = $_GET[controller];
		$action = $_GET[action];
		$ret = "controller=".$controller."&action=".$action;
		if (count($paramArr)>0) {
			foreach($paramArr as $key=>$value) {
				if ($value!='') $ret .= "&$key=".rawurlencode($value);
			}
		};
		return $ret;
	}
	
	//使用时注意初始话pager必须以sql语句作为第一个参数
	function findAllBySql($sql){
		/*FLEA::loadClass('TMIS_TableDataGateway');
		$count = TMIS_TableDataGateway::findCountBySql($sql);
		$dbo = FLEA::getDBO(false);
		$this->setDBO($dbo);
		$this->setCount($count);*/		
		return $this->findAll();
	}
}
?>