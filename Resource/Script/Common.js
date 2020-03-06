function dump(obj){
	 /*var objPlayer = httpRequest;
	 var str = '<table border=1>';
	 for (var i in objPlayer)
	 {
	  str += '<tr><td>' + i + ' </td><td> ' + objPlayer[i] + '</td></tr>';
	  i++;
	 }
	 str += '</table>';
	 document.getElementById('spanInfo').innerHTML = str;
	 */
	var ret = '';
	for (var i in obj){
		ret += i + '=>' + obj[i] + "\n";
	}
	alert(ret);
}
//动态载入css文件
function loadCss(file){ 
	var head = document.getElementsByTagName("head").item(0);	
	var style = document.createElement("link"); 	
	style.href = file; 
	style.rel = "stylesheet";	
	style.type = "text/css"; 	
	head.appendChild(style);
} 
// JavaScript Document
function getTop(e){ 
	var offset=e.offsetTop; 
	if(e.offsetParent!=null) offset+=getTop(e.offsetParent); 
	return offset; 
} 
//获取元素的横坐标 
function getLeft(e){ 
	var offset=e.offsetLeft; 
	if(e.offsetParent!=null) offset+=getLeft(e.offsetParent); 
	return offset; 
} 
//类似php中的explode函数
function explode(separator,str) {
	return str.split(separator);
}

//得到供应商联动控件的options
function setSupplierOpts(o,type) {	
	//清空o.option
	while (o.options.length>1) {o.remove(1);}; 
	//从ajax取得options
	var url='?controller=JiChu_Supplier&action=GetJson';
	var params={type:type};
	$.getJSON(url, params, function(json){
		//设置o的option
		for (var i=0;i<json.length;i++){
			var opt=new Option(json[i].compName,json[i].id);   
			o.options.add(opt);
		}		
	}) ;	
	return false;
}
//得到支出项目的联动options
function setExpenseTypeOpts(o,type) {
	//清空o.option
	while (o.options.length>0) {o.remove(0);}; 
	//从ajax取得options
	var url='?controller=CaiWu_ExpenseItem&action=GetJson';
	var params={type:type};
	$.getJSON(url, params, function(json){
		//设置o的option
		for (var i=0;i<json.length;i++){
			var opt=new Option(json[i].itemName,json[i].id);   
			o.options.add(opt);
		}		
	}) ;	
	return false;
}
//弹出选择客户的对话框，并在目标select控件 o 中加入选中的客户option
function popClient(o,arType) {
	//alert(o.value);
	var url='Index.php?controller=JiChu_Client&action=Popup';
	if (arType) url += '&arType=' + arType;
	var Client = showModalDialog(url);
	if (!Client) return false;
	//清空o.option
	while (o.options.length>0) {o.remove(0);};
	var opt=new Option(Client.compName,Client.clientId); 
	o.options.add(opt);
}
//仓库领用出库时弹出入库批次选择的对话框，主要在染料领用时需要弹出。
//objCondition:条件对象{wareId:'23',dateFrom:''}
function popRuku(objCondition) {	
	var url='Index.php?controller=CangKu_RuKu&action=popup';
	if (objCondition.wareId) url += '&wareId='+objCondition.wareId;
	var Client = showModalDialog(url);
	return Client;
}
//弹出选择纱支对话框图，并在目标select控件 o中加入先中的纱支option
function popWare(o) {
	//alert(o.value);
	var url='?controller=Jichu_Ware&action=Popup';
	var Ware = showModalDialog(url,window,'dialogWidth:530px;dialogHeight:510px;center: yes;help:no;resizable:no;status:no');
	if (!Ware) return false;
	//清空o.option
	while (o.options.length>0) {o.remove(0);};
	var opt=new Option(Ware.wareName+' '+Ware.guige, Ware.id); //Option(text, value)
	o.options.add(opt);
}