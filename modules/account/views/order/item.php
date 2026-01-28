<?php

use app\models\Status;
use yii\bootstrap5\Html;

$this->registerCssFile('@web/css/card-style.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]);

?>

<div class="card mb-4 mt-4 text-black">
    <div class="card-header fw-semibold fs-5 text-bold">
        Заказ № <?= $model->id ?> от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s') ?>
    </div>
    <div class="card-body">
        <h5 class="card-title">
            Дата и время получения: <?= Yii::$app->formatter->asDatetime($model->date_time, 'php:d.m.Y H:i:s') ?>
        </h5>
        <h5 class="card-title">
            Статус заказа: <?= Status::getStatuses()[$model->status_id] ?? 'Не указан' ?>
        </h5>
        <p class="card-text">Количество товаров: <?= $model->amount ?> шт.</p>
        <p class="card-text">Сумма заказа: <?= Yii::$app->formatter->asDecimal($model->total, 2) ?> ₽</p>
        <div class="d-flex justify-content-end">
            <?= Html::a('Просмотреть заказ', 
                ['view', 'id' => $model->id],
                ['class' => 'btn btn-outline-primary fw-semibold text-bold']
            ) ?>
        </div>
    </div>
</div>