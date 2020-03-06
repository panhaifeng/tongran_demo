<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery1.10.1.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.query.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" src="Resource/Script/TmisSuggest.js"></script>
<script language="javascript" src="Resource/Script/ymPrompt/ymPrompt.js"></script>
<script language="javascript" src="Resource/Script/jquery.autocomplete.js"></script>
<link href="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="Resource/Script/Calendar/WdatePicker.js"></script>
<link href="Resource/Css/Edit100.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/jquery.autocomplete.css" type="text/css" rel="stylesheet" />
{literal}
<script language="javascript">
var table;
var _cacheChandi = new Array();
var dataLoding = false;//染色计划数据加载标志，防止按回车后加载两次。
var _cacheKucun = new Array();
var _cacheCnt = new Array();
$(function(){
	getTKg();
	table = document.getElementById('tbl');
	getColor();
	//document.getElementById('form2').onsubmit = checkForm;
	document.getElementById('form1').onsubmit = checkForm;
	if($('#clientId').val()>0) {
		var cd = document.getElementsByName('chandi[]');
		var w = document.getElementsByName('wareId[]');
		var pihao = document.getElementsByName('pihao[]');
		linkageChandi(cd[cd.length-1],w[w.length-1].value, $(pihao[pihao.length-1]).val());
	}
});

$(function(){
	document.getElementById('form1').onsubmit = function(){
		return checkForm();
		$('[name="submit"]').disabled=true;
	};
	document.onkeydown = function(e){
		//可以用上下键移动的控件序列，用来标志移动的顺序
		var cellNames = ['color[]','colorNum[]','cntKgJ[]','cntKgW[]','cntKg[]'];
		var ev = document.all ? window.event : e;
		//debugger;
		//假如不是回车和方向键，则返回
		if(ev.keyCode!=13&&ev.keyCode!=37&&ev.keyCode!=38&&ev.keyCode!=39&&ev.keyCode!=40) return true;

		var target = document.all ? ev.srcElement : ev.target;
		//找到和target的name相同的所有元素
		var ts = document.getElementsByName(target.name);
		if (target.id=="ranshaNum") return false;
		//找到位置
		for (var i=0;i<ts.length;i++) {
			if (target==ts[i]) {
				var pos =i;
				break;
			}
		}

		//如果回车,cab
		if(ev.keyCode==13 && target.type!='button' && target.type!='submit' && target.type!='reset' && target.type!='textarea' && target.type!='')  {
			if (document.all) ev.keyCode=9;
			else return false;
		}
		if(ev.keyCode==39||ev.keyCode==37) {//如果是左37或右39,平移
			//客户要在 文本框中左右移动修改  所以要注销左右跳到下一个文本框 by zcc 2017年11月9日 14:24:02
			// if (ev.keyCode==37){//左移
			// 	//如果是最左返回
			// 	if (target.name==cellNames[0]) return false;
			// 	//否则往左移动
			// 	for(var i=0;i<cellNames.length;i++){
			// 		if(cellNames[i]==target.name) {
			// 			//document.getElementsByName(cellNames[i-1])[pos].focus();
			// 			document.getElementsByName(cellNames[i-1])[pos].select();
			// 			return false;
			// 		}
			// 	}
			// } else if (ev.keyCode==39){//右移
			// 	//如果是最右返回
			// 	if (target.name==cellNames[cellNames.length]) return false;
			// 	//否则往右移动
			// 	for(var i=0;i<cellNames.length;i++){
			// 		if(cellNames[i]==target.name) {
			// 			document.getElementsByName(cellNames[i+1])[pos].select();
			// 			return false;
			// 		}
			// 	}
			// }
		} else if(ev.keyCode==38||ev.keyCode==40) {//如果是上38下40,竖直移动
			if(ev.keyCode==40&&pos<ts.length-1) ts[pos+1].focus();
			if(ev.keyCode==38&&pos>0) ts[pos-1].select();
		}
	}
});


$(function(){
	/*在接口地址参数错误时，作提示*/
	window.onerror = function(msg, url, line){
		if(msg=="Script error"){
			dataLoding = false;
			$("#jhLoading").hide();
			alert("警告：请查询握手接口地址是否正确！");
			return true;
		}
		return false;
	};
	$("#clientId").bind("change", function(){
		var clientId = $(this).val();
		if(clientId){
			getClient(clientId);
		}
	});



	$("#ransheTr").hide();
	$("#rsSazhiHead").hide();
	$(".rsSazhiTd").hide();
	$("#jhLoading").hide();
	//alert(1);
	getClient($("#clientId").val());
});
//根据clientID判断是否需要显示染纱计划单号
function getClient(clientId){
	//alert(1);
	if (!clientId){
		return;
	}
	var url   = '?Controller=Jichu_Client&Action=getSingleInfoByAjax';
	var param = {clientId: clientId};
	$.getJSON(url, param, function(json){
		if(!json.success) {
		    alert(json.msg);
		    return false;
		}else{
			setValue(json.data[0]);
			return true;
		}
	});
}
//获得染纱计划数据
//obj: 提示对象
//iurl: 接口地址
//idata: 染纱计划单号
function getRansaData(obj, iurl, idata){
	var param = {
		jiHuaNum: !idata ? obj.val().toUpperCase() : idata
	};

	var loadSuccess = false;
	$("#jhLoading").show();
	$.getJSON(iurl+"&callback=?", param, function(json){
		loadSuccess = true;
		$("#jhLoading").hide();
		if(!json.success) {
		    alert(json.msg);
		    return false;
		}else{
			numbers = json.rsNums.split(",");
			var isShow = numbers.length == 1 ? false : true;
			if (!isShow){
				getIshaveRanshaNum(param.jiHuaNum, iurl, json.data);
				return true;
			}
			obj.autocomplete({
				data: numbers,
				delay: 100,
				multiple: false,
				minChars: 1,
				useCache:false,
				sortResults:false,
				autoShow: isShow,
				onItemSelect: function(data){
					getRansaData(null, iurl, data.value);
				}
			});
			return true;
		}
	});

	var testURL = function(){
		if (!loadSuccess){
			dataLoding = false;
			alert("警告：握手接口地址超时，请确认是否联网！");
			$("#jhLoading").hide();
		}
	}

	//如果5秒后loadSuccess还为false，则提示接口地址超时
	setTimeout(testURL, 5000);
}

