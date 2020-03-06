<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>打印染化料领料单</title>
<link href="Resource/Css/print.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="Resource/Script/Lodop/CheckActivX.js"></script>
<object id="LODOP" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
  <param name="CompanyName" value="常州易奇信息科技有限公司">
  <param name="License" value="664717080837475919278901905623">
</object>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/PrintYlck.js"></script>
{literal}
<script language="javascript">
$(function(){
	var obj = {/literal}{$obj|@json_encode}{literal};	
	//dump(obj);
	for(var i=1;obj[i];i++) {
		CreatePrintPage(obj[i],i,obj.length-1);
		//CreatePrintPage(obj[i]);
		//LODOP.PRINT_DESIGN();return false;
		LODOP.PRINT();
	}
	if(window.opener) window.close();else window.location.href=document.referrer;
});
</script>
{/literal}
</head>
<body style="margin-top:0px">
<script language="javascript">CheckLodop();</script>
</body>
</html>
