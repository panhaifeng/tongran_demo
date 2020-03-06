<?php
load_class('TMIS_TableDataGateway');
class Model_Trade_Dye_Order extends TMIS_TableDataGateway {
	var $tableName = 'trade_dye_order';
	var $primaryKey = 'id';
	//var $primaryName = 'ruKuNum';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'clientId',
			'mappingName' => 'Client'
		),
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader'
		),
		array(
			'tableClass' => 'Model_JiChu_SaleKind',
			'foreignKey' => 'saleKind',
			'mappingName' => 'SaleKind'
		)
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_Trade_Dye_Order2Ware',
			'foreignKey' => 'orderId',
			'mappingName' => 'Ware'
		)
	);

	//删除订单时判断是否产生过缸号
	function removeByPkv($pkv) {
		$arr = $this->findByField('id',$pkv);
		//dump($arr);exit;
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		if (count($arr[Ware])>0) foreach($arr[Ware] as $v) {
			$gang = $m->find(array(
				order2wareId => $v[id]
			));
			//dump($gang);exit;
			if ($gang) {
				js_alert('已经产生了缸号,请清除缸号后删除!','',url('Trade_Dye_Order','PlanManage',array(
					orderCode=>$arr[orderCode]
				)));
			}
		}

		return parent::removeByPkv($pkv);
	}

	function formatRet(& $row) {
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$mCpck = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$mGang->disableLink('OrdWare');
		$mGang->disableLink('Vat');
		$mGang->enableLink('SongtongChanliang');
		$mGang->enableLink('RanseChanliang');
		$mGang->enableLink('HuidaoChanliang');
		$mGang->enableLink('HongshaChanliang');
		$mGang->enableLink('Cpck');
		$mGang->enableLink('Cprk');
		$mPerson =& FLEA::getSingleton('Model_JiChu_Employ');
		//$mGang->enableLink('Vat');
		if(count($row['Ware'])>0) foreach($row['Ware'] as & $v) {
			//打样人
			$rowPerson = $mPerson->find(array('id'=>$v['personDayang']));
			if ($rowPerson) $v['personDayangName'] = $rowPerson['employName'];
			else $v['personDayangName'] = "<font color=#cccccc>未指定</font>";

			$v['Ware'] = $mWare->find(array('id'=>$v['wareId']));

			$v['Gang'] = $mGang->findAll(array(
				'order2wareId'=>$v['id']
			));
			// dump($v);exit;
			if($v['Gang']) foreach($v['Gang'] as & $vv) {
				//移除  （李哥要求）回修缸号 为独立状态 不跟着 父缸号出库状态 by zcc 2017年12月6日 14:12:31 
				// if($vv['parentGangId']!=0)$vv['Cpck']=$mCpck->findAll(array('planId'=>$vv['parentGangId']));
				$vv['RkTongziCnt'] = $mGang->getCprkTongziCnt($vv['id']);
				$vv['CkCnt'] = $mGang->getCpckJingkg($vv['id']);
				$vv['haveSt']= $vv['SongtongChanliang'] ? true : false;
				$vv['haveRs']=$vv['RanseChanliang'] ? true : false;
				$vv['haveHd']=$vv['HuidaoChanliang'] ? true : false;
				$vv['haveHs']=$vv['HongshaChanliang'] ? true : false;
				$vv['haveFh']=$vv['Cpck'] ? true : false;
				$vv['haveRk']=$vv['Cprk'] ? true : false;
			}
		}
		//dump($row);exit;
		return $row;
	}

	#将订单明细的数量按wareId汇总，返回规格说明和数量总和的汇总
	function groupByWare($orderId){
		$sql = "select wareId,sum(cntKg) as cntKg,y.wareName,y.guige
			from trade_dye_order2ware x
			left join jichu_ware y on x.wareId=y.id
			where x.orderId='{$orderId}'
			group by x.wareId order by x.id";
		return $this->findBySql($sql);
	}
	function groupByColor($orderId,$column){
		$sql = "select {$column}
			from trade_dye_order2ware 
			where orderId='{$orderId}'
			group by {$column} order by id asc";
		return $this->findBySql($sql);
	}
	function getGuigeDescByWare($orderId){
		$arr = $this->groupByWare($orderId);
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		if($arr) foreach($arr as $key=>& $v) {
			$v['guige'] = $mWare->formatGuige($v['guige']);
			$a[] = "{$v['wareName']} {$v['guige']} : &nbsp;<font color='blue'>{$v['cntKg']}</font>KG";
		}

		if ($a) $return = join('<br>',$a);
		else $return = "<span style='color:red;'>此单没有填写纱支！</span>";
		return $return;

		//return join('<br>',$a);
	}
	function getDescByWare($orderId,$column){
		$arr = $this->groupByColor($orderId,$column);
		if($arr) foreach($arr as $key=>& $v) {
			$a[] = "{$v[$column]}";
		}
		if ($a) $return = join('<br>',$a);
		else $return = "<span style='color:red;'>此单没有填写！</span>";
		return $return;

		//return join('<br>',$a);
	}
	#得到订单总要货数
	function getCntYaohuo($orderId){
		$sql = "select sum(cntKg) cnt from trade_dye_order2ware where orderId='{$orderId}'
			group by orderId";
		$re =mysql_fetch_assoc(mysql_query($sql));
		return $re['cnt'];
	}
	function getOrderTrack($orderId,$orderCode){
		$r="<a href='".url('Public_Search','right1',array('orderId'=>$orderId))."' target='_blank'>$orderCode</a>";
		return $r;
	}
}
?>