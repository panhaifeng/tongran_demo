<?php
/**
*޸by jeff zeng 2007-4-5
*{webcontrol type='TmisOptions' model='' selected=''}
*/
/**
*取得用于option的数组，
*之所以扩展出该方法，是因为大多数基础信息都需要以select形式显示，以供选择.
*firstKey:第一个option的显示文字
*/
function arrInOptions($model,$fieldNameOfKey=NULL,$firstKey=NULL,$conditions=NULL) {
	if ($fieldNameOfKey==NULL) $fieldNameOfKey = $model->primaryName ;	
	if ($firstKey == NULL) $firstKey = "请选择";
	$fieldNameOfValue = $model->primaryKey;
	
	$ret = array($firstKey => "");
	$arrDep = $model->findAll($conditions,$fieldNameOfValue,NULL,"$fieldNameOfValue,$fieldNameOfKey");	
	$ret = array_merge($ret,array_to_hashmap($arrDep,$fieldNameOfKey,$fieldNameOfValue));	
	return $ret;
}
function _ctlTmisOptions($name, $params)	{	
	if ($params['model']!="") {
		$modelName = "Model_" . $params[model];
		$_model = FLEA::getSingleton($modelName);
		$arr = arrInOptions($_model,'','',$params[condition]);
	} elseif ($params['inf']!="") {
		$arr=FLEA::getAppInf($params['inf']);
	}
	foreach ($arr as $cap => $value) {
		$ret .= "<option value=\"$value\"";
		//if selected is a var
		if (!is_array($params[selected])) {
			$ret .= ($value == $params[selected]) ? " selected" : "";
		} else {
			$tempArr = array_col_values($params[selected],$_model->primaryKey);
			if (in_array($value,array_col_values($params[selected],$_model->primaryKey))) {			
				$ret .= " selected";
			}
		}
		//if selected is a array,
		$ret .= ">$cap</option>\n";
	}
	return $ret;
}
?>