//获得此计划单号是否已经安排
function getIshaveRanshaNum(objValue, iurl, idata){
	// alert(objValue)
	if (!objValue) return;
	var param = {
		ranshaNum: objValue.toUpperCase()
	};
	var url = "?Controller=Trade_Dye_Order&Action=GetRsJihua";
	$.getJSON(url, param, function(json){
		dataLoding = false;
		if(!json.success) {
		    alert(json.msg);
		    return false;
		}else{
			addRanseRow(idata);
			// getRansaData(obj, iurl);
			return true;
		}
	});
}
//获得客户资料后设置相关参数
function setValue(obj){
	var url = obj.iURL;
	$('#paymentWay').val(obj.paymentWay);
	if (obj.isShow==1) {
		$('#memo').val(obj.special_memo);
		$('#qita_memo').val(obj.qita_memo);
		$('#packing_memo').val(obj.packing_memo);
	}
	var ransheTr = $("#ransheTr");
	var ransheDataHead = $("#rsSazhiHead");
	var ransheDataBody = $(".rsSazhiTd");
	if(url && $('#orderId').val()==''){
		ransheTr.show();
		ransheDataHead.show();
		ransheDataBody.show();

		var ranshaNum = $("#ranshaNum");

		ranshaNum.bind("keyup", function(e){
			if (dataLoding) return;//防止重复查询
			if (e.keyCode != 13) return false;
			dataLoding = true;
			getRansaData(ranshaNum, url);
		});
	}else{
		ransheTr.hide();
		ransheDataHead.hide();
		ransheDataBody.hide();
	}
}
//添加染色计划行
function addRanseRow(objs){
	var trs = $(".dataRow");
	var tr = $(trs[trs.length-1]);
	$.each(objs, function(i, v){
		var newTr = tr.clone(true);
		$('[name="id[]"]',newTr).val('');
		var rsSazhi       = newTr.find("#rsSazhi");
		var rsSazhiInput  = newTr.find("[name='randanShazhi[]']");
		var rsColor       = newTr.find("[name='color[]']");
		var rsJing        = newTr.find("[name='cntKgJ[]']");
		var rsWei         = newTr.find("[name='cntKgW[]']");
		var rsJingweiHeji = newTr.find("[name='cntKg[]']");

		rsSazhi.text(v.rsSazhi);
		rsSazhiInput.val(v.rsSazhi);
		rsColor.val(v.rsColor);
		rsJing.val(v.rsJing);
		rsWei.val(v.rsWei);
		rsJingweiHeji.val(v.rsJingweiHeji);

		tr.after(newTr);
	});
	trs.remove();

	//计算合计
	var total = 0;
	$("[name='cntKg[]']").each(function(i, v){
		total += $(v).val() ? parseFloat($(v).val()) : 0;
	});
	$("#spanTKg").text(total.toFixed(1));
}
//提交判断字段
function checkForm(){
	if(document.getElementById('clientId').value=='') {
		alert('必须选择客户!');
		return false;
	}
	//业务员必填
	if(document.getElementById('traderId').value=='') {
		alert('必须选择业务员!');
		return false;
	}
	//第一步 先找出选择纱支的明细行 
	var wareId = document.getElementsByName('wareId[]');
	var danjia = document.getElementsByName('danjia[]');
	var money = document.getElementsByName('money[]');
	for (var i = 0; i < wareId.length; i++) {
		if(wareId[i].value!=''){//当纱支存在 则去判断 对应的行 中单价和 小缸价
			var danjiaV = parseFloat(danjia[i].value||0);
			var moneyV = parseFloat(money[i].value||0);
			if (danjiaV==0 && moneyV==0) {
				alert('订单明细中，单价和小缸价必填一项！请检查填写后再进行保存！')
				return false;
			}
		}
	}
	return true;
}
function addRow() {
	var trs = $('.dataRow');
	var len = trs.length;
	for(var i=0;i<5;i++) {
		var newTr = trs.eq(len-1).clone(true);
		$('input,select',newTr).each(function(i, o){
			var oName = $(o).attr("name");
			if (oName == "color[]" || oName == "cntKgJ[]" || oName == "cntKgW[]" || oName == "cntKg[]" || oName == "id[]" || oName == "randanShazhi[]"){
				$(o).val("");
			}
		});
		$('[id="wareId[]"]',newTr).attr('targetMenu',null);
		$('[id="rsSazhi"]',newTr).html('');
		$('[name="color[]"]',newTr).attr("AutoComplete",null);
		trs.eq(len-1).after(newTr);
	}
	getColor();//使新增行的颜色在输入时有提示
}
//增加一行
function addOneRow(){
	var trs = $('.dataRow');
	var len = trs.length;
	var newTr = trs.eq(len-1).clone(true);
	$('input,select',newTr).each(function(i, o){
		var oName = $(o).attr("name");
		if (oName == "color[]" || oName == "cntKgJ[]" || oName == "cntKgW[]" || oName == "cntKg[]" || oName == "id[]" || oName == "randanShazhi[]"){
			$(o).val("");
		}
	});
	$('[id="wareId[]"]',newTr).attr('targetMenu',null);
	$('[id="rsSazhi"]',newTr).html('');
	$('[name="color[]"]',newTr).attr("AutoComplete",null);
	trs.eq(len-1).after(newTr);
	getColor();//使新增行的颜色在输入时有提示
}

function delRow(obj){
	var arrButton = document.getElementsByName('btnDel');
	///var rev = document.getElementsByName('ifRemove[]');
	var pos = -1;
	for(var i=0;arrButton[i];i++) {
		if(obj==arrButton[i]) {
			pos=i;break;
		}
	}
	if(pos<0) return false;

	var ids = document.getElementsByName('id[]');

	//如果只有一个新增行，禁止删除(移除 只保留最后一条)
	// if(ids.length==1 || (pos+1==ids.length && ids[pos].value=='' && (ids[pos-1].value)>0)) return false;
	if(ids.length==1) return false;
	//alert(ids.length);return false;
	if(ids[pos].value>0) {//如果当前id>0,需要用ajax从数据库中删除
		if(!confirm("警告：该操作将删除该颜色计划及已经计划过的所有缸,您确认吗?")) return false;
		var url = "?controller=Trade_Dye_Order&action=RemoveWare";
		var param = {id:ids[pos].value};
		$.getJSON(url,param,function(json){
			if(!json.success) {
				alert(json.msg);
				return false;
			}
			table.deleteRow(pos+2);
		});
	} else {
		table.deleteRow(pos+2);
	}
}

