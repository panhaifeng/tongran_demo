<?php
/**
*޸by jeff zeng 2007-4-5
*{webcontrol type='SupplierSelect' selected=''}
*以联动select方式显示供应商控件
*/
function _ctlSupplierSelect($name,$params)	{
	$_model = FLEA::getSingleton('Model_Jichu_Supplier');
	$selected=$params[selected];
	if (is_array($selected)) $selectedId = $selected[id];
	else $selectedId=$selected;
	if ($params[disabled]) $dis = ' disabled';
	if ($params[id]!="") $id =$params[id];
	else $id='supplierId';
	$html = "<select name='$id' id='$id'".$dis.">";
	$html .= "<option value=''>选择</option>";
	$arr = $_model->findAll();
	if(count($arr)>0) foreach($arr as $v) {
		$html .= "<option value='$v[id]'";
		if($selectedId==$v[id]) {
			$html .= " selected";
		}
		$html .= ">$v[compName]</option>";
	}
	$html .= "</select>";
	return $html;

	$html = "<select id='supplierType' onchange=\"setSupplierOpts(document.getElementById('supplierId'),this.value)\">
		<option value=''>供应商类别</option>
	    <option value='01'>染料供应商</option>
		<option value='02'>助剂供应商</option>
		<option value='03'>其它供应商</option>
        </select>
  <select name='supplierId' id='supplierId' check='^0$' warning='请选择供应商'>";
	if ($params[selected]>0) {
		$_model = FLEA::getSingleton('Model_Jichu_Supplier');
		$arr = $_model->find($params[selected]);
		$html .= "<option value='$arr[id]'>$arr[compName]</option>";
	}
	$html .= "</select>";
	return $html;
}
?>