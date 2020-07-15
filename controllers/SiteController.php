<?php

namespace app\controllers;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;


class SiteController extends CustomController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
                    'logout' => ['post', 'get'],
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index'/*, compact('model')*/);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        //$this->enableCsrfValidation = false;
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }
        $this->setMeta('Авторизация');
        $model = new LoginForm();

        /*CustomController::printr($model->scenario);
        exit;*/
        if ($model->load(Yii::$app->request->post()) && $model->login() ) {

            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $this->setMeta('Регистрация');
        $model = new SignupForm();
        $model->date_create = gmdate("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {

                Yii::$app->session->setFlash('success', 'Вам  отправлена ссылка с подтверждением Email');
                return $this->goHome();
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionConfirmemail()
    {
        $code = Yii::$app->request->get('code');
        $email = Yii::$app->request->get('email');

        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $user = User::find()->where(['code' => $code, 'email' => $email])->one();

        if($user->active == 0)
        {
            $user->code = '';
            $user->active = User::ACTIVE_USER;

            if($user->save())
            {
                Yii::$app->session->setFlash('success', 'Аккаунт активирован');
                return $this->goHome();
            }

        }
        else
        {

            Yii::$app->session->setFlash('error', 'Не удалось активировать аккаунт, обратитесь к Администрации сайта.');
            return $this->goHome();
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
