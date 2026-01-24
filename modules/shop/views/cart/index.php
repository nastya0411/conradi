<?php

use app\models\Cart;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\shop\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;

// Находим корзину текущего пользователя
$cart = Cart::findOne(['user_id' => Yii::$app->user->id]);
?>
<div class="cart-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin([
        'id' => 'cart-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <?php if ($dataProvider->totalCount): ?>
        <div class="d-flex justify-content-end mb-3">
            <?= Html::a('Очистить корзину', ['clear', 'id' => $cart->id], [
                'class' => 'btn btn-red-style btn-cart-clear',
                'data-pjax' => 0,
                'data-method' => 'post',
                'data-confirm' => 'Вы уверены, что хотите очистить корзину?'
            ]) ?>
        </div>
        
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item',
            'layout' => '{items}'
        ]) ?>
        
        <div class="border-white border-top border-2 py-3 order-total fw-bold fs-3">
            <div class="row align-items-center">
                <!-- Блок с текстом -->
                <div class="col-md-3">
                    Итого:
                </div>

                <!-- Количество товара -->
                <div class="col-md-3 text-center">
                    <?= $cart->amount ?> шт.
                </div>

                <!-- Сумма -->
                <div class="col-md-6 text-end">
                    <?= Yii::$app->formatter->asDecimal($cart->cost, 2) ?> ₽
                    <div class="text-end mt-3">
                        <?= Html::a('Оформить заказ', ['order/create', 'cart_id' => $cart->id], [
                            'class' => 'btn btn-orange-style btn-order-create'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-success alert-cart-empty" role="alert">
            Ваша корзина пуста!
        </div>
        <div class="text-center mt-3">
            <?= Html::a('Перейти в каталог', ['catalog/index'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif ?>

    <?php Pjax::end(); ?>

</div>