<?php
load_class('TMIS_TableDataGateway');
class Model_Plan_Dye_Gang extends TMIS_TableDataGateway {
	var $tableName = 'plan_dye_gang';
	var $primaryKey = 'id';
	var $primaryName = 'carCode';
	var $errorMsg ='';//删除或修改时受限制的提示信息
	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Trade_Dye_Order2Ware',
			'foreignKey' => 'order2wareId',
			'mappingName' => 'OrdWare'
		),
		array(
			'tableClass' => 'Model_JiChu_Vat',
			'foreignKey' => 'vatId',
			'mappingName' => 'Vat'

		)
	);

	//松筒计划,因为建立取消计划,所以取消这个link
	/*var $manyToMany = array(
		array (
			'tableClass' => 'Model_JiChu_StCar' ,
			'mappingName' => 'Car',
			'joinTable' => 'dye_gang2stcar',
			'foreignKey' => 'gangId',
			'assocForeignKey' => 'stcarId',
			'enabled' =>false
		)
	);
	*/

	var $hasMany = array(
		array(//松筒产量,取消松筒计划后新增
			'tableClass' => 'Model_Chejian_SongtongChanliang',
			'foreignKey' => 'gangId',
			'mappingName' => 'SongtongChanliang',
			'enabled' =>false
		),
		array(//坯纱领用
			'tableClass' => 'Model_CangKu_ChuKu2Ware',
			'foreignKey' => 'gangId',
			'mappingName' => 'PishaLingliao',
			'enabled' =>false
		),
		array(//装出笼产量
			'tableClass' => 'Model_Chejian_ZhuangchulongChanliang',
			'foreignKey' => 'gangId',
			'mappingName' => 'ZhuangchulongChanliang',
			'enabled' =>false
		),
		array(//染色产量
			'tableClass' => 'Model_Chejian_RanseChanliang',
			'foreignKey' => 'gangId',
			'mappingName' => 'RanseChanliang',
			'enabled' =>false
		),
		array(//烘纱产量
			'tableClass' => 'Model_Chejian_HongshaChanliang',
			'foreignKey' => 'gangId',
			'mappingName' => 'HongshaChanliang',
			'enabled' =>false
		),
		array(//回倒产量
			'tableClass' => 'Model_Chejian_HuidaoChanliang',
			'foreignKey' => 'gangId',
			'mappingName' => 'HuidaoChanliang',
			'enabled' =>false
		),
		array(//打包产量
			'tableClass' => 'Model_Chejian_DabaoChanliang',
			'foreignKey' => 'gangId',
			'mappingName' => 'DabaoChanliang',
			'enabled' =>false
		),
		array(//入库数
			'tableClass' => 'Model_Chengpin_Dye_Cprk',
			'foreignKey' => 'planId',
			'mappingName' => 'Cprk',
			'enabled' =>false
		),
		array(//发货数
			'tableClass' => 'Model_Chengpin_Dye_Cpck',
			'foreignKey' => 'planId',
			'mappingName' => 'Cpck',
			'enabled' =>false
		),
	);

	//很多生产流程需要显示缸号的列表，该函数提供一个通用的缸号数据集
	//客户,纱支规格,颜色,交货日期,缸号,计划投料，定重
	//同时提供分页操作
	function findAllGang($condition=NULL,&$pager=null,$pageSize=0) {
		$mOrder = & FLEA::getSingleton('Model_Trade_Dye_Order');
		$mWare = & FLEA::getSingleton('Model_JiChu_Ware');
		FLEA::loadClass('TMIS_Pager');
		$modelO2w = $this;
		$pager = new TMIS_Pager($modelO2w,$condition,null,$pageSize);
		$rowO2w = $pager->findAll();
		//$dbo=FLEA::getDBO(false);
		//dump($dbo->log);exit;
		//dump($rowO2w);
		/**/
		foreach($rowO2w as & $value) {
				$rowset = $mOrder->findByField('id', $value[OrdWare][orderId]);
				//订单号
				$value[orderCode] = $rowset[orderCode];
				//客户
				$value[clientName] = $rowset[Client][compName];
				//纱支规格
				$Ware = $mWare->findByField('id',$value[OrdWare][wareId]);
				$value[guige] = $Ware[wareName]." ".$Ware[guige];
				//颜色
				$value[color] = $value[OrdWare][color];
				//交货日期
				$value[dateJiaohuo] = $rowset[dateJiaohuo];
		}
		return $rowO2w;
	}

	//利用视图，更加直接，方便根据不同条件进行查询。
	//pageSize=0表示默认为配置文件中的pageSize
	function findAllGang1($condition=NULL,&$pager=null,$pageSize=0,$sortBy=NULL) {
		//dump($condition);
		FLEA::loadClass('TMIS_Pager');
		//$tableName=$tableName;
		if ($condition) $conStr = join(" and ",$condition);
		//if ($condition[clientId]>0) $conStr = " and clientId = '$condition[clientId]'";
		$sql = "select * from view_dye_gang where 1";
		if ($conStr!='') $sql .= " and $conStr";
		if($sortBy==NULL) {
			$sortBy = "gangId desc";
		}
		$sql.=" order by $sortBy";
		// echo $sql;exit;
		$pager = new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAllBySql($sql);
		return $rowset;
	}

		//利用视图，更加直接，方便根据不同条件进行查询。
	//pageSize=0表示默认为配置文件中的pageSize
	function findAllGangNew($condition=NULL,&$pager=null,$pageSize=0,$sortBy=NULL) {
		//dump($condition);
		FLEA::loadClass('TMIS_Pager');
		//$tableName=$tableName;
		if ($condition) $conStr = join(" and ",$condition);
		//if ($condition[clientId]>0) $conStr = " and clientId = '$condition[clientId]'";
		$sql = "select x.*,y.PishaPrintTimes 
		        from view_dye_gang x
		        left join plan_dye_gang y on x.gangId=y.id
		        where 1";
		if ($conStr!='') $sql .= " and $conStr";
		if($sortBy==NULL) {
			$sortBy = "gangId desc";
		}
		$sql.=" order by $sortBy";
		// echo $sql;exit;
		$pager = new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAllBySql($sql);
		return $rowset;
	}
	/**
	 * ps ：关联plan_dye_gang 其中视图部分字段未更新 
	 * Time：2017年12月28日 09:49:07
	 * @author zcc
	*/
	function findAllGang1New($condition=NULL,&$pager=null,$pageSize=0,$sortBy=NULL) {
		//dump($condition);
		FLEA::loadClass('TMIS_Pager');
		//$tableName=$tableName;
		if ($condition) $conStr = join(" and ",$condition);
		//if ($condition[clientId]>0) $conStr = " and clientId = '$condition[clientId]'";
		$sql = "select 
			x.*,y.PishaPrintTimes
			from view_dye_gang x 
			left join plan_dye_gang y on x.gangId = y.id
			where 1";
		if ($conStr!='') $sql .= " and $conStr";
		if($sortBy==NULL) {
			$sortBy = "gangId desc";
		}
		$sql.=" order by $sortBy";
		// echo $sql;exit;
		$sql = "select * from ({$sql}) as a";
		$pager = new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAllBySql($sql);
		return $rowset;
	}

	//利用视图，更加直接，方便根据不同条件进行查询。
	//pageSize=0表示默认为配置文件中的pageSize
	function findAllGang1News($condition=NULL,&$pager=null,$pageSize=0,$sortBy=NULL) {
		//dump($condition);
		FLEA::loadClass('TMIS_Pager');
		//$tableName=$tableName;
		if ($condition) $conStr = join(" and ",$condition);
		//if ($condition[clientId]>0) $conStr = " and clientId = '$condition[clientId]'";
		$sql = "select * from view_dye_gang where 1 and sqlingliao=0";
		if ($conStr!='') $sql .= " and $conStr";
		if($sortBy==NULL) {
			$sortBy = "gangId desc";
		}
		$sql.=" order by $sortBy";
		//echo $sql;exit;
		$pager = new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAllBySql($sql);
		return $rowset;
	}
    
  	/*function findAllGang2($tableName,$condition=NULL,&$pager=null,$pageSize=0,$sortBy=NULL) {
		//dump($condition);
		FLEA::loadClass('TMIS_Pager');
		if ($condition) $conStr = join(" and ",$condition);
		//if ($condition[clientId]>0) $conStr = " and clientId = '$condition[clientId]'";
		$sql = "select x.* from view_dye_gang x left join $tableName y on x.gangId=y.gangId where 1";
		if ($conStr!='') $sql .= " and $conStr";
		if($sortBy==NULL) {
			$sortBy = "x.gangId desc";
		}
		$sql.=" order by $sortBy";
		//echo $sql;exit;
		$pager = new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAllBySql($sql);
		return $rowset;
	}*/
	function findAllGang2($tableName,$condition=NULL,&$pager=null,$pageSize=0,$sortBy=NULL) {
		//dump($condition);
		FLEA::loadClass('TMIS_Pager');
		if ($condition) $conStr = join(" and ",$condition);
		//if ($condition[clientId]>0) $conStr = " and clientId = '$condition[clientId]'";
		$chanliang="select sum(cntK) as cntK,gangId from $tableName where 1 group by gangId";
		$sql = "select x.*,y.cntK
			from view_dye_gang x
			left join ({$chanliang}) y on x.gangId=y.gangId
			where IFNULL(x.cntPlanTouliao,0)>IFNULL(y.cntK,0)
		";
		if ($conStr!='') $sql .= " and $conStr";
		if($sortBy==NULL) {
			$sortBy = "x.gangId desc";
		}
		$sql.=" order by $sortBy";
		//echo $sql;exit;
		$pager = new TMIS_Pager($sql,null,null,$pageSize);
		$rowset = $pager->findAllBySql($sql);
		return $rowset;
	}
	//删除缸时判断是否产生过成品出库记录,是则禁止
	//级联删除领料记录
	function removeByPkv($pkv) {
		//echo($pkv);
		$m = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$gang = $m->find(array('planId'=>$pkv));
		if ($gang) {
			$this->errorMsg = '缸号'.$gang['Plan']['vatNum'].'已有成品发货记录, 请先通知成品仓库删除发货记录后再删除计划!';
			return false;
		}

		//删除相关领料记录
		$m = & FLEA::getSingleton('Model_CangKu_ChuKu');
		$con = array(array('Wares.gangId',$pkv));
		$chuku = $m->find($con);

		//将待删除的领纱记录和待删除的缸号信息形成生产信息插入oa_message表中
		if ($chuku) {
			$gang = $this->formatRet($this->find(array('id'=>$chuku['Wares'][0]['gangId'])));
			$title = date("Y-m-d").",删除缸号:{$gang['vatNum']}({$gang['Client']['compName']},{$gang['OrdWare']['Ware']['wareName']} {$gang['OrdWare']['Ware']['guige']},{$gang['OrdWare']['color']}),投料{$gang['OrdWare']['cntKg']}kg";

			$msg = date("Y-m-d").",<font color='blue'>删除</font>缸号:<font color='red'>{$gang['vatNum']}</font>(<font color='blue'>{$gang['Client']['compName']},{$gang['OrdWare']['Ware']['wareName']} {$gang['OrdWare']['Ware']['guige']},{$gang['OrdWare']['color']},投料{$gang['OrdWare']['cntKg']}kg</font>),相关领纱记录由系统自动删除!";

			$mMsg = & FLEA::getSingleton('Model_OA_Message');
			$arr = array(
				'classId'=>6,
				'title'=>$title,
				'content'=>$msg,
				'buildDate'=>date('Y-m-d'),
				'userId'=>$_SESSION['USERID']
			);
			$mMsg->create($arr);

			$m->removeByPkv($chuku[id]);
		}

		//删除加急信息
		$sql = "delete from oa_message where classId=7 and gangId='$pkv'";
		mysql_query($sql) or die(mysql_error());

		return parent::removeByPkv($pkv);
	}

	#修改缸之前，如果计划数有变，则修改坯纱领料表中的相关记录,同时发送通知
	function _beforeUpdateDb(&$row) {
		if(!$row['cntPlanTouliao']) return true;

		$m = & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
		$m->clearLinks();
		$con = array('gangId'=>$row['id']);
		//dump($con);exit;
		$chuku = $m->find($con);
		if($row['cntPlanTouliao']!=$chuku['cnt'] && $chuku['cnt']>0) {
			$gang = $this->formatRet($this->find(array('id'=>$row['id'])));
			$title = date("Y-m-d").",缸号:{$gang['vatNum']}({$gang['Client']['compName']},{$gang['OrdWare']['Ware']['wareName']} {$gang['OrdWare']['Ware']['guige']},{$gang['OrdWare']['color']})投料数有变({$gang['cntPlanTouliao']}->{$row['cntPlanTouliao']})";

			$msg = date("Y-m-d").",缸号:{$gang['vatNum']}({$gang['Client']['compName']},{$gang['OrdWare']['Ware']['wareName']} {$gang['OrdWare']['Ware']['guige']},{$gang['OrdWare']['color']})投料数有变({$gang['cntPlanTouliao']}->{$row['cntPlanTouliao']}),相关领纱数由系统自动修改,请注意坯纱库存的改动!";

			$mMsg = & FLEA::getSingleton('Model_OA_Message');
			$arr = array(
				'classId'=>6,
				'title'=>$title,
				'content'=>$msg,
				'buildDate'=>date('Y-m-d'),
				'userId'=>$_SESSION['USERID']
			);
			//dump($arr);exit;
			$mMsg->create($arr);

			$chuku['cnt']=$row['cntPlanTouliao'];
			//dump($chuku);exit;
			return $m->update($chuku);
		}
		return true;
		//dump($row);
		//dump($chuku);exit;
	}

	//根据缸号表的主键取得客户,
	function getClient($pkv) {
		$arr = $this->find($pkv);
		$orderId = $arr[OrdWare][orderId];
		$_model = FLEA::getSingleton('Model_Trade_Dye_Order');
		$o = $_model->findByField('id',$orderId);
		return $o[Client];
	}

	//根据缸号表的主键取得规格信息
	function getWare($pkv) {
		$arr = $this->find($pkv);
		$wareId = $arr[OrdWare][wareId];
		$_model = FLEA::getSingleton('Model_JiChu_Ware');
		return $_model->findByField('id',$wareId);
	}

	//得到某个缸号下的松筒产量
	function getStChanliang($pkv){
		$m = & FLEA::getSingleton('Model_Chejian_SongtongChanliang');
		$arr = $m->findAll(array(gangId=>$pkv));
		// dump($arr);exit;
		if(count($arr)>0) foreach($arr as $v) {
			$r += $v[cntTongzi];
		}
		return $r;
		//下面是排计划后的产量搜索,暂时保留。
		/*
		$sql = "select sum(cntKg) as cntKg,sum(cntTongzhi) as cntTongzi from dye_st_chanliang x
			 inner join dye_gang2stcar y on x.gang2stcarId = y.id
			 where y.gangId = $pkv";
		//echo $sql;
		$re = mysql_fetch_array(mysql_query($sql));
		$arr = array(
			cntKg => $re[cntKg],
			cntTongzi => $re[cntTongzi]
		);
		return $arr;
		*/
	}
	//得到某个缸号下的松筒净重
	function getStNetWeight($pkv){
		$m = & FLEA::getSingleton('Model_Chejian_SongtongChanliang');
		$arr = $m->findAll(array(gangId=>$pkv));

		if(count($arr)>0) foreach($arr as $v) {
			$r += $v['netWeight'];
		}
		return $r;
		//下面是排计划后的产量搜索,暂时保留。
		/*
		$sql = "select sum(cntKg) as cntKg,sum(cntTongzhi) as cntTongzi from dye_st_chanliang x
			 inner join dye_gang2stcar y on x.gang2stcarId = y.id
			 where y.gangId = $pkv";
		//echo $sql;
		$re = mysql_fetch_array(mysql_query($sql));
		$arr = array(
			cntKg => $re[cntKg],
			cntTongzi => $re[cntTongzi]
		);
		return $arr;
		*/
	}

	//得到某个缸号下的烘纱产量
	function getHsChanliang($pkv){
		$m = & FLEA::getSingleton('Model_Chejian_HongshaChanliang');
		$arr = $m->findAll(array(gangId=>$pkv));

		if(count($arr)>0) foreach($arr as $v) {
			$r += $v[cntTongzi];
		}
		return $r;
	}

	//得到某个缸号下的回倒产量
	function getHdChanliang($pkv){
		$m = & FLEA::getSingleton('Model_Chejian_HuidaoChanliang');
		$arr = $m->findAll(array(gangId=>$pkv));

		if(count($arr)>0) foreach($arr as $v) {
			$r += $v[cntTongzi];
		}
		return $r;
	}

	//得到某个缸号下的装出笼产量
	function getZclChanliang($pkv){
		$m = & FLEA::getSingleton('Model_Chejian_ZhuangchulongChanliang');
		$arr = $m->findAll(array(gangId=>$pkv));

		if(count($arr)>0) foreach($arr as $v) {
			$r += $v[cntTongzi];
		}
		return $r;
	}

	//得到某个缸号下的打包产量
	function getDbChanliang($pkv){
		$m = & FLEA::getSingleton('Model_Chejian_DabaoChanliang');
		$arr = $m->findAll(array(gangId=>$pkv));

		if(count($arr)>0) foreach($arr as $v) {
			$r += $v[cntTongzi];
		}
		return $r;
	}

	//得到某个缸的坯纱领料出库数量
	function getCntPishaLingliao($pkv) {
		$m = & FLEA::getSingleton('Model_CangKu_ChuKu2Ware');
		$arr = $m->findAll(array(gangId=>$pkv));
		//dump($arr);
		if(count($arr)>0) foreach($arr as $v) {
			$r += $v[cnt];
		}
		return $r;
	}

	//得到某个缸的成品入库产量
	function getCprkChanliang($pkv) {
		$m = & FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
		$arr = $m->findAll(array('planId'=>$pkv));
		//dump($arr);exit;
		if(count($arr)>0) foreach($arr as & $v) {
			//$r += $v[Plan][cntPlanTouliao];
            $r+=$v['cntJian'];
		}
        //echo($r);exit;
		return $r;
	}

	//得到某个缸的染色筒子的正常产量,产量类别为0表示正常产量，1为修色，2为加色
	function getRanseChanliang($pkv) {
		$m = & FLEA::getSingleton('Model_Chejian_RanseChanliang');
		$arr = $m->findAll(array(gangId=>$pkv));
		//dump($arr);
		if(count($arr)>0) foreach($arr as $v) {
			if($v[chanliangKind]==0) {
				$r += $v[cntTongzi];
			}
		}
		return $r;
	}

	//得到某个缸的染色的所有类型产量,0表示正常产量，1为修色，2为加色
	function getArrRanseChanliang($pkv) {
		$m = & FLEA::getSingleton('Model_Chejian_RanseChanliang');
		$arr = $m->findAll(array(gangId=>$pkv));
		$arrR = array(0,0,0);
		if(count($arr)>0) foreach($arr as $v) {
			$arrR[$v[chanliangKind]] += $v[cntTongzi];
		}
		return $arrR;
	}

	//得到某个缸的成品入库筒子数
	function getCprkTongziCnt($pkv) {
		$m = & FLEA::getSingleton('Model_Chengpin_Dye_Cprk');
		$arr = $m->findAll(array(planId=>$pkv));
		//dump($arr);
		if(count($arr)>0) foreach($arr as $v) {
			//$r += $v[Plan][cntPlanTouliao];
			$r += $v[cntTongzi];
		}
		return $r;
	}

	//得到某个缸的成品出库产量和
	function getCpckChanliang($pkv) {
		$m = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$arr = $m->findAll(array(planId=>$pkv));
		//dump($arr);
		if(count($arr)>0) foreach($arr as $v) {
			//$r += $v[Plan][cntPlanTouliao];
			$r += $v[cntChuku];
		}
		return $r;
	}
	//得到某个缸的成品出库的净重和
	function getCpckJingkg($pkv) {
		$m = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$arr = $m->findAll(array(planId=>$pkv));
		//dump($arr);
		if(count($arr)>0) foreach($arr as $v) {
			//$r += $v[Plan][cntPlanTouliao];
			$r += $v[jingKg];
		}
		return $r;
	}
	//得到某个缸的成品出库的折率净重和
	function getCpckJingkgZ($pkv) {
		$m = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$arr = $m->findAll(array(planId=>$pkv));
		//dump($arr);
		if(count($arr)>0) foreach($arr as $v) {
			//$r += $v[Plan][cntPlanTouliao];
			$r += $v[jingKgZ];
		}
		return $r;
	}
	//得到某个缸的成品出库的毛重和
	function getCpckMaokg($pkv) {
		$m = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$arr = $m->findAll(array(planId=>$pkv));
		//dump($arr);
		if(count($arr)>0) foreach($arr as $v) {
			//$r += $v[Plan][cntPlanTouliao];
			$r += $v[maoKg];
		}
		return $r;
	}
	//得到某个缸成品出库的净重
	function getCpckJingzhong($pkv) {
		$m = & FLEA::getSingleton('Model_Chengpin_Dye_Cpck');
		$arr = $m->findAll(array(planId=>$pkv));
		//dump($arr);
		if(count($arr)>0) foreach($arr as $v) {
			$r += $v[jingKg];
		}
		return $r;
	}

	//得到工艺是否完成
	function getCntOfChufang($gangId) {
		$m= & FLEA::getSingleton('Model_Gongyi_Dye_Chufang');
		$arr = $this->find(array(id=>$gangId));
		return $m->getCntOfChufang($arr[order2wareId]);
	}

	#格式化某行记录
	function formatRet( & $row) {
		$m = & FLEA::getSingleton('Model_Trade_Dye_Order2Ware');
		$m->disableLink('Pdg');
		$mClient = & FLEA::getSingleton('Model_JiChu_Client');
		$mVat = & FLEA::getSingleton('Model_JiChu_Vat');
		$row['OrdWare'] = $m->find(array('id'=>$row['order2wareId']));
		$row['Client'] = $mClient->find(array('id'=>$row['OrdWare']['Order']['clientId']));
		if (!$row['Vat']) $row['Vat'] = $mVat->find(array('id'=>$row['vatId']));
		return $row;
	}
	#得到反修缸的缸号,普通缸号后加-X,已反修缸号后自增1
	function getGangNumOfFanxiu($vatNum) {
		$a = substr($vatNum,0,9);

		$sql = "select * from plan_dye_gang where vatNum like '{$a}%' order by vatNum desc limit 0,1";
		//dump($sql);
		$row = $this->findBySql($sql);//dump($row);
		$max = $row[0]['vatNum'];

		if(substr($max,9,1)!='-') {//如果是普通缸号，搜索相关的最大反修的缸号，自增1
			return $max.'-1';
		}
		return $a .'-'. (substr($max,10)+1);
	}
	#得到新的逻辑缸号
	function getNewGangNum($cntVat=1) {
		//dump($cntVat);exit;
		$ymd=date("ymd");
		//echo $ymd;exit;
		$sql = "select code from other_newcode where type=1";	//type=1表示是缸号id
		$row = $this->findBySql($sql);
	//dump($row);exit;
		//第一次取缸号，不存在记录，需要插入一条新的记录
		if(!$row){
			$t = date('ymd').'000';
			$sql = "insert into other_newcode (type,code) values(1,'{$t}')";
			//echo $sql;exit;
			mysql_query($sql) or die(mysql_error());
		} else $t = $row[0]['code'];
		//比较
		//$max = 0000;//临时最大值
		$temp = date("ymd")."000";
		//dump($t);dump($temp);exit;
		if ($temp>$t) {//当天第一缸 返回一定数目的缸号,并保存最大缸号
			$t = $temp;
		}

		//确保$t不小于plan_dye_gang表中的最大缸号
		$likeName = date("ymd").'___';//添加 条件 以便于 能自定义缸号 和这边不冲突
		$str = "select max(vatNum) code from plan_dye_gang where vatNum like '{$likeName}'";
		$re = mysql_fetch_assoc(mysql_query($str));
		if($re['code']>$t) $t = $re['code'];

		//返回一定数目的缸号,并保存最大缸号
		return $this->makeNewVatNum($t,$cntVat);
	}

	//返回一定数目的缸号,并保存最大缸号
	function makeNewVatNum($codeFrom,$cntVat) {
		$ymd = date('ymd');
		$vatNo = substr($codeFrom,6,3);
		//echo $cntVat;exit;
		for($i=0;$i<$cntVat;$i++) {
			//$arrR[] = $ymd.$newOrderNo.substr(101+$i+$vatNo,-2);
			$arrR[] = $ymd.substr(1001+$i+$vatNo,-3);
		}
		//dump($arrR);exit;
		$max = $arrR[$i-1];
		//dump($arrR);exit;
		//本应该将最大缸号保存进other_newcode表中，但是为了保持缸号插入与新缸号的一致，所以这一步放在_afterCreate方法中.
		return $arrR;
	}

	function addTimesPrint($pkv) {//流转卡 打印次数增加
		$str = "update plan_dye_gang set timesPrint=timesPrint+1 where id=$pkv";
		mysql_query($str) or die(mysql_error());
	}

	function addTimesPrintPg($pkv) {//排杠卡 打印次数增加
		$str = "update plan_dye_gang set timesPrint2=timesPrint2+1 where id=$pkv";
		mysql_query($str) or die(mysql_error());
	}

	function isJiaji($pkv){
		$sql = "select count(*) cnt from  oa_message where classId=7 and gangId='$pkv'";
		$r = mysql_fetch_assoc(mysql_query($sql));
		if($r['cnt']==0) return false;
		return true;
	}

	function _afterCreateDb(&$row) {
		$gang = $this->find($row['id']);
		if ($gang['parentGangId']==''||$gang['parentGangId']=='0') {//回修的数据不进行保存(原因：由于客户会修改缸号 这样就导致 other_newcode 存入无规则的缸号 导致 下一天排缸计划 跳号 ) by zcc
			//保持临时表中最大缸号的值，方便以后取得最大缸号.
			$str = "update other_newcode set code='{$row['vatNum']}' where type=1";
			mysql_query($str) or die(mysql_error());
		}
	}

	//得到双染的缸的当前状态
	function getTwiceStatu(&$row) {
		if($row['markTwice']!=1) return '';
		if($row['fensanOver']==0) {//如果未排过缸,表示需要进行第一道工序:分散
			if($row['dateAssign']==$row['dateAssign1'] && $row['ranseBanci']==$row['ranseBanci1']) return "分散+套棉";
			return '分散';
		}
		if($row['fensanOver']==1) {//如果未排过缸,表示需要进行第一道工序:分散
			return '套棉';
		}
		return '未知';
		//如果第一道工序有产量了，表示进入第二道工序:套棉
	}
	#设置缸号
	function setVatNum($gangId,$order2wareId){
		$str="select id,vatNum from plan_dye_gang where order2wareId='{$order2wareId}' order by id asc";
		//echo $str.'<br>';
		$arr=$this->findBySql($str);
		//dump($arr);
		$cnt=count($arr);
		if($cnt>1){
			$a='';
			for($i=0;$i<$cnt;$i++){
				if($arr[$i]['id']==$gangId){
					$a=$arr[$i]['vatNum'].'('.$cnt.'/'.($i+1).')';
				}
			}
			return $a;
		}else{
			return $arr[0]['vatNum'];
		}
	}
}
?>
