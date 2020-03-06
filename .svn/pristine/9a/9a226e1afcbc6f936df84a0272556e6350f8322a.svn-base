/**
*自动提示效果，仿google效果,开发者曾峰，2008-1-11
*调用举例
*
*$(function(){
*	var obj=需要出现提示效果的文本框元素
*	var url= ajax服务器地址
*	new TmisSuggest.AutoSuggest(obj,null,[{
*		RequestUrl: url,		
*		OverWidth: 0//设置是否超出obj的宽度
*	}]);
*});
*
*/

var TmisSuggest = new Object();
TmisSuggest.AutoSuggest = function(oTextbox,/*:HTMLInputElement*/
									oOtherbox,/*:HTMLButtonElement*/
									oParameter/*:JSON*/
									){
	this.cur = -1;
    this.layer = null;
	this.Parm = oParameter;
    this.textbox = oTextbox;
	this.button = oOtherbox;
    this.timeoutId = null;
    this.userText = oTextbox.value;
	//this.Fun = new TmisSuggest.jFunction();
    this.init();
}

TmisSuggest.AutoSuggest.prototype.name = function(){
	if (this.textbox.value=="")
		return null;
	else
		return this.textbox.value;
}

TmisSuggest.AutoSuggest.prototype.value = function(){
	if (this.textbox.value=="")
		return null;
	else
		return this.textbox.getAttribute("data_value");
}

TmisSuggest.AutoSuggest.prototype.toString = function (){
	return "自动提示控件类 " + this.Version;
}
TmisSuggest.AutoSuggest.toString = function (){
	return "自动提示控件类 " + this.Version;
}
TmisSuggest.AutoSuggest.prototype.init = function () {
    //保存参考对象
    var oThis = this; 
	loadCss("Resource/Css/Suggest.css");
	
	//对textbox添加onkeyup事件。
    this.textbox.onkeyup = function (oEvent) {
            if (!oEvent) {
            oEvent = window.event;
        } 
        oThis.handleKeyUp(oEvent);
    };
    
    //对textbox添加onkeydown事件
    this.textbox.onkeydown = function (oEvent) {
        if (!oEvent) {
            oEvent = window.event;
        }
        oThis.handleKeyDown(oEvent);
    };
    
    //对textbox添加onblur事件，隐藏提示框    
    this.textbox.onblur = function () {
        oThis.hideSuggestions();
    };
	
	if (this.button && this.button != null){
		this.button.onclick = this.textbox.onkeyup;
	};
	
    this.createDropDown();
}

TmisSuggest.AutoSuggest.prototype.requestSuggestToXML = function(bTypeAhead /*:boolean*/){
	var oThis = this;	
	var Url = oThis.Parm[0].RequestUrl;
	var params = {mnemocode:oThis.textbox.value};
	//[{RequestUrl: "",RequestString: "";Limit: 0,OverWidht: 0}]
	//开始ajax
	$.getJSON(Url,params,function (json) {
		if (!json) return false;
		oThis.autosuggest(json,bTypeAhead);
	});	
}

TmisSuggest.AutoSuggest.prototype.handleKeyUp = function (oEvent) {
    var iKeyCode = oEvent.keyCode;
	var iKeytype = oEvent.type;
    var oThis = this;
    
    this.userText = this.textbox.value;    
    clearTimeout(this.timeoutId);
    //退格键(8) 删除键(46), 在输入之前显示提示框
    if (iKeyCode == 8 || iKeyCode == 46) {
        if (this.userText!='') this.timeoutId = setTimeout( function () {
            oThis.requestSuggestToXML(false);
        }, 250);
        
    //其它键时则不进行任何操作
    } else if ((iKeyCode > 0 && iKeyCode < 32) || (iKeyCode >= 33 && iKeyCode < 46) || (iKeyCode >= 112 && iKeyCode <= 123)) {
        //ignore		
    } else {
        //显示提示
		if (iKeytype=="click")
			this.timeoutId = setTimeout( function () {
				oThis.requestSuggestToXML(true);
			}, 10);
		else
			this.timeoutId = setTimeout( function () {
				oThis.requestSuggestToXML(true);
			}, 250);
    }
}

TmisSuggest.AutoSuggest.prototype.handleKeyDown = function (oEvent) {
    switch(oEvent.keyCode) {
        case 38: //键提起
            this.goToSuggestion(-1);
            break;
        case 40: //键按下
            this.goToSuggestion(1);
            break;
        case 27: //esc键
            this.textbox.value = this.userText;
            this.selectRange(this.userText.length, 0);
            /* falls through */
			break;
        case 13: //回车键
            this.hideSuggestions();
            oEvent.returnValue = false;
            if (oEvent.preventDefault) {
                oEvent.preventDefault();
            }
            break;
    }
}

TmisSuggest.AutoSuggest.prototype.hideSuggestions = function () {
    this.layer.style.visibility = "hidden";
}

