<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{webcontrol type='GetAppInf' varName='systemV'}</title>
<link rel="stylesheet" type="text/css" href="Resource/Css/LoginBetter.css">
{if $login.CssFile}<link rel="stylesheet" type="text/css" href="{$login.CssFile}">{/if}
<link type="favicon" rel="shortcut icon" href="favicon.ico" />
</head>
<body>
	<div class="container">
		<div class="header">
			<a href='http://www.eqinfo.com.cn' target="_blank"><div class="logo" style="background-image:url(Resource/Image/LoginNew/logo.png)"></div></a>
			<div class="link">
				<span>{webcontrol type='GetAppInf' varName='systemV'}</span>
				&nbsp;|&nbsp;
				<span>免费服务热线:{$login.servTel}</span>
			</div>
		</div>

		<div class="content" id="content">
			<img id="conimg" style="width:100%; height:100%">
				<div class="rightBox">
					<div class="header_login">
						<div id="common_login" to="kuaijie_form" class="login_btn col-6 text-center active">
						<div class="yaoshi"></div>
						账号密码登陆
						</div>
						<!-- <div id="kuaijie_login" to="qrcode_form" class="login_btn col-6 text-center">快速登陆</div> -->
						<div class="active_bottom">&nbsp;</div>
					</div>

					<!-- 密码登陆 -->
            <div id="divError"></div>
	        <div class="input input_block" id="kuaijie_form">
	        	<form action="{url controller=$smarty.get.controller action='login'}" method="post" autocomplete='off' id="form_login">
	        		<div class="uinArea" id="uinArea">
	        			<label class="input_tips" id="uin_tips" for="username">用户名</label>
		        			<input type="text" class="inputstyle" id="username" name="username"  tabindex="1">
	        		</div>
	        		<div class="pwdArea" id="pwdArea">
	        			<label class="input_tips" id="pwd_tips" for="password">密码</label>
	        				<input type="password" class="inputstyle password" id="password"  name="password" tabindex="2">
	        		</div>
	        		<div class="verifyArea" id="verifyArea">
	        			<label class="input_tips" id="verify_tips" for="verify">验证码/可以为空</label>
	        				<input type="text" class="inputstyle verify" id="verify" name="verify"  tabindex="3">
	        		</div>
	            <button type="submit" id="submit" tabindex="4">登 录</button>
	           </form>

	        </div>
					<!-- 二维码登陆 -->
					<!-- <div class="input input_hide" id="qrcode_form">
						<div class="login_text">请使用<span style='color:#3481D8'>微信扫一扫</span>登陆</div>
						<div class="br_20">&nbsp;</div>
						<div id="qrcode"><img src="Resource/Image/LoginNew/yiqi.png" /></div>
					</div> -->
                    <!-- 登录框下收藏和创建连接 -->
                    <div class="toolbar">
                        <a id='collect' href='javascript:void(addFavorite());'>
                            <img src="Resource/Image/toolbar/heart.png"/>
                            <span>加入收藏</span>
                        </a>
                        <a id='shortcut' href='javascript:void(createShortcut());'>
                            <img src="Resource/Image/toolbar/link.png"/>
                            <span>生成快捷方式</span>
                        </a>
                    </div>
				</div>

		</div>
		<div class="footer">
			<a href="http://www.eqinfo.com.cn" target="_blank">关于易奇</a>
			&nbsp;|&nbsp;
	      	<span class="gray">©2007 - {$smarty.now|default:'2015'|date_format:'%Y'} EQINFO Inc. All Rights Reserved.</span>
		</div>
	</div>
	<form action="{url controller=$smarty.get.controller action='createshortcuts'}" name="createshortcuts" target="_blank" method="post">
		<input type="hidden" name="furl" value=""/>
		<input type="hidden" name="fname" value=""/>
	</form>
	<!-- 近期跟新 -->
	<!-- <div class="main">
  <div class="main2"><a href="javascript:" class="bar"></a>
    <ol>
      <li>近期更新的内容：</li>
      <li>近期更新的内容：</li>
      <li>近期更新的内容：</li>
      <li>近期更新的内容：</li>
      <li>近期更新的内容：</li>
      <li>近期更新的内容：</li>
      <li>近期更新的内容：</li>
      <li>近期更新的内容：</li>
    </ol>
  </div>
