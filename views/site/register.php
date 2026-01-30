<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\RegisterForm $model */

use app\models\Gender;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-register">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
            </div>
            
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="register-card p-4 p-lg-5">
                    <?php $form = ActiveForm::begin([
                        'id' => 'register-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-bold'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <div class="mb-4">
                        <?= $form->field($model, 'full_name')->textInput([
                            'autofocus' => true,
                            'placeholder' => 'Введите ФИО'
                        ]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                            'mask' => '8(999)999-99-99',
                            'options' => [
                                'class' => 'form-control',
                                'placeholder' => '8(999)999-99-99'
                            ]
                        ]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'login', ['enableAjaxValidation' => true])->textInput([
                            'placeholder' => 'Придумайте логин'
                        ]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'password')->passwordInput([
                            'placeholder' => 'Придумайте пароль'
                        ]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'birthday')->input('date', [
                            'max' => date('Y-m-d'),
                            'min' => date('Y-m-d', strtotime('-100 years')),
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'rule')->checkbox([
                            'template' => "<div class=\"form-check\">{input} {label}</div>\n<div>{error}</div>",
                            'label' => 'Я согласен(а) на обработку персональных данных',
                            'labelOptions' => ['class' => 'form-check-label']
                        ]) ?>
                    </div>

                    <div class="form-group text-center mt-4">
                        <?= Html::submitButton('Зарегистрироваться', [
                            'class' => 'btn btn-primary btn-lg w-100 mb-3',
                            'name' => 'register-button'
                        ]) ?>
                        
                        <?= Html::a('Уже есть аккаунт? Авторизация', ['site/login'], [
                            'class' => 'd-block text-center text-decoration-none mt-3'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>