<?php
load_class('TMIS_TableDataGateway');
class Model_Cangku_Ruku2Ware extends TMIS_TableDataGateway {
	var $tableName = 'cangku_ruku2ware';
	var $primaryKey = 'id';
	//var $primaryName = 'rukuId';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Ware'
		),
		array(
			'tableClass' => 'Model_Cangku_Ruku',
			'foreignKey' => 'rukuId',
			'mappingName' => 'Ruku'
		)
	);

	//得到特定wareId的入库单价，以最后一次入库单价为准。
	function getDanjia($wareId) {
		return 100;
		$model = FLEA::getSingleton('Model_Cangku_RuKu2Ware');
		$a=$model->find("wareId='$wareId'",'id desc');
		$danjia = $a[danJia];
		if ($danjia>0) return $danjia;
		//初始单价
		$model = FLEA::getSingleton('Model_Cangku_Init');
		$a = $model->find("wareId = '$wareId'");
		if ($a[cntInit]==0) return false;
		$danjia = $a[moneyInit]/$a[cntInit];
		return number_format($danjia,2,".","");
	}

	function _afterCreateDb(&$row) {
		//dump($row);exit;
		//$this->changeKucun($row);
		//计算本期的加权平均价,用来为出库时使用
		//$this->_changeJqDanjia($row);
	}

	function _afterRemoveDb(&$row) {
		//$this->changeKucun($row);
		//计算本期的加权平均价,用来为出库时使用
		//$this->_changeJqDanjia($row);
	}
	function _afterUpdateDb(&$row) {
		//$this->changeKucun($row);
		//计算本期的加权平均价,用来为出库时使用
		//$this->_changeJqDanjia($row);
	}

	function _changeJqDanjia(&$row) {
		$wareId = $row['wareId'];
		//$rukuDate = $ruku['rukuDate'];
		FLEA::loadClass('TMIS_Controller');
		$arrDate = TMIS_Controller::getBenqi();
		$fDay = $arrDate['dateFrom'];
		$eDay = $arrDate['dateTo'];

		//当月出库单价已经确定的话，不需要更新单价,应该禁止
		//后改为每笔出库都确认单价，故取消此判断
		/*$sql = "select count(*) cnt from cangku_chuku x inner join cangku_chuku2ware y on x.id=y.chukuId where
			y.wareId='{$wareId}' and x.chukuDate>='{$fDay}' and x.chukuDate<='{$eDay}' and y.danjia>0";
		$row = $this->findBySql($sql);
		if($row[0]['cnt']>0) {
			return false;
		}*/

		$m = FLEA::getSingleton('Model_Cangku_Kucun');
		//初始
		$sql = "select * from cangku_kucun where wareId='{$wareId}'";
		$rowset = $this->findBySql($sql);
		//dump($rowset);
		$initCnt = $rowset[0]['initCnt'];
		$initMoney = $rowset[0]['initMoney'];
		$kucunId = $rowset[0]['id']+0;

		//修改本月加权单价
		//所有入库
		$sql = "select sum(x.cnt*x.danjia) money,sum(x.cnt) as cnt from cangku_ruku2ware x
		inner join cangku_ruku y on x.rukuId=y.id
		where x.wareId='{$wareId}'";
		//echo $sql;
		$rowset = $this->findBySql($sql);
		$rukuCnt = $rowset[0]['cnt'];
		$rukuMoney = $rowset[0]['money'];
		//所有本期之前的出库
		$sql = "select sum(x.cnt*x.danjia) money,sum(x.cnt) as cnt from cangku_chuku2ware x
		inner join cangku_chuku y on x.chukuId=y.id
		where x.wareId='{$wareId}' and y.chukuDate<'{$fDay}' and y.chukuDate<='{$eDay}'";
		//echo $sql;exit;
		$rowset = $this->findBySql($sql);
		$chukuCnt = $rowset[0]['cnt'];
		$chukuMoney = $rowset[0]['money'];

		$cnt = $initCnt+$rukuCnt-$chukuCnt;
		if($cnt==0) $danjia=0;
		else {
			$money = $initMoney + $rukuMoney - $chukuMoney;
			$danjia = round($money/$cnt,3);
		}
		$arr = array('id'=>$kucunId,'wareId'=>$wareId,'jqDanjia'=>$danjia);
		//dump($arr);exit;
		$m->save($arr);

		//修改本期的所有出库的出库单价
		/*$str="select y.id from cangku_chuku x
		    left join cangku_chuku2ware y on y.chukuId=x.id
		    where x.type=0 and y.wareId='$wareId' and x.chukuDate>='$fDay' and x.chukuDate<='$eDay'
		";
		//echo $str;exit;
		$rowset = $this->findBySql($str);
		if($rowset) foreach($rowset as & $v) {
		    $sql = "update cangku_chuku2ware set danjia='{$danjia}',money={$danjia}*cnt where id='{$v['id']}'";
		    $this->execute($sql);
		}*/
		return true;
	}

	//得到$ymd之前所有的加权单价
	function getJqDanjia($wareId,$ymd) {

		$m = FLEA::getSingleton('Model_Cangku_Kucun');
		//初始
		$sql = "select * from cangku_kucun where wareId='{$wareId}'";
		$rowset = $this->findBySql($sql);
		//dump($rowset);
		$initCnt = $rowset[0]['initCnt'];
		$initMoney = $rowset[0]['initMoney'];
		$kucunId = $rowset[0]['id']+0;
		$initSql = $sql;


		//所有入库
		$sql = "select sum(x.cnt*x.danjia) money,sum(x.cnt) as cnt from cangku_ruku2ware x
		inner join cangku_ruku y on x.rukuId=y.id
		where x.wareId='{$wareId}' and y.rukuDate<'{$ymd}'";
		//echo $sql;
		$rowset = $this->findBySql($sql);
		$rukuCnt = $rowset[0]['cnt'];
		$rukuMoney = $rowset[0]['money'];
		$rukuSql = $sql;

		//所有本期之前的出库
		if($ymd=='2010-09-28') $dateFrom='0000-00-00';
		if($ymd=='2010-10-28') $dateFrom='2010-09-28';
		if($ymd=='2010-11-28') $dateFrom='2010-10-28';
		$sql = "select sum(x.cnt*x.danjia) money,sum(x.cnt) as cnt from cangku_chuku2ware x
		inner join cangku_chuku y on x.chukuId=y.id
		where x.wareId='{$wareId}' and y.chukuDate<'{$dateFrom}'";
		//echo $sql;exit;
		$rowset = $this->findBySql($sql);
		$chukuCnt = $rowset[0]['cnt'];
		$chukuMoney = $rowset[0]['money'];
		$chukuSql = $sql;

		$cnt = $initCnt+$rukuCnt-$chukuCnt;
		if($cnt==0) $danjia=0;
		else {
			$money = $initMoney + $rukuMoney - $chukuMoney;
			$danjia = round($money/$cnt,3);
		}
		//$arr = array('id'=>$kucunId,'wareId'=>$wareId,'jqDanjia'=>$danjia);

		return array(
			initCnt => $initCnt,
			initMoney => $initMoney,
			initDanjia=>$initMoney/$initCnt,
			rukuCnt=>$rukuCnt,
			rukuMoney=>$rukuMoney,
			rukuDanjia=>$rukuMoney/$rukuCnt,
			chukuCnt=>$chukuCnt,
			chukuMoney=>$chukuMoney,
			danjia=>$danjia,
			initSql=>$initSql,
			rukuSql=>$rukuSql,
			chukuSql=>$chukuSql
		);
		//dump($arr);exit;
		//$m->save($arr);
	}
}
?>