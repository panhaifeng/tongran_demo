<?php
load_class('TMIS_TableDataGateway');
class Model_CangKu_Log extends TMIS_TableDataGateway {
    var $tableName = 'cangku_chuku_log';
    var $primaryKey = 'id';
    var $belongsTo=array(
        array(
            'tableClass'=>'Model_Jichu_Ware',
            'foreignKey' => 'wareId',
            'mappingName' => 'Wares'
        ),
    );
}

?>