//将所有颜色控件改写为自动提示
function getColor(){
	var arr = document.getElementsByName('color[]');
	for (var i=0;i<arr.length;i++) {
		if(arr[i].getAttribute('AutoComplete')=='off') continue;
		arr[i].setAttribute("AutoComplete", "off");
		new TmisSuggest.AutoSuggest(arr[i],null,[{
			RequestUrl: "?controller=JiChu_Color&action=GetSuggestJson",
			OverWidth: 0
		}]);
	}
}
//计算经纱和纬纱的总用量
function getCnt(obj) {
	var js = document.getElementsByName('cntKgJ[]');
	var ws = document.getElementsByName('cntKgW[]');
	var kg = document.getElementsByName('cntKg[]');
	var pihao = document.getElementsByName('pihao[]');
	var chandi = document.getElementsByName('chandi[]');
	var wareId = document.getElementsByName('wareId[]');
	var id = obj.id;

	var kuCun = document.getElementsByName('kuCun[]');
	var objs = document.getElementsByName(id);
	var pos = -1;
	for (var i=0;i<objs.length;i++) {
		if(objs[i]==obj) {
			pos = i;break;
		}
	}
	var a = (parseFloat(js[i].value||0)+parseFloat(ws[i].value||0)).toFixed(1)*1;
	var b = parseFloat(kuCun[i].value||0).toFixed(1)*1;
	var c = _cacheKucun[wareId[i].value+','+pihao[i].value+","+chandi[i].value];
	var sum = GetCntKg(objs,wareId[i].value,pihao[i].value,chandi[i].value);
	if (sum>c) {
		alert('投料数大于库存数！');
		objs[i].value=0;
		// return false;
	}
	kg[i].value= (parseFloat(js[i].value||0)+parseFloat(ws[i].value||0)).toFixed(2);
	getTKg();
}
function GetCntKg(obj,a,b,c){
	var num = 0;
	$('[name="cntKgJ[]"]').each(function(){
		var tr = $(this).parents('.dataRow');
		if ($('[name="wareId[]"]',tr).val()==a) {
			if ($('[name="pihao[]"]',tr).val()==b) {
				if ($('[name="chandi[]"]',tr).val()==c) {
					var cntKgJ =parseFloat($('[name="cntKgJ[]"]',tr).val()||0);
					var cntKgW =parseFloat($('[name="cntKgW[]"]',tr).val()||0);
					num =num+cntKgJ+cntKgW;
				}
			}
		}
	});
	return num;
}
// function checkForm(){
// 	//客户必填
// 	if(document.getElementById('clientId').value=='') {
// 		alert('必须选择客户!');
// 		return false;
// 	}
// 	//业务员必填
// 	if(document.getElementById('traderId').value=='') {
// 		alert('必须选择业务员!');
// 		return false;
// 	}
// 	return true;
// }
function popMenu(e) {
	return false;//让这个功能失效
	// debugger;
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',2,false,function(json) {
		//alert(1);
		var arr = explode("||",json.text);
		//取得位置
		var pos=0;
		var id = "wareId[]";
		var arr1 = document.getElementsByName(id);
		for (var i=0;i<arr1.length;i++) {
			if (arr1[i]==e) {
				pos =i;
				break;
			}
		}

		document.getElementsByName('spanWareName')[pos].innerHTML = arr[0]?arr[0]:'&nbsp;';
		document.getElementsByName('spanGuige')[pos].innerHTML = arr[1]?arr[1]:'&nbsp;';

		//取得产地列表
		//清空o.option
		var o = document.getElementsByName('chandi[]')[pos];
		var p = document.getElementsByName('pihao[]')[pos];
		getPihao(p,e);
		getChandi(o,e);
		coloneShazhi(e);
	});
}
//该造  根据订单类型来获取客户仓库和本厂仓库中的批号
function getPihao(o,e,v){
	if(!e.value) return false;
	while (o.options && o.options.length>1) {o.remove(1);};
	var url='?controller=Cangku_Ruku&action=GetJsonPihao';
	var params={clientId:$('#clientId').val(),wareId:e.value,kind:$('#kind').val()};
	$.getJSON(url, params, function(json){
		//设置o的option
		for (var i=0;i<json.length;i++){
			var opt=new Option(json[i].pihao,json[i].pihao);
			o.options.add(opt);
		}
		if (v) {
			o.value = v;
		}
	});
}
function changeWare(e){
	var id = $(e).val();
	var tr = $(e).parents('.dataRow');
	var url='?controller=JiChu_Ware&action=GetWare';
	var params = {id:id};
	$.get(url, params, function(json){
		if (json) {
			$('[name="spanWareName"]',tr).text(json.wareName);
			$('[name="spanGuige"]',tr).text(json.guige);
		}else{
			alert("不存在该纱支的Id!");
			$(e).val('');
			return false;
		}
	},'json');

}
function getChandi(o,e,v){
	if(!e.value) return false;
	while (o.options && o.options.length>1) {o.remove(1);};
	var url='?controller=Cangku_Ruku&action=GetJsonChandiNew';
	var params={clientId:$('#clientId').val(),wareId:e.value,kind:$('#kind').val()};
	$.getJSON(url, params, function(json){
		//设置o的option
		for (var i=0;i<json.length;i++){
			var opt=new Option(json[i].chandi,json[i].chandi);
			o.options.add(opt);
		}
		if (v) {
			o.value = v;
		}
	}) ;
}
function linkageChandi(o, wareId, pihao){
	if(!wareId) return false;
	while (o.options && o.options.length>1) {o.remove(1);};
	var url='?controller=Cangku_Ruku&action=GetJsonChandiByPihao';
	var params={clientId:$('#clientId').val(),wareId:wareId, pihao:pihao,kind:$('#kind').val()};
	$.getJSON(url, params, function(json){
		var length = json.length;
		//设置o的option
		// for (var i=0; i<length; i++){
		// 	var opt=new Option(json[i].chandi,json[i].chandi);
		// 	o.options.add(opt);
		// }
		// if(length == 1)
		// {
		// 	o.selectedIndex = 1;
		// }
		o.value = json[0].chandi;
	}) ;
}
function beginUp(obj,id){
	var cnt = obj.innerText;
	//取得innerText
	obj.innerHTML="<input type=text size=3 value='"+cnt+"'><input type=button value='√' onClick=\"update(this,"+id+")\">";
}
function update(buttonObj,id) {	//取得text的值
	var span = buttonObj.parentNode;
	var text = span.childNodes[0];
	var button = span.childNodes[1];
	var url = "?controller=Trade_Dye_Order2Ware&action=jsonUpdate";
	var params = {id:id,cnt:text.value};	//开始json
	$.getJSON(url, params, function(json){
		span.innerHTML=text.value;
	});
}

