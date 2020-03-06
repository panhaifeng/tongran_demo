<style>
{literal}
h1 {
  background: #F4FAFB;
  border: 1px solid #BBDDE5;
  color: #9CACAF;
  font-size: 14px;
  padding: 7px 10px;
  margin: 5px 0 0 0;
}

h1 a:visited {
  color: #9CACAF;
}

h1 a:link {
  color: #9CACAF;
}

h1 a:hover {
	color: #EB8A3D;
	font-weight:bold;
}

h1 .action-span {
  float: right;
  padding-left: 10px;
  padding-right: 10px;
  border-left: 2px solid #B8B8B8;
}

h1 .action-span a {
  color: #B8B8B8;
  font-size: 14px;
  font-weight: lighter;
}
{/literal}
</style>

<script type="text/javascript">
{literal}
function modalDialog(url, name, width, height)
{
  if (width == undefined)
  {
    width = 400;
  }
  if (height == undefined)
  {
    height = 300;
  }

  x = (window.screen.width - width) / 2;
  y = (window.screen.height - height) / 2;
  try
  {
    window.showModalDialog(url, name, 'dialogWidth=' + (width) + 'px; dialogHeight=' + (height+5) + 'px; status=off');
  }
  catch (ex)
  {
    window.open(url, name, 'height='+height+', width='+width+', left='+x+', top='+y+', toolbar=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, modal=yes');
  }
}
{/literal}
</script>
<h1>
	<!--<span style="color:#CCCCCC">{$smarty.get.controller},{$smarty.get.action}</span>-->
	<span class="action-span">
	<a href="javascript:modalDialog('Index.php?controller=main&action=calculator', 'calculator', 340, 250)">计算器</a>
	</span>
	<span class="action-span">
	<a href="javascript:window.document.location.reload()">刷新</a>
	</span>
	<span>当前位置&nbsp;&raquo;&nbsp;{$title}</span>
</h1>