<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>领纱日计划安排</title>
<script language="javascript" src="Resource/Script/calendar.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
{literal}
<script language="javascript">
//(选择缸号后下面自动清空然后显示该缸下所有未完成的缸，不能合右边的项目重复)
$(function(){	
	beginTiqu();
	
	//按照缸号来提取
	$('#vatId').change(function(){
		if(this.value=='') return false;
		//$('#clientId').selectedIndex="0";
		var url='?controller=Plan_Dye&action=GetJsonByVatIdLingsha';
		var param= {vatId:this.value};
		$.getJSON(url,param,function(json){
			//清空select
			var o = document.getElementById('selLeft');
			while (o.options.length>0) {o.remove(0);}; 
			if (json) {
				for (var i=0;i<json.length;i++) {
					//判断右边是否有相关的id
					//插入selLeft中
					var msg = json[i].Vat.vatCode + ',' + json[i].vatNum+ '(' + json[i].Client.compName+ ',' + json[i].OrdWare.Ware.wareName + " " + json[i].OrdWare.Ware.guige + "," + json[i].OrdWare.color + "),计划投" + json[i].cntPlanTouliao + "kg(" + json[i].planTongzi +")";
					var opt=new Option(msg,json[i].id);
					o.options.add(opt);
				}
			}		
		});
	});
	
	//按照客户名称来提取
	$('#clientId').change(function(){
		if(this.value=='') return false;		
		var url='?controller=Plan_Dye&action=GetJsonByClientIdLingsha';
		var param= {clientId:this.value};
		$.getJSON(url,param,function(json){
			var o = document.getElementById('selLeft');
			while (o.options.length>0) {o.remove(0);}; 
			if (json) {
				for (var i=0;i<json.length;i++) {
					//判断右边是否有相关的id
					//插入selLeft中
					var msg = json[i].vatCode + ',' + json[i].vatNum+ '(' + json[i].compName+ ',' + json[i].wareName + " " + json[i].guige + "," + json[i].color + "),计划投" + json[i].cntPlanTouliao + "kg(" + json[i].planTongzi +")";
					var opt=new Option(msg,json[i].id);
					o.options.add(opt);
				}
			}		
		});
	});
	
	
	$('#selLeft').dblclick(function(){
		moveOpt(document.getElementById('selLeft'),document.getElementById('selRight'));
	});
	$('#selRight').dblclick(function(){
		moveOpt(document.getElementById('selRight'),document.getElementById('selLeft'));
	});
	$('#btnMove1').click(function(){
		moveOpt(document.getElementById('selLeft'),document.getElementById('selRight'));
	});
	$('#btnMove2').click(function(){
		moveOpt(document.getElementById('selRight'),document.getElementById('selLeft'));
	});
	
	$('#btnTiqu').click(function(){
		beginTiqu();
	});
});
function moveOpt(source,target) {
	if (source.selectedIndex==-1) return false;
	var opt = source.options[source.selectedIndex];		
	
	//移入
	target.options.add(new Option(opt.text,opt.value));
	//移去
	source.remove(source.selectedIndex);
}

function beginTiqu() {
	var url='?controller=Plan_Dye&action=GetJsonByDateLingsha';
	var param= {dateLingsha:$('#dateLingsha').val(), lingshaBanci:$('#lingshaBanci').val()};

	$.getJSON(url,param,function(json){	
		//清空select
		var o = document.getElementById('selRight');
		while (o.options.length>0) {o.remove(0);};		
		if (json) {
			for (var i=0;i<json.length;i++) {
				//判断右边是否有相关的id
				//插入selLeft中
				var msg = json[i].Vat.vatCode + ',' + json[i].vatNum+ '(' + json[i].Client.compName+ ',' + json[i].OrdWare.Ware.wareName + " " + json[i].OrdWare.Ware.guige + "," + json[i].OrdWare.color + "),计划投" + json[i].cntPlanTouliao + "kg(" + json[i].planTongzi +")";
				var opt=new Option(msg,json[i].id);
				o.options.add(opt);
			}
		}	
	});
}

//提交前将所有右边的值用,连接，方便提交。
function joinId(){	
	var opts = document.getElementById('selRight').options;
	if (opts.length==0) return false;
	var v = opts[0].value;
	for (var i=1;i<opts.length;i++) {
		v += "," + opts[i].value;
	}
	$('#vatIds').val(v);
}
</script>
{/literal}
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center" style="font-size:26px; font-weight:bold">领纱日计划安排</div>
<form action="{url controller=$smarty.get.controller action='SaveLingshaDayPlan'}" method="post" onSubmit="return joinId()">

<table width="100%" border="0" align="center">
  <tr>
    <td align="right">
	选择客户:
	<select name="clientId" id='clientId'>
		{webcontrol type='TmisOptions' model='JiChu_Client'}
    </select>	
	
	选择缸:
	<select name="vatId" id="vatId">
      {webcontrol type='TmisOptions' model='JiChu_Vat'}
    </select>
      <br />
	<select name="selLeft" size="10" id="selLeft" style=" width:430px; height:450px;">
	</select>
	</td>
    <td align="center">
	
	<input type="submit" name="btnMove1" id="btnMove1" value="-&gt;" />
      <br />
    <input type="submit" name="btnMove2" id="btnMove2" value="&lt;-" />
	
	</td>
    <td align="left">安排领纱日期：
      <input name="dateLingsha" type="text" id="dateLingsha" value="{$smarty.get.dateLingsha|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()" size="10"/>
	  选择班次：
	  <select name="lingshaBanci" id="lingshaBanci">
	  	<option value="1" {if ($smarty.get.lingshaBanci == 1)} selected="selected" {/if}>早班1</option>
		<option value="3" {if ($smarty.get.lingshaBanci == 3)} selected="selected" {/if}>早班2</option>
		<option value="2" {if ($smarty.get.lingshaBanci == 2)} selected="selected" {/if}>晚班</option>
		<option value="4" {if ($smarty.get.lingshaBanci == 4)} selected="selected" {/if}>晚班2</option>
	  </select>
      <input type="button" name="btnTiqu" id="btnTiqu" value="提取计划" />
      <br />
      	<select name="selRight" size="10" id="selRight"  style=" width:430px; height:450px;">
		</select>
	</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><input type="submit" name="button2" id="button2" value="确定并返回" />
    <input type="submit" name="button3" id="button3" value="确定并打印" />
    <input type="hidden" name="vatIds" id="vatIds" /></td>
  </tr>
</table>
</form>
</body>
</html>