//创建下拉层，并不包含数据
TmisSuggest.AutoSuggest.prototype.createDropDown = function () {
	var oThis = this;
    //建立层
	if (oThis.Parm && oThis.Parm.length > 0){
		var Parms = oThis.Parm[0];
		var overWidth = Parms.OverWidth;
	}
    this.layer = document.createElement("div");
    this.layer.className = "suggest";
    this.layer.style.visibility = "hidden";
    this.layer.style.width = this.textbox.offsetWidth + overWidth;
    document.body.appendChild(this.layer);    
    
    //when the user clicks on the a suggestion, get the text (innerHTML)
    //and place it into a textbox   
    this.layer.onmousedown = 
    this.layer.onmouseup = 
    this.layer.onmouseover = function (oEvent) {
        oEvent = oEvent || window.event;
        oTarget = oEvent.target || oEvent.srcElement;

        if (oEvent.type == "mousedown") {
            oThis.textbox.value = oTarget.outerText;
			oThis.textbox.setAttribute("data_value",oTarget.getAttribute("value"));
            oThis.hideSuggestions();
        } else if (oEvent.type == "mouseover") {
            oThis.highlightSuggestion(oTarget);
        } else {
            oThis.textbox.focus();
        }
    }
}

TmisSuggest.AutoSuggest.prototype.autosuggest = function (aSuggestions /*:JSON*/,
                                                    bTypeAhead /*:boolean*/) {
    this.cur = -1;
    if (aSuggestions.length > 0) {
        if (bTypeAhead) {
           this.typeAhead(aSuggestions[0].name);
        }
        
        this.showSuggestions(aSuggestions);
    } else {
        this.hideSuggestions();
    }
}

TmisSuggest.AutoSuggest.prototype.getLeft = function (){

    var oNode = this.textbox;
    var iLeft = 0;
    
    while(oNode.tagName != "BODY") {
        iLeft += oNode.offsetLeft;
        oNode = oNode.offsetParent;        
    }
    
    return iLeft;
}

TmisSuggest.AutoSuggest.prototype.getTop = function (){

    var oNode = this.textbox;
    var iTop = 0;
    
    while(oNode.tagName != "BODY") {
        iTop += oNode.offsetTop;
        oNode = oNode.offsetParent;
    }
    
    return iTop;
}

//移动到与当前行指定间距的行上
TmisSuggest.AutoSuggest.prototype.goToSuggestion = function (iDiff) {
    var cSuggestionNodes = this.layer.childNodes[0].rows;
    
    if (cSuggestionNodes.length > 0) {
        var oNode = null;
    
        if (iDiff > 0) {
            if (this.cur < cSuggestionNodes.length-1) {
                oNode = cSuggestionNodes[++this.cur].cells[0];
            }        
        } else {
            if (this.cur > 0) {
                oNode = cSuggestionNodes[--this.cur].cells[0];
            }    
        }
        if (oNode) {
            this.highlightSuggestion(oNode);
            this.textbox.value = oNode.outerText||oNode.textContent;
			this.textbox.setAttribute("data_value",oNode.getAttribute("value"),0);
        }
    }
}
//高亮显示某行
TmisSuggest.AutoSuggest.prototype.highlightSuggestion = function (oSuggestionNode) {
    for (var i=0; i < this.layer.childNodes[0].rows.length; i++) {
        var oNode = this.layer.childNodes[0].rows[i].cells[0];
		
        if (oNode == oSuggestionNode) {
            oNode.className = "current";
        } else if (oNode.className == "current") {
            oNode.className = "";
        }
    }
}

TmisSuggest.AutoSuggest.prototype.selectRange = function (iStart /*:int*/, iEnd /*:int*/) {

    //use text ranges for Internet Explorer
    if (this.textbox.createTextRange) {
        var oRange = this.textbox.createTextRange(); 
        oRange.moveStart("character", iStart); 
        oRange.moveEnd("character", iEnd - this.textbox.value.length);      
        oRange.select();
        
    //use setSelectionRange() for Mozilla
    } else if (this.textbox.setSelectionRange) {
        this.textbox.setSelectionRange(iStart, iEnd);
    }     

    //set focus back to the textbox
    this.textbox.focus();      
}
//将aSuggestions这个对象形成表格，并附加在layer上
TmisSuggest.AutoSuggest.prototype.showSuggestions = function (aSuggestions /*:JSON*/) {
	
    this.layer.innerHTML = "";  //clear contents of the layer
    
/*    for (var i=0; i < aSuggestions.length; i++) {
        oDiv = document.createElement("div");
        oDiv.appendChild(document.createTextNode(aSuggestions[i]));
        this.layer.appendChild(oDiv);
    }*/
	var oTable = document.createElement("table");
	oTable.width = "100%";
	for (var i=0; i < aSuggestions.length; i++) {
        var row  = oTable.insertRow(-1);
		var td = row.insertCell(-1);
		td.setAttribute("value",aSuggestions[i].values);
		td.setAttribute("noWrap",true);
		
		var text = aSuggestions[i].name;
		var reg = eval("/^"+this.userText+"/gi");
		var arr = reg.exec(text);
		if (arr != null) text = text.replace(arr,"<b>"+ arr +"</b>");
		
        td.innerHTML = text;        
	}
	this.layer.appendChild(oTable);
    
    this.layer.style.left = this.getLeft() + "px";
    this.layer.style.top = (this.getTop()+this.textbox.offsetHeight) + "px";
    this.layer.style.visibility = "visible";

}

TmisSuggest.AutoSuggest.prototype.typeAhead = function (sSuggestion /*:String*/) {
    if (this.textbox.createTextRange || this.textbox.setSelectionRange){
        var iLen = this.textbox.value.length; 
        this.textbox.value = sSuggestion; 
        this.selectRange(iLen, sSuggestion.length);
    }
}