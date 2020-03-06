<?php
load_class('Model_CangKu_RuKu');
class Model_CangKu_RukuPeisha extends Model_CangKu_RuKu {
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Client',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier'
		)
	);
}
?>