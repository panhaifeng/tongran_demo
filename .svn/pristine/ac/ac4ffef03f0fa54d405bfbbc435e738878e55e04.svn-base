<?php
class TMIS_Common {	
	/** 
	* 将数字金额转换成中文大写数字 
	* 例子: 231123.402 => 贰拾叁万壹仟壹佰贰拾叁元肆角整 
	* 
	* @author Sandy Lee(leeqintao@gmail.com) 
	* @param float $num 表示金额的浮点数 
	* @return string 返回中文大写的字符串 
	*/ 
	function trans2rmb($num) { 
		$rtn = ''; 
		$num = round($num, 2); 		
		$s = array(); // 存储数字的分解部分 
		//==> 转化为字符串,$s[0]整数部分,$s[1]小数部分 
		$s = explode('.', strval($num)); 		
		// 超过12位(大于千亿)则不予处理 
		if (strlen($s[0]) > 12) { 
			return '*'.$num; 
		} 		
		// 中文大写数字数组 
		$c_num = array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'); 
		
		// 保存处理过程数据的数组 
		$r = array(); 
		
		//==> 处理 分/角 部分 
		if (!empty($s[1])) { 
			$jiao = substr($s[1], 0,1); 
			if (!empty($jiao)) { 
				$r[0] .= $c_num[$jiao].'角'; 
			} else { 
				$r[0] .= '零'; 
			} 			
			$cent = substr($s[1], 1,1); 
			if (!empty($cent)) { 
				$r[0] .=  $c_num[$cent].'分'; 
			} 
		} 
	  
		//==> 数字分为三截,四位一组,从右到左:元/万/亿,大于9位的数字最高位都归为"亿" 
		$f1 = 1; 
		for ($i = strlen($s[0])-1; $i >= 0; $i--, $f1 ++) { 
			$f2 = floor(($f1-1)/4)+1; // 第几截 
			if ($f2 > 3) { 
				$f2 = 3; 
			} 			
			// 当前数字 
			$curr = substr($s[0], $i, 1); 
			
			switch ($f1%4) { 
				case 1: 
					$r[$f2] = (empty($curr) ? '零' : $c_num[$curr]).$r[$f2]; 
					break; 
				case 2: 
					$r[$f2] = (empty($curr) ? '零' : $c_num[$curr].'拾').$r[$f2]; 
					break; 
				case 3: 
					$r[$f2] = (empty($curr) ? '零' : $c_num[$curr].'佰').$r[$f2]; 
					break; 
				case 0: 
					$r[$f2] = (empty($curr) ? '零' : $c_num[$curr].'仟').$r[$f2]; 
					break; 
			} 
		} 
		
		$rtn .= empty($r[3]) ? '' : $r[3].'亿'; 
		$rtn .= empty($r[2]) ? '' : $r[2].'万'; 
		$rtn .= empty($r[1]) ? '' : $r[1].'元'; 
		
		$rtn .= $r[0].'整'; 
		
		
		//==> 规则:如果位数为零,在"元"之前不出现"零",在空位处且不在"元"之间的,则填充一个"零"(num为0的情况除外) 
		if ($num != 0) { 
			while(1) { 
				if (substr_count($rtn, "零零") == 0 && substr_count($rtn, "零元") == 0 
					&& substr_count($rtn, "零万") == 0 && substr_count($rtn, "零亿") == 0) { 
					break; 
				} 
				$rtn = str_replace("零零", "零", $rtn); 
				$rtn = str_replace("零元", "元", $rtn); 
				$rtn = str_replace("零万", "万", $rtn); 
				$rtn = str_replace("零亿", "亿", $rtn); 
			} 
		} 		
		return $rtn; 
	} 

	//去除数据的BOM头
	function removeBOM($content) {
		$charset[1] = substr($content, 0, 1);
		$charset[2] = substr($content, 1, 1);
		$charset[3] = substr($content, 2, 1);
		if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
			$content = substr($content, 3);
		}
		return $content;
	} 

	
	
    function getYear(){
        $year = date('Y');
        for($y = 0 ;$y <= 4 ;$y++){
            $value = $year - $y;
            $arr[] = array('text'=> $value,'value'=>$value);
        }

        return $arr;
    }

    //获取公司编号
    function getCompCode(){
        $certConf = 'Config/config.point.php';
        if(file_exists($certConf)){
            require($certConf);
        }else{
            $code = md5(FLEA::getAppInf('compName').time());
            $data = <<<controller
<?php
    \$compCode = '{$code}';
controller;
            if (safe_file_put_contents($certConf, $data)) {
                require($certConf);
            } else {
               return false;
            }
        }

        return $compCode;
    }
}
?>