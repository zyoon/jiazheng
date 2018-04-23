<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\YxServer;
/**
 * This is the model class for table "yx_user".
 *
 * @property int $id
 * @property string $username 账号
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email 邮箱
 * @property int $role 权限
 * @property int $status 状态
 * @property int $create_at 创建时间
 * @property int $update_at 跟新时间
 * @property string $province 省份
 * @property string $city 城市
 * @property string $img 头像
 * @property int $sex 性别
 * @property string $phone 联系电话
 * @property string $address 收货地址
 * @property string $nickname 昵称
 */
class YxUser extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yx_user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),

        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['username', 'password_hash', 'create_at', 'update_at', 'province', 'city', 'sex'], 'required'],
            // [['role', 'create_at', 'update_at', 'sex'], 'integer'],
            // [['username'], 'string', 'max' => 50],
            // [['auth_key'], 'string', 'max' => 32],
            // [['password_hash', 'password_reset_token', 'img', 'address'], 'string', 'max' => 255],
            [['province', 'city'],'integer'],
            [['email'], 'string', 'max' => 45],
            [['phone', 'nickname'], 'string', 'max' => 20],
            // [['phone'], 'unique'],
            // [['nickname'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '账号',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'role' => '权限',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'province' => '省份',
            'city' => '城市',
            'img' => '头像',
            'sex' => '性别',
            'phone' => '电话',
            'address' => '地址',
            'nickname' => '昵称',
        ];
    }
    /**
     * [getName 匹配名字]
     * @Author   Yoon
     * @DateTime 2018-04-05T18:23:53+0800
     * @param    [type]                     $models    [键]
     * @param    [type]                     $ClassName [方法名]
     * @param    [type]                     $params    [方法参数]
     * @return   [type]                                [名字]
     */
    public static function getName($models, $ClassName = "", ...$params)
    {
        $types = self::$ClassName(...$params);

        if (isset($types[$models])) {
            return $types[$models];
        }
        return '未知';
    }

    public static function getUserSex()
    {
        return array(1 => '男', 2 => '女');
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    // 得到用户的名字
    public static function getUserName($user_id) {
      $userName = YxUser::find()->where(['id' => $user_id])->one();
      // print_r($userName);
      return $userName['username'];
    }
}
