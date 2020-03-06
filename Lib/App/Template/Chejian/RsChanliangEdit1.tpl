<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>{$title}</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>

<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChanliang1'}" method="post">
<div align="center">
<table width="100%" border="1">
                <tr class="th">
                  <td align="center">客户</td>
                  <td align="center">订单号</td>
                  <td align="center">纱支规格</td>
                  <td align="center">颜色</td>
                  <td align="center">缸号</td>
                  <td align="center">色号</td>
                  <td align="center">计划筒子数</td>
                  <td align="center">产量类别</td>
                  <td align="center">工号</td>
                  <td align="center">染出筒子数(个)</td>
                  <td align="center">公斤数</td>
                  <td align="center">保存</td>
                </tr>
				{foreach from=$rows key=key item=item}
                <tr>
                  <td align="center">{$item.clientName}</td>
                  <td align="center">{$item.orderCode}</td>
                  <td align="center">{$item.guige}</td>
                  <td align="center">{$item.color}</td>
                  <td align="center">{$item.vatNum}</td>
                  <td align="center">{$item.OrdWare.colorNum}</td>
                  <td align="center">{$item.planTongzi}</td>
                  <td align="center"><select name="chanliangKind[]" id="chanliangKind[]">
                    <option value="0">正常</option>
                    <option value="1">修色</option>
                    <option value="2">加色</option>
                  </select>
                  </td>
                  <td align="center"><input name="workerCode[]" type="text" id="workerCode[]" value="{$item.workerCode}" size='10'>
                  <td align="center"><input name="gangId[]" type="hidden" id="gangId[]" value="{$item.id}">
                  <input name="cntTongzi[]" type="text" id="cntTongzi[]" onMouseOver="this.select()" value="{$item.planTongzi}" size="10"></td>
                  <td align="center"><input name="cntK[]" type="text" id="cntK[]" value="{$item.Gang.cntPlanTouliao|default:$item.cntPlanTouliao}" size="10"></td>
                  <td align="center"><label>
                    <input name="check[{$key}]" type="checkbox" id="check[{$key}]" value="{$key}" checked >
                  </label></td>
                </tr>
                
                {/foreach}
				
				{*显示已经出库的产量*}
				{foreach from=$rows1 item=item}
                <tr style="color:red">
                  <td align="center">&nbsp;</td>
                  <td align="center">{$item.clientName}</td>
                  <td align="center">{$item.orderCode}</td>
                  <td align="center">{$item.guige}</td>
                  <td align="center">{$item.color}</td>
                  <td align="center">{$item.vatNum}</td>
                  <td align="center">{$item.OrdWare.colorNum}</td>
                  <td align="center">{$item.planTongzi}</td>
                  <td align="center"></td>
                  <td align="center"></td>
                  <td align="center">{$item.cntK}</td>
                  <td align="center">{$item.rsChanliang}</td>
                </tr>
                
                {/foreach}
              </table>
							
<input name="Submit" type="submit" id="Submit" value='提交' onClick="javascript:window.location='?controller={$smarty.get.controller}&action=right'">
		</td>
	
</div>
</form>
</body>
</html>
