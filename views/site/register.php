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
$this->registerCssFile('/css/flatpickr.min.css');
$this->registerJsFile('/js/flatpickr.min.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerJsFile('/js/ru.js', ['depends' => 'yii\web\YiiAsset']);
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
                        <?= $form->field($model, 'login')->textInput([
                            'placeholder' => 'Придумайте логин'
                        ]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'password')->passwordInput([
                            'placeholder' => 'Придумайте пароль'
                        ]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'birthday', [
                            'template' => "{label}\n<div class=\"input-group\">{input}<button type=\"button\" class=\"calendar-btn\" id=\"calendar-icon\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><rect x=\"3\" y=\"4\" width=\"18\" height=\"18\" rx=\"2\" ry=\"2\"></rect><line x1=\"16\" y1=\"2\" x2=\"16\" y2=\"6\"></line><line x1=\"8\" y1=\"2\" x2=\"8\" y2=\"6\"></line><line x1=\"3\" y1=\"10\" x2=\"21\" y2=\"10\"></line></svg></button></div>\n{error}",
                        ])->widget(MaskedInput::class, [
                            'mask' => '99.99.9999',
                            'options' => [
                                'id' => 'birthday-input',
                                'class' => 'form-control',
                                'placeholder' => 'дд.мм.гггг',
                                'autocomplete' => 'off',
                            ]
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
                        <?= Html::submitButton('Регистрация', [
                            'class' => 'btn btn-primary btn-lg w-100 mb-3',
                            'name' => 'register-button'
                        ]) ?>

                        <?= Html::a('Уже есть аккаунт? <br> Авторизация', ['site/login'], [
                            'class' => 'd-block text-center text-decoration-none mt-3 '
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$this->registerJs("
    let maxDate = new Date();
    maxDate.setFullYear(maxDate.getFullYear() - 14);
    let minDate = new Date();
    minDate.setFullYear(minDate.getFullYear() - 100);

    window.fpInstance = flatpickr('#birthday-input', {
        locale: 'ru',
        dateFormat: 'd.m.Y',
        maxDate: maxDate,
        minDate: minDate,
        disableMobile: true,
        allowInput: true,
        clickOpens: false,        // клик на поле НЕ открывает календарь — только иконка
        onReady: function(selectedDates, dateStr, instance) {
            instance.input.removeAttribute('readonly');
            document.getElementById('calendar-icon').addEventListener('click', function() {
                instance.open();
            });
        },
        onClose: function(selectedDates, dateStr, instance) {
            instance.input.removeAttribute('readonly');
        },
    });
");
?>