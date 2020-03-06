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
		)
	);

	function getRoles($userId) {
		//echo $userId;exit;
		$arr = $this->find($userId);
		return $arr[roles];
	}
}
?>