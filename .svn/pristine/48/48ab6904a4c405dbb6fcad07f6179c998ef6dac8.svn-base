<?php
/**
*޸by jeff zeng 2007-4-5
*{webcontrol type='SupplierSelect' selected=''}
*以联动select方式显示供应商控件
*/
function _ctlSupplierSelect($name,$params)	{	
	$html = "<select id='supplierType' name='supplierType' onchange=\"setSupplierOpts(document.getElementById('supplierId'),this.value)\">
		<option value=''>供应商类别</option>
	    <option value='01'>染料供应商</option>
		<option value='02'>助剂供应商</option>
		<option value='03'>其它供应商</option>
		<option value='04'>坯纱供应商</option>
        </select> 
  <select name='supplierId' id='supplierId' check='^0$' warning='请选择供应商'><option value=''>全部</option>";

	if ($params[selected]>0) {
		$_model = FLEA::getSingleton('Model_JiChu_Supplier');
		$arr = $_model->find($params[selected]);
		$html .= "<option value='$arr[id]'>$arr[compName]</option>";
	}
	$html .= "</select>";
	return $html;	
}
?>