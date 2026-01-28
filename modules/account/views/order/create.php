<?php
 
 use yii\bootstrap5\Html;
 
 /** @var yii\web\View $this */
 /** @var app\models\Order $model */
 
 $this->title = 'Создание заказа';
 $this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
 $this->params['breadcrumbs'][] = $this->title;
 ?>
 <div class="order-create">
 
     <h3><?= Html::encode($this->title) ?></h3>
 
     <?= $this->render('_form', [
         'model' => $model,
     ]) ?>
 
 </div>
