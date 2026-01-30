<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
            </div>
            
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="login-card p-4 p-lg-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-bold'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <div class="mb-4">
                        <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"form-check\">{input} {label}</div>\n<div>{error}</div>",
                        ]) ?>
                    </div>

                    <div class="form-group text-center mt-4">
                        <?= Html::submitButton('Вход', ['class' => 'btn btn-primary btn-lg w-100 mb-3', 'name' => 'login-button']) ?>
                        
                        <?= Html::a('Еще не зарегистрированы? Регистрация', 'register', [
                            'class' => 'd-block text-center text-decoration-none mt-3'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    
                    <div class="help-text text-center mt-3 pt-4">
                        <small>Тестовые пользователи:</small>
                        <div class="mt-2">
                            <code>User12 / Password12</code><br>
                            <code>Admin12 / Adminka12</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>