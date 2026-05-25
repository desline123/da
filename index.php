<?php session_start(); $login = $_SESSION['login'] ?? ''; $role = ($login === 'Admin26') ? 'admin' : ($login ? 'client' : 'guest'); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Конференции.РФ</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="images/imgbin-orange.jpg">
</head>
<body>
<header class="main-header">
    <div class="container header-inner">
        <div class="logo">
            <img src="images/1282150.png" alt="Лого" class="logo-img" onerror="this.src='images/1282150.png'">
            <div><h1>Конференции.РФ</h1><p>Бронирование для конференций</p></div>
        </div>
        <nav class="nav-links">
            <a href="index.php" class="btn">Главная</a>
            <?php if ($role === 'guest'): ?>
                <a href="register.php" class="btn">Регистрация</a>
                <a href="login.php" class="btn btn-primary">Вход</a>
            <?php elseif ($role === 'client'): ?>
                <a href="profile.php" class="btn">Личный кабинет</a>
                <a href="booking_create.php" class="btn btn-primary">Новая заявка</a>
                <a href="logout.php" class="btn btn-outline">Выход</a>
            <?php else: ?>
                <a href="admin.php" class="btn btn-primary">Админка</a>
                <a href="logout.php" class="btn btn-outline">Выход</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container">
    <div class="card">
        <h2>Добро пожаловать!</h2>
        <p>Система бронирования помещений для всероссийских конференций: аудитория, коворкинг, кинозал.</p>
    </div>

    <!-- Слайдер -->
    <div id="mainSlider" class="slider-container">
        <div class="slider">
            <div class="slide"><img src="images/ad4b1ceed37823f2225c0e7a.jpg"></div>
            <div class="slide"><img src="images/dizayn-interera-co-working-.jpg"></div>
            <div class="slide"><img src="images/978e0d84d6b940fe1.jpg"></div>
            <div class="slide"><img src="images/ec8a14264510f22a979f3.jpg"></div>
        </div>
        <button class="slider-btn prev">❮</button>
        <button class="slider-btn next">❯</button>
        <div class="dots"></div>
    </div>

    <div class="card">
        <h2>Наши помещения</h2>
        <div class="grid-2col">
            <div class="room-card"><img src="images/12fe2c7de382debb49c.jpg" alt="Аудитория"><h3>Аудитория</h3><p>До 200 мест, мультимедиа</p></div>
            <div class="room-card"><img src="images/1643087798_5-bigfoto-name-p-id.jpg" alt="Коворкинг"><h3>Коворкинг</h3><p>Гибкое пространство</p></div>
            <div class="room-card"><img src="images/2692984_1632745507.225.jpg" alt="Кинозал"><h3>Кинозал</h3><p>Профессиональный звук</p></div>
        </div>
    </div>
</main>

<footer>
    <div class="container footer-content">
        <div class="footer-links">
            <a href="#"><img src="images/social.jpg" class="footer-icon"></a>

        </div>
        <p>© Конференции.РФ 2026</p>
    </div>
</footer>

<script src="js/script.js"></script>
<script>initSlider('mainSlider');</script>
</body>
</html>