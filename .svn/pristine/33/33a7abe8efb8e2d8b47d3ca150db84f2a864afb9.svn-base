<?php
FLEA::loadFile('FLEA_Helper_Array.php');
FLEA::loadClass('FLEA_Db_TableDataGateway');
class TMIS_TableDataGateway extends FLEA_Db_TableDataGateway {
	/**
	*最能表达某个记录意义的字段名,比如用户表中的用户姓名字段，客户表中的客户姓名字段等。
	*当select控件中显示时有用。
	*/
	var $primaryName;

	function findCountBySql($querystring) {
		#有limit或者有union的直接执行mysql_num_rows(mysql_query($sqlstr));
		#如果是简单的browsing，用count(*),能大大加快速度
		#其他的用select  SQL_CALC_FOUND_ROWS .....
		$querystring=preg_replace("/[\n\r	]/"," ",trim($querystring));
		$sqlstr=strtolower($querystring);

		$pos_select=strpos($sqlstr,"select ");
		$pos_limit=strpos($sqlstr," limit ");
		$pos_union=strpos($sqlstr," union ");
		$str="explain ".$sqlstr;
		$query=mysql_query($str);
		$cnt_table=mysql_num_rows($query);
		$re=mysql_fetch_array($query);

		if ($cnt_table==1&&$re['Extra']=="") {
			#第一个select位置,第一个 from 位置之间插入count(*) cnt, return $re[cnt];
			$FPos = strpos($sqlstr," from");
			$str=substr_replace($querystring,"select count(*) rows",0,$FPos);
			//echo $str;
			$re=mysql_fetch_array(mysql_query($str));
			return $re['rows'];
		}
		if ($pos_limit!==false||$pos_union!==false) {
			return mysql_num_rows(mysql_query($querystring));
		}
		if ($pos!==false) {
			$str=substr_replace($sqlstr," SQL_CALC_FOUND_ROWS",$pos+6,0). " limit 1";
			mysql_query($str);
			$re=mysql_fetch_array(mysql_query("SELECT FOUND_ROWS() as count"));
			return $re[count];
		}
	}

	//生成option的html代码
	function createOptions($selected='') {
		$arr = $this->findAll();

		if(count($arr)>0) foreach($arr as $v) {
			$r .= "<option value='{$v[$this->primaryKey]}'";
			if($selected==$v[$this->primaryKey]) {
				$r .= " selected";
			}
			$r .= ">{$v[$this->primaryName]}</option>";
		}
		//dump($r);exit;
		return $r;
	}

	//改变库存的函数,出入库明细每次改动都触发。
	function changeKucun(&$row) {
		if(!is_array($row)) $row = array('wareId'=>$row);
		if($row['wareId']==0) return false;
		$sql = "select sum(cnt) cnt,sum(cnt*danjia) as money from cangku_ruku2ware where wareId='{$row['wareId']}' group by wareId";
		//echo $sql;
		$re = mysql_fetch_assoc(mysql_query($sql));

		$sql = "select sum(cnt) cnt,sum(cnt*danjia) as money from cangku_chuku2ware where wareId='{$row['wareId']}' group by wareId";
		$re1 = mysql_fetch_assoc(mysql_query($sql));

		//dump($re);dump($re1);exit;
		$sql = "select id,initCnt,initMoney from cangku_kucun where wareId='{$row['wareId']}'";
		$re2 = mysql_fetch_assoc(mysql_query($sql));

		$cntKucun = $re2['initCnt'] + $re['cnt'] - $re1['cnt'];
		$moneyKucun = $re2['initMoney'] + $re['money'] - $re1['money'];

		$m = & FLEA::getSingleton("Model_Cangku_Kucun");
		//if($cntKucun==0 && $re2['id']>0) {
			//$m->removeByPkv($re2['id']);
		//} else {
			$arr = array('id'=>$re2['id'],'wareId'=>$row['wareId'],'cnt'=>$cntKucun,'money'=>$moneyKucun);
			$id=$m->save($arr);
		//}
	}
}
?>