function selWare(obj) {
	// var url="?controller=jichu_ware&action=PopupPishaOfften";
	var clientId = $('#clientId').val();
	if (!clientId) {
		alert('客户未选择！请选择客户后在进行操作！');
		return false;
	}
	var kind = $('#kind').val();
	if (kind==0) {
		var url="?controller=Trade_Dye_Order&action=Popup&clientId="+clientId;
	}else{
		var url="?controller=Trade_Dye_Order&action=PopupBc";
	}
	ymPrompt.win({message:url,handler:callBack,width:550,height:400,title:'选择纱支',iframe:true});
	return false;
	function callBack(ret){
			if(!ret || ret=='close') return false;

			var btns = document.getElementsByName('btnSel');
			var pos = -1;
			for (var i=0;btns[i];i++) {
				if(btns[i]==obj) {
					pos=i;break;
				}
			}
			if(pos==-1) return false;
			// 判断行数是否足够，不够，则增加相应行
			var needRow = ret.length - (btns.length - pos);
			for (var i = 0; i < needRow; i++) {
				addOneRow();
			};
			var texts = document.getElementsByName('wareId[]');
			var spanWareName = document.getElementsByName('spanWareName');
			var spanGuige = document.getElementsByName('spanGuige');
			var wareNameBc = document.getElementsByName('wareNameBc[]');
			var pihao = document.getElementsByName('pihao[]');
			var chandi = document.getElementsByName('chandi[]');
			//处理返回的结果
			for (var i = 0; i <ret.length; i++) {
				var index = parseFloat(pos)+parseFloat(i);
				texts[index].value= ret[i].id;
				spanWareName[index].innerHTML= ret[i].wareName;
				spanGuige[index].innerHTML= ret[i].guige;
				wareNameBc[index].value = ret[i].wareNameBc;
				pihao[index].value = ret[i].pihao;
				chandi[index].value = ret[i].chandi;
				//把得到的库存 保存到缓存中
				_cacheKucun[ret[i].id+","+ret[i].pihao+","+ret[i].chandi] = ret[i].kuCun;
				//刷新产地信息
				// getChandi(document.getElementsByName('chandi[]')[index],texts[index],ret[i].chandi)
				// getPihao(document.getElementsByName('pihao[]')[index],texts[index],ret[i].pihao)
				document.getElementsByName('kuCun[]')[index].value = ret[i].kuCun;
				coloneShazhi(obj);

			}
	}
}
function getTKg(){
	var k = document.getElementsByName('cntKg[]');
	var t=0;
	for (var i=0;k[i];i++) {
		//alert(t+parseFloat(k[i].value));
		t+=parseFloat(k[i].value||0);
	}
	document.getElementById('spanTKg').innerHTML = t;
}

