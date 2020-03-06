<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<link href="Resource/Css/Main.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript" src="Resource/Script/jquery.js"></script>
	<script src="Resource/Script/treeview/tree.js" type="text/javascript" ></script>
    <script src="Resource/Script/Common.js" type="text/javascript" ></script>
    <script src="Resource/Script/Calendar.js" type="text/javascript" ></script>
    <link href="Resource/Script/treeview/tree.css" type="text/css" rel="stylesheet">
    <link href="Resource/Css/Main.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">		
		var o = {			
			url: "?controller=Jichu_Ware&action=GetTreeJson" ,
			//showcheck: true, //是否显示选择
			oncheckboxclick: false, //当checkstate状态变化时所触发的事件，但是不会触发因级联选择而引起的变化
			onnodeclick: false,
			cascadecheck: true,
			data: null,
			clicktoggle: true, //点击节点展开和收缩子节点
			theme: "bbit-tree-arrows", //bbit-tree-lines ,bbit-tree-no-lines,bbit-tree-arrows
			//onexpand : null,
			onnodeclick: function(json){
			             
			}
		};
		o.data = {/literal}{$data}{literal};
		var ware={/literal}{$aRow}{literal};
		var row={/literal}{$row1}{literal};
		//如果_cacheFunc存在,需要根据cacheFunc中的值改变子节点的状态。
		o.onexpand = function(item){
			var nodes = item.ChildNodes;
			//根据_cacheFunc中的值，设置nodes中的checkstate值
			//dump(row);return false;
			for (var i=0;nodes[i];i++){
				if(item.checkstate==1) {
					$('#tree').changeCheckstate(nodes[i].id,1);
					continue;
				}
				//dump(ware[0]);return false;
				if(ware==null)return false;
				for(var j=0;ware[j];j++) {
					//if equal click
					if(ware[j].id==nodes[i].id) {
						$('#tree').changeCheckstate(nodes[i].id,1);
						break;
					}
				}
			}
			//dump(_cacheFunc);return false;
		}
		//dump(dep[0]);
        $(document).ready(function() {
            $("#tree").treeview(o);
			$('#btnSel').click(function(){
					var userId=$('#userId').val();
   					//alert(userId);return false;
					var url='?controller=Acm_User&action=AssignWareByAjax';
					var param={userId:userId};
					var s=$("#tree").getTSVs();
					if(s !=null) for(var i=0;s[i];i++) {
						url+='&wareId[]='+s[i];
					}
					//alert(url);return false;
					$.getJSON(url,param,function(json){
							if(!json) return false;
							//dump(json);return false;
							if(json['success']==true) {
								alert('保存成功!');
							}else alert(json.msg);
					});
			});
			
        });
		
		reCheck();
		function ret(obj) {	
			window.parent.ymPrompt.doHandler(obj,true);
		}
		function reCheck(){
			if(ware==null)return false;
			if(ware.length>0){
			for(var i=0;ware[i];i++){
					for(var j=0;o.data[j];j++){
						//如果节点存在，选中
						if(o.data[j].id==ware[i].id) {
							o.data[j].checkstate=1;
							break;
						}else{
							//如果节点的路径中存在，设置checkstate=2
							for(var k=0;row[j].path[k];k++) {
								if(ware[i].id==row[j].path[k]) {
									o.data[j].checkstate=2;
									break;
								}
							}
						}
					}
				}
			}
		}
</script>
{/literal}
</head>

<body>
<table width="60%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>用户名：{$row.realName}</td>
  </tr>
  <tr>
    <td>
      <div style="border-bottom: #c3daf9 1px solid; border-left: #c3daf9 1px solid; width: 100%; height: 500px; overflow: auto; border: #999 1px dotted; float:left; margin-left:0px;margin-top:8px; background-color:#FFF">       
        <div id="tree" style="text-align:left"></div>
    </div>	
    </td>
  </tr>
  <tr>
    <td><input type="submit" name="btnSel" id="btnSel" value="提交">
    <!--<input type="button" name="btnSel" id="btnSel" value="tttt" onClick=" dump($('#tree').getTSVs())">-->
    <input name="userId" type="hidden" id="userId" value="{$row.id}"></td>
  </tr>
</table>
</body>
</html>
