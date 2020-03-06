<?php
/**
 * 注释参考Supplier.php
 */
FLEA::loadClass('TMIS_Controller');
class Controller_CangKu_Report_Month extends Tmis_Controller {
	var $_modelExample;
	var $funcId=106;
	function Controller_CangKu_Report_Month() {
		$this->_modelExample = & FLEA::getSingleton('Model_CangKu_Report_Month');
		$this->_modelWare =  & FLEA::getSingleton('Model_JiChu_Ware');
		$this->_modelClient =  & FLEA::getSingleton('Model_JiChu_Client');

	}
	//坯纱仓库库存报表
	function actionRight1(){
		//$this->authCheck($this->funcId); 已被选入公共查询区, 所以要去掉权限

		//必须选客户
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId=>''
		));
		//客户的列出表
		$cRow = $this->_modelClient->findAll();
		//dump($cRow);
		if (count($cRow)>0) foreach($cRow as $v) {
			//dump($v);
			$cHtml .= " | <a href='".$this->_url('right1',array(
				dateFrom =>$arrGet[dateFrom],
				dateTo => $arrGet[dateTo],
				clientId=>$v[id]
			))."'>$v[compName]</a>";
		}

		if ($arrGet[clientId]!='') {
			$clientId = $arrGet[clientId];
			//得到坯纱规格id的范围
			$topNode = $this->_modelWare->getTopNodeOfPisha();
			$leftId = $topNode[leftId];
			$rightId = $topNode[rightId];
			$nodeCondition = "leftId>'$leftId' and rightId<'$rightId' and leftId+1=rightId";
			$arrNode = $this->_modelWare->findAll($nodeCondition);
			//dump($arrNode); exit;

			////对每一个坯纱的品种进行搜索,如果3个项目都空，则不显示。
			$dateFrom = $arrGet[dateFrom];
			$dateTo = $arrGet[dateTo];
			$newArr = array();
			foreach($arrNode as $v) {
				$wareId = $v['id'];
				$ware = $this->_modelWare->find("id=".$wareId);
				$tempArr=array();
				$tempArr[wareId]		= $wareId;
				$tempArr[shazhi]		= $ware[wareName] . " " . $ware[guige];
				$tempArr[cntInit]		= $this->_modelExample->getInitInfo($clientId,$wareId,$dateFrom,0);
				$tempArr[cntRuku]		= $this->_modelExample->getRukuInfo($clientId,$wareId,$dateFrom,$dateTo,0);
				$tempArr[cntChuku]		= $this->_modelExample->getChukuInfo($clientId,$wareId,$dateFrom,$dateTo,0);
				
				$tempArr[cntTuiku]		= $this->_modelExample->getTuikuInfo($clientId,$wareId,$dateFrom,$dateTo,0);
				$tempArr[cntRemain]		= $tempArr[cntInit]+$tempArr[cntRuku]+$tempArr[cntTuiku]-$tempArr[cntChuku];
				if (empty($tempArr[cntInit])&&empty($tempArr[cntRuku])&&empty($tempArr[cntChuku])&&empty($tempArr[cntTuiku])) continue;
				$tempArr[cntChukuCp]= $this->getChukuInfoCp($clientId,$wareId,$dateFrom,$dateTo);
				$tempArr[KehuCnt] = round($tempArr[cntInit]+$tempArr[cntRuku]-$tempArr[cntChukuCp]-abs($tempArr[cntTuiku]),3);

				$initCntTotal += $tempArr[cntInit];
				$rukuCntTotal += $tempArr[cntRuku];
				$chukuCntTotal += $tempArr[cntChuku];
				$chukuCntTotalCp += $tempArr[cntChukuCp];
				$tuikuCntTotal += abs($tempArr[cntTuiku]);

				if ($tempArr[cntRuku]>=0) $tempArr[cntRuku] = "<a href='?controller=CangKu_RuKu&action=right1&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1' class='thickbox'>$tempArr[cntRuku]</a>";
				if ($tempArr[cntChuku]>0) $tempArr[cntChuku] = "<a href='?controller=CangKu_ChuKu&action=right2&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1' class='thickbox'>$tempArr[cntChuku]</a>";
				if ($tempArr[cntTuiku]) $tempArr[cntTuiku] = "<a href='?controller=CangKu_Tuiku&action=right&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1' target='_blank'>".abs($tempArr[cntTuiku])."</a>";
				if ($tempArr[cntChukuCp]>0) $tempArr[cntChukuCp] = "<a href='?controller=chengpin_dye_cpck&action=RightMx2&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1&width=800' class='thickbox' >$tempArr[cntChukuCp]</a>";
				$tempArr['cntRemain']="<a href='".$this->_url('Detail',array('clientId'=>$clientId,'wareId'=>$wareId,'dateFrom'=>$dateFrom,'dateTo'=>$dateTo,'rukuTag'=>1,'TB_iframe'=>1))."' class='thickbox'>".$tempArr['cntRemain']."</a>";
				$newArr[] = $tempArr;
			}
			//exit();
			$initTotal=0;$rukuTotal=0;$chukuTotal=0;
			$initMoneyTotal=0;$rukuMoneyTotal=0;$chukuMoneyTotal=0;

			//加入合计
			$i = count($newArr);
			$newArr[$i][shazhi] = '<b>合计</b>';
			$newArr[$i][cntInit]  = '<b>'.$initCntTotal.'</b>';
			$newArr[$i][cntRuku]  = '<b>'.$rukuCntTotal.'</b>';
			$newArr[$i][cntChuku] = '<b>'.$chukuCntTotal.'</b>';
			$newArr[$i][cntChukuCp] = '<b>'.$chukuCntTotalCp.'</b>';
			$newArr[$i][cntTuiku] = '<b>'.$tuikuCntTotal.'</b>';
			$newArr[$i][cntRemain] = '<b>'.($initCntTotal+$rukuCntTotal-$tuikuCntTotal-$chukuCntTotal).'</b>';
			$newArr[$i][KehuCnt] = '<b>'.($initCntTotal+$rukuCntTotal-$chukuCntTotalCp-$tuikuCntTotal).'<b>';
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		//by zcc 客户库存数=上月余存+入库-成品出库
		$arr_field_info = array(
			"shazhi" => "纱支规格",
			"cntInit"=>"上月余存",
			"cntRuku" =>"入库(点击查看明细)",
			"cntChuku" =>"领料出库(点击查看明细)",
			"cntChukuCp" =>"成品出库(点击查看明细)",
			"cntTuiku" =>"退库",
			"cntRemain" => "实际库存数",
			"KehuCnt" => "客户库存数"
		);
		$smarty->assign('title','坯纱仓库库存报表');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$newArr);
		$smarty->assign('add_display', 'none');
		$smarty->assign('url_daochu', $this->_url('export2excel',$arrGet));
		$smarty->assign('arr_condition', $arrGet);
        // $smarty->assign('other_script','<script language="javascript" src="Resource/Script/thickbox/thickbox.js"></script>');
		//$smarty->assign('other_search_item',$cHtml);
		//$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arrGet)));
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps ：坯纱收发存中新增的成品出库信息
	 * Time：2017/03/06 17:35:02
	 * @author zcc
	*/
	function getChukuInfoCp($clientId,$wareId,$dateFrom,$dateTo) {
		//dump($wareId);exit();
		$str = "SELECT sum(x.cntChuku) as cnt 
			from chengpin_dye_cpck x
			inner join view_dye_gang y on x.planId=y.gangId
			where y.clientId='$clientId' and y.wareId='$wareId'
			and x.dateCpck>='$dateFrom' and x.dateCpck<='$dateTo'
			";
		//if($wareId==19) echo $str;
		//echo $str;exit;
		/*$re=mysql_fetch_array(mysql_query($str));
		return $re[cnt];*/
		//dump($str);exit();
		$result = mysql_query($str);
		if ($result){
			$re = mysql_fetch_array($result);
			$return = $re['cnt'];
		} else {
			$return = 0;
		}
		return $return;
	}
	function actionExport2excel() {
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId=>''
		));
		//客户的列出表
		$cRow = $this->_modelClient->findAll();
		//dump($cRow);
		if (count($cRow)>0) foreach($cRow as $v) {
			//dump($v);
			$cHtml .= " | <a href='".$this->_url('right1',array(
				dateFrom =>$arrGet[dateFrom],
				dateTo => $arrGet[dateTo],
				clientId=>$v[id]
			))."'>$v[compName]</a>";
		}

		if ($arrGet[clientId]!='') {
			$clientId = $arrGet[clientId];
			//得到坯纱规格id的范围
			$topNode = $this->_modelWare->getTopNodeOfPisha();
			$leftId = $topNode[leftId];
			$rightId = $topNode[rightId];
			$nodeCondition = "leftId>'$leftId' and rightId<'$rightId' and leftId+1=rightId";
			$arrNode = $this->_modelWare->findAll($nodeCondition);
			//dump($arrNode); exit;

			////对每一个坯纱的品种进行搜索,如果3个项目都空，则不显示。
			$dateFrom = $arrGet[dateFrom];
			$dateTo = $arrGet[dateTo];
			$newArr = array();
			foreach($arrNode as $v) {
				//dump($v);
				$wareId = $v['id'];
				$ware = $this->_modelWare->find("id=".$wareId);
				$tempArr=array();
				$tempArr[wareId]		= $wareId;
				$tempArr[shazhi]		= $ware[wareName] . " " . $ware[guige];
				$tempArr[cntInit]		= $this->_modelExample->getInitInfo($clientId,$wareId,$dateFrom);
				$tempArr[cntRuku]		= $this->_modelExample->getRukuInfo($clientId,$wareId,$dateFrom,$dateTo);
				$tempArr[cntChuku]		= $this->_modelExample->getChukuInfo($clientId,$wareId,$dateFrom,$dateTo);
				$tempArr[cntTuiku]		= $this->_modelExample->getTuikuInfo($clientId,$wareId,$dateFrom,$dateTo);
				$tempArr[cntRemain]		= $tempArr[cntInit]+$tempArr[cntRuku]+$tempArr[cntTuiku]-$tempArr[cntChuku];
				if (empty($tempArr[cntInit])&&empty($tempArr[cntRuku])&&empty($tempArr[cntChuku])&&empty($tempArr[cntTuiku])) continue;
				$initCntTotal += $tempArr[cntInit];
				$rukuCntTotal += $tempArr[cntRuku];
				$chukuCntTotal += $tempArr[cntChuku];
				$tuikuCntTotal += abs($tempArr[cntTuiku]);

				if ($tempArr[cntRuku]>0) $tempArr[cntRuku] = "<a href='?controller=CangKu_RuKu&action=right1&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1' class='thickbox'>$tempArr[cntRuku]</a>";
				if ($tempArr[cntChuku]>0) $tempArr[cntChuku] = "<a href='?controller=CangKu_ChuKu&action=right2&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1' class='thickbox'>$tempArr[cntChuku]</a>";
				if ($tempArr[cntTuiku]) $tempArr[cntTuiku] = "<a href='?controller=CangKu_Tuiku&action=right&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1' target='_blank'>".abs($tempArr[cntTuiku])."</a>";
				$tempArr['cntRemain']="<a href='".$this->_url('Detail',array('clientId'=>$clientId,'wareId'=>$wareId,'dateFrom'=>$dateFrom,'dateTo'=>$dateTo,'rukuTag'=>1,'TB_iframe'=>1))."' class='thickbox'>".$tempArr['cntRemain']."</a>";
				$newArr[] = $tempArr;
			}
			$initTotal=0;$rukuTotal=0;$chukuTotal=0;
			$initMoneyTotal=0;$rukuMoneyTotal=0;$chukuMoneyTotal=0;

			//加入合计
			$i = count($newArr);
			$newArr[$i][shazhi] = '<b>合计</b>';
			$newArr[$i][cntInit]  = '<b>'.$initCntTotal.'</b>';
			$newArr[$i][cntRuku]  = '<b>'.$rukuCntTotal.'</b>';
			$newArr[$i][cntChuku] = '<b>'.$chukuCntTotal.'</b>';
			$newArr[$i][cntTuiku] = '<b>'.$tuikuCntTotal.'</b>';
			$newArr[$i][cntRemain] = '<b>'.($initCntTotal+$rukuCntTotal-$tuikuCntTotal-$chukuCntTotal).'</b>';
		}
		//dump($newArr);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"shazhi" => "纱支规格",
			"cntInit"=>"上月余存",
			"cntRuku" =>"入库(点击查看明细)",
			"cntChuku" =>"出库(点击查看明细)",
			"cntTuiku" =>"退库",
			"cntRemain" => "库存数"
		);


		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		//header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", '内销收款查询').".xls");
		header("Content-Disposition: attachment;filename=坯纱仓库库存报表.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty->assign('title','坯纱仓库库存报表');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$newArr);
		//$smarty->assign('add_display', 'none');
		//$smarty->assign('arr_condition', $arrGet);
        // $smarty->assign('other_script','<script language="javascript" src="Resource/Script/thickbox/thickbox.js"></script>');
		$smarty->display('Export2Excel.tpl');
	}
	#库存明细
	function actionDetail(){
		//dump($_GET);exit;
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			pihao=>''
		));
		#取得入库信息
        $str="select sum(x.cnt) as cntRuku,x.supplierId,x.chandi,x.wareId,y.pihao
			from view_cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.id
			where x.supplierId='{$_GET['clientId']}'
			and x.wareId='{$_GET['wareId']}'			
		";
		if($arrGet[pihao]!=''){
			$str .= " and y.pihao like '%{$arrGet[pihao]}%'";
		}
		$str .=" group by y.pihao,x.chandi";
		//dump($str);die;
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			$row[]=$re;
		}
		#取得出库信息
		$str="select sum(x.cnt) as cntChuku,x.supplierId,x.chandi,x.wareId,y.pihao
			from view_cangku_chuku x 
			left join cangku_chuku2ware y on x.id = y.id
			where x.supplierId='{$_GET['clientId']}'
			and x.wareId='{$_GET['wareId']}'		
		";
		if($arrGet[pihao]!=''){
			$str.=" and y.pihao like '%{$arrGet[pihao]}%'";
		}
		$str .=" group by y.pihao,y.chandi";
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			$row[]=$re;
		}
		// dump($row);exit();
		if(count($row)>0)foreach($row as & $v){
			$arrWare=$this->_modelWare->find(array('id'=>$v['wareId']));
			$arrClient=$this->_modelClient->find(array('id'=>$v['supplierId']));
			$v['compName']=$arrClient['compName'];
			$v['wareName']=$arrWare['wareName'].' '.$arrWare['guige'];
			$v['cntKucun']=$v['cntRuku']-$v['cntChuku'];
		}

		$row=array_group_by($row,'pihao');
		if(count($row)>0)foreach($row as $key=>& $v){
			$heji=$this->getHeji($v,array('cntKucun'));
			$mm=array(
				'compName'=>$v[0]['compName'],
				'wareName'=>$v[0]['wareName'],
				'pihao'=>$key,
				'chandi'=>$v[0]['chandi'],
				'cntKucun'=>$heji['cntKucun'],
			);
			$rowset[]=$mm;
		}
		// dump($rowset);die();
		$zj=$this->getHeji($rowset,array('cntKucun'),'compName');
		$rowset[]=$zj;
		$arrFieldInfo = array(
            'compName' =>'客户',
            'wareName' =>'规格',
            'pihao' =>'批号',
            'chandi'=>'产地',
			'cntKucun'=>'库存数'
        );
        $smarty = & $this->_getView();
        $smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('nav_display','none');
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_condition',$arrGet);
        $smarty->assign('page_info',"<a href='".$this->_url('DetailExport',array('clientId'=>$_GET['clientId'],'wareId'=>$_GET['wareId']))."'style='font-size:16px'>导出</a>");
        $smarty->display('TableList.tpl');
	}
	//库存明细导出
	function actionDetailExport(){
		//dump($_GET);exit();
		FLEA::loadClass('TMIS_Pager');
		#取得入库信息
        $str="select sum(cnt) as cntRuku,supplierId,chandi,wareId 
			from view_cangku_ruku
			where supplierId='{$_GET['clientId']}'
			and wareId='{$_GET['wareId']}'
			group by chandi
		";
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			$row[]=$re;
		}
		#取得出库信息
		$str="select sum(cnt) as cntChuku,supplierId,chandi,wareId 
			from view_cangku_chuku
			where supplierId='{$_GET['clientId']}'
			and wareId='{$_GET['wareId']}'
			group by chandi
		";
		$query=mysql_query($str);
		while($re=mysql_fetch_assoc($query)){
			$row[]=$re;
		}
		//dump($row);
		if(count($row)>0)foreach($row as & $v){
			$arrWare=$this->_modelWare->find(array('id'=>$v['wareId']));
			$arrClient=$this->_modelClient->find(array('id'=>$v['supplierId']));
			$v['compName']=$arrClient['compName'];
			$v['wareName']=$arrWare['wareName'].' '.$arrWare['guige'];
			$v['cntKucun']=$v['cntRuku']-$v['cntChuku'];
		}
		$row=array_group_by($row,'chandi');
		//dump($row);
		if(count($row)>0)foreach($row as $key=>& $v){
			$heji=$this->getHeji($v,array('cntKucun'));
			$mm=array(
				'compName'=>$v[0]['compName'],
				'wareName'=>$v[0]['wareName'],
				'chandi'=>$key,
				'cntKucun'=>$heji['cntKucun'],
			);
			$rowset[]=$mm;
		}
		$zj=$this->getHeji($rowset,array('cntKucun'),'compName');
		$rowset[]=$zj;
		$arrFieldInfo = array(
            'compName' =>'客户',
            'wareName' =>'规格',
            'chandi'=>'产地',
			'cntKucun'=>'库存数'
        );
        $smarty = & $this->_getView();
       	header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		//header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", '内销收款查询').".xls");
		header("Content-Disposition: attachment;filename=坯纱仓库库存明细.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty->assign('title','坯纱仓库库存明细');
		$smarty->assign('arr_field_info',$arrFieldInfo);
        $smarty->assign('arr_field_value',$rowset);
		$smarty->display('Export2Excel.tpl');
	}
	//坯纱加工库存报表
	function actionReportDay(){
		//必须选客户
		FLEA::loadClass('TMIS_Pager');
		$m= & FLEA::getSingleton('Model_CangKu_Report_Month');
		$mruku= & FLEA::getSingleton('Model_CangKu_ViewRuku');
		$dateFrom = $m->dateFrom;
		//$mchuku= & FLEA::getSingleton('Model_CangKu_ViewChuku');
		//客户的列出表
		$newArr = array();
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d"),
			'dateTo' => date("Y-m-d"),
			'week'=>''
			//clientId=>''
		));
		if($_POST['week']!=0)
		{
			$arrGet['dateFrom']=date('Y-m-d',strtotime('-'.$_POST['week'].' day'));
			$arrGet['dateTo']=date('Y-m-d');
		}
		$arr = & $arrGet;
		//dump($arrGet);
		$ret = array();
		//取得本日入库
		//$dateFrom='2008-01-01';
		$sql = "SELECT sum(cnt) as cnt,supplierId,wareId FROM view_cangku_ruku
			where rukuDate>='{$arr['dateFrom']}' and rukuDate<='{$arr['dateTo']}' and kind = 0 group by supplierId,wareId";
		$rowset = $mruku->findBysql($sql);
		if($rowset) foreach($rowset as & $v) {
			$key = $v['supplierId'].','.$v['wareId'];
			$ret[$key]['cntRuku'] = $v['cnt'];
		}

		//取得本日出库
		$sql = "SELECT sum(cnt) as cnt,supplierId,wareId FROM view_cangku_chuku
		where chukuDate>='{$arr['dateFrom']}' and  chukuDate<='{$arr['dateTo']}' and kind = 0 group by supplierId,wareId";
		$rowset = $mruku->findBysql($sql);
		if($rowset) foreach($rowset as & $v) {
			$key = $v['supplierId'].','.$v['wareId'];
			$ret[$key]['cntChuku'] = $v['cnt'];
		}

		//取得起初 总入
		$sql = "SELECT sum(cnt) as cnt,supplierId,wareId 
			FROM view_cangku_ruku
			where rukuDate<'{$arr['dateFrom']}' and kind = 0 
			group by supplierId,wareId";
		$rowset = $mruku->findBysql($sql);
		if($rowset) foreach($rowset as & $v) {
			$key = $v['supplierId'].','.$v['wareId'];
			$ret[$key]['cntInitRuku'] = $v['cnt'];
		}

		//取得起初 总出
		$sql = "SELECT sum(cnt) as cnt,supplierId,wareId 
		FROM view_cangku_chuku
		where chukuDate<'{$arr['dateFrom']}' and kind = 0
		group by supplierId,wareId";
		$rowset = $mruku->findBysql($sql);
		if($rowset) foreach($rowset as & $v) {
			$key = $v['supplierId'].','.$v['wareId'];
			$ret[$key]['cntInitChuku'] = $v['cnt'];
		}

		//计算起初,还原客户和规格
		$mClient = & FLEA::getSingleton('Model_Jichu_Client');
		$mWare = & FLEA::getSingleton('Model_Jichu_Ware');
		if($ret) foreach($ret as $key =>& $v) {
			$v['cntInit'] = $v['cntInitRuku'] - $v['cntInitChuku'];
			$temp = explode(',',$key);
			$v['Client'] = $mClient->find(array('id'=>$temp[0]));
			$v['Ware'] = $mWare->find(array('id'=>$temp[1]));
			$v['guige'] = $v['Ware']['wareName']. ' ' .$v['Ware']['guige'];
			$v['cntRemain'] = $v['cntInit']+$v['cntRuku'] - $v['cntChuku'];
		}
		$ret[] = $this->getHeji($ret,array('cntInit','cntRuku','cntChuku','cntRemain'),'Client.compName');
		//dump($ret);
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			"Client.compName"=>"客户",
			"guige" => "纱支规格",
			"cntInit"=>"上日余存",
			"cntRuku" =>"本日入库",
			"cntChuku" =>"本日出库",
			//"cntTuiku" =>"本日退库",
			"cntRemain" => "本日结余"
		);
		$smarty->assign('title','坯纱日报表');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$ret);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		//$smarty->assign('other_search_item',$cHtml);
		//$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arrGet)));
		$smarty->display('TableList.tpl');
	}

	//库存作为入库数据插入，并删除部分数据
	function actionUp(){
		//$this->authCheck($this->funcId); 已被选入公共查询区, 所以要去掉权限
		$dateKucun = '2011-02-25';
		$from = $_GET['from']+0;
		$dateFrom = $dateKucun;
		$dateTo = $dateKucun;
		$cRow = $this->_modelClient->findAll(null,null,array(1,$from));
		//dump($cRow[0]);exit;
		$mRuku = & FLEA::getSingleton("Model_CangKu_RuKu");
		//dump($cRow);exit;
		//得到坯纱规格id的范围
		$arr = explode('-',$dateKucun);
		$ymd = date('Y-m-d',mktime(0,0,0,$arr[1],$arr[2]+1,$arr[0]));
		$topNode = $this->_modelWare->getTopNodeOfPisha();
		$leftId = $topNode[leftId];
		$rightId = $topNode[rightId];
		$nodeCondition = "leftId>'$leftId' and rightId<'$rightId' and leftId+1=rightId";
		$arrNode = $this->_modelWare->findAll($nodeCondition);
		foreach($cRow as $c) {
			$clientId = $c['id'];
			////对每一个坯纱的品种进行搜索,如果3个项目都空，则不显示。
			foreach($arrNode as $v) {
				$wareId = $v['id'];
				$ware = $this->_modelWare->find(array('id'=>$wareId));
				$tempArr=array();
				$tempArr[wareId]		= $wareId;
				$tempArr[shazhi]		= $ware[wareName] . " " . $ware[guige];
				$tempArr[cntInit]		= $this->_modelExample->getInitInfo($clientId,$wareId,$dateFrom);
				$tempArr[cntRuku]		= $this->_modelExample->getRukuInfo($clientId,$wareId,$dateFrom,$dateTo);
				$tempArr[cntChuku]		= $this->_modelExample->getChukuInfo($clientId,$wareId,$dateFrom,$dateTo);
				$tempArr[cntTuiku]		= $this->_modelExample->getTuikuInfo($clientId,$wareId,$dateFrom,$dateTo);
				$tempArr[cntRemain]		= $tempArr[cntInit]+$tempArr[cntRuku]+$tempArr[cntTuiku]-$tempArr[cntChuku];
				if (empty($tempArr[cntInit])&&empty($tempArr[cntRuku])&&empty($tempArr[cntChuku])&&empty($tempArr[cntTuiku])) continue;

				//插入temp_cangku表
				//$str = "insert into temp_cangku(clientId,wareId,cnt) values('{$clientId}','{$wareId}','{$tempArr[cntRemain]}')";
				//mysql_query($str) or die(__LINE__.mysql_error());

				//作为入库数据插入		//id  ruKuNum  ruKuDate  supplierId  memo  tag  isTuiku 1表示退库
				//purchase2wareId  ruKuId  wareId  chandi 产地 danJia  cnt  cntJian 件数 invoiceId 凭证号码
				$row = array(
					'ruKuNum'=>$mRuku->getNewRukuNum(),
					'ruKuDate'=>$ymd,
					'supplierId'=>$clientId,
					'memo'=>'库存转换',
					'tag'=>0,
					'Wares'=>array(
						array(
							'wareId'=>$wareId,
							'cnt'=>$tempArr['cntRemain']
						)
					)
				);
				$mRuku->save($row);
				//dump($row);exit;
			}
		}
		echo "正在提取 {$cRow[0]['compName']} 的库存，请稍后....";
		if($cRow) echo '<meta http-equiv="Refresh" content="3;url='.$this->_url('up',array('from'=>$_GET['from']+1)).'">';
		else echo '库存提取完毕!<br>3秒后将删除 '.$ymd.' 前的所有入库及出库数据！<meta http-equiv="Refresh" content="3;url='.$this->_url('up1',array('dateKucun'=>$dateKucun)).'">';
	}

	//删除出入库数据
	function actionUp1(){
		//$arr = explode('-',$_GET['dateKucun']);
		//$ymd = date('Y-m-d',mktime(0,0,0,$arr[1],$arr[2]+1,$arr[0]));
		set_time_limit(0);
		$mRuku = & FLEA::getSingleton("Model_CangKu_RuKu");
		$condition = array(
			array('ruKuDate',$_GET['dateKucun'],'<=')
		);
		$mRuku->removeByConditions($condition);

		$mChuku = & FLEA::getSingleton("Model_CangKu_ChuKu");
		$condition = array(
			array('chuKuDate',$_GET['dateKucun'],'<=')
		);
		$mChuku->removeByConditions($condition);
		echo '坯纱数据处理完毕！<br>3秒后将删除 订单及生产 数据！<meta http-equiv="Refresh" content="3;url='.$this->_url('up2',array('dateKucun'=>$_GET['dateKucun'])).'">';
	}

	#删除订单及生产数据，工艺数据
	function actionUp2(){
		set_time_limit(0);
		$ymd = $_GET['dateKucun'];
		$from = $_GET['from']+0;
		$mOrder = & FLEA::getSingleton("Model_Trade_Dye_Order");
		//$condition= array(array('Order.dateOrder',$ymd,'<'));
		//$ord2ware = $m->findAll($condition);

		//删除工艺数据
		$mGongyi = & FLEA::getSingleton("Model_Gongyi_Dye_Chufang");
		$arrTbl = array(
			'dye_db_chanliang',
			'dye_hd_chanliang',
			'dye_hs_chanliang',
			'dye_rs_chanliang',
			'dye_st_chanliang',
			'dye_zcl_chanliang'
		);

		$sql = "select order2wareId,orderId,gangId from view_dye_all where dateOrder<='$ymd' limit 0,500";
		//echo $sql;
		$query = mysql_query($sql) or die(__LINE__.mysql_error());
		$end = false;
		if(mysql_num_rows($query)<500) $end=true;
		while ($v = mysql_fetch_assoc($query)) {
			$con = array('order2wareId'=>$v['order2wareId']);
			$mGongyi->removeByConditions($con);

			//删除缸和生产数据
			foreach($arrTbl as $tbl) {
				if($v['gangId']) {
					$sql = "delete from $tbl where gangId = {$v['gangId']}";
					mysql_query($sql) or die(__LINE__.mysql_error());
				}
			}
			//删除缸数据
			if($v['gangId']) {
				$sql = "delete from plan_dye_gang where id = {$v['gangId']}";
				//echo $sql;exit;
				mysql_query($sql) or die(__LINE__.mysql_error());
			}

			//删除订单数据
			if($v['order2wareId']>0) {
				$sql = "delete from trade_dye_order2ware where id = {$v['order2wareId']}";
				mysql_query($sql) or die(__LINE__.mysql_error()."<br>".$sql);
			}
			$sql = "delete from trade_dye_order where id = {$v['orderId']}";
			mysql_query($sql) or die(__LINE__.mysql_error());
		}
		if(!$end) {
			echo "正在处理 $from 到 ".($from+500)."条记录,请稍候";
			echo '<meta http-equiv="Refresh" content="3;url='.$this->_url('up2',array('dateKucun'=>$ymd,'from'=>$_GET['from']+500)).'">';
			exit;
		}
		//echo '订单及生产数据处理完毕！<br>3秒后将删除 财务 数据！<meta http-equiv="Refresh" content="3;url='.$this->_url('up3').'">';
		echo "订单数据处理完毕!";
	}

	#删除财务数据，工艺数据
	function actionUp3(){
		$ymd = '2010-01-01';
	}
	/**
	 * ps ：本厂坯纱日报表
	 * Time：2017/09/01 14:50:05
	 * @author zcc
	*/
	function actionReportDayBc(){
		//必须选客户
		FLEA::loadClass('TMIS_Pager');
		$m= & FLEA::getSingleton('Model_CangKu_Report_Month');
		$mruku= & FLEA::getSingleton('Model_CangKu_ViewRuku');
		$dateFrom = $m->dateFrom;
		//$mchuku= & FLEA::getSingleton('Model_CangKu_ViewChuku');
		//客户的列出表
		$newArr = array();
		$arrGet = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d"),
			'dateTo' => date("Y-m-d"),
			'week'=>''
			//clientId=>''
		));
		if($_POST['week']!=0)
		{
			$arrGet['dateFrom']=date('Y-m-d',strtotime('-'.$_POST['week'].' day'));
			$arrGet['dateTo']=date('Y-m-d');
		}
		$arr = & $arrGet;
		//dump($arrGet);
		$ret = array();
		//取得本日入库
		//$dateFrom='2008-01-01';
		$sql = "SELECT sum(y.cnt) as cnt, y.wareId
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId
			where x.rukuDate>='{$arr['dateFrom']}' and x.rukuDate<='{$arr['dateTo']}' and x.kind = 1 group by wareId ";
		$rowset = $mruku->findBysql($sql);
		if($rowset) foreach($rowset as & $v) {
			$key = $v['wareId'];
			$ret[$key]['cntRuku'] = $v['cnt'];
		}	
		// $sql = "SELECT sum(cnt) as cnt,supplierId,wareId FROM view_cangku_ruku
		// 	where rukuDate>='{$arr['dateFrom']}' and rukuDate<='{$arr['dateTo']}' group by supplierId,wareId";
		// $rowset = $mruku->findBysql($sql);
		// if($rowset) foreach($rowset as & $v) {
		// 	$key = $v['supplierId'].','.$v['wareId'];
		// 	$ret[$key]['cntRuku'] = $v['cnt'];
		// }

		//取得本日出库
		$sql = "SELECT sum(y.cnt) as cnt, y.wareId
			FROM cangku_chuku x 
			left join cangku_chuku2ware y on x.id = y.chuKuId
			where x.chukuDate>='{$arr['dateFrom']}' and x.chukuDate<='{$arr['dateTo']}' and y.kind = 1 group by wareId ";
		$rowset = $mruku->findBysql($sql);
		if($rowset) foreach($rowset as & $v) {
			$key = $v['wareId'];
			$ret[$key]['cntChuku'] = $v['cnt'];
		}	

		// $sql = "SELECT sum(cnt) as cnt,supplierId,wareId FROM view_cangku_chuku
		// where chukuDate>='{$arr['dateFrom']}' and  chukuDate<='{$arr['dateTo']}' group by supplierId,wareId";
		// $rowset = $mruku->findBysql($sql);
		// if($rowset) foreach($rowset as & $v) {
		// 	$key = $v['supplierId'].','.$v['wareId'];
		// 	$ret[$key]['cntChuku'] = $v['cnt'];
		// }

		//取得起初 总入
		$sql = "SELECT sum(y.cnt) as cnt, y.wareId
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId
			where x.rukuDate<'{$arr['dateFrom']}'  and x.kind = 1 group by wareId ";
		$rowset = $mruku->findBysql($sql);
		if($rowset) foreach($rowset as & $v) {
			$key = $v['wareId'];
			$ret[$key]['cntInitRuku'] = $v['cnt'];
		}	
		// $sql = "SELECT sum(cnt) as cnt,supplierId,wareId FROM view_cangku_ruku
		// 	where rukuDate<'{$arr['dateFrom']}'  group by supplierId,wareId";
		// $rowset = $mruku->findBysql($sql);
		// if($rowset) foreach($rowset as & $v) {
		// 	$key = $v['supplierId'].','.$v['wareId'];
		// 	$ret[$key]['cntInitRuku'] = $v['cnt'];
		// }

		//取得起初 总出
		$sql = "SELECT sum(y.cnt) as cnt, y.wareId
			FROM cangku_chuku x 
			left join cangku_chuku2ware y on x.id = y.chuKuId
			where x.chukuDate<'{$arr['dateFrom']}' and y.kind = 1 group by wareId ";
		$rowset = $mruku->findBysql($sql);
		if($rowset) foreach($rowset as & $v) {
			$key = $v['wareId'];
			$ret[$key]['cntInitChuku'] = $v['cnt'];
		}	
		// $sql = "SELECT sum(cnt) as cnt,supplierId,wareId FROM view_cangku_chuku
		// where chukuDate<'{$arr['dateFrom']}'  group by supplierId,wareId";
		// $rowset = $mruku->findBysql($sql);
		// if($rowset) foreach($rowset as & $v) {
		// 	$key = $v['supplierId'].','.$v['wareId'];
		// 	$ret[$key]['cntInitChuku'] = $v['cnt'];
		// }

		//计算起初,还原客户和规格
		$mClient = & FLEA::getSingleton('Model_Jichu_Client');
		$mWare = & FLEA::getSingleton('Model_Jichu_Ware');
		// dump($ret);exit();
		if($ret) foreach($ret as $key =>& $v) {
			$v['cntInit'] = $v['cntInitRuku'] - $v['cntInitChuku'];
			$temp = explode(',',$key);
			$v['Ware'] = $mWare->find(array('id'=>$temp[0]));
			$v['guige'] = $v['Ware']['wareName']. ' ' .$v['Ware']['guige'];
			$v['cntRemain'] = $v['cntInit']+$v['cntRuku'] - $v['cntChuku'];
		}
		$ret[] = $this->getHeji($ret,array('cntInit','cntRuku','cntChuku','cntRemain'),'guige');
		//dump($ret);
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		$arr_field_info = array(
			// "Client.compName"=>"客户",
			"guige" => "纱支规格",
			"cntInit"=>"上日余存",
			"cntRuku" =>"本日入库",
			"cntChuku" =>"本日出库",
			//"cntTuiku" =>"本日退库",
			"cntRemain" => "本日结余"
		);
		$smarty->assign('title','坯纱日报表');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$ret);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arrGet);
		//$smarty->assign('other_search_item',$cHtml);
		//$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arrGet)));
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps ：本厂坯纱仓库库存报表
	 * Time：2017/09/01 15:44:28
	 * @author zcc
	*/
	function actionRight2(){
		//$this->authCheck();
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
		));
		$dateFrom = $arrGet['dateFrom'];
		$dateTo = $arrGet['dateTo'];
		//期初入库（退库也是其中一种）
		$initRk = "SELECT sum(cnt) as initCnt,0 as rukuCnt,0 as chukuCnt,0 as cntTuiku,y.wareId
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId
			where 1 and x.rukuDate<'{$arrGet['dateFrom']}' and x.kind ='1' group by y.wareId";
		//期初出库
		$initCk = "SELECT sum(-1*cnt) as initCnt,0 as rukuCnt,0 as chukuCnt,0 as cntTuiku,y.wareId
			FROM cangku_chuku x 
			left join cangku_chuku2ware y on x.id = y.chuKuId
			where 1 and x.chukuDate<'{$arrGet['dateFrom']}' and y.kind ='1' group by y.wareId";	
		//期初退库
		// $initTk = "SELECT 0 as initCnt,0 as rukuCnt,0 as chukuCnt,sum(cnt*-1) as cntTuiku,y.wareId
		// 	FROM cangku_ruku x 
		// 	left join cangku_ruku2ware y on x.id = y.ruKuId
		// 	where 1 and x.rukuDate<'{$arrGet['dateFrom']}' and x.kind ='1' group by y.wareId";

		//本期入库
		$benqiRk = "SELECT 0 as initCnt,sum(cnt) as rukuCnt,0 as chukuCnt,0 as cntTuiku,y.wareId
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId
			where 1 and x.rukuDate>='{$arrGet['dateFrom']}' and x.rukuDate<='{$arrGet['dateTo']}' and x.kind ='1' and x.isTuiku=0 group by y.wareId";

		//本期退库
		$benqiTk = "SELECT 0 as initCnt,0 as rukuCnt,0 as chukuCnt,sum(cnt*-1) as cntTuiku,y.wareId
			FROM cangku_ruku x 
			left join cangku_ruku2ware y on x.id = y.ruKuId
			where 1 and x.rukuDate>='{$arrGet['dateFrom']}' and x.rukuDate<='{$arrGet['dateTo']}' and x.kind ='1' and x.isTuiku=1 group by y.wareId";
				
		//本期出库	
		$benqiCk = "SELECT 0 as initCnt,0 as rukuCnt,sum(cnt) as chukuCnt,0 as cntTuiku,y.wareId
			FROM cangku_chuku x 
			left join cangku_chuku2ware y on x.id = y.chuKuId
			where 1 and x.chukuDate>='{$arrGet['dateFrom']}' and x.chukuDate<='{$arrGet['dateTo']}' and y.kind ='1' group by y.wareId";	


		$sql = "SELECT 
			sum(initCnt) as initCnt,
			sum(rukuCnt) as rukuCnt,
			sum(chukuCnt) as chukuCnt,
			sum(cntTuiku) as cntTuiku,
			sum(initCnt+rukuCnt-chukuCnt-cntTuiku) as kucun,
			w.wareName,w.guige,a.wareId
			FROM ($initRk union $initCk union $benqiRk union $benqiCk union $benqiTk) as a
			left join jichu_ware w on w.id = a.wareId
			WHERE 1";
		$sql .= " GROUP BY a.wareId order by a.wareId";		
		//本期出库	
		// dump($sql);exit;
		$pager = new TMIS_Pager($sql);
		$rowset=$pager->findAll();
		// dump($rowset);exit();
		foreach ($rowset as &$v) {
			//求出退库的数据

			$v['shazhi'] = $v['wareName'].''.$v['guige'];
			if ($v['rukuCnt']>0) $v['rukuCnt'] = "<a href='?controller=CangKu_RuKuBc&action=DetailRuku&clientId=$clientId&wareId=$v[wareId]&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1' class='thickbox'>$v[rukuCnt]</a>";
			if ($v['chukuCnt']>0) $v['chukuCnt'] = "<a href='?controller=CangKu_ChuKuBc&action=DetailChuku&clientId=$clientId&wareId=$v[wareId]&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1' class='thickbox'>$v[chukuCnt]</a>";
			if ($v['cntTuiku']) $v['cntTuiku'] = "<a href='?controller=CangKu_TuikuBc&action=right&clientId=$clientId&wareId=$v[wareId]&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1' target='_blank'>".abs($v[cntTuiku])."</a>";
		}

		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		//by zcc 客户库存数=上月余存+入库-成品出库
		$arr_field_info = array(
			"shazhi" => "纱支规格",
			"initCnt"=>"上月余存",
			"rukuCnt" =>"入库(点击查看明细)",
			"chukuCnt" =>"领料出库(点击查看明细)",
			"cntTuiku" =>"退库",
			"kucun" => "库存数"
		);
		$smarty->assign('title','坯纱仓库库存报表');
		//$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display', 'none');
		$smarty->assign('url_daochu', $this->_url('export2excel',$arrGet));
		$smarty->assign('arr_condition', $arrGet);
        // $smarty->assign('other_script','<script language="javascript" src="Resource/Script/thickbox/thickbox.js"></script>');
		//$smarty->assign('other_search_item',$cHtml);
		$smarty->assign('page_info',$pager->getNavBar('Index.php?'.$pager->getParamStr($arrGet)));
		$smarty->display('TableList.tpl');
	}
	/**
	 * ps ：客户坯纱库存
	 * Time：2018年1月11日 13:24:10
	 * @author zcc
	*/
	function actionClientPishaKucun(){
		//必须选客户
		FLEA::loadClass('TMIS_Pager');
		$arrGet = TMIS_Pager::getParamArray(array(
			dateFrom =>date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y"))),
			dateTo => date("Y-m-d"),
			clientId=>''
		));

		if ($arrGet[clientId]!='') {
			$clientId = $arrGet[clientId];
			//得到坯纱规格id的范围
			$topNode = $this->_modelWare->getTopNodeOfPisha();
			$leftId = $topNode[leftId];
			$rightId = $topNode[rightId];
			$nodeCondition = "leftId>'$leftId' and rightId<'$rightId' and leftId+1=rightId";
			$arrNode = $this->_modelWare->findAll($nodeCondition);
			// dump($arrNode); exit;

			////对每一个坯纱的品种进行搜索,如果3个项目都空，则不显示。
			$dateFrom = $arrGet[dateFrom];
			$dateTo = $arrGet[dateTo];
			$newArr = array();
			foreach($arrNode as $v) {
				$wareId = $v['id'];
				$ware = $this->_modelWare->find("id=".$wareId);
				$tempArr=array();
				$tempArr[wareId]		= $wareId;
				$tempArr[shazhi]		= $ware[wareName] . " " . $ware[guige];
				$tempArr[cntInit]		= $this->_modelExample->getInitInfo($clientId,$wareId,$dateFrom,0);
				$tempArr[cntRuku]		= $this->_modelExample->getRukuInfo($clientId,$wareId,$dateFrom,$dateTo,0);
				$tempArr[cntChuku]		= $this->_modelExample->getChukuInfo($clientId,$wareId,$dateFrom,$dateTo,0);
				
				$tempArr[cntTuiku]		= $this->_modelExample->getTuikuInfo($clientId,$wareId,$dateFrom,$dateTo,0);
				$tempArr[cntRemain]		= $tempArr[cntInit]+$tempArr[cntRuku]+$tempArr[cntTuiku]-$tempArr[cntChuku];
				if (empty($tempArr[cntInit])&&empty($tempArr[cntRuku])&&empty($tempArr[cntChuku])&&empty($tempArr[cntTuiku])) continue;
				$sql = "SELECT sum(x.cntKg) as planCnt
				FROM trade_dye_order2ware x
				left join trade_dye_order y on x.orderId = y.id
				where 1 and y.kind = 0 and y.clientId = {$clientId} and x.wareId={$wareId}
				and y.dateOrder <'{$dateFrom}'
				";
				$cntInit2 = $this->_modelWare->findBysql($sql);
				
				$str = "select sum(cnt) as cnt from view_cangku_chuku
					where supplierId='$clientId' and wareId='$wareId' and chukuDate<'$dateFrom' and kind = 0";	
				$re = mysql_fetch_array(mysql_query($str));
				$tempArr[cntInit2] = $cntInit2[0]['planCnt']-$re[cnt];

				$sql = "SELECT sum(x.cntKg) as planCnt
				FROM trade_dye_order2ware x
				left join trade_dye_order y on x.orderId = y.id
				where 1 and y.kind = 0 and y.clientId = {$clientId} and x.wareId={$wareId}
				and y.dateOrder >='{$dateFrom}' and y.dateOrder <= '{$dateTo}'
				";
				$planCnt = $this->_modelWare->findBysql($sql);
				$tempArr[cntYw] = $planCnt[0]['planCnt']-$tempArr[cntChuku];
				$tempArr[cntKeyong] = $tempArr[cntInit]+$tempArr[cntRuku]-$planCnt[0]['planCnt']-$tempArr[cntInit2];

				$initCntTotal += $tempArr[cntInit];
				$initCntTotal2 += $tempArr[cntInit2];
				$rukuCntTotal += $tempArr[cntRuku];
				$chukuCntTotal += $tempArr[cntChuku];
				$chukuCntTotalCp += $tempArr[cntChukuCp];
				$tuikuCntTotal += abs($tempArr[cntTuiku]);
				$cntKeyong +=$tempArr[cntKeyong];
				$cntYw += $tempArr[cntYw];
				if ($tempArr[cntRuku]>=0) $tempArr[cntRuku] = "<a href='?controller=CangKu_RuKu&action=right1&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1' class='thickbox'>$tempArr[cntRuku]</a>";
				if ($tempArr[cntChuku]>0) $tempArr[cntChuku] = "<a href='?controller=CangKu_ChuKu&action=right2&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1' class='thickbox'>$tempArr[cntChuku]</a>";
				if ($tempArr[cntTuiku]) $tempArr[cntTuiku] = "<a href='?controller=CangKu_Tuiku&action=right&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1' target='_blank'>".abs($tempArr[cntTuiku])."</a>";
				if ($tempArr[cntChukuCp]>0) $tempArr[cntChukuCp] = "<a href='?controller=chengpin_dye_cpck&action=RightMx2&clientId=$clientId&wareId=$wareId&dateFrom=$dateFrom&dateTo=$dateTo&rukuTag=1&TB_iframe=1&width=800' class='thickbox' >$tempArr[cntChukuCp]</a>";
				$tempArr['cntRemain']="<a href='".$this->_url('Detail',array('clientId'=>$clientId,'wareId'=>$wareId,'dateFrom'=>$dateFrom,'dateTo'=>$dateTo,'rukuTag'=>1,'TB_iframe'=>1))."' class='thickbox'>".$tempArr['cntRemain']."</a>";
				$newArr[] = $tempArr;
			}
			//exit();
			$initTotal=0;$rukuTotal=0;$chukuTotal=0;
			$initMoneyTotal=0;$rukuMoneyTotal=0;$chukuMoneyTotal=0;

			//加入合计
			$i = count($newArr);
			$newArr[$i][shazhi] = '<b>合计</b>';
			$newArr[$i][cntInit]  = '<b>'.$initCntTotal.'</b>';
			$newArr[$i][cntInit2]  = '<b>'.$initCntTotal2.'</b>';
			$newArr[$i][cntRuku]  = '<b>'.$rukuCntTotal.'</b>';
			$newArr[$i][cntChuku] = '<b>'.$chukuCntTotal.'</b>';
			$newArr[$i][cntChukuCp] = '<b>'.$chukuCntTotalCp.'</b>';
			$newArr[$i][cntTuiku] = '<b>'.$tuikuCntTotal.'</b>';
			$newArr[$i][cntRemain] = '<b>'.($initCntTotal+$rukuCntTotal-$tuikuCntTotal-$chukuCntTotal).'</b>';
			$newArr[$i][cntKeyong] = '<b>'.$cntKeyong.'</b>';
			$newArr[$i][cntYw] = '<b>'.$cntYw.'</b>';
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $this->title);
		//by zcc 客户可用库存数=期初+入库-出库+tuiku-计划未出库 那就等于期初+入库+退库-计划数
		$arr_field_info = array(
			"shazhi" => "纱支规格",
			"cntInit"=>"上月余存",
			"cntInit2"=>"上月已计划未出库",
			"cntRuku" =>"入库(点击查看明细)",
			"cntChuku" =>"领料出库(点击查看明细)",
			"cntYw" =>"已计划未出库",
			"cntTuiku" =>"退库",
			// "cntRemain" => "实际库存数",
			"cntKeyong" => "可用库存数",
		);
		$smarty->assign('title','坯纱仓库可用库存报表');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$newArr);
		$smarty->assign('add_display', 'none');
		// $smarty->assign('url_daochu', $this->_url('export2excel',$arrGet));
		$smarty->assign('arr_condition', $arrGet);
		$smarty->assign('page_info', "<b>提示：可用库存=(上月余存-上月已计划未出库)+入库-领料出库-已计划未出库+退库</b>");
		$smarty->display('TableList.tpl');
	}
}
?>