</div> -->
<!-- 广告 -->
<!-- <TABLE height="29" border="0" cellspacing="0" class=rollboder>
  <TBODY>
  <TR>
    <TD height="22" class=rollleft>
      <DIV class=rollTextMenus>
      <DIV id=rollTextMenu1 style="DISPLAY: block"><STRONG>　相关企业：</STRONG> <A
      href="http://www.baidu.com" target="_blank">可能涉及到的企业1</A></DIV>
      <DIV id=rollTextMenu2 style="DISPLAY: none"><STRONG>　相关企业：</STRONG> <A
      href="http://www.eqinfo.com.cn" target="_blank">可能涉及到的企业2</A></DIV>
      <DIV id=rollTextMenu3 style="DISPLAY: none"><STRONG>　相关企业：</STRONG> <A
      href="http://www.qfc.cn" target="_blank">可能涉及到的企业3</A></DIV>
      <DIV id=rollTextMenu4 style="DISPLAY: none"><STRONG>　相关企业：</STRONG> <A
      href="http://www.youku.com" target="_blank">可能涉及到的企业4</A></DIV>
      <DIV id=rollTextMenu5 style="DISPLAY: none"><STRONG>　相关企业：</STRONG> <A
      href="http://www.1905.com" target="_blank">可能涉及到的企业5</A></DIV>
      <DIV id=rollTextMenu6 style="DISPLAY: none"><STRONG>　相关企业：</STRONG> <A
      href="http://www.cntrades.com" target="_blank">可能涉及到的企业6</A></DIV></DIV></TD>
    <TD class=rollcenter id=pageShow>1/6</TD>
    <TD class=rollright><A title=上一条 href="javascript:rollText(-1);"><IMG src="Resource/Image/last.gif"
      alt=上一条 width="11" height="11" border="0"></A> <A title=下一条 href="javascript:rollText(1);"><IMG src="Resource/Image/next.gif"
      alt=下一条 width="11" height="11" border="0"></A></TD>
</TR></TBODY></TABLE> -->

