<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>修改排缸信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>
<body onload="setOption(document.getElementsByName('planTongzi[]')[0])">
<form name="form1" action="{url controller=$smarty.get.controller action=SetTwiceSave}" method=post>
<fieldset>     
<legend><span class="legendFront">{$smarty.get.dateAssign}染色计划-设置双染工序(仅针对化纤类纱线)</span></legend>
	<div align="center">
	<table width="100%">
<tr class="tdItem">
  <td width="120" bgcolor="#CCCCCC">班次</td> 
			<td width="120" bgcolor="#CCCCCC">逻辑缸号</td>
			<td width="120" bgcolor="#CCCCCC">纱支规格</td>
		  <td width="120" bgcolor="#CCCCCC">颜色</td>
			<td width="120" bgcolor="#CCCCCC">计划投料</td>
		  <td width="120" bgcolor="#CCCCCC">工序设置</td>
	  </tr>
        {foreach from=$arr_field_value item=item}
		<tr>
		  <td>{if $item.ranseBanci==1}早班{elseif $item.ranseBanci==2}晚班{elseif $item.ranseBanci==3}早班1{elseif $item.ranseBanci==4}早班2{elseif $item.ranseBanci==5}早班3{elseif $item.ranseBanci==6}晚班1{elseif $item.ranseBanci==7}晚班2{elseif $item.ranseBanci==8}晚班3{/if}</td> 
			<td>
			{$item.vatNum}
		    <input name="gangId[]" type="hidden" id="gangId[]" value="{$item.id}" /></td>
			<td>{$item.Ware.wareName} {$item.Ware.guige}</td>
			<td>{$item.OrdWare.color}</td>
			<td>{$item.cntPlanTouliao}</td>
		  <td><select name="markTwice[]" id="markTwice[]" >
		    <option value="1">先分散后套棉</option>
		    <option value="2">套棉</option>
		    <option value="3">分散连套</option>		    
		    </select>
		    <select name="oneBanci[]" id="oneBanci[]">
		      <option value="0">分班安排</option>
		      <option value="1">同一班做掉</option>
	        </select></td>
	    </tr>
         {/foreach}
	</table>
<div style="clear:both;">
  <input name="indexNum" type="hidden" id="indexNum" value="{$smarty.get.indexNum}" />
  <input name="dateAssign" type="hidden" id="dateAssign" value="{$smarty.get.dateAssign}" />
  <input name="ranseBanci" type="hidden" id="ranseBanci" value="{$smarty.get.ranseBanci}" />
  <input type="submit" name="Submit" value="完成并返回" id="Submit" />
  <input type="submit" name="Submit" value="完成并打印" />
</div>

</div>
</fieldset>
</form>
</body>
</html>