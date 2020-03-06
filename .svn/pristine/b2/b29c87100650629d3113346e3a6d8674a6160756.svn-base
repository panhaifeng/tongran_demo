function beginSet(obj,id) {
	//debugger;
	if (obj.childNodes.length>1){
		return false;
	}
	obj.innerHTML="<input name='textDanjia' type=text value='"+ (obj.innerText||obj.textContent) + "' size=4><input type=button value='改' onclick='setDanjia(this,"+id+")' name='btnDanjia'>";
	obj.childNodes[0].select();obj.childNodes[0].focus();
}
function setDanjia(btn,id) {
	//debugger;
	var texts = document.getElementsByName('textDanjia');
	var btns = document.getElementsByName('btnDanjia');
	var span = btn.parentNode;
	
	var index = 0;
	for(var i=0;i<btns.length;i++) {
		if (btns[i]==btn){
			index=i;break;
		}
	}
	
	
	var url='?controller=Trade_Dye_Order&action=SetPriceAjax';
	var param = {id:id,danjia:texts[index].value};
	$.getJSON(url,param,function(json){
		span.innerHTML=param.danjia;
	});
}