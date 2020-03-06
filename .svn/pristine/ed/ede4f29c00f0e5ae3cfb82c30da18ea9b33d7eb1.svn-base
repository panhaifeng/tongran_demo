<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 FleaPHP 项目的一部分
//
// Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.fleaphp.org/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * 定义 FLEA_Com_RBAC_UsersManager 类
 *
 * @copyright Copyright (c) 2005 - 2006 FleaPHP.org (www.fleaphp.org)
 * @author 廖宇雷 dualface@gmail.com
 * @package RBAC
 * @version $Id: UsersManager.php 683 2007-01-05 16:27:22Z dualface $
 */

// {{{ constants
/**
 * 密码的加密方式

define('PWD_MD5',       1);
define('PWD_CRYPT',     2);
define('PWD_CLEARTEXT', 3);
define('PWD_SHA1',      4);
define('PWD_SHA2',      5);
 */
// }}}

// {{{ includes
load_class('FLEA_Db_TableDataGateway');
// }}}

/**
 * UsersManager 派生自 FLEA_Db_TableDataGateway，用于访问保存用户信息的数据表
 *
 * 如果数据表的名字不同，应该从 FLEA_Com_RBAC_UsersManager 派生类并使用自定义的数据表名字、主键字段名等。
 *
 * @package RBAC
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.0
 */
class Model_Login extends FLEA_Db_TableDataGateway
{
    /**
     * 主键字段名
     *
     * @var string
     */
    var $primaryKey = 'id';

    /**
     * 数据表名字
     *
     * @var string
     */
    var $tableName = 'acm_userdb';

    /**
     * 用户名字段的名字
     *
     * @var string
     */
    var $usernameField = 'userName';

    /**
     * 密码字段的名字
     *
     * @var string
     */
    var $passwordField = 'passwd';


    /**
     * 密码加密方式
     *
     * @var int
     */
    //var $encodeMethod = PWD_CRYPT;

    /**
     * 构造函数
     */
    function FLEA_Com_RBAC_UsersManager() {
        log_message('Construction FLEA_Com_RBAC_UsersManager', 'debug');
        parent::FLEA_Db_TableDataGateway();
        $this->meta[strtoupper($this->emailField)]['complexType'] = 'EMAIL';
    }

    /**
     * 返回指定 ID 的用户
     *
     * @param mixed $id
     *
     * @return array
     */
    function findByUserId($id) {
        return $this->findByField($this->fullTableName . '.' . $this->primaryKey, $id);
    }

    /**
     * 返回指定用户名的用户
     *
     * @param string $username
     *
     * @return array
     */
    function findByUsername($username) {
        return $this->findByField($this->usernameField, $username);
    }

    /**
     * 检查指定的用户名是否已经存在
     *
     * @param string $username
     *
     * @return boolean
     */
    function existsUsername($username) {
        return $this->findCount($this->usernameField . ' = ' .
            $this->dbo->qstr($username)) > 0;
    }



    /**
     * 验证指定的用户名和密码是否正确
     *
     * @param string $username 用户名
     * @param string $password 密码
     *
     * @return boolean
     *
     * @access public
     */
    function validateUser($username, $password) {
        $user = $this->findByField($this->usernameField, $username, null,
            $this->passwordField);
		//die($user);
        if (!$user) { return false; }
		//die($this->checkPassword($password, $user[$this->passwordField]));
        return $this->checkPassword($password, $user[$this->passwordField]);
    }

    /**
     * 检查密码的明文和密文是否符合
     *
     * @param string $cleartext 密码的明文
     * @param string $cryptograph 密文
     *
     * @return boolean
     *
     * @access public
     */
    function checkPassword($cleartext, $cryptograph) {
	/**
	 * 取消加密
        switch ($this->encodeMethod) {
        case PWD_MD5:
            return (md5($cleartext) == rtrim($cryptograph));
        case PWD_CRYPT:
            return (crypt($cleartext, $cryptograph) == rtrim($cryptograph));
        case PWD_CLEARTEXT:
            return ($cleartext == rtrim($cryptograph));
        case PWD_SHA1:
            return (sha1($cleartext) == rtrim($cryptograph));
        case PWD_SHA2:
            return (hash('sha512', $cleartext) == rtrim($cryptograph));

        default:
            return false;
	 */
	 	return ($cleartext == $cryptograph);
    }
	
	function checkPasswordSn($cleartext, $cryptograph, $username) {
		//把用户输入的密码分成两段
		$password = substr($cleartext,0,strlen($cleartext)-6);
		$snPassword = substr($cleartext,strlen($cleartext)-6);
		
		//调用判断动态密码口令函数
		$result = $this->getSn($username, $snPassword); 
				
		//echo($password.'--'.$cryptograph.'--'.$result); exit;
		if (($password == $cryptograph) && $result){
			return true;
		}else{
			return false;
		}
    }
	
	
	//判断动态口令是否正确，正确返回true结果
	function getSn($username, $snPassword){
		//取得acm_sninfo表中对应的sninfo值。
		$sql = "select x.sn, sninfo from acm_sninfo x 
				left join acm_userdb y on y.sn = x.sn 
				where y.username = '$username'";
		$re=mysql_fetch_assoc(mysql_query($sql));
		$snInfo = $re['sninfo'];
		//echo($sql); exit;
		
		//如果取sninfo值有误，则直接退出。
		if (!$snInfo) {
			return false; exit;
		}
		$sn = $re['sn'];
		
		$b=new COM("SeaMoonDLL.ClassKeys");//调用Com组件

		//调用验证接口
		$a=$b->CheckITSecurityPassWord($snInfo,$snPassword);//调用验证方法，第一个参数为动态令牌SN号对应的字符串，第二个参数为动态密码
		
		//echo($a);exit;
		if (strlen($a)>3){
			//echo "动态密码验证通过"; //此时你需要把$a的值更新到你的数据库，下次调用时取出此字符串作为参数			
			//把新的sninfo写入acm_sninfo的sninfo字段，如果写入失败，直接返回FALSE结果，禁止登入。
			$update = "update acm_sninfo set sninfo = '$a' where sn = '$sn'";
			
			if (!mysql_query($update)){
				return false;
			}
			
			return true;
		}elseif($a=="-2"){		
			//echo "系统内部错误";
			return false;
		}else{
		 	//echo "动态密码错误";
			return false;
		}
	}

}
?>