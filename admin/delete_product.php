<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include('../config.php');

// Получаем ID товара из URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Сначала получаем информацию о товаре чтобы удалить изображение
    $stmt = $pdo->prepare("SELECT image_path FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        // Удаляем изображение, если оно есть
        if ($product['image_path'] && file_exists('../' . $product['image_path'])) {
            unlink('../' . $product['image_path']);
        }
        
        // Удаляем товар из базы
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Перенаправляем обратно в админку
header('Location: index.php');
exit;
?>