<?php
namespace models;

use Yii;
use yii\base\NotSupportedException;
use yii\base\Object;
use yii\web\IdentityInterface;
use clients\PmClient;
use clients\UserClient;

use clients\ucenter\services\User as Identity;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends Object implements IdentityInterface
{
    public $uid;
    public $account;
    public $name;
    public $authKey = 'b0baee9d279d34fa1dfd71aadb908c3f';
    
    public static $permission;

    /**
     * @inheritdoc
     */
    public static function findIdentity($uid)
    {
        if (!$uid) {
            return null;
        }

        $userInfo = Identity::getUserById($uid);

        if (is_null($userInfo)) {
            return null;
        }

        // 将获取的用户信息封装成 IdentityInterface 实例
        $user = new self();
        $user->uid = $userInfo['id'];
        $user->account = $userInfo['account'];
        $user->name = $userInfo['name'];
        return $user;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"' . __METHOD__ . '" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User
     */
    public static function findByAccount($username)
    {
        throw new NotSupportedException('"' . __METHOD__ . '" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->uid;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 获取当前用户所能使用的功能数据
     *
     * @return array
     */
    public function getUserFunctions()
    {
        $data = [];

        if (is_null($this->uid)) {
            return $data;
        }

        $data = Identity::getFunctionPaths($this->uid);
        return $data;
    }

    /**
     * 获取当前用户所拥有的角色数据
     *
     * @return array|mixed
     */
    public function getUserRoles()
    {
        $data = [];
        $data = Identity::getRolesById($this->uid);
        return $data;


//        foreach ($this->_userRoles as $role) {
//            if ($this->_sysAdminRoleName == $role['en_name']) {
//                $this->_isSysAdmin = true;
//                break;
//            }
//        }
    }
}
