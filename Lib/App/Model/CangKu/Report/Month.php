<?php
/**
 * 物料仓库报表的基础类，从此类中衍生了仓库月报表。适应出入库中都有单价的情况
 * 单独用于坯纱仓库，有客户和纱支两个关键字段。
 */
FLEA::loadClass('FLEA_Db_TableDataGateway');
class Model_CangKu_Report_Month extends FLEA_Db_TableDataGateway {
	var $dateFrom = "2008-01-01";
	var $tableName = 'jichu_ware';
	/*var $primaryKey = 'id';
	var $initTable = 'cangku_init';
	var $rukuTable = 'view_cangku_ruku';
	var $chukuTable = 'view_cangku_chuku';
	var $keyField = 'wareId';
	var $rukuDateField = 'ruKuDate';
	var $chukuDateField = 'chukuDate';
	var $rukuCntField = 'cnt';
	var $rukuDanjiaField = 'danJia';
	var $chukuCntField = 'cnt';
	var $chukuDanjiaField = 'danjia';
	var $initCntField = 'cntInit';
	var $initMoneyField = 'moneyInit';
	*/
	// kind = 0为正常出入库 1 为本厂采购出入库
	function __construct() {
		$m = & FLEA::getSingleton("Model_Sys_Set");
		$arr = $m->find(array('setName'=>'PishaStartDate'));
		if(!$arr) $this->dateFrom = "2008-01-01";
		else $this->dateFrom = $arr['setValue'];
	}
	function getInitInfo($clientId,$wareId,$dateFrom,$kind=0) {
		//初始入库值
		$str = "select sum(cnt) as cnt from view_cangku_ruku
			where supplierId='$clientId' and wareId='$wareId' and ruKuDate<'$dateFrom' and ruKuDate>='{$this->dateFrom}' and kind = '$kind'";

		$re=mysql_fetch_array(mysql_query($str));
		$cntRuku =$re[cnt];

		//初始出库值
		$str = "select sum(cnt) as cnt from view_cangku_chuku
			where supplierId='$clientId' and wareId='$wareId' and chukuDate<'$dateFrom' and chukuDate>='{$this->dateFrom}'and kind = 0";
		$result = mysql_query($str);
		if ($result){
			$re = mysql_fetch_array($result);
			$cntChuku = $re['cnt'];
		} else {
			$cntChuku = 0;
		}

		return $cntRuku-$cntChuku;
	}

	//得到当月的入库信息，包括入库总数和金额,入库数为正
	function getRukuInfo($clientId,$wareId,$dateFrom,$dateTo,$kind=0) {
		$str = "select sum(cnt) as cnt from view_cangku_ruku
			where supplierId='$clientId' and wareId='$wareId'
			and ruKuDate>='$dateFrom' and ruKuDate<='$dateTo'
			and ruKuDate>='{$this->dateFrom}' and kind = '$kind'";
		//if ($wareId==280) echo $str;
		$re=mysql_fetch_array(mysql_query($str));
		//$cntRuku =$re[cnt];
		return $re[cnt];
	}

	//得到当月的领用出库信息，包括入库总数和金额
	function getChukuInfo($clientId,$wareId,$dateFrom,$dateTo,$kind=0) {
		$str = "select sum(cnt) as cnt from view_cangku_chuku
			where supplierId='$clientId' and wareId='$wareId'
			and chukuDate>='$dateFrom' and chukuDate<='$dateTo'
			and chukuDate>='{$this->dateFrom}' and kind = '$kind'";
		//if($wareId==19) echo $str;
		//echo $str;exit;
		/*$re=mysql_fetch_array(mysql_query($str));
		return $re[cnt];*/

		$result = mysql_query($str);
		if ($result){
			$re = mysql_fetch_array($result);
			$return = $re['cnt'];
		} else {
			$return = 0;
		}
		return $return;
	}

	//得到当月的发货信息，包括入库总数和金额
	function getCpckInfo($clientId,$wareId,$dateFrom,$dateTo) {
		$str = "select sum(cntPlanTouliao) as cnt from view_dye_cpck_ar
			where clientId='$clientId' and wareId='$wareId'
			and dateCpck>='$dateFrom' and dateCpck<='$dateTo'
			and dateCpck>='{$this->dateFrom}'";
		//if($wareId==19) echo $str;
		//echo $str;exit;
		$re=mysql_fetch_array(mysql_query($str));
		return $re[cnt];
	}

	//得到当月的退库信息，也就是入库数为负的入库信息
	function getTuikuInfo($clientId,$wareId,$dateFrom,$dateTo,$kind=0) {
		$str = "select sum(cnt) as cnt from view_cangku_ruku
			where supplierId='$clientId' and wareId='$wareId'
			and ruKuDate>='$dateFrom' and ruKuDate<='$dateTo'
			and ruKuDate>='{$this->dateFrom}' and  cnt<0 and kind = '$kind' and isTuiku='1'";
		/*$str = "select sum(cnt) as cnt from view_cangku_ruku
			where supplierId='$clientId' and ruKuDate>='$dateFrom' and ruKuDate<='$dateTo'
			and ruKuDate>='{$this->dateFrom}' and isTuiku=1";*/

		//echo($str); exit;
		//if ($wareId==32) echo $str;
		$re=mysql_fetch_array(mysql_query($str));
		//$cntRuku =$re[cnt];
		return $re[cnt];
	}

	//得到某个客户某个品种的库存数量
	function getCntKucn($clientId,$wareId,$kind=0) {
		$str = "select sum(cnt) as cnt from view_cangku_ruku where supplierId='$clientId' and wareId='$wareId'  and cnt>0 and ruKuDate>='{$this->dateFrom}' and kind = '$kind'";
		//if ($wareId==32) echo $str;
		$ruku=mysql_fetch_array(mysql_query($str));

		$str = "select sum(cnt) as cnt from view_cangku_chuku where supplierId='$clientId' and wareId='$wareId' and chukuDate>='{$this->dateFrom}' and kind = '$kind'";
		$chuku=mysql_fetch_array(mysql_query($str));
		return $ruku['cnt']-$chuku['cnt'];
	}
}
?>