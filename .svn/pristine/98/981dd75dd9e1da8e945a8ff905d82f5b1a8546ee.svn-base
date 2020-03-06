<?php
/**
 * 染料助剂收付月报表
 */ 
FLEA::loadClass('TMIS_Model_MonthReport');
class Model_CangKu_Report_MonthDye extends TMIS_Model_MonthReport {
	var $dateFrom = "2009-04-01";
	var $tableName = 'jichu_ware';
	//var $primaryKey = 'id';
	var $initTable = 'cangku_init';
	var $rukuTable = 'view_yl_ruku';
	var $chukuTable = 'view_yl_chuku';
	var $keyField = 'wareId';
	var $rukuDateField = 'ruKuDate';
	var $chukuDateField = 'chukuDate';
	var $rukuCntField = 'cnt';
	var $rukuDanjiaField = 'danJia';
	var $chukuCntField = 'cnt';
	var $chukuDanjiaField = 'danjia';
	var $initCntField = 'cntInit';
	var $initMoneyField = 'moneyInit';
	var $initDate = '2009-04-01'; //初始化日期	

	function getPandianInfo($wareId,$datePandian) {
		$str = "select cnt,money from cangku_dye_pandian where wareId='{$wareId}' and datePandian='{$datePandian}'";
		$re = mysql_fetch_assoc(mysql_query($str));
		return $re;
	}

	function getInitInfo($wareId,$dateFrom) {
		$arr = explode('-',$dateFrom);
		$ymd = date("Y-m-d",mktime(0,0,0,$arr[1],$arr[2]-1,$arr[0]));
		$str = "select cnt,money from cangku_dye_pandian where wareId='{$wareId}' and datePandian='{$ymd}'";
		//echo $str;
		$re = mysql_fetch_assoc(mysql_query($str));
		return $re;
		//return parent::getInitInfo($wareId,$dateFrom);
	}
}
?>