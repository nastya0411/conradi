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

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index pt-5">

    <h3><?= Html::encode($this->title) ?></h3>


    <?php Pjax::begin(); ?>
    <?php if ($dataProvider->totalCount): ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => '{pager}<div">{items}</div>{pager}'],
            'itemView' => 'item',
            'pager' => ['class' => LinkPager::class]
        ]) ?>
    <?php else: ?>
        <div class="mt-5">
            Заказов не обнаружено
        </div>
    <?php endif ?>

    <?php Pjax::end(); ?>

</div>