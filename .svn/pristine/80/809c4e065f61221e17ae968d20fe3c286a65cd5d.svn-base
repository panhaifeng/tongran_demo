<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>二维码</title>
    {webcontrol type='LoadJsCss' src="Resource/Script/Calendar/WdatePicker.js"}
    {webcontrol type='LoadJsCss' src="Resource/Script/jquery/1.9.1/jquery.js"}
    {webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.2.0/css/bootstrap.css"}
    {webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.2.0/js/bootstrap.min.js"}
    {webcontrol type='LoadJsCss' src="Resource/BtGrid/btGrid.2.0.js"}
    {webcontrol type='LoadJsCss' src="Resource/BtGrid/btGrid.css"}
<style type="text/css">
{literal}
 body{
    background: #EBF1F2;
    /*height:100%;*/
  }
.cal{
  padding: 10px;
  /*height: 100%;*/
}
.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active {
    background: #007aff;
    color: white;
    border-color: #007aff;
}
.btn-default{
    background: transparent;
    color: #007aff;
    border-color: #007aff;
}
.codeImg{
    height: 20px;padding-left: 25%;
}
.headOne,.bodyTwo{height: 200px;}
</style>
{/literal}
<script type="text/javascript">
{literal}
$(function(){
    // $('.bind').hover(function() {
    //     document.getElementById("wxImg").style.display="block";
    // }, function() {
    //     document.getElementById("wxImg").style.display="none";
    // });
    // $('.focus').hover(function() {
    //     document.getElementById("focusImg").style.display="block";
    // }, function() {
    //     document.getElementById("focusImg").style.display="none";
    // });
});


{/literal}
</script>
</head>
<body>
  <div class=" cal">
    <div class="col-md-12" >
        <div class="alert alert-success alert-dismissible headOne" role="alert" >
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <a class="bind">1.扫码或搜索“易奇色织”打开小程序（注：建议设置为我的小程序,微信下拉快速打开）</a>
            <div id="wxImg" class="codeImg">
               <img src="{$miniUrl}" width="450px" height="150px;" />
            </div>&nbsp;
        </div>

        <div class="alert alert-success alert-dismissible bodyTwo" role="alert" >
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <a class="focus">2.小程序扫码登录账号(注：请不要泄露安全二维码)</a>
            <div id="focusImg" class="codeImg">
               <img src="{$currPro}" width="150px" height="150px;" />
            </div>
        </div>
    </div>

    <div class="col-md-12" >

    </div>
  </div>
</body>
</html>