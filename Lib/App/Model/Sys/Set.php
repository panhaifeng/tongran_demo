<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_Sys_Set extends TMIS_TableDataGateway {
	var $tableName = 'sys_setup';
	var $primaryKey = 'id';
}
?>