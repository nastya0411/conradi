<?php

use yii\bootstrap5\Html;
?>

<footer id="footer" style="position: fixed; left: 0; bottom: 40px; width: 100%; z-index: 1030;">
    <div class="container py-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-4 mb-4">
            <nav class="footer-nav d-flex flex-wrap gap-4">
                <?= Html::a('Главная', ['/site/index'], ['class' => 'footer-link']) ?>
                <?= Html::a('Каталог', ['/shop'], ['class' => 'footer-link']) ?>
            </nav>

            <div class="footer-contacts">
                Контакты: <br>
                <?= Html::a('+7 928 282-82-82', 'tel:+79282828282', ['class' => 'footer-contact-link']) ?> <br>

            </div>
        </div>

        <div class="footer-copyright">2026 Конради. Все права защищены</div>
    </div>
</footer>