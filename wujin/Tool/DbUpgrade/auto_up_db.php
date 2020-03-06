<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div>
<?php
require 'config.php';
//根据ini文件中的内容，和数据库中的记录进行比对，发现新的记录，在数据库中执行。
$arr =file2array('log.ini');
//$newArr = array();
//if($str) eval('$arr='.$str.';');
foreach ( $arr as $key=>&$v) {
	$sql = "select count(*) cnt from sql_log where dtCreate='{$key}'";
	$re = mysql_fetch_assoc(mysql_query($sql));
	if($re['cnt']>0) continue;
	foreach ($v as & $vv) {
		$temp = str_replace("'","''",$vv);
		if(mysql_query($vv)) {
			echo "<font color='green'>".$vv.";成功</font><br>";
			//写入sql_log表
			$sql = "insert into sql_log (dtCreate,dtExcute,strSql) values('{$key}','".date('Y-m-d H:i:s')."','".$temp."')";
			mysql_query($sql) or die($sql."<br>".mysql_error());
			//
		}
		else {
			//写入sql_log表
			$sql = "insert into sql_log (dtCreate,dtExcute,strSql,isError) values('{$key}','".date('Y-m-d H:i:s')."','".$temp."',1)";
			mysql_query($sql) or die($sql."<br>".mysql_error());
			echo("<font color='red'>{$vv}</font>"."<br/><span style='color:red' title='".mysql_error()."'>执行出错</span><br>");
		}
	}
}

?>
</div>
</body>
</html>