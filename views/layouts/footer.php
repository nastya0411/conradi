<?php

use yii\bootstrap5\Html;

?>

<footer id="footer" class="app-footer">
    <div class="footer-animation-bar"></div>

    <div class="container py-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-4 mb-4">
            <nav class="footer-nav d-flex flex-wrap gap-4">
                <?= Html::a('Главная', ['/site/index'], ['class' => 'footer-link']) ?>
                <?= Html::a('Каталог', ['/shop'], ['class' => 'footer-link']) ?>
            </nav>

            <div class="footer-contacts">
                Контакты: <br>
                <?= Html::a('+7 928 282-82-82', 'tel:+79282828282', ['class' => 'footer-contact-link']) ?> <br>
                <?= Html::mailto('info@konradi.ru', 'info@konradi.ru') ?> <br>
                Адрес: Невский проспект, 55, Санкт-Петербург
            </div>
        </div>

        <div class="footer-map mb-4">
            <iframe
                src="https://yandex.ru/map-widget/v1/?ll=30.350184%2C59.932031&pt=30.350184%2C59.932031&z=16&l=map&size=500%2C300"
                width="100%"
                height="200"
                frameborder="0"
            ></iframe>
        </div>

        <div class="footer-copyright">
            <span class="copyright-text">2026 Конради. Все права защищены</span>
        </div>
    </div>
</footer>