<?php
load_class('TMIS_TableDataGateway');
class Model_Ganghao_Gx extends TMIS_TableDataGateway {
	var $tableName = 'Ganghao_gx';
	var $primaryKey = 'id';
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Ganghao_Gx',
			'foreignKey' => 'gxId',
			'mappingName' => 'Gx'

		)
	);

  function _afterCreateDb(&$row) {
	// dump($row);die;
	$mGx = & FLEA::getSingleton('Model_Ganghao_Gx');
	foreach ($row as $key => &$value) {
		//dump($value);die;
      if($value['isOverGx']=='1'){
	   	  $sql ="insert into ganghao_gx values(id,{$value['gxIds']},{$value['gangId']},'{$value['dateInput']}')";
	   	  //dump($sql);die;
          $mGx->execute($sql);
	  } 
	  if($value['id']&&$value['isOverGx']==0){
	  	  $sql1 ="select * from ganghao_gx where gxId='{$value['gxIds']}' and ganghao='{$value['gangId']}'";
          $info =$mGx->findBySql($sql1);
          $sql2 ="delete from ganghao_gx where id='{$info[0]['id']}'";
          $mGx->execute($sql2);

	  }     

	}
  }
}
?>