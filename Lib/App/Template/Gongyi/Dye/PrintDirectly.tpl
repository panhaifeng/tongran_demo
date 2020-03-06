<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>工艺处方单打印</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css">
{if $smarty.get.kind==1} 
	<script language="javascript" src="Resource/Script/Gongyi/PrintChufang3.js"></script>	
{else} 
	<script language="javascript" src="Resource/Script/Gongyi/PrintChufang1.js"></script>
{/if}
{literal}
<script language="javascript" src="Resource/Script/Lodop/CheckActivX.js"></script>

<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0>
  <param name="CompanyName" value="常州易奇信息科技有限公司">
  <param name="License" value="664717080837475919278901905623">
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript">
$(function(){
		var obj = {/literal}{$row|@json_encode}{literal};
		//alert(LODOP);
		CreatePrintPage(obj,0,0);
		//alert(1);
		//LODOP.PRINT_DESIGN();return false;
		{/literal}
		{if $smarty.get.preview==1}
		LODOP.PREVIEW();
		{else}
		LODOP.PREVIEW();return false;
		LODOP.PRINT();
		{/if}
		{literal}if(window.opener) window.close();else window.location.href=document.referrer;
		//LODOP.PRINT();if(window.opener) window.close();else window.location.href=document.referrer;
});
</script>
{/literal}
</head>
<body>
<script language="javascript">CheckLodop();</script>
</body></html>
