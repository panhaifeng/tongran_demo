<?php
mysql_connect('localhost','root','eqinfo');
mysql_select_db('e7_gangwu11');
mysql_query('set names utf8');
function dump($vars, $label = '', $return = false)
 {
     if (ini_get('html_errors')) {
         $content = "<pre>\n";
         if ($label != '') {
             $content .= "<strong>{$label} :</strong>\n";
         }
         $content .= htmlspecialchars(print_r($vars, true));
         $content .= "\n</pre>\n";
     } else {
         $content = $label . " :\n" . print_r($vars, true);
     }
     if ($return) { return $content; }
     echo $content;
     return null;
 }

function array_sortby_multifields($rowset, $args){
     $sortArray = array();
     $sortRule = '';
     foreach ($args as $sortField => $sortDir) {
         foreach ($rowset as $offset => $row) {
             $sortArray[$sortField][$offset] = $row[$sortField];
         }
         $sortRule .= '$sortArray[\'' . $sortField . '\'], ' . $sortDir . ', ';
     }
     if (empty($sortArray) || empty($sortRule)) { return $rowset; }
     eval('array_multisort(' . $sortRule . '$rowset);');
     return $rowset;
}

function array_column_sort($array, $keyname, $sortDirection = SORT_ASC){
    return array_sortby_multifields($array, array($keyname => $sortDirection));
}


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<div style="width:100%; height:200px; overflow:auto; border:1px solid #000">
所有出库金额为0的记录如下（单击分析按钮进行单价分析）:
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td bgcolor="#CCCCCC">chuku2wareId</td>
    <td bgcolor="#CCCCCC">wareId</td>
    <td bgcolor="#CCCCCC">编码</td>
    <td bgcolor="#CCCCCC">品名</td>
    <td bgcolor="#CCCCCC">规格</td>
    <td bgcolor="#CCCCCC">出库单号</td>
    <td bgcolor="#CCCCCC">出库时间</td>
    <td bgcolor="#CCCCCC">出库数量</td>
    <td bgcolor="#CCCCCC">出库单价</td>
    <td bgcolor="#CCCCCC">出库金额</td>
    <td bgcolor="#CCCCCC">加权单价</td>
    <td bgcolor="#CCCCCC">操作</td>
  </tr>
  <?php
  $str = "select x.*,y.wareCode,y.wareName,y.guige,z.chukuCode,z.chukuDate,a.jqDanjia
	from cangku_chuku2ware x
	left join jichu_ware y on x.wareId=y.id 
	left join cangku_chuku z on x.chukuId=z.id
	left join cangku_kucun a on a.wareId=x.wareId
	where (x.money<0 or x.danjia<0 or a.jqDanjia<0)";
  //$query = mysql_query($str) or die(mysql_error());
  while ($re=mysql_fetch_assoc($query)) {
  ?>
  <tr >
    <td><?php echo $re['id'];?></td>
    <td><?php echo $re['wareId']?></td>
    <td><?php echo $re['wareCode']?></td>
    <td><?php echo $re['wareName']?></td>
    <td><?php echo $re['guige']?></td>
    <td><?php echo $re['chukuCode']?></td>
    <td><?php echo $re['chukuDate']?></td>
    <td <?php echo $re['cnt']<0 ? 'style="background-color:#F00"':''?>><?php echo $re['cnt']?></td>
    <td <?php echo $re['danjia']<0 ? 'style="background-color:#F00"':''?>><?php echo $re['danjia']?></td>
    <td <?php echo $re['money']<0 ? 'style="background-color:#F00"':''?>><?php echo $re['money']?></td>
    <td <?php echo $re['jqDanjia']<0 ? 'style="background-color:#F00"':''?>><?php echo $re['jqDanjia']?></td>
    <td><a href="test.php?wareId=<?php echo $re['wareId']?>">单价分析</a> </td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<div style="width:100%; height:550px; overflow:auto; border:1px solid #000">
单价形成分析<a href="index.php?controller=Cangku_ruku&action=ChangeJqDanjia&wareId=<?php echo $_GET['wareId']?>" target="_blank">修改加权单价</a>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td bgcolor="#CCCCCC">日期</td>
    <td bgcolor="#CCCCCC">编码</td>
    <td bgcolor="#CCCCCC">品名规格</td>
    <td bgcolor="#CCCCCC">入库数量</td>
    <td bgcolor="#CCCCCC">单价</td>
    <td bgcolor="#CCCCCC">金额</td>
    <td bgcolor="#CCCCCC">出库数</td>
    <td bgcolor="#CCCCCC">单价</td>
    <td bgcolor="#CCCCCC">金额</td>
    <td bgcolor="#CCCCCC">出库id</td>
    <td bgcolor="#CCCCCC">库存数*单价=库存金额</td>
  </tr>
  <?php
  $wareId=$_GET['wareId'];
  $rowset = array();
  
  //取得入库数
  $sql = "select x.cnt,x.danjia,y.rukuDate 
  from cangku_ruku2ware x left join cangku_ruku y on x.rukuId=y.id where x.wareId='{$wareId}'";
  //echo $sql;
  $query = mysql_query($sql);
  while ($re = mysql_fetch_assoc($query)) {
	  $rowset[] = array(
		'd'=>$re['rukuDate'],
		'rukuInfo'=>"{$re['cnt']}*{$re['danjia']}=".($re['cnt']*$re['danjia']),
		'rukuCnt'=>$re['cnt'],
		'rukuDanjia'=>$re['danjia']
	  );
  }
  //取得出库数
  $sql = "select x.cnt,x.danjia,y.chukuDate,x.id
  from cangku_chuku2ware x left join cangku_chuku y on x.chukuId=y.id where x.wareId='{$wareId}'";
  //echo $sql;
  $query = mysql_query($sql);
  while ($re = mysql_fetch_assoc($query)) {
	  $rowset[] = array(
		'd'=>$re['chukuDate'],
		'chukuInfo'=>"{$re['cnt']}*{$re['danjia']}=".($re['cnt']*$re['danjia']),
		'chukuCnt'=>$re['cnt'],
		'chukuDanjia'=>$re['danjia'],
		'chuku2wareId'=>$re['id']
	  );
  }
  //排序
  //dump($rowset);
  $rowset = array_column_sort($rowset,'d');
 // dump($rowset);
  
  $sql = "select x.* from cangku_kucun x  	
	where x.wareId='{$wareId}'";
  $query = mysql_query($sql);
  $re = mysql_fetch_assoc($query);
  array_unshift($rowset,array(
  	'd'=>'期初',
	'kucunInfo'=>"{$re['initCnt']}*".($re['initMoney']/$re['initCnt'])."={$re['initMoney']}"
  ));
  //dump($rowset);
  $sql = "select * from jichu_ware where id='{$_GET['wareId']}'";
	 // echo $sql;
	  $re = mysql_fetch_assoc(mysql_query($sql));
	  $wareName = $re['wareName'];
	  $guige = $re['guige'];
	  $wareCode = $re['wareCode'];
  foreach($rowset as & $v) {
	  
  ?>
  
  <tr>
    <td><?php echo $v['d']?></td>
    <td><?php echo $wareCode?></td>
    <td><?php echo $wareName.' '.$guige;?></td>
    <td><?php echo $v['rukuCnt'];
	?></td>
    <td><?php echo $v['rukuDanjia'];
	?></td>
    <td><?php echo $v['rukuCnt']*$v['rukuDanjia'];
	?></td>
    <td><?php echo $v['chukuCnt'];
	?></td>
    <td><?php echo $v['chukuDanjia'];
	?></td>
    <td><?php echo $v['chukuDanjia']*$v['chukuCnt'];
	?></td>
    <td>    
	<?php 
	if($v['chuku2wareId']>0) {
	echo $v['chuku2wareId'];
	?>[ <a href="index.php?controller=Cangku_ruku&action=ChangeChukuDanjia&wareId=<?php echo $_GET['wareId']?>&chuku2wareId=<?php echo $v['chuku2wareId']?>" target="_blank">调整</a> ]
    <?php
	}
	?>
    </td>
    <td><?php echo $v['kucunInfo']?></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td>合计</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php 
	echo "数量合计:{$rCnt},金额合计:{$rMoney}";
	?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php 
	echo "数量合计:{$cCnt},金额合计:{$cMoney}";
	?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
</body>
</html>