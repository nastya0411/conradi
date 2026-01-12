<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\OrderSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'pay_type_id') ?>

    <?= $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'date_time') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'pay_receipt') ?>

    <?php // echo $form->field($model, 'total') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