//导入的染纱计划单，选择某个纱支后，相同纱支的进行复制
//2013-8-22 by jeff
function coloneShazhi(obj) {
	//debugger;
	//randanShazhi[],dataRow
	//取得本行的染单纱支
	var tr = $(obj).parents('.dataRow');
	var shazhi = $('[name="randanShazhi[]"]',tr).val();
	var wareName = $('#spanWareName',tr).text();
	var guige = $('#spanGuige',tr).text();
	var wareId = $('[name="wareId[]"]',tr).val();
	if(shazhi=='') return;
	if(wareId=='') return;

	$('.dataRow').each(function(){
		if($('[name="randanShazhi[]"]',this).val()==shazhi && $('[name="wareId[]"]',this).val()=='') {
			//wareId[],spanWareName,spanGuige
			//alert(wareName+guige+wareId);
			$('#spanWareName',this).text(wareName);
			$('#spanGuige',this).text(guige);
			$('[name="wareId[]"]',this).val(wareId);
		}
	});
}
function ChangePihao(obj){
	if (obj.value=='') return false;
	var tr = $(obj).parents('.dataRow'),
		chandi = $("[name='chandi[]']",tr);
	var wareId = $("[name='wareId[]']",tr).val();
	var url='?controller=Cangku_Ruku&action=GetKucun';
	var params={clientId:$('#clientId').val(),wareId:wareId,pihao:obj.value};
	$.getJSON(url, params, function(json){
		$("[name='kuCun[]']",tr).val(json.kucun);
		// 绑定产地
		linkageChandi(chandi[0],wareId,obj.value);
	}) ;
}
function getMoney(obj){
	var danjia=document.getElementsByName('danjia[]');
	var money=document.getElementsByName('money[]');
	var pos=-1;
	for(var i=0;danjia[i];i++){
		if(danjia[i]==obj||money[i]==obj){
			pos=i;
		}
	}
	if(pos==-1)return false;
	//alert(danjia[pos].value);alert(money[pos].value);return false;
	if(danjia[pos].value!=0&&money[pos].value!=0){
		alert('单价和小缸价只能填写一个,请确认后重新填写！');
		if(danjia[pos].value!=0){
			money[pos].value='';
		}else{
			danjia[pos].value=''
		}
	}
}
function saveRow(obj){
	//新增字段时  请这边也进行增加
	var arrButton = document.getElementsByName('btnSave');
	var wareId = document.getElementsByName('wareId[]');
	var wareNameBc = document.getElementsByName('wareNameBc[]');
	var color = document.getElementsByName('color[]');
	var pihao = document.getElementsByName('pihao[]');
	var chandi = document.getElementsByName('chandi[]');
	var colorNum = document.getElementsByName('colorNum[]');
	var ganghaoKf = document.getElementsByName('ganghaoKf[]');
	var kuanhao = document.getElementsByName('kuanhao[]');
	var dateJiaoqi = document.getElementsByName('dateJiaoqi[]');
	var zhelvMx = document.getElementsByName('zhelvMx[]');
	var isJiaji = document.getElementsByName('isJiaji[]');
	var cntKgJ = document.getElementsByName('cntKgJ[]');
	var cntKgW = document.getElementsByName('cntKgW[]');
	var cntKg = document.getElementsByName('cntKg[]');
	var danjia = document.getElementsByName('danjia[]');
	var money = document.getElementsByName('money[]');
	var memo = document.getElementsByName('memo[]');
	var personDayang = document.getElementsByName('personDayang[]');
	var id = document.getElementsByName('id[]');
	///var rev = document.getElementsByName('ifRemove[]');
	var pos = -1;
	for(var i=0;arrButton[i];i++) {
		if(obj==arrButton[i]) {
			pos=i;break;
		}
	}
	if(pos<0) return false;
	var tr =$(obj).parents('tr'); 
	var url='?controller=Trade_Dye_Order&action=AjaxSaveRow';
	var params={orderId:$('#orderId').val(),wareId:wareId[pos].value,pihao:pihao[pos].value,wareNameBc:wareNameBc[pos].value,color:color[pos].value,chandi:chandi[pos].value,colorNum:colorNum[pos].value,ganghaoKf:ganghaoKf[pos].value,kuanhao:kuanhao[pos].value,dateJiaoqi:dateJiaoqi[pos].value,zhelvMx:zhelvMx[pos].value,isJiaji:isJiaji[pos].checked,cntKgJ:cntKgJ[pos].value,cntKgW:cntKgW[pos].value,cntKg:cntKg[pos].value,danjia:danjia[pos].value,money:money[pos].value,memo:memo[pos].value,personDayang:personDayang[pos].value,id:id[pos].value};
	$.getJSON(url, params, function(json){
		if (json.success==true) {
			alert(json.msg);
			//再把界面的单行的id 添加上,修改时 不添加
			if (json.id) {
				id[pos].value = json.id;
			}

		}else{
			alert(json.msg);
		}
	}) ;

}
/**
 * ps ：选着单选框 赋值隐藏域
 * Time：2017年11月29日 17:57:30
 * @author zcc
*/
function changeCheckd(o) {
	var tr = $(o).parents('.dataRow');
	if (o.checked===true) {
		$("[name='isJiajiV[]']",tr).val('1');
	}else{
		$("[name='isJiajiV[]']",tr).val('');
	}
}
</script>
<style type="text/css">
.table100{text-align:center;}
.th td{height:15px;}
.txt { width:70px}
.Num{
	font-size: 24px;
	color: #319CB3;
	line-height: 24px;
	width: 200px;
}
#jhLoading{
	padding-left: 10px;
	color: #FF000;
}
#divPro {
	width: 100%;
	height: 200px;
	overflow: scroll;;
	border: 1px solid #999;
}
</style>
{/literal}
</head>

<body>
<div id="container">
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveWare'}" method="post">
<fieldset>
<legend>合同信息( * 为必填项)</legend>
<table class="tableHaveBorder table100" style=" text-align:left">
          <tr>
            <td class="tdTitle">合同编号：</td>
			<td><input name="orderCode" type="text" id="orderCode" value="{$arr_field_value.orderCode}" size="15" readonly="readonly"></td>
			<td class="tdTitle">业务员*：</td>
			<td><select name="traderId" id="traderId" warning='请选择'>
              {webcontrol type='TmisOptions' model='JiChu_Employ' selected=$arr_field_value.traderId condition='depId=11'}
			  </select></td>
			<td class="tdTitle">客户*：</td>
			<td colspan="3">{webcontrol type='ClientSelect' selected=$arr_field_value.Client arType='1'}
			  <input type="text" name="orderCode2" id="orderCode2" size="10" value="{$arr_field_value.orderCode2}" title="客户单号" emptyText='客户单号' placeholder='客户单号'>
			  [ <a href="javascript:void(0)" onClick='window.open("{url controller="CangKu_Report_Month" action="ClientPishaKucun" clientId=$rows[0].Order.clientId}&clientId="+document.getElementById("clientId").value)'>查看该客户坯纱库存</a> ] </td>
		  </tr>

          <tr>
            <td class="tdTitle">签约日期：</td>
            <td><input name="dateOrder" type="text" id="dateOrder"  value="{$arr_field_value.dateOrder|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
            <td class="tdTitle">产品大类：</td>
			<td><select name="saleKind" id="saleKind" warning='请选择' check='^0$'>
              {webcontrol type='TmisOptions' model='JiChu_SaleKind' selected=$arr_field_value.saleKind }
            </select>
			</td>

			<td class="tdTitle">质量要求等级：</td>
			<td><select name="zhiliang" id="zhiliang">
                <option value="A" >A类(精品)</option>
                <option value="B" >B类(外贸)</option>
                <option value="C" selected >C类(一般)</option>
               </select></td>
            <td class="tdTitle">烘干要求：</td>
			<td>
				<select name="honggan" id="honggan">
					<option value="要烘干" {if $arr_field_value.honggan=='要烘干'}selected{/if}>要烘干</option>
					<option value="不要烘干" {if $arr_field_value.honggan=='不要烘干'}selected{/if}>不要烘干</option>
					<option value="含水率&lt;5%" {if $arr_field_value.honggan=='含水率&lt;5%'}selected{/if}>含水率&lt;5%</option>
					<option value="微波" {if $arr_field_value.honggan=='微波'}selected{/if}>微波</option>
					<option value="热风" {if $arr_field_value.honggan=='热风'}selected{/if}>热风</option>
				</select>
		  </tr>
          <tr>
            <td class="tdTitle">交货日期：</td>
            <td><input name="dateJiaohuo" type="text" id="dateJiaohuo"  value="{$arr_field_value.dateJiaohuo|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
            <td class="tdTitle">翻单：</td>
            <td><input name="isFandan" type="checkbox" id="isFandan" value="1" {if $arr_field_value.isFandan==1} checked="checked" {/if}></td>
            <td class="tdTitle">空捻：</td>
            <td><input name="isKongnian" type="checkbox" id="isKongnian" value="1" {if $arr_field_value.isKongnian==1} checked="checked" {/if}></td>
            <td class="tdTitle">回倒要求：</td>
            <td>
            	<select name="huidao" id="huidao">
					<option value="空白" {if $arr_field_value.huidao=='空白'}selected{/if}>空</option>
					<option value="倒内外层" {if $arr_field_value.huidao=='倒内外层'}selected{/if}>倒内外层</option>
					<option value="一倒二" {if $arr_field_value.huidao=='一倒二'}selected{/if}>一倒二</option>
					<option value="要剥皮" {if $arr_field_value.huidao=='要剥皮'}selected{/if}>要剥皮</option>
					<option value="剥皮干净" {if $arr_field_value.huidao=='剥皮干净'}selected{/if}>剥皮干净</option>
					<option value="注意内外层" {if $arr_field_value.huidao=='注意内外层'}selected{/if}>注意内外层</option>
				</select>
            </td>
          </tr>
            <tr>
	          	<td class="tdTitle">订单类型：</td>
	          	<td>
				  <select name='kind' id='kind'>
				  	<option value='0' {if $arr_field_value.kind=='0'}selected{/if}>加工</option>
				  	<option value='1' {if $arr_field_value.kind=='1'}selected{/if}>经销</option>
				  </select>
				</td>
				<td class="tdTitle">结算方式：</td>
				<td colspan='3'>
				  <select name='paymentWay' id='paymentWay' >
				  	<option value='0' {if $arr_field_value.paymentWay=='0'}selected{/if}>投坯</option>
				  	<option value='1' {if $arr_field_value.paymentWay=='1'}selected{/if}>净重</option>
				  	<option value='2' {if $arr_field_value.paymentWay=='2'}selected{/if}>折率</option>
				  </select>
