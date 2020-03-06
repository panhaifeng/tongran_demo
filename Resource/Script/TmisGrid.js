/*var TmisGrid = function () {
}
var TmisGrid.edit = function (obj,fldName,value) {
	alert(obj.id);
}
alert('asdf');
*/
function gridEdit(obj,fieldName,pkv) {
	var tag = obj.firstChild.tagName;
	if (typeof(tag) != "undefined" && tag.toLowerCase() == "input"){
		return;
	}
	var oValue = obj.innerHTML;	
	var text = document.createElement('input');
	text.style.width = (obj.offsetWidth + 12) + "px" ;
	text.value=oValue;
	obj.innerHTML='';
	obj.appendChild(text);
	text.select();
	text.onblur = function() {
		var controller = $.query.get('controller');
		var value = obj.firstChild.value;
		if (value.length==0||value==oValue){
			obj.innerHTML = oValue;
			return false;
		}
		var url = "";
		var param = {
			controller:controller,
			action : 'AjaxEdit',
			fieldName: fieldName,
			value : value,
			id:pkv		
		}
		$.getJSON(url,param,function(json){
			//alert(param[msg]);
			obj.innerHTML = text.value;
		});		
	};	
}

//用于修改单价无刷新更新金额
//用于修改某一字段无刷新更新另一指定字段(目前只做到单价改变金额,数量改变金额)
function gridEdit2(obj,fieldName,pkv,value1,value2) {
	//debugger;	
	var oValue = value1;
	var controller = $.query.get('controller');
	var nValue = obj.value;
	if (nValue.length==0||nValue==oValue){
		obj.value = oValue;
		return false;
	}
	
	var newMoneyValue = value2 * nValue;
	//alert(fieldName);
	
	var url = "";
	var param = {
		controller:controller,
		action : 'AjaxEdit',
		fieldName: fieldName,
		value : nValue,
		id:pkv,
		newMoneyValue:newMoneyValue
	}
	//debugger;
	$.getJSON(url,param,function(json){
		obj.value = nValue;
		var fName = fieldName+"[]";
		var arrFName = document.getElementsByName(fName);
		var money = document.getElementsByName('money[]');
		var found=false;
		for (var i=0;i<arrFName.length;i++){
			if (arrFName[i]==obj) {
				found=true;
				break;
			}
		}
		if(found) money[i].value= newMoneyValue;
	});
}



