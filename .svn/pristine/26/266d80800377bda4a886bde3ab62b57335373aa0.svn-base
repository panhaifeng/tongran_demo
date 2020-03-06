<?php
class Api_Lib_Rsp_Uni {
    function __construct() {
        $this->_modelClient = &FLEA::getSingleton('Model_Jichu_Client');
        $this->_pageSize = 8;
    }
    /**
     * 获取客户列表
     * Time：2019/11/07 15:09:10
     * @author li
     * @param 参数类型
     * @return 返回值类型
    */
    function getCList($params,& $service){
        $pageNum     = $params['pageNum'] ? $params['pageNum'] : 20;
        $currentPage = $params['page'] ? $params['page'] : 1;
        $condition = array();
        if($params['key']!='') {
            $condition[] = array('compName',"%{$params['key']}%",'like');
        }
        if($params['compName']!='') {
            $condition[] = array('compName',"%{$params['compName']}%",'like');
        }

        FLEA::loadClass('TMIS_Pager');
        TMIS_Pager::clearCondition(true);
        $pager = & new TMIS_Pager($this->_modelClient,$condition,'id desc',$pageNum ,($currentPage - 1));
        $rowset = $pager->findAll();
        //把需要的数据带出来
        $rows = array();
        foreach ($rowset as $key => & $v) {
            $rows[] = array(
                'cid'        => $v['id'],
                'compCode'   => $v['compCode'],
                'compName'   => $v['compName'],
            );
        }

        return array('row'=>$rows,'page'=>$currentPage,'total'=>$pager->totalCount,'pageCount'=>count($rows));
    }

}
?>