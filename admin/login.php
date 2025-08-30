<?php
session_start();

// Проверяем, уже авторизован ли пользователь
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Обработка формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Замените на свои логин и пароль
    $correct_username = 'admin';
    $correct_password = 'admin'; // поставьте сложный пароль!
    
    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = "Неверные логин или пароль";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админку - BazaRR</title>
    <style>
        body { 
            font-family: 'PT Root UI', sans-serif; 
            background: #fffaf4; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .login-container { 
            background: white; 
            padding: 2rem; 
            border-radius: 20px; 
            box-shadow: 0 12px 32px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px; 
        }
        h2 { 
            text-align: center; 
            color: #ff5722; 
            margin-bottom: 1.5rem; 
        }
        .form-group { 
            margin-bottom: 1rem; 
        }
        input[type="text"], 
        input[type="password"] { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 10px; 
            font-size: 16px; 
        }
        button { 
            width: 100%; 
            padding: 12px; 
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
            text-align: center; 
            margin-bottom: 1rem; 
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Вход в админ-панель</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Логин" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Пароль" required>
            </div>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>