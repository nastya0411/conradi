<?php

use app\models\PayType;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/account/cart/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="application-form">
    <?php Pjax::begin([
        'id' => 'form-application-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]) ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-application'
    ]); ?>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Данные для доставки</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'address')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Улица, дом, квартира'
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'date')->textInput([
                        'type' => 'date',
                        'min' => date('Y-m-d')
                    ]) ?>

                    <?= $form->field($model, 'time')->textInput([
                        'type' => 'time',
                        'min' => date('H:i')
                    ]) ?>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <?= $form->field($model, 'pay_type_id')->dropDownList(
                        PayType::getPayTypes(),
                        ['prompt' => 'Выберите тип оплаты']
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <?= Html::submitButton('Подтвердить заказ', [
        'class' => 'btn btn-outline-success'
    ]) ?>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$this->registerJsFile('/js/order.js', ['depends' => 'yii\web\YiiAsset']);
?>