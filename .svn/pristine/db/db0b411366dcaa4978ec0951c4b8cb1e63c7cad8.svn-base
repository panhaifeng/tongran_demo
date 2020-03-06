<?php
load_class('TMIS_TableDataGateway');
class Model_SongTong_Gang2StCar  extends TMIS_TableDataGateway {
	var $tableName = 'dye_gang2stcar';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Plan_Dye_Gang',
			'foreignKey' => 'gangId',
			'mappingName' => 'Gang'
		),
		array(
			'tableClass' => 'Model_JiChu_StCar',
			'foreignKey' => 'stcarId',
			'mappingName' => 'Car'
		)
	);
	var $hasMany = array(
		//松筒产量
		array(
			'tableClass' => 'Model_SongTong_Chanliang',
			'foreignKey' => 'gang2stcarId',
			'mappingName' => 'Chanliang',
			'enabled' => false
		)		
	);
	
	//得到某个计划下(某个车台上的某个缸号)的产量
	function getChanliang($pkv) {
		$this->enableLink('Chanliang');
		$r = array(
			cntKg => 0,
			cntTongzhi => 0
		);
		$arr = $this->find($pkv);	
		
		if(count($arr[Chanliang])>0) foreach($arr[Chanliang] as $v) {
			$r[cntKg] += $v[cntKg];
			$r[cntTongzhi] += $v[cntTongzhi];
		}
		return $r;
	}	
}
?>