</body>
<script language="javascript" type="text/javascript" src="Resource/script/jquery.1.9.1.js"></script>
<script type="text/javascript">
{literal}
$(function(){
    $('.main').css('left','0');
    var expanded = true;
    $('.bar').click(function(){
    	if (expanded) {
    		$('.main').animate({left:'-262px'},500);
    		$('.bar').css('background-position','-25px 0px');

    	}else {
    		$('.main').animate({left:'0'},500);
    		$('.bar').css('background-position','-0px 0px');
    	}
    	expanded = !expanded;
    });
});
{/literal}
</script>
<script language="javascript" type="text/javascript" src="Resource/Script/jqueryNew.js"></script>
<script language="javascript" type="text/javascript" src="Resource/Script/jquery.form.js"></script>
{if $login.JsFile}<script language="javascript" type="text/javascript" src="{$login.JsFile}"></script>{/if}
<script type="text/javascript">
var backurl='{$login.bg}';
var btnColor='{$login.btnColor}';
{literal}
	$(function(){
		//加载界面就判断
		$('.inputstyle').each(function(){
			if(this.value==''){
				$(this).parent().find('label').css({'display':'block'});
			}else{
				$(this).parent().find('label').css({'display':'none'});
			}
		});
		//placeholder效果模拟
		$('.inputstyle').keydown(function(event){
			$(this).parent().find('label').css({'display':'none'});
		});
		$('.inputstyle').keyup(function(event){
			if(this.value==''){
				$(this).parent().find('label').css({'display':'block'});
			}else{
				$(this).parent().find('label').css({'display':'none'});
			}
		});
		$('.inputstyle').blur(function(){
			//边框
			$(this).removeClass('inputstyle_focus');

			//判断是否要显示label placeholder
			if(this.value==''){
				$(this).parent().find('label').css({'display':'block'});
			}else{
				$(this).parent().find('label').css({'display':'none'});
			}
		});

		//边框聚焦问题
		$('.inputstyle').focus(function(){
			$(this).addClass('inputstyle_focus');
		});

		//切换登陆方式
		$('.login_btn').click(function(){
			var that = this;
			//按钮颜色改变
			$('.login_btn').removeClass('active');
			$(that).addClass('active');

			$('.active_bottom').css({'left':(that.offsetLeft+35)+'px'});

			//显示的登陆框改变
			$('.input').removeClass('input_block').addClass('input_hide');
			$('#'+$(that).attr('to')).removeClass('input_hide').addClass('input_block');
		});

        //聚焦用户名输入
        $('#username').focus();

        //确定按钮点击后效果
        $('#form_login').submit(function(){
            $('#submit').attr('disabled',true);
            $('#submit').text('登录中…');
            $(this).ajaxSubmit({
                'data':{'is_ajax':true},
                success:function(t,b,f){
                    var json = eval("("+t+")");
                    if(json.success==true){
                        showError('登陆成功');
                        setTimeout(function(){window.location.href=json.href;}, 500);
                    }else{
                        showError(json.msg);
                        setTimeout(function(){
                            $('#submit').attr('disabled',false);
                            $('#submit').text('登 录');
                        }, 500);
                    }
                }
            });

            return false;
        });

		// $('#content').css("backgroundImage","url("+backurl+")");
		$('#conimg').attr("src",backurl);
		$('#submit').css("background-color",btnColor);
	});


    // 显示登陆验证信息
    function showError(text) {
        $('#divError').text(text).fadeIn('slow');
        setTimeout(function(){$('#divError').fadeOut('normal');}, 3500);
    }
void function(){
 	var sURL = location.href;
 	var sTitle = document.title;
	// 加入收藏夹
 	addFavorite = function(){
        try
        {
            window.external.addFavorite(sURL, sTitle);
        }
        catch (e)
        {
            try
            {
                window.sidebar.addPanel(sTitle, sURL, "");
            }
            catch (e)
            {
				var c = "ctrl";
				if(navigator.platform.match(/mac/i)){
					 c = "command"
				}
                alert("您的浏览器不支持,请使用键盘上\n\n"+c+"+D\n\n进行收藏操作。");
            }
        }
		return false;
    }
    //生成快捷方式
   	createShortcut = function(){
	   var sname  =  document.title.replace(/\s/ig,'');
	   var surl   =	 location.href;
	   document.createshortcuts.furl.value = surl;
	   document.createshortcuts.fname.value = sname;
       document.createshortcuts.submit();
   	}
}();
{/literal}
</script>
<SCRIPT type=text/javascript>
{literal}
				<!--
				var rollText_k=6; //菜单总数
				var rollText_i=1; //菜单默认值
				//setFocus1(0);
				rollText_tt=setInterval("rollText(1)",3000);
				function rollText(a){
				clearInterval(rollText_tt);
				rollText_tt=setInterval("rollText(1)",3000);
				rollText_i+=a;
				if (rollText_i>rollText_k){rollText_i=1;}
				if (rollText_i==0){rollText_i=rollText_k;}
				//alert(i)
				 for (var j=1; j<=rollText_k; j++){
				 document.getElementById("rollTextMenu"+j).style.display="none";
				 }
				 document.getElementById("rollTextMenu"+rollText_i).style.display="block";
				 document.getElementById("pageShow").innerHTML = rollText_i+"/"+rollText_k;
				}
				//-->
{/literal}
</SCRIPT>
</html>
