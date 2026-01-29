<?php
/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\bootstrap5\BootstrapAsset;

$this->title = 'Конради';
$this->registerCssFile('@web/css/home.css', ['depends' => [BootstrapAsset::class]]);
?>

<div class="site-index">


<!-- Герой-секция с летающими розами -->
<div class="container-fluid p-0">
    <div class="fullscreen-hero">
        <!-- Летающие розы разных размеров -->
        <div class="flying-roses">
            <!-- Большие розы -->
            <div class="flying-rose rose-large rose-1"></div>
            <div class="flying-rose rose-huge rose-2"></div>
            
            <!-- Средние розы -->
            <div class="flying-rose rose-medium rose-3"></div>
            <div class="flying-rose rose-medium rose-4"></div>
            <div class="flying-rose rose-medium rose-5"></div>
            
            <!-- Маленькие розы -->
            <div class="flying-rose rose-small rose-6"></div>
            <div class="flying-rose rose-small rose-7"></div>
            <div class="flying-rose rose-small rose-8"></div>
            
            <!-- Крошечные розы -->
            <div class="flying-rose rose-tiny rose-9"></div>
            <div class="flying-rose rose-tiny rose-10"></div>
            <div class="flying-rose rose-tiny rose-11"></div>
            <div class="flying-rose rose-tiny rose-12"></div>
        </div>
        
        <!-- Контент -->
        <div class="hero-container">
            <h1 class="hero-title">Конради</h1>
            <p class="hero-subtitle">Превращаем ваши чувства в цветы</p>
            <?= Html::a('Каталог', ['/shop/catalog/index'], ['class' => 'hero-btn']) ?>
        </div>
    </div>
</div>

</div>

    <!-- Карусель с бордовой обводкой -->
    <section class="carousel-section">
        <div id="mainCarousel" class="carousel slide premium-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators premium-indicators">
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" 
                        aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" 
                        aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" 
                        aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img src="/web/img/1.png" class="d-block w-100" alt="Букет роз">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="/web/img/2.png" class="d-block w-100" alt="Свадебный букет">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img src="/web/img/3.png" class="d-block w-100" alt="Экзотические цветы">
                </div>
            </div>
            <button class="carousel-control-prev premium-control" type="button" data-bs-target="#mainCarousel" 
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next premium-control" type="button" data-bs-target="#mainCarousel" 
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Блок "О нас" -->
    <section class="about-section">
        <div class="container">
            <h2 class="section-title">О нас</h2>
            <div class="about-content">
                <p class="about-text">
                    Сеть салонов «Конради» уже двадцать пять лет вместе с вами. Главное для нас — ваши позитивные эмоции, 
                    ведь нет более сильной мотивации для развития компании, чем улыбки благодарных клиентов.
                </p>
                <p class="about-text">
                    Спрос рождает предложение, и мы, расширяя с каждым годом круг возможностей, развили несколько направлений. 
                    Сегодня «Конради» — это разнообразие букетов и композиций, свадебное оформление, 
                    декор праздничных событий, быстрая доставка, ландшафтный дизайн — и всё это благодаря нашим любимым покупателям.
                </p>
                <div class="about-image-container">
                    <img src="/web/img/4.png" class="about-image" alt="Наша команда">
                </div>
            </div>
        </div>
    </section>

    <!-- Блок "Отзывы" -->
    <section class="reviews-section">
        <div class="container">
            <h2 class="reviews-title">Отзывы клиентов</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-header">
                            <img src="/web/img/5.png" class="review-avatar" alt="Анна">
                            <div class="review-info">
                                <h4>Анна</h4>
                                <span>15 января 2024</span>
                            </div>
                        </div>
                        <p class="review-text">
                            Заказывала букет на годовщину свадьбы. Цветы были свежие, доставка вовремя. 
                            Муж был в восторге! Обязательно буду заказывать снова.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-header">
                            <img src="/web/img/5.png" class="review-avatar" alt="Михаил">
                            <div class="review-info">
                                <h4>Михаил</h4>
                                <span>10 февраля 2024</span>
                            </div>
                        </div>
                        <p class="review-text">
                            Заказал свадебное оформление. Все было сделано безупречно! 
                            Команда профессионалов, которые чувствуют каждую деталь. 
                            Спасибо Конради за наш идеальный день!
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-header">
                            <img src="/web/img/5.png" class="review-avatar" alt="Елена">
                            <div class="review-info">
                                <h4>Елена</h4>
                                <span>5 марта 2024</span>
                            </div>
                        </div>
                        <p class="review-text">
                            Пользуюсь услугами Конради уже более 5 лет. Всегда свежие цветы, 
                            креативные букеты и вежливые сотрудники. Рекомендую всем!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
$this->registerJs(<<<JS
// Плавная прокрутка
$(document).on('click', '.hero-btn', function(e) {
    if(this.hash === '#catalog') {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('.carousel-section').offset().top
        }, 1000);
    }
});
JS
);
?>