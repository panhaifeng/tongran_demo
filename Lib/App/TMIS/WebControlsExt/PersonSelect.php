<?php
/**
* by ShenHao 2018年4月9日
* select2控件
*/
function _ctlPersonSelect($name,$params)	{	
	
	//$_model = FLEA::getSingleton('Model_JiChu_Employ');
	$_model = FLEA::getSingleton('Model_JiChu_GxPerson');
	$selected=  $params['selected'];
	$actions = $params['action'];
    $multiple = $params['multiple']?"multiple='multiple'":'';

	// 兼容以「,」分隔的字符
    if(!is_array($selected)){
        $selected = explode(',', trim($selected));
    }else{
        $selected = array_col_values($selected,'id');
    }

	// if (is_array($selected)) $selectedId = $selected[id];
	// else $selectedId=$selected;

	if ($params['disabled']) $dis = ' disabled';
	if ($params['id']!="") $id =$params['id'];
	else $id='gxPersonId[]';

	$html = "<select name='$id' id='$id'".$dis." check='^0$' {$multiple} class='select2' warning='请选择'>";
	// $html .= "<option value=''>请选择</option>";
	//$condition[] = array(id, $arr[dateTo]);
	//$arr = $_model->findAll();
	if($actions=='st'){
		$sql = "select * from jichu_gxperson where type='st' or type='db' or type='hd'";
		$arr = $_model->findBySql($sql);
	}else if($actions=='zcl'){
		$sql = "select * from jichu_gxperson where type='zcl'";
		$arr = $_model->findBySql($sql);
	}else{
		$sql = "select * from jichu_gxperson where type='rs'";
		$arr = $_model->findBySql($sql);
	}
	
	if(count($arr)>0) foreach($arr as $v) {
		$html .= "<option value='$v[id]'";
		// if($selectedId==$v[id]) {
		// 	$html .= " selected";
		// }
        if(in_array($v['id'],$selected)) $html.=" selected ";
		$html .= ">$v[perName]</option>";
	}	
	$html .= "</select>";
	return $html;
}
?>