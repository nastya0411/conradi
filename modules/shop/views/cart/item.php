<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var array $model */

// Цена товара из product
$productPrice = $model['product_current_price'] ?? 0;

// Если в cart_item.cost хранится не цена, а что-то другое,
// будем использовать product.price
$pricePerItem = $productPrice;
$itemTotal = $pricePerItem * $model['item_amount'];
?>

<div class="cart-item border-bottom pb-3 mb-3" data-cart-item-id="<?= $model['item_id'] ?>">
    <div class="row align-items-center">
        <!-- Изображение товара -->
        <div class="col-3 col-md-2">
            <?php if (!empty($model['product_photo'])): ?>
                <?= Html::img('/img/' . $model['product_photo'], [
                    'class' => 'img-fluid rounded',
                    'alt' => $model['product_title'],
                    'style' => 'width: 80px; height: 80px; object-fit: cover;'
                ]) ?>
            <?php else: ?>
                <?= Html::img('/img/no_photo.jpg', [
                    'class' => 'img-fluid rounded',
                    'alt' => 'Нет фото',
                    'style' => 'width: 80px; height: 80px; object-fit: cover;'
                ]) ?>
            <?php endif; ?>
        </div>
        
        <!-- Информация о товаре -->
        <div class="col-5 col-md-6">
            <h6 class="mb-1">
                <?= Html::a(Html::encode($model['product_title']), 
                    ['catalog/view', 'id' => $model['product_id']], 
                    ['class' => 'text-decoration-none']
                ) ?>
            </h6>
            <div class="text-primary fw-bold mb-1">
                <?= number_format($productPrice, 0, '', ' ') ?> ₽ / шт.
            </div>
            <?php if (isset($model['product_count'])): ?>
                <div class="text-success small">
                    На складе: <?= $model['product_count'] ?> шт.
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Управление количеством и сумма -->
        <div class="col-4 col-md-4">
            <div class="d-flex align-items-center justify-content-end mb-2">
                <!-- Кнопка уменьшения (-) -->
                <?= Html::a('-', ['item-del', 'id' => $model['product_id']], [
                    'class' => 'btn btn-outline-secondary btn-sm btn-item-del',
                    'data-method' => 'post',
                    'data-pjax' => 0,
                    'title' => 'Уменьшить',
                    'style' => 'width: 36px;'
                ]) ?>
                
                <!-- Количество -->
                <div class="mx-2 fw-bold" style="min-width: 40px; text-align: center;">
                    <?= $model['item_amount'] ?> шт.
                </div>
                
                <!-- Кнопка увеличения (+) - ЗЕЛЕНАЯ -->
                <?= Html::a('+', ['item-add', 'id' => $model['item_id']], [
                    'class' => 'btn btn-outline-success btn-sm btn-item-add',
                    'data-method' => 'post',
                    'data-pjax' => 0,
                    'title' => 'Увеличить',
                    'style' => 'width: 36px;'
                ]) ?>
                
                <!-- Кнопка "Удалить" -->
                <?= Html::a('Удалить', ['item-remove', 'id' => $model['item_id']], [
                    'class' => 'btn btn-outline-danger btn-sm btn-item-remove ms-2',
                    'data-method' => 'post',
                    'title' => 'Удалить',
                    'data-confirm' => 'Удалить товар из корзины?'
                ]) ?>
            </div>
            
            <!-- Итого за позицию -->
            <div class="text-end">
                <div class="fw-bold fs-5 text-primary">
                    <?= number_format($itemTotal, 0, '', ' ') ?> ₽
                </div>
                <div class="text-muted small">
                    <?= number_format($productPrice, 0, '', ' ') ?> × <?= $model['item_amount'] ?> шт.
                </div>
            </div>
        </div>
    </div>
</div>