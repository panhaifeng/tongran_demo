<?php
//染缸档案
load_class('TMIS_TableDataGateway');
class Model_JiChu_Vat extends TMIS_TableDataGateway {
	var $tableName = 'jichu_vat';
	var $primaryKey = 'id';
	var $primaryName = 'vatCode';

	var $hasMany = array(
		array(
			'tableClass' => 'Model_JiChu_Vat2shuirong',
			'foreignKey' => 'vatId',
			'mappingName' => 'Shuirongs'
		),
		array(
			'tableClass' => 'Model_JiChu_Vat2GxPrice',
			'foreignKey' => 'vatId',
			'mappingName' => 'RsgxPrice'
		)
	);
	//排计划时根据输入的筒子数取出装筒数大于或=计划筒子数的最前两个染缸
	//以json格式返回
	function getVatOption($planTongzi) {		
		$arr = $this->findAll("cntTongzi>='$planTongzi'",'cntTongzi asc',2);
		//$dbo=FLEA::getDBO(false);
		//dump($dbo->log);exit;
		//dump($arr);
		return $arr;
	}
	//排计划时根据输入的筒子数取出装筒数在最大筒子和最小筒子数范围内的最小水溶量的染缸
	//若水溶量相同，则取缸的水溶量小的那个缸
	//以json格式返回
	function getVatOptionNew($planTongzi) {
		$sql = "SELECT b.*,a.id as vat2shuirongId
			FROM jichu_vat2shuirong a 
			LEFT JOIN jichu_vat b ON a.vatId=b.id 
			WHERE {$planTongzi}>=a.minCntTongzi 
			AND {$planTongzi}<=a.maxCntTongzi 
			GROUP BY b.id
			ORDER BY b.shuiRong ASC,b.cntTongzi ASC,a.id desc
			";
		$temp = $this->findBySql($sql);
		// dump($sql);exit();
		return $temp;
	}
}
?>