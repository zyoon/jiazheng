<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\UserLoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\tools\Message;
use common\models\YxBanner;
use common\models\YxActivity;
use common\models\YxRecomLeft;
use common\models\YxRecomRight;
use common\models\YxCompany;
use common\models\YxStaff;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //return $this->render('index');
        $this->getView()->title = "首页";
    		$this->layout = "layout1";
    		$YxBanner = YxBanner::find()->limit(4)->all();
    		$YxRecomLeft = YxRecomLeft::find()->limit(4)->all();
    		$YxActivity = YxActivity::find()->one();
    		$YxRecomRight = YxRecomRight::find()->one();
        // 获取地区
        $user_info = Yii::$app->user->identity;
        $YxCompany = YxCompany::find()->select(['*'])
  								->innerjoin('yx_cmp_server', 'yx_cmp_server.company_id=yx_company.id')
  									->where(['yx_company.status'=>2,'yx_company.city'=>$user_info['city']])->orderby('yx_company.total_fraction desc')->limit(4)->all();
        $YxStaff = YxStaff::find()->select(['*'])
  								->innerjoin('yx_staff_server', 'yx_staff_server.staff_id=yx_staff.staff_id')
  									->where(['yx_staff.staff_state'=>1,'yx_staff.staff_city'=>$user_info['city']])->orderby('yx_staff.staff_fraction desc')->limit(8)->all();
    		return $this->render("/index/index", [
                'YxBanner' => $YxBanner,
                'YxRecomLeft' => $YxRecomLeft,
                'YxActivity' => $YxActivity,
                'YxRecomRight' => $YxRecomRight,
                'YxCompany' => $YxCompany,
                'YxStaff' => $YxStaff
            ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionGetsignupcode(){
      $code = -1;
      $msg = "请勿频繁发送";
      Yii::$app->response->format = 'json';
      if(Yii::$app->request->isAjax) {
          $params = Yii::$app->request->post();
          if(!isset($params['phone']) || strlen($params['phone']) != 11){
              $msg = "电话号码不正确";
              return [ 'msg' => $msg, 'code' => $code];
          }
          $result = Message::SendSignUpCodeMessage($params['phone']);
          if($result){
              $code =  0;
              $msg = "ok";
          }
      }
      Yii::$app->response->format = 'json';
      return [ 'msg' => $msg, 'code' => $code];
    }

    public function actionGetresetpwdcode(){
      $code = -1;
      $msg = "请勿频繁发送";
      Yii::$app->response->format = 'json';
      if(Yii::$app->request->isAjax) {
          $params = Yii::$app->request->post();
          if(!isset($params['phone']) || strlen($params['phone']) != 11){
              $msg = "电话号码不正确";
              return [ 'msg' => $msg, 'code' => $code];
          }
          $result = Message::SendResetPwdCodeMessage($params['phone']);
          if($result){
              $code =  0;
              $msg = "ok";
          }
      }
      return [ 'msg' => $msg, 'code' => $code];
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $model->getToken();
            if ($user != null) {
                return $this->redirect('reset-password?token='.$user->password_reset_token);
            } else {
                Yii::$app->session->setFlash('error', '验证失败');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
