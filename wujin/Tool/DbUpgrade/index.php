<?php
require "config.php";
//array2file(array('a'=>array(0=>"select * from 'aa'\"",1=>'aa'),'b'=>array(0=>'b',1=>'bb')),'log.ini');
//print_r(file2array('log.ini'));
//exit;
if($_SERVER['REQUEST_METHOD']=='POST') {
	$arrSql = array_filter(explode(';',str_replace("\r\n",'',trim(stripslashes($_POST["newSql"])))));
	if(count($arrSql)>0) {
		//print_r($arrSql);exit;
		$dt = date('Y-m-d H:i:s');
		
		//新增的sql语句写入本机的执行记录表中
		foreach($arrSql as & $v) {
			$vv = str_replace("'","''",$v);
			$sql = "insert into sql_log (dtCreate,dtExcute,strSql,isError) values('{$dt}','{$dt}','{$vv}',2)";
			//echo $sql;exit;
			mysql_query($sql) or die($sql."<br>".mysql_error());
		}
		
		$arr =file2array('log.ini');
		$arr[$dt] = $arrSql;

		//进行排序，重新写入ini文件
		$arrKey = array();
		foreach($arr as $key =>&$v) {
			$arrKey[] = $key;
		}
		sort($arrKey);

		$ret = array();
		//删除ini文件超过cntLogLine行的记录,每次更新不要超过cntLogLine行
		foreach($arrKey as $key=>&$v) {
			if($key>$cntLogLine) break;
			$ret[$v] = &$arr[$v];
		}
		array2file($ret,'log.ini');
	}
	header('Location:index.php');exit;
}

//判断是否需要执行初始化
$sql = "select * from `sql_log`";
mysql_query($sql) or ($n=mysql_errno());
if($n==1146) {
	$createSql = "CREATE TABLE IF NOT EXISTS `sql_log` (
	  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
	  `dtCreate` datetime NOT NULL COMMENT '产生时间',
	  `dtExcute` datetime NOT NULL COMMENT '执行时间',
	  `strSql` text COLLATE utf8_bin NOT NULL COMMENT 'sql语句',
	  `isError` tinyint(1) NOT NULL COMMENT '是否出错',
	  PRIMARY KEY (`id`),
	  KEY `dtCreate` (`dtCreate`),
	  KEY `dtExcute` (`dtExcute`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='数据库结构改变日志' AUTO_INCREMENT=1";
	//$s = str_replace("'","''",$createSql);
	mysql_query($createSql) or die('数据表初始化失败');
	//array2file(null,'log.ini');
}
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
#divIni {height:200px; overflow:auto;}
#divLog {height:200px; overflow:auto;}
</style>
</head>
<body>
<h3>数据库结构维护程序(by jeff)  <font color='red'><?php echo "当前数据库:".$db_name?></font> <a href="readme.txt" target='_blank'>使用说明(readme.txt)</a></h3>
<form id="form1" name="form1" method="post" action="" onSubmit="return document.getElementById('newSql').value=='' ? false : true;">
  <fieldset>
    <legend>输入新增语句</legend>
    <label>
      <textarea name="newSql" id="newSql" cols="80" rows="10"></textarea>
    </label>
    <input type="submit" name="button" id="button" value="提交" />
  </fieldset>
</form>
<fieldset>
  <legend><font color='red'>需要执行的语句</fotn> <a href='auto_up_db.php' target="_blank">确认执行</a></legend>
  <div id='divIni'>
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <?php
	//$str = file_get_contents('log.ini');
	//if($str) eval('$arr='.$str.';');
	$arr =file2array('log.ini');
	foreach($arr as $key =>& $v) {
		//判断是否执行。
			$sql = "select count(*) cnt from sql_log where dtCreate='$key'";
			//echo $sql;exit;
			$tt = mysql_fetch_assoc(mysql_query($sql));
			if($tt['cnt']>0) continue;
			$color='red';
	?>
    <tr>
      <td><strong><em>[ <?php echo $key?> ]</em></strong>
      <?php
	  	foreach ($v as $k=>& $vv) {
			echo "<br/>{$k}. <font color='{$color}'>{$vv}</font>";
		}
	  ?>
      </td>
    </tr>
    <?php
	}
	?>
  </table>
  </div>
</fieldset>
<fieldset>
  <legend>近<?php echo $cntLogLine?>条执行记录</legend>
  <div id='divLog'>
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
	  <td width="100" bgcolor="#CCCCCC">出错</td>
      <td width="150" bgcolor="#CCCCCC">cteate time</td>
      <td width="150" bgcolor="#CCCCCC">execute time</td>
      <td width="687" bgcolor="#CCCCCC">sql</td>
    </tr>
  <?php
  $sql = "select * from sql_log order by dtExcute desc limit 0,{$cntLogLine}";
  $query = mysql_query($sql) or die(mysql_error());
  while ($re = mysql_fetch_assoc($query)) {
	  $bgColor = $re['isError']==1?'red':($re['isError']==2?'green':'');
  ?>
    <tr bgcolor='<?php echo $bgColor?>'>
	  <td><?php echo $re['isError']==1?'出错':($re['isError']==2?'主动新增':'被动更新')?></td>
      <td><?php echo $re['dtCreate']?></td>
      <td><?php echo $re['dtExcute']?></td>
      <td><?php echo $re['strSql']?></td>
    </tr>
    <?
  }
    ?>
  </table>
  </div>
</fieldset>
</body>
</html>