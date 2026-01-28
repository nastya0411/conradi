<?php

use app\models\Category;
use app\models\ProductType;
use yii\bootstrap5\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="product-view container mt-4" id="view-product">
    <p>
        <?= Html::a('Назад', ['/shop'], ['class' => 'btn btn-outline-info']) ?>
    </p>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <?php if ($model->id0): ?>
                        <div class="text-center">
                            <?= Html::img('/img/' . $model->id0->image, [
                                'class' => 'img-fluid',
                                'alt' => $model->title,
                                'style' => 'max-height: 400px;'
                            ]) ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted">
                            <?= Html::img('/img/no_photo.jpg', [
                                'class' => 'img-fluid',
                                'alt' => 'Нет фото',
                                'style' => 'max-height: 300px;'
                            ]) ?>
                            <p class="mt-2">Нет изображения</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title"><?= Html::encode($model->title) ?></h1>
                    
                    <div class="mb-3">
                        <h3 class="text-primary"><?= number_format($model->price, 0, '', ' ') ?> ₽</h3>
                    </div>

                    <div class="mb-4">
                        <h5>Описание товара:</h5>
                        <p class="card-text"><?= nl2br(Html::encode($model->desciption)) ?></p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Категория:</strong><br>
                                <?= $model->category ? Html::encode($model->category->title) : 'Не указана' ?>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Тип товара:</strong><br>
                                <?= $model->productType ? Html::encode($model->productType->title) : 'Не указан' ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Количество на складе:</strong><br>
                                <?= Html::encode($model->count) ?> шт.
                            </div>
                            
                            <div class="mb-3">
                                <strong>Рейтинг:</strong><br>
                                <?= Html::encode($model->stars) ?> / 5
                            </div>
                        </div>
                    </div>

                    <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
                        <div class="d-grid gap-2 mb-4">
                            <?= Html::a('В корзину', ['/shop/cart/add', 'id' => $model->id], [
                                'class' => 'btn btn-primary btn-lg btn-add-cart',
                                'data-method' => 'post'
                            ]) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <?= DetailView::widget([
                    'model' => $model,
                    'options' => [
                        'class' => 'table table-bordered',
                    ],
                    'attributes' => [
                        [
                            'attribute' => 'category_id',
                            'value' => $model->category ? $model->category->title : null,
                            'label' => 'Категория',
                        ],
                        [
                            'attribute' => 'product_type_id',
                            'value' => $model->productType ? $model->productType->title : null,
                            'label' => 'Тип товара',
                        ],
                        'title',
                        'stars',
                        [
                            'attribute' => 'price',
                            'value' => number_format($model->price, 0, '', ' ') . ' ₽',
                        ],
                        [
                            'attribute' => 'desciption',
                            'format' => 'ntext',
                            'label' => 'Описание',
                        ],
                        'count',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>