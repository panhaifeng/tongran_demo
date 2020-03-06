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
	document.getElementById('form1').onsubmit = function(){
		return checkForm();
		$('[name="submit"]').disabled=true;
	};
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
	return true;
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
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='SaveMain'}" method="post">
	<fieldset>
	<legend>合同信息( * 为必填项)</legend>
	<table class="tableHaveBorder table100" style=" text-align:left">
		<tr>
			<td class="tdTitle">
				合同编号：
			</td>
			<td>
				<input name="orderCode" type="text" id="orderCode" value="{$arr_field_value.orderCode}" readonly="readonly" size="15">
			</td>
			<td class="tdTitle">
				业务员*：
			</td>
			<td>
				<select name="traderId" id="traderId" warning='请选择'>
		              {webcontrol type='TmisOptions' model='JiChu_Employ' selected=$arr_field_value.traderId condition='depId=11'}
				</select>
			</td>
			<td class="tdTitle">
				客户*：
			</td>
			<td colspan="3">
				{webcontrol type='ClientSelect' selected=$arr_field_value.Client arType='1'}
				<input type="text" name="orderCode2" id="orderCode2" size="10" value="{$arr_field_value.orderCode2}" title="客户单号" emptytext='客户单号' placeholder='客户单号'>
					  [ 
				<a href="javascript:void(0)" onclick='window.open("{url controller="CangKu_Report_Month" action="ClientPishaKucun" clientId=$rows[0].Order.clientId}&clientId="+document.getElementById("clientId").value)'>查看该客户坯纱库存</a> ]
			</td>
		</tr>

		<tr>
			<td class="tdTitle">
				签约日期：
			</td>
			<td>
				<input name="dateOrder" type="text" id="dateOrder" value="{$arr_field_value.dateOrder|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onclick="calendar()">
			</td>
			<td class="tdTitle">
				产品大类：
			</td>
			<td>
				<select name="saleKind" id="saleKind" warning='请选择' check='^0$'>
		              {webcontrol type='TmisOptions' model='JiChu_SaleKind' selected=$arr_field_value.saleKind }
				</select>
			</td>
			<td class="tdTitle">
				质量要求等级：
			</td>
			<td>
				<select name="zhiliang" id="zhiliang">
					<option value="A" {if $arr_field_value.zhiliang=='A'}selected{/if}>A类(精品)</option>
					<option value="B" {if $arr_field_value.zhiliang=='B'}selected{/if}>B类(外贸)</option>
					<option value="C" {if $arr_field_value.zhiliang=='C'}selected{/if}>C类(一般)</option>
				</select>
			</td>
			<td class="tdTitle">
				烘干要求：
			</td>
			<td>
				<select name="honggan" id="honggan">
					<option value="要烘干" {if $arr_field_value.honggan=='要烘干'}selected{/if}>要烘干</option>
					<option value="不要烘干" {if $arr_field_value.honggan=='不要烘干'}selected{/if}>不要烘干</option>
					<option value="含水率&lt;5%" {if $arr_field_value.honggan=='含水率&lt;5%'}selected{/if}>含水率&lt;5%</option>
					<option value="微波" {if $arr_field_value.honggan=='微波'}selected{/if}>微波</option>
					<option value="热风" {if $arr_field_value.honggan=='热风'}selected{/if}>热风</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="tdTitle">
				交货日期：
			</td>
            <td>
            	<input name="dateJiaohuo" type="text" id="dateJiaohuo"  value="{$arr_field_value.dateJiaohuo|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()">
            </td>
			<td class="tdTitle">
				翻单：
			</td>
			<td>
				<input name="isFandan" type="checkbox" id="isFandan" value="1" {if $arr_field_value.isfandan==1}" checked="checked" {/if}>
			</td>
			<td class="tdTitle">
				空捻：
			</td>
			<td>
				<input name="isKongnian" type="checkbox" id="isKongnian" value="1" {if $arr_field_value.iskongnian==1}" checked="checked" {/if}>
			</td>
			<td class="tdTitle">
				回倒要求：
			</td>
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
			</td>
			<td class="tdTitle"></td>
			<td></td>
	  	</tr>
		<tr>
			<td colspan="1" class="tdTitle">
				色牢度要求:
			</td>
			<td colspan="7">
				1.干磨
				<input name="fastness_gan" type="text" id="fastness_gan" value="{$arr_field_value.fastness_gan|default:'4'}" size="2">级；
				2.湿磨
				<input name="fastness_shi" type="text" id="fastness_shi" value="{$arr_field_value.fastness_shi|default:'3'}" size="2">级； 
				3.白沾
				<input name="fastness_baizhan" type="text" id="fastness_baizhan" value="{$arr_field_value.fastness_baizhan|default:'3-4'}" size="2">级；
				4.褪色
				<input name="fastness_tuise" type="text" id="fastness_tuise" value="{$arr_field_value.fastness_tuise|default:'4'}" size="2">级; 	
				5.原样变化
				<input name="fastness_yuanyang" type="text" id="fastness_yuanyang" value="{$arr_field_value.fastness_yuanyang|default:'3-4'}" size="2">级;
				6.日晒
				<input name="fastness_rishai" type="text" id="fastness_rishai" value="{$arr_field_value.fastness_rishai|default:'4'}" size="2">级;
				7.汗渍
				<input name="fastness_hanzi" type="text" id="fastness_hanzi" value="{$arr_field_value.fastness_hanzi|default:'4'}" size="2">级;
			</td>
		</tr>
		<tr>
			<td colspan="1" class="tdTitle">
				包装要求：
			</td>
			<td colspan="7">
				<textarea name="packing_memo" id="packing_memo" style="width:100%" rows="3">{$arr_field_value.packing_memo|default:'1.纸管 尖新纸管2.塑料袋 套塑料袋3.外包装 新蛇皮袋'}
				</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="1" class="tdTitle">
				特别要求：
			</td>
			<td colspan="7">
				<textarea name="memo" id="memo" style="width:100%" rows="3">{$arr_field_value.memo|default:'7.不含禁用偶氮染料。8、福尔马林含量不超标。9、对色标准：确认样 中样 原样 对色光源。10.织物组织11、检测标准12、后整理工艺13、紧筒要求'}</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="1" class="tdTitle">
				其他：
			</td>
			<td colspan="7">
				<textarea name="qita_memo" id="qita_memo" style="width:100%" rows="3">
				{$arr_field_value.qita_memo|default:''}
				</textarea>
			</td>
		</tr>
		<tr id="ransheTr">
			<td colspan="1" class="tdTitle" style="background-color:#C8E9F0;">
				染纱计划单号：
			</td>
			<td colspan="7">
				<input name="ranshaNum" type="text" id="ranshaNum" value="{$arr_field_value.ranshaNum}" class="Num"><span id="jhLoading">正在加载染纱计划数据...</span>
			</td>
		</tr>
	</table>
	</fieldset>
	<div align="center">
		<input name="orderId" type="hidden" id="orderId" value="{$smarty.get.id}">
		<input name="page" type="hidden" id="page" value="{$smarty.get.page}">
		<input name="sub" type="submit" id="sub" value='保存并下一步'>
		<span style=" clear:both;margin:0 auto;">		
		<input type="button" id="Back" name="Back" value='返回生产计划' onClick="window.location='Index.php?controller=Trade_Dye_Order&action=right'">
		</span>
	</div>
</form>
</div>
</body>
</html>
