/*var TmisGrid = function () {
}
var TmisGrid.edit = function (obj,fldName,value) {
	alert(obj.id);
}
alert('asdf');
*/
function gridEdit(obj,fieldName,pkv,action) {
	if(!action) action='AjaxEdit';
	var tag = obj.firstChild.tagName;
	if (typeof(tag) != "undefined" && tag.toLowerCase() == "input"){
		return;
	}
	var oValue = obj.innerHTML;	
	var text = document.createElement('input');
	text.style.width = (obj.offsetWidth + 12) + "px" ;
	text.style.margin = "0px" ;
	text.style.padding = "0px" ;
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
		var url = "?controller="+controller+"&action="+action;
		var param = {			
			fieldName: fieldName,
			value : value,
			id:pkv		
		}
		debugger;
		$.get(url,param,function(json){
			//alert(param[msg]);
			debugger;
			if(!json.success) {
				alert(json.msg);
				return false;
			}
			
			obj.innerHTML = text.value;
		},'json');		
	};	
}