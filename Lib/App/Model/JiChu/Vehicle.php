<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_JiChu_Vehicle extends TMIS_TableDataGateway {
	var $tableName = 'jichu_vehicle';
	var $primaryKey = 'id';
	var $primaryName = 'carCode';
}
?>