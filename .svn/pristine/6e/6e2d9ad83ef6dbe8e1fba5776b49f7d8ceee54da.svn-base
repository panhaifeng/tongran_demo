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

    //修改用户的最后登录日期和登录次数
    function changeLoginTime($userId) {
    //
        $dt=date('Y-m-d');
        $cnt=0;
        $str="SELECT * FROM acm_userdb where id='{$userId}' and lastLoginTime='{$dt}'";
        $re=mysql_fetch_assoc(mysql_query($str));
        $cnt+=$re['loginCnt'];
        //修改
        $newCnt=$cnt+1;
        $sql="UPDATE acm_userdb SET lastLoginTime='{$dt}' , loginCnt='{$newCnt}' where id='{$userId}'";
        if (!mysql_query($sql)) {
            return false;
        }
        return true;
    }

}
?>