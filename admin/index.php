<?php
session_start();
// Проверяем авторизацию
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include('../config.php');

// Получаем все товары
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - BazaRR</title>
    <style>
        body { 
            font-family: 'PT Root UI', sans-serif; 
            background: #f5f5f5; 
            margin: 0; 
            padding: 20px; 
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white; 
            padding: 2rem; 
            border-radius: 20px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
        }
        h1 { 
            color: #ff5722; 
            margin-bottom: 2rem; 
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 2rem; 
        }
        .btn { 
            padding: 10px 20px; 
            border-radius: 10px; 
            text-decoration: none; 
            color: white; 
            display: inline-block; 
            margin: 5px; 
        }
        .btn-add { 
            background: #4CAF50; 
        }
        .btn-edit { 
            background: #2196F3; 
            padding: 5px 10px; 
        }
        .btn-delete { 
            background: #f44336; 
            padding: 5px 10px; 
        }
        .btn-logout { 
            background: #9e9e9e; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 1rem; 
        }
        th, td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #eee; 
        }
        th { 
            background: #ff5722; 
            color: white; 
        }
        img { 
            max-width: 50px; 
            height: auto; 
            border-radius: 5px; 
        }
        .no-products { 
            text-align: center; 
            padding: 2rem; 
            color: #666; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Управление товарами</h1>
            <div>
                <a href="add_product.php" class="btn btn-add">+ Добавить товар</a>
                <a href="logout.php" class="btn btn-logout">Выйти</a>
            </div>
        </div>

        <?php if (count($products) > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td>
                        <?php if ($product['image_path']): ?>
                            <img src="../<?= $product['image_path'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <?php else: ?>
                            Нет изображения
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td>₽<?= number_format($product['price'], 2) ?></td>
                    <td>
                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-edit">✏️</a>
                        <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-delete" onclick="return confirm('Удалить этот товар?')">❌</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <div class="no-products">
                <h3>Товаров пока нет</h3>
                <p>Добавьте первый товар</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>