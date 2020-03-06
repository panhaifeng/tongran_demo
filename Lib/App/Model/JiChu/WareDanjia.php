<?php
FLEA::loadClass('TMIS_TableDataGateway');
class Model_JiChu_WareDanjia extends TMIS_TableDataGateway {
    var $tableName = 'jichu_ware_danjia';
    var $primaryKey = 'id';
    //var $primaryName = '';

    var $belongsTo = array(
        array(
            'tableClass' => 'Model_JiChu_Ware',
            'foreignKey' => 'wareId',
            'mappingName' => 'Ware'
        )
    );

}
?>