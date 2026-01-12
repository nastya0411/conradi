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
        $model = new \app\models\RegisterForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $user = new User();
                $user->load($model->attributes, '');              

                $user->role_id = Role::getRoleId('user');
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->password = Yii::$app->security->generatePasswordHash($user->password);
                if ($user->save()) {
                    // var_dump('Пользователь сохранен, ID:', $user->id);
                    // die;
                    Yii::$app->session->setFlash('success', 'Пользователь успешно зарегестрирован!');
                    return $this->redirect('/account');
                } else {
                    var_dump('Ошибки при сохранении:', $user->errors);
                }
            } else {
                var_dump('Ошибки валидации:', $user->errors);
            }
            die();
        }


        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
