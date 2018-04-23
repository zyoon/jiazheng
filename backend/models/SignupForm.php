<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password_see;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password_see', 'required'],
            ['password_see', 'string', 'min' => 6],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username'=>'账号',
            'email'=>'邮箱',
            'password_see'=>'密码',
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

        $user = new User();
        $user->username = $this->username;
        $user->password_see=$this->password_see;
        $user->email = $this->email;
        $user->setPassword($this->password_see);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
