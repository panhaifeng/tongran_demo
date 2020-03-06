<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Acm_User extends TMIS_TableDataGateway {
	var $tableName = 'acm_userdb';
	var $primaryKey = 'id';
	var $primaryName = 'realName';
	var $manyToMany = array(		
		array (
			'tableClass' => 'Model_Acm_Role' ,			
			'mappingName' => 'roles',
			'joinTable' => 'acm_user2role',
			'foreignKey' => 'userId',
			'assocForeignKey' => 'roleId'
		),
		array (
			'tableClass' => 'Model_JiChu_Department' ,
			'mappingName' => 'deps',
			'joinTable' => 'acm_user2dep',
			'foreignKey' => 'userId',
			'assocForeignKey' => 'depId'
		),
		array (
			'tableClass' => 'Model_JiChu_Ware' ,
			'mappingName' => 'Ware',
			'joinTable' => 'acm_user2ware',
			'foreignKey' => 'userId',
			'assocForeignKey' => 'wareId'
		)
	);

	function getRoles($userId) {
		//echo $userId;exit;
		$arr = $this->find($userId);
		return $arr[roles];
	}
}
?>