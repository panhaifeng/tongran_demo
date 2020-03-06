<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>消息</title>
</head>
<body  onload="movePFW()" style="background-color:#CCCCCC;padding:0px; margin:0px">
<fieldset style="margin-left:5px; margin-right;5px">     
<legend><img src="Resource/Image/System/0000.gif"></legend>
<div style="padding:0px; margin:0px">
	<table width="160" height="100" style="padding:0px; margin:0px;">
			<tr>
				<td colspan="2" align="center">通  知</td></tr>
			<tr>
				<td colspan="2" align="center">您有{$count}条新消息!</td></tr>
		  <tr>
				<td width="80" align="center">
				<input onclick="javascript:See();" type="button" value="查看"></td><td width="80" align="center"><input onclick="javascript:void(0);window.close();" type="button" value="退出"></td></tr>
	</table>
</div>
</fieldset>		

{literal}	
		<script language="javascript">
		//window.resizeTo(208,200);
		var windowW=200  // wide
		var windowH=200  // high
		var Yoffset=0   // in pixels, negative values allowed
		var windowStep=2 // move increment (pixels)
		var moveSpeed=12 // move speed (larger is slower)
		Xoffset=25;
		var windowX = (screen.width/2)-(windowW/2);
		windowX=screen.availWidth-Xoffset-windowW;
		var windowY = (screen.availHeight);
		var windowYstop = windowY-windowH-Yoffset;
		var windowYnow = windowY;
		window.focus ();
		resizeTo(windowW,windowH);
		moveTo(windowX,windowY);
		
		function movePFW()
		{
			if (document.all)
			{
				if (windowYnow>=windowYstop){
					moveTo(windowX,windowYnow);
					windowYnow=windowYnow-windowStep;
					timer=setTimeout("movePFW()",moveSpeed);
				}
				else
				{
					clearTimeout(timer);
					setTimeout("moveBack()",120000 );
					moveTo(windowX,windowYstop);
				}
			}
			else
			{
				moveTo(windowX,windowYstop);
			}
		}
		function moveBack()
		{
			if (document.all)
			{
				if (windowYnow<=windowY)
				{
					moveTo(windowX,windowYnow);
					windowYnow=windowYnow+windowStep;
					timer1=setTimeout("moveBack()",moveSpeed);
				}
				else
				{
					clearTimeout(timer1);
					moveTo(windowX,windowY);
					self.close();
				}
			}
			else
			{
				moveTo(windowX,windowYstop);
				self.close();
			}
		}
		function See()
		{
			window.opener.location= "Index.php?Controller=OA_SM";
			window.close();
		}
		</script>
		{/literal}
	</body>
</html>