<!-- 				  &nbsp; &nbsp;折率:<input type="text" name="zhelv" id='zhelv' style="width: 70px" {$readonly} value="{$arr_field_value.zhelv}"> -->
				</td>
				<td class="tdTitle"></td>
				<td></td>
          	</tr>
          <tr>
            <td colspan="1" class="tdTitle">色牢度要求：</td>
			<td colspan="7">1.干磨
            <input name="fastness_gan" type="text" id="fastness_gan" value="{$arr_field_value.fastness_gan|default:'4'}" size="2">
            级；2.湿磨
            <input name="fastness_shi" type="text" id="fastness_shi" value="{$arr_field_value.fastness_shi|default:'3'}" size="2">
级； 3.白沾
<input name="fastness_baizhan" type="text" id="fastness_baizhan" value="{$arr_field_value.fastness_baizhan|default:'3-4'}" size="2">
级；4.褪色
<input name="fastness_tuise" type="text" id="fastness_tuise" value="{$arr_field_value.fastness_tuise|default:'4'}" size="2">
级; 5.原样变化
<input name="fastness_yuanyang" type="text" id="fastness_yuanyang" value="{$arr_field_value.fastness_yuanyang|default:'3-4'}" size="2">级;
6.日晒
<input name="fastness_rishai" type="text" id="fastness_rishai" value="{$arr_field_value.fastness_rishai|default:'4'}" size="2">级;
7.汗渍
<input name="fastness_hanzi" type="text" id="fastness_hanzi" value="{$arr_field_value.fastness_hanzi|default:'4'}" size="2">级;
</td>
          </tr>
<!--           <tr>
            <td class="tdTitle">包装要求：</td>
			<td colspan="7"> 1.纸管
              <select name="packing_zhiguan" id="packing_zhiguan">
                <option value="尖新纸管" selected>尖新纸管</option>
                <option value="小旧纸管">小旧纸管</option>
                <option value="小新纸管">小新纸管</option>
              </select>
2.塑料袋
<select name="packing_suliao" id="packing_suliao">
  <option value="套塑料袋" selected>套塑料袋</option>
  <option value="不要套塑料袋">不要套塑料袋</option>
</select>
3.外包装
<select name="packing_out" id="packing_out">
  <option value="新蛇皮袋" selected>新蛇皮袋</option>
  <option value="旧蛇皮袋">旧蛇皮袋</option>
  <option value="新纸箱">新纸箱</option>
  <option value="旧纸箱">旧纸箱</option>
</select></td>
          </tr> -->
          <tr>
          	<td colspan="1" class="tdTitle">包装要求：</td>
			<td colspan="7"><textarea name="packing_memo" id="packing_memo" style="width:100%" rows="3">{$arr_field_value.packing_memo|default:'1.纸管 尖新纸管2.塑料袋 套塑料袋3.外包装 新蛇皮袋'}</textarea></td>
          </tr>
          <tr>
            <td colspan="1" class="tdTitle">特别要求：</td>
			<td colspan="7"><textarea name="memo" id="memo" style="width:100%" rows="2">{$arr_field_value.memo|default:'7.不含禁用偶氮染料。8、福尔马林含量不超标。9、对色标准：确认样 中样 原样 对色光源。10.织物组织11、检测标准12、后整理工艺13、紧筒要求'}</textarea></td>
          </tr>
          <tr>
            <td colspan="1" class="tdTitle">其他：</td>
			<td colspan="7"><textarea name="qita_memo" id="qita_memo" style="width:100%" rows="2">{$arr_field_value.qita_memo|default:''}</textarea></td>
          </tr>
          <tr id="ransheTr">
            <td colspan="1" class="tdTitle" style="background-color:#C8E9F0;">染纱计划单号：</td>
			<td colspan="7"><input name="ranshaNum" type="text" id="ranshaNum" value="{$arr_field_value.ranshaNum}" class="Num"><span id="jhLoading">正在加载染纱计划数据...</span></td>
          </tr>
        </table>
</fieldset>


