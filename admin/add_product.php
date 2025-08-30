<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include('../config.php');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    
    // Валидация
    if (empty($name) || empty($price)) {
        $error = 'Название и цена обязательны для заполнения';
    } else {
        // Обработка загрузки изображения
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            // Проверяем тип файла
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            
            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = 'uploads/' . $fileName;
                } else {
                    $error = 'Ошибка при загрузке изображения';
                }
            } else {
                $error = 'Разрешены только изображения (JPG, PNG, GIF, WEBP)';
            }
        }
        
        if (empty($error)) {
            // Добавляем товар в базу
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image_path) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $description, $price, $imagePath])) {
                $success = 'Товар успешно добавлен!';
                // Очищаем форму
                $name = $description = $price = '';
            } else {
                $error = 'Ошибка при добавлении товара';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар - BazaRR</title>
    <style>
        body { 
            font-family: 'PT Root UI', sans-serif; 
            background: #f5f5f5; 
            margin: 0; 
            padding: 20px; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: white; 
            padding: 2rem; 
            border-radius: 20px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
        }
        h2 { 
            color: #ff5722; 
            margin-bottom: 2rem; 
        }
        .form-group { 
            margin-bottom: 1rem; 
        }
        label { 
            display: block; 
            margin-bottom: 0.5rem; 
            font-weight: bold; 
        }
        input[type="text"], 
        input[type="number"], 
        textarea, 
        input[type="file"] { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 10px; 
            font-size: 16px; 
        }
        textarea { 
            height: 100px; 
            resize: vertical; 
        }
        button { 
            padding: 12px 24px; 
            background: #ff5722; 
            color: white; 
            border: none; 
            border-radius: 10px; 
            font-size: 16px; 
            cursor: pointer; 
            margin-top: 1rem; 
        }
        button:hover { 
            background: #e64a19; 
        }
        .error { 
            color: red; 
            margin-bottom: 1rem; 
        }
        .success { 
            color: green; 
            margin-bottom: 1rem; 
        }
        .back-link { 
            display: inline-block; 
            margin-bottom: 1rem; 
            color: #ff5722; 
            text-decoration: none; 
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">← Назад к списку</a>
        <h2>Добавить новый товар</h2>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Название товара *</label>
                <input type="text" id="name" name="name" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea id="description" name="description"><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="price">Цена (руб) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="<?= isset($price) ? $price : '' ?>" required>
            </div>
            
            <div class="form-group">
                <label for="image">Изображение товара</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            
            <button type="submit">Добавить товар</button>
        </form>
    </div>
</body>
</html>