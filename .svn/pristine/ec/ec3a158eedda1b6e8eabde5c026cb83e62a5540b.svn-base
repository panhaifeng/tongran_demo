<?php
FLEA::loadClass('TMIS_Controller');
class Controller_JiChu_Employ extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 27;
	function Controller_JiChu_Employ() {
		//if(!$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_JiChu_Employ');
		$this->imgPath ='Upload/Employ/';
	}

	#列表
	/*
	function actionIndex() {
        $smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$smarty->assign('caption', "员工资料");
		$smarty->assign('controller', 'JiChu_Employ');
		$smarty->assign('action', 'right');
		$smarty->display('MainContent.tpl');
	}*/

	function actionRight() {
		$this->authCheck($this->funcId);
        $table = $this->_modelExample->tableName;

		#TMIS_Pager继承自FLEA_Helper_Pager,加入了getPages()方法，获得分页的显示
		#注意,
		#--1,必须将TMIS/Pager.php放置在App目录中,App的位置Index.php有定义 App_Dir
		#--2,这里不能使用FLEA::getSingleton('TMIS_Pager');因为需要参数
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		$pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();

		/*对$rowset进行处理，比如对sex=0输出为"男"*/
		foreach ($rowset as & $value) {
			$value[sex]=($value[sex]==0?"男":"女");
			$temp = array_pop($value);
			$value[depName]=$temp[depName];
		}

		/*FLEA_Helper_Pager::findAll([string $fields = '*'])
		与 FLEA_Db_TableDataGateway::findAll( [mixed $conditions = null],
		[string $sort = null], [mixed $limit = null], [string $fields = '*'] )
		参数不太一样，建议格式进行调整，统一成用字符串编码进
		*/

		/**下面两句可以用来跟踪所有执行过的sql语句*/
		#$dbo=& get_dbo(false);
		#dump($dbo->log);

		/**
		/*利用Smarty显示
		**/
		#初始化smarty对象,根据config.inc.php的设置进行初始化
		$smarty = & $this->_getView();

		#对变量赋值
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('title','员工信息');
		$smarty->assign('controller', 'JiChu_Employ');

		#对表头进行赋值
		$arr_field_info = array(
			"depName" =>"部门",
			"employCode" =>"员工代码",
			"employName" =>"姓名",
			'workerCode'=>'工号',
			"sex" =>"性别",
			"mobile" =>"电话",
			"address" =>"地址",
			"dateEnter" =>"上岗日期",
			"dateLeave" =>"离职日期"
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

		#设置主键字段，在列表中不显示，并在url_eidt和url_del中加在get参数后,
		$smarty->assign('pk', $pk);

		$smarty->assign('arr_condition',$arr);

		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'])));

		#开始显示
		$smarty->display('TableList.tpl');
	}



	private function _editJiChuEmploy($Arr) {
		$this->authCheck($this->funcId);
		$smarty = & $this->_getView();
		$smarty->assign("aEmploy",$Arr);

		#通过判断isset($_GET[$pk]) 判断是否存在$pk参数，
		#在区分编辑界面是用来增加还是用来修改时起作用,在增加时primary_key赋值为空
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");

		//die($_GET[$pk]);
		$smarty->assign("pk",$primary_key);
		$smarty->assign('imgPath',$this->imgPath);
		$smarty->display('JiChu/EmployEdit.tpl');
	}
	#增加界面
	function actionAdd() {
		$this->_editJiChuEmploy(array());
	}
	#保存
	function actionSave() {
		//dump($_FILES);
        $path=$this->getPath('imageUrl');
		//echo($path);exit;
		if($path!="")
		{
          if(move_uploaded_file($_FILES['imageUrl']['tmp_name'],$path))
		  {
              $arrary=array(
				  'employCode'=>$_POST['employCode'],
				  'employName'=>$_POST['employName'],
				  'sex'=>$_POST['sex'],
				  'DepId'=>$_POST['DepId'],
				  'mobile'=>$_POST['mobile'],
				  'workerCode'=>$_POST['workerCode'],
				  'address'=>$_POST['address'],
				  'dateEnter'=>$_POST['dateEnter'],
				  'IDCard'=>$_POST['IDCard'],
				  'imageUrl'=>substr($path,strrpos($path,'\\')+1),
				  'id'=>$_POST['id']
				  );
			//dump($arrary);exit;
			$this->_modelExample->save($arrary);
            redirect(url("JiChu_Employ","Right"));
		  }
		  else
	      {
             echo ("<script>alert('保存失败');history.go(-1)</script>");exit;
	      }
		}
		else
		{
        $this->_modelExample->save($_POST);
		}
		redirect(url("JiChu_Employ","Right"));
	}

	#取得图片绝对路径
    function  getPath($fileid) {
	//允许的文件扩展名
       $path=realpath($this->imgPath).'\\s';
      // echo($path);exit;
        $allowed_types = array('jpg', 'gif', 'png');
        $filename = $_FILES[$fileid]['name'];
        //正则表达式匹配出上传文件的扩展名
        preg_match('|\.(\w+)$|', $filename, $ext);
        //print_r($ext);
        //转化成小写
        $ext = strtolower($ext[1]);
		//echo($ext);
        //判断是否在被允许的扩展名里
        if($filename!="")
        {
           if(!in_array($ext, $allowed_types)){
             // die('不被允许的文件类型');
             echo("<script>alert('不被允许的文件类型');history.go(-1)</script>");exit;
           }
           else
           {
              if((int)$_FILES[$fileid]['size']>500000)
                 {
                     echo("<script>alert('不被大于500KB');history.go(-1)</script>");exit;
                 }
              else {
				    $path.=date('YmdHis');
                }
				return $path.'.'.$ext;
				exit;
           }
        }

        return "";
    }
	#修改界面
	function actionEdit() {
		$pk=$this->_modelExample->primaryKey;
		$aEmploy=$this->_modelExample->find($_GET[$pk]);
		$this->_editJiChuEmploy($aEmploy);
	}
	function actionRemove() {
		$pk=$this->_modelExample->primaryKey;
		$this->_modelExample->removeByPkv($_GET[$pk]);
		redirect(url("JiChu_Employ","Right"));
	}
	#判断工号是否重复
	function actionGetJsonByCode(){
		$str="select count(*) as cnt from jichu_employ where workerCode='{$_GET['workerCode']}'";
		if($_GET['id']!='')$str.=" and id<>'{$_GET['id']}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		$re['id']=$_GET['id'];
		echo json_encode($re);exit;
	}
}
?>