<?php
 
 use app\models\Order;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
 use yii\helpers\Url;
 use yii\grid\ActionColumn;
 use yii\widgets\ListView;
 use yii\widgets\Pjax;
 /** @var yii\web\View $this */
 /** @var yii\data\ActiveDataProvider $dataProvider */
 
 $this->title = 'Панель управления';
 $this->params['breadcrumbs'][] = $this->title;
 ?>
 <div class="application-index">
 
     <h3><?= Html::encode($this->title) ?></h3>
 
     <?php Pjax::begin(); ?>
     <p>
     <?= Html::a('Интернет-магазин', ['/admin/default/index'], ['class' => 'btn btn-outline-primary'])?>
     </p>
 
     <?= ListView::widget([
         'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => '{pager}<div class="card-style">{items}</div>{pager}'],
        'itemView' => 'item',
        'pager' => ['class' => LinkPager::class]
     ]) ?>
 
     <?php Pjax::end(); ?>
 
 </div>