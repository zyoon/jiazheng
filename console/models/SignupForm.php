<?php
namespace console\models;

use yii\base\Model;
use common\models\YxCmpUser;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\YxCmpUser', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            [['email'], 'required','message'=>'手机号不能为空'],
            [['email'],'number','message' => '请输入正确手机号'],
            [['email'],'match','pattern'=>'/^[0-9]{11}$/','message' => '请输入正确手机号'],
            ['email', 'unique', 'targetClass' => '\common\models\YxCmpUser', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'账号',
            'email'=>'手机号',
            'password'=>'密码',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new YxCmpUser();
        $user->username = $this->username;
        $user->password_see=$this->password;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
