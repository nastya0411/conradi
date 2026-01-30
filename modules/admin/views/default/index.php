<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

?>
<h3>Панель управления интернет-магазином</h3>
<p>
    <?= Html::a('Продукт', ['/admin/product/index'], ['class' => 'btn btn-outline-primary']) ?>
    <?= Html::a('Категории', ['/admin/category/index'], ['class' => 'btn btn-outline-primary']) ?>
    <?= Html::a('Тип товаров', ['/admin/product-type/index'], ['class' => 'btn btn-outline-primary']) ?>

</p>