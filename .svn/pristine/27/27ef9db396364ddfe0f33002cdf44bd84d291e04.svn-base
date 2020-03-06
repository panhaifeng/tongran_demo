<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
<link href="Resource/Css/Edit.css" type="text/css" rel="stylesheet">
{literal}
<style type="text/css">

</style>
{/literal}
<script language="javascript">
{literal}

$(function(){
    $.validator.addMethod("checkPass", function(value, element) {
        var o = document.getElementById('passwd');
        if(o.value!=value || value=='')
        return false;
        return true;
    }, "密码不匹配!");

    $('#form1').validate({
        rules:{
            userName:"required",
            realName:"required",
            tel:"required",
        },
        submitHandler : function(form){
            $('#Submit').attr('disabled',true);
            $('#Submit1').attr('disabled',true);
            form.submit();
        }
    });
    //ret2cab();
});
{/literal}
</script>
</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='InfoPerfectSave'}" method="post">
<input name="id" type="hidden" id="id" value="{$aUser.id}" />
<input name="from" type="hidden" id="from" value="{$smarty.get.from}" />
<fieldset>
<legend>用户信息完善</legend>
<table>
  <tr>
    <td align="right" bgcolor="#CCCCCC" class="tdTitle">真实姓名：</td>
    <td><input name="realName" type="text" id="realName" readonly="" value="{$aUser.realName}"/></td>
    </tr>
   <!--  <tr>
   <td align="right" bgcolor="#CCCCCC" class="tdTitle">身份证号：</td>
   <td><input name="shenfenzheng" type="text" id="shenfenzheng" value="{$aUser.shenfenzheng}"/></td>
   </tr> -->
    <tr>
    <td align="right" bgcolor="#CCCCCC" class="tdTitle">手机号：</td>
    <td><input name="tel" type="text" id="tel" value="{$aUser.tel}"/></td>
    </tr>
 </table>
<table>
<tr>
    <td><input type="submit" id="Submit" name="Submit" value='保存' class="button"></td>
    <td><input type="button" id="Back" name="Back" value='返回' onClick="javascript:window.history.go(-1);" class="button"></td>
    </tr>
</table>
</fieldset>
</form>
</body>
</html>
