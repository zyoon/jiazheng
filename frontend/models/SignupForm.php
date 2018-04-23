<?php
namespace frontend\models;

use yii\base\Model;
use common\models\YxUser;
use yii;
/**
 * Signup form
 */
class SignupForm extends \yii\db\ActiveRecord
{
    public $username;
    public $email;
    public $password;
    public $repassword;
    public $phone;
    public $nickname;
    public $sex;
    public $age;
    public $code;

    public static function tableName()
    {
        return 'yx_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'repassword', 'phone', 'nickname', 'sex', 'age','code'], 'required'],
            [['phone','nickname','code'], 'trim'],
            [['age'], 'integer','min'=>10,'max'=>140],
            [['username','password','repassword'], 'string','min' => 6, 'max' => 20],
            [['phone'], 'string','min' => 11, 'max' => 11],
            [['code'], 'string','min' => 6, 'max' => 6],
            [['username','phone','nickname'], 'trim'],
            [['username','phone','nickname'], 'unique'],
            [['repassword'], 'compare', 'compareAttribute' => 'password', 'message' => '两次输入的密码不一致！'],
            [['code'], 'validateCode', 'message' => '请输入正确的验证码'],

        ];
    }
    public function validateCode($attribute, $params)
    {
        if (!$this->hasErrors()) {
          $redis = Yii::$app->redis;
          if(!$this->code || $redis->get($this->phone) != $this->code){
              $this->addError($attribute, '请输入正确的验证码.');
          }
        }
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '账号',
            'password' => '密码',
            'repassword' => '确认密码',
            'email' => '邮箱',
            'province' => '省份',
            'city' => '城市',
            'img' => '头像',
            'sex' => '性别',
            'age' => '年龄',
            'phone' => '电话',
            'code' => '验证码',
            'address' => '地址',
            'nickname' => '昵称',
        ];
    }

    public static function getUserSex()
    {
        return YxUser::getUserSex();
    }
    /**
     * Signs user up.
     *
     * @return YxUser|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        if ($this->repassword != $this->password) {
            return null;
        }
        $user = new YxUser();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->nickname = $this->nickname;
        $user->sex = $this->sex;
        $user->age = $this->age;
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
