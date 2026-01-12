<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

?>
<h3>Панель управления интернет-магазином</h3>
<p>
    <?= Html::a('Продукт', ['/admin/product'], ['class' => 'btn btn-outline-success']) ?>
    <?= Html::a('Категории', ['/admin/category/index'], ['class' => 'btn btn-outline-success']) ?>
    <?= Html::a('Тип товаров', ['/admin/product_type'], ['class' => 'btn btn-outline-success']) ?>

</p>