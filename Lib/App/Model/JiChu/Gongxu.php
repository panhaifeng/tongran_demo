<?php
/*生产流转卡的打印*/
load_class('TMIS_TableDataGateway');
class Model_JiChu_Gongxu extends TMIS_TableDataGateway {
	var $tableName = 'jichu_gongxu';
	var $primaryKey = 'id';
	var $primaryName = 'gongxuName';
}
?>