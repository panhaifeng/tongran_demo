<?php
/*生产流转卡的打印*/
load_class('TMIS_TableDataGateway');
class Model_JiChu_Print extends TMIS_TableDataGateway {
	var $tableName = 'jichu_print';
	var $primaryKey = 'id';
	//var $primaryName = 'doctName';
}
?>