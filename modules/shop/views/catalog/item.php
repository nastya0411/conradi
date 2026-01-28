<?php

use app\models\EstimationUser;
use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->registerCssFile('@web/css/cart.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]);
?>

<div class="card h-100 text-center product-card">
    <div class="card-img-top p-2">
        <?php if ($model->id0): ?>
            <?= Html::img('/img/' . $model->id0->image, [
                'class' => 'img-fluid w-100',
                'alt' => $model->title,
                'style' => 'height: 200px; object-fit: cover;'
            ]) ?>
        <?php else: ?>
            <?= Html::img('/img/no_photo.jpg', [
                'class' => 'img-fluid w-100',
                'alt' => 'Нет фото',
                'style' => 'height: 200px; object-fit: cover;'
            ]) ?>
        <?php endif; ?>
    </div>

    <div class="card-body d-flex flex-column">
        <h5 class="card-title text-center product-title">
            <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id], [
                'class' => 'text-decoration-none text-dark'
            ]) ?>
        </h5>

        <div class="text-center text-muted small mb-2">
            <?php if ($model->category && $model->productType): ?>
                <?= Html::encode($model->category->title) ?>, <?= Html::encode($model->productType->title) ?>
            <?php elseif ($model->category): ?>
                <?= Html::encode($model->category->title) ?>
            <?php elseif ($model->productType): ?>
                <?= Html::encode($model->productType->title) ?>
            <?php else: ?>
                <span class="text-muted">Без категории</span>
            <?php endif; ?>
        </div>

        <div class="h4 text-primary text-center mb-2 price">
            <?= number_format($model->price, 0, '', ' ') ?> ₽
        </div>
            <div class="text-center mb-3">
                <span class="badge bg-secondary">
                    <?= Html::encode($model->count) ?> шт.
                </span>
            </div>

        <?php $avgRating = $model->getAverageRating(); ?>
        <?php if ($avgRating > 0): ?>
            <div class="product-rating-container-style mb-3">
                <div class="product-rating-style d-flex ">
                    <span><?= number_format($avgRating, 1) ?></span>
                    <?#= EstimationUser::widget([
                    //     'name' => 'product-rating-style' . $model->id,
                    //     'value' => $avgRating,
                    //     'pluginOptions' => [
                    //         'size' => 'xs',
                    //         'readonly' => true,
                    //         'showClear' => false,
                    //         'showCaption' => false,
                    //         'hoverEnabled' => false,
                    //         'displayOnly' => true
                    //     ]
                    // ]) ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="mt-auto">
            <div class="row g-2 justify-content-center">
                <div class="col-8">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= Html::a('В корзину', ['/site/login'], [
                            'class' => 'btn btn-outline-primary btn-sm w-100 btn-add-cart',                                
                        ]) ?>
                    <?php elseif (!Yii::$app->user->identity->isAdmin): ?>
                        <?= Html::a('В корзину', ['/shop/cart/add', 'id' => $model->id], [
                            'class' => 'btn btn-outline-primary btn-sm w-100 btn-add-cart',
                            'data-method' => 'post', 'data-pjax' => 0,
                        ]) ?>
                    <?php endif; ?>
                </div>

                <div class="col-8">
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin): ?>
                        <div class="row g-1">
                            <div class="col-6">
                                <?= Html::a('Редактировать', ['update', 'id' => $model->id], [
                                    'class' => 'btn btn-outline-warning btn-sm w-100'
                                ]) ?>
                            </div>
                        </div>
                    <?php else: ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>