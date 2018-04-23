<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\YxUser;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $phone;
    public $code;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone','code'], 'trim'],
            [['phone','code'], 'required'],
            [['phone'], 'string','min' => 11, 'max' => 11],
            [['phone'], 'exist',
                'targetClass' => '\common\models\YxUser',
                'filter' => ['status' => YxUser::STATUS_ACTIVE],
                'message' => '该手机号码不存在'
            ],
            [['code'], 'string','min' => 6, 'max' => 6],
            [['code'], 'validateCode', 'message' => '请输入正确的验证码'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => '电话',
            'code' => '验证码',
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
    /**
     * Sends an phone with a link, for resetting the password.
     *
     * @return bool whether the phone was send
     */
    public function getToken()
    {
        /* @var $user YxUser */
        $user = YxUser::findOne([
            'status' => YxUser::STATUS_ACTIVE,
            'phone' => $this->phone,
        ]);

        if (!$user) {
            return null;
        }

        if (!YxUser::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return null;
            }
        }
        return $user;
    }
}
