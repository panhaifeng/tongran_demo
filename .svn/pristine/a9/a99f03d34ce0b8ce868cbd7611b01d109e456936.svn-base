<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{literal}
<head>
    <title>Big Tree</title>
	<script language="javascript" src="Resource/Script/jquery.js"></script>
	<script src="Resource/Script/treeview/tree.js" type="text/javascript" ></script>
    <script src="Resource/Script/Common.js" type="text/javascript" ></script>
    <link href="Resource/Script/treeview/tree.css" type="text/css" rel="stylesheet">
    <link href="Resource/Css/Main.css" type="text/css" rel="stylesheet">
    <script type="text/javascript">
		var _cacheFunc = new Array();//当前角色拥有的node
		var _cRow = null;//当前被选中的行
		var o = {
			showcheck: true,
			url: "?controller=Jichu_Ware&action=GetTreeJson" ,
			showcheck: true, //是否显示选择
			oncheckboxclick: false, //当checkstate状态变化时所触发的事件，但是不会触发因级联选择而引起的变化
			onnodeclick: false,
			cascadecheck: true,
			data: null,
			clicktoggle: true, //点击节点展开和收缩子节点
			theme: "bbit-tree-arrows", //bbit-tree-lines ,bbit-tree-no-lines,bbit-tree-arrows
			onnodeclick: function(){
				var s=$("#tree").getTCT();
				//dump(s);exit;
				document.getElementById('fra').src = "?controller=cangku_kucun&action=InitRight&parentId="+s.value;
				//dump(s);                
			}
		};
		o.data = {/literal}{$data}{literal};

		//节点展开完成时，如果当前节点的checkstate=1,所有子节点的checkstate置为1
		//如果_cacheFunc存在,需要根据cacheFunc中的值改变子节点的状态。
		o.onexpand = function(item){
			var nodes = item.ChildNodes;
			//根据_cacheFunc中的值，设置nodes中的checkstate值
			for (var i=0;nodes[i];i++){
				if(item.checkstate==1) {
					$('#tree').changeCheckstate(nodes[i].id,1);
					continue;
				}
				for(var j=0;_cacheFunc[j];j++) {
					//if equal click
					if(_cacheFunc[j].id==nodes[i].id) {
						$('#tree').changeCheckstate(nodes[i].id,1);
						break;
					}
					//路径中存在部分选择
					for(var k=0;_cacheFunc[j].path[k];k++) {
						if(_cacheFunc[j].path[k]==nodes[i].id) {
							//nodes[i].checkstate=2;
							//$('#tree_'+nodes[i].id+'_cb').attr("src", dfop.cbiconpath + dfop.icons[item.checkstate]);
							$('#tree').changeCheckstate(nodes[i].id,2);
						}
					}
				}
			}


			/*if (item.render && pstate != item.checkstate) {
                var et = $("#" + id + "_" + item.id + "_cb");
                if (et.length == 1) {
                    et.attr("src", dfop.cbiconpath + dfop.icons[item.checkstate]);
                }
            }*/
			//debugger;
		}

        $(document).ready(function() {
            $("#tree").treeview(o);
			$('tr[id="trRole"]').click(function(){
				if(_cRow) _cRow.style.backgroundColor='#efefef';
				_cRow = this;
				_cRow.style.backgroundColor = 'lightgreen';
				_cacheFunc = new Array();
				//单击某个角色，将这个角色拥有的所有funcId存入缓存中，然后根据缓存中的值，刷新树的被选中状态
				var url='?controller=Acm_Role&action=getJsonRole';
				var param={roleId:$(this).attr('val')};
				$.getJSON(url,param,function(json){
					if(!json) {
						reCheck();
						return false;
					}
					if(json.length) {
						for(var i=0;json[i];i++) {
							_cacheFunc.push(json[i]);
						}
						//dump(_cacheFunc);
						//改变treeview的选中状态
						reCheck();
					}
				});

			});
            $("#showchecked").click(function(e){
                var s=$("#tree").getTSVs();
                if(s !=null)
                alert(s.join(","));
                else
                alert("NULL");
            });
            $("#showcurrent").click(function(e){
                var s=$("#tree").getTCT();
                if(s !=null)
                    //alert(s.text);
					dump(s);
                else
                    alert("NULL");
            });
			$('#btnSub').click(function(){
				if(_cRow==null) return false;
				//取得所有已选中的节点,提交
				var url='?controller=Acm_Func&action=AssignFuncByAjax';
				var param={roleId:$(_cRow).attr('val')};
				var s=$("#tree").getTSVs();
				if(s !=null) for(var i=0;s[i];i++) {
					url+='&funcId[]='+s[i];
				}
				$.getJSON(url,param,function(json){
					if(!json) return false;
					if(json['success']==true) {
						alert('保存成功!');
					}else alert(json.msg);
				});

			});
        });
		function reCheck(){
			//刷新整个视图
			o.data = null;
			o.data = {/literal}{$data}{literal};
			//debugger;
			if(_cacheFunc.length>0) for(var i=0;_cacheFunc[i];i++) {
				for(var j=0;o.data[j];j++) {
					//如果节点存在，选中
					if(o.data[j].id==_cacheFunc[i].id) {
						o.data[j].checkstate=1;
						break;
					}
					//如果节点的路径中存在，设置checkstate=2
					for(var k=0;_cacheFunc[i].path[k];k++) {
						if(o.data[j].id==_cacheFunc[i].path[k]) {
							o.data[j].checkstate=2;
							break;
						}
					}
				}

			}
			$("#tree").treeview(o);
		}
    </script>
</head>
{/literal}
<body>
	<div style="text-align:left">{include file="_ContentNav2.tpl"}</div>
    
    <div style="border-bottom: #c3daf9 1px solid; border-left: #c3daf9 1px solid; width: 20%; height: 500px; overflow: auto; border: #999 1px dotted; float:left; margin-left:0px;margin-top:8px; background-color:#FFF">
        <div style="clear:both; background-color:#CCC; height:25px; padding:5px;">选择物料</div>
        <div id="tree" style="text-align:left"></div>
    </div>	
    <div style="border-bottom: #aaa 1px solid; border-left: #aaa 1px solid; width: 75%; height: 500px; overflow: hidden; border-top: #aaa 1px solid; border-right: #aaa 1px solid; float:left;margin-left:8px;margin-top:8px;">
      <iframe src="{url controller='cangku_kucun' action='InitRight'}" frameborder="0" name="fra" id='fra' scrolling="no" framespacing="0" style="width:100%;height:100%;visibility:inherit;z-index:3"></iframe>
	</div>
</body>
</html>