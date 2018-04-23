<?php
namespace console\models;

use Yii;
use yii\base\Model;
use common\models\YxCmpUser;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;
    public $code;


    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['email','code'], 'trim'],
            [['email','code'], 'required'],
            [['email'], 'string','min' => 11, 'max' => 11],
            [['email'], 'exist',
                'targetClass' => '\common\models\YxCmpUser',
                'filter' => ['status' => YxCmpUser::STATUS_ACTIVE],
                'message' => '该手机号码不存在'
            ],
            [['code'], 'string','min' => 6, 'max' => 6],
            [['code'], 'validateCode', 'message' => '请输入正确的验证码'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => '电话',
            'code' => '验证码',
        ];
    }

    public function validateCode($attribute, $params)
    {
        if (!$this->hasErrors()) {
          $redis = Yii::$app->redis;
          if(!$this->code || $redis->get($this->email) != $this->code){
              $this->addError($attribute, '请输入正确的验证码.');
          }
        }
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    // public function sendEmail()
    // {
    //     /* @var $user User */
    //     $user = YxCmpUser::findOne([
    //         'status' => YxCmpUser::STATUS_ACTIVE,
    //         'email' => $this->email,
    //     ]);

    //     if (!$user) {
    //         return false;
    //     }

    //     if (!YxCmpUser::isPasswordResetTokenValid($user->password_reset_token)) {
    //         $user->generatePasswordResetToken();
    //         if (!$user->save()) {
    //             return false;
    //         }
    //     }

    //     return Yii::$app
    //         ->mailer
    //         ->compose(
    //             ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
    //             ['user' => $user]
    //         )
    //         ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
    //         ->setTo($this->email)
    //         ->setSubject('Password reset for ' . Yii::$app->name)
    //         ->send();
    // }
    public function getToken()
    {
        /* @var $user YxCmpUser */
        $user = YxCmpUser::findOne([
            'status' => YxCmpUser::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return null;
        }

        if (!YxCmpUser::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return null;
            }
        }
        return $user;
    }
}
