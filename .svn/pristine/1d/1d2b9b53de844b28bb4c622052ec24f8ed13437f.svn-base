<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>选择客户</title>
<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css" />
<link href="Resource/Css/page.css" rel="stylesheet" type="text/css" />
<script language="javascript">
{literal}
function retClient(id,val){
	var obj = {clientId:id,compName:val};
	window.returnValue=obj;
	window.close();
}
{/literal}
</script>
</head>
<base target="_self">
<body>
<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">
	
  <tr>
    <td background="Resource/Image/System/bg_search.gif" width="798" height="25">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><em><strong>选择客户</strong></em></td>
      </tr>
      <tr>
        <form method="post" action="" name="FormSearch">
        <td align="center">类别：
        <select name="arType" id="arType" onChange="FormSearch.submit()">  
        {webcontrol type='TmisOptions' model='CaiWu_ArType' selected=$s.arType}
        </select>
          本厂负责人：
          <select name="traderId" id="traderId" onChange="FormSearch.submit()">
			{webcontrol type='TmisOptions' model='JiChu_Employ' selected=$s.traderId condition='depId=11'}
    	  </select>
          关键字：
          <input name="key" type="text" size="10" value="{$smarty.post.key|default:$smarty.get.key}"/>
          <input type="submit" name="Submit" value="搜索" />
          <a href="?controller=JiChu_Client&Action=Add">新增</a></td>
      	</form>
	  </tr>	
    </table></td>
  </tr>  
	<tr>
		<td>{include file="_TableForBrowse.tpl"}</td>
	</tr>
	<tr height=""><td>{$page_info}</td></tr>
</table>
</body>
</html>
