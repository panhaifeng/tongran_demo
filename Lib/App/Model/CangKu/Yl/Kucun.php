<?php
load_class('TMIS_Model_MonthReport');
class Model_Cangku_Yl_Kucun extends TMIS_Model_MonthReport {
	//var $initTable = 'view_yl_ruku';

	var $rukuTable = 'view_yl_ruku';
	var $chukuTable = 'view_yl_chuku';

	var $keyField = 'wareId';

	var $rukuDateField = 'rukuDate';
	var $chukuDateField = 'chukuDate';

	//var $initCntField = 'cnt';
	//var $initMoneyField ='cnt';
	var $rukuCntField = 'cnt';
	var $chukuCntField = 'cnt';

	var $rukuDanjiaField = 'danjia';
	var $chukuDanjiaField = 'danjia';

	//var $initDate = '2009-1-3'; //初始化日期

	function __construct() {
		$m = & FLEA::getSingleton("Model_Sys_Set");
		$arr = $m->find(array('setName'=>'RanliaoStartDate'));
		if(!$arr) $this->initDate = "2008-01-01";
		else $this->initDate = $arr['setValue'];
	}

	//重写，之前是从view中取，太慢
	function getInitInfo($wareId,$dateFrom) {
		$m = & FLEA::getSingleton('Model_JiChu_Ware');
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia) as money
		FROM	(
			`cangku_yl_ruku2ware` `x`
		LEFT JOIN `cangku_yl_ruku` `y` ON((`x`.`rukuId` = `y`.`id`))
		) where x.wareId='{$wareId}' and y.rukuDate<'{$dateFrom}'";
		$ruku = mysql_fetch_assoc(mysql_query($sql));
		
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia+x.money) as money
		FROM `cangku_yl_chuku2ware` `x`
		LEFT JOIN `cangku_yl_chuku` `y` ON((`x`.`chukuId` = `y`.`id`))
		where x.wareId='{$wareId}' and y.chukuDate<'{$dateFrom}'";		
		$chuku = mysql_fetch_assoc(mysql_query($sql));

		$arr = array();
		$arr['cnt'] = round($ruku['cnt'] - $chuku['cnt'],2);
		$arr['money'] = round($ruku['money'] - $chuku['money'],2);
		return $arr;
	}
	/**
	 * ps ：染化料月报表总获得期初库存(即是实际库存的期初)
	 * Time：2017年12月15日 15:38:33
	 * @author zcc
	*/
	function getInitInfoReport($wareId,$dateFrom) {
		//实际库存 即为 染化料仓库的库存 不算车间里面的库存
		$m = & FLEA::getSingleton('Model_JiChu_Ware');
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia) as money
		FROM	(
			`cangku_yl_ruku2ware` `x`
		LEFT JOIN `cangku_yl_ruku` `y` ON((`x`.`rukuId` = `y`.`id`))
		) where x.wareId='{$wareId}' and y.rukuDate<'{$dateFrom}' and y.kuwei = 0";
		$ruku = mysql_fetch_assoc(mysql_query($sql));
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia+x.money) as money
		FROM `cangku_yl_chuku2ware` `x`
		LEFT JOIN `cangku_yl_chuku` `y` ON((`x`.`chukuId` = `y`.`id`))
		where x.wareId='{$wareId}' and y.chukuDate<'{$dateFrom}' and y.kind<>0 and y.kuwei=0";		
		$chuku = mysql_fetch_assoc(mysql_query($sql));
		$arr = array();
		$arr['cnt'] = round($ruku['cnt'] - $chuku['cnt'],2);
		$arr['money'] = round($ruku['money'] - $chuku['money'],2);
		return $arr;
	}
	function getRukuInfo($wareId,$dateFrom,$dateTo) {
		$m = & FLEA::getSingleton('Model_JiChu_Ware');
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia) as money
		FROM	(
			`cangku_yl_ruku2ware` `x`
		LEFT JOIN `cangku_yl_ruku` `y` ON((`x`.`rukuId` = `y`.`id`))
		) where x.wareId='{$wareId}' and y.rukuDate>='{$dateFrom}' and y.rukuDate<='{$dateTo}'";
		$ruku = mysql_fetch_assoc(mysql_query($sql));
		return $ruku;
	}

	function getChukuInfo($wareId,$dateFrom,$dateTo,$kind) {
		$m = & FLEA::getSingleton('Model_JiChu_Ware');
		$sql = "SELECT
		sum(x.cnt) as cnt,sum(x.cnt*x.danjia+x.money) as money
		FROM	(
			`cangku_yl_chuku2ware` `x`
		LEFT JOIN `cangku_yl_chuku` `y` ON((`x`.`chukuId` = `y`.`id`))
		) where x.wareId='{$wareId}' and y.chukuDate>='{$dateFrom}' and y.chukuDate<='{$dateTo}'";
		if($kind>9)$sql.=" and kind<>9";
		else $sql.=" and kind='{$kind}'";
		$sql .= " group by x.wareId";
		 // 
		$chuku = mysql_fetch_assoc(mysql_query($sql));
		// dump($sql);dump($chuku);exit;
		return $chuku;
	}
}

?>