<div id="divPro">
<fieldset>
<legend>颜色修改</legend>
<table class="tableHaveBorder table100" id="tbl" style="width: 1800px">
	<thead>
		<tr class="th">
		  <td rowspan="2">纱支选择</td>
		  <td rowspan="2" style="width:60px">纱支</td>
		  <td rowspan="2" style="width:60px">纱支别名</td>
		  <td rowspan="2" style="width:100px">规格</td>
		  <td rowspan="2" style="background-color:#C8E9F0;" id="rsSazhiHead">染单纱支</td>
		  <td rowspan="2">颜色</td>
		  <td rowspan="2">批号</td>
		  <td rowspan="2">产地</td>
		  <td rowspan="2">色号</td>
		  <td rowspan="2">库存</td>
		  <td rowspan="2">客户缸号</td>
		  <td rowspan="2">款号</td>
		  <td rowspan="2">产品交期</td>
		  <!-- <td rowspan="2">结算方式</td> -->
		  <td rowspan="2">折率</td>
		  <td rowspan="2">是否加急</td>
		  <td colspan="3">计划投料(kg)</td>
		  <td rowspan="2">单价</td>
		  <td rowspan="2">小缸价</td>
		  <td rowspan="2">备注</td>
		  <td rowspan="2">已计划数量<br>
		  (缸数)</td>
		  <td rowspan="2">打样人</td>
		  <td rowspan="2">操作</td>
		</tr>
		<tr class="th">
		  <td>经</td>
		  <td>纬</td>
		  <td>合计</td>
		</tr>
	</thead>
	<tbody>
		{foreach from=$rows item=item}
		<tr class="dataRow">
		  <td>
		  <!-- <input name="wareId[]" id="wareId[]" type="text" value="{$item.wareId}" onClick="popMenu(this)" size="5" readonly> -->
		  <input name="wareId[]" id="wareId[]" type="text" value="{$item.wareId}" onChange="changeWare(this)" onClick="popMenu(this)" size="5"  >
		  <input type="button" name="btnSel" id="btnSel" value=".." onClick="selWare(this)">
		  <strong>
		  <input name="id[]" type="hidden" id="id[]" value="{$item.id}">
		  </strong></td>
		  <td><span id='spanWareName' name='spanWareName'>{$item.Ware.wareName}</span></td>
		  <td><input type="text" name="wareNameBc[]" id="wareNameBc[]" value="{$item.wareNameBc}" size="5"></td>
		  <td><span id='spanGuige' name='spanGuige'>{$item.Ware.guige}</span></td>

		  <td class="rsSazhiTd"><span id="rsSazhi">{$item.randanShazhi}</span>
	      <input name="randanShazhi[]" type="hidden" id="randanShazhi[]" value="{$item.randanShazhi}"/></td>

          </td>
		  <td ><input name="color[]" type="text" class="txt" id="color[]" value="{$item.color}"></td>
		  <td>
	        <!-- <select name="pihao[]" id="pihao[]" onchange="ChangePihao(this)">
	        	<option value=''>请选择</option>
	        	{foreach from=$item.pihaoArr item=item2}
	        		<option value="{$item2.pihao}" {if $item.pihao == $item2.pihao}selected{/if}>{$item2.pihao}</option>
	        	{/foreach}
	        </select> -->
	        <input type="text" name="pihao[]" id="pihao[]" readonly="readonly" value="{$item.pihao}" style="width: 80px">
          </td>
		  <td>
<!-- 			  <select name="chandi[]" id="chandi[]">
	          	<option value=''>请选择</option>
	          </select> -->
	          <input type="text" name="chandi[]" id="chandi[]" readonly="readonly" value="{$item.chandi}" style="width: 50px">
          </td>
		  <td><input name="colorNum[]" id="colorNum[]" type="text" value="{$item.colorNum}" size="5"></td>
		  <td><input name="kuCun[]" id="kuCun[]" type="text" value="{$item.kuCun}" size="5" readonly="readonly" value="{$item.kuCun}"></td>
		  <td><input name="ganghaoKf[]" id="ganghaoKf[]" type="text"  size="5"  value="{$item.ganghaoKf}"></td>
		  <td><input name="kuanhao[]" id="kuanhao[]" type="text"  size="5"  value="{$item.kuanhao}"></td>
		  <td><input name="dateJiaoqi[]" id="dateJiaoqi[]" type="text"  size="5"  value="{$item.dateJiaoqi|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
<!-- 		  <td>
		  	<select name='paymentWayMx[]' id='paymentWayMx[]' >
			  	<option value='0' {if $item.paymentWayMx=='0'}selected{/if}>投坯</option>
			  	<option value='1' {if $item.paymentWayMx=='1'}selected{/if}>净重</option>
			  	<option value='2' {if $item.paymentWayMx=='2'}selected{/if}>折率</option>
			</select>
		  </td> -->
		  <td><input name="zhelvMx[]" id="zhelvMx[]" type="text"  size="5"  value="{$item.zhelvMx}"></td>
		  <td>
		  	<input name="isJiaji[]" type="checkbox" id="isJiaji[]" value="1" {if $item.isJiaji==1} checked="checked" {/if} onchange="changeCheckd(this)">
		  	<input type="hidden" name="isJiajiV[]" id="isJiajiV[]" value="{$item.isJiaji} ">
		  </td>
		  <td><input name="cntKgJ[]" id="cntKgJ[]" type="text" value="{$item.cntKgJ}" size="5" onClick="this.select()" onChange="getCnt(this)"></td>
		  <td><input name="cntKgW[]" id="cntKgW[]" type="text" value="{$item.cntKgW}" size="5" onClick="this.select()"  onChange="getCnt(this)"></td>
		  <td><input name="cntKg[]" type="text" class="txt" id="cntKg[]" onClick="this.select()" value="{$item.cntKg}" size="8"></td>

		  <td><input name="danjia[]" id="danjia[]" type="text"  size="3"  value="{$item.danjia}" onchange="getMoney(this)" {if $item.isShenhe==1}readonly{/if}></td>
		  <td><input name="money[]" id="money[]" type="text"  size="3"  value="{$item.money}" onchange="getMoney(this)" {if $item.isShenhe==1}readonly{/if}></td>

		  <td><input name="memo[]" id="memo[]" type="text"  size="10"  value="{$item.memo}"></td>
		  <td align="right">{$item.cntPlan}({$item.cntGang})
		    [{if $item.cntGang>0} <a href="?controller=Trade_Dye_Order&action=PlanManage1&order2wareId={$item.id}">修改</a> {else} <a href="?controller=Plan_Dye&action=MakeGang1&id={$item.orderId}&wareId={$item.id}&page={$smarty.get.page}">增加</a> {/if}]
		    {if $item.islock==0}
		    [<a href="?controller=Trade_Dye_Order2Ware&action=RemoveAllGang&order2wareId={$item.id}" target='_blank' onClick="return confirm('该操作将删除该颜色下所有已经生成过的缸,您确认吗？')">清除</a>]
		    {else $item.islock==1}
		    [<a href="javascript:void(0)"  onClick="return alert('该颜色下缸号有产量数据，则无法进行操作！')">清除</a>]
		    {/if}
		  </td>
		  <td><select name="personDayang[]" id="personDayang[]" warning='请选择'>

			  {webcontrol type='TmisOptions' model='JiChu_Employ' condition='depId=13' selected=$item.personDayang}

		    </select></td>
		  <td>
		  	<input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)">
		  	<input type="button" name="btnSave" id="btnSave" value="保存" size="8" onClick="saveRow(this)">
		  </td>
		  <!-- <td>&nbsp;</td> -->
		</tr>
        {/foreach}
 {if $rows|@count==0 }
