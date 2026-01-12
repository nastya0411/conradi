<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;
use yii\web\JqueryAsset;

?>
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'Конради',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-expand-lg navbar-dark bg-dark fixed-top',
        ],
        'collapseOptions' => [
            'class' => 'justify-content-between navbar-collapse collapse',
            'id' => 'navbarCollapse'
        ],
    ]);
    ?>

    <button class="navbar-toggler ms-auto text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="d-flex flex-grow-1 justify-content-center navbar-nav">
            <div class="d-flex align-items-center gap-4">
                <?= Html::a('Главная', ['/site/index'], ['class' => 'text-light text-decoration-none']) ?>
                <?= Html::a('Каталог', ['/shop'], ['class' => 'text-light text-decoration-none']) ?>
            </div>
        </div>

        <div class="d-flex align-items-center gap-4 ms-auto">
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin): ?>
                <?= Html::a('Панель управления', ['/admin'], ['class' => 'text-light text-decoration-none']) ?>
            <?php endif; ?>

            <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
                <?= Html::a('Личный кабинет', ['/account'], ['class' => 'text-light text-decoration-none']) ?>
            <?php endif; ?>

            <?= Html::a(
                Yii::$app->user->isGuest ? 'Вход' : 'Выход (' . Yii::$app->user->identity->login . ')',
                Yii::$app->user->isGuest ? ['/site/login'] : ['/site/logout'],
                [
                    'class' => 'text-light text-decoration-none',
                    'data-method' => Yii::$app->user->isGuest ? null : 'post'
                ]
            ) ?>

            <?php if (Yii::$app->user->isGuest): ?>
                <?= Html::a('Регистрация', ['/site/register'], ['class' => 'text-light text-decoration-none']) ?>
            <?php endif; ?>

            <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin): ?>
                <div class="position-relative">
                    <?= Html::a(
                        Html::img('/img/backet.png', ['alt' => 'Корзина', 'class' => 'text-light']),
                        ['/shop/cart'],
                        ['class' => 'text-light text-decoration-none']
                    ) ?>
                    <div id="cart-item-count" class="text-white position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></div>
                </div>
                <?php $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php NavBar::end(); ?>
</header>