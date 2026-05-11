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
$this->registerCssFile('/css/flatpickr.min.css');
$this->registerJsFile('/js/flatpickr.min.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerJsFile('/js/ru.js', ['depends' => 'yii\web\YiiAsset']);
?>
<div class="application-form">
    <?php Pjax::begin([
        'id' => 'form-application-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]) ?>
    <?php $form = ActiveForm::begin([
        'id' => 'form-application',
        'enableAjaxValidation' => true,
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
                        'placeholder' => 'Улица, дом, квартира',
                        'id' => 'address-input',
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'date')->textInput([
                        'id' => 'order-date',
                        'placeholder' => 'дд.мм.гггг',
                        'autocomplete' => 'off'
                    ]) ?>

                    <?= $form->field($model, 'time')->textInput([
                        'id' => 'order-time',
                        'placeholder' => 'чч:мм',
                        'autocomplete' => 'off'
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'pay_type_id')->dropDownList(
                        PayType::getPayTypes(),
                        [
                            'prompt' => 'Выберите тип оплаты',
                            'class' => 'form-control'
                        ]
                    ) ?>
                </div>
            </div>
        </div>
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
<?php
$this->registerJs("
    // 1. Инициализация адреса
    const addressInput = document.getElementById('address-input');
    if (addressInput) {
        addressInput.addEventListener('input', function() {
            let pos = this.selectionStart;
            let val = this.value;
            let newVal = val.replace(/([^,])\s([а-яёa-zA-Z\d])/gi, '\$1, \$2');
            if (newVal !== val) {
                this.value = newVal;
                this.selectionStart = this.selectionEnd = pos + (newVal.length - val.length);
            }
        });
    }

    // 2. Инициализация ДАТЫ
    if (window.fpInstance) {
        window.fpInstance.destroy();
    }

    window.fpInstance = flatpickr('#order-date', {
        locale: 'ru',
        dateFormat: 'd.m.Y',
        minDate: 'today',
        maxDate: new Date().fp_incr(90),
        disableMobile: true,
        allowInput: true,
    });

    // 3. Инициализация ВРЕМЕНИ (теперь тоже flatpickr)
    const timeInput = document.getElementById('order-time');
    if (timeInput) {
        if (window.fpTimeInstance) {
            window.fpTimeInstance.destroy();
        }

window.fpTimeInstance = flatpickr(timeInput, {
    locale: 'ru',
    enableTime: true,
    noCalendar: true,
    dateFormat: 'H:i',
    time_24hr: true,
    minuteIncrement: 15,
    minTime: '09:00',
    maxTime: '21:00',
    defaultHour: 12,
    disableMobile: true,
    allowInput: true,
});
    }
");
?>