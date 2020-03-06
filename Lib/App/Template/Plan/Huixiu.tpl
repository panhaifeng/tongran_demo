<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>修改排缸信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
</head>
<body>
<form name="form1" action="{url controller=$smarty.get.controller action=saveHuixiu}" method=post>
<fieldset>     
<legend>输入回修原因</legend>
	<div align="center">
      <div>
        <textarea name="reasonHuixiu" id="reasonHuixiu" cols="50" rows="10">{$smarty.get.reasonHuixiu}</textarea>
      </div>
	  <div style="clear:both;">
	    <input name="id" type="hidden" id="id" value="{$smarty.get.id}" />
	    <input type="submit" name="Submit" value="提交">
        <input type="button" name="Submit2" value="取消" onclick="window.parent.tb_remove()"/>
	  </div>

</div>
</fieldset>
</form>
</body>
</html>