<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_Yl_Chuku extends TMIS_TableDataGateway {
	var $tableName = 'cangku_yl_chuku';
	var $primaryKey = 'id';
	var $primaryName = 'chukuNum';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Department',
			'foreignKey' => 'depId',
			'mappingName' => 'Department'
		),
		array(
			'tableClass' => 'Model_Plan_Dye_Gang',
			'foreignKey' => 'gangId',
			'mappingName' => 'Gang'
		)
	);
	var $hasMany = array(
		array(
			'tableClass' => 'Model_CangKu_Yl_Chuku2Ware',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Wares'
		)
	);
	function getNewChukuNum() {
		$ym=date("ym");
		$arr=$this->find("chukuNum like '%$ym%'", 'chukuNum desc', 'chukuNum');
		$max = $arr['chukuNum'];
		$temp = date("ym")."0001";
		//dump($max);
		if ($temp>$max) return $temp;
		$a = substr($max,-4)+10001;
		return substr($max,0,-4).substr($a,1);
	}
	//by zcc 2017年12月15日 16:41:07
	function getRukuNum($Name) {
		$ym=$Name.date("ym");
		$condition = array(
			array('chukuNum',$ym.'____','like')
		);
		$arr=$this->find($condition, 'chukuNum desc', 'chukuNum');
		// dump($arr);exit;
		$max = $arr['chukuNum'];
		$temp = $Name.date("ym")."0001";
		if ($temp>$max) return $temp;
		$a = substr($max,-4)+10001;
		return substr($max,0,-4).substr($a,1);
	}
	function getRukuDanjia($wareId){
		$sql = "select danjia from cangku_yl_ruku2ware where wareId='$wareId' order by id desc limit 0,1";
		$re = mysql_fetch_assoc(mysql_query($sql));
		//佳楠2013-5-28，改为取最后一次入库单价
		return $re['danjia'];
		#最近一次调库
		$sql1 = "select y.danjia
			from cangku_yl_chuku x
			left join cangku_yl_chuku2ware y on y.chukuId=x.id
			where y.wareId='$wareId'
			and x.kind=9
			order by y.id desc
		";
		$re1 = mysql_fetch_assoc(mysql_query($sql1));
		$sql2 = "select danjia from jichu_ware where id='$wareId' order by id desc";
		$re2 = mysql_fetch_assoc(mysql_query($sql2));
		$danjia=($re['danjia']==0?($re1['danjia']==0?$re2['danjia']:$re1['danjia']):$re['danjia']);
		return $danjia;
	}
}
?>