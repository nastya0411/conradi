<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use app\models\Role;
use app\models\User;
use yii\bootstrap5\ActiveForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Вы успешно авторизованы!');
            return  Yii::$app->user->identity->isAdmin
                ? $this->redirect('/admin')
                : $this->redirect('/account');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Вы успешно вышли из системы!');

        return $this->goHome();
    }


public function actionRegister()
{
    if (!Yii::$app->user->isGuest) {
        return $this->goHome();
    }

    $model = new \app\models\RegisterForm();
    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            $user = new User();
            $user->load($model->attributes, '');              

            $user->role_id = Role::getRoleId('user');
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->password = Yii::$app->security->generatePasswordHash($user->password);
            
            if ($user->save()) {
                $duration = 3600 * 24 * 30; // 30 дней
                Yii::$app->user->login($user, $duration);
                
                Yii::$app->session->setFlash('success', 'Регистрация успешно завершена! Вы вошли в систему.');
                return Yii::$app->user->identity->isAdmin
                    ? $this->redirect('/admin')
                    : $this->redirect('/account');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при сохранении пользователя.');
                Yii::error('Ошибки при сохранении: ' . print_r($user->errors, true));
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка валидации данных.');
        }
    }

    return $this->render('register', [
        'model' => $model,
    ]);
}
}
