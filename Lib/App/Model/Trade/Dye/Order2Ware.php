<?php
load_class('TMIS_TableDataGateway');
class Model_Trade_Dye_Order2Ware extends TMIS_TableDataGateway {
	var $tableName = 'trade_dye_order2ware';
	var $primaryKey = 'id';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Trade_Dye_Order',
			'foreignKey' => 'orderId',
			'mappingName' => 'Order'
		),
		array(
			'tableClass' => 'Model_JiChu_Ware',
			'foreignKey' => 'wareId',
			'mappingName' => 'Ware'
		),
		array(
			'tableClass' => 'Model_JiChu_Employ',
			'foreignKey' => 'personDayang',
			'mappingName' => 'PersonDayang'
		)
	);
	var $hasMany = array(
		//计划科分缸
		array(
			'tableClass' => 'Model_Plan_Dye_Gang',
			'foreignKey' => 'order2wareId',
			'mappingName' => 'Pdg'
		),
		//工艺科处方
		array(
			'tableClass' => 'Model_Gongyi_Dye_Chufang',
			'foreignKey' => 'order2WareId',
			'mappingName' => 'Chufang',
			'enabled' => false
		)
	);

	//得工艺的状态
	function isGongyiOk($pkv) {
		$m = &FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$arr=$m->findByField('order2wareId',$pkv);
		if($arr) return true;
		return false;
	}

	//得到一个颜色的计划投料数
	//为了速度，用sql
	function getCntPlanTouliao($order2wareId) {
		$str = "select sum(cntPlanTouliao) cnt from plan_dye_gang where order2wareId='$order2wareId' and parentGangId=0";
		$re=mysql_fetch_array(mysql_query($str));
		return $re[cnt];
	}

	//得到一个颜色的已领料数量
	//为了速度，用sql
	function getCntPishaLingliao($order2wareId) {
		$str = "select sum(x.cnt) cnt
		from cangku_chuku2ware x left join plan_dye_gang y on x.gangId=y.id
		where y.order2wareId='$order2wareId'";
		//$str = "select sum(cntPlanTouliao) cnt from plan_dye_gang where order2wareId='$order2wareId' and parentGangId=0";
		$re=mysql_fetch_array(mysql_query($str));
		return $re[cnt];
	}

	//得到一个颜色的成品出库数量
	function getCpckChanliang($order2wareId) {
		$str = "select sum(y.cntPlanTouliao) cnt
		from chengpin_dye_cpck x
		inner join plan_dye_gang y on x.planId=y.id
		where y.order2wareId='$order2wareId'
		";
		$re=mysql_fetch_array(mysql_query($str));
		return $re[cnt];
	}


	//更新坯纱领料单中的wareId
	function updateChuku2wareId($order2wareId, $wareId) {
		$modelPlan = FLEA::getSingleton('Model_Plan_Dye_Gang');
		$modelC2w = FlEA::getSingleton('Model_CangKu_ChuKu2Ware');

		//找出缸号
		$rowPlan = $modelPlan->findByField('order2wareId', $order2wareId);
			dump($rowPlan);
			//echo('-----------'.$rowPlan[vatNum]);die();

		//更新领料出库单中的wareId
		if (count($rowPlan)>0) {
			//echo('-----------'.$rowPlan['vatNum']); die();
			$rowC2w = $modelC2w->findByField('gangId', "$rowPlan[vatNum]");
			dump($rowC2w); die();
			$modelC2w->updateField("gangId='$rowPlan[vatNum]'", 'wareId', $wareId);
		}
	}
	function update($row) {
		if(isset($row[wareId])&&$row[wareId]>0) {
			//找到关联缸号
			$modelPlan = FLEA::getSingleton('Model_Plan_Dye_Gang');
			$modelC2w = FlEA::getSingleton('Model_CangKu_ChuKu2Ware');
			$condition = array(order2wareId=>$row[id]);
			$rowPlan = $modelPlan->findAll($condition);
			//dump($rowPlan);exit;
			//根据缸号,更新相关领料
			if (count($rowPlan)>0) foreach($rowPlan as $v) {
				//$condition = array(gangId=>$v[id]);
				//dump($modelC2w->findAll($condition));exit;
				$modelC2w->updateField (array(gangId=>$v[id]),'wareId',$row[wareId]);
			}
		}
		return parent::update($row);
	}

	function removeByPkv($pkv){
		//echo "asdf";exit;
		//判断是否存在相关缸号，存在则禁止
		$m = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		//dump($m->find(array('id'=>$pkv)));exit;
		if($m->find(array('order2wareId'=>$pkv))) {
			$this->errorMsg="该计划已经生成缸号,请清除计划后再进行删除!";
			return false;
		}
		return parent::removeByPkv($pkv);
	}
}
?>