<tr class="dataRow">
  <td>
  	<!-- <input name="wareId[]" type="text" id="wareId[]" size="5" onClick="popMenu(this)" value="{$defaultWare.id}" readonly> -->
  	<input name="wareId[]" type="text" id="wareId[]" size="5" onChange="changeWare(this)" onClick="popMenu(this)" value="{$defaultWare.id}"  >
    <input type="button" name="btnSel" id="btnSel2" value=".." onClick="selWare(this)">
    <strong>
    <input name="id[]" type="hidden" id="id[]">
    </strong></td>
  <td><span id='spanWareName' name='spanWareName'>{$defaultWare.wareName}</span>
  </td>
  <td><input type="text" name="wareNameBc[]" id="wareNameBc[]" value=""  size="5"></td>
  <td><span id='spanGuige' name='spanGuige'>{$defaultWare.guige}</span></td>
  <td class="rsSazhiTd"><span id="rsSazhi">&nbsp;</span>
  	<input name="randanShazhi[]" type="hidden" id="randanShazhi[]"/>
  </td>
  <td><input name="color[]" type="text" class="txt" id="color[]"></td>
  <td>
<!--     <select name="pihao[]" id="pihao[]" onchange="ChangePihao(this)">
    	<option value=''>请选择</option>
    </select> -->
    <input type="text" name="pihao[]" id="pihao[]" readonly="readonly" value="" style="width: 80px">
  </td>
  <td>
<!--   	<select name="chandi[]" id="chandi[]">
        <option value=''>请选择</option>
    </select> -->
    <input type="text" name="chandi[]" id="chandi[]" readonly="readonly" value="" style="width: 50px">
  </td>
  <td><input name="colorNum[]" type="text" id="colorNum[]" size="5"/></td>
  <td><input name="kuCun[]" id="kuCun[]" type="text" value="" size="5" readonly="readonly"></td>
  <td><input name="ganghaoKf[]" id="ganghaoKf[]" type="text"  size="5"  value="{$item.ganghaoKf}"></td>
  <td><input name="kuanhao[]" id="kuanhao[]" type="text"  size="5"  value="{$item.kuanhao}"></td>
  <td><input name="dateJiaoqi[]" id="dateJiaoqi[]" type="text"  size="5"  value="{$item.dateJiaoqi|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
<!--   <td>
  	<select name='paymentWayMx[]' id='paymentWayMx[]' >
	  	<option value='0' >投坯</option>
	  	<option value='1' >净重</option>
	  	<option value='2' >折率</option>
	</select>
  </td> -->
  <td><input name="zhelvMx[]" id="zhelvMx[]" type="text"  size="5"  value=""></td>
  <td>
  	<input name="isJiaji[]" id="isJiaji[]" type="checkbox"  size="5"  value="" onchange="changeCheckd(this)">
  	<input type="hidden" name="isJiajiV[]" id="isJiajiV[]" value="">
  </td>
  <td><input name="cntKgJ[]" id="cntKgJ[]" type="text" size="5" onClick="this.select()" onChange="getCnt(this)"></td>
  <td><input name="cntKgW[]" id="cntKgW[]" type="text" size="5" onClick="this.select()"  onChange="getCnt(this)"></td>
  <td><input name="cntKg[]" type="text" class="txt" id="cntKg[]" onClick="this.select()" size="8" onChange="getTKg()"></td>
  <td><input name="danjia[]" id="danjia[]" type="text"  size="3"  value="" onchange="getMoney(this)"></td>
  <td><input name="money[]" id="money[]" type="text"  size="3"  value="" onchange="getMoney(this)"></td>
  <td><input name="memo[]" id="memo[]" type="text"  size="10"  value="{$item.memo}"></td>
  <td>&nbsp;</td>
  <td><select name="personDayang[]" id="personDayang[]" warning='请选择'>

			  {webcontrol type='TmisOptions' model='JiChu_Employ' condition='depId=13'}

  </select></td>
  <td>
  	<input type="button" name="btnDel" id="btnDel" value="删除" size="8" onClick="delRow(this)">
  	<input type="button" name="btnSave" id="btnSave" value="保存" size="8" onClick="saveRow(this)">
  </td>
</tr>
{/if}
</tbody>
<tfoot>
		<tr>
		  <td><strong>合计</strong></td>
		  <td class="rsSazhiTd">&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><strong><span id='spanTKg'>0</span></strong></td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><input type="button" name="button" id="button" value="+5行" onClick="addRow()" ></td>
		</tr>
  </tfoot>
  </table>
  </fieldset>
  </div>
  	<div align="center">
		<input name="orderId" type="hidden" id="orderId" value="{$smarty.get.id}">
		<input name="page" type="hidden" id="page" value="{$smarty.get.page}">
		<input name="sub" type="submit" id="sub" value='保存并排计划'>
		<span style=" clear:both;margin:0 auto;">
		<input type="submit" name="sub" id="sub" value="保存并返回">
		<input type="button" id="Back" name="Back" value='返回生产计划' onClick="window.location='Index.php?controller=Trade_Dye_Order&action=right'">
		<input type="button" id="Back" name="Back" value='返回排缸任务清单' onClick="window.location='Index.php?controller=Trade_Dye_Order&action=right1'">
		</span>
	</div>
  
</form>
<br>

</div>
</body>
</html>
