<?php
include('config.php');
// Получаем ВСЕ товары из базы (БЕЗ LIMIT)
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
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
    <a href="index.php">Главная</a>
    <a href="#catalog">Каталог</a>
  </nav>
</header>

<div class="backdrop" hidden></div>

<main>
  <section id="catalog" class="products container">
    <h2>Каталог товаров</h2>
    <div class="product-grid">
      <?php foreach ($products as $product): ?>
        <div class="product-card">
          <img src="<?= $product['image_path'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
          <h3><?= htmlspecialchars($product['name']) ?></h3>
          <div class="price">₽<?= number_format($product['price'], 2) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <!-- Кнопка возврата на главную -->
    <div style="text-align: center; margin-top: 3rem;">
      <a href="index.php" class="cta" style="text-decoration: none;">
        ← Назад на главную
      </a>
    </div>
  </section>
</main>

<footer class="footer">
  <nav class="footer__nav">
    <a href="index.php">Главная</a>
    <a href="catalog.php">Каталог</a>
  </nav>

  <div class="footer__info">
    <div><strong>📍 Адрес:</strong> г. Санкт-Петербург, ул. Примерная, д. 10</div>
    <div><strong>📞 Телефон:</strong> +7 (999) 123‑45‑67</div>
    <div><strong>🕒 Время работы:</strong> ежедневно с 08:00 до 22:00</div>
  </div>

  <div class="footer__social">
    <span>Мы в соцсетях:</span>
    <a href="https://t.me/BazaRRstore_bot" target="_blank" class="footer__social-link">
      <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" 
           alt="Telegram" class="footer__icon">
    </a>
  </div>

  <div class="footer__bottom">
    <a href="https://api.kokodjam.ru/" target="_blank" style="text-decoration: none; color: black;">Создан kokodjam</a>
  </div>
</footer>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="scripts/main.js"></script>
</body>
</html>