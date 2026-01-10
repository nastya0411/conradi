<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\RegisterForm $model */

use app\models\Gender;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\MaskedInput;
use yii\helpers\VarDumper;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

            <?= $form->field($model, 'full_name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'mask' => '8(999)999-99-99',
            ]) ?>

            <?= $form->field($model, 'login', ['enableAjaxValidation' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'birthday')->input('date', [
                'max' => date('Y-m-d'),
                'min' => date('Y-m-d', strtotime('-100 years')),
            ]) ?>

            <?= $form->field($model, 'rule')->checkbox([
                'label' => 'Я согласен(а) на обработку персональных данных',
            ]) ?>

            <div class="form-group">
                <div class="d-flex justify-content-between align-items-baseline">
                    <?= Html::a('Авторизация', ['site/login'], ['class' => 'd-flex align-self-baseline']) ?>
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>