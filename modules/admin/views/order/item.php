<?php

use app\models\Status;
use yii\bootstrap5\Html;

?>

<div class="card mb-4">
  <div class="card-header fw-semibold fs-5 text-bold border-bordo text-bordo">
        № <?= $model->id ?> от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i:s') ?>
        <h5 class="card-title">Клиент: <?= $model->user->full_name ?></h5>
    </div>
    <div class="card-body text-black" >
        <h5 class="card-title">Дата и время получения заказа: <?= Yii::$app->formatter->asDate($model->date_time, 'php:d.m.Y') . ' ' . $model->time ?></h5>
        <h5 class="card-title">Статус заказа: <?= $model->status->title ?></h5>
        <p class="card-text">Количество товаров: <?= $model->amount ?> </p>
        <p class="card-text">Сумма заказа: <?= $model->total ?> Р </p>
        <div class="d-flex justify-content-start gap-2">

            <?= $model->status_id == Status::getStatusId('Оплачен оффлайн')
                ? Html::a('Выдача заказа', ['apply', 'id' => $model->id], ['class' =>
                'btn btn-orange-last', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>


            <?= $model->status_id == Status::getStatusId('Создан')
                ? Html::a('В сборку', ['work', 'id' => $model->id], ['class' =>
                'btn btn-orange-last', 'data-method' => 'post', 'data-pjax' => 0])
                . Html::a('Отменить', ['cancel', 'id' => $model->id], ['class' =>
                'btn btn-red', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>

            <?= $model->status_id == Status::getStatusId('Оплачен онлайн')
                ? Html::a('В сборку', ['work', 'id' => $model->id], ['class' =>
                'btn btn-orange-last', 'data-method' => 'post', 'data-pjax' => 0])
                . Html::a('Отменить', ['cancel', 'id' => $model->id], ['class' =>
                'btn btn-red', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>

            <?= $model->status_id == Status::getStatusId('Ожидает оплаты')
                ? Html::a('Отменить', ['cancel', 'id' => $model->id], ['class' =>
                'btn btn-red', 'data-method' => 'post', 'data-pjax' => 0])
                : ''
            ?>

            <?php
            $btn = "";
            if ($model->status_id == Status::getStatusId('В сборке')) {
                if ($model->pay_receipt) {
                    $btn = Html::a('Оплата при получении', ['paid', 'id' => $model->id], ['class' => 'btn btn-orange-last', 'data-method' => 'post', 'data-pjax' => 0]);
                } else {
                    $btn = Html::a('Доставлен', ['apply', 'id' => $model->id], ['class' => 'btn btn-orange-last', 'data-method' => 'post', 'data-pjax' => 0]);
                }
            }
            echo $btn;
            ?>



            <?= Html::a('Просмотреть заказ', ['/account/order/view', 'id' => $model->id], ['class' => 'btn btn-outline-info']) ?>
        </div>

    </div>
</div>