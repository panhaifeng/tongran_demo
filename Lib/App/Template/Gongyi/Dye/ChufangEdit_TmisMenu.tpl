<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<title>筒染工艺处方单</title>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript">
{literal}
function popMenu(e) {
	tMenu(e,'Index.php?controller=JiChu_Ware&action=tmismenu',5,false,function(e) {
		var arr = explode("||",e.text);
		$('#spanWareName')[0].innerHTML = arr[0]?arr[0]:'&nbsp;';
		$('#spanGuige')[0].innerHTML = arr[1]?arr[1]:'&nbsp;';
	});
}
{/literal}
</script>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='saveChufang'}" method="post">
<div align="center">
<table align="center">
                <tr>
                  <td colspan="8">日期：
                  <input name="dateChufang" type="text" id="dateChufang" value="{$chufang.dateChufang|default:$smarty.now|date_format:'%Y-%m-%d'}" readonly="true">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;已开处方数：{$number}</td>
                </tr>
                <tr>
                  <td align="center">染化料选择</td>
                  <td align="center">品名</td>
                  <td align="center">规格</td>
                  <td align="center">单位用量(g)</td>
                  <td align="center">单位</td>
                  <td align="center">温度</td>
                  <td align="center">顺序</td>
                  <td align="center">操作</td>
                </tr>
                <tr>
                  <td align="center"><input name="wareId" type="text" id="wareId" size="3" onClick="popMenu(this)" readonly></td>
                  <td align="center"><span id='spanWareName'>&nbsp;</span></td>
                  <td align="center"><span id='spanGuige'>&nbsp;</span></td>
                  <td align="center"><input name="unitKg" type="text" id="cnt2" size="10"></td>
                  <td align="center"><select name="unit" id="unit">
                    <option value="g/包">g/包</option>
                    <option value="g/升">g/升</option>
                    <option value="%">%</option>
                  </select>
                  </td>
                  <td align="center"><input name="tmp" type="text" id="cnt" size="8"></td>
                  <td align="center"><input name="ord" type="text" id="tmp" size="8"></td>
                  <td align="center"><input type="submit" name="Submit" id="Submit" value="提交"></td>
                </tr>
                {foreach from=$chufang.Ware item=item}
                <tr>
                  <td align="center">{$item.Ware.id}</td>
                  <td align="center">{$item.Ware.wareName}</td>
                  <td align="center">{$item.Ware.guige}</td>
                  <td align="center">{$item.unitKg}</td>
                  <td align="center"><p>{$item.unit}</p></td>
                  <td align="center">{$item.tmp}</td>
                  <td align="center"><p>{$item.ord}</p>
                  </td>
                  <td align="center"><a href="?controller={$smarty.get.controller}&action=RemoveWare&id={$item.id}">删除</a></td>
                </tr>
                {/foreach}
              </table>
							
					<br>
							
		<input name="Back" type="button" id="Back" value='确定返回' onClick="javascript:window.location='?controller={$smarty.get.controller}&action=right'"></td>
	
        <input type="hidden" name="chufangId" id="chufangId" value="{$smarty.get.chufangId}">
        <input type="hidden" name="order2wareId" id="order2wareId" value="{$smarty.get.id}">
</div>
</form>
</body>
</html>
