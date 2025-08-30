<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BazaRR — Свежие овощи и фрукты</title>
  <!-- Preload основных стилей -->
  <link rel="preload" href="styles/base.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <link rel="preload" href="styles/layout.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/layout.css">
  </noscript>
  
  <!-- Отложенная загрузка остальных стилей -->
  <link rel="stylesheet" href="styles/components.css" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="styles/media.css" media="print" onload="this.media='all'">
  
  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
</head>
<body>
<header class="header">
  <div class="header-left">
    <button class="burger" aria-label="Открыть меню" aria-expanded="false">
      <span class="burger-line"></span>
      <span class="burger-line"></span>
      <span class="burger-line"></span>
    </button>
    <div class="logo">
      <img src="assets/icons/landing_logo_x2.jpg" alt="Bazarr" style="height: 32px; margin-right: 0.5rem;" loading="lazy" />
      BazaRR.
    </div>
  </div>

  <nav class="nav-links">
    <a href="#home">Главная</a>
    <a href="#catalog">Каталог</a>
    <a href="#reviews">Отзывы</a>
    <a href="#location">Как добраться</a>
  </nav>
</header>

<div class="backdrop" hidden></div>

<main>
  <section id="home" class="hero container reval">
    <div class="hero-text">
      <h1>BazaRR — только свежее</h1>
      <p>Откройте для себя свежие овощи и фрукты.</p>
      <button class="cta" onclick="document.getElementById('catalog').scrollIntoView({ behavior: 'smooth' })">
          Перейти в каталог
      </button>
    </div>
    <div class="hero-image">
      <img src="assets/images/hero.png" alt="Пакет с продуктами" loading="lazy" />
    </div>
  </section>

  <section id="catalog" class="products container">
    <h2>Популярные товары</h2>
    <div class="product-grid">
      <?php
      include('config.php');
      
      try {
          $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
          $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          if (count($products) > 0) {
              foreach ($products as $product): ?>
                  <div class="product-card">
                      <img src="<?= $product['image_path'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
                      <h3><?= htmlspecialchars($product['name']) ?></h3>
                      <div class="price">₽<?= number_format($product['price'], 2) ?></div>
                  </div>
              <?php endforeach;
          } else {
              echo '
              <div class="product-card">
                  <img src="assets/images/placeholder.jpg" alt="Товаров пока нет" loading="lazy">
                  <h3>Товаров пока нет</h3>
                  <div class="price">Добавьте товары в админке</div>
              </div>
              ';
          }
          
      } catch (PDOException $e) {
          echo '
          <div class="product-card">
              <img src="assets/images/placeholder.jpg" alt="Ошибка загрузки" loading="lazy">
              <h3>Ошибка загрузки товаров</h3>
              <div class="price">Попробуйте позже</div>
          </div>
          ';
      }
      ?>
    </div>
    
    <div style="text-align: center; margin-top: 3rem;">
      <a href="catalog.php" class="cta" style="text-decoration: none;">
        Смотреть весь каталог
      </a>
    </div>
  </section>

  <section id="reviews" class="reviews container">
    <div class="reviews-widget">
      <iframe src="https://yandex.ru/maps-reviews-widget/101125564764?comments" loading="lazy"></iframe>
      <a href="https://yandex.ru/maps/org/bazarr/101125564764/" target="_blank" class="reviews-link">
        BazaRR на карте Санкт‑Петербурга — Яндекс Карты
      </a>
    </div>
  </section>

  <section id="location" class="location container">
    <div class="map-widget">
      <iframe src="https://yandex.ru/map-widget/v1/org/bazarr/101125564764/?ll=30.372902%2C59.752825&z=16" allowfullscreen loading="lazy"></iframe>
    </div>
  </section>
</main>

<footer class="footer">
  <nav class="footer__nav">
    <a href="#home">Главная</a>
    <a href="#catalog">Каталог</a>
    <a href="#reviews">Отзывы</a>
    <a href="#location">Контакты</a>
  </nav>

  <div class="footer__info">
    <div><strong>📍 Адрес:</strong> г. Санкт-Петербург, Образцовая ул., 5, корп. 2, территория Пулковское</div>
    <div><strong>📞 Телефон:</strong> +7 (906) 226‑03‑33</div>
    <div><strong>🕒 Время работы:</strong> ежедневно с 09:00 до 21:00</div>
  </div>

  <div class="footer__social">
    <span>Мы в соцсетях:</span>
    <a href="https://t.me/BazaRRstore_bot" target="_blank" class="footer__social-link">
      <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" 
           alt="Telegram" class="footer__icon" loading="lazy">
    </a>
  </div>

  <div class="footer__bottom">
    <a href="https://api.kokodjam.ru/" target="_blank" style="text-decoration: none; color: black;">Создан kokodjam</a>
  </div>
</footer>

<script>
  // Загружаем некритичные стили после загрузки страницы
  window.addEventListener('load', function() {
    // Активируем отложенные стили
    var links = document.querySelectorAll('link[media="print"]');
    links.forEach(function(link) {
      link.media = 'all';
    });
    
    // Динамически подключаем шрифт (после загрузки страницы)
    var fontLink = document.createElement('link');
    fontLink.href = 'https://fonts.cdnfonts.com/css/pt-root-ui';
    fontLink.rel = 'stylesheet';
    document.head.appendChild(fontLink);
  });
</script>

<script src="scripts/main.js"></script>
</body>
</html>