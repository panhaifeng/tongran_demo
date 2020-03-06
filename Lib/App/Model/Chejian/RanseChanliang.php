<?php
load_class('TMIS_TableDataGateway');
class Model_Chejian_RanseChanliang extends TMIS_TableDataGateway {
	var $tableName = 'dye_rs_chanliang';
	var $primaryKey = 'id';
	//var $primaryName = 'employName';
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Plan_Dye_Gang',
			'foreignKey' => 'gangId',
			'mappingName' => 'Vat'
		),
	   	array(
			'tableClass' => 'Model_Plan_Dye_ViewGang',
			'foreignKey' => 'gangId',
			'mappingName' => 'VatView',
			'enabled'=>false
		)
	);

	var $hasMany  =array(
		array(
			'tableClass' => 'Model_Chejian_RsClDetail',
			'foreignKey' => 'rsClId',
			'mappingName' => 'rsGxCl',
		),
	);
	//删除产量前判断是否双染，如是修改fensanOver的值
	function _beforeRemoveDbByPkv($pkv) {
		$row = $this->find(array('id'=>$pkv));
		$gang = $row['Vat'];
		//dump($gang);exit;
		if($gang['markTwice']==1) {
			if($gang['fensanOver']==2) {//如果分散没有完成,表示产量是第一道工序分散产量
				//判断是否双染分配在同一班做掉
				if($gang['dateAssign']==$gang['dateAssign1'] && $gang['ranseBanci']==$gang['ranseBanci1']) {
					$sql = "update plan_dye_gang set fensanOver=0 where id='{$gang['id']}'";
				} else {
					$sql = "update plan_dye_gang set fensanOver=1 where id='{$gang['id']}'";
				}
			} else $sql = "update plan_dye_gang set fensanOver=0 where id='{$gang['id']}'";
			//echo $sql;exit;
			mysql_query($sql) or die(mysql_error());
		}
		return true;
	}
	
	//根据染色产量的整形类别,返回中文说明的类别
	function getKindName($kindId){
		if ($kindId==0) return "正常";
		if ($kindId==1) return "修色";
		if ($kindId==2) return "加色";
	}

	//根据逻辑缸号取得产量
	function getRanseChanliang($vatNum) {
		//echo('____________'.$vatNum.'__________');
		$mGang = & FLEA::getSingleton('Model_Plan_Dye_Gang');
		$rowGang = $mGang->findByField('vatNum', $vatNum);
		$row =	parent::findByField('gangId', $rowGang[id]);
		//echo($row[cntTongzi]); exit;
		return $row[cntTongzi];
	}

	//根据wareId 判断是否为 T/C, CVC规格, 如果是返回false
	function wareLeach($wareId) {
		$leachWare = array('T/C', 'CVC');

		//echo($leachWare[0]); exit;
		//dump($leachWare);

		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		$rowWare = $mWare->findByField('id', $wareId);
		//echo(trim($rowWare[wareName])); exit;

		 for ($i=0; $i<count($leachWare); $i++) {
			 if (trim($rowWare[wareName]) == $leachWare[$i]) return false;
		}

		return true;
	}
}
?>