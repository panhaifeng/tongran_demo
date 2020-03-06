<?php
load_class('Model_CangKu_RuKu');
class Model_CangKu_RukuDye extends Model_CangKu_RuKu {
	var $belongsTo = array (
		array(
			'tableClass' => 'Model_JiChu_Supplier',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier'
		)
	);
}
?>