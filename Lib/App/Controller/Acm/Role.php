<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Acm_Role extends Tmis_Controller {
	var $_modelRole;
	var $funcId = 22;
	function Controller_Acm_Role() {
		$this->_modelRole = FLEA::getSingleton('Model_Acm_Role');				
	}
	
	
	function actionRight() {
		$this->authCheck($this->funcId);
		if (isset($_POST[key])&&$_POST[key]!="") $condition = "roleName like '%$_POST[key]%'";
		FLEA::loadClass('TMIS_Pager');
		$pager = new TMIS_Pager($this->_modelRole,$condition,'roleName');
		$rowSet = $pager->findAll();
		$arrFieldInfo = array(
			"id"=>"编号",
			"roleName"=>"角色名",
			"ass" =>"分配权限"
		);
		$arr_edit_info = array(			
			"edit" =>"修改",
			"remove" =>"删除"
		);
		if (count($rowSet)>0) {
			foreach($rowSet as &$row) {
				$row[ass] = "<a href='?controller=Acm_Role&action=assignFunc&id=$row[id]'>分配权限</a>";
			}
		}
		$smarty = & $this->_getView();
		$smarty->assign("title","角色管理");
		$smarty->assign('pk','id');	
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign("arr_field_info",$arrFieldInfo);
		$smarty->assign("arr_field_value",$rowSet);
		//$smarty->assign('search_display', 'none');
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'])));
		$smarty->display("TableList.tpl");
		//$smarty->display("Acm/RoleList.tpl");
	}
	function actionAdd() {
		$this->_edit(array());
	}
	function actionEdit() {
		$aRole = $this->_modelRole->find($_GET[id]);
		$this->_edit($aRole);
	}
	function actionSave() {
		$this->_modelRole->save($_POST);
		redirect($this->_url('right'));
	}
	function actionRemove() {
		$this->_modelRole->removeByPkv($_GET[id]);
		redirect($this->_url('right'));
	}
	function _edit($arr) {
		$this->authCheck($this->funcId);
		$smarty = $this->_getView();
		$smarty->assign('aRole',$arr);
		$smarty->display('Acm/RoleEdit.tpl');
	}	
	
	function actionAssignFunc() {
		//为角色分配权限
		$this->authCheck($this->funcId);
		$aRole = $this->_modelRole->find($_GET[id]);
		$smarty = $this->_getView();
		$smarty->assign("aRole",$aRole);
		$smarty->display("Acm/AssignFunc.tpl");
	}
	
	/**
	*从关联表中删除指定的关联纪录	
	*/
	function actionRemoveAssign() {
		#取得关联对象
		$link = $this->_modelRole->getLink('funcs');
		#生成sql语句
		$sql = "delete from {$link->joinTable} 
			where {$link->foreignKey}='{$_GET[$link->foreignKey]}'
			and {$link->assocForeignKey} = '{$_GET[$link->assocForeignKey]}'";
		//echo $sql;exit;
		if (!$link->dbo->execute($sql)) {
			js_alert('','',$this->_getBack());
		}
		redirect($this->_url('assignfunc',array('id'=>$_GET[roleId])));
		#执行sql语句
	}
	
	/**
	*保存分配结果
	*/
	function actionSaveAssign() {
		//check the existence of the $_POST[funcId];
		$modelFunc = FLEA::getSingleton('Model_Acm_Func');
		$aFunc = $modelFunc->find($_POST[funcId]);
		
		if (!$aFunc) {
			js_alert('权限不存在!请核实后重新输入!', 
				'', 
				$this->_url('assignfunc',array('id'=>$_POST[roleId]))
			);			
		}
		
		//if the parentId have been assigned, then cancel
		if ($modelFunc->isAssigned($_POST[funcId],$_POST[roleId])) {
			js_alert('父权限已经被分配过!您不需要再进行分配!', 
				'', 
				$this->_url('assignfunc',array('id'=>$_POST[roleId]))
			);
		}		
		
		//begin assign 1,get the funcs that were assigned befor ,then merge with new func
		$aRole = $this->_modelRole->find($_POST[roleId]);
		
		$arr = count($aRole[funcs])>0 ? array_col_values($aRole[funcs],'id') : array();		
		$arr = array_unique(array_merge($arr,array($_POST[funcId])));
		//begin save
		$link = & $this->_modelRole->getLink('funcs');
		$link->saveAssocData($arr,$_POST[roleId]);
		
		/*$str = "insert into  {$link->joinTable} (
			{$link->foreignKey},{$link->assocForeignKey}
			) values(
			'$_POST[roleId]','$_POST[funcId]'
		)";
		$this->_modelRole->execute($str);
		*/
		redirect($this->_url('assignfunc',array('id'=>$_POST[roleId])));
	}
}
?>