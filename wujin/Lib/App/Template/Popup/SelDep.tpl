<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{literal}
<head>
    <title>Big Tree</title>
	<script language="javascript" src="Resource/Script/jquery.js"></script>
	<script src="Resource/Script/treeview/tree.js" type="text/javascript" ></script>
    <script src="Resource/Script/Common.js" type="text/javascript" ></script>
    <script src="Resource/Script/Calendar.js" type="text/javascript" ></script>
    <link href="Resource/Script/treeview/tree.css" type="text/css" rel="stylesheet">
    <link href="Resource/Css/Main.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">
		var _cacheFunc = new Array();//当前角色拥有的node
		var _cRow = null;//当前被选中的行
		
		var o = {			
			url: "?controller=Jichu_Department&action=GetTreeJson" ,
			showcheck: true, //是否显示选择
			oncheckboxclick: false, //当checkstate状态变化时所触发的事件，但是不会触发因级联选择而引起的变化
			onnodeclick: false,
			cascadecheck: true,
			data: null,
			clicktoggle: true, //点击节点展开和收缩子节点
			theme: "bbit-tree-arrows", //bbit-tree-lines ,bbit-tree-no-lines,bbit-tree-arrows
			onexpand : null,
			onnodeclick: function(){
				var s=$("#tree").getTCT();
				//dump(s);return false;
				if(s.hasChildren) return false;
				ret(s)
				//dump(s);                
			}
		};
		
		o.data = {/literal}{$data}{literal};
        $(document).ready(function() {
            $("#tree").treeview(o);
        });
		function ret(obj) {	
			window.parent.ymPrompt.doHandler(obj,true);//return false;
			//window.returnValue=arr;
			//window.close();
			
			//如果是iframe,改变opener中的变量,并执行callback(arr);
		}
    </script>
</head>
{/literal}
<body>    
    <div style="border-bottom: #c3daf9 1px solid; border-left: #c3daf9 1px solid; width: 100%; height: 500px; overflow: auto; border: #999 1px dotted; float:left; margin-left:0px;margin-top:8px; background-color:#FFF">       
        <div id="tree" style="text-align:left"></div>
    </div>	    
</body>
</html>