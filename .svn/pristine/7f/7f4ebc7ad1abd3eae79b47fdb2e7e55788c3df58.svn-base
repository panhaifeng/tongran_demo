<?php
$db_name = 'e7_gangwu';
mysql_connect('localhost','root','eqinfo');
mysql_select_db($db_name) or die(mysql_error());
mysql_query('set names utf8');
$cntLogLine=50;//log文件中最多保留的sql语句条数
function array2file($array, $filename) {
	//print_r($array);exit;
	file_exists($filename) or touch($filename);
	$c = '';
	foreach($array as $key=>&$v) {
		$c.="\n[{$key}]";
		foreach($v as $k=>&$vv) {
			$c.="\n	{$k}=\"{$vv}\"";
		}
	}
	//echo $c;exit;
	file_put_contents($filename, $c);
	//file_put_contents($filename, $array ? var_export($array, TRUE):'');
}
function file2array($filename) {
	//echo $filename;exit;
	return parse_ini_file($filename,true